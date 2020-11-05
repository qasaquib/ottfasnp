<?php
session_start();
require_once('server.php');
require_once('tables.php');
 if(!isset($_SESSION['usrtype']))
 {
    header("location:home.php");
    die();
  }
  else
  {
    if($_SESSION['usrtype']=='guest' || $_SESSION['usrtype']=='admin')
    {
    header("location:home.php");
    die();
    }
  }
echo <<<EOT
<!DOCTYPE html>
<html>
<head>
	<title>Find Your Teacher Online Or Offline</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="css/forum.css">
	<link rel="stylesheet" type="text/css" href="css/footstyle.css">
	<link rel="stylesheet" type="text/css" href="css/navstyle.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
	<script src="https://kit.fontawesome.com/48e4b8916e.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="ckeditor/ckeditor.js"></script>
	<script src="js/vote.js"></script>
	</head>
	<body class="bg-black text-light">
EOT;
 	$email="";
 	$ans="";
 	$stu_email="";
 	require 'navbar.php';
      $chk=isset($_SESSION['usrtype']);
    if ($chk){
      if($_SESSION['usrtype']=='teacher')
      {
      teacher_navbar();
      $chk=1;
  	  }
      else if($_SESSION['usrtype']=='student')
      {
      $stu_email=$_SESSION['email'];
      student_navbar();
      $chk=2;
  	  }
  	}
  	else{
      //default_navbar();
      $chk=0;
      header("location:home.php");
      die();
  	}
  	/*
	 if(mysqli_connect_errno())
	 {
	 	printf("Connect failed: %s\n", mysqli_connect_error());
	 }
	 */

	 $sql="SELECT * FROM forum_topics ORDER BY topic_date DESC LIMIT 0, 5";//new
	 $sql1="SELECT * FROM forum_topics ORDER BY activity DESC LIMIT 0, 5";//recent activity
	 //echo $sql3;
	 

	echo '<div class="container-fluid">';
	
	
	if(isset($_SESSION['ques_success']))
	{
		if($_SESSION['ques_success']===1)
		{
			echo '<div class="alert alert-dark" role="alert">Your Question has been posted in the doubt forum!</div>';
		}
		unset($_SESSION['ques_success']);
	}
	if(isset($_SESSION['ans_success']))
	{
		if($_SESSION['ans_success']===2)
		{
			echo '<div class="alert alert-dark" role="alert">Your Answer has been posted in the doubt forum!</div>';
		}
		else if($_SESSION['ans_success']===1)
		{
			echo '<div class="alert alert-dark" role="alert">Your Answer has been modified in the doubt forum!</div>';
		}
		unset($_SESSION['ans_success']);
	}
	if(isset($_GET['did']))
	{
		$did=$_GET['did'];
		$bestans=NULL;
		 $query="SELECT * FROM forum_topics WHERE topic_id = ".$did;
		if ($result = mysqli_query($conn, $query)) 
		{
		 $rowcount=mysqli_num_rows($result);
		 if($rowcount === 0)
		 	{
		 	//echo $rowcount;
		 	 header('location:forum.php');
			}
		   $row=mysqli_fetch_row($result);
		   $bestans=$row[8];
		echo '<div class="row">';
			echo '<div class="col bg-secondary text-center">';
			echo '<h3 style="" class="p-2">'.$row[9].'</h3>';
			echo '<h5 style="" class="p-2">'.$row[2].'</h5>';
			echo '</div>';
		echo '</div>';//no prob

		if(!is_null($row[7]))
		{
			echo '<div class="row" id="AnswerList">';
			echo '<div class="col bg-info text-center" >';
			echo '<h4 style="" class="p-2">There is/are '.$row[7].' answer(s) to this question'.'</h4>';
			echo '<br/>';
		}
		else
		{
			echo '<div class="row" id="AnswerList">';
			echo '<div class="col bg-secondary text-center" >';
			echo '<h4 style="" class="p-2">No answers yet !</h4>';
			echo '<br/>';
		}
			if(isset($_SESSION['usrtype']))
			{
				if($_SESSION['usrtype']==="teacher")
				{
				$email=$_SESSION['email']; 
				$_SESSION['did']=$_GET['did'];
				echo <<<EOT
				<div class="teacher-aq m-2">
				<form action="readanswer.php" method="post">
				<div class="form-group p-4">
				<label for="aqTextarea">Answer this question :</label>
				<textarea class="form-control" id="aqTextarea" rows="4" name="aqTextarea">
				 Type your answer here...
				</textarea>
				<button id="aqSubmit" type="submit" class="btn btn-light m-2" name="aqSubmit">Submit Answer</button>
				</div>
				</form>
				</div>
				EOT;
				}
			}//end of questions
				echo '</div>';//end of col
				echo '</div>';//end of row
				$query2="SELECT * FROM forum_answer WHERE topic_id = ".$did;
		 	if ($result2 = mysqli_query($conn, $query2) )
		 		{		$num=1;
		 		while ($row2=mysqli_fetch_row($result2)) 
    			{
    			$emailq=$row2[2];
    			if($emailq == $email)
    			{
    				$ans=$row2[3];
    			}
    					$imgsql = "SELECT * FROM teacher_image WHERE email like '".$emailq."' ORDER BY id DESC";
    					$ressql="SELECT * FROM teacher_data WHERE email like '$emailq'";
						$imgresult=mysqli_query($conn, $imgsql);
						if (mysqli_num_rows($imgresult) === 0)
						$src="avatar.png";
						else
						{	while ($imgrow = mysqli_fetch_row($imgresult)) {
			 			   $src=$imgrow[3];
						    break;
							}	 
						}
						$resall=mysqli_query($conn,$ressql);
						$resrow=mysqli_fetch_array($resall);
						//$votesql = "";
						//$voteresult = "";
    					 //echo '<div class="container-fluid p-3" id="idAns">';	
    					 echo '<div class="row bg-secondary p-2 mt-3 ml-2 mr-2">';
    					 echo '<div class="col-3 text-center" >';

    					echo '<img class="res-pic" src="'.$src.'" alt="avatar.png" width="100%" height="auto" align="">';
    					 echo '<p>'.$resrow['fname']." ".$resrow['lname'].' </p>';
    					 echo '</div>';
    					 echo '<div class="col-9 text-left bg-dark">';
    					 if($ans!="")
    					 {
    					 	echo '<p class="bg-primary text-center">Your Answer</p>';
    					 }
    					 else
    					 {
    					 	echo '<p>Answer</p>';
    					 }
      					 echo '<p>'.$row2[3].'</p>';
    					 echo '</div>';
    					 echo '</div>';
    					 echo '<div class="row bg-secondary border-top border-dark p-2 ml-2 mr-2">'; 
    					 if($row[1]==$stu_email)
    					 {
    					 	echo '<button class="btn btn-sm btn-dark m-2 vote-up" id="'.$row2[0].'-up"><i class="fas fa-arrow-up"></i></button>';
    						echo '<p id="'.$row2[0].'-votes" class="mt-2">'.$row2[6].'</p>';
    					 	echo '<button class="btn btn-sm btn-dark m-2 vote-down" id="'.$row2[0].'-down"><i class="fas fa-arrow-down"></i></button>';
    					 	if($bestans!=$row2[0])
    					 		echo '<button class="btn btn-sm btn-dark m-2 vote-best" id="'.$row2[0].'-best"><i class="fas fa-star"></i></button>';
    					 	else
    					 		echo '<button class="btn btn-sm btn-warning m-2 vote-best" id="'.$row2[0].'-best"><i class="fas fa-star"></i></button>';
    					 }
    					 if($bestans==$row[0])
    					 {
    					 echo '<p id="'.$row2[0].'-notif" class="mt-2">'."Best Answer! Chosen by original poster.".'</p>';
    					 }
    					 else
    					 {
    					 	echo '<p id="'.$row2[0].'-notif" class="mt-2"></p>';
    					 }
    					 }
         			     echo '</div>';
				} 
			}//end of answers
		}

	
