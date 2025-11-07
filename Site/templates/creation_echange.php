<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=creation_compte");
	die("");
}


if(valider("connecte","SESSION")){

?>

<div class="page-header login">
  
	<h1>Création de votre échange</h1>
</div>


<h3>Vous avez choisi :</h3><br>

<?php

	$competenceRecherche = infoUserSkillRecherche(valider("idPseudo"));
	// tprint($competenceRecherche);

	echo '<div>Utilisateur : '.valider("pseudo").'</div><br>';
	echo '<div>Skill proposé : '.valider("CA").'</div>';
	echo '<div>'.valider("DESC_CA").'</div><br>';
	echo 'Skill rechechés :';
	foreach($competenceRecherche as $compRech){
		echo '<div>-> '.$compRech["nom"].'</div>';
	}
	echo '<br><hr>';

?>

<br>
<h4>Vous devez maintenant choisir entre 2 choix</h4>
<h5>Soit vous échangez avec une de vos compétences</h5>
<h5>Soit vous payez des token pour que la personne vous apprenne sa compétence</h5>

<br><br>

<form action="controleur.php">
  <div>
    <label>
      <input type="radio" name="choix" value="1" checked>
      Echange de compétence
    </label>
</div>
<br>

  <div>Choisissez la compétence a échanger (assurez-vous que la personne recherche cette compétence) :</div>
  <?php
	echo '<input type="hidden" name="idUser1" value="'.valider("idPseudo").'">';
	echo '<input type="hidden" name="idComp1" value="'.valider("idComp").'">';

	$competences = infoUserSkill(valider("idUser","SESSION"));
	// tprint($competences);

	echo '<select name="comp">';
	foreach($competences as $comp){
		echo '<option value="'.$comp["idComp"].'">'.$comp["nom"].'</option>';
	}
  	echo '</select>';
	
  ?>

	<?php
	$userTokens = getUserTokens(valider("idUser","SESSION")); 
	if ($userTokens >= 25) {
	?>
		<br><br><hr><br>
		<div>
			<label>
				<input type="radio" name="choix" value="2">
				Payez des tokens
			</label>
		</div>
		<br>
		<label><p>L'échange coûte 25 token</label>
		<br>
	<?php
	} else {
		echo "<br><br><hr><br>Vous n'avez pas assez de tokens (minimum 25 requis)";
		echo '<br>';
	}
	?>


  <br>
  <button type="submit" name="action" value="DemarreEchange" class="btn btn-success btn-lg">Démarrer l'échange</button>
</form>


<?php
}
else{
  header("Location:./index.php?view=login");
}

?>

<link rel="stylesheet" href="Style/creation_echange.css">