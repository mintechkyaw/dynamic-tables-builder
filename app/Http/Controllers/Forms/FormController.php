<?php

namespace App\Http\Controllers\Forms;

use App\Models\Form;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FormResource;
use App\Http\Requests\FormStoreRequest;

class FormController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate(['status' => 'nullable|string|in:drafted,published']);
        if ($request->status === 'drafted') {
            $forms = Form::where('status', 'drafted')->get();
        } elseif ($request->status === 'published') {
            $forms = Form::where('status', 'published')->get();
        } else {
            $forms = Form::all();
        }

        return FormResource::collection($forms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormStoreRequest $request)
    {
        $data = $request->validated();
        try {
            $data['status'] = 'drafted';
            $form = auth()->user()->forms()->create($data);

            return response()->json(
                [
                    'message' => 'Form Created Successfully!',
                    'form' => new FormResource($form),
                ],
                201
            );
        } catch (\Throwable $th) {
            \Log::error("Error in Creating Form: {$th->getMessage()}", [
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
    public function show(Form $form)
    {
        return new FormResource($form);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormStoreRequest $request, Form $form)
    {
        $data = $request->validated();
        try {
            $form->update($data);

            return response()->json([
                'message' => 'Form Name Updated Successfully!',
            ], 200);
        } catch (\Throwable $th) {
            \Log::error("Error in Updating Form: {$th->getMessage()}", [
                'exception' => $th,
            ]);
        }

        return response()->json([
            'error' => true,
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        try {
            DynamicFormController::destroyDynamicForm($form);
            $form->delete();
            return response()->json([
                'message' => 'Form Deleted Successfully!',
            ]);

        } catch (\Throwable $th) {
            \Log::error("Error in Deleting Form: {$th->getMessage()}", [
                'exception' => $th,
            ]);
        }

        return response()->json([
            'error' => true,
        ], 500);
    }
}
