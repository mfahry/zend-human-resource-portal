

<?php if($_SESSION['level_id']==2){?>
<form name="formUserMingguan" style="margin-left:5px;" method="post" action="index.php?mod=reporting/weekly">
  <?php  $this->registry->view->show("combo_user");	?>  <input type="submit" name="sbmtUser" class="btn" value="Submit"  />
</form>
<?php } ?>
<center>
<table id="gridbox">
    <thead>
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
    </thead>
	<?php 
		$i = 1;
		$url = explode('/',$_GET['mod']);
		for ($ctr = 1; $ctr <= 5; $ctr++){ // ampe 5 kali	
			if(!isset($url[1])&&($_SESSION['level_id']==2))
				$getDataReport = $this->registry->mAbsensiHarian->select_reportMingguan($calID);
			else
				$getDataReport = $this->registry->mAbsensiHarian->select_reportMingguan($calID, $user);
				
			$calID++;
			foreach($getDataReport as $data){ 
		?>
			<tr>
				<td><?php echo $i++;  ?></td>
				<td><?php echo $data->USER_ID." <br> ".$this->registry->mUser->get_fullname($data->USER_ID);  ?></td>
				<td><?php echo $data->DATE."-".$data->MONTH."-".$data->YEAR."";  ?></td>
				<td><?php 
					if($data->START_TIME > "09:00") echo '<b style="color:red;">'.$data->START_TIME.'</b>';
					else echo $data->START_TIME;  
				?></td>
				<td><?php echo $data->OUT_TIME;  ?></td>
				<td>
				<p><b>Masuk  : </b><?php echo $data->START_DESC;  ?></p>
				<hr />
				<p><b>Pulang : </b><?php echo $data->OUT_DESC;  ?></p>
				</td>
				<td><?php echo $data->WORKSUMMARY;  ?></td>
				<td><?php echo $data->START_INPUTFROM;  ?></td>
				<td><?php echo $data->OUT_INPUTEND;  ?></td>
		  </tr>
	 <?php 
			} //tutup foreach
		}// tutup for 
?>
</table>
</center>


<script>
	grid = new dhtmlXGridFromTable("gridbox");
	grid.setImagePath("includes/dhtmlx/dhtmlxGrid/imgs/");
	grid.setSkin("dhx_black"); 
	grid.enableAutoWidth(true,900,900);
	grid.enableAutoHeight(true, 600,600);
	grid.setSizes();
	grid.setColTypes("ro,ro,ro,ro,ro,ro,ro,ro,ro"); 
</script>
