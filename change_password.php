<?php 
  session_start();
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
  require_once 'server.php';
  require_once ('edit_functions.php');
    $errors=array();
    $email;
  ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://kit.fontawesome.com/48e4b8916e.js"></script>
  <script src="js/auth_pass.js"></script>
  <link rel="stylesheet" type="text/css" href="css/navstyle.css">
  <title>𝓣𝓮𝓪𝓬𝓱𝓮𝓻𝓕𝓲𝓷𝓭𝓮𝓻</title>
</head>


<body class="bg-black">
    <?php require 'navbar.php';
    
      $chk=isset($_SESSION['usrtype']);
      $src="";
    if ($chk){
      if($_SESSION['usrtype']=='teacher')
      {
         $email= $_SESSION['email'];
      if(isset($_POST['submit_tea']))
      {
            $password_p = ($_POST['password_p']);
            $password_1 = ($_POST['password_1']);
            $password_2 = ($_POST['password_2']);
            //$query_2 = "SELECT * FROM teacher_data WHERE contact='$contact' AND email <> '$email'";
            if (empty($password_p)) {
              array_push($errors, "Previous Password is Not Correct");
            }
            else{
              $pass_hash=sha1($password_p);
              $query_1 = "SELECT * FROM teacher_data WHERE email='$email' AND password = '$pass_hash'";
              $result_1 = mysqli_query($conn, $query_1);
              if (mysqli_num_rows($result_1) < 1) { 
                  array_push($errors, "Previous Password is Not Correct");
              }
            }
            
            // ensure that form fields are filled properly
            if (empty($password_1)) {
              array_push($errors, "Password is required");
            }
            if (empty($password_2)) {
              array_push($errors, "The two passwords do not match");
            }
            if ($password_1 != $password_2) {
              array_push($errors, "The two passwords do not match");
            }
            if (count($errors) == 0) {
            $password = sha1($password_1);
            $sql = "UPDATE teacher_data SET password='$password' WHERE email='$email'";
            mysqli_query($conn, $sql);
            }
      }
      teacher_navbar();
            //echo $email;
  }
      else if($_SESSION['usrtype']=='student')
      {
        $email= $_SESSION['email'];
        if(isset($_POST['submit_stu']))
        {
        $password_1 = ($_POST['password_1']);
        $password_2 = ($_POST['password_2']);
        $password_p=($_POST['password_p']);
          if (empty($password_p)) {
              array_push($errors, "Previous Password is Not Correct");
            }
            else{
              $pass_hash=sha1($password_p);
              $query_1 = "SELECT * FROM student_data WHERE email='$email' AND password = '$pass_hash'";
              $result_1 = mysqli_query($conn, $query_1);
              if (mysqli_num_rows($result_1) < 1) { 
                  array_push($errors, "Previous Password is Not Correct");
              }
            }
        //$result_2 = mysqli_query($conn, $query_2);
        // ensure that form fields are filled properly
        if (empty($password_1)) {
          array_push($errors, "Password is required");
        }
        if (empty($password_2)) {
          array_push($errors, "Passwords do not match");
        }
        if ($password_1 != $password_2) {
          array_push($errors, "The two passwords do not match");
        }
          
  
        if (count($errors) == 0) {
        $password = sha1($password_1);
        $sql = "UPDATE student_data SET password='$password' WHERE email='$email'";
        mysqli_query($conn, $sql);
        }
      }
      student_navbar();
      //echo $email;
    }
  else{

    default_navbar();

  }
}
else
{
  header("location:home.php");
}
?>
  <br><h4 class="msg cg">CHANGE PASSWORD</h4><br>
 
  <div class="container">
    <div class="row">
      <div class="col">
        <?php
          if(count($errors)>0)
          {
            echo '<div class="alert alert-danger" role="alert">Could Not Change Password!</div>';
          }
          else if(isset($_POST['submit_stu'])||isset($_POST['submit_tea']))
          {
            if(count($errors)==0)
            {
            echo '<div class="alert alert-dark" role="alert">Password Changed</div>';
            }
          }
        ?>
      </div>
    </div>
    <div class="row">

        <div class="col-lg-3"></div>

        <div class="col-lg-6">
          <div id="ui">
            <br>
            <?php
            if((isset($_SESSION['success'])&& $_SESSION['usrtype']==='teacher')) 
            {
            teacher_pass_form($_SESSION['email']);
            }
            else if((isset($_SESSION['success'])&& $_SESSION['usrtype']==='student')) 
            {
            student_pass_form($_SESSION['email']);
            }
            else
            {
              header('location : home.php');
            }
            ?>
          </div>
        </div>
        <div class="col-lg-3"></div>
    </div>
  </div>
</body>  
</html>
