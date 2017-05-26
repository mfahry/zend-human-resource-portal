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

if($month==1){
	$pastmonth = 12;
}else{
	$pastmonth = $month - 1;
}

//dapetin nama username
$fullname = $this->registry->mUser->selectDB_user();
//while($data = $fullname->FetchNextObject()){  
foreach($fullname as $data){
	 $fullNM=$data->NAME;
	 $userid=$data->USER_ID;
?>
<table width="100%">
    <tr>
        <td colspan="14"></td>
    </tr>
    <tr>
        <td colspan="14" bgcolor="#000000" height="10"></td>
    </tr>
    <tr>
        <td colspan="7"><font size="+3">Absensi Detail</font></td>
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
    <tr bgcolor="#CC99FF" align="center" height="23" valign="middle">
      <th >Username</th>
        <th >Tanggal</th>
        <th bgcolor="#FFFF99">Jam Masuk</th>
        <th bgcolor="#FFFF99">Keterangan</th>
        <th bgcolor="#FFFF99">Jam Pulang</th>
        <th bgcolor="#FFFF99">Keterangan</th>
        <th bgcolor="#FFFF99">Work Summary</th>
        <th bgcolor="#99CCFF">Jam Keluar Kantor</th>
        <th bgcolor="#99CCFF">Keterangan</th>
        <th bgcolor="#99CCFF">Jam Kembali</th>
        <th bgcolor="#99CCFF">Keterangan</th>
        <th bgcolor="#99CCFF">Work Summary</th>
        <th bgcolor="#99CCFF">Tipe Absen</th>
    </tr>
<?php
	$i=0;
	$getCalid = $this->registry->mCalendar->selectCalId("", 26, 31, $pastmonth, $year);
	//while($data = $getCalid->FetchNextObject()){
	foreach($getCalid as $data){
		$i++;
		$calid[$i] = $data->CALENDAR_ID;
	}
	$getCalid = $this->registry->mCalendar->selectCalId("", 1, 25, $month, $year);
	//while($data = $getCalid->FetchNextObject()){
	foreach($getCalid as $data)	{
		$i++;
		$calid[$i] = $data->CALENDAR_ID;
	}
	for($idx = 1; $idx <= $i; $idx++){
		$reportAll 	= $this->registry->mAbsensiHarian->select_AllReportDetail($calid[$idx], $userid);
		//if($reportAll == NULL){
			
			foreach($reportAll as $data){
				$tgl = $this->registry->mCalendar->select_calendarID("", "", "", $data->CALENDAR_ID, 1);
?>
				<tr height="22" align="center" valign="top">
					<td align="center"><?php echo $data->USER_ID;  ?></td>
					<td align="center"><?php echo $tgl; ?></td>
					<td align="center"><?php echo $data->START_TIME;  ?></td>
					<td align="left"><?php echo $data->START_DESC;  ?></td>
					<td align="center"><?php echo $data->OUT_TIME;  ?></td>
					<td align="left"><?php echo $data->OUT_DESC;  ?></td>
					<td align="left"><?php echo $data->WS_HARIAN;  ?></td>
					<td align="center"><?php echo $data->OUT_TIMESTART;  ?></td>
					<td align="left"><?php echo $data->OUT_DESCSTART;  ?></td>
					<td align="center"><?php echo $data->OUT_TIMEEND;  ?></td>
					<td align="left"><?php echo $data->OUT_DESCEND;  ?></td>
					<td align="left"><?php echo $data->WS_OUT;  ?></td>
					<td align="center"><?php echo ucwords($data->TYPE_NAME);  ?></td>
			  </tr>	
<?php 
			} // tutup while absen harian
		//}
	} //tutup For
?>
</table>
<?php 
} //tutup while user
?>