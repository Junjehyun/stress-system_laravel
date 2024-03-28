<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;

class DoctorDetailController extends Controller
{
    public function index(){

        return view('stress_system.doctor_detail');
    }

    public function detailSearch(Request $request) {

        // 社員IDを受け取る
        $syainId = $request->input('USER_ID');

        // USERモデルを使って社員のじょうほうを検索
        $syain = User::where('USER_ID', $syainId)->first();

        //結果がをリターン
        return response()->json($syain);

    }

    public function saveDoctor(CreateUserRequest $request) {

        $syainId = User::updateOrCreate(
            ['USER_ID' => $request->USER_ID],
            [
                'name' => $request->name,
                'KAISYA_CODE' => $request->KAISYA_CODE,
                'SOSHIKI_CODE' => $request->SOSHIKI_CODE,
                'KENGEN_KUBUN' => $request->KENGEN_KUBUN,
            ]
            );

        return redirect()->route('stress_system.doctor_list')->
        with('success', '保存されました。');
    }

    public function updateDoctor(UpdateUserRequest $request, $USER_ID) {

            $user = User::where('USER_ID', $USER_ID)->firstOrFail();
            $user->update(
                $request->validated()+ ['KENGEN_KUBUN' => $request->KENGEN_KUBUN]
            );

            return redirect()->route('stress_system.doctor_list')->
            with('success', '保存されました。');
    }


// 修正ページ
public function detail(Request $request) {

//dd($request->all());

        $companyCheck = $request->input('comCheck');
        $companyNameIn = $request->input('companyNameIn');
        $companyNameOut = $request->input('companyNameOut');
        $soCheck = $request->input('soCheck');
        $soshikiNameIn = $request->input('soshikiNameIn');
        $soshikiNameOut = $request->input('soshikiNameOut');
        $kengenCheck = $request->input('kengenCheck');
        $kengenKubun = $request->input('kengenKubun');

        //$user = User::where('USER_ID', $USER_ID)->first();
        $user = User::where('USER_ID', $request->input('USER_ID'))->first();
        //dd($companyNameIn);

        return view('stress_system.doctor_detail', compact
        ('user', 'companyCheck', 'companyNameIn', 'companyNameOut','soCheck','soshikiNameIn',
             'soshikiNameOut','kengenCheck','kengenKubun'));
     }

    public function createDoctorDetail($userId = null) {

        $user = null;
        if ($userId) {
            $user = User::find($userId);

        }

        return view('doctor_detail', compact('user'));

    }



}
