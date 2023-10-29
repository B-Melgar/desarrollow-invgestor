<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Http\Request;
use Illuminate\Validation\Rule;

class secOptionsFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'idMenu'=>'required',
            'DescriptionOption'=>'required', 'max:45',
            'RouteOption'=>'required', 'max:150',
            'IconOption'=>'required', 'max:50',
            'status'
        ];
    }
}