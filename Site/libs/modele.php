<?php

/*
Partie modèle : on effectue ici tous les traitements sur la base de données (lecture, insertion, suppression, mise à jour).

Des fonctions sont déjà présentes : vous avez le droit de les modifier ou d'en ajouter à votre guise. Des indications sont données en commentaires.
*/

include_once("maLibSQL.pdo.php");

//*** Il est recommandé de ne pas modifier les fonctions suivantes, utilisées pour l'identification ***

function verifUserBdd($login,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès

	$SQL="SELECT id FROM utilisateurs WHERE pseudo='$login' AND passe='$passe';";

	return SQLGetChamp($SQL);
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}

function isAdmin($idUser)
{
	// Vérifie si l'utilisateur est un administrateur
	$SQL ="SELECT id FROM utilisateurs WHERE id='$idUser' AND role='admin';";
	return SQLGetChamp($SQL); 
}


//*** Fin des fonctions fournies avec le sujet ***

// TODO : D'autres fonctions peuvent être ajoutées à la suite


function creationCompte($pseudo , $passe){

	$SQL = "INSERT INTO utilisateurs(pseudo, passe) VALUES('$pseudo','$passe')";

	 SQLInsert($SQL);

}

function listerUtilisateurs($texte="") {

    if (!empty($texte)) {
        $texte = "%$texte%";
		$SQL = "SELECT pseudo, id, role, bio, token FROM utilisateurs WHERE pseudo LIKE '$texte' OR id LIKE '$texte'";
        return parcoursRs(SQLSelect($SQL));
    }
    else {
		$SQL = "SELECT pseudo, id, role, bio, token FROM utilisateurs";
        return parcoursRs(SQLSelect($SQL));
    }
}


function verifUserDejaUtilise($pseudo){

	$utilisateurs = listerUtilisateurs();

	foreach($utilisateurs as $users){
		if($pseudo == $users["pseudo"]){
			return 0;
		}
	}
	return 1;
}



function verifUserDejaUtilise2($pseudo, $idUser){

	$utilisateurs = listerUtilisateurs();

	foreach($utilisateurs as $users){
		if($pseudo == $users["pseudo"]){
			if($idUser == $users["id"]){
				return 1;
			}
			else{
				return 0;
			}
		}
	}
	return 1;

}


function infoUser($idUser){

	$SQL = "SELECT * FROM utilisateurs WHERE id = '$idUser'";

	return parcoursRs(SQLSelect($SQL))[0];  

}


function infoComp($idComp){

	$SQL = "SELECT * FROM competences_acquises WHERE idComp = '$idComp'";

	return parcoursRs(SQLSelect($SQL));  

}



function Comp($idUser){

	$SQL = "SELECT * FROM competences_acquises WHERE utilisateur = '$idUser'";

	return parcoursRs(SQLSelect($SQL));  

}

function CompRecherche($idUser){

	$SQL = "SELECT * FROM competences_recherche WHERE utilisateur = '$idUser'";

	return parcoursRs(SQLSelect($SQL));  

}


// COMPÉTENCES ACQUISES OU RECHERCHE : 

function infoUserSkill($idUser){

	$SQL = "SELECT * FROM utilisateurs u JOIN competences_acquises c ON u.id = c.utilisateur WHERE id = '$idUser'";

	return parcoursRs(SQLSelect($SQL));  

}


function infoUserSkillRecherche($idUser){

	$SQL = "SELECT * FROM utilisateurs u JOIN competences_recherche c ON u.id = c.utilisateur WHERE id = '$idUser'";

	return parcoursRs(SQLSelect($SQL));  

}


function modifierComp($nom, $desc, $idComp){

	$SQL = "UPDATE competences_acquises SET nom = '$nom', description = '$desc' WHERE idComp = '$idComp'";

	SQLUpdate($SQL);

}



function ajouterComp($nom, $desc, $user){

	$SQL = "INSERT INTO competences_acquises(nom, description, utilisateur) VALUES('$nom','$desc', '$user')";

	SQLInsert($SQL);  

}



function modifierCompRecherche($nom, $desc, $idComp){

	$SQL = "UPDATE competences_recherche SET nom = '$nom', description = '$desc' WHERE idCompRecherche = '$idComp'";

	SQLUpdate($SQL);

}



function ajouterCompRecherche($nom, $desc, $user){

	$SQL = "INSERT INTO competences_recherche(nom, description, utilisateur) VALUES('$nom','$desc', '$user')";

	SQLInsert($SQL);  

}


