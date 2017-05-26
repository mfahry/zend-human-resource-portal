<?php
session_start();
?>

<div id="window_cv_education" class="window" style="display:block;overflow:hidden;">
<script src="includes/js/validasi.js"></script>
<form action="" method="post" style="padding:15px;overflow:hidden;" id="winEditCvEdu">
<?php
require_once("../dbsconf/DbConnect.php"); 
global $CONN;

$sid=$_GET['schid'];
$cid=$_GET['compid'];
$skid=$_GET['skillid'];
$oid=$_GET['otherjobid'];
$frm=$_GET['frm'];
$act=$_GET['act'];


if($frm=="edu"){
	if($act=="edit"){

	$query0="SELECT a.name as nama,a.email,
				c.school_id as schoolid,c.school_name as sname, c.school_year AS syear, c.school_yearend AS syear_end, c.education, c.description, c.city as educity				
				FROM user a JOIN school c ON c.user_id = a.user_id				
				WHERE a.user_id ='".$_SESSION['userid']."' and c.school_id='".$sid."'";//nantinya pake session id
	$datauser0   = $CONN->Execute($query0);
	
	$dataU0 = $datauser0->FetchNextObject();
	$curid		= $dataU0->CV_ID;
	$schid		= $dataU0->SCHOOLID;
	$schly	 	= $dataU0->SYEAR;
	$schlyend 	= $dataU0->SYEAR_END;	
	$sname	 	= $dataU0->SNAME;
	$education	= $dataU0->EDUCATION;
	$desc		= $dataU0->DESCRIPTION;
	$educity	= $dataU0->EDUCITY;
	
	}

?>
<table>    
   <tr valign="top">
        <td width="100"><label>Sekolah</label></td>
        <td>:</td>
        <td><textarea name="sname" id="sname" class="disabled2 validate[optional, length[10,50]] text-input"  ><?php echo $sname;?></textarea></td>
      	<td colspan="3" style="font-size:9px;">*nama universitas/sekolah anda</td>
    </tr>
    <tr valign="top">
      	<td><label>Pendidikan</label></td>
        <td>:</td>
        <td><input type="text" value="<?php echo $education;?>" name="pendidikan" id="pendidikan" class="disabled2 validate[optional,custom[pendidikan]] text-input"   /></td>
   		<td colspan="3" style="font-size:9px;">*jenjang pendidikan anda</td>
    </tr>    
    
    <tr valign="top">
        <td><label>Deskripsi</label></td>
        <td>:</td>
        <td><textarea name="Deskripsi1" id="Deskripsi1" class="disabled2 validate[optional, length[10,50]] text-input"  ><?php echo $desc;?></textarea></td>
    	<td colspan="3" style="font-size:9px;">*judul proyek akhir anda</td>
    </tr>
    <tr valign="top">
        <td><label>Tahun Mulai</label></td>
        <td>:</td>
        <td>
        <input type="text" value="<?php echo $schly;?>" name="year" id="year" class="disabled2 validate[optional,custom[year]] text-input" onblur="valid(this,'year')" onkeyup="valid(this,'year')" size="4" maxlength="4" /></td>
   		<td colspan="3" style="font-size:9px;">*tahun mulai</td>
   </tr>
   <tr valign="top">
        <td><label>Tahun Selesai</label></td>
        <td>:</td>
        <td>
        <input type="text" value="<?php if($schlyend!='0000'){echo $schlyend;}else{echo "";};?>" name="yearend" id="yearend" class="disabled2 validate[optional,custom[year]] text-input" onblur="valid(this,'year')" onkeyup="valid(this,'year')" size="4" maxlength="4" /></td>
   		<td colspan="3" style="font-size:9px;">*tahun kelulusan</td>
   </tr>
   <tr valign="top">
        <td><label>Kota/Kabupaten</label></td>
        <td>:</td>
        <td><input type="text" value="<?php echo $educity;?>" name="kotapendidikan" id="kotapendidikan" class="disabled2 validate[optional,custom[kotapendidikan]] text-input"   /></td>
   		<td colspan="3" style="font-size:9px;">*Kota tempat menuntut ilmu</td>
    </tr>
</table>
</form>
<?php
}elseif($frm=='exp'){	
	if($act=="edit"){

		$query1="SELECT a.name as nama,a.email,				
					d.company_id as companyid,d.company_name as company, d.company_year as cyear,d.end_year as endyear,
					d.city, d.working_position as position, d.project 
					
					FROM user a JOIN company d ON d.user_id = a.user_id
					WHERE a.user_id ='".$_SESSION['userid']."' and d.company_id='".$cid."'";//nantinya pake session id
		$datauser1   = $CONN->Execute($query1);
		
		$dataU1 = $datauser1->FetchNextObject();				
		$compid		= $dataU1->COMPANYID;
		$company	= $dataU1->COMPANY;
		$cyear		= $dataU1->CYEAR;
		$endyear	= $dataU1->ENDYEAR;
		$position	= $dataU1->POSITION;
		$project	= $dataU1->PROJECT;
		$compcity	= $dataU1->CITY;
		$j++;
		}

?>
<form action="" method="post" style="padding:15px;overflow:hidden;" id="winEditCvExp">
<table>    
   <tr valign="top">
        <td width="100"><label>Perusahaan</label></td>
        <td>:</td>
        <td><textarea name="Perusahaan" id="Perusahaan" class="disabled2 validate[optional, length[10,50]] text-input"  ><?php echo $company;?></textarea></td>
		<td colspan="3" style="font-size:9px;">*nama perusahaan/tempat bekerja anda</td>
    </tr>
    <tr valign="top">
      	<td><label>Posisi</label></td>
        <td>:</td>
        <td><input type="text" value="<?php echo $position;?>" name="jobspecification" id="jobspecification" class="disabled2 validate[optional,custom[pendidikan]] text-input"   /></td>
    	<td colspan="3" style="font-size:9px;">*posisi/jabatan anda</td>
    </tr>    
    
    <tr valign="top">
        <td><label>Project</label></td>
        <td>:</td>
        <td><textarea name="Deskripsi2" id="Deskripsi2" class="disabled2 validate[optional, length[10,50]] text-input"  ><?php echo $project;?></textarea></td>
    	<td colspan="3" style="font-size:9px;">*nama proyek yang dikerjakan anda</td>
    </tr>
    <tr valign="top">
        <td><label>Tahun Mulai</label></td>
        <td>:</td>
        <td>
        <input type="text" value="<?php echo $cyear;?>" name="yearhire" id="yearhire" class="disabled2 validate[optional,custom[year]] text-input" onblur="valid(this,'year')" onkeyup="valid(this,'year')" size="4" maxlength="4" /></td>
   		<td colspan="3" style="font-size:9px;">*tahun mulai bekerja</td>
   </tr>
   <tr valign="top">
        <td><label>Tahun Selesai</label></td>
        <td>:</td>
        <td>
        <input type="text" value="<?php if($endyear!='0000'){echo $endyear;}else{echo "";};?>" name="yearhireend" id="yearhireend" class="disabled2 validate[optional,custom[year]] text-input" onblur="valid(this,'year')" onkeyup="valid(this,'year')" size="4" maxlength="4" /></td>
   		<td colspan="3" style="font-size:9px;">*tahun selesai bekerja</td>
   </tr>
   <tr valign="top">
        <td><label>Kota/Kabupaten</label></td>
        <td>:</td>
        <td><input type="text" value="<?php echo $compcity;?>" name="KotaSpesifikasi" id="KotaSpesifikasi" class="disabled2 validate[optional,custom[kotapendidikan]] text-input"   /></td>
    	<td colspan="3" style="font-size:9px;">*kota/tempat bekerja anda</td>
    </tr>
</table>
</form>
<?php 
}elseif($frm=='skll'){	
	if($act=="edit"){

		$query2="SELECT a.name as nama,a.email,e.skill_id as skillid,e.skill_desc as skill
				FROM user a JOIN skill e ON e.user_id = a.user_id
				WHERE a.user_id ='".$_SESSION['userid']."'and e.skill_id ='".$skid."'";//nantinya pake session id
				//echo $query;
		$datauser2   = $CONN->Execute($query2);
				
		$dataU2 = $datauser2->FetchNextObject();			
		$skillid	= $dataU2->SKILLID;
		$skill		= $dataU2->SKILL;	
		$l++;
		}
		
?>
<form action="" method="post" style="padding:15px;overflow:hidden;" id="winEditCvSkill">
<table>    
   <tr valign="top">
        <td width="100"><label>Skill</label></td>
        <td>:</td>
        <td><textarea name="skill" id="skill" class="disabled2 validate[optional, length[10,50]] text-input"  ><?php echo $skill;?></textarea></td>
    	<td colspan="3" style="font-size:9px;">*isi sesuai kemampuan yang anda miliki</td>
    </tr>
</table>
</form>
<?php 
}elseif($frm=='oth'){	
	if($act=="edit"){
		
		$query3="SELECT a.name as nama,a.email,f.add_activities_id as otherjobid,f.other_job as otherjob
				FROM user a JOIN additional_profesional_activities f ON f.user_id = a.user_id
				WHERE a.user_id ='".$_SESSION['userid']."' and f.add_activities_id ='".$oid."'";//nantinya pake session id
				
		$datauser3   = $CONN->Execute($query3);
				
		$dataU3 = $datauser3->FetchNextObject();					
		$otherjobid	= $dataU3->OTHERJOBID;
		$otherjob	= $dataU3->OTHERJOB;
		$k++;	
		}

?>
<form action="" method="post" style="padding:15px;overflow:hidden;" id="winEditCvOther">
<table>    
   <tr valign="top">
        <td width="100"><label>Pekerjaan Lain</label></td>
        <td>:</td>
        <td><textarea name="pekerjaan" id="pekerjaan" class="disabled2 validate[optional, length[10,50]] text-input"  ><?php echo $otherjob;?></textarea></td>
      	<td colspan="3" style="font-size:9px;">*pisahkan dengan tanda koma(,)bila lebih dari satu!</td>
    </tr>
</table>
</form>
<?php 
}elseif($frm=='feedback'){	
	if($act=="edit"){

		$query="SELECT * FROM feedback	";
		$datauser   = $CONN->Execute($query);
		
		$data = $datauser->FetchNextObject();				
		$j++;
		}

?>
<form action="" method="post" style="padding:15px;overflow:hidden;" id="winEditFb">
<table>    
    <tr valign="top">
        <td><label>Feedback</label></td>
        <td>:</td>
        <td><textarea name="descfb" id="descfb" class="disabled2 validate[optional, length[10,50]] text-input"  ></textarea></td>
    	<td colspan="3" style="font-size:9px;">*beri komentar disini</td>
    </tr>
</table>
</form>
<?php
}?>
</div>