<?php
session_start();
require '../server.php';
//echo 'Hello';
//if(isset($_SESSION['admin_id']))
//echo $_SESSION['admin_id'];
//echo session_id();
?>
<!DOCTYPE html>
<html>
<head>
	<title>ADMIN LOGIN</title>
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
<body class="bg-dark text-light">
	<div class="container-fluid">
		<div class="row">
			<div class="col-3">
			<form action="../admin.php" method="post" class="form-group" style="margin-top:40%">
					<button type="submit" name="signout" class="btn btn-block btn-secondary mt-3">Log Out</button>
				</form>
			</div>
			<div class="col-6">

			</div>
			<div class="col-3">
				
			</div>
		</div>
		<div class="row">
			<div class="col-1">

			</div>
			<div class="col-10">
				<?php
				$id=$_SESSION['id'];
				$sql="SELECT * from teacher_kyc INNER JOIN teacher_data ON teacher_kyc.teacher_id = teacher_data.email WHERE teacher_id IN (SELECT teacher_id from admin_kyc WHERE admin_id = '$id' AND status = 'PENDING')";
				$res=mysqli_query($conn,$sql);
				echo '  <table class="table table-dark">
				<thead>
				<tr>
				<th scope="col">Teacher Name</th>
				<th scope="col">Address</th>
				<th scope="col">City</th>
				<th scope="col">State</th>
				<th scope="col">Phone Number</th>
				<th scope="col">Document Proof</th>
				<th colspan="2">Give/Decline Verified Tag</th>
				</tr>
				</thead>
				<tbody>';
				while ($row=mysqli_fetch_assoc($res)) {
				$sp_id=encodeMail('teacher',$row['email']);

				 echo '<tr id ="'.$sp_id.'row">';
				 echo '<td id ="'.$sp_id.'name">'.$row['fname'].' '.$row['lname'].'</td>';
                 echo '<td id =" '.$sp_id.'addr">'.$row['house'].' '.$row['street'].'</td>';
                  echo '<td id ="'.$sp_id.'city">'.$row['city'].'</td>';
                  echo '<td id ="'.$sp_id.'state">'.$row['state'].'</td>';
                  echo '<td id ="'.$sp_id.'contact">'.$row['contact'].'</td>';
                  echo '<td id ="'.$sp_id.'link"><a href="../doc_viewer.php?cid='.$sp_id.'">View Document</a></td>';
                  echo '<td><button id="'.$sp_id.'" type="button" class="btn btn-success" onclick="acceptPress(\''.$sp_id.'\')">Accept</button></td>';
                  echo '<td><button id="'.$sp_id.'" type="button" class="btn btn-danger" onclick="deletePress(\''.$sp_id.'\')">Decline</button></td>';
                  echo '</tr>';

				}
				echo "</tbody>";
            	echo "</table>";
            	echo "</div>";
				?>
			</div>
			<div class="col-1">
				
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
function acceptPress(strng) 
{
	//window.alert("accepted"+strng+"");
	//var txt = strng;
	if(window.confirm("Are You Sure?"))
	{
		this.accFunc(strng);
	}
	else
	{
		window.alert("Request Not Accepted");
	}
}


function delFunc(txt)
{
		//alert("Deleting....");
		//let mailID=$("#"+txt+"mail").html();
		//let nameText=$("#"+txt+"name").html();
		//let subjectText=$("#"+txt+"subject").html();
		$.post("../assets.php",{kyc_id:txt,type:'del'},function(result){
		var x =result;
		window.alert(x);
		if(result!="Failed")
		{
			$("tr#"+txt+"row").remove();
			location.reload();
		}
		});
}


function accFunc(txt)
{
		//alert("Accepting....");
		//let mailID=$("#"+txt+"mail").html();
		//let nameText=$("#"+txt+"name").html();
		//let subjectText=$("#"+txt+"subject").html();
		//alert(txt);
		//alert(mailID);
		$.post("../assets.php",{kyc_id:txt,type:'acc'},function(result){
		var x =result;
		window.alert(x);
		if(result!="Failed")
		{
			$("tr#"+txt+"row").remove();
			location.reload();
		}
		});

}


function deletePress(strng) {
	//window.alert("deleted"+strng+"");
	//var txt = strng;
	if(window.confirm("Are You Sure?"))
	{
		this.delFunc(strng);
	}
	else
	{
		window.alert("Request Not Declined");
	}
}
</script>
</html>