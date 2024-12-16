<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = ['form_id', 'column_name', 'data_type', 'type', 'options', 'required'];

    protected $casts = [
        'form_id' => 'string',
        'options' => 'json',
        'required' => 'boolean',
    ];

    public function form(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Form::class);
    }
}
