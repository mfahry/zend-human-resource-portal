
<script type="text/javascript">
$(function() {
      $("#formReportBulan").validationEngine({
		inlineValidation: false,
		success :  false
		// promptPosition: "bottomLeft"
	   });
	   
});
</script>
<form name="formReportBulan" id="formReportBulan" method="post" action="index.php?mod=reporting/monthly">
  <table width="858">
    <tr>
      <?php if($_SESSION['level_id'] == 2){ ?>
      <td width="45" height="34"><?php
				$this->registry->view->show("combo_user");
			?></td>
      <?php } ?>
      <td width="45"><?php 
				$this->registry->view->type="month";
				$this->registry->view->show("combo_date");?></td>
      <td width="45"><?php 
				$this->registry->view->type="year";
				$this->registry->view->show("combo_date");?></td>
      <td width="116"><input type="submit" name="submitCalendar" id="submitCalendar" class="btn" value="Submit"/></td>
      <td width="385"></td>
      <?php if(isset($_POST['submitCalendar'])) { ?>
      <td width="194" ><?php
				if(($_SESSION['level_id'] == 2)/*&&(isset($_POST['submitCalendar']))*/){ ?>
        <a href="index.php?mod=reporting/monthlyToExcel/<?php echo $_POST['cmbUser'];?>/<?php echo $_POST['cmbMonth']; ?>/<?php echo $_POST['cmbYear']; ?>" class="merahBold"><img src="includes/img/excel.gif" border="0" align="absmiddle" alt="untuk mendownload excel" />&nbsp;Export to Excel</a>
        <?php
				}
				?></td>
      <?php } ?>
    </tr>
  </table>
</form>
 
<center> 
<b>Absen bulan <?php echo $bln_1." ".$year; ?> tgl 26 <?php echo $bln_2; ?> s/d 25 <?php echo $bln_1; ?></b>
</center> 
  <table id="gridbox">
    <tr>
      <th width="30">#</th>
      <th width="110">Karyawan</th>
      <th width="60">Tanggal</th>
      <th width="70">Jam Masuk</th>
      <th width="70">Jam Pulang</th>
      <th width="200">Keterangan</th>
      <th width="200">Catatan</th>
      <th width="80">IP Login</th>
      <th width="80">IP Logout</th>
    </tr>
    <?php  
$url = explode('/',$_GET['mod']);
//if(isset($url[1]) && $url[1]=='monthly'){
	$i 		   = 0;
	$calid = array();
	reset($calid);			 		
	foreach($getCalidMonthly1 as $data){
		$calid[$i] = $data->CALENDAR_ID;
		$i++;
	}
			 		
	foreach($getCalidMonthly2 as $data){
		$calid[$i] = $data->CALENDAR_ID;
		$i++;
	}
			
	$j = 0;
	for($idx = 0; $idx < $i; $idx++){
		
		$query = $this->registry->mAbsensiHarian->select_reportBulanan($calid[$idx],$user);
		foreach($query as $data){
			$j++; 
			$tgl = $this->registry->mCalendar->select_calendarID("", "", "", $data->CALENDAR_ID, 1);
			$dtm = $data->CALENDAR_ID;
		?>
    <tr>
      <td><?php echo $j;  ?></td>
      <td><?php echo $data->USER_ID." <br> ".$this->registry->mUser->get_fullname($data->USER_ID);  ?></td>
      <td>
        <!--<a href="index.php?mod=reporting/detailReport/<?php //echo $data->USER_ID;?>/<?php //echo $data->CALENDAR_ID;?>" style="color:#990000;"></a>--><?php echo $tgl; ?>
        </td>
      <td><?php 
			if($data->START_TIME > "08:31")  echo '<b style="color:red;">'.$data->START_TIME.'</b>';
			else echo $data->START_TIME;  
		?></td>
      <td><?php echo $data->OUT_TIME;  ?></td>
      <td><p><b>Masuk  : </b><?php echo $data->START_DESC;  ?></p>
        <p><b>Pulang  : </b><?php echo $data->OUT_DESC;  ?></p></td>
      <td><?php echo $data->WORKSUMMARY;  ?></td>
      <td><?php echo $data->START_INPUTFROM; ?></td>
      <td><?php echo $data->OUT_INPUTEND; ?></td>
    </tr>
    <?php 	
		}#tutup foreach
	}#tutup for
//}
?>
  </table>
</center>
<?php if($_SESSION['level_id']==3){ ?>
<table style="margin-left:10px;">
  <!--tr>  <?php /* 
			
			$getType 	= $this->registry->mAbsenType->selectDB_typeAbsen();
			foreach($getType as $tipe){
				if(($tipe->TYPE_ID != 0) && ($tipe->TYPE_ID != 1) && ($tipe->TYPE_ID != 10)){
					$jml = $this->registry->mAbsenOut->selectDB_outOffice($user, $tipe->TYPE_ID, "", "",1);
							echo "<b>".ucwords($tipe->TYPE_NAME)."</b> ".$jml."&nbsp &nbsp &nbsp &nbsp";
				}
			}
			 echo "<b>Terlambat</b> ".$this->registry->mAbsensiHarian->selectDB_jamMasukKantor($user, "09:00", ">")."&nbsp &nbsp &nbsp &nbsp"; 
			*/
			?> 
  </tr-->
</table>
<?php } ?>
</center>
<script>
grid = new dhtmlXGridFromTable("gridbox");
grid.setImagePath("includes/dhtmlx/dhtmlxGrid/imgs/");
grid.setSkin("dhx_black"); 
grid.enableAutoWidth(true,900,900);
grid.enableAutoHeight(true, 600,600);
grid.setSizes();
grid.setColTypes("ro,ro,ro,ro,ro,ro,ro"); 
</script>


<?php
	$url = explode('/',$_GET['mod']);
	if (isset($url[1]) && $url[1] == 'detailReport'){
		$this->registry->view->show('window_report_keluar_kantor');
?>
<script>
var dhxWins = null;
if (!dhxWins){
	dhxWins = new dhtmlXWindows();
	dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");
	dhxWins.setSkin("dhx_skyblue");
	document.getElementById("windowAbsenBulanan").style.display = "block";
}

if (!dhxWins.window("winFin")) {
	var winFin = dhxWins.createWindow("w1", 300, 200, 500, 400);
	//winFin.attachObject("windowAbsenBulanan");
	winFin.setText("Report Absensi Keluar");
	winFin.setModal(true);
	winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");
	winFin.allowResize();
	//winFin.denyMove();
	//winFin.button("close").hide();
	winFin.button("park").hide();
	winFin.button("minmax1").hide();
	winFin.button("minmax2").hide();
	
	winFin.attachEvent("onClose",function(win){
		if (win.getId() == "w1") {
			win.detachObject();
			win.hide();
			winFin.setModal(false);
			//location.reload();
		}
	})
}else{
	var w1 = dhxWins.window("winFin");
	w1.show();
}
winFin.attachObject("windowAbsenBulanan");
</script> 
<?php

	} 
	?>