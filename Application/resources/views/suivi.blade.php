<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" sizes="144x144" href="http://localhost/PPE-3/Application/storage/app/public/CCI.png" />
        <link rel="stylesheet" href="http://localhost/PPE-3/Application/resources/css/suivi.css" />
        <title>Suivi</title>
        <script>
            function imprimer(nomSection) {
                var contenuAImprimer = document.getElementById(nomSection).innerHTML;
                var contenuOriginel = document.body.innerHTML;
                document.body.innerHTML = contenuAImprimer;
                window.print();
                document.body.innerHTML = contenuOriginel;
                }
        </script>
    </head>
    <body>
        <nav>
            <ul>
                <li id="li_logo"><img id="logo" src="http://localhost/PPE-3/Application/storage/app/public/logo-cci.png" alt="Logo de la CCI" /></li>
                <li><a class="menu" href="accueil">ACCUEIL</a></li>
                <li><a class="menu" href="departements">DÉPARTEMENTS</a></li>
                <li><a class="menu" href="fournitures">FOURNITURES</a></li>
                <?php if ($_SESSION['categorie'] == 'Administrateur') { ?>
                    <li><a class="menu" href="messagerie">MÉSSAGERIE</a></li>
                    <li><a class="menu" href="statistique">STATISTIQUE</a></li>
                <?php } ?>
                <li><a class="menu" href="demandesspecifiques">DEMANDE SPÉCIFIQUE</a></li>
                <li><a class="menu" href="suivi">SUIVI</a></li>
                <?php if ($_SESSION['categorie'] != 'Administrateur') { ?>
                    <li><a class="menu" id="personnalisation" href="personnalisationducompte">PERSONNALISATION DU COMPTE</a></li>
                <?php } ?>
            </ul>
        </nav>
        <header>
            <h1>Suivi</h1>
            {!! Form::open(['url' => 'rechercher']) !!}
            {{ Form::search('recherche', $value = null, ['id'=>'recherche', 'placeholder'=>'Recherche', 'required'=>'true']) }}
            {{ Form::image('http://localhost/PPE-3/Application/storage/app/public/icon-search.png', 'envoyer', ['id'=>'envoyer', 'alt'=>'Icone de loupe']) }}
            {!! Form::close() !!}
            <div id="nom_deconnexion">
                <p id="nom_prenom">{{ $_SESSION['prenom'] }} {{ $_SESSION['nom'] }}</p>
                <button type="button" name="deconnexion" id="deconnexion" onclick="window.location.href='deconnexion'">Se déconnecter</button>
            </div>
            <?php if (isset($_SESSION['commandes'][0])) { ?>
                <table id="commandes_cours">
                    <caption>Commandes en cours</caption>
                    <tr>
                        <th class="tabl_comm">Nom</th>
                        <th class="tabl_comm">Quantitée demandée</th>
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
        <div id="bouton_imprimer"><button onclick="imprimer('corps');">Imprimer</button></div>
        <section id="corps">
            <?php if ($_SESSION['categorie'] == 'Administrateur') {
                $envoye = $envoyer ?? false;
                if ($envoye) { ?>
                    <p class="confirm"><img class="img_confirm" src="http://localhost/PPE-3/Application/storage/app/public/confirm.png" alt="Icon de confirmation" /> La mise a jour à bien été prise en compte</p><br />
                    <?php header('Refresh: 5; url=demandesspecifiques');
                }

                if (isset($_SESSION['commande_complet'][0])) { ?>
                    <table id="liste_commandes_utilisateur">
                        <caption>Liste des commandes des utilisateurs</caption>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Nom de la commande</th>
                            <th>Quantitée demandée</th>
                            <th>État</th>
                            <th>Création</th>
                            <th>Dernière mise à jour</th>
                        </tr>
                    <?php for ($i=0; $i < $_SESSION['commande_complet']->count(); $i++) { ?>
                        <tr>
                            <td>{{ $_SESSION['commande_complet'][$i]->nom }}</td>
                            <td>{{ $_SESSION['commande_complet'][$i]->prenom }}</td>
                            <td>{{ $_SESSION['commande_complet'][$i]->nomCommandes }}</td>
                            <td>{{ $_SESSION['commande_complet'][$i]->quantiteDemande }}</td>
                            <td>{{ $_SESSION['commande_complet'][$i]->nomEtat }}</td>
                            <td>{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['commande_complet'][$i]->created_at)) }}</td>
                            <td>{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['commande_complet'][$i]->updated_at)) }}</td>
                        </tr>
                    <?php } ?>
                    </table>
                <?php } else { ?>
                    <section id="commande_util">
                        <h4>Liste des commandes des utilisateurs :</h4><br />
                        <p>Il n'y a pas encore de commandes d'utilisateurs.</p>
                    </section>
                <?php } ?>
            <?php }

            if ($_SESSION['categorie'] == 'Valideur') {
                if (isset($_SESSION['commande_valid'])) { ?>
                    <table id="liste_commandes_utilisateur">
                        <caption>Liste des commandes des utilisateurs</caption>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Nom de la commande</th>
                            <th>Quantitée demandée</th>
                            <th>État</th>
                            <th>Création</th>
                            <th>Dernière mise à jour</th>
                            <th> </th>
                        </tr>
                    <?php for ($j=0; $j < $_SESSION['commande_valid']->count(); $j++) { ?>
                        <tr>
                            <td>{{ $_SESSION['commande_valid'][$j]->nom }}</td>
                            <td>{{ $_SESSION['commande_valid'][$j]->prenom }}</td>
                            <td>{{ $_SESSION['commande_valid'][$j]->nomCommandes }}</td>
                            <td>{{ $_SESSION['commande_valid'][$j]->quantiteDemande }}</td>
                            <td>
                                {!! Form::open(['url' => 'majetatcommande']) !!}
                                {{ Form::hidden('id', $_SESSION['commande_valid'][$j]->id) }}
                                {{ Form::select('etat',[
                                'Prise en compte' => 'Prise en compte',
                                'Validé' => 'Validé',
                                'En cours' => 'En cours',
                                'Terminer' => 'Terminer'
                                ], $_SESSION["commande_valid"][$j]->nomEtat) }}
                            </td>
                            <td>{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['commande_valid'][$j]->created_at)) }}</td>
                            <td>{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['commande_valid'][$j]->updated_at)) }}</td>
                            <td>
                                {{ Form::submit('Envoyer') }}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    <?php } ?>
                    </table>
                <?php } else { ?>
                    <section id="commande_valid">
                        <h4>Liste des commandes des utilisateurs :</h4><br />
                        <p>Il n'y a pas encore de commandes d'utilisateurs.</p>
                    </section>
                <?php }
            }

            if (isset($_SESSION['commande_utilisateur'][0])) { ?>
                <table id="liste_commandes">
                    <caption>Liste des commandes</caption>
                    <tr>
                        <th>Nom de la commande</th>
                        <th>Quantitée demandée</th>
                        <th>État</th>
                        <th>Création</th>
                        <th>Dernière mise à jour</th>
                    </tr>
                <?php for ($k=0; $k < $_SESSION['commande_utilisateur']->count(); $k++) { ?>
                    <tr>
                        <td>{{ $_SESSION['commande_utilisateur'][$k]->nomCommandes }}</td>
                        <td>{{ $_SESSION['commande_utilisateur'][$k]->quantiteDemande }}</td>
                        <td>{{ $_SESSION['commande_utilisateur'][$k]->nomEtat }}</td>
                        <td>{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['commande_utilisateur'][$k]->created_at)) }}</td>
                        <td>{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['commande_utilisateur'][$k]->updated_at)) }}</td>
                    </tr>
                <?php } ?>
                </table>
            <?php } else { ?>
                <section id="commande_pers">
                    <h4>Liste des commandes :</h4><br />
                    <p>Vous n'avez pas encore effectué de commandes.</p>
                </section>
            <?php } ?>
        </section>
        <footer>
            <?php if (isset($_SESSION['commandes_fini'][0])) { ?>
                <table id="commandes_fini">
                    <caption>Historique des commandes</caption>
                    <tr>
                        <th class="tabl_comm">Nom</th>
                        <th class="tabl_comm">Quantitée demandée</th>
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
