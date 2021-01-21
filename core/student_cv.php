<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>CV</title>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/nosco.css">
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<style>

	h3 { margin: 0; padding: 0;}
	
	.container {
		padding: 0;
	}
	.cvCont {
		border:1px solid #aaa;
		max-width: 850px; 
		width: 100%;
		padding: 20px;
	}
	.row, .col-md-3 {
		margin: 0;
		padding: 0;
	}

	.heading {
		margin: 0;
		font-size: 22px;
		color: orange;
	}

	.heading-sub {
		margin: 10px 0;
		font-size: 16px;
		color: #444;
	}

	.content {
		font-size: 16px;
		margin: 10px 0;
	}
</style>
</head>
<body>

<?php 	 
	include 'DB.php';
	include 'library.php';
	$db = new DB();
	$con = $db->connection();

	if (empty($_GET['student'])){
		header('Location: ../home.php');
	} else {
		$student_id = mysqli_real_escape_string($con, $_GET['student']);
		$query = "SELECT * FROM users WHERE user_id = $student_id";
		$result = mysqli_query($con, $query);
		if ($result){
			while($row = mysqli_fetch_array($result)){ ?>

				<div class="container cvCont">
					<div class="row">

						<div class="col-md-3" style="padding:0;">
							<h3 class="heading"><?= $row['firstname'] . " " . $row['lastname']; ?></h3>
							<h3 class="heading-sub"><?= $row['user_title'] ?></h3>
							<h3 class="heading-sub"><?= $row['user_email'] ?></h3>
						</div>


						<div class="col-md-9" style="padding:0;">
							<h3 class="heading">Summary</h3>
							<p class="content"><?= $row['user_desc'] ?></p>
							<h3 class="heading">Experience</h3>
							<p class="content"><?= $row['user_experience'] ?></p>
							<h3 class="heading">Projects</h3>
							<p class="content"><?= format_list($row['user_projects']); ?></p>
							<h3 class="heading">Education</h3>
							<p class="content"><?= $row['user_education']; ?></p>
							<h3 class="heading">Certifications & Coursework</h3>
							<p class="content"><?= $row['user_titles'] ?></p>
							<h3 class="heading">Recommendations</h3>
							<p class="content"><?= format_list($row['user_recoms']); ?></p>
						</div>
					</div>
				</div>



			<?php } 
			}
		}
	?>




</body>
</html>

