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
<div id="window_taskDetail" class="window" style="background:#fff;">
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
	<table>
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
   
    <table border="1" cellpadding="1">
    	<thead>
    	<tr>
        	<td width="30">#</td>
            <td width="80">Status (%)</td>
            <td width="150">Tanggal</td>
        </tr>
        </thead>
        <?php
		$getData = $registry->mTask->selectDB_task($userid, '', '', '', $taskid);
		$i = 1;
		foreach($getData as $data){
		?>
        <tr valign="top">
        	<td><?php echo $i++;?></td>
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