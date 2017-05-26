<form name="formReportDetail" method="post" action="index.php?mod=reporting/statistic">
  <table width="873" style="margin-left:0px;">
    <tr>
      <td width="43"><?php 
				$this->registry->view->type="month";
				$this->registry->view->show("combo_date");?></td>
      <td width="43"><?php 
				$this->registry->view->type="year";
				$this->registry->view->show("combo_date");?></td>
      <td width="590"><input type="submit" name="submitDetail" class="btn" value="submit"/></td> 
    </tr>
  </table>
</form>
<br />
<center>
  <table id="gridbox">
    <tr>
      <th width="30">#</th>
      <th width="150">Karyawan</th>
      <th width="50">Terlambat</th> 
      <th width="50">Sakit</th>
      <th width="50">Ijin</th>
      <th width="50">Kuliah</th>
      <th width="50">SPJ Lokal+Luar Kota</th> 
      <th width="50">Cuti</th>
    </tr>
    <?php 
	
$url = explode('/',$_GET['mod']);
if(isset($url[1]) && $url[1]=='statistic'){
	if(isset($getCalidMonthly1) && count($getCalidMonthly1)>0 && count($getCalidMonthly2)>0 && count($datauser)>0){ 
		 
		
		$j 			= 0;
		foreach($datauser as $data){
			$j++; 
	?>
    <tr>
      <td><?php echo $j;  ?></td>
      <td><?php echo $data->USER_ID." <br> ".$this->registry->mUser->get_fullname($data->USER_ID); ?></td>
      <td><?php echo $this->registry->mAbsensiHarian->selectDB_jamMasukKantor($data->USER_ID, "09:00", ">"); ?></td> 
      <td><?php echo $this->registry->mAbsenOut->selectDB_outOffice($data->USER_ID, '2', $getCalidMonthly1, $getCalidMonthly2, 1); ?></td>
      <td><?php echo $this->registry->mAbsenOut->selectDB_outOffice($data->USER_ID, '3', $getCalidMonthly1, $getCalidMonthly2, 1); ?></td>
      <td><?php echo $this->registry->mAbsenOut->selectDB_outOffice($data->USER_ID, '4', $getCalidMonthly1, $getCalidMonthly2, 1); ?></td>
      <td><?php echo intval($this->registry->mAbsenOut->selectDB_outOffice($data->USER_ID, '5', $getCalidMonthly1, $getCalidMonthly2, 1))+intval($this->registry->mAbsenOut->selectDB_outOffice($data->NAME, '6', $getCalidMonthly1, $getCalidMonthly2, 1)); ?></td>
      <td><?php echo $this->registry->mAbsenOut->selectDB_outOffice($data->USER_ID, '7', $getCalidMonthly1, $getCalidMonthly2, 1); ?></td>
    </tr>
    <?php 	} //tutup foreach
		} // tutup isset($_POST['submitDetail'])
}
			?>
  </table>
</center>
<!--tutup statistik--> 

<script>
	grid = new dhtmlXGridFromTable("gridbox");
	grid.setImagePath("includes/dhtmlx/dhtmlxGrid/imgs/");
	grid.setSkin("dhx_black");
	grid.enableAutoWidth(true,500,500);
	grid.enableAutoHeight(true, 500,500);
	grid.setSizes();
	grid.setColTypes("ro,ro,ro,ed,ed,ed,ed");
</script>