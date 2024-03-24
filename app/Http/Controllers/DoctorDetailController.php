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
            ]
            );


        return redirect()->route('stress_system.doctor_list')->
        with('success', '保存されました。');
    }

    public function updateDoctor(UpdateUserRequest $request, $USER_ID) {
            $user = User::where('USER_ID', $USER_ID)->firstOrFail();
            $user->update($request->validated());

            return redirect()->route('stress_system.doctor_list')->
            with('success', '保存されました。');
    }



    // 修正ページ
    public function detail($USER_ID) {
        // user モデルを使って職員情報を検索
        $user = User::where('USER_ID', $USER_ID)->first();
        return view('stress_system.doctor_detail', compact('user'));
    }

    public function delete($USER_ID) {
        User::where('USER_ID', $USER_ID)->delete();
        return redirect()->route('stress_system.doctor_list')->
        with('success', '');
    }

}
