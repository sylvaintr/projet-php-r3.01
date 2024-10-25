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
    if (isset($_GET['id'])) {
      $articleId = $_GET['id'];

      try {

        $pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=strouilh_bd', 'strouilh_bd', 'strouilh_bd');

        // Préparer et exécuter la requête de suppression
        $sql = "DELETE FROM Articlephp WHERE id = :id";
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindParam(':id', $articleId, PDO::PARAM_INT);
        $pdoStatement->execute();
        print("zevhlzgzegfvzekiufgzeaiufgzefiyzegfz");
        echo ("<meta http-equiv=\"refresh\" content=\"0;url=EditArticle.php\" />");




        exit;
      } catch (PDOException $e) {
        // En cas d'erreur
        echo "Erreur : " . $e->getMessage();
      }
    }
    ?>
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