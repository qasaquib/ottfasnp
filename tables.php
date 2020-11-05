<?php
require_once('server.php');
function getForTable()
{
	 if(!isset($_SESSION['for']['sorter']))
	 	$_SESSION['for']['sorter']="ABC";
	 //echo "ABCDEF";
	 //echo $_SESSION['for']['sorter'];
	 if(!isset($_SESSION['for']['orderer']))
	 	$_SESSION['for']['orderer']="";
	 if(!isset($_SESSION['for']['narrower']))
	 	$_SESSION['for']['narrower']="";
	 if(!isset($_SESSION['for']['perpg']))
	 	$_SESSION['for']['perpg']=3;
	 if(!isset($_SESSION['for']['pgno']))
	 	$_SESSION['for']['pgno']="1";
	 if(isset($_POST['pgbt']))
	 {
	 	//print_r($_POST['pgbt']);
	 	//prin($_POST['pgbt']);
	 	$_SESSION['for']['pgno']=(int)$_POST['pgbt'][0];
	 }

	 if(isset($_POST['nextpg']))
	 {
	 	if($_SESSION['for']['pgno']<$_SESSION['for']['pglim'])
	 	{
	 	$_SESSION['for']['pgno']=$_SESSION['for']['pgno']+1;
	 	//echo $_SESSION['for']['pgno'];
	 	}
	 }

	 if(isset($_POST['prevpg']))
	 {
	 	if($_SESSION['for']['pgno']>1)
	 	{
	 		$_SESSION['for']['pgno']=$_SESSION['for']['pgno']-1;
	 		//echo $_SESSION['for']['pgno'];
	 	}
	 }


	 $sortby="topic_date";
	 $direction="ASC";
	 $pgno=1;
	 	if(isset($_SESSION['for']['pgno']))
	 	{	
	 	//print_r($_POST['pgbt']);
	 	//prin($_POST['pgbt']);
	 	$pgno=(int)$_SESSION['for']['pgno'];
	 	}
	 	else
	 	{
	 				$_SESSION['for']['pgno']=1;
	 	}
	 $perpg=5;
	 $narrow="NA";
	 $highlim=(int)$pgno*(int)$perpg;
	 $lowlim=(int)$highlim - (int)$perpg;
	 $sql2="SELECT * FROM forum_topics ORDER BY topic_cat ASC LIMIT ".$lowlim.", ".$perpg;//default_custom
	 $sql3="SELECT * FROM forum_topics ORDER BY topic_cat ASC";
	 $tot;
	 if(isset($_SESSION['custom_fields_for']))
	 {
	 	//echo "SET ALL";
	 	$sortby=$_SESSION['for']['sorter'];
	 	$direction=$_SESSION['for']['orderer'];
	 	$perpg=(int)$_SESSION['for']['perpg'];
	 	$narrow=$_SESSION['for']['narrower'];
	 	$highlim=(int)$pgno*(int)$perpg;
	 	$lowlim=(int)$highlim - (int)$perpg;

	 			if($_SESSION['for']['narrower']=='NA')
	 			{
	 			$sql3="SELECT * FROM forum_topics ORDER BY ".$sortby." ".$direction." LIMIT ".$lowlim.", ".$perpg;
	 			$sql2=$sql3;
	 			$sql3="SELECT * FROM forum_topics ORDER BY ".$sortby." ".$direction;
	 			}
	 			else
	 			{
	 			$sql3="SELECT * FROM forum_topics WHERE topic_cat like '".$narrow."' ORDER BY ".$sortby." ".$direction." LIMIT ".$lowlim.", ".$perpg;
	 			$sql2=$sql3;
	 			$sql3="SELECT * FROM forum_topics WHERE topic_cat like '".$narrow."' ORDER BY ".$sortby." ".$direction;
	 			}
	 	//$pgno=(int)$_SESSION['for']['pgno'];
	 }

	 $sortby_arr=array('topic_desc_short','topic_date','subject');
	 $perpg_arr=array('3','5','10','20','30');
	 $direction_arr=array('ASC','DESC');
	 $narrower_arr=getSubject();
	 array_push($narrower_arr, "NA","Others");
	 //getSubjectVod();
	 if(isset($_POST['custom_sub_for']))
	 {
	 	$sortby=$_POST['sorter'];
	 	$direction=$_POST['orderer'];
	 	$perpg=$_POST['perpg'];
	 	$narrow=$_POST['narrower'];
		$pgno=1;
		$highlim=(int)$pgno*(int)$perpg;		
		$_SESSION['custom_fields_for']=1;
		$_SESSION['for']['sorter']=$_POST['sorter'];
		$_SESSION['for']['orderer']=$_POST['orderer'];
		$_SESSION['for']['perpg']=$_POST['perpg'];
		$_SESSION['for']['narrower']=$_POST['narrower'];
		$_SESSION['for']['pgno']=1;
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
	 	if($safe_input===1)
	 	{
	 		if(isset($_POST['narrower']))
	 		{
	 			if($_POST['narrower']=='NA')
	 			{
	 			$sql3="SELECT * FROM forum_topics ORDER BY ".$sortby." ".$direction." LIMIT ".$lowlim.", ".$perpg;
	 			$sql2=$sql3;
	 			$sql3="SELECT * FROM forum_topics ORDER BY ".$sortby." ".$direction;
	 			}
	 			else
	 			{
	 			$sql3="SELECT * FROM forum_topics WHERE topic_cat like '".$narrow."' ORDER BY ".$sortby." ".$direction." LIMIT ".$lowlim.", ".$perpg;
	 			$sql2=$sql3;
	 			$sql3="SELECT * FROM forum_topics WHERE topic_cat like '".$narrow."' ORDER BY ".$sortby." ".$direction;
	 			}
	 		}
	 	}
	 }
	 					//echo $sql3."<br/>".$sql2;
	 					$tot=mysqli_num_rows(mysqli_query($GLOBALS['conn'],$sql3));
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
						$_SESSION['for']['pglim']=$lim;
						return array('tot1'=>$tot1,'tot2'=>$tot2,'pgno'=>$pgno,'sql2'=>$sql2);

}

