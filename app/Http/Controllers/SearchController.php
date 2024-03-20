<?php

namespace App\Http\Controllers;
use App\Models\Haisya_mst;
use App\Models\Taisyo_soshiki;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class SearchController extends Controller
{

    // public function defaultList() {
    // // users 테이블에서 필요한 컬럼만 선택하여 모든 레코드 조회
    // $results = User::select('id as No', 'USER_ID', 'name', 'KAISYA_CODE',
    // 'SOSHIKI_CODE')->get();

    // // 뷰로 데이터 전달
    // return view('stress_system.doctor_list', compact('results'));
    // }

    public function search(Request $request){

        $CompanyName = request()->input('companyNameInput');

        $haisyaInfo = Haisya_mst::where('KAISYA_NAME_JPN', 'like', '%' . $CompanyName . '%')->first();

        // 검색 결과를 받는다.
        $haisya_msts = $request->input("KAISYA_NAME_JPN");
        $taiyo_soshikis = $request->input("SOSHIKI_NAME_JPN");

        // 회사명으로 검색
        $haisya_msts = Haisya_mst::where('KAISYA_NAME_JPN', 'like' , '%' . $haisya_msts . '%')->get();

        // 대상조직으로 검색
        $taiyo_soshikis = Taisyo_soshiki::where('SOSHIKI_NAME_JPN', 'like' , '%' . $taiyo_soshikis . '%')->get();

    }

    public function hyoji_search(Request $request) {

    $result = [];

    // リクエストから検索条件を受け取る
    $userID = $request->input("USER_ID");
    $name = $request->input("name");
    $companyCode = $request->input("KAISYA_CODE");
    $soshikiCode = $request->input("SOSHIKI_CODE");

    // users 테이블을 기준으로, 쿼리를 시작. 초기 쿼리 구성
    $query = DB::table('users')
    ->join('haisya_msts','users.KAISYA_CODE','=','haisya_msts.KAISYA_CODE')
    ->join('taisyo_soshikis','users.SOSHIKI_CODE','=','taisyo_soshikis.SOSHIKI_CODE')
    ->select('users.*',
    'haisya_msts.KAISYA_NAME_JPN',
    'haisya_msts.KAISYA_NAME_ENG',
    'taisyo_soshikis.SOSHIKI_NAME_JPN');

   // 회사명 검색 조건을 받아옴

   $companyName = $request->input('companyNameInput');
   // 회사명 검색 조건이 있는 경우 쿼리에 조건 추가
   if ($companyName) {
       $query->where('haisya_msts.KAISYA_NAME_JPN', 'like', "%{$companyName}%");
   }

   // 조직명 검색 조건을 받아옴
   $soshikiName = $request->input('soshikiNameInput');
   // 조직명 검색 조건이 있는 경우 쿼리에 조건 추가
   if ($soshikiName) {
       $query->where('taisyo_soshikis.SOSHIKI_NAME_JPN', 'like', "%{$soshikiName}%");

    }

     // 결과를 가져옴
     $results = $query->get();

     // 뷰로 결과 반환
     return view('stress_system.doctor_list', compact('results'));


   }
       // 아무런 조건도 없으면 모든 레코드를 반환 (전체 목록 표시)

}
