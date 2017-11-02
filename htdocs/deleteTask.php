<?php
	session_start();
  $taskid = $_POST['taskid'];
  $user = $_POST['user'];
  // Connect to the database. Please change the password and dbname in the following line accordingly
  
  $db     = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
  $result = pg_query($db, "DELETE FROM task WHERE taskID = '$taskid' AND userName = '$user'");
  header("Location: viewAllTasks.php");
?>