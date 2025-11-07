<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=echanges");
	die("");
}

if(valider("connecte","SESSION")){



echo '<h1>Profil des utilisateurs : </h1><br>';

?>

<div class="d-flex login">
<form action="controleur.php">
    <div class="mb-3 input-group">
    <input type="text" class="form-control" id="Rechercher" name="mot">
	<button type="submit" name="action" value="RechercheUser" class="btn btn-outline-secondary">Rechercher</button>
	</div>
</form>
</div>
	

<?php

$profil = listerUtilisateurs(valider("texte"));
// tprint($profil);

echo '<div class="d-flex afficheCompDiv">';
foreach($profil as $pro){

	$imagePath = getImagePath($pro["id"]);

	if ($imagePath && file_exists($imagePath)) {
    	echo '<img src="' . $imagePath . '" width="200" height="200" class="rounded-circle">';
	} else {
   		// Image par défaut
    	echo '<img src="ressources/pp.png" width="200" height="200" class="rounded-circle">';
	}

	echo '<form action="controleur.php">';
	echo '<div class="afficheComp2">';

	echo '<div>Utilisateur : '.$pro["pseudo"].'</div><br>';


	echo '<input type="hidden" name="idUser" value="'.$pro["id"].'">';

	echo '<button type="submit" name="action" value="Profil" class="btn btn-primary">Voir le profil</button>';
	echo '</div>';

	echo '</form>';
	echo '<br>';
}
echo '</div>';


}
else{
  header("Location:./index.php?view=login");
}

?>

<link rel="stylesheet" href="Style/recherche_profil.css">