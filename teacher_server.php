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

require_once 'mailer.php';
$fname = "";
$lname ="";
$gender = "";
$email = "";
$state="";
$contact = "";
$city="";
$street = "";
$house = "";
$landmark = "";
$pin = "";
$subpri="";
$errors = array();


// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'teacher_finder');

// if the register button is clicked
if (isset($_POST['submit_reg']))
{
    $cityArr=$_SESSION['cities'];
    $stateArr=$_SESSION['states'];
    $fname = ($_POST['fname']);
    $lname = ($_POST['lname']);
    $gender = ($_POST['gender']);
    $email = ($_POST['email']);
    $contact = ($_POST['contact']);
    $pin = ($_POST['pin']);
    $password_1 = ($_POST['password_1']);
    $password_2 = ($_POST['password_2']);
    $city = $_POST['city'];
    $state=$_POST['state'];
    $street = $_POST['street'];
    $house = $_POST['house'];
    $landmark = $_POST['landmark'];
    $offcheck = "";
    if(isset($_POST['off-check']))
    {
    $offcheck = $_POST['off-check'];
    }
    $fees=0;
    $slots=0;
    if($offcheck=="yes")
    {
        $fees=$_POST['fees'];
        $slots=$_POST['slots'];
        $offcheck=1;
    }
    else
    {
        $offcheck=0;
    }
    $query_1 = "SELECT * FROM teacher_data WHERE email='$email'";
    //$query_2 = "SELECT * FROM teacher_data WHERE contact='$contact'";
    $result_1 = mysqli_query($db, $query_1);
    //$result_2 = mysqli_query($db, $query_2);
      if (empty($fname)) {
        array_push($errors, "First Name is required");
    }
    if (empty($lname)) {
        array_push($errors, "Last Name is required");
    }
    if (empty($gender)) {
        array_push($errors, "Gender is required");
    }
    // Email check
    if (empty($email)) {
        array_push($errors, "Email id is required");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors,"$email is an invalid email address");
    } 
    
    if (mysqli_num_rows($result_1) >= 1) { 
        array_push($errors, "The email is already taken");
    }
    if (empty($contact)) {
        array_push($errors, "Contact number is required");
    }
    if (empty($pin)) {
        array_push($errors, "Pin number is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    if (empty($street)) {
        array_push($errors, "Street information is required");
    }

     if (empty($city)) {
        array_push($errors, "City is required");
    }
     if (empty($state)) {
        array_push($errors, "State is required");
    }
    if ((int)$slots < 0) {
        array_push($errors, "Slots is required");
    }
    if ((float)$fees < 0) {
        array_push($errors, "Fees is required");
    }
        // ensure that form fields are filled properly  
    if (count($errors) == 0) 
    {
        $password = sha1($password_1);
        $sql = "INSERT INTO teacher_data (fname, lname, gender, email, contact, street,house,landmark,city,state,pin, password,fees,slots,accept) VALUES ('$fname','$lname', '$gender', '$email', '$contact', '$street','$house','$landmark', '$city','$state','$pin', '$password' , '$fees' , '$slots' ,'$offcheck')";
        mysqli_query($db, $sql);
        $sql= "INSERT INTO teacher_uid (id,email) VALUES (NULL,'$email')";
        mysqli_query($db, $sql);
        $hash=md5(rand(1200,9000).$email).sha1(rand(1200,9000).$email);
        $sql= "INSERT INTO teacher_verified (email,link,verified_mail,verified_doc) VALUES ('$email','$hash','0','0')";
        mysqli_query($db, $sql);
        $body="Verify Your email at this link <a href='localhost/project/teacher_verify.php?vid=$hash'><strong>Click Here</strong></a>";
        sendVerifyLink($email,"TeacherFinder : Email Needs Confirmation",$body);
        $_SESSION['email'] = $email;
        $_SESSION['success'] = "You are now logged in";
        $_SESSION["usrtype"] = "teacher";
        $_SESSION['fname'] = $fname;
        $_SESSION['lname'] = $lname;
        $_SESSION['searchable'] = 0;
        header('location: after_teacher_login.php');  //redirect next page
    }
    else
    {
         echo '<div class="error">';
        //echo "<script>alert(".print_r($GLOBALS['errors']).")</script>";
        if (count($errors) > 0)
        {
           
            foreach ($errors as $error)
            {
                echo '<p>'.$error.'</p>';
            }
        
        }
        echo '</div>';
    }

}



 // log user in form login page
 if (isset($_POST['login'])) 
 {
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
 	 /*if (empty($usrtype)) {
 		array_push($errors, "User Type is not selected");
 	 }
 	 if (!($usrtype === 'student' || $usrtype === 'teacher'))
 	 {
 	 	array_push($errors, "User Type is not proper");
 	 }*/
 	if (count($errors) == 0 ) {
 		$password = sha1($password);
 		//$query = "SELECT * FROM teacher_data WHERE email='$email' AND password='$password'";
        $query= "SELECT teacher_data.*,teacher_image.* FROM teacher_data LEFT outer JOIN teacher_image ON teacher_data.email = teacher_image.email WHERE teacher_data.email='$email' AND teacher_data.password='$password' ORDER BY teacher_image.id DESC";
  		$result = mysqli_query($db, $query);
 		if (mysqli_num_rows($result) >= 1) {
 			// log user in
 			$_SESSION['email'] = $email;
 			$_SESSION['success'] = "You are now logged in";
            $_SESSION['usrtype'] = "teacher";
            if ($row = mysqli_fetch_row($result)) {
                $_SESSION['fname'] = $row[1];
 				$_SESSION['lname'] = $row[2];
                $_SESSION['searchable']=$row[15];
                /*
 				$_SESSION['gender'] = $row[3];
 				$_SESSION['contact']=$row[4];
 				$_SESSION['street']=$row[5];
 				$_SESSION['house']=$row[6];
 				$_SESSION['landmark']=$row[7];
 				$_SESSION['city']=$row[8];
 				$_SESSION['pin']=$row[9];
                */
                if (!is_null($row[19]))
                $_SESSION['src']="avatar.png";
                else
                { 
                $_SESSION['src']=$row[19];
                }
                 //header('location: after_teacher_login.php'); //redirect to dashboard  
            }
                if(isset($_SESSION['vid']))
                {
                $vid=$_SESSION['vid'];
                header('location:teacher_verify?vid='.$vid.'');
                die();
                }
                header('location: after_teacher_login.php'); //redirect to dashboard
 		 }
                else
                {
                array_push($errors, "wrong username/password combination");
                }
 		}

 	}



 ?>