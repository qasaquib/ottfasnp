<?php 
	 $server = "localhost";
	 $user = "root";
	 $pw = "";
	 $db="teacher_finder";
	 $conn=mysqli_connect($server,$user,$pw,$db);
	 $queryg="";
     $g_array=array();
     $errors=array();

if (isset($_GET['logout'])) {
    foreach ($_SESSION as $key => $value) {
        //echo $value;
        unset($_SESSION[''.$key.'']);
    }
    header('location:home.php');
    session_destroy();
    exit();
 }

function popCity() {
	//echo "Hello";
    $GLOBALS['queryg']="select distinct city_name from `all_cities`";
    $arr=printList("city");
    return $arr;
}

function popState() {
    //echo "Hello";
    $GLOBALS['queryg']="select distinct state_name from `all_states`";
    $arr=printList("state");
    return $arr;
}

function popStandard() {
	//echo "Hello";
    $GLOBALS['queryg']="select distinct standard from `standard_list`";
    $arr=printList("standard");
    return $arr;
}
function popExam(){
    //echo "Hello";
    $GLOBALS['queryg']="select distinct name from `exam_list`";
    $arr=printList("exam");
    return $arr;
}

function popExamWithId(){
    //echo "Hello";
    $GLOBALS['queryg']="select id , name from `exam_list`";
    $arr=printList("examid");
    return $arr;
}

function popSubject() {
	//echo "Hello";
    $GLOBALS['queryg']="select distinct name from `subject_list` UNION select distinct sub_name from `teacher_subjects`";
    $arr=printList("subject");
    return $arr;
}

function getSubjectVod() {
    //echo "Hello";
    $GLOBALS['queryg']="select distinct name from `subject_list` UNION select distinct sub_name from `teacher_subjects`";
    //printList("subject");
    if ($result = mysqli_query($GLOBALS['conn'], $GLOBALS['queryg'])) {
                    while ($row = mysqli_fetch_row($result)) {
                        array_push($GLOBALS['narrower_arr'],$row[0]);
                    }
                
           }
}

function getSubject() {
    //echo "Hello";
    $r_array=array();
    $GLOBALS['queryg']="select distinct name from `subject_list` UNION select distinct sub_name from `teacher_subjects`";
    //printList("subject");
    if ($result = mysqli_query($GLOBALS['conn'], $GLOBALS['queryg'])) {
                    while ($row = mysqli_fetch_row($result)) {
                        array_push($r_array,$row[0]);
                    }

    return $r_array;
    }
    return false;
}

function getExam() {
    //echo "Hello";
    $r_array=array();
    $GLOBALS['queryg']="select distinct name from `exam_list`";
    //printList("subject");
    if ($result = mysqli_query($GLOBALS['conn'], $GLOBALS['queryg'])) {
                    while ($row = mysqli_fetch_row($result)) {
                        array_push($r_array,$row[0]);
                    }

    return $r_array;
    }
    return false;
}


function getStandard() {
    //echo "Hello";
    $r_array=array();
    $GLOBALS['queryg']="select distinct standard from `standard_list`";
    //printList("subject");
    if ($result = mysqli_query($GLOBALS['conn'], $GLOBALS['queryg'])) {
                    while ($row = mysqli_fetch_row($result)) {
                        array_push($r_array,$row[0]);
                    }

    return $r_array;
    }
    return false;
}

