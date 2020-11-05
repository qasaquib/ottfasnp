<?php
session_start();
include ('server.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Teacher Finder Notify</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
</head>
<body class="bg-black">
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
<div class="container-fluid text-light">
<div class="row">
	<div class="col-1">
	</div>
	<div class="col-10">
		<?php
				echo <<<EOT
				<div class="form-group p-4">
				<label for="receiver">Choose Recipient</label>
				<select name="receiver" id="receiver" class="form-control mb-2">
				<option value="subs">All Subscribers</option>
				<option value="off_stu">All Offline Students</option>
				EOT;
				printRecvList();
				echo <<<EOT
				</select>
				<label for="aqTextarea">Enter your Message here</label>
				<textarea class="form-control" id="aqTextarea" name="aqTextarea" rows="4" name="aq">
				</textarea>
				<button id="aqSubmit" type="button" class="btn btn-light m-2" name="aqSubmit">Send Notification</button>
				</div>
				EOT;
		?>
	</div>
	<div class="col-1">
	</div>
</div>
</div>
<script type="text/javascript">
	$("#aqSubmit").click(function(){
		let msg = $("#aqTextarea").html();
		let recv= $("#receiver").val();
		$.post("assets.php",{message:1,"msg_cont":msg,"recv":recv},function(result){
		var x =result;
		//window.alert(x);
		if(result!="Failed")
		{
			alert("Message Sent");
		}
	})});
</script>
</body>
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