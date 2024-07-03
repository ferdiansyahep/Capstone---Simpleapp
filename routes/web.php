<?php

use Illuminate\Support\Facades\Auth;
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

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'beranda'])->name('beranda');
    Route::get('nilai',[\App\Http\Controllers\Admin\SiswaController::class, 'hasilUjian'])->name('client.results');
    Route::get('daftar-nilai',[\App\Http\Controllers\Admin\GuruController::class, 'daftarNilai'])->name('client.nilai');
    Route::get('results/{result_id}',[\App\Http\Controllers\ResultController::class, 'show'])->name('client.results.show');
    Route::get('/ujian', [\App\Http\Controllers\Admin\SiswaController::class, 'jadwalUjian'])->name('admin.client.index');
    Route::get('admin/guru/mata-pelajaran', [\App\Http\Controllers\Admin\GuruController::class, 'myClass'])->name('guru.categories');
    Route::post('/admin/categories/verify/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'verifyExamCode'])->name('admin.categories.verify');
    Route::get('/admin/questions/create/{id}', [App\Http\Controllers\Admin\QuestionController::class, 'create'])->name('admin.questions.createQuestions');
    Route::get('/admin/categories/{category}/results', [\App\Http\Controllers\Admin\CategoryController::class, 'showResults'])->name('admin.categories.results');

    
    // admin only
    Route::group(['middleware' => 'isAdmin','prefix' => 'admin', 'as' => 'admin.'], function() {
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
        Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
        Route::delete('permissions_mass_destroy', [\App\Http\Controllers\Admin\PermissionController::class, 'massDestroy'])->name('permissions.mass_destroy');
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
        Route::delete('roles_mass_destroy', [\App\Http\Controllers\Admin\RoleController::class, 'massDestroy'])->name('roles.mass_destroy');

        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::delete('users_mass_destroy', [\App\Http\Controllers\Admin\UserController::class, 'massDestroy'])->name('users.mass_destroy');
        
        Route::resource('guru',\App\Http\Controllers\Admin\GuruController::class);
        Route::get('guru/kelas/{kelas}', [\App\Http\Controllers\Admin\GuruController::class, 'index']);
        Route::put('admin/guru/{guru}', [\App\Http\Controllers\Admin\GuruController::class, 'update'])->name('admin.guru.update');

        Route::resource('siswa',\App\Http\Controllers\Admin\SiswaController::class);
        Route::get('siswa/kelas/{kelas_id}', [\App\Http\Controllers\Admin\SiswaController::class, 'index']);
        Route::put('admin/siswa/{siswa}', [\App\Http\Controllers\Admin\SiswaController::class, 'update'])->name('admin.siswa.update');
        
        Route::get('/siswa/{siswa}/add-mapel', [\App\Http\Controllers\Admin\SiswaController::class, 'addSubject'])->name('siswa.addSubject');
        Route::post('/siswa/{siswa}/store-mapel', [\App\Http\Controllers\Admin\SiswaController::class, 'storeSubject'])->name('siswa.storeSubject');

        // menampilkan kelas siswa
        Route::get('/kelas', [\App\Http\Controllers\Admin\SiswaController::class, 'kelas'])->name('siswa.kelas');

        // categories
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::delete('categories_mass_destroy', [\App\Http\Controllers\Admin\CategoryController::class, 'massDestroy'])->name('categories.mass_destroy');
        Route::post('categories/{category}/questions/{question}/answer', [\App\Http\Controllers\Admin\CategoryController::class, 'show'])->name('categories.answer');
        // categories
        Route::resource('mapel', \App\Http\Controllers\Admin\MapelController::class);
        Route::delete('mapel_mass_destroy', [\App\Http\Controllers\Admin\MapelController::class, 'massDestroy'])->name('mapel.mass_destroy');
        Route::get('mapel/kelas/{kelas_id}', [\App\Http\Controllers\Admin\MapelController::class, 'index']);


        // questions
        Route::resource('questions', \App\Http\Controllers\Admin\QuestionController::class);
        Route::delete('questions_mass_destroy', [\App\Http\Controllers\Admin\QuestionController::class, 'massDestroy'])->name('questions.mass_destroy');

        // options
        Route::resource('options', \App\Http\Controllers\Admin\OptionController::class);
        Route::delete('options_mass_destroy', [\App\Http\Controllers\Admin\OptionController::class, 'massDestroy'])->name('options.mass_destroy');

        // results
        Route::resource('results', \App\Http\Controllers\Admin\ResultController::class);
        Route::delete('results_mass_destroy', [\App\Http\Controllers\Admin\ResultController::class, 'massDestroy'])->name('results.mass_destroy');
    });
});

Auth::routes();