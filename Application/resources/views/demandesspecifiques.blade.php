<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" sizes="144x144" href="http://localhost/PPE-3/Application/storage/app/public/CCI.png" />
        <link rel="stylesheet" href="http://localhost/PPE-3/Application/resources/css/demandesspecifiques.css" />
        <title>Demandes spécifiques</title>
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
            <h1>Demandes spécifiques</h1>
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
        <?php if ($_SESSION['categorie'] == 'Administrateur') { ?>
            <div id="bouton_imprimer"><button onclick="imprimer('corps');">Imprimer</button></div>
        <?php } ?>
        <section id="corps">
            <?php if ($_SESSION['categorie'] != 'Administrateur') {
                    $confirm = $vrai ?? false;
                    if ($confirm) { ?>
                        <p class="confirm"><img class="img_confirm" src="http://localhost/PPE-3/Application/storage/app/public/confirm.png" alt="Icon de confirmation" /> Votre demande a bien été envoyée</p><br />
                    <?php header('Refresh: 5; url=demandesspecifiques');
                    }

                    $envoye = $envoyer ?? false;
                    if ($envoye) { ?>
                        <p class="confirm"><img class="img_confirm" src="http://localhost/PPE-3/Application/storage/app/public/confirm.png" alt="Icon de confirmation" /> La mise a jour à bien été prise en compte</p><br />
                        <?php header('Refresh: 5; url=demandesspecifiques');
                    } ?>

                    <h4>Effectuer une demande spécifique :</h4><br />
                    {!! Form::open(['url' => 'creationdemande']) !!}
                    {{ Form::label('nom_demande', 'Nom de la demande :') }}
                    {{ Form::text('nom_demande', $value = null, ['maxlength'=>'50', 'placeholder'=>'Ex: Lampe de projecteur', 'required'=>'true']) }}
                    {{ Form::label('quantite_demande', 'Quantitée demandée :') }}
                    {{ Form::number('quantite_demande', '1', ['min'=>'1', 'max'=>'50']) }}
                    {{ Form::label('lien_produit', 'Lien vers le produit :') }}
                    {{ Form::text('lien_produit', $value = null, ['maxlength'=>'200', 'placeholder'=>'Optionnel']) }}
                    {{ Form::submit('Envoyer la demande') }}
                    {!! Form::close() !!}

                    <?php if ($_SESSION['categorie'] == 'Valideur') {
                        if (isset($_SESSION['demandes_valid'][0])) { ?>
                            <table id="tab_ut">
                                <caption class="titre_demande">Liste des demandes des utilisateurs</caption>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Nom de la demande</th>
                                    <th>Quantitée demandée</th>
                                    <th>Lien du produit</th>
                                    <th>État</th>
                                    <th>Création</th>
                                    <th>Dernière mise à jour</th>
                                    <th> </th>
                                </tr>
                                <?php for ($i=0; $i < $_SESSION['demandes_valid']->count(); $i++) { ?>
                                    <tr>
                                        <td>{{ $_SESSION['demandes_valid'][$i]->nom }}</td>
                                        <td>{{ $_SESSION['demandes_valid'][$i]->prenom }}</td>
                                        <td>{{ $_SESSION['demandes_valid'][$i]->nomDemande }}</td>
                                        <td>{{ $_SESSION['demandes_valid'][$i]->quantiteDemande }}</td>
                                        <td class="lien_produit">
                                            <?php if ($_SESSION['demandes_valid'][$i]->lienProduit != 'Aucun lien fourni') { ?>
                                                <a href="{{ $_SESSION['demandes_valid'][$i]->lienProduit }}" target="_blank">{{ $_SESSION['demandes_valid'][$i]->lienProduit }}</a>
                                            <?php } else {
                                                echo $_SESSION['demandes_valid'][$i]->lienProduit;
                                            } ?>
                                        </td>
                                        <td>
                                            {!! Form::open(['url' => 'majetatdemande']) !!}
                                            {{ Form::hidden('id', $_SESSION['demandes_valid'][$i]->id) }}
                                            {{ Form::select('etat',[
                                            'Prise en compte' => 'Prise en compte',
                                            'Validé' => 'Validé',
                                            'En cours' => 'En cours',
                                            'Terminer' => 'Terminer'
                                            ], $_SESSION["demandes_valid"][$i]->nomEtat) }}
                                        </td>
                                        <td>{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['demandes_valid'][$i]->created_at)) }}</td>
                                        <td>{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['demandes_valid'][$i]->updated_at)) }}</td>
                                        <td>
                                            {{ Form::submit('Envoyer') }}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } else { ?>
                            <section id="demandes_utilisateur">
                                <h4>Demandes utilisateurs :</h4><br />
                                <p>Vous n'avez pas de demandes d'utilisateurs.</p>
                            </section>
                        <?php   }
                    }
                    if (isset($_SESSION['demandes_pers'][0])) { ?>
                        <table id="demandes_pers">
                            <caption class="titre_demande">Liste des demandes effectuées :</caption>
                            <tr>
                                <th>Nom de la demande</th>
                                <th>Quantitée demandée</th>
                                <th>Lien du produit</th>
                                <th>État</th>
                                <th>Création</th>
                                <th>Dernière mise à jour</th>
                            </tr>
                        <?php for ($j=0; $j < $_SESSION['demandes_pers']->count(); $j++) { ?>
                            <tr>
                                <td>{{ $_SESSION['demandes_pers'][$j]->nomDemande }}</td>
                                <td>{{ $_SESSION['demandes_pers'][$j]->quantiteDemande }}</td>
                                <td class="lien_produit">
                                    <?php if ($_SESSION['demandes_pers'][$j]->lienProduit != 'Aucun lien fourni') { ?>
                                    <a href="{{ $_SESSION['demandes_pers'][$j]->lienProduit }}" target="_blank">{{ $_SESSION['demandes_pers'][$j]->lienProduit }}</a>
                                    <?php } else {
                                        echo $_SESSION['demandes_pers'][$j]->lienProduit;
                                    } ?>
                                </td>
                                <td>{{ $_SESSION['demandes_pers'][$j]->nomEtat }}</td>
                                <td>{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['demandes_pers'][$j]->created_at)) }}</td>
                                <td>{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['demandes_pers'][$j]->updated_at)) }}</td>
                            </tr>
                        <?php } ?>
                        </table>
              <?php } else { ?>
                        <section id="demandes_spec">
                            <h4>Demandes spécifiques :</h4><br />
                            <p>Vous n'avez pas encore effectué de demandes.</p>
                        </section>
              <?php }
                  } else { ?>
                      <table id="demandes_list">
                          <caption>Liste des demandes spécifiques</caption>
                          <tr>
                              <th>Nom</th>
                              <th>Prénom</th>
                              <th>Nom de la demande</th>
                              <th>Quantitée demandée</th>
                              <th>Lien du produit</th>
                              <th>État</th>
                              <th>Création</th>
                              <th>Dernière mise à jour</th>
                          </tr>
                      <?php for ($k=0; $k < $_SESSION['demandes']->count(); $k++) { ?>
                          <tr>
                              <td>{{ $_SESSION['demandes'][$k]->nom }}</td>
                              <td>{{ $_SESSION['demandes'][$k]->prenom }}</td>
                              <td>{{ $_SESSION['demandes'][$k]->nomDemande }}</td>
                              <td>{{ $_SESSION['demandes'][$k]->quantiteDemande }}</td>
                              <td class="lien_produit">
                                  <?php if ($_SESSION['demandes'][$k]->lienProduit != 'Aucun lien fourni') { ?>
                                  <a href="{{ $_SESSION['demandes'][$k]->lienProduit }}" target="_blank">{{ $_SESSION['demandes'][$k]->lienProduit }}</a>
                                  <?php } else {
                                      echo $_SESSION['demandes'][$k]->lienProduit;
                                  } ?>
                              </td>
                              <td>{{ $_SESSION['demandes'][$k]->nomEtat }}</td>
                              <td>{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['demandes'][$k]->created_at)) }}</td>
                              <td>{{ date('G:i:s \l\e d-m-Y', strtotime($_SESSION['demandes'][$k]->updated_at)) }}</td>
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
