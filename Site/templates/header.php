<?php
ob_start();
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SkillSwap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  
<style>

body{ 
  background-color: rgb(47, 47, 47) !important;
  color : rgb(236, 234, 234) !important;
  /* text-shadow : 1px 1px 1px rgb(26, 26, 26); */
}


label{
  color : rgb(255, 255, 255) !important;
}

input{

  background-color: rgb(47, 47, 47) !important;
  color : rgb(236, 234, 234) !important;
  max-width : 450px !important;

}

.login{
  text-align: center !important;
  justify-content: center !important;
  flex-direction: column;
  align-items: center;        
}


.afficheCompDiv{
  justify-content: center !important;
  flex-direction: column;
  align-items: center;
}

.afficheComp{
  border : 1px solid rgb(71, 71, 71) ;
  padding : 10px ;
  background-color : rgb(71, 71, 71) ;
  width : 500px ;
  color : rgb(255, 255, 255) ;
}


.afficheComp2{
  border : 1px solid rgb(71, 71, 71) ;
  padding : 10px ;
  background-color : rgb(71, 71, 71) ;
  width : 300px ;
  color : rgb(255, 255, 255) ;
  text-align : center;
}


@media (max-width: 500px) {
  .afficheComp{
    width:300px;
  }
}
/* Pour page d'accueil */

.imgtxt {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: center;
      gap: 20px;
    }

.img {
      flex: 1 1 300px;
    }

.img img{
  border-radius:30px;
  max-width:400px;
  height : auto !important;
  
}

.txt {
      flex: 1 1 500px;
    }

@media (max-width: 768px) {
      .imgtxt {
        flex-direction: column;
        text-align: center;
      }

      .txt {
        padding: 0 10px;
      }
    }

/* Fin page d'accueil */


</style>

</head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>



<header class="p-3 mb-3 border-bottom bg-light" style="background-color: rgb(47, 47, 47) !important;">
  <div class="container">
    <nav class="navbar navbar-expand-lg">
      <a class="navbar-brand me-5" href="?view=accueil" style="color:rgb(236, 234, 234);"><img style="width:100px; border-radius:20px;" src="ressources/skillswap.jpg"></a>

      <!-- Bouton burger visible sur petits écrans -->
      <button class="navbar-toggler"  style="background-color : rgb(91, 91, 91) !important;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
              aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menu responsive -->
      <div class="collapse navbar-collapse" id="navbarMenu">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <?php
          if(valider("connecte","SESSION")){
            echo '<li class="nav-item"><a href="?view=recherche_profil" class="nav-link px-2 link-secondary">Utilisateurs</a>';
            echo '</li>';

            echo '<li class="nav-item"><a href="?view=competences" class="nav-link px-2 link-secondary">Compétences</a>';
            echo '</li>';

            echo '<li class="nav-item"><a href="?view=echanges" class="nav-link px-2 link-secondary">Échanges</a>';
            echo '</li>';
            if(isAdmin(valider("idUser","SESSION"))){
              echo '<li class="nav-item"><a href="?view=admin" class="nav-link px-2 link-secondary">Administration</a>';
              echo '</li>';
            }
          }
          ?>
        </ul>

        <div class="d-flex">
          <?php
          if(!valider("connecte","SESSION")){
              echo '<ul class="navbar-nav">';
              echo '<li class="nav-item"><a href="?view=login" class="nav-link px-2 link-secondary">Se connecter</a></li>';
              echo '</ul>';
          } else {
              echo '<div class="dropdown">';
              echo '<a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">';
              
              $imagePath = getImagePath(valider("idUser", "SESSION"));

              if ($imagePath && file_exists($imagePath)) {
                echo '<img src="' . $imagePath . '" width="45" height="45" class="rounded-circle">';
              } else {
                // Image par défaut
                echo '<img src="ressources/pp.png" width="45" height="45" class="rounded-circle">';
              }
              
              
              echo '</a>';
              echo '<ul class="dropdown-menu dropdown-menu-lg-end text-small">';
              echo '<li><a class="dropdown-item" style="color:black!important;" href="?view=account&idUser='.$_SESSION["idUser"].'">Profil</a></li>';
              echo '<li><hr style="margin : 10px 0!important; color: black!important;" class="dropdown-divider"></li>';
              echo '<li><a class="dropdown-item" style="color:black!important;" href="controleur.php?action=Logout">Se déconnecter</a></li>';
              echo '</ul>';
              echo '</div>';
          }
          ?>
        </div>
      </div>
    </nav>
  </div>
</header>


	  
  <!-- Begin page content -->
  <div class="container">
  
  <?php
    if ($msg = valider("msg")) {
      echo "<div class='alert  alert-warning'>$msg</div>\n";
    }
  
  ?>
