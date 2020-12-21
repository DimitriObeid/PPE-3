<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" sizes="144x144" href="http://localhost/PPE-3/Application/storage/app/public/CCI.png" />
        <link rel="stylesheet" href="http://localhost/PPE-3/Application/resources/css/demandesspecifiques.css" />
        <title>Demandes spécifiques</title>
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
            <h1>Demandes spécifiques</h1>
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
                if ($_SESSION['categorie'] != 'Administrateur') { ?>

            <?php }
                else { ?>
                    <table>
                        <caption>Liste des demandes spécifiques</caption>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Nom de la demande</th>
                            <th>Quantité demandé</th>
                            <th>Lien du produit</th>
                            <th>État</th>
                            <th>Création</th>
                            <th>Dernière mise à jour</th>
                        </tr>
                    <?php for ($i=0; $i < $_SESSION['demandes']->count(); $i++) { ?>
                        <tr>
                            <td>{{ $_SESSION['demandes'][$i]->nom }}</td>
                            <td>{{ $_SESSION['demandes'][$i]->prenom }}</td>
                            <td>{{ $_SESSION['demandes'][$i]->nomDemande }}</td>
                            <td>{{ $_SESSION['demandes'][$i]->quantiteDemande }}</td>
                            <td>{{ $_SESSION['demandes'][$i]->lienProduit }}</td>
                            <td>{{ $_SESSION['demandes'][$i]->nomEtat }}</td>
                            <td>{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['demandes'][$i]->created_at)) }}</td>
                            <td>{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['demandes'][$i]->updated_at)) }}</td>
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
