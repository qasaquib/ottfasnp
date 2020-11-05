<?php
session_start();
include ('server.php');
if(isset($_SESSION['usrtype']))
{
  if($_SESSION['usrtype']!='teacher')
  {
   header('location:home.php');
   exit();
  }
}
else
{
   header('location:home.php');
   exit();
}
    //echo $_SESSION['success'];
    //echo $_SESSION['usrtype'];
    //echo $_SESSION['email'];
    $teach_subArr=array();
    $teach_stanArr=array();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Teacher Finder :𝓣𝓮𝓪𝓬𝓱𝓮𝓻𝓕𝓲𝓷𝓭𝓮𝓻 : Find Your Teacher Online Or Offline</title>
	
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css/tea_setup.css">
    <link rel="stylesheet" type="text/css" href="css/footstyle.css">
    <link rel="stylesheet" type="text/css" href="css/navstyle.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/48e4b8916e.js"></script>
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
  <!-- rest body-->
	<div class="container-fluid">
    <div class="row mt-2">
      <div class="col-sm-2">
      </div>
      <div class="col-sm-8">
          <?php
           if(isset($_SESSION['msg']))
           {
            echo '<div class="alert alert-warning" role="alert">';
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
            echo '</div>';
           } 
          ?>
      </div>
      <div class="col-sm-2">
      </div>
    </div>
        <div class="row">
          <div class="col-sm notif-panel">
            <?php
            $numSub=$numStan=0;
            if((int)$_SESSION['searchable']==0)
            {
            echo '<a href="teacher_setup.php"><div class="alert alert-warning no-search-warn" role="alert">The following reasons are restricting searching your profile </div></a>'; 
            }
            $email = $_SESSION['email'];
            $preres=0;
            $sql="SELECT * FROM teacher_subjects where teacher_id = '$email'";
            $subResult=mysqli_query($conn,$sql);
            $_SESSION['numSub']=$numSub=mysqli_num_rows($subResult); 
            if($numSub < 1)
            {
             echo '<div class="alert alert-danger" id="zero-res-sub" role="alert">Add the subjects that you teach!</div>'; 
            }
            $sql="SELECT * FROM teacher_standards where teacher_id = '$email'";
            $stanResult=mysqli_query($conn,$sql);
            $_SESSION['numStan']=$numStan=mysqli_num_rows($stanResult);
            if($numStan<1)
            {
              echo '<div class="alert alert-danger" id="zero-res-stan" role="alert">Add your prospective standards that you will be  teaching!</div>'; 
            }
            $sql="SELECT verified_mail FROM teacher_verified where email = '$email'";
            $verResult=mysqli_query($conn,$sql);
            $row=mysqli_fetch_row($verResult);
            if((int)$row[0]<1)
            {
              echo '<div class="alert alert-danger" id="zero-res-stan" role="alert">Your email is not verified please check your inbox of registered email address</div>'; 
            }

            ?>
          </div>
      </div>
		<div class="row m-2" id="sub-box">
      <div class="col-sm-9">
        <div id="sub-disp">
          <h4 class="text-success">Subjects : </h4>
          <?php
          if($numSub<1)
          {
             echo '<div class="alert alert-info text-center"  id="zero-res-subs" role="alert">Nothing Here</div>';
          }
            else
            {
              while($row=mysqli_fetch_assoc($subResult))
              {
                echo '<div id="close-'.$row['id'].'-sub-cont" class="bubble-cont"><p class="data-bubble">'.$row['sub_name'].'</p><p class="data-bubble closer closer-sub" id="close-'.$row['id'].'">&times</p></div>';
                array_push($teach_subArr,$row['id']);
              }
            }
          ?>
        </div>
      </div>
      <div class="col-sm-3">
                <?php
                   $subject_arr=getSubject();
                   $subject_json=json_encode($subject_arr);
                  ?>
              <label class="text-info">Add Subjects</label>
              <span class="text-warning"></span>
              <div class="btn-toolbar">
              <div class="autocomplete input-group">
              <input class="form-control mt-1" type="text" name="subjectS" id="subInp" class="form-control" placeholder="Enter Subject">
            </div>
            <div class="btn-group-sm pt-2 ml-1">
              <button id="sub-btn" type="button" class="btn btn-info btn-sm">Add</button>
            </div>
            </div>
      </div>
		</div>
		<div class="row m-2" id="stan-box">
      <div class="col-sm-9">
        <div id="stan-disp">
          <h4 class="text-success">Standards : </h4>
          <?php
          if($numStan<1)
          {
             echo '<div class="alert alert-info text-center"  id="zero-res-stans" role="alert">Nothing Here</div>';
          }
            else
            {
              while($row=mysqli_fetch_assoc($stanResult))
              {
                echo '<div id="close-'.$row['id'].'-stan-cont" class="bubble-cont"><p class="data-bubble">'.$row['standard'].'</p><p class="data-bubble closer closer-stan" id="close-'.$row['id'].'">&times</p></div>';
                array_push($teach_stanArr,$row['id']);
              }
            }
          ?>
        </div>
      </div>
      <div class="col-sm-3">
              <label class="text-info">Add Standards</label>
              <span class="text-warning"></span>
              <div class="btn-toolbar">
              <div class="input-group">
              <select name="standard" id="standardS" class="form-control custom-select sel">
              <option value="">Select Standards</option>
                  <?php
                  $standard_arr=popStandard();
                  //$standard_json=json_encode($standard_arr);
                  ?>
              </select>
            </div>
              <div class="btn-group-sm pt-1 ml-1">
              <button id="stan-btn" type="button" class="btn btn-info btn-sm">Add</button>
            </div>
          </div>
      </div>

	  </div>
    <div class="row">
      <div class="col-sm-4">
        <?php
        $sql="SELECT * FROM teacher_data WHERE email = '$email'";
        $result=mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($result);
        $accept=$row['accept'];
        $slots=$row['slots'];
        $fees=$row['fees'];
        ?>
        <h4 class="text-info">Accepting Offline Batches</h4>
              <div class="input-group">
              <select name="offline-batch" id="offline-batch" class="form-control custom-select">
              <option value="1">Yes</option>
              <option value="0" <?php if(!$accept){echo 'selected';}?>>No</option>
              </select>
            </div>
        <h4 class="text-info">Number of Seats</h4>
              <div class="input-group">
              <input class="form-control mt-1" type="number" name="seats" id="seats" class="form-control" placeholder="Enter Number of Seats" value="<?php echo $slots; ?>" <?php if(!$accept){echo ' disabled';}?> min="1" max="120">
            </div>
            <div class="btn-group-xs">
              <button id="seats-btn" type="button" class="btn btn-xs btn-success" <?php if(!$accept){echo ' disabled';}?>>Save</button>
            </div>
      </div>
       <div class="col-sm-8 text-info" id="kyc-cont">
        <?php
        $sql="SELECT * FROM teacher_kyc WHERE teacher_id = '$email'";
        if(mysqli_num_rows(mysqli_query($conn,$sql)) == 0)
        {
          echo '
          <form action="assets.php" method="post" class="form-group" style="margin-top:20px" enctype="multipart/form-data">
          <input id="kyc" type="text" name="kyc" size="20" class="form-control" value="upload" hidden>
          <label for="docfile">Upload Document Proof Here:</label>
          <input id="docfile" type="file" name="docfile">
          <button type="submit" name="submit_doc" class="btn btn-block btn-outline-success mt-3">Upload Identity & Address Proof</button>
          </form>';
        }
        else
        {
          echo '<div class="p-2 bg-dark text-center clearfix">';
          echo '<span id="close-kyc" class="float-right">&times</span>';
          echo '<p class="text-success"><a href="doc_viewer.php?self=1">View Verification Document</a></p>';
          echo '</div>';
        }
        ?>
      </div>
    </div>
  </div>

