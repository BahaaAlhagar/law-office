<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeJudgementRequest extends FormRequest
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
        'issue_id' => 'required|numeric|exists:issues,id',
        'meeting_id' => 'required|numeric|exists:meetings,id',
        'person_id' => 'nullable|numeric|exists:people,id',
        'body' => 'required|string|min:5|max:150',
        'date' => 'required|date',
        'level' => 'required|numeric',
        'present' => 'required|numeric',
        'active' => 'required|numeric',
        'type' => 'required|numeric',
        'record' => 'required_with:year|numeric',
        'year' => 'required_with:record|numeric'
        ];
    }
}
