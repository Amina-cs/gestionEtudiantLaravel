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
        <h2 class="text-2xl font-black text-slate-800 mb-2">Mot de passe oublié ?</h2>
        <p class="text-slate-500 text-sm mb-6">Entrez votre email pour recevoir un code de validation.</p>

        <form action="/forgot-password" method="POST" class="space-y-4">
            @csrf
            <input type="email" name="email" placeholder="votre@email.com" required 
                class="w-full px-4 py-3 rounded-xl bg-slate-50 border-none focus:ring-2 focus:ring-emerald-500 font-semibold">
            
            <button type="submit" class="w-full bg-emerald-600 text-white font-bold py-3 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">
                Envoyer le code
            </button>
        </form>
    </div>
</div>

    </body>
</html>