//tables start here---

	echo '<div class="row mt-2">';
		echo '<div class="col mx-auto mb-4">';
		echo '<h3 class="res-h3">New Doubts</h3>';
			 if ($result = mysqli_query($conn, $sql)) {
			 		if(is_null($result))
					{
						echo '<div class="alert alert-dark" role="alert">No Threads</div>';
					}
					else if(mysqli_num_rows($result)==0)
					{						
						echo '<div class="alert alert-dark" role="alert">No Threads</div>';
					}
					else
					{	
echo <<<EOT
	<div class="table-responsive">
	<table class="table table-dark">
	<thead>
	<tr>
	<th scope="col">Topic</th>
	<th scope="col">Category</th>
	<th scope="col">Date</th>
	<th scope="col">Answers</th>
	<th scope="col">Status</th>
	</tr>
	</thead>
<tbody>
EOT;		
    					while ($row=mysqli_fetch_row($result)) 
    					{
    					 echo '<tr>';
      					 echo '<th scope="row"><a href="forum.php?did='.$row[0].'">'.$row[9].'</a></th>';
      					 if($row[8]==NULL)
      					 	$status="NOT SOLVED";
      					 else
      					 	$status="SOLVED";
      					 echo '<td>'.$row[3].'</td>';
      					 echo '<td>'.$row[4].'</td>';
      					 echo '<td>'.$row[7].'</td>';
      					 echo '<td>'.$status.'</td>';
    					 echo '</tr>';
						}
						echo "</tbody>";
						echo "</table>";	
					}
 
			}
			mysqli_free_result($result);
	
		echo '</div>';
		echo '</div>';
		echo '</div>';
	echo '<div class="row">';
	echo 	'<div class="col mx-auto mb-4">';
	echo '<h3 class="res-h3">Recent Activity</h3>';
			 if ($result = mysqli_query($conn, $sql1)) {
			 		if(is_null($result))
					{
						echo '<div class="alert alert-dark" role="alert">No Threads</div>';
					}
					else if(mysqli_num_rows($result)==0)
					{						
						echo '<div class="alert alert-dark" role="alert">No Threads</div>';
					}
					else
					{	
echo <<<EOT
	<div class="table-responsive">
	<table class="table table-dark">
	<thead>
	<tr>
	<th scope="col">Topic</th>
	<th scope="col">Category</th>
	<th scope="col">Date</th>
	<th scope="col">Answers</th>
	<th scope="col">Status</th>
	</tr>
	</thead>
<tbody>
EOT;		
    					while ($row=mysqli_fetch_row($result)) 
    					{
    					 echo '<tr>';
      					 echo '<th scope="row"><a href="forum.php?did='.$row[0].'">'.$row[9].'</a></th>';
          				 if($row[8]==NULL)
      					 	$status="NOT SOLVED";
      					 else
      					 	$status="SOLVED";
      					 echo '<td>'.$row[3].'</td>';
      					 echo '<td>'.$row[4].'</td>';
      					 echo '<td>'.$row[7].'</td>';
      					 echo '<td>'.$status.'</td>';
    					 echo '</tr>';
    					echo '</tr>';
						}
						echo "</tbody>";
						echo "</table>";	
					}
 
			}
			mysqli_free_result($result);
		
	echo '</div>';
	echo '</div>';
	echo '</div>';
	echo '<div id="for-tab-cont">';
	printForTable();
	echo '</div>';
	echo '</div>';
	echo '</div>';
