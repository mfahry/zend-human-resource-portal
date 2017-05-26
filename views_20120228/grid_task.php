<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_black.css">
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
<link type="text/css" href="includes/JQuery/ui/css/neuron/jquery-ui-1.8.17.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="includes/JQuery/ui/js/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript">
$(function() {
      $("#frmReportTaskbisaall").validationEngine({
		inlineValidation: false,
		success :  false
		// promptPosition: "bottomLeft"
	   });
	    

	var dhxWins = null;
	var dhxWins = new dhtmlXWindows();
	dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");
	dhxWins.setSkin("dhx_skyblue");
	
	/*$('.detail').click(function(){
		var data = $('.detail').attr("id"); 
		data = data.split('_');
		//alert( $('.detail').attr("id") );
		$("#window_taskDetail").load(location.href+" #window_taskDetail>*",
		{userid : data[0], taskid : data[1]}, 
		function(){
			createWindow0(); 
			//alert(dataApprove);
		});  
	});
	
	function createWindow0(){
		if (!dhxWins.window("winFin")) {
			document.getElementById("window_taskDetail").style.display = "block";
			var winFin = dhxWins.createWindow("w1", 300, 200, 360, 230);
			winFin.setText("Detail Task");
			winFin.setModal(true); 
			winFin.button("park").hide();
			winFin.button("minmax1").hide();
			winFin.button("minmax2").hide();
			winFin.attachEvent("onClose",function(win){
				if (win.getId() == "w1") {
					win.detachObject();
					win.hide();
					winFin.setModal(false);
				}
			})
		}else{
			var w1 = dhxWins.window("winFin");
			w1.show();
		}
		winFin.attachObject("window_taskDetail"); 
	}*/
});

function detailTask(userid,taskid){
	$("#winDetailTask").dialog("close");
	$("#winDetailTask").remove();
	$("#taskDetail").append('<div id="winDetailTask"></div>');
	$("#winDetailTask").dialog({
		title	: "Detail Task",
		width	: 350,
		show	: "fold",
		hide	: "fold",
		resizable: false,
		modal	: true,
		open	: function(){
			$.ajax({
				type: "POST",
				url	: "views/window_taskDetail.php",
				data: "userid="+userid+"&taskid="+taskid,
				success: function(msg){
					$("#winDetailTask").html(msg);
				}
			});
		},
		close	: function(){
			$("#winDetailTask").dialog("close");
			$("#winDetailTask").remove();
		},
		buttons	: {
			"Close" : function(){
				$("#winDetailTask").dialog("close");
				$("#winDetailTask").remove();			
			}
		}
	});
}

function winTask(){
	$("#taskWide").dialog({
		width	: 900,
		title	: 'Task',
		show	: 'slide',
		hide	: 'slide',
		resizable: false,
		open	: function(){
			$("#taskWide").show();
		},
		buttons	:{
			"Close": function(){
				$("#taskWide").hide();
				$("#taskWide").dialog('close');
			}
		}
	});
}
</script>
<style>
#taskWide{
	display:none;
	padding: 10px;
}
#taskWide table{
	border:1px solid #ccc;
	border-collapse: collapse;
}
#taskWide table td.hdrGrid{
	border:1px solid #ccc;
	border-collapse: collapse;
	background: url('includes/JQuery/ui/css/blitzer/images/ui-bg_highlight-soft_15_cc0000_1x100.png');
	font-size: 14px;
	color: #fff;
	font-weight: bold;
	padding: 5px;
	text-align:center;
}
#taskWide table td{
	border:1px solid #ccc;
	border-collapse: collapse;
	background: #fff;
}
</style>
<?php

if(isset($_GET['userid'])){
	$task = $this->registry->mTask->update_userTaskStatus($_GET['userid']);
	if($task) {
		echo "<script>$(function(){
					self.location.href='?mod=attendance';
					});</script>";
	}
}

