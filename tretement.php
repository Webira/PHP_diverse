<?php
session_start();
if (isset($_post["pseudo"])){
   $_SESSION["pseudo"] = $_post["pseudo"];

}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Variables de session</title>
</head>
<body>
    <?php
    if(isset($_SESSION["pseudo"])) {
        echo "Bienvenue".$_SESSION["pseudo"];
    }
    else {
        echo "vous n'etes pas connecte...";
    }
    ?>

    <p><a href="http://localhost/PHP-dev.php">Tester la variable de session</a></p>
    </body>
</html>    