<?php

namespace App\Services\Forms;

use App\Exports\DynamicTableExport;
use App\Http\Controllers\AccessControl\PermissionController;
use App\Models\Form;
use Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DynamicFormService
{
    public function publish(Form $form): \Illuminate\Http\JsonResponse
    {
        if ($form->status === 'published') {
            return response()->json(['error' => 'Form is already published'], 400);
        }

        try {
            $this->generateDynamicMigration($form);
            Artisan::call('migrate');
            PermissionController::generate($form);
            $form->update(['status' => 'published']);

            return response()->json(['message' => 'Form published successfully']);
        } catch (\Exception $e) {
            Log::error("Error publishing form: {$e->getMessage()}", ['exception' => $e]);

            return response()->json(['error' => 'Failed to publish form'], 500);
        }
    }

    private function generateDynamicMigration(Form $form): void
    {
        $fields = $form->fields;
        $migrationName = 'create_'.$form->slug.'_table';
        $tableName = $form->slug;

        if (empty($tableName)) {
            response()->json(['error' => 'Table name cannot be empty. Please ensure the form has a valid slug.'], 400);

            return;
        }

        $fieldDefinitions = $this->getFieldDefinitions($fields);

        $migrationContent = <<<EOT
        <?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        return new class extends Migration {
            public function up()
            {
                Schema::create('$tableName', function (Blueprint \$table) {
                    \$table->id();
                    $fieldDefinitions
                    \$table->timestamps();
                });
            }

            public function down()
            {
                Schema::dropIfExists('$tableName');
            }
        };
        EOT;

        $filePath = database_path('migrations/'.now()->format('Y_m_d_His')."_{$migrationName}.php");
        file_put_contents($filePath, $migrationContent);
    }

    private function getFieldDefinitions($fields)
    {
        return $fields->map(function ($field) {
            $type = $this->getFieldType($field->data_type);
            $columnDefinition = "\$table->{$type}('{$field->column_name}')";

            if ($type === 'enum') {
                $optionsArray = json_decode($field->options, true);
                if (empty($optionsArray)) {
                    return response()->json(['error' => "Enum field '{$field->column_name}' must have non-empty options."], 400);
                }
                $options = implode("', '", $optionsArray);
                $columnDefinition = "\$table->{$type}('{$field->column_name}', ['{$options}'])";
            }

            $columnDefinition .= $field->required ? '->notNullable()' : '->nullable()';

            return $columnDefinition.';';
        })->implode("\n            ");
    }

    private function getFieldType($dataType): string
    {
        return match ($dataType) {
            'integer' => 'integer',
            'json' => 'json',
            'enum' => 'enum',
            'date' => 'date',
            default => 'string',
        };
    }

    public function insertDataIntoDynamicTable(Form $form, Request $request): \Illuminate\Http\JsonResponse
    {
        if ($form->status !== 'published') {
            return response()->json(['error' => 'Form is not published'], 400);
        }

        $data = $this->validateDynamicData($form, $request->all());

        foreach ($form->fields as $field) {
            if ($field->data_type === 'json' && isset($data[$field->column_name])) {
                $data[$field->column_name] = json_encode($data[$field->column_name]);
            }
        }

        $tableName = $form->slug;

        if (empty($tableName)) {
            return response()->json(['error' => 'Table name cannot be empty. Please ensure the form has a valid slug.'], 400);
        }

        if (! Schema::hasTable($tableName)) {
            return response()->json(['error' => "Table '{$tableName}' does not exist."], 400);
        }

        try {
            $data['created_at'] = now();
            $data['updated_at'] = now();
            DB::table($tableName)->insert($data);

            return response()->json(['message' => 'Data inserted successfully']);
        } catch (\Exception $e) {
            Log::error("Error inserting data: {$e->getMessage()}", ['exception' => $e]);

            return response()->json(['error' => 'Failed to insert data'], 500);
        }
    }

    private function validateDynamicData(Form $form, array $data)
    {
        $rules = $form->fields->mapWithKeys(function ($field) {
            $rule = match ($field->data_type) {
                'string' => 'string',
                'number' => 'numeric',
                'json' => [
                    'array',
                    function ($attribute, $value, $fail) use ($field) {
                        $options = json_decode($field->options, true);
                        if (! empty($options) && array_diff($value, $options)) {
                            $fail("The {$attribute} contains invalid options.");
                        }
                    },
                ],
                'enum' => 'in:'.implode(',', json_decode($field->options, true)),
                'date' => 'date',
                default => 'string',
            };

            if ($field->required) {
                $rule = is_array($rule) ? array_merge($rule, ['required']) : $rule.'|required';
            }

            return [$field->column_name => $rule];
        })->toArray();

        return Validator::make($data, $rules)->validate();
    }

    public function destroyDynamicForm(Form $form)
    {
        $tableName = $form->slug;
        $migrationName = 'create_'.$tableName.'_table';

        $migrationFiles = glob(database_path('migrations/*_'.$migrationName.'.php'));
        foreach ($migrationFiles as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
        try {
            if ($form->status === 'published') {
                PermissionController::deletePermissions($form);
            }
        } catch (\Exception $e) {
            logger()->error("Failed to delete permissions: {$tableName}. Error: {$e->getMessage()}");
        }

        try {
            Schema::dropIfExists($tableName);
        } catch (\Exception $e) {
            logger()->error("Failed to drop table: {$tableName}. Error: {$e->getMessage()}");
        }
    }

    // private function deletePermissions(Form $form)
    // {
    //     $permissions = ["create-$form->slug", "read-$form->slug", "update-$form->slug", "delete-$form->slug"];
    //     foreach ($permissions as $p) {
    //         $permission = Permission::where('name', $p)->first();
    //         if ($permission) {
    //             $permission->delete();
    //         }
    //     }
    // }

    public function getDataFromDynamicTable(Form $form, Request $request)
    {
        $tableName = $form->slug;

        if (empty($tableName)) {
            return response()->json(['error' => 'Table name cannot be empty. Please ensure the form has a valid slug.'], 400);
        }

        if (! Schema::hasTable($tableName)) {
            return response()->json(['error' => "Table '{$tableName}' does not exist."], 400);
        }

        try {
            $perPage = $request->input('per_page', 10);
            $headers = $form->fields->pluck('column_name');
            if ($perPage == -1) {
                $totalRecords = DB::table($tableName)->count();
                $paginatedData = DB::table($tableName)->paginate($totalRecords);

            }
            if ($perPage > -1) {
                $paginatedData = DB::table($tableName)->paginate($perPage);
            }
            $data = $paginatedData->items();
            $data = collect($data)->map(function ($item) use ($form) {
                foreach ($form->fields as $field) {
                    if ($field->data_type === 'json' && isset($item->{$field->column_name})) {
                        $item->{$field->column_name} = json_decode($item->{$field->column_name}, true);
                    }
                }

                return $item;
            });

            return response()->json([
                'headers' => $headers,
                'data' => $data,
                'pagination' => [
                    'total' => $paginatedData->total(),
                    'per_page' => $paginatedData->perPage(),
                    'current_page' => $paginatedData->currentPage(),
                    'last_page' => $paginatedData->lastPage(),
                    'from' => $paginatedData->firstItem(),
                    'to' => $paginatedData->lastItem(),
                ],
            ], 200);
        } catch (\Exception $e) {
            Log::error("Error retrieving data: {$e->getMessage()}", ['exception' => $e]);

            return response()->json(['error' => 'Failed to retrieve data'], 500);
        }
    }

    public function exportToExcel(Form $form)
    {
        $tableName = $form->slug;

        if (empty($tableName) || ! Schema::hasTable($tableName)) {
            return response()->json(['error' => 'Table does not exist'], 400);
        }

        try {
            $headers = $form->fields->pluck('column_name')->toArray();
            $data = DB::table($tableName)->get()
                ->map(function ($item) use ($form) {
                    $row = [];
                    foreach ($form->fields as $field) {
                        $value = $item->{$field->column_name};
                        if ($field->data_type === 'json' && $value) {
                            $value = json_decode($value, true);
                            $value = is_array($value) ? implode(', ', $value) : $value;
                        }
                        $row[$field->column_name] = $value;
                    }

                    return $row;
                })
                ->toArray();

            return Excel::download(
                new DynamicTableExport($data, $headers),
                "{$form->name}_data.xlsx"
            );
        } catch (\Exception $e) {
            Log::error("Error exporting data: {$e->getMessage()}", ['exception' => $e]);

            return response()->json(['error' => 'Failed to export data'], 500);
        }
    }
}
