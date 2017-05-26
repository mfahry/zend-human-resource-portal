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
<form name="frmAttendanceBack" id="frmAttendanceBack" method="post"  action="index.php?mod=attendance/returnOffice">
  <table class="tableForm">
    <tr>
      <th colspan="3" class="thForm">Absensi kembali anda :</th>
    </tr>
    <tr valign="top">
      <td><label>Jenis Absen</label></td>
      <td><label>:</label></td>
      <td>
	  <?php //var_dump($getAbsentBack); 
	  	if(count($getAbsentBack)>0){
			foreach($getAbsentBack as $type){
				$typeID = $type->OUT_TYPE;
				$desc = $type->OUT_DESCSTART;
			}	
		}
		echo $this->registry->mAbsenType->selectDB_typeAbsen($typeID);
		if($desc != NULL) echo ' ('.$desc.')';
		?>
      </td>
    </tr>
    <tr valign="top">
      <td><label>Jam Kembali</label></td>
      <td><label>:</label></td>
      <td><?php echo $time; ?></td>
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
        <!--<input name="tTime" type="hidden" value="<?php //echo $this->registry->mCalendar->getTime(); ?>" /> 
        <input name="ipAddress" type="hidden" value="<?php //echo $this->registry->mUser->getIPGuest(); ?>" />
        <input name="tAbsen" type="hidden" value="0" /> -->
        </td>
      <td><input type="submit" name="submitAbsenOut" class="btn" value="Submit" /></td>
    </tr>
  </table>
</form>
