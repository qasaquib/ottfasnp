<?php
session_start();
require_once 'server.php';

?>
<!DOCTYPE html>
<html>
<head>
	<title>TeacherFinder - Verify</title>
</head>
<body>
<?php
if(isset($_GET['vid']))
{
	if(isset($_SESSION['usrtype']))
	{
		if($_SESSION['usrtype']!='teacher')
		{
			header('location:home.php');
		}
		else
		{
			$email=$_SESSION['email'];
			$vid=$_GET['vid'];
			$sql="SELECT * FROM teacher_verified WHERE email='$email' AND link ='$vid' AND verified_mail = '0'";
			if(mysqli_num_rows(mysqli_query($conn,$sql))==1)
			{
				$sql="UPDATE teacher_verified SET verified_mail = '1' , link = ''";
				mysqli_query($conn,$sql);
				echo "Email Verified";
				echo "<script> setTimeout(function(){
            window.location.href = 'localhost/project/home.php';
         }, 5000);</script>";
			$test=checkSearchable();
			if($test)
			{
				$sql="UPDATE teacher_data SET searchable = '1' WHERE email = '$email'";
				$result=mysqli_query($conn,$sql);
				$_SESSION['searchable']=1;
			}
			else
			{
				$sql="UPDATE teacher_data SET searchable = '0' WHERE email = '$email'";
				$result=mysqli_query($conn,$sql);
				$_SESSION['searchable']=0;
			}
			}
			else
			{
				echo "Invalid Verification Link";
			}
		}
	}
	else
	{
		$_SESSION['vid']=$_GET['vid'];
		header('location:teacher_signin.php');
	}
}
?>
</body>
</html>