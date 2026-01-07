<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Etudiant;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class EtudiantController extends Controller
{
    public function signin(Request $request){
        $info=$request->validate([
            'email'=>['required','email'],
            'password'=>['required','min:3']
        ]);
       if (Auth::guard('etudiant')->attempt(['email'=>$info['email'],'password'=>$info['password']])){
         $request->session()->regenerate();
        return redirect('/etudianthome')->with('message', 'Vous êtes connecté.');
       }

         return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->onlyInput('email');
    }
    public function logout(Request $request){
         Auth::guard('etudiant')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
