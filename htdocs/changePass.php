
  <?php
      session_start();
      //$_SESSION['Username']= 'damien';
    if(isset($_POST['update'])){

        if ($_POST['newPass']==$_POST['secondPass']){
          $newPass = password_hash($_POST['newPass'],PASSWORD_DEFAULT);
        $db     = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root"); 
        $check = pg_query($db,"UPDATE account SET pw = '$newPass' WHERE username = '$_SESSION[user]'");
        if($check) {
            echo "<script>
              alert('Update Successful!');
              location.href = 'dashBoard.php';
            </script>";
        }
        else {
          echo "<script>
              alert('Update unsuccessful!');
              
            </script>";
        }
        }
        else{
          echo "<script>
              alert('Password does not match!');
              
            </script>";
        }
    }
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

<!-- Change password !-->

<div class="w3-container w3-light-grey" style="padding:96px" id="home">
  <h1 class="w3-center">Change Password</h1>
  <p class="w3-center w3-large">Update your Password!</p>
  <div class="w3-row-padding" style="margin-top:64px padding:128px 16px">
    <div class="w3-content" align="center">
      <form action="changePass.php" method="POST" >
       
        <div class="row">
          <div class="col-6">
            <span>New Password</span>
            <input class="w3-input w3-border" type="password" placeholder="New Password" required name="newPass">
          </div>
        </div>

        <div class="row">
          <div class="col-6">
            <span>Retype New Password</span>
            <input class="w3-input w3-border" type="password" placeholder="Retype New Password" required name="secondPass">
          </div>
        </div>

        <p>
          <button class="w3-button w3-black" type="submit" name = "update">
            <i class="fa fa-pencil"></i> Change Password
          </button>
        </p>
      </form>
    </div>
  </div>

</div>

        </div>


</body>

<!-- Footer -->
<?php include 'footer.html'; ?>