<link rel="stylesheet" type="text/css"  href="includes/JQuery/styles/timeEntry.css" />
<script type="text/javascript" src="includes/JQuery/jquery.mousewheel.js"></script>
<script type="text/javascript" src="includes/JQuery/script/timeEntry.js"></script>
<script type="text/javascript">
$(function () {
	$('.jamOut').timeEntry({
		spinnerImage: 'includes/JQuery/images/timeEntry/spinnerText.png',
		show24Hours: true,
		useMouseWheel: true
		//defaultTime: new Date(0, 0, 0, 17, 0, 0)
	});
});
</script>
<SCRIPT language="javascript" src="includes/JQuery/script/validation_engine.js"></SCRIPT>
<SCRIPT language="javascript" src="includes/JQuery/script/validation_engine-id.js"></SCRIPT>
<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/validation_engine.css"/>
<SCRIPT>

$(function() {
	$("#frmAttendanceBackY").validationEngine({
		inlineValidation: false,
		success :  function(){ 
			if($(".jamOut").val()=="00:00")
				$.validationEngine.buildPrompt("#frmAttendanceBackY .jamOut","* Jam '00:00' tidak diperbolehkan","error");	
		}
	});
	   
});

</SCRIPT>
<?php echo isset($message)?$this->registry->view->show($message):''; ?>
<br>
<form method="post" name="frmAttendanceBackY" id="frmAttendanceBackY" action="index.php?mod=attendance/returnOfficeYday">
  <table class="tableForm">
    <tr>
      <td colspan="3" class="alertRed">Kemarin Anda tidak menginputkan Absensi Kembali Anda!</td>
    </tr>
    <tr>
      <th colspan="3" class="thForm">Absensi kembali anda:</th>
    </tr>
    <?php
		$k=1;
		foreach($dataAbsentBackYesterday as $data2){ 
			$absenHarianID = "abhID".$k; 
			$jamOut = "tTime".$k; 
			$noteOut = "tNote".$k; 
			$wsOut = "tWs".$k; 
		?>
    <tr valign="top">
      <td><label>Jenis Absen</label></td>
      <td><label>:</label></td>
      <td><?php echo $data2->TYPE_NAME; ?></td>
    </tr>
    <tr valign="top">
      <td><label>Untuk tanggal</label></td>
      <td><label>:</label></td>
      <td><?php echo $data2->DATE." ".$this->registry->mCalendar->monthname($data2->MONTH)." ".$data2->YEAR; ?></td>
    </tr>
    <tr valign="top">
      <td><label>Jam </label></td>
      <td><label>:</label></td>
      <td><input name="<?php echo $jamOut; ?>" type="text"  class="jamOut validate[required]" id="<?php echo $jamOut; ?>" style="width:50px;"/>
        <i>"Gunakan mousewheel utk plus/minus jam."</i></td>
    </tr>
    <tr valign="top">
      <td><label>Keterangan</label></td>
      <td><label>:</label></td>
      <td><textarea name="<?php echo $noteOut; ?>" id="<?php echo $noteOut; ?>" class="validate[optional,length[3,255]]" cols="45" ></textarea></td>
    </tr>
    <tr valign="top">
      <td><label>Work Summary</label></td>
      <td><label>:</label></td>
      <td><textarea name="<?php echo $wsOut; ?>" id="<?php echo $wsOut; ?>" class="validate[required,length[3,255]]" cols="45" ></textarea></td>
    </tr>
    <input name="<?php echo $absenHarianID; ?>" type="hidden" value="<?php $abhID=$data2->ABSENSIHARIAN_ID; echo $abhID; ?>" />
    <!-- <input name="tAbsen" type="hidden" value="0" />
    <input name="ipAddress" type="hidden" value="<?php //$ip = $this->registry->mUser->getIPGuest(); echo $ip; ?>" /> -->
    <?php  $k++;
			} 
			
			if($k > 1){
			?>
    <tr>
      <td colspan="2"><input name="ctrOut" type="hidden" value="<?php echo $k; ?>" /></td>
      <td><input type="submit" name="submitKembaliY" value=" Submit " class="btn"/></td>
    </tr>
    <?php } ?>
  </table>
</form>
