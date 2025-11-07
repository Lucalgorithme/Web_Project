<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=echanges");
	die("");
}

if(valider("connecte","SESSION")){

$profil = infoUser(valider("idUser")); 
// tprint($profil);

echo '<h1>Profil de "'.$profil["pseudo"].'" : </h1><br>';


$imagePath = getImagePath(valider("idUser"));

if ($imagePath && file_exists($imagePath)) {
    echo '<img src="' . $imagePath . '" width="200" height="200" class="rounded-circle">';
} else {
    // Image par défaut
    echo '<img src="ressources/pp.png" width="200" height="200" class="rounded-circle">';
}

echo '<br><br>';
echo '<h5>Bio : '.$profil["bio"].'</h5>';

echo '<br>';
echo '<h3>Ses compétences acquises : </h3>';

$comp = Comp(valider("idUser"));
//tprint($comp);
echo '<br>';

foreach($comp as $cp){

	echo '<h5>Nom : '.$cp["nom"].'</h5>';
	echo '<h5>Description : '.$cp["description"].'</h5>';
	echo '<a href="index.php?view=competences&texte='.$cp["nom"].'"><button class="btn btn-primary">Aller à la compétence</button></a>';
	echo '<br><br>';
}


echo '<h3>Ses compétences recherchées : </h3>';

$comp2 = CompRecherche(valider("idUser"));
 // tprint($comp2);
echo '<br>';
foreach($comp2 as $cp){

	echo '<h5>Nom : '.$cp["nom"].'</h5>';
	echo '<h5>Description : '.$cp["description"].'</h5>';
	echo '<br>';
}


}
else{
  header("Location:./index.php?view=login");
}

?>

<link rel="stylesheet" href="Style/profil.css">