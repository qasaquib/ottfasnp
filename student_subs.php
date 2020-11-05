<?php
session_start();
if(!(isset($_SESSION['usrtype'])))
	header('location:home.php');
else if($_SESSION['usrtype']=='student')
{
	require_once('server.php');

}
else if($_SESSION['usrtype']=='teacher')
{
	header('location:after_teacher_login.php');
}
else
{
  header('location:home.php');
}
?>
<!DOCTYPE html>
<html>
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/teach.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/footstyle.css">
    <link rel="stylesheet" type="text/css" href="css/navstyle.css">
    <link rel="stylesheet" type="text/css" href="css/restext.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
 <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/48e4b8916e.js"></script>

    <title>Teacher Finder :𝓣𝓮𝓪𝓬𝓱𝓮𝓻𝓕𝓲𝓷𝓭𝓮𝓻 : Find Your Teacher Online Or Offline</title>
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
<div class="container-fluid">
			<?php
			$email=$_SESSION['email'];
			$presentDate=date("Y-m-d H:i:s");
			$sql="SELECT * FROM subscriptions INNER JOIN teacher_data ON subscriptions.teacher_id = teacher_data.email WHERE subscriptions.end_date > '$presentDate' AND subscriptions.student_id like '$email'";
			//$sql="SELECT * from abc";
			if ($result = mysqli_query($conn, $sql)) {
    		while ($row = mysqli_fetch_row($result)) {
            $emailq=$row[2];
            $imgsql = "SELECT * FROM teacher_image where email like '".$emailq."' ORDER BY id DESC";
            $imgresult=mysqli_query($conn, $imgsql);
            if (mysqli_num_rows($imgresult) === 0)
            $src="avatar.png";
            else
            { while ($imgrow = mysqli_fetch_row($imgresult)) {
               $src=$imgrow[3];
               break;
              }  
            }
            			echo ('<a class="res-link" href="teacher_profile.php?disp_teach_id='.encodeMail('teacher',$row[2]).'">');
    					echo ('<div class="res-box-wd row ml-1" id="">');
    					echo ('<div class="col-2">');
    					echo '<img class="res-pic-wd" src="'.$src.'" alt="avatar.png" align=""/>';
    					echo ('</div>');
    					echo '<div class="res-info-wd col-10">';
    					echo ('<p> Name : '.$row[6]." ".$row[7]."</p><br/>");
    					echo ('<p> City : '.$row[13]."</p><br/>");
    					//echo ('<p> Address : '.$row[11]." ".$row[10]." ".$row[12].'</p>');
    					echo ('<p> State : '.$row[14].'<br/>Fees : ₹'.$row[17].'</p>');
              if($row[20])
              {
    					echo ('<p> Accepting Offline Students '.'</p>');// place holders
              }
              else
              {
              echo ('<p> Not Accepting Offline Students '.'</p>');
              }

    					echo ('</div>');
    					echo ('</div>');
    					echo ('</a>');
              
				}	 
			}
			?>
</div>