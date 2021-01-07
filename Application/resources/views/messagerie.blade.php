<?php
/*
$nb = 0;
if (isset($_GET["s"]) AND $_GET["s"] == "Rechercher")
{
 $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les failles html
 $terme = $_GET["terme"];
 $terme = trim($terme); //supprimer des caractères au début et en fin d’une chaîne de caractère.
 $terme = strip_tags($terme);//Supprime les balises HTML et PHP d'une chaîne ...

}

if (isset($terme) AND $terme != "")
{
 $terme = "%".strtolower($terme)."%"; //convertir tous les caractères alphabétiques en minuscules.
 $select_terme = $BDD->prepare("SELECT * FROM personnel WHERE nom LIKE :nom OR prenom LIKE :prenom");
 $select_terme->execute(array("nom" => $terme, "prenom" => $terme));
 while($terme_trouve = $select_terme->fetch())
 {
   $mail_result = $terme_trouve['email'];
   $nb++;

 }
 $select_terme->closeCursor();
}

// traitement du formulaire
$destinataire = 'sicmu608@gmail.com';
$copie = 'oui';
$form_action = '';
$message_envoye = "Votre message a bien été envoyé";
$message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";

function Enregistrer($text)
{
	$text = htmlspecialchars(trim($text), ENT_QUOTES);

	{
		$text = stripslashes($text);
	}

	$text = nl2br($text);
	return $text;
};

function IsEmail($email)
{
	$value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
	return (($value === 0) || ($value === false)) ? false : true;
}

// recuperer les données du formulaire
$nom     = (isset($_GET['nom']))     ? Enregistrer($_GET['nom'])     : '';
$email   = (isset($_GET['email']))   ? Enregistrer($_GET['email'])   : '';
$objet   = (isset($_GET['objet']))   ? Enregistrer($_GET['objet'])   : '';
$message = (isset($_GET['message'])) ? Enregistrer($_GET['message']) : '';

// On va vérifier les variables et l'email ...
$email = (IsEmail($email)) ? $email : '';
$err_formulaire = false;

if (isset($_GET['envoi']))
{
	if (($nom != '') && ($email != '') && ($objet != '') && ($message != ''))
	{

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'From:'.$nom.' <'.$email.'>' . "\r\n" .
				'Reply-To:'.$email. "\r\n" .
				'Content-Type: text/plain; charset="utf-8"; DelSp="Yes"; format=flowed '."\r\n" .
				'Content-Disposition: inline'. "\r\n" .
				'Content-Transfer-Encoding: 7bit'." \r\n" .
				'X-Mailer:PHP/'.phpversion();
				$EmailTo = "sicmu608@gmail.com";
				$Subject = "Vous avez un nouveau message de " .$nom;

		// envoyer une copie au visiteur
		if ($copie == 'oui')
		{
			$cible = $destinataire.';'.$email;
		}
		else
		{
			$cible = $destinataire;
		};

		// Remplacement de certains caractères spéciaux
		$message = str_replace("&#039;","'",$message);
		$message = str_replace("&#8217;","'",$message);
		$message = str_replace("&quot;",'"',$message);
		$message = str_replace('<br>','',$message);
		$message = str_replace('<br />','',$message);
		$message = str_replace("&lt;","<",$message);
		$message = str_replace("&gt;",">",$message);
		$message = str_replace("&amp;","&",$message);

		// Envoi du mail
		$num_emails = 2;
		$tmp = explode(';', $cible);
		foreach($tmp as $email_destinataire)
		{
			if (mail($email_destinataire, $objet, $message, $headers))
				$num_emails++;
		}

		if ((($copie == 'oui') && ($num_emails == 2)) || (($copie == 'non') && ($num_emails == 1)))
		{
			$req = $BDD->prepare('INSERT INTO reception(nom, email, objet, message) VALUES(:nom, :email, :objet, :message)');
			$req->execute(array(
				'nom' => $nom,
				'email' => $email,
				'objet' => $objet,
				'message' => $message,
				));
			$req-> closeCursor();
			echo '<p id="msg">'.$message_envoye.'</p>';
      header("Refresh: 5; url=index.php");
		}
	}

};
*/
?>

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
            <?php if ($_SESSION['categorie'] == 'Administrateur') {//afficher un truc  ?>
            <?php } ?>
        </section>






        <body>
          <form method="get" action="messagerie" name="form"  onSubmit="return validation()" style=" margin-left: 200px; margin-right: 400px; ">
        <div id="coordonées">
          <fieldset><legend>Coordonées du destinataire</legend>
        		<p><label for="nom">Nom :</label><input type="text" id="nom" name="nom" /></p>
        		<p><label for="email">Email :</label><input type="text" id="email" name="email" /></p>
        	</fieldset>
        </div>

        <div id="message">
        	<fieldset><legend>Votre message :</legend>
        		<p><label for="objet">Objet :</label><input type="text" id="objet" name="objet" value="<?php echo $_GET['objet'] ?? '' ?>" /></p>
        		<p><label for="message">Message :</label><textarea id="message" name="message" cols="30" rows="8"><?php echo $_GET['message'] ?? '' ?></textarea></p>
        	</fieldset>
        </div>
        	<div style="text-align:center;"><button type="button" name="envoi"/>Envoyer</div>
        </form>
        <!--*** DANS LA BARRE DE RECHERCHE IL FAUT ETRE CAPABLE DE CHOISIR UN MAIL SEUL OU UN  DEPARTEMENT ***-->
        <?php
          /*$search = ($nb==1 ? ($mail_result ?? "") : "");*/
         ?>
           <div id="bdr"><label for="rechercher">Quel adresse mail recherchez vous : </label></br>
             <form action = "messagerie" method = "get"/>
                 <input type = "search" name = "terme" value="<?php /* echo $search; */ ?>"/>
                 <button type = "submit" name = "s" id="bouton_r"/>Rechercher</button>
                 <input type ="text" id="message_e" readonly value="<?php /* if ($nb>1) echo 'Veuillez affiner votre recherche' */ ?>"/>
             </form>
           </div>

        </body>












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
