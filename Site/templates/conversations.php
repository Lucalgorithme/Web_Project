<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php?view=echanges");
    die("");
}

if(valider("connecte","SESSION")) {
    echo '<div class="echange-container">';
    echo '<h1>Mon échange</h1>';

    // ---------------------- Echange Normal ----------------------
    if(valider("idEchange")) {
        $echange = infoEchange(valider("idEchange"));
        $user1 = infoUser($echange["idUser1"]);
        $user2 = infoUser($echange["idUser2"]);
        $comp1 = infoComp($echange["idComp1"])[0];
        $comp2 = infoComp($echange["idComp2"])[0];

        echo '<div class="echange-card">';
        echo '<h3>Rappel des informations de l\'échange</h3>';
        echo '<div class="echange-info">';
        echo '<div>Utilisateur 1 : '.$user1["pseudo"].'</div>';
        echo '<div>Compétence de l\'utilisateur 1 : '.$comp1["nom"].'</div>';
        echo '<br>';
        echo '<div>Utilisateur 2 : '.$user2["pseudo"].'</div>';
        echo '<div>Compétence de l\'utilisateur 2 : '.$comp2["nom"].'</div>';
        echo '</div>';

        echo '<h3>Messages</h3>';
        echo '<div class="message-container">';
        $messages = listerMessages(valider("idEchange"));
        foreach ($messages as $mess) {
            echo '<div class="message">';
            echo '<span class="message-author">[' . secure($mess["pseudo"]) . ']</span> --> ' . secure($mess["contenu"]);
            echo '</div>';
        }
        echo '</div>';

        if ($echange["actif"]) {
            echo '<form action="controleur.php">';
            echo '<h5>Poster un message</h5>';
            echo '<div class="mb-3 form-floating">';
            echo '<input type="text" class="form-control" id="poster" placeholder="" name="contenu">';
            echo '<input type="hidden" name="idEchange" value="'.valider("idEchange").'">';
            echo '<label for="poster" class="form-label">Votre message</label>';
            echo '</div>';
            echo '<button type="submit" name="action" value="PosterMessage" class="btn btn-primary">Poster le message</button>';
            echo '</form>';

            echo '<h3>Rendre inactif</h3>';
            echo '<div class="alert-warning">Attention cette action est irréversible !</div>';
            echo '<form action="controleur.php">';
            echo '<input type="hidden" name="idEchange" value="'.valider("idEchange").'">';
            echo '<button type="submit" name="action" value="Inactif" class="btn btn-danger">Rendre inactif</button>';
            echo '</form>';
        }

        if (!$echange["validationUser1"]) {
            if (valider("idUser", "SESSION") == $echange["idUser1"]) {
                echo '<h4>Vous devez valider ou non l\'échange</h4>';
                echo '<form action="controleur.php">';
                echo '<input type="hidden" name="idEchange" value="'.$echange["idEchange"].'">';
                echo '<button type="submit" name="action" value="Valider" class="btn btn-success">Valider</button>';
                echo '<button type="submit" name="action" value="Refuser" class="btn btn-danger">Refuser</button>';
                echo '</form>';
            } else {
                echo '<h4>En attente de validation de l\'échange</h4>';
            }
        }
        echo '</div>'; // Fin echange-card
    }

    // ---------------------- Echange Token ----------------------
    if(valider("idEchangeToken")) {
        $echange = infoEchangeToken(valider("idEchangeToken"));
        $user1 = infoUser($echange["idUser1"]);
        $user2 = infoUser($echange["idUser2"]);
        $comp1 = infoComp($echange["idComp1"])[0];

        echo '<div class="echange-card">';
        echo '<h3>Rappel des informations de l\'échange</h3>';
        echo '<div class="echange-info">';
        echo '<div>Utilisateur 1 : '.$user2["pseudo"].'</div>';
        echo '<div>Cet utilisateur donne '.$echange["token"].' tokens à l\'autre</div>';
        echo '<br>';
        echo '<div>Utilisateur 2 : '.$user1["pseudo"].'</div>';
        echo '<div>Compétence de l\'utilisateur 2 : '.$comp1["nom"].'</div>';
        echo '</div>';

        echo '<h3>Messages</h3>';
        echo '<div class="message-container">';
        $messages = listerMessagesToken(valider("idEchangeToken"));
        foreach($messages as $mess) {
            echo '<div class="message">';
            echo '<span class="message-author">['.$mess["pseudo"].']</span> --> '.$mess["contenu"];
            echo '</div>';
        }
        echo '</div>';

        if ($echange["actif"]) {
            echo '<form action="controleur.php">';
            echo '<h5>Poster un message</h5>';
            echo '<div class="mb-3 form-floating">';
            echo '<input type="text" class="form-control" id="poster" placeholder="" name="contenu">';
            echo '<input type="hidden" name="idEchangeToken" value="'.valider("idEchangeToken").'">';
            echo '<label for="poster" class="form-label">Votre message</label>';
            echo '</div>';
            echo '<button type="submit" name="action" value="PosterMessageToken" class="btn btn-primary">Poster le message</button>';
            echo '</form>';

            echo '<h3>Rendre inactif</h3>';
            echo '<div class="alert-warning">Attention cette action est irréversible !</div>';
            echo '<form action="controleur.php">';
            echo '<input type="hidden" name="idEchangeToken" value="'.valider("idEchangeToken").'">';
            echo '<input type="hidden" name="idUser1" value="'.$echange["idUser1"].'">';
            echo '<input type="hidden" name="idUser2" value="'.$echange["idUser2"].'">';
            echo '<button type="submit" name="action" value="InactifToken" class="btn btn-danger">Rendre inactif</button>';
            echo '</form>';
        }

        if (!$echange["validationUser1"]) {
            if (valider("idUser", "SESSION") == $echange["idUser1"]) {
                echo '<h4>Vous devez valider ou non l\'échange</h4>';
                echo '<form action="controleur.php">';
                echo '<input type="hidden" name="idEchangeToken" value="'.$echange["idEchangeToken"].'">';
                echo '<input type="hidden" name="idUser2" value="'.$echange["idUser2"].'">';
                echo '<button type="submit" name="action" value="ValiderToken" class="btn btn-success">Valider</button>';
                echo '<button type="submit" name="action" value="RefuserToken" class="btn btn-danger">Refuser</button>';
                echo '</form>';
            } else {
                echo '<h4>En attente de validation de l\'échange</h4>';
            }
        }
        echo '</div>'; 
    }
    echo '</div>'; 
} else {
    header("Location:./index.php?view=login");
}

?>

<link rel="stylesheet" href="Style/conversations.css">