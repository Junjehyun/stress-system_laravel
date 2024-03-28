<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DoctorDelkakuninController extends Controller
{
    //
    public function index(){
        return view("stress_system.doctor_delkakunin");
    }

    public function confirmDelete($USER_ID) {
        $user = User::findOrFail($USER_ID);

        return view('stress_system.doctor_delkakunin', compact('user'));
    }

    public function delete($USER_ID) {
        User::where('USER_ID', $USER_ID)->delete();
        return redirect()->route('stress_system.doctor_list')->
        with('success', '');
    }
}
