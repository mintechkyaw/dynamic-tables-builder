<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Artisan;
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
                'date' => 'date',
                default => 'string',
            };

            return "\$table->{$type}('{$field->column_name}')->nullable();";
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
}
