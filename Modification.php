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
    <form action="Modification.php" method="post" enctype="multipart/form-data">
        <p>Id Article *</p>
        <input type="text" name="idArticle" id="idArticle" placeholder="1">
        <p>Titre de l'article *</p>
        <input type="text" name="titre" id="titre" placeholder="Maillot EDF">
        <p>Description *</p>
        <input type="text" name="descriptioion" id="descriptioion" placeholder="La description de l'article">
        <p>Prix *</p>
        <input type="number" name="prix" id="prix" placeholder="200">
        <p>Image</p>
        <input type="file" name="image" id="image">
        <p>Quantitee *</p>
        <input type="text" name="Quantitee" id="Quantitee" placeholder="150">
        <input type="submit" value="envoier" name="submit">
        <p> * obligatoire</p>
    </form>
    <?php
    try {
        // Connexion à la base de données
        $pdo = new PDO('mysql:host=lakartxela.iutbayonne.univ-pau.fr;dbname=strouilh_bd', 'strouilh_bd', 'strouilh_bd');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifier que tous les champs requis sont présents
        if (isset($_POST['submit'], $_POST['titre'], $_POST['descriptioion'], $_POST['prix'], $_POST['Quantitee'])) {
            // Récupérer les valeurs POST
            $id = $_POST['idArticle'];
            $titre = $_POST['titre'];
            $description = $_POST['descriptioion'];
            $prix = $_POST['prix'];
            $quantitee = $_POST['Quantitee'];

            // Vérifier si un fichier image a été téléversé
            $url = null; // Initialiser $url
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
                // Validation du type et de la taille du fichier
                $fileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                if (in_array($fileType, $allowedTypes) && $_FILES["image"]["size"] < 2000000) { // Taille max de 2 Mo
                    // Téléverser le fichier dans le répertoire "image/"
                    $targetDir = "image/";
                    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                        // Ajouter automatiquement "image/" devant l'URL
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
                        $url = basename($_FILES["image"]["name"]);
                        pasfichier:
                    } else {



                        echo "Erreur lors du téléversement de l'image.";
                    }
                } else {
                    if (isset($_POST["submit"])) {
                        echo "Type de fichier non autorisé ou fichier trop lourd.";
                    }
                }
            }

            // Requête SQL mise à jour pour inclure qteStocks
            $sql = "UPDATE Articlephp 
                SET titre = :titre, 
                    description = :description, 
                    prix = :prix, 
                    qteStocks = :qteStocks" . ($url ? ", url = :url" : "") . " 
                WHERE id = :id";

            $req = $pdo->prepare($sql);

            // Préparation des paramètres de la requête
            $params = [
                ':titre' => $titre,
                ':description' => $description,
                ':prix' => $prix,
                ':qteStocks' => $quantitee,  // Utiliser qteStocks pour la colonne de la quantité
                ':id' => $id
            ];

            // Ajouter l'URL de l'image si elle est présente
            if ($url) {
                $params[':url'] = $url; // Ajouter l'URL à l'ensemble des paramètres
            }

            // Exécution de la requête avec les paramètres
            $req->execute($params);

            echo "L'article a été mis à jour avec succès.";
        } else {
            echo "Tous les champs requis ne sont pas présents.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
    // affiche les boutons pour l'admin si il est connecter
    if (isset($_SESSION["login"])) {
        if ($_SESSION["login"] == "root" && $_SESSION["Mdp"] == "root") { ?>
            <script>
                document.getElementById("ajouarticle").style.display = "block";
                document.getElementById("editArticle").style.display = "block";
            </script>
    <?php }
    }
    ?>
</body>

</html>