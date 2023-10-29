<?php

namespace App\Services;

use App\Models\secOptionsModel;

class secOptionsService
{
    public function get()
    {
        $secOptionsModel = secOptionsModel::where('secOptions.status','=', '1')->orderBy('secOptions.idMenu', 'asc')->get();
        $secOptionArray[''] = 'Seleccionar';
        foreach ($secOptionsModel as $option) {
            $secOptionArray[$option->idOption] = $option->DescriptionOption;
        }
        return $secOptionArray;
    }
}