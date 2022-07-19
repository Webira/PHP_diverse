<?php
    //  Code PHP
    require_once("init.php");

    if(isset($_GET["id_logement"])) {
        $stmt = $pdo->query("SELECT * FROM logement WHERE id_logement = '$_GET[id_logement]' "); // PDO STATEMENT
        $logement = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    require_once("haut_de_page.php");
?>

<!-- BODY -->

<div class="card" style="width: 18rem;">
  <img src="<?php echo $logement["photo"]; ?>" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title"><?php echo $logement["titre"]; ?></h5>
    <p class="card-text"><?php echo $logement["description"]; ?></p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><?php echo $logement["adresse"]; ?></li>
    <li class="list-group-item"><?php echo $logement["ville"] . " " . $logement["cp"]; ?></li>
  </ul>
  <div class="card-body">
    <a href="#" class="card-link"><?php echo "Surface : " . $logement["surface"]; ?></a>
    <a href="#" class="card-link"><?php echo "Prix : " . $logement["prix"]; ?></a>
  </div>
</div>

<?php
    //  Code PHP
    require_once("bas_de_page.php");
?>

