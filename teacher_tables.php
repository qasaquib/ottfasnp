<?php
require_once('server.php');
function getReqTable()
{
	 $email=$_SESSION['email'];
	 $res;
	 $preres=0;
	 $stat;
     $lim;
	 $res=0;
	 if(!isset($_SESSION['req']['sorter']))
	 {
	 	//setcookie('sorter',"req_date");
	 	$_SESSION['req']['sorter']="req_date";
	 }
	 if(!isset($_SESSION['req']['orderer']))
	 {
	 	//setcookie('orderer',"ASC");
	 	$_SESSION['req']['orderer']="ASC";
	 }
	 if(!isset($_SESSION['req']['narrower']))
	 {
	 	//setcookie('narrower',"NA");
	 	$_SESSION['req']['narrower']="NA";
	 }
	 if(!isset($_SESSION['req']['perpg']))
	 {
	 	//setcookie('perpg',3);
	 	$_SESSION['req']['perpg']=3;
	 }
	 if(!isset($_SESSION['req']['pgno']))
	 {
	 	//setcookie('pgno',1);
	 	$_SESSION['req']['pgno']=1;
	 }

	 if(isset($_POST['pgbt']))
	 {
	 	//print_r($_POST['pgbt']);
	 	//print_r($_POST['pgbt']);
	 	$_SESSION['req']['pgno']=(int)$_POST['pgbt'][0];
	 	//setcookie('pgno',(int)$_POST['pgbt'][0]);
	 }

	 if(isset($_POST['nextpg']))
	 {
	 	if($_SESSION['req']['pgno']<$_SESSION['req']['pglim'])
	 	{
	 	$_SESSION['req']['pgno']=$_SESSION['req']['pgno']+1;
	 	//setcookie('pgno',$_SESSION['req']['pgno']+1);
	 	//echo $_SESSION['req']['pgno'];
	 	//echo $_SESSION['req']['pglim'];
	 	}
	 }

	 if(isset($_POST['prevpg']))
	 {
	 	if($_SESSION['req']['pgno']>1)
	 	{
	 		$_SESSION['req']['pgno']=$_SESSION['req']['pgno']-1;
	 		//setcookie('pgno',$_SESSION['req']['pgno']-1);
	 		//echo $_SESSION['req']['pgno'];
	 	}
	 }
     //$illegal=0;
     ///-----///


    // Offline batch Management
          $sortby="req_date";
          $direction="ASC";
          $pgno=1;
          $perpg=3;
          if(isset($_SESSION['req']['pgno']))
          { 
          //print_r($_POST['pgbt']);
          //prin($_POST['pgbt']);
          $pgno=(int)$_SESSION['req']['pgno'];
          }
          $tot;
          //$tot=mysqli_num_rows(mysqli_query());
          //$num_page=0;
          $narrow="NA";
          if(isset($_SESSION['custom_fields_req']))
          {
              $sortby=$_SESSION['req']['sorter'];
              $direction=$_SESSION['req']['orderer'];
              $perpg=(int)$_SESSION['req']['perpg'];
              $narrow=$_SESSION['req']['narrower'];
              //$pgno=(int)$_SESSION['req']['pgno'];

          }
          $highlim=(int)$pgno*(int)$perpg;
          $lowlim=(int)$highlim - (int)$perpg;
          $sortby_arr=array('name','req_date','subject');
          $perpg_arr=array('3','5','10','20','30');
          $direction_arr=array('ASC','DESC');
          $narrower_arr=getSubject();
          array_push($narrower_arr, "NA","Others");
          //print_r($narrower_arr);
          //echo 'ASDASD1';
          //$narrower_arr=array_merge_recursive($narrower_arr,$g_array);
          if($sortby != "name")
          {
          $sql3="SELECT * , CONCAT(student_data.fname, ' ' ,student_data.lname) as name FROM teacher_offline INNER JOIN student_data ON student_data.email = teacher_offline.student_id WHERE teacher_offline.teacher_id=? ORDER BY ".$sortby." $direction  ,name $direction LIMIT $lowlim, $perpg";//default_custom
     	  }
     	  else
     	  {
     	  	$sql3="SELECT * , CONCAT(student_data.fname, ' ' ,student_data.lname) as name FROM teacher_offline INNER JOIN student_data ON student_data.email = teacher_offline.student_id WHERE teacher_offline.teacher_id=? ORDER BY ".$sortby." $direction  ,req_date $direction LIMIT $lowlim, $perpg";//default_custom
     	  }
          $sql2="SELECT * , CONCAT(student_data.fname, ' ' ,student_data.lname) as name FROM teacher_offline INNER JOIN student_data ON student_data.email = teacher_offline.student_id WHERE teacher_offline.teacher_id='$email' ORDER BY req_date $direction, name $direction";

          if($narrow!="NA")
          {
              if(!in_array($narrow, $narrower_arr))
             $preres=0;
            else
            {
             $preres=1;
            if($sortby != "name")
            {
            $sql3="SELECT * , CONCAT(student_data.fname, ' ' ,student_data.lname) as name FROM teacher_offline INNER JOIN student_data ON student_data.email = teacher_offline.student_id WHERE teacher_offline.teacher_id like ? AND teacher_offline.subject like ? ORDER BY ".$sortby." $direction,name ".$direction." LIMIT ".$lowlim.", ".$perpg;
        	}
        	else
        	{
        		$sql3="SELECT * , CONCAT(student_data.fname, ' ' ,student_data.lname) as name FROM teacher_offline INNER JOIN student_data ON student_data.email = teacher_offline.student_id WHERE teacher_offline.teacher_id like ? AND teacher_offline.subject like ? ORDER BY ".$sortby." $direction,req_date ".$direction." LIMIT ".$lowlim.", ".$perpg;
        	}
            $sql2="SELECT * , CONCAT(student_data.fname, ' ' ,student_data.lname) as name FROM teacher_offline INNER JOIN student_data ON student_data.email = teacher_offline.student_id WHERE teacher_offline.teacher_id like '$email' AND teacher_offline.subject like '$narrow' ORDER BY ".$sortby." ".$direction;
            }
          }
           //echo $sql2."<br/>".$sql3;
          if(isset($_POST['custom_sub_req']))
          {
            //echo 'Custom_sub';
          //print_r($_POST['brax']);
          $sortby=$_POST['sorter'];
          $direction=$_POST['orderer'];
          $perpg=(int)$_POST['perpg'];
          //$pgno=(int)$_SESSION['req']['$pgno'];
          $pgno=1;
          $highlim=(int)$pgno*(int)$perpg;
          $narrow=$_POST['narrower'];
          $_SESSION['custom_fields_req']=1;
          //setcookie('sorter',$_POST['sorter']);
          //setcookie('orderer',$_POST['orderer']);
          //setcookie('perpg',$_POST['perpg']);
          //setcookie('narrower',$_POST['narrower']);
          $_SESSION['req']['sorter']=$_POST['sorter'];
          $_SESSION['req']['orderer']=$_POST['orderer'];
          $_SESSION['req']['perpg']=$_POST['perpg'];
          $_SESSION['req']['narrower']=$_POST['narrower'];
          /*$_SESSION['req']['pgno']=(int)$pgno;*/
          $_SESSION['req']['pgno']=1;
          $lowlim=(int)$highlim - (int)$perpg;
          $safe_input=1;
          if(!in_array($sortby, $sortby_arr))
            $safe_input=0;
          if(!in_array($perpg, $perpg_arr))
            $safe_input=0;
          if(!in_array($direction, $direction_arr))
            $safe_input=0;
          if(!in_array($narrow, $narrower_arr))
            $safe_input=0;
          //echo $safe_input.$sortby.$perpg.$direction.$narrow;
          //echo array_search($narrow, $narrower_arr);
          if($safe_input===1)
          {
          if(isset($_POST['narrower']))
          {
           if($_POST['narrower']=='NA')
           {
           //echo "$narrow";
             if($sortby != "name")
             {
             $sql3="SELECT * , CONCAT(student_data.fname, ' ' ,student_data.lname) as name FROM teacher_offline INNER JOIN student_data ON student_data.email = teacher_offline.student_id WHERE teacher_offline.teacher_id= ? ORDER BY ".$sortby." $direction,name ".$direction." LIMIT ".$lowlim.", ".$perpg;
         	 }
         	 else
         	 {
         	 	$sql3="SELECT * , CONCAT(student_data.fname, ' ' ,student_data.lname) as name FROM teacher_offline INNER JOIN student_data ON student_data.email = teacher_offline.student_id WHERE teacher_offline.teacher_id= ? ORDER BY ".$sortby." $direction,req_date ".$direction." LIMIT ".$lowlim.", ".$perpg;
         	 }
             $sql2="SELECT * , CONCAT(student_data.fname, ' ' ,student_data.lname) as name FROM teacher_offline INNER JOIN student_data ON student_data.email = teacher_offline.student_id WHERE teacher_offline.teacher_id='$email' ORDER BY ".$sortby." ".$direction;
           
            //echo $sql2."<br/>".$sql3;
             $tot=mysqli_num_rows(mysqli_query($GLOBALS['conn'],$sql2));
             //$sql3="SELECT * FROM teacher_vod WHERE teacher_id like ? ORDER BY ? ? LIMIT ?, ?";
             //echo "ADSAD";
               if ($stmt = mysqli_prepare($GLOBALS['conn'],$sql3)) {
                //echo "Asdasd";
              /* bind parameters for markers */
                mysqli_stmt_bind_param($stmt, 's', $email);
                $stat=mysqli_stmt_execute($stmt);
                //echo $stat;
                $res=mysqli_stmt_get_result($stmt);
                //print_r($res);
                mysqli_stmt_close($stmt);
            }
            else
            {
            echo "Failed1";
            //session_destroy();
            }

           }
           else
           {
           //echo "$narrow";
           if($sortby != "name")
           {
           $sql3="SELECT * , CONCAT(student_data.fname, ' ' ,student_data.lname) as name FROM teacher_offline INNER JOIN student_data ON student_data.email = teacher_offline.student_id WHERE teacher_offline.teacher_id like ? AND teacher_offline.subject like ? ORDER BY ".$sortby." $direction,name ".$direction." LIMIT ".$lowlim.", ".$perpg;
       		}
       		else
       		{
       			$sql3="SELECT * , CONCAT(student_data.fname, ' ' ,student_data.lname) as name FROM teacher_offline INNER JOIN student_data ON student_data.email = teacher_offline.student_id WHERE teacher_offline.teacher_id like ? AND teacher_offline.subject like ? ORDER BY ".$sortby." $direction,req_date ".$direction." LIMIT ".$lowlim.", ".$perpg;
       		}
           $sql2="SELECT * , CONCAT(student_data.fname, ' ' ,student_data.lname) as name FROM teacher_offline INNER JOIN student_data ON student_data.email = teacher_offline.student_id WHERE teacher_offline.teacher_id like '$email' AND teacher_offline.subject like '$narrow' ORDER BY ".$sortby." ".$direction;
           //$sql3="SELECT * FROM teacher_vod WHERE teacher_id like ? AND subject like ? ORDER BY ? ? LIMIT ?, ?";
           $tot=mysqli_num_rows(mysqli_query($GLOBALS['conn'],$sql2));
           if ($stmt = mysqli_prepare($GLOBALS['conn'],$sql3)) {

              /* bind parameters for markers */
                mysqli_stmt_bind_param($stmt, 'ss', $email,$narrow);
                $stat=mysqli_stmt_execute($stmt);
                //echo $stat;
                $res=mysqli_stmt_get_result($stmt);
                //print_r($res);
                mysqli_stmt_close($stmt);
            }
            else
            {
            echo "Failed2";
            //session_destroy();
            }
           if($stat == false)
           {
              echo '<div class="alert alert-dark" role="alert">No Results</div>';
           }

          }

           /* execute query */
          
          //echo (mysqli_num_rows($res));

           /* bind result variables */
          // mysqli_stmt_bind_result($stmt, $ruid,$rpasswd);

           /* fetch value */
          // mysqli_stmt_fetch($stmt);

          /* store result */
           /* close statement */
          // mysqli_stmt_close($stmt);
      
    }
    }//end of safe input check
   }//end of if custom_sub
   else
   {
            $tot=mysqli_num_rows(mysqli_query($GLOBALS['conn'],$sql2));
            if ($stmt = mysqli_prepare($GLOBALS['conn'],$sql3)) {

              /* bind parameters for markers */
                //mysqli_stmt_bind_param($stmt, 'ss', $email,$narrow);
                if($preres==0)
                {
                  mysqli_stmt_bind_param($stmt, 's', $email);
                }
                else
                {
                  mysqli_stmt_bind_param($stmt, 'ss', $email,$narrow);
                }
                $stat=mysqli_stmt_execute($stmt);
                //echo $stat;
                $res=mysqli_stmt_get_result($stmt);
                //print_r($res);
                mysqli_stmt_close($stmt);
            }
            else
            {
            echo "Failed3";
            //session_destroy();
            }
            //echo $sql3."<br>";
            //echo $sql2;
            //print_r($res);
   }
            $tot1=1;
            if(($pgno-5)>$tot1)
            {
              $tot1=$pgno-5;
            }
            $lim=(int)($tot/$perpg);
              if(($tot%$perpg)>0)
                $lim=$lim+1;
            $tot2=$lim;
            if(($pgno+5)<$lim)
            {
              $tot2=$pgno+5;
            }
	  //setcookie('pglim',$lim);
      $_SESSION['req']['pglim']=$lim;
      //echo "$lim";
      //echo $_SESSION['req']['pglim'];
      //print_r($_SESSION);
      return array('res' =>$res ,'tot1'=>$tot1,'tot2'=>$tot2,'pgno'=>$pgno);

}


