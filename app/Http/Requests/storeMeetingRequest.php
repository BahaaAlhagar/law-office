<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeMeetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'issue_id' => 'numeric|exists:issues,id',
        'person' => 'nullable|numeric|exists:people,id',
        'parent_id' => 'nullable|numeric|exists:meetings,id',
        'judgement_id' => 'nullable|numeric|exists:judgements,id',
        'date' => 'required|date',
        'role' => 'nullable|numeric',
        'level' => 'nullable|numeric',
        'decision' => 'required|string',
        'notes' => 'nullable|string'
        ];
    }
}
