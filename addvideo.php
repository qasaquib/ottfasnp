<?php
	session_start();
	if(!isset($_SESSION['usrtype']))
	{
		header('location:home.php');
		exit();
	}
	else
	{
	if($_SESSION['usrtype']==='teacher') 
    {
    	;
    	//Do nothing
    }
    else
    {
    	header('location:home.php');
		exit();
    }
	}
    $illegal=array();
    $uid=$_SESSION['email'];
	$res=0;
	require_once('server.php');
	require_once('teacher_tables.php');
	 if(isset($_SESSION['usrtype']))
	 {
	 	if($_SESSION['usrtype']=='teacher')
	 	{
	 		if(isset($_POST['submit_vid']))
	 		{
	 			if(!isset($_POST['vodname'])||empty($_POST['vodname']))
				{
				 	array_push($illegal, 'vodname');
				}
				if(!isset($_POST['vodsub'])||empty($_POST['vodsub']))
				{
					array_push($illegal, 'vodsub');
				}
	 			$link=$_POST['vodlink'];
	 			if(!verify_vod($link))
	 			{
	 				array_push($illegal, 'vodlink');
	 			}

	 			$rand=mt_rand(0,99999999999999);
	 			$name=$_POST['vodname'];
	 			$subject=$_POST['vodsub'];
	 			$date=date("Y-m-d H:i:s");
	 			if (mysqli_connect_errno()) {
   				 //printf("Connect failed: %s\n", mysqli_connect_error());
    			//exit();
	 				echo "Failed";
				}
				if ($stmt = mysqli_prepare($conn, "INSERT INTO teacher_vod VALUES(?,?,?,?,?,?)")) {

    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, 'isssss', $rand,$uid,$name,$subject,$date,$link);
}
else
{
	echo "Failed";
	//session_destroy();
}

    /* execute query */
    if(count($illegal)==0)
    {
    	$res=mysqli_stmt_execute($stmt);
    }
    else
    {
    	$res=false;
    }


    /* bind result variables */
   // mysqli_stmt_bind_result($stmt, $ruid,$rpasswd);

    /* fetch value */
   // mysqli_stmt_fetch($stmt);

    /* store result */
    /* close statement */
    mysqli_stmt_close($stmt);

/* close connection */
//mysqli_close($conn);
	 		}
	 	}
	 }
?>
<!DOCTYPE html>
<html>
<head>
<title>Teacher Finder - Add Video</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="css/footstyle.css">
    <link rel="stylesheet" type="text/css" href="css/navstyle.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/48e4b8916e.js"></script>
</head>
<body class="bg-info text-light">
	 <?php require 'navbar.php';
      $chk=isset($_SESSION['usrtype']);
    if ($chk){
      if($_SESSION['usrtype']=='teacher')
      teacher_navbar();
      else if($_SESSION['usrtype']=='student')
      student_navbar();
  }
  else{

    default_navbar();
  }

?>
	<div class="container-fluid">
		<div class="row">
			<div class="col">
			<?php
	if(isset($_SESSION['usrtype']))
	 {
	 	if($_SESSION['usrtype']=='teacher')
	 	{
			  if(isset($_POST['submit_vid']))
  				{
   				 if($res==true)
    				{
    				echo '<div class="alert alert-dark" role="alert">Your Video has added to database!</div>';
    				}
    			else if(in_array('vodlink',$illegal))
    			{
    				    	//echo "<script>window.onload=function(){window.alert('Youtube video does not exist');}</script>";
    				    	echo '<div class="alert alert-danger" role="alert">Video Does not Exist in Youtube!</div>';
    			}
    			else if(in_array('vodsub',$illegal))
    			{
    				    	//echo "<script>window.onload=function(){window.alert('Youtube video does not exist');}</script>";
    				    	echo '<div class="alert alert-danger" role="alert">Video Subject Not Entered</div>';
    			}
    			else if(in_array('vodname',$illegal))
    			{
    				    	//echo "<script>window.onload=function(){window.alert('Youtube video does not exist');}</script>";
    				    	echo '<div class="alert alert-danger" role="alert">Video Title Not Entered</div>';
    			}
    			else
    				{
    				echo '<div class="alert alert-danger" role="alert">An error has occured please contact support!</div>';
    	 			//printf("Error: %s.\n", mysqli_stmt_error($stmt));
    	 			//echo $_SESSION['email'];
    			}
			 }
			}
		}
			?>
		</div>
		</div>
		<div class="row">
			<div class="col-1">
			</div>
			<div class="col-10">
