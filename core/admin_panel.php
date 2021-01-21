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
	</head>
	<body>
		<div class="container">
		<?php 

			/* Remove post */
			if (isset($_GET['post_id'])){
				$postid = mysqli_real_escape_string($con, $_GET['post_id']);
				$sql = "DELETE FROM inquiries WHERE inq_id = $postid";
				if (mysqli_query($con, $sql)){
					die("<div class='alert alert-success'>Post successfully deleted. 
						<a href='admin_panel.php' class='btn btn-dark'>Return</a></div>");
				} else {
					die("<div class='alert alert-danger'>Couldn't delete post.  
						<a href='admin_panel.php' class='btn btn-dark'>Return</a></div>");
				}
			}

			/* Remove user */
			if (isset($_GET['u']) && isset($_GET['action'])){
				$uid = mysqli_real_escape_string($con, $_GET['u']);
				$action = mysqli_real_escape_string($con, $_GET['action']);
				if ($action == 'ru'){
					$sql = "DELETE FROM users WHERE user_id = $uid";
					if (mysqli_query($con, $sql)){
						die("<div class='alert alert-success'>User successfully deleted. 
						<a href='admin_panel.php' class='btn btn-dark'>Return</a></div>");
					} else {
						die("<div class='alert alert-danger'>Couldn't delete user.
							<a href='admin_panel.php' class='btn btn-dark'>Return</a></div>");
					}
				} else if ($action == 'rp'){
					$sql = "DELETE FROM inquiries WHERE user_inq_id = $uid";
					if (mysqli_query($con, $sql)){
						die("<div class='alert alert-success'>User posts successfully deleted. 
						<a href='admin_panel.php' class='btn btn-dark'>Return</a></div>");
					} else {
						die("<div class='alert alert-dark'>Couldn't delete user's posts.
							<a href='admin_panel.php' class='btn btn-dark'>Return</a></div>");
					}
				} else {
					header('Location: admin_panel.php');
				}
			}
		?>
			<a href="logout.php" class="btn btn-info pull-right">Logout [<?= $_SESSION['active_name'] ?>]</a>
			<h4>Manage Nosco - Overview</h4>
			<hr>
				<div class="row">

					<form method="post" action="./admin_search.php" class="form-control" style="max-width: 650px; width: 100%; margin-bottom: 5px;
						margin-right: auto; margin-left: auto;">
						<input type="text" name="subject_name" class="form-control" placeholder="Find User">
						<input type="submit" name="find_user" class="btn btn-secondary form-control" value="Search"/>
					</form>


					</div>
						<?php
							$sql = "SELECT * FROM inquiries, users WHERE user_id = user_inq_id";
							$result = mysqli_query($con, $sql);
							if (mysqli_num_rows($result) > 0){
								while($row = mysqli_fetch_array($result)){ 
									?>
									<div class="row" style="border: 1px solid #ccc; padding: 15px 0;">
										<div class="col-md-8">
											<!-- MANAGE POST -->
											<div class="alert alert-info" style="height: 100%;">
												<h6><i>Authored by <b><?= $row['user_name'] ?></b></i></h6>
												<h5><?= $row['inq_title'] ?></h5>
												<p style="font-size:12px;"><?= $row['inq_body'] ?></p>
												<a href="admin_panel.php?post_id=<?= $row['inq_id'] ?>"
												class="btn btn-dark badges" style="margin-bottom: 5px;">Remove Post &nbsp <i class="fa fa-close"></i> </a>
											</div>
										</div>
										<div class="col-md-4">
											<!-- MANAGE USER PER POST -->
											<div class="alert alert-warning" style="height: 100%;">
												<h5><i class="fa fa-area-chart"></i> &nbsp Account details</h5>
												<h6><i class="fa fa-address-book"></i> &nbsp <b><i><?= $row['firstname'] . ' '. $row['lastname'] ?></i></b></h6>
												<h6><i class="fa fa-user"></i> &nbsp <b><i><?= $row['user_name'] ?></i></b></h6>
												<h6><i class="fa fa-envelope"></i> &nbsp <b><i><?= $row['user_email'] ?></i></b></h6>
												<h6><i class="fa fa-code"></i> &nbsp <b><i><?= $row['user_title'] ?></i></b></h6>

												<a href="admin_panel.php?u=<?= $row['user_id'] ?>&action=ru"
												class="badge-pill badge-warning badges">Remove User</a>

												<a href="admin_panel.php?u=<?= $row['user_id'] ?>&action=rp"
												class="badge-pill badge-warning badges">Remove All Posts</a>
											</div>
												
										
										</div>
									</div>

							<?php }
							} else { ?>
								<div class="alert alert-dark">No questions available.</div>
							<?php } ?>
				</div>
		</div>
	</body>
</html>