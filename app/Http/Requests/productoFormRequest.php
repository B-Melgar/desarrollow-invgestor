<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Http\Request;
use Illuminate\Validation\Rule;

class productoFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'codigoproducto'=>'max:50' ,
            'descripcionproducto'=>'required', 'max:1500' ,
            'preciocosto'=> 'required', 
            'precioventa'=> 'required', 
            'idcategoria'=> 'required', //llave foranea
            'idsubcategoria', //llave foranea
            'estado',
        ];
    }
}