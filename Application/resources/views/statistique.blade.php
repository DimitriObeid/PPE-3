<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" sizes="144x144" href="http://localhost/PPE-3/Application/storage/app/public/CCI.png" />
        <link rel="stylesheet" href="http://localhost/PPE-3/Application/resources/css/statistique.css" />
        <title>Statistique</title>
        <script type="text/javascript">
            function afficherMenu(menu) {
                menu.style.visibility = "visible";
            }

            function cacherMenu(menu) {
                menu.style.visibility = "hidden";
            }
        </script>
    </head>
    <body>
        <nav>
            <ul>
                <li id="li_logo"><img id="logo" src="http://localhost/PPE-3/Application/storage/app/public/logo-cci.png" alt="Logo de la CCI" /></li>
                <?php if ($_SESSION['categorie'] != 'Administrateur') { ?>
                    <li><a class="menu" href="accueil">ACCUEIL</a></li>
                <?php } else { ?>
                    <li><a class="menu" href="accueil" onmouseover="afficherMenu(menu_lateral)" onmouseout="cacherMenu(menu_lateral)">ACCUEIL</a></li>
                <?php } ?>
                <li><a class="menu" href="departements">DÉPARTEMENTS</a></li>
                <li><a class="menu" href="fournitures">FOURNITURES</a></li>
                <?php if ($_SESSION['categorie'] == 'Administrateur') { ?>
                    <li><a class="menu" href="famillesfournitures">FAMILLES FOURNITURES</a></li>
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
        <nav id="menu_lateral"  onmouseover="afficherMenu(menu_lateral)" onmouseout="cacherMenu(menu_lateral)">
            <ul id="ul_menu_lateral">
                <li class="li_menu_lateral"><a class="menu_lateral" href="accueil#navlistecomptes">Liste des comptes</a></li>
                <li class="li_menu_lateral"><a class="menu_lateral" href="accueil#supprimer_tous">Supprimer tous les messages</a></li>
                <li class="li_menu_lateral"><a class="menu_lateral" href="accueil#liste_commandes">Liste des commandes en cours</a></li>
            </ul>
        </nav>
        <header>
            <h1>Statistique</h1>
            {!! Form::open(['url' => 'rechercher']) !!}
            {{ Form::search('recherche', $value = null, ['id'=>'recherche', 'placeholder'=>'Recherche', 'required']) }}
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

        <section id="corps">
          <?php if (isset($reponse)) { ?>
            <a href="statistique" id="retour">< Retour à la page statistique</a><br /><br />
            <?php if ($reponse) { ?>
              <?php if (isset($Statistiques_commande[0])) { ?>
              <table id="statistiques">
                    <caption>Statistiques</caption>
                    <tr>
                        <th class="tabl_comm">Nom</th>
                        <th class="tabl_comm">Quantitée demandée</th>
                        <th class="tabl_comm">Service</th>
                        <th class="tabl_comm">Création</th>
                    </tr>
                <?php foreach ($Statistiques_commande as $lignes => $colonnes) { ?>
                    <tr>
                        <td class="tabl_comm">{{ $colonnes->nomCommandes }}</td>
                        <td class="tabl_comm">{{ $colonnes->quantiteDemande }}</td>
                        <td class="tabl_comm">{{ $colonnes->nomService }}</td>
                        <td class="tabl_comm">{{ date('G:i:s \l\e d-m-Y', strtotime($colonnes->created_at)) }}</td>
                    </tr>
                <?php } ?>
                </table>
            <?php }

            if (isset($Statistiques_demande[0])) {?>
          <table id="statistiques">
                    <caption>Statistiques</caption>
                    <tr>
                        <th class="tabl_comm">Nom</th>
                        <th class="tabl_comm">Quantitée demandée</th>
                        <th class="tabl_comm">Service</th>
                        <th class="tabl_comm">Création</th>
                    </tr>
                <?php foreach ($Statistiques_demande as $lignes => $colonnes) { ?>
                    <tr>
                        <td class="tabl_comm">{{ $colonnes->nomCommandes }}</td>
                        <td class="tabl_comm">{{ $colonnes->quantiteDemande }}</td>
                        <td class="tabl_comm">{{ $colonnes->nomService }}</td>
                        <td class="tabl_comm">{{ date('G:i:s \l\e d-m-Y', strtotime($colonnes->created_at)) }}</td>
                    </tr>
                <?php } ?>
                </table>
              <?php }

            }
            else {
              echo "Aucun résultat n'a été trouvé";
            }
            ?>
         <?php } else {
                  $errorsdate = $erreurdate ?? false;
                  if ($errorsdate) { ?>
                    <p class="erreur"><img class="img_erreur" src="http://localhost/PPE-3/Application/storage/app/public/warning.png" alt="Icon de confirmation" /> La date selectionner n'est pas valide !</p><br />
                    <?php header('Refresh: 5; url=statistique');
                  }
                ?>
                                        <!--*****************************************PARTIE PHP*****************************************-->

                  <h1> Table de statistique</h1>

                   <!-- Selection des fournitures -->
                   {!! Form::open(['url' => 'stats_produit']) !!}
                   <fieldset id="a"><h3>Selectionner un produit</h3>
                     <select name="nom_produits">
                       <?php
                         foreach ($Fournitures as $key => $value)
                          {
                         echo '<option value="'.$value->nomFournitures.'">'.$value->nomFournitures.'</option>';
                       } ?>
                     </select>
                   </fieldset>

                   <fieldset id="b"><h3>Date début</h3>
                     <input type ="date" id="date1" name="date1" />
                   </fieldset>

                   <fieldset id="c"><h3>Date fin</h3>
                     <input type ="date" id="date2" name="date2" />
                   </fieldset>

                   <input type="submit" id="resultat" name="resultat" value="Voir le résultat">
                  </form>
                  <!---
                  <! Selection des services -->
                  {!! Form::open(['url' => 'stats_produit']) !!}
                  <fieldset id="a"><h3>Selectionner un service</h3>
                    <select name="nom_service">
                      <?php
                        foreach ($Services as $key => $valeur)
                        {
                        echo '<option value="'.$valeur->nomService.'">'.$valeur->nomService.'</option>';
                      } ?>
                    </select>
                  </fieldset>

                  <fieldset id="b"><h3>Date début</h3>
                    <input type ="date" id="date1" name="date1" />
                  </fieldset>

                  <fieldset id="c"><h3>Date fin</h3>
                    <input type ="date" id="date2" name="date2" />
                  </fieldset>

                  <input type="submit" id="resultat2" name="resultat" value="Voir le résultat">
                  </form>
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
