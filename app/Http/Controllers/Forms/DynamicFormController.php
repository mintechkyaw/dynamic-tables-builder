<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Services\Forms\DynamicFormService;
use Gate;
use Illuminate\Http\Request;

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
