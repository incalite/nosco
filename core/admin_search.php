<?php 
	session_start();
	if (!isset($_SESSION['active_admin'])){
		header('Location: ../index.php');
	}

	include 'DB.php';
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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  		<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  		<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  		<style>label {  display: block; } .stat { margin: 20px 0; } </style>
	</head>
	<body>
		<div class="container">
			<a href="admin_panel.php" class="btn btn-info pull-right">Go Back</a>
			<h4>Manage Nosco - Admin Panel</h4>
			<div class="row">
				<div class="col-md-2 text-center">
					<?php 	
						if (isset($_POST['find_user'])){
							$user = mysqli_real_escape_string($con, $_POST['subject_name']);
							$sql = "SELECT * FROM users WHERE user_name LIKE '%$user%'";
							$query = mysqli_query($con, $sql);
							if ($query){
								$user_data = mysqli_fetch_array($query);
								$id = $user_data['user_id'];

								/* get posts */
								$sql = "SELECT COUNT(inq_id) AS posts FROM inquiries WHERE user_inq_id = $id";
								$query = mysqli_query($con, $sql);
								$res = ($query) ? mysqli_fetch_array($query) : 0;
								$total_posts = $res['posts']; 

								/* get comments */
								$sql = "SELECT COUNT(comment_id) AS comms FROM comments WHERE user_c_id = $id";
								$query = mysqli_query($con, $sql);
								$res = ($query) ? mysqli_fetch_array($query) : 0;
								$total_comments = $res['comms']; 

								/* get votes */
								$sql = "SELECT COUNT(vote_id) AS vts FROM votes WHERE vote_user_id = $id";
								$query = mysqli_query($con, $sql);
								$res = ($query) ? mysqli_fetch_array($query) : 0;
								$total_votes = $res['vts']; 
								?>
										<div class="form-control stat">
											<label>ID</label>
											<span class="badge badge-dark form-control"><?= $id ?></span>
										</div>

										<div class="form-control stat">
											<label>Firstname</label>
											<span class="badge badge-dark form-control"><?= $user_data['firstname'] ?></span>
										</div>

										<div class="form-control stat">
											<label>Lastname</label>
											<span class="badge badge-dark form-control"><?= $user_data['lastname'] ?></span>
										</div>

										<div class="form-control stat">
											<label>Posts</label>
											<span class="badge badge-dark form-control"><?= $total_posts ?></span>
										</div>

										<div class="form-control stat">
											<label>Comments</label>
											<span class="badge badge-dark form-control"><?= $total_comments ?></span>
										</div>

										<div class="form-control stat">
											<label>Votes</label>
											<span class="badge badge-dark form-control"><?= $total_votes ?></span>
										</div>

										<div class="form-control stat">
											<label>Reputation</label>
											<span class="badge badge-dark form-control"><?= ((int)$total_posts * 10) ?></span>
										</div>
							<?php } else {
								die('<div class="alert alert-danger">No statistics found</div>');
							}
						} else {
							die('<div class="alert alert-danger">No user found</div>');
						}
					?>
				</div>
				<div class="col-md-7">
					
					<?php 

						$sql = "SELECT * FROM inquiries WHERE user_inq_id = $id";
						$query = mysqli_query($con, $sql);
						if (mysqli_num_rows($query) > 0){
							while($row = mysqli_fetch_array($query)){ ?>
								

								<div class="form-control stat">
									<h5><span class="badge badge-info"><?= $row['inq_level'] ?></span> <?= $row['inq_title'] ?></h5>
									<p><?= $row['inq_body'] ?></p>
									<div class="alert alert-dark"><b>Tags:</b> <?= $row['inq_tags'] ?></div>
									<a class="badge badge-pill badge-danger pull-right" 
									style="margin-top:-2px;"
									href="admin_panel.php?post_id=<?= $row['inq_id'] ?>">Remove</a>
								</div>


						<?php } } else { ?>
							<div class="alert alert-danger stat">No user posts found</div>
						<?php } ?>

				</div>
				<div class="col-md-3 text-center">
					<div class="form-control stat">
						<h5>Modify User Settings</h5>
					</div>
				</div>
		</div>
	</body>
</html>