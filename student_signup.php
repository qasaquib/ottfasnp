<?php 
   require_once ('student_server.php');
   require_once ('server.php');
   if(isset($_SESSION['usrtype']))
   {
   if((isset($_SESSION['success'])&& $_SESSION['usrtype']==='teacher')) 
    {
      header('location: after_teacher_login.php');
    }
    if((isset($_SESSION['success'])&& $_SESSION['usrtype']==='student')) 
    {
      header('location: after_student_login.php');
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
  <script src="js/auth_stu.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>𝓣𝓮𝓪𝓬𝓱𝓮𝓻𝓕𝓲𝓷𝓭𝓮𝓻</title>
</head>


<body class="bg-black">
   
   <br><a href="home.php" class="lbrand"><h1 class="msg cw">𝓣𝓮𝓪𝓬𝓱𝓮𝓻𝓕𝓲𝓷𝓭𝓮𝓻</h1></a><br>
  <br><h4 class="msg cg">Sign up to find the teachers you like best!</h4><br>
 
  <div class="container">

    <div class="row">

        <div class="col-lg-3"></div>

        <div class="col-lg-6">
          <div id="ui">

            <form class="form-group" method="post" action="student_signup.php" onsubmit="return valInputs()">
              <?php include('student_errors.php');
               ?>
               <label class="cw">First Name</label>
               <span class='cy'></span>
              <input type="text" name="fname" class="form-control" placeholder="Enter your name" value="<?php echo $fname; ?>" required>
              <label class="cw">Last Name</label>
              <span class='cy'></span>
              <input type="text" name="lname" class="form-control" placeholder="Enter your name" value="<?php echo $lname; ?>" required>
              <label class="cw">Gender</label>
              <span class='cy'></span>
              <select class="form-control" name="gender" value="<?php echo $gender; ?>" required>
                <option>Choose Gender</option>
                <option>Male</option>
                <option>Female</option>
                <option>Others</option>
              </select>
              <label class="cw">City</label>
              <span class='cy'></span>
              <select name="city" id="cityS" class="form-control custom-select sel" required="">
              <option value="">Select City</option>
                  <?php
                   $_SESSION['cities']=popCity();
                  ?>
              </select>
              <label class="cw">State</label>
              <span class='cy'></span>
              <select name="state" id="stateS" class="form-control custom-select sel" required="">
              <option value="">Select State</option>
                  <?php
                  $_SESSION['states']=popState();
                  ?>
              </select>
              <label class="cw">E-mail&nbsp</label>
              <span id="emailval"class='cy'></span>
              <input type="text" name="email" class="form-control" placeholder="Enter your e-mail id" value="<?php echo $email; ?>" required onfocusout="checkStr('email','emailval')">
                  <label class="cw">Password</label>
                  <span class='cy'></span>
                  <input type="Password" name="password_1" class="form-control" placeholder="Type your password" required>
                  <label class="cw">Re-enter password</label>
                  <input type="Password" name="password_2" class="form-control" placeholder="Type your password" required>         
              <br><button type="submit" name="submit_stu" class="btn btn-outline-success btn-block btn-lg" onclick="valInputs()">SUBMIT</button>
              <p class="cw">
                  Already a student member? <a class="cg lbrand" href="student_signin.php">Sign in</a>
                  </p>
              <p class="cw">
                  Are you a teacher? <a class="cg lbrand" href="teacher_signup.php"> Sign Up Here!</a>
              </p>
            </form>
          </div>
        </div>
        <div class="col-lg-3"></div>
    </div>
  </div>
</body>  
</html>
