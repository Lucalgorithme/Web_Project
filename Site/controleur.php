<?php
session_start();

	include_once "libs/maLibUtils.php";	
	include_once "libs/modele.php"; 
	include_once "libs/maLibSecurisation.php"; 
	// cf. injection de dépendances 


	$qs = "";
	$dataQS = array(); 

	
	// voir les entetes HTTP venant du client : 
	// tprint($_SERVER);
	// die("");

	if ($action = valider("action"))
	{
		ob_start ();
		echo "Action = '$action' <br />";
		// ATTENTION : le codage des caractères peut poser PB si on utilise des actions comportant des accents... 
		// A EVITER si on ne maitrise pas ce type de problématiques

		// Un paramètre action a été soumis, on fait le boulot...
		switch($action)
		{
			
			// Connexion //////////////////////////////////////////////////
			case 'Connexion' :
				// On verifie la presence des champs login et passe
				if ($login = valider("login"))
				if ($passe = valider("passe"))
				{
					// On verifie l'utilisateur, 
					// et on crée des variables de session si tout est OK
					// Cf. maLibSecurisation
					if (verifUser($login,$passe)) {
						// tout s'est bien passé, doit-on se souvenir de la personne ? 
						if (valider("remember")) {
							setcookie("login",$login , time()+60*60*24*30);
							setcookie("passe",$passe, time()+60*60*24*30);
							setcookie("remember",true, time()+60*60*24*30);
						} else {
							setcookie("login","", time()-3600);
							setcookie("passe","", time()-3600);
							setcookie("remember",false, time()-3600);
						}
				    // On redirigera vers la page index automatiquement, avec la vue d'accueil
				    $qs = array("view" => "accueil",
				                "msg" => "Connexion réussie ! Bienvenue $login !");
					} else {
				    $qs = array("view" => "login",
				                "msg" => "Erreur de connexion, veuillez réessayer");
					}
				}
			break;

			case 'CreationCompte' :
				
				if ($pseudo = valider("login"))
				if ($passe = valider("passe"))
				if (verifUserDejaUtilise($pseudo)){
					creationCompte($pseudo , $passe);
					$qs = array("view" => "login", "msg" => "Votre compte a bien été créé !");
				}
				else{
					$qs = array("view" => "login", "msg" => "Erreur, ce nom est déjà utlisé !");
				}

			break;

			case 'SupprimerCompte' :
				if ($idUser = valider("idUser","SESSION"))
				if (valider("connecte","SESSION")){
					supprimerUtilisateur($idUser);
					$qs = array("view" => "accueil", "msg" => "Utilisateur $pseudo(id = $idUser) supprimé !");
					session_destroy();
				}
			break;


			case 'SuppressionCompRecherche' :
				if ($idUser = valider("idUser","SESSION"))
				if ($idComp = valider("idComp"))
				if (valider("connecte","SESSION")){
					supprimerCompRecherche($idUser, $idComp);
					$qs = array("view" => "account", "idUser" => $idUser ,"msg" => "Compétence recherchée supprimée !");
				}
			break;


			case 'SuppressionCompAcquise' :
				if ($idUser = valider("idUser","SESSION"))
				if ($idComp = valider("idComp"))
				if (valider("connecte","SESSION")){
					supprimerCompAcquise($idUser, $idComp);
					$qs = array("view" => "account", "idUser" => $idUser ,"msg" => "Compétence acquise + échange supprimés !");
				}
			break;


				// COMPÉTENCES

			case 'ModifierComp' :

				if ($idComp = valider("idComp"))
				if ($user = valider("idUser","SESSION"))
				if ($nom = valider("nom"))
				if ($desc = valider("desc"))
				if (valider("connecte","SESSION")){

					modifierComp($nom, $desc, $idComp);
					$qs = array("view" => "account", "idUser" => $user, "msg" => "Votre compétence a bien été modifié !");
				}

			break;



			case 'AjouterComp' :

				if ($user = valider("idUser","SESSION"))
				if ($nom = valider("nom"))
				if ($desc = valider("desc"))
				if (valider("connecte","SESSION")){

					ajouterComp($nom, $desc, $user);
					$qs = array("view" => "account", "idUser" => $user, "msg" => "Vous avez ajouter une compétence !");
				}

			break;



			case 'ModifierCompRecherche' :

				if ($idComp = valider("idComp"))
				if ($user = valider("idUser","SESSION"))
				if ($nom = valider("nom"))
				if ($desc = valider("desc"))
				if (valider("connecte","SESSION")){

					modifierCompRecherche($nom, $desc, $idComp);
					$qs = array("view" => "account", "idUser" => $user, "msg" => "Votre compétence recherchée a bien été modifié !");
				}

			break;



			case 'AjouterCompRecherche' :

				if ($user = valider("idUser","SESSION"))
				if ($nom = valider("nom"))
				if ($desc = valider("desc"))
				if (valider("connecte","SESSION")){

					ajouterCompRecherche($nom, $desc, $user);
					$qs = array("view" => "account", "idUser" => $user, "msg" => "Vous avez ajouter une compétence recherchée !");
				}

			break;

				// FIN COMPETENCE

			case 'ModifierUser' :

				
				if ($user = valider("idUser","SESSION"))
				if ($login = valider("login"))
				if ($passe = valider("passe"))
				if ($bio = valider("bio"))
				if (valider("connecte","SESSION"))
				if (verifUserDejaUtilise2($login, $user)){
					modifierUser($login, $passe, $bio, $user);					
					$qs = array("view" => "account", "idUser" => $user, "msg" => "Vos informations ont bien été modifié !");
				}
				else{
					$qs = array("view" => "account", "idUser" => $user, "msg" => "Ce nom est déjà utilisé !");
				}

			break;

			case 'EnvoyerImage':
				// Vérification de l'authentification de l'utilisateur
				if (!valider("connecte", "SESSION")) break;
				if (!$idUser = valider("idUser", "SESSION")) break;

				// Validation du fichier uploadé
				if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
					$qs = ["view" => "account", "msg" => "Erreur lors de l'envoi du fichier"];
					break;
				}

				// Définition des types d'images autorisés et validation
				$allowedTypes = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
				$fileType = $_FILES['image']['type'];
				
				if (!isset($allowedTypes[$fileType])) {
					$qs = ["view" => "account", "msg" => "Format non autorisé. Utilisez JPG/PNG uniquement"];
					break;
				}

				// Préparation du chemin et du nom du fichier
				$uploadDir = 'ressources/profil/';
				if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
				
				$extension = $allowedTypes[$fileType];
				$fileName = "profil_" . $idUser . "." . $extension;
				$filePath = $uploadDir . $fileName;

				// Gestion de la photo de profil existante
				$oldImage = SQLGetChamp("SELECT file_path FROM images WHERE user_id = $idUser");
				if ($oldImage && file_exists($oldImage)) {
					unlink($oldImage);
					SQLDelete("DELETE FROM images WHERE user_id = $idUser");
				}

				// Sauvegarde de la nouvelle image
				if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
					SQLInsert("INSERT INTO images (user_id, file_name, file_path) VALUES ($idUser, '$fileName', '$filePath')");
					$qs = ["view" => "account", "msg" => "Photo de profil mise à jour"];
				} else {
					$qs = ["view" => "account", "msg" => "Erreur lors de l'upload"];
				}
			break;


			case 'RechercheComp' :

				if ($texte = valider("mot"))
				if (valider("connecte","SESSION")){
					$qs = array("view" => "competences", "texte" => $texte);
				}

			break;


			case 'RechercheUser' :

				if ($texte = valider("mot"))
				if (valider("connecte","SESSION")){
					$qs = array("view" => "recherche_profil", "texte" => $texte);
				}

			break;



			case 'Echange' :

				if ($pseudo = valider("pseudo"))
				if ($idPseudo = valider("idPseudo"))
				if ($CA = valider("CA"))
				if ($DESC_CA = valider("DESC_CA"))
				if ($idComp = valider("idComp"))
				if (valider("connecte","SESSION")){

				$qs = array("view" => "creation_echange","pseudo"=>$pseudo,"idPseudo"=>$idPseudo,"CA"=>$CA,"DESC_CA"=>$DESC_CA,"idComp"=>$idComp);

				}
			break;


			case 'Profil' :

				if ($idUser = valider("idUser"))
				if (valider("connecte","SESSION")){

				$qs = array("view" => "profil" , "idUser" => $idUser);

				}
			break;



			case 'DemarreEchange' :
				$token = 25;
				if (valider("connecte","SESSION"))
				if ($choix = valider("choix")){

					switch($choix)
					{

						case '1' :

						if ($idComp1 = valider("idComp1"))
						if ($idUser1 = valider("idUser1"))
						if ($idComp2 = valider("comp"))
						if ($idUser2 = valider("idUser","SESSION")){

							creerEchange($idUser1, $idComp1, $idUser2, $idComp2);

							$qs = array("view" => "echanges", "msg" => "L'échange a été créé !");
						}
						else{
							$qs = array("view" => "echanges", "msg" => "Erreur valeur !");

						}

						
						break;

						case '2' :

							if ($idComp1 = valider("idComp1"))
							if ($idUser1 = valider("idUser1"))
							if ($idUser2 = valider("idUser","SESSION")){

								creerEchangeToken($idUser1, $idUser2, $idComp1, $token);
								
								$qs = array("view" => "echanges", "msg" => "L'échange a été créé ! (token)");

							}

						break;
							
						default :

							$qs = array("view" => "competences", "msg" => "Erreur inattendue !");

						break;

					
					}
					
				}
				else{
					$qs = array("view" => "competences", "msg" => "Erreur inattendue ! (aucun radio)");
				}


			break;


			case 'PosterMessage' : 
				if ($idEchange = valider("idEchange")) 
				if ($contenu = valider("contenu"))
				if (valider("connecte","SESSION")) {
					// CENSURER ICI avant d'enregistrer
					$contenu = censurerMessage($contenu);
					enregistrerMessage($idEchange, $_SESSION["idUser"], $contenu);
					$qs = array("view" => "conversations", "idEchange" => $idEchange);
				}
			break;

			case 'PosterMessageToken' : 
				if ($idEchange = valider("idEchangeToken")) 
				if ($contenu = valider("contenu"))
				if (valider("connecte","SESSION")) {
					// CENSURER ICI aussi
					$contenu = censurerMessage($contenu);
					enregistrerMessageToken($idEchange, $_SESSION["idUser"], $contenu);
					$qs = array("view" => "conversations", "idEchangeToken" => $idEchange);
				}
			break;
			
			// ADMINISTRATION //////////////////////////////////////////////////

			//Users

			case 'adminuser' :
				if (isAdmin(valider("connecte","SESSION")))
				if ($mot = valider("mot"))
				if (valider("connecte","SESSION")){
					$qs = array("view" => "admin", "mot" => $mot);
				}
			break;

			case 'adminafficheruser' :
				if (isAdmin(valider("connecte","SESSION")))
				if (valider("connecte","SESSION")){
					$qs = array("view" => "admin");
				}
			break;

			case 'SupprimerUser' :
				if (isAdmin(valider("connecte","SESSION")))
				if ($idUser = valider("idUser"))
				if ($pseudo = valider("pseudo"))
				if (valider("connecte","SESSION")){
					supprimerUtilisateur($idUser);
					$qs = array("view" => "admin", "msg" => "Utilisateur $pseudo(id = $idUser) supprimé !");
				}
			break;

			//Echanges

			case 'adminechanges' :
				if (isAdmin(valider("connecte","SESSION")))
				if ($mot = valider("a"))
				if (valider("connecte","SESSION")){
					$qs = array("view" => "admin", "a" => $mot);
				}
			break;

			case 'adminafficherechanges' :
				if (isAdmin(valider("connecte","SESSION")))
				if (valider("connecte","SESSION")){
					$qs = array("view" => "admin");
				}
			break;

			case 'SupprimerEchange' :
				if (isAdmin(valider("connecte","SESSION")))
				if ($idEchange = valider("idEchange"))
				if (valider("connecte","SESSION")){
					supprimerEchange($idEchange);
					$qs = array("view" => "admin", "msg" => "Échange supprimé !");
				}
			break;

			case 'ajouterToken' :
				if ($user = valider("idautreuser"))
				if ($vote = valider("voter"))
				if ($idEchange = valider("idEchange"))
				if (valider("connecte","SESSION")){
					// On ajoute le token à l'utilisateur
					Ajoutertoken($user);
					if ($vote == "1") {
						afficherVoteUser1($idEchange);
					} else {
						afficherVoteUser2($idEchange);
					}
					$qs = array("view" => "echanges", "msg" => "Vote positif ajouté !");
				}
			break;

			case 'pasDeToken' :
				if ($vote = valider("voter"))
				if ($idEchange = valider("idEchange"))
				if (valider("connecte","SESSION")){
					if ($vote == "1") {
						afficherVoteUser1($idEchange);
					} else {
						afficherVoteUser2($idEchange);
					}
					$qs = array("view" => "echanges", "msg" => "vote négatif ajouté !");
				}
			break;

			//Echanges Token

			case 'adminechangestoken' :
				if (isAdmin(valider("connecte","SESSION")))
				if ($mot = valider("c"))
				if (valider("connecte","SESSION")){
					$qs = array("view" => "admin", "c" => $mot);
				}
			break;

			case 'adminafficherechangestoken' :
				if (isAdmin(valider("connecte","SESSION")))
				if (valider("connecte","SESSION")){
					$qs = array("view" => "admin");
				}
			break;

			case 'SupprimerEchangeToken' :
				if (isAdmin(valider("connecte","SESSION")))
				if ($idEchange = valider("idEchangeToken"))
				if (valider("connecte","SESSION")){
					supprimerEchangeToken($idEchange);
					$qs = array("view" => "admin", "msg" => "Échange token supprimé !");
				}
			break;


			case 'Valider' :
				if ($idEchange = valider("idEchange"))
				if (valider("connecte","SESSION")){
					validerEchange($idEchange);
					$qs = array("view" => "conversations", "idEchange" => $idEchange, "msg" => "L'échange a débuté !");
				}
			break;

			case 'ValiderToken' :
				if ($idEchange = valider("idEchangeToken"))
				if ($idUser2 = valider("idUser2"))
				if (valider("connecte","SESSION")){
					validerEchangeToken($idEchange);
					retirerToken($idUser2);
					$qs = array("view" => "conversations", "idEchangeToken" => $idEchange, "msg" => "L'échange a débuté !");
				}
			break;


			case 'Refuser' :
				if ($idEchange = valider("idEchange"))
				if (valider("connecte","SESSION")){
					supprimerEchange($idEchange);
					$qs = array("view" => "echanges", "msg" => "L'échange a été refusé !");
				}
			break;


			case 'RefuserToken' :
				if ($idEchange = valider("idEchangeToken"))
				if (valider("connecte","SESSION")){
					supprimerEchangeToken($idEchange);
					$qs = array("view" => "echanges", "msg" => "L'échange Token a été refusé !");
				}
			break;

			case 'ajouterToken2' :
				if ($user = valider("idautreuser"))
				if ($vote = valider("voter"))
				if ($idEchange = valider("idEchangeToken"))
				if (valider("connecte","SESSION")){
					// On ajoute le token à l'utilisateur
					Ajoutertoken($user);
					if ($vote == "1") {
						afficherVoteUser1Token($idEchange);
					} else {
						afficherVoteUser2Token($idEchange);
					}
					$qs = array("view" => "echanges", "msg" => "Vote positif ajouté !");
				}
			break;

			case 'pasDeToken2' :
				if ($vote = valider("voter"))
				if ($idEchange = valider("idEchangeToken"))
				if (valider("connecte","SESSION")){
					if ($vote == "1") {
						afficherVoteUser1Token($idEchange);
					} else {
						afficherVoteUser2Token($idEchange);
					}
					$qs = array("view" => "echanges", "msg" => "vote négatif ajouté !");
				}
			break;

			// Compétences

			case 'adminecompetences' :
				if (isAdmin(valider("connecte","SESSION")))
				if ($mot = valider("b"))
				if (valider("connecte","SESSION")){
					$qs = array("view" => "admin", "b" => $mot);
				}
			break;

			case 'adminaffichercompetences' :
				if (isAdmin(valider("connecte","SESSION")))
				if (valider("connecte","SESSION")){
					$qs = array("view" => "admin");
				}
			break;

			case 'SupprimerComp' :
				if (isAdmin(valider("connecte","SESSION")))
				if ($idComp = valider("id"))
				if ($type = valider("type"))
				if ($idUser = valider("idutilisateur"))
				if (valider("connecte","SESSION")){
					supprimerComp($idUser,$idComp, $type);
					$qs = array("view" => "admin", "msg" => "Compétence supprimée !");
				}
			break;

			// Tokens

			case 'admintoken' :
				if (isAdmin(valider("connecte","SESSION")))
				if ($mot = valider("e"))
				if (valider("connecte","SESSION")){
					$qs = array("view" => "admin", "e" => $mot);
				}
			break;

			case 'adminaffichertoken' :
				if (isAdmin(valider("connecte","SESSION")))
				if (valider("connecte","SESSION")){
					$qs = array("view" => "admin");
				}
			break;

			case 'ModifierToken' :
				if (isAdmin(valider("connecte","SESSION")))
				if ($idUser = valider("idUser"))
				if ($token = valider("token"))
				if (valider("connecte","SESSION")){
					modifierToken($idUser, $token);
					$qs = array("view" => "admin", "msg" => "Tokens modifiés !");
				}
			break;

			// FIN ADMINISTRATION //////////////////////////////////////////////////

			case 'Inactif' :
				if ($idEchange = valider("idEchange"))
				if (valider("connecte","SESSION")){
					// On rend l'échange inactif
					rendreEchangeInactif($idEchange);
					$qs = array("view" => "conversations", "idEchange" => $idEchange, "msg" => "L'échange a été rendu inactif !");
				}
			break;

			case 'InactifToken' :
				if ($idEchange = valider("idEchangeToken"))
				if ($user1 = valider("idUser1"))
				if ($user2 = valider("idUser2"))
				if (valider("connecte","SESSION")){
					// On rend l'échange token inactif
					rendreEchangeTokenInactif($idEchange);
					donnerToken($user1);
					$qs = array("view" => "conversations", "idEchangeToken" => $idEchange, "msg" => "L'échange token a été rendu inactif !");
				}
			break;

			case 'Logout' :
			case 'logout' :
				session_destroy();
				$qs = array("view" => "login",
				            "msg" => "Déconnexion réussie");
			break;
			
		}
	}

	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
	// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
	// On redirige vers la page index avec les bons arguments
	
	if ($qs == "") {
		// On renvoie vers la page précédente en se servant de HTTP_REFERER
		// attention : il peut y avoir des champs en + de view...
		$qs = parse_url($_SERVER["HTTP_REFERER"]. "&cle=val", PHP_URL_QUERY);
		$tabQS = explode('&', $qs);
		array_map('parseDataQS', $tabQS);
		$qs = "?view=" . $dataQS["view"];
	}

	rediriger($urlBase, $qs);

	// On écrit seulement après cette entête
	ob_end_flush();

	function parseDataQS($qs) {
		global $dataQS; 
		$t = explode('=',$qs);
		$dataQS[$t[0]]=$t[1]; 
	}
	
?>
