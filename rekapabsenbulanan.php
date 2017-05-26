<?php

require_once("dbsconf/DbConnect.php"); 
global $CONN;



//-----setting rekap
if (!isset($_POST['submit'])){
$year2 	= date("Y");
$month2 = date("m");
}

?>

<html>
<head>
<title>
	Portal Neuronworks - rekap
</title>
</head>
<!--<link href="include/css/style.css" rel="stylesheet" type="text/css" />-->
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td align="center">
		<form name="formReportBulanan" method="post" action="" >
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td>Bulan</td>
				<td>
				<select name="month">
					<option value="1" <?php if (($month2 == 1) || ($_POST['month'] == 1)) echo "selected=\"selected\""; ?>> Januari </option>
					<option value="2" <?php if (($month2 == 2) || ($_POST['month'] == 2)) echo "selected=\"selected\""; ?>> Februari </option>
					<option value="3" <?php if (($month2 == 3) || ($_POST['month'] == 3)) echo "selected=\"selected\""; ?>> Maret </option>
					<option value="4" <?php if (($month2 == 4) || ($_POST['month'] == 4)) echo "selected=\"selected\""; ?>> April </option>
					<option value="5" <?php if (($month2 == 5) || ($_POST['month'] == 5)) echo "selected=\"selected\""; ?>> Mei </option>
					<option value="6" <?php if (($month2 == 6) || ($_POST['month'] == 6)) echo "selected=\"selected\""; ?>> Juni </option>
					<option value="7" <?php if (($month2 == 7) || ($_POST['month'] == 7)) echo "selected=\"selected\""; ?>> Juli </option>
					<option value="8" <?php if (($month2 == 8) || ($_POST['month'] == 8)) echo "selected=\"selected\""; ?>> Agustus </option>
					<option value="9" <?php if (($month2 == 9) || ($_POST['month'] == 9)) echo "selected=\"selected\""; ?>> September </option>
					<option value="10" <?php if (($month2 == 10) || ($_POST['month'] == 10)) echo "selected=\"selected\""; ?>> Oktober </option>
					<option value="11" <?php if (($month2 == 11) || ($_POST['month'] == 11)) echo "selected=\"selected\""; ?>> November </option>
					<option value="12" <?php if (($month2 == 12) || ($_POST['month'] == 12)) echo "selected=\"selected\""; ?>> Desember </option>
				</select>
				</td>
				<td>
				<select name="year">
				<?php
				$currentYear = date("Y");
				for ($i=0; $i < 6; $i++){
					$valueYear = $currentYear - $i;
				?>
				<option value="<?php echo $valueYear; ?>" 
				<?php if (($valueYear == $currentYear) || ($valueYear == $_POST['year'])) echo "selected=\"selected\""; ?>>
				<?php echo $valueYear; ?></option>
					
				<?php
				}
				?>
				</select>
				</td>
				<td>
					<input type="submit" name="submit" value="Tampilkan!">
				</td>
			</tr>
			<tr></tr>
			
		</table>
		</form>
		</td>
	</tr>
	<?php

		if (isset($_POST['submit'])){

			$year2 	= $_POST['year'];
			$month2 = $_POST['month'];
			
		}
				
		if ($month2 == 1){
			$year1 	= $year2 - 1;
			$month1 = 12;
		}else{
			$year1 = $year2;
			$month1 = $month2 - 1;			
		
		}			
	?>
	<tr>
		<td align="center">
		RekapAbsensi
		<br />
		<a href="rekapabsenbulananExcel.php?year1=<?php echo $year1; ?>&month1=<?php echo $month1; ?>&year2=<?php echo $year2; ?>&month2=<?php echo $month2; ?>">export excel</a>
		</td>
	</tr>
	
	<tr>
		<td>
			 <table border="1px" cellpadding="3" align="center" cellspacing="1" width="95%">
			 <tr bgcolor="#CCCCCC">
				<td width="5%"><b> Nik </b></td>
				<td width="15%"><b> Nama </b></td>
				<td width="8%"><b> Jml Masuk (hari)</b></td>
				<td width="8%"> <b>Jml Sakit (hari)</b></td>
				<td width="8%"> <b>Jml Ijin (hari)</b></td>
				<td width="8%"> <b>Jml Bolos (hari)</b></td>
				<td width="8%"> <b>Jml Telat (jam)</b></td>
				<td width="8%"> <b>Jml Spj lokal full (hari) </b></td>
				<td width="8%"> <b>Jml SPJ lokal not full (hari) </b></td>
				<td width="8%"> <b>Jml Puasa/Ganti makan (hari)</b> </td>
				<td width="8%"> <b>Jml Lembur workday (jam)</b></td>
				<td width="8%"> <b>Jml Lembur non workday (jam) </b></td>
			 </tr>
			 
			 <?php
				$query = "SELECT user_id, name FROM user WHERE level_id = 3 AND status_login <> 2
							ORDER BY name ASC";

				$datauser   = $CONN->Execute($query);
				$cntUser = 0;
				
				
				while($dataU = $datauser->FetchNextObject()){
					//echo "text<br />";
			//---------------- hitung absen masuk, sakit, ijin, bolos---------------------------------------
			//----------------------------------------------------------------------------------------------
			
					$queryAbsen1 = "SELECT absentype_id, count(*) AS jmlAbsen
									FROM absensiharian ah JOIN calendar cal ON ah.calendar_id = cal.calendar_id
									WHERE (((cal.year = ".$year1.") AND (cal.month = ".$month1.") AND (cal.date >25)) 
									OR ((cal.year = ".$year2.") AND (cal.month = ".$month2.") AND (cal.date <26)))
									AND ah.user_id = ".$dataU->USER_ID."
									AND cal.status = 1
									GROUP BY absentype_id";  


					$dataAbsen1   = $CONN->Execute($queryAbsen1);
					
					$jmlAbsenMasuk = 0; $jmlAbsenSakit = 0; $jmlAbsenIjin = 0; $jmlAbsenBolos = 0;
					
					while($dataRowAbsen1 = $dataAbsen1->FetchNextObject()){	
						
						if ($dataRowAbsen1->ABSENTYPE_ID == 1){
							$jmlAbsenMasuk = $dataRowAbsen1->JMLABSEN;
						}else if ($dataRowAbsen1->ABSENTYPE_ID == 2){
							$jmlAbsenSakit = $dataRowAbsen1->JMLABSEN;
						}else if ($dataRowAbsen1->ABSENTYPE_ID == 3){
							$jmlAbsenIjin = $dataRowAbsen1->JMLABSEN;
						}else if ($dataRowAbsen1->ABSENTYPE_ID == 0){
							$jmlAbsenBolos = $dataRowAbsen1->JMLABSEN;
						}
					}							
					
			//----------------------------------------------------------------------------------------------
			
			
			//---------------- hitung absen telat---------------------------------------
			//----------------------------------------------------------------------------------------------
			
					$queryAbsenTelat = "SELECT ah.start_time AS jammasuk
										FROM absensiharian ah JOIN calendar cal ON ah.calendar_id = cal.calendar_id
										WHERE (((cal.year = ".$year1.") AND (cal.month = ".$month1.") AND (cal.date >25)) 
										OR ((cal.year = ".$year2.") AND (cal.month = ".$month2.") AND (cal.date <26)))
										AND ah.user_id = ".$dataU->USER_ID."
										AND absentype_id = 1
										AND start_time > '08:31:00' 
										ORDER BY cal.year, cal.month, cal.date ASC";  	
					$dataAbsenTelat   = $CONN->Execute($queryAbsenTelat);
					
					$jmlAbsenTelat=0;
					
					while($dataRowTelat = $dataAbsenTelat->FetchNextObject()){	
						
						$expJamMasuk = explode(":",$dataRowTelat->JAMMASUK);
						
						if ($expJamMasuk[0] == "09"){
							$tambahTelat = 1;
						}else{
							$intJamMasuk = (int)$expJamMasuk[0];
							
							$tambahTelat = ($intJamMasuk - 9) + 1;
						
						}
						
						$jmlAbsenTelat = $jmlAbsenTelat + $tambahTelat;  
			
					}							
				
			//----------------------------------------------------------------------------------------------
			
			
			
			//---------------- hitung spj lokal, puasa ---------------------------------------
			//----------------------------------------------------------------------------------------------
			# perhitungan absen puasa sudah tidak disini query nya..!
					/*$queryAbsenSPJ = "SELECT ao.out_type, ao.out_timestart AS jammulai, out_descstart AS descstart, 
											 ao.out_timeend AS jamselesai, cal.date, cal.month, cal.year 
										FROM (absensiout ao JOIN absensiharian ah ON ao.absensiharian_id = ah.absensiharian_id)
										JOIN calendar cal ON ah.calendar_id = cal.calendar_id  
										WHERE (((cal.year = ".$year1.") AND (cal.month = ".$month1.") AND (cal.date >25)) 
										OR ((cal.year = ".$year2.") AND (cal.month = ".$month2.") AND (cal.date <26)))
										AND ah.user_id = ".$dataU->USER_ID."
										AND ao.out_type = 5 
										ORDER BY cal.year, cal.month, cal.date ASC";  
										
											
					$dataAbsenSPJ   = $CONN->Execute($queryAbsenSPJ);
					//echo $dataAbsenSPJ."<br />";   
					$jmlAbsenSPJLokalFull=0; $jmlAbsenSPJLokalNotFull=0; $jmlAbsenPuasa=0;
					
					while($dataRowSPJ = $dataAbsenSPJ->FetchNextObject()){	
						
						$posSaum = strpos(strtolower($dataRowSPJ->DESCSTART), "saum"); 
						$posShaum = strpos(strtolower($dataRowSPJ->DESCSTART), "shaum"); 
						if (($posSaum === false) && ($posShaum === false)){
							
							$posPuasa = strpos(strtolower($dataRowSPJ->DESCSTART), "puasa");
							if ($posPuasa === false){
								$expJamMulai   = explode(":",$dataRowSPJ->JAMMULAI);
								$intJamMulai = (int)$expJamMulai[0];
								
								if ($intJamMulai < 13){
									$jmlAbsenSPJLokalFull = $jmlAbsenSPJLokalFull + 1;
								}else{
									$jmlAbsenSPJLokalNotFull = $jmlAbsenSPJLokalNotFull + 1;
								}
								
							}else{
								$jmlAbsenPuasa = $jmlAbsenPuasa + 1;
							}
							
						}else{
							$jmlAbsenPuasa = $jmlAbsenPuasa + 1;
						}
						
						if ($dataRowSPJ->OUT_TYPE == 14)
						 	$jmlAbsenPuasa = $jmlAbsenPuasa + 1;
							
						if ($dataRowSPJ->OUT_TYPE == 5)
						 	$jmlAbsenSPJLokalFull = $jmlAbsenSPJLokalFull + 1;
						
						if ($dataRowSPJ->OUT_TYPE == 13)
						 	$jmlAbsenSPJLokalNotFull = $jmlAbsenSPJLokalNotFull + 1;		
							
						$test = $dataRowSPJ->DESCSTART;
						
					}				*/
					$queryAbsenSPJ = "SELECT ao.out_type, ao.out_timestart AS jammulai, out_descstart AS descstart, 
											 ao.out_timeend AS jamselesai, cal.date, cal.month, cal.year 
										FROM (absensiout ao JOIN absensiharian ah ON ao.absensiharian_id = ah.absensiharian_id)
										JOIN calendar cal ON ah.calendar_id = cal.calendar_id  
										WHERE (((cal.year = ".$year1.") AND (cal.month = ".$month1.") AND (cal.date >25)) 
										OR ((cal.year = ".$year2.") AND (cal.month = ".$month2.") AND (cal.date <26)))
										AND ah.user_id = ".$dataU->USER_ID."
										 
										ORDER BY cal.year, cal.month, cal.date ASC";  	
					$dataAbsenSPJ   = $CONN->Execute($queryAbsenSPJ);
					
					$jmlAbsenSPJLokalFull=0; $jmlAbsenSPJLokalNotFull=0; $jmlAbsenPuasa=0;
					
					while($dataRowSPJ = $dataAbsenSPJ->FetchNextObject()){	
						
						$posSaum = strpos(strtolower($dataRowSPJ->DESCSTART), "saum"); 
						$posShaum = strpos(strtolower($dataRowSPJ->DESCSTART), "shaum"); 
						if (($posSaum === false) && ($posShaum === false)){
							
							$posPuasa = strpos(strtolower($dataRowSPJ->DESCSTART), "puasa");
							if ($posPuasa === false){
								$expJamMulai   = explode(":",$dataRowSPJ->JAMMULAI);
								$intJamMulai = (int)$expJamMulai[0];
								
								//if ($intJamMulai < 13){
								//	$jmlAbsenSPJLokalFull = $jmlAbsenSPJLokalFull + 1;
								//}else{
								//	$jmlAbsenSPJLokalNotFull = $jmlAbsenSPJLokalNotFull + 1;
								//}
								
							}else{
								$jmlAbsenPuasa = $jmlAbsenPuasa + 1;
							}
							
						}else{
							$jmlAbsenPuasa = $jmlAbsenPuasa + 1;
						}
						
						if ($dataRowSPJ->OUT_TYPE == 14)
						 	$jmlAbsenPuasa = $jmlAbsenPuasa + 1;
							
						if ($dataRowSPJ->OUT_TYPE == 5)
						 	$jmlAbsenSPJLokalFull = $jmlAbsenSPJLokalFull + 1;
						
						if ($dataRowSPJ->OUT_TYPE == 13)
						 	$jmlAbsenSPJLokalNotFull = $jmlAbsenSPJLokalNotFull + 1;		
							
						$test = $dataRowSPJ->DESCSTART;
						
					}					
				
			//----------------------------------------------------------------------------------------------
			#----------------------------------puasa---------------------
			#20120119 : new revisi
					$queryAbsenPuasa = "SELECT count(distinct(a.calendar_id))as jmlhpuasa 
										FROM absen_temp a join calendar cal on cal.calendar_id = a.calendar_id
										WHERE (((cal.year = ".$year1.") AND (cal.month = ".$month1.") 
										AND (cal.date >25)) OR ((cal.year = ".$year2.") 
										AND (cal.month = ".$month2.") AND (cal.date <26)))										
										AND a.user_id =".$dataU->USER_ID."
										and a.absenType_id = 14	
										and a.status = 1
										
										ORDER BY cal.year, cal.month, cal.date ASC";  	
					//echo $queryAbsenPuasa;
					$dataAbsenPuasa   = $CONN->Execute($queryAbsenPuasa);
					//echo $queryAbsenPuasa."<br />";
					$jmlAbsenPuasa1=0;
					
					while($dataRowPuasa = $dataAbsenPuasa->FetchNextObject()){	
						
						$posPuasa = $dataRowPuasa->JMLHPUASA; 
						
						//echo $posPuasa;
						$posShaum = strpos(strtolower($dataRowPuasa->DESCSTART), "shaum"); 
						
							if ($posPuasa > 0){
								
								$jmlAbsenPuasa1 = $posPuasa;
								
							}								
											
					}							
				
			//----------------------------------------------------------------------------------------------
			
			
			//---------------- hitung Lembur ---------------------------------------
			//----------------------------------------------------------------------------------------------

					$queryAbsenLembur = "SELECT count(ah.start_time) as jumlah, ah.start_time AS jamlembur, ah.start_desc AS descLembur, ah.out_time AS jampulang, cal.status AS statusday 
										FROM absensiharian ah JOIN calendar cal ON ah.calendar_id = cal.calendar_id
										WHERE (((cal.year = ".$year1.") AND (cal.month = ".$month1.") AND (cal.date >25)) 
										OR ((cal.year = ".$year2.") AND (cal.month = ".$month2.") AND (cal.date <26)))
										AND ah.user_id = ".$dataU->USER_ID."
										AND absentype_id = 1
										
										AND ah.start_time > '08:00:00'
										
										ORDER BY cal.year, cal.month, cal.date ASC";  	
										
					$dataAbsenLembur  = $CONN->Execute($queryAbsenLembur);
					
					$jmlLemburWorkDay=0; $jmlLemburNonWorkDay=0;
					
					while($dataRowLembur = $dataAbsenLembur->FetchNextObject()){
						
						$posLembur = strpos(strpos($dataRowLembur->START_DESC), "lembur");
						//$posLembur = $dataRowLembur->JAMLEMBUR;
						$jumlah = $dataRowLembur->JUMLAH;
						if ($posLembur === false){
						//if ($posLembur === true){
						
							$jmlLemburWorkDay=0;
						}else{
					
							$expJamLembur = explode(":",$dataRowLembur->JAMLEMBUR);
							$intJamLembur = (int)$expJamLembur[0];
							 
							$expJamPulang = explode(":",$dataRowLembur->JAMPULANG);
							$intJamPulang = (int)$expJamPulang[0];
							//echo $dataRowLembur->STATUSDAY;
							if ($dataRowLembur->STATUSDAY == 0){
								//$jmlJamLembur = $intJamPulang-$intJamLembur;
								$jmlJamLembur = $jumlah;
								//$jmlLemburNonWorkDay = $jmlLemburNonWorkDay + $jmlJamLembur;
								$jmlLemburNonWorkDay = $jumlah;
							}else{
							
								//$jmlJamLembur = $intJamLembur - 19;
								$jmlJamLembur = $jumlah;
								//$jmlLemburWorkDay = $jmlLemburWorkDay + $jmlJamLembur;
								$jmlLemburWorkDay = $jumlah;
							}	
							
						}
					}	
					//=-------------------------------------=						
				$queryAbsenLembur2 = "SELECT count(distinct lem.calendar_id, lem.user_id) as jumlah, lem.out_time, cal.status 
										FROM lembur lem join calendar cal on cal.calendar_id = lem.calendar_id
										WHERE(((cal.year = ".$year1.") AND (cal.month = ".$month1.") AND (cal.date >25)) 
										OR ((cal.year = ".$year2.") AND (cal.month = ".$month2.") AND (cal.date <26)))
										and lem.user_id = ".$dataU->USER_ID."
										ORDER BY lem.calendar_id ASC";	
										
					$dataAbsenLembur2  = $CONN->Execute($queryAbsenLembur2);
					
					$jmlLemburWorkDay2=0; $jmlLemburNonWorkDay2=0;
					
					while($dataRowLembur2 = $dataAbsenLembur2->FetchNextObject()){
						
						//$posLembur2 = strpos(strpos($dataRowLembur2->start_desc), "lembur");
						//$posLembur = $dataRowLembur->JAMLEMBUR;
						$jumlah2 = $dataRowLembur2->JUMLAH;
						//if ($posLembur2 === false){
						/*if ($jumlah2 < 1){
						
							$jmlLemburWorkDay2=0;
						}else{*/
						//echo $jumlah2;
							if ($dataRowLembur2->STATUS == 0){
								//$jmlJamLembur = $intJamPulang-$intJamLembur;
								$jmlJamLembur2 = $jumlah2;
								//$jmlLemburNonWorkDay = $jmlLemburNonWorkDay + $jmlJamLembur;
								$jmlLemburNonWorkDay2 = $jumlah2;
							}else{
							
								//$jmlJamLembur = $intJamLembur - 19;
								$jmlJamLembur2 = $jumlah2;
								//$jmlLemburWorkDay = $jmlLemburWorkDay + $jmlJamLembur;
								$jmlLemburWorkDay2 = $jumlah2;
							}
							
						//}
					}
			//----------------------------------------------------------------------------------------------
					$rowColor = "";
					$rowGajilGenap = $cntUser%2;
					if ($rowGajilGenap ==1)
						$rowColor = "bgcolor=\"#DEDEEE\"";
			
						 ?>
				<tr <?php echo $rowColor; ?>>
					<td align="center"><?php echo $dataU->USER_ID; ?></td>
					<td align="left"><?php echo ucwords(strtolower($dataU->NAME)); ?></td>
					<td align="right"><a href="rekapabsenbulanan.php?id=1&userid=<?php echo $dataU->USER_ID;?>" ><?php echo $jmlAbsenMasuk; ?></a></td>
					
					<td align="right"><?php echo $jmlAbsenSakit; ?></td>
					<td align="right"><?php echo $jmlAbsenIjin; ?></td>
					<td align="right"><?php echo $jmlAbsenBolos; ?></td>
					<td align="right"><a href="rekapabsenbulanan.php?id=2&userid=<?php echo $dataU->USER_ID;?>" ><?php echo $jmlAbsenTelat; ?></a></td>
					<td align="right"><a href="rekapabsenbulanan.php?id=5&userid=<?php echo $dataU->USER_ID;?>" ><?php echo $jmlAbsenSPJLokalFull; ?></a></td>
					<td align="right"><a href="rekapabsenbulanan.php?id=3&userid=<?php echo $dataU->USER_ID;?>" ><?php echo $jmlAbsenSPJLokalNotFull; ?></a></td>
					<!--td align="right"><?php //echo $jmlAbsenPuasa; ?>&nbsp;&nbsp;</td-->
                    <td align="right"><a href="rekapabsenbulanan.php?id=4&userid=<?php echo $dataU->USER_ID;?>" ><?php echo $jmlAbsenPuasa1; ?></a></td>
					<td align="right"><?php echo $jmlLemburWorkDay2; ?></td>
					<td align="right"><?php echo $jmlLemburNonWorkDay2; ?></td>
				</tr>
				<?php
				if (($_GET['id'] == 1) && ($dataU->USER_ID == $_GET['userid'])){
					$queryAbsenDetail = "SELECT CONCAT (cal.year, '-',cal.month, '-',cal.date) AS tanggal, ah.start_time, 
												ah.start_desc, ah.out_time, ah.out_desc, ah.worksummary, absentype_id  
										FROM absensiharian ah JOIN calendar cal ON ah.calendar_id = cal.calendar_id
										WHERE (((cal.year = ".$year1.") AND (cal.month = ".$month1.") AND (cal.date >25)) 
										OR ((cal.year = ".$year2.") AND (cal.month = ".$month2.") AND (cal.date <26)))
										AND ah.user_id = ".$_GET['userid']."
										ORDER BY cal.year, cal.month, cal.date ASC";  	
					$dataAbsenDetail   = $CONN->Execute($queryAbsenDetail);
			?>
						<tr bgcolor="#dddd88">
							<td colspan="2" bgcolor="#FFFFFF"></td>
							<td align="center"><b>Tanggal</b></td>
							<td align="center"><b>Jam Masuk</b></td>
							<td align="center" colspan="2"><b>Keterangan Masuk</b></td>
							<td align="center"><b>Jam Keluar</b></td>
							<td align="center" colspan="2"><b>Keterangan Keluar</b></td>
							<td align="center" colspan="3"><b>Work Summary</b></td>
			
						</tr>
			
			<?php 		
					
					
					while($dataRowAbsenDetail = $dataAbsenDetail->FetchNextObject()){	
						
						if (strtolower($dataRowAbsenDetail->ABSENTYPE_ID) == 2){
							$bgcolor = "bgcolor = \"#cc0000\"";
							
						}else if (strtolower($dataRowAbsenDetail->ABSENTYPE_ID) == 3){	
							$bgcolor = "bgcolor = \"#4444aa\"";
						}else if (strtolower($dataRowAbsenDetail->ABSENTYPE_ID) == 0){	
							$bgcolor = "bgcolor = \"#996633\"";
							
						}else{
						
							$bgcolor = "";
						}
							
					?>
				
					
						<tr bgcolor="#FFFFCC">
							<td colspan="2" bgcolor="#FFFFFF"></td>
							<td align="center"><?php echo $dataRowAbsenDetail->TANGGAL; ?>&nbsp;&nbsp;</td>
							<td align="center"><?php echo $dataRowAbsenDetail->START_TIME; ?>&nbsp;&nbsp;</td>
							<td align="left" colspan="2" <?php echo $bgcolor;?>><?php echo $dataRowAbsenDetail->START_DESC; ?>&nbsp;&nbsp;</td>
							<td align="center"><?php echo $dataRowAbsenDetail->OUT_TIME; ?>&nbsp;&nbsp;</td>
							<td align="left" colspan="2"><?php echo $dataRowAbsenDetail->OUT_DESC; ?>&nbsp;&nbsp;</td>
							<td align="left" colspan="3"><?php echo $dataRowAbsenDetail->WORKSUMMARY;  ?>&nbsp;&nbsp;</td>
			
						</tr>	
					
				<?php
					} 	
					?>

					<tr bgcolor="#666666" height="15">
						<td colspan="12"></td>
					</tr>
			
				
			 <?php
			
				}else if(($_GET['id'] == 2) && ($dataU->USER_ID == $_GET['userid'])){
				
					$queryAbsenDetail = "SELECT CONCAT (cal.year, '-',cal.month, '-',cal.date) AS tanggal, ah.start_time AS jammasuk, ah.start_desc
										FROM absensiharian ah JOIN calendar cal ON ah.calendar_id = cal.calendar_id
										WHERE (((cal.year = ".$year1.") AND (cal.month = ".$month1.") AND (cal.date >25)) 
										OR ((cal.year = ".$year2.") AND (cal.month = ".$month2.") AND (cal.date <26)))
										AND ah.user_id = ".$dataU->USER_ID."
										AND absentype_id = 1
										AND start_time > '09:01:00' 
										ORDER BY cal.year, cal.month, cal.date ASC";  	
					$dataAbsenDetail   = $CONN->Execute($queryAbsenDetail);
			?>
						<tr bgcolor="#dddd88">
							<td colspan="3" bgcolor="#FFFFFF"></td>
							<td align="center"><b>No</b></td>
							<td align="center" colspan="2"><b>Tanggal</b></td>
							<td align="center" colspan="2"><b>Jam Masuk</b></td>
							<td align="center" colspan="4"><b>Keterangan Masuk</b></td>
			
						</tr>
			
			<?php 		
					
					$no = 1;
					while($dataRowAbsenDetail = $dataAbsenDetail->FetchNextObject()){	
							
					?>
						<tr bgcolor="#FFFFCC">
							<td colspan="3" bgcolor="#FFFFFF"></td>
							<td align="right"><?php echo $no;?>&nbsp;</td>
							<td align="center" colspan="2"><?php echo $dataRowAbsenDetail->TANGGAL; ?>&nbsp;&nbsp;</td>
							<td align="center" colspan="2"><?php echo $dataRowAbsenDetail->JAMMASUK; ?>&nbsp;&nbsp;</td>
							<td align="left" colspan="4"><?php echo $dataRowAbsenDetail->START_DESC; ?>&nbsp;&nbsp;</td>
						</tr>	
					
				<?php
						$no++;
					} 	
					?>
					<tr bgcolor="#666666" height="15">
						<td colspan="12"></td>
					</tr>
				<?php
				}else if(($_GET['id'] == 3) && ($dataU->USER_ID == $_GET['userid'])){
				
					$queryAbsenDetail = "SELECT CONCAT (cal.year, '-',cal.month, '-',cal.date) AS tanggal, at.type_name AS typedesc, 
											 ao.out_timestart AS jammulai, 
											 out_descstart AS descstart, ao.out_timeend AS jamselesai
										FROM ((absensiout ao JOIN absensiharian ah ON ao.absensiharian_id = ah.absensiharian_id)
										JOIN calendar cal ON ah.calendar_id = cal.calendar_id )
										JOIN absen_type at ON ao.out_type = at.type_id 
										WHERE (((cal.year = ".$year1.") AND (cal.month = ".$month1.") AND (cal.date >25)) 
										OR ((cal.year = ".$year2.") AND (cal.month = ".$month2.") AND (cal.date <26)))
										AND ah.user_id = ".$dataU->USER_ID."
										AND ao.out_type = 13 
										ORDER BY cal.year, cal.month, cal.date ASC"; 	
					$dataAbsenDetail   = $CONN->Execute($queryAbsenDetail);
			?>
						<tr bgcolor="#dddd88">
							<td colspan="2" bgcolor="#FFFFFF"></td>
							<td align="center"><b>No</b></td>
							<td align="center"><b>Tanggal</b></td>
							<td align="center"><b>Jam Mulai</b></td>
							<td align="center" colspan="2"><b>Keterangan Mulai</b></td>
							<td align="center"><b>Jam Selesai</b></td>
							<td align="center" colspan="2"><b>Tipe Keluar</b></td>
							<td align="center" colspan="2"><b>Work Summary</b></td>
			
						</tr>
			
			<?php 		
					
					$no = 1;
					while($dataRowAbsenDetail = $dataAbsenDetail->FetchNextObject()){	
							
					?>
						<tr bgcolor="#FFFFCC">
							<td colspan="2" bgcolor="#FFFFFF"></td>
							<td align="right"><?php echo $no;?>&nbsp;</td>
							<td align="center"><?php echo $dataRowAbsenDetail->TANGGAL; ?>&nbsp;&nbsp;</td>
							<td align="center"><?php echo $dataRowAbsenDetail->JAMMULAI; ?>&nbsp;&nbsp;</td>
							<td align="left" colspan="2" <?php echo $bgcolor;?>><?php echo $dataRowAbsenDetail->DESCSTART; ?>&nbsp;&nbsp;</td>
							<td align="center"><?php echo $dataRowAbsenDetail->JAMSELESAI; ?>&nbsp;&nbsp;</td>
							<td align="left" colspan="2"><?php echo $dataRowAbsenDetail->TYPEDESC; ?>&nbsp;&nbsp;</td>
							<td align="left" colspan="2"><?php echo $dataRowAbsenDetail->WORKSUMMARY;  ?>&nbsp;&nbsp;</td>
			
						</tr>	
					
				<?php
					$no++;
					} 	
					?>
					<tr bgcolor="#666666" height="15">
						<td colspan="12"></td>
					</tr>
                <?php
				}else if(($_GET['id'] == 5) && ($dataU->USER_ID == $_GET['userid'])){
				
					$queryAbsenDetail = "SELECT CONCAT (cal.year, '-',cal.month, '-',cal.date) AS tanggal, at.type_name AS typedesc, 
											 ao.out_timestart AS jammulai, 
											 out_descstart AS descstart, ao.out_timeend AS jamselesai
										FROM ((absensiout ao JOIN absensiharian ah ON ao.absensiharian_id = ah.absensiharian_id)
										JOIN calendar cal ON ah.calendar_id = cal.calendar_id )
										JOIN absen_type at ON ao.out_type = at.type_id 
										WHERE (((cal.year = ".$year1.") AND (cal.month = ".$month1.") AND (cal.date >25)) 
										OR ((cal.year = ".$year2.") AND (cal.month = ".$month2.") AND (cal.date <26)))
										AND ah.user_id = ".$dataU->USER_ID."
										AND ao.out_type = 5 
										ORDER BY cal.year, cal.month, cal.date ASC"; 	
					$dataAbsenDetail   = $CONN->Execute($queryAbsenDetail);
			?>
						<tr bgcolor="#dddd88">
							<td colspan="2" bgcolor="#FFFFFF"></td>
							<td align="center"><b>No</b></td>
							<td align="center"><b>Tanggal</b></td>
							<td align="center"><b>Jam Mulai</b></td>
							<td align="center" colspan="2"><b>Keterangan Mulai</b></td>
							<td align="center"><b>Jam Selesai</b></td>
							<td align="center" colspan="2"><b>Tipe Keluar</b></td>
							<td align="center" colspan="2"><b>Work Summary</b></td>
			
						</tr>
			
			<?php 		
					
					$no = 1;
					while($dataRowAbsenDetail = $dataAbsenDetail->FetchNextObject()){	
							
					?>
						<tr bgcolor="#FFFFCC">
							<td colspan="2" bgcolor="#FFFFFF"></td>
							<td align="right"><?php echo $no;?>&nbsp;</td>
							<td align="center"><?php echo $dataRowAbsenDetail->TANGGAL; ?>&nbsp;&nbsp;</td>
							<td align="center"><?php echo $dataRowAbsenDetail->JAMMULAI; ?>&nbsp;&nbsp;</td>
							<td align="left" colspan="2" <?php echo $bgcolor;?>><?php echo $dataRowAbsenDetail->DESCSTART; ?>&nbsp;&nbsp;</td>
							<td align="center"><?php echo $dataRowAbsenDetail->JAMSELESAI; ?>&nbsp;&nbsp;</td>
							<td align="left" colspan="2"><?php echo $dataRowAbsenDetail->TYPEDESC; ?>&nbsp;&nbsp;</td>
							<td align="left" colspan="2"><?php echo $dataRowAbsenDetail->WORKSUMMARY;  ?>&nbsp;&nbsp;</td>
			
						</tr>	
					
				<?php
					$no++;
					} 	
					?>
					<tr bgcolor="#666666" height="15">
						<td colspan="12"></td>
					</tr>    
                    <?php
			
				}else if(($_GET['id'] == 4) && ($dataU->USER_ID == $_GET['userid'])){
				
					$queryAbsenDetail = "SELECT CONCAT (cal.year, '-',cal.month, '-',cal.date) AS tanggal, ah.start_time AS jammasuk, ah.start_desc
										FROM absen_temp ah JOIN calendar cal ON ah.calendar_id = cal.calendar_id
										WHERE (((cal.year = ".$year1.") AND (cal.month = ".$month1.") AND (cal.date >25)) 
										OR ((cal.year = ".$year2.") AND (cal.month = ".$month2.") AND (cal.date <26)))
										AND ah.user_id = ".$dataU->USER_ID."
										AND absentype_id = 14
										and ah.status = 1
										GROUP BY tanggal
										ORDER BY cal.year, cal.month, cal.date ASC";  	
					$dataAbsenDetail   = $CONN->Execute($queryAbsenDetail);
			?>
						<tr bgcolor="#dddd88">
							<td colspan="3" bgcolor="#FFFFFF"></td>
							<td align="center"><b>No</b></td>
							<td align="center" colspan="2"><b>Tanggal</b></td>
							<td align="center" colspan="2"><b>Jam Masuk</b></td>
							<td align="center" colspan="4"><b>Keterangan Puasa</b></td>
			
						</tr>
			
			<?php 		
					
					$no = 1;
					while($dataRowAbsenDetail = $dataAbsenDetail->FetchNextObject()){	
							
					?>
						<tr bgcolor="#FFFFCC">
							<td colspan="3" bgcolor="#FFFFFF"></td>
							<td align="right"><?php echo $no;?>&nbsp;</td>
							<td align="center" colspan="2"><?php echo $dataRowAbsenDetail->TANGGAL; ?>&nbsp;&nbsp;</td>
							<td align="center" colspan="2"><?php echo $dataRowAbsenDetail->JAMMASUK; ?>&nbsp;&nbsp;</td>
							<td align="left" colspan="4"><?php echo $dataRowAbsenDetail->START_DESC; ?>&nbsp;&nbsp;</td>
						</tr>	
			<?php
						$no++;
					} 	
			?>
					<tr bgcolor="#666666" height="15">
						<td colspan="12"></td>
					</tr>
				<?php	
				
					
				} //tutup if detail
				$cntUser++;
			 }//tutup while user
			 ?>
			 </table>
		</td>
	</tr>
</table>
</html>
