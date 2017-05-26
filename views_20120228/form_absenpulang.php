<?php
$calendar_id = $this->registry->mCalendar->select_calendarID($this->registry->mCalendar->getDate(),$this->registry->mCalendar->getMonth(),$this->registry->mCalendar->getYear());
?>
<form method="post" name="absenPulangY" id="absenPulangY" onSubmit="return validasiAbsenPulangY();" action="index.php?mod=attendance/actAbsenPulang">
  <table width="80%" border="0" align="left" style="margin:15px;"> 
    <tr style="border-bottom:1px solid #000;"> 
      <td colspan="3">
        <input type="hidden" name="radio" id="radio" value="0"/>
        <input name="ipAddress" type="hidden" value="<?php echo $this->registry->mUser->getIPGuest(); ?>" />
   		<input name="CalendarID" type="hidden" value="<?php echo $calendar_id; ?>" />
		<input name="tTime" type="hidden" value="<?php echo $this->registry->mCalendar->getTime(); ?>" />
        Absen Pulang
      </td>
    </tr>
    <tr valign="top"> 
      <td><label>Tanggal</label></td>
      <td>:</td>
      <td><?php echo $this->registry->mCalendar->currentDate(); ?></td>
    </tr>
    <tr valign="top"> 
      <td><label>Pukul</label></td>
      <td>:</td>
      <td><?php echo $this->registry->mCalendar->getTime(); ?></td>
    </tr>
    <tr valign="top"> 
      <td><label>Note</label></td>
      <td>:</td>
      <td><textarea name="tNote" id="tNote" cols="45" rows="5"></textarea></td>
    </tr>
    <tr valign="top"> 
      <td><label>Work Summary</label></td>
      <td>:</td>
      <td><textarea name="tWs" id="tWs" cols="45" rows="5"></textarea>
        </label></td>
    </tr>
    <tr>
      <td align="right" colspan="4"><input name="SubmitHarian" type="submit" value="Submit " class="btn" /></td>
    </tr>
  </table>
</form>
