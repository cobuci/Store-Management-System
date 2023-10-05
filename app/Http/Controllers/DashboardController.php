<?php

namespace App\Http\Controllers;


class DashboardController extends Controller
{

    public static function checkMonth($month)
    {
        $namesOfMonths = [
            "12" => "Janeiro",
            "11" => "Fevereiro",
            "10" => "Março",
            "9" => "Abril",
            "8" => "Maio",
            "7" => "Junho",
            "6" => "Julho",
            "5" => "Agosto",
            "4" => "Setembro",
            "3" => "Outubro",
            "2" => "Novembro",
            "1" => "Dezembro",
        ];

        return $namesOfMonths[$month] ?? 0;
    }

}
