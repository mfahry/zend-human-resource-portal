<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=AbsensiRekapTask.xls");
require_once("dbsconf/DbConnect.php"); 
global $CONN;

//-----setting rekap task 20111118
$project= $_GET['project'];
$userid	= $_GET['member'];
$year	= $_GET['year'];
$month	= $_GET['month'];
//echo $member;
?>

<html>
<head>
<title>
	Portal Neuronworks - rekap task
</title>
</head>
<!--<link href="include/css/style.css" rel="stylesheet" type="text/css" />-->
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td>
		RekapTask
		</td>
	</tr>
	
	<tr>
		<td>
            <table border="1px" cellpadding="3" align="center" cellspacing="1" width="95%">
                <tr>
                    <td width="10">&nbsp;</td>
                    <td>Nama</td>            
                    <td width="90">Prioritas</td>           
                    <td width="400">Task</td>
                    <td width="50">Status (%)</td>
                    <td width="50">Prioritas</td> 
                    
                </tr>
			 
			 <?php
				
			//---------------- hitung absen masuk, sakit, ijin, bolos---------------------------------------
			//----------------------------------------------------------------------------------------------
			
					$query = "SELECT DISTINCT(t.task), u.user_id, u.photo, MIN(ts.update_dtm) AS initial_dtm, ts.status, t.task_id,t.priority_id, u.name
						FROM task t JOIN user u ON t.user_id=u.user_id
						JOIN task_status ts ON ts.task_id = t.task_id ";
					 	
					/*if($userid != -1 && $project != -1){
						$query .= " WHERE t.user_id = '".$userid."'  
									AND MONTH(ts.update_dtm) = '".$month."' 
									AND YEAR(ts.update_dtm) = '".$year."'
									AND t.task LIKE '%[".$project."]%'";
					}elseif($userid != -1 && $project == -1){
						$query .= " WHERE t.user_id = '".$userid."'  
									AND MONTH(ts.update_dtm) = '".$month."' 
									AND YEAR(ts.update_dtm) = '".$year."'";				
					}elseif($userid == -1 && $project != -1){
						$query .= " AND MONTH(ts.update_dtm) = '".$month."' 
									AND YEAR(ts.update_dtm) = '".$year."'
									AND t.task LIKE '%[".$project."]%'";
					}elseif($userid == -1 && $project == -1){
						$query .= " AND MONTH(ts.update_dtm) = '".$month."' 
									AND YEAR(ts.update_dtm) = '".$year."'";
					}*/
					        if($userid != NULL && $userid != '-1' && $month != NULL && $year != NULL && $project!=-1){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'";
		}elseif($userid != NULL && $userid != '-1' && $month != NULL && $year != NULL && $project==-1){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'";	
		
		}elseif($userid != NULL && $userid != '-1' && $month == NULL && $year != NULL && $project!=-1){
			$query .= " WHERE t.user_id = '".$userid."'   
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'";
		}elseif($userid != NULL && $userid != '-1' && $month == NULL && $year != NULL && $project==-1){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND YEAR(ts.update_dtm) = '".$year."'";
		}elseif($userid != NULL && $userid != '-1' && $month != NULL && $year == NULL && $project!=-1){
			$query .= " WHERE t.user_id = '".$userid."'   
						AND MONTH(ts.update_dtm) = '".$month."'
						AND t.task LIKE '%[".$project."]%'";
		}elseif($userid != NULL && $userid != '-1' && $month != NULL && $year == NULL && $project==-1){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND MONTH(ts.update_dtm) = '".$month."'";	
									
		}elseif($userid != NULL && $userid == '-1' && $month != NULL && $year != NULL && $project!=-1){
			$query .= " AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'";
		}elseif($userid != NULL && $userid == '-1' && $month != NULL && $year != NULL && $project==-1){
			$query .= " AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'";
		
		}elseif($userid != NULL && $userid == '-1' && $month == NULL && $year != NULL && $project!=-1){
			$query .= " WHERE YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'";
		}elseif($userid != NULL && $userid == '-1' && $month == NULL && $year != NULL && $project==-1){
			$query .= " WHERE YEAR(ts.update_dtm) = '".$year."'";				
		}elseif($userid != NULL && $userid == '-1' && $month != NULL && $year == NULL && $project!=-1){
			$query .= " WHERE MONTH(ts.update_dtm) = '".$month."'
						AND t.task LIKE '%[".$project."]%'";
		}elseif($userid != NULL && $userid == '-1' && $month != NULL && $year == NULL && $project==-1){
			$query .= " WHERE MONTH(ts.update_dtm) = '".$month."'";
						
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $month != NULL && $year != NULL && $project!=-1){
			$query .= " WHERE t.user_id = '".$_SESSION['userid']."'  
						AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'";
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $month != NULL && $year != NULL && $project==-1){
			$query .= " WHERE t.user_id = '".$_SESSION['userid']."' 
						AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'";
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $month == NULL && $year == NULL && $project!=-1){
			$query .= " WHERE t.user_id = '".$_SESSION['userid']."'
						AND t.task LIKE '%[".$project."]%'";
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $month == NULL && $year == NULL && $project==-1){
			$query .= " WHERE t.user_id = '".$_SESSION['userid']."'";
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $month != NULL && $year == NULL && $project!=-1){
			$query .= " WHERE t.user_id = '".$_SESSION['userid']."'
						AND MONTH(ts.update_dtm) = '".$month."'
						AND t.task LIKE '%[".$project."]%'";
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $month != NULL && $year == NULL && $project==-1){
			$query .= " WHERE t.user_id = '".$_SESSION['userid']."'
						AND MONTH(ts.update_dtm) = '".$month."'";
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $month == NULL && $year != NULL && $project!=-1){
			$query .= " WHERE t.user_id = '".$_SESSION['userid']."'
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'";
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $month == NULL && $year != NULL && $project==-1){
			$query .= " WHERE t.user_id = '".$_SESSION['userid']."'
						AND YEAR(ts.update_dtm) = '".$year."'";					
		}elseif($userid == NULL && $_SESSION['position_id'] == 1 && $month != NULL && $year != NULL && $project==-1){
			$query .= " WHERE MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'";
						
		}
					$query .= " GROUP BY ts.task_id ORDER BY ts.task_id,ts.update_dtm DESC";
					//echo $query;
					$datatask   = $CONN->Execute($query);
					
					$i=0;
					while($data = $datatask->FetchNextObject()){
							
					//foreach($datatask as $data){				
					
			//----------------------------------------------------------------------------------------------
			
				?>
				<tr>
					<td align="center">&nbsp;</td>
					<td align="left"><?php echo ucwords(strtolower($data->NAME)); ?></td>
					<td align="right"><?php echo $data->PRIORITY_ID; ?>&nbsp;&nbsp;</td>
					<td align="right"><?php echo $data->TASK; ?>&nbsp;&nbsp;</td>
					<td align="right"><?php echo $data->STATUS; ?>&nbsp;&nbsp;</td>
					<td align="right"><?php echo $data->PRIORITY_ID; ?>&nbsp;&nbsp;</td>
					
				</tr>
				<?php
			 	}//tutup while user
			 ?>
			 </table>
		</td>
	</tr>
</table>
</html>