// FIN COMPÉTENCES



function modifierUser($login, $passe, $bio, $user){

	$SQL = "UPDATE utilisateurs SET pseudo = '$login', passe = '$passe', bio = '$bio' WHERE id = '$user'";

	SQLUpdate($SQL);

}

function getImagePath($userId) {
    $SQL = "SELECT file_path FROM images WHERE user_id = $userId";
    return SQLGetChamp($SQL); // Retourne directement la valeur du champ
}

// Supprime une image physique du serveur
function supprimerImagePhysique($userId) {
    $imagePath = "SELECT file_path FROM images WHERE user_id = $userId";
	SQLSelect($imagePath);
    if ($imagePath && file_exists($imagePath)) {
        return unlink($imagePath);
    }
    return false;
}

// Supprime l'entrée de la table images
function supprimerImageBDD($userId) {
    $SQL = "DELETE FROM images WHERE user_id = $userId";
    return SQLDelete($SQL);
}




// ÉCHANGES :


function infoEchange($idEchange){

	$SQL = "SELECT * FROM echanges WHERE idEchange = '$idEchange'";

	return parcoursRs(SQLSelect($SQL))[0];

}


function infoEchangeToken($idEchange){

	$SQL = "SELECT * FROM echanges_token WHERE idEchangeToken = '$idEchange'";

	return parcoursRs(SQLSelect($SQL))[0];

}


function listerEchanges($idUser, $actif, $valide){ // !!!!!!!!!!! ATTENTION NOUVELLE TABLE !!!!!!!!!!!

	$SQL = "SELECT * FROM echanges e WHERE (idUser1 = '$idUser' OR idUser2 = '$idUser') AND actif = '$actif' AND validationUser1 = $valide";

	return parcoursRs(SQLSelect($SQL));

}

function listerEchangesToken($idUser, $actif, $valide){ // !!!!!!!!!!! ATTENTION NOUVELLE TABLE !!!!!!!!!!!

	$SQL = "SELECT * FROM echanges_token e WHERE (idUser1 = '$idUser' OR idUser2 = '$idUser') AND actif = '$actif' AND validationUser1 = $valide";

	return parcoursRs(SQLSelect($SQL));

}



function creerEchange($id1, $idC1, $id2, $idC2){

	$SQL = "INSERT INTO echanges(idUser1, idComp1, idUser2, idComp2) VALUES('$id1', '$idC1', '$id2', '$idC2')";

	SQLInsert($SQL);  

}


function creerEchangeToken($id1, $id2, $idC1, $token){

	$SQL = "INSERT INTO echanges_token(idUser1, idUser2, idComp1, token) VALUES('$id1', '$id2', '$idC1', '$token')";

	SQLInsert($SQL);  

}


function listerMessages($idEchange)
{

	$SQL = "SELECT * FROM messages m JOIN utilisateurs u ON m.auteur = u.id WHERE idEchange = '$idEchange' ORDER BY m.idMessage";

	return parcoursRS(SQLSelect($SQL));
	
}


function listerMessagesToken($idEchange)
{

	$SQL = "SELECT * FROM messages_token m JOIN utilisateurs u ON m.auteur = u.id WHERE idEchangeToken = '$idEchange' ORDER BY m.idMessageToken";

	return parcoursRS(SQLSelect($SQL));
	
}



// FIN ÉCHANGES



// VUE COMPÉTENCES :


function listerCompetences($idUser, $texte=""){

	$SQL = "SELECT u.pseudo, u.id, ca.nom AS CA, ca.description AS DESC_CA, ca.idComp, cr.nom AS CR, cr.description AS DESC_CR FROM 
	competences_acquises ca JOIN utilisateurs u ON ca.utilisateur = u.id JOIN competences_recherche cr ON cr.utilisateur = u.id
	WHERE (ca.nom LIKE '%$texte%' OR ca.description LIKE '%$texte%') AND u.id != $idUser";

	return parcoursRs(SQLSelect($SQL));
}


// FIN VUE COMPÉTENCES

// VUE CONVERSATIONS


function enregistrerMessage($idEchange, $idAuteur, $contenu)
{
	$echange = infoEchange($idEchange);

	if($echange["actif"]){

	$SQL = "INSERT INTO messages(idEchange, auteur ,contenu) VALUES('$idEchange','$idAuteur','$contenu')";

	SQLInsert($SQL);  
	}
}


