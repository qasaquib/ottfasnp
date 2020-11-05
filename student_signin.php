<?php 

include ('student_server.php');
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


//echo $_POST['email']; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://kit.fontawesome.com/48e4b8916e.js"></script>
  <script src="js/valLogin.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">  
  <title>𝓣𝓮𝓪𝓬𝓱𝓮𝓻𝓕𝓲𝓷𝓭𝓮𝓻</title>
</head>

<body class="bg-black">
   
   <br><a href="home.php" class="lbrand"><h1 class="msg cw">𝓣𝓮𝓪𝓬𝓱𝓮𝓻𝓕𝓲𝓷𝓭𝓮𝓻</h1></a><br>
  <br><h4 class="msg cg">STUDENTS' SIGN IN</h4><br>
 
  <div class="container">

    <div class="row">

        <div class="col-lg-3"></div>

        <div class="col-lg-6">
          <div id="ui">

            <form class="form-group" method="post" onsubmit="return valField()">
                  <?php include('student_errors.php'); ?>

                  <label class="cw">Email Id</label>
                  <span class='cy'></span>
                  <input type="text" name="email" class="form-control" placeholder="Enter your email id" required>

                  <label class="cw">Password</label>
                  <span class='cy'></span>
                  <input type="Password" name="password" class="form-control" placeholder="Type your password" required>
                <!--  <label class="radio-inline cw"><input type="radio" name="usrtype" value="student" checked required>Student</label>
                  <label class="radio-inline cw"><input type="radio" name="usrtype" value="teacher" required>Teacher</label>-->
                  
              <br><button type="submit" name="login" class="btn btn-outline-success btn-block btn-lg">SUBMIT</button>

              <p class="cw">
                  Not a student member yet? <a class="cg lbrand" href="student_signup.php">Sign up here!</a><br/>
              </p>

              <p class="cw">
                  Are you a teacher? <a class="cg lbrand" href="teacher_signin.php">Sign In Here!</a>
              </p>

            </form>
            
          </div>
        </div>

        <div class="col-lg-3"></div>
    </div>
  </div>

</body>  
</html>
