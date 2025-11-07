<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php?view=echanges");
    die("");
}

if(valider("connecte","SESSION")) {
    echo '<div class="echange-container">';
    echo '<h1>Mes échanges en cours</h1>';

    $liste = listerEchanges(valider("idUser","SESSION"), 1, 1);
    $liste2 = listerEchangesToken(valider("idUser","SESSION"), 1, 1);

    // Echange normal
    foreach($liste as $list) {
        $user1 = infoUser($list["idUser1"]);
        $user2 = infoUser($list["idUser2"]);
        $comp1 = infoComp($list["idComp1"])[0];
        $comp2 = infoComp($list["idComp2"])[0];

        echo '<div class="echange-card">';
        echo '<a href="index.php?view=conversations&idEchange='.$list["idEchange"].'">';
        echo '<div class="echange-info">Echange : '.$user1["pseudo"].' - '.$comp1["nom"].' <-> '.$user2["pseudo"].' - '.$comp2["nom"].'</div>';
        echo '</a>';
        echo '</div>';
    }

    // Echange token
    foreach($liste2 as $list) {
        $user1 = infoUser($list["idUser1"]);
        $user2 = infoUser($list["idUser2"]);
        $comp1 = infoComp($list["idComp1"])[0];

        echo '<div class="echange-card">';
        echo '<a href="index.php?view=conversations&idEchangeToken='.$list["idEchangeToken"].'">';
        echo '<div class="echange-info">Echange : '.$user2["pseudo"].' - <-> '.$user1["pseudo"].' - '.$comp1["nom"].'</div>';
        echo '</a>';
        echo '</div>';
    }

    echo '<h1>Mes échanges terminés</h1>';

    $liste = listerEchanges(valider("idUser","SESSION"), 0, 1);
    $liste2 = listerEchangesToken(valider("idUser","SESSION"), 0, 1);

    // Echange normal
    foreach($liste as $list) {
        $idUseractuel = valider("idUser","SESSION");
        $idautreuser = ($idUseractuel == $list["idUser1"]) ? $list["idUser2"] : $list["idUser1"];
        $idUser1 = ($idUseractuel == $list["idUser1"]);

        $user1 = infoUser($list["idUser1"]);
        $user2 = infoUser($list["idUser2"]);
        $comp1 = infoComp($list["idComp1"])[0];
        $comp2 = infoComp($list["idComp2"])[0];

        echo '<div class="echange-card">';
        echo '<div style="display: flex; justify-content: space-between; align-items: center;">';
        echo '<a href="index.php?view=conversations&idEchange='.$list['idEchange'].'">';
        echo '<div class="echange-info">Echange : '.$user1["pseudo"].' - '.$comp1["nom"].' <-> '.$user2["pseudo"].' - '.$comp2["nom"].'</div>';
        echo '</a>';

        if (($idUser1 && !$list["voteUser1"]) || (!$idUser1 && !$list["voteUser2"])) {
            mkForm("controleur.php");
            echo '<div class="vote-buttons">';
            echo '<input type="hidden" name="idEchange" value="' . $list["idEchange"] . '">';
            echo '<input type="hidden" name="voter" value="' . ($idUser1 ? '1' : '2') . '">';
            echo '<input type="hidden" name="idautreuser" value="' . $idautreuser . '">';
            echo '<button type="submit" name="action" value="ajouterToken" class="vote-btn vote-up">👍</button>';
            echo '<button type="submit" name="action" value="pasDeToken" class="vote-btn vote-down">👎</button>';
            echo '</div>';
            endForm();
        } else {
            echo '<div class="alert-success">Vous avez déjà voté</div>';
        }
        echo '</div>';
        echo '</div>';
    }

    // Echange token
    foreach($liste2 as $list) {
        $idUseractuel = valider("idUser","SESSION");
        $idautreuser = ($idUseractuel == $list["idUser1"]) ? $list["idUser2"] : $list["idUser1"];
        $idUser1 = ($idUseractuel == $list["idUser1"]);

        $user1 = infoUser($list["idUser1"]);
        $user2 = infoUser($list["idUser2"]);
        $comp1 = infoComp($list["idComp1"])[0];

        echo '<div class="echange-card">';
        echo '<div style="display: flex; justify-content: space-between; align-items: center;">';
        echo '<a href="index.php?view=conversations&idEchangeToken='.$list['idEchangeToken'].'">';
        echo '<div class="echange-info">Echange : '.$user2["pseudo"].' - <-> '.$user1["pseudo"].' - '.$comp1["nom"].'</div>';
        echo '</a>';

        if (!$idUser1 && !$list["voteUser1"]) {
            mkForm("controleur.php");
            echo '<div class="vote-buttons">';
            echo '<input type="hidden" name="idEchangeToken" value="' . $list["idEchangeToken"] . '">';
            echo '<input type="hidden" name="voter" value="1">';
            echo '<input type="hidden" name="idautreuser" value="' . $idautreuser . '">';
            echo '<button type="submit" name="action" value="ajouterToken2" class="vote-btn vote-up">👍</button>';
            echo '<button type="submit" name="action" value="pasDeToken2" class="vote-btn vote-down">👎</button>';
            echo '</div>';
            endForm();
        } else if (!$idUser1) {
            echo '<div class="alert-success">Vous avez déjà voté</div>';
        }
        echo '</div>';
        echo '</div>';
    }

    echo '<h1>Mes échanges en attente de validation</h1>';

    $liste = listerEchanges(valider("idUser","SESSION"), 0, 0);
    $liste2 = listerEchangesToken(valider("idUser","SESSION"), 0, 0);

    // Echange normal
    foreach($liste as $list) {
        $user1 = infoUser($list["idUser1"]);
        $user2 = infoUser($list["idUser2"]);
        $comp1 = infoComp($list["idComp1"])[0];
        $comp2 = infoComp($list["idComp2"])[0];

        echo '<div class="echange-card">';
        echo '<a href="index.php?view=conversations&idEchange='.$list["idEchange"].'&validation=0">';
        echo '<div class="echange-info">Echange : '.$user1["pseudo"].' - '.$comp1["nom"].' <-> '.$user2["pseudo"].' - '.$comp2["nom"].'</div>';
        echo '</a>';
        echo '</div>';
    }

    // Echange token
    foreach($liste2 as $list) {
        $user1 = infoUser($list["idUser1"]);
        $user2 = infoUser($list["idUser2"]);
        $comp1 = infoComp($list["idComp1"])[0];

        echo '<div class="echange-card">';
        echo '<a href="index.php?view=conversations&idEchangeToken='.$list["idEchangeToken"].'">';
        echo '<div class="echange-info">Echange : '.$user2["pseudo"].' - <-> '.$user1["pseudo"].' - '.$comp1["nom"].'</div>';
        echo '</a>';
        echo '</div>';
    }

    echo '</div>'; 
} else {
    header("Location:./index.php?view=login");
}

?>

<link rel="stylesheet" href="Style/echanges.css">

