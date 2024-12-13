<?php

namespace App\Http\Controllers\Forms;

use App\Exports\DynamicTableExport;
use App\Http\Controllers\AccessControl\PermissionController;
use App\Http\Controllers\Controller;
use App\Models\Form;
use Artisan;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\Forms\DynamicFormService;

class DynamicFormController extends Controller
{
    private $dynamicFormService;

    public function __construct(DynamicFormService $dynamicFormService)
    {
        $this->dynamicFormService = $dynamicFormService;
    }

    public function publish(Form $form)
    {
        auth()->user()->can('create', $form);
        return $this->dynamicFormService->publish($form);
    }

    public function insertDataIntoDynamicTable(Form $form, Request $request)
    {
        Gate::authorize('create-data', $form);
        return $this->dynamicFormService->insertDataIntoDynamicTable($form, $request);
    }

    public function destroyDynamicForm(Form $form)
    {
        return $this->dynamicFormService->destroyDynamicForm($form);
    }

    public function getDataFromDynamicTable(Form $form, Request $request)
    {
        Gate::authorize('read-data', $form);
        return $this->dynamicFormService->getDataFromDynamicTable($form, $request);
    }

    public function exportToExcel(Form $form)
    {
        Gate::authorize('read-data', $form);
        return $this->dynamicFormService->exportToExcel($form);
    }
}
