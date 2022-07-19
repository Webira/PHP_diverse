<?php
    //  Code PHP
    require_once("init.php");

    if($_POST) {

        
        // GESTION DES ERREURS

        $erreur = "";

        if(empty($_POST["titre"])) {
            $erreur .= "<div class='alert alert-danger' role='alert'>
            Le titre est obligatoire !
          </div>";
        }

        if(empty($_POST["adresse"])) {
            $erreur .= "<div class='alert alert-danger' role='alert'>
            L'adresse est obligatoire !
          </div>";
        }

        if(empty($_POST["ville"])) {
            $erreur .= "<div class='alert alert-danger' role='alert'>
            La ville est obligatoire !
          </div>";
        }

        if(empty($_POST["cp"])) {
            $erreur .= "<div class='alert alert-danger' role='alert'>
            Le code postal est obligatoire !
          </div>";
        }

        if(!is_numeric($_POST["cp"]) || strlen($_POST["cp"]) < 4) {
            $erreur .= "<div class='alert alert-danger' role='alert'>
            Veuillez renseigner un code postal à 4 chiffres !
          </div>";
        }

        if(empty($_POST["surface"])) {
            $erreur .= "<div class='alert alert-danger' role='alert'>
            La sufrace est obligatoire !
          </div>";
        }

        if(!ctype_digit($_POST["surface"])) {
            $erreur .= "<div class='alert alert-warning' role='alert'>
            Veuillez-renseigner un chiffre entier pour la surface !
          </div>";
        }

        if(empty($_POST["prix"])) {
            $erreur .= "<div class='alert alert-danger' role='alert'>
            Le prix est obligatoire !
          </div>";
        }

        if(!ctype_digit($_POST["prix"])) {
            $erreur .= "<div class='alert alert-warning' role='alert'>
            Veuillez-renseigner un chiffre entier pour le prix !
          </div>";
        }

        // Photo

        // echo '<pre>';
        // var_dump($_FILES);
        // echo '</pre>';

        // echo $_POST["titre"];

        // EXTENSION
        $extensions = [".png", ".jpg", ".jpeg"];
        $extension = strrchr($_FILES["photo"]["name"], ".");

        if(!in_array($extension, $extensions)) {
            $erreur .= "<div class='alert alert-warning' role='alert'>
            Veuillez uploader un fichier au bon format (png, jpg, jpeg) !
            </div>";
        }

        $maxSize = 1000000;
        if($_FILES["photo"]["size"] > $maxSize) {
            $erreur .= "<div class='alert alert-warning' role='alert'>
            Veuillez uploader une image moins lourde (1Mo max)
            </div>";
        }

        $content .= $erreur;

        if(empty($erreur)) {

            if(isset($_FILES) && !empty($_FILES["photo"]["name"])) {

                // nom de la photo
                // $pictureName = $_FILES["photo"]["name"];
                $pictureName = "logement_" . time(). $extension;

                // copier le chemin vers le serveur en BDD
                $pathPhotoDB = URL . "photo/" . $pictureName;
    
                // echo $pathPhotoDB . "<br>";
    
                // copier sur le serveur
                $pathFolder = RACINE_SITE . "photo/" . $pictureName;
    
                // echo $pathFolder;
    
                copy($_FILES["photo"]["tmp_name"], $pathFolder);
    
            }

            $count = $pdo->exec("INSERT INTO logement (titre, adresse, ville, cp, surface, prix, photo, type, description)
            VALUES(
                '$_POST[titre]',
                '$_POST[adresse]',
                '$_POST[ville]',
                '$_POST[cp]',
                '$_POST[surface]',
                '$_POST[prix]',
                '$pathPhotoDB',
                '$_POST[type]',
                '$_POST[description]'
            )");
    
            if($count > 0) {
                $content = "<div class='alert alert-success' role='alert'>
                    Votre logement a bien été inséré !
                </div>";
            }

        }

    }

    $titre = (!empty($_POST["titre"]) ? $_POST["titre"] : "");
    $adresse = (!empty($_POST["adresse"]) ? $_POST["adresse"] : "");
    $ville = (!empty($_POST["ville"]) ? $_POST["ville"] : "");
    $cp = (!empty($_POST["cp"]) ? $_POST["cp"] : "");
    $surface = (!empty($_POST["surface"]) ? $_POST["surface"] : "");
    $prix = (!empty($_POST["prix"]) ? $_POST["prix"] : "");
    $description = (!empty($_POST["description"]) ? $_POST["description"] : "");

    require_once("haut_de_page.php");
?>

<h2>Ajouter un logement</h2> 

<?php echo $content; ?>

<form class="col-md-12 d-flex flex-wrap" method="POST" enctype="multipart/form-data">

    <div class="form-group col-md-6">
        <label for="titre">Titre</label>
        <input type="text" class="form-control" name="titre" id="titre" aria-describedby="titre" placeholder="Entrer un titre" value="<?php echo $titre; ?>">
    </div>

    <div class="form-group col-md-6">
        <label for="adresse">Adresse</label>
        <input type="text" class="form-control" name="adresse" id="adresse" aria-describedby="adresse" placeholder="Entrer une adresse" value="<?php echo $adresse; ?>">
    </div>

    <div class="form-group col-md-6">
        <label for="ville">Ville</label>
        <input type="text" class="form-control" name="ville" id="ville" aria-describedby="ville" placeholder="Entrer une ville" value="<?php echo $ville; ?>">
    </div>

    <div class="form-group col-md-6">
        <label for="cp">Code Postal</label>
        <input type="tel" class="form-control" name="cp" id="cp" aria-describedby="cp" placeholder="Entrer une code postal" value="<?php echo $cp; ?>">
    </div>

    <div class="form-group col-md-6">
        <label for="surface">Surface</label>
        <input type="tel" class="form-control" name="surface" id="surface" aria-describedby="surface" placeholder="Entrer une Surface" value="<?php echo $surface; ?>">
    </div>

    <div class="form-group col-md-6">
        <label for="prix">Prix</label>
        <input type="tel" class="form-control" name="prix" id="prix" aria-describedby="prix" placeholder="Entrer un prix" value="<?php echo $prix; ?>">
    </div>

    <div class="form-group col-md-6">
        <label for="prix">Photo</label>
        <div class="w-100"></div>
        <input type="file" name="photo">
    </div>

    <div class="form-group col-md-6">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="type" id="location" value="location" checked>
            <label class="form-check-label" for="location"> Location </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="type" id="vente" value="vente">
            <label class="form-check-label" for="vente"> Vente </label>
        </div>
    </div>

    <div class="form-group col-md-6">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" id="exampleFormControlTextarea1" rows="3"><?php echo $description; ?></textarea>
    </div>

    <div class="form-group col-md-12">
        <button type="submit" class="btn btn-primary">Ajouter un logement</button>
    </div>
</form>

<?php
    //  Code PHP
    require_once("bas_de_page.php");
?>

