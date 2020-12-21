<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function index(){
        $title = "Bem vindo ao meu mundo";
        return view("pages.index", compact('title'));
    }
}
