<?php
if(isset($_SESSION['userid'])){
echo "<h3>Polling</h3>";
echo "<ul>";
	$data = $this->registry->mPolling->SelectPolling();
	foreach($data as $polling){
		$pollingid = $polling->POLLING_ID;
		$pertanyaan = $polling->QUESTION;
		$start = $polling->START_DATE;
		$end = $polling->END_DATE;
	}
	$user = $this->registry->mPolling->UserSudahMemilih($pollingid);
	$date = date("Y-m-d");
	if((($user == 0) && ($date<=$end)) && ($date >= $start)){
	?>
	<form action="index.php?mod=polling/UserMemilih" method="post" name="pilih_polling">
	<table>
	<tr>
		<td colspan="2" align="center"><?php echo $pertanyaan;?></td>
		<td><input name="polling" type="hidden" value="<?php echo $pollingid;?>"/></td>
		<br>
	</tr>
		<?php		
			$datapilihan = $this->registry->mPolling->SelectPilihan($pollingid);
			foreach($datapilihan as $pilihan){
				$namapilihan = $pilihan->PILIHAN;
				$pilihan_id = $pilihan->PILIHAN_ID;
	echo "<tr>";
		echo "<td>$namapilihan</td>";
		echo "<td><input name='pilihan$pilihan_id' type='radio' value='$pilihan_id' /></td>";
	echo "</tr>";
			}
		?>
	<tr>
		<td colspan='2' align='center'><input name='Add' type='submit' value='Pilih' class='btn'></td>
	</tr>
	</table>
	</form>
<?php
	}
	else{
		$this->registry->view->show('view_tampil_polling');
	}
echo "</ul>";
}
?>
