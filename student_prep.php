<?php
session_start();
require_once('server.php');
require_once('course.php');
$res;
$cresult;
$email;
$course_id;
$crow;
$exam_name;
$exam_id;
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
    header('location:after_teacher_login.php');
    exit();
  }
  else if($_SESSION['usrtype']=='admin')
  {
    header('location:admin/dashboard.php');
    exit();
  }
  else if($_SESSION['usrtype']=='student')
  {

    if(isset($_GET['exam_id']))
    {
      $exam_id=$_GET['exam_id'];
      //echo $course_id;
      $email=$_SESSION['email'];
      $sql1="SELECT * from exam_list where id = '$exam_id'";
      $cresult=mysqli_query($conn,$sql1);
      $status=mysqli_num_rows($cresult);
      if($status==1)
      {
      $crow=mysqli_fetch_assoc($cresult);
      $exam_name=$crow['name'];
      $presentDate=date("Y-m-d H:i:s");
      $sql2="SELECT * FROM teacher_course , teacher_data where teacher_course.teacher_id = teacher_data.email AND teacher_id IN (SELECT subscriptions.teacher_id FROM subscriptions INNER JOIN teacher_data ON subscriptions.teacher_id = teacher_data.email WHERE subscriptions.end_date > '$presentDate' AND subscriptions.student_id like '$email') AND teacher_course.comp_exam like '$exam_name'";
      $res=mysqli_query($conn,$sql2);
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
      $sql2="SELECT * FROM teacher_course , teacher_data where teacher_course.teacher_id = teacher_data.email AND teacher_id IN (SELECT subscriptions.teacher_id FROM subscriptions INNER JOIN teacher_data ON subscriptions.teacher_id = teacher_data.email WHERE subscriptions.end_date > '$presentDate' AND subscriptions.student_id like '$email') AND teacher_course.comp_exam <> 'NULL'";
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
        <div class="row">
          <div class="col-1">
          </div>
          <div class="col-10">
            <form class="form-group">
            <label class="text-info" for="examS">Select Exam</label>
              <select name="exam_id" id="examS" class="form-control custom-select sel">
                  <?php
                  $standard_arr=popExamWithId();
                  //$standard_json=json_encode($standard_arr);
                  ?>
              </select>
              <button type="submit" class="btn btn-info"> Filter </button>
            </form>
          </div>
          <div class="col-1">
          </div>
        </div>
    <?php

    if(isset($_GET['exam_id']))
    {
          $count=mysqli_num_rows($res);
          if($count > 0)
          {
            echo ('<h1 class="display-4 text-light">Courses Available For '.$exam_name.'</h1>');  
          }
          else
          {
          echo ('<h3 class="display-6 text-primary">Subscribe to Teachers with Courses on '.$exam_name.' to prepare for '.$exam_name.'</h3>');  
          }
          while($row = mysqli_fetch_assoc($res))
          {
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
    }// when supplied ID
     
    else
    {  
          $count=mysqli_num_rows($res);
          if($count==0)
          {
            echo ('<h3 class="display-6 text-primary">Subscribe to Teachers to Get Access to Their Courses</h3>');  
          }
          else if ($count > 0)
          {
            echo ('<h1 class="display-4 text-light">Courses Available</h1>');  
          }
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

    }
      ?>

      </div>
<script type="text/javascript" src="js/learn.js"></script>
</body>