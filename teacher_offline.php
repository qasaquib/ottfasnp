<?php
	session_start();
	if(!(isset($_SESSION['success'])&& $_SESSION['usrtype']==='teacher')) 
    {
      header('location: teacher_signin.php');
    }
	require_once('server.php');
	require_once('teacher_tables.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>Teacher Finder - Offline Requests</title>
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
			//alerts
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
    <label for="req_perpg" class="m-2">Number of Results</label>
    <select class="form-control" id="req_perpg" name="perpg">
EOT;
  $printvar=conEcho($_SESSION['req']['perpg'],'3');
     echo '<option value="3" '.$printvar.'>3</option>';
      $printvar=conEcho($_SESSION['req']['perpg'],'5');
      echo '<option value="5" '.$printvar.'>5</option>';
        $printvar=conEcho($_SESSION['req']['perpg'],'10');
      echo '<option value="10" '.$printvar.'>10</option>';
        $printvar=conEcho($_SESSION['req']['perpg'],'20');
      echo '<option value="20" '.$printvar.'>20</option>';
        $printvar=conEcho($_SESSION['req']['perpg'],'30');
      echo '<option value="30" '.$printvar.'>30</option>';
echo <<<EOT
    </select>
  </div>
  <div class="form-group m-2 p-2">
    <label for="req_orderer" class="m-2">Select Order</label>
    <select class="form-control" id="req_orderer" name="orderer">
EOT;
     $printvar=conEcho($_SESSION['req']['orderer'],'ASC');
      echo '<option value="ASC" '.$printvar.'>Ascending</option>';
     $printvar=conEcho($_SESSION['req']['orderer'],'DESC');
      echo '<option value="DESC" '.$printvar.'>Descending</option> ';
echo <<<EOT
    </select>
  </div>
    <div class="form-group m-2 p-2">
    <label for="req_sorter" class="m-2">Sort By</label>
    <select class="form-control" id="req_sorter" name="sorter">
EOT;
   $printvar=conEcho($_SESSION['req']['sorter'],'name');
      echo '<option value="name" '.$printvar.'>Student Name</option>';
   $printvar=conEcho($_SESSION['req']['sorter'],'req_date');
     echo '<option value="req_date" '.$printvar.'>Upload Date</option>';
   $printvar=conEcho($_SESSION['req']['sorter'],'subject');
     echo '<option value="subject" '.$printvar.'>Subject</option>';
     //echo $_SESSION['req']['sorter'];
echo <<<EOT
    </select>
  </div>
  <div class="form-group m-2 p-2">
    <label for="req_narrower" class="m-2">Narrow By Category</label>
    <select class="form-control" id="req_narrower" name="narrower">
      
EOT;
$printvar=conEcho($_SESSION['req']['narrower'],'NA');
echo '<option value="NA" '.$printvar.'>Do Not Narrow</option>';
$arr=getSubject();
foreach ($arr as $key => $value) {
	$printvar=conEcho($_SESSION['req']['narrower'],$value);
	echo '<option value="'.$value.'" '.$printvar.'>'.$value.'</option>';
}
$printvar=conEcho($_SESSION['req']['narrower'],'Others');
echo '<option value="Others"'.$printvar.'>Others</option>';
echo <<<EOT
    
    </select>
  </div>
  <div class="form-group m-2 p-2">
  <button type="button" class="btn btn-secondary mb-2" name="custom_sub_req" id="custom_sub_req" onclick="requests.subReq()">Search</button>
  </div>
  </form>
EOT;
?>
			<div id="req-tab-cont">
				<?php
				        printReqTable();
				?>
			</div>
			</div>
			<div class="col-1">
			</div>
		</div>
		<div class="row">
			<div class="col-1">
			</div>
			<div class="col-10">
				<?php
       			$uid=$_SESSION['email'];
				$sql="SELECT * from teacher_batch INNER JOIN student_data ON teacher_batch.student_id = student_data.email WHERE teacher_batch.teacher_id like '$uid'"; 
				$result=mysqli_query($conn,$sql);
				if($result)
				{
				if(mysqli_num_rows($result)==0)
				{
					echo '<div class="alert alert-dark" role="alert">No Students Studying Offline</div>';
				}
				else
				{
				echo <<<EOT
								<h3>Student Studying Offline</h3>
								<div class="table-responsive">
								<table class="table table-dark">
								<thead>
								<tr>
								<th scope="col">Name</th>
								<th scope="col">Subject</th>
								<th scope="col">Email</th>
								</tr>
								</thead>
								<tbody>
				EOT;    
					while($row=mysqli_fetch_array($result))
					{
					//print_r($row);
					echo '<tr id ="'.$row[0].'row">';
					echo '<td scope="row" id ="'.$row[0].'name">'.$row['fname']." ".$row['lname'].'</td>';
                	 echo '<td id ="'.$row[0].'subject">'.$row['sub_name'].'</td>';;
                 	echo '<td id ="'.$row[0].'mail">'.$row[2].'</td>';
                 	echo '<td><button id="'.$row[0].'" type="button" class="btn btn-danger" onclick="batch.deletePress(\''.$row[0].'\')">Remove</button></td>';
              		echo '</tr>';
					}

					echo '</tbody>';
				}
				}
				?>
			</div>
			<div class="col-1">
			</div>
		</div>
	</div>
<script type="text/javascript" src="js/validOffline.js"></script>
<script>
	//alert(document.cookie);
</script>
</body>
</html>