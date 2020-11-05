<?php
session_start();
 // logout
if (isset($_GET['logout'])) {
    foreach ($_SESSION as $key => $value) {
        //echo $value;
        unset($_SESSION[''.$key.'']);
    }
    header('location:home.php');
    session_destroy();
    exit();
 }
 
$fname = "";
$lname ="";
$gender = "";
$email = "";
$contact = "";
$city="";
$state="";
$street = "";
$house = "";
$landmark = "";
$pin = "";
$subpri="";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'teacher_finder');


 // log user in form login page
 if (isset($_POST['login'])) {
 	$email = $_POST['email'];
 	$password = $_POST['password'];
 	//$usrtype = $_POST['usrtype'];
 	// ensure that form fields are filled properly
 	if (empty($email)) {
 		array_push($errors, "Email is required");
 	}
 	if (empty($password)) {
 		array_push($errors, "Password is required");
 	}
    //array_push($errors, "random error");
 	 /*if (empty($usrtype)) {
 		array_push($errors, "User Type is not selected");
 	 }
 	 if (!($usrtype === 'student' || $usrtype === 'teacher'))
 	 {
 	 	array_push($errors, "User Type is not proper");
 	 }*/
 	if (count($errors) == 0 ) {
 		$password = sha1($password);
 		$query = "SELECT * FROM student_data WHERE email='$email' AND password='$password'";
 		$result = mysqli_query($db, $query);
 		if (mysqli_num_rows($result) == 1) {
 			// log user in
 			$_SESSION['email'] = $email;
 			$_SESSION['success'] = "You are now logged in";
 			$_SESSION["usrtype"] = "student";
            //echo 'hello';
 			header('location: after_student_login.php'); //redirect to home page
 		}
        else{
 			array_push($errors, "wrong username/password combination");
 			//header('location: student_signin.php');
 		}
 	}
}





if (isset($_POST['submit_stu'])) {
 	$fname = ($_POST['fname']);
 	$lname = ($_POST['lname']);
 	$gender = ($_POST['gender']);
 	$email = ($_POST['email']);
 	$password_1 = ($_POST['password_1']);
 	$password_2 = ($_POST['password_2']);
 	$city = $_POST['city'];
 	$state = $_POST['state'];
 	$query_1 = "SELECT * FROM student_data WHERE email='$email'";
	$result_1 = mysqli_query($db, $query_1);
	//$result_2 = mysqli_query($db, $query_2);
	 // Email check
	 if (empty($email)) {
 		array_push($errors, "Email id is required");
 	}
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);

	// Validate e-mail
	if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
  		array_push($errors,"$email is a valid email address");
	} 
 	// ensure that form fields are filled properly
 	if (empty($fname)) {
 		array_push($errors, "First Name is required");
 	}
 	if (empty($lname)) {
 		array_push($errors, "Last name is required");
 	}
 	if (empty($gender)) {
 		array_push($errors, "Gender is required");
 	}

 	if (mysqli_num_rows($result_1) >= 1) { 
        array_push($errors, "The email is already taken");
    }
 	if (empty($password_1)) {
 		array_push($errors, "Password is required");
 	}
 	if ($password_1 != $password_2) {
 		array_push($errors, "The two passwords do not match");
 	}
 	
    if (empty($city)) {
 		array_push($errors, "City is required");
 	}
 	
 	if (empty($state)) {
 		array_push($errors, "State is required");
 	}
 	
 	if (count($errors) == 0) {
 		$password = sha1($password_1);
 		$sql = "INSERT INTO student_data (fname,lname, gender, email,city, state,password) VALUES ('$fname','$lname', '$gender', '$email', '$city', '$state' ,'$password')";
 		mysqli_query($db, $sql);
 		$sql= "INSERT INTO student_uid (id,email) VALUES (NULL,'$email')";
 		mysqli_query($db, $sql);
 		$_SESSION['email'] = $email;
 		$_SESSION['success'] = "You are now logged in";
 		$_SESSION["usrtype"] = "student";
 		$_SESSION['fname'] = $fname;
 		$_SESSION['lname'] = $lname;
 		$_SESSION['gender'] = $gender;
 		$_SESSION['city'] = $city;
 		header('location: after_student_login.php');  //redirect to home page
 	}
}



 ?>