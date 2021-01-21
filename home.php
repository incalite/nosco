<?php 

	include 'core/DB.php';

	
	session_start();	
	if (!isset($_SESSION['stud_id'])){
		header('Location: index.php');
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
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/nosco.css">
		<link href='https://fonts.googleapis.com/css?family=Rock+Salt' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Inika' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<style>
			#postTrigger {
				border: 1px solid #eee;
				padding: 15px 0;
				margin: 10px 0;
				font-size: 14px;
			} 

			#submitForm { 
				margin: 10px 0;

			}
		</style>

</head>
<body>


	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="box-shadow: 0px 5px 5px #afd;">
	  <a class="navbar-brand" href="home.php">Nosco</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item active">
	        <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="profile.php?u=<?= $uid; ?>">Profile</a>
	      </li>
	      <li class="nav-item">
	      	<a class="btn btn-outline-light" href="./core/logout.php">Logout &nbsp <strong><?= $_SESSION['stud_name'] ?></strong></a>
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
				<form method="get" action="core/search.php">
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

		<!-- SINGLE EXAMPLE -->
		<div class="row">
			<div class="col-md-9">
				<h4>Ask a question!</h4>
				<hr>
				<div id="postTrigger" class="bg-light text-center">
					Tap to post <i id="postChev" class="fa fa-chevron-down"></i></div>
				<form id="postForm" action="core/core.php" method="post" onsubmit="return validatePost()">
					<input type="hidden" value="<?= $uid; ?>" name="q_user_id"/>
					<label>Choose a title</label>
					<input type="text" class="form-control" id="ptitle" name="q_title" placeholder="Write a title">
					<label>Type your question and be specific!</label>
					<textarea class="form-control" style="height:100px;resize:none;" id="pquestion" name="q_body" placeholder="Describe your question"></textarea>
					<input type="text" class="form-control" name="q_tags" id="ptags" placeholder="Add tags using commas">
					<span class="badge badge-success">Beginner</span> <input type="radio" checked="checked" name="q_level"value="Beginner">
					<span class="badge badge-warning">Intermediate</span> <input type="radio" name="q_level" value="Intermediate">
					<span class="badge badge-danger">Advanced</span> <input type="radio" name="q_level" value="Advanced">
					<span class="badge badge-dark">Expert</span> <input type="radio" name="q_level" value="Expert">
					<input type="submit" class="btn btn-dark form-control" id="submitForm" name="q_submit" value="Post Question"/>	
				</form>

				<hr>

				<!-- MAIN FEED CONTENT -->
				<p class="text-right">Main Feed</p>
				<?php 
					$sql = "SELECT * FROM inquiries 
							ORDER BY 
								(SELECT COUNT(vote_id) 
								FROM votes 
								WHERE vote_q_id = inq_id) 
							DESC;";
					$res = mysqli_query($con, $sql);
					if (mysqli_num_rows($res) > 0) { 
						while ($row = mysqli_fetch_array($res)){ 

							$qid = (int)$row['inq_id'];
							$query = mysqli_query($con, "SELECT * FROM users WHERE user_id = '".$row['user_inq_id']."'");
							$user = mysqli_fetch_array($query); 
							$query_likes = mysqli_query($con, "SELECT COUNT(vote_id) AS likes FROM votes WHERE vote_q_id = '$qid'");
							$inq_likes = mysqli_fetch_array($query_likes);  ?>


							<div class="jumbotron" style="padding: 40px">
								<form action="core/core.php" method="post">
									<h4><span class="badge badge-dark"><?= $row['inq_level']; ?></span> 
									<?php if ($inq_likes['likes'] > 0){ ?>
										<span class="badge badge-info" style='font-size: 13px;padding:5px;'>Liked by <?= $inq_likes['likes'] ?></span> 
									<?php } ?>
									<i class="fa fa-question-circle-o"></i> <?= $row['inq_title']; ?></h4>	
									<p><i class="fa fa-folder-open-o"></i> <?= $row['inq_body']; ?></p>
									<?php $tags = explode(',', $row['inq_tags']); ?>
									<i class="fa fa-tags"></i> <?php if ($tags) {  
										foreach($tags as $tag) { ?> 
											<?php if (strlen($tag) != 1){ ?>
												<a href="./core/search.php?query_string=<?= $tag ?>&target_field=tag_query" class="badge badge-pill badge-dark" style='margin: 2px 0;color: #fff; padding: 10px;'><?= $tag ?></a>
											<?php } ?>
										<?php } ?>
									<?php } ?>
									<hr>
									<input type="hidden" name="q_id" value="<?= $qid ?>">
									<input type="hidden" name="u_id" value="<?= $uid ?>">
									
									<!-- MAIN QUESTION SECTION -->	
									<div class="row">
										<!-- VOTES -->
										<div class="col-md-2 text-center">
											<?php if ($uid != $row['user_inq_id']){ ?> 
												<div class="alert <?= ($inq_likes['likes'] > 0) ? 'alert-success' : 'alert-light'; ?>" role="alert">
													<a href="core/core.php?qq_id=<?= $qid; ?>&uq_id=<?= $uid ?>" class="badge badge-light form-control"><i class="fa fa-angle-up" style="font-size:22px;"></i></a>
													<span style="margin: 5px auto;" class="badge badge-pill <?= ($inq_likes['likes'] > 0) ? 'badge-success' : 'badge-danger'; ?>"><?= $inq_likes['likes']; ?></span>
													<a href="core/core.php?qq_id=<?= $qid; ?>&uq_id=<?= $uid ?>&rm=true" class="badge badge-light form-control"><i class="fa fa-angle-down" style="font-size:22px;"></i></a>
												</div>
											<?php } ?>
										</div>
										<!-- COMMENTS -->
										<div class="col-md-8">
											<?php if ($uid != $row['user_inq_id']){ ?>
												<textarea style="resize: none;" class="form-control" name="comm_body" ></textarea>
												<input type="submit" name="add_comment" class="btn btn-dark" value="Add Response"/>
											<?php } ?>
										</div>

										<!-- USER DETAILS -->
										<div class="col-md-2 text-center">
											<span style="display:block;" class="badge badge-warning">Posted by</span>
											<a href="profile.php?u=<?= $user['user_id'] ?>"><h3 class="badge badge-dark form-control" style="font-size:17px;margin:0;"><?= $user['user_name']; ?></h3></a>
											<?php if ($uid == $row['user_inq_id']){ ?> 
												<!-- DELETE QUESTION -->
												<a href="core/core.php?q_id=<?= $qid ?>" class="btn btn-outline-danger form-control text-center"><i class="fa fa-ban"></i></a>
											<?php } ?>
										</div>
									</div>



									<!-- RESPONSES SECTION -->
									<p class="alert alert-dark"><i>Responses</i></p>
									<div class="row">
										<?php 
											$query_resp = mysqli_query($con, "SELECT * FROM comments WHERE inquiry_id = '$qid'");
											if ($query_resp){
												while ($response = mysqli_fetch_array($query_resp)){ ?>
														<input type="hidden" name="resp_id" value="<?= $response['comment_id'] ?>">
														<?php 
															$comment_likes = mysqli_query($con, "SELECT COUNT(cvote_id) AS clikes FROM cvotes WHERE cvote_c_id = '". $response['comment_id'] ."'");
															$com_likes = mysqli_fetch_array($comment_likes);
														?>
														<div class="col-md-2 text-center" style="margin: 10px auto;">
															<!-- SIGNATURE -->
															<span style="display:block;" class="badge badge-warning">Posted by</span>
															<?php 
																$sql = mysqli_query($con,"SELECT * FROM users WHERE user_id = '". $response['user_c_id'] . "' "); 
																$comment_user = mysqli_fetch_array($sql);
															?>
															<a href="profile.php?u=<?= $comment_user['user_id'] ?>"><h3 class="badge badge-dark form-control" style="font-size:17px;margin:0;"><?= $comment_user['user_name']; ?></h3></a>
															<?php if ($uid == $response['user_c_id']){ ?> 
																<a href="core/core.php?cid=<?= $response['comment_id']?>" class="btn btn-outline-dark form-control" style="margin-top:1px; padding:0;"><i class="fa fa-ban"></i></a>
															<?php } ?>
														</div>

														<div class="col-md-10" style="font-size:16px; margin: 10px auto;">
															<!-- RESPONSE COMMENT BODY -->
															<p><?= $response['comment_body'] ?></p>
														</div>
											<?php } ?>
										<?php } else { ?>
											<div class="alert alert-dark">No responses yet.</div>
										<?php } ?> 	
									</div>
								</form>
							</div>
						<?php } 
					} else { ?>
					  	<div class="alert alert-dark">No questions yet.</div>
					<?php } ?>
			</div>


			<div class="col-md-3">
				<h4>Student Area</h4>
				<p>Helpful websites for students</p>
					<div class="btn-group-vertical form-control">
						<a class="btn btn-outline-primary form-control" href="https://eclass.teimes.gr" target="_blank">eClass</a>
						<a class="btn btn-outline-primary form-control" href="https://e-students.teiwest.gr" target="_blank">Students Web</a>
						<a class="btn btn-outline-primary form-control" href="https://webmail.teimes.gr/" target="_blank">Webmail</a>
						<a class="btn btn-outline-dark form-control" href="http://www.library.teiwest.gr/" target="_blank">Library</a>
						<a class="btn btn-outline-dark form-control" href="http://academicid.minedu.gov.gr/" target="_blank">AcademicID</a>
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
							<a href="./core/search.php?query_string=<?= $d ?>&target_field=tag_query" 
							class="form-control badge badge-pill badge-dark" style='margin: 2px 0;color: #fff; padding: 10px;'><?= $d ?></a>
						<?php } ?>
				<?php } ?>
				</ul>
			</div>
	</div>
		
	<!-- COPYRIGHTS -->
	<div class="text-center">
		<a style="color: #444; text-decoration: none;">Copyright <script>const d = new Date(); const year = d.getFullYear(); document.write(year);</script> - George Zafiris</a>
	</div>
		
</div>
</body>
</html>
<script>
	function validatePost(){

		var title = $('#ptitle');
		var question = $('#pquestion');
		var tags = $('#ptags');
		var pattGen = /^\s+$/;

		if (title.val() == null || title.val() == "" || title.val().match(pattGen)) {
			title.css({
				"border":"1px solid red"
			});
			return false;
		} else {
			title.css({
				"border":"1px solid #aaa"
			});
		}
	   	
	   	if (question.val() == null || question.val() == "" || question.val().match(pattGen)){
	   		question.css({
	   			"border":"1px solid red",
	   		});
	   		return false;
	   	} else {
	   		question.css({
	   			"border":"1px solid #aaa"
	   		});
	   	}

	   	if (tags.val() == null || tags.val() == "" || tags.val().match(pattGen)) {
			tags.css({
				"border":"1px solid red"
			});
			return false;
		} else {
			tags.css({
				"border":"1px solid #aaa"
			});
		}
		return true;

	}

	$(document).ready(function(){
		$('#postForm').hide();
		$('#postTrigger').on('click',function(){
			$(this).find('#postChev').toggleClass('fa fa-chevron-down fa fa-chevron-up');
			$('#postForm').toggle(800);
		});

	});
</script>
