<script type="text/javascript">
$(function() {
      $("#formKeluar").validationEngine({
		inlineValidation: false,
		success :  false
		// promptPosition: "bottomLeft"
	   });
	   
});
</script>
 
<form name="formKeluar" id="formKeluar" method="post" action="index.php?mod=reporting/OutOfOffice">
  <table>
    <tr>
      <?php  if($_SESSION['level_id'] == 2){ ?>
      <td width="32" height="34"><?php $this->registry->view->show('combo_user'); ?></td>
      <?php } ?>
      <td><?php 
			$this->registry->view->type = 'month';
			$this->registry->view->show('combo_date');
			?></td>
      <td><?php 
			$this->registry->view->type = 'year';
			$this->registry->view->show('combo_date');
			?></td>
      <td><?php 	
			$this->registry->view->onChange = TRUE;
			$this->registry->view->jsFungsi = "displayCombo";
			$this->registry->view->DivName = "displayDiv";
			$this->registry->view->alltype = FALSE;
			$this->registry->view->show('combo_typeabsen');
			?></td>
      <td><input type="submit" name="submitKeluar" class="btn" value="submit"/></td>
    </tr>
  </table>
</form> 
<center>
  <table>
    <tr>
      <th style="font-size:8pt;" colspan="8" class="blackBold">Absen bulan <?php echo $bln_1." ".$year; ?> <br />
        (tgl 26 <?php echo $bln_2; ?> s/d 25 <?php echo $bln_1; ?>)</th>
    </tr>
  </table>
  
  <table id="gridbox">
    <tr>
      <th width="30">No</th>
      <th width="110">Karyawan</th>
      <th width="110">Tipe Absen</th>
      <th width="60">Tanggal</th>
      <th width="72">Jam Keluar</th>
      <th width="72">Jam Kembali</th>
      <th width="220">Keterangan</th>
      <th width="220">Catatan</th>
    </tr>
    <?php  

$url = explode('/',$_GET['mod']);
if(isset($url[1]) && $url[1]=='OutOfOffice'){				
		$i 		   = 0; 
			
		foreach($getCalidMonthly1 as $data){
			$i++;
			$calid[$i] = $data->CALENDAR_ID;
		}
				
			
		foreach($getCalidMonthly2 as $data){
			$i++;
			$calid[$i] = $data->CALENDAR_ID;
		}
		$j = 0;
		$query = 0;
		for($idx = 1; $idx <= $i; $idx++){
			if (isset($_POST['cmbAbsen'])){
					$dataAbsenOut 	= $this->registry->mAbsensiHarian->select_reportBulananOut($calid[$idx], $user, $_POST['cmbAbsen']);
			}else{
					$dataAbsenOut 	= $this->registry->mAbsensiHarian->select_reportBulananOut($calid[$idx], $user);
			}  
			
			if(count($dataAbsenOut) >0){
			foreach($dataAbsenOut as $data){	
				$j++;  
				?>
    <tr valign="top">
      <td><?php echo $j;  ?></td>
      <td><?php echo $data->USER_ID." <br> ".$this->registry->mUser->get_fullname($data->USER_ID);  ?></td>
      <td><?php echo ucwords($data->TYPE_NAME);  ?></td>
      <td><?php echo $this->registry->mCalendar->select_calendarID("", "", "", $data->CALENDAR_ID, 1); ?></td>
      <td><?php echo $data->OUT_TIMESTART;  ?></td>
      <td><?php echo $data->OUT_TIMEEND;  ?></td>
      <td><b>Masuk : </b><?php echo $data->OUT_DESCSTART;  ?><br />
        <hr />
        <b>Pulang : </b><?php echo $data->OUT_DESCEND;  ?><br /></td>
      <td><?php echo $data->WORKSUMMARY;  ?></td>
    </tr>
    <?php 	
			}#tutup foreach
			}
		}#tutup for
}
?>
  </table> 
</center>

<script>
grid = new dhtmlXGridFromTable("gridbox");
grid.setImagePath("includes/dhtmlx/dhtmlxGrid/imgs/");
grid.setSkin("dhx_black");
//echo 'grid.enableAutoWidth(true, 900, 900);';
//echo 'grid.enableAutoHeight(true, 400, 250);';
grid.enableAutoWidth(true,900,900);
grid.enableAutoHeight(true, 600,600);
grid.setSizes();
grid.setColTypes("ro,ro,ro,ro,ro,ro,ro,ro,ro");

</script>

