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
	
	$('.detail').click(function(){
		var data = $(this).attr("id"); 
		data = data.split('_');
		
		 $("#window_taskDetail").load(location.href+" #window_taskDetail>*",
			{userid : data[0],
			taskid : data[1]}, 
			 function(){
				createWindow0(); 
				//alert(dataApprove);
		 });  
	})
	
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
	}	
})
</script>
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
<form name="frmReportTaskPeriod" id="frmReportTaskPeriod" style="margin-left:5px;" method="post" action="index.php?mod=reporting/taskperiod">
  <table>
    <tr> 
      <td><?php $this->registry->view->show("combo_project");?></td>
      <td><?php $this->registry->view->show("combo_user"); ?></td> 
      <td><?php 
				$this->registry->view->type="month";
				$this->registry->view->show("combo_date");?></td>        
      <td><?php 
				$this->registry->view->type="year";
				$this->registry->view->show("combo_date");?></td>
      <td><input type="submit" name="submitLapTaskPeriod" class="btn" value="Submit"/></td>
    </tr>
  </table>
</form>
<?php }?>
<div style="width:100% auto;text-align:center;">
<?php
		if (isset($_POST['submitLapTask'])){ 
			$project= $_POST['cmbProject'];
			$member	= $_POST['cmbUser'];
			$year	= $_POST['cmbYear'];
			$month	= $_POST['cmbMonth'];
			
		} 

		/*if(($_SESSION['level_id']!=3 || $_SESSION['position_id'] == 1)&&($url[0]=='reporting')){ */?>
            <!--div style="text-align:left;">
                <a href="rekaptasktoExcel.php?project=<?php //echo $project; ?>&member=<?php //echo $member; ?>&year=<?php //echo $year; ?>&month=<?php //echo $month; ?>"><img src="includes/img/excel.gif" alt="untuk mendownload excel" />Export to Excel</a>
            </div><br /-->
        <?php /*}*/
	
		?>       
	<table id="gridbox" align="center" width="635">

        <tr>
            <td width="1"> </td>
			<td>Nama</td>
			<!--td width="90" style="text-align:center;"><b>Tgl Mulai</b></td--> 
            <td>Tanggal</td>            
			<td width="55" style="text-align:center;" align="center"><b>Prioritas</b></td>
			<td width="400" style="text-align:center;" align="center"><b>Task</b></td>
            <td width="65" style="text-align:center;" align="center"><b>Status (%)</b></td>
			<td width="110" style="text-align:center;" align="center"><b>Target</b></td> 
		</tr>
       
		<?php 
		if(count($tasklistperiod)){
			foreach($tasklistperiod as $data){
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
					if(($_SESSION['level_id']!=3 || $_SESSION['position_id'] == 1))
						echo '	<td>'.$data->NAME.'</td>';
						echo '	<td align="center">'.$data->NAME_DAY.'</td>';
						//echo '	<td>'.$this->registry->mTask->get_initialTaskDate($data->TASK_ID, $data->USER_ID).'</td>';					
						//echo '	<td>'.$data->UPDATE_DTM.'</td>';
						echo '	<td align="center">'.$data->PRIORITY_ID.'</td>'; //new 20110607
						echo '	<td align="left"><a href="#detail" class="detail" id="'.$data->USER_ID.'_'.$data->TASK_ID.'">'.$data->TASK.'</a></td>';
						echo '	<td align="center">'.$data->STATUS.'</td>';
						echo '	<td align="center">'.$data->TARGET.'</td>';
						echo '</tr>';
				}
			}
		}
		?>
	</table>
</div>
<?php
if ($url[0] == 'reporting')
	$this->registry->view->show('window_taskDetail');
	

echo '<script>';
echo 'var dhxWins = null;';
echo 'var winFin = null;';
echo 'var dhxWins = new dhtmlXWindows();';
echo 'dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");';
echo 'dhxWins.setSkin("dhx_skyblue"); ';

echo 'grid = new dhtmlXGridFromTable("gridbox");';
echo 'grid.setImagePath("includes/dhtmlx/dhtmlxGrid/imgs/");';
echo 'grid.setSkin("dhx_black");';


echo 'grid.enableAutoWidth(true, 1300, 580);';

	
echo 'grid.enableAutoHeight(true, 500, 600);';
echo 'grid.setSizes();'; 

if($_SESSION['position_id'] == 1)
	echo 'grid.setColTypes("ro,ro,ro,ro,ro,ro");';
else
	echo 'grid.setColTypes("ro,ro,ro,ro,ro");';
		
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