$url = explode('/',$_GET['mod']);
if($url[0]=='reporting') {?>
<form name="frmReportTask" id="frmReportTask" style="margin-left:5px;" method="post" action="index.php?mod=reporting/task">
  <table>
    <tr> 
      <td><?php $this->registry->view->show("combo_project");?></td>
     <?php if($_SESSION['position_id'] == 1 || $_SESSION['level_id']==2){ ?>
      <td><?php $this->registry->view->show("combo_user"); ?></td> 
     <?php } ?>
      <td><?php 
				$this->registry->view->type="month";
				$this->registry->view->show("combo_date");?></td>
      <?php if($_SESSION['position_id'] == 1 || $_SESSION['level_id']==2){ ?>
      <td><?php 
				$this->registry->view->type="date";
				$this->registry->view->show("combo_date");?></td>
      <?php } ?>          
      <td><?php 
				$this->registry->view->type="year";
				$this->registry->view->show("combo_date");?></td>
      <td><input type="submit" name="submitLapTask" class="btn" value="Submit"/></td>
    </tr>
  </table>
</form>
<?php }

if($url[0]=='attendance'){ ?>
<div style="width:100%;text-align:center;padding:5px 0;">
	<a href="#" onclick="add()"><b>Tambah task</b></a> 
	| <a href="#" onclick="delete_r()"><b>Hapus task</b></a> 
	| <a href="#" onclick="winTask()"><b>Maximize</b></a></li>
</div>
<?php
} 
?>
<div style="width:100% auto;text-align:center;">
<?php
		if (isset($_POST['submitLapTask'])){ 
			$project= $_POST['cmbProject'];
			$member	= $_POST['cmbUser'];
			$year	= $_POST['cmbYear'];
			$month	= $_POST['cmbMonth'];
			//if($month<10) $month = "0$month";
			
			if($_POST['cmbMonth'] == '') 	$month	 = date('m');
			if($_POST['cmbYear'] == '') 	$year	 = date('Y');
			if($_POST['cmbUser'] == '')  	$member  = $_SESSION['userid'];
			if($_POST['cmbProject'] == '')	$project = '';
		} 

		//if(($_SESSION['level_id']!=3 || $_SESSION['position_id'] == 1)&&($url[0]=='reporting')){
		if($url[0]=='reporting'){
		
			if($month=='') 	 $month	  = date('m');
			if($year=='') 	 $year	  = date('Y');
			if($member=='')  $member  = $_SESSION['userid'];
			if($project=='') $project = '';
		?>
            <div style="text-align:left;" id="taskDetail">
                <a href="rekaptasktoExcel.php?project=<?php echo $project; ?>&member=<?php echo $member; ?>&year=<?php echo $year; ?>&month=<?php echo $month; ?>"><img src="includes/img/excel.gif" alt="untuk mendownload excel" />Export to Excel</a>
            </div><br />
        <?php 
		}
		?>       
	<table id="gridbox" align="center" width="<?=($url[0]=="reporting"? "750":"635")?>">
		<input name="CalendarIDperiod" type="hidden" value="1<?php echo $calendar_id;?>" />
        <tr>
            <td width="1"> </td>
            <?php if(($_SESSION['level_id']!=3 || $_SESSION['position_id'] == 1)&&($url[0]=='reporting')){ ?>
				<td>Nama</td>
             <?php } ?>
			<!--td width="90" style="text-align:center;"><b>Tgl Mulai</b></td-->             
			<td width="55" style="text-align:center;" align="center"><b>Prioritas</b></td>
			<td width="400" style="text-align:center;" align="center"><b>Task</b></td>
            <td width="65" style="text-align:center;" align="center"><b>Status (%)</b></td>
			<td width="110" style="text-align:center;" align="center"><b>Target</b></td>
            <?php 
			if($url[0]=='reporting') echo '<td width="110" style="text-align:center;" align="center">Posted Date</td>';
            ?>
		</tr>
       
		<?php 
		if(count($tasklist)){
			foreach($tasklist as $data){
				if($url[0]=='attendance'){
					if($data->STATUS < 100){
						echo '<tr>';
						echo '	<td style="color:transparent;">'.$data->TASK_ID.'</td>'; 
						//echo '	<td>'.$this->registry->mTask->get_initialTaskDate($data->TASK_ID, $data->USER_ID).'</td>';
						echo '	<td align="center">'.$data->PRIORITY_ID.'</td>'; //new 20110607
						echo '	<td align="left">'.$data->TASK.'</td>';
						echo '	<td align="center">'.$data->STATUS.'</td>';
						echo '	<td align="center">'.$data->TARGET.'</td>';						
						echo '</tr>';
					}
				}else{
					echo '<tr>';
					echo '	<td style="color:transparent;">'.$data->TASK_ID.'</td>';
					
					if(($_SESSION['level_id']!=3 || $_SESSION['position_id'] == 1)) echo '	<td>'.$data->NAME.'</td>';
					
					echo '	<td align="center">'.$data->PRIORITY_ID.'</td>'; //new 20110607
					echo '	<td align="left"><a href="#detail" class="detail" onclick="detailTask('.$data->USER_ID.','.$data->TASK_ID.')" id="'.$data->USER_ID.'_'.$data->TASK_ID.'">'.$data->TASK.'</a></td>';
					echo '	<td align="center">'.$data->STATUS.'</td>';
					echo '	<td align="center">'.$data->TARGET.'</td>';
					echo '	<td align="center">'.$data->UPDATE_DTM.'</td>';					
					echo '</tr>';
				}
			}
		}
		?>
	</table>
	<div id="taskWide">
	<table id="gridBox2" align="center" width="751">
        <tr>
			<td width="1"> </td>
			<td width="55" align="center"><b>Prioritas</b></td>
			<td width="400" align="center"><b>Task</b></td>
            <td width="75" align="center"><b>Status (%)</b></td>
			<td width="110" align="center"><b>Target</b></td> 
			<td width="110" align="center"><b>Date</b></td> 
		</tr>
       
		<?php 
		if(count($tasklist)){
			foreach($tasklist as $data2){
				if($data2->STATUS < 100){
					echo '<tr>';
					echo '	<td style="color:transparent;">'.$data2->TASK_ID.'</td>';
					echo '	<td align="center">'.$data2->PRIORITY_ID.'</td>';
					echo '	<td align="left">'.$data2->TASK.'</td>';
					echo '	<td align="center">'.$data2->STATUS.'</td>';
					echo '	<td align="center">'.$data2->TARGET.'</td>';						
					echo '	<td align="center">'.$data2->UPDATE_DTM.'</td>';						
					echo '</tr>';
				}
			}
		}
		?>
	</table>
	</div>
