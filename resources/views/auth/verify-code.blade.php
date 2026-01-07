<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="min-h-screen flex items-center justify-center bg-slate-50">
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-emerald-100 w-full max-w-md">
                <h2 class="text-2xl font-black text-slate-800 mb-2">Vérification</h2>
                <p class="text-emerald-600 text-sm font-bold mb-6 italic">Un code a été envoyé à {{ $email }}</p>

                <form action="/reset-password" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    
                    <input type="text" name="code" placeholder="Code à 6 chiffres" maxlength="6" required 
                        class="w-full text-center text-2xl tracking-[1em] font-black px-4 py-3 rounded-xl bg-slate-50 border-none focus:ring-2 focus:ring-emerald-500">
                    
                    <input type="password" name="password" placeholder="Nouveau mot de passe" required 
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border-none focus:ring-2 focus:ring-emerald-500">
                    
                    <input type="password" name="password_confirmation" placeholder="Confirmer mot de passe" required 
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border-none focus:ring-2 focus:ring-emerald-500">

                    <button type="submit" class="w-full bg-emerald-600 text-white font-black py-4 rounded-xl hover:bg-emerald-700 transition-all">
                        Réinitialiser
                    </button>
                </form>
            </div>
        </div>
    </body>
</html>