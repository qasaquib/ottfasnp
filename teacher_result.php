<?php 
$type;
require_once('server.php');
session_start();
if(isset($_SESSION['usrtype']))
{
  if($_SESSION['usrtype']!='student')
  {
   header('location:home.php');
   exit();
  }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Find Your Teacher Online Or Offline</title>
	<link rel="stylesheet" type="text/css" href="css/teach.css">
  <link rel="stylesheet" type="text/css" href="css/footstyle.css">
  <link rel="stylesheet" type="text/css" href="css/navstyle.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://kit.fontawesome.com/48e4b8916e.js"></script>
</head>
<body class="bg-dark">
   <?php require 'navbar.php';
      $chk=isset($_SESSION['usrtype']);
      if ($chk){
      if($_SESSION['usrtype']=='teacher')
      teacher_navbar();
      else if($_SESSION['usrtype']=='student')
      student_navbar();
      }
      else{
        default_navbar();
      }
  ?>
    <div class="container-fluid" id="id10">
     <div class="row">
      <div class="col-sm-3 search-panel" style="">
      <div style="">
        <form action="teacher_result.php" method="get" class="form-group">
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
        <p style="font-size:30px; font-style: bold;" class="ml-2 text-success" id="myRangeDisp"><?php if(isset($_GET['fees'])){echo "₹".$_GET['fees'];}else{echo "Rs. 2000";}?></p>
         </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="off_only" name="off_only" value="1" <?php if(isset($_GET['off_only'])){if($_GET['off_only']=="1") {echo "checked";}}?>>
        <label class="form-check-label" for="off_only">Only Show Teachers Available Offline</label>
    </div>
        <input class="btn btn-secondary btn-block m-2" type="submit" name="sub_find" value="Search">
    </form>
  </div>
</div>
<div class="col-sm-9 results">
	<!--Results Here-->
	<?php 
  if (isset($_GET['sub_find']))
  {
	 $server = "localhost";
	 $user = "root";
	 $pw = "";
	 $db="teacher_finder";
	 $conn=mysqli_connect($server,$user,$pw,$db);
	 if(mysqli_connect_errno())
	 {
	 	printf("Connect failed: %s\n", mysqli_connect_error());
	 }
	 else
	 	{
	 		$standard=$_GET['standard'];$city=$_GET['city'];$subject=$_GET['subject'];
      //$rating=$_GET['rating'];
	 		$fees=$_GET['fees'];
	 		$query="select * from teacher_data where fees <=".$fees." AND searchable = '1'";
	try {
	 		if ($standard === "*" && $city === "*" && $subject === "*")
	 		{
	 		$query="select * from teacher_data where fees <=".$fees." AND searchable = '1'";
	 	    }
	 	    else
	 	    {

	 	    	if($city!=="*"){
	 	    		$query=$query." and city = '".$city."'";
          }
	 	    	if($subject!=="*"){
	 	    		$query=$query." AND email IN (SELECT teacher_id as email FROM teacher_subjects WHERE sub_name ='"."$subject"."')";
          }
          if($standard!=="*"){
            $query=$query." AND email IN (SELECT teacher_id as email FROM teacher_standards WHERE standard ='"."$standard"."')";
          }
	 	    }
        if(isset($_GET['off_only']))
        {
          if($_GET['off_only']=="1")
          {
            $query=$query." AND accept <> '0'";
          }
        }
	 	    if($query=="")
	 	    {
	 	    	throw new Exception("Query Not Resolved");
	 	    }
	 	    //echo $query."\n";
	 		//$stmt = mysqli_prepare($conn, $query);
	 		//echo $abc;
	 		//mysqli_stmt_bind_param($stmt, "sss", $val1, $val2, $val3);
	 		//mysqli_stmt_execute($stmt);
	 			if ($result = mysqli_query($conn, $query)) {
    				while ($row = mysqli_fetch_row($result)) {
            $emailq=$row[0];
            $imgsql = "SELECT * FROM teacher_image where email like '".$emailq."' ORDER BY id DESC";
            $imgresult=mysqli_query($conn, $imgsql);
            if (mysqli_num_rows($imgresult) === 0)
            $src="avatar.png";
            else
            { while ($imgrow = mysqli_fetch_row($imgresult)) {
               $src=$imgrow[3];
               break;
              }  
            }
              echo ('<a href="teacher_profile.php?disp_teach_id='.encodeMail('teacher',$row[0]).'">');
    					echo ('<div class="res-box" id="">');
    					echo '<img class="res-pic" src="'.$src.'" alt="avatar.png" align="">';
    					echo ('<h6 class="teach-name"> Name : '.$row[1]." ".$row[2]."</h6><br/>");
    					echo ('<h6> City : '.$row[8]."</h6>");
              echo ('<h6> State : '.$row[9]."</h6>");
              echo ('<h6> Fees (Offline) : ₹'.$row[12]."</h6>");
              if($row[14])
              {
              echo ('<p> Accepting Offline Students</p>');// place holders
              }
              else
              {
               echo ('<p> Not Accepting Offline Students '.'</p>');
              }
    					//echo ('<h7 class="teach-addr"> Address : '.$row[6]." ".$row[5]." ".$row[7].'</h7>');
    					//echo ('<h6 class="teach-dat"> Subject : '.$row[11].'<br/>Standard : '.$row[12].'</h6>');
    					//echo ('<h6 class="teach-rating"> Rating : '.$row[13].'</h6/>');// place holders
    					echo ('</div>');
              echo ('</a>');
				}	 
			}
			mysqli_free_result($result);
		}
	catch(Exception $e) {
			     echo "Message: " . $e->getMessage();
    			 echo "";
   			}

    /* free result set */
}
}
else
{
  echo '<div class="alert alert-dark" role="alert">Adjust Categories to find teachers!</div>';
}
	?>

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
          videoId: 'H1elmMBnykA',
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
