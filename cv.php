<?php

require_once("dbsconf/DbConnect.php"); 
global $CONN;

$getid=$_GET['id'];
?>
<link rel="stylesheet" media="print" title="Printer-Friendly Style" 
         type="text/css">
<style type="text/css">
.font{
	/*font-family: Verdana, "Times New Roman", SansSerif*/
	font-family: Garamond, "Times New Roman", SansSerif
	}

</style>
<html>
<title>CURRICULUM VITAE
</title>
<head>
<div style="width:100%; text-align:center;">
<form name="formCv" method="get" action="">

<table class="font" cellpadding="0" cellspacing="0" border="0" width="800px" align="center">

	<?php 
		$query="SELECT a.name as nama,a.email,a.alamat, a.zipcode,a.phone, 
				c.school_id as schoolid,c.school_name as sname,c.school_year AS syear, c.school_yearend AS syear_end, c.education, c.description, c.city as educity				
				FROM user a JOIN school c ON c.user_id = a.user_id				
				WHERE a.user_id ='".$getid."' ";//nantinya pake session id
		//echo $query;
		$datauser   = $CONN->Execute($query);
		$count = $datauser->NumRows();
				$i;
				while($dataU = $datauser->FetchNextObject()){
				$cvid		= $dataU->CV_ID;
				$nama 	 	= strtoupper($dataU->NAMA);
				$name 	 	= $dataU->NAMA;
				$email	 	= strtoupper($dataU->EMAIL);
				$phone		= $dataU->PHONE;
				$phone1	 	= $dataU->PHONE_1;
				$phone2	 	= $dataU->PHONE_2;
				$address 	= strtoupper($dataU->ALAMAT);
				$city 		= strtoupper($dataU->CITY);
				$zipcode	= $dataU->ZIPCODE;
				$schid		= $dataU->SCHOOLID;				
				$schly	 	= $dataU->SYEAR;
				$schlyend 	= $dataU->SYEAR_END;		
				$sname	 	= $dataU->SNAME;
				$education	= $dataU->EDUCATION;
				$desc		= $dataU->DESCRIPTION;
				$educity	= $dataU->EDUCITY;

				if($count > 1){
					if($schlyend!='0000'){
						$edu	.= "$schly - $schlyend $sname".", "."<span style='float:right;'>$educity</span><br />"."<i>$education</i><br />"."$desc<br /><br />";
					}else{
						$edu	.= "$schly - "."now"." $sname".", "."<span style='float:right;'>$educity</span><br />"."<i>$education</i><br />"."$desc<br /><br />";
					}
				}else{
					if($schlyend!='0000'){
						$edu	= "$schly - $schlyend $sname".", "."<span style='float:right;'>$educity</span><br />"."<i>$education</i><br />"."$desc<br /><br />";
					}else{
						$edu	= "$schly - "."now"." $sname".", "."<span style='float:right;'>$educity</span><br />"."<i>$education</i><br />"."$desc<br /><br />";
					}
				}
				/*if($sname > 1){
					$comp	.= "$cyear - $company<br />"."<b>$position</b><br />".•."$project<br /><br />";
				}else{
					$comp	= "$cyear - $company<br />"."<b>$position</b><br />".•."$project<br /><br />";
				}
				if($skillid > 1){
					$skl	.= "$skill<br /><br />";
				}else{
					$skl	= "$skill<br /><br />";
				}*/
				$i++;
				} 
			
		#----------------------------PROFESSIONAL EXPERIENCE-------------------------------------------------------
		$query1="SELECT a.name as nama,a.email,				
				d.company_id as companyid,d.company_name as company, d.company_year as cyear, d.end_year as endyear,
				d.city, d.working_position as position, d.project 
				
				FROM user a JOIN company d ON d.user_id = a.user_id
				WHERE a.user_id ='".$getid."' ";//nantinya pake session id					
				//echo $query;
		$datauser1   = $CONN->Execute($query1);
		$count1 = $datauser1->NumRows();
				$i;
				while($dataU1 = $datauser1->FetchNextObject()){
				
				$compid		= $dataU1->COMPANYID;
				$company	= $dataU1->COMPANY;
				$cyear		= $dataU1->CYEAR;
				$endyear	= $dataU1->ENDYEAR;
				$position	= $dataU1->POSITION;
				$project	= $dataU1->PROJECT;
				$compcity	= $dataU1->CITY;


				if($count1 > 1){
					if($endyear!='0000'){
					$comp	.= "$cyear - $endyear $company".", "."<span style='float:right;'>$compcity</span><br />"."<i><b>$position</b></i><br />&bull;<i>$project</i><br /><br />";
					//$comp	.= "$cyear - $company";
					//$postn	.= "<b><i>$position</i></b><br />".•."<i>$project</i><br /><br />";
					}else{
					$comp	.= "$cyear - $company".", "."<span style='float:right;'>$compcity</span><br />"."<i><b>$position</b></i><br />&bull;<i>$project</i><br /><br />";
					}
				}else{
					if($endyear!='0000'){
					$comp	= "$cyear - $endyear $company".", "."<span style='float:right;'>$compcity</span><br />"."<i><b>$position</b></i><br />&bull;<i>$project</i><br /><br />";
					//$comp	= "$cyear - $company";
					//$postn	= "<b><i>$position</i></b><br />".•."<i>$project</i><br /><br />";
					}else{
					$comp	= "$cyear - $company".", "."<span style='float:right;'>$compcity</span><br />"."<i><b>$position</b></i><br />&bull;<i>$project</i><br /><br />";
					}
				}

				$i++;
				}
		#----------------------------ADDITIONAL-------------------------------------------------------		
		$query3="SELECT a.name as nama,a.email,f.add_activities_id as otherjobid,f.other_job as otherjob
				FROM user a JOIN additional_profesional_activities f ON f.user_id = a.user_id
				WHERE a.user_id ='".$getid."' ";//nantinya pake session id
				//echo $query;
		$datauser3   = $CONN->Execute($query3);
		$count3 = $datauser3->NumRows();
				$i;
				while($dataU3 = $datauser3->FetchNextObject()){
				$otherjobid	= $dataU3->OTHERJOBID;
				$otherjob		= $dataU3->OTHERJOB;
		
				if($count3 > 1){
					$ojob	.= "<i>$otherjob</i><br /><br />";
				}else{
					$ojob	= "<i>$otherjob</i><br /><br />";
				}
				$i++;
				} 		
		#----------------------------SKILL-------------------------------------------------------		
		$query2="SELECT a.name as nama,a.email,e.skill_id as skillid,e.skill_desc as skill
				FROM user a JOIN skill e ON e.user_id = a.user_id
				WHERE a.user_id ='".$getid."' ";//nantinya pake session id
				//echo $query;
		$datauser2   = $CONN->Execute($query2);
		$count2 = $datauser2->NumRows();
				$i;
				while($dataU2 = $datauser2->FetchNextObject()){
				$skillid	= $dataU2->SKILLID;
				$skill		= $dataU2->SKILL;
		
				if($count2 > 1){
					$skl	.= "- $skill<br /><br />";
				}else{
					$skl	= "- $skill<br /><br />";
				}
				$i++;
				} 
	if($schid!=NULL){		
	?>

	<tr>
		<td colspan="8" align="center"><span style="font-size:13px;"><?php echo $address.", ".$city.$zipcode;?><br><?php echo "&bull; PHONE ".$phone."&nbsp;&bull; E-MAIL ".$email;?></span><br><br></td>
    </tr>
    <tr>
    	<td colspan="8" align="center"><span style="font-size:36px;"><?php echo $nama;?></span><br><br><br></td>
    </tr>
    <tr>
    	<td colspan="8" align="center"><div style="border-bottom:1px solid #000; text-align:left;"><b>EDUCATION</b></div></td>
    </tr>
    <tr>
    	<td width="100">&nbsp;</td>
    	<td width="100">&nbsp;</td>
    	<td width="100">&nbsp;</td>
    	<td width="100">&nbsp;</td>
    	<td width="100">&nbsp;</td>
    	<td width="100">&nbsp;</td>
    	<td width="100">&nbsp;</td>
    	<td width="100">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2" align="right">&nbsp;</td>
        <td colspan="6" align="left"><?php echo  $edu;?></td>
    </tr> 
    <tr>
    	<td>&nbsp;</td>
    </tr>   
	<tr>
    	<td colspan="8" align="center"><div style="border-bottom:1px solid #000; text-align:left"><b>PROFESSIONAL EXPERIENCE</b></div></td>
    </tr>
    <tr>
    	<td colspan="8">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2" align="right">&nbsp;</td>
        <td colspan="6" align="left"><?php echo  $comp;?></td>
    </tr> 
    <tr>
   		<td>&nbsp;</td>
    </tr>
    <?php 
		if($count3 < 1){
	?> 
    <tr>
    	<td colspan="8" align="center">&nbsp;</td>
    </tr>
    <?php
	}else{
	?> 
	<tr>
    	<td colspan="8" align="center"><div style="border-bottom:1px solid #000; text-align:left"><b>ADDITIONAL PROFESSIONAL ACTIVITIES</b></div></td>
    </tr>

    <tr>
    	<td colspan="8">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2" align="right">&nbsp;</td>
        <td colspan="6" align="left"><?php echo  $ojob;?></td>
    </tr> 
    <tr>
    	<td>&nbsp;</td>
    </tr> 
    <?php
	}
	?>
	<tr>
    	<td colspan="8" align="center"><div style="border-bottom:1px solid #000; text-align:left"><b>SKILL</b></div></td>
    </tr>
    <tr>
    	<td colspan="8">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2" align="right">&nbsp;</td>
        <td colspan="6" align="left"><?php echo  $skl;?></td>
    </tr> 
    <tr>
    	<td>&nbsp;</td>
    </tr>
    


</table>
<div style="float:center; width:100%; position:relative; bottom:10px;">
	
    <div style="float:left; text-align:center; width:50%;"> &nbsp;</div>   
    <div style="float:right; text-align:center; width:50%;">&nbsp;</div>
    <div style="float:left; text-align:center; width:50%;"> &nbsp;</div>   
    <div style="float:right; text-align:center; width:50%;">&nbsp;</div>
	<div style="float:left; text-align:center; width:50%;">Mengetahui,</div>
    <div style="float:right; text-align:center; width:50%;">Tertanda,</div>
    <div style="float:left; text-align:center; width:50%;">Direktur </div>    
    <div style="float:right; text-align:center; width:50%;">&nbsp;</div>
    <div style="float:left; text-align:center; width:50%;"> &nbsp;</div>   
    <div style="float:right; text-align:center; width:50%;">&nbsp;</div>
    <div style="float:left; text-align:center; width:50%;">&nbsp; </div>    
    <div style="float:right; text-align:center; width:50%;">&nbsp;</div> 
    <div style="float:left; text-align:center; width:50%;">&nbsp;</div>    
    <div style="float:right; text-align:center; width:50%;">&nbsp;</div>         
    <div style="float:left; text-align:center; width:50%;"><u>Sriyanto</u></div>    
    <div style="float:right; text-align:center; width:50%;"><u><?php echo $name;?></u></div>
</div>
<?php
}else{
	echo "<div style='padding-top:20%;'><span>Data CV Anda belum lengkap, silahkan mengisikan data CV anda menggunakan fasilitas yang terdapat di Portal NEURONWORKS INDONESIA !</span></div>";
}
?>
</form>
</div>
</head>
</html>