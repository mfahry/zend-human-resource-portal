<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/uploadify.css" />
<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/validation_engine.css" />
<!--link rel="stylesheet" type="text/css" href="includes/css/jquery-ui-1.8.16.custom.css" /-->
<link rel="stylesheet" type="text/css" href="includes/JQuery/ui/css/custom-theme/jquery-ui-1.8.14.custom.css" />
<script type="text/javascript" src="includes/JQuery/ui/js/jquery-ui-1.8.14.custom.min.js"></script>
<script type="text/javascript" src="includes/JQuery/script/uploadify.swfobject.js"></script>
<script type="text/javascript" src="includes/JQuery/script/uploadify.v2.1.0.js"></script>
<script type="text/javascript" src="includes/JQuery/script/validation_engine-id.js"></script>
<script type="text/javascript" src="includes/JQuery/script/validation_engine.js"></script>
<script type="text/javascript" src="includes/JQuery/script/dynamicForm.js"></script>

<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxcommon.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgridcell.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_start.js"></script> 
<script type="text/javascript" src="includes/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxdataprocessor.js"></script>

<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/skins/dhtmlxwindows_dhx_skyblue.css">
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcommon.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcontainer.js"></script>
<script src="includes/js/createWindowNotif.js"></script>

<script type="text/javascript">
$(document).ready(function(){
$("").dynamicForm("", "", {limit:4});
$("#duplicate2").dynamicForm("#plus2", "#minus2", {limit:4});
$("#duplicate3").dynamicForm("#plus3", "#minus3",
{
	limit:3,
	createColor: 'yellow',
	removeColor: 'red'
}
);
});
</script>

