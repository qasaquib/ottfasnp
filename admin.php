<?php
 session_start();
 if(isset($_POST['signout']))
 {
 	//print_r($_SESSION);
 	foreach ($_SESSION as $key => $value) {
 		//echo $value;
 		unset($_SESSION[''.$key.'']);
 	}
 	//echo '<br>';
 	//print_r($_SESSION);
	//session_unset();
	//echo session_id();
	session_destroy();
	//echo "session destroyed";
	//echo session_id();
 }
 	if(!isset($_SESSION['usrtype']))
	{
		header('location:home.php');
		exit();
	}
	else
	{
	if($_SESSION['usrtype']==='admin') 
    {
      header('location: admin/dashboard.php');
      exit();
    }
    else
    {
    	header('location:home.php');
		exit();
    }
	}
 if(isset($_POST['submit']))
 {
 	 $server = "localhost";
	 $user = "root";
	 $pw = "";
	 $db="teacher_finder";
	 $conn=mysqli_connect($server,$user,$pw,$db);
	 $uid=$_POST['uname'];
	 $passwd=$_POST['pass'];
	 $passwd=sha1($passwd);
	//echo $uid.$passwd;
	 $ruid="";
	 $rpass="";

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
/* create a prepared statement */
if ($stmt = mysqli_prepare($conn, "SELECT * FROM admin WHERE name =? and pass=? ")) {

    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, 'ss', $uid,$passwd);
}
else
{
	echo "Failed";
	session_destroy();
}

    /* execute query */
    mysqli_stmt_execute($stmt);

    /* bind result variables */
   // mysqli_stmt_bind_result($stmt, $ruid,$rpasswd);

    /* fetch value */
   // mysqli_stmt_fetch($stmt);

    /* store result */
    $result=mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result)==1)
    {
    $row=mysqli_fetch_row($result);
    printf("logged in as %s\n", $uid);
    $_SESSION['usrtype']='admin';
    $_SESSION['id']=$row[0];
    header('location: admin/dashboard.php');
	}
	else
	{
	 echo 'Login Failed';
	 session_destroy();
	}
    /* close statement */
    mysqli_stmt_close($stmt);

/* close connection */
mysqli_close($conn);
 	//echo 'Admin Panel';
}

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
			</div>
			<div class="col-6">
				<form action="admin.php" method="post" class="form-group" style="margin-top:40%">
					<label for="name">UserID:</label>
					<input id="name" type="text" name="uname" size="20" class="form-control">
					<label for="password">Password:</label>
					<input ide="password" type="password" name="pass" size="20" class="form-control">
					<button type="submit" name="submit" class="btn btn-block btn-secondary mt-3">Submit</button>
				</form>
			</div>
			<div class="col-3">
				
			</div>
		</div>
	</div>
</body>
</html>