function enregistrerMessageToken($idEchange, $idAuteur, $contenu)
{
	$echange = infoEchangeToken($idEchange);

	if($echange["actif"]){

	$SQL = "INSERT INTO messages_token(idEchangeToken, auteur ,contenu) VALUES('$idEchange','$idAuteur','$contenu')";

	SQLInsert($SQL);  
	}
}

// FIN VUE CONVERSATIONS

// VUE ADMINISTRATION :
 // VUE ADMINISTRATION :
function supprimerUtilisateur($idUser){

    supprimermessages($idUser);
    supprimerEchanges($idUser);
    supprimermessage_token($idUser);
    supprimerEchanges_token($idUser);
    supprimerCompetencesAcquises($idUser);
    supprimerCompetencesRecherche($idUser);
 	supprimerImagePhysique($idUser);
    supprimerImageBDD($idUser);    
	
	$SQL = "DELETE FROM utilisateurs WHERE id = '$idUser'";
    SQLDelete($SQL);

}
function supprimermessages($idUser){

    $SQL = "SELECT * FROM echanges WHERE idUser1 = '$idUser' OR idUser2 = '$idUser'";
    $echange = SQLSelect($SQL);

    foreach($echange as $ech){
        $SQL = "DELETE FROM messages WHERE idEchange = '$ech[idEchange]'";

        SQLDelete($SQL);
    }

}

function supprimerimage($idUser){

    $SQL = "DELETE FROM images WHERE idUser = '$idUser'";

    SQLDelete($SQL);

}

function supprimerCompetencesAcquises($idUser){

    $SQL = "DELETE FROM competences_acquises WHERE utilisateur = '$idUser'";

    SQLDelete($SQL);

}

function supprimerCompetencesRecherche($idUser){

    $SQL = "DELETE FROM competences_recherche WHERE utilisateur = '$idUser'";

    SQLDelete($SQL);

}

function supprimerEchanges_token($idUser){

    $SQL = "DELETE FROM echanges_token WHERE idUser1 = '$idUser' OR idUser2 = '$idUser'";

    SQLDelete($SQL);

}

function supprimerEchanges($idUser){

    $SQL = "DELETE FROM echanges WHERE idUser1 = '$idUser' OR idUser2 = '$idUser'";

    SQLDelete($SQL);

}

function supprimermessage_token($idUser){

    $SQL = "SELECT * FROM echanges_token WHERE idUser1 = '$idUser' OR idUser2 = '$idUser'";
    $echange = SQLSelect($SQL);

    foreach($echange as $ech){
        $SQL = "DELETE FROM messages_token WHERE idEchangeToken = '$ech[idEchangeToken]'";

        SQLDelete($SQL);
    }

}

function listageEchanges($texte=""){

	if (!empty($texte)) {
		$texte = "%$texte%";
		$SQL = "SELECT e.*, u1.pseudo as pseudo1, u2.pseudo as pseudo2, 
		ca1.nom as comp1, ca2.nom as comp2
		FROM echanges e 
		JOIN utilisateurs u1 ON e.idUser1 = u1.id 
		JOIN utilisateurs u2 ON e.idUser2 = u2.id
		JOIN competences_acquises ca1 ON e.idComp1 = ca1.idComp
		JOIN competences_acquises ca2 ON e.idComp2 = ca2.idComp 
		WHERE e.idEchange LIKE '$texte' 
		OR u1.pseudo LIKE '$texte' 
		OR u2.pseudo LIKE '$texte'";
		return parcoursRs(SQLSelect($SQL));
	}
	else {
		$SQL = "SELECT e.*, u1.pseudo as pseudo1, u2.pseudo as pseudo2,
			ca1.nom as comp1, ca2.nom as comp2 
			FROM echanges e 
			JOIN utilisateurs u1 ON e.idUser1 = u1.id 
			JOIN utilisateurs u2 ON e.idUser2 = u2.id
			JOIN competences_acquises ca1 ON e.idComp1 = ca1.idComp
			JOIN competences_acquises ca2 ON e.idComp2 = ca2.idComp";
		return parcoursRs(SQLSelect($SQL));
	}

}

function supprimerEchange($idEchange){

	$SQL = "DELETE FROM messages WHERE idEchange = '$idEchange'";
	SQLDelete($SQL);
	$SQL = "DELETE FROM echanges WHERE idEchange = '$idEchange'";
	SQLDelete($SQL);

}

