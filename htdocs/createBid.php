<?php
session_start();
    // Connect to the database. Please change the password and dbname in the following line accordingly
        $curruser = $_SESSION["user"]; //Person that wants to bid
        $taskcreator = $_POST["user"]; // Task owner
        $taskid = $_POST["taskid"];
        $price = $_POST["price"];

        $db     = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
        $result = pg_query($db, "SELECT * FROM task WHERE taskID = '$taskid' AND userName = '$taskcreator'");
        $row = pg_fetch_assoc($result);
        date_default_timezone_set('Asia/Singapore');
        $date = date("Y/m/d");
        $enddate = $row[enddate];
        $enddate = date('Y/m/d', strtotime(str_replace('/','-', $enddate)));

        if (isset($_POST['bid'])) { 

          if ($price <= $_POST[amount]){
              $delResult = pg_query($db, "DELETE FROM bid WHERE bidder = '$curruser' AND taskid = '$_POST[task]'"); //remove duplicates for a specific task as 1 user can only bid once for each task

              $command = "INSERT INTO bid (taskID,bidder,taskOwner,status,bidDate,bidAmt)
              VALUES('$_POST[task]','$_SESSION[user]','$_POST[tasker]','Pending', '$date', '$_POST[amount]')";
              $check = pg_query($db, $command);
              if($check) 
                  echo "<script> alert('Bid successful!'); </script>";
              else {
                  echo "<script>
                    var bidder = '$_SESSION[user]';
                    var taskowner = '$_POST[tasker]'; 
                    if (bidder == taskowner)
                      alert('You cannot bid for your own task!');
                    else
                      alert('Bid unsuccessful!'); 
                  </script>";    
              }  
            } else {
                echo "<script>
                  alert('Bid a price higher than the stated price');
                  </script>";
            }
        }
         
      ?> 

      <!DOCTYPE html>
      <html>
      <title>CS2102 Assignment</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <style>
        body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}
        body, html {
          height: 100%;
          line-height: 1.8;
        }
        .w3-bar .w3-button {
          padding: 20px;
        }
      </style>
      <body>

        <!-- Navbar (sit on top) -->
        <?php 
        include 'navbar.php';
        ?>

        <!-- Login Section !-->
        <div class="w3-container w3-light-grey" style="padding:96px" id="home">
          <h3 class="w3-center">Bid for Task!</h3>
          <p><div class="container">   
            <div class="row">
              <div class="col-sm-12">
                <div class="panel panel-info">
                  <div class="panel-heading" align="center"><b> <?php echo $row["title"]; ?></b></div>
                  <div class="panel-body" align = "center">
                    TaskID : <?php echo $taskid; ?></br>
                    Creator: <?php echo $row["username"]; ?></br>
                    Type: <?php echo $row["type"]; ?></br>
                    Start Date: <?php echo $row["startdate"]; ?></br>
                    Start Time: <?php echo $row["starttime"]; ?></br>
                    End Date: <?php echo $row["enddate"]; ?></br>
                    End Time: <?php echo $row["endtime"]; ?></br>
                    Price: $<?php echo $row["price"]; ?></br>
                    Description: <?php echo $row["description"]; ?></br></br>
                    <?php 
                    $highestBid = pg_query($db, "SELECT bidamt FROM bid WHERE taskid=$taskid AND taskowner='$taskcreator' AND bidamt >= ALL(SELECT bidamt FROM bid WHERE taskid=$taskid AND taskowner='$taskcreator')");
                    $row = pg_fetch_assoc($highestBid);
                    $highest = $row["bidamt"];
                    if ($highest=="")
                      $highest = 0;
                    ?>
                    Current highest bid is <b><?php echo "$" . $highest ?></b>
                  </div>
                </div>
              </div>
            </div>
          </div></p>
          <div class="w3-row-padding" style="margin-top:64px padding:128px 16px">
            <div class="w3-content" align="center">
              <form action="createBid.php" method="POST" >
                <p><input type="hidden" name="task" value = "<?php echo $taskid ?>"></p>
                <p><input type="hidden" name="tasker" value = "<?php echo $taskcreator ?>"></p>
                <p><input type="hidden" name="price" value = "<?php echo $price ?>"></p>
                <?php
                  if ($enddate > $date) { 
                     echo "<p><input class=\"w3-input w3-border\" type=\"number\" placeholder=\"Amount\" name=\"amount\"></p>
                           <p>
                             <button class=\"w3-button w3-white w3-border w3-border-blue\" type=\"submit\" name = \"bid\">
                               <i class=\" \"></i> BID
                             </button>
                           </p>";
                  } else {
                    echo "Task is not available for bidding.";
                  }
                ?>
              </form>
            <?php echo $echo1; ?>
            </div>
          </div>
        </div>  
      </body>

      <!-- Footer -->
      <?php
      include 'footer.html';
      ?>
