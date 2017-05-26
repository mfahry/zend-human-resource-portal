
<div id="window_alertRecommendation" class="window" style="display:none">
bug fixing by ganteng.. test.. muncul !
  <script>
// ---  utk  submit form ini liat di includes/js/createWindowNotif.js
</script>
 <?php 
if(isset($_POST['userid'])){
	$_POST['userid'] = isset($_POST['userid'])?$_POST['userid']:$_SESSION['userid'];
	$_POST['calid'] = isset($_POST['calid'])?$_POST['calid']:'';
	$_POST['absentype'] = isset($_POST['absentype'])?$_POST['absentype']:'';
	
	$fullname = "";
	$id = "";
	$level = "";
	$tgl = "";
	$desc = "";
	$absen = "";
	$time1 = "";
	$getData 		= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],"user_recommendation", 0, $_POST['calid'],'no', $_POST['absentype'], 'calendar_id');
	foreach($getData as $data){
		$id			= $data->TEMP_ID;
		$fullname 	= $this->registry->mUser->selectDB_userLevel($data->USER_ID, "u.name"); 
		$tgl		= $this->registry->mCalendar->select_calendarID("", "", "", $data->CALENDAR_ID, 1);
		$desc		= $data->START_DESC;
		$absen		= $this->registry->mAbsenType->selectDB_typeAbsen($data->ABSENTYPE_ID);
		$time1		= $data->TIME1;
	}
?>

  <form name="form_alertRecommendation" id="form_alertRecommendation">
    <div id="loadingRecommendation" align="left"> </div>
  	<div id="status"></div>
    <input type="hidden" name="atID" value="<?php echo $id;?>" />
    <table>
      <tr>
        <td colspan="3"><label>Pegawai di bawah ini membutuhkan persetujuan absensi anda:</label></td>
      </tr>
      <tr> </tr>
      <tr>
        <td width="114"><label>Nama</label></td>
        <td width="8">:</td>
        <td width="234"><?php echo $fullname;?></td>
      </tr>
      <tr>
        <td><label>Tanggal/Jam</label></td>
        <td>:</td>
        <td><?php echo $tgl.' - '.$time1;?></td>
      </tr>
      <tr>
        <td><label>Absen</label></td>
        <td>:</td>
        <td><?php echo $absen;?></td>
      </tr>
      <tr>
        <td><label>Keterangan</label></td>
        <td>:</td>
        <td><p><?php echo $desc;?></p></td>
      </tr>
      <tr>
      <tr>
        <td><label>Aksi Anda</label></td>
        <td>:</td>
        <td><input type="radio" name="rConfirm" value="1"/>
          Terima
          <input type="radio" name="rConfirm" value="2"/>
          Tolak </td>
      </tr>
      <tr align="center">
        <td height="21" colspan="3"><input type="button" name="cmdConfirmGotRecommend" id="cmdConfirmGotRecommend" class="btn" value="Submit"  /></td>
      </tr>
        </tr>
      
    </table>
  </form>
<?php  } ?>
</div>
