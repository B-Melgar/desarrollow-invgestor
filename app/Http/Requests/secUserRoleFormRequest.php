<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Http\Request;
use Illuminate\Validation\Rule;

class segusuariorolFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'idrol', //llave foranea
            'users_id', //llave foranea
            'startDate'=>'required',
            'endDate',
            'Active',
            'status'
        ];
    }
}