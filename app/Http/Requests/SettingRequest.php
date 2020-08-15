<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
        $parameter = $this->route('parameter');
        $rules = [
            'new_number' => 'required|integer',
        ];
        if ($parameter === 'test_attempts') {
            $rules['new_number'] .= '|between:1,10';
        } else if ($parameter === 'default_questions') {
            $rules['new_number'] .= '|between:2,8';
        }
        return $rules;
    }
}
