<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormFieldRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->forms()->where('id', $this->form_id)->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'form_id' => 'required|exists:forms,id',
            'column_name' => 'required|string|max:255|'.
                Rule::unique('form_fields')->where(function ($query) {
                    return $query->where('form_id', $this->form_id);
                }),
            'data_type' => 'required|string|in:string,number,enum,date',
            'type' => [
                'required',
                'string',
                Rule::in(['text', 'check_box', 'radio']),
                Rule::prohibitedIf($this->data_type === 'enum' and $this->type === 'text'),

            ],
            'options' => 'required_if:data_type,enum|array',

            'required' => 'sometimes|boolean',
        ];
    }
}