<script src="js/tea_setup.js"></script>
<script type="text/javascript">


let subarr = <?php print_r($subject_json);?>; 
autocomplete(document.getElementById("subInp"), subarr);

$("#sub-btn").click(function(){
if($("#subInp").val() == "")
{
  window.alert("Subject Cannot be empty");
  return false;
}
else
{
  let val=$("#subInp").val();
  $.post("assets.php", { value : val, type: "subject" , setup : "1" ,action:"insert"}).done(function(data)
    {
    if(data == "Failed")
    {
      alert("Error Has Occured");
    }
    else
    {
      //alert(data);
      teach_subArr.push(data);
      $("#sub-disp").append('<div id="close-'+data+'-sub-cont" class="bubble-cont"><p class="data-bubble">'+val+'</p><p class="data-bubble closer closer-sub" id="close-'+data+'">&times</p></div>');
      if($("#zero-res-subs").length)
      {
        $("#zero-res-subs").remove();
      }
      if($("#zero-res-sub").length)
      {
        $("#zero-res-sub").remove();
      }

  }
});
}
});

$("#stan-btn").click(function(){
if($("#standardS").val() == "")
{
  window.alert("Please select standard");
  return false;
}
else
{
  let val=$("#standardS").val();
  $.post("assets.php", { value : val, type: "standard" , setup : "1" ,action:"insert"}).done(function(data)
    {
    if(data == "Failed")
    {
      alert("Error Has Occured");
    }
    else
    {
      //alert(data);
      teach_stanArr.push(data);
      $("#stan-disp").append('<div id="close-'+data+'-stan-cont" class="bubble-cont"><p class="data-bubble">'+val+'</p><p class="data-bubble closer closer-stan" id="close-'+data+'">&times</p></div>');
      if($("#zero-res-stans").length)
      {
        $("#zero-res-stans").remove();
      }
      if($("#zero-res-stan").length)
      {
        $("#zero-res-stan").remove();
      }

  }
});
}
});
teach_stanArr = <?php print_r(json_encode($teach_stanArr));?>;
teach_subArr = <?php print_r(json_encode($teach_subArr));?>; 

      $("#stan-disp").on('click','.closer-stan',function()
      {
        let id=$(this).attr("id");
        let aid=id.substr(6);
        if(window.confirm("Are You Sure?"))
        {
          $.post( "assets.php", { value : aid, type: "standard" , setup : "1" , action: "delete"} ).done(function(data)
            {
                if(data == "Failed")
                {
                alert("Error Has Occured");
                }
                else
                {
                  //alert(data);
                  $("#"+id+"-stan-cont").remove();
                  if($(".closer-stan").length < 1)
                  {
                    $(".notif-panel").append('<div class="alert alert-danger" id="zero-res-stan" role="alert">Add your prospective standards that you will be  teaching!</div>');
                  }
                }
            });
        }
        });

      $("#sub-disp").on('click','.closer-sub',function()
      {
        let id=$(this).attr("id");
        let aid=id.substr(6);

        if(window.confirm("Are You Sure?"))
        {
          $.post( "assets.php", { value : aid, type: "subject" , setup : "1" , action: "delete"} ).done(function(data)
            {
                if(data == "Failed")
                {
                alert("Error Has Occured");
                }
                else
                {
                  //alert(data);
                  $("#"+id+"-sub-cont").remove();
                  if($(".closer-sub").length < 1)
                  {
                   $(".notif-panel").append('<div class="alert alert-danger" id="zero-res-sub" role="alert">Add the subjects that you teach!</div>');
                  }
                }
            });
        }
        });


        $("#offline-batch").change(function(){
         let aid=$("#offline-batch").val();
        $.post("assets.php",{ value : aid, type:"toggle_accept" , setup : "1" , action: "toggle"}).done(function(data)
        {
          //console.log(data);
          if(data=="Success")
          {
            alert("Saved");
            if(aid=="0")
            {
              $("#seats").attr("disabled","");
              $("#seats-btn").attr("disabled","");
            }
            else
            {
              $("#seats").removeAttr("disabled");
              $("#seats-btn").removeAttr("disabled");
            }
          }
        });
      });

        $('#seats-btn').on('click',function(){
        var attr = $("#seats").attr('disabled');
        if($('#seats').val() > 0 && $('#seats').val() <=120) 
        $.post("assets.php",{ value : $('#seats').val(), type:"seat" , setup : "1" , action: "set"}).done(function(data)
        {
          alert("Updated");
        });
        });

        $("#kyc-cont").on('click','#close-kyc',function()
        {
          $.post("assets.php",{ kyc : "delete"}).done(function(data)
            {
              if(window.confirm("You will lose verification tick if you have already been verified"))
              {
              if(data=="Deleted")
              {
                $("#kyc-cont").html('<form action="assets.php" method="post" class="form-group" style="margin-top:20px" enctype="multipart/form-data"><input id="kyc" type="text" name="kyc" size="20" class="form-control" value="upload" hidden><label for="docfile">Upload Document Proof Here:</label><input id="docfile" type="file" name="docfile"><button type="submit" name="submit_doc" class="btn btn-block btn-outline-success mt-3">Upload Identity & Address Proof<</button></form>');
              }
              }
            });
        })
   // });*/
</script>
</body>
</html>