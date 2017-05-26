<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlWindows/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">

<script type="text/javascript" src="includes/dhtmlx/dhtmlxWindows/dhtmlxcommon.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxWindows/dhtmlxcontainer.js"></script>

<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">

<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxcommon.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgridcell.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_start.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_validation.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxdataprocessor.js"></script>


<?php 

	$userid = $_SESSION['userid'];
	if(isset($_POST['submitKeluar'])){
		if($_POST['cmbMonth']==1){
			$mm = 12;
		}else{
			$mm = $_POST['cmbMonth'] - 1;
		}
		$bln_1=$this->registry->mCalendar->monthname($_POST['cmbMonth']);
		$bln_2=$this->registry->mCalendar->monthname($mm);
		?>
		<div id="absen_header" style="display:none">
		<center>
		<table>
		<tr>
			<th style="font-size:8pt;" colspan="8" class="blackBold">Absen bulan <?php echo $bln_1." ".$_POST['cmbYear']; ?> <br />
			(tgl 26 <?php echo $bln_2; ?> s/d 25 <?php echo $bln_1; ?>)</th>
		</tr>
	
<?php
	}
	?>
		</table>
		</center>
		</div>


<center>
<table id="windowAbsenBulanan" style="display:none"> 
	<tr>
        <th width="100">No</th>
        <?php if($_SESSION['level_id'] != 3){ ?>
        <th width="100">Username</th>
        <?php } ?>
        <th width="100">Tanggal</th>
        <th width="100">Jam Keluar</th>
        <th width="100">Keterangan</th>
        <th width="100">Jam Kembali</th>
        <th width="100">Keterangan</th>
        <th width="100">Tipe Absen</th>
        </tr>
        <?php 
		if(isset($_POST['submitKeluar'])){
			$year= $_POST['cmbYear'];
			$month = $_POST['cmbMonth'];
			if($month==1){
				$pastmonth = 12;
			}else{
				$pastmonth = $month - 1;
			}
					
			$i 		   = 0;
			$getCalid = $this->registry->mCalendar->selectCalId("", 26, 31, $pastmonth, $year);
				
			foreach($getCalid as $data){
				$i++;
				$calid[$i] = $data->CALENDAR_ID;
			}
					
			$getCalid = $this->registry->mCalendar->selectCalId("", 1, 25, $month, $year);
				
			foreach($getCalid as $data){
				$i++;
				$calid[$i] = $data->CALENDAR_ID;
			}
			$j = 0;
			
			for($idx = 1; $idx <= $i; $idx++){
				if (isset($_POST['cmbAbsen']) != -1){
					if((isset($_POST['cmbAbsen']) != 5)&&(isset($_POST['cmbAbsenLokal']))){				
						$query = $this->registry->mAbsensiHarian->select_reportBulananOut($calid[$idx], $userid, $_POST['cmbAbsen']);
					}else{
						$query 	= $this->registry->mAbsensiHarian->select_reportBulananOut($calid[$idx], $userid, $_POST['cmbAbsen']);
					}
				}else{
						$query 	= $this->registry->mAbsensiHarian->select_reportBulananOut($calid[$idx], $userid);
				}  
				
				foreach($query as $data){	
					$j++;
					$selang	= $j%2;
					$tgl = $this->registry->mCalendar->select_calendarID("", "", "", $data->CALENDAR_ID, 1);
					$dtm = $data->CALENDAR_ID;
				?>
					<tr height="16" bgcolor="<?php if ($selang==0){ echo "#CEEFFF" ;} else {echo "#ECF7FF" ;}?>" align="center" valign="top">
						<td><?php echo $j;  ?></td>
						<?php if($_SESSION['level_id'] != 3){ ?>
						<td><?php echo $data->USER_ID;  ?></td>
						<?php } ?>
						<td><?php echo $tgl; ?></td>
						<td><?php echo $data->OUT_TIMESTART;  ?></td>
						<td><?php echo $data->OUT_DESCSTART;  ?></td>
						<td><?php echo $data->OUT_TIMEEND;  ?></td>
						<td><?php echo $data->OUT_DESCEND;  ?></td>
						<td><?php echo ucwords($data->TYPE_NAME);  ?></td>
					</tr>
<?php 	
				}#tutup foreach
			}#tutup for
		}#tutup if
?>
</table>
</center>





