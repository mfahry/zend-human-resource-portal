<?php 
include("dbsconf/adodb5/adodb.inc.php");

global $CONN;

$CONN = ADONewConnection('mysql');    # create a connection 
$CONN->PConnect('localhost','root','4dm1ns3rv3r','portalnw_db');

$tahun = '2012';

echo "Generate Calendar ".$tahun." <br>";

$CONN->debug = true;

$query = "SELECT MAX(calendar_id) AS maxcalid
          FROM calendar ";
		  
$rs = $CONN->Execute($query);


while($data = $rs->FetchNextObject())
{

	$query2 = "SELECT * FROM calendar WHERE calendar_id = ".$data->MAXCALID." ";
		  
	$rs2 = $CONN->Execute($query2);	

}	
$tgl = 0;
for($i = 1; $i<=12; $i++){
	if ($i == 2){

		$jmlhari = 29;
	}else{
		if (($i == 1) || ($i == 3) || ($i == 5) || ($i == 7) ||
			($i == 8) || ($i == 10) || ($i == 12)){

			$jmlhari = 31;
		}else{
			$jmlhari = 30;
		}  
		
	}
	
	for($j = 1; $j<= $jmlhari; $j++){
		
		

		if (($tgl == 0) || ($tgl == 6))
			$status = 0;
		else 
			$status = 1;
	
		$query2 = "INSERT calendar(date, month, year, day_id, status)
			VALUES (".$j.", ".$i.", '".$tahun."', $tgl, $status) ";

		if ($tgl == 6)
			$tgl = 0;
		else
			$tgl = $tgl + 1;
		
		echo $query2."<br>";  
		$rs2 = $CONN->Execute($query2);	

		
	}

}	

echo "end of file <br>";



			   
?>