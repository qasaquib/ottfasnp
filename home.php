<!DOCTYPE html>
<?php
include 'server.php';
session_start();
if(isset($_SESSION['usrtype']))
{
  if($_SESSION['usrtype']=="admin")
  {
    header("location:admin.php");
  }
  else if($_SESSION['usrtype']=="teacher")
  {
    header("location:after_teacher_login.php");
  }
  else if($_SESSION['usrtype']=="student")
  {
    header("location:after_student_login.php");
  }
}
?>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/navstyle.css">
    <link rel="stylesheet" type="text/css" href="css/homestyle.css">
    <link rel="stylesheet" type="text/css" href="css/footstyle.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://kit.fontawesome.com/48e4b8916e.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <title>Find Your Teacher Online Or Offline</title>
  </head>

<body>
  <?php
  ?>

  <!--navbar code starts here-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" >
          <a class="dropdown-item" href="student_signin.php">Sign In</a>
          <a class="dropdown-item" href="student_signup.php">Sign Up</a>
          
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <!-- navbar codes end here-->

    <div class="carousel slide" data-ride="carousel" data-interval="3000" id="dip">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/1.jpg" class="w-100">
        <div class="carousel-caption">
          <h3>Supratim Ghosh</h3>
          <p>Developer</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="images/2.jpg" class="w-100">
      </div>
      <div class="carousel-item">
        <img src="images/3.jpg" class="w-100">
      </div>
    </div>
    <a href="#dip"class="carousel-control-next" data-slide="next">
      <span class="carousel-control-next-icon"></span>
    </a>
    <a href="#dip"class="carousel-control-prev" data-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </a>
    <ul class="carousel-indicators">
      <li data-target="#dip" data-slide-to="0" class="active"></li>
      <li data-target="#dip" data-slide-to="1"></li>
      <li data-target="#dip" data-slide-to="2"></li>
    </ul>
  </div>

    <div class="container-fluid" id="id10">
     <div class="row">
      <div class="col-sm-4 search-panel">
          <form action="teacher_result.php" method="get" style="">
          <span class="mb-3">Change Search Parameters</span>
            <h1><span class="mb-3">Search Teachers By Category</span></h1>
            <div class="input-group input-group-sm mb-3"><label for="cityS">&nbspCity&nbsp</label>
          <select name="city" id="cityS" class="custom-select sel">
            <option value="*">--All Cities--</option>
            <?php
            if(isset($_GET['city']))
              $GLOBALS['type']=$_GET['city'];
            popCity();
            ?>
            </select>
        </div>
        <div class="input-group input-group-sm mb-3"><label for="cityS">&nbspState&nbsp</label>
          <select name="state" id="stateS" class="custom-select sel">
            <option value="*">--All States--</option>
            <?php
              if(isset($_GET['state']))
              $GLOBALS['type']=$_GET['state'];
            popState();
            ?>
            </select>
        </div>
            <div class="input-group input-group-sm mb-3">
            <label for="subjectS">&nbspSubject&nbsp</label>
        <select name="subject" id="subjectS" class="custom-select sel">
          <option value="*">--All Subjects--</option>
            <?php
            if(isset($_GET['subject']))
              $GLOBALS['type']=$_GET['subject'];
            popSubject();
                ?>
           </select>
         </div>
         <div class="input-group input-group-sm mb-3"><label for="standardS">&nbspStandard&nbsp</label>
          <select name="standard" id="standardS" class="custom-select sel">
          <option value="*">--All Standards--</option>
            <?php
            $GLOBALS['type']=$_GET['standard'];
            popStandard();
                ?>
           </select>
       </div>
  <div class="offline-fees-slider">
          <label>&nbspOffline&nbspFees&nbsp</label>
      <input type="range" name="fees" min="0" max="10000"  class="slider" id="myRange" <?php if(isset($_GET['fees'])){echo "value=".$_GET['fees'];}else{echo "value=2000";}?>>
        <p style="font-size:30px; font-style: bold;" class="ml-2 text-success" id="myRangeDisp"><?php if(isset($_GET['fees'])){echo "₹".$_GET['fees'];}else{echo "₹2000";}?></p>
         </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="off_only" name="off_only">
        <label class="form-check-label" for="off_only">Only Show Teachers Available Offline</label>
    </div>
        <input class="btn btn-secondary btn-block m-2" type="submit" name="sub_find" value="Search">
    </form>
         </div>
      <div id="id001" class="col-sm-8 embed-responsive embed-responsive-16by9">
           <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
      <div id="player"></div>
     </div>

       <script id=YTAPILOADER>
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '360',
          width: '480',
          videoId: '<?php echo(getVideoId());?>',
          events: {
            'onReady': onPlayerReady
          }
        });
      }
           // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo();
        //window.alert('Hello');
      }

      function getRangeValue(){
        var x = document.getElementById("myRange").value;
      	document.getElementById("myRangeDisp").innerHTML="₹"+x;

      }
    document.getElementById("myRange").addEventListener("mouseover", getRangeValue);
	document.getElementById("myRange").addEventListener("click", getRangeValue);
	document.getElementById("myRange").addEventListener("mouseout", getRangeValue); 



      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
    </script>
  </div>
</div>
<footer id="footer">
  <div class="footer-top">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-6  footer-info">
        <h3>Teacher Finder</h3>
        <p></p>
      </div>
     
      <div class="col-lg-3 col-md-6 footer-contact">
        <h4>Contact us</h4>
        <p>
          Supratim Ghosh<br>Quazi Ahmed Saquib<br>
          
          <strong>Phone: </strong>+91 7550853867<br>
          <strong>Email: </strong>teacherfinder@gmail.com<br>  
        </p>
        <div class="social-links">
          <a href="https://twitter.com/dipsupratim"><i class="fab fa-twitter"> </i></a>
          <a href="https://www.facebook.com/supratim.ghosh.104855"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.instagram.com/supratim0000/"><i class="fab fa-instagram"></i></a>
          <a href="https://www.linkedin.com/in/supratim-ghosh-a75566159/"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 footer-newsletter">
        <h4>Get all updates</h4>
        <p></p>
        <form action="subscribe.php" method="post">
          <input type="email" name="email" placeholder="email id"><input type="submit" value="SUBSCRIBE">
        </form>
      </div>
    </div>
  </div>
</div>
</footer>
  </body>
</html>