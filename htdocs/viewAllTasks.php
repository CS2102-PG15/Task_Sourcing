  <?php
      session_start();
      // Connect to the database. Please change the password and dbname in the following line accordingly
          $db     = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
          $result = pg_query($db, "SELECT * FROM task");
  ?> 

<!DOCTYPE html>
<html>
<title>CS2102 Assignment</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
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
      <h3 class="w3-center">All Tasks in the Database!</h3>
      <p><div class="container">   
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-info">
<?php 
          if(!$result) {
            echo '<p>There is no task in the database!</p> </div> </div> </div>';
          } else {
			  $index = 1;
			  echo '
			<table style = "width:100%">
					<tr>
					<th>S/N</th>
					<th>Owner</th>
					<th>Title</th>
					<th>Type</th>
					<th>Start Date</th>
					<th>Start Time</th>
					<th>End Date</th>
					<th>End Time</th>
					<th>Price</th>
					<th>Description</th>
					<th>Total Bids</th>
					<th>Edit</th>
					<th>Delete</th>
					<th>View Bids</th>
					</tr>';
            while($row = pg_fetch_assoc($result)) {   //Creates a loop to loop through results
		    		$taskid = $row["taskid"];
            			$taskowner = $row["username"];
		    		$totalBid = pg_query($db, "SELECT COUNT(*) FROM bid WHERE taskid = {$taskid} AND taskowner = '$taskowner'");
				$count = 0;
				if (!$totalBid) {
					echo pg_last_error();
				} else {
					$row1 = pg_fetch_assoc($totalBid);
					$count = $row1["count"];
				}
				echo '<tr>
				<th>'.$index.'</th>
				<th>'.$row["username"].'</th>
				<th>'.$row["title"].'</th>
				<th>'.$row["type"].'</th>
				<th>'.$row["startdate"].'</th>
				<th>'.$row["starttime"].'</th>
				<th>'.$row["enddate"].'</th>
				<th>'.$row["endtime"].'</th>
				<th>'.$row["price"].'</th>
				<th>'.$row["description"].'</th>
				<th>'.$count.'</th>
				<th>
				<form action="editTask.php" method = "POST">
					<input type = "hidden" name = "user" value = "'.$row["username"].'" />
					<input type = "hidden" name = "taskid" value = "'.$row["taskid"].'" />
					<button class="w3-button w3-white w3-border w3-border-blue" type="submit" name = "Display">
                <i class=" "></i> Edit
				</button>
				</form>
				</th>
				<th>
				<form action="deleteTask.php" method = "POST">
					<input type = "hidden" name = "user" value = "'.$row["username"].'" />
					<input type = "hidden" name = "taskid" value = "'.$row["taskid"].'" />
					<button class="w3-button w3-white w3-border w3-border-blue" type="submit" name = "Display">
					<i class=" "></i> Delete
					</button>
				</form>
				</th>
				<th>
				<form action="viewAllBid.php" method = "POST">
					<input type = "hidden" name = "user" value = "'.$row["username"].'" />
					<input type = "hidden" name = "taskid" value = "'.$row["taskid"].'" />
					<button class="w3-button w3-white w3-border w3-border-blue" type="submit" name = "Display">
                			<i class=" "></i> Bids
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
<footer>
	<?php include 'footer.html'; ?>
</footer>
