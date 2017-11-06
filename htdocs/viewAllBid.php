  <?php
      session_start();
      // Connect to the database. Please change the password and dbname in the following line accordingly
          $db     = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
          $result = pg_query($db, "SELECT * FROM bid WHERE taskid = '$_POST[taskid]' AND taskowner = '$_POST[user]'");
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
<?php include 'navbar.php';?>

<!-- Login Section !-->
<div class="w3-container w3-light-grey" style="padding:96px" id="home">
      <h3 class="w3-center">All Bids for the task!</h3>
      <p><div class="container">   
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-info">

<?php 
          if(!$result) {
            echo '<p>There is no bids for this task in the database!</p> </div> </div> </div>';
          } else {
        $index = 1;
        echo '
      <table style = "width:100%">
          <tr>
          <th>S/N</th>
          <th>Owner</th>
          <th>Bidder</th>
          <th>Status</th>
          <th>Bid Amount</th>
          <th>Bid Date</th>
          <th>Edit</th>
          <th>Delete</th>
          </tr>';
            while($row = pg_fetch_assoc($result)) {   //Creates a loop to loop through results
        echo '<tr>
        <th>'.$index.'</th>
        <th>'.$row["taskowner"].'</th>
        <th>'.$row["bidder"].'</th>
        <th>'.$row["status"].'</th>
        <th>'.$row["biddate"].'</th>
        <th>'.$row["bidamt"].'</th>
        <th>
        <form action="editBid.php" method="POST" >
        <input type = "hidden" name = "bidder" value = "'.$row["bidder"].'" />
          <input type = "hidden" name = "taskid" value = "'.$row["taskid"].'" />
            <button class="w3-button w3-white w3-border w3-border-blue" type="submit" name = "accept">
                <i class=" "></i> Edit bid!
            </button>
        </form>
        </th>
        <th>
          <form action="deleteBid.php" method="POST" >
            <button class="w3-button w3-white w3-border w3-border-blue" type="submit" name = "accept" value = "'.$row["bidder"]. "//" .$row["taskid"].'">
                <i class=" "></i> Delete bid!
            </button>
        </form>
        </th>
          </tr>';
          $index++;
      }
    echo '</table>';
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
<?php include 'footer.html';?>
