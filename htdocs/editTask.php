<!DOCTYPE html>
<?php
	session_start();
  $taskid = $_POST['taskid'];
  $user = $_POST['user'];
  // Connect to the database. Please change the password and dbname in the following line accordingly
  
  $db     = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
  $result = pg_query($db, "SELECT * FROM task WHERE taskID = '$taskid' AND userName = '$user'");
  $row = pg_fetch_assoc($result);
?>
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

.row::after {
    content: "";
    clear: both;
    display: table;
}
[class*="col-"] {
    float: left;
    padding: 15px;
}
.col-1 {width: 8.33%;}
.col-2 {width: 16.66%;}
.col-3 {width: 25%;}
.col-4 {width: 33.33%;}
.col-5 {width: 41.66%;}
.col-6 {width: 50%;}
.col-7 {width: 58.33%;}
.col-8 {width: 66.66%;}
.col-9 {width: 75%;}
.col-10 {width: 83.33%;}
.col-11 {width: 91.66%;}
.col-12 {width: 100%;}
</style>
<body>
<?php 
    include 'navbar.php';
?>

<!-- Create Task -->
<div class="w3-container w3-light-grey" style="padding:96px" id="home">
  <h1 class="w3-center">Edit Task</h1>
  <p class="w3-center w3-large">Update your task!</p>
  <div class="w3-row-padding" style="margin-top:64px padding:128px 16px">
    <div class="w3-content" align="center">
      <form action="editTask.php" method="POST" >
        
        <div class="row">
          <span>Task Title</span>
          <div class="col-12">
            <input class="w3-input w3-border" type="text" placeholder="Task Title" value="<?php echo $row['title']; ?>" required name="tasktitle">
          </div>
        </div>
        
        <div class="row">
          <span>Description</span>
          <div class="col-12">  
            <textarea class="w3-input w3-border" type="textarea" placeholder="Description of task..." required name="taskdescription"><?php echo $row['description']; ?></textarea>
          </div>
        </div>
        
        <div class="row">
          <div class="col-6">
            <span>Start Date</span>
            <input class="w3-input w3-border" type="date" required name="starttaskdate" value="<?php echo $row['startdate']; ?>">
          </div>

          <div class="col-6">
            <span>End Date</span>  
            <input class="w3-input w3-border" type="date" required name="endtaskdate" value="<?php echo $row['enddate']; ?>">
          </div>     
        </div>

        <div class="row">
          <div class="col-6">
            <span>Start Time</span>
            <input class="w3-input w3-border" type="time" required name="starttasktime" value="<?php echo $row['starttime']; ?>">
          </div>
          <div class="col-6">
            <span>End Time</span>  
            <input class="w3-input w3-border" type="time" required name="endtasktime" value="<?php echo $row['endtime']; ?>">
          </div>
        </div>
        
        <div class="row">
          <div class="col-6">
            <span>Task Price</span>
            <input class="w3-input w3-border" type="number" placeholder="Task Price in SGD" value="<?php echo $row['price']; ?>" required name="taskprice">
          </div>

          <div class="col-6">
            <label>Task Type</label>
            <select class="w3-input w3-border" required name = "tasktype">
            <option value = "" disabled> --- Select Task Type --- </option>
            <option <?php if($row['type'] == 'Miscellanous') echo 'selected="selected"'; ?> value = "Miscellanous "> Miscellanous </option>
            <option <?php if($row['type'] == 'Housing Agent') echo 'selected="selected"'; ?> value = "Housing Agent "> Housing Agent </option>
            <option <?php if($row['type'] == 'Car Washing') echo 'selected="selected"'; ?> value = "Car Washing"> Car Washing </option>
            <option <?php if($row['type'] == 'Education') echo 'selected="selected"'; ?> value = "Education "> Education </option>
            <option <?php if($row['type'] == 'Holiday Planner') echo 'selected="selected"'; ?> value = "Holiday Planner "> Holiday Planner </option>
            <option <?php if($row['type'] == 'Home') echo 'selected="selected"'; ?> value = "Home"> Home </option>
            </select>
          </div>
        </div>

        <p><input type="hidden" name="taskID" value = "<?php echo $taskid ?>"></p>
		<p><input type="hidden" name="username" value = "<?php echo $user ?>"></p>
        <p>
          <button class="w3-button w3-black" type="submit" name = "update">
            <i class="fa fa-pencil"></i> UPDATE
          </button>
        </p>
      </form>
    </div>
  </div>

</div>

<?php
  if(isset($_POST['update'])) {

    // Connect to database. Change pw and dbname as accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
    $rn = $_SESSION['user']; // current session user
    $query = "UPDATE task SET title = '$_POST[tasktitle]', description = '$_POST[taskdescription]', type = '$_POST[tasktype]', startdate = '$_POST[starttaskdate]', enddate = '$_POST[endtaskdate]', starttime = '$_POST[starttasktime]', endtime = '$_POST[endtasktime]', price = '$_POST[taskprice]' WHERE taskid = '$_POST[taskID]' AND username = '$_POST[username]'";
    $result = pg_query($db, $query);

    if(!$result) {
      echo "<script>
              var startDate = new Date('$_POST[starttaskdate]');
              var endDate= new Date('$_POST[endtaskdate]');
              var today = new Date();
              today.setHours(0,0,0,0);

              if(startDate >= today) {
                if(startDate > endDate) {
                  alert('Check that your end date is not earlier that your start date');
                } else {
                  alert('Error in updating your task. Try again!');
                }
              } else if (startDate < today){
                alert('Check that your start date is not in the past.');
              } else {
                alert('Error in updating the task. Try again!');
              }
              
            </script>";
    } else {
      echo "<script>
              alert('Success!');
              location.href = 'viewTask.php';
            </script>";
    }
  }  
?>

<?php 
    include 'navbar.php';
?>