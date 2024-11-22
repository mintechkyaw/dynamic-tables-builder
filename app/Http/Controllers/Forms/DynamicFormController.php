<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Artisan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DynamicFormController extends Controller
{
    public function publish(Form $form)
    {
        if ($form->status === 'published') {
            return response()->json(['error' => 'Form is already published'], 400);
        }

        $this->generateDynamicMigration($form);
        Artisan::call('migrate');

        $form->update(['status' => 'published']);

        return response()->json(['message' => 'Form published successfully']);
    }

    public function generateDynamicMigration(Form $form)
    {
        $fields = $form->fields;
        $migrationName = 'create_'.$form->slug.'_table';
        $tableName = $form->slug;

        if (empty($tableName)) {
            throw new \Exception('Table name cannot be empty. Please ensure the form has a valid slug.');
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
                    throw new \Exception("Enum field '{$field->column_name}' must have non-empty options.");
                }
                $options = implode("', '", $optionsArray);
                $columnDefinition = "\$table->{$type}('{$field->column_name}', ['{$options}'])";
            }

            if ($field->required) {
                $columnDefinition .= "->notNullable()";
            } else {
                $columnDefinition .= "->nullable()";
            }

            return $columnDefinition . ";";
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

        $filePath = database_path('migrations/'.now()->format('Y_m_d_His')."_{$migrationName}.php");
        file_put_contents($filePath, $migrationContent);
    }

    public function insertDataIntoDynamicTable(Form $form, Request $request)
    {
        $data = $request->all();
        //I want to make only published form can be submitted
        if ($form->status !== 'published') {
            return response()->json(['error' => 'Form is not published'], 400);
        }

        $this->validateDynamicData($form, $data);

        $tableName = $form->slug;

        if (empty($tableName)) {
            throw new \Exception('Table name cannot be empty. Please ensure the form has a valid slug.');
        }

        if (!\Schema::hasTable($tableName)) {
            throw new \Exception("Table '{$tableName}' does not exist.");
        }

        \DB::table($tableName)->insert($data);

        return response()->json(['message' => 'Data inserted successfully']);
    }

    public function validateDynamicData(Form $form, array $data)
    {
        $rules = $form->fields->mapWithKeys(function ($field) {
            $rule = match ($field->data_type) {
                'string' => 'string',
                'number' => 'numeric',
                'json' => 'json',
                'enum' => 'in:' . implode(',', json_decode($field->options, true)),
                'date' => 'date',
                default => 'string',
            };

            if ($field->required) {
                $rule .= '|required';
            }

            return [$field->column_name => $rule];
        })->toArray();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new \Exception('Validation failed: ' . implode(', ', $validator->errors()->all()));
        }
    }




}
