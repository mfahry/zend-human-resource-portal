
<SCRIPT language="javascript" src="includes/JQuery/script/validation_engine.js"></SCRIPT>
<SCRIPT language="javascript" src="includes/JQuery/script/validation_engine-id.js"></SCRIPT>
<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/validation_engine.css"/> 

<SCRIPT>

$(function() {
	$("#frmAttendanceIn").validationEngine({
		inlineValidation: false,
		success : false	  
	});
	   
});

</SCRIPT>
<form method="post" name="frmAttendanceIn" id="frmAttendanceIn" action="index.php?mod=attendance/attendanceIn"><!--actAbsenHarian-->
  <table class="tableForm">
    <tr>
      <th colspan="3" class="thForm">Absen Masuk
      <!-- <input name="ipAddress" type="hidden" value="<?php //echo $this->registry->mUser->getIPGuest(); ?>" />
      <input name="tTime" type="hidden" value="<?php //echo $this->registry->mCalendar->getTime(); ?>" /> -->
      <input name="CalendarID" type="hidden" value="<?php echo $calendar_id; ?>" /></th>
    </tr>
    <tr>
      <td><label>Tanggal</label></td>
      <td><label>:</label></td>
      <td><?php echo $date.'-'.$month.'-'.$year; ?> </td>
    </tr>
    <tr>
      <td><label>Pukul</label></td>
      <td><label>:</label></td>
      <td><?php echo  $time; ?></td>
    </tr>
    <tr>
      <td valign="top"><label>Keterangan</label></td>
      <td valign="top"><label>:</label></td>
      <td><textarea name="tNote" id="tNote" class="validate[required,length[3,255]]" cols="45"></textarea></td>
    </tr>
    <tr>
    	<td colspan="2"></td>
      <td><input name="SubmitHarian" type="submit" class="btn" value=" Submit" /></td>
    </tr>
  </table>
</form>
