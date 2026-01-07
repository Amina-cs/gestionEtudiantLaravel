<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudEtudiant;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\filiereController;
use App\Http\Controllers\etudiantController;
use App\Http\Controllers\FirebaseAuthController;

Route::get('/', function () {
    return view('welcomePage');
});

Route::get('/signin',
function (){
    return view('signin');
}
);
Route::get('/signup',
function (){
    return view('signup');
}
);
Route::post('/signoutadmin',
[AdminController::class,'logout']);

Route::post('/signoutetudiant',
[EtudiantController::class,'logout']);

Route::post('/submitsignup',
[AdminController::class,'signup']);

Route::post('/submitsignin',
[AdminController::class,'signin']);


Route::get('/etudianthome',function (){
    return view('etudianthome');
});




Route::get('/getbyfiliere',
[CrudEtudiant::class,'getbyfiliere']);

Route::get('/adminhome',
 [CrudEtudiant::class, 'getAll']);


Route::post('/addfiliere',
[filiereController::class,'addfiliere']);

Route::post('/createetudiant',
[CrudEtudiant::class,'create']);


Route::delete('deleteetudiant/{id}',
[CrudEtudiant::class,'delete'])->name('deleteetudiant') ;


Route::get('/updateetudiant/{id}',
 [CrudEtudiant::class, 'update'])->name('updateetudiant');


 Route::put('/admin/profile',
  [AdminController::class, 'updateProfile'])->name('admin.updateProfile');

Route::post('/auth/firebase/login', 
[FirebaseAuthController::class, 'login']);

use App\Http\Controllers\PasswordResetController;

Route::get('/forgot-password', function() { return view('auth.forgot-password'); });
Route::post('/forgot-password', [PasswordResetController::class, 'sendCode']);
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);