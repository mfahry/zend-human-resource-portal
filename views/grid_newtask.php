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

<script type="text/javascript">
$(function() {
      $("#frmReportTask").validationEngine({
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
$url = explode('/',$_GET['mod']);
if($url[0]=='reporting') {?>
<form name="frmReportTask" id="frmReportTask" style="margin-left:5px;" method="post" action="index.php?mod=reporting/task">
  <table>
    <tr> 
    <?php if($_SESSION['position_id'] == 1 || $_SESSION['level_id']==2){ ?>
      <td><?php $this->registry->view->show("combo_user"); ?></td> 
     <?php } ?>
      <td><?php 
				$this->registry->view->type="month";
				$this->registry->view->show("combo_date");?></td>
      <td><?php 
				$this->registry->view->type="year";
				$this->registry->view->show("combo_date");?></td>
      <td><input type="submit" name="submitTask" class="btn" value="Submit"/></td>
    </tr>
  </table>
</form>
<?php }

if($url[0]=='attendance'){ ?>
<ul>
	<li><a href="#" onclick="add()"> &nbsp; Tambah task</a></li>
	<li><a href="#" onclick="delete_r()">&nbsp; Hapus task</a></li>
</ul>
<?php } ?>
	<table id="gridbox">

        <tr>
            <td> </td>
			<td width="110">Tgl Mulai</td> 
            <?php if(($_SESSION['level_id']!=2 || $_SESSION['position_id'] == 1)&&($url[0]=='reporting')){ ?>
				<td>Nama</td>
             <?php } ?>
			<td width="400">Task</td>
			<td width="65">Status (%)</td> 
		</tr>
       <?php 
			//$i 			= 1;
			$datatask = $this->registry->mTask->selectDB_orgtask($_SESSION['userid'],$orgid);
			if(count($datatask)>0){				
				foreach($datatask as $data){ 
			?>
		  <tr>
			<!--<td><?php // echo $i++;  ?></td>-->
			<td><?php echo $this->registry->mUser->get_fullName($data->USER_ID); ?></td>
			<td><?php echo $this->registry->mTask->get_initialTaskDate($data->TASK_ID, $data->USER_ID);	?></td>            
			<td><?php echo ($data->TASK);?></td>
            <td><?php echo ($data->STATUS);?></td>
            
		  </tr>
	  	<?php	
				}
			/ 
		?>
		<!--<?php 
		/*if(count($tasklist)){
			foreach($tasklist as $data){
				if($url[0]=='attendance'){
					if($data->STATUS < 100){
						echo '<tr>';
						echo '	<td style="color:transparent;">'.$data->TASK_ID.'</td>'; 
						echo '	<td>'.$this->registry->mTask->get_initialTaskDate($data->TASK_ID, $data->USER_ID).'</td>';
						echo '	<td>'.$data->TASK.'</td>';
						echo '	<td>'.$data->STATUS.'</td>'; 
						echo '</tr>';
					}
				}else{
					echo '<tr>';
					echo '	<td style="color:transparent;">'.$data->TASK_ID.'</td>';
					echo '	<td>'.$this->registry->mTask->get_initialTaskDate($data->TASK_ID, $data->USER_ID).'</td>';
					if(($_SESSION['level_id']!=3 || $_SESSION['position_id'] == 1))
						echo '	<td>'.$data->NAME.'</td>';
 					echo '	<td><a href="#detail" class="detail" id="'.$data->USER_ID.'_'.$data->TASK_ID.'">'.$data->TASK.'</a></td>';
					echo '	<td>'.$data->STATUS.'</td>'; 
					echo '</tr>';
				}
			}
		}*/
		?>-->
	</table>

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

/*if (isset($url[1]) && $url[1] == 'taskDetail'){
echo '	if (!dhxWins.window("winFin")) {';
echo '		document.getElementById("window_taskDetail").style.display = "block";';
echo '		winFin = dhxWins.createWindow("w3", 400, 200, 400, 400);';
echo '		winFin.setText("Detail Task");';
echo '		winFin.setModal(true); ';
echo '		winFin.button("park").hide();';
echo '		winFin.button("minmax1").hide();';
echo '		winFin.button("minmax2").hide();';
echo '		winFin.attachEvent("onClose",function(win){';
echo '			if (win.getId() == "w3") {';
echo '				win.detachObject();';
echo '				win.hide();';
echo '				winFin.setModal(false);';
echo '			}';
echo '		})';
echo '	}else{';
echo '		var w1 = dhxWins.window("winFin");';
echo '		w1.show();';
echo '	}';
echo 'winFin.attachObject("window_taskDetail");';
}*/

echo 'function add_r() {';
 
echo 	'var ind1= document.getElementById("inputTask").value;';
echo	'var ind2= document.getElementById("prosentaseTask").value;';
//echo 	'if((ind1!="") && (ind2!="")){';
echo 		'if(ind2<=100){';
echo 			'grid.addRow(grid.uid(), ["'.$_SESSION['userid'].'", "",ind1, ind2], 0);';
echo 			'parent.winFin.close();';
echo 		'}else{';
echo 			'$.validationEngine.buildPrompt("#frmWindowInputTask #prosentaseTask","* Prosentase tidak boleh lebih dari 100","error");';
echo 		'}';
//echo 	'}else{';
//echo 	'alert("Anda harus mengisi semua field");';
//echo 	'}';
echo '}';


echo 'function add() {'; 
echo 	'if (!dhxWins.window("winFin")) {';
echo	'	document.getElementById("windowInputTask").style.display = "block";';
echo	'	winFin = dhxWins.createWindow("w1", 500, 200, 400, 300);'; 
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
echo 'grid.setSkin("dhx_skyblue");';
if(($_SESSION['level_id']!=3 || $_SESSION['position_id'] == 1)&&($url[0]=='reporting'))
	echo 'grid.enableAutoWidth(true, 1300, 580);';
else
	echo 'grid.enableAutoWidth(true, 600, 580);';
	
echo 'grid.enableAutoHeight(true, 500, 600);';
echo 'grid.setSizes();'; 
	
if($url[0]=='attendance')	
	echo 'grid.setColTypes("ro,ro,txt,ed");'; 
else{
	if($_SESSION['position_id'] == 1)
		echo 'grid.setColTypes("ro,ro,ro,ro,ro");';
	else
		echo 'grid.setColTypes("ro,ro,ro,ro");';
}
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