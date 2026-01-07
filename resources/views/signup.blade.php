<!DOCTYPE html>
<html>
    <head>
         <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gestion des Etudiants</title>
         @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>

    <body>
        <div class="min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md border border-gray-100">
        <h2 class="text-2xl font-bold text-center mb-2">Inscription Admin</h2>
        <p class="text-gray-400 text-sm text-center mb-6 italic">Remplissez ces champs pour créer votre compte</p>
        <form action="/submitsignup" method="POST" class="space-y-3">
            @csrf
                @if ($errors->any())
                    <div class="bg-red-100 text-red-600 p-3 rounded-lg text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif
            <input type="text" name="cin" placeholder="CIN" class="w-full border p-2 rounded-lg" required>
            <div class="flex gap-2">
                <input type="text" name="prenom" placeholder="Prénom" class="w-full border p-2 rounded-lg" required>
                <input type="text" name="nom" placeholder="Nom" class="w-full border p-2 rounded-lg" required>
            </div>
            <input type="text" name="tel" placeholder="Téléphone" class="w-full border p-2 rounded-lg">
            <input type="email" name="email" placeholder="Email" class="w-full border p-2 rounded-lg" required>
            <input type="password" name="password" placeholder="Mot de passe" class="w-full border p-2 rounded-lg" required>
            <button style="cursor: pointer" type="submit" class="w-full bg-blue-600 text-white p-3 rounded-xl font-bold mt-4 shadow-lg">S'inscrire</button>
        </form>
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


        <button type="button" onclick="googleLogin('admin')" style="margin-top: 15px;cursor:pointer" class="w-full border p-3 rounded-xl flex items-center justify-center gap-2 hover:bg-gray-50  ">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="20"> Continuer avec Google
        </button>
    </div>
</div>
    </body>
</html>