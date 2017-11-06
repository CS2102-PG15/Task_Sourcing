  <?php
      session_start();
      // Connect to the database. Please change the password and dbname in the following line accordingly
          $db     = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
          $result = pg_query($db, "SELECT * FROM task WHERE username = '$_SESSION[user]'");

        if(isset($_POST['delete'])) {

    	pg_query($db, "DELETE FROM bid WHERE taskid = '$_POST[delete]' AND taskowner = '$_POST[user]'");
    	pg_query($db, "DELETE FROM task WHERE taskid = '$_POST[delete]' AND username = '$_POST[user]'");

    	echo "<script>
    		alert('Task deleted!');
    		location.href = 'viewTask.php';
    	</script>";
    }
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
      <h3 class="w3-center">Your Tasks!</h3>
      <p><div class="container">   
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-info">
<?php 
          if(!$result) {
            echo '<p>You have no created task!</p> </div> </div> </div>';
          }
            while($row = pg_fetch_assoc($result)){   //Creates a loop to loop through results

            echo '<div class="panel-heading"><b>'.$row["title"].'</b></div>
            <div class="panel-body">
              Type: '.$row["type"]. '</br>
              Date: '.$row["startdate"]. '</br>
              Time: '.$row["starttime"]. '</br>
              Price: '.$row["price"]. '</br>
              Description: '.$row["description"]. '</br></br>
            </div>
    <div class="w3-row-padding" style="margin-top:64px padding:128px 16px">
      <div class="button-container" align="center">
        <form action="approveBid.php" method="POST">
          <div>
            <button class="w3-button w3-white w3-border w3-border-blue" type="submit" name = "Display" value="'.$row['taskid'].'"">
                <i class=" "></i> View Bids Here!
            </button>
          </div>
        </form>

        <form action="editTask.php" method="POST">
          <div>
		    <input type = "hidden" name = "user" value = '.$_SESSION[user].' />
            <button class="w3-button w3-white w3-border w3-border-blue" type="submit" name = "taskid" value="'.$row['taskid'].'"">
                <i class=" "></i> Edit task
            </button>
          </div>
        </form>
        
        <form action="viewTask.php" method="POST">
          <div>
		    <input type = "hidden" name = "user" value = '.$_SESSION[user].' />
            <button class="w3-button w3-white w3-border w3-border-blue" type="submit" name = "delete" value="'.$row['taskid'].'"">
                <i class=" "></i> Delete task
            </button>
          </div>
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
