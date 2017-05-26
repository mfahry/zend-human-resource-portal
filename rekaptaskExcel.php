<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=AbsensiRekap.xls");
require_once("dbsconf/DbConnect.php"); 
global $CONN;

//-----setting rekap
$year1 	= $_GET['year1'];
$month1 = $_GET['month1'];

$year2 	= $_GET['year2'];
$month2 = $_GET['month2'];

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
		<td>
		RekapAbsensi
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
				while($dataU = $datauser->FetchNextObject()){
				
			//---------------- hitung absen masuk, sakit, ijin, bolos---------------------------------------
			//----------------------------------------------------------------------------------------------
			
					$queryAbsen1 = "SELECT absentype_id, count(*) AS jmlAbsen
									FROM absensiharian ah JOIN calendar cal ON ah.calendar_id = cal.calendar_id
									WHERE (((cal.year = ".$year1.") AND (cal.month = ".$month1.") AND (cal.date >25)) 
									OR ((cal.year = ".$year2.") AND (cal.month = ".$month2.") AND (cal.date <26)))
									AND ah.user_id = ".$dataU->USER_ID."
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
										AND start_time > '09:01:00' 
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
			
					$queryAbsenSPJ = "SELECT ao.out_type, ao.out_timestart AS jammulai, out_descstart AS descstart, 
											 ao.out_timeend AS jamselesai, cal.date, cal.month, cal.year 
										FROM (absensiout ao JOIN absensiharian ah ON ao.absensiharian_id = ah.absensiharian_id)
										JOIN calendar cal ON ah.calendar_id = cal.calendar_id  
										WHERE (((cal.year = ".$year1.") AND (cal.month = ".$month1.") AND (cal.date >25)) 
										OR ((cal.year = ".$year2.") AND (cal.month = ".$month2.") AND (cal.date <26)))
										AND ah.user_id = ".$dataU->USER_ID."
										AND ao.out_type = 5 
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
						
						$test = $dataRowSPJ->DESCSTART;
						
					}							
				
			//----------------------------------------------------------------------------------------------
			
			
			//---------------- hitung Lembur ---------------------------------------
			//----------------------------------------------------------------------------------------------
			
					$queryAbsenLembur = "SELECT ah.start_time AS jamlembur, ah.start_desc AS descLembur, ah.out_time AS jampulang, cal.status AS statusday
										FROM absensiharian ah JOIN calendar cal ON ah.calendar_id = cal.calendar_id
										WHERE (((cal.year = ".$year1.") AND (cal.month = ".$month1.") AND (cal.date >25)) 
										OR ((cal.year = ".$year2.") AND (cal.month = ".$month2.") AND (cal.date <26)))
										AND ah.user_id = ".$dataU->USER_ID."
										AND absentype_id = 1
										AND ah.out_time > '18:00:00'
										ORDER BY cal.year, cal.month, cal.date ASC";  	
					$dataAbsenLembur  = $CONN->Execute($queryAbsenLembur);
					
					$jmlLemburWorkDay=0; $jmlLemburNonWorkDay=0;
					
					while($dataRowLembur = $dataAbsenLembur->FetchNextObject()){
						
						$posLembur = strpos(strpos($dataRowLembur->JAMLEMBUR), "lembur");
						
						if ($posLembur === false){
						
							$jmlLemburWorkDay=0;
						}else{
					
							$expJamLembur = explode(":",$dataRowLembur->JAMLEMBUR);
							$intJamLembur = (int)$expJamLembur[0];
							 
							$expJamPulang = explode(":",$dataRowLembur->JAMPULANG);
							$intJamPulang = (int)$expJamPulang[0];
						
							if ($dataRowLembur->STATUSDAY == 0){
								$jmlJamLembur = $intJamPulang-$intJamLembur;
								
								$$jmlLemburNonWorkDay = $jmlLemburNonWorkDay + $jmlJamLembur;
								
							}else{
							
								$jmlJamLembur = $intJamLembur - 19;
								
								$jmlLemburWorkDay = $jmlLemburWorkDay + $jmlJamLembur;
							}	
							
						}
					}							
				
			//----------------------------------------------------------------------------------------------
			
			
						 ?>
				<tr>
					<td align="center"><?php echo $dataU->USER_ID; ?></td>
					<td align="left"><?php echo ucwords(strtolower($dataU->NAME)); ?></td>
					<td align="right"><?php echo $jmlAbsenMasuk; ?>&nbsp;&nbsp;</td>
					
					<td align="right"><?php echo $jmlAbsenSakit; ?>&nbsp;&nbsp;</td>
					<td align="right"><?php echo $jmlAbsenIjin; ?>&nbsp;&nbsp;</td>
					<td align="right"><?php echo $jmlAbsenBolos; ?>&nbsp;&nbsp;</td>
					<td align="right"><?php echo $jmlAbsenTelat; ?>&nbsp;&nbsp;</td>
					<td align="right"><?php echo $jmlAbsenSPJLokalFull; ?>&nbsp;&nbsp;</td>
					<td align="right"><?php echo $jmlAbsenSPJLokalNotFull; ?>&nbsp;&nbsp;</td>
					<td align="right"><?php echo $jmlAbsenPuasa; ?>&nbsp;&nbsp;</td>
					<td align="right"><?php echo $jmlLemburWorkDay; ?>&nbsp;&nbsp;</td>
					<td align="right"><?php echo $jmlLemburNonWorkDay; ?>&nbsp;&nbsp;</td>
				</tr>
				<?php
			 }//tutup while user
			 ?>
			 </table>
		</td>
	</tr>
</table>
</html>
