<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createPersonRequest extends FormRequest
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
            'name'      => 'required|min:2|max:70|unique:people',
            'location'  => 'required|min:2',
            'idenity'   => 'nullable|number',
            'phone'     => 'nullable|number',
            'is_client'     => 'required|boolean'
        ];
    }
}
