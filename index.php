<?php session_start(); ?>


<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="CSS/styles.css">
  <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
  <title>vente de maillaux</title>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand actual" href="index.php">NBO Stare</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="Panier.php">panier</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="loginAdmin.php">loginadmine</a>
            </li>
            <li id="ajouarticle" class="nav-item" style="display: none">
              <a class="nav-link" href="ajouterArticle.php">ajouter un Article</a>
            </li>
            <li id="editArticle" class="nav-item" style="display: none">
              <a class="nav-link" href="EditArticle.php">Edit un Article</a>
            </li>

          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <?php

    //Connexion à la base de données en pdo
    $pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=strouilh_bd', 'strouilh_bd', 'strouilh_bd');
    // requete pour selectionner les articles en stock
    $sql = "Select * from Articlephp Where qteStocks > 0";
    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->execute();
    $articles = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="container text-center">
      <h2 class="mb-5 mt-5"> Nos articles</h2>
      <div class="row ">
        <?php
        // affiche les articles en stock
        foreach ($articles as $article) {
        ?>
          <div class="col col-4">
            <div class="card mb-3">
              <img src="image/M<?= $article['url'] ?>" name=<?= $article['url'] ?> class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title"><?= $article['titre'] ?></h5>
                <p class="card-text"><?= $article['description'] ?></p>
                <p class="card-text"><small class="text-body-secondary"><?= $article['prix'] ?> €</small></p>
                <p class="card-text"><small ckass="text-body-secondary"><?= $article['qteStocks'] ?> Restant</small></p>
                <form action="index.php" method="post">
                  <input type="text" name="panier" value=<?= $article['id'] ?> style="display: none" id="">
                  <input type="submit" value="ajouter au panier">
                </form>



              </div>
            </div>
          </div>

        <?php } ?>

      </div>
      <div id="popup" style="display: none" class="popup">
        <img src="image/<?= $article['url'] ?>" class="popup-content" id="popup-img">
      </div>
    </div>
  </main>


  <?php
  if (isset($_SESSION["login"])) {
    if ($_SESSION["login"] == "root" && $_SESSION["Mdp"] == "root") { ?>
      <script>
        // affiche les boutons pour l'admin si il est connecter
        document.getElementById("ajouarticle").style.display = "block";
        document.getElementById("editArticle").style.display = "block";
        for (let index = 0; index < document.getElementsByClassName("BoutonModifier").length; index++) {
          document.getElementsByClassName("BoutonModifier")[index].style.display = "block";

        }
      </script>

  <?php }
  } ?>

  <?php
  // ajoute un article au panier
  if (isset($_POST["panier"])) {
    if (isset($_SESSION["panier"][$_POST["panier"]])) {

      $_SESSION["panier"][$_POST["panier"]]  = $_SESSION["panier"][$_POST["panier"]] + 1;
    } else {
      $_SESSION["panier"][$_POST["panier"]] = 1;
    }
  }



  ?>
  <script>
    // fonction pour ouvrir le popup
    function openPopup(src) {
      var popup = document.getElementById("popup");
      var popupImg = document.getElementById("popup-img");
      popup.style.display = "block";
      popupImg.src = src;
    }
    // ferme le popup
    document.getElementById("popup").addEventListener("click", () => {
      document.getElementById("popup").style.display = "none";
      document.getElementsByClassName("row")[0].style.display = "flex";
    });
    // pour chaque article ajoute un event listener pour ouvrir le popup
    for (let index = 0; index < document.getElementsByClassName("col").length; index++) {
      element = document.getElementsByClassName("col")[index];
      element.addEventListener("click", () => {

        element = document.getElementsByClassName("col")[index];

        openPopup("http://lakartxela.iutbayonne.univ-pau.fr/~strouilh/ptojetphp/image/" + element.getElementsByTagName("img")[0].name);
        document.getElementsByClassName("row")[0].style.display = "none";
      });
    };
  </script>

</body>

</html>