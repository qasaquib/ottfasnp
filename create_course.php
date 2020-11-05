<?php
session_start();
require_once('server.php');
require_once('course.php');
$narrower_arr=$g_array;
getSubjectVod();
array_push($narrower_arr, "NA","Others");
$examArray=getExam();
if($_SESSION['usrtype']=='teacher')
{
	if(isset($_POST['course_pub']))
	{
	//print_r($_POST);
	$course= new Course($_SESSION['email'],$narrower_arr,$examArray);
	//$chk=$course->writeCourseData($_POST,$GLOBALS['narrower_arr']);
	$chk=$course->writeCourseData($_POST);
	//echo $chk['info'];
	$_SESSION['cou']['msg']=$chk;
	header('location:teacher_course.php');
	die();
	}
}
else
{
	header('location: home.php');
}
die();
?>