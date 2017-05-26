<div id="window_alertRecommendationAprove" class="window" style="display:none">
<script> 
// ---  utk  submit form ini liat di includes/js/createWindowNotif.js
</script>
<?php   
if(isset($_POST['userid'])){
echo "test : ".$_POST['userid'];
$_POST['userid'] = isset($_POST['userid'])?$_POST['userid']:'';
$_POST['calid'] = isset($_POST['calid'])?$_POST['calid']:'';
$_POST['absentype'] = isset($_POST['absentype'])?$_POST['absentype']:'';

$getData 		= $this->registry->mAbsenTemp->selectDB_absenTemp($_POST['userid'],'user_id',1, $_POST['calid'],'no', $_POST['absentype'], 'calendar_id');
foreach($getData as $data){
	$tempid		= $data->TEMP_ID;
	$userid		= $data->USER_ID;
	$fullname 	= $this->registry->mUser->get_fullName($data->USER_ID); 
	$tgl		= $this->registry->mCalendar->select_calendarID("", "", "", $data->CALENDAR_ID, 1);
	$calid 		= $data->CALENDAR_ID;
	$desc		= $data->START_DESC;
	$absen		= $this->registry->mAbsenType->selectDB_typeAbsen($data->ABSENTYPE_ID);
	$absenid	= $data->ABSENTYPE_ID; 
	$time1		= $data->TIME1;
}
?>
  <form name="form_alertRecommendationAprove" id="form_alertRecommendationAprove">
  	<div id="loadingRecommendation" align="left">  </div> 
  	<div id="status"></div>
    	<input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>" />
    	<input type="hidden" name="tempid" id="tempid" value="<?php echo $tempid; ?>" />
       Rekomendasi absen <b><?php echo $absen; ?></b> anda telah disetujui :
 		<br /><br /> 
    <table>
      <tr>
      	<td valign="top"><label>Tanggal/Jam</label></td>
        <td valign="top">:</td>
        <td><?php echo $tgl.' - '.$time1; ?>
        <input type="hidden" name="calid" id="calid" value="<?php echo $calid; ?>" />
        <input type="hidden" name="time1" id="time1" value="<?php echo $time1; ?>" />
        </td> 
      </tr>
      <tr>
      	<td valign="top"><label>Jenis Absen</label></td>
        <td valign="top">:</td>
        <td><?php echo $absen; ?><input type="hidden" name="rbAbsen" id="rbAbsen" value="<?php echo $absenid; ?>" /></td> 
      </tr>
      <tr>
      	<td valign="top"><label>Keterangan</label></td>
        <td valign="top">:</td>
        <td> <?php echo $desc; ?> <input type="hidden" name="desc" id="desc" value="<?php echo $desc; ?>" /></td> 
      </tr>  
    </table><br />

   <label> Oleh:</label>
    <table border="1" cellpadding="1">
    	<thead>
    	<tr>
        	<td width="30">#</td>
            <td width="200">Nama</td>
            <td width="60">Tanggal</td>
        </tr>
        </thead>
        <?php
		$getData 		= $this->registry->mAbsenTemp->selectDB_absenTemp($_POST['userid'],'user_id',1, $_POST['calid'],'no', $_POST['absentype']);
		$i = 1;
		foreach($getData as $data){
		?>
        <tr valign="top">
        	<td><?php echo $i++;?></td>
            <td><?php echo $data->USER_RECOMMENDATION.'<br>'.$this->registry->mUser->get_fullName($data->USER_RECOMMENDATION);?></td>
            <td><?php echo $data->DTM_APPROVED;?></td>
        </tr>
        <?php
		}
		?>
      </table><br />

       <input type="butoon" name="cmdConfirm" id="cmdConfirm" class="btn" value="Update Absen"  />
  </form> 
  <?php  }//else echo 'Gagal menjalankan proses, mohon hubungi administrator'; ?>
</div>
