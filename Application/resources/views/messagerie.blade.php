<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" sizes="144x144" href="http://localhost/PPE-3/Application/storage/app/public/CCI.png" />
        <link rel="stylesheet" href="http://localhost/PPE-3/Application/resources/css/messagerie.css" />
        <title>Méssagerie</title>
        <script type="text/javascript">
            function afficherMenu(menu) {
                menu.style.visibility = "visible";
            }

            function cacherMenu(menu) {
                menu.style.visibility = "hidden";
            }

            function validateEmail(email) {
              const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
              return re.test(String(email).toLowerCase());
          }


            function validation()
            {

              if (document.form.nom.value=="")
              {
                window.alert ("Entrez votre nom")
                return false;
              }
              if (!validateEmail(document.form.email.value))
              {
                window.alert ("Adresse mail non valide.");
                document.form.email.focus();
                return false;
              }
              if (document.form.objet.value=="")
              {
                window.alert ("Entrez l'objet de votre message")
                return false;
              }
              if (document.form.message.value=="")
              {
                window.alert ("Votre message est vide ou invalide")
                return false;
              }
              return true;
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
            <h1>Méssagerie</h1>
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
            <?php $confirmEnvoi = $envoi ?? false;
            if ($confirmEnvoi) { ?>
                <p class="confirm"><img class="img_confirm" src="http://localhost/PPE-3/Application/storage/app/public/confirm.png" alt="Icon de confirmation" /> <?php echo $message_envoye; ?></p><br />
            <?php header('Refresh: 5; url=messagerie');
            }

            $aucun_resultat = $aucun_result ?? false;
            if ($aucun_resultat) { ?>
                <p class="erreur"><img class="img_erreur" src="http://localhost/PPE-3/Application/storage/app/public/warning.png" alt="Icon de confirmation" /> Aucun résultat trouvé !</p><br />
                <?php header('Refresh: 5; url=messagerie');
            } ?>

              {!! Form::open(['url' => 'traitementmessagerie', 'name' => 'form', 'onSubmit' => 'return validation()']) !!}
                <div id="coordonées">
                    <fieldset>
                        <legend>Coordonées du destinataire</legend>
        		        <p><label class="label" for="nom">Nom :</label><input class="input" type="text" id="nom" name="nom" value="<?php echo $_GET['nom_prenom'] ?? '' ?>" /></p>
        		        <p><label class="label" for="email">Email :</label><input class="input" type="text" id="email" name="email" value="<?php echo $_GET['email'] ?? '' ?>" /></p>
                    </fieldset>
                </div>

                <div id="message">
                    <fieldset>
                       <legend>Votre message :</legend>
                       <?php if (isset($_GET['nomcommande'])) {
                           $objet = 'Votre commande : '.$_GET['nomcommande'];
                           $message = 'Je souhaite vous donnez des précisions sur votre commande '.$_GET['nomcommande'].', celle-ci est ...';
                       } elseif (isset($_GET['nomdemande'])) {
                           $objet = 'Votre demande : '.$_GET['nomdemande'];
                           $message = 'Je souhaite vous donnez des précisions sur votre demande '.$_GET['nomdemande'].', celle-ci est ...';
                       } ?>
                       <p><label class="label" for="objet">Objet :</label><input class="input" type="text" id="objet" name="objet" value="<?php echo $objet ?? '' ?>" /></p>
                       <p><label class="label" for="message">Message :</label><textarea id="message" name="message" cols="30" rows="8"><?php echo $message ?? '' ?></textarea></p>
                    </fieldset>
                </div>
        	    <div style="text-align:center;"><input type="submit" name="envoi" value="Envoyer"/></div>
            </form>
            <!--*** DANS LA BARRE DE RECHERCHE IL FAUT ETRE CAPABLE DE CHOISIR UN MAIL SEUL OU UN  DEPARTEMENT ***-->
            <?php $nb = $nb ?? 1;
            $search = ($nb==1 ? ($mail_result[0]->mail ?? "") : ""); ?>
            <div id="bdr"><label class="label" for="rechercher">Quel adresse mail recherchez vous : </label></br>
                  {!! Form::open(['url' => 'recherchemail']) !!}
                    <input class="input" type = "search" name = "terme" value="<?php echo $search; ?>"/>
                    <input type = "submit" name = "s" id="bouton_r" value="Rechercher"/>
                    <input type ="text" id="message_e" name="message_e" readonly value="<?php if ($nb>1) echo 'Veuillez affiner votre recherche'; ?>"/>
                </form>
            </div>
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
