<?php
	$data = $this->registry->mPolling->SelectPolling();
	foreach($data as $polling){
		$polling_id = $polling->POLLING_ID;
		$pertanyaan = $polling->QUESTION;
		$start = $polling->START_DATE;
		$end = $polling->END_DATE;
	}
	$pilihanuser = $this->registry->mPolling->PilihanUser($polling_id);
	
	$jumlahpemilih = $this->registry->mPolling->JumlahPemilih($polling_id);
	foreach($pilihanuser as $user){
		$hasil_id = $user->HASIL_ID;
		$polling_id = $user->POLLING_ID;
		$pilihan_id = $user->PILIHAN_ID;
	}	
		echo "<table>";
			echo "<tr>";
				echo "<td><font size=1><b>$pertanyaan</b></font></td>";
			echo "</tr>";
		$datapilihan = $this->registry->mPolling->SelectPilihan($polling_id,$pilihan_id);
		foreach($datapilihan as $daftar){
			$pilihan = $daftar->PILIHAN;
			$jumlah = $daftar->JUMLAH;
			
		$persen = round($jumlah/$jumlahpemilih,4)*100;
			echo "<tr>";
				echo "<td><font size=1><b>$pilihan: $jumlah  </b></font> </td>";
				echo "<td align='left'><img src='includes/img/poll.gif' width='$persen' height=20> </td>";
				echo "<td align='left'><font size=1><b>$persen%</b></font></td>";
			echo "</tr>";
		}
			echo "<tr>";
				echo "<td><font size=1><b>Jumlah Pemilih: $jumlahpemilih</b></font></td>";
			echo "</tr>";
		echo "</table>";
?>