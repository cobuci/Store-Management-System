<?php

namespace App\Http\Controllers;

use App\Models\History;

class HistoryController extends Controller
{
    public static function listarHistorico()
    {
        return History::latest("id")->paginate(10)->onEachSide(1);
    }

    public static function addToHistory($type, $description)
    {
        $history = new History();

        $history->type = $type;
        $history->description = $description;

        $history->save();
    }

}
