<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" sizes="144x144" href="http://localhost/PPE-3/Application/storage/app/public/CCI.png" />
        <link rel="stylesheet" href="http://localhost/PPE-3/Application/resources/css/connexion.css">
        <title>Créer un compte</title>
    </head>
    <body>
        <header>
            <img src="http://localhost/PPE-3/Application/storage/app/public/logo-cci-alsace.png" alt="Logo de la CCI d'alsace" />
            <h1>Inscription</h1>
        </header>
        {!! Form::open(['url' => 'inscription']) !!}
        {{ Form::label('nom', 'Nom') }}
        {{ Form::text('nom') }}
        <br>
        {{ Form::label('prenom', 'Prénom') }}
        {{ Form::text('prenom') }}
        <br>
        {{ Form::label('email', 'Adresse mail') }}
        {{ Form::email('email', $value = null, $attributes = []) }}
        <br>
        {{ Form::label('mdp', 'Mot de passe') }}
        {{ Form::password('mdp') }}
        <br>
        {{ Form::label('categorie', 'Catégorie') }}
        {{ Form::select('categorie',[
                '1' => 'Utilisateur',
                '2' => 'Valideur',
            ]) }}
        <br>
        {{ Form::label('service', 'Service') }}
        {{ Form::select('service',[
                '1' => 'Accueil',
                '2' => 'Comptabilité',
                '3' => 'Administration'
            ]) }}
        <br>
        {{ Form::submit('Créer',['class'=>'submit']) }}
        <button type="button" name="button" onclick="window.location.href='http://localhost/PPE-3/Application/server.php'">Retour à l'accueil</button>
        {!! Form::close() !!}
    </body>
</html>
