<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/skins/dhtmlxwindows_dhx_skyblue.css">
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcommon.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcontainer.js"></script> 
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcontainer.js"></script>
<script src="includes/js/createWindowRecommendation.js"></script>

<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/validation_engine.css">
<script type="text/javascript" src="includes/JQuery/script/validation_engine.js"></script> 
<script type="text/javascript" src="includes/JQuery/script/validation_engine-id.js"></script> 

<?php
if(!isset($setWindowActive)){
	$setWindowActive = '0';
} 
?>
<br>
<center>
  <strong>Absen pegawai (Team) tanggal <?php echo $this->registry->mCalendar->currentDate();?></strong>
  <table id="gridbox">
    <tr>
      <th width=30>No</th>
      <th width=110>Nama</th>
      <th width=200>Keterangan</th>
      <th width=135>Aksi</th>
    </tr>
    <?php 
	$i = 1;		
	foreach($datauser1 as $data){
		$typename = NULL;
		$typeid 	= $this->registry->mAbsensiHarian->selectDB_absensi_type($data->USER_ID, $calid);		
		if($typeid != NULL) $typename 	= $this->registry->mAbsenType->selectDB_typeAbsen($typeid);
		
		if($data->LEVEL_ID == 3){
	?>
    <tr>
      <td><?php echo $i++;  ?></td>
      <td><?php echo $data->NAME; ?></td>
      <td><?php echo $typename;?></td>
      <td><?php 
		if(strtolower($typename) != "sakit"){
	?>
        <a href="#sakit" class="sakit" id="<?php echo $data->USER_ID.'_'.$data->NAME.'_2';?>">Sakit </a>
        <?php
		}else
			echo "Sakit";
		
		echo '  |  ';
		
		if(strtolower($typename) != "izin"){
	?>
        <a href="#izin" class="sakit" id="<?php echo $data->USER_ID.'_'.$data->NAME.'_3';?>">Izin </a>
        <?php
		}else
			echo "Izin";
			
		echo '  |  ';
		
		?>
        <a href="index.php?mod=recommendation/actAbsenTabRekomendasi/<?php echo 4 ?>/<?php echo $data->USER_ID;?>">Rekomendasi</a></td>
    </tr>
    <?php 	
		}
	}
?>
  </table>
</center>
<?php
$this->registry->view->show('window_absenRekomendasi');
	$url = explode('/',$_GET['mod']);
	if(isset($url[1])){
		if($url[1] == 'actAbsensiRekomendasi'){
			$this->registry->view->show('window_absenRekomendasi');
		}else if($url[1] == 'actAbsenTabRekomendasi'){
			$this->registry->view->show('window_Recommendation'); //revision 20110606
			//$this->registry->view->show('window_fullRecommendation');
		}
	}
?>
<?php 
echo	'<script>';
//untuk membuat grid

echo	'grid = new dhtmlXGridFromTable("gridbox");';
echo	'grid.setImagePath("includes/dhtmlx/dhtmlxGrid/codebase/imgs/");';
echo	'grid.setSkin("dhx_black");';
echo	'grid.enableAutoWidth(true, 800, 780);';
echo	'grid.enableAutoHeight(true, 100, 100);';
//echo	'grid.setSizes();';
echo	'grid.setColTypes("ro,ro,ro,ro");';
//echo 	'grid.setAwaitedRowHeight(200);';


//fungsi untuk membuat window,sakit, dan rekomendasi

if($setWindowActive == '1'){
	echo	'var dhxWins = new dhtmlXWindows();';
	echo	'dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");';
	echo	'dhxWins.setSkin("dhx_black");';

	echo	'document.getElementById("window_absenRekomendasi").style.display = "block";';
	echo	'var winFin = dhxWins.createWindow("w1", 300, 200, 500, 400);';
	echo	'winFin.attachObject("window_absenRekomendasi");';
	echo	'winFin.setText("Rekomendasi");';
	echo	'winFin.setModal(true);';
	echo	'winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");';
	echo	'winFin.allowResize();';
	echo	'winFin.allowMove();';
	//echo	'winFin.button("close").hide();';
	echo	'winFin.button("park").hide();';
	echo	'winFin.button("minmax1").hide();';
	echo	'winFin.button("minmax2").hide();';
}else if($setWindowActive == '2'){
	echo	'var dhxWins = new dhtmlXWindows();';
	echo	'dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");';
	echo	'dhxWins.setSkin("dhx_black");';

	echo	'document.getElementById("window_fullRecommendation").style.display = "block";';
	echo	'var winFin = dhxWins.createWindow("w1", 300, 100, 650, 650);';
	echo	'winFin.attachObject("window_fullRecommendation");';
	echo	'winFin.setText("Rekomendasi");';
	echo	'winFin.setModal(true);';
	echo	'winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");';
	echo	'winFin.allowResize();';
	echo	'winFin.allowMove();';
	//echo	'winFin.button("close").hide();';
	echo	'winFin.button("park").hide();';
	echo	'winFin.button("minmax1").hide();';
	echo	'winFin.button("minmax2").hide();';
}
echo	'</script>';
?>
