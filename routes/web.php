<?php

use App\Http\Controllers\DoctorDelkakuninController;
use App\Http\Controllers\DoctorDelkauninController;
use App\Http\Controllers\DoctorDetailController;
use App\Http\Controllers\DoctorListController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use function Laravel\Prompts\search;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// http://localhost:8000/index operator_menu 이동
Route::get('/index', [IndexController::class, 'index'])
        ->name("stress_system.operator_menu");

// http://localhost:8000/blank 안쓰는 페이지 대충 처리
Route::get('/blank', [IndexController::class, 'blank'])
        ->name('stress_system.blank');

// Route::get('/doctor_list', [SearchController::class, 'hyoji_search'])
//          ->name('stress_system.doctor_list');

Route::get('/doctor_list',[SearchController::class, 'hyoji_search'])
        ->name('stress_system.doctor_list');

// ajaxCompany Route Setting
Route::post('ajaxcompany', [DoctorListController::class, 'AjaxCompany'])
        ->name('AjaxCompany');

// ajaxSoshiki Route Setting
Route::post('ajaxsoshiki', [DoctorListController::class, 'AjaxSoshiki'])
        ->name('AjaxSoshiki');

Route::get('search', [SearchController::class, 'search'])
        ->name('search');

Route::post('/hyoji_search', [SearchController::class, 'hyoji_search'])
        ->name('hyoji_search');

Route::get('doctor_detail', [DoctorDetailController::class,'index'])
        ->name('stress_system.doctor_detail');

// 既存のデータを変更ボタンを押した時
// Route::get('/detail/{USER_ID}', [DoctorDetailController::class,'detail'])
//         ->name('detail');

//既存のデータを変更ボタンを押した時
Route::get('/detail', [DoctorDetailController::class,'detail'])
        ->name('detail');


// GET
Route::get('/detailSearch', [DoctorDetailController::class, 'detailSearch'])
        ->name('detailSearch');

//検索結果を処理するPOSTルート
Route::post('/detailSearch', [DoctorDetailController::class, 'detailSearch'])
        ->name('detailSearch.post');

Route::post('doctor_detail/{USER_ID}', [DoctorDetailController::class, 'updateDoctor'])
        ->name('updateDoctor');

Route::post('doctor_detail', [DoctorDetailController::class, 'saveDoctor'])
        ->name('saveDoctor');

// 削除関連
Route::get('/delete/{USER_ID}', [DoctorDelkakuninController::class,'delete'])
        ->name('delete');


