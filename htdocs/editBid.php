<!DOCTYPE html>
<?php
	session_start();
    $taskid =$_POST['taskid'];
    $bidder = $_POST['bidder'];
  // Connect to the database. Please change the password and dbname in the following line accordingly
  
  $db     = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
  $result = pg_query($db, "SELECT * FROM bid WHERE taskid = '$_POST[taskid]' AND bidder = '$_POST[bidder]'");
  $row = pg_fetch_assoc($result);

    if(isset($_POST['update'])) {
    // Connect to database. Change pw and dbname as accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
    $rn = $_SESSION['user']; // current session user

    if($_POST['status']=='Pending'||$_POST['status']=='Rejected') {
      $query = "UPDATE bid SET status = '$_POST[status]', biddate = '$_POST[biddate]', bidamt = '$_POST[bidamt]'WHERE bidder = '$_POST[bidder]' AND taskid = '$_POST[taskid]'";
      $result = pg_query($db, $query);
    }
    else {
      $query2 = "UPDATE bid SET status = 'Rejected' WHERE taskid = '$taskid'";
      $query = "UPDATE bid SET status = '$_POST[status]', biddate = '$_POST[biddate]', bidamt = '$_POST[bidamt]'WHERE bidder = '$_POST[bidder]' AND taskid = '$_POST[taskid]'";
      pg_query($db,$query2);
      $result = pg_query($db, $query);
    }
    if(!$result) {
      echo "<script>
              alert('Bid update unsuccessful!');
              
            </script>";
    } else {
      echo "<script>
              alert('Success!');
              location.href = 'viewAllBid.php';
            </script>";
    }
  }  
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
  <h1 class="w3-center">Edit Bid</h1>
  <p class="w3-center w3-large">Update your Bid!</p>
  <div class="w3-row-padding" style="margin-top:64px padding:128px 16px">
    <div class="w3-content" align="center">
      <form action="editBid.php" method="POST" >
        
        <div>
          <div class="col-6">
            <label>Status</label>
            <select class="w3-input w3-border" required name = "status">
            <option value = "" disabled> --- Select Status --- </option>
            <option <?php if($row['status'] == 'Accepted') echo 'selected="selected"'; ?> value = "Accepted "> Accepted </option>
            <option <?php if($row['status'] == 'Rejected') echo 'selected="selected"'; ?> value = "Rejected "> Rejected </option>
            <option <?php if($row['status'] == 'Pending') echo 'selected="selected"'; ?> value = "Pending"> Pending </option>
            </select>
          </div>
        </div>
        
        
        <div class="row">
          <div class="col-6">
            <span>Bid Date</span>
            <input class="w3-input w3-border" type="date" required name="biddate" value="<?php echo $row['biddate']; ?>">
          </div>  
        </div>

        
        <div class="row">
          <div class="col-6">
            <span>Bid Price</span>
            <input class="w3-input w3-border" type="number" placeholder="Bid Price in SGD" value="<?php echo $row['bidamt']; ?>" required name="bidamt">
          </div>
        </div>


        <p><input type="hidden" name="taskid" value = "<?php echo $taskid ?>"></p>
    <p><input type="hidden" name="bidder" value = "<?php echo $bidder ?>"></p>
        <p>

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
    include 'footer.html';
?>