<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DynamicFormController extends Controller
{
    public function publish(Form $form)
    {
        if ($form->status === 'published') {
            return response()->json(['error' => 'Form is already published'], 400);
        }

        try {
            $this->generateDynamicMigration($form);
            Artisan::call('migrate');
            $form->update(['status' => 'published']);

            return response()->json(['message' => 'Form published successfully']);
        } catch (\Exception $e) {
            Log::error("Error publishing form: {$e->getMessage()}", ['exception' => $e]);
            return response()->json(['error' => 'Failed to publish form'], 500);
        }
    }

    public function generateDynamicMigration(Form $form)
    {
        $fields = $form->fields;
        $migrationName = 'create_' . $form->slug . '_table';
        $tableName = $form->slug;

        if (empty($tableName)) {
            return response()->json(['error' => 'Table name cannot be empty. Please ensure the form has a valid slug.'], 400);
        }

        $fieldDefinitions = $fields->map(function ($field) {
            $type = match ($field->data_type) {
                'string' => 'string',
                'number' => 'integer',
                'json' => 'json',
                'enum' => 'enum',
                'date' => 'date',
                default => 'string',
            };

            $columnDefinition = "\$table->{$type}('{$field->column_name}')";

            if ($type === 'enum') {
                $optionsArray = json_decode($field->options, true);
                if (empty($optionsArray)) {
                    return response()->json(['error' => "Enum field '{$field->column_name}' must have non-empty options."], 400);
                }
                $options = implode("', '", $optionsArray);
                $columnDefinition = "\$table->{$type}('{$field->column_name}', ['{$options}'])";
            }

            if ($field->required) {
                $columnDefinition .= '->notNullable()';
            } else {
                $columnDefinition .= '->nullable()';
            }

            return $columnDefinition . ';';
        })->implode("\n            ");

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
                    \$table->timestamps();
                    $fieldDefinitions
                });
            }

            public function down()
            {
                Schema::dropIfExists('$tableName');
            }
        };
        EOT;

        $filePath = database_path('migrations/' . now()->format('Y_m_d_His') . "_{$migrationName}.php");
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
                    return response()->json(["error" => "Enum field '{$field->column_name}' must have non-empty options."], 400);
                }
                $options = implode("', '", $optionsArray);
                $columnDefinition = "\$table->{$type}('{$field->column_name}', ['{$options}'])";
            }

            $columnDefinition .= $field->required ? '->notNullable()' : '->nullable()';

            return $columnDefinition . ';';
        })->implode("\n            ");
    }

    private function getFieldType($dataType)
    {
        return match ($dataType) {
            'string' => 'string',
            'integer' => 'integer',
            'json' => 'json',
            'enum' => 'enum',
            'date' => 'date',
            default => 'string',
        };
    }

    public function insertDataIntoDynamicTable(Form $form, Request $request)
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

        if (!Schema::hasTable($tableName)) {
            return response()->json(["error" => "Table '{$tableName}' does not exist."], 400);
        }

        try {
            DB::table($tableName)->insert($data);
            return response()->json(['message' => 'Data inserted successfully']);
        } catch (\Exception $e) {
            Log::error("Error inserting data: {$e->getMessage()}", ['exception' => $e]);
            return response()->json(['error' => 'Failed to insert data'], 500);
        }
    }

    public function validateDynamicData(Form $form, array $data)
    {
        $rules = $form->fields->mapWithKeys(function ($field) {
            $rule = match ($field->data_type) {
                'string' => 'string',
                'number' => 'numeric',
                'json' => [
                    'array',
                    function ($attribute, $value, $fail) use ($field) {
                            $options = json_decode($field->options, true);
                            if (!empty($options) && array_diff($value, $options)) {
                                $fail("The {$attribute} contains invalid options.");
                            }
                        },
                ],
                'enum' => 'in:' . implode(',', json_decode($field->options, true)),
                'date' => 'date',
                default => 'string',
            };

            if ($field->required) {
                $rule = is_array($rule) ? array_merge($rule, ['required']) : $rule . '|required';
            }

            return [$field->column_name => $rule];
        })->toArray();

        return Validator::make($data, $rules)->validate();
    }

    public static function destroyDynamicForm(Form $form)
    {
        $tableName = $form->slug;
        $migrationName = 'create_' . $tableName . '_table';

        // Find and delete the migration file
        $migrationFiles = glob(database_path('migrations/*_' . $migrationName . '.php'));
        foreach ($migrationFiles as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }

        Schema::dropIfExists($tableName);
    }

    public function getDataFromDynamicTable(Form $form)
    {
        $tableName = $form->slug;

        if (empty($tableName)) {
            return response()->json(['error' => 'Table name cannot be empty. Please ensure the form has a valid slug.'], 400);
        }

        if (!Schema::hasTable($tableName)) {
            return response()->json(["error" => "Table '{$tableName}' does not exist."], 400);
        }

        try {
            $data = DB::table($tableName)->get();
            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            Log::error("Error retrieving data: {$e->getMessage()}", ['exception' => $e]);
            return response()->json(['error' => 'Failed to retrieve data'], 500);
        }
    }
}
