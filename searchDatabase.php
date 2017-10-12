	<!DOCTYPE html>
	<html lang="en">
	<head>
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

			.w3-bar .w3-button {
				padding: 20px;
			}

			.jumbotron {
				padding-top: 120px;
				padding-bottom: 40px;
				background-color: #FEFEFE;
			}

			.panel {
				text-align: center;
			}

			.pagination {
				display: inline-block;
			}

			.pagination a {
				color: black;
				float: left;
				padding: 8px 16px;
				text-decoration: none;
			}

			.pagination a.active {
				background-color: #4CAF50;
				color: white;
				border: 1px solid #4CAF50;
			}

			.center {
				text-align: center;
			}

			select {
				width: 100%;
				padding: 12px 12px;
				border: none;
				border-radius: 4px;
				background-color: #f1f1f1;
			}

		</style>
	</head>
	<body>

		<?php 
		include 'navbar.php';
		?>

		<div class="jumbotron">
			<div class="container">
				<p>
					<h2 style="text-align: center">Browse over 1,000 taskers with the skills you need</h2></br>
				</p>
				<form> 
					<h4>Filter by category:</h4>
					<h6>
						<select id="category" name="category">
							<option value="ed">Education</option>
							<option value="ha">Housing Agent</option>
							<option value="ho">Home</option>
							<option value="hp">Holiday Planner</option>
							<option value="cw">Car Washing</option>
							<option value="mi">Miscellaneous</option>
						</select>
					</h6>
					<a href="#" class="w3-button w3-grey">Go</a>
				</form>
			</div>
		</div>

		<?php

		$db     = pg_connect("host=localhost port=5432 dbname=TaskRabbit user=postgres password=cs2102");
		$page = $_GET["page"];

		if ($page=="" || $page=="1"){
			$page1=0;
		} else {
			$page1 = $page*5-5;
		}

	$result = pg_query($db, "SELECT * FROM task LIMIT 10 OFFSET $page1");		// Query template
	$row    = pg_fetch_assoc($result);		// To store the result row
	while($row = pg_fetch_array($result))
		{ ?>
	<p><div class="container">   
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-info">
					<div class="panel-heading"><b> <?php echo $row["title"]; ?></b></div>
					<div class="panel-body">
						Type: <?php echo $row["type"]; ?></br>
						Date: <?php echo $row["date"]; ?></br>
						Time: <?php echo $row["time"]; ?></br>
						Price: <?php echo $row["price"]; ?></br>
						Description: <?php echo $row["description"]; ?></br></br>
						<p><a href="#" class="w3-button w3-white w3-border w3-border-blue">Click here to hire!</a></p>
					</div>
				</div>
			</div>
		</div>
	</div></p>

	<?php 
}
$result1 = pg_query($db, "select * from task");
$count = pg_num_rows($result1);
$pages = ceil($count/10);
if ($page > 1){
	$prevPage = $page - 1;
} else {
	$prevPage = $page;
}
if ($page < $pages){
	$nextPage = $page + 1;
} else {
	$nextPage = $page;
}

?>
<div class="center">
	<div class="pagination"> 
		<a href="searchDatabase.php?page=<?php echo $prevPage ?>">&laquo;</a>
		<?php
		for ($a=1; $a<=$pages; $a++){
			if($page == $a){
			?>
			<a href="searchDatabase.php?page=<?php echo $a ?>" class="active"><?php echo "$a"?></a>
			<?php
			} else {
			?>
			<a href="searchDatabase.php?page=<?php echo $a ?>"><?php echo "$a"?></a>
			<?php 
			}
		}
		?>
		<a href="searchDatabase.php?page=<?php echo $nextPage ?>">&raquo;</a>
	</div>
</div>

</body>
</html>
