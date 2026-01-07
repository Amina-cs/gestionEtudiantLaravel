<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gestion des Etudiants</title>
         @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="min-h-screen flex items-center justify-center">
            <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md border border-gray-100">

                <h2 class="text-3xl font-bold text-center mb-8">Connexion</h2>

                <form class="space-y-4" method="POST" action="/submitsignin">
                    @csrf
                     @if ($errors->any())
                        <div class="bg-red-100 text-red-600 p-3 rounded-lg text-sm">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <input type="email" name="email" placeholder="Email" class="w-full border p-3 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="password" name="password" placeholder="Mot de passe" class="w-full border p-3 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-xl font-bold hover:bg-blue-700">Se connecter</button>
        
                    <!-- Importez Firebase SDK -->
                <script type="module">
                import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
                import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

                const firebaseConfig = {
                apiKey: "AIzaSyDULwvxJFgbaWHHQojktVxk5hFBHZtuu10",
                authDomain: "gestionetudiant-8424e.firebaseapp.com",
                projectId: "gestionetudiant-8424e",
                storageBucket: "gestionetudiant-8424e.firebasestorage.app",
                messagingSenderId: "697614229854",
                appId: "1:697614229854:web:36eaa3d24afc98f33defcf",
                measurementId: "G-9J1BFJF7Q7"
                };

                const app = initializeApp(firebaseConfig);
                const auth = getAuth(app);
                const provider = new GoogleAuthProvider();

                // Fonction pour gérer le clic sur le bouton Google
                window.googleLogin = async (role) => {
                    try {
                    const result = await signInWithPopup(auth, provider);
                    const idToken = await result.user.getIdToken();

                    // Envoyer le token à Laravel via AJAX (Fetch)
                    const response = await fetch('/auth/firebase/login', {
                        method: 'POST',
                        headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ token: idToken, role: role })
                    });

                    const data = await response.json();
                    if (data.success) {
                        window.location.href = data.redirect;
                    } else {
                        alert("Erreur de connexion");
                    }
                    } catch (error) {
                    console.error(error);
                    }
                };
                </script>


                     <button onclick="googleLogin('admin')" type="button" class="w-full border p-3 rounded-xl flex items-center justify-center gap-2 hover:bg-gray-50">
                        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="20"> Continuer avec Google
                    </button>
                     <a href="/forgot-password" class="text-blue-600 font-bold"><p class="mt-6 text-center text-sm">Mot de passe oublié ?</p></a>

                    <p class="mt-6 text-center text-sm">Pas de compte ? <a href="/signup" class="text-blue-600 font-bold">S'inscrire</a></p>

                </form>
            </div>
        </div>
    </body>
</html>