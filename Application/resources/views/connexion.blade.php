<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" sizes="144x144" href="storage/app/public/CCI.png" />
        <link rel="stylesheet" href="resources/css/connexion.css">
        <title>Connexion</title>
    </head>
    <body>
        {!! Form::open(['url' => 'connexion']) !!}
        {{ Form::label('nom', 'Nom') }}
        {{ Form::text('nom') }}
        <br>
        {{ Form::label('mdp', 'Mot de passe') }}
        {{ Form::password('mdp') }}
        <br>
        {{ Form::submit('Se connecter') }}
        {!! Form::close() !!}
    </body>
</html>
