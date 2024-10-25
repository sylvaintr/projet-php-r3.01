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
  <form action="ajouterArticle.php" method="post" enctype="multipart/form-data">
    <p>titre de l'article</p>
    <input type="text" name="titre" id="titre">
    <p>descriptioion</p>
    <input type="text" name="descriptioion" id="descriptioion">
    <p>prix </p>
    <input type="number" name="prix" id="prix">
    <p>image</p>
    <input type="file" name="image" id="image">
    <p>Quantitee</p>
    <input type="number" name="quantitee" id="quantitee"><br> <br>
    <input type="submit" value="envoier" name="submit">
  </form>

  <?php
  if (isset($_POST["submit"])) {

    // Téléverse et copie immédiatement le fichier dans un dossier
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "image/" . basename($_FILES["image"]["name"]))) {
      $imageFileType = strtolower(pathinfo("image/" . basename($_FILES["image"]["name"]), PATHINFO_EXTENSION));
      switch ($imageFileType) {
        case "jpg":
          imagejpeg(imagecreatefromjpeg("image/" . basename($_FILES["image"]["name"])), "image/M" . basename($_FILES["image"]["name"]), 2);
          break;
        case "jpeg":
          imagejpeg(imagecreatefromjpeg("image/" . basename($_FILES["image"]["name"])), "image/M" . basename($_FILES["image"]["name"]), 2);
          break;
        case "png":
          imagejpeg(imagecreatefrompng("image/" . basename($_FILES["image"]["name"])), "image/M" . basename($_FILES["image"]["name"]), 2);
          break;
        case "gif":
          imagejpeg(imagecreatefromgif("image/" . basename($_FILES["image"]["name"])), "image/M" . basename($_FILES["image"]["name"]), 2);

          break;
        case "webp":
          imagejpeg(imagecreatefromwebp("image/" . basename($_FILES["image"]["name"])), "image/M" . basename($_FILES["image"]["name"]), 2);
          break;
        default:
          unlink("image/" . basename($_FILES["image"]["name"]));
          print "Le fichier n'est pas une image";
          goto pasfichier;
          break;
      }

      echo "Le fichier " . basename($_FILES["image"]["name"]) . " a été téléversé.";
      //Connexion à la base de données en pdo
      $pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=strouilh_bd', 'strouilh_bd', 'strouilh_bd');
      //choisi l'id 
      $sql = "SELECT max(id) AS max FROM Articlephp";
      $pdoStatement = $pdo->prepare($sql);
      $pdoStatement->execute();
      $id = $pdoStatement->fetch(PDO::FETCH_ASSOC);
      // requete pour ajouter un article
      $sqlinsetion2 = "INSERT INTO Articlephp (`id`, `titre`, `description`, `prix`, `url`, `qteStocks`)  VALUES ( " . ($id['max'] + 1) . ", '" . $_POST['titre'] . "','" . $_POST['descriptioion'] . "'," . $_POST['prix'] . ",'" . basename($_FILES["image"]["name"]) . "'," . $_POST['quantitee'] . ") ";
      $pdoStatement2 = $pdo->exec($sqlinsetion2);


      pasfichier:
    } else {
      echo "Désolé, une erreur s'est produite en téléversant le fichier.";
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