<!DOCTYPE html>
<html lang="fr" x-data="{ openModal: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Gestion Étudiants</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js pour la gestion du Modal (Simple & léger) -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 font-sans antialiased"  x-data="{ 
        openModal: false, 
        openEditModal: false,
        openAdminModal: false,
        student: { id: '', cin: '', nom: '', prenom: '', email: '', tel: '', filiere_id: '', niveau: '' },
        adminData: { 
            cin: '{{ auth()->guard('admin')->user()->cin }}',
            nom: '{{ auth()->guard('admin')->user()->nom }}',
            prenom: '{{ auth()->guard('admin')->user()->prenom }}',
            email: '{{ auth()->guard('admin')->user()->email }}',
            tel: '{{ auth()->guard('admin')->user()->tel }}'
        }
      }">

    <!-- Navigation -->
    <nav  class="bg-white border-b border-emerald-100 sticky top-0 z-30 ">
       <div class="flex justify-between h-16 items-center">

    <!-- On clique sur le nom pour ouvrir le modal -->
        <button style="margin-left: 30px" @click="openAdminModal = true" class="group flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-all cursor-pointer">
            <div class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center group-hover:bg-emerald-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <span>{{ auth()->guard('admin')->user()->prenom }} {{ auth()->guard('admin')->user()->nom }}</span>
        </button>
        
    <!-- Bouton déconnexion -->
    <form action="/signoutadmin" method="POST">
        @csrf
        <button style="margin-right: 30px" class="p-2 text-slate-400 hover:text-red-500 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
        </button>
    </form>
