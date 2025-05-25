<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('menunggu', function(){
    return view('tunggu'); //view yg isinya pesan tolak
})->name('tunggu');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    //tambahkan nama alias checkuserroles, dan parameternya (role)
    'CheckUserRoles:super_admin',
    'CheckUserRoles:admin_guru',
    'CheckUserRoles:siswa'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

//pkl-ish
Route::get('dataPkl',App\Livewire\Pkl\Index::class)->name('pkl');
Route::get('/dataPkl/createDataPkl',App\Livewire\Pkl\Create::class)->name('pklCreate');
Route::get('/dataPkl/{id}',App\Livewire\Pkl\View::class)->name('pklView');
Route::get('/dataPkl/{id}/editDataPkl',App\Livewire\Pkl\Edit::class)->name('pklEdit');

//guru-ish
Route::get('/dataGuru',App\Livewire\Guru\Index::class)->name('guru');