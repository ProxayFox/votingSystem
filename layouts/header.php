<!DOCTYPE html>
<html lang="en">
<head>
  <?php
  session_start();
  $_SESSION['username'] = 'amelh0'; //fake session for the example
  ?>
  <title>Voting System</title>
  <link rel="icon" href="img/cavlogo.jpeg">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- JQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="./js/popper.js"></script>
  <script src="./js/tooltip.js"></script>
</head>
<body>
  <!-- Top section of the page -->
  <header class="w-100">
    <nav class="row" style="background-color: #26A7BC; height: 76px;">
      <div class="col-1 text-center">
        <div  style="padding-top: 12px; padding-bottom: 12px;">
          <a href="index.php"><img src="img/cavlogo.png" alt="Cav Road logo, will also take you to home page" style="width: 50px;"></a>
        </div><!-- alignment end -->
      </div><!-- col-1 end -->
      <div class="col-11" style="padding-top: 18px;">
        <h4 class="">Welcome <?php echo $_SESSION['username']; ?></h4>
      </div><!-- col-11 end -->
    </nav><!-- row end -->
  </header><!-- Top section end -->