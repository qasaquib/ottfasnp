<?php
session_start();
require_once('server.php');
require_once('course.php');
$res;
$cresult;
$email;
$course_id;
$crow;
if(!isset($_SESSION['usrtype']))
{
	header('location:home.php');
	//echo "Hello".$_SESSION['usrtype'];
	exit();
}
else
{
	if($_SESSION['usrtype']=='teacher')
	{
		header('location:teacher_course.php');
		exit();
	}
	else if($_SESSION['usrtype']=='admin')
	{
		header('location:admin/dashboard.php');
		exit();
	}
	else if($_SESSION['usrtype']=='student')
	{

		if(isset($_GET['course_id']))
		{
			$course_id=$_GET['course_id'];
			//echo $course_id;
			$email=$_SESSION['email'];
			$sql1="SELECT * from teacher_course where course_id = '$course_id'";
			$cresult=mysqli_query($conn,$sql1);
			$status=mysqli_num_rows($cresult);
			if($status==1)
			{
			$crow=mysqli_fetch_assoc($cresult);
			$teacher_id=$crow['teacher_id'];
			$presentDate=date("Y-m-d H:i:s");
			$sql2="SELECT * FROM subscriptions INNER JOIN teacher_data ON subscriptions.teacher_id = teacher_data.email WHERE subscriptions.end_date > '$presentDate' AND subscriptions.student_id like '$email' AND subscriptions.teacher_id = '$teacher_id'";
			$result=mysqli_query($conn,$sql2);
				if(mysqli_num_rows($result)==1)
				{
          //$narrower_arr=getSubject();
					$narrower_arr=$g_array;
					getSubjectVod();
					array_push($narrower_arr, "NA","Others");
          $examArray=getExam();
					$course= new Course($teacher_id,$narrower_arr,$examArray);
					$res=$course->getCourseData($course_id);
					if($res==false)
					{
						die("Error");
					}
					else
					{
						// Start HTML;
						//echo 'Success';
					}
				}
				else
				{
					echo "Not Subscribed To Teacher";
				}
			}
			else
			{
				die("Error");
			}
		}
		else
		{
      $email=$_SESSION['email'];
			//die("An Error Has Occured");
      $presentDate=date("Y-m-d H:i:s");
      $sql2="SELECT * FROM teacher_course , teacher_data where teacher_course.teacher_id = teacher_data.email AND teacher_id IN (SELECT subscriptions.teacher_id FROM subscriptions INNER JOIN teacher_data ON subscriptions.teacher_id = teacher_data.email WHERE subscriptions.end_date > '$presentDate' AND subscriptions.student_id like '$email') and comp_exam like ''";
      $res=mysqli_query($conn,$sql2);
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Find Your Teacher Online Or Offline</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/learn.css">
  <link rel="stylesheet" type="text/css" href="css/footstyle.css">
  <link rel="stylesheet" type="text/css" href="css/navstyle.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
      <div class="container-fluid course-cont" id="id10">
    <?php
    if(isset($_GET['course_id']))
    {
      	echo '<div class="row">
      	<div class="col-md-3 p-2">
      	<p class="mat-container">';
      	$src;
      	$week="wk0";
      	$pweek="wk0";
      	foreach ($res as $row) {
      	//print_r($row);
      	$week=$row['week_no'];
      	if(strcmp($pweek, $week)<0)
      	{
      		echo '<div>';
      		echo '<a class="bres-link" id="'.$week.'">Week'.substr($week,2).'</a>';
      		echo '</div>';
      		$pweek=$week;
      	}
      	echo '<div>';
      	if($row['mat_type']=='vod')
      	{
      	$type=$row['mat_type'];
      	$id=$row['mat_id'];
      	$sql="SELECT * FROM teacher_vod WHERE id='$id'";
      	$subRes=mysqli_fetch_assoc(mysqli_query($conn,$sql));
      	$videoID=extract_vod_id($subRes['vod_link']);
      	$src="https://www.youtube.com/embed/".$videoID."?enablejsapi=1";
      	echo '<a target="view-frame" href= "'.$src.'" data-link-vod="'.$subRes['vod_link'].'" class="res-link '.$type." ".$week.'-clink" hidden>'.$subRes['name'].'</a>';
      	}
      	else if($row['mat_type']=='doc')
      	{
      	$type=$row['mat_type'];
      	$id=$row['mat_id'];
      	$sql="SELECT * FROM teacher_docs WHERE id='$id'";
      	$subRes=mysqli_fetch_assoc(mysqli_query($conn,$sql));
      	echo '<a target="view-frame" href="doc_viewer.php?doc_id='.$id.'" class="res-link '.$type." ".$week.'-clink" hidden>'.$subRes['name'].'</a>';
      	}
      	echo '</div>';
      	}
		    echo '</p>';
      	echo '</div>';
        echo '<div class="col-md-9 p-2 text-center">';
        echo '<div class="cinfo"><h1 class="display-4 cinfo text-light">'.$crow['name'].'</h1>';
        echo '<h1 class="display-6 cinfo text-light">'.$crow['subject'].'</h1>';
        echo '<h1 class="display-6 cinfo text-light">'.$crow['num_weeks'].' Weeks</h1></div>';
       	echo '<iframe id="pv-frame" name="view-frame" class="vframe" src=""></iframe>
       </div>
   		</div>';
    }// when supplied ID
    else
    {  
          echo ('<h1 class="display-4 text-light">Courses Available</h1>');  
          $count=0;
          while($row = mysqli_fetch_assoc($res))
          {
              $count++;
              echo ('<a class="cres-link" target "_blank" href="student_course.php?course_id='.$row['course_id'].'">');
              echo ('<div class="cres-box-wd row m-2" id="">');
              echo '<div class="cres-info-wd col-4">';
              echo ('<h1 class="display-6">'.$row['name']." "."</h1><br/>");
              echo ('</div>');
              echo '<div class="cres-info-wd col-4">';
              echo ('<p> Course By : '.$row['fname']." ".$row['lname']."</p><br/>");
              echo ('</div>');
              //echo ('<p> Address : '.$row[11]." ".$row[10]." ".$row[12].'</p>');
              echo '<div class="cres-info-wd col-4">';
              echo ('<p> Subject : '.$row['subject'].'</p>');
              //echo ('<p> Rating : '.$row[18].'</p>');// place holders
              echo ('</div>');
              echo ('</div>');
              echo ('</a>');
          }
          if($count==0)
          {
            echo ('<h1 class="display-4 text-primary">Subscribe to Teachers to Get Access to Their Courses</h1>');  
          }
    }
      ?>

      </div>
<script type="text/javascript" src="js/learn.js"></script>
</body>