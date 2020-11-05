<?php
session_start(); 
include ('server.php');
$studentEmail;
if(!isset($_SESSION['usrtype']))
{
  $studentEmail="";
}
else if($_SESSION['usrtype']!="student")
{
  $studentEmail="";
}
else
{
  $studentEmail=$_SESSION['email'];
  //echo "We are here".$studentEmail;
}
$name="";
?>
<!DOCTYPE html>
<html>
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" charset="utf-8">
	  <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link rel="stylesheet" type="text/css" href="css/footstyle.css">
    <link rel="stylesheet" type="text/css" href="css/navstyle.css">
    <link rel="stylesheet" type="text/css" href="css/restext.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
 <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/48e4b8916e.js"></script>

    <title>Teacher Finder :𝓣𝓮𝓪𝓬𝓱𝓮𝓻𝓕𝓲𝓷𝓭𝓮𝓻 : Find Your Teacher Online Or Offline</title>
</head>
<body class="bg-black">
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

<?php
  if (isset($_GET['disp_teach_id']))
  {
   $_GET['disp_teach_id']=decodeMail('teacher',$_GET['disp_teach_id']);
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
    	$email=$_GET['disp_teach_id'];
    	$sql = "SELECT * FROM teacher_image where email like '".$email."'";
		$result=mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) === 0)
			$src="avatar.png";
		else
		{	while ($row = mysqli_fetch_row($result)) {
			    $src=$row[3];
				}	 
		}
      $subjects="";
      $off_students;
      $slots;
      $fees;
      $accept;
      $presentDate=date("Y-m-d H:i:s");
      $startDate="";
      $endDate="";
      $query="select * from teacher_data where `email` like \"".$_GET['disp_teach_id']."\"";
      $query2="select * from subscriptions where `teacher_id` like '".$_GET['disp_teach_id']."' and `student_id` like '".$studentEmail."' AND end_date >= '$presentDate'";
      $query3="select * from subscriptions where `teacher_id` like '".$_GET['disp_teach_id']."' AND end_date > '$presentDate'";
      $tot_subs=mysqli_num_rows(mysqli_query($conn,$query3));
      $result2=mysqli_query($conn,$query2);
      //print_r($result2);
      //echo $query2;
      if(mysqli_num_rows($result2))
      {
        $subStatus='Subscribed';
        $temp=mysqli_fetch_assoc($result2);
        $startDate=date_create(date("Y-m-d H:i:s"));
        $endDate=date_create($temp['end_date']);
        $dateDiff=date_diff($startDate,$endDate);
        if($dateDiff==NULL)
          die("An Error Has Occured");
        $dateDiffVal=(int)$dateDiff->format("%R%a");
        $dateDiff=$dateDiff->format("%a Days %H Hours Left");
      }
      else
      {
        $subStatus="Subscribe";
        //echo $query."\n";
      }
      //$stmt = mysqli_prepare($conn, $query);
      //echo $abc;
      //mysqli_stmt_bind_param($stmt, "sss", $val1, $val2, $val3);
      //mysqli_stmt_execute($stmt);
        if ($result = mysqli_query($conn, $query)) {
          $_SESSION['disp_teach_id']=$_GET['disp_teach_id'];
            while ($row = mysqli_fetch_array($result)) {
       $off_students=$row['off_students'];
      $slots=$row['slots'];
      $accept=$row['accept'];
      $fees=$row['fees'];
              echo ('<div class="container-fluid" id="">
                    <div class="row">');
              echo '<div class="col-8">';
              $name=$row[1]." ".$row[2];
              echo ('<h4 class="teach-name">'.$row[1]."&nbsp".$row[2]."<h4/><br/>");
              echo ('<h5 class="teach-city">'.$row[8]."</h5><br/>");
              echo ('<h6> Fees : ₹ '.$row[12]."</h6><br/>");
              //echo ('<h6 class="teach-addr"> Address : '.$row[6]." ".$row[5]." ".$row[7].'</h6>');

              if((int)$accept>0)
              {
              $sqlChk="SELECT * FROM teacher_offline WHERE teacher_id = '$email' and student_id = '$studentEmail'";
              if(mysqli_num_rows(mysqli_query($conn,$sqlChk)))
              {
              echo ('<button type="button" class="btn btn-info mb-2 btn-right" id="offline-btn">'."Requested Offline Study".'</button>');
              }
              else
              {
              echo ('<button type="button" class="btn btn-info mb-2 btn-right" id="offline-btn">'."Request To Study Offline".'</button>');
              }
              echo '<div class="form-group">';
              echo '<label for="subject">Subject For Offline Study:</label>';
              echo ('<select name="subject" id="subject" class="form-control">');
              $subjects=getTeacherSubjects($email);
              echo ('<option>Multiple (Elaborate During Discussion)</option>');
              echo('</select>');
             //echo($off_students." ".$accept."  ".$slots);
              echo "<h5>($off_students / $slots) Students Studying Offline</h5>";
              echo '</div>';
              }
              else
              {
              echo ('<button type="button" class="btn btn-info mb-2 btn-right" id="offline-btn" disabled>'."Request To Study Offline".'</button>');
              //echo($off_students." ".$accept."  ".$slots);
              echo "<h6>Teacher is not currently accepting requests for offline teaching</h6>";
              }
              //echo ('<h6 class="teach-sub"> Subject : '.$row[11].'</h6><br/><h6 class="teach-sta">Standard : '.$row[12].'</h6>');
              //echo ('<h6 class="teach-rat"> Rating : '.$row[13].'</h6>');// place holders
              echo '</div>';
              echo ('<div class="col-4"><img class="res-pic m-2" src="'.$src.'" alt="avatar.png" align="">');
              echo ('<button type="button" class="btn btn-info mb-2 btn-right" id="sub-btn">'.$subStatus.'</button>');
              echo ('</div>');
              echo ('</div>');
        }

        $query="SELECT COUNT(*) from `teacher_course` where teacher_id like '".$email."'";
        $result=mysqli_fetch_row(mysqli_query($conn,$query));
        echo('<div class="row">');
        echo('<div class="col-8">');
        echo ('<h6 class="teach-rat text-info">'.$result[0].' Courses Published </h6>');
        echo ('<h6 class="teach-rat text-info">'.$tot_subs.' Subscribers </h6>');
        if($subjects!=false)
        {
          echo ('<h6 class="teach-rat text-info">'.sizeof($subjects).' Subjects Taught </h6>');
        }
        else
        {
          echo ('<h6 class="teach-rat text-info">No Subjects Added</h6>');
        }
        echo('</div>');
        echo('<div class="col-4">');
              if($subStatus==="Subscribe")
              {
              echo ('<h6 class="teach-rat">Subscribe to Gain Access to Courses</h6>');
              }
              else
              {
              echo('You have already subscribed! Go to explore courses to browse the courses provided by your teacher!');
              echo '<br/>';
              echo($dateDiff);
              }
              $sqlVer="SELECT * FROM admin_kyc WHERE teacher_id = '$email' and status = 'VERIFIED'";
              if(mysqli_num_rows(mysqli_query($conn,$sqlVer))>0)
              {
                echo '<div class="">';
                  echo '<i class="fa fa-check-circle" aria-hidden="true">Teacher Finder Verified</i>';
                echo '</div>';
              }
        echo('</div>');
        echo('</div>');
        echo ('</div>');


      }
      //mysqli_free_result($result);
    }

    /* free result set */
}
?>

<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2>Register Now to Get Access to Content from <?php echo $name;?></h2>
      <span class="close-btn">&times;</span>
    </div>
    <div class="modal-body">
      <h4><a href="student_signup.php">Click Here To Register!</a></h4>
    </div>
    <div class="modal-footer">
      <h3>Many other teachers also await you.</h3>
    </div>
  </div>
</div>


<script type="text/javascript" src="js/profile.js"></script>
</body>
</html>