</div>
    </nav>

    <main class="max-w-7xl mx-auto py-10 px-4">
        
        <!-- Header & Actions -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900">Liste des Étudiants</h1>
                <p class="text-slate-500">Gérez les inscriptions et les informations de vos étudiants.</p>
            </div>
            
            <button @click="openModal = true" class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-emerald-100 transition-all transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Ajouter un étudiant
            </button>
        </div>

        <!-- Filtres -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 mb-6 flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2 text-slate-500 text-sm font-bold uppercase tracking-widest">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filtrer par :
            </div>
            <form action="/getbyfiliere" method="GET" class="flex gap-2">
                <select style="padding: 10px" name="filiere" class="bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-emerald-500">
                    <option value="0">Toutes les filières</option>
                     @foreach($filieres as $filiere)
                    <option  value="{{ $filiere->id }}" {{ request('filiere') == $filiere ? 'selected' : '' }}>
                            {{ $filiere->nom }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-emerald-50 text-emerald-700 px-4 py-2 rounded-xl font-bold text-sm hover:bg-emerald-100 transition-colors">Appliquer</button>
            </form>
        </div>

        <!-- Table des étudiants -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400">Étudiant</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400">Filière</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400">Niveau</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($etudiants as $etudiant)
                    <tr class="hover:bg-emerald-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-700 font-bold text-sm">
                                    {{ substr($etudiant->nom, 0, 1) }}{{ substr($etudiant->prenom, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-800">{{ $etudiant->prenom }} {{ $etudiant->nom }}</div>
                                    <div class="text-xs text-slate-400 font-medium">{{ $etudiant->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-lg uppercase">
                                {{ $etudiant->filiere->nom }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-600">
                            {{ $etudiant->niveau }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                    <button type="button" 
                                        @click="student = { 
                                            id: '{{ $etudiant->id }}', 
                                            cin: '{{ $etudiant->cin }}', 
                                            nom: '{{ $etudiant->nom }}', 
                                            prenom: '{{ $etudiant->prenom }}', 
                                            email: '{{ $etudiant->email }}', 
                                            tel: '{{ $etudiant->tel }}', 
                                            filiere_id: '{{ $etudiant->filiere_id }}', 
                                            niveau: '{{ $etudiant->niveau }}' 
                                        }; openEditModal = true"
                                        class="p-2 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 transition-colors">
                                        
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                <form action="{{ route('deleteetudiant', $etudiant->id) }}" method="POST" onsubmit="return confirm('Supprimer cet étudiant ?')">
                                    @csrf @method('DELETE')
                                    <button class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>

    <!-- FORMULAIRE MODAL (AJOUTER) -->
    <div x-show="openModal" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-cloak>
        
        <div @click.away="openModal = false" 
             class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden transform transition-all">
            
            <div class="bg-emerald-600 px-8 py-6 text-white flex justify-between items-center">
                <h2 class="text-2xl font-black">Nouvel Étudiant</h2>
                <button @click="openModal = false" class="hover:rotate-90 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18" />
                    </svg>
                </button>
            </div>

            <form action="/createetudiant" method="POST" class="p-8 grid grid-cols-2 gap-4">
                @csrf
                <div class="col-span-1">
                    <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">CIN</label>
                    <input style="padding: 10px" type="text" name="cin" required class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div class="col-span-1">
                    <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">Téléphone</label>
                    <input style="padding: 10px" type="text" name="tel" required class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div class="col-span-1">
                    <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">Nom</label>
                    <input style="padding: 10px" type="text" name="nom" required class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div class="col-span-1">
                    <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">Prénom</label>
                    <input style="padding: 10px" type="text" name="prenom" required class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div class="col-span-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">Email</label>
                    <input style="padding: 10px" type="email" name="email" required class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div class="col-span-1">
                    <label style="padding: 10px" class="text-[10px] font-black uppercase text-slate-400 block mb-1">Filière</label>
                    <select style="padding: 10px" name="filiere" class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500">
                        @foreach($filieres as $filiere)
                         <option  value="{{ $filiere->id }}" {{ request('filiere') == $filiere ? 'selected' : '' }}>
                            {{ $filiere->nom }}
                          </option>
                    @endforeach
                    </select>
                </div>
                <div class="col-span-1">
                    <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">Niveau</label>
                    <select style="padding: 10px" name="niveau" class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500">
                        <option>1ère année</option>
                        <option>2ème année</option>
                        <option>3ème année</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">Mot de passe par défaut</label>
                    <input style="padding: 10px" type="password" name="password" required class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                
                <div class="col-span-2 mt-4">
                    <button type="submit" class="w-full bg-emerald-600 text-white font-black py-4 rounded-2xl shadow-lg shadow-emerald-100 hover:bg-emerald-700 transition-colors">
                        Enregistrer l'étudiant
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DE MODIFICATION -->
<div x-show="openEditModal" 
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
     x-cloak>
    
    <div @click.away="openEditModal = false" 
         class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden transform transition-all">
        
        <!-- Header -->
        <div class="bg-amber-500 px-8 py-6 text-white flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-black">Modifier l'Étudiant</h2>
                <p class="text-amber-100 text-sm">Modification des informations de <span x-text="student.prenom"></span></p>
            </div>
            <button @click="openEditModal = false" class="hover:rotate-90 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <!-- Formulaire : Note l'action dynamique avec x-bind:action -->
        <form :action="'/updateetudiant/' + student.id" method="get" class="p-8 grid grid-cols-2 gap-4">
            @csrf
            @method('get') <!-- Indispensable pour la mise à jour en Laravel -->

            <div class="col-span-1">
                <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">CIN</label>
                <input type="text" name="cin" x-model="student.cin" required class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-amber-500 px-4 py-3">
            </div>

            <div class="col-span-1">
                <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">Téléphone</label>
                <input type="text" name="tel" x-model="student.tel" required class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-amber-500 px-4 py-3">
            </div>

            <div class="col-span-1">
                <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">Nom</label>
                <input type="text" name="nom" x-model="student.nom" required class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-amber-500 px-4 py-3">
            </div>

            <div class="col-span-1">
                <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">Prénom</label>
                <input type="text" name="prenom" x-model="student.prenom" required class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-amber-500 px-4 py-3">
            </div>

            <div class="col-span-2">
                <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">Email</label>
                <input type="email" name="email" x-model="student.email" required class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-amber-500 px-4 py-3">
            </div>

            <div class="col-span-1">
                <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">Filière</label>
                <select name="filiere" x-model="student.filiere_id" class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-amber-500 px-4 py-3 font-semibold">
                    @foreach($filieres as $filiere)
                        <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-1">
                <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">Niveau</label>
                <select name="niveau" x-model="student.niveau" class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-amber-500 px-4 py-3 font-semibold">
                    <option value="1ère année">1ère année</option>
                    <option value="2ème année">2ème année</option>
                    <option value="3ème année">3ème année</option>
                </select>
            </div>

            <div class="col-span-2 mt-6">
                <button type="submit" class="w-full bg-emerald-600 text-white font-black py-4 rounded-2xl shadow-lg hover:bg-emerald-700 transition-all">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>
<!-- MODAL PROFIL ADMIN -->
<div x-show="openAdminModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
    <div @click.away="openAdminModal = false" class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden transform transition-all">
        
        <div class="bg-slate-800 px-8 py-6 text-white flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-black">Mon Profil Admin</h2>
                    <p class="text-slate-400 text-xs uppercase tracking-widest font-bold">Paramètres du compte</p>
                </div>
            </div>
            <button @click="openAdminModal = false" class="text-slate-400 hover:text-white transition-colors text-2xl">✕</button>
        </div>

        <form action="{{ route('admin.updateProfile') }}" method="POST" class="p-8 space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2 md:col-span-1">
                    <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">CIN</label>
                    <input type="text" name="cin" x-model="adminData.cin" class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500 px-4 py-3 font-semibold text-slate-700">
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">Téléphone</label>
                    <input type="text" name="tel" x-model="adminData.tel" class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500 px-4 py-3 font-semibold text-slate-700">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-1">
                    <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">Prénom</label>
                    <input type="text" name="prenom" x-model="adminData.prenom" class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500 px-4 py-3 font-semibold text-slate-700">
                </div>
                <div class="col-span-1">
                    <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">Nom</label>
                    <input type="text" name="nom" x-model="adminData.nom" class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500 px-4 py-3 font-semibold text-slate-700">
                </div>
            </div>

            <div>
                <label class="text-[10px] font-black uppercase text-slate-400 block mb-1">Adresse Email</label>
                <input type="email" name="email" x-model="adminData.email" class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500 px-4 py-3 font-semibold text-slate-700">
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-emerald-600 text-white font-black py-4 rounded-2xl shadow-lg hover:bg-emerald-700 transition-all flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Mettre à jour mon profil
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>