<style>
.inputan{
	background:none;border:0;
}
.aligns{
text-align:center;
}
</style>
<script>
$(function(){

	$(".disabled1").addClass("disabled");
	$(".disabled2").addClass("disabled");
	$(".disabled3").addClass("disabled");
	$(".disabled4").addClass("disabled");
	$(".disabled5").addClass("disabled");
	$(".cvPassword").hide();
	$(".cvPasswordEdu").hide();
	$(".cvPasswordExp").hide();
	$(".cvPasswordOther").hide();
	$(".cvPasswordSkill").hide();
	$("#uploadifyPhotocv").hide();
	$("#uploadifyPhotoUploadercv").hide();
	$(".disabled1").attr("disabled","disabled");
	$(".disabled1").addClass("inputan");
	$(".disabled2").attr("disabled","disabled");
	$(".disabled2").addClass("inputan");
	$(".disabled3").attr("disabled","disabled");
	$(".disabled3").addClass("inputan");
	$(".disabled4").attr("disabled","disabled");
	$(".disabled4").addClass("inputan");
	$(".disabled5").attr("disabled","disabled");
	$(".disabled5").addClass("inputan");
	
	$("#tblEditCv").hover(
		  function () {
			$("#spanEditCv").fadeIn("slow");			
			$("#spanAddCv").fadeIn("slow");
			$('#spanEditCv').append($('.tblEditCv'));
		  }, 
		  function () {
			$("#spanEditCv").fadeOut("slow");
			$("#spanAddCv").fadeOut("slow");
			$('#spanEditCv').append($('.tblEditCv'));
  });
  
  	$("#education").hover(
		  function () {
			$("#spanEditCvEdu").fadeIn("slow");		
			$("#spanAddCvEdu").fadeIn("slow");	
		  }, 
		  function () {
			$("#spanEditCvEdu").fadeOut("slow");
			$("#spanAddCvEdu").fadeOut("slow");
  });
  
    $("#experience").hover(
		  function () {
			$("#spanEditCvExp").fadeIn("slow");
			$("#spanAddCvExp").fadeIn("slow");			
		  }, 
		  function () {
			$("#spanEditCvExp").fadeOut("slow");
			$("#spanAddCvExp").fadeOut("slow");
			
  });
    $("#other").hover(
		  function () {
			$("#spanEditCvOther").fadeIn("slow");
			$("#spanAddCvOther").fadeIn("slow");			
		  }, 
		  function () {
			$("#spanEditCvOther").fadeOut("slow");
			$("#spanAddCvOther").fadeOut("slow");
			
  });
    $("#skills").hover(
		  function () {
			$("#spanEditCvSkill").fadeIn("slow");
			$("#spanAddCvSkill").fadeIn("slow");			
		  }, 
		  function () {
			$("#spanEditCvSkill").fadeOut("slow");
			$("#spanAddCvSkill").fadeOut("slow");
			
  });  
    $("#spanEditCv").toggle(
	  function () {
	  	$(".disabled1").removeClass("disabled");
	 	$(".disabled1").removeAttr("disabled");		
		$(".cvPassword").show();
		//$("#uploadifyPhotoUploadercv").css("visibility", "visible");
		//$("#oldpasscv").val('');
		$(".disabled1").removeClass("inputan");
	  },
	  function () {
	  	$(".disabled1").addClass("disabled");
	  	$(".disabled1").attr("disabled");
		//$("#uploadifyPhotoUploadercv").css("visibility", "hidden");
		$(".cvPassword").hide();
		var xpass = $("#xpasscv").val();
		//$("#oldpasscv").val(xpass);
		$(".disabled1").attr("disabled","disabled");
		$(".disabled1").addClass("inputan");	
	  }
	);
	$("#spanAddCv").toggle(
	   function () {
	  	$('.disabled2').append($('.disabled2'));
	  },
	  function () {
		$('.disabled2').append($('.disabled2'));
	  }
	);
	
	$("#spanEditCvEdu").toggle(
	   function () {
	  	$(".disabled2").removeAttr("disabled");
		$(".disabled2").removeClass("disabled");
		$(".cvPasswordEdu").show();
		$("#uploadifyPhotoUploadercv").css("visibility", "visible");
		$("#oldpasscv").val('');
		$(".disabled2").removeClass("inputan");
	  },
	  function () {
		$(".disabled2").addClass("disabled");
		$(".disabled2").attr("disabled");
		$("#uploadifyPhotoUploadercv").css("visibility", "hidden");
		$(".cvPasswordEdu").hide();
		var xpass = $("#xpasscv").val();
		$("#oldpasscv").val(xpass);
		$(".disabled2").attr("disabled","disabled");
		$(".disabled2").addClass("inputan");	
	  }
	);
	$("#spanEditCvExp").toggle(
	  function () {
		$(".disabled3").removeAttr("disabled");
		$(".disabled3").removeClass("disabled");
		$(".cvPasswordExp").show();
		$(".disabled3").removeClass("inputan");
	  },
	  function () {
	 	$(".disabled3").addClass("disabled");
		$(".disabled3").attr("disabled");
		$(".cvPasswordExp").hide();
		var xpass = $("#xpasscv").val();
		$(".disabled3").attr("disabled","disabled");
		$(".disabled3").addClass("inputan");	
	  }
	);
	$("#spanEditCvOther").toggle(
	  function () {
		$(".disabled4").removeAttr("disabled");
		$(".disabled4").removeClass("disabled");
		$(".cvPasswordOther").show();
		$(".disabled4").removeClass("inputan");
	  },
	  function () {
	  	$(".disabled4").addClass("disabled");
		$(".disabled4").attr("disabled");
		$(".cvPasswordOther").hide();
		var xpass = $("#xpasscv").val();
		$(".disabled4").attr("disabled","disabled");
		$(".disabled4").addClass("inputan");	
	  }
	);
	$("#spanEditCvSkill").toggle(
	  function () {
		$(".disabled5").removeAttr("disabled");
		$(".disabled5").removeClass("disabled");
		$(".cvPasswordSkill").show();
		$(".disabled5").removeClass("inputan");
	  },
	  function () {
	  	$(".disabled5").addClass("disabled");
		$(".disabled5").attr("disabled");
		$(".cvPasswordSkill").hide();
		var xpass = $("#xpasscv").val();
		$(".disabled5").attr("disabled","disabled");
		$(".disabled5").addClass("inputan");	
	  }
	);
	
   
	
  	$("#frmEditCv").validationEngine({
		inlineValidation: false,
		success :  function(){
			if($("#passwordcv").val()!=""){
				var oldpass = $("#oldpasscv").val();
				var newpass = $("#passwordcv").val();
					
				/*if(oldpass != newpass)
					$.validationEngine.buildPrompt("#frmEditCv #passwordcv","* Kolom password tidak cocok","error");*/
			} 
		}
   });
 });  
   //untuk buka window_cv_education
</script>


<?php
require_once("dbsconf/DbConnect.php"); 
global $CONN;
//include("/views/window_cv_education.php");
	$data = $this->registry->mUser->select_user($_SESSION['userid']);
			foreach($data as $user){
				$userid		= $user->USER_ID;
				$password 	= $user->PASSWORD;
				$nama 		= $user->NAME;
				$email 		= $user->EMAIL;
				$alamat 	= $user->ALAMAT;
				$phone 		= $user->PHONE;
				$foto 		= $user->PHOTO;
				$city 		= $user->CITY;
				$zipcode 	= $user->ZIPCODE;
				}