echo <<<EOT
<form class="form-inline" method="post" action="" onsubmit="return nosubmit(event)">
  <div class="form-group m-2 p-2">
    <label for="perpg" class="m-2">Number of Results</label>
    <select class="form-control" id="for_perpg" name="perpg">
EOT;
	$printvar=conEcho($_SESSION['for']['perpg'],'3');
     echo '<option value="3" '.$printvar.'>3</option>';
     	$printvar=conEcho($_SESSION['for']['perpg'],'5');
      echo '<option value="5" '.$printvar.'>5</option>';
      	$printvar=conEcho($_SESSION['for']['perpg'],'10');
      echo '<option value="10" '.$printvar.'>10</option>';
      	$printvar=conEcho($_SESSION['for']['perpg'],'20');
      echo '<option value="20" '.$printvar.'>20</option>';
      	$printvar=conEcho($_SESSION['for']['perpg'],'30');
      echo '<option value="30" '.$printvar.'>30</option>';
echo <<<EOT
    </select>
  </div>
  <div class="form-group m-2 p-2">
    <label for="orderer" class="m-2">Select Order</label>
    <select class="form-control" id="for_orderer" name="orderer">
EOT;
	   $printvar=conEcho($_SESSION['for']['orderer'],'ASC');
      echo '<option value="ASC" '.$printvar.'>Ascending</option>';
	   $printvar=conEcho($_SESSION['for']['orderer'],'DESC');
      echo '<option value="DESC" '.$printvar.'>Descending</option> ';