function popCWeeks() {
    for($i=4;$i<=24;$i+=2)
    {
        if($i==4)
        {
        echo('<option value="'.$i.'" selected>'.$i.' Weeks </option>');
        }
        else
        {
            echo('<option value="'.$i.'">'.$i.' Weeks </option>');
        }
    }
}
function printList($type){
	//echo "Hello";
	//echo $GLOBALS['query'];
    $g_array=array();
if ($result = mysqli_query($GLOBALS['conn'], $GLOBALS['queryg'])) {
    				while ($row = mysqli_fetch_row($result)) {
                    /*if(isset($_GET['$type']))
                    {
    				    if((null !== $_GET['$type'] )&& ($_GET['$type']===$row[0]))
                        {
    					echo('<option value="'.$row[0].'" selected>'.$row[0].'</option>');
                        array_push($g_array,$row[0]);
                        }
    				    else
                        {
    					echo('<option value="'.$row[0].'">'.$row[0].'</option>');
                        array_push($g_array,$row[0]);
                        }
                    }*/
                    if(isset($GLOBALS['type']))
                    {
                        if((null !== $GLOBALS['type'] )&& ($GLOBALS['type']==$row[0]))
                        {
                        echo('<option value="'.$row[0].'" selected>'.$row[0].'</option>');
                        array_push($g_array,$row[0]);
                        }
                        else
                        {
                        echo('<option value="'.$row[0].'">'.$row[0].'</option>');
                        array_push($g_array,$row[0]);
                        }
                    }
                    else if(isset($_SESSION['custom_fields_vod'])||isset($_SESSION['custom_fields_doc'])||isset($_SESSION['custom_fields_req']))
                    {
                      if((null !== $_SESSION['narrower'] )&& ($_SESSION['narrower']==$row[0]))
                      {
                        echo('<option value="'.$row[0].'" selected>'.$row[0].'</option>');
                        array_push($g_array,$row[0]);
                      }

                      else if((null !== $_COOKIE['narrower'] )&& ($_COOKIE['narrower']==$row[0]))
                      {
                        echo('<option value="'.$row[0].'" selected>'.$row[0].'</option>');
                        array_push($g_array,$row[0]);
                      }
                        else
                        {
                        echo('<option value="'.$row[0].'">'.$row[0].'</option>');
                        array_push($g_array,$row[0]);
                        }
                    }
                    else if($type == 'examid')
                    {
                        echo('<option value="'.$row[0].'">'.$row[1].'</option>');
                        array_push($g_array,array($row[0],$row[1]));
                    }
                    else
                    {
                        echo('<option value="'.$row[0].'">'.$row[0].'</option>');
                        array_push($g_array,$row[0]);
                    }
   				
    	   }
           //$GLOBALS['g_array']=$g_array;
           return $g_array;
     }
     return false;
     
}
//popStandard();
//popSubject();
//popCity();

if (isset($_GET['logout'])) {
    foreach ($_SESSION as $key => $value) {
        //echo $value;
        unset($_SESSION[''.$key.'']);
    }
    header('location:home.php');
    exit();
 }

 function conEcho($str1,$str2)
 {
    if($str1===$str2)
        return 'selected';
    else
        return '';
 }


 function verify_vod($link)
 {  
    $videoID="";
    if(strrpos($link,"v="))
    {
    $videoID=explode("v=",$link);
    $videoID=end($videoID);
        if(strpos($videoID,"&"))
        {
            $videoID=substr($videoID,0,strpos($videoID,"&"));
        }
    }
    else if(strrpos($link,"https://youtu.be/")>=0)
    {https://youtu.be/YS4e4q9oBaU
    $videoID=explode("https://youtu.be/",$link);
    $videoID=end($videoID);
        if(strpos($videoID,"?"))
        {
            $videoID=substr($videoID,0,strpos($videoID,"?"));
        }
    }
    if($videoID=="")
    {
        return false;
    }
    $apiPublicKey="AIzaSyBQm_ahSiNK2LkZR4R-m7s0Vpxn68cfIX4";
    $response = file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=id&id=' . $videoID . '&key=' . $apiPublicKey);
    $json = json_decode($response,true);

if (sizeof($json['items'])) {
    return true;

}
else {
    return false;
    // video does not exist
}
}


