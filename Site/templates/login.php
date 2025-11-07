<?php
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php?view=login");
    die("");
}

if(!valider("connecte","SESSION")) {
    $login = valider("login", "COOKIE");
    $passe = valider("passe", "COOKIE"); 
    if ($checked = valider("remember", "COOKIE")) $checked = "checked"; 
?>

<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Connexion</h1>
        
        <form action="controleur.php" class="auth-form">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="login" placeholder="Identifiant" value="<?php echo $login;?>">
                <label for="floatingInput">Identifiant</label>
            </div>
            
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="Password" name="passe" placeholder="Mot de passe" value="<?php echo $passe;?>">
                <label for="Password">Mot de passe</label>
            </div>
            
            <div class="form-check mb-4">
                <input type="checkbox" class="form-check-input" id="Check" name="remember" <?php echo $checked;?>>
                <label class="form-check-label" for="Check">Se souvenir de moi</label>
            </div>
            
            <button type="submit" name="action" value="Connexion" class="btn btn-primary auth-btn">Se connecter</button>
            
            <div class="auth-footer">
                <a href="?view=creation_compte" class="auth-link">Créer un compte</a>
            </div>
        </form>
    </div>
</div>
<link rel="stylesheet" href="Style/login.css">

<?php
} else {
    header("Location:./?view=accueil");
}
?>