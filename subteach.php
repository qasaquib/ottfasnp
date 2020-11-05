<?php
session_start();
if(isset($_SESSION['usrtype']))
{
if($_SESSION['usrtype']=='student')
{
$teacher_id=$_SESSION['disp_teach_id'];
$student_id=$_SESSION['email'];
$rand=mt_rand(0,99999999999999);
$date=date("Y-m-d H:i:s");
$dateObj=date_create($date);
$endDate=date_add($dateObj, date_interval_create_from_date_string('30 days'));
$endDate=date("Y-m-d H:i:s",date_timestamp_get($endDate));
require_once('server.php');
 if(isset($_POST['sub']))
 { 
 			$email=$_SESSION['email'];
			$presentDate=date("Y-m-d H:i:s");
			$sql="SELECT * FROM subscriptions WHERE end_date >= '$presentDate' AND student_id like '$student_id' AND teacher_id like '$teacher_id'";
			//$sql="SELECT * from abc";
			if ($result = mysqli_query($conn, $sql)) 
			{
    			if (mysqli_num_rows($result)>=1)
    			{
    				echo("An Error has occured!");
    				exit();
    			}
    		}
	$sql="INSERT INTO `subscriptions` VALUES('$rand','$student_id','$teacher_id','$date','$endDate')";
	$res=mysqli_query($conn,$sql);
	if($res!=NULL)
	{
	//echo $date.$endDate;
	echo 'Success';
	}
	else
	{
		echo "An error has occured!";
		exit();
	}
 }
 if(isset($_POST['offline']))
 {
 			$subject=$_POST['subject'];
 			//echo $subject;
 	 		$email=$_SESSION['email'];
			//$presentDate=date("Y-m-d H:i:s");
			$sql="SELECT * FROM teacher_offline WHERE student_id like '$student_id' AND teacher_id like '$teacher_id'";
			//$sql="SELECT * from abc";
			if ($result = mysqli_query($conn, $sql)) 
			{
    			if (mysqli_num_rows($result)>=1)
    			{
    				echo("An Error has occured!");
    				exit();
    			}
    		}
	$sql="INSERT INTO `teacher_offline` VALUES('$rand','$student_id','$teacher_id','$date','$subject')";
	$res=mysqli_query($conn,$sql);
	if($res!=NULL)
	{
	//echo $date.$endDate;
	echo 'Success';
	}
	else
	{
		echo "An error has occured!";
		exit();
	}
 }
//unset($_SESSION['disp_teach_id']);

}
else if($_SESSION['usrtype']=='teacher')
{
	unset($_SESSION['disp_teach_id']);
	header("location:after_teacher_login.php");
	exit();
}
else
{
unset($_SESSION['disp_teach_id']);
echo "Activate Modal";
}
}
else
{
	unset($_SESSION['disp_teach_id']);
	echo "Activate Modal";	
} 

?>