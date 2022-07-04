<?php

use App\Http\Controllers\Main\Account\BasicController;
use App\Http\Controllers\Main\Account\PasswordController;
use App\Http\Controllers\Main\Article\ArticleController;
use App\Http\Controllers\Main\Article\ManageArticleController;
use App\Http\Controllers\Main\Auth\AuthenticatedController;
use App\Http\Controllers\Main\Auth\LoginController;
use App\Http\Controllers\Main\Auth\RegisterController;
use App\Http\Controllers\Main\Auth\RetrievePasswordController;
use App\Http\Controllers\Main\Auth\VerificationController;
use App\Http\Controllers\Main\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'loginForm'])->defaults('_config', [
    'view' => 'main.auth.login',
])->name('home');
Route::group(['prefix' => 'login', 'as' => 'login.'], static function () {
    Route::post('/', [LoginController::class, 'processLogin'])->name('process-login');
});

Route::group(['prefix' => 'register', 'as' => 'register.'], static function () {
    Route::get('/', [RegisterController::class, 'registerForm'])->defaults('_config', [
        'view' => 'main.auth.register',
    ])->middleware(['guest:user'])->name('form');
    Route::post('/', [RegisterController::class, 'processRegistration'])->name('process-register');
    //verify account
    Route::get('verify/{confirmationToken}', [VerificationController::class, 'processVerification'])->name('verify');
    //verification
    Route::group(['prefix' => 'verification', 'as' => 'verification.'], static function () {
        //resend verification email
        Route::get('resend', [VerificationController::class, 'showResendForm'])->defaults('_config', [
            'view' => 'main.auth.verification.resend_form',
        ])->name('resend');
        Route::post('resend',
            [VerificationController::class, 'processResend'])->middleware(['throttle:user,6,8'])->name('resend-post');
    });
});


Route::group(['prefix' => 'password', 'as' => 'password.', 'middleware' => ['guest:user']], static function () {
    //reset request
    Route::get('request', [RetrievePasswordController::class, 'requestForm'])->defaults('_config', [
        'view' => 'main.auth.password.request',
    ])->name('reset-request');

    Route::post('reset_request', [RetrievePasswordController::class, 'processRequest'])->name('process-reset-request');
    //complete reset
    Route::get('reset-password/{passwordResetToken}',
        [RetrievePasswordController::class, 'resetForm'])->defaults('_config', [
        'view' => 'main.auth.password.reset',
    ])->name('reset');
    Route::post('process_reset', [RetrievePasswordController::class, 'processReset'])->defaults('_config', [
        'redirect' => 'app.login.form',
    ])->name('process-reset');
});
Route::group(['middleware' => ['auth:user']], static function () {
    Route::group(['as' => 'account.', 'prefix' => 'account'], static function () {
        Route::delete('logout', [AuthenticatedController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->defaults('_config', [
            'view' => 'main.dashboard',
        ])->name('dashboard');
        Route::group(['as' => 'manage.', 'prefix' => 'manage'], static function () {
            Route::get('basic', [BasicController::class, 'index'])->defaults('_config', [
                'view' => 'main.account.manage.basic',
            ])->name('basic');
            Route::post('basic', [BasicController::class, 'processBasic'])->defaults('_config', [
                'redirect' => 'app.account.manage.basic',
            ]);
            Route::post('password', [PasswordController::class, 'processPassword'])->defaults('_config', [
                'redirect' => 'app.account.manage.basic',
            ])->name('password-post');
        });
    });

    Route::group(['as' => 'articles.', 'prefix' => 'articles'], static function () {
        Route::get('new', [ManageArticleController::class, 'createForm'])->defaults('_config', [
            'view' => 'main.articles.form',
        ])->name('new');
        Route::post('new', [ManageArticleController::class, 'store']);

        Route::group(['as' => 'single.', 'prefix' => '{article}'], static function (){
            Route::get('edit', [ManageArticleController::class, 'editForm'])->defaults('_config', [
                'view' => 'main.articles.form',
            ])->name('edit')->middleware('article.can-update-delete');
            Route::post('edit', [ManageArticleController::class, 'update'])->middleware('article.can-update-delete');

            Route::get('single', [ArticleController::class, 'single'])->defaults('_config', [
                'view' => 'main.articles.single',
            ])->name('view');

            Route::delete('remove', [ManageArticleController::class, 'delete'])->name('remove')->middleware('article.can-update-delete');
        });
    });
});
