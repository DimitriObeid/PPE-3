<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" sizes="144x144" href="http://localhost/PPE-3/Application/storage/app/public/CCI.png" />
        <link rel="stylesheet" href="http://localhost/PPE-3/Application/resources/css/fournitures.css" />
        <title>Fournitures</title>
    </head>
    <body>
        <nav>
            <ul>
                <li id="li_logo"><img id="logo" src="http://localhost/PPE-3/Application/storage/app/public/logo-cci-alsace.png" alt="Logo de la CCI d'alsace" /></li>
                <li><a class="menu" href="accueil">ACCUEIL</a></li>
                <li><a class="menu" href="">DÉPARTEMENTS</a></li>
                <li><a class="menu" href="fournitures">FOURNITURES</a></li>
                <?php if ($_SESSION['categorie'] == 'Administrateur') { ?>
                    <li><a class="menu" href="">MÉSSAGERIE</a></li>
                    <li><a class="menu" href="">STATISTIQUE</a></li>
                <?php } ?>
                <li><a class="menu" href="demandesspecifiques">DEMANDE SPÉCIFIQUE</a></li>
                <li><a class="menu" href="">SUIVI</a></li>
                <?php if ($_SESSION['categorie'] != 'Administrateur') { ?>
                    <li><a class="menu" id="personnalisation" href="">PERSONNALISATION DU COMPTE</a></li>
                <?php } ?>
            </ul>
        </nav>
        <header>
            <h1>Fournitures</h1>
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
        <section id="corps">
            <?php if (isset($reponse)) { ?>
                    <a href="fournitures" id="retour">< Retour à la liste des fournitures</a><br /><br />
                    <?php if ($reponse) { ?>
                        <table id="resultat_recherche">
                            <caption>Résultat de la recherche :</caption>
                            <tr>
                                <th>Photo</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Quantitée disponible</th>
                            <?php if ($_SESSION['categorie'] != 'Administrateur') { ?>
                                <th>Quantitée demandée</th>
                            <?php } ?>
                            </tr>
                        <?php for ($i=0; $i < $_SESSION['recherche']->count(); $i++) { ?>
                            <tr>
                                <td><img class="photo_fournitures" src="http://localhost/PPE-3/Application/storage/app/public/{{ $_SESSION['recherche'][$i]->nomPhoto }}.jpg" /></td>
                                <td>{{ $_SESSION['recherche'][$i]->nomFournitures }}</td>
                                <td>{{ $_SESSION['recherche'][$i]->descriptionFournitures }}</td>
                                <td>
                                <?php if ($_SESSION['categorie'] == 'Administrateur') { ?>
                                    {!! Form::open(['url' => 'majquantite']) !!}
                                    {{ Form::hidden('id', $_SESSION['recherche'][$i]->id) }}
                                    {{ Form::number('quantite_disponible', $_SESSION['recherche'][$i]->quantiteDisponible, ['min'=>'0', 'max'=>'100']) }}
                                    {{ Form::submit('Mettre à jour') }}
                                    {!! Form::close() !!}
                                <?php } else { ?>
                                    {{ $_SESSION['recherche'][$i]->quantiteDisponible }}
                                <?php } ?>
                                </td>
                            <?php if ($_SESSION['categorie'] != 'Administrateur') { ?>
                                <td>
                                    {!! Form::open(['url' => 'commander']) !!}
                                    {{ Form::hidden('id', $_SESSION['recherche'][$i]->id) }}
                                    {{ Form::number('quantite_disponible', '1', ['min'=>'1', 'max'=>$_SESSION['recherche'][$i]->quantiteDisponible]) }}
                                    {{ Form::submit('Commander') }}
                                    {!! Form::close() !!}
                                </td>
                            <?php } ?>
                            </tr>
                        <?php } ?>
                        </table>
                    <?php } else { ?>
                        <p>Aucun résultat trouvé pour votre recherche.</p>
                    <?php }
                } else {
                    $valide = $valider ?? false;
                    if ($valide) { ?>
                        <p class="confirm"><img class="img_confirm" src="http://localhost/PPE-3/Application/storage/app/public/confirm.png" alt="Icon de confirmation" /> La mise à jour à bien été prise en compte</p><br />
                        <?php header('Refresh: 5; url=fournitures');
                    }

                    $fichiertropgros = $tropgros ?? false;
                    if ($fichiertropgros) { ?>
                        <p class="erreur"><img class="img_erreur" src="http://localhost/PPE-3/Application/storage/app/public/warning.png" alt="Icon de confirmation" /> Le poids de la photo est trop volumineux ! (Max : 500Mo)</p><br />
                        <?php header('Refresh: 5; url=fournitures');
                    }

                    $formatinvalide = $invalide ?? false;
                    if ($formatinvalide) { ?>
                        <p class="erreur"><img class="img_erreur" src="http://localhost/PPE-3/Application/storage/app/public/warning.png" alt="Icon de confirmation" /> Le format de la photo n'est pas valide !</p><br />
                        <?php header('Refresh: 5; url=fournitures');
                    }

                    $creation = $cree ?? false;
                    if ($creation) { ?>
                        <p class="confirm"><img class="img_confirm" src="http://localhost/PPE-3/Application/storage/app/public/confirm.png" alt="Icon de confirmation" /> L'article a bien été créé</p><br />
                        <?php header('Refresh: 5; url=fournitures');
                    }

                    if ($_SESSION['categorie'] == 'Administrateur') { ?>
                        <table id="ajout_fourniture">
                            <caption>Ajouter une fourniture</caption>
                            <tr>
                                <th>Photo</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Quantitée disponible</th>
                            </tr>
                            <tr>
                                <td>
                                    {!! Form::open(['url' => 'creationfourniture', 'files' => true]) !!}
                                    {{ Form::file('photo_fournitures', ['required'=>'true']) }}
                                </td>
                                <td>{{ Form::text('nom_fourniture', $value = null, ['maxlength'=>'50', 'placeholder'=>'Ex: Ciseau Maped', 'required'=>'true']) }}</td>
                                <td>{{ Form::text('description_fourniture', $value = null, ['maxlength'=>'50', 'required'=>'true']) }}</td>
                                <td>
                                    {{ Form::number('quantite_disponible', '1', ['min'=>'1', 'max'=>'100']) }}
                                    {{ Form::submit('Créer l\'article') }}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        </table>
                    <?php } ?>

                    <table id="liste_fourniture">
                        <caption>Liste des fournitures :</caption>
                        <tr>
                            <th>Photo</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Quantitée disponible</th>
                        <?php if ($_SESSION['categorie'] != 'Administrateur') { ?>
                            <th>Quantitée demandée</th>
                        <?php } ?>
                        </tr>
                    <?php for ($j=0; $j < $_SESSION['fournitures']->count(); $j++) { ?>
                        <tr>
                            <td><img class="photo_fournitures" src="http://localhost/PPE-3/Application/storage/app/public/{{ $_SESSION['fournitures'][$j]->nomPhoto }}.jpg" /></td>
                            <td>{{ $_SESSION['fournitures'][$j]->nomFournitures }}</td>
                            <td>{{ $_SESSION['fournitures'][$j]->descriptionFournitures }}</td>
                            <td>
                            <?php if ($_SESSION['categorie'] == 'Administrateur') { ?>
                                {!! Form::open(['url' => 'majquantite']) !!}
                                {{ Form::hidden('id', $_SESSION['fournitures'][$j]->id) }}
                                {{ Form::number('quantite_disponible', $_SESSION['fournitures'][$j]->quantiteDisponible, ['min'=>'0', 'max'=>'100']) }}
                                {{ Form::submit('Mettre à jour') }}
                                {!! Form::close() !!}
                            <?php } else { ?>
                                {{ $_SESSION['fournitures'][$j]->quantiteDisponible }}
                            <?php } ?>
                            </td>
                        <?php if ($_SESSION['categorie'] != 'Administrateur') { ?>
                            <td>
                                {!! Form::open(['url' => 'commander']) !!}
                                {{ Form::hidden('id', $_SESSION['fournitures'][$j]->id) }}
                                {{ Form::number('quantite_disponible', '1', ['min'=>'1', 'max'=>$_SESSION['fournitures'][$j]->quantiteDisponible]) }}
                                {{ Form::submit('Commander') }}
                                {!! Form::close() !!}
                            </td>
                        <?php } ?>
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
