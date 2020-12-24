<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" sizes="144x144" href="http://localhost/PPE-3/Application/storage/app/public/CCI.png" />
        <link rel="stylesheet" href="http://localhost/PPE-3/Application/resources/css/connexion.css" />
        <title>Connexion</title>
    </head>
    <body>
        <header>
            <img src="http://localhost/PPE-3/Application/storage/app/public/logo-cci-alsace.png" alt="Logo de la CCI d'alsace" />
            <h1>Connexion</h1>
        </header>
        <?php
            $refresh = $deconnexion ?? false;
            if ($refresh) {
                header('Refresh: 0; url=http://localhost/PPE-3/Application/server.php');
            }

            if (isset($erreur)) {
                if ($erreur == 'mail') { ?>
                    <p class="erreur"><img class="img_erreur" src="http://localhost/PPE-3/Application/storage/app/public/warning.png" alt="Icone d'erreur" /> L\'adresse mail est incorrect !</p>
                <?php }
                elseif ($erreur == 'mdp') { ?>
                    <p class="erreur"><img class="img_erreur" src="http://localhost/PPE-3/Application/storage/app/public/warning.png" alt="Icone d'erreur" /> Le mot de passe est incorrect !</p>
                <?php }
            }
        ?>
        {!! Form::open(['url' => 'connexion']) !!}
        {{ Form::label('email', 'Adresse mail') }}
        {{ Form::email('email', $value = null, ['required'=>'true']) }}
        <br>
        {{ Form::label('mdp', 'Mot de passe') }}
        {{ Form::password('mdp', ['required'=>'true']) }}
        <br>
        {{ Form::submit('Se connecter', ['class'=>'submit']) }}
        {{ Form::button('Créer un compte', ['onclick'=>'window.location.href="http://localhost/PPE-3/Application/server.php/inscription"']) }}
        {!! Form::close() !!}
    </body>
</html>
