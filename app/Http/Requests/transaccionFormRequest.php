<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Http\Request;
use Illuminate\Validation\Rule;

class transaccionFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'iddepartamento',
            'idtipotransaccion',
            'idempleado', 
            'idproveedor', 
            'idcliente',
            'fecha', 
            'total',
            'idestadotransaccion'
        ];
    }
}