<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" sizes="144x144" href="http://localhost/PPE-3/Application/storage/app/public/CCI.png" />
        <link rel="stylesheet" href="http://localhost/PPE-3/Application/resources/css/accueil.css" />
        <title>Accueil</title>
    </head>
    <body>
        <nav>
            <ul>
                <li id="li_logo"><img id="logo" src="http://localhost/PPE-3/Application/storage/app/public/logo-cci-alsace.png" alt="Logo de la CCI d'alsace" /></li>
                <li><a class="menu" href="dashboard">DASHBOARD</a></li>
                <li><a class="menu" href="">NOS SERVICES</a></li>
                <li><a class="menu" href="">NOS FOURITURES</a></li>
                <li><a class="menu" href="">DEPARTEMENTS</a></li>
                <li><a class="menu" href="">COMMANDE-SUIVI</a></li>
                <li><a class="menu" href="">ETAT</a></li>
                <li><a class="menu" href="">VOIR PLUS</a></li>
            </ul>
        </nav>
        <header>
            <h1>Accueil</h1>
            {!! Form::open(['url' => 'rechercher']) !!}
                <input id="recherche" type="search" name="recherche" placeholder="Recherche" />
                <input type="image" id="envoyer" name="envoyer" src="http://localhost/PPE-3/Application/storage/app/public/icon-search.png" alt="Icone de loupe" />
            {!! Form::close() !!}
            <p id="nom_prenom">{{ $_SESSION['prenom'] }} {{ $_SESSION['nom'] }}</p>
            <button type="button" name="deconnexion" id="deconnexion" onclick="window.location.href='deconnexion'">Se déconnecter</button>
        </header>
        <section id="corps">
            <?php
                if ($_SESSION['nom'] != 'Admin') {
                    if ($_SESSION['message'] != '') { ?>
                        <section id="message"><h4>Message :</h4>{{ $_SESSION["message"] }}</section>
                    <?php } ?>

                    <table>
                        <tr>
                            <th>Photo</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Quantité disponible</th>
                            <th>Quantité demander</th>
                        </tr>
                        <?php for ($i=0; $i < 6; $i++) { ?>
                                <tr>
                                    <td><img class="photo_fournitures" src="http://localhost/PPE-3/Application/storage/app/public/{{ $Fournitures[$i]->nomPhoto }}.jpg" /></td>
                                    <td>{{ $Fournitures[$i]->nomFournitures }}</td>
                                    <td>{{ $Fournitures[$i]->descriptionFournitures }}</td>
                                    <td>{{ $Fournitures[$i]->quantiteDisponible }}</td>
                                    <td>
                                        {!! Form::open(['url' => 'commander']) !!}
                                            <input type="number" name="quantite_disponible" value="0" min="0" max="{{ $Fournitures[$i]->quantiteDisponible }}" />
                                        {{ Form::submit('Commander') }}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                        <?php } ?>
                    </table>

            <?php }
                else {
                    $confirm = $vrai ?? false;
                    if ($confirm)
                    { ?>
                        <p class="confirm"><img class="img_confirm" src="http://localhost/PPE-3/Application/storage/app/public/confirm.png" alt="Icon de confirmation" /> Votre message à bien été envoyé</p><br />
                    <?php }

                    $confirmSuppr = $suppr ?? false;
                    if ($confirmSuppr)
                    { ?>
                        <p class="confirm"><img class="img_confirm" src="http://localhost/PPE-3/Application/storage/app/public/confirm.png" alt="Icon de confirmation" /> Le message à bien été supprimé</p><br />
                    <?php } ?>

                    <h4>Envoyer un message à un utilisateur :</h4>
                    {!! Form::open(['url' => 'message']) !!}
                    {{ Form::textarea('message') }}
                    {{ Form::label('mail', 'Utilisateur :', ['id'=>'label_select']) }}
                        <select name="mail">
                            <?php for ($j=0; $j < $Personnels->count(); $j++) {
                                echo '<option value='.$Personnels[$j]->mail.'>'.$Personnels[$j]->mail.'</option>';
                            } ?>
                        </select>
                    {{ Form::submit('Envoyer') }}
                    {!! Form::close() !!}

                    <table id='liste_comptes'>
                        <caption>Liste des comptes</caption>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Mail</th>
                            <th>Service</th>
                            <th>Catégorie</th>
                            <th id="col_message">Message</th>
                        </tr>
                    <?php for ($k=0; $k < $Personnels->count(); $k++) { ?>
                        <tr>
                            <td>{{ $Personnels[$k]->nom }}</td>
                            <td>{{ $Personnels[$k]->prenom }}</td>
                            <td>{{ $Personnels[$k]->mail }}</td>
                            <td>{{ $Personnels[$k]->nomService }}</td>
                            <td>{{ $Personnels[$k]->nomCategorie }}</td>
                            <td>
                                {{ $Personnels[$k]->message }}
                                <?php if ($Personnels[$k]->message != '') { ?>
                                    {!! Form::open(['url' => 'supprimer']) !!}
                                    <?php echo '<input type="hidden" name="mail" value='.$Personnels[$k]->mail.'>' ?>
                                    {{ Form::submit('Supprimer le message', ['id'=>'supprimer_message']) }}
                                    {!! Form::close() !!}
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </table>
                <?php } ?>
        </section>
        <footer>
            <p id="service">Vous êtes dans le service : {{ $_SESSION['service'] }}</p>
            <p id="categorie">Votre rôle est : {{ $_SESSION['categorie'] }}</p>
        </footer>
    </body>
</html>
