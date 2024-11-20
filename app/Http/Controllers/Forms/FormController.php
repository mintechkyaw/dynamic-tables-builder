<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormStoreRequest;
use App\Http\Resources\FormResource;
use App\Models\Form;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FormResource::collection(Form::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormStoreRequest $request)
    {
        $data = $request->validated();
        try {
            $form = auth()->user()->forms()->create($data);

            return response()->json(
                [
                    'msg' => 'Form Created Successfully!',
                    'form' => $form,
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
            $form->delete();

            return response()->json([
                'msg' => 'Form Deleted Successfully!',
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
