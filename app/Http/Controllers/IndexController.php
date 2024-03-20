<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index() {
        return view("stress_system.operator_menu");
    }

    public function blank() {
        return view("stress_system.blank");
    }
}
