<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Http\Request;
use Illuminate\Validation\Rule;

class segusuarioFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 'id'=> 'required', //llave foranea
            // 'name'=>'required',
            'email',
            'email_verified_at',
            'password',
            'remember_token',
            'idempleado', //llave foranea
            'estado'
        ];
    }
}