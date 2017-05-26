<link rel="STYLESHEET" type="text/css" href="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxtabbar.css">
<script  src="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxcommon.js"></script>
<script  src="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxtabbar.js"></script>
<script src="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxcontainer.js"></script>

<div id="a_tabbar" style="width:600px; height:600px;"/>
<div id='html_1'>
  <?php $this->registry->view->show('form_home');?>
</div>
<div id='html_2' style="width: 600px; height: 500px;">
  <?php $this->registry->view->show('form_profile');?>
</div>
<div id='html_3' style="width: 600px; height:auto;">
  <?php $this->registry->view->show('form_cv');?>
</div>
<script type="text/javascript">
function ambilCookie(nama_variabel){
	var awal;
	var akhir;
	if(document.cookie.length>0){
		if(document.cookie.indexOf(nama_variabel)!=-1){
			awal = awal+nama_variabel.length+1;
			akhir = document.cookie.length;
			return unescape(document.cookie.substring(awal,akhir));
		}
	}
}

function tulisCookie(nama_variabel,nilai){
	document.cookie=nama_variabel+ "=" +escape(nilai);
}
</script>
<?php

if(!isset($setActive)){
	$setActive = '1';
}else{
	setcookie("x",$setActive);
}

$sessionHRD = $_SESSION['level_id'];
setcookie("session",$sessionHRD);
?>
<?php
echo '<script>';
echo 'tabbar = new dhtmlXTabBar("a_tabbar", "top");';
echo 'tabbar.setSkin("dhx_skyblue");';
echo 'tabbar.setImagePath("includes/dhtmlx/dhtmlxTabbar/codebase/imgs/");';
echo 'tabbar.enableAutoSize(true, true);';
echo 'tabbar.addTab("a1", "My Status", "150px");';
echo 'tabbar.addTab("a2", "My Profile", "150px");';
echo 'tabbar.addTab("a3", "My Curriculum Vitae", "150px");';
echo 'tabbar.setContent("a1","html_1");';
echo 'tabbar.setContent("a2","html_2");';
echo 'tabbar.setContent("a3","html_3");';


//setActive = ambilCookie("x");
if($setActive=='2'){
echo '	tabbar.setTabActive("a2");';
}elseif($setActive=='3'){
echo '	tabbar.setTabActive("a3");';
}else{
echo '  tabbar.setTabActive("a1");';
}	
echo '</script>';
?>
