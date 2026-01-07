<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil | {{ auth()->guard('etudiant')->user()->prenom }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased">

    <!-- Barre de navigation -->
    <nav class="bg-white shadow-sm border-b border-emerald-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <!-- Logo Vert -->
                    <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center text-white font-bold shadow-sm shadow-emerald-200">
                        G
                    </div>
                    <span class="text-slate-800 font-bold text-xl tracking-tight">GestionEtudiant</span>
                </div>
                <form action="/signoutetudiant" method="POST">
                    @csrf
                    <button type="submit" class="text-sm font-semibold text-slate-500 hover:text-emerald-600 transition-colors flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto py-12 px-4">
        
        <!-- En-tête de profil -->
        <div class="mb-10 flex flex-col md:flex-row items-center gap-6 text-center md:text-left">
            <!-- Avatar Vert -->
            <div class="w-28 h-28 bg-emerald-100 rounded-3xl flex items-center justify-center text-emerald-700 text-4xl font-black border-4 border-white shadow-xl rotate-3">
                {{ strtoupper(substr(auth()->guard('etudiant')->user()->prenom, 0, 1)) }}{{ strtoupper(substr(auth()->guard('etudiant')->user()->nom, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">
                    {{ auth()->guard('etudiant')->user()->prenom }} {{ auth()->guard('etudiant')->user()->nom }}
                </h1>
                <p class="text-emerald-600 font-semibold text-lg">Étudiant en {{ auth()->guard('etudiant')->user()->filiere->nom }}</p>
                <div class="mt-2 flex gap-2 justify-center md:justify-start">
                    <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full border border-emerald-100 uppercase">
                        {{ auth()->guard('etudiant')->user()->niveau }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Grille d'informations -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Carte Infos Personnelles -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-emerald-50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-slate-800">Identité</h2>
                </div>
                
                <div class="space-y-5">
                    <div class="group">
                        <label class="text-[10px] text-slate-400 uppercase font-black tracking-widest block mb-1">Numéro CIN</label>
                        <p class="text-slate-700 font-semibold bg-slate-50 p-3 rounded-xl border border-transparent group-hover:border-emerald-100 transition-colors">
                            {{ auth()->guard('etudiant')->user()->cin }}
                        </p>
                    </div>
                    <div class="group">
                        <label class="text-[10px] text-slate-400 uppercase font-black tracking-widest block mb-1">Adresse Email</label>
                        <p class="text-slate-700 font-semibold bg-slate-50 p-3 rounded-xl border border-transparent group-hover:border-emerald-100 transition-colors">
                            {{ auth()->guard('etudiant')->user()->email }}
                        </p>
                    </div>
                    <div class="group">
                        <label class="text-[10px] text-slate-400 uppercase font-black tracking-widest block mb-1">Contact Téléphonique</label>
                        <p class="text-slate-700 font-semibold bg-slate-50 p-3 rounded-xl border border-transparent group-hover:border-emerald-100 transition-colors">
                            {{ auth()->guard('etudiant')->user()->tel }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Carte Infos Académiques -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-emerald-50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-slate-800">Scolarité</h2>
                </div>
                
                <div class="space-y-5">
                    <div class="group">
                        <label class="text-[10px] text-slate-400 uppercase font-black tracking-widest block mb-1">Département / Filière</label>
                        <p class="text-slate-700 font-semibold bg-emerald-50/50 p-3 rounded-xl border border-emerald-100">
                            {{ auth()->guard('etudiant')->user()->filiere->nom }}
                        </p>
                    </div>
                    <div class="group">
                        <label class="text-[10px] text-slate-400 uppercase font-black tracking-widest block mb-1">Année d'étude</label>
                        <p class="text-slate-700 font-semibold bg-slate-50 p-3 rounded-xl border border-transparent group-hover:border-emerald-100 transition-colors">
                            {{ auth()->guard('etudiant')->user()->niveau }}
                        </p>
                    </div>
                    <div class="group">
                        <label class="text-[10px] text-slate-400 uppercase font-black tracking-widest block mb-1">État du dossier</label>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></span>
                            <span class="text-emerald-700 font-bold text-sm">Dossier Actif / En règle</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        

    </main>

</body>
</html>