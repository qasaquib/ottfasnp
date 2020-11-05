<?php
	session_start();
	$db = mysqli_connect('localhost', 'root', '', 'teacher_finder');
	if(isset($_POST['email_stu']))
	{
		echo strtolower($_POST['email_stu'])."&nbsp";
		$var=$_POST['email_stu'];
		$query = "SELECT * FROM student_data WHERE email='$var'";
 		$result = mysqli_query($db, $query);
 		if (mysqli_num_rows($result) == 1) {
 			echo "is already taken";
 		}
 		else{ 
 			echo("is available");
 		}
	}


	if(isset($_POST['email_tea']))
	{
		echo strtolower($_POST['email_tea'])."&nbsp";
		$var=$_POST['email_tea'];
		$query = "SELECT * FROM teacher_data WHERE email='$var'";
 		$result = mysqli_query($db, $query);
 		if (mysqli_num_rows($result) == 1) {
 			echo "is already taken";
 		}
 		else{ 
 			echo("is available");
 		}
	}
	if(isset($_POST['email_edit']))
	{

	  if(isset($_SESSION['usrtype']))
	  {
	  		if($_SESSION['usrtype']=='teacher')
	  		{
			echo strtolower($_POST['email_stu'])."&nbsp";
			$var=$_POST['email_stu'];
			$query = "SELECT * FROM student_data WHERE email='$var'";
 			$result = mysqli_query($db, $query);
 			if (mysqli_num_rows($result) == 1) {
 			echo "is already taken";
 			}
 			else
 			{ 
 			echo("is available");
 			}
 		    }
 		    else if($_SESSION['usrtype']=='student')
 		    {
 		    	
 		    }
 	  }
	}
?>