</div>
<?php
if($url[0]=='attendance')
	$this->registry->view->show('window_inputTask');
	
if ($url[0] == 'reporting')
	$this->registry->view->show('window_taskDetail');
	

echo '<script>';
echo 'var dhxWins = null;';
echo 'var winFin = null;';
echo 'var dhxWins = new dhtmlXWindows();';
echo 'dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");';
echo 'dhxWins.setSkin("dhx_skyblue"); ';

echo 'function add_r() {';
 
echo 	'var ind1= document.getElementById("inputTask").value;';
echo	'var ind2= document.getElementById("prosentaseTask").value;';
echo	'var ind3= document.getElementById("priorityTask").value;';
echo 		'if(ind2<=100){';
echo 			'grid.addRow(grid.uid(), ["'.$_SESSION['userid'].'", "",ind1, ind2, ind3], 0);';
echo 			'grid2.addRow(grid2.uid(), ["'.$_SESSION['userid'].'", "",ind1, ind2, ind3], 0);';
echo 			'parent.winFin.close();';
echo 		'}else{';
echo 			'$.validationEngine.buildPrompt("#frmWindowInputTask #prosentaseTask #priorityTask","* Prosentase tidak boleh lebih dari 100","error");';
echo 		'}';
echo '}';


echo 'function add() {'; 
echo 	'if (!dhxWins.window("winFin")) {';
echo	'	document.getElementById("windowInputTask").style.display = "block";';
echo	'	winFin = dhxWins.createWindow("w1", 500, 200, 550, 300);'; 
echo	'	winFin.setText("Input Task");';
echo	'	winFin.setModal(true);';
echo	'	winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");';
echo	'	winFin.allowResize();';
echo	'	winFin.allowMove();';
echo	'	winFin.button("park").hide();';
echo	'	winFin.button("minmax1").hide();';
echo	'	winFin.button("minmax2").hide();';
echo	'	winFin.attachEvent("onClose",function(win){';
echo	'		if (win.getId() == "w1") {';
echo 	'			win.detachObject();';
echo 	'			win.hide();';
echo	'			winFin.setModal(false);';
echo 	'		}';
echo 	'	})';
echo 	'}else{';
echo 	'	var w1 = dhxWins.window("winFin");';
echo 	'	w1.show();';
echo 	'}';
echo 	'winFin.attachObject("windowInputTask");';
echo '}';


