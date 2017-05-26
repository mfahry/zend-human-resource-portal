<link rel="STYLESHEET" type="text/css" href="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxtabbar.css">
<script  src="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxcommon.js"></script>
<script  src="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxtabbar.js"></script>

<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxcommon.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgridcell.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_start.js"></script>

<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/validation_engine.css">
<script type="text/javascript" src="includes/JQuery/script/validation_engine.js"></script>
<script type="text/javascript" src="includes/JQuery/script/validation_engine-id.js"></script>
<?php
if((isset($_SESSION['level_id'])) &&  ($_SESSION['level_id']==2)){

	echo '	<div>
<a href="rekapabsenbulanan.php" target="_blank">statistik bulanan</a>
<br />
<br />
</div>';
} 
?>

<div id="a_tabbar" style="width:150%; height:400px;"/>
<div id='html_1'><?php $this->registry->view->show('grid_report_mingguan');?></div>
<div id='html_2'><?php $this->registry->view->show('grid_report_bulanan');?></div>
<div id='html_3'><?php $this->registry->view->show('grid_report_keluar_kantor');?></div>
<?php if((isset($_SESSION['level_id'])) && ($_SESSION['level_id']==2)){?>
<div id='html_4'><?php $this->registry->view->show('grid_statistik');?></div>
<?php } ?>
<div id='html_5'><?php $this->registry->view->show('grid_task');?></div>
<div id='html_6'><?php $this->registry->view->show('grid_userRecommend');?></div>
<?php if((isset($_SESSION['level_id'])) && ($_SESSION['level_id']==2)){?>
<div id='html_7'><?php $this->registry->view->show('grid_taskmonitor');?></div>
<?php }

echo '<script>';
echo 'tabbar = new dhtmlXTabBar("a_tabbar", "top");';
echo 'tabbar.setSkin("default");';
echo 'tabbar.setSkinColors("#CCCCCC", "#f9f9f9");';
echo 'tabbar.setImagePath("includes/dhtmlx/dhtmlxTabbar/codebase/imgs/");';
echo 'tabbar.enableAutoSize(true, true);';
echo 'tabbar.addTab("a1", "Laporan Mingguan", "150px");';
echo 'tabbar.addTab("a2", "Laporan Bulanan", "150px");';
echo 'tabbar.addTab("a3", "Laporan Keluar Kantor", "150px");';
	echo '	tabbar.addTab("a5", "Laporan Task", "150px");';
	echo '	tabbar.addTab("a6", "Status Rekomendasi", "150px");';
	
echo 'tabbar.setContent("a1","html_1");';
echo 'tabbar.setContent("a2","html_2");';
echo 'tabbar.setContent("a3","html_3");';
	echo '	tabbar.setContent("a5","html_5");';
	echo '	tabbar.setContent("a6","html_6");';


if((isset($_SESSION['level_id'])) &&  ($_SESSION['level_id']==2)){
	echo '	tabbar.addTab("a4", "Statistik", "150px");';
	echo '	tabbar.setContent("a4","html_4");';
	echo '	tabbar.addTab("a7", "Monitoring Task", "150px");';
	echo '	tabbar.setContent("a7","html_7");';
} 
 
$url = explode('/',$_GET['mod']);
if (isset($url[1]) && $url[1] == 'detailReport'){
	echo 'tabbar.setTabActive("a2");';
}
if(isset($setActive)){
	if($setActive=='3'){
		echo '	tabbar.setTabActive("a3");';
	}else if($setActive=='2'){
		echo '	tabbar.setTabActive("a2");';
	}else if($setActive=='4'){
		echo '	tabbar.setTabActive("a4");';
	}else if($setActive=='5'){
		echo '	tabbar.setTabActive("a5");';
	}else if($setActive=='6'){
		echo '	tabbar.setTabActive("a6");';
	}else if($setActive=='7'){
		echo '	tabbar.setTabActive("a7");';
	}else{
		echo '  tabbar.setTabActive("a1");';
	}
}else{
	echo '  tabbar.setTabActive("a1");';
}
echo '</script>';
?>
