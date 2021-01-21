<?php 

	include 'DB.php';
	
	session_start();	
	if (!isset($_SESSION['stud_id'])){
		header('Location: ../index.php');
	}
	
	$uid = (int)$_SESSION['stud_id'];
	$db = new DB();
	$con = $db->connection();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>NoscoSystem</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/nosco.css">
		<link href='https://fonts.googleapis.com/css?family=Rock+Salt' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Inika' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/validation_master.js"></script>
</head>
<body>


	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="box-shadow: 0px 5px 5px #afd;">
	  <a class="navbar-brand" href="#">Nosco</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item active">
	        <a class="nav-link" href="../home.php">Home <span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="../profile.php?u=<?= $uid; ?>">Profile</a>
	      </li>
	      <li class="nav-item">
	      	<a class="nav-link" href="logout.php">Logout &nbsp <strong><?= $_SESSION['stud_name'] ?></strong></a>
	      </li>  
	    </ul>

	  </div>
	</nav>

	<div class="container" style="margin-top: 80px;">
		<!-- SEARCH -->
		<div class="row">
			<div class="col-md-3 text-center">
				<h1>NoscoSystem</h1>
				<p>Ask, Study, Advance.</p>
			</div>
			<div class="col-md-9">
				<form method="get" action="search.php">
					<input type="text" class="form-control" style="padding: 10px 20px;" name="query_string" placeholder="How to...">
					<input type="submit" class="btn btn-dark form-control" value="Search">
					<div class="text-center">
						<input type="radio" name="target_field" value="tag_query" checked="checked"><span class="badge badge-outline-dark">Tag based</span>
						<input type="radio" name="target_field" value="body_query"><span class="badge badge-outline-dark">Content based</span>
						<input type="radio" name="target_field" value="title_based"><span class="badge badge-outline-dark">Title based</span>
					</div>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-md-9">
				<?php 
					if (!empty($_GET['query_string'])){
						$filter = $_GET['target_field'];
						if ($filter == "tag_query"){
							$column = "inq_tags";
						} else if ($filter == "body_query"){
							$column = "inq_body";
						} else if ($filter == "title_based"){
							$column = "inq_title";
						} else {
							$column = "";
						}
						$search_query = htmlspecialchars($_GET['query_string']);
						$sql = "SELECT * FROM inquiries WHERE $column LIKE '%$search_query%'";
						$res = mysqli_query($con, $sql);
						if (mysqli_num_rows($res) > 0){
							echo "<div class='alert alert-dark'>Results found : " . mysqli_num_rows($res) . "</div>";
							while($row = mysqli_fetch_array($res)){ ?>
								<!-- SEARCHED RESULT -->
								<div class="jumbotron" style="padding: 30px;">
									<!-- RESULT STYLING -->
									<h4 style="margin:0;"><?= $row['inq_title']; ?></h4>
									<p class="alert alert-warning" style="margin: 10px auto;"><?= $row['inq_body']; ?></pre></p>
									<span class="badge-pill badge-warning"><strong>Responses</strong></span>
									<?php 
											$inner = "SELECT * FROM comments WHERE inquiry_id = " . $row['inq_id'] . "";
											$innerRes = mysqli_query($con, $inner);
											if (mysqli_num_rows($innerRes) > 0){
												while($irow = mysqli_fetch_array($innerRes)){ ?>
													<div class="alert alert-dark" style="margin: 10px auto;">
														<div class="row">
															<div class="col-md-10">
																
																<?php
																	$comment_user = "SELECT user_name, user_id FROM users WHERE user_id = " . $irow['user_c_id'] . "";
																	$q = mysqli_query($con, $comment_user);
																	$c_user = ($q) ? mysqli_fetch_array($q) : '';
																?>
																	
																<a style="font-size: 13px; font-weight: 600;" target="_blank" href="../profile.php?u=<?= $c_user['user_id'] ?>"
																class="badge-pill badge-warning">Posted by <?= $c_user['user_name'] ?></a>

																<?= $irow['comment_body'] ?>

															</div>
															<div class="col-md-2 text-center" style="border-left: 2px solid #555;">
																<!-- SHARING -->
																<a target="_blank" href="https://twitter.com/intent/tweet?text=<?=urlencode($irow['comment_body']) ?>&via=NoscoSystem - <?= urlencode($c_user['user_name'])?>" 
																style="text-decoration: none; color:#000;"><i style="font-size:24px" class="fab fa-twitter-square"></i></a>

																<a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&title=<?= 
																urlencode($row['inq_title']); ?>&summary=<?= urlencode($irow['comment_body']) ?>&source=NoscoSystem" 
																style="text-decoration: none; color:#000;"> <i style="font-size:24px" class="fab fa-linkedin-square"></i></a>
															
															</div>
														</div>
													</div>
											<?php } 
											} else { ?>
												<div class="alert alert-dark">No comments.</div>
									<?php } ?>


								</div>
							<?php } ?>
						<?php } else {
							die("No results. <a class='btn btn-dark' href='../home.php'>Go back</a>");
						}
					} else if (empty($_GET['query_string'])){
						header("Location: ../home.php");
					}
				?>
			</div>
			<div class="col-md-3">
				<h4>Student Area</h4>
					<p>Helpful websites for students</p>
					<div class="btn-group-vertical form-control">
						<a class="btn btn-outline-primary form-control" href="https://eclass.teimes.gr" target="_blank">e-Class TeiWest</a>
						<a class="btn btn-outline-primary form-control" href="https://e-students.teiwest.gr" target="_blank">e-Students Web</a>
						<a class="btn btn-outline-primary form-control" href="https://webmail.teimes.gr/" target="_blank">e-Webmail</a>
						<a class="btn btn-outline-dark form-control" href="http://www.library.teiwest.gr/" target="_blank">Library</a>
						<a class="btn btn-outline-dark form-control" href="http://academicid.minedu.gov.gr/" target="_blank">Academic ID</a>
						<a class="btn btn-outline-danger form-control" href="http://opencourses.gr/" target="_blank">OpenCourses.gr</a>
					</div>
				<hr>
				<!-- Display all tags in the network -->
				<ul style="margin: 0; padding: 0;">
				<?php 
					$query = "SELECT inq_tags FROM inquiries";
					$result = mysqli_query($con, $query);
					if ($result){
						$data = array();
						while($row = mysqli_fetch_array($result)){
							array_push($data, $row['inq_tags']);
						}
						$data = array_unique(explode(",",implode(",", $data)));
					}  else {
						$data = [];
					}
				?>
				<?php if (!empty($data)){ ?>
						<?php foreach($data as $d){ ?>
							<a href="search.php?query_string=<?= $d ?>&target_field=tag_query" 
							class="form-control badge badge-pill badge-dark" style='margin: 2px 0;color: #fff; padding: 10px;'><?= $d ?></a>
						<?php } ?>
				<?php } ?>
				</ul>
			</div>
		</div>
</div>
</body>
</html>
<?php exit; ?>