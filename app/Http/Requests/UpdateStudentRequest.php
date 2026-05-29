<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'batch_id'    => 'nullable|exists:batches,id',
            'name'        => 'required|string',
            'email'       => 'required|email',
            'phone'       => 'required|string',
            'address'     => 'nullable|string',
            'enrolled_at' => 'nullable|date',
            'status'      => 'required|in:active,inactive,graduated',
        ];
    }
}
