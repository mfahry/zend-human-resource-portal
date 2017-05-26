<?php
session_start();
require_once("../dbsconf/DbConnect.php"); 
global $CONN;

$sid=$_POST['schid'];
$frm=$_POST['frm'];
$act=$_POST['act'];
$sname=$_POST['sname'];
$pendidikan=$_POST['pendidikan'];
$Deskripsi1=$_POST['Deskripsi1'];
$syear=$_POST['year'];
$syearend=$_POST['yearend'];
$kotapendidikan=$_POST['kotapendidikan'];

$compid=$_POST['compid'];
$Perusahaan=$_POST['Perusahaan'];
$jobspecification=$_POST['jobspecification'];
$Deskripsi2=$_POST['Deskripsi2'];
$yearhire=$_POST['yearhire'];
$yearhireend=$_POST['yearhireend'];
$KotaSpesifikasi=$_POST['KotaSpesifikasi'];

$skillid=$_POST['skillid'];
$skill=$_POST['skill'];

$otherjobid=$_POST['otherjobid'];
$otherjob=$_POST['pekerjaan'];
#for feedback
$descfb=$_POST['descfb'];
$fbid=$_POST['fbid'];


if($frm=='edu'){
	if($act=='add'){
			$query 	= "INSERT INTO school(user_id, school_name, city, school_year, school_yearend, education, description) 
						VALUES('".$_SESSION['userid']."', '".$sname."','".$kotapendidikan."','".$syear."','".$syearend."','".$pendidikan."','".$Deskripsi1."')";
			
			$rs = $CONN->Execute($query);
						
			if($rs) echo "ok";
			else echo mysql_error();
	}elseif($act=='edit'){
		
			$query 	= "UPDATE school SET school_name = '".$sname."', city  = '".$kotapendidikan."', school_year = '".$syear."',  school_yearend='".$syearend."', education = '".$pendidikan."', description = '".$Deskripsi1."' 
						WHERE user_id='".$_SESSION['userid']."' and school_id = '". $sid."' ";
			
			$rs = $CONN->Execute($query);
						
			if($rs) echo "ok";
			else echo mysql_error();
			
	}elseif($act=='del'){
			$query 	= "DELETE FROM school WHERE user_id='".$_SESSION['userid']."' and school_id = '". $sid."' ";
			
			$rs = $CONN->Execute($query);
			if($rs) echo "ok";
			else echo mysql_error();
	}
}elseif($frm=='exp'){
		if($act=='add'){
				$query 	= "INSERT INTO company(user_id, company_name, city, company_year, end_year, working_position, project) 
							VALUES('".$_SESSION['userid']."', '".$Perusahaan."','".$KotaSpesifikasi."','".$yearhire."', '".$yearhireend."', '".$jobspecification."','".$Deskripsi2."')";
				
				$rs = $CONN->Execute($query);
							
				if($rs) echo "ok";
				else echo mysql_error();
		}elseif($act=='edit'){
			
				$query 	= "UPDATE company SET company_name = '".$Perusahaan."', city  = '".$KotaSpesifikasi."', company_year = '".$yearhire."', end_year = '".$yearhireend."',  working_position = '".$jobspecification."', project = '".$Deskripsi2."'
							 where user_id='".$_SESSION['userid']."' AND company_id = '".$compid."' ";
				//echo $query;					
				$rs = $CONN->Execute($query);
							
				if($rs) echo "ok";
				else echo mysql_error();
				
		}elseif($act=='del'){
				$query 	= "DELETE FROM company WHERE user_id='".$_SESSION['userid']."' and company_id = '".$compid."' ";
				
				$rs = $CONN->Execute($query);
				if($rs) echo "ok";
				else echo mysql_error();
		}
}elseif($frm=='oth'){
		if($act=='add'){
				$query 	= "INSERT INTO additional_profesional_activities(user_id, other_job) 
							VALUES('".$_SESSION['userid']."', '".$otherjob."')";
				
				$rs = $CONN->Execute($query);
							
				if($rs) echo "ok";
				else echo mysql_error();
		}elseif($act=='edit'){
			
				$query 	= "UPDATE additional_profesional_activities SET other_job = '".$otherjob."' 
							WHERE user_id='".$_SESSION['userid']."' AND add_activities_id = '".$otherjobid."' ";
				//echo	$query;				
				$rs = $CONN->Execute($query);
							
				if($rs) echo "ok";
				else echo mysql_error();
				
		}elseif($act=='del'){
				$query 	= "DELETE FROM additional_profesional_activities WHERE user_id='".$_SESSION['userid']."' and add_activities_id = '".$otherjobid."' ";
				
				$rs = $CONN->Execute($query);
				if($rs) echo "ok";
				else echo mysql_error();
		}
}elseif($frm=='skll'){
		if($act=='add'){
				$query 	= "INSERT INTO skill(user_id, skill_desc) 
							VALUES('".$_SESSION['userid']."', '".$skill."')";
				
				$rs = $CONN->Execute($query);
							
				if($rs) echo "ok";
				else echo mysql_error();
		}elseif($act=='edit'){
			
				$query 	= "UPDATE skill SET skill_desc = '".$skill."' WHERE user_id='".$_SESSION['userid']."' AND skill_id = '".$skillid."' ";
									
				$rs = $CONN->Execute($query);
							
				if($rs) echo "ok";
				else echo mysql_error();
				
		}elseif($act=='del'){
				$query 	= "DELETE FROM skill WHERE user_id='".$_SESSION['userid']."' and skill_id = '".$skillid."' ";
				
				$rs = $CONN->Execute($query);
				if($rs) echo "ok";
				else echo mysql_error();
		}
}elseif($frm=='feedback'){
	if($act=='add'){
			$query 	= "INSERT INTO feedback (fb_desc, input_by, input_dtm) 
						VALUES ('".$descfb."', '".(isset($_SESSION['userid']) ? $_SESSION['userid']:'guest')."', now())";
			//echo $query;
			$rs = $CONN->Execute($query);
			//echo $rs;			
			if($rs) echo "ok";
			else echo mysql_error();
			
	}else if ($act=='del'){
			$query 	= "UPDATE feedback SET `Status` = '1' WHERE feedback_id =$fbid";
			//echo $query;
			$rs = $CONN->Execute($query);
			//echo $rs;			
			if($rs) echo "ok";
			else echo mysql_error();
	}
}				
?>