<?php
	session_start();
	$uid="";
	//echo $_SESSION['email'];
	if(isset($_SESSION['usrtype']))
	{
		if($_SESSION['usrtype']=='teacher')
		{
			$uid=$_SESSION['email'];
		}
		else
		{
			//header('location:home.php');
		}
	}
	$conn = mysqli_connect('localhost', 'root', '', 'teacher_finder');
	if(isset($_POST['vod_id']))
	{						

						if($_POST['type']==='edit')
						{
						$sql="UPDATE teacher_vod SET name = ? , subject = ? WHERE id = ? AND teacher_id like ? ";

						$vod_id=$_POST['vod_id'];$vod_name=$_POST['vod_name'];$vod_sub=$_POST['vod_subject'];
	 		 			if ($stmt = mysqli_prepare($conn,$sql)) {

    					/* bind parameters for markers */
    			    	mysqli_stmt_bind_param($stmt, 'ssis', $vod_name,$vod_sub,$vod_id,$uid);
    			    	$stat=mysqli_stmt_execute($stmt);
    			    	//echo $stat;
    			    	//$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	mysqli_stmt_close($stmt);
    			    	if($stat)
    			    		echo 'Successfully Edited Data';
    			    	else
    			    		echo 'Unknown Error Has Occured';
						}
					}

						else if($_POST['type']==='del')
						{
							$vod_id=$_POST['vod_id'];
							$sql="DELETE FROM teacher_vod WHERE id = ? AND teacher_id like ?";
		 		 		if ($stmt = mysqli_prepare($conn,$sql)) {

    					/* bind parameters for markers */
    			    	mysqli_stmt_bind_param($stmt, 'ss', $vod_id,$uid);
    			    	//mysqli_stmt_bind_param($stmt, 's', $uid);
    			    	$stat=mysqli_stmt_execute($stmt);
    			    	//echo $stat;
    			    	//$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	//echo $sql;
    			    	if($stat)
    			    		echo 'Successfully Deleted Data';
    			    	else
    			    		echo 'Unknown Error Has Occured';
    			    	mysqli_stmt_close($stmt);
						}
						else
						{
						echo "Failed";
						//session_destroy();
						}
					}
	}
	if(isset($_POST['doc_id']))
	{						

						if($_POST['type']==='edit')
						{
						$sql="UPDATE teacher_docs SET name = ? , subject = ? WHERE id = ? AND teacher_id like ? ";

						$doc_id=$_POST['doc_id'];$doc_name=$_POST['doc_name'];$doc_sub=$_POST['doc_subject'];
	 		 			if ($stmt = mysqli_prepare($conn,$sql)) {

    					/* bind parameters for markers */
    			    	mysqli_stmt_bind_param($stmt, 'ssis', $doc_name,$doc_sub,$doc_id,$uid);
    			    	$stat=mysqli_stmt_execute($stmt);
    			    	//echo $stat;
    			    	//$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	mysqli_stmt_close($stmt);
    			    	if($stat)
    			    		echo 'Successfully Edited Data';
    			    	else
    			    		echo 'Unknown Error Has Occured';
						}
					}

						else if($_POST['type']==='del')
						{
							$doc_id=$_POST['doc_id'];
							$sql="DELETE FROM teacher_docs WHERE id = ? AND teacher_id like ?";
		 		 		if ($stmt = mysqli_prepare($conn,$sql)) {

    					/* bind parameters for markers */
    			    	mysqli_stmt_bind_param($stmt, 'ss', $doc_id,$uid);
    			    	//mysqli_stmt_bind_param($stmt, 's', $uid);
    			    	$stat=mysqli_stmt_execute($stmt);
    			    	//echo $stat;
    			    	//$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	//echo $sql;
    			    	if($stat)
    			    		echo 'Successfully Deleted Data';
    			    	else
    			    		echo 'Unknown Error Has Occured';
    			    	mysqli_stmt_close($stmt);
						}
						else
						{
						echo "Failed";
						//session_destroy();
						}
					}
	}

	if(isset($_POST['course_id']))
	{						

						if($_POST['type']==='edit')
						{
						$sql="UPDATE teacher_course SET name = ? , subject = ? WHERE course_id = ? AND teacher_id like ? ";

						$course_id=$_POST['course_id'];$course_name=$_POST['course_name'];$course_sub=$_POST['course_subject'];
	 		 			if ($stmt = mysqli_prepare($conn,$sql)) {

    					/* bind parameters for markers */
    			    	mysqli_stmt_bind_param($stmt, 'ssis', $course_name,$course_sub,$course_id,$uid);
    			    	$stat=mysqli_stmt_execute($stmt);
    			    	//echo $stat;
    			    	//$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	mysqli_stmt_close($stmt);
    			    	if($stat)
    			    		echo 'Successfully Edited Data';
    			    	else
    			    		echo 'Unknown Error Has Occured';
						}
					}

						else if($_POST['type']==='del')
						{
							$course_id=$_POST['course_id'];
							$sql="DELETE FROM teacher_course WHERE course_id = ? AND teacher_id like ?";
		 		 		if ($stmt = mysqli_prepare($conn,$sql)) {

    					/* bind parameters for markers */
    			    	mysqli_stmt_bind_param($stmt, 'ss', $doc_id,$uid);
    			    	//mysqli_stmt_bind_param($stmt, 's', $uid);
    			    	$stat=mysqli_stmt_execute($stmt);
    			    	//echo $stat;
    			    	//$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	//echo $sql;
    			    	if($stat)
    			    		echo 'Successfully Deleted Data';
    			    	else
    			    		echo 'Unknown Error Has Occured';
    			    	mysqli_stmt_close($stmt);
						}
						else
						{
						echo "Failed";
						//session_destroy();
						}
					}
	}

	if(isset($_POST['json_course']))
	{
		//echo "Test";
		//echo sizeof($_POST);
		$reply_res=array();
		$temp=array();
		$error=0;
		$query = "SELECT `id`,`name`,`subject` FROM teacher_docs WHERE teacher_id='$uid'";
		$query2 = "SELECT `id`,`name`,`subject`,`vod_link` FROM teacher_vod WHERE teacher_id = '$uid'";
 		$result = mysqli_query($conn, $query);
 		if (mysqli_num_rows($result) >= 1) {
 			while ($row = mysqli_fetch_assoc($result)) {
 				array_push($temp, $row);
 				//print_r($row);
 			}
 			$reply_res['docs']=$temp;
 			//echo '<br/>';
 			//print_r($temp);
 		}
 		else
 		{
 			$reply_res['docs']=0;
 		}
 		mysqli_free_result($result);
 		$temp=array();
 		$result= mysqli_query($conn,$query2);
 		if(mysqli_num_rows($result)>=1)
 		{
 			while ($row = mysqli_fetch_assoc($result)) {
 				array_push($temp, $row);
 				//print_r($row);
 			}
 			$reply_res['vods']=$temp;
 			//echo '<br/>';
 			//print_r($temp);
 		}
 		else
 		{
 			$reply_res['vods']=0;
 		}
 		//header("Content-Type: application/json");
 		$json = json_encode($reply_res);
		if ($json === false) {
    	// Avoid echo of empty string (which is invalid JSON), and
    	// JSONify the error message instead:
    	$json = json_encode(["jsonError" => json_last_error_msg()]);
   		if ($json === false) {
        // This should not happen, but we go all the way now:
        $json = '{"jsonError":"unknown"}';
    	}
    	// Set HTTP response status code to: 500 - Internal Server Error
    	http_response_code(500);
		}
		echo $json;
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

	if(isset($_POST['setup']))
	{
		//mysqli_begin_transaction($conn,MYSQLI_TRANS_START_READ_WRITE);
		$email=$_SESSION['email'];
		if($_POST['type']=="subject")
		{
			if($_POST['action']=='insert')
			{
			$subject=$_POST['value'];
			$rand=mt_rand(0,99999999999999);
			$sql="INSERT INTO teacher_subjects VALUES ('$rand','$email','$subject')";
			//echo $rand;
			$result=mysqli_query($conn,$sql);
			if($result==false)
			 {
			 	echo "Failed";
			 }
			 else
			 {
			 	echo $rand;
			 	$_SESSION['numSub']=$_SESSION['numSub']+1;
			 }
			}
			else if ($_POST['action']=="delete") {
				$rand=$_POST['value'];
				$sql="DELETE FROM teacher_subjects WHERE id = '$rand' and teacher_id = '$email'";
				$result=mysqli_query($conn,$sql);
				if($result==false)
				{
				echo "Failed";
				}
				else
				{
				echo "$rand";
				if($_SESSION['numSub']>0)
					$_SESSION['numSub']=$_SESSION['numSub']-1;
				}
			}
		}
		if($_POST['type']=="standard")
		{

			if($_POST['action']=='insert')
			{
			$standard=$_POST['value'];
			$rand=mt_rand(0,99999999999999);
			$sql="INSERT INTO teacher_standards VALUES ('$rand','$email','$standard')";
			//echo $rand;
			$result=mysqli_query($conn,$sql);
			if($result==false)
			 {
			 	echo "Failed";
			 }
			 else
			 {
			 	echo $rand;
			 	$_SESSION['numStan']=$_SESSION['numStan']+1;
			 }
			}
			else if ($_POST['action']=="delete") {
				$rand=$_POST['value'];
				$sql="DELETE FROM teacher_standards WHERE id = '$rand' and teacher_id = '$email'";
				$result=mysqli_query($conn,$sql);
				if($result==false)
				{
				echo "Failed";
				}
				else
				{
				echo "$rand";
				if($_SESSION['numStan']>0)
					$_SESSION['numStan']=$_SESSION['numStan']-1;
				}
			}
		}
		if ($_POST['type']=="toggle_accept") 
		{
			if(isset($_POST['value']))
			{
				$val=$_POST['value'];
				if($val==0 || $val == 1)
				{
					$sql = "UPDATE teacher_data SET accept = '$val' WHERE email like '$email'";
					$result=mysqli_query($conn,$sql);
					if($result==false)
					{
						echo "Failed";
					}
					else
					{
						echo "Success";
					}
				}
				else
				{
					echo "Failed";
				}
			}
			else
			{
				echo "Failed";
			}
			
		}
		else if ($_POST['type']=="seat")
		{
			if(isset($_POST['value']))
			{
				$val=$_POST['value'];
				if($val>=1)
				{
					$sql = "UPDATE teacher_data SET slots = '$val' WHERE email like '$email'";
					$result=mysqli_query($conn,$sql);
					if($result==false)
					{
						echo "Failed";
					}
					else
					{
						echo "Success";
					}
				}
				else
				{
					echo "Failed";
				}
			}
			else
			{
				echo "Failed";
			}
		}

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

	if(isset($_POST['off_req_id']))
	{
				if($_POST['type']==='acc')
				{
						$rand=mt_rand(0,99999999999999);
						$stuEmail=$_POST['mail'];
						//$name=$_POST['name'];
						$subject=$_POST['subject'];
	 					$date=date("Y-m-d H:i:s");
						//echo $stuEmail."stu";
						//$sql="UPDATE student_inbox SET name = ? , subject = ? WHERE id = ? AND teacher_id like ? ";
						$sql="INSERT INTO student_inbox VALUES (?,?,?,?)";

						$req_id=$_POST['off_req_id'];
						$message="You will be contacted shortly";
	 		 			if ($stmt = mysqli_prepare($conn,$sql)) {

    					/* bind parameters for markers */
    			    	mysqli_stmt_bind_param($stmt, 'ssss', $stuEmail,$message,$uid,$date);
    			    	$stat=mysqli_stmt_execute($stmt);
    			    	//echo $stat;
    			    	//$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	mysqli_stmt_close($stmt);
    			    	}
    			    	$sql2="DELETE FROM teacher_offline WHERE student_id = ? AND teacher_id like ? AND id = ?";
	 		 			if ($stmt2 = mysqli_prepare($conn,$sql2)) {
    					/* bind parameters for markers */
    			    	mysqli_stmt_bind_param($stmt2, 'sss', $stuEmail,$uid,$req_id);
    			    	$stat2=mysqli_stmt_execute($stmt2);
    			    	//echo $stat;
    			    	//$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	mysqli_stmt_close($stmt2);
						}
	   			    	$sql3="INSERT INTO teacher_batch (id,teacher_id,student_id,sub_name) VALUES (?,?,?,?)";
	 		 			if ($stmt3 = mysqli_prepare($conn,$sql3)) {
    					/* bind parameters for markers */
    			    	mysqli_stmt_bind_param($stmt3, 'ssss', $rand,$uid,$stuEmail,$name,$subject);
    			    	$stat3=mysqli_stmt_execute($stmt3);
    			    	//echo $stat;
    			    	//$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	mysqli_stmt_close($stmt3);
						}



    			    	if($stat && $stat2 && $stat3)
    			    	{
    			    		echo 'Successfully Accepted Request';

    			    	}
    			    	else
    			    	{
    			    		echo 'Unknown Error Has Occured';
							//if(!$stat)
    			    			//echo 'stat';
    			    		//if(!$stat2)
    			    			//echo 'stat2';
    			    	}
				}
					

				 else if($_POST['type']==='del')
				{
							$rand=mt_rand(0,99999999999999);
							$stuEmail=$_POST['mail'];
							$req_id=$_POST['off_req_id'];
							$sql="DELETE FROM teacher_offline WHERE student_id = ? AND teacher_id like ? AND id=?";
		 		 		if ($stmt = mysqli_prepare($conn,$sql)) {

    					/* bind parameters for markers */
    			    	mysqli_stmt_bind_param($stmt, 'sss', $stuEmail,$uid,$req_id);
    			    	//mysqli_stmt_bind_param($stmt, 's', $uid);
    			    	$stat=mysqli_stmt_execute($stmt);
    			    	//echo $stat;
    			    	//$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	//echo $sql;
    			    	if($stat)
    			    		echo 'Successfully Declined Request';
    			    	else
    			    		echo 'Unknown Error Has Occured';
    			    	mysqli_stmt_close($stmt);
						}
						else
						{
						echo "Failed";
						//session_destroy();
						}
				}

				else if($_POST['type']==='del_curr')
				{
							$stuEmail=$_POST['mail'];
							$req_id=$_POST['off_req_id'];
							$sql="DELETE FROM teacher_batch WHERE student_id = ? AND teacher_id like ? AND id=?";
		 		 		if ($stmt = mysqli_prepare($conn,$sql)) {

    					/* bind parameters for markers */
    			    	mysqli_stmt_bind_param($stmt, 'sss', $stuEmail,$uid,$req_id);
    			    	//mysqli_stmt_bind_param($stmt, 's', $uid);
    			    	$stat=mysqli_stmt_execute($stmt);
    			    	//echo $stat;
    			    	//$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	//echo $sql;
    			    	if($stat)
    			    		echo 'Successfully Removed Student';
    			    	else
    			    		echo 'Unknown Error Has Occured';
    			    	mysqli_stmt_close($stmt);
						}
						else
						{
						echo "Failed";
						//session_destroy();
						}
				}
	}



if(isset($_SESSION['usrtype']))
{
if($_SESSION['usrtype']=='teacher')
{
  if(isset($_POST['tabtype']))
  {
  	require_once('teacher_tables.php');
  	if($_POST['tabtype']=='req')
  	{
  		printReqTable();
  	}
  	if($_POST['tabtype']=='vod')
  	{
  		printVodTable();
  	}
  	if($_POST['tabtype']=='doc')
  	{
  		printDocTable();
  	}
  	if($_POST['tabtype']=='cou')
  	{
  		printCouTable();
  	}
  }
}
if($_SESSION['usrtype']=='student'||$_SESSION['usrtype']=='teacher')
{
  if(isset($_POST['tabtype']))
  {
  	require_once('tables.php');
  	if($_POST['tabtype']=='for')
  	{
  	printForTable();
  	}
  }
}
}

if(isset($_POST['message']))
{
	try{
	$date=date("Y-m-d H:i:s");
	$msg=$_POST['msg_cont'];
	$recv=$_POST['recv'];
	//$uid=$_SESSION['email'];
	$sql="INSERT INTO student_inbox VALUES (?,?,?,?)";
	$stmt;
	$stat="";
	if ($stmt = mysqli_prepare($conn,$sql)) {
	if($recv == 'subs')
	{
		$sql2="SELECT student_id from subscriptions WHERE teacher_id = '$uid'";
		$result=mysqli_query($GLOBALS['conn'],$sql2);
		while($row=mysqli_fetch_row($result))
		{
			$rec=$row[0];
			/* bind parameters for markers */
    		mysqli_stmt_bind_param($stmt, 'ssss', $rec,$msg,$uid,$date);
    		$stat=mysqli_stmt_execute($stmt);
    		//echo $stat;
    		//$res=mysqli_stmt_get_result($stmt);
    		//print_r($res);
		}
	}
	else if ($recv== 'off_stu')
	{
		$sql2="SELECT student_id from teacher_batch WHERE teacher_id = '$uid'";
		$result=mysqli_query($GLOBALS['conn'],$sql2);
		while($row=mysqli_fetch_row($result))
		{
			$rec=$row[0];
			/* bind parameters for markers */
    		mysqli_stmt_bind_param($stmt, 'ssss', $rec,$msg,$uid,$date);
    		$stat=mysqli_stmt_execute($stmt);
    		//echo $stat;
    		//$res=mysqli_stmt_get_result($stmt);
    		//print_r($res);
		}

	}
	else
	{
		$sql2="SELECT student_uid.email from student_uid INNER JOIN teacher_batch ON teacher_batch.student_id=student_uid.email WHERE teacher_batch.teacher_id = '$uid'";
		$result=mysqli_query($GLOBALS['conn'],$sql2);
		while($row=mysqli_fetch_row($result))
		{
			$rec=$row[0];
			/* bind parameters for markers */
    		mysqli_stmt_bind_param($stmt, 'ssss', $rec,$msg,$uid,$date);
    		$stat=mysqli_stmt_execute($stmt);
    		//echo $stat;
    		//$res=mysqli_stmt_get_result($stmt);
    		//print_r($res);
		}

	}
		//echo $stat;
	}
		mysqli_stmt_close($stmt);
	}
	catch(Exception $e)
	{
		echo 'Failed';
	}
}

if(isset($_POST['kyc']))
{
	if($_POST['kyc']=="upload")
	{
	 if(isset($_SESSION['usrtype']))
	 {
	 	if($_SESSION['usrtype']=='teacher')
	 	{
	 		if(isset($_POST['submit_doc']))
	 		{
	 			$file=$_FILES['docfile'];
	 			//print_r($file['tmp_name']);
	 			//print_r($_FILES['docfile']['tmp_name']);
	 			$fileName = $file['name'];
				$fileSize = $file['size'];
				$fileError= $file['error'];
				$fileType= $file['type'];
				$fileTmpName=$file['tmp_name'];
				$fileExt = explode('.',$fileName);
				$fileActualExt = strtolower(end($fileExt));
				$allowed = array('pdf');
			if(in_array($fileActualExt,$allowed))
			{
				$fileActualExt=".".$fileActualExt;
				if($fileError===0){
				if($fileSize<1000000000){
	 			$link="";
	 			//$link=fread($fp,filesize($_FILES['docfile']['tmp_name']));
	 			//$link=addslashes($link);
	 			//$link=file_get_contents($_FILES['docfile']['tmp_name']);
	 			if (mysqli_connect_errno()) {
   				 //printf("Connect failed: %s\n", mysqli_connect_error());
    			//exit();
	 				$_SESSION['msg'] = "Failed";
	 				$illegal=1;
	 				header('location:teacher_setup.php');
	 				die();
				}
				if ($stmt = mysqli_prepare($conn, "INSERT INTO teacher_kyc VALUES(?,?)")) {


    			/* bind parameters for markers */
   					 mysqli_stmt_bind_param($stmt, 'sb',$uid,$link);
   			 		 $fp=fopen($_FILES['docfile']['tmp_name'],'rb');
						while (!feof($fp)) {
   						mysqli_stmt_send_long_data($stmt,1,fread($fp, 8192));
						}
					fclose($fp);
					}
   				}
  			}	
		}
		else
		{
	 				$_SESSION['msg'] = "Failed";
	 				$illegal=1;
	 				header('location:teacher_setup.php');
	 				die();
		}	

    	/* execute query */
    	if($illegal==0)
    	{
    		$res=mysqli_stmt_execute($stmt);
    	}
    	else
    	{
    		$res=false;
    	}

    	if($illegal==0)
    	{
    		mysqli_stmt_close($stmt);
		}

		/* close connection */
    	$result=mysqli_query($conn,"SELECT * FROM admin ORDER BY work");
    	$row=mysqli_fetch_row($result);
    	$admin_id=$row[0];
    	$status="PENDING";
		$stmt=mysqli_prepare($conn,"INSERT INTO admin_kyc VALUES(?,?,?)");
		if($stmt)
		{
			mysqli_stmt_bind_param($stmt, 'sss',$admin_id,$uid,$status);
			$stat=mysqli_stmt_execute($stmt);
			if($stat)
			{
				$_SESSION['msg']="Uploaded";
			}
		}

	 			}
	 		}
		 }
		 header('location:teacher_setup.php');
		 die();
	}
	if($_POST['kyc']=="delete")
	{
		$sql="DELETE from teacher_kyc WHERE teacher_id = '$uid'";
		$sql2="DELETE from admin_kyc WHERE teacher_id = '$uid'";
		$sql3="UPDATE teacher_verified SET verified_doc = '0' WHERE email = '$uid'";
		$res=mysqli_query($conn,$sql);
		if($res == false)
		{
			echo "Failed";
			die();
		}
		$res=mysqli_query($conn,$sql2);
		if($res == false)
		{
			echo "Failed";
			die();
		}
		$res=mysqli_query($conn,$sql);
		if($res == false)
		{
			echo "Failed";
			die();
		}
		echo "Deleted";
	}
}
if(isset($_POST['kyc_id']))
{
		require_once('server.php');
		$uid=decodeMail('teacher',$_POST['kyc_id']);
		$date=date('Y-m-d H:i:s');
	if($_POST['type']=='del')
	{

		$sql="DELETE from teacher_kyc WHERE teacher_id = '$uid'";
		$sql2="DELETE from admin_kyc WHERE teacher_id = '$uid'";
		$sql3="INSERT INTO teacher_inbox VALUES ('$uid','Document for Verification Rejected','admin','$date')";
		$sql4="UPDATE teacher_verified SET verified_doc = '0' WHERE email = '$uid'";
		$res=mysqli_query($conn,$sql);
		if($res == false)
		{
			echo "Failed";
			die();
		}
		$res=mysqli_query($conn,$sql2);
		if($res == false)
		{
			echo "Failed";
			die();
		}
		$res=mysqli_query($conn,$sql3);
		if($res == false)
		{
			echo "Failed";
			die();
		}
		$res=mysqli_query($conn,$sql4);
		if($res == false)
		{
			echo "Failed";
			die();
		}
		echo "Declined";
	}
	else if($_POST['type']=='acc')
	{
		$sql="UPDATE teacher_verified SET verified_doc = '1' WHERE email = '$uid'";
		$sql2="INSERT INTO teacher_inbox VALUES ('$uid','Document for Verification Accepted','admin','$date')";
		$sql3="UPDATE admin_kyc SET status = 'VERIFIED' WHERE teacher_id = '$uid'";
		$res=mysqli_query($conn,$sql);
		if($res == false)
		{
			echo "Failed";
			die();
		}
		$res=mysqli_query($conn,$sql2);
		if($res == false)
		{
			echo "Failed";
			die();
		}
		$res=mysqli_query($conn,$sql3);
		if($res == false)
		{
			echo "Failed";
			die();
		}
		echo 'Accepted';
	}
}


function checkSearchable()
{
            $numSub=$numStan=0;
            $email = $_SESSION['email'];
            //$preres=0;
            $sql="SELECT * FROM teacher_subjects where teacher_id = '$email'";
            $subResult=mysqli_query($GLOBALS['conn'],$sql);
            $numSub=mysqli_num_rows($subResult); 
            $sql="SELECT * FROM teacher_standards where teacher_id = '$email'";
            $stanResult=mysqli_query($GLOBALS['conn'],$sql);
            $numStan=mysqli_num_rows($stanResult);
            $sql="SELECT verified_mail FROM teacher_verified where email = '$email'";
            $verResult=mysqli_query($GLOBALS['conn'],$sql);
            $row=mysqli_fetch_row($verResult);
            $numVer=(int)$row[0];
            $sql = "UPDATE teacher_data SET searchable = '1' WHERE email = '$email'";
            if($numSub && $numStan && $numVer)
            {
                mysqli_query($GLOBALS['conn'],$sql);
                return true;
            }
            return false;
}
		 //mysqli_close($conn);
		 //
		 //if(sizeof($_POST)==0)
		 //{
		 //header('location:home.php');
		 //echo $uid;
		 //}
?>