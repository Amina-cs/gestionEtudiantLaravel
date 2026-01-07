<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CrudEtudiant extends Controller
{

    public function getAll(){
        $filieres = Filiere::all();
      $etudiants = Etudiant::where('admin_id',Auth::guard('admin')->id())->get();
        return view('adminhome', [
        'filieres' => $filieres, 
        'etudiants' => $etudiants
    ]);
    }
    public function create(Request $request){
        $info=$request->validate([
           'cin'=>['required','min:6','max:10',Rule::unique('etudiants','cin')],
            'nom'=>['required','min:3'],
            'prenom'=>['required','min:3'],
            'email'=>['required','email',Rule::unique('etudiants','email')],
            'password'=>['required','min:6'],
            'tel'=>['required','min:10'],
            'filiere'=>['required'],
            'niveau'=>['required']
        ]);
        $info['password']=Hash::make($info['password']);
        $info['admin_id']=Auth::guard('admin')->id();
        $filire=Filiere::where('id',$info['filiere'])->firstOrFail();
        $info['filiere_id']=$filire->id;
        Etudiant::create($info);

        return $this->getall();        

    }


     public function update(Request $request, $id)
{
    $etudiant = Etudiant::findOrFail($id);

    $info = $request->validate([
        'cin'      => ['required', 'min:6', 'max:10', Rule::unique('etudiants', 'cin')->ignore($id)],
        'nom'      => ['required', 'min:3'],
        'prenom'   => ['required', 'min:3'],
        'email'    => ['required', 'email', Rule::unique('etudiants', 'email')->ignore($id)],
        'tel'      => ['required', 'min:10'],
        'filiere'  => ['required'], 
        'niveau'   => ['required']
    ]);

    $info['filiere_id'] = $info['filiere'];
    unset($info['filiere']); 

    
    if ($request->filled('password')) {
        $info['password'] = Hash::make($request->password);
    } else {
        unset($info['password']);
    }

    $etudiant->update($info);

    return redirect('/adminhome')->with('success', 'Étudiant mis à jour !');
}
    public function getbyID(Request $request,$id){
        
        $etudiant=Etudiant::where('id', $id)
                        ->where('admin_id', auth()->guard('admin')->id())
                        ->firstOrFail(); 
        return $etudiant;
    }
    
    public function delete($id){
        $et=Etudiant::findOrFail($id);
        $et->delete();
       return $this->getall();  
    }

      public function getbyfiliere(Request $request){
       $query = Etudiant::where('admin_id', auth()->guard('admin')->id());
       $filieres = Filiere::all();
       if($request->filiere==0){
        $etudiants=$query->get();
        return view('adminhome', [  
        'etudiants' => $etudiants,
         'filieres' => $filieres,
    ]);
       }
        
        if ($request->has('filiere')) {
            $query->where('filiere_id', $request->filiere);
        }
        $etudiants=$query->get();
         return view('adminhome', [  
        'etudiants' => $etudiants,
         'filieres' => $filieres,
    ]);
    }
   
}
