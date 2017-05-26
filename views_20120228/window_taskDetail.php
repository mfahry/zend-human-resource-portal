<?php
ob_start();
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include_once "../dbsconf/adodb5/adodb.inc.php";
include_once "../model/mTask.php";
include_once "../model/mUser.php";
include_once "../config/registry.cfg.php";
global $db;

$registry = new registry;
$registry->db = ADONewConnection('mysql');

$registry->mTask = new mTask($registry);
$registry->mUser = new mUser($registry);
//$registry->db->PConnect('localhost','root','','portalnw_db');
$registry->db->PConnect('localhost','root','4dm1ns3rv3r','portalnw_db');
?>
<style>
#tblTask{
	border: 1px solid #ccc;
	border-collapse: collapse;
}
#tblTask td{
	border: 1px solid #ccc;
	border-collapse: collapse;
	padding: 3px 5px;
}
#tblTask thead tr td{
	font-size:14px;
	font-weight: bold;
	background: url('./includes/JQuery/ui/css/blitzer/images/ui-bg_highlight-soft_15_cc0000_1x100.png');
	color: #fff;
}
</style>
<div>
<?php 
if(isset($_POST['userid'])){
	$datauser	= $registry->mTask->selectDB_task($_POST['userid'], '', '', '', $_POST['taskid']);
	foreach($datauser as $data){
		$name		= $data->NAME;
		$task		= $data->TASK;
		$userid		= $data->USER_ID;
		$taskid 	= $data->TASK_ID;
	} 
?>
	<table style="background:#fff;padding: 3px 5px;" cellpadding="2" cellspacing="2">
		<tr>
			<td valign="top"><b>Nama</b></td>
			<td valign="top">:</td>
			<td><?php echo $registry->mUser->get_fullName($data->USER_ID);?></td> 
		</tr>
		<tr>
			<td valign="top"><b>Task</b></td>
			<td valign="top">:</td>
			<td><?php echo $task; ?></td> 
		</tr>  
    </table><br />

   <b> Detail:</b>
   
    <table id="tblTask" cellpadding="2" cellspacing="2" style="background:#fff;">
    	<thead>
    	<tr>
        	<td width="30" align="center">#</td>
            <td width="80" align="center">Status (%)</td>
            <td width="150" align="center">Tanggal</td>
        </tr>
        </thead>
        <?php
		$getData = $registry->mTask->selectDB_task($userid, '', '', '', $taskid);
		$i = 1;
		foreach($getData as $data){
		?>
        <tr valign="top">
        	<td align="right"><?php echo $i++;?></td>
            <td><?php echo $data->STATUS;?></td>
            <td><?php echo $data->UPDATE_DTM;?></td>
        </tr>
        <?php
		}
		?>
      </table>
<?php 
}
?>   
</div>