echo 'function delete_r() {';
echo '	if(grid.getSelectedId()){';
echo '		var ind1 = confirm("Yakin menghapus task ini?");';
echo '    	if (ind1){';
echo '    		grid.deleteRow(grid.getSelectedId());';
echo			'alert("Task telah dihapus");';
echo '	  	}';
echo '	}else{';
echo 		'alert("Pilih task yang akan dihapus");';
echo '	}';
echo '}';

echo 'grid = new dhtmlXGridFromTable("gridbox");';
echo 'grid.setImagePath("includes/dhtmlx/dhtmlxGrid/imgs/");';
echo 'grid.setSkin("dhx_black");';

if(($_SESSION['level_id']!=3 || $_SESSION['position_id'] == 1)&&($url[0]=='reporting'))
	echo 'grid.enableAutoWidth(true, 1300, 580);';
else
	echo 'grid.enableAutoWidth(true, '.($url[0]=='reporting'?750:640).', 580);';
	
echo 'grid.enableAutoHeight(true, 500, 600);';
echo 'grid.setSizes();'; 
	
if($url[0]=='attendance'){
	echo 'grid.setColTypes("ro,ed,txt,ed,ed");'; 
?>
grid.attachEvent("onEditCell",function(stage,rowId,cInd){
    if(cInd==3 && stage==1){
        grid.editor.obj.onkeypress = function(e){
            if(this.value > 101){
				alert('maksimum 100');
				this.value='';
                return false;
            } else {
				return true;
			}
        }
    }
    return true;
});

<?php
}else{
	if($_SESSION['position_id'] == 1)
		echo 'grid.setColTypes("ro,ro,ro,ro,ro,ro");';
	else
		echo 'grid.setColTypes("ro,ro,ro,ro,ro");';
}
/*
echo "\n";
echo 'grid2 = new dhtmlXGridFromTable("gridbox2");';
echo "\n";
echo 'grid2.setImagePath("includes/dhtmlx/dhtmlxGrid/imgs/");';
echo "\n";
echo 'grid2.setSkin("dhx_black");';
echo "\n";
echo 'grid2.enableAutoWidth(true, 750, 580);';	
echo "\n";
echo 'grid2.enableAutoHeight(true, 500, 600);';
echo "\n";
echo 'grid2.setSizes();'; 
echo "\n";
	
echo 'grid2.setColTypes("ro,ed,txt,ed,ed");'; 
echo "\n";
?>
grid2.attachEvent("onEditCell",function(stage,rowId,cInd){
    if(cInd==3 && stage==1){
        grid2.editor.obj.onkeypress = function(e){
            if(this.value > 100){
				alert('maksimum 100');
				this.value='';
                return false;
            } else {
				return true;
			}
        }
    }
    return true;
});

<?php
*/

echo 'myDataProcessor = new dataProcessor("model/task_ajax.php");';
echo 'myDataProcessor.setTransactionMode("POST", true);';
echo 'myDataProcessor.attachEvent("onAfterUpdate", function() {
		var myDate = new Date();
		var jam = parseInt(myDate.getHours());
		if((arguments[1]=="update") && (jam >= 16)) location.href = "index.php?mod=attendance/index/activateTabAbsen";
		else location.reload();
	});';
echo 'myDataProcessor.init(grid);';
echo '</script>';
?>