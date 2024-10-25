<?php session_start();


?>

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
        <a class="navbar-brand" href="index.php">NBO Stare</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="Panier.php">panier</a>
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



  <main class="container">

    <?php
    if (isset($_POST["retire"])) {
      if (isset($_SESSION["panier"][$_POST["retire"]]) && $_SESSION["panier"][$_POST["retire"]] != 1) {

        $_SESSION["panier"][$_POST["retire"]]  = $_SESSION["panier"][$_POST["retire"]] - 1;
      } else {
        unset($_SESSION["panier"][$_POST["retire"]]);
      }
    }
    if (isset($_SESSION["panier"]) && count($_SESSION["panier"])  != 0) {

      $pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=strouilh_bd', 'strouilh_bd', 'strouilh_bd');



      // creation de la table pour afficher les articles mi dans le pannier
      print "<h2 class='mr-auto'> votre commande </h2> <table class =' table table-striped table-hover'>
  <tr>
    <th>nom </th>
    <th>description</th>
    <th>prix unitaire</th>
    <th>qantite</th>
    <th>prix total</th>
    <th></th>
  </tr>";
      $prixtautal = 0;
      // affiche les articles mi dans le pannier 
      foreach ($_SESSION["panier"] as $key  => $value) {
        $pdoStatement = $pdo->prepare("SELECT * FROM Articlephp WHERE id=$key");
        $pdoStatement->execute();
        $articles = $pdoStatement->fetch(PDO::FETCH_ASSOC);
        print "<tr>
    <td>" . $articles["titre"] . "</td>
    <td>" . $articles["description"] . "</td>
    <td>" . $articles["prix"] . "</td>
    <td>$value</td>
    <td>" . $value * $articles["prix"] . "</td>
    <td> <form action=Panier.php method=post>
    <input type=text name=retire value = " . $articles['id'] . "  style='display: none'>
    <input type=submit value='retire un'> </form></td>
  </tr>";
        $prixtautal = $prixtautal + $value * $articles["prix"];
      }
      // affiche le prix total
      print " <tr>
  <td>prix totale</td>
  <td></td>
  <td></td>
  <td></td>
  <td>$prixtautal</td>
  <td></td>
</tr> </table>";
    } else {
      print "<H2><center><p> le panier est vide  </p></center></H2>"; ?>

      <script>
        // cache le bouton payer si le panier est vide
        window.onload = function() {
          document.getElementById("payer").style.display = "none"
        };
      </script> <?php
              }



                ?>

    <a href="http://lakartxela.iutbayonne.univ-pau.fr/~strouilh/ptojetphp/Payement.php" class="btn btn-primary mr-auto" id="payer"> payer</a>


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
</body>

</html>