?>
<div id="cvDia"></div>
<form action="index.php?mod=profile/updateCv" method="post" style="padding:15px;" id="frmEditCv">
<?php 
		$query0="SELECT a.name as nama,a.email,
				c.school_id as schoolid,c.school_name as sname, c.school_year AS syear, c.school_yearend AS syear_end, c.education, c.description, c.city as educity				
				FROM user a JOIN school c ON c.user_id = a.user_id				
				WHERE a.user_id ='".$_SESSION['userid']."' ";//nantinya pake session id
		//echo $query0;
		$datauser0   = $CONN->Execute($query0);
		$count0 = $datauser0->NumRows();
				//$i;
		
		//echo $count0;	
		
			
		#----------------------------PROFESSIONAL EXPERIENCE-------------------------------------------------------
		$query1="SELECT a.name as nama,a.email,				
				d.company_id as companyid,d.company_name as company, d.company_year as cyear,d.end_year as endyear,
				d.city, d.working_position as position, d.project 
				
				FROM user a JOIN company d ON d.user_id = a.user_id
				WHERE a.user_id ='".$_SESSION['userid']."' ";//nantinya pake session id					
				//echo $query;
		$datauser1   = $CONN->Execute($query1);
		$count1 = $datauser1->NumRows();
				//$i;
				
		#----------------------------SKILL-------------------------------------------------------		
		$query2="SELECT a.name as nama,a.email,e.skill_id as skillid,e.skill_desc as skill
				FROM user a JOIN skill e ON e.user_id = a.user_id
				WHERE a.user_id ='".$_SESSION['userid']."' ";//nantinya pake session id
				//echo $query;
		$datauser2   = $CONN->Execute($query2);
		$count2 = $datauser2->NumRows();
				//$i;	
					
		#----------------------------ADDITIONAL-------------------------------------------------------		
		$query3="SELECT a.name as nama,a.email,f.add_activities_id as otherjobid,f.other_job as otherjob
				FROM user a JOIN additional_profesional_activities f ON f.user_id = a.user_id
				WHERE a.user_id ='".$_SESSION['userid']."' ";//nantinya pake session id
				//echo $query;
		$datauser3   = $CONN->Execute($query3);
		$count3 = $datauser3->NumRows();
				//$i;
					
		
				
	?>
    <!--input type="button" class="btn" onclick="testDialog()" value="Test Dialog" /-->
 		
        
    	
       	
<div style="float:right;"><a href="cv.php?id=<?php echo $_SESSION['userid']; ?>" target="_blank"><span style="float:right; color:#000000;" class="btn">Cetak</span></a></div>
<table id="tblEditCv" >    
    <tr>
    	<td width="102">&nbsp;</td>
        <td width="3">&nbsp;</td>
        <td width="250">&nbsp;</td>
        <td width="50">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="141">&nbsp;</td>
    </tr>
    <tr style="visibility:hidden">
      <td><label>User Id</label></td>
      <td>:</td>
      <td><input type="hidden" value="<?php echo $userid; ?>" name="userid" />
          <?php echo $userid; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="top">
      <td ><label>Nama </label></td>
      <td>:</td>
      <td><input type="text" value="<?php echo $nama; ?>" name="nama" id="nama" class="disabled1 validate[required,custom[onlyLetter],length[7,50]] text-input"   /></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="top">
      <td ><label>Email </label></td>
      <td>:</td>
      <td><input type="text" value="<?php echo $email; ?>" name="email" id="email" class="disabled1 validate[optional,custom[email]] text-input"   /></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="top">
      <td ><label>Telepon</label></td>
      <td>:</td>
      <td><input type="text" value="<?php echo $phone; ?>" name="phone" id="phone" class="disabled1 validate[optional,custom[telephone]] text-input"   /></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="top">
      <td ><label>Alamat </label></td>
      <td>:</td>
      <td><textarea name="alamat" id="alamat" class="disabled1 validate[optional, length[10,50]] text-input"  ><?php echo $alamat; ?></textarea></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="top">
      <div id="kota"> </div>
    </tr>
    <tr valign="top">
      <td><label>Kota/Kabupaten</label></td>
      <td>:</td>
      <td><input type="text" value="<?php echo $city;?>" name="kota" id="kota" class="disabled1 validate[optional,custom[kota]] text-input"   /></td>
      <td>&nbsp;</td>
    </tr>

    <tr valign="top">
      	<td ><label>Kode Pos </label></td>
      	<td>:</td>
      	<td><input type="text" value="<?php echo $zipcode; ?>" name="zipcode" id="zipcode" class="disabled1 validate[optional,custom[zipcode]] text-input"   /></td>
      	<td>&nbsp;</td>
    </tr>

    <tr>
    	<td colspan="3">&nbsp;</td>
        <td colspan="2"><span style="display:none;" class="btn" id="spanEditCv">Ubah</span></td>
      	<td align="center" class="cvPassword">
      <input type="submit" name="cmdEditProfile1" id="cmdEditProfile1" class="btn" value=" Simpan "/></td>
    </tr>
