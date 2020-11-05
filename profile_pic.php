<?php
session_start();
try
{
$email=$_SESSION['email'];
$path="";

if(isset($_POST['submit'])){
	$file = $_FILES['profile_pic'];
	$fileName = $file['name'];
	$fileSize = $file['size'];
	$fileError= $file['error'];
	$fileType= $file['type'];
	$fileTmpName=$file['tmp_name'];
	$fileExt = explode('.',$fileName);
	$fileActualExt = strtolower(end($fileExt));
	$allowed = array('jpg','jpeg','png','jfif');

	if(in_array($fileActualExt,$allowed))
	{
		if($fileError===0){
			if($fileSize<1000000000){
				$fileNameNew="propic".$email.".".$fileActualExt;
				if($_SESSION['usrtype']==='teacher')
				{
				$fileDestination = 'teacher/uploads/'.$fileNameNew;
				$path=$fileDestination;
				$db = mysqli_connect('localhost', 'root', '', 'teacher_finder');
				$sql = "SELECT * FROM teacher_image where 'email' like '".$email."'";
				$result=mysqli_query($db, $sql);
				if (mysqli_num_rows($result) === 0)
				$sql = "INSERT INTO teacher_image (email, cond , img_path) VALUES ('".$email."', '1','".$path."' )"; 
				else
				$sql = "UPDATE teacher_image SET (email, cond , img_path) VALUES ('".$email."', '1','".$path."')  where 'email' like '".$email."'";
				move_uploaded_file($fileTmpName, $fileDestination);
				$result=mysqli_query($db, $sql);
				//echo $email;
				//header("location:teacher_profile.php?disp_teach_id=".$email."");
				header("location:after_teacher_login.php");
				}
				else if ($_SESSION['usrtype']=='student') {
				$fileDestination = 'student/uploads/'.$fileNameNew;
				$path=$fileDestination;
				$db = mysqli_connect('localhost', 'root', '', 'teacher_finder');
				$sql = "SELECT * FROM student_image where 'email' like '".$email."'";
				$result=mysqli_query($db, $sql);
				if (mysqli_num_rows($result) === 0)
				$sql = "INSERT INTO student_image (email, cond , img_path) VALUES ('".$email."', '1','".$path."' )"; 
				else
				$sql = "UPDATE teacher_image SET (email, cond , img_path) VALUES ('".$email."', '1','".$path."')  where 'email' like '".$email."'";
				move_uploaded_file($fileTmpName, $fileDestination);
				$result=mysqli_query($db, $sql);
				//echo $email;
				//header("location:teacher_profile.php?disp_teach_id=".$email."");
				header("location:after_student_login.php");
				}
				else
				{
					die("Error");
				}

			}
			else
			{
			echo "File was too big!";
			}
		}
		else{
			echo "There was an error uploading your file!";
		}
			}
			else{
			echo "You cannot upload files of this type";
		}
	}
}
catch(Exception $e)
	{
	 echo "ERROR has occured".$e;
	}

		