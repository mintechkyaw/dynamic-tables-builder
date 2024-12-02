<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormFieldRequest;
use App\Http\Resources\FormFieldResource;
use App\Models\FormField;

class FormFieldController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(FormField::class, 'form_field');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $form_fields = FormField::all();

        return FormFieldResource::collection($form_fields);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormFieldRequest $request)
    {
        $data = $request->validated();
        $data['data_type'] = $this->dataTypeChanger($data['type']);
        $data['options'] = isset($data['options']) &&
            ($data['type'] === 'check_box' || $data['type'] === 'radio')
            ? json_encode($data['options']) : null;
        try {
            FormField::create($data);

            return response()->json(
                [
                    'message' => 'Field Created Successfully!',
                ],
                201
            );
        } catch (\Throwable $th) {
            \Log::error("Error in Creating FormField: {$th->getMessage()}", [
                'exception' => $th,
            ]);
        }

        return response()->json([
            'error' => true,
        ], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(FormField $formField)
    {
        return new FormFieldResource($formField);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormFieldRequest $request, FormField $formField)
    {
        if ($formField->form->status === 'drafted') {
            $data = $request->validated();
            $data['data_type'] = $this->dataTypeChanger($data['type']);
            $data['options'] = isset($data['options']) &&
                ($data['type'] === 'check_box' || $data['type'] === 'radio')
                ? json_encode($data['options']) : null;
            try {
                $formField->update($data);

                return response()->json([
                    'message' => 'Form Field Updated!',
                ], 202);
            } catch (\Throwable $th) {
                \Log::error("Error in Updating Form: {$th->getMessage()}", [
                    'exception' => $th,
                ]);
            }

            return response()->json([
                'error' => true,
            ], 500);
        }

        return response()->json([
            'error' => 'Form had been published!',
        ], 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormField $formField)
    {
        try {
            $formField->delete();

            return response()->json([
                'message' => 'Form Deleted Successfully!',
            ]);
        } catch (\Throwable $th) {
            \Log::error("Error in Deleting Form Field: {$th->getMessage()}", [
                'exception' => $th,
            ]);
        }

        return response()->json([
            'error' => true,
        ], 500);
    }

    private function dataTypeChanger($type)
    {
        return match ($type) {
            'text' => 'string',
            'number' => 'integer',
            'check_box' => 'json',
            'radio' => 'enum',
            default => 'string'
        };
    }
}