function getVideoId()
{
    $sql="SELECT vod_link from teacher_vod";
    $result=mysqli_query($GLOBALS['conn'],$sql);
    if($result)
    {
    $num=mysqli_num_rows($result);
    $rand=rand(0,$num);
    $row=mysqli_fetch_all($result);
    return extract_videoId($row[$rand][0]);
    //return print_r($row);
    }
    else
    {
        return 'Rub-JsjMhWY';
    }
}


 function extract_vod_id($link)
 {  
    $videoID;
    if(strrpos($link,"v="))
    {
    $videoID=explode("v=",$link);
    $videoID=end($videoID);
        if(strpos($videoID,"&"))
        {
            $videoID=substr($videoID,0,strpos($videoID,"&"));
        }
    }
    else if(strrpos($link,"https://youtu.be/")>=0)
    {https://youtu.be/YS4e4q9oBaU
    $videoID=explode("https://youtu.be/",$link);
    $videoID=end($videoID);
        if(strpos($videoID,"?"))
        {
            $videoID=substr($videoID,0,strpos($videoID,"?"));
        }
    }
    $apiPublicKey="AIzaSyBQm_ahSiNK2LkZR4R-m7s0Vpxn68cfIX4";
    $response = file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=id&id=' . $videoID . '&key=' . $apiPublicKey);
    $json = json_decode($response,true);

if (sizeof($json['items'])) {
    return $videoID;

} 
else {
    return false;
    // video does not exist
}
}


 function extract_videoId($link)
 {  
    $videoID;
    if(strrpos($link,"v="))
    {
    $videoID=explode("v=",$link);
    $videoID=end($videoID);
        if(strpos($videoID,"&"))
        {
            $videoID=substr($videoID,0,strpos($videoID,"&"));
        }
    }
    else if(strrpos($link,"https://youtu.be/")>=0)
    {https://youtu.be/YS4e4q9oBaU
    $videoID=explode("https://youtu.be/",$link);
    $videoID=end($videoID);
        if(strpos($videoID,"?"))
        {
            $videoID=substr($videoID,0,strpos($videoID,"?"));
        }
    }
    return $videoID;
}


function getTeacherSubjects($email)
{
    $GLOBALS['queryg']="select distinct sub_name from `teacher_subjects` where teacher_id like '$email'";
    $arr=printList("subject");
    return $arr;
}

function encodeMail($type,$email)
{
    if($type=='teacher')
    {
        $sql="SELECT id from teacher_uid WHERE email like '$email'";
        $result=mysqli_query($GLOBALS['conn'],$sql);
        if($result)
        {
            $row=mysqli_fetch_row($result);
            return $row[0];
        }
        else
        {
            return "";
        }
    }
    else if($type=='student')
    {
        $sql="SELECT id from student_uid WHERE email like '$email'";
        $result=mysqli_query($GLOBALS['conn'],$sql);
        if($result)
        {
            $row=mysqli_fetch_row($result);
            return $row[0];        }
        else
        {
            return "";
        }
    }
}


function decodeMail($type,$code)
{
    if($type=='teacher')
    {
        $sql="SELECT email from teacher_uid WHERE id like '$code'";
        $result=mysqli_query($GLOBALS['conn'],$sql);
        if($result)
        {
            $row=mysqli_fetch_row($result);
            return $row[0];
        }
        else
        {
            return false;
        }
    }
    else if($type=='student')
    {
        $sql="SELECT email from student_uid WHERE id like '$code'";
        $result=mysqli_query($GLOBALS['conn'],$sql);
        if($result)
        {
            $row=mysqli_fetch_row($result);
            return $row[0];
        }
        else
        {
            return false;
        }
    }
}


function printRecvList()
{
    $date=date("Y-m-d H:i:s");
    $tmail=$_SESSION['email'];
    $sql="SELECT * FROM student_uid INNER JOIN teacher_batch ON student_uid.email = teacher_batch.student_id INNER JOIN student_data ON student_uid.email = student_data.email WHERE teacher_batch.teacher_id = '$tmail'";
    $result=mysqli_query($GLOBALS['conn'],$sql);
    while($row=mysqli_fetch_array($result))
    {
        echo '<option value="'.$row['id'].'">'.$row['fname'].' '.$row['lname'].'</option>';
    }

}

function checkSearchable()
{
            $numSub=$numStan=0;
            $email = $_SESSION['email'];
            //$preres=0;
            $sql="SELECT * FROM teacher_subjects where teacher_id = '$email'";
            $subResult=mysqli_query($GLOBALS['conn'],$sql);
            $numSub=mysqli_num_rows($subResult); 
            $sql="SELECT * FROM teacher_standards where teacher_id = '$email'";
            $stanResult=mysqli_query($GLOBALS['conn'],$sql);
            $numStan=mysqli_num_rows($stanResult);
            $sql="SELECT verified_mail FROM teacher_verified where email = '$email'";
            $verResult=mysqli_query($GLOBALS['conn'],$sql);
            $row=mysqli_fetch_row($verResult);
            $numVer=(int)$row[0];
            $sql = "UPDATE teacher_data SET searchable = '1' WHERE email = '$email'";
            if($numSub && $numStan && $numVer)
            {
                mysqli_query($GLOBALS['conn'],$sql);
                return true;
            }
            return false;
}


?>