<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gestion des Etudiants</title>
        <link rel="stylesheet" href="{{asset('css/welcomePage.css')}}">

    </head>
    <body>

        
        <div class="container">
            <div>
                <img class="img" src="{{asset('images/ptr.png')}}">
            </div>
            <div>
                <h1 class="h1">Bienvenue sur la plateforme de gestion des étudiants</h1>
                <div class="h2"> Créez un compte comme un admin et ajoutez vos étudiants.</div>
                <a href="{{url('/signup')}}">
                 <button class="button button-primary" >Sign up</button>
                </a>
                <a href="{{url('/signin')}}">
                    <button class="button button-primary">Sign in</button>
                </a>
               
            </div>
        </div>

        

    </body>
</html>