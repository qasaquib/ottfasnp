<?php
session_start();
if(!isset($_SESSION['usrtype']))
{
	header('location:home.php');
	exit();
}
else if($_SESSION['usrtype']!='teacher')
{
	header('location:home.php');
	exit();
}
require_once('server.php');
require_once('teacher_tables.php');
//Pagination
  $uid=$_SESSION['email'];
  $res;
  $preres=0;

//End of pagination
?>
<!DOCTYPE html>
<html>
<head>
	<title>Find Your Teacher Online Or Offline</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" type="text/css" href="css/footstyle.css">
	<link rel="stylesheet" type="text/css" href="css/navstyle.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/restext.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
	<script src="https://kit.fontawesome.com/48e4b8916e.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="ckeditor/ckeditor.js"></script>
	<script src="js/teachcourse.js"></script>
	<link rel="stylesheet" type="text/css" href="css/teachcourse.css">
	</head>
	<body class="bg-black text-light">
	 <?php require 'navbar.php';
      $chk=isset($_SESSION['usrtype']);
      if ($chk){
      if($_SESSION['usrtype']=='teacher')
      teacher_navbar();
      else if($_SESSION['usrtype']=='student')
      student_navbar();
  	  }
      else{
      	default_navbar();
      }
	?>
	<div class="container-fluid">
	  <div class="row">
	  	<div class="col" id="client-result">
	  		<?php
	  		if(isset($_SESSION['cou']['msg']))
	  		{
	  			//print_r($_SESSION['msg']);
	  			if($_SESSION['cou']['msg']['info'] == "Success!")
	  			{
	  				echo '<div class="alert alert-success" role="alert">Course Added to your library</div>';
	  			}
	  			else
	  			{
	  				echo '<div class="alert alert-danger" role="alert">An error has occured. Please contact support!</div>';
	  			}
	  			unset($_SESSION['cou']['msg']);
	  		} 
	  		?>
	  	</div>
	  </div>
	  <div class="row">
	  	<div class="col-1">
	  	</div>
	  	<div class="col-10">
	  		<?php
echo <<<EOT
<form class="form-inline" method="post" onsubmit="return nosubmit(event)">
  <div class="form-group m-2 p-2">
    <label for="perpg" class="m-2">Number of Results</label>
    <select class="form-control" id="cou_perpg" name="perpg">
EOT;
	$printvar=conEcho($_SESSION['cou']['perpg'],'3');
     echo '<option value="3" '.$printvar.'>3</option>';
     	$printvar=conEcho($_SESSION['cou']['perpg'],'5');
      echo '<option value="5" '.$printvar.'>5</option>';
      	$printvar=conEcho($_SESSION['cou']['perpg'],'10');
      echo '<option value="10" '.$printvar.'>10</option>';
      	$printvar=conEcho($_SESSION['cou']['perpg'],'20');
      echo '<option value="20" '.$printvar.'>20</option>';
      	$printvar=conEcho($_SESSION['cou']['perpg'],'30');
      echo '<option value="30" '.$printvar.'>30</option>';
echo <<<EOT
    </select>
  </div>
  <div class="form-group m-2 p-2">
    <label for="orderer" class="m-2">Select Order</label>
    <select class="form-control" id="cou_orderer" name="orderer">
EOT;
	   $printvar=conEcho($_SESSION['cou']['orderer'],'ASC');
      echo '<option value="ASC" '.$printvar.'>Ascending</option>';
	   $printvar=conEcho($_SESSION['cou']['orderer'],'DESC');
      echo '<option value="DESC" '.$printvar.'>Descending</option> ';
echo <<<EOT
    </select>
  </div>
    <div class="form-group m-2 p-2">
    <label for="sorter" class="m-2">Sort By</label>
    <select class="form-control" id="cou_sorter" name="sorter">
