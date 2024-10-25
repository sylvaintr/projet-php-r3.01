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
  <?php



  ?>
  <main class="container">
    <form action="Payement.php" method="post">
      <div class="form-group mt-2">
        <label for="formGroupExampleInput"> quelle est votre numro de catre</label>
        <input type="text" class="form-control" name="numcatre" id="numcatre">
      </div>
      <div class="form-group mt-2">
        <label for="formGroupExampleInput"> quelle est la date d'expiration </label>
        <input type="date" class="form-control" name="dateexpeiration" id="dateexpeiration">
      </div>
      <div class="form-group mt-2">
        <label for="formGroupExampleInput"> quelle est le cryptogramme </label>
        <input type="text" class="form-control" name="numCrypto" id="numCrypto">
      </div>
      <input type="submit" class="btn btn-primary mt-2" value="envoyer">
    </form>
    <?php
    $pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=strouilh_bd', 'strouilh_bd', 'strouilh_bd');
    if (isset($_POST["numcatre"])) {
      $_POST["numcatre"] = str_replace(' ', '', $_POST["numcatre"]);
      $_POST["numCrypto"] = str_replace(' ', '', $_POST["numCrypto"]);
      // verifier si les champs sont bien remplis pour le payement
      if (strlen($_POST["numcatre"]) == 16 && strlen($_POST["numCrypto"]) == 3 && strtotime($_POST["dateexpeiration"]) - strtotime(date('Y-m-d')) >= 7776000) {
        // Retirer qte depuis bd
        foreach ($_SESSION["panier"] as $articleId => $quantitee) {
          $sql = "UPDATE Articlephp SET qteStocks = qteStocks - $quantitee WHERE id = $articleId";
          $req = $pdo->prepare($sql);
          $req->execute();
        }


        print "merci de votre achat";
        $_SESSION["panier"] = array();
      } else {

        if ($_POST["numcatre"] != 16 || strtotime($_POST["dateexpeiration"]) - strtotime(date('Y-m-d')) < 7776000) {
          print "pas ok veuiller ressayer <br>";
        }
      }
    }

    ?>
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