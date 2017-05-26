<div id="window_userDetail" class="window" >
  <?php
if(isset($_POST['userid'])){
	$datauserid = $this->registry->mUser->selectDB_userID($_POST['userid']);
	foreach($datauserid as $data){
		$userid 	= $data->USER_ID;
		$nama 		= $data->NAME;
		$email 		= $data->EMAIL;
		$hire_dtm	= $data->HIRE_DATE;
		$addr 		= $data->ALAMAT;
		$phone 		= $data->PHONE; 
		$foto = $data->PHOTO;		
		 
	}
?>
  <table>
    <tr valign="top">
      <td rowspan="8">
        <img src="includes/img/photo/<?php echo ((!empty($foto))?$foto:'image.gif'); ?>" width="180" height="180"  id="fcover"/></td>
      <td><label>User ID</label></td>
      <td>:</td>
      <td><?php echo $userid; ?></td>
    </tr>
    <tr valign="top">
      <td ><label>Nama </label></td>
      <td>:</td>
      <td><?php echo $nama; ?></td>
    </tr>
    <tr valign="top">
      <td ><label>Email </label></td>
      <td>:</td>
      <td><?php echo $email; ?></td>
    </tr>
    <tr valign="top">
      <td >Tanggal Masuk</td>
      <td>:</td>
      <td><?php echo $hire_dtm; ?></td>
    </tr>
    <tr valign="top">
      <td ><label>Telepon</label></td>
      <td>:</td>
      <td><?php echo $phone; ?></td>
    </tr>
    <tr valign="top">
      <td ><label>Alamat </label></td>
      <td>:</td>
      <td><?php echo $addr; ?></td>
    </tr>
  </table>
  <?php } ?>
</div>
