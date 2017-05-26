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

<div id="a_tabbar" style="width:150%; height:400px;">
	<div id='html_1'>
		<?php 
		if($_SESSION['level_id']==3)
			$this->registry->view->show('window_fullRecommendation');
		else 
			$this->registry->view->show('grid_absenEmployee');
		?>
	</div>
	<div id='html_2'>
		<?php 
		$this->registry->view->show('grid_userRecommend');
		
		echo '<script>';
		echo '	tabbar = new dhtmlXTabBar("a_tabbar", "top");';
		echo '	tabbar.setSkin("dhx_skyblue");';
		echo '	tabbar.setImagePath("includes/dhtmlx/dhtmlxTabbar/codebase/imgs/");';
		echo '	tabbar.enableAutoSize(true, true);';
		echo '	tabbar.addTab("a1", "Rekomendasi", "150px");';
		echo '	tabbar.addTab("a2", "Status Rekomendasi", "150px");';
		echo '	tabbar.setContent("a1","html_1");';
		echo '	tabbar.setContent("a2","html_2");';
		
		if($tabActive==1)
			echo '	tabbar.setTabActive("a1");';
		else
			echo '	tabbar.setTabActive("a2");';
		echo '</script>';
		?>
	</div>
</div>