<?php
class Course
{
	private $dbh;
	private $email;
	private $error=false;
	private $info;
	private $subjectArray;
	private $examArray;
	public function __construct($email,$subjectArray,$examArray)
	{
		try
		{
		$this->dbh = new PDO("mysql:host=localhost;dbname=teacher_finder;", "root", "");
		$this->email=$email;
		$this->subjectArray=$subjectArray;
		$this->examArray=$examArray;
		}
		catch (Exception $e) {
  		die("Unable to connect: " . $e->getMessage());
		}
	}

	public function getCourseData($course_id)
	{
		//echo "Fetching Course Data";
		$date=date("Y-m-d H:i:s");
		$doc_array;
		$vod_array;
		//$course_name = $arr['course_name'];
		$email=$this->email;
		try
		{
		$stmt=$this->dbh->query("SELECT * FROM `teacher_module_doc` UNION SELECT * from `teacher_module_vod` WHERE teacher_module_vod.course_id='$course_id' ORDER BY week_no ASC, position ASC");
		return $stmt;
		}
		catch(Exception $e)
		{
			echo($e->getMessage());
			return false;
		}
		
	}

	public function writeCourseData($arr)
	{
		if(!isset($arr['course_name']) || empty($arr['course_name']))
		{
			$this->error=true;
			$this->info="Course Name not filled out!";
			return array('error' =>$this->error ,'info'=>$this->info);
		}
		if(!isset($arr['course_weeks']) || empty($arr['course_weeks']))
		{
			$this->error=true;
			$this->info="Number of Weeks not filled out";
			return array('error' =>$this->error ,'info'=>$this->info);
		}
		if(!isset($arr['subject']) || empty($arr['subject']))
		{
			$this->error=true;
			$this->info="subject not filled out";
			return array('error' =>$this->error ,'info'=>$this->info);
		}
		else if(!in_array($arr['subject'], $this->subjectArray))
		{
			$this->error=true;
			$this->info="subject not filled out";
			return array('error' =>$this->error ,'info'=>$this->info);
		}

		if(!isset($arr['course_assoc']))
		{
			$this->error=true;
			$this->info="Course Exam not filled out";
			return array('error' =>$this->error ,'info'=>$this->info);
		}
		else if(!in_array($arr['course_assoc'], $this->examArray))
		{
			if($arr['course_assoc']!="")
			{
			$this->error=true;
			$this->info="Course Exam not filled out";
			return array('error' =>$this->error ,'info'=>$this->info);
			}
		}

		$length = (int)$arr['course_weeks'];
		$validLength = array(4,6, 8,10, 12,14, 16,18, 20,22 ,24);
		echo  "Writing Course Data";
		if(in_array($length,$validLength))
		{
			for($i =1; $i <= $length; $i++)
			{
			 if(!isset($arr['wk'.$i]) || empty($arr['wk'.$i]))
			 {
			  //echo "Error"." Cannot Find wk".$i;
			  $this->error=true;
			  $this->info="Week ".$i." not filled";
			  return array('error' =>$this->error ,'info'=>$this->info);
			 }
			//print_r($_POST['wk'.$i]);
			//echo "<br/>";
			}
	
		}
		else
		{
			$this->error=true;
			$this->info="Invalid Course Length!";
			return array('error' =>$this->error ,'info'=>$this->info);
		}
		$this->error=!($this->startTransact($arr));
		if($this->error === false)
		{
			$this->info="Success!";
		}
		else
		{
			$this->info="An Error has occured!";

		}
		return array('error' =>$this->error ,'info'=>$this->info);
	}

	public function showId()
	{
		echo $this->email;
	}

	protected function startTransact($arr)
	{
		print_r($arr);
		//echo 'ABC';
		$rand=mt_rand(0,99999999999999);
		$date=date("Y-m-d H:i:s");
		$pub='PUBLISHED';
		$course_name = $arr['course_name'];
		$email=$this->email;
		$subject=$arr['subject'];
		$num_weeks=$arr['course_weeks'];
		$exam=$arr['course_assoc'];
		if($exam=="")
			$exam=NULL;
		try
		{
		$this->dbh->beginTransaction();
		$stmt=$this->dbh->exec("INSERT INTO teacher_course VALUES ('$rand','$email','$course_name','$subject','$date','PUBLISHED','$num_weeks','$exam')");
		
			if($stmt==0)
			{
			throw new Exception("Course Data Insertion Failed", 1);
			
			}
			for($i=1;$i<=(int)$arr['course_weeks'];$i++)
			{
				//echo $i.$arr['course_weeks'];
				//print_r($arr['wk'.$i.'']);
				for($j=0;$j<count($arr['wk'.$i.'']);$j++)
				{
					
					$week="wk".$i;
					$data=$arr[$week][$j];
					$type="";
					$mat_id="";
					if(strlen(strrpos($arr[$week][$j],'vod')) > strlen(strrpos($arr[$week][$j],'doc')))
					{
						$type="vod";
						$mat_id=substr($arr[$week][$j],0,strrpos($arr[$week][$j],'vod'));
						$result=$this->dbh->query("SELECT COUNT(*) FROM teacher_vod where teacher_id = '$this->email' and id = '$mat_id'");
						$result=$result->fetchColumn();
						if($result==0)
						{
							throw new Exception("Data Error Contact Support", 3);
						}	
					}
					else
					{
						$type="doc";
						$mat_id=substr($arr[$week][$j],0,strrpos($arr[$week][$j],'doc'));
						$result=$this->dbh->query("SELECT COUNT(*) FROM teacher_docs where teacher_id = '$this->email' and id = '$mat_id'");
						$result=$result->fetchColumn();
						if($result==0)
						{
							throw new Exception("Data Error Contact Support", 3);
						}
					}
					$stmt=$this->dbh->exec("INSERT INTO `teacher_module_$type` VALUES ('$rand','$week','$j','$mat_id','$type')");	
					if($stmt==0)
					{
						throw new Exception("Course Material Data Insertion Failed", 2);
					}
				}// Add material data
			}
			$this->dbh->commit();
			return true;
		}
		catch(Exception $e)
		{
			echo($e->getMessage());
			$this->dbh->rollBack();
			return false;
		}
		
	}
}//end of class
?>