function listageCompetences($texte="") {
	if (!empty($texte)) {
		$texte = "%$texte%";
		$SQL = "(SELECT ca.idComp as id, ca.nom, ca.description, ca.utilisateur, u.pseudo, u.id as user_id, 'acquise' as type_competence 
				FROM competences_acquises ca 
				JOIN utilisateurs u ON ca.utilisateur = u.id 
				WHERE u.pseudo LIKE '$texte' OR ca.idComp LIKE '$texte')
				UNION
				(SELECT cr.idCompRecherche as id, cr.nom, cr.description, cr.utilisateur, u.pseudo, u.id as user_id, 'recherchée' as type_competence 
				FROM competences_recherche cr
				JOIN utilisateurs u ON cr.utilisateur = u.id 
				WHERE u.pseudo LIKE '$texte' OR cr.idCompRecherche LIKE '$texte')";
		return parcoursRs(SQLSelect($SQL));
	}
	else {
		$SQL = "(SELECT ca.idComp as id, ca.nom, ca.description, ca.utilisateur, u.pseudo, u.id as user_id, 'acquise' as type_competence 
				FROM competences_acquises ca 
				JOIN utilisateurs u ON ca.utilisateur = u.id)
				UNION
				(SELECT cr.idCompRecherche as id, cr.nom, cr.description, cr.utilisateur, u.pseudo, u.id as user_id, 'recherchée' as type_competence 
				FROM competences_recherche cr
				JOIN utilisateurs u ON cr.utilisateur = u.id)";
		return parcoursRs(SQLSelect($SQL));
	}
}

function supprimerComp($iduser,$idComp,$type){
	if ($type === 'acquise') {

		$SQL = "SELECT * FROM echanges WHERE idComp1 = '$idComp' OR idComp2 = '$idComp'";
    	$echange = SQLSelect($SQL);

    foreach($echange as $ech){
        $SQL = "DELETE FROM messages WHERE idEchange = '$ech[idEchange]'";

        SQLDelete($SQL);
    }

	$SQL = "SELECT * FROM echanges_token WHERE idComp1 = '$idComp'";
    	$echange = SQLSelect($SQL);

    foreach($echange as $ech){
        $SQL = "DELETE FROM messages_token WHERE idEchangeToken = '$ech[idEchangeToken]'";

        SQLDelete($SQL);
    }

		$SQL = "DELETE FROM echanges_token WHERE idComp1 = $idComp";
		SQLDelete($SQL);
		$SQL = "DELETE FROM echanges WHERE idComp1 = $idComp OR idComp2 = $idComp";
		SQLDelete($SQL);
		$SQL = "DELETE FROM competences_acquises WHERE idComp = $idComp";
		SQLDelete($SQL);


	} elseif ($type === 'recherchée') {
		$SQL = "DELETE FROM competences_recherche WHERE idCompRecherche = $idComp";
		SQLDelete($SQL);
	} 
}

function listageEchangestoken($texte=""){
	if (!empty($texte)) {
		$texte = "%$texte%";
		$SQL = "SELECT et.*, u1.pseudo as pseudo1, u2.pseudo as pseudo2, ca1.nom as comp1 
				FROM echanges_token et
				JOIN utilisateurs u1 ON et.idUser1 = u1.id 
				JOIN utilisateurs u2 ON et.idUser2 = u2.id
				JOIN competences_acquises ca1 ON et.idComp1 = ca1.idComp
				WHERE et.idEchangeToken LIKE '$texte' 
				OR u1.pseudo LIKE '$texte'
				OR u2.pseudo LIKE '$texte'";
		return parcoursRs(SQLSelect($SQL));
	}
	else {
		$SQL = "SELECT et.*, u1.pseudo as pseudo1, u2.pseudo as pseudo2, ca1.nom as comp1
				FROM echanges_token et 
				JOIN utilisateurs u1 ON et.idUser1 = u1.id
				JOIN utilisateurs u2 ON et.idUser2 = u2.id 
				JOIN competences_acquises ca1 ON et.idComp1 = ca1.idComp";
		return parcoursRs(SQLSelect($SQL));
	}
}

function supprimerEchangeToken($idEchange){

	$SQL = "DELETE FROM messages_token WHERE idEchangeToken = '$idEchange'";
	SQLDelete($SQL);
	$SQL = "DELETE FROM echanges_token WHERE idEchangeToken = '$idEchange'";
	SQLDelete($SQL);

}

