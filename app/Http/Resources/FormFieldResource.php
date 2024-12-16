<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormFieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'column_name' => $this->column_name,
            'data_type' => $this->data_type,
            'type' => $this->type,
            'options' => json_decode($this->options) ?? null,
            'required' => $this->required,
        ];
    }
}
