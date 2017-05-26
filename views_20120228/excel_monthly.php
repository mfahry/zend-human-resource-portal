<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"AbsensiHarian.xls\"");
/*
global $CONN;

require_once("../dbsconf/DbConnect.php"); 
require_once("../classes/CAbsensi.php");

$ins_CAbsensi = new CAbsensi($CONN);
*/

//$userid		= $_GET['id'];		
//$month 		= $_GET['mon'];
//$year 		= $_GET['yr'];
$monthNM=$this->registry->mCalendar->monthname($month);

//dapetin nama username
$fullname = $this->registry->mUser->selectDB_user($userid);
/*while($data = $fullname->FetchNextObject()){  
	 $fullNM=$data->NAME;
}*/

foreach($fullname as $data){
	$fullNM=$data->NAME;
}

?>
<table width="100%">
    <tr>
        <td colspan="7"><font size="+3">Absensi Harian</font></td>
    </tr>
    <tr>
        <td colspan="2">Nama</th>
        <td width="4%">:</td>
        <td width="85%" colspan="3"><?php echo ucwords($fullNM); ?></td>
    </tr>
    <tr>
        <td colspan="2">Bulan</th>
        <td>: </td>
        <td colspan="3"><?php echo $monthNM." ".$year; ?></td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
</table>

<table width="100%" border="1">
    <tr bgcolor="#CCCCCC" align="center" height="23">
        <td width="3%">No</td>
        <td>Tanggal</td>
        <td>Jam Masuk</td>
        <td>Keterangan</td>
        <td>Jam Pulang</td>
        <td>Keterangan</td>
    </tr>
<?php
if ($month  == 1){
	$pastmonth 	= 12;
}else{
	$pastmonth 	= $month - 1;
}
$i 		   	= 0;

$getCalid = $this->registry->mCalendar->selectCalId("", 26, 31, $pastmonth, $year);

foreach($getCalid as $data){
	$calid[$i] = $data->CALENDAR_ID;
	$i++;
}

$getCalid = $this->registry->mCalendar->selectCalId("", 1, 25, $month, $year);
foreach($getCalid as $data){
	$calid[$i] = $data->CALENDAR_ID;
	$i++;
}

$j = 0;
for($idx = 0; $idx < $i; $idx++){
	$query 	= $this->registry->mAbsensiHarian->select_reportBulanan($calid[$idx], $userid);  
	foreach($query as $data){	
		$j++;
		$tgl = $this->registry->mCalendar->select_calendarID("", "", "", $data->CALENDAR_ID, 1);
		$dtm = $data->CALENDAR_ID;
?>
    <tr height="20" align="center">
        <td align="center"><?php echo $j;  ?></td>
        <td align="center"><?php echo $tgl; ?></td>
        <td align="center"><?php echo $data->START_TIME;  ?></td>
        <td align="center"><?php echo $data->START_DESC;  ?></td>
        <td align="center"><?php echo $data->OUT_TIME;  ?></td>
        <td align="center"><?php echo $data->OUT_DESC;  ?></td>
    </tr>		
<?php }
} 
?>
</table>
<table>
    <tr>
        <td colspan="4"></td>
    </tr>
<?php
$getType 	= $this->registry->mAbsenType->selectDB_typeAbsen();
foreach($getType as $tipe){	
	$jml = $this->registry->mAbsenOut->selectDB_outOffice($userid, $tipe->TYPE_ID, "","", 1);
?>
    <tr height="20">
    	<td>&nbsp;</td>
        <td><?php echo $tipe->TYPE_NAME;?></td>
        <td>:</td>
        <td align="left"><?php echo $jml; ?></td>
    </tr>
<?php
}
?>
</table>