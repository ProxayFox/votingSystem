<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php
  //linking to layouts and adding the header
  include_once("./layouts/header.php");
  require_once("./mydb/databaseManager/DBEnter.db.php"); //meekro db connection

  /*Getting the times/data from the database*/
  $openTimeResult = DB::queryFirstRow("SELECT * FROM openTime");
  $closeTimeResult = DB::queryFirstRow("SELECT * FROM closeTime");

  /*Getting Current Time*/
  $currentDate = strtotime("now");
  /*converting the array to a readable form php*/
  $startTime = mktime(
      $openTimeResult['hour'],
      $openTimeResult['minute'],
      $openTimeResult['second'],
      $openTimeResult['month'],
      $openTimeResult['day'],
      $openTimeResult['year']
  );
  /*converting the array to a readable form to php*/
  $closeTime = mktime(
      $closeTimeResult['hour'],
      $closeTimeResult['minute'],
      $closeTimeResult['second'],
      $closeTimeResult['month'],
      $closeTimeResult['day'],
      $closeTimeResult['year']
  );

  /*Converting the mktime to a readable form for the user*/
  $actualOpenTime = date("Y/m/d h:ia", $closeTime);
  $actualCloseTime = date("Y/m/d h:ia", $closeTime);

  //Finding out if the voting is open or not
  /*Finding if current time is smaller than start time and posting when the vote will start*/
  if ($currentDate < $startTime) {
    ?>
      <div class="text-center">
        <div style="padding-top: 20%">
          <h1>Voting Opens at <?php echo $actualOpenTime; ?></h1>
        </div>
    <?php
      if ($_SESSION['username'] === "amelh0") {
    ?>
      <div style="padding-top: 10px;">
        <h5>Admin Page</h5>
        <a class="btn btn-outline-secondary w-25">Admin</a>
      </div>
      </div>
      <?php
    }
    exit;
    /*Finding out if the current time is greater than close time to display the vote has ended*/
  } elseif ($currentDate > $closeTime) {
    ?>
      <div class="text-center">
        <div style="padding-top: 20%">
          <h1>Voting Closed at <?php echo $actualCloseTime; ?></h1>
        </div>
    <?php
      if ($_SESSION['username'] === "amelh0") {
    ?>
      <div style="padding-top: 10px;">
        <h5>Admin Page</h5>
        <a class="btn btn-outline-secondary w-25">Admin</a>
      </div>
      </div>
      <?php
    }
    exit;
  }

  // checking is a SESSION user exists
  // else redirect to user login page
  if (!empty($_SESSION['username'])) {
    /*Gathering all the contestants from the database*/
    $result = DB::query("SELECT * FROM options ORDER BY RAND()");
    /*Checking how many rows there are*/
    $rowNum = DB::affectedRows();
    ?>

    <script>
      // when document is ready run script
      $( document ).ready(function() {
        <?php foreach ($result as $row) { ?>
        //checking that the numbers are between 1-10
        $("#<?php echo $row['VID']; ?>").on("change paste keydown keyup", function (event) { //run when the key is down
          setTimeout(() => { // Run this code after the event
            const val = $("#<?php echo $row['VID']; ?>");
            if (val.val() === '') return; // Empty, ignore it
            const value = parseInt(val.val()); // Try getting the number they typed

            // checking values
            if (!isNaN(value) && value >= 1 && value <= 10) { // If it is a number, and between 1 and 10
              const msg = $('#message<?php echo $row['VID']; ?>');
              msg.text("Correct Value");
              msg.removeClass("alert alert-danger");
              msg.addClass("alert alert-success");
            } else { //value is not correct so set value to NULL
              const msg = $('#message<?php echo $row['VID']; ?>');
              $(msg).text("Incorrect Value");
              $(msg).removeClass("alert alert-success");
              $(msg).addClass("alert alert-danger");
              val.val("");
            }
          }, 0);
        });
        <?php } ?>

        // checking that their is only one of each number in between 110
        $("#submitResults").click(function () {
          //assigning all the input values to an array
          const array = $(".check[name='task\\[\\]']").map(function(){
            return $(this).val();
          }).get();
          //filtering the Null values out of the string
          const nullFiltered  = array.filter(function(v){return v!== ''});
          //checking the length of the array after filtering null values
          const num1 = nullFiltered.length;
          //creating a new array
          const uniqueNames = [];
          //removing duplicated items
          $.each(nullFiltered, function(i, el){
            if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
          });
          //checking the length of the new array
          const num2 = uniqueNames.length;

          // now using the two lengths to see if their is a change in
          // length (if shorter values where duplicated and removed
          const msg = $('#submitMessage');
          if (num1 !== num2) {/*alert the user that their is a duplicate*/
            msg.text("Duplicate Items, try again.");
            msg.addClass("alert alert-danger");
          } else if (num1 === num2) {
            const array = [<?php foreach ($result as $row2) { ?>$('#<?php echo $row2['VID'] ?>').val(),<?php } ?>];
            console.log(array);
            console.log(nullFiltered);
            if (num2 === 10) { /*requires there to be 10 elements in the array*/
              const post = {};
              let vid = 1;
              let input;
              while ((input = $("#" + vid)).length !== 0) {
                if (input.val() !== '') {
                  post[input.val()] = vid;
                }
                vid++;
              }
              console.log(post);
              $.post("./mydb/pointEnter.worker.php", post,
              function (data, status) {
                const msg1 = $("#submitMessage");
                console.log(data, status);
                if (data === "Success") {
                  msg1.text("Vote Created");
                  msg1.removeClass("alert alert-danger");
                  msg1.addClass("alert alert-success");
                } else {
                  msg1.text(data);
                  msg1.removeClass("alert alert-success");
                  msg1.addClass("alert alert-danger");
                }
              })
            } else if (num2 < 10) { /*if their are more than 10 elements in the array*/
              msg.text("Not Enough Values");
              msg.addClass("alert alert-danger");
              console.log(num2);
            } else if (num2 > 10) { /*if their are less than 10 elements in the array*/
              msg.text("Too Many Values");
              msg.addClass("alert alert-danger");
              console.log(num2);
            } else {
              msg.text("error");
              msg.addClass("alert alert-danger");
              console.log(num2);
            }
          }
        });
      });
    </script>



    <main class="container">
      <div id="message"></div>
      <!-- title and information -->
      <div class="text-center" style="padding-bottom: 20px;">
        <h2>Voting</h2>
        <p>Vote 1 to 10, (1 is the best, 10 is the worst)</p>
        <small>You only give 10 people a vote</small>
      </div>
      <div class="row">
        <div class="col-md-9">
          <div class="row">
            <?php foreach ($result as $row3) { ?>
              <div class="col-md-4">
                <div class="card" style="margin-bottom: 25px;">
                  <img class="card-img-top rounded mx-auto d-block w-50" style="margin-top: 25px;" src="./img/voteIMG/<?php echo $row3['IMG']; ?>" alt="Card image cap">
                  <div class="card-body form-group">
                    <label for="<?php echo $row3['VID']; ?>" class="card-title form-control"><?php echo $row3['fName']." ".$row3['lName'] ?></label>
                    <input id="<?php echo $row3['VID']; ?>" class="w-100 form-control check" autocomplete="off" name="task[]" type="text" maxlength="2"/>
                    <div id="message<?php echo $row3['VID']; ?>" class="mx-auto d-block position-absolute" style="width: calc(100% - 40px); margin-top: 5px;"></div><!-- success message telling the user if the number is ok -->
                    <br>
                  </div>
                </div>
              </div>
            <?php }  ?>
          </div>
        </div><!-- col-md-10 end -->
        <div class="col-md-3">
          <div style="padding-top: 10px;">
            <h5>Submit your Results</h5>
            <a class="btn btn-outline-primary w-100" style="margin-bottom: 10px;" id="submitResults">Update</a>
            <div id="submitMessage"></div>
          </div>
          <?php
          if ($_SESSION['username'] === "amelh5") {
            ?>
            <div style="padding-top: 10px;">
              <h5>Admin Page</h5>
              <a class="btn btn-outline-secondary w-100">Admin</a>
            </div>
            <?php
          }
          ?>
        </div>
      </div><!-- row end -->
    </main><!-- container end -->

  <?php
  } else {
    header("Location: ./login.php?needToLogin");
  }

  //linking to layouts and opening footer
  require_once("./layouts/footer.php");
?>
