<?php

namespace App\Http\Controllers;

use App\Models\Haisya_mst;
use App\Models\Taisyo_soshiki;
use Illuminate\Http\Request;
use App\Models\User;
class DoctorListController extends Controller
{
    //
    public function DoctorListIndex(){
        $results = [];

        $results = User::select('id as No', 'USER_ID', 'name', 'KAISYA_CODE',
        'SOSHIKI_CODE')->get();

        return view("stress_system.doctor_list", compact('results'));
    }

    public function AjaxCompany(Request $request) {

        $kaishaName = $request->input('CompanyName');
        $haisya = Haisya_mst::where('KAISYA_NAME_JPN', 'like',
        "%{$kaishaName}%")->first();

        if($haisya) {
            return response()->json(['KAISYA_CODE' => $haisya->KAISYA_CODE]);
        } else {
            return response()->json(['error' => '会社の情報が存在しません。'], 404);
        }
    }

    public function AjaxSoshiki(Request $request) {

        $soshikiName = $request->input('SoshikiName');
        $soshiki = Taisyo_soshiki::where('SOSHIKI_NAME_JPN', 'like',
        "%{$soshikiName}%")->first();

        if($soshiki) {
            return response()->json(['SOSHIKI_CODE' => $soshiki->SOSHIKI_CODE]);
        } else {
            return response()->json(['error' => '組織の情報が存在しません。'], 404);
        }
    }

}
