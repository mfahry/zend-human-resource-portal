<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/uploadify.css" />
<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/validation_engine.css" />
<!--link rel="stylesheet" type="text/css" href="includes/css/jquery-ui-1.8.16.custom.css" /-->
<link rel="stylesheet" type="text/css" href="includes/JQuery/ui/css/neuron/jquery-ui-1.8.17.custom.css" />
<script type="text/javascript" src="includes/JQuery/ui/js/jquery-ui-1.8.17.custom.min.js"></script>
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
<style>
#feedback{
	border:1px solid #ccc;
	border-collapse:collapse;
	clear:both;
	width:600px;
	float:left;
}
#feedback td{
	border:1px solid #ccc;
	border-collapse:collapse;
}
#feedback th{
	border:1px solid #ccc;
	border-collapse:collapse;
	padding: 5px;
	font-size: 14px;
}
</style>
<script>
function diaFeedBack(id){
	$("#feedbackdtl").dialog('close');
	$("#feedbackdtl").remove();
	$("#feedbackid").append('<div id="feedbackdtl"></div>');
	
	$("#feedbackid").dialog({
		title	: "Detail Feedback",
		width	: 350,
		show	: "fold",
		hide	: "fold",
		resizable: false,
		modal	: true,
		open	: function(){
			$("#feedbackdtl").html("index.php?mod=feedback/detail/"+id);
		},
		close	: function(){
			$("#feedbackdtl").dialog("close");
			$("#feedbackdtl").remove();
		},
		buttons	: {
			"Close" : function(){
				$("#feedbackdtl").dialog("close");
				$("#feedbackdtl").remove();			
			}
		}
	});
}
</script>
<?php 
require_once("dbsconf/DbConnect.php"); 
global $CONN;
?>
<div id="feedbackid"></div>
<form action="" method="post" style="padding:15px;" id="frmfeedback">
<div style="border-bottom:1px solid #000;text-align:left;width:600px;height:30px;"  class="aligns">
    <div style="width:30%;float:left;">
    	<b>Feedback</b>
    </div>
    <div style="width:30%;float:right;text-align:right;">
    	<input type="button" value="+ Tambah" onclick="editFb('','feedback','add');" />
    </div> 
</div>
<br />
<?php
$url = isset($_GET['mod'])? explode('/',$_GET['mod']):'';
if(isset($url[1]) && $url[1]=='detail'){

	$i=0;
	foreach($feedback as $data){ 
	
		$i++;
?>
<table>
	<tr>
    	<td colspan="2">
		<?php if(isset($url[1]) && $url[1]=='detail') echo $data->FB_DESC;?></td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
    	<td width="100px"><h5 style="border:1px solid #ccc;">by: <?php echo $this->registry->mUser->get_fullName($data->INPUT_BY);?></h5></td>
    	<td>&nbsp;</td>
    </tr>
</table>    
<?php }
}else{
?>
<table id="feedback" class="ui-widget ui-widget-content ui-corner-all">
	<tr>
    	<th class="ui-dialog-titlebar ui-widget-header">No</th>
    	<th class="ui-dialog-titlebar ui-widget-header">Feedback</th>
    	<th class="ui-dialog-titlebar ui-widget-header">Input By</th>
        <th class="ui-dialog-titlebar ui-widget-header">Date</th>
        <th class="ui-dialog-titlebar ui-widget-header">Status</th>
        <?php
		if((isset($_SESSION['level_id'])) &&  ($_SESSION['level_id']==2)){
		
			echo '	<th class="ui-dialog-titlebar ui-widget-header">Action</th>';
		
		} 
		?>
    </tr>    
<?php

	$query = "SELECT a.* FROM feedback a ORDER BY input_dtm DESC";
	$datafeedback   = $CONN->Execute($query);
	$i=0;
	while($data = $datafeedback->FetchNextObject()){
		$fbid = $data->FEEDBACK_ID;
		$feedback = $data->FB_DESC;
		
		if(($data->INPUT_BY)=='guest'){
			$fbby = $data->INPUT_BY;
		}else{
			$fbby = $this->registry->mUser->get_fullName($data->INPUT_BY);
		}
		$fbdtm = $data->INPUT_DTM;
		$fbstat = $data->STATUS;
		$i++;
?>
	<tr>
    	<td style="border:1px solid #ccc;text-align:center;" ><?php echo $i;?></td>
        <td style="border:1px solid #ccc;text-align:left;" >
        <a style="color:#CC3300;" href="index.php?mod=feedback/detail/<?php echo $fbid; ?>"><?php echo $this->registry->mFeedback->shortAlineaFb($feedback);?></a>
        <!--a style="color:#CC3300;" href="javascript:void(0)" onclick="diaFeedBack(<?php echo $fbid; ?>)"><?php echo $this->registry->mFeedback->shortAlineaFb($feedback);?></a-->
        </td>
    	<td style="border:1px solid #ccc;text-align:center;" ><?php echo $fbby;?></td>
        <td style="border:1px solid #ccc;text-align:center;" ><?php echo $fbdtm;?></td>
        <td style="border:1px solid #ccc;text-align:center;" ><?php if ($fbstat==0) { echo "Unread"; }else{ echo "Solved";}?></td>
        <?php
		if((isset($_SESSION['level_id'])) &&  ($_SESSION['level_id']==2)){
		?>
			<td style="border:1px solid #ccc;text-align:center;" >
			<?php if  ($fbstat!='1') {
			
			?> <a href="#" class="deletefb" id="fbdel" onclick="editFb(<?php echo $fbid; ?>,'feedback','del');">Solved</a>
			<?php }else{ echo "Solved"; }?></td>
		 
		
		<?php } 
		?>
    </tr>
<?php }
}
?>   
</table>
</form>






