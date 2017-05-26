<?php
require_once("../dbsconf/DbConnect.php"); 
global $CONN;

$userid = $_POST['userid'];
$periode = $_POST['periode'];
$gajibulanan = $_POST['gajibulanan'];
$potonganKoperasi = $_POST['potonganKoperasi'];
$potonganPajak = $_POST['potonganPajak'];
$SPJLokal1_val = $_POST['SPJLokal1_val'];
$SPJLokal2_val = $_POST['SPJLokal2_val'];
$feeMakan_val = $_POST['feeMakan_val'];
$lemburMlm_val = $_POST['lemburMlm_val'];
$lemburDayOff_val = $_POST['lemburDayOff_val'];
$puasa_val = $_POST['puasa_val'];
$sewaInfra = $_POST['sewaInfra'];
$rapat = $_POST['rapat'];
$pemantra = $_POST['pemantra'];
$thr = $_POST['thr'];
$iuranharitua = $_POST['iuranharitua'];

$SPJLokal1 = ($_POST['SPJLokal1'] * $SPJLokal1_val);
$SPJLokal2 = ($_POST['SPJLokal2'] * $SPJLokal2_val);
$feeMakan = ($_POST['feeMakan'] * $feeMakan_val);
$lemburMlm = ($_POST['lemburMlm'] * $lemburMlm_val);
$lemburDayOff = ($_POST['lemburDayOff'] * $lemburDayOff_val);
$puasa = ($_POST['puasa'] * $puasa_val);
  
$sql = "INSERT INTO gaji_dibayarkan VALUES 
		('','$userid','$periode','$gajibulanan','$SPJLokal1','$SPJLokal2',
		'$lemburDayOff','$lemburMlm','$thr','$potonganPajak','$potonganKoperasi',
		'$feeMakan','$pemantra','$puasa','$sewaInfra','$feeRapat',
		'$iuranharitua','0')";
$rs = $CONN->Execute($sql);

if($rs){
	echo "ok";
}else{
	$CONN->ErrorMsg();
}
?>