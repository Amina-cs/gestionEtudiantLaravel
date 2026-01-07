<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
   public function signup(Request $request){
      
        $info=$request->validate(
            ['cin'=>['required','min:6','max:10',Rule::unique('admins','cin')],
            'nom'=>['required','min:3'],
            'prenom'=>['required','min:3'],
            'email'=>['required','email',Rule::unique('admins','email')],
            'password'=>['required','min:6'],
            'tel'=>['required','min:10'],
            ]
            );
           
        $info['password'] = Hash::make($info['password']); 
        $admin=Admin::create($info);
        Auth::guard('admin')->login($admin);


        return redirect('/adminhome')->with('success', 'Compte créé avec succès !');

   }
   public function signin(Request $request){
   
    $info=$request->validate([
        'email'=>['email','required'],
        'password'=>['required','min:3']
    ]);
    if(Auth::guard('admin')->attempt(['email'=>$info['email'],'password'=>$info['password']])){
        $request->session()->regenerate();
        return redirect('/adminhome')->with('message', 'Vous êtes connecté.');

    }
    if(Auth::guard('etudiant')->attempt(['email'=>$info['email'],'password'=>$info['password']])){
        $request->session()->regenerate();
        return redirect('/etudianthome')->with('message', 'Vous êtes connecté.');

    }
    return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->onlyInput('email');
   




   }
   public function logout(Request $request){
    Auth::guard('admin')->logout();
     $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');


   }
   public function updateProfile(Request $request)
{
    $admin = auth()->guard('admin')->user();

    $data = $request->validate([
        'cin' => ['required', Rule::unique('admins')->ignore($admin->id)],
        'nom' => ['required', 'min:3'],
        'prenom' => ['required', 'min:3'],
        'email' => ['required', 'email', Rule::unique('admins')->ignore($admin->id)],
        'tel' => ['required'],
    ]);
    /** @var \App\Models\Admin $admin */
    $admin->update($data);

    return back()->with('success', 'Votre profil a été mis à jour.');
}
}
