<?php 
include ('teacher_server.php');
    if(isset($_SESSION['usrtype']))
    {
        if($_SESSION['usrtype']!='teacher')
        {
          header("location:home.php");
          exit();
        }
      }
      else
      {
      header('location: home.php');
      exit();
      }
    //echo $_SESSION['success'];
    //echo $_SESSION['usrtype'];
    //echo $_SESSION['email'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Teacher Finder :𝓣𝓮𝓪𝓬𝓱𝓮𝓻𝓕𝓲𝓷𝓭𝓮𝓻 : Find Your Teacher Online Or Offline</title>
	
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="css/footstyle.css">
    <link rel="stylesheet" type="text/css" href="css/navstyle.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/48e4b8916e.js"></script>
</head>
<body class="bg-black">
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
  <!-- rest body-->
	<div class="container-fluid">
        <div class="row">
          <div class="col-sm">
            <?php
            if((int)$_SESSION['searchable']==0)
            echo '<a href="teacher_setup.php"><div class="alert alert-warning" role="alert">You are not presently searchable by students for one or more reasons! Click here to resolve! </div></a>'; 
            ?>
          </div>
      </div>
		<div class="row">
			    <div class="col-6 sbox">
      				<a class="cwl" href="addvideo.php" target="_blank"> Add Videos</a>
              <a class="cwl" href="addnotes.php" target="_blank"> Add Notes</a>
              <a class="cwl" href="teacher_course.php" target="_blank"> Create New Course</a>
              <a class="cwl" href="forum.php" target="_blank"> Doubt Forum</a>
              <a class="cwl" href="teacher_offline.php" target="_blank">Offline Manager</a>
              <a class="cwl" href="teacher_notify.php" target="_blank"> Send Notification</a>
    			</div>
          <div class="col-6 bg-secondary p-3">
            <h3>Notifications</h3>
            <div style="height:40vh;overflow:auto; !important;">
            <?php
            $email=$_SESSION['email'];
            $sql="SELECT * FROM teacher_inbox WHERE teacher_id = '$email' ORDER BY msg_date DESC";
            $res=mysqli_query($db,$sql);
            while($row=mysqli_fetch_assoc($res))
            {
              echo '<div class="bg-info m-2 p-3">';
              echo 'Message From : ';
              echo '<strong>'.$row['sender'].'</strong><br/><br/>';
              echo '<p>'.$row['msg'].'</p></br>';
              echo '<p>Date Sent : '.$row['msg_date'].'</p></br>';
              echo '</div>';
            }
            ?>
          </div>
          </div>
          </div>
          </div>
<footer id="footer">
          
	</div>
</div>
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
</body>
</html>