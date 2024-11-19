<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;

class DynamicFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function generateDynamicMigration(Form $form)
    {
        $fields = $form->fields;
        $migrationName = 'create_' . $form->slug . '_table';
        $tableName = $form->slug;

        $fieldDefinitions = $fields->map(function ($field) {
            $type = match ($field->type) {
                'text' => 'string',
                'number' => 'integer',
                'date' => 'date',
                default => 'string',
            };
            return "\$table->{$type}('{$field->name}')->nullable();";
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
}
