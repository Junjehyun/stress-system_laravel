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
        'SOSHIKI_CODE', 'KENGEN_KUBUN')->get();
        //$companyCheck = 'aaa';
        // pagination
        $results = User::latest()->paginate(10);

        return view("stress_system.doctor_list", compact('results', 'companyCheck'));
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
        // `like`를 사용한 あいまい検索 구현
        $soshiki = Taisyo_soshiki::where('SOSHIKI_NAME_JPN', 'like', "%{$soshikiName}%")->get();

        if(!$soshiki->isEmpty()) {
            // 회사 코드와 이름을 포함하는 배열로 변환
            $data = $soshiki->map(function($item) {
                return ['SOSHIKI_CODE' => $item->SOSHIKI_CODE, 'SOSHIKI_NAME' => $item->SOSHIKI_NAME_JPN];
            });

            return response()->json($data);
        } else {
            return response()->json(['error' => '組織の情報が存在しません。'], 404);
        }
    }

}
