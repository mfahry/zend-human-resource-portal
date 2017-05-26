<?php
$absenid = "";
$tgl= "";
$name = "";
$intime="";
$indesc="";
$outtime = "";
$outdesc = "";
$works="";
$absentype="";
?>

<center>
  <!--<div id="formAlert_r" style="font-family: Courier New; background-color:#F3FBFC; overflow: auto; font-size:10px; border:solid 4px #333333; height:300px;" align="center">!-->
  <table id="windowAbsenBulanan" style="display:none">
    <?php
		if(!isset($userid)){
			//$userid = $_SESSION['userid'];
			//$calid = 222;
		}

		$query = $this->registry->mAbsensiHarian->select_reportHarian($userid, $calid,3);

		foreach($query as $data){
			$absenid = $data->ABSENSIHARIAN_ID;
			$tgl = $this->registry->mCalendar->select_calendarID("", "", "", $calid, 1);
			//echo $tgl;
			$name = $this->registry->mUser->selectDB_userLevel($userid, "u.name");
			$intime = $data->START_TIME;
			$indesc = $data->START_DESC;
			$outtime = $data->OUT_TIME;	
			$outdesc = $data->OUT_DESC;		
			$works = $data->WORKSUMMARY;
			$absentype = $data->ABSENTYPE_ID;
}	
?>
    <tr>
      <td width="124">Tanggal</td>
      <td width="10">:</td>
      <td width="348"><?php echo $tgl; ?></td>
    </tr>
    <tr>
      <td>Nama</td>
      <td>:</td>
      <td><?php echo $name; ?></td>
    </tr>
    <tr>
      <td>Jam masuk</td>
      <td>:</td>
      <td><?php echo $intime; ?></td>
    </tr>
    <tr>
      <td>Jam Keluar</td>
      <td>:</td>
      <td><?php echo $outtime; ?></td>
    </tr>
    <tr>
      <td>Keterangan Masuk</td>
      <td>:</td>
      <td><?php echo $indesc; ?></td>
    </tr>
    <tr>
      <td>Keterangan Pulang</td>
      <td>:</td>
      <td><?php echo $outdesc; ?></td>
    </tr>
    <tr>
      <td>Catatan</td>
      <td>:</td>
      <td><?php echo $works; ?></td>
    </tr>
    <tr>
      <td colspan="3" align="center">
      <table width="480" border="1" >
          <caption>Absen Keluar</caption>
          <tr>
            <th width="27">No</th>
            <th width="75">Absen</th>
            <th width="90">Jam Keluar</th>
            <th width="76">Keterangan</th>
            <th width="83">Jam Kembali</th>
          </tr>
          <?php $i = 0;
			$query2 = $this->registry->mAbsensiHarian->selectDB_outOffice($userid, "", $calid);								
			if(count($query2) > 0){
				foreach($query2 as $data2){	
					$i++;
					if($i%2 == 0)	$selang = "#CEEFFF";
					else			$selang = "#ECF7FF";
				?>
          <tr bgcolor="<?php echo $selang;?>">
            <td><?php echo $i; ?></td>
            <td><?php echo $data2->TYPE_NAME; ?></td>
            <td><?php echo $data2->OUT_TIMESTART; ?></td>
            <td><?php echo $data2->OUT_DESCSTART; ?></td>
            <td><?php echo $data2->OUT_TIMEEND; ?></td>
          </tr>
          <?php 	
				}
		  }else{ ?>
          <tr>
            <td colspan="5" align="center" style="color:#FF0000"><i>Data Kosong</i></td>
          </tr>
          <?php 	
			}
			?>
        </table></td>
    </tr>
  </table>
</center>
</div>
<script>
/*
	var dhxWins = new dhtmlXWindows();
	dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");
	dhxWins.setSkin("dhx_skyblue");
	document.getElementById("windowAbsenBulanan").style.display = "block";
	var winFin = dhxWins.createWindow("w1", 300, 200, 500, 270);
	winFin.attachObject("windowAbsenBulanan");
	winFin.setText("Absensi Keluar");
	winFin.setModal(true);
	winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");
	winFin.allowResize();
	winFin.button("park").hide();
	winFin.button("minmax1").hide();
	winFin.button("minmax2").hide();
*/
</script> 
