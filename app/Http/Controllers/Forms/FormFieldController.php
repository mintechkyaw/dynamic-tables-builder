<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormFieldRequest;
use App\Models\FormField;
use Illuminate\Http\Request;

class FormFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $form_fields = FormField::all();

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
}
