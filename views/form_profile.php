<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/uploadify.css" />
<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/validation_engine.css" />
<script type="text/javascript" src="includes/JQuery/script/uploadify.swfobject.js"></script>
<script type="text/javascript" src="includes/JQuery/script/uploadify.v2.1.0.js"></script>
<script type="text/javascript" src="includes/JQuery/script/validation_engine-id.js"></script>
<script type="text/javascript" src="includes/JQuery/script/validation_engine.js"></script>
<script>
$(function(){
	$(".trPassword").hide();
	$("#uploadifyPhoto").hide();
	$("#uploadifyPhotoUploader").hide();
	
	$("#tblEdit").hover(
		  function () {
			$("#spanEdit").fadeIn("slow");
		  }, 
		  function () {
			$("#spanEdit").fadeOut("slow");
  });
  
  $("#spanEdit").toggle(
	  function () {
		$(".disabled").removeAttr("disabled");
		$(".disabled").removeClass("disabled");
		//$(".trPassword").css("display", "none");
		$(".trPassword").show();
		$("#uploadifyPhotoUploader").css("visibility", "visible");
		$("#oldpass").val('');
	  },
	  function () {
		$("form input, form textarea").addClass("disabled");
		$(".disabled").attr("disabled");
		$("#uploadifyPhotoUploader").css("visibility", "hidden");
		//$(".trPassword").css("display", "block");
		$(".trPassword").hide();
		var xpass = $("#xpass").val();
		$("#oldpass").val(xpass);
	  }
	);
	
	
    $("#uploadifyPhoto").uploadify({
        'uploader'       : 'includes/JQuery/images/uploadify/uploadify.swf',
        'script'         : 'includes/JQuery/script/uploadify.php',
		'cancelImg'      : 'includes/JQuery/images/uploadify/uploadify_cancel.png',
        'checkScript'    : 'includes/JQuery/script/uploadify.check.php',
		'folder'         : 'includes/img/photo',
        'sizeLimit'      : 2048576,
        'fileDesc'       : '*.jpg, *.png, *.gif',
        'fileExt'        : '*.jpg;*.png; *.gif',
        'buttonText'     : 'Unggah',
        'simUploadLimit' : 1,
        'onError'        : function(a, b, c, d){
                            if (d.status == 404)
                                alert("Could not find upload script.");
                            else if  (d.type === "HTTP")
                                alert("error " + d.type + ": "  + d.status);
                            else if  (d.type === "File Size")
                                alert(c.name + " " + d.type + " Limit: " + Math.round(d.info / (1024 * 1024)) + "MB");
                            else
                                alert("error " + d.type + ": "  + d.text);
                            },
        'onComplete'     : function(event, queueId, fileObj, response, data){
                            // document.formAddMember.submit();
                            $('#files img').attr({
                                'src'   : 'includes/img/photo/'+fileObj.name,
                                'title' : fileObj.name,
                                'id'    : 'fcover'
                            });
                            $('#files #fimage').attr('value',fileObj.name);
                            },
		'auto'           : true,
		'multi'          : false
	});
	
  	$("#frmEditProfile").validationEngine({
		inlineValidation: false,
		success :  function(){
			if($("#password").val()!=""){
				var oldpass = $("#oldpass").val();
				var newpass = $("#password").val();
					
				if(oldpass != newpass)
					$.validationEngine.buildPrompt("#frmEditProfile #password","* Kolom password tidak cocok","error");
			} 
		}
   });
   
});
</script>
<?php
	$data = $this->registry->mUser->select_user($_SESSION['userid']);
			foreach($data as $user){
				$userid	= $user->USER_ID;
				$password = $user->PASSWORD;
				$nama = $user->NAME;
				$email = $user->EMAIL;
				$alamat = $user->ALAMAT;
				$phone = $user->PHONE;
				$foto = $user->PHOTO;
				}
?>

<form action="index.php?mod=profile/updateProfile" method="post" style="padding:15px;" id="frmEditProfile">
  <table id="tblEdit">
    <tr valign="top">
      <td rowspan="8"><div id="fileQueue"></div>
        <div id="files">
          <input type="hidden" name="fimage" id="fimage" value="<?php echo ((!empty($foto))?$foto:'image.gif'); ?>"/>
          <img src="includes/img/photo/<?php echo ((!empty($foto))?$foto:'image.gif'); ?>" width="180" height="200"  id="fcover"/> </div>
        <input type="file" name="uploadifyPhoto" id="uploadifyPhoto" />
        <br /></td>
      <td><label>User Id</label></td>
      <td>:</td>
      <td width="300"><input type="hidden" value="<?php echo $userid; ?>" name="userid" />
        <?php echo $userid; ?></td>
      <td rowspan="8"><span style="display:none;" class="btn" id="spanEdit">Edit</span></td>
    </tr>
    <tr valign="top" class="">
      <td ><label>Password </label></td>
      <td>:</td>
      <td>
      <input type="hidden" id="xpass" value="<?php echo $password; ?>" />
      <input type="password" value="<?php echo $password; ?>" name="oldpass" id="oldpass" class="disabled" disabled="disabled" />
      </td>
	</tr>
    <tr class="vtip trPassword" title=" * Kosongkan password jika tidak ingin diubah ">
    	<td colspan="2"></td>
      <td><input type="password" name="password" id="password" class="disabled validate[optional,length[7,50]]" disabled="disabled" /></td>
    </tr>
    <tr valign="top">
      <td ><label>Nama </label></td>
      <td>:</td>
      <td><input type="text" value="<?php echo $nama; ?>" name="nama" id="nama" class="disabled validate[required,custom[onlyLetter],length[7,50]] text-input" disabled="disabled" /></td>
    </tr>
    <tr valign="top">
      <td ><label>Email </label></td>
      <td>:</td>
      <td><input type="text" value="<?php echo $email; ?>" name="email" id="email" class="disabled validate[optional,custom[email]] text-input" disabled="disabled" /></td>
    </tr>
    <tr valign="top">
      <td ><label>Telepon</label></td>
      <td>:</td>
      <td><input type="text" value="<?php echo $phone; ?>" name="phone" id="phone" class="disabled validate[optional,custom[telephone]] text-input" disabled="disabled" /></td>
    </tr>
    <tr valign="top">
      <td ><label>Alamat </label></td>
      <td>:</td>
      <td><textarea name="alamat" id="alamat" class="disabled validate[optional, length[10,50]] text-input" disabled="disabled"><?php echo $alamat; ?></textarea></td>
    </tr>
    <tr class="trPassword">
      <td  colspan="2"></td>
      <td><input type="submit" name="cmdEditProfile" id="cmdEditProfile" class="btn" value=" Simpan "/></td>
    </tr>
  </table>
</form>
