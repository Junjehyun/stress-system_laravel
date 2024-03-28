<?php

namespace App\Http\Controllers;

use App\Models\Haisya_mst;
use App\Models\Taisyo_soshiki;
use Illuminate\Http\Request;
use App\Models\User;
class DoctorListController extends Controller
{
    //
    public function DoctorListIndex(Request $request)   {

        $results = [];
        // 요청에서 검색 조건을 추출
        $companyCheck = $request->input('companyCheck');
        $companyNameInput = $request->input('companyNameInput');
        $companyNameOutput = $request->input('companyNameOutput');
        $soshikiCheck = $request->input('soshikiCheck');
        $soshikiNameInput = $request->input('soshikiNameInput');
        $soshikiNameOutput = $request->input('soshikiNameOutput');
        $authorityCheck = $request->input('authorityCheck');
        $allCompany = $request->input('allCompany');
        $myCompany = $request->input('myCompany');
        $user = User::where('USER_ID', $request->input('USER_ID'))->first();
        $haisyaList = [];
        $soshikiList = [];
        //dd($request->all());

        $results = User::select('id as No', 'USER_ID', 'name', 'KAISYA_CODE',
        'SOSHIKI_CODE', 'KENGEN_KUBUN')
        ->latest('id')
        ->paginate(10);

        return view("stress_system.doctor_list", compact('results',
        'companyCheck', 'companyNameInput', 'companyNameOutput', 'soshikiCheck',
        'soshikiNameInput', 'soshikiNameOutput', 'authorityCheck',
        'allCompany', 'myCompany', 'haisyaList', 'soshikiList'));
    }

    public function AjaxCompany(Request $request) {
        $kaishaName = $request->input('CompanyName');

        $haisyaList = Haisya_mst::where('KAISYA_NAME_JPN', 'like', "%{$kaishaName}%")->get();

        if(!$haisyaList->isEmpty()) {

            $data = $haisyaList->map(function($item) {
                return ['KAISYA_CODE' => $item->KAISYA_CODE, 'KAISYA_NAME' => $item->KAISYA_NAME_JPN];
            });

            return response()->json($data);
        } else {
            return response()->json(['error' => '会社の情報が存在しません。'], 404);
        }
    }

    public function AjaxSoshiki(Request $request) {
        $soshikiName = $request->input('SoshikiName');
        // `like` あいまい検索
        $soshiki = Taisyo_soshiki::where('SOSHIKI_NAME_JPN', 'like', "%{$soshikiName}%")->get();

        if(!$soshiki->isEmpty()) {

            $data = $soshiki->map(function($item) {
                return ['SOSHIKI_CODE' => $item->SOSHIKI_CODE, 'SOSHIKI_NAME' => $item->SOSHIKI_NAME_JPN];
            });

            return response()->json($data);
        } else {
            return response()->json(['error' => '組織の情報が存在しません。'], 404);
        }
    }

}
