<?php
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php?view=admin");
    die("");
}

if(!isAdmin(valider("idUser","SESSION"))) {
    header("Location:../index.php?view=accueil");
    die("");
}
?>

<div class="admin-container">
    <h1 class="admin-title">Administration du site</h1>
    
    <div class="admin-section">
        <h2>Utilisateurs</h2>
        <form action="controleur.php" class="admin-search">
            <input type="text" name="mot" placeholder="Entrez un pseudo ou id" class="form-control">
            <div class="button-group">
                <button type="submit" name="action" value="adminuser" class="btn btn-secondary">Rechercher</button>
                <button type="submit" name="action" value="adminafficheruser" class="btn btn-secondary">Tout afficher</button>
            </div>
        </form>
        
        <div class="admin-results">
            <?php
            $users = listerUtilisateurs(valider("mot"));
            if (empty($users)) {
                echo '<div class="no-results">Aucun utilisateur trouvé.</div>';
            } else {
                foreach ($users as $user) {
                    echo '<div class="admin-card">';
                    echo '<form action="controleur.php">';
                    echo '<div class="admin-card-content">';
                    echo '<p><strong>ID:</strong> ' . $user['id'] . '</p>';
                    echo '<p><strong>Utilisateur:</strong> ' . $user['pseudo'] . '</p>';
                    echo '<p><strong>Bio:</strong> ' . $user['bio'] . '</p>';
                    echo '<p><strong>Rôle:</strong> ' . $user['role'] . '</p>';
                    echo '<p><strong>Token:</strong> ' . $user['token'] . '</p>';
                    echo '</div>';
                    echo '<input type="hidden" name="pseudo" value="'.$user['pseudo'].'">';
                    echo '<input type="hidden" name="idUser" value="'.$user['id'].'">';
                    echo '<button type="submit" name="action" value="SupprimerUser" class="btn btn-danger">Supprimer</button>';
                    echo '</form>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
    
    <div class="admin-section">
        <h2>Compétences</h2>
        <form action="controleur.php" class="admin-search">
            <input type="text" name="b" placeholder="Entrez un pseudo ou id" class="form-control">
            <div class="button-group">
                <button type="submit" name="action" value="adminecompetences" class="btn btn-secondary">Rechercher</button>
                <button type="submit" name="action" value="adminaffichercompetences" class="btn btn-secondary">Tout afficher</button>
            </div>
        </form>
        
        <div class="admin-results">
            <?php
            $competences = listageCompetences(valider("b"));
            if (empty($competences)) {
                echo '<div class="no-results">Aucune compétence trouvée.</div>';
            } else {
                foreach ($competences as $competence) {
                    echo '<div class="admin-card">';
                    echo '<form action="controleur.php">';
                    echo '<div class="admin-card-content">';
                    echo '<p><strong>ID:</strong> ' . $competence['id'] . '</p>';
                    echo '<p><strong>Type:</strong> ' . $competence['type_competence'] . '</p>';
                    echo '<p><strong>Utilisateur:</strong> ' . $competence['pseudo'] . ' (id = ' . $competence['utilisateur'] . ')</p>';
                    echo '<p><strong>Nom:</strong> ' . $competence['nom'] . '</p>';
                    echo '<p><strong>Description:</strong> ' . $competence['description'] . '</p>';
                    echo '</div>';
                    echo '<input type="hidden" name="id" value="'.$competence['id'].'">';
                    echo '<input type="hidden" name="type" value="'.$competence['type_competence'].'">';
                    echo '<input type="hidden" name="idutilisateur" value="'.$competence['utilisateur'].'">';
                    echo '<button type="submit" name="action" value="SupprimerComp" class="btn btn-danger">Supprimer</button>';
                    echo '</form>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
    
    <div class="admin-section">
        <h2>Échanges</h2>
        <form action="controleur.php" class="admin-search">
            <input type="text" name="a" placeholder="Entrez un pseudo ou id" class="form-control">
            <div class="button-group">
                <button type="submit" name="action" value="adminechanges" class="btn btn-secondary">Rechercher</button>
                <button type="submit" name="action" value="adminafficherechanges" class="btn btn-secondary">Tout afficher</button>
            </div>
        </form>
        
        <div class="admin-results">
            <?php
            $echanges = listageEchanges(valider("a"));
            if (empty($echanges)) {
                echo '<div class="no-results">Aucun échange trouvé.</div>';
            } else {
                foreach ($echanges as $echange) {
                    echo '<div class="admin-card">';
                    echo '<form action="controleur.php">';
                    echo '<div class="admin-card-content">';
                    echo '<p><strong>ID:</strong> ' . $echange['idEchange'] . '</p>';
                    echo '<p><strong>Utilisateur 1:</strong> ' . $echange['pseudo1'] . '</p>';
                    echo '<p><strong>Utilisateur 2:</strong> ' . $echange['pseudo2'] . '</p>';
                    echo '<p><strong>Compétence 1:</strong> ' . $echange['comp1'] . " (id = " . $echange['idComp1'] . ')</p>';
                    echo '<p><strong>Compétence 2:</strong> ' . $echange['comp2'] . " (id = " . $echange['idComp2'] . ')</p>';
                    echo '<p><strong>Actif:</strong> ' . ($echange['actif'] == 1 ? 'Oui' : 'Non') . '</p>';
                    echo '</div>';
                    echo '<input type="hidden" name="idEchange" value="'.$echange['idEchange'].'">';
                    echo '<input type="hidden" name="idUser1" value="'.$echange['idUser1'].'">';
                    echo '<input type="hidden" name="idUser2" value="'.$echange['idUser2'].'">';
                    echo '<input type="hidden" name="idComp1" value="'.$echange['idComp1'].'">';
                    echo '<input type="hidden" name="idComp2" value="'.$echange['idComp2'].'">';
                    echo '<button type="submit" name="action" value="SupprimerEchange" class="btn btn-danger">Supprimer</button>';
                    echo '</form>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
    
    <div class="admin-section">
        <h2>Échanges Avec Token</h2>
        <form action="controleur.php" class="admin-search">
            <input type="text" name="c" placeholder="Entrez un pseudo ou id" class="form-control">
            <div class="button-group">
                <button type="submit" name="action" value="adminechangestoken" class="btn btn-secondary">Rechercher</button>
                <button type="submit" name="action" value="adminafficherechangestoken" class="btn btn-secondary">Tout afficher</button>
            </div>
        </form>
        
        <div class="admin-results">
            <?php
            $echangestoken = listageEchangesToken(valider("c"));
            if (empty($echangestoken)) {
                echo '<div class="no-results">Aucun échange avec token trouvé.</div>';
            } else {
                foreach ($echangestoken as $echangetoken) {
                    echo '<div class="admin-card">';
                    echo '<form action="controleur.php">';
                    echo '<div class="admin-card-content">';
                    echo '<p><strong>ID:</strong> ' . $echangetoken['idEchangeToken'] . '</p>';
                    echo '<p><strong>Utilisateur 1:</strong> ' . $echangetoken['pseudo1'] . ' (id = ' . $echangetoken['idUser1'] . ')</p>';
                    echo '<p><strong>Utilisateur 2:</strong> ' . $echangetoken['pseudo2'] . ' (id = ' . $echangetoken['idUser2'] . ')</p>';
                    echo '<p><strong>Compétence:</strong> ' . $echangetoken['comp1'] . '</p>';
                    echo '<p><strong>Tokens:</strong> ' . $echangetoken['token'] . '</p>';
                    echo '<p><strong>Actif:</strong> ' . ($echangetoken['actif'] == 1 ? 'Oui' : 'Non') . '</p>';
                    echo '</div>';
                    echo '<input type="hidden" name="idEchangeToken" value="'.$echangetoken['idEchangeToken'].'">';
                    echo '<input type="hidden" name="idUser1" value="'.$echangetoken['idUser1'].'">';
                    echo '<input type="hidden" name="idUser2" value="'.$echangetoken['idUser2'].'">';
                    echo '<button type="submit" name="action" value="SupprimerEchangeToken" class="btn btn-danger">Supprimer</button>';
                    echo '</form>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
    
    <div class="admin-section">
        <h2>Tokens</h2>
        <form action="controleur.php" class="admin-search">
            <input type="text" name="e" placeholder="Entrez un pseudo ou id" class="form-control">
            <div class="button-group">
                <button type="submit" name="action" value="admintoken" class="btn btn-secondary">Rechercher</button>
                <button type="submit" name="action" value="adminaffichertoken" class="btn btn-secondary">Tout afficher</button>
            </div>
        </form>
        
        <div class="admin-results">
            <?php
            $tokens = listertoken(valider("e"));
            if (empty($tokens)) {
                echo '<div class="no-results">Aucun token trouvé.</div>';
            } else {
                foreach ($tokens as $token) {
                    echo '<div class="admin-card">';
                    echo '<form action="controleur.php">';
                    echo '<div class="admin-card-content">';
                    echo '<p><strong>Utilisateur:</strong> ' . $token['pseudo'] . ' (id = ' . $token['id'] . ')</p>';
                    echo '<p><strong>Tokens:</strong> ' . $token['token'] . '</p>';
                    echo '</div>';
                    echo '<input type="hidden" name="idUser" value="'.$token['id'].'">';
                    echo '<input type="text" name="token" value="'.$token['token'].'" class="form-control mb-2">';
                    echo '<button type="submit" name="action" value="ModifierToken" class="btn btn-danger">Modifier</button>';
                    echo '</form>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</div>

<link rel="stylesheet" href="Style/admin.css">