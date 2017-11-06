<?php
      session_start();
      $accept = $_POST[accept];
      $accept_explode = explode('//', $accept);
      $taskid = $accept_explode[1];
      $bidder = $accept_explode[0];

      // Connect to the database. Please change the password and dbname in the following line accordingly
      $db     = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
      $result1 = pg_query($db, "UPDATE bid SET status = 'Accepted' WHERE bidder = '$bidder' AND taskid = '$taskid' AND taskowner = '$_SESSION[user]' ");
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
<?php include 'navbar.php'; ?>

<!-- Login Section !-->
<div class="w3-container w3-light-grey" style="padding:96px" id="home">
      <h3 class="w3-center">Your received Bids for the task!</h3>
      <p><div class="container">   
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-info">
<?php 
          if(!$result1) {
            echo '<p>Bid not successful!</p> ';
          }
          else {
            echo '<p>Bid successful!</p>';
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