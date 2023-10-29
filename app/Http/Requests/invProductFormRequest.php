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
            // 'idproducto', //llave primaria
            'descripcionproducto'=>'required', 'max:1500' ,
            'codigoproducto'=>'max:50' ,
            //'barcode'=>'required', 'max:50' ,
            'idcategoria'=> 'required', //llave foranea
            'idsubcategoria', //llave foranea
            'estado',//=> 'required', //llave foranea
            //'unitMeasure'=>'required',
            'idTradeMark'=>'required',
            'idUnitMeasurement'=>'required',
            'optimalQuantity',//=>'required',
            'photo', //limitamos el tipo de archivo que puede subir
            'freeFieldOne'=> 'max:1000' ,
            'freeFieldTwo'=> 'max:1000' ,
            'freeFieldThree'=> 'max:1000',
            'status',
            
        ];
    }
}