function printForTable()
{
	$for_ret_arr=getForTable();
	$sql2=$for_ret_arr['sql2'];
	$tot2=$for_ret_arr['tot2'];
	$tot1=$for_ret_arr['tot1'];
	$pgno=$for_ret_arr['pgno'];
		echo '<div class="row">';
		echo '<div class="col mx-auto  mb-4">';
		echo '<h3 class="res-h3" id="custom-search-section">Custom Search</h3>';
		//echo $sql2;
		//echo $sql3;					
			 if ($result = mysqli_query($GLOBALS['conn'], $sql2)) {
	
			 		if(is_null($result))
					{
						echo '<div class="alert alert-dark" role="alert">No Threads3</div>';
					}
					else if(mysqli_num_rows($result)==0)
					{						
						echo '<div class="alert alert-dark" role="alert">No Threads</div>';
					}
					else
					{	
echo <<<EOT
	<div class="table-responsive">
	<table class="table table-dark">
	<thead>
	<tr>
	<th scope="col">Topic</th>
	<th scope="col">Category</th>
	<th scope="col">Date</th>
	<th scope="col">Answers</th>
	<th scope="col">Status</th>
	</tr>
	</thead>
<tbody>
EOT;		
    					while ($row=mysqli_fetch_row($result)) 
    					{
    					 echo '<tr>';
      					 echo '<th scope="row"><a href="forum.php?did='.$row[0].'">'.$row[9].'</a></th>';
      					 if($row[8]==NULL)
      					 	$status="NOT SOLVED";
      					 else
      					 	$status="SOLVED";
      					 echo '<td>'.$row[3].'</td>';
      					 echo '<td>'.$row[4].'</td>';
      					 echo '<td>'.$row[7].'</td>';
      					 echo '<td>'.$status.'</td>';
    					 echo '</tr>';
    					echo '</tr>';
						}
						echo "</tbody>";
						echo "</table>";
						echo "</div>";

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
				else
				{
					echo '<div class="alert alert-dark" role="alert">No Threads</div>';
				}
}
?>