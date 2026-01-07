<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Illuminate\Support\Str;

class FirebaseAuthController extends Controller
{
    protected $firebaseAuth;

    public function __construct(FirebaseAuth $firebaseAuth) {
        $this->firebaseAuth = $firebaseAuth;
    }

    public function login(Request $request) {
        try {
            // 1. Vérifier le token Firebase
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($request->token);
            $firebaseId = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');
            $name = $verifiedIdToken->claims()->get('name');

            $role = $request->role; // 'admin' ou 'etudiant'
            $model = ($role === 'admin') ? Admin::class : Etudiant::class;
            $guard = ($role === 'admin') ? 'admin' : 'etudiant';

            // 2. Chercher ou créer l'utilisateur
            $user = $model::where('email', $email)->first();

            if (!$user) {
                $user = $model::create([
                    'nom' => $name,
                    'prenom' => '',
                    'email' => $email,
                    'google_id' => $firebaseId,
                    'password' => bcrypt(Str::random(16)),
                    'cin' => 'FB_' . Str::random(5),
                    'tel' => '',
                    // Ajoutez les champs par défaut pour Etudiant si besoin
                    'filiere_id' => ($role === 'etudiant') ? 1 : null, 
                    'niveau' => ($role === 'etudiant') ? '1ère année' : null,
                ]);
            }

            // 3. Connecter dans Laravel
            Auth::guard($guard)->login($user);

            return response()->json([
                'success' => true,
                'redirect' => ($role === 'admin') ? '/adminhome' : '/etudianthome'
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
        }
    }
}