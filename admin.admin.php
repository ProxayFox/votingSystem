<?php
  if ($_SESSION['username'] == "amelh0") {
    include_once("./layouts/header.php");
    require_once("./mydb/databaseManager/DBEnter.db.php"); //meekro db connection
    ?>

      <h1>you gay</h1>

    <?php
  } else {
    header("Location: index.php?notAllowed");
    exit;
  }