<?php
echo <<<EOT
<form class="form-inline" method="post" onsubmit="return nosubmit(event)">
  <div class="form-group m-2 p-2">
    <label for="vod_perpg" class="m-2">Number of Results</label>
    <select class="form-control" id="vod_perpg" name="perpg">
EOT;
	$printvar=conEcho($_SESSION['vod']['perpg'],'3');
     echo '<option value="3" '.$printvar.'>3</option>';
     	$printvar=conEcho($_SESSION['vod']['perpg'],'5');
      echo '<option value="5" '.$printvar.'>5</option>';
      	$printvar=conEcho($_SESSION['vod']['perpg'],'10');
      echo '<option value="10" '.$printvar.'>10</option>';
      	$printvar=conEcho($_SESSION['vod']['perpg'],'20');
      echo '<option value="20" '.$printvar.'>20</option>';
      	$printvar=conEcho($_SESSION['vod']['perpg'],'30');
      echo '<option value="30" '.$printvar.'>30</option>';
echo <<<EOT
    </select>
  </div>
  <div class="form-group m-2 p-2">
    <label for="orderer" class="m-2">Select Order</label>
    <select class="form-control" id="vod_orderer" name="orderer">
EOT;
	   $printvar=conEcho($_SESSION['vod']['orderer'],'ASC');
      echo '<option value="ASC" '.$printvar.'>Ascending</option>';
	   $printvar=conEcho($_SESSION['vod']['orderer'],'DESC');
      echo '<option value="DESC" '.$printvar.'>Descending</option> ';
echo <<<EOT
    </select>
  </div>
    <div class="form-group m-2 p-2">
    <label for="sorter" class="m-2">Sort By</label>
    <select class="form-control" id="vod_sorter" name="sorter">
EOT;
	 $printvar=conEcho($_SESSION['vod']['sorter'],'name');
      echo '<option value="name" '.$printvar.'>Video Title</option>';
	 $printvar=conEcho($_SESSION['vod']['sorter'],'vod_date');
     echo '<option value="vod_date" '.$printvar.'>Upload Date</option>';
	 $printvar=conEcho($_SESSION['vod']['sorter'],'subject');
     echo '<option value="subject" '.$printvar.'>Video Subject</option>';
     echo $_SESSION['vod']['sorter'];
echo <<<EOT
    </select>
  </div>
  <div class="form-group m-2 p-2">
    <label for="narrower" class="m-2">Narrow By Category</label>
    <select class="form-control" id="vod_narrower" name="narrower">
      
EOT;
$printvar=conEcho($_SESSION['vod']['narrower'],'NA');
echo '<option value="NA" '.$printvar.'>Do Not Narrow</option>';
popSubject();
$printvar=conEcho($_SESSION['vod']['narrower'],'Others');
echo '<option value="Others"'.$printvar.'>Others</option>';
echo <<<EOT
    
    </select>
  </div>
  <div class="form-group m-2 p-2">
  <button type="button" class="btn btn-secondary mb-2" name="custom_sub_vod" onclick="subVod()">Search</button>
  </div>
</form>
EOT;

///Search Panel -------	 
/*if ($res) {
	
	if(is_null($res))
		{
			echo '<div class="alert alert-dark" role="alert">No Videos</div>';
		}
		else if(mysqli_num_rows($res)==0)
		{						
			echo '<div class="alert alert-dark" role="alert">No Videos</div>';
		}
		else
		{	
			printVodTable();
		}
 
}

//mysqli_close($conn);*/
?>
		<div id="vod-tab-cont">
			<?php
			printVodTable();
			?>
		</div>
		</div>
			<div class="col-1">
			</div>
		</div>
		<div class="row">
			<div class="col-3">
			</div>
			<div class="col-6 bg-secondary init-hide" style="opacity: 1">
				<form action="addvideo.php" method="post" class="form-group" style="margin-top:20px">
					<label for="vodname">Enter Title:</label>
					<input id="vodname" type="text" name="vodname" size="50" class="form-control" required="">
					<label for="vodlink">Enter Video Link:</label>
					<input id="vodlink" type="text" name="vodlink" size="1000" class="form-control" required="">
					<label for="vodsub">Enter Subject:</label>
					<input id="vodsub" type="text" name="vodsub" size="50" class="form-control" required="">

					<button type="submit" name="submit_vid" class="btn btn-block btn-outline-success btn-warning mt-3">Add Video</button>
				</form>
			</div>
			<div class="col-3">
			</div>
		</div>
	</div>
<script type="text/javascript" src="js/validVideo.js"></script>
</body>
</html>