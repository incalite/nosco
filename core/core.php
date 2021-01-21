

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>NoscoSystem</title>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/nosco.css">
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<div class="row">
<div class="col text-center">
<?php

	include 'DB.php';
	$db = new DB();
	$con = $db->connection();

	/* User login details */
	if (isset($_POST['login_submit'])){
		$user = mysqli_real_escape_string($con, $_POST['l_username']);
		$pass = mysqli_real_escape_string($con, $_POST['l_password']);
		$password = md5(sha1(md5($pass)));
		$query = "SELECT * FROM users WHERE user_name = '$user' AND user_password = '$password' ";
		$result = mysqli_query($con, $query);
		$row = mysqli_fetch_array($result);
		if (mysqli_num_rows($result) == 1){
			session_start();
			$_SESSION['stud_id'] = $row['user_id'];
			$_SESSION['stud_name'] = $row['user_name'];
			header('Location: ../home.php');
		} else {	
			die("No user with such details. Sign up here <a class='btn btn-dark' href='../index.php'>Go back</a>");
		}
	}

	/* Manage sign ups */
	if (isset($_POST['signup_submit'])){
		// Prevent mysql injection
		$first_name = mysqli_real_escape_string($con, $_POST['s_name']);
		$last_name = mysqli_real_escape_string($con, $_POST['s_lastname']);
		$username = mysqli_real_escape_string($con, $_POST['s_username']);
		$email = mysqli_real_escape_string($con, $_POST['s_email']);
		$user_pass = mysqli_real_escape_string($con, $_POST['s_password']);
		$user_pass_confirmation = mysqli_real_escape_string($con, $_POST['s_conf_password']);
		if ($user_pass === $user_pass_confirmation){
			$pass = md5(sha1(md5($user_pass)));
			$query = "SELECT * FROM users WHERE user_name = '$username' OR user_email = '$email'";
			$res = mysqli_query($con, $query);
			if (mysqli_num_rows($res) == 1){
				die("User already exists! Try logging in instead. <a class='btn btn-dark' href='../index.php'>Login</a>"); 
			} else {
				$qr = "INSERT INTO users VALUES (null, '$first_name', '$last_name', '$username', '$pass', '$email', '', '', '', '', '', '', '', '')";
				$res = mysqli_query($con, $qr);
				die("User created. <a class='btn btn-dark' href='../index.php'>Login</a>");
			}
		} else {
			die("Unable to create user. Check your details. <a class='btn btn-dark' href='../index.php'>Go back</a>");
		}
	}
	
	/* end of user login details */



	/* Admin login details */
	if (isset($_POST['l_admin'])){
		$ad_user = mysqli_real_escape_string($con, $_POST['u_admin']);
		$pass = mysqli_real_escape_string($con, $_POST['p_admin']);
		$ad_pass = md5($pass);
		$query = "SELECT * FROM administration WHERE admin_username = '$ad_user' AND admin_password = '$ad_pass' ";
		$result = mysqli_query($con, $query);
		$row = mysqli_fetch_array($result);
		if (mysqli_num_rows($result) == 1){
			session_start();
			$_SESSION['active_admin'] = $row['admin_id'];
			$_SESSION['active_name'] = $row['admin_username'];
			header('Location: admin_panel.php');
		} else {	
			header('Location: ../index.php');
		}
	}
	/* end of admin login details */




	/* Manage new inquiries */
	if (isset($_POST['q_submit'])){
		$question_title = mysqli_real_escape_string($con, $_POST['q_title']);
		$question_body = mysqli_real_escape_string($con, $_POST['q_body']);
		$question_tags = mysqli_real_escape_string($con, $_POST['q_tags']);
		$question_level = mysqli_real_escape_string($con, $_POST['q_level']);
		$user_id = $_POST['q_user_id'];
		$query = "INSERT INTO inquiries VALUES (null, '$user_id', '$question_title', '$question_body', '$question_tags', '$question_level')";
		$res = mysqli_query($con, $query);
		if ($res){
			header('Location: ../home.php');
		} else {
			die("Unable to make this post. Something went wrong <a class='btn btn-dark' href='../home.php'>Go back</a>");
		}
	}


	/* Manage inquiry votes */
	if (isset($_GET['qq_id']) && isset($_GET['uq_id'])){
		$question_id = $_GET['qq_id'];
		$user_id = $_GET['uq_id'];
		$remove = ($_GET['rm']) ? $_GET['rm'] : false;

		if ($remove){
			$sql = "DELETE FROM votes WHERE vote_user_id = $user_id AND vote_q_id = $question_id";
			$res = mysqli_query($con, $sql);
			if ($res){
			header('Location: ../home.php');
			} else {
				die("These aren't the droids you're looking for. <a class='btn btn-dark' href='../home.php'>Go back</a>");
			}
		} else {
			$sql = "INSERT INTO votes (vote_user_id, vote_q_id) 
					SELECT {$user_id}, {$question_id}
					FROM inquiries
					WHERE EXISTS (
						SELECT inq_id 
						FROM inquiries
						WHERE inq_id = {$question_id}
					) AND NOT EXISTS (
				  		SELECT * 
				  		FROM votes 
				  		WHERE vote_user_id = {$user_id}
				  		AND vote_q_id = {$question_id}
				  	) LIMIT 1";
			$res = mysqli_query($con, $sql);
			if ($res){
				header('Location: ../home.php');
			} else {
				die("These aren't the droids you're looking for. <a class='btn btn-dark' href='../home.php'>Go back</a>");
			}
		}
	}


	/* Remove inquiry */
	if (isset($_GET['q_id'])){
		$question_id = $_GET['q_id'];
		$sql_q = "DELETE FROM inquiries WHERE inq_id = $question_id";
		$res = mysqli_query($con, $sql_q);
		if ($res){
			$sql_qc = mysqli_query($con, "DELETE FROM comments WHERE inquiry_id = $question_id");
			if($sql_qc){
				$remove_votes = mysqli_query($con, "DELETE FROM votes WHERE vote_q_id = $question_id");
				if ($remove_votes){
					header('Location: ../home.php');
				} else {
					die("Unable to execute this operation. Something went wrong <a class='btn btn-dark' href='../home.php'>Go back</a>");
				}
			} else {
				die("Unable to execute this operation. Something went wrong <a class='btn btn-dark' href='../home.php'>Go back</a>");
			}
		} else {
			die("Unable to remove this post. Something went wrong <a class='btn btn-dark' href='../home.php'>Go back</a>");
		}
	}

	/* Leave comment */ 
	if (isset($_POST['add_comment'])){
		$user_id = $_POST['u_id'];
		$question_id = $_POST['q_id']; 
		$comment = mysqli_real_escape_string($con, htmlspecialchars($_POST['comm_body']));
		$sql = "INSERT INTO comments VALUES (null, '$question_id', '$user_id', '$comment')";
		$result = mysqli_query($con, $sql);
		if ($result){
			header('Location: ../home.php');
		} else {
			die("Unable to post comment. Something went wrong <a class='btn btn-dark' href='../home.php'>Go back</a>");
		}
	}

	/* Remove comment */
	if (isset($_GET['cid'])){
		$response_id = $_GET['cid'];
		$sql_c = "DELETE FROM comments WHERE comment_id = $response_id";
		$res = mysqli_query($con, $sql_c);
		if ($res){
				header('Location: ../home.php');
		} else {
			die("Unable to remove this post. Something went wrong <a class='btn btn-dark' href='../home.php'>Go back</a>");
		}
	}

	/* Manage comment votes */
	if (isset($_GET['r_id']) && isset($_GET['ru_id'])){
		$comment_id = $_GET['r_id'];
		$user_id = $_GET['ru_id'];
		$sql = "INSERT INTO cvotes (cvote_user_id, cvote_c_id) 
				SELECT {$user_id}, {$comment_id}
				FROM comments
				WHERE EXISTS (
					SELECT comment_id 
					FROM comments
					WHERE comment_id = {$comment_id}
				) AND NOT EXISTS (
			  		SELECT * 
			  		FROM cvotes 
			  		WHERE cvote_user_id = {$user_id}
			  		AND cvote_c_id = {$comment_id}
			  	) LIMIT 1";
		$res = mysqli_query($con, $sql);
		if ($res){
			header('Location: ../home.php');
		} else {
			die("Unable to vote this comment. Something went wrong <a class='btn btn-dark' href='../home.php'>Go back</a>");
		}
	}


	/* Manage user details */
	if (isset($_POST['dev_details'])){
		$deve_id = $_POST['dev_id'];
		$deve_title = trim(htmlspecialchars(mysqli_real_escape_string($con, $_POST['dev_title'])));
		$deve_desc = trim(htmlspecialchars(mysqli_real_escape_string($con, $_POST['dev_desc'])));
		$deve_projects = trim(htmlspecialchars(mysqli_real_escape_string($con, $_POST['dev_projects'])));
		$deve_skills = trim(htmlspecialchars(mysqli_real_escape_string($con, $_POST['dev_skills'])));
		$deve_exps = trim(htmlspecialchars(mysqli_real_escape_string($con, $_POST['dev_exps'])));
		$deve_recs = trim(htmlspecialchars(mysqli_real_escape_string($con, $_POST['dev_recs'])));
		$deve_edu = trim(htmlspecialchars(mysqli_real_escape_string($con, $_POST['dev_edu'])));
		$deve_titles = trim(htmlspecialchars(mysqli_real_escape_string($con, $_POST['dev_titles'])));
		$sql = "UPDATE users SET user_title = '$deve_title', user_desc = '$deve_desc',
				 user_projects = '$deve_projects', user_skills = '$deve_skills', 
				 user_experience = '$deve_exps', user_recoms = '$deve_recs', 
				 user_education = '$deve_edu', user_titles = '$deve_titles' WHERE user_id = $deve_id";
		$res = mysqli_query($con, $sql);
		if ($res){
			header('Location: ../profile.php?u='. $deve_id);
		} else {
			die("Unable update details. Something went wrong <a class='btn btn-dark' href='../profile.php'>Back </a>");
		}		

	}



	
?>
</div>
</div>
</div>
</body>
</html>