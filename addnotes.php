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
     $uid=$_SESSION['email'];
	 $res=0;
	require_once('server.php');
	require_once('teacher_tables.php');
	$illegal=array();
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
				$allowed = array('pdf','doc','docx','ppt','pptx','odt','odp','jpg');
			if(!isset($_POST['docname'])||empty($_POST['docname']))
			{
				array_push($illegal, 'docname');
			}
			if(!isset($_POST['docsub'])||empty($_POST['docsub']))
			{
				array_push($illegal, 'docsub');
			}

			if(in_array($fileActualExt,$allowed) && count($illegal)==0)
			{
				$fileActualExt=".".$fileActualExt;
				if($fileError===0){
					if($fileSize<1000000000){
	 			$rand=mt_rand(0,99999999999999);
	 			$name=$_POST['docname'];
	 			$subject=$_POST['docsub'];
	 			$date=date("Y-m-d H:i:s");
	 			$link="";
	 			//$link=fread($fp,filesize($_FILES['docfile']['tmp_name']));
	 			//$link=addslashes($link);
	 			//$link=file_get_contents($_FILES['docfile']['tmp_name']);
	 			if (mysqli_connect_errno()) {
   				 //printf("Connect failed: %s\n", mysqli_connect_error());
    			//exit();
	 				//echo "Failed";
	 			array_push($illegal, 'docfile');
				}
				else{
				if ($stmt = mysqli_prepare($conn, "INSERT INTO teacher_docs VALUES(?,?,?,?,?,?,?,?)")) {


    			/* bind parameters for markers */
   					 mysqli_stmt_bind_param($stmt, 'issssbss', $rand,$uid,$name,$subject,$date,$link,$fileType,$fileActualExt);
   			 		 $fp=fopen($_FILES['docfile']['tmp_name'],'rb');
						while (!feof($fp)) {
   						mysqli_stmt_send_long_data($stmt,5,fread($fp, 8192));
						}
					fclose($fp);
					}
				}
   			}
  		}	
	}
else
{
	array_push($illegal, 'docfile');
	//echo "Failed";
	//session_destroy();
}
}
else
{
	array_push($illegal, 'docfile');
	//echo "Failed";
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
    if(count($illegal)==0)
    {
    	mysqli_stmt_close($stmt);
	}

/* close connection */
//mysqli_close($conn);
	 	}
	 }
	 
?>
<!DOCTYPE html>
<html>
<head>
<title>Teacher Finder - Mannage Notes</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="css/footstyle.css">
    <link rel="stylesheet" type="text/css" href="css/navstyle.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
  <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
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
			  if(isset($_POST['submit_doc']))
  				{
   				 if($res==true)
    				{
    				echo '<div class="alert alert-dark" role="alert">Your Document was uploaded successfully!</div>';
    				}
    			else if(in_array('docfile', $illegal))
    			{
    				    	echo '<div class="alert alert-danger" role="alert">The document type was improper.Please use pdf, doc , ppt files only. Also make sure document name and subjects are filled in.</div>';
    			}
     			else if(in_array('docsub', $illegal))
    			{
    				    	echo '<div class="alert alert-danger" role="alert">Document Subject Not Entered</div>';
    			}
     			else if(in_array('docname', $illegal))
    			{
    				    	echo '<div class="alert alert-danger" role="alert">Document Title Not Entered</div>';
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
    <label for="perpg" class="m-2">Number of Results</label>
    <select class="form-control" id="doc_perpg" name="perpg">
EOT;
	$printvar=conEcho($_SESSION['doc']['perpg'],'3');
     echo '<option value="3" '.$printvar.'>3</option>';
     	$printvar=conEcho($_SESSION['doc']['perpg'],'5');
      echo '<option value="5" '.$printvar.'>5</option>';
      	$printvar=conEcho($_SESSION['doc']['perpg'],'10');
      echo '<option value="10" '.$printvar.'>10</option>';
      	$printvar=conEcho($_SESSION['doc']['perpg'],'20');
      echo '<option value="20" '.$printvar.'>20</option>';
      	$printvar=conEcho($_SESSION['doc']['perpg'],'30');
      echo '<option value="30" '.$printvar.'>30</option>';
echo <<<EOT
    </select>
  </div>
  <div class="form-group m-2 p-2">
    <label for="orderer" class="m-2">Select Order</label>
    <select class="form-control" id="doc_orderer" name="orderer">
EOT;
	   $printvar=conEcho($_SESSION['doc']['orderer'],'ASC');
      echo '<option value="ASC" '.$printvar.'>Ascending</option>';
	   $printvar=conEcho($_SESSION['doc']['orderer'],'DESC');
      echo '<option value="DESC" '.$printvar.'>Descending</option> ';
echo <<<EOT
    </select>
  </div>
    <div class="form-group m-2 p-2">
    <label for="sorter" class="m-2">Sort By</label>
    <select class="form-control" id="doc_sorter" name="sorter">
EOT;
	 $printvar=conEcho($_SESSION['doc']['sorter'],'name');
      echo '<option value="name" '.$printvar.'>Document Title</option>';
	 $printvar=conEcho($_SESSION['doc']['sorter'],'doc_date');
     echo '<option value="doc_date" '.$printvar.'>Upload Date</option>';
	 $printvar=conEcho($_SESSION['doc']['sorter'],'subject');
     echo '<option value="subject" '.$printvar.'>Document Subject</option>';
     echo $_SESSION['doc']['sorter'];
echo <<<EOT
    </select>
  </div>
  <div class="form-group m-2 p-2">
    <label for="narrower" class="m-2">Narrow By Category</label>
    <select class="form-control" id="doc_narrower" name="narrower">
      
EOT;
$printvar=conEcho($_SESSION['doc']['narrower'],'NA');
echo '<option value="NA" '.$printvar.'>Do Not Narrow</option>';
popSubject();
$printvar=conEcho($_SESSION['doc']['narrower'],'Others');
echo '<option value="Others"'.$printvar.'>Others</option>';
echo <<<EOT
    
    </select>
  </div>
  <div class="form-group m-2 p-2">
  <button type="button" class="btn btn-secondary mb-2" name="custom_sub_doc" onclick="subDoc()">Search</button>
  </div>
</form>
EOT;

///Search Panel -------	 


//mysqli_close($conn);
?>
			<div id="doc-tab-cont">
				<?php
				        printDocTable();
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
				<form action="addnotes.php" method="post" class="form-group" style="margin-top:20px" enctype="multipart/form-data">
					<label for="docname">Enter Title:</label>
					<input id="docname" type="text" name="docname" size="50" class="form-control">
					<label for="docsub">Enter Subject:</label>
					<input id="docsub" type="text" name="docsub" size="50" class="form-control">
					<label for="docfile">Upload Document Here:</label>
					<input id="docfile" type="file" name="docfile">
					<button type="submit" name="submit_doc" class="btn btn-block btn-outline-success mt-3">Add Document</button>
				</form>
			</div>
			<div class="col-3">
			</div>
		</div>
	</div>
<script type="text/javascript" src="js/validNotes.js"></script>
</body>
</html>