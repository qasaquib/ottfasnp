<?php require ('../teacher_server.php'); 
if (empty($_SESSION['usrtype'])) {
	header('location: ../home.php');
}
else if((isset($_SESSION['success'])&& $_SESSION['usrtype']==='teacher')) 
    {
      header('location: ../after_teacher_signin.php');
    }
else if((isset($_SESSION['success'])&& $_SESSION['usrtype']==='student')) 
    {
      header('location: ../after_student_signin.php');
    }
else
	header('location: ../home.php');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width,initial-scale=1.0">
  	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  	<script src="https://kit.fontawesome.com/48e4b8916e.js"></script>
	<title>𝓣𝓮𝓪𝓬𝓱𝓮𝓻𝓕𝓲𝓷𝓭𝓮𝓻</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="header">
		<h2>Home Page</h2>
	</div>

	<div class="content">
		<?php if (isset($_SESSION['success'])): ?>
			<div class="error success">
				<h3>
					<?php
					echo $_SESSION['success'];
					//unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>

		<?php// if (isset($_SESSION["name"])): ?>
			<p>Welcome <strong><?php //echo $_SESSION['name']; ?></strong></p>
			<p><a href="index.php?logout='1'" style="color: red;">Singout</a></p>
		<?php// endif ?>
	</div>
</body>
</html>