</table>
</form>

<form action="" method="post" style="padding:15px;" id="frmEditCvEdu">
<div style="border-bottom:1px solid #000;text-align:left;width:99%;height:30px;"  class="aligns">
    <div style="width:30%;float:left;">
    	<b>EDUKASI</b>
    </div>
</div>
<br />
<table id="education" class="ui-widget ui-widget-content ui-corner-all" style="border:1px solid #ccc;clear:both;"> 
	<div style="width:30%;float:right;text-align:right;">
    	<input type="button" value="+ Tambah" onclick="editCV('','edu','add');" />
    </div> 
    <br />  
    <tr valign="top" align="center" class="tabl">
    	<th class="ui-dialog-titlebar ui-widget-header">No</th>
     	<th class="ui-dialog-titlebar ui-widget-header">Institusi</th>
        <th class="ui-dialog-titlebar ui-widget-header">Tahun Mulai</th>
        <th class="ui-dialog-titlebar ui-widget-header">Tahun Selesai</th>
        <th class="ui-dialog-titlebar ui-widget-header">Deskripsi/TA</th>
     	<th class="ui-dialog-titlebar ui-widget-header">Kota/Kabupaten</th>
        <th class="ui-dialog-titlebar ui-widget-header">Aksi</th>
    </tr>   
    <?php 
	
	$i = 0;
	$countschid = $count0;
	while($dataU0 = $datauser0->FetchNextObject()){
				$curid		= $dataU0->CV_ID;
				$schid		= $dataU0->SCHOOLID;
				//$countschid	= count($schid);
				$schly	 	= $dataU0->SYEAR;	
				$schlyend 	= $dataU0->SYEAR_END;	
				$sname	 	= $dataU0->SNAME;
				$education	= $dataU0->EDUCATION;
				$desc		= $dataU0->DESCRIPTION;
				$educity	= $dataU0->EDUCITY;
				$i++;

	 ?>

    <tr style="border-bottom:1px solid #ccc;">
    	<td><?php echo $i;?></td>
    	<td><?php echo $sname;?></td>
        <td><?php echo $schly;?></td>
        <td><?php if($schlyend!='0000'){echo $schlyend;}else{echo "Belum selesai!";}?></td>
        <td><?php echo $desc;?></td>
    	<td><?php echo $educity;?></td>
        <td width="80" align="center">
        <a href="#" class="editcv" id="<?php echo $schid;?>" onclick="editCV(<?php echo $schid;?>,'edu','edit');">Ubah</a> | 
        <a href="#" class="deletecv" id="dcv" onclick="editCV(<?php echo $schid;?>,'edu','del');">Hapus</a></td>
    </tr>
<?php  }?>
</table>
</form>

<form action="" method="post" style="padding:15px;" id="frmEditCvExp">
<div style="border-bottom:1px solid #000;text-align:left;width:99%;height:30px;"  class="aligns">
    <div style="width:30%;float:left;">
    	<b>PENGALAMAN</b>
    </div>
