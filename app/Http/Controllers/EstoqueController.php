<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EstoqueController extends Controller
{
    public function index()
    {       
             
        return view('admin.estoque');
    }
}
