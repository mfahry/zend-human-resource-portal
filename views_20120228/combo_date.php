<?php
$getDate = $this->registry->mCalendar->selectDB_monthCalendar($type);
$i = 1;

if(strtolower($type) == "month"){
	$type 		= "Bulan";
	$cmbName	= "cmbMonth";
}elseif(strtolower($type) == "year"){
	$type 		= "Tahun";
	$cmbName	= "cmbYear";
}elseif(strtolower($type) == "date"){
	$type 		= "Tanggal";
	$cmbName	= "cmbDate";
}
?>

<table>
  <tr>
    <td><select name = "<?php echo $cmbName; ?>" style="width:auto"  class="validate[required]" id="<?php echo $cmbName; ?>">
        <option value=""> <?php echo $type; ?></option>
        <?php 
		foreach($getDate as $data){
			if(strtolower($type) == "bulan"){
				$monthName = $this->registry->mCalendar->monthname($data->TYPECALENDAR);
				echo "<option ".(isset($_POST['cmbMonth'])&&($data->TYPECALENDAR == $_POST['cmbMonth'])?"selected":"")." value=\"".$data->TYPECALENDAR."\"> ".$monthName." </option>";
			}elseif(strtolower($type) == "tanggal"){
				echo "<option ".(isset($_POST['cmbDate'])&&($data->TYPECALENDAR == $_POST['cmbDate'])?"selected":"")." value=\"".$data->TYPECALENDAR."\"> ".$data->TYPECALENDAR." </option>";
			}else{
				echo "<option ".(isset($_POST['cmbYear'])&&($data->TYPECALENDAR == $_POST['cmbYear'])?"selected":"")." value=\"".$data->TYPECALENDAR."\"> ".$data->TYPECALENDAR." </option>";
			}
		}
		?>
      </select>
      </td>
  </tr>
</table>
