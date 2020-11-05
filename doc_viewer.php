<?php
session_start();
require 'server.php';
$uid="";
$dbh = new PDO("mysql:host=localhost;dbname=teacher_finder","root","");
$id=isset($_GET['doc_id'])?$_GET['doc_id']:"";
$uid="";
//echo "ABC";
//echo $_SESSION['usrtype'];
if(!isset($_SESSION['usrtype']))
{
	header("location:home.php");
	die("");
}
else
{
if($_SESSION['usrtype']=='teacher')
{
	//echo "ABC";
	$uid=$_SESSION['email'];
	$stat;
	if(isset($_GET['self']))
	{
		$stat=$dbh->prepare("select * from teacher_kyc where teacher_id = ?");
		$stat->bindParam(1,$uid);
	}
	else
	{
		$stat=$dbh->prepare("select * from teacher_docs where id = ? and teacher_id like ?");
		$stat->bindParam(1,$id);
		$stat->bindParam(2,$uid);
	}

	$stat->execute();
	$row=$stat->fetch();
	if (!$row) {
		die("No Document Found");
    	echo "\nPDO::errorInfo():\n";
   		print_r($dbh->errorCode());
    	echo $uid;
	}
	else
	{
	if(!isset($_GET['self']))
	{
		$file_name=str_replace(" ","_",$row['name']).$row['doc_type'];
		header('Content-Type:'.$row['doc_mime']);
		//header("Content-Transfer-Encoding: Binary"); 
		header("Content-disposition: attachment; filename=".$file_name); 	//echo $row['doc_mime'];
		echo $row['doc_blob'];
	}
	else
	{
		$file_name="document.pdf";
		header('Content-Type:application/pdf');
		//header("Content-Transfer-Encoding: Binary"); 
		header("Content-disposition: attachment; filename=".$file_name); 	//echo $row['doc_mime'];
		echo $row['proof'];
	}
	}
}
else if($_SESSION['usrtype']=='student')
{
	$uid=$_SESSION['email'];
 	$presentDate=date("Y-m-d H:i:s");
 	$res=$dbh->query("SELECT teacher_id FROM teacher_docs WHERE id = '$id'");
 	$row=$res->fetch();
 	$teacher_id=$row['teacher_id'];
 	$stat=$dbh->query("SELECT COUNT(*) FROM subscriptions INNER JOIN teacher_data ON subscriptions.teacher_id = teacher_data.email WHERE subscriptions.end_date > '$presentDate' AND subscriptions.student_id like '$uid' AND subscriptions.teacher_id = '$teacher_id'");
 	if ($stat->fetchColumn() > 0)
	{
		$stmt=$dbh->prepare("select * from teacher_docs where id = ?");
		$stmt->bindParam(1,$id);
		$stmt->execute();
		$row=$stmt->fetch();
 		header('Content-Type:'.$row['doc_mime']);
		echo $row['doc_blob'];
 	}
 	else
 	{
		die("No Permission");
    	echo "\nPDO::errorInfo():\n";
   		print_r($dbh->errorCode());
    	echo $uid;
 	}
}
else if($_SESSION['usrtype']=='admin')
{
	if(!isset($_GET['cid']))
	{
		echo "Client Id not Supplied";
	}
	else
	{
	$uid=decodeMail('teacher',$_GET['cid']);
	$stat;
	$stat=$dbh->prepare("select * from teacher_kyc where teacher_id = ?");
	$stat->bindParam(1,$uid);
	$stat->execute();
	$row=$stat->fetch();
	if (!$row) 
	{
		die("No Document Found");
    	echo "\nPDO::errorInfo():\n";
   		print_r($dbh->errorCode());
    	echo $uid;
	}
		$file_name="document.pdf";
		header('Content-Type:application/pdf');
		//header("Content-Transfer-Encoding: Binary"); 
		header("Content-disposition: attachment; filename=".$file_name); 	//echo $row['doc_mime'];
		echo $row['proof'];

	}	
}
else
{	echo $_SESSION['usrtype'];
	die("No Permission");
}
}
?>