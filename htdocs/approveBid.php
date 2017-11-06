<?php
      session_start();
      $_POST['taskid'] = $_POST['Display'];
      // Connect to the database. Please change the password and dbname in the following line accordingly
          $db     = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
          $result = pg_query($db, "SELECT * FROM bid WHERE taskid = '$_POST[taskid]' AND taskowner = '$_SESSION[user]'");
?>
<!DOCTYPE html>
<html>
<title>CS2102 Assignment</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
<?php include 'navbar.php'; ?>

<!-- Login Section !-->
<div class="w3-container w3-light-grey" style="padding:96px" id="home">
      <h3 class="w3-center">Your received Bids for the task!</h3>
      <p><div class="container">   
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-info">
<?php 

            while($row = pg_fetch_assoc($result)){   //Creates a loop to loop through results
  
            echo '<div class="panel-heading"><b>'.$row["title"].'</b></div>
            <div class="panel-body">
              Bidder: '.$row["bidder"]. '</br>
              Status: '.$row["status"]. '</br>
              Bid Amount: '.$row["bidamt"]. '</br>
              Bid Date: '.$row["biddate"]. '</br>
            </div>
    <div class="w3-row-padding" style="margin-top:64px padding:128px 16px">
      <div class="w3-content" align="center">
        <form action="acceptBid.php" method="POST" >
            <button class="w3-button w3-white w3-border w3-border-blue" type="submit" name = "accept" value = "'.$row["bidder"]. "//" .$row["taskid"].'">
                <i class=" "></i> Accept bid!
            </button>
        </form>
      </div>
    </div>';
            }
?>
        </div>
      </div>
    </div>
    </div>
  </p>
  </div>

</body>

<!-- Footer -->
<?php include 'footer.html'; ?>