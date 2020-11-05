<?php
session_start();
 if(!isset($_SESSION['usrtype']))
 {
 	if(isset($_POST['aqSubmit']))
 	{
 	print "Please sign up to teacher finder";
 	}
 	else
 	{
 		header('location:home.php');
 		//echo 'hello';
 		//echo $_SESSION['usrtype'];
 		//echo $_SESSION["usrtype"];
 	}
 }
 elseif($_SESSION['usrtype']==='teacher')
 {
 $email=$_SESSION['email'];
 $rand=mt_rand(0,99999999999999);
 $ansid="none";
 $desc="";
 $shortdesc="";
 $date="";
 $category="";
 $errors=array();
 $db = mysqli_connect('localhost', 'root', '', 'teacher_finder');
 $test = "SELECT ans_id from forum_answer where ans_id=$rand";

 if(isset($_POST['aqSubmit']))
 {
 	
 	//mysqli_query($db, $sql);
 	$date=date("Y-m-d H:i:s");
 	$desc=$_POST['aqTextarea'];
 	$did=$_SESSION['did'];
 	$edit=0;
 	unset($_SESSION['did']);
 	$sqlstr = "SELECT ans_id from forum_answer where topic_id=$did";
 	$result=mysqli_query($db,$sqlstr);
	$rowcount=mysqli_num_rows($result);
	if($rowcount > 0)
	{
	 while ($row = mysqli_fetch_row($result)) {
	 	 $ansid=$row[0];
	 }
	 $edit = 1;
	}
 	while(true)
 	{
 	try {
			$result=mysqli_query($db,$test);
			$rowcount=mysqli_num_rows($result);
			if($rowcount > 0)
			{
			$rand=mt_rand(0,99999999999999);
			$test = "SELECT ans_id from forum_answer where ans_id=$rand";
			}
			else
			{
			break;
			}
		}
		catch (Exception $e) {
		echo "Error=".$e;
		}
	}
	if($edit==0)
	{ 
 	$sql = "INSERT INTO forum_answer (ans_id, topic_id, teacher_id, ans_desc, ans_date, edit_date) VALUES ('$rand','$did', '$email', '$desc', '$date', NULL)";
 	$sql2= "UPDATE forum_topics SET answers=answers+1 where topic_id=".$did;
 	echo $sql2;
 	}
 	else
 	{
 	$sql = "UPDATE forum_answer SET ans_desc='$desc',edit_date='$date' WHERE ans_id=$ansid";
 	}

 	 if (empty($desc)) {
 		array_push($errors, "Description is required");
 	}


 	if (count($errors) > 0)
 	{ 
	foreach ($errors as $error):
	echo $error;
	 endforeach;
	}
	else
	{
	try {
	mysqli_query($db,$sql);
		if($edit==0)
			{
			mysqli_query($db,$sql2);
			
		}
	} 
	catch (Exception $e) {
	echo "Error=".$e;
	}
 	echo $date;
 	echo '<br/>';
 	echo $rand;
 	echo $desc;
 	echo "EDIT".$edit;
 	echo $ansid;
 	if($edit==1)
 	$_SESSION['ans_success']=1;
 	else
 	$_SESSION['ans_success']=2;
 	header('location:forum.php');
 	}
 }
 else
 {
 	header('location:forum.php');
 }
}

?>