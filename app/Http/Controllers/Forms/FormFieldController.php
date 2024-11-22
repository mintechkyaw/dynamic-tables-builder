<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormFieldRequest;
use App\Http\Resources\FormFieldResource;
use App\Models\FormField;

class FormFieldController extends Controller
{
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
        $data['options'] = isset($data['options']) ? json_encode($data['options']) : $data['options'] ?? null;
        try {
            FormField::create($data);

            return response()->json(
                [
                    'msg' => 'Field Created Successfully!',
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
            try {
                $formField->update($data);

                return response()->json([
                    'msg' => 'Form Field Updated!',
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
                'msg' => 'Form Deleted Successfully!',
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
}
