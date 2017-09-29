<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updatePersonRequest extends FormRequest
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
        $person = $this->segment(2);
        return [
            'name'      => 'required|min:2|max:70|unique:people,name,' .$person,
            'location'  => 'required|min:2',
            'idenity'   => 'numeric|nullable',
            'phone'     => 'numeric|nullable',
            'is_client'     => 'required|boolean'
        ];
    }
}
