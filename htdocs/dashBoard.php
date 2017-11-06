<!DOCTYPE html>
<?php
	session_start();
  $db = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
  $curUser = $_SESSION["user"];
?>
<html>
<title>CS2102 Assignment</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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

 /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
 .row.content {height: 550px}
 
 /* Set gray background color and 100% height */
 .sidenav {
   background-color: #f1f1f1;
   height: 100%;
 }
     
 /* On small screens, set height to 'auto' for the grid */
 @media screen and (max-width: 767px) {
   .row.content {height: auto;} 
 }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<body>


<?php 
    include 'navbar.php'; //What is this? echo $echo;
?> 

<div class="container-fluid w3-container w3-light-grey" style="padding:96px" id="home">
  <div class="row content">
    <div class="col-sm-3 sidenav hidden-xs">
      <h2>Welcome <?php echo $_SESSION["user"]; ?></h2>
	        <ul class="nav nav-pills nav-stacked">
			<li class="active"><a href="#section1">Dashboard</a></li>
	  <?php
	  if(isset($_SESSION['isAdmin'])) {
		  echo '<li><a href="createTask.php">Create new task</a></li>';
			echo '<li><a href="viewAllTasks.php">View All Tasks</a></li>';
			echo '<li><a href="changePass.php">Change password</a></li>';
			echo '<li><a href="logout.php">Logout</a></li>';
	  } else {

			echo '<li><a href="createTask.php">Create new task</a></li>';
			echo '<li><a href="viewTask.php">View your tasks</a></li>';
      			echo '<li><a href="viewBid.php">View your bids</a></li>';
			echo '<li><a href="changePass.php">Change password</a></li>';
			echo '<li><a href="logout.php">Logout</a></li>';
		}
	  ?>
      </ul><br>
    </div>
    <br>
    
    <div class="col-sm-9">
      <div class="well">
        <h4>Upcoming tasks</h4>
        <table class="table table-hover">
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Start Time</th>
            <th>End Time</th>
          </tr>
          <tbody>
            <?php 
              $result = pg_query($db, "SELECT * FROM task t
                WHERE (t.startDate >= date_trunc('week', CURRENT_TIMESTAMP)
                AND t.startDate < date_trunc('week', CURRENT_TIMESTAMP + interval '1 week')
                AND t.username = '$curUser')"); //query for upcoming tasks for the week
  
              if (pg_num_rows($result) > 0) {
  
                while($row = pg_fetch_array($result)) {
                  echo "<tr> ".
                          "<td> ". $row["title"]. " </td>".
                          "<td> ". $row["description"]. " </td>". 
                          "<td> ". $row["startdate"]. " </td>".
                          "<td> ". $row["enddate"].  "</td>".
                          "<td> ". $row["starttime"]. " </td>".
                          "<td> ". $row["endtime"].  "</td>".
                        "</tr>";
                }
  
              } else {
                echo ("No task this week! Go start one now! \n");
              }
            ?>
        </tbody>
        </table>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="well">
            <h4>Completed</h4>
            <?php
              
              $result = pg_query($db, "SELECT COUNT (*) FROM dashboard_completed_task('$curUser');");

              $data = pg_fetch_assoc($result);

              if ($data["count"] > 0) {
                echo "<p> ". $data["count"] ." </p>";
              } else {
                echo "No task completed.";
              }

            ?>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
            <h4>Accepted</h4>
            <?php
              $result = pg_query($db, "SELECT COUNT (*) AS total FROM task t, bid b 
                WHERE t.username = '$curUser' 
                AND b.taskOwner = '$curUser'
                AND b.status = 'Accepted'
                AND t.taskid = b.taskid
                AND t.username = b.taskowner;"); //query for task that have pass the end date
              $data = pg_fetch_assoc($result);

              if ($data["total"] > 0) {
                echo "<p> ". $data["total"] ." </p>";
              } else {
                echo "No accepted task.";
              }

            ?>  
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
            <h4>Bidded</h4>
            <?php

               
              $result = pg_query($db, "SELECT COUNT (*) AS total FROM account a, bid b 
                WHERE a.username = '$curUser' AND a.username = b.bidder"); //query for task that have pass the end date
              $data = pg_fetch_assoc($result);

              if ($data["total"] > 0) {
                echo "<p> ". $data["total"] ." </p>";
              } else {
                echo "No task bidded.";
              }

            ?> 
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
            <h4>Amount Earned</h4>
            <!-- Sum of completed task prices !-->
            <?php

              $result = pg_query($db, "SELECT SUM(b.bidamt) FROM dashboard_completed_task('$curUser') AS dct, bid AS b 
                                       WHERE dct.taskid = b.taskid
                                       AND dct.username = b.taskowner
                                       AND b.status = 'Accepted';");
              $data = pg_fetch_assoc($result);

              echo "<p> $". $data["sum"] ." </p>";
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>	
</body>
<?php include 'footer.html' ?>
