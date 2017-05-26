<div id="window_recommendationDetail" class="window" style="display:none" > 
<?php   
if(isset($_POST['userid'])){
	$url = explode('/',$_GET['mod']);
	$detailRec = $this->registry->mAbsenTemp->selectDB_absenTemp($_POST['userid'],"user_id", NULL, $_POST['calid'],'', $_POST['absentype'], 'calendar_id');
 foreach($detailRec as $data){ 
	$fullname 	= $this->registry->mUser->get_fullName($data->USER_ID); 
	$tgl		= $this->registry->mCalendar->get_fullDate($data->CALENDAR_ID); 
	$desc		= $data->START_DESC;
	$absen		= $this->registry->mAbsenType->selectDB_typeAbsen($data->ABSENTYPE_ID); 
	$time1		= $data->TIME1;
}

	echo $_POST['userid'],"user_id", NULL, $_POST['calid'],'', $_POST['absentype'], 'calendar_id';
?>  
    <table>
      <tr>
      	<td valign="top"><b>Nama</b></td>
        <td valign="top">:</td>
        <td><?php echo $fullname; ?></td> 
      </tr>
      <tr>
      	<td valign="top"><b>Tanggal/Jam</b></td>
        <td valign="top">:</td>
        <td><?php echo $tgl.' - '.$time1; ?></td> 
      </tr>
      <tr>
      	<td valign="top"><b>Jenis Absen</b></td>
        <td valign="top">:</td>
        <td><?php echo $absen; ?></td> 
      </tr>
      <tr>
      	<td valign="top"><b>Keterangan</b></td>
        <td valign="top">:</td>
        <td> <?php echo $desc; ?> </td> 
      </tr>  
    </table><br />

   <b> Rekomendasi kepada:</b>
    <table border="1" cellpadding="1">
    	<thead>
    	<tr>
        	<td width="30">#</td>
            <td width="200">Nama</td>
            <td width="60">Tgl Approve</td>
        </tr>
        </thead>
        <?php
		$getData 		= $this->registry->mAbsenTemp->selectDB_absenTemp($_POST['userid'],'user_id',NULL, $_POST['calid'],'', $_POST['absentype']);
		$i = 1;
		foreach($getData as $data){
		?>
        <tr valign="top">
        	<td><?php echo $i++;?></td>
            <td><?php echo $data->USER_RECOMMENDATION.'<br>'.$this->registry->mUser->get_fullName($data->USER_RECOMMENDATION);?></td>
            <td><?php 
				if($data->STATUS==1)
					echo $data->DTM_APPROVED;
				elseif($data->STATUS==0 || $data->STATUS==2)
					echo '<b style="color:red;">Need Approval</b>';
				elseif($data->STATUS==3)
					echo '<b style="color:red;">Rejected</b>';?></td>
        </tr>
        <?php
		}
		?>
      </table> 
  <?php }//else echo 'Gagal menjalankan proses, mohon hubungi administrator'; ?>
</div>
