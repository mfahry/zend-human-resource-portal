
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxcommon.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgridcell.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_start.js"></script>

<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.css">
<link rel="stylesheet" type="text/css" href="includes/JQuery/ui/css/custom-theme/jquery-ui-1.8.14.custom.css" />
<script type="text/javascript" src="includes/JQuery/ui/js/jquery-ui-1.8.14.custom.min.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcommon.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcontainer.js"></script>

<script src="includes/js/createWindowManageUser.js"></script> 
 
<link rel="STYLESHEET" type="text/css" href="includes/dhtmlx/dhtmlxCalendar/codebase/dhtmlxcalendar.css">
<script> window.dhx_globalImgPath = "includes/dhtmlx/dhtmlxCalendar/codebase/imgs/"; </script>
<script  src="includes/dhtmlx/dhtmlxCalendar/codebase/dhtmlxcommon.js"></script>
<script  src="includes/dhtmlx/dhtmlxCalendar/codebase/dhtmlxcalendar.js"></script>

<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/validation_engine.css">
<script type="text/javascript" src="includes/JQuery/script/validation_engine.js"></script> 
<script type="text/javascript" src="includes/JQuery/script/validation_engine-id.js"></script>
<?php 

?>
<form name="formdocument" method="post" action="index.php?mod=document/test">
  <table width="873" style="margin-left:0px;">
    <tr>
      <td width="43"><?php 
				$this->registry->view->type="month";
				$this->registry->view->show("combo_date");?></td>
      <td width="43"><?php 
				$this->registry->view->type="year";
				$this->registry->view->show("combo_date");?></td>
      <td width="590"><input type="submit" name="submitdocument" class="btn" value="submit"/></td> 
    </tr>
  </table>
</form>
<table id="grid_document" class="window">
  <tr>
    <th width="150" align="center"><b>Nama</b></th>
    <th width="150" align="center"><b>Direktori</b></th>
    <th width="380" align="center"><b>Nama File</b></th>
    <th width="100" align="center"><b>Tipe File</b></th>
    <th width="120" align="center"><b>Upload Time</b></th>
  </tr>
  <?php 	
		$i 	= 1;
		//$url = explode('/',$_GET['mod']);
		//if($url[0]=='document'){
		$document = $this->registry->mDocument->get_documentByCalendar('', $_POST['cmbMonth'], $_POST['cmbYear']);
			
		foreach($document as $data){
	
			$uploadedby = $data->NAME;
			$uploadeddtm = $data->UPLOADED_DTM;
			$file = $data->FILE_NAME;
			$fileori = $data->ORIGINAL_FILE_NAME;
			$folderid = $data->FOLDER_ID;
			$filetype = $data->FILE_TYPE;
			$folder = $data->FOLDER_NAME;
			$folderparent = $data->FOLDER_PARENT;
			
			if($folderparent!=0){
				$query2 = "select folder_name from folder_kerja where folder_id=$folderparent";
		
				$rs2 = $this->registry->db->Execute($query2);
				$parent = $rs2->fields[0];
				
				$folder = "$parent/$folder";
			}
			
			$locate = "upload/".$folder."/".$file;
	?>
  <tr>
	<td align="left"><?php echo $data->NAME;?></td>
    <td align="left"><?php echo $folder;?></td>
    <td align="left"><a href="<?=$locate;?>" target="_blank" ><?php echo $fileori; ?></a></td>
	<td align="center"><?=$filetype?></td>
    <td align="center"><?php echo $data->UPLOADED_DTM;?></td>
  </tr>
  <?php 	
 		}//}
?>
</table>
<script>

	function deleteUser(user){
		var c = confirm("Hapus data user "+user+"?");
		if(c) location.href = "index.php?mod=staffing/delete/"+user;
	}
	 
	var grid = new dhtmlXGridFromTable("grid_document");
	grid.setImagePath("includes/dhtmlx/dhtmlxGrid/imgs/");
	grid.setSkin("dhx_skyblue");
	grid.enableAutoWidth(true,920,920);
	grid.enableAutoHeight(true, 600,600);
	grid.setSizes();
	grid.setColTypes("ro,ro,ro");
</script>
