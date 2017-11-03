<!DOCTYPE html>
<?php
	session_start();
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
/* Full height image header */
.bgimg-1 {
    background-position: center;
    background-size: cover;
    min-height: 100%;
}
.w3-bar .w3-button {
    padding: 20px;
}
</style>
<body>
<?php 
    include 'navbar.php';
?>
<!-- Header with full-height image -->
<header class="bgimg-1 w3-display-container w3-grayscale-min" id="home">
  <div class="w3-display-left w3-text-black" style="padding:48px">
    <span class="w3-jumbo w3-hide-small">Start something that matters!</span><br>
    <span class="w3-xxlarge w3-hide-large w3-hide-medium">Start something that matters</span><br>
    <span class="w3-large">Stop doing everything yourself and get help from others.</span>
    <p><a href="Registration.php" class="w3-button w3-black w3-padding-large w3-large w3-margin-top w3-opacity w3-hover-opacity-off">Register now and start today</a></p>
  </div>
</header>

<div class="container">
    <div class="row">

        <center> <h2> Most popular tasker! </h2> </center>
    
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center>Housing Agent</center>
                    </div>
                    <div class="panel-body">
                        <?php

                            $db = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
                            $query = "SELECT username FROM popular_housing_agent";
                            $result = pg_query($db, $query);
                            $data = pg_fetch_assoc($result);
                            echo $data["username"];

                        ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center>Miscellaneous</center>
                    </div>
                    <div class="panel-body">
                        <?php

                            $db = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
                            $query = "SELECT username FROM popular_miscellaneous";
                            $result = pg_query($db, $query);
                            $data = pg_fetch_assoc($result);
                            echo $data["username"];

                        ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center>Car Washing</center>
                    </div>
                    <div class="panel-body">
                        <?php

                            $db = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
                            $query = "SELECT username FROM popular_car_washing";
                            $result = pg_query($db, $query);
                            $data = pg_fetch_assoc($result);
                            echo $data["username"];

                        ?>
                    </div>
                </div>
            </div>
    </div>

    <div class="row">
    
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center>Holiday Planner</center>
                    </div>
                    <div class="panel-body">
                        <?php

                            $db = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
                            $query = "SELECT username FROM popular_holiday_planner";
                            $result = pg_query($db, $query);
                            $data = pg_fetch_assoc($result);
                            echo $data["username"];

                        ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center>Home</center>
                    </div>
                    <div class="panel-body">
                        <?php

                            $db = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
                            $query = "SELECT username FROM popular_home";
                            $result = pg_query($db, $query);
                            $data = pg_fetch_assoc($result);
                            echo $data["username"];

                        ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center>Education</center>
                    </div>
                    <div class="panel-body">
                        <?php

                            $db = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=root");
                            $query = "SELECT username FROM popular_education";
                            $result = pg_query($db, $query);
                            $data = pg_fetch_assoc($result);
                            echo $data["username"];

                        ?>
                    </div>
                </div>
            </div>
    </div>
</div>

<?php
    include 'footer.html';
?>
</body>
</html>
