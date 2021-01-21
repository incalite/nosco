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
		
</head>
<body>


	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="box-shadow: 0px 5px 5px #afd;">
	  <a class="navbar-brand" href="#">Nosco</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item">
	        <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item active">
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

		<div class="row">
			<div class="col-md-9">
				<?php 	
					$u_id = htmlspecialchars($_GET['u']);
					$sql = "SELECT * FROM users WHERE user_id = $u_id";
					$query = mysqli_query($con, $sql);
					$rep = mysqli_query($con, "SELECT COUNT(inq_id) as active_rep FROM inquiries WHERE user_inq_id = $u_id");
					$rep_active = mysqli_fetch_array($rep);
					$reputation = (int) $rep_active['active_rep'] * 10; 
					include 'core/library.php';
					$class = get_rank($reputation);

					while ($row = mysqli_fetch_array($query)){ ?>
						<div class="row">
							<div class="col">
								<!-- USER INFORMATION -->
								<h2>
									<i class="fa fa-user-circle"></i> <?= $row['firstname'] . ' ' . $row['lastname'] ?>
									<font style="font-size: 18px;">[ <?= $row['user_name'] ?> <span class="badge badge-pill badge-warning">Reputation: <?= $reputation ?></span> ] <?= $class; ?></font>
								</h2>
								<h5 class="userTitle"><pre><i class="fa fa-cube"></i> <?= $row['user_title'] ?></h5>
								<h3 class="profTitle"><i class="fa fa-coffee"></i> Biography</h3>
								<p class="userBio"><?= $row['user_desc']; ?></p>
							</div>
						</div>

						<?php 
							$achievements = explode(',', $row['user_projects']);
							$skills = explode(',', $row['user_skills']); 
							$exps = explode(',', $row['user_experience']);
							$recs = explode(',', $row['user_recoms']);
							$edu = explode(',', $row['user_education']);
							$titles = explode(',', $row['user_titles']);
							
						?> 
						<div class="row">
							<div class="col-md-6">
								<h3><i class="fa fa-mortar-board"></i> Achievements</h3>
								<?php if ($achievements) {  
									foreach($achievements as $achv) { ?> 
										<a class="btn btn-light achClass" style="margin:2px 0;"><?= $achv; ?></a>
									<?php } ?>
								<?php } ?>
							</div>
							<div class="col-md-6">
								<h3><i class="fa fa-code"></i> Skills & Endorsements</h3>
								<?php if ($skills) {  
									foreach($skills as $skill) { ?> 
										<a class="btn btn-light skillClass" style="margin:2px 0;"><?= $skill; ?></a>
									<?php } ?>
								<?php } ?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<h3><i class="fa fa-cogs"></i> Experience</h3>
								<?php if ($exps) {  
									foreach($exps as $exp) { ?> 
										<a class="btn btn-light expClass" style="margin:2px 0;"><?= $exp; ?></a>
									<?php } ?>
								<?php } ?>
							</div>
							<div class="col-md-6">
								<h3><i class="fa fa-commenting-o"></i> Recommendations</h3>
								<?php if ($recs) {  
									foreach($recs as $rec) { ?> 
										<a class="btn btn-light recClass" style="margin:2px 0;"><?= $rec; ?></a>
									<?php } ?>
								<?php } ?>
							</div>
						</div>


						<div class="row">
							<div class="col-md-6">
								<h3><i class="fa fa-institution"></i> Education</h3>
								<?php if ($edu) {  
									foreach($edu as $ed) { ?> 
										<a class="btn btn-light eduClass" style="margin:2px 0;"
										><?= $ed; ?></a>
									<?php } ?>
								<?php } ?>
							</div>
							<div class="col-md-6">
								<h3><i class="fa fa-briefcase"></i> Titles</h3>
								<?php if ($titles) {  
									foreach($titles as $title) { ?> 
										<a class="btn btn-light titlesClass" style="margin:2px 0;"><?= $title; ?></a>
									<?php } ?>
								<?php } ?>
							</div>
						</div>

						<hr>
						
						<?php if ($uid == $u_id){ ?> 
							<div class="row">
								<div class="col">
									<a href="core/student_cv.php?student=<?= $uid ?>" target="_blank" id="cv" class="btn btn-info"><i class="fa fa-download"></i> Build CV</a>
									<a href="#" id="openBox" class="btn btn-dark" data-toggle="modal" data-target="#detailsModal"><i class="fa fa-wrench"></i> Edit Details</a>
									
									<!-- Modal -->
									<div id="detailsModal" class="modal fade" role="dialog">
										<div class="modal-dialog">
									    	<div class="modal-content">
									    		<div class="modal-header">
											    	<h4 class="modal-title">Update your profile details...</h4>
											    </div>

									    		<div class="modal-body">
													<form method="POST" action="core/core.php" onsubmit="return validateUpdates()">
														<input type="hidden" name="dev_id" value="<?= $uid; ?>"/>
														<!-- USER DETAILS UPDATES -->
														<label>Professional Title</label>
														<input class="form-control" id="utitle" type="text" name="dev_title" value="<?= $row['user_title']; ?>"/>
														
														<label>Biography</label>
														<textarea style="resize:none;" class="form-control" id="ubio" name="dev_desc" rows="2"><?= $row['user_desc']; ?></textarea>

														<label>Projects (Separate by commas)</label>
														<textarea style="resize:none;" class="form-control" id="uproj" name="dev_projects" rows="2"><?= $row['user_projects'] ?></textarea>
															
														<label>Experience (Separate by commas)</label>
														<textarea style="resize:none;" class="form-control" id="uexps" name="dev_exps" rows="2"><?= $row['user_experience'] ?></textarea>
															
														<label>Recommendations (Separate by commas)</label>
														<textarea style="resize:none;" class="form-control" id="urecs" name="dev_recs" rows="2"><?= $row['user_recoms'] ?></textarea>
														
														<label>Education (Separate by commas)</label>
														<textarea style="resize:none;" class="form-control" id="urecs" name="dev_edu" rows="2"><?= $row['user_education'] ?></textarea>
														
														<label>Titles (Separate by commas)</label>
														<textarea style="resize:none;" class="form-control" id="urecs" name="dev_titles" rows="2"><?= $row['user_titles'] ?></textarea>
															
														<label>Skills (Separate by commas)</label>
														<input class="form-control" type="text" name="dev_skills" id="uskills" value="<?= $row['user_skills']; ?>"/>
														
														<input type="submit" name="dev_details" class="btn btn-dark form-control" value="Update Details"/>
														
													</form>
												</div>
											</div>
										</div><!-- END OF MODAL -->
									</div>

								</div>
							</div>
						<?php } ?>
					<!-- END OF USER INFORMATION -->
				<?php } ?>
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
							<a href="./core/search.php?query_string=<?= $d ?>&target_field=tag_query" 
							class="form-control badge badge-pill badge-dark" style='margin: 2px 0;color: #fff; padding: 10px;'><?= $d ?></a>
						<?php } ?>
				<?php } ?>
				</ul>
			</div>
		</div>

		<div class="row">
			<div class="col" id="output"></div>
		</div>
	</div>
	<script src="js/main.js"></script>
</body>
</html>