function getVodTable()
{
	 $uid=$_SESSION['email'];
	 $res;
	 $preres=0;
	 if(!isset($_SESSION['vod']['sorter']))
	 	$_SESSION['vod']['sorter']="";
	 if(!isset($_SESSION['vod']['orderer']))
	 	$_SESSION['vod']['orderer']="";
	 if(!isset($_SESSION['vod']['narrower']))
	 	$_SESSION['vod']['narrower']="";
	 if(!isset($_SESSION['vod']['perpg']))
	 	$_SESSION['vod']['perpg']=3;
	 if(!isset($_SESSION['vod']['pgno']))
	 	$_SESSION['vod']['pgno']="1";
	 if(isset($_POST['pgbt']))
	 {
	 	//print_r($_POST['pgbt']);
	 	//prin($_POST['pgbt']);
	 	$_SESSION['vod']['pgno']=(int)$_POST['pgbt'][0];
	 }

	 if(isset($_POST['nextpg']))
	 {
	 	if($_SESSION['vod']['pgno']<$_SESSION['vod']['pglim'])
	 	{
	 	$_SESSION['vod']['pgno']=$_SESSION['vod']['pgno']+1;
	 	//echo $_SESSION['vod']['pgno'];
	 	}
	 }

	 if(isset($_POST['prevpg']))
	 {
	 	if($_SESSION['vod']['pgno']>1)
	 	{
	 		$_SESSION['vod']['pgno']=$_SESSION['vod']['pgno']-1;
	 		//echo $_SESSION['vod']['pgno'];
	 	}
	 }
	 	 //if(!isset($_SESSION['custom_fields_vod']))
	 	//$_SESSION['custom_fields_vod']=0;
	//if(isset($_SESSION['custom_fields_vod']))
	 //echo $_SESSION['custom_fields_vod'];
     //$illegal=0;

     				$sortby="vod_date";
	 				$direction="ASC";
	 				$pgno=1;
	 				$perpg=3;
	 			    if(isset($_SESSION['vod']['pgno']))
	 				{	
	 				//print_r($_POST['pgbt']);
	 				//prin($_POST['pgbt']);
	 				$pgno=(int)$_SESSION['vod']['pgno'];
	 				}
	 				$tot;
	 				//$tot=mysqli_num_rows(mysqli_query());
	 				//$num_page=0;
	 				$narrow="NA";
	 				if(isset($_SESSION['custom_fields_vod']))
	 				{
	 						$sortby=$_SESSION['vod']['sorter'];
	 						$direction=$_SESSION['vod']['orderer'];
	 						$perpg=(int)$_SESSION['vod']['perpg'];
	 						$narrow=$_SESSION['vod']['narrower'];
	 						//$pgno=(int)$_SESSION['vod']['pgno'];

	 				}
	 				$highlim=(int)$pgno*(int)$perpg;
	 				$lowlim=(int)$highlim - (int)$perpg;
	 				$sortby_arr=array('name','vod_date','subject');
	 				$perpg_arr=array('3','5','10','20','30');
	 				$direction_arr=array('ASC','DESC');
	 				$narrower_arr=getSubject();
	 				array_push($narrower_arr, "NA","Others");
	 				//print_r($narrower_arr);
	 				//echo 'ASDASD1';
	 				//$narrower_arr=array_merge_recursive($narrower_arr,$g_array);
	 				$sql3="SELECT * FROM teacher_vod WHERE teacher_id=? ORDER BY `teacher_vod`.`".$sortby."` $direction LIMIT $lowlim, $perpg";//default_custom
	 				$sql2="SELECT * FROM teacher_vod WHERE teacher_id='$uid' ORDER BY 'vod_date'";

	 				if($narrow!="NA")
	 				{
	 				    if(!in_array($narrow, $narrower_arr))
	 					 $preres=0;
	 					else
	 					{
	 					 $preres=1;
	 					$sql3="SELECT * FROM teacher_vod WHERE teacher_id like ? AND subject like ? ORDER BY `teacher_vod`.`".$sortby."` ".$direction." LIMIT ".$lowlim.", ".$perpg;
	 					$sql2="SELECT * FROM teacher_vod WHERE teacher_id like '$uid' AND subject like '$narrow' ORDER BY `teacher_vod`.`".$sortby."` ".$direction;
	 					}
	 				}
	 				
	 				if(isset($_POST['custom_sub_vod']))
	 				{
	 			    //echo 'Custom_sub';
	 				$sortby=$_POST['sorter'];
	 				$direction=$_POST['orderer'];
	 				$perpg=(int)$_POST['perpg'];
	 				//$pgno=(int)$_SESSION['vod']['$pgno'];
	 				$pgno=1;
	 				$highlim=(int)$pgno*(int)$perpg;
	 				$narrow=$_POST['narrower'];
	 				$_SESSION['custom_fields_vod']=1;
	 				$_SESSION['vod']['sorter']=$_POST['sorter'];
	 				$_SESSION['vod']['orderer']=$_POST['orderer'];
	 				$_SESSION['vod']['perpg']=$_POST['perpg'];
	 				$_SESSION['vod']['narrower']=$_POST['narrower'];
	 				//$_SESSION['vod']['pgno']=(int)$pgno;
	 				$_SESSION['vod']['pgno']=1;
	 				$lowlim=(int)$highlim - (int)$perpg;
	 				$safe_input=1;
	 				if(!in_array($sortby, $sortby_arr))
	 					$safe_input=0;
	 				if(!in_array($perpg, $perpg_arr))
	 					$safe_input=0;
	 				if(!in_array($direction, $direction_arr))
	 					$safe_input=0;
	 				if(!in_array($narrow, $narrower_arr))
	 					$safe_input=0;
	 				//echo $safe_input.$sortby.$perpg.$direction.$narrow;
	 				//echo array_search($narrow, $narrower_arr);
	 				if($safe_input===1)
	 				{
	 				if(isset($_POST['narrower']))
	 				{
	 				 if($_POST['narrower']=='NA')
	 				 {
	 				 //echo "$narrow";
	 			  	 $sql3="SELECT * FROM teacher_vod WHERE teacher_id= ? ORDER BY `teacher_vod`.`".$sortby."` ".$direction." LIMIT ".$lowlim.", ".$perpg;
	 			  	 $sql2="SELECT * FROM teacher_vod WHERE teacher_id='$uid' ORDER BY `teacher_vod`.`".$sortby."` ".$direction;
	 			  	 $tot=mysqli_num_rows(mysqli_query($GLOBALS['conn'],$sql2));
	 			  	 //$sql3="SELECT * FROM teacher_vod WHERE teacher_id like ? ORDER BY ? ? LIMIT ?, ?";
	 			  	 //echo "ADSAD";
	 			  		 if ($stmt = mysqli_prepare($GLOBALS['conn'],$sql3)) {
	 			  		 	//echo "Asdasd";
    					/* bind parameters for markers */
    			    	mysqli_stmt_bind_param($stmt, 's', $uid);
    			    	$stat=mysqli_stmt_execute($stmt);
    			    	//echo $stat;
    			    	$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	mysqli_stmt_close($stmt);
						}
						else
						{
						echo "Failed";
						//session_destroy();
						}

	 				 }
	 				 else
	 				 {
	 				 //echo "$narrow";
	 				 $sql3="SELECT * FROM teacher_vod WHERE teacher_id like ? AND subject like ? ORDER BY `teacher_vod`.`".$sortby."` ".$direction." LIMIT ".$lowlim.", ".$perpg;
	 				 $sql2="SELECT * FROM teacher_vod WHERE teacher_id like '$uid' AND subject like '$narrow' ORDER BY `".$sortby."` ".$direction;
	 				 //$sql3="SELECT * FROM teacher_vod WHERE teacher_id like ? AND subject like ? ORDER BY ? ? LIMIT ?, ?";
	 				 $tot=mysqli_num_rows(mysqli_query($GLOBALS['conn'],$sql2));
	 				 if ($stmt = mysqli_prepare($GLOBALS['conn'],$sql3)) {

    					/* bind parameters for markers */
    			    	mysqli_stmt_bind_param($stmt, 'ss', $uid,$narrow);
    			    	$stat=mysqli_stmt_execute($stmt);
    			    	//echo $stat;
    			    	$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	mysqli_stmt_close($stmt);
						}
					 	else
					 	{
						echo "Failed";
						//session_destroy();
					 	}
					 if($stat == false)
					 {
					  	echo '<div class="alert alert-dark" role="alert">No Results</div>';
					 }

	 				}

   				 /* execute query */
    			
    			//echo (mysqli_num_rows($res));

   				 /* bind result variables */
   				// mysqli_stmt_bind_result($stmt, $ruid,$rpasswd);

   				 /* fetch value */
  				// mysqli_stmt_fetch($stmt);

    			/* store result */
   				 /* close statement */
   				// mysqli_stmt_close($stmt);
	 		
	 	}
	  }//end of safe input check
	 }//end of if custom_sub
	 else
	 {
	 					$tot=mysqli_num_rows(mysqli_query($GLOBALS['conn'],$sql2));
	 		 			if ($stmt = mysqli_prepare($GLOBALS['conn'],$sql3)) {

    					/* bind parameters for markers */
    			    	//mysqli_stmt_bind_param($stmt, 'ss', $uid,$narrow);
    			    	if($preres==0)
    			    	{
    			    		mysqli_stmt_bind_param($stmt, 's', $uid);
    			    	}
    			    	else
    			    	{
    			    		mysqli_stmt_bind_param($stmt, 'ss', $uid,$narrow);
    			    	}
    			    	$stat=mysqli_stmt_execute($stmt);
    			    	//echo $stat;
    			    	$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	mysqli_stmt_close($stmt);
						}
						else
						{
						echo "Failed";
						//session_destroy();
						}
						//echo $sql3."<br>";
						//echo $sql2;
						//print_r($res);
	 }
		$tot1=1;
		if(($pgno-5)>$tot1)
		{
			$tot1=$pgno-5;
		}
		$lim=(int)($tot/$perpg);
		if(($tot%$perpg)>0)
			$lim=$lim+1;
		$tot2=$lim;
		if(($pgno+5)<$lim)
		{
			$tot2=$pgno+5;
		}
$_SESSION['vod']['pglim']=$lim;
return array('res' =>$res ,'tot1'=>$tot1,'tot2'=>$tot2,'pgno'=>$pgno);

}


