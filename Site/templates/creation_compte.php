<?php
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php?view=creation_compte");
    die("");
}
?>

<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Création de compte</h1>
        
        <form action="controleur.php" class="auth-form">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="Identifiant" name="login" placeholder="Identifiant" required>
                <label for="Identifiant">Identifiant</label>
                <div class="form-text">Choisissez un nom d'utilisateur unique</div>
            </div>
            
            <div class="form-floating mb-4">
                <input type="password" class="form-control" id="Password" name="passe" placeholder="Mot de passe" required>
                <label for="Password">Mot de passe</label>
                <div class="form-text">Minimum 8 caractères</div>
            </div>
            
            <button type="submit" name="action" value="CreationCompte" class="btn btn-primary auth-btn">Créer mon compte</button>
            
            <div class="auth-footer">
                <p>Déjà un compte ? <a href="?view=login" class="auth-link">Se connecter</a></p>
            </div>
        </form>
    </div>
</div>


<script>
document.getElementById('Password').addEventListener('input', function(e) {
    const password = e.target.value;
    const strength = calculatePasswordStrength(password);
    const indicator = document.createElement('div');
    indicator.className = 'password-strength strength-' + strength;
    
    let existingIndicator = document.querySelector('.password-strength');
    if (existingIndicator) {
        existingIndicator.className = 'password-strength strength-' + strength;
    } else {
        e.target.parentNode.appendChild(indicator);
    }
});

function calculatePasswordStrength(password) {
    let strength = 0;
    if (password.length > 0) strength++;
    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    return Math.min(strength, 4);
}
</script>

<link rel="stylesheet" href="Style/creation_compte.css">