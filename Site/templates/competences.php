<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=competences");
	die("");
}

if(valider("connecte","SESSION")){

echo '<h1 style="text-align:center;">Liste des compétences</h1>';

?>
<br>
<div class="d-flex login">
<form action="controleur.php">
    <div class="mb-3 input-group">
    <input type="text" class="form-control" id="Rechercher" name="mot">
	<button type="submit" name="action" value="RechercheComp" class="btn btn-outline-secondary">Rechercher</button>
	</div>
</form>
</div>
	<br><br>

<?php

$competenceListe = listerCompetences(valider("idUser","SESSION"),valider("texte"));

// tprint($competenceListe);

echo '<div class="d-flex afficheCompDiv">';
foreach($competenceListe as $comp){

	echo '<form action="controleur.php">';
	echo '<div class="afficheComp">';

	echo '<div>Utilisateur : '.$comp["pseudo"].'</div><br>';
	echo '<div>Skill proposé : '.$comp["CA"].'</div>';
	echo '<div>'.$comp["DESC_CA"].'</div><br>';
	echo '<div>Skill recherché : '.$comp["CR"].'</div>';
	echo '<div>'.$comp["DESC_CR"].'</div>';

	echo '<br>';
	echo '<div style="text-align:center !important;">';
	echo '<button type="submit" name="action" value="Echange" class="btn btn-primary">Commencer un échange</button>';
	echo '</div>';

	echo '</div>';

	echo '<input type="hidden" name="pseudo" value="'.$comp["pseudo"].'">';
	echo '<input type="hidden" name="idPseudo" value="'.$comp["id"].'">';
	echo '<input type="hidden" name="CA" value="'.$comp["CA"].'">';
	echo '<input type="hidden" name="DESC_CA" value="'.$comp["DESC_CA"].'">';
	echo '<input type="hidden" name="idComp" value="'.$comp["idComp"].'">';



	echo '</form>';
	echo '<br>';
}
echo '</div>';


}
else{
  header("Location:./index.php?view=login");
}

?>


<link rel="stylesheet" href="Style/competences.css">