<div id="window_alertRecommendationReject" class="window" style="display:block">
<script>
// ---  utk  submit form ini liat di includes/js/createWindowNotif.js
</script>
<?php
 /*$this->registry->view->show("confirm_underConstruction");
echo 'Untuk Rekomendasi ulang, gunakan menu "Recommendation"';*/
if(isset($_POST['userid'])){
	$_POST['userid'] = isset($_POST['userid'])?$_POST['userid']:'';
	$_POST['calid'] = isset($_POST['calid'])?$_POST['calid']:'';
	$_POST['absentype'] = isset($_POST['absentype'])?$_POST['absentype']:'';
	$fullname = "";
	$id = "";
	$level = "";
	$tgl = "";
	$desc = "";
	$absen = "";
	$getData 		= $this->registry->mAbsenTemp->selectDB_absenTemp($_POST['userid'],"user_id", 2, $_POST['calid'], '', $_POST['absentype'], 'calendar_id');
	foreach($getData as $data){
		$tempid			= $data->TEMP_ID;
		$fullname 	= $this->registry->mUser->get_fullName($data->USER_ID); 
		$tgl		= $this->registry->mCalendar->select_calendarID("", "", "", $data->CALENDAR_ID, 1);
		$calid 		= $data->CALENDAR_ID;
		$desc		= $data->START_DESC;
		$absen		= $this->registry->mAbsenType->selectDB_typeAbsen($data->ABSENTYPE_ID);
		$absenid	= $data->ABSENTYPE_ID;
		$userRec	= $this->registry->mUser->get_fullName($data->USER_RECOMMENDATION); 
		$time		= $data->TIME1;
		$userReject = $data->USER_RECOMMENDATION;
	}
?><br />

  <form name="form_alertRecommendationReject" id="form_alertRecommendationReject">
  <div id="loadingRecommendation" align="left">  </div> 
  	<div id="status"></div>
    	<input type="hidden" name="tempid" id="tempid" value="<?php echo $tempid; ?>" />
    	<input type="hidden" name="userReject" id="userReject" value="<?php echo $userReject; ?>" />
       Rekomendasi absen <b><?php echo $absen; ?></b> anda telah ditolak oleh <b><?php echo $userRec; ?></b>. <br /><br />
       Rekomendasikan absen anda kepada pegawai lain? <br />
    <table>
      <tr>
      	<td valign="top"><label>Tanggal</label></td>
        <td valign="top">:</td>
        <td><?php echo $tgl.' - '.$time; ?>
        <input type="hidden" name="calid" id="calid" value="<?php echo $calid; ?>" />
        <input type="hidden" name="time1" id="time1" value="<?php echo $time; ?>" />
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
        <td><textarea name="tKet" cols="30" rows="3"></textarea></td> 
      </tr> 
      <tr>
      	<td valign="top"><label>Pegawai</label></td>
        <td valign="top">:</td>
        <td><?php
        	$this->registry->view->multiple = 1;
            $this->registry->view->submit = 0;
            $this->registry->view->show("combo_user"); 
        ?> 
        </td> 
      </tr> 
      <tr align="center">
        <td colspan="3"><input type="button" name="cmdRerecommend" id="cmdRerecommend" class="btn" value="Submit"/>&nbsp;
        <input type="button" name="cmdRerecommendcancel" id="cmdRerecommendcancel" class="btn" value="Cancel Recommendation"/></td>
      </tr>
        
      
    </table>
  </form> 
 <?php  } ?>
</div>
