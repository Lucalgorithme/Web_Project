<?php

//blablabla
//C'est la propriété php_self qui nous l'indique : 
// Quand on vient de index : 
// [PHP_SELF] => /chatISIG/index.php 
// Quand on vient directement par le répertoire templates
// [PHP_SELF] => /chatISIG/templates/accueil.php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
// Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}

?>


    <div class="page-header">
      <h1 style="text-align:center;">Bienvenue sur SkillSwap</h1>
    </div>

  
    <!--
<div class="container marketing">
    <div class="row featurette"> 
      <div class="col-md-7 order-md-2"> 
        <h2 class="featurette-heading fw-normal lh-1">C'est quoi SkillSwap ?</h2> 
        <p class="lead">Another featurette? Of course. More placeholder content here to give you an idea of how this layout would work with some actual real-world content in place.</p> </div> 
        <div class="col-md-5 order-md-1"> 
          <svg aria-label="Placeholder: 500x500" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" height="300" preserveAspectRatio="xMidYMid slice" role="img" width="300" xmlns="http://www.w3.org/2000/svg">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="var(--bs-secondary-bg)"></rect>
            <text x="50%" y="50%" fill="var(--bs-secondary-color)" dy=".3em">500x500</text>
          </svg> 
        </div> 
      </div>
</div>
-->

<div class="imgtxt">
  <div class="img">
  <img src="https://cdn-icons-png.flaticon.com/512/1017/1017314.png">
</div>
  <div class="txt">
    <h2>C’est quoi SkillSwap ?</h2>

    <h5>SkillSwap, c’est une plateforme d’échange de compétences entre particuliers. Tu veux
    apprendre la guitare, le dessin, le développement web ou même faire du pain ? Ici, tu
    rencontres des gens prêts à t’enseigner ce qu’ils savent faire.</h5>

    <h2>Comment ça fonctionne ?</h2>

    <h5>Chaque compétence peut être échangée de deux façons : en proposant une autre
    compétence en retour, ou en utilisant des tokens, la monnaie interne de la plateforme. Tu
    gagnes des tokens en enseignant à d’autres utilisateurs, et tu les dépenses pour
    apprendre ce que tu veux. Pas besoin d’être expert dans un domaine pour commencer : tu
    peux apprendre d’abord, puis transmettre plus tard.</h5>

  </div>
</div>

<hr>

<div class="imgtxt">
  <div class="txt">
    <h2>Que doit faire l’utilisateur pour commencer ?</h2>

    <h5>Crée ton profil, ajoute les compétences que tu maîtrises. Ensuite, choisis une compétence qui t’intéresse,
    et propose un échange ou utilise tes tokens pour y accéder.</h5>

    <h2>Pourquoi SkillSwap, c’est cool ?</h2>

    <h5>Parce que tu progresses en apprenant des vraies compétences utiles, dans une logique de partage. Tu
    n’as rien à ofrir au début ? Pas grave. Utilise des tokens, apprends, puis reviens enseigner à ton tour pour
    en regagner. C’est un système équitable, humain, et motivant, où chaque savoir a de la valeur. </h5>
</div>
  <div class="img" >
      <img src="https://cdn-icons-png.flaticon.com/512/6681/6681925.png">
</div>
    </div>


<link rel="stylesheet" href="Style/accueil.css">