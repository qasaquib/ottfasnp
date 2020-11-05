<?php 
  session_start();
  require_once 'server.php';
  $db = mysqli_connect('localhost', 'root', '', 'teacher_finder');
    require ('edit_functions.php');
    $errors=array();
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
  <link rel="stylesheet" type="text/css" href="css/navstyle.css">
  <title>𝓣𝓮𝓪𝓬𝓱𝓮𝓻𝓕𝓲𝓷𝓭𝓮𝓻</title>
</head>


<body class="bg-black">
    <?php require 'navbar.php';
      $fname = $lname = $gender =$email =$contact = $pin = $city =$state= $street = $house = $landmark = "";
      $chk=isset($_SESSION['usrtype']);
      $src="";
    if ($chk){
      if($_SESSION['usrtype']=='teacher')
      {
      if(isset($_POST['submit_tea']))
      {
            $fname = ($_POST['fname']);
            $lname = ($_POST['lname']);
            $gender = ($_POST['gender']);
            $email = ($_SESSION['email']);
            $contact = ($_POST['contact']);
            $pin = ($_POST['pin']);
            $city = $_POST['city'];
            $state= $_POST['state'];
            $street = $_POST['street'];
            $house = $_POST['house'];
            $landmark = $_POST['landmark'];
            $query_2 = "SELECT * FROM teacher_data WHERE contact='$contact' AND email <> '$email'";
            
            $result_2 = mysqli_query($db, $query_2);
            // ensure that form fields are filled properly
            if (empty($fname)) {
              array_push($errors, "First Name is required");
            }
            if (empty($lname)) {
              array_push($errors, "Last Name is required");
            }
            if (empty($gender)) {
              array_push($errors, "Gender is required");
            }

            if (empty($contact)) {
                  array_push($errors, "Contact number is required");
             }
            // Mobile number check

           // if (mysqli_num_rows($result_2) >= 1) { 
            //      array_push($errors, "The contact number is already taken");
             // }
            if (empty($pin)) {
              array_push($errors, "Pin number is required");
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

            if (count($errors) == 0) {

             if($_SESSION['fname']!=$fname || $_SESSION['lname'] != $lname || $_SESSION['gender']!= $gender || $_SESSION['contact']!=$contact || $pin != $_SESSION['pin'] || $_SESSION['street']!= $street || $_SESSION['city']!=$city || $_SESSION['state']!= $state)
             {
              $date=date("Y-m-d H:i:s");
              $sqlCheck="SELECT verified_doc FROM teacher_verified";
              $check=mysqli_fetch_row(mysql_query($db,$sql));
              $check=$check[0];
              if($check==1)
              {
              $sql="DELETE from teacher_kyc WHERE teacher_id = '$email'";
              mysqli_query($db, $sql);
              $sql="DELETE from admin_kyc WHERE teacher_id = '$email'";
              mysqli_query($db, $sql);
              $sql="UPDATE teacher_verified SET verified_doc = '0' WHERE email = '$email'";
              mysqli_query($db, $sql);
              $sql="INSERT INTO teacher_inbox VALUES ('$email','Document for Verification Tick Rejected due to recent profile update','admin','$date')";
              mysqli_query($db, $sql);
              }
             } 

            $sql = "UPDATE teacher_data SET fname='$fname', lname='$lname', gender='$gender',contact='$contact', street = '$street',house='$house',landmark='$landmark',city='$city',state='$state',pin='$pin' WHERE email='$email'";
            mysqli_query($db, $sql);
            }
      }
      teacher_navbar();
      $email= $_SESSION['email'];
      //echo $email;
      $query = "SELECT teacher_data.*,teacher_image.* FROM teacher_data LEFT outer JOIN teacher_image ON teacher_data.email = teacher_image.email WHERE teacher_data.email='$email' ORDER BY teacher_image.id DESC";
      $result = mysqli_query($db, $query);
      if (mysqli_num_rows($result) >= 1) {
      // log user in
      while ($row = mysqli_fetch_row($result)) {
        $_SESSION['fname']=$fname = $row[1];
        $_SESSION['lname']=$lname = $row[2];
        $_SESSION['gender']=$gender = $row[3];
        $_SESSION['contact']=$contact=$row[4];
        $_SESSION['street']=$street=$row[5];
        $house=$row[6];
        $landmark=$row[7];
        $_SESSION['city']=$city=$row[8];
        $_SESSION['state']=$state=$row[9];
        $_SESSION['pin']=$pin=$row[10];
          if($row[20]!=NULL)
          {
          $src=$row[20];
          }
          else
          {
          $src="avatar.png";
          }
          break;//need first value
        }
    }
    //echo $fname;
  }
      else if($_SESSION['usrtype']=='student')
      {
        if(isset($_POST['submit_stu']))
        {
        $fname = ($_POST['fname']);
        $lname = ($_POST['lname']);
        $gender = ($_POST['gender']);
        $email = ($_SESSION['email']);
        $city = $_POST['city'];
        $state= $_POST['state'];
  // ensure that form fields are filled properly
  if (empty($fname)) {
    array_push($errors, "First Name is required");
  }
  if (empty($lname)) {
    array_push($errors, "Last Name is required");
  }
  if (empty($gender)) {
    array_push($errors, "Gender is required");
  }
  // Mobile number check
  //if (mysqli_num_rows($result_2) >= 1) { 
    //    array_push($errors, "The contact number is already taken");
    //}

   if (empty($city)) {
    array_push($errors, "City is required");
  }
   if (empty($state)) {
        array_push($errors, "State is required");
    }
    
        if (count($errors) == 0) {
        $sql = "UPDATE student_data SET fname='$fname', lname='$lname', gender='$gender',city='$city',state='$state' WHERE email='$email'";
        mysqli_query($db, $sql);
        }
      }
      student_navbar();
      $email= $_SESSION['email'];
      //echo $email;
      $query = "SELECT student_data.*,student_image.* FROM student_data LEFT outer JOIN student_image ON student_data.email = student_image.email WHERE student_data.email='$email' ORDER BY student_image.id DESC";
      $result = mysqli_query($db, $query);
      if (mysqli_num_rows($result) >= 1) {
      // log user in
      while ($row = mysqli_fetch_row($result)) {
        $fname = $row[1];
        $lname = $row[2];
        $gender = $row[3];
        $city=$row[4];
        $state=$row[5];
          if($row[10]!=NULL)
          {
          $src=$row[10];
          }
          else
          {
          $src="avatar.png";
          }
          break;//need first value
        }
    }
    }
}
  else{

    default_navbar();
  }

?>
  <br><h4 class="msg cg">EDIT PROFILE</h4><br>
 
  <div class="container">
    <div class="row">
      <div class="col">
        <?php
          if(count($errors)>0)
          {
            echo '<div class="alert alert-danger" role="alert">UPDATE Failed!</div>';
          }
          else if(isset($_POST['submit_stu'])||isset($_POST['submit_tea']))
          {
            if(count($errors)==0)
            {
            echo '<div class="alert alert-dark" role="alert">Information Updated</div>';
            }
          }
        ?>
      </div>
    </div>
    <div class="row">

        <div class="col-lg-3"></div>

        <div class="col-lg-6">
          <div id="ui">
            <form method="post" action="profile_pic.php" enctype="multipart/form-data" class="text-light">
              <input type="file" name="profile_pic">
              <img src="<?php echo $src; ?>" height="128px" width="128" style="">
              <input type="submit" name="submit" value="Change Profile Picture" class="btn btn-outline-success btn-sm">
            </form>
            <br>
            <?php
            if((isset($_SESSION['success'])&& $_SESSION['usrtype']==='teacher')) 
            {
            teacher_edit_form($_SESSION['email']);
            }
            else if((isset($_SESSION['success'])&& $_SESSION['usrtype']==='student')) 
            {
            student_edit_form($_SESSION['email']);
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
  <?php
  if($_SESSION['usrtype']=='teacher')
  {
  echo '<script src="js/auth_edit_tea.js"></script>';
  }
  else if($_SESSION['usrtype']=='student')
  {
  echo '<script src="js/auth_edit_stu.js"></script>';
  }
  ?>
</body>  
</html>
