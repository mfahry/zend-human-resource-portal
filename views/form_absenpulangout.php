<?php echo isset($message)?$this->registry->view->show($message):''; ?>
<SCRIPT language="javascript" src="includes/JQuery/script/validation_engine.js"></SCRIPT>
<SCRIPT language="javascript" src="includes/JQuery/script/validation_engine-id.js"></SCRIPT>
<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/validation_engine.css"/>
<SCRIPT>

$(function() {
	$("#frmAttendanceBack").validationEngine({
		inlineValidation: false,
		success :  false
	});
	   
});

</SCRIPT>
<form name="frmAttendanceBack" id="frmAttendanceBack" method="post"  action="index.php?mod=attendance/actAbsenPulangOut">
  <table style="margin:15px;">
    <tr>
      <td colspan="3"><label>Absensi kembali anda :</label></td>
    </tr>
    <tr valign="top">
      <td><label>Jam Kembali</label></td>
      <td><label>:</label></td>
      <td><?php echo $this->registry->mCalendar->getTime(); ?></td>
    </tr>
    <tr valign="top">
      <td><label>Keterangan</label></td>
      <td><label>:</label></td>
      <td><textarea name="tNote" id="tNote" class="validate[optional,length[3,255]]" cols="45"></textarea></td>
    </tr>
    <tr valign="top">
      <td><label>Work Summary</label></td>
      <td><label>:</label></td>
      <td><textarea name="tWs" id="tWs" class="validate[required,length[3,255]]" cols="45"></textarea></td>
    </tr>
    <tr>
      <td colspan="2"><?php
	  		$cekHarian=$this->registry->mAbsensiHarian->cekCalendarHarian(1,$this->registry->mCalendar->getDate(),$this->registry->mCalendar->getMonth(),$this->registry->mCalendar->getYear(),$_SESSION['userid']);
			if($cekHarian != 0){
			foreach ($cekHarian as $data){
				$harian = $data->ABSENSIHARIAN_ID;
				} 
			}
	        ?>
        <input name="harianID" type="hidden" value="<?php echo $harian; ?>" />
        <input name="tTime" type="hidden" value="<?php echo $this->registry->mCalendar->getTime(); ?>" />
        <input name="tAbsen" type="hidden" value="0" />
        <input name="ipAddress" type="hidden" value="<?php echo $this->registry->mUser->getIPGuest(); ?>" /></td>
      <td><input type="submit" name="submitAbsenOut" class="btn" value="Submit" /></td>
    </tr>
  </table>
</form>
