<?php

namespace App\Http\Controllers;


class StatisticsController extends Controller
{


    public static function estoqueAlerta($qtdVendida, $dias)
    {
        $dias == 0 && $dias = 1;
        return round((($qtdVendida / $dias) * 14));
    }


}
