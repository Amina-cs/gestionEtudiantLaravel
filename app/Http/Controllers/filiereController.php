<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class filiereController extends Controller
{
    public function addfiliere(Request $request){
        $filiere=$request->validate([
            'filiere'=>['required',Rule::unique('filiere','nom')]
        ]);
        Filiere::create($filiere);
        
        return redirect('/adminhome')->back()->with('success', 'Filière ajoutée !');


    }

    
  
}
