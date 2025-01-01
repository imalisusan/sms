<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TermController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
    Route::post('/register-admin', [AuthController::class, 'registerAdmin']);
    Route::post('/register-parent', [AuthController::class, 'registerParent']);
    Route::get('/users', [AuthController::class, 'getAllUsers']);
});

Route::prefix('classes')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [SchoolClassController::class, 'createClass']);
    Route::get('/', [SchoolClassController::class, 'getAllClasses']);
    Route::post('{id}/terms', [TermController::class, 'addTermToClass']);
    Route::get('{id}/terms', [TermController::class, 'getTermsForClass']);
});

Route::prefix('students')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [StudentController::class, 'addStudent']);
    Route::get('/', [StudentController::class, 'getAllStudents']);
    Route::get('class/{class_id}', [StudentController::class, 'getStudentsByClass']);
    Route::get('{student_id}/payments', [PaymentController::class, 'getPaymentHistory']);
    Route::get('{student_id}/balances', [BalanceController::class, 'getStudentBalances']);
});

Route::prefix('payments')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [PaymentController::class, 'makePayment']);
});

Route::prefix('balances')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [BalanceController::class, 'getAllBalances']);
});


