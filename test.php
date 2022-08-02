<?php
session_start();
if (isset($_SESSION["pseudo"])) {
    echo "le variable de session existe:". $_SESSION["pseudo"];
}
else {
    echo "Lvariable de session n'est pas disponible";
    
}

?>