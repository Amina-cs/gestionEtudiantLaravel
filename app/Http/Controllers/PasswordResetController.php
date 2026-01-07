<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Etudiant;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // 1. Envoyer le code par Email
    public function sendCode(Request $request) {
        $request->validate(['email' => 'required|email']);

        // Vérifier si l'utilisateur existe (Admin ou Etudiant)
        $user = Admin::where('email', $request->email)->first() 
                ?? Etudiant::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Aucun compte trouvé avec cet email.']);
        }

        // Générer code à 6 chiffres
        $code = rand(100000, 999999);

        // Sauvegarder en base (remplace l'ancien code si existant)
        DB::table('password_codes')->updateOrInsert(
            ['email' => $request->email],
            ['code' => $code, 'created_at' => Carbon::now()]
        );

        // Envoyer l'email (Configurez votre SMTP dans .env)
        Mail::raw("Votre code de réinitialisation est : $code", function ($message) use ($request) {
            $message->to($request->email)->subject("Code de récupération");
        });

        return view('auth.verify-code', ['email' => $request->email]);
    }

    // 2. Vérifier le code et changer le mot de passe
    public function resetPassword(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
            'password' => 'required|min:6|confirmed'
        ]);

        // Vérifier si le code est valide et a moins de 15 minutes
        $record = DB::table('password_codes')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->where('created_at', '>', Carbon::now()->subMinutes(15))
            ->first();

        if (!$record) {
            return back()->withErrors(['code' => 'Code invalide ou expiré.']);
        }

        // Trouver l'utilisateur et mettre à jour
        $user = Admin::where('email', $request->email)->first() 
                ?? Etudiant::where('email', $request->email)->first();

        $user->update(['password' => Hash::make($request->password)]);

        // Supprimer le code utilisé
        DB::table('password_codes')->where('email', $request->email)->delete();

        return redirect('/signin')->with('success', 'Mot de passe modifié avec succès !');
    }
}
