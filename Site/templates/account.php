<?php
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php?view=login");
    die("");
}

if(!(valider("connecte","SESSION") && (valider("idUser") == valider("idUser","SESSION")))) {
    header("Location:./index.php?view=login&msg=" . urlencode("Veuillez vous connectez !"));
} else {
    $infoUser = infoUser(valider("idUser","SESSION"));
    $skill = infoUserSkill(valider("idUser","SESSION"));
    $skillRecherche = infoUserSkillRecherche(valider("idUser","SESSION"));
?>

<div class="account-container">
    <div class="account-header">
        <h1>Mon compte</h1>
        <div class="token-badge"><?php echo $infoUser['token']?> tokens</div>
    </div>

    <div class="account-section">
        <h2>Informations personnelles</h2>
        <form action="controleur.php" class="account-form">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="Identifiant" name="login" value="<?php echo $infoUser['pseudo'];?>">
                <label for="Identifiant">Identifiant</label>
            </div>
            
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="Password" name="passe" value="<?php echo $infoUser['passe'];?>">
                <label for="Password">Mot de passe</label>
            </div>
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="Bio" name="bio" value="<?php echo $infoUser['bio'];?>">
                <label for="Bio">Bio</label>
            </div>
            
            <button type="submit" name="action" value="ModifierUser" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>

    <div class="account-section">
        <h2>Photo de profil</h2>
        <form action="controleur.php?action=EnvoyerImage" method="POST" enctype="multipart/form-data" class="upload-form">
            <div class="input-group">
                <input type="file" class="form-control" name="image" id="grp" required>
                <button class="btn btn-primary" type="submit">Envoyer</button>
            </div>
        </form>
    </div>

    <div class="account-section">
        <h2>Mes compétences</h2>
        <div class="alert alert-warning">Eviter les accents et apostrophes !</div>
        
        <?php foreach($skill as $i => $competence): ?>
        <div class="competence-card">
            <h3>Compétence n°<?= $i+1 ?></h3>
            <form action="controleur.php">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="nom" value="<?= $competence["nom"] ?>">
                    <label>Nom</label>
                </div>
                
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="desc" value="<?= $competence["description"] ?>">
                    <label>Description</label>
                </div>
                
                <input type="hidden" name="idComp" value="<?= $competence["idComp"] ?>">
                
                <div class="button-group">
                    <button type="submit" name="action" value="ModifierComp" class="btn btn-primary">Modifier</button>
                    <button type="submit" name="action" value="SuppressionCompAcquise" class="btn btn-danger">Supprimer</button>
                </div>
            </form>
        </div>
        <?php endforeach; ?>
        
        <div class="competence-card new">
            <h3>Ajouter une compétence</h3>
            <form action="controleur.php">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="nom">
                    <label>Nom</label>
                </div>
                
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="desc">
                    <label>Description</label>
                </div>
                
                <button type="submit" name="action" value="AjouterComp" class="btn btn-primary">Ajouter</button>
            </form>
        </div>
    </div>

    <div class="account-section">
        <h2>Compétences recherchées</h2>
        
        <?php foreach($skillRecherche as $i => $competence): ?>
        <div class="competence-card">
            <h3>Compétence n°<?= $i+1 ?></h3>
            <form action="controleur.php">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="nom" value="<?= $competence["nom"] ?>">
                    <label>Nom</label>
                </div>
                
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="desc" value="<?= $competence["description"] ?>">
                    <label>Description</label>
                </div>
                
                <input type="hidden" name="idComp" value="<?= $competence["idCompRecherche"] ?>">
                
                <div class="button-group">
                    <button type="submit" name="action" value="ModifierCompRecherche" class="btn btn-primary">Modifier</button>
                    <button type="submit" name="action" value="SuppressionCompRecherche" class="btn btn-danger">Supprimer</button>
                </div>
            </form>
        </div>
        <?php endforeach; ?>
        
        <div class="competence-card new">
            <h3>Ajouter une compétence recherchée</h3>
            <form action="controleur.php">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="nom">
                    <label>Nom</label>
                </div>
                
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="desc">
                    <label>Description</label>
                </div>
                
                <button type="submit" name="action" value="AjouterCompRecherche" class="btn btn-primary">Ajouter</button>
            </form>
        </div>
    </div>

    <div class="account-danger">
        <form action="controleur.php">
            <button type="submit" name="action" value="SupprimerCompte" class="btn btn-danger">SUPPRIMER MON COMPTE</button>
        </form>
    </div>
</div>

<link rel="stylesheet" href="Style/account.css">

<?php } ?>