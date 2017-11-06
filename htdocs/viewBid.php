  <?php
      session_start();
          $db     = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
          $result = pg_query($db, "SELECT * FROM bid WHERE bidder = '$_SESSION[user]'");
  ?> 

<!DOCTYPE html>
<html>
<title>CS2102 Assignment</title>
<meta charset="utf-8">
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

.button-container form,
.button-container form div {
    display: inline;
}

.button-container button {
    display: inline;
    vertical-align: middle;
}
</style>
<body>

<!-- Navbar (sit on top) -->
<?php include 'navbar.php'; ?>
<!-- Login Section !-->
<div class="w3-container w3-light-grey" style="padding:96px" id="home">
      <h3 class="w3-center">Your Bids!</h3>
      <p><div class="container">   
      <div class="row">
        <div class="col-sm-12">

<?php 
          if(!$result) {
            echo '<p>You have no bid!</p>';
          }
            while($row = pg_fetch_assoc($result)){   //Creates a loop to loop through results
              $taskTitleQuery = "SELECT t.title FROM task t WHERE t.taskid = '$row[taskid]' AND t.username = '$row[taskowner]'";
              $taskTitle = pg_query($db, $taskTitleQuery);
              $taskTableResults = pg_fetch_assoc($taskTitle);

              if ($row[status] == 'Pending') {
                echo '<div class="panel panel-info">
                        <div class="panel-heading"><b>'.$taskTableResults["title"].'</b></div>
                        <div class="panel-body">
                          Tasker: '.$row["taskowner"]. '</br>
                          Status: '.$row["status"]. '</br>
                          Bid Date: '.$row["biddate"]. '</br>
                          Bid Amount: $'.$row["bidamt"]. '</br></br>
                        </div>
                      </div>';
              } else if ($row[status] == 'Accepted') {
                echo '<div class="panel panel-success">
                      <div class="panel-heading"><b>'.$taskTableResults["title"].'</b></div>
                      <div class="panel-body">
                        Tasker: '.$row["taskowner"]. '</br>
                        Status: '.$row["status"]. '</br>
                        Bid Date: '.$row["biddate"]. '</br>
                        Bid Amount: $'.$row["bidamt"]. '</br></br>
                      </div>
                    </div>';
              } else {
                echo '<div class="panel panel-danger">
                        <div class="panel-heading"><b>'.$taskTableResults["title"].'</b></div>
                        <div class="panel-body">
                          Tasker: '.$row["taskowner"]. '</br>
                          Status: '.$row["status"]. '</br>
                          Bid Date: '.$row["biddate"]. '</br>
                          Bid Amount: $'.$row["bidamt"]. '</br></br>
                        </div>
                      </div>';
              }
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
