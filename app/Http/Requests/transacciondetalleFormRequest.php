<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Http\Request;
use Illuminate\Validation\Rule;

class transacciondetalleFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'iddepartamento',
            'idtransaccion'=> 'required',
            'idproducto'=> 'required',
            'cantidad', 
            'precio',
            'subtotal'
        ];
    }
}