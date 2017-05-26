<link rel="STYLESHEET" type="text/css" href="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxtabbar.css">
<script  src="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxcommon.js"></script>
<script  src="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxtabbar.js"></script>
<script src="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxcontainer.js"></script>

<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxcommon.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgridcell.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_start.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_validation.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxdataprocessor.js"></script>
<script type="application/javascript">
$(function(){
	waitPreloadPageIn();	   
});
</script>
<div id="prepagein" align="center" style="height:100%;width:100%;background:#fff;">
	<img src="includes/img/loading.gif" style="padding-top:200px;" />
</div>

<!--div id="a_tabbar" style="width:150%; height:400px;"/-->
<div id='html_4'>
	<?php 
	if($_SESSION['level_id']==3){
			$this->registry->view->show('window_fullRecommendation');
	}
	?>
</div>
<?php
$jamPulang = NULL;
$absenTypeid = NULL;
$now = $this->registry->mCalendar->getTime();

if(count($dataAbsentHomeYesterday)<=0){
	if(count($getAbsentToday) > 0){ 
		foreach($getAbsentToday as $dataCek){
			$jamPulang 	= $dataCek->OUT_TIME;
		}
	}
}
//echo count($getAbsentToday);

if($jamPulang != NULL){
	$this->registry->view->show("confirm_goodBye");		
	
}else{
	//edit disini
	if((count($getAbsentYesterday) === 0) || ($absenType_id==0)) $this->registry->view->show('confirm_notAbsent');
	if(count($dataAbsentHomeYesterday)>0) $this->registry->view->show('confirm_absenHome');
	//sampai sini
	
	//if($_SESSION['level_id']==3) $this->registry->view->show('window_fullRecommendation');
	//echo count($getAbsentYesterday);
	echo '<div id="a_tabbar" style="width:640px; height:400px;"></div>';
	echo '<div id="html_1">';$this->registry->view->show('grid_task');echo'</div>';
	echo '<div id="html_2">';isset($tab2)?$this->registry->view->show($tab2):'';echo'</div>';
	echo '<div id="html_3">';isset($tab3)?$this->registry->view->show($tab3):'';echo'</div>';
	if($_SESSION['userid']=='75080710'){
		echo '<div id="html_5">';$this->registry->view->show('grid_rekap_absen');echo'</div>';
	}
}

echo '<script>';
echo 'tabbar = new dhtmlXTabBar("a_tabbar", "top");';
echo 'tabbar.setSkin("default");';
echo 'tabbar.setSkinColors("#CCCCCC", "#f9f9f9");';
echo 'tabbar.setImagePath("includes/dhtmlx/dhtmlxTabbar/codebase/imgs/");';
echo 'tabbar.enableAutoSize(true, true);';
echo 'tabbar.addTab("a1", "Task", "100px");';
echo 'tabbar.addTab("a2", "Absensi Harian", "100px");';
echo 'tabbar.addTab("a3", "Absensi Keluar", "100px");';
echo 'tabbar.addTab("a4", "Rekomendasi", "100px");';
if($_SESSION['userid']=='75080710'){
	echo 'tabbar.addTab("a5", "Rekap Absen", "100px");';
}
echo 'tabbar.setContent("a1","html_1");';
echo 'tabbar.setContent("a2","html_2");';
echo 'tabbar.setContent("a3","html_3");';
echo 'tabbar.setContent("a4","html_4");';
if($_SESSION['userid']=='75080710'){
	echo 'tabbar.setContent("a5","html_5");';
}

#if, task kurang dari 100% == 0 (harus input task dulu sblm absen)
$currentask = 0;
if(count($tasklist)> 0){
	foreach($tasklist as $task){
		if($task->STATUS < 100) $currentask++;
	}
}

if($currentask == 0){	
	echo 'tabbar.disableTab("a2",true);';
	echo 'tabbar.disableTab("a3",true);';
	//echo 'tabbar.disableTab("a4",true);';
	echo 'tabbar.setTabActive("a1");';
	//echo 'alert("Isikan task anda terlebih dahulu!");';
}

if(count($dataAbsentHomeYesterday)<=0){
	if(count($getAbsentToday) == 0){ 
		# belum absen utk hari ini
		echo 'tabbar.disableTab("a3",true);';
		echo 'tabbar.setTabActive("a2");';
	}else{
		if(($jamPulang == NULL) && ($now >= "16:00:00")){
			# edit by andri 31-8-2010
			//if(($now >= "16:00:00") && ($now <= "16:30:00")){
				if(count($getAbsentOut)>0){
					if(count($getAbsentBack)==0){
						# edit by andri 31-8-2010
						/*echo 'tabbar.disableTab("a3",true);';
						echo 'tabbar.setTabActive("a2");';*/	
						
						if($activateTabAbsen == NULL){
							//echo 'alert("Update task anda terlebih dahulu, baru absen pulang.");';
							//echo 'tabbar.disableTab("a2",true);';
							//echo 'tabbar.disableTab("a3",true);';
							echo 'tabbar.setTabActive("a1");';	
						}else{
							echo 'tabbar.disableTab("a3",true);';
							echo 'tabbar.setTabActive("a2");';	
						}
					}else{
						echo 'tabbar.disableTab("a2",true);';
						echo 'tabbar.setTabActive("a3");';
					}
				}else{
					# edit by andri 31-8-2010
					//echo 'tabbar.setTabActive("a2");';	
				//}
			//}else{
				# saatnya pulaaaang.... tapi harus isi task dulu
					if($activateTabAbsen == NULL){
						//echo 'alert("Update task anda terlebih dahulu, baru absen pulang.");';
						//echo 'tabbar.disableTab("a2",true);';
						//echo 'tabbar.disableTab("a3",true);';
						echo 'tabbar.setTabActive("a1");';	
					}else{
						echo 'tabbar.disableTab("a3",true);';
						echo 'tabbar.setTabActive("a2");';	
					}
				}
		}else{
			echo 'tabbar.disableTab("a2",true);';
			echo 'tabbar.setTabActive("a1");';	
		}
	}
}else{
	if(count($dataAbsentBackYesterday)>0){
		echo 'tabbar.disableTab("a1",true);';
		echo 'tabbar.disableTab("a2",true);';
		echo 'tabbar.setTabActive("a3");';
		# edit by andri 31-8-2010
	/*}else if(count($dataAbsentHomeYesterday)>0){
		echo 'tabbar.disableTab("a1",true);';
		echo 'tabbar.disableTab("a3",true);';
		echo 'tabbar.setTabActive("a2");';*/
	}else {
		# edit by andri 31-8-2010
		//echo 'tabbar.disableTab("a2",true);';
		//echo 'tabbar.disableTab("a3",true);';
		echo 'tabbar.setTabActive("a1");';
	}
}
echo '</script>';

?>

