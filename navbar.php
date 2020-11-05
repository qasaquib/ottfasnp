<?php
function default_navbar()
{
echo <<<EOT
  <!--navbar code starts here-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <label class="navbar-brand" href="#">𝓣𝓮𝓪𝓬𝓱𝓮𝓻𝓕𝓲𝓷𝓭𝓮𝓻</label>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapse_target" >
    <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="collapse_target">
      <ul class="navbar-nav ml-auto">

        <li class="nav-item">
          <a class="nav-link" href="home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#footer">About Us</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Teacher</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="teacher_signin.php">Sign In</a>
              <a class="dropdown-item" href="teacher_signup.php">Sign Up</a>
            </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Student
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="student_signin.php">Sign In</a>
          <a class="dropdown-item" href="student_signup.php">Sign Up</a>
          
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <!-- navbar codes end here-->
EOT;
}


function teacher_navbar()
{
echo <<<EOT
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <label class="navbar-brand" href="#">𝓣𝓮𝓪𝓬𝓱𝓮𝓻𝓕𝓲𝓷𝓭𝓮𝓻</label>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapse_target" aria-controls="collapse_target" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="collapse_target">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="after_teacher_login.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#footer">About Us</a>
        </li>
      </ul>
       <ul class="navbar-nav ml-auto mr-6">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-cog" aria-hidden="true"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">          
EOT;
          echo '<a class="dropdown-item" href="edit_profile.php">Edit Profile</a>';
          //echo '<a class="dropdown-item" href="after_teacher_login.php">Dashboard</a>';

echo<<<EOT
          <a class="dropdown-item" href="teacher_setup.php">Teacher Information</a>
          <a class="dropdown-item" href="change_password.php">Security and Login</a>         
          </div>
        </li>
         <form class="form-inline ml-2 mr-2" method="get">
                <button class="btn btn-xs my-2 my-sm-0 btn-danger" type="submit" name="logout"><i class="fa fa-sign-out" aria-hidden="true"></i>
</button>
        </form>
      </ul>
    </div>
  </nav>
EOT;
}

function student_navbar()
{
echo<<<EOT
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <label class="navbar-brand" href="#">𝓣𝓮𝓪𝓬𝓱𝓮𝓻𝓕𝓲𝓷𝓭𝓮𝓻</label>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapse_target" aria-controls="collapse_target" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="collapse_target">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="after_student_login.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#footer">About Us</a>
        </li>
      </ul>
       <ul class="navbar-nav ml-auto mr-6">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-cog" aria-hidden="true"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="edit_profile.php">Edit Profile</a>
          <a class="dropdown-item" href="change_password.php">Security</a>
          
          </div>
        </li>
         <form class="form-inline ml-2 mr-2" method="get">
                <button class="btn btn-xs my-2 my-sm-0 btn-danger" type="submit" name="logout"><i class="fa fa-sign-out" aria-hidden="true"></i>
</button>
        </form>
      </ul>
    </div>
  </nav>
EOT;

}

?>