function getDocTable()
{
	 $uid=$_SESSION['email'];
	 $res;
	 $preres=0;
	 if(!isset($_SESSION['doc']['sorter']))
	 	$_SESSION['doc']['sorter']="";
	 if(!isset($_SESSION['doc']['orderer']))
	 	$_SESSION['doc']['orderer']="";
	 if(!isset($_SESSION['doc']['narrower']))
	 	$_SESSION['doc']['narrower']="";
	 if(!isset($_SESSION['doc']['perpg']))
	 	$_SESSION['doc']['perpg']=3;
	 if(!isset($_SESSION['doc']['pgno']))
	 	$_SESSION['doc']['pgno']="1";
	 if(isset($_POST['pgbt']))
	 {
	 	//print_r($_POST['pgbt']);
	 	//prin($_POST['pgbt']);
	 	$_SESSION['doc']['pgno']=(int)$_POST['pgbt'][0];
	 }

	 if(isset($_POST['nextpg']))
	 {
	 	if($_SESSION['doc']['pgno']<$_SESSION['doc']['pglim'])
	 	{
	 	$_SESSION['doc']['pgno']=$_SESSION['doc']['pgno']+1;
	 	//echo $_SESSION['doc']['pgno'];
	 	}
	 }

	 if(isset($_POST['prevpg']))
	 {
	 	if($_SESSION['doc']['pgno']>1)
	 	{
	 		$_SESSION['doc']['pgno']=$_SESSION['doc']['pgno']-1;
	 		//echo $_SESSION['doc']['pgno'];
	 	}
	 }
	 //if(!isset($_SESSION['custom_fields_doc']))
	 	//$_SESSION['custom_fields_doc']=0;
	//if(isset($_SESSION['custom_fields_doc']))
	 //echo $_SESSION['custom_fields_doc'];
     $illegal=0;

      					$sortby="doc_date";
	 				$direction="ASC";
	 				$pgno=1;
	 				$perpg=3;
	 			    if(isset($_SESSION['doc']['pgno']))
	 				{	
	 				//print_r($_POST['pgbt']);
	 				//prin($_POST['pgbt']);
	 				$pgno=(int)$_SESSION['doc']['pgno'];
	 				}
	 				$tot;
	 				//$tot=mysqli_num_rows(mysqli_query());
	 				//$num_page=0;
	 				$narrow="NA";
	 				if(isset($_SESSION['custom_fields_doc']))
	 				{
	 						$sortby=$_SESSION['doc']['sorter'];
	 						$direction=$_SESSION['doc']['orderer'];
	 						$perpg=(int)$_SESSION['doc']['perpg'];
	 						$narrow=$_SESSION['doc']['narrower'];
	 						//$pgno=(int)$_SESSION['doc']['pgno'];

	 				}
	 				$highlim=(int)$pgno*(int)$perpg;
	 				$lowlim=(int)$highlim - (int)$perpg;
	 				$sortby_arr=array('name','doc_date','subject');
	 				$perpg_arr=array('3','5','10','20','30');
	 				$direction_arr=array('ASC','DESC');
	 				$narrower_arr=getSubject();	 				
	 				array_push($narrower_arr, "NA","Others");
	 				//print_r($narrower_arr);
	 				//echo 'ASDASD1';
	 				//$narrower_arr=array_merge_recursive($narrower_arr,$g_array);
	 				$sql3="SELECT * FROM teacher_docs WHERE teacher_id=? ORDER BY `teacher_docs`.`".$sortby."` $direction LIMIT $lowlim, $perpg";//default_custom
	 				$sql2="SELECT * FROM teacher_docs WHERE teacher_id='$uid' ORDER BY 'doc_date'";

	 				if($narrow!="NA")
	 				{
	 				    if(!in_array($narrow, $narrower_arr))
	 					 $preres=0;
	 					else
	 					{
	 					 $preres=1;
	 					$sql3="SELECT * FROM teacher_docs WHERE teacher_id like ? AND subject like ? ORDER BY `teacher_docs`.`".$sortby."` ".$direction." LIMIT ".$lowlim.", ".$perpg;
	 					$sql2="SELECT * FROM teacher_docs WHERE teacher_id like '$uid' AND subject like '$narrow' ORDER BY `teacher_docs`.`".$sortby."` ".$direction;
	 					}
	 				}
	 				
	 				if(isset($_POST['custom_sub_doc']))
	 				{
	 			    //echo 'Custom_sub';
	 				$sortby=$_POST['sorter'];
	 				$direction=$_POST['orderer'];
	 				$perpg=(int)$_POST['perpg'];
	 				//$pgno=(int)$_SESSION['doc']['$pgno'];
	 				$pgno=1;
	 				$highlim=(int)$pgno*(int)$perpg;
	 				$narrow=$_POST['narrower'];
	 				$_SESSION['custom_fields_doc']=1;
	 				$_SESSION['doc']['sorter']=$_POST['sorter'];
	 				$_SESSION['doc']['orderer']=$_POST['orderer'];
	 				$_SESSION['doc']['perpg']=$_POST['perpg'];
	 				$_SESSION['doc']['narrower']=$_POST['narrower'];
	 				//$_SESSION['doc']['pgno']=(int)$pgno;
	 				$_SESSION['doc']['pgno']=1;
	 				$lowlim=(int)$highlim - (int)$perpg;
	 				$safe_input=1;
	 				if(!in_array($sortby, $sortby_arr))
	 					$safe_input=0;
	 				if(!in_array($perpg, $perpg_arr))
	 					$safe_input=0;
	 				if(!in_array($direction, $direction_arr))
	 					$safe_input=0;
	 				if(!in_array($narrow, $narrower_arr))
	 					$safe_input=0;
	 				//echo $safe_input.$sortby.$perpg.$direction.$narrow;
	 				//echo array_search($narrow, $narrower_arr);
	 				if($safe_input===1)
	 				{
	 				if(isset($_POST['narrower']))
	 				{
	 				 if($_POST['narrower']=='NA')
	 				 {
	 				 //echo "$narrow";
	 			  	 $sql3="SELECT * FROM teacher_docs WHERE teacher_id= ? ORDER BY `teacher_docs`.`".$sortby."` ".$direction." LIMIT ".$lowlim.", ".$perpg;
	 			  	 $sql2="SELECT * FROM teacher_docs WHERE teacher_id='$uid' ORDER BY `teacher_docs`.`".$sortby."` ".$direction;
	 			  	 $tot=mysqli_num_rows(mysqli_query($GLOBALS['conn'],$sql2));
	 			  	 //$sql3="SELECT * FROM teacher_vod WHERE teacher_id like ? ORDER BY ? ? LIMIT ?, ?";
	 			  	 //echo "ADSAD";
	 			  		 if ($stmt = mysqli_prepare($GLOBALS['conn'],$sql3)) {
	 			  		 	//echo "Asdasd";
    					/* bind parameters for markers */
    			    	mysqli_stmt_bind_param($stmt, 's', $uid);
    			    	$stat=mysqli_stmt_execute($stmt);
    			    	//echo $stat;
    			    	$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	mysqli_stmt_close($stmt);
						}
						else
						{
						echo "Failed";
						//session_destroy();
						}

	 				 }
	 				 else
	 				 {
	 				 //echo "$narrow";
	 				 $sql3="SELECT * FROM teacher_docs WHERE teacher_id like ? AND subject like ? ORDER BY `teacher_docs`.`".$sortby."` ".$direction." LIMIT ".$lowlim.", ".$perpg;
	 				 $sql2="SELECT * FROM teacher_docs WHERE teacher_id like '$uid' AND subject like '$narrow' ORDER BY `".$sortby."` ".$direction;
	 				 //$sql3="SELECT * FROM teacher_vod WHERE teacher_id like ? AND subject like ? ORDER BY ? ? LIMIT ?, ?";
	 				 $tot=mysqli_num_rows(mysqli_query($GLOBALS['conn'],$sql2));
	 				 if ($stmt = mysqli_prepare($GLOBALS['conn'],$sql3)) {

    					/* bind parameters for markers */
    			    	mysqli_stmt_bind_param($stmt, 'ss', $uid,$narrow);
    			    	$stat=mysqli_stmt_execute($stmt);
    			    	//echo $stat;
    			    	$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	mysqli_stmt_close($stmt);
						}
					 	else
					 	{
						echo "Failed";
						//session_destroy();
					 	}
					 if($stat == false)
					 {
					  	echo '<div class="alert alert-dark" role="alert">No Results</div>';
					 }

	 				}

   				 /* execute query */
    			
    			//echo (mysqli_num_rows($res));

   				 /* bind result variables */
   				// mysqli_stmt_bind_result($stmt, $ruid,$rpasswd);

   				 /* fetch value */
  				// mysqli_stmt_fetch($stmt);

    			/* store result */
   				 /* close statement */
   				// mysqli_stmt_close($stmt);
	 		
	 	}
	  }//end of safe input check
	 }//end of if custom_sub
	 else
	 {
	 					$tot=mysqli_num_rows(mysqli_query($GLOBALS['conn'],$sql2));
	 		 			if ($stmt = mysqli_prepare($GLOBALS['conn'],$sql3)) {

    					/* bind parameters for markers */
    			    	//mysqli_stmt_bind_param($stmt, 'ss', $uid,$narrow);
    			    	if($preres==0)
    			    	{
    			    		mysqli_stmt_bind_param($stmt, 's', $uid);
    			    	}
    			    	else
    			    	{
    			    		mysqli_stmt_bind_param($stmt, 'ss', $uid,$narrow);
    			    	}
    			    	$stat=mysqli_stmt_execute($stmt);
    			    	//echo $stat;
    			    	$res=mysqli_stmt_get_result($stmt);
    			    	//print_r($res);
    			    	mysqli_stmt_close($stmt);
						}
						else
						{
						echo "Failed";
						//session_destroy();
						}
						//echo $sql3."<br>";
						//echo $sql2;
						//print_r($res);
	 }

	 					$tot1=1;
						if(($pgno-5)>$tot1)
						{
							$tot1=$pgno-5;
						}
						$lim=(int)($tot/$perpg);
							if(($tot%$perpg)>0)
								$lim=$lim+1;
						$tot2=$lim;
						if(($pgno+5)<$lim)
						{
							$tot2=$pgno+5;
						}
						$_SESSION['doc']['pglim']=$lim;
						return array('res' =>$res ,'tot1'=>$tot1,'tot2'=>$tot2,'pgno'=>$pgno);

}