EOT;
	 $printvar=conEcho($_SESSION['cou']['sorter'],'name');
      echo '<option value="name" '.$printvar.'>Name of Course</option>';
	 $printvar=conEcho($_SESSION['cou']['sorter'],'course_date');
     echo '<option value="course_date" '.$printvar.'>Upload Date</option>';
	 $printvar=conEcho($_SESSION['cou']['sorter'],'subject');
     echo '<option value="subject" '.$printvar.'>Course Subject</option>';
     echo $_SESSION['cou']['sorter'];
echo <<<EOT
    </select>
  </div>
  <div class="form-group m-2 p-2">
    <label for="narrower" class="m-2">Narrow By Category</label>
    <select class="form-control" id="cou_narrower" name="narrower">
      
EOT;
$printvar=conEcho($_SESSION['cou']['narrower'],'NA');
echo '<option value="NA" '.$printvar.'>Do Not Narrow</option>';
popSubject();
$printvar=conEcho($_SESSION['cou']['narrower'],'Others');
echo '<option value="Others"'.$printvar.'>Others</option>';
echo <<<EOT
    
    </select>
  </div>
  <div class="form-group m-2 p-2">
  <button type="button" class="btn btn-secondary mb-2" name="custom_sub_cou" onclick="subCou()">Search</button>
  </div>
</form>
EOT;


?>
		<div id="cou-tab-cont">
			<?php
			printCouTable();
			?>
		</div>
	  	</div>
	  	<div class="col-1">
	  	</div>
	  </div>
	  <div class="row">
			<div class="col-2">
			</div>
			<div class="col-8">
				<form action="create_course.php" method="post" class="form-group" id="courseform">
					<label for="subject">Select Course Subject</label>
					<div class="form-group">
					<select name="subject" id="subject" class="form-control form-control">
						<?php
						popSubject();
						?>
					</select>
					</div>
					<label for="course_name">Enter Course Name</label>
					<div class="form-group">
						<input type="text" name="course_name" id="course_name" class="form-control" required/>
					</div>
					<label for="course_weeks">Select Course Duration</label>
					<div class="form-group">
						<select name="course_weeks" id="course_weeks" class="form-control">
							<?php
							popCWeeks();
							?>
						</select>
					</div>
					<label for="course_assoc">Select Corresponding Exam (If Any)</label>
					<div class="form-group">
						<select name="course_assoc" id="course_assoc" class="form-control form-control mb-3">
						<option value="">None</option>
						<?php
						popExam();
						?>
					</select>
					</div>
					<div class="form-group">
						<button class="btn btn-success" type="submit" name="course_pub">Publish</button>
					</div>
					</form>
				</div>
				
			<div class="col-2">
				
			</div>
		</div>
	</div>
	<footer id="footer">
  <div class="footer-top">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-6  footer-info">
        <h3>Teacher Finder</h3>
        <p></p>
      </div>
     
      <div class="col-lg-3 col-md-6 footer-contact">
        <h4>Contact us</h4>
        <p>
          Supratim Ghosh<br>Quazi Ahmed Saquib<br>
          
          <strong>Phone: </strong>+91 7550853867<br>
          <strong>Email: </strong>teacherfinder@gmail.com<br>  
        </p>
        <div class="social-links">
          <a href="https://twitter.com/dipsupratim"><i class="fab fa-twitter"> </i></a>
          <a href="https://www.facebook.com/supratim.ghosh.104855"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.instagram.com/supratim0000/"><i class="fab fa-instagram"></i></a>
          <a href="https://www.linkedin.com/in/supratim-ghosh-a75566159/"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 footer-newsletter">
        <h4>Get all updates</h4>
        <p></p>
        <form action="subscribe.php" method="post">
          <input type="email" name="email" placeholder="email id"><input type="submit" value="SUBSCRIBE">
        </form>
      </div>
    </div>
  </div>
</div>
</footer>
	<script type="text/javascript" src="js/validCourse.js"></script>
	</body>
	</html>