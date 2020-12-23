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

            if (isset($erreur))
            {
                if ($erreur == 'mail')
                {
                    echo '<p id="erreur"><img id="warning" src="http://localhost/PPE-3/Application/storage/app/public/warning.png" alt="Icon de warning" /> L\'adresse mail est incorrect !</p>';
                    header('Refresh: 5; url=http://localhost/PPE-3/Application/server.php');
                }
                elseif ($erreur == 'mdp')
                {
                    echo '<p id="erreur"><img id="warning" src="http://localhost/PPE-3/Application/storage/app/public/warning.png" alt="Icon de warning" /> Le mot de passe est incorrect !</p>';
                    header('Refresh: 5; url=http://localhost/PPE-3/Application/server.php');
                }
            }

            if ($errors->any()) {
                echo $errors;
                foreach ($errors->all() as $key => $value) {
                    echo $key.$value;
                }
            }
        ?>
        {!! Form::open(['url' => 'connexion']) !!}
        {{ Form::label('email', 'Adresse mail') }}
        {{ Form::email('email', $value = null, $attributes = []) }}
        <br>
        {{ Form::label('mdp', 'Mot de passe') }}
        {{ Form::password('mdp') }}
        <br>
        {{ Form::submit('Se connecter',['class'=>'submit']) }}
        {{ Form::button('Créer un compte',['onclick'=>'window.location.href="http://localhost/PPE-3/Application/server.php/inscription"']) }}
        {!! Form::close() !!}
    </body>
</html>
