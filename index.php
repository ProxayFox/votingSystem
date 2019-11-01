<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php

  $currentDate = strtotime("now");
  $startTime = strtotime("Thu Sep 05 2019 10:00:00 GMT+1000");
  $closeTime = strtotime("Thu Sep 10 2019 15:00:00 GMT+1000");
  //linking to layouts and adding the header
  include_once("./layouts/header.php");
  require_once("./mydb/databaseManager/DBEnter.db.php"); //meekro db connection

  if ($currentDate < $startTime) {
    ?>
      <div style="padding-top: 20%">
        <h1 class="text-center">Voting opens at 10am</h1>
      </div>
    <?php
    exit;
  }

  if ($currentDate > $closeTime) {
    ?>
    <div style="padding-top: 20%">
      <h1 class="text-center">Voting Closed</h1>
    </div>
    <?php
    exit;
  }


  if (!empty($_SESSION['username'])) {
    $result = DB::query("SELECT * FROM students ORDER BY RAND()");
    $rowNum = DB::affectedRows();
    ?>

    <script>
      $( document ).ready(function() {
        <?php foreach ($result as $row) { ?>
        //checking that the numbers are between 1-10
        $("#<?php echo $row['SID']; ?>").on("change paste keydown keyup", function (event) { //run when the key is down
          setTimeout(() => { // Run this code after the event
            const val = $("#<?php echo $row['SID']; ?>");
            if (val.val() === '') return; // Empty, ignore it
            const value = parseInt(val.val()); // Try getting the number they typed

            //checking that the user is not copying in or something funny/not right
            //if ($.inArray(event.keyCode, [49, 50, 51, 52, 53, 54, 55, 56, 57, 48, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 8, 46]) !== -1) {
            //value is correct
            // giving the user a message if the number is correct
            if (!isNaN(value) && value >= 1 && value <= 10) { // If it is a number, and between 1 and 10
              const msg = $('#message<?php echo $row['SID']; ?>');
              msg.text("Correct Value");
              msg.removeClass("alert alert-danger");
              msg.addClass("alert alert-success");
            } else { //value is not correct so set value to NULL
              const msg = $('#message<?php echo $row['SID']; ?>');
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
            const array = [<?php foreach ($result as $row2) { ?>$('#<?php echo $row2['SID'] ?>').val(),<?php } ?>];
            console.log(array);
            console.log(nullFiltered);










            if (num2 === 10) { /*requires there to be 10 elements in the array*/
              var post = {};
              var sid = 1;
              var input;
              while ((input = $("#" + sid)).length !== 0) {
                if (input.val() !== '') {
                  post[input.val()] = sid;
                }
                sid++;
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
                  <img class="card-img-top rounded mx-auto d-block w-50" style="margin-top: 25px;" src="img/studentIMG/<?php echo $row3['IMG']; ?>" alt="Card image cap">
                  <div class="card-body form-group">
                    <label for="<?php echo $row3['SID']; ?>" class="card-title form-control"><?php echo $row3['fName']." ".$row3['lName'] ?></label>
                    <input id="<?php echo $row3['SID']; ?>" class="w-100 form-control check" autocomplete="off" name="task[]" type="text" maxlength="2"/>
                    <div id="message<?php echo $row3['SID']; ?>" class="mx-auto d-block position-absolute" style="width: calc(100% - 40px); margin-top: 5px;"></div><!-- success message telling the user if the number is ok -->
                    <br>
                  </div>
                </div>
              </div>
            <?php }  ?>
          </div>
        </div><!-- col-md-10 end -->
        <div class="col-md-3">
          <div style="padding-top: 10px;">
            <h5 class="">Submit your Results</h5>
            <a class="btn btn-outline-primary w-100" style="margin-bottom: 10px;" id="submitResults">Update</a>
            <div id="submitMessage"></div>
          </div>
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
