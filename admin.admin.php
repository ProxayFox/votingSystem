<?php
  if ($_SESSION['username'] === "ämelh0") {
    include_once("./layouts/header.php");
    require_once("./mydb/databaseManager/DBEnter.db.php"); //meekro db connection
    ?>


    <?php
  } else {
    header("Location: index.php");
  }