function printReqTable()
{
	$req_ret_arr=getReqTable();
	$req_res=$req_ret_arr['res'];
	$req_tot2=$req_ret_arr['tot2'];
	$req_tot1=$req_ret_arr['tot1'];
	$req_pgno=$req_ret_arr['pgno'];

///Search Panel -------  
	if ($req_res) {
  
  if(is_null($req_res))
    {
      echo '<div class="alert alert-dark" role="alert">No New Requests</div>';
    }
    else if(mysqli_num_rows($req_res)==0)
    {           
      echo '<div class="alert alert-dark" role="alert">No New Requests</div>';
    }
    else
    { 
echo <<<EOT
  <div class="table-responsive">
  <table class="table table-dark">
  <thead>
  <tr>
  <td><div class="form-check"><input type="checkbox" class="form-check-input" id="checkSel" onclick="requests.selectAll()"/></div></td>
  <th scope="col">Name</th>
  <th scope="col">Subject</th>
  <th scope="col">Date</th>
  <th scope="col">Email</th>
  </tr>
  </thead>
<tbody>
EOT;    
              while ($row=mysqli_fetch_array($req_res)) 
              {
               echo '<tr id ="'.$row[0].'row">';
               echo '<td><div class="form-check">
               <input onclick="requests.setSelect('.$row[0].')" name="rowsel" type="checkbox" class="form-check-input" value="'.$row[0].'" id="'.$row[0].'rowsel"></div></td>';
                 echo '<td scope="row" id ="'.$row[0].'name">'.$row['name'].'</td>';
                 echo '<td id ="'.$row[0].'subject">'.$row[4].'</td>';
                 echo '<td id ="'.$row[0].'date">'.$row[3].'</td>';
                 echo '<td id ="'.$row[0].'mail">'.$row[5].'</td>';
                 echo '<td><button id="'.$row[0].'" type="button" class="btn btn-success" onclick="requests.acceptPress(\''.$row[0].'\')">Accept</button></td>';
             echo '<td><button id="'.$row[0].'" type="button" class="btn btn-danger" onclick="requests.deletePress(\''.$row[0].'\')">Decline</button></td>';
              echo '</tr>';
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            echo '<div class="btn-group mb-2">';
            echo '<button type="button" class="btn btn-success m-1" onclick="requests.selectAccept()">Accept Selected</button>';
            echo '<button type="button" class="btn btn-danger m-1" onclick="requests.selectDelete()">Delete Selected</button>';
            echo "</div>";
            //<button type="button" class="btn btn-danger">Danger</button>
            //echo "</form>";
            echo '<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group mr-2" role="group" aria-label="First group">';
              echo '<button type="button" name="prevpg" class="btn btn-secondary mr-2" value="" onclick="requests.prevpg()">&lt&lt&lt</button>';

            while($req_tot1<=$req_pgno)
            {
              if($req_tot1!=$req_pgno)
              {
              echo '<button type="button" name="pgbt[]" class="btn btn-secondary" value="'.$req_tot1.'" onclick="requests.pgbt('.$req_tot1.')">'.$req_tot1.'</button>';
              }
              else
              {
              echo '<button type="button" name="pgbt[]" class="btn btn-success" value="'.$req_tot1.'" onclick="requests.pgbt('.$req_tot1.')">'.$req_tot1.'</button>';
              }

              $req_tot1=$req_tot1+1;

            }
            //echo $req_tot2." "$req_tot1." ".$pgno;
            //$req_tot1=$req_pgno;
            while($req_tot1<=$req_tot2)
            {
              if($req_tot2!=$req_pgno)
              {
              echo '<button type="button" name="pgbt[]" class="btn btn-secondary" value="'.$req_tot1.'" onclick="requests.pgbt('.$req_tot1.')">'.$req_tot1.'</button>';
              }
              else
              {
              echo '<button type="button" name="pgbt[]" class="btn btn-success" value="'.$req_tot1.'" onclick="requests.pgbt('.$req_tot1.')">'.$req_tot1.'</button>';
              }

              $req_tot1=$req_tot1+1;

            }
            echo '<button type="button" name="nextpg" class="btn btn-secondary ml-2" value="" onclick="requests.nextpg()">&gt&gt&gt</button>';

            echo '</div>';
            echo '</div>';

          }
 
      }
  }

function printDocTable()
{
	$doc_ret_arr=getDocTable();
	$res=$doc_ret_arr['res'];
	$tot2=$doc_ret_arr['tot2'];
	$tot1=$doc_ret_arr['tot1'];
	$pgno=$doc_ret_arr['pgno'];
	//echo "PAgeNO=".$pgno;
if ($res) {
	
	if(is_null($res))
		{
			echo '<div class="alert alert-dark" role="alert">No Documents Found</div>';
		}
		else if(mysqli_num_rows($res)==0)
		{						
			echo '<div class="alert alert-dark" role="alert">No Documents Found</div>';
		}
		else
		{	
echo <<<EOT
    <div class="table-responsive">
	<table class="table table-dark">
	<thead>
	<tr>
	<td><div class="form-check"><input type="checkbox" class="form-check-input" id="checkSel" onclick="selectAll()"/></div></td>
	<th scope="col">Name</th>
	<th scope="col">Subject</th>
	<th scope="col">Date</th>
	<th scope="col">Link</th>
	</tr>
	</thead>
<tbody>
EOT;		
    					while ($row=mysqli_fetch_row($res)) 
    					{
    					 echo '<tr id ="'.$row[0].'row">';
    					 echo '<td><div class="form-check">
   						 <input onclick="setSelect('.$row[0].')" name="rowsel" type="checkbox" class="form-check-input" value="'.$row[0].'" id="'.$row[0].'rowsel"></div></td>';
      					 echo '<td scope="row" id ="'.$row[0].'name">'.$row[2].'</td>';
      					 echo '<td id ="'.$row[0].'subject">'.$row[3].'</td>';
      					 echo '<td id ="'.$row[0].'date">'.$row[4].'</td>';
      					 echo '<td id ="'.$row[0].'link"><a target="_blank" href="doc_viewer.php?doc_id='.$row[0].'"> View Document</a></td>';
      					 echo '<td><button id="'.$row[0].'" type="button" class="btn btn-warning" onclick="editPress(\''.$row[0].'\')">Edit</button></td>';
						 echo '<td><button id="'.$row[0].'" type="button" class="btn btn-danger" onclick="deletePress(\''.$row[0].'\')">Delete</button></td>';
    					echo '</tr>';
						}
						echo "</tbody>";
						echo "</table>";
						echo "</div>";
						echo '<button type="button" class="btn btn-danger" onclick="selectDelete()">Delete Selected</button>';
						//<button type="button" class="btn btn-danger">Danger</button>
						//echo "</form>";
						echo '<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
  							<div class="btn-group mr-2" role="group" aria-label="First group">';
  						echo '<button type="button" name="prevpg" class="btn btn-secondary mr-2" value="" onclick="prevpg()">&lt&lt&lt</button>';

            while($tot1<=$pgno)
            {
              if($tot1!=$pgno)
              {
              echo '<button type="button" name="pgbt[]" class="btn btn-secondary" value="'.$tot1.'" onclick="pgbt('.$tot1.')">'.$tot1.'</button>';
              }
              else
              {
              echo '<button type="button" name="pgbt[]" class="btn btn-success" value="'.$tot1.'" onclick="pgbt('.$tot1.')">'.$tot1.'</button>';
              }

              $tot1=$tot1+1;

            }
            //echo $tot2." "$tot1." ".$pgno;
            //$tot1=$pgno;
            while($tot1<=$tot2)
            {
              if($tot2!=$pgno)
              {
              echo '<button type="button" name="pgbt[]" class="btn btn-secondary" value="'.$tot1.'" onclick="pgbt('.$tot1.')">'.$tot1.'</button>';
              }
              else
              {
              echo '<button type="button" name="pgbt[]" class="btn btn-success" value="'.$tot1.'" onclick="pgbt('.$tot1.')">'.$tot1.'</button>';
              }

              $tot1=$tot1+1;

            }
            echo '<button type="button" name="nextpg" class="btn btn-secondary ml-2" value="" onclick="nextpg()">&gt&gt&gt</button>';


						echo '</div>';
						echo '</div>';
}
}
}


function printVodTable()
{
	$vod_ret_arr=getVodTable();
	$res=$vod_ret_arr['res'];
	$tot2=$vod_ret_arr['tot2'];
	$tot1=$vod_ret_arr['tot1'];
	$pgno=$vod_ret_arr['pgno'];
	//echo "PAgeNO=".$pgno;
	if ($res) {
	
	if(is_null($res))
		{
			echo '<div class="alert alert-dark" role="alert">No Videos Found</div>';
		}
		else if(mysqli_num_rows($res)==0)
		{						
			echo '<div class="alert alert-dark" role="alert">No Videos Found</div>';
		}
		else
		{	
	echo <<<EOT
	<div class="table-responsive">
	<table class="table table-dark">
	<thead>
	<tr>
	<td><div class="form-check"><input type="checkbox" class="form-check-input" id="checkSel" onclick="selectAll()"/></div></td>
	<th scope="col">Name</th>
	<th scope="col">Subject</th>
	<th scope="col">Date</th>
	<th scope="col">Link</th>
	</tr>
	</thead>	
	<tbody>
	EOT;		
    					while ($row=mysqli_fetch_row($res)) 
    					{
    					 echo '<tr id ="'.$row[0].'row">';
    					 echo '<td><div class="form-check">
   						 <input onclick="setSelect('.$row[0].')" name="rowsel" type="checkbox" class="form-check-input" value="'.$row[0].'" id="'.$row[0].'rowsel"></div></td>';
      					 echo '<td scope="row" id ="'.$row[0].'name">'.$row[2].'</td>';
      					 echo '<td id ="'.$row[0].'subject">'.$row[3].'</td>';
      					 echo '<td id ="'.$row[0].'date">'.$row[4].'</td>';
      					 echo '<td id ="'.$row[0].'link">'.$row[5].'</td>';
      					 echo '<td><button id="'.$row[0].'" type="button" class="btn btn-warning" onclick="editPress(\''.$row[0].'\')">Edit</button></td>';
						 echo '<td><button id="'.$row[0].'" type="button" class="btn btn-danger" onclick="deletePress(\''.$row[0].'\')">Delete</button></td>';
    					echo '</tr>';
						}
	echo "</tbody>";
	echo "</table>";
						echo "</div>";
						echo '<button type="button" class="btn btn-danger" onclick="selectDelete()">Delete Selected</button>';
						//<button type="button" class="btn btn-danger">Danger</button>
						//echo "</form>";
						echo '<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
  							<div class="btn-group mr-2" role="group" aria-label="First group">';
  						echo '<button type="button" name="prevpg" class="btn btn-secondary mr-2" value="" onclick="prevpg()">&lt&lt&lt</button>';

            while($tot1<=$pgno)
            {
              if($tot1!=$pgno)
              {
              echo '<button type="button" name="pgbt[]" class="btn btn-secondary" value="'.$tot1.'" onclick="pgbt('.$tot1.')">'.$tot1.'</button>';
              }
              else
              {
              echo '<button type="button" name="pgbt[]" class="btn btn-success" value="'.$tot1.'" onclick="pgbt('.$tot1.')">'.$tot1.'</button>';
              }

              $tot1=$tot1+1;

            }
            //echo $tot2." "$tot1." ".$pgno;
            //$tot1=$pgno;
            while($tot1<=$tot2)
            {
              if($tot2!=$pgno)
              {
              echo '<button type="button" name="pgbt[]" class="btn btn-secondary" value="'.$tot1.'" onclick="pgbt('.$tot1.')">'.$tot1.'</button>';
              }
              else
              {
              echo '<button type="button" name="pgbt[]" class="btn btn-success" value="'.$tot1.'" onclick="pgbt('.$tot1.')">'.$tot1.'</button>';
              }

              $tot1=$tot1+1;

            }
            echo '<button type="button" name="nextpg" class="btn btn-secondary ml-2" value="" onclick="nextpg()">&gt&gt&gt</button>';


						echo '</div>';
						echo '</div>';
}
}
}


function getCouTable()
{
  $uid=$_SESSION['email'];
  $res;
  $preres=0;
   if(!isset($_SESSION['cou']['sorter']))
    $_SESSION['cou']['sorter']="";
   if(!isset($_SESSION['cou']['orderer']))
    $_SESSION['cou']['orderer']="";
   if(!isset($_SESSION['cou']['narrower']))
    $_SESSION['cou']['narrower']="";
   if(!isset($_SESSION['cou']['perpg']))
    $_SESSION['cou']['perpg']=3;
   if(!isset($_SESSION['cou']['pgno']))
    $_SESSION['cou']['pgno']="1";
   if(isset($_POST['pgbt']))
   {
    //print_r($_POST['pgbt']);
    //prin($_POST['pgbt']);
    $_SESSION['cou']['pgno']=(int)$_POST['pgbt'][0];
   }

   if(isset($_POST['nextpg']))
   {
    if($_SESSION['cou']['pgno']<$_SESSION['cou']['pglim'])
    {
    $_SESSION['cou']['pgno']=$_SESSION['cou']['pgno']+1;
    //echo $_SESSION['cou']['pgno'];
    }
   }

   if(isset($_POST['prevpg']))
   {
    if($_SESSION['cou']['pgno']>1)
    {
      $_SESSION['cou']['pgno']=$_SESSION['cou']['pgno']-1;
      //echo $_SESSION['cou']['pgno'];
    }
   }

          $sortby="course_date";
          $direction="ASC";
          $pgno=1;
          $perpg=3;
            if(isset($_SESSION['cou']['pgno']))
          { 
          //print_r($_POST['pgbt']);
          //prin($_POST['pgbt']);
          $pgno=(int)$_SESSION['cou']['pgno'];
          }
          $tot;
          //$tot=mysqli_num_rows(mysqli_query());
          //$num_page=0;
          $narrow="NA";
          if(isset($_SESSION['custom_fields_cou']))
          {
              $sortby=$_SESSION['cou']['sorter'];
              $direction=$_SESSION['cou']['orderer'];
              $perpg=(int)$_SESSION['cou']['perpg'];
              $narrow=$_SESSION['cou']['narrower'];
              //$pgno=(int)$_SESSION['cou']['pgno'];

          }
          $highlim=(int)$pgno*(int)$perpg;
          $lowlim=(int)$highlim - (int)$perpg;
          $sortby_arr=array('name','course_date','subject');
          $perpg_arr=array('3','5','10','20','30');
          $direction_arr=array('ASC','DESC');
          $narrower_arr=getSubject();
          array_push($narrower_arr, "NA","Others");
          //getSubjectVod();
          //print_r($narrower_arr);
          //echo 'ASDASD1';
          //$narrower_arr=array_merge_recursive($narrower_arr,$g_array);
          $sql3="SELECT * FROM teacher_course WHERE teacher_id=? ORDER BY `teacher_course`.`".$sortby."` $direction LIMIT $lowlim, $perpg";//default_custom
          $sql2="SELECT * FROM teacher_course WHERE teacher_id='$uid' ORDER BY 'course_date'";

          if($narrow!="NA")
          {
              if(!in_array($narrow, $narrower_arr))
             $preres=0;
            else
            {
             $preres=1;
            $sql3="SELECT * FROM teacher_course WHERE teacher_id like ? AND subject like ? ORDER BY `teacher_course`.`".$sortby."` ".$direction." LIMIT ".$lowlim.", ".$perpg;
            $sql2="SELECT * FROM teacher_course WHERE teacher_id like '$uid' AND subject like '$narrow' ORDER BY `teacher_course`.`".$sortby."` ".$direction;
            }
          }
          
          if(isset($_POST['custom_sub_cou']))
          {
            //echo 'Custom_sub';
          $sortby=$_POST['sorter'];
          $direction=$_POST['orderer'];
          $perpg=(int)$_POST['perpg'];
          //$pgno=(int)$_SESSION['cou']['$pgno'];
          $pgno=1;
          $highlim=(int)$pgno*(int)$perpg;
          $narrow=$_POST['narrower'];
          $_SESSION['custom_fields_cou']=1;
          $_SESSION['cou']['sorter']=$_POST['sorter'];
          $_SESSION['cou']['orderer']=$_POST['orderer'];
          $_SESSION['cou']['perpg']=$_POST['perpg'];
          $_SESSION['cou']['narrower']=$_POST['narrower'];
          //$_SESSION['cou']['pgno']=(int)$pgno;
          $_SESSION['cou']['pgno']=1;
          $lowlim=(int)$highlim - (int)$perpg;
          $safe_input=1;
          if(!in_array($sortby, $sortby_arr))
            $safe_input=0;
          if(!in_array($perpg, $perpg_arr))
            $safe_input=0;
          if(!in_array($direction, $direction_arr))
            $safe_input=0;
          if(!in_array($narrow, $narrower_arr))
            $safe_input=0;
          //echo $safe_input.$sortby.$perpg.$direction.$narrow;
          //echo array_search($narrow, $narrower_arr);
          if($safe_input===1)
          {
          if(isset($_POST['narrower']))
          {
           if($_POST['narrower']=='NA')
           {
           //echo "$narrow";
             $sql3="SELECT * FROM teacher_course WHERE teacher_id= ? ORDER BY `teacher_course`.`".$sortby."` ".$direction." LIMIT ".$lowlim.", ".$perpg;
             $sql2="SELECT * FROM teacher_course WHERE teacher_id='$uid' ORDER BY `teacher_course`.`".$sortby."` ".$direction;
             $tot=mysqli_num_rows(mysqli_query($GLOBALS['conn'],$sql2));
             //$sql3="SELECT * FROM teacher_course WHERE teacher_id like ? ORDER BY ? ? LIMIT ?, ?";
             //echo "ADSAD";
               if ($stmt = mysqli_prepare($GLOBALS['conn'],$sql3)) {
                //echo "Asdasd";
              /* bind parameters for markers */
                mysqli_stmt_bind_param($stmt, 's', $uid);
                $stat=mysqli_stmt_execute($stmt);
                //echo $stat;
                $res=mysqli_stmt_get_result($stmt);
                //print_r($res);
                mysqli_stmt_close($stmt);
            }
            else
            {
            echo "Failed";
            //session_destroy();
            }

           }
           else
           {
           //echo "$narrow";
           $sql3="SELECT * FROM teacher_course WHERE teacher_id like ? AND subject like ? ORDER BY `teacher_course`.`".$sortby."` ".$direction." LIMIT ".$lowlim.", ".$perpg;
           $sql2="SELECT * FROM teacher_course WHERE teacher_id like '$uid' AND subject like '$narrow' ORDER BY `".$sortby."` ".$direction;
           //$sql3="SELECT * FROM teacher_course WHERE teacher_id like ? AND subject like ? ORDER BY ? ? LIMIT ?, ?";
           $tot=mysqli_num_rows(mysqli_query($GLOBALS['conn'],$sql2));
           if ($stmt = mysqli_prepare($GLOBALS['conn'],$sql3)) {

              /* bind parameters for markers */
                mysqli_stmt_bind_param($stmt, 'ss', $uid,$narrow);
                $stat=mysqli_stmt_execute($stmt);
                //echo $stat;
                $res=mysqli_stmt_get_result($stmt);
                //print_r($res);
                mysqli_stmt_close($stmt);
            }
            else
            {
            echo "Failed";
            //session_destroy();
            }
           if($stat == false)
           {
              echo '<div class="alert alert-dark" role="alert">No Results</div>';
           }

          }

           /* execute query */
          
          //echo (mysqli_num_rows($res));

           /* bind result variables */
          // mysqli_stmt_bind_result($stmt, $ruid,$rpasswd);

           /* fetch value */
          // mysqli_stmt_fetch($stmt);

          /* store result */
           /* close statement */
          // mysqli_stmt_close($stmt);
      
    }
    }//end of safe input check
   }//end of if custom_sub
   else
   {
            $tot=mysqli_num_rows(mysqli_query($GLOBALS['conn'],$sql2));
            if ($stmt = mysqli_prepare($GLOBALS['conn'],$sql3)) {

              /* bind parameters for markers */
                //mysqli_stmt_bind_param($stmt, 'ss', $uid,$narrow);
                if($preres==0)
                {
                  mysqli_stmt_bind_param($stmt, 's', $uid);
                }
                else
                {
                  mysqli_stmt_bind_param($stmt, 'ss', $uid,$narrow);
                }
                $stat=mysqli_stmt_execute($stmt);
                //echo $stat;
                $res=mysqli_stmt_get_result($stmt);
                //print_r($res);
                mysqli_stmt_close($stmt);
            }
            else
            {
            echo "Failed";
            //session_destroy();
            }
            //echo $sql3."<br>";
            //echo $sql2;
            //print_r($res);
   }
            $tot1=1;
            if(($pgno-5)>$tot1)
            {
              $tot1=$pgno-5;
            }
            $lim=(int)($tot/$perpg);
              if(($tot%$perpg)>0)
                $lim=$lim+1;
            $tot2=$lim;
            if(($pgno+5)<$lim)
            {
              $tot2=$pgno+5;
            }
            $_SESSION['cou']['pglim']=$lim;
            return array('res' =>$res ,'tot1'=>$tot1,'tot2'=>$tot2,'pgno'=>$pgno);

}


function printCouTable()
{
  $cou_ret_arr=getCouTable();
  $res=$cou_ret_arr['res'];
  $tot2=$cou_ret_arr['tot2'];
  $tot1=$cou_ret_arr['tot1'];
  $pgno=$cou_ret_arr['pgno'];


    ///Search Panel -------  
if ($res) {
  
  if(is_null($res))
    {
      echo '<div class="alert alert-info" role="alert">No Courses Created!</div>';
    }
    else if(mysqli_num_rows($res)==0)
    {           
      echo '<div class="alert alert-info" role="alert">No Courses Created!</div>';
    }
    else
    { 
echo <<<EOT
    <div class="table-responsive">
  <table class="table table-dark">
  <thead>
  <tr>
  <td><div class="form-check"><input type="checkbox" class="form-check-input" id="checkSel" onclick="selectAll()"/></div></td>
  <th scope="col">Name</th>
  <th scope="col">Subject</th>
  <th scope="col">Date</th>
  <th scope="col">Status</th>
  </tr>
  </thead>
<tbody>
EOT;    
              while ($row=mysqli_fetch_row($res)) 
              {
               echo '<tr id ="'.$row[0].'row">';
               echo '<td><div class="form-check">
               <input onclick="setSelect('.$row[0].')" name="rowsel" type="checkbox" class="form-check-input" value="'.$row[0].'" id="'.$row[0].'rowsel"></div></td>';
                 echo '<td scope="row" id ="'.$row[0].'name">'.$row[2].'</td>';
                 echo '<td id ="'.$row[0].'subject">'.$row[3].'</td>';
                 echo '<td id ="'.$row[0].'date">'.$row[4].'</td>';
                 echo '<td id ="'.$row[0].'status">'.$row[5].'</td>';
                 echo '<td><button id="'.$row[0].'" type="button" class="btn btn-warning" onclick="editPress(\''.$row[0].'\')">Edit</button></td>';
             echo '<td><button id="'.$row[0].'" type="button" class="btn btn-danger" onclick="deletePress(\''.$row[0].'\')">Delete</button></td>';
              echo '</tr>';
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            echo '<button type="button" class="btn btn-danger" onclick="selectDelete()">Delete Selected</button>';
            //<button type="button" class="btn btn-danger">Danger</button>
            //echo "</form>";
            echo '<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group mr-2" role="group" aria-label="First group">';
              echo '<button type="button" name="prevpg" class="btn btn-secondary mr-2" value="" onclick="prevpg()">&lt&lt&lt</button>';

            while($tot1<=$pgno)
            {
              if($tot1!=$pgno)
              {
              echo '<button type="button" name="pgbt[]" class="btn btn-secondary" value="'.$tot1.'" onclick="pgbt('.$tot1.')">'.$tot1.'</button>';
              }
              else
              {
              echo '<button type="button" name="pgbt[]" class="btn btn-success" value="'.$tot1.'" onclick="pgbt('.$tot1.')">'.$tot1.'</button>';
              }

              $tot1=$tot1+1;

            }
            //echo $tot2." "$tot1." ".$pgno;
            //$tot1=$pgno;
            while($tot1<=$tot2)
            {
              if($tot2!=$pgno)
              {
              echo '<button type="button" name="pgbt[]" class="btn btn-secondary" value="'.$tot1.'" onclick="pgbt('.$tot1.')">'.$tot1.'</button>';
              }
              else
              {
              echo '<button type="button" name="pgbt[]" class="btn btn-success" value="'.$tot1.'" onclick="pgbt('.$tot1.')">'.$tot1.'</button>';
              }

              $tot1=$tot1+1;

            }
            echo '<button type="button" name="nextpg" class="btn btn-secondary ml-2" value="" onclick="nextpg()">&gt&gt&gt</button>';

            echo '</div>';
            echo '</div>';
          }
 
      }
}



?>