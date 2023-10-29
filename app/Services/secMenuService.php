<?php

namespace App\Services;

use App\Models\secMenuModel;

class secMenuService
{
    public function get()
    {
        $secMenuModel = secMenuModel::get();
        $secMenuArray[''] = 'Seleccionar';
        foreach ($secMenuModel as $secMenu) {
            $secMenuArray[$secMenu->idMenu] = $secMenu->DescriptionMenu;
        }
        return $secMenuArray;
    }
}