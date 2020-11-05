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
 	}
 }
 else
 {
 $email=$_SESSION['email'];
 $rand=mt_rand(0,99999999999999);
 $desc="";
 $shortdesc="";
 $date="";
 $category="";
 $errors=array();
 $db = mysqli_connect('localhost', 'root', '', 'teacher_finder');
 if(isset($_POST['aqSubmit']))
 {
 	
 	//mysqli_query($db, $sql);
 	$date=date("Y-m-d H:i:s");
 	$desc=$_POST['aqTextarea'];
 	$shortdesc=$_POST['shortdesc'];
 	$category=$_POST['aqcat'];
 	$test = "SELECT * from forum_topics where topic_id=$rand";
 	
 	while(true)
 	{
 	try {
			$result=mysqli_query($db,$test);
			$rowcount=mysqli_num_rows($result);
			if($rowcount > 0)
			{
			$rand=mt_rand(0,99999999999999);
			$test = "SELECT topic_id from forum_topics where topic_id=$rand";
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
 	$sql = "INSERT INTO forum_topics (topic_id, student_id, topic_desc, topic_cat, topic_date, edit_date,activity,answers,bestans,topic_desc_short) VALUES ('$rand','$email', '$desc', '$category', '$date', NULL ,NULL ,0,NULL,'$shortdesc')";


 	 if (empty($desc)) {
 		array_push($errors, "Description is required");
 	}
 	if (empty($shortdesc)) {
 		array_push($errors, "Short Description is required");
 	}

 	if (empty($category)) {
 		array_push($errors, "Category is required");
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
	} 
	catch (Exception $e) {
	echo "Error=".$e;
	}
 	echo $date;
 	echo '<br/>';
 	echo $rand;
 	echo $desc;
 	echo $shortdesc;
 	echo $category;
 	//echo $sql;
 	$_SESSION['ques_success']=1;
 	header('location:forum.php');
 	}
 }
 else
 {
 	header('location:forum.php');
 }
}

?>