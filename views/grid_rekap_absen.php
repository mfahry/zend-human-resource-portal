<?php
error_reporting(E_ALL);

require_once("dbsconf/DbConnect.php"); 
global $CONN;

$year2 	= date("Y");
$month2 = date("n");

if ($month2 == 1){
	$year1 	= $year2 - 1;
	$month1 = 12;
}else{
	$year1 = $year2;
	$month1 = $month2;
}
if(date("d") > 25){
	$month = $month1 - 1;
}
?>
<div style="padding:5px;float:left;" align="left">
<br />
<b>Rekap Absen Periode Bulan <?php echo "$month $year1"; ?></b>
<br />
<table border="1px" cellpadding="3" align="center" cellspacing="1" width="400">
	<tr style="background:url(includes/dhtmlx/dhtmlxGrid/imgs/dhxgrid_dhx_black/hdr.png) top repeat-x;color:#fff;">
		<td align="center" width="280"><b>Nama</b></td>
		<td align="center" width="60"><b>Satuan</b></td>
		<td align="center" width="60"><b>Jumlah</b></td>
	</tr>
		
	 <?php
		$query = "SELECT user_id, name FROM user WHERE user_id=".$_SESSION['userid'];
		//echo $query;
		$datauser   = $CONN->Execute($query);
		$cntUser = 0;
		while($dataU = $datauser->FetchNextObject()){
		
	//---------------- hitung absen masuk, sakit, ijin, bolos---------------------------------------
	//----------------------------------------------------------------------------------------------
	
			$queryAbsen1 = "SELECT absentype_id, count(*) AS jmlAbsen
							FROM absensiharian ah JOIN calendar cal ON ah.calendar_id = cal.calendar_id
							WHERE (((cal.year = ".$year1.") AND (cal.month = ".$month1.") AND (cal.date >25)) 
							OR ((cal.year = ".$year2.") AND (cal.month = ".$month2.") AND (cal.date <26)))
							AND ah.user_id = ".$dataU->USER_ID."
							AND cal.status = 1
							GROUP BY absentype_id";  

			//echo($queryAbsen1);
			$dataAbsen1   = $CONN->Execute($queryAbsen1);
			
			$jmlAbsenMasuk = 0; $jmlAbsenSakit = 0; $jmlAbsenCuti = 0; $jmlAbsenIjin = 0; $jmlAbsenBolos = 0;
			
			while($dataRowAbsen1 = $dataAbsen1->FetchNextObject()){	
				
				if ($dataRowAbsen1->ABSENTYPE_ID == 1){
					$jmlAbsenMasuk = $dataRowAbsen1->JMLABSEN;
				}else if ($dataRowAbsen1->ABSENTYPE_ID == 2){
					$jmlAbsenSakit = $dataRowAbsen1->JMLABSEN;
				}else if ($dataRowAbsen1->ABSENTYPE_ID == 7){
					$jmlAbsenCuti = $dataRowAbsen1->JMLABSEN;
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
			#----------------------------------puasa---------------------
			$queryAbsenPuasa = "SELECT count(*)as jmlhpuasa FROM absen_temp a join calendar cal on cal.calendar_id = a.calendar_id
								WHERE (((cal.year = ".$year1.") AND (cal.month = ".$month1.") 
								AND (cal.date >25)) OR ((cal.year = ".$year2.") 
								AND (cal.month = ".$month2.") AND (cal.date <26)))										
								AND a.user_id =".$dataU->USER_ID."
								and a.absenType_id = 14	
								and a.status = 1
								ORDER BY cal.year, cal.month, cal.date ASC";  	
			//echo $queryAbsenPuasa;
			$dataAbsenPuasa   = $CONN->Execute($queryAbsenPuasa);
			
			$jmlAbsenPuasa1=0;
			
			while($dataRowPuasa = $dataAbsenPuasa->FetchNextObject()){	
				
				$posPuasa = $dataRowPuasa->JMLHPUASA; 
				//echo $posPuasa;
				//$posShaum = strpos(strtolower($dataRowPuasa->DESCSTART), "shaum"); 
				
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
				
				$posLembur = strpos(strtolower($dataRowLembur->DESCLEMBUR), "lembur");
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
			<td><b>Jml Masuk</b></td>
			<td align="center"><b>Hari</b></td>
			<td align="right" width="10"><a href="rekapabsenbulanan.php?id=1&userid=<?php echo $dataU->USER_ID;?>" ><?php echo $jmlAbsenMasuk; ?></a></td>
		</tr>
		<tr <?php echo $rowColor; ?>>
			<td> <b>Jml Sakit</b></td>
			<td align="center"><b>Hari</b></td>
			<td align="right"><?php echo $jmlAbsenSakit; ?></td>
		</tr>
		<tr <?php echo $rowColor; ?>>
			<td> <b>Jml Cuti</b></td>
			<td align="center"><b>Hari</b></td>
			<td align="right"><?php echo $jmlAbsenCuti; ?></td>
		</tr>
		<tr <?php echo $rowColor; ?>>
			<td> <b>Jml Ijin</b></td>
			<td align="center"><b>Hari</b></td>
			<td align="right"><?php echo $jmlAbsenIjin; ?></td>
		</tr>
		<tr <?php echo $rowColor; ?>>
			<td> <b>Jml Bolos</b></td>
			<td align="center"><b>Hari</b></td>
			<td align="right"><?php echo $jmlAbsenBolos; ?></td>
		</tr>
		<tr <?php echo $rowColor; ?>>
			<td> <b>Jml Telat</b></td>
			<td align="center"><b>Jam</b></td>
			<td align="right"><a href="rekapabsenbulanan.php?id=2&userid=<?php echo $dataU->USER_ID;?>" ><?php echo $jmlAbsenTelat; ?></a></td>
		</tr>
		<tr <?php echo $rowColor; ?>>
			<td> <b>Jml Spj lokal sehari</b></td>
			<td align="center"><b>Hari</b></td>
			<td align="right"><a href="rekapabsenbulanan.php?id=3&userid=<?php echo $dataU->USER_ID;?>" ><?php echo $jmlAbsenSPJLokalFull; ?></a></td>
		</tr>
		<tr <?php echo $rowColor; ?>>
			<td> <b>Jml SPJ lokal transport</b></td>
			<td align="center"><b>Hari</b></td>
			<td align="right"><?php echo $jmlAbsenSPJLokalNotFull; ?></td>
		</tr>
		<tr <?php echo $rowColor; ?>>
			<td> <b>Jml Puasa/Ganti makan</b></td>
			<td align="center"><b>Hari</b></td>
			<td align="right"><a href="rekapabsenbulanan.php?id=4&userid=<?php echo $dataU->USER_ID;?>" ><?php echo $jmlAbsenPuasa1; ?></a></td>
		</tr>
		<tr <?php echo $rowColor; ?>>
			<td> <b>Jml Lembur Hari Kerja</b></td>
			<td align="center"><b>Hari</b></td>
			<td align="right"><?php echo $jmlLemburWorkDay2; ?></td>
		</tr>
		<tr <?php echo $rowColor; ?>>
			<td> <b>Jml Lembur Bukan Hari Kerja</b></td>
			<td align="center"><b>Hari</b></td>
			<td align="right"><?php echo $jmlLemburNonWorkDay2; ?></td>
		</tr>
		<?php
		$cntUser++;
	 }//tutup while user
	 ?>
</table>
</div>
<div style="clear:both;"></div>