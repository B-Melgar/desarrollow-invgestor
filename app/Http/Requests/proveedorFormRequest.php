<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Http\Request;
use Illuminate\Validation\Rule;

class proveedorFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 'idproveedor'=> 'required', //llave primaria
            'nit'=>'required',
            'nombreproveedor'=>'required',
            'direccion'=>'required',
            'telefono'=>'required',
            'correo'=>'required',
            'credito',
            'diascredito'
        ];
    }
}