<?php session_start(); ?>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="CSS/styles.css">
  <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
  <title>Document</title>
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

  <body>





    <?php

    //Connexion à la base de données en pdo
    $pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=strouilh_bd', 'strouilh_bd', 'strouilh_bd');
    $sql = "Select * from Articlephp";
    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->execute();
    $articles = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="container text-center">
      <h2 class="mb-5 mt-5"> Nos articles</h2>
      <div class="row">
        <?php
        foreach ($articles as $article) {
        ?>
          <div class="col">
            <div class="card mb-3">
              <img src="image/<?= $article['url'] ?>" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title"><?= $article['titre'] ?></h5>
                <p class="card-text"><?= $article['description'] ?></p>
                <p class="card-text"><small class="text-body-secondary"><?= $article['prix'] ?> €</small></p>
                <p class="card-text"><small ckass="text-body-secondary"><?= $article['qteStocks'] ?> Restant</small></p>
                <a href="Modification.php?id=<?= $article['id'] ?>" class="btn btn-primary mt-2 btnModif">Modifier</a><br>
                <a href="deleteArticle.php?id=<?= $article['id'] ?>" class="btn btn-danger mt-2 btnSupp" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?');">Supprimer</a>
              </div>
            </div>
          </div>
        <?php }

        if (isset($_GET['id'])) {
          $articleId = $_GET['id'];

          // Connexion à la base de données
          $pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=strouilh_bd', 'strouilh_bd', 'strouilh_bd');

          // Récupération des données de l'article
          $sql = "SELECT * FROM Articlephp WHERE id = $articleId";
          $pdoStatement = $pdo->prepare($sql);
          $pdoStatement->execute();
          $article = $pdoStatement->fetch(PDO::FETCH_ASSOC);
        }
        ?>
      </div>
    </div>
    </main>

    <?php
    // affiche les boutons pour l'admin si il est connecter
    if (isset($_SESSION["login"])) {
      if ($_SESSION["login"] == "root" && $_SESSION["Mdp"] == "root") { ?>
        <script>
          document.getElementById("ajouarticle").style.display = "block";
          document.getElementById("editArticle").style.display = "block";
        </script>

    <?php }
    } ?>



  </body>

</html>