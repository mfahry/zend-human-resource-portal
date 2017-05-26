<link rel="STYLESHEET" type="text/css" href="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxtabbar.css">
<script  src="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxcommon.js"></script>
<script  src="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxtabbar.js"></script>
<script src="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxcontainer.js"></script>

<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/skins/dhtmlxwindows_dhx_skyblue.css">
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcommon.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcontainer.js"></script>


<SCRIPT language="javascript" src="includes/JQuery/script/validation_engine.js"></SCRIPT>
<SCRIPT language="javascript" src="includes/JQuery/script/validation_engine-id.js"></SCRIPT>
<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/validation_engine.css"/> 

<div id="a_tabbar" style="width:150%;"/>
    <div id='html_1' align="left" style="width: 600px; height: 500px;"> 
    
      <?php $this->registry->view->show('grid_calendar');?>
    </div>
    <div id='html_2' style="width: 600px; height: 500px;">
    
      <?php $this->registry->view->show('grid_categoryKnowledge');?>
    </div>

<!--<div id='html_3' style="width: 600px; height: 500px;"><?php //$this->registry->view->show('grid_polling');?></div>
--> 
 
<?php

	if(!isset($setActive)){
		$setActive = '1';
	} 
 
	$url = explode('/',$_GET['mod']);
	if(isset($url[1])){
		if($url[1]== 'editCategory'){
			$this->registry->view->show('windowAdminEditCategory');
		}
	}
	
	if(!isset($setWindowActive)){
		$setWindowActive = '0';
	}
?>
<?php
echo '<script>';
echo 'tabbar = new dhtmlXTabBar("a_tabbar", "top");';
echo 'tabbar.setSkin("dhx_skyblue");';
echo 'tabbar.setImagePath("includes/dhtmlx/dhtmlxTabbar/codebase/imgs/");';
echo 'tabbar.enableAutoSize(true, true);';
echo 'tabbar.addTab("a1", "Kalendar", "150px");';
echo 'tabbar.addTab("a2", "Kategori Knowledge", "150px");';
//echo 'tabbar.addTab("a3", "Polling", "150px");';
echo 'tabbar.setContent("a1","html_1");';
echo 'tabbar.setContent("a2","html_2");';
//echo 'tabbar.setContent("a3","html_3");';



//setActive = ambilCookie("x");
if($setActive == '3'){
	echo '	tabbar.setTabActive("a3");';
}else if($setActive=='2'){
	echo '	tabbar.setTabActive("a2");';
}else{
	echo '  tabbar.setTabActive("a1");';
}


if($setWindowActive == '1'){
	echo 	'var dhxWins = new dhtmlXWindows();';
	echo 	'dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");';
	echo 	'dhxWins.setSkin("dhx_skyblue");';
	echo 	'document.getElementById("windowAdminEditCategory").style.display = "block";';
	echo 	'var winFin = dhxWins.createWindow("w1", 150, 150, 300, 300);';
	//echo	'winFin.window(windowAdminEditCategory).setDimension(300,400);';
	//echo	'var dim = winFin.window(id).getDimension();';
	echo 	'winFin.setPosition(400,200);';
	echo 	'winFin.setDimension(400,300);';
	echo 	'winFin.attachObject("windowAdminEditCategory");';
	echo 	'winFin.setText("Add/Edit Category");';
	echo 	'winFin.setModal(true);';
	echo 	'winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");';
	echo 	'winFin.denyResize();';
	echo 	'winFin.denyMove();';
	//echo 	'dhxWins.setSize();';
	//echo 	'winFin.button("close").hide();';
	echo 	'winFin.button("park").hide();';
	echo 	'winFin.button("minmax1").hide();';
	echo 	'winFin.button("minmax2").hide();';
}else if($setWindowActive == '2'){
	echo 	'var dhxWins = new dhtmlXWindows();';
	echo 	'dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");';
	echo 	'dhxWins.setSkin("dhx_skyblue");';
	echo 	'document.getElementById("windowAdminDeleteCategory").style.display = "block";';
	echo 	'var winFin = dhxWins.createWindow("w1", 150, 150, 300, 300);';
	echo 	'winFin.setPosition(400,200);';
	echo 	'winFin.setDimension(400,300);';
	echo 	'winFin.attachObject("windowAdminDeleteCategory");';
	echo 	'winFin.setText("Add/Edit Category");';
	echo 	'winFin.setModal(true);';
	echo 	'winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");';
	echo 	'winFin.denyResize();';
	echo 	'winFin.denyMove();';
	//echo 	'winFin.button("close").hide();';
	echo 	'winFin.button("park").hide();';
	echo 	'winFin.button("minmax1").hide();';
	echo 	'winFin.button("minmax2").hide();';
}

echo '</script>';
?>
