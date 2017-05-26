<!-- Last Edited by de_haynain !-->
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxcommon.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgridcell.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_start.js"></script>

<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/skins/dhtmlxwindows_dhx_skyblue.css">
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

<link type="text/css" href="includes/JQuery/ui/css/ui-darkness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="includes/JQuery/ui/js/jquery-ui-1.8.16.custom.min.js"></script>

<a href="#add" class="edit" id="add_0">
	<img src="includes/img/user.gif" hspace="4"/>
	Tambah User
</a> 
- 
<a href="javascript:void(0);" onclick="setFee();">
	Set Fee
</a>
<table id="grid_managementUser">
  <tr>
    <th width="30" style="text-align:center;">No</th>
    <th width="70" style="text-align:center;">Username</th>
    <th width="180" style="text-align:center;">Nama Lengkap</th>
    <th width="80" style="text-align:center;">Level</th>
    <th width="80" style="text-align:center;">HRD Status</th>
    <th width="70" style="text-align:center;">Edit</th>
    <th width="70" style="text-align:center;">Delete</th>
    <th width="80" style="text-align:center;">Lock/Unlock</th>
    <th width="70" style="text-align:center;">Gaji</th>
    <th width="70" style="text-align:center;">Dibayarkan</th>
  </tr>
  <?php 
  	if(count($datauser)>0){
		$i 	= 1;
		foreach($datauser as $data){ 
	?>
  <tr>
    <td style="text-align:right;padding-right:5px;"><?php echo $i++;  ?></td>
    <td><a href="#detail" class="detail" id="<?php echo $data->USER_ID; ?>"> <?php echo $data->USER_ID; ?></a></td>
    <td><?php echo ($data->HRDSTATUS==0)?'<font color="red" class="vtip" title=" Tidak aktif ">'.$data->NAME.'</font>':$data->NAME; ?></td>
    <td align="center"><?php echo $data->LEV_NAME; ?></td>
    <td align="center">
	<?php 
		if($data->HRDSTATUS==0)		echo "<font color=\"red\">Tidak aktif</font>";
	  	elseif($data->HRDSTATUS==1)	echo "<font color=\"green\">Aktif</font>"; 
	?>
    </td>
    <td align="center"><a href="#edit" class="edit" id="edit_<?php echo $data->USER_ID; ?>">Edit</a></td>
    <td align="center"><a href="javascript:void(0)" onclick="deleteUser('<?php echo $data->USER_ID; ?>')" class="merah">Delete</a></td>
    <td align="center"><a href="#<?php echo ($data->STATUS_LOGIN==2)?'unlock':'lock'; ?>" 
    	class="<?php echo ($data->STATUS_LOGIN==2)?'unlock':'lock'; ?>" 
        id="<?php echo ($data->STATUS_LOGIN==2)?'unlock':'lock'; ?>_<?php echo $data->USER_ID; ?>">
        <?php echo ($data->STATUS_LOGIN==2)?'unlock':'<font color="green">lock</font>'; ?>
        </a> 
    </td>
    <td align="center"><a href="javascript:void(0);" onclick="gaji(<?php echo $data->USER_ID; ?>,'<? echo $data->NAME;?>');">Set Gaji</a></td>
    <td align="center"><a href="javascript:void(0);" onclick="thp(<?php echo $data->USER_ID; ?>,'<? echo $data->NAME;?>');">Set</a></td>
  </tr>
  <?php 	}
	}
?>
</table>
<div id="divGaji"></div>
<script>
function setFee(act,id){
	if(act=='del'){
		if(confirm('Yakin akan menghapus data fee ini?')){
			$.ajax({
				type	: 'post',
				url		: 'views/form_fee_act.php',
				data	: 'act=del&id='+id,
				success	: function(msg){
					//$("#dialogFee").html(msg);
					alert('Data fee telah di hapus');
					$("#dialogFee").dialog("close");
					setFee();
				}
			});
		}
	}else{
		$("#dialogFee").remove();
		$("#divGaji").append('<div id="dialogFee"></div>');
		$("#dialogFee").dialog({
			title	: 'Set Fee',
			width	: 500,
			show	: 'fold',
			hide	: 'fold',
			draggable: false,
			resizable: false,
			modal	: true,
			open	: function(){
				$.ajax({
					type	: 'post',
					url		: 'views/form_fee.php',
					data	: 'act='+act+'&id='+id,
					success	: function(msg){
						$("#dialogFee").html(msg);
					}
				});
			}
		});
	}
}

function gaji(id,nama){
	$("#dialogGaji").remove();
	$("#divGaji").append('<div id="dialogGaji"></div>');
	$("#dialogGaji").dialog({
		title	: 'Set Gaji Untuk ' + nama,
		width	: 330,
		height	: 300,
		show	: 'fold',
		hide	: 'fold',
		draggable: false,
		resizable: false,
		modal	: true,
		open	: function(){
			$.ajax({
				type	: 'post',
				url		: 'views/form_gaji.php',
				data	: 'userid='+id,
				success	: function(msg){
					$("#dialogGaji").html(msg);
				}
			});
		}
	});
}
function thp(id,nama){
	$("#dialogGaji").remove();
	$("#divGaji").append('<div id="dialogGaji"></div>');
	$("#dialogGaji").dialog({
		title	: 'Set Gaji Yang Dibayarkan Untuk ' + nama,
		width	: 500,
		height	: 520,
		show	: 'fold',
		hide	: 'fold',
		draggable: false,
		resizable: false,
		modal	: true,
		open	: function(){
			$.ajax({
				type	: 'post',
				url		: 'views/form_gaji_dibayarkan.php',
				data	: 'userid='+id,
				success	: function(msg){
					$("#dialogGaji").html(msg);
				}
			});
		}
	});
}
function deleteUser(user){
	var c = confirm("Hapus data user "+user+"?");
	if(c) location.href = "index.php?mod=staffing/delete/"+user;
}
 
var grid = new dhtmlXGridFromTable("grid_managementUser");
grid.setImagePath("includes/dhtmlx/dhtmlxGrid/imgs/");
grid.setSkin("dhx_skyblue");
grid.enableAutoWidth(true,900,900);
grid.enableAutoHeight(true, 600,600);
grid.setSizes();
grid.setColTypes("ro,ro,ro,ro,ro,ro,ro");
</script>

<?php  
$this->registry->view->show('window_user');
$this->registry->view->show('window_userDetail');
$this->registry->view->show('window_userAccess');
?>
