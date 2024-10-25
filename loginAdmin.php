<?php

  session_start();


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
              <a class="nav-link" aria-current="page" href="Panier.php">panier</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active " href="loginAdmin.php">loginadmine</a>
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
      <FORM ACTION="loginAdmin.php" METHOD="POST">
        <p>Login : </p>
        <INPUT TYPE="TEXT" NAME="Login" SIZE="20" MAXSIZE="50"><BR>
        <p>Mot de passe : </p>
        <INPUT TYPE="password" NAME="Mdp" SIZE="20" MAXSIZE="50"><BR>
        <br>
        <INPUT TYPE="SUBMIT" VALUE="Valider">
    </FORM>
<?php


// Logins DEBILES pour se login ADMIN
$loginAdmin = "root";
$mdpAdmin = "root";

if(isset($_POST["Login"])) {
if ($_POST["Login"] == $loginAdmin && $_POST["Mdp"] == $mdpAdmin) {
  print "login correcte";
  $_SESSION["login"] = $_POST["Login"];
  $_SESSION["Mdp"] = $_POST["Mdp"];

  
  
}
else{
  if ($_POST["Login"] != "" && $_POST["Mdp"] != "") {
    print "login incorrecte";
  }
  print "login incorrecte";
} 
}



if(isset($_SESSION["login"])) {
  if ($_SESSION["login"] == "root" && $_SESSION["Mdp"] == "root") { ?>
          <script>
            document.getElementById("ajouarticle").style.display ="block";
            document.getElementById("editArticle").style.display ="block";
          </script>
          
        <?php }} ?>
</body>
</html>