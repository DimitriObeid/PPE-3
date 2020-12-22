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
                <li><a class="menu" href="accueil">ACCUEIL</a></li>
                <li><a class="menu" href="">DÉPARTEMENTS</a></li>
                <li><a class="menu" href="">FOURNITURES</a></li>
                <?php if ($_SESSION['categorie'] == 'Administrateur') { ?>
                    <li><a class="menu" href="">MÉSSAGERIE</a></li>
                    <li><a class="menu" href="">STATISTIQUE</a></li>
                <?php } ?>
                <li><a class="menu" href="demandesspecifiques">DEMANDE SPÉCIFIQUE</a></li>
                <li><a class="menu" href="">SUIVI</a></li>
                <?php if ($_SESSION['categorie'] != 'Administrateur') { ?>
                    <li><a class="menu" href="">PERSONNALISATION DU COMPTE</a></li>
                <?php } ?>
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
            <?php if (isset($_SESSION['commandes'][0])) { ?>
                <table id="commandes_cours">
                    <caption>Commandes en cours</caption>
                    <tr>
                        <th class="tabl_comm">Nom</th>
                        <th class="tabl_comm">Quantité demandé</th>
                        <th class="tabl_comm">État</th>
                        <th class="tabl_comm">Dernière mise à jour</th>
                    </tr>
                <?php for ($h=0; $h < $_SESSION['commandes']->count(); $h++) { ?>
                    <tr>
                        <td class="tabl_comm">{{ $_SESSION['commandes'][$h]->nomCommandes }}</td>
                        <td class="tabl_comm">{{ $_SESSION['commandes'][$h]->quantiteDemande }}</td>
                        <td class="tabl_comm">{{ $_SESSION['commandes'][$h]->nomEtat }}</td>
                        <td class="tabl_comm">{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['commandes'][$h]->updated_at)) }}</td>
                    </tr>
                <?php } ?>
                </table>
            <?php } ?>
        </header>
        <section id="corps">
            <?php
                $refresh = $connexion ?? false;
                if ($refresh) {
                    header('Refresh: 0; url=accueil');
                }

                if ($_SESSION['categorie'] != 'Administrateur') {
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
                                    <td><img class="photo_fournitures" src="http://localhost/PPE-3/Application/storage/app/public/{{ $_SESSION['fournitures'][$i]->nomPhoto }}.jpg" /></td>
                                    <td>{{ $_SESSION['fournitures'][$i]->nomFournitures }}</td>
                                    <td>{{ $_SESSION['fournitures'][$i]->descriptionFournitures }}</td>
                                    <td>{{ $_SESSION['fournitures'][$i]->quantiteDisponible }}</td>
                                    <td>
                                        {!! Form::open(['url' => 'commander']) !!}
                                            <input type="number" name="quantite_disponible" value="0" min="0" max="{{ $_SESSION['fournitures'][$i]->quantiteDisponible }}" />
                                        {{ Form::submit('Commander') }}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                        <?php } ?>
                    </table>

            <?php }
                else {
                    $confirm = $vrai ?? false;
                    if ($confirm) { ?>
                        <p class="confirm"><img class="img_confirm" src="http://localhost/PPE-3/Application/storage/app/public/confirm.png" alt="Icon de confirmation" /> Votre message à bien été envoyé</p><br />
                    <?php header('Refresh: 5; url=accueil');
                    }

                    $confirmSuppr = $suppr ?? false;
                    if ($confirmSuppr) { ?>
                        <p class="confirm"><img class="img_confirm" src="http://localhost/PPE-3/Application/storage/app/public/confirm.png" alt="Icon de confirmation" /> Le message à bien été supprimé</p><br />
                    <?php header('Refresh: 5; url=accueil');
                    }
                    
                    if ($_SESSION['message'] != '') { ?>
                        <section id="message"><h4>Message :</h4>{{ $_SESSION["message"] }}</section>
                    <?php } ?>

                    <h4>Envoyer un message à un utilisateur :</h4>
                    {!! Form::open(['url' => 'message']) !!}
                    {{ Form::textarea('message') }}
                    {{ Form::label('mail', 'Utilisateur :', ['id'=>'label_select']) }}
                        <select name="mail">
                            <?php for ($j=0; $j < $_SESSION['personnels']->count(); $j++) {
                                echo '<option value='.$_SESSION['personnels'][$j]->mail.'>'.$_SESSION['personnels'][$j]->mail.'</option>';
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
                    <?php for ($k=0; $k < $_SESSION['personnels']->count(); $k++) { ?>
                        <tr>
                            <td>{{ $_SESSION['personnels'][$k]->nom }}</td>
                            <td>{{ $_SESSION['personnels'][$k]->prenom }}</td>
                            <td>{{ $_SESSION['personnels'][$k]->mail }}</td>
                            <td>{{ $_SESSION['personnels'][$k]->nomService }}</td>
                            <td>{{ $_SESSION['personnels'][$k]->nomCategorie }}</td>
                            <td>
                                {{ $_SESSION['personnels'][$k]->message }}
                                <?php if ($_SESSION['personnels'][$k]->message != '') { ?>
                                    {!! Form::open(['url' => 'supprimer']) !!}
                                    <?php echo '<input type="hidden" name="mail" value='.$_SESSION['personnels'][$k]->mail.'>' ?>
                                    {{ Form::submit('Supprimer le message', ['id'=>'supprimer_message']) }}
                                    {!! Form::close() !!}
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </table>
                    <table>
                        <caption>Commandes en cours</caption>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Nom de la commande</th>
                            <th>Quantité demandé</th>
                            <th>État</th>
                            <th>Création</th>
                            <th>Dernière mise à jour</th>
                        </tr>
                    <?php for ($l=0; $l < $_SESSION['commandes_liste']->count(); $l++) { ?>
                        <tr>
                            <td>{{ $_SESSION['commandes_liste'][$l]->nom }}</td>
                            <td>{{ $_SESSION['commandes_liste'][$l]->prenom }}</td>
                            <td>{{ $_SESSION['commandes_liste'][$l]->nomCommandes }}</td>
                            <td>{{ $_SESSION['commandes_liste'][$l]->quantiteDemande }}</td>
                            <td>{{ $_SESSION['commandes_liste'][$l]->nomEtat }}</td>
                            <td>{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['commandes_liste'][$l]->created_at)) }}</td>
                            <td>{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['commandes_liste'][$l]->updated_at)) }}</td>
                        </tr>
                    <?php } ?>
                    </table>
                <?php } ?>
        </section>
        <footer>
            <?php if (isset($_SESSION['commandes_fini'][0])) { ?>
                <table id="commandes_fini">
                    <caption>Historique des commandes</caption>
                    <tr>
                        <th class="tabl_comm">Nom</th>
                        <th class="tabl_comm">Quantité demandé</th>
                        <th class="tabl_comm">État</th>
                        <th class="tabl_comm">Dernière mise à jour</th>
                    </tr>
                <?php for ($m=0; $m < $_SESSION['commandes_fini']->count(); $m++) { ?>
                    <tr>
                        <td class="tabl_comm">{{ $_SESSION['commandes_fini'][$m]->nomCommandes }}</td>
                        <td class="tabl_comm">{{ $_SESSION['commandes_fini'][$m]->quantiteDemande }}</td>
                        <td class="tabl_comm">{{ $_SESSION['commandes_fini'][$m]->nomEtat }}</td>
                        <td class="tabl_comm">{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['commandes_fini'][$m]->updated_at)) }}</td>
                    </tr>
                <?php } ?>
                </table>
            <?php } ?>
            <p id="service">Vous êtes dans le service : {{ $_SESSION['service'] }}</p>
            <p id="categorie">Votre rôle est : {{ $_SESSION['categorie'] }}</p>
        </footer>
    </body>
</html>
