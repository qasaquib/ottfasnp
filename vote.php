<?php
session_start();
$prevVote=0;
if(isset($_SESSION['usrtype']))
{
	$email=$_SESSION['email'];
	if($_SESSION['usrtype']=='student')
	{
	$db = mysqli_connect('localhost', 'root', '', 'teacher_finder');
	mysqli_autocommit($db, FALSE);
	if(mysqli_begin_transaction($db, MYSQLI_TRANS_START_READ_WRITE))
	{
	try{
		if(isset($_POST['voteDif'])&&isset($_POST['id']))
		{
		$val=(int)$_POST['voteDif'];
		//echo $val;
		$var=$_POST['id'];
		if(!($val == -1 || $val == 1))
		{
			mysqli_rollback($db);
			mysqli_autocommit($db, TRUE);
			die("FAILED");
		}
		$query = "SELECT * FROM votes WHERE ans_id='$var' AND student_id='$email'";
		$result = mysqli_query($db, $query);
		if(mysqli_num_rows($result)>=1)
		{
			$row = mysqli_fetch_assoc($result);
			$prevVote=1;
			if($row['vote_val']==$val)
			{
				mysqli_rollback($db);
				mysqli_autocommit($db, TRUE);
				//echo ("NOCHANGE");
				exit("NOCHANGE");
			}
			else
			{
				$query="UPDATE votes SET vote_val='$val' WHERE ans_id = '$var'";
				$result= mysqli_query($db, $query);
				if($result==NULL)
				{
					die("FAILED");
					mysqli_rollback($db);

					mysqli_autocommit($db, TRUE);

				}
			}
		}
		if($prevVote!=0)
		{
		$val=2*$val;
		}
		$query = "UPDATE forum_answer SET votes = votes + '$val' WHERE ans_id='$var'";
		//echo $query;
 		$result = mysqli_query($db, $query);
 		if ($result!=NULL) {
 			if($prevVote==0)
 			{
 			$sql="INSERT INTO votes VALUES('$var','$email','$val')";
 			if(mysqli_query($db,$sql)==NULL)
 			{
 				mysqli_rollback($db);
 				mysqli_autocommit($db, TRUE);
 				die("FAILED");
 			}
 			}

 		}
 		else{ 
 			mysqli_rollback($db);
 			mysqli_autocommit($db, TRUE);
 			die("FAILED");

 		}
 		echo "Success";
 		mysqli_commit($db);
		mysqli_autocommit($db, TRUE);
		}
		else if(isset($_POST['vote'])&&isset($_POST['id'])&&isset($_POST['did']))
		{
			if($_POST['vote']=="best")
			{
				$id=$_POST['id'];
				$did=$_POST['did'];
				$query="SELECT bestans from forum_topics WHERE topic_id = '$did'";
				$sql;
				$num=mysqli_fetch_row(mysqli_query($db,$query));
				if($num[0] == NULL)
				{
					$sql="UPDATE forum_topics SET bestans = '$id' WHERE topic_id = '$did'";
				}
				else
				{
					$sql="UPDATE forum_topics SET bestans = NULL WHERE topic_id = '$did'";
				}
			if(mysqli_query($db,$sql)==NULL)
 			{
 				mysqli_rollback($db);
 				mysqli_autocommit($db, TRUE);
 				die("FAILED");
 			}
 			else
 			{
 				if($num[0] == NULL)
				{
 				echo "Success";
 				}
 				else
 				{
 				echo "Removed";
 				}
 				mysqli_commit($db);
				mysqli_autocommit($db, TRUE);
 			}

		    }

		}
	}
	catch(Exception $e)
	{
		print_r($e);
		mysqli_rollback($db);
		mysqli_autocommit($db, TRUE);
		die("FAILED");
	}
 }
 else
 {
 	die("Could Not Begin Transaction");
 }
}
}
else
{
	header("location:home.php");
}	
?>