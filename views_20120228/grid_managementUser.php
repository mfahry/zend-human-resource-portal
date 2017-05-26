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
<script type="text/javascript" src="includes/JQuery/script/validation_engine-id.js"></script> 

<img src="includes/img/user.gif" hspace="4"/><a href="#add" class="edit" id="add_0">Tambah User</a>
<table id="grid_managementUser">
  <tr>
    <th width="50">No</th>
    <th width="100">Username</th>
    <th width="250">Nama Lengkap</th>
    <th width="100">Level</th>
    <th width="100">HRD Status</th>
    <th width="100">Edit</th>
    <th width="100">Delete</th>
    <th width="100">Lock/Unlock</th>
  </tr>
  <?php 
  	if(count($datauser)>0){
		$i 	= 1;
		foreach($datauser as $data){ 
	?>
  <tr align="center">
    <td align="center"><?php echo $i++;  ?></td>
    <td><a href="#detail" class="detail" id="<?php echo $data->USER_ID; ?>"> <?php echo $data->USER_ID; ?></a></td>
    <td><?php echo ($data->HRDSTATUS==0)?'<font color="red" class="vtip" title=" Tidak aktif ">'.$data->NAME.'</font>':$data->NAME; ?></td>
    <td><?php echo $data->LEV_NAME; ?></td>
    <td>
	<?php 
		if($data->HRDSTATUS==0)		echo "<font color=\"red\">Tidak aktif</font>";
	  	elseif($data->HRDSTATUS==1)	echo "<font color=\"green\">Aktif</font>"; 
	?>
    </td>
    <td><a href="#edit" class="edit" id="edit_<?php echo $data->USER_ID; ?>">Edit</a></td>
    <td><a href="javascript:void(0)" onclick="deleteUser('<?php echo $data->USER_ID; ?>')" class="merah">Delete</a></td>
    <td><a href="#<?php echo ($data->STATUS_LOGIN==2)?'unlock':'lock'; ?>" 
    	class="<?php echo ($data->STATUS_LOGIN==2)?'unlock':'lock'; ?>" 
        id="<?php echo ($data->STATUS_LOGIN==2)?'unlock':'lock'; ?>_<?php echo $data->USER_ID; ?>">
        <?php echo ($data->STATUS_LOGIN==2)?'unlock':'<font color="green">lock</font>'; ?>
        </a> 
    </td>
  </tr>
  <?php 	}
	}
?>
</table>
<script>

	function deleteUser(user){
		var c = confirm("Hapus data user "+user+"?");
		if(c) location.href = "index.php?mod=staffing/delete/"+user;
	}
	 
	var grid = new dhtmlXGridFromTable("grid_managementUser");
	grid.setImagePath("includes/dhtmlx/dhtmlxGrid/imgs/");
	grid.setSkin("dhx_black");
	grid.enableAutoWidth(true,900,900);
	grid.enableAutoHeight(true, 600,600);
	grid.setSizes();
	grid.setColTypes("ro,ro,ro,ro,ro,ro,ro");
</script>

<?php  
$this->registry->view->show('window_user');
$this->registry->view->show('window_userDetail');
$this->registry->view->show('window_userAccess');
 /*
echo 	'<script>';

if($setWindowActive == 'detail'){
	echo 	'var dhxWins = new dhtmlXWindows();';
	echo 	'dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");';
	echo 	'dhxWins.setSkin("dhx_skyblue");';
	echo 	'document.getElementById("adminUserDetail").style.display = "block";';
	echo 	'var winFin = dhxWins.createWindow("w1", 400, 150, 430, 300);';
	echo 	'winFin.attachObject("adminUserDetail");';
	echo 	'winFin.setText("User Detail");';
	//echo 	'winFin.setModal(true);';
	echo 	'winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");';
	//echo 	'winFin.denyResize();';
	//echo 	'winFin.denyMove();';
	//echo 	'winFin.button("close").hide();';
	echo 	'winFin.button("park").hide();';
	//echo 	'winFin.button("minmax1").hide();';
	//echo 	'winFin.button("minmax2").hide();';
}else if($setWindowActive == 'edit'){
	echo 	'var dhxWins = new dhtmlXWindows();';
	echo 	'dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");';
	echo 	'dhxWins.setSkin("dhx_skyblue");';
	echo 	'document.getElementById("form_user").style.display = "block";';
	echo 	'var winFin = dhxWins.createWindow("w1", 400, 150, 430, 400);';
	echo 	'winFin.attachObject("form_user");';
	echo 	'winFin.setText("Add/Edit Data User");';
	echo 	'winFin.setModal(true);';
	echo 	'winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");';
	echo 	'winFin.denyResize();';
	//echo 	'winFin.denyMove();';
	//echo 	'winFin.button("close").hide();';
	echo 	'winFin.button("park").hide();';
	echo 	'winFin.button("minmax1").hide();';
	echo 	'winFin.button("minmax2").hide();';
}else if($setWindowActive = 'unlock'){
	echo 	'var dhxWins = new dhtmlXWindows();';
	echo 	'dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");';
	echo 	'dhxWins.setSkin("dhx_skyblue");';
	echo 	'document.getElementById("adminUserAccess").style.display = "block";';
	echo 	'var winFin = dhxWins.createWindow("w1", 300, 200, 400, 300);';
	echo 	'winFin.attachObject("adminUserAccess");';
	echo 	'winFin.setText("Lock/Unlock User");';
	echo 	'winFin.setModal(true);';
	echo 	'winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");';
	echo 	'winFin.denyResize();';
	echo 	'winFin.denyMove();';
	//echo 	'winFin.button("close").hide();';
	echo 	'winFin.button("park").hide();';
	echo 	'winFin.button("minmax1").hide();';
	echo 	'winFin.button("minmax2").hide();';
}
echo 	'</script>';*/
?>
