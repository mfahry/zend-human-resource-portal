<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"AbsensiHarian.xls\"");
/*global $CONN;

require_once("../dbsconf/DbConnect.php"); 
require_once("../classes/CAbsensi.php");

$ins_CAbsensi = new CAbsensi($CONN);

$userid		= $_GET['id'];		
$month 		= $_GET['mon'];
$year 		= $_GET['yr'];
*/
$monthNM=$this->registry->mCalendar->monthname($month);

//dapetin nama username
$fullname = $this->registry->mUser->selectDB_user($userid);
foreach($fullname as $data){
	$fullNM=$data->NAME;
}

?>
<table width="100%">
    <tr>
        <td colspan="7"><font size="+3">Absensi Keluar</font></td>
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
    <tr bgcolor="#CCCCCC" align="center" height="23" valign="middle">
        <th width="3%">No</th>
        <th >Username</th>
        <th >Tanggal</th>
        <th >Jam Keluar</th>
        <th >Keterangan</th>
        <th >Jam Kembali</th>
        <th >Keterangan</th>
        <th >Tipe Absen</th>
    </tr>
<?php 
	if($month==1){
		$pastmonth = 12;
	}else{
		$pastmonth = $month - 1;
	}
	
	$i 		   = 0;
	
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
		if ($tipeAbsen != '-1'){
			$query 	= $this->registry->mAbsensiHarian->select_reportBulananOut($calid[$idx], $userid, $tipeAbsen);
		}else{
			$query 	= $this->registry->mAbsensiHarian->select_reportBulananOut($calid[$idx], $userid);
		}
		//while($data = $query->FetchNextObject()){  
		foreach($query as $data){	
			$j++;
			$selang	= $j%2;
			$tgl = $this->registry->mCalendar->select_calendarID("", "", "", $data->CALENDAR_ID, 1);
			$dtm = $data->CALENDAR_ID;
?>
    <tr height="20" align="center" valign="top">
        <td align="center"><?php echo $j;  ?></td>
        <td align="center"><?php echo $data->USER_ID;  ?></td>
        <td align="center"><?php echo $tgl; ?></td>
        <td align="center"><?php echo $data->OUT_TIMESTART;  ?></td>
        <td align="left"><?php echo $data->OUT_DESCSTART;  ?></td>
        <td align="center"><?php echo $data->OUT_TIMEEND;  ?></td>
        <td align="left"><?php echo $data->OUT_DESCEND;  ?></td>
        <td align="center"><?php echo ucwords($data->TYPE_NAME);  ?></td>
    </tr>	
<?php 					}//tutup while
	} //tutup FOR
?>
</table>