echo <<<EOT
    </select>
  </div>
    <div class="form-group m-2 p-2">
    <label for="sorter" class="m-2">Sort By</label>
    <select class="form-control" id="for_sorter" name="sorter">
EOT;
	 $printvar=conEcho($_SESSION['for']['sorter'],'topic_desc_short');
      echo '<option value="topic_desc_short" '.$printvar.'>Topic</option>';
	 $printvar=conEcho($_SESSION['for']['sorter'],'topic_date');
     echo '<option value="topic_date" '.$printvar.'>Upload Date</option>';
	 $printvar=conEcho($_SESSION['for']['sorter'],'topic_cat');
     echo '<option value="topic_cat" '.$printvar.'>Subject</option>';
     echo $_SESSION['for']['sorter'];
echo <<<EOT
    </select>
  </div>
  <div class="form-group m-2 p-2">
    <label for="narrower" class="m-2">Narrow By Category</label>
    <select class="form-control" id="for_narrower" name="narrower">
      
EOT;
$printvar=conEcho($_SESSION['for']['narrower'],'NA');
echo '<option value="NA" '.$printvar.'>Do Not Narrow</option>';
popSubject();
$printvar=conEcho($_SESSION['for']['narrower'],'Others');
echo '<option value="Others"'.$printvar.'>Others</option>';
echo <<<EOT
    
    </select>
  </div>
  <div class="form-group m-2 p-2">
  <button type="button" class="btn btn-secondary mb-2" name="custom_sub_for" onclick="subFor()">Search</button>
  </div>
</form>
EOT;
echo '</div>';
echo '</div>';
//end of tables
	if(isset($_SESSION['usrtype']))
	{
		if($_SESSION['usrtype']!=='teacher')
		{
				echo <<<EOT
				<div class="row">
				<div class="teacher-aq col bg-secondary m-2">
				<h4 class="res-h4">Have a question or doubt? :</h4>
				<form action="readquestion.php" method="post">
				<div class="form-group p-4">
				<label for="shortdesc">Describe in short</label>
				<input type="text" class="form-control mb-2" name="shortdesc" id="shortdesc" placeholder="Enter a short description of your problem" required>
				<label for="aqTextarea">Give a detailed description</label>
				<textarea class="form-control" id="aqTextarea" name="aqTextarea" rows="4" name="aq">
				 Type your question here...
				</textarea>
				<label for="aqcat">Select a Category</label>
				<select id="aqcat" name="aqcat" class="form-control" required>
				EOT;
				popSubject();
				echo <<<EOT
				</select>
				<button id="aqSubmit" type="submit" class="btn btn-light m-2" name="aqSubmit">Submit Question</button>
				</div>
				</form>
				</div>
				</div>
				EOT;
		}

	}
	else
	{
				echo <<<EOT
				<div class="row">
				<div class="teacher-aq col bg-secondary m-2">
				<h4 class="res-h4">Have a question or doubt? :</h4>
				<form action="readquestion.php" method="post">
				<div class="form-group p-4">
				<label for="shortdesc">Describe in short</label>
				<input type="text" class="form-control mb-2" name="shortdesc" id="shortdesc" placeholder="Enter a short description of your problem" required>
				<label for="aqTextarea">Give a detailed description</label>
				<textarea class="form-control" id="aqTextarea" name="aqTextarea" rows="4" name="aq">
				 Type your question here...
				</textarea>
				<label for="aqcat">Select a Category</label>
				<select id="aqcat" name="aqcat" class="form-control" required>
				EOT;
				popSubject();
				echo <<<EOT
				<option value="others">Others</option>
				</select>
				<button id="aqSubmit" type="submit" class="btn btn-light m-2" name="aqSubmit">Submit Question</button>
				</div>
				</form>
				</div>
				</div>
				EOT;
	}
	
echo '</div>';
echo '<!--Container End-->';
?>
<?php
	    	echo <<<EOT
				<script type="text/javascript">
				 //window.alert('Hello');
				 window.onload = function() {
				  CKEDITOR.replace('aqTextarea');
				};
				</script>
				EOT;
?>
</html>