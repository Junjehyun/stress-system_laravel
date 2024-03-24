<?php

namespace App\Http\Controllers;
use App\Models\Haisya_mst;
use App\Models\Taisyo_soshiki;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class SearchController extends Controller
{
    public function search(Request $request){

        $CompanyName = request()->input('companyNameInput');

        $haisyaInfo = Haisya_mst::where('KAISYA_NAME_JPN', 'like', '%' . $CompanyName . '%')->first();

        $haisya_msts = $request->input("KAISYA_NAME_JPN");

        $taiyo_soshikis = $request->input("SOSHIKI_NAME_JPN");

        $haisya_msts = Haisya_mst::where('KAISYA_NAME_JPN', 'like' , '%' . $haisya_msts . '%')->get();

        $taiyo_soshikis = Taisyo_soshiki::where('SOSHIKI_NAME_JPN', 'like' , '%' . $taiyo_soshikis . '%')->get();

        $companyNameInput = $request->input('companyNameInput');

    }

    public function hyoji_search(Request $request) {

    $result = [];

    $userID = $request->input("USER_ID");
    $name = $request->input("name");
    $companyCode = $request->input("KAISYA_CODE");
    $soshikiCode = $request->input("SOSHIKI_CODE");

    // 検索しても検索語残す
    $companyName = $request->input('companyNameInput');
    $soshikiName = $request->input('soshikiNameInput');

    $companyNameOut = $request->input('companyNameOutput');
    $soshikiNameOut = $request->input('soshikiNameOutput');


    $companyCheck = $request->input('companyCheck');
    $soshikiCheck = $request->input('soshikiCheck');
    $authorityCheck = $request->input('authorityCheck');


    $query = DB::table('users')
    ->join('haisya_msts','users.KAISYA_CODE','=','haisya_msts.KAISYA_CODE')
    ->join('taisyo_soshikis','users.SOSHIKI_CODE','=','taisyo_soshikis.SOSHIKI_CODE')
    ->select('users.*',
    'haisya_msts.KAISYA_NAME_JPN',
    'haisya_msts.KAISYA_NAME_ENG',
    'taisyo_soshikis.SOSHIKI_NAME_JPN');


   $companyName = $request->input('companyNameInput');

   if ($companyName) {
       $query->where('haisya_msts.KAISYA_NAME_JPN', 'like', "%{$companyName}%");
   }

   $soshikiName = $request->input('soshikiNameInput');

   if ($soshikiName) {
       $query->where('taisyo_soshikis.SOSHIKI_NAME_JPN', 'like', "%{$soshikiName}%");

    }

    //権限区分で検索
    $kengenKubun = $request->input('kengenKubun');
    if($kengenKubun) {
        $query->where('users.KENGEN_KUBUN', $kengenKubun);
    }


     $results = $query->get();

    //Pagination
    $results = $query->paginate(10);


     return view('stress_system.doctor_list',compact('results', 'companyName', 'soshikiName',
     'companyNameOut', 'soshikiNameOut', 'companyCheck', 'soshikiCheck', 'authorityCheck', 'kengenKubun'));
   }
}