function listertoken($texte="") {
	if (!empty($texte)) {
		$texte = "%$texte%";
		$SQL = "SELECT id, pseudo, token FROM utilisateurs WHERE pseudo LIKE '$texte' OR id LIKE '$texte'";
		return parcoursRs(SQLSelect($SQL));
	}
	else {
		$SQL = "SELECT id, pseudo, token FROM utilisateurs";
		return parcoursRs(SQLSelect($SQL));
	}
}

function modifierToken($idUser, $nbToken) {
	$SQL = "UPDATE utilisateurs SET token = '$nbToken' WHERE id = '$idUser'";
	SQLUpdate($SQL);
}
//FIN VUE ADMINISTRATION

// Sécurisation des entrées utilisateur pour éviter les injections XSS
function secure($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// Censure les mots interdits dans une chaîne de caractères
function censurerMessage($message) {
    // Liste noire étendue de mots interdits
    $motsInterdits = [
        // Insultes générales
        'connard', 'connards', 'connasse', 'connasses',
        'salaud', 'salauds', 'salope', 'salopes',
        'putain', 'pute', 'putes', 'bordel',
        'merde', 'merdes', 'chier', 'chiasse',
        'con', 'cons', 'conne', 'connes',
        'batard', 'batards', 'batarde', 'batarede',
        'fils de pute', 'fdp', 'enculé', 'enculés',
        'encule', 'encules', 'enfoiré', 'enfoirés',
        'enfoire', 'enfoires', 'crétin', 'crétins',
        'débile', 'débiles', 'imbécile', 'imbéciles',
        'idiot', 'idiots', 'idiote', 'idiotes',
        'abruti', 'abrutis', 'abrutie', 'abruties',
		'clochard', 'clochards', 'clocharde', 'clochardes',
        
        // Insultes sexuelles
        'bite', 'bites', 'queue', 'queues',
        'couilles', 'couille', 'testicules',
        'chatte', 'chattes', 'sexe', 'cul',
        'nichons', 'nichon', 'tétons', 'téton',
        'seins', 'sein', 'fesses', 'fesse',
        
        // Insultes racistes (attention sensible)
        'negro', 'negros', 'nègre', 'nègres',
        'bougnoule', 'bougnoules', 'bamboula',
        'raton', 'ratons', 'bicot', 'bicots',
        'youpin', 'youpins', 'feuj', 'feujs',
		
        
        // Insultes homophobes
        'pédé', 'pédés', 'pede', 'pedes',
        'tapette', 'tapettes', 'tantouze', 'tantouzes',
        'gouine', 'gouines', 'lesbienne', 'lesbiennes',
		
        
        // Insultes religieuses
        'putain de dieu', 'bordel de dieu',
        
        // Variantes avec caractères spéciaux/chiffres
        'c0nn4rd', 'c0nnard', 'conn4rd',
        'm3rd3', 'm3rde', 'merd3',
        'put41n', 'put4in', 'puta1n',
        's4l4ud', 's4laud', 'sal4ud',
        'enc0lé', 'enc0le', 'encul3',
        'enf01ré', 'enf0ire', 'enfoir3',
        
        // Insultes en verlan
        'tepu', 'tepus', 'tebé', 'tebes',
        'renoi', 'renois', 'rebeu', 'rebeus',
        
        // Autres insultes courantes
        'salopard', 'salopards', 'fumier', 'fumiers',
        'ordure', 'ordures', 'pourriture', 'pourritures',
        'raclure', 'raclures', 'vermine', 'vermines',
        'charogne', 'charognes', 'crevard', 'crevards',
        'micheton', 'michetons', 'gigolo', 'gigolos',
        
        // Insultes familiales
	    'ta race',
        
        // Menaces et violence
        'je vais te tuer', 'crever', 'mort',
        'suicide', 'suicider', 'buter', 'flinguer',
        'tabasser', 'massacrer', 'égorger',
        
        // Insultes diverses
        'pauvre type', 'pauvre con', 'minable', 'minables',
        'merdeux', 'merdeuse', 'pourri', 'pourris',
        'dégueulasse', 'dégueu', 'immonde', 'immondes',
        'répugnant', 'répugnants', 'répugnante', 'répugnantes',
        
        // Abréviations internet
        'ntm', 'vtff', 'tmtc', 'ptn', 'mdr',] ;
    
    // Conversion en minuscules pour la comparaison
    $messageLower = strtolower($message);
    $messageOriginal = $message;
    
    foreach ($motsInterdits as $mot) {
        $motLower = strtolower($mot);
        
        // Créer des étoiles de la même longueur que le mot
        $etoiles = str_repeat('*', mb_strlen($mot, 'UTF-8'));
        
        // Remplacement insensible à la casse mais préservant la casse originale
        $pattern = '/\b' . preg_quote($motLower, '/') . '\b/ui';
        $messageOriginal = preg_replace_callback($pattern, function($matches) use ($etoiles) {
            return $etoiles;
        }, $messageOriginal);
    }
    
    return $messageOriginal;
}



function supprimerCompRecherche($idUser, $idCompRecherche){

	$SQL = "DELETE FROM competences_recherche WHERE utilisateur = $idUser AND idCompRecherche = $idCompRecherche";

	return SQLDelete($SQL);
}

function supprimerCompAcquise($idUser, $idComp){

	$SQL = "SELECT * FROM echanges WHERE (idUser1 = '$idUser' OR idUser2 = '$idUser') AND (idComp1 = '$idComp' OR idComp2 = '$idComp') ";
    $echange = SQLSelect($SQL);

    foreach($echange as $ech){
        $SQL = "DELETE FROM messages WHERE idEchange = $ech[idEchange]";
        SQLDelete($SQL);

		$SQL = "DELETE FROM echanges WHERE idEchange = $ech[idEchange]";
    	SQLDelete($SQL);
    }

	$SQL = "SELECT * FROM echanges_token WHERE (idUser1 = '$idUser' OR idUser2 = '$idUser') AND (idComp1 = '$idComp') ";
    $echange = SQLSelect($SQL);

    foreach($echange as $ech){
        $SQL = "DELETE FROM messages_token WHERE  idEchangeToken = $ech[idEchangeToken]";
        SQLDelete($SQL);

		$SQL = "DELETE FROM echanges_token WHERE idEchangeToken = $ech[idEchangeToken]";
    	SQLDelete($SQL);
    }

	$SQL = "DELETE FROM competences_acquises WHERE utilisateur = '$idUser' AND idComp = '$idComp'";
	SQLDelete($SQL);
}


function validerEchange($idEchange){

	$SQL = "UPDATE echanges SET validationUser1 = '1', actif = '1' WHERE idEchange = '$idEchange'";

	SQLUpdate($SQL);
}

function validerEchangeToken($idEchangeToken){

	$SQL = "UPDATE echanges_token SET validationUser1 = '1', actif = '1' WHERE idEchangeToken = '$idEchangeToken'";

	SQLUpdate($SQL);
}

function ajouterToken($idUser) {
	$SQL = "UPDATE utilisateurs SET token = token + 25 WHERE id = $idUser";
	return SQLUpdate($SQL);
}

function rendreEchangeInactif($idEchange){
	$SQL = "UPDATE echanges SET actif = '0' WHERE idEchange = '$idEchange'";
	SQLUpdate($SQL);
}

function affichervoteuser1($idEchange) {
	$SQL = "UPDATE echanges SET voteuser1 = '1' WHERE idEchange = '$idEchange'";
	SQLUpdate($SQL);
}

function affichervoteuser2($idEchange) {
	$SQL = "UPDATE echanges SET voteuser2 = '1' WHERE idEchange = '$idEchange'";  
	SQLUpdate($SQL);
}

function rendreEchangeTokenInactif($idEchange){
	$SQL = "UPDATE echanges_token SET actif = '0' WHERE idEchangeToken = '$idEchange'";
	SQLUpdate($SQL);
}

function afficherVoteUser1Token($idEchange) {
	$SQL = "UPDATE echanges_token SET voteuser1 = '1' WHERE idEchangeToken = '$idEchange'";
	SQLUpdate($SQL);
}

function afficherVoteUser2Token($idEchange) {
	$SQL = "UPDATE echanges_token SET voteuser2 = '1' WHERE idEchangeToken = '$idEchange'";
	SQLUpdate($SQL);
}

function donnerToken($idUser) {
	$SQL = "UPDATE utilisateurs SET token = token + 25 WHERE id = '$idUser'";
	return SQLUpdate($SQL);
}

function retirerToken($idUser) {
	$SQL = "UPDATE utilisateurs SET token = token - 25 WHERE id = '$idUser'";
	return SQLUpdate($SQL);
}

function getUserTokens($userId) {
	$SQL = "SELECT token FROM utilisateurs WHERE id = '$userId'";
	return SQLGetChamp($SQL);
}
?>