</div>
<br />
<table id="experience" class="ui-widget ui-widget-content ui-corner-all" style="border:1px solid #ccc;"> 
    <div style="width:30%;float:right;text-align:right;">
    	<input type="button" value="+ Tambah" onclick="editCV('','exp','add');" />
    </div><br />  
    <tr valign="top" align="center" class="tabl">
    	<th class="ui-dialog-titlebar ui-widget-header">No</th>
     	<th class="ui-dialog-titlebar ui-widget-header">Perusahaan</th>
        <th class="ui-dialog-titlebar ui-widget-header">Tahun Mulai</th>
        <th class="ui-dialog-titlebar ui-widget-header">Tahun Selesai</th>
        <th class="ui-dialog-titlebar ui-widget-header">Posisi</th>
        <th class="ui-dialog-titlebar ui-widget-header">Deskripsi/Project</th>
     	<th class="ui-dialog-titlebar ui-widget-header">Kota/Kabupaten</th>
        <th class="ui-dialog-titlebar ui-widget-header">Aksi</th>
    </tr>       
    <?php 
	
	$j = 0;
	$countschid = $count0;
	while($dataU1 = $datauser1->FetchNextObject()){
				
				$compid		= $dataU1->COMPANYID;
				$company	= $dataU1->COMPANY;
				$cyear		= $dataU1->CYEAR;
				$endyear	= $dataU1->ENDYEAR;
				$position	= $dataU1->POSITION;
				$project	= $dataU1->PROJECT;
				$compcity	= $dataU1->CITY;
				$j++;
	 ?>

    <tr style="border-bottom:1px solid #ccc;">
    	<td><?php echo $j;?></td>
    	<td><?php echo $company;?></td>
        <td><?php echo $cyear;?></td>
        <td><?php if($endyear!='0000'){echo $endyear;}else{echo "Belum selesai!";}?></td>
        <td><?php echo $position;?></td>
        <td><?php echo $project;?></td>
    	<td><?php echo $compcity;?></td>
        <td width="80" align="center">
        <a href="#" class="editcv" onclick="editCV(<?php echo $compid;?>,'exp','edit');">Ubah</a> |
        <a href="#" class="deletecv" onclick="editCV(<?php echo $compid;?>,'exp','del');">Hapus</a></td>
    </tr>
<?php  }?>
</table> 
</form>

<form action="" method="post" style="padding:15px;" id="frmEditCvOther">
<div style="border-bottom:1px solid #000;text-align:left;width:99%;height:30px;"  class="aligns">
    <div style="width:30%;float:left;">
    	<b>PEKERJAAN LAINNYA</b>
    </div>
    
</div>
<br />
<table id="other" class="ui-widget ui-widget-content ui-corner-all" style="border:1px solid #ccc;"> 
	<div style="width:30%;float:right;text-align:right;">
    	<input type="button" value="+ Tambah" onclick="editCV('','oth','add');" />
    </div><br />
    <tr valign="top" align="center" class="tabl">
    	<th class="ui-dialog-titlebar ui-widget-header">No</th>
     	<th class="ui-dialog-titlebar ui-widget-header" width="75%">Lainnya</th>
        <th class="ui-dialog-titlebar ui-widget-header" width="25%">Aksi</th>
    </tr>      
    <?php 
	
	$k = 0;
	$countotherjobid = $count3;
	while($dataU3 = $datauser3->FetchNextObject()){
					
				$otherjobid	= $dataU3->OTHERJOBID;
				$otherjob	= $dataU3->OTHERJOB;
				$k++;	
	 ?>

    <tr style="border-bottom:1px solid #ccc;">
    	<td><?php echo $k ;?></td>
    	<td><?php echo $otherjob;?></td>
        <td width="80" align="center">
        <a href="#" class="editcv" onclick="editCV(<?php echo $otherjobid;?>,'oth','edit');">Ubah</a> |
        <a href="#" class="deletecv" onclick="editCV(<?php echo $otherjobid;?>,'oth','del');">Hapus</a></td>
    </tr>
<?php  }?>
</table> 
</form>

<form action="" method="post" style="padding:15px;" id="frmEditCvSkill">
<div style="border-bottom:1px solid #000;text-align:left;width:99%;height:30px;"  class="aligns">
    <div style="width:30%;float:left;">
    	<b>KEAHLIAN</b>
    </div>
    
</div>
<br />
<table id="skills" class="ui-widget ui-widget-content ui-corner-all" style="border:1px solid #ccc;">   
	<div style="width:30%;float:right;text-align:right;">
    	<input type="button" value="+ Tambah" onclick="editCV('','skll','add');" />
    </div><br /> 
    <tr valign="top" align="center" class="tabl">    
    	<th class="ui-dialog-titlebar ui-widget-header">No</th>
     	<th class="ui-dialog-titlebar ui-widget-header"  width="75%">Keahlian</th>
        <th class="ui-dialog-titlebar ui-widget-header" width="25%">Aksi</th>
    </tr>   
    <?php 
	
	$l = 0;
	while($dataU2 = $datauser2->FetchNextObject()){
				
				$skillid	= $dataU2->SKILLID;
				$skill		= $dataU2->SKILL;	
				$l++;
	 ?>

    <tr style="border-bottom:1px solid #ccc;">
    	<td><?php echo $l;?></td>
    	<td><?php echo $skill;?></td>
        <td width="80" align="center">
        <a href="#" class="editcv" onclick="editCV(<?php echo $skillid;?>,'skll','edit');">Ubah</a> |
        <a href="#" class="deletecv" onclick="editCV(<?php echo $skillid;?>,'skll','del');">Hapus</a></td>
    </tr>
<?php  }?>
</table>
</form>
