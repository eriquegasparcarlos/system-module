<?php

namespace Modules\System\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->input('id');
        return [
            'email' => [
                'required',
                'email',
            ],
            'number' => [
                'required',
                'size:11',
                 Rule::unique('system.clients')->ignore($id),
            ],
            'name' => [
                'required',
                Rule::unique('system.clients')->ignore($id)
            ],
            'password' => [
                'required',
            ],
            'subdomain' => [
                'required'
            ]
        ];
    }
}