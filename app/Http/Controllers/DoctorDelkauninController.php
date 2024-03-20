<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorDelkauninController extends Controller
{
    //
    public function index(){
        return view("stress_system.doctor_delkakunin");
    }

    public function confirmDelete($id) {
        $user = User::findOrFail($id);

        return view('stress_system.doctor_delkakunin', compact('user'));
    }
}
