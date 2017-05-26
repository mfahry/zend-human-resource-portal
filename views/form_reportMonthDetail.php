<script src="./lib/dhtmlxaccordion/dhtmlxWindows/codebase/dhtmlxwindows.js"></script>
<div id="formAlert_r" style="font-family: Courier New; background-color:#F3FBFC; overflow: auto; font-size:10px; border:solid 4px #333333; height:300px;" align="center">
  <table border="0" cellpadding="1" cellspacing="1" width="500" height="200">
    <?php
					$query = $this->registry->mAbsensiHarian->select_reportHarian($userid, $calid,3);
					foreach($query as $data){	
						$absenid = $data->ABSENSIHARIAN_ID;
						$name = $data->USER_ID;
						$calid = $data->CALENDAR_ID;
						$intime = $data->START_TIME;
						$indesc = $data->START_DESC;
						$ipawal = $data->START_INPUTFROM;
						$outtime = $data->OUT_TIME;	
						$outdesc = $data->OUT_DESC;		
						$ipakhir = $data->OUT_INPUTEND;
						$works = $data->WORKSUMMARY;
						$absentype = $data->ABSENTYPE_ID;
					$tgl=$this->registry->mCalendar->select_calendarID("","","", $calid, 1);
					}	
			?>
    <tr>
      <td width="124">Tanggal</td>
      <td width="10">:</td>
      <td width="348"><?php echo $tgl ?></td>
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
      <td>Keterangan Masuk</td>
      <td>:</td>
      <td><?php echo $indesc; ?></td>
    </tr>
    <tr>
      <td>IP Masuk</td>
      <td>:</td>
      <td><?php echo $ipawal; ?></td>
    </tr>
    <tr>
      <td>Jam Keluar</td>
      <td>:</td>
      <td><?php echo $outtime; ?></td>
    </tr>
    <tr>
      <td>Keterangan Keluar</td>
      <td>:</td>
      <td><?php echo $outdesc; ?></td>
    </tr>
    <tr>
      <td>IP Keluar</td>
      <td>:</td>
      <td><?php echo $ipakhir; ?></td>
    </tr>
    <tr>
      <td>Worksummary</td>
      <td>:</td>
      <td><?php echo $works; ?></td>
    </tr>
    <tr>
      <td colspan="3" align="center"><table width="480" border="0" >
          <tr>
            <th colspan="6">Absen keluar</th>
          </tr>
          <tr background="./images/tbl_lblue.gif" style="color:#FFFFFF; font-size:12px;">
            <th width="27">No</th>
            <th width="75">Absen</th>
            <th width="90">Jam Keluar</th>
            <th width="76">Keterangan</th>
            <th width="83">Jam Kembali</th>
          </tr>
          <?php $i = 0;
			$query2 = $this->registry->mAbsenOut->selectDB_outOffice($userid, "", $calid);								
			foreach($query2 as $data2){
				$i++;
				if($i != 0){
					if($i%2 == 0)	$selang = "#CEEFFF";
					else	$selang = "#ECF7FF";
					?>
          <tr bgcolor="<?php echo $selang;?>">
            <td><?php echo $i; ?></td>
            <td><?php echo $data2->TYPE_NAME; ?></td>
            <td><?php echo $data2->OUT_TIMESTART; ?></td>
            <td><?php echo $data2->OUT_DESCSTART; ?></td>
            <td><?php echo $data2->OUT_TIMEEND; ?></td>
          </tr>
          <?php 	}else{ ?>
          <tr>
            <td colspan="5" align="center" style="color:#FF0000"><b>-</b></td>
          </tr>
          <?php 	}
						}
									?>
        </table></td>
    </tr>
    <tr>
      <td height="28" colspan="3" align="center"><form method="post">
          <input type="submit" name="close" value="Submit" class="btn-close"/>
        </form></td>
    </tr>
  </table>
  <?php
			if(isset($_POST['close'])){
				if($_SESSION['level_id'] != 3)
					echo "<script>location.href=\"index.php?abs=21\";</script>";
				else
					echo "<script>location.href=\"index.php?abs=31\";</script>";
			}
		?>
</div>
<script>
			var dhxWins = new dhtmlXWindows();
			dhxWins.setImagePath("./lib/dHTMLxWindows/imgs/");
			
			var winFin = dhxWins.createWindow("w1", 270, 200, 530, 312);
			winFin.attachObject("formAlert_r");
			winFin.button("close").hide();
			winFin.button("park").hide();
			winFin.button("minmax1").hide();
			winFin.button("minmax2").hide();
			winFin.setText(" ");
			winFin.setModal(true);
			winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");
			winFin.denyResize();
			winFin.denyMove();
			winFin.hideHeader();
		</script>