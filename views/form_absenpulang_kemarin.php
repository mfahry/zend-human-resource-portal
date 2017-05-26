<link rel="stylesheet" type="text/css"  href="includes/JQuery/styles/timeEntry.css" />
<script type="text/javascript" src="includes/JQuery/jquery.mousewheel.js"></script>
<script type="text/javascript" src="includes/JQuery/script/timeEntry.js"></script>
<script type="text/javascript">
$(function () {
	$('#tjam').timeEntry({
		spinnerImage: 'includes/JQuery/images/timeEntry/spinnerText.png',
		show24Hours: true,
		useMouseWheel: true,
		defaultTime: new Date(0, 0, 0, 17, 0, 0)
	});
});
</script>
<form method="post" name="absenPulangY" id="absenPulangY" onSubmit="return validasiAbsenPulangY();" action="index.php?mod=attendance/submitAbsentGoHome"><!--actAbsenPulang-->
	<table border="0" style="margin:15px;">
		<tr>
			<td colspan="3" class="alertRed">Kemarin Anda tidak menginputkan Absensi Pulang Anda!</td>
		</tr>
		<tr>
			<td><b>Jenis Absen</b></td>
			<td colspan="2" class="header3BoldBlue"><input type="hidden" name="radio" id="radio" value="0" />Absen Pulang</td>
		</tr>
	<?php	
	if(count($dataAbsentHomeYesterday) > 0){
		$j = 1;
		foreach($dataAbsentHomeYesterday as $data){ 
			$CalHarian = "CalendarID".$j; 
			$jamHarian = "tTime".$j; 
			$noteHarian = "tNote".$j; 
			$wsHarian = "tWs".$j; 
	?>
		<tr>
			<td><input name="<?php echo $CalHarian; ?>" type="hidden" value="<?php echo $data->CALENDAR_ID; ?>" /></td>
			<td><input name="ipAddress" type="hidden" value="<?php $ip = $this->registry->mUser->getIPGuest(); echo $ip; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td valign="top"><strong>Untuk tanggal</strong></td>
			<td valign="top"><strong>:</strong></td>
			<td><?php echo $data->DATE." ".$this->registry->mCalendar->monthname($data->MONTH)." ".$data->YEAR; ?></td>
		</tr>
		<tr>
			<td valign="top"><strong>Jam </strong></td>
			<td valign="top"><strong>:</strong></td>
			<td>
            <input name="<?php echo $jamHarian; ?>" type="text" value="" id="tjam" style="width:50px;"/>
            <i>"Gunakan mousewheel utk plus/minus jam."</i>
            </td>
		</tr>
		<tr>
			<td valign="top"><strong>Keterangan</strong></td>
			<td valign="top"><strong>:</strong></td>
			<td><label>
			<textarea name="<?php echo $noteHarian; ?>" cols="45" rows="5"></textarea>
			</label></td>
		</tr> 
		<tr>
			<td valign="top"><strong>Work Summary</strong></td>
			<td valign="top"><strong>:</strong></td>
			<td><label>
			<textarea name="<?php echo $wsHarian; ?>" cols="45" rows="5"></textarea>
			</label>
			</td>
		</tr>  
		<?php
			$j++;
		}
	}
	?>
		<tr>
			<td align="right" colspan="3"><input name="ctrHarian" style="visibility:hidden;" type="hidden" value="<?php echo ($j-1);?>" />
			<script language="javascript"> 
					function validasiAbsenPulangY()
					{ 
						if (document.absenPulangY.<?php echo $wsHarian; ?>.value == '') {
				alert('Work Summary tidak boleh kosong! Isikan dengan Task yang sudah Anda kerjakan hari ini..'); 
				return false;
				}
					}
			</script>
			<input name="SubmitPulangY" type="submit" value=" Submit " class="btn"/></td>
		</tr>
	</table>
</form>
