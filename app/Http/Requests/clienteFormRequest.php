<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Http\Request;
use Illuminate\Validation\Rule;

class clienteFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nit'=>'required',
            'nombrecliente'=>'required',
            'direccion'=>'required',
            'telefono'=>'required',
            'correo'=>'required',
            'credito',
            'diascredito'
        ];
    }
}