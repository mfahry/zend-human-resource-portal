<script>
	$(function() {
	   function buildPrompt(element, message){
		   $.validationEngine.buildPrompt("#frmUnlock #"+element,"* "+message,"error");
		}
		
		$('#cmdUnlock').live("click",function() {   
			var boo = true; 
			var tPass =  $('#tPass').val();
			var tPassConfirm =  $('#tPassConfirm').val();
			
			if(tPass == ''){
				buildPrompt('tPass', 'Kolom ini harus diisi.');
				boo = boo && false;
			}
				
			if(tPassConfirm == ''){
				buildPrompt('tPassConfirm', 'Kolom ini harus diisi.');
				boo = boo && false;
			} 
			
			if(tPassConfirm != tPass){
				buildPrompt('tPassConfirm', 'Kolom password tidak cocok.');
				boo = boo && false;
			} 
			
			if(boo){
				//alert('boo');
				var submitData = $('#frmUnlock').serialize();
				$(this).attr('disabled','disabled');
				$(this).addClass('disabled');
				$.ajax({
					type: "POST",
					url: "index.php?mod=staffing/unlock",
					data: submitData,
					dataType: "html",
					success: function(msg){
						location.href="index.php?mod=staffing";	
					},
					error: function(XMLHttpRequest, textStatus, errorThrown){
						alert("error:" +XMLHttpRequest);	
						alert("error:" +textStatus);	
						alert("error:" +errorThrown);
					}
					
				}); 
			}
		});
	   
	});
    </script>

<div id='window_userAccess' class="window" style="display:none">
  <?php if(isset($_POST['userid']) && isset($_POST['winDesc']))	{ ?>
  <form method="post" name="frmUnlock" action="index.php?mod=staffing/saveUserLock" id="frmUnlock">
    <?php
	$datauserid = $this->registry->mUser->selectDB_userID($_POST['userid']);
	foreach($datauserid as $data){	
		$username 	= $data->USER_ID;
		$name 		= $data->NAME; 
		$lastLog	= $data->LAST_LOGIN;		
	}
	?>
    <input type="hidden" name="setWindowActive" value="<?php echo $_POST['winDesc']; ?>" />
    <input type="hidden" name="userid" value="<?php echo $username; ?>" />
    <table style="margin:10px;">
      <tr>
        <td><label> User ID</label></td>
        <td>:</td>
        <td><?php echo $username;?></td>
      </tr>
      <tr>
        <td><label> Nama </label></td>
        <td>:</td>
        <td><?php echo $name; ?></td>
      </tr>
      <tr>
        <td><label>Login Terakhir</label></td>
        <td>:</td>
        <td><?php echo $lastLog; ?></td>
      </tr>
      <tr>
        <td colspan="3" style="border-bottom:1px solid #000;"><b>Mohon masukkan password baru.</b></td>
      <tr>
        <td><label>Password</label></td>
        <td>:</td>
        <td><input name="tPass" type="password" id="tPass" class="validate[required]" /></td>
      </tr>
      <tr>
        <td><label>Konfirm Password</label></td>
        <td>:</td>
        <td><input name="tPassConfirm" type="password" id="tPassConfirm" class="validate[required,confirm[tPasswd]] text-input" /></td>
      </tr>
      <tr>
        <td align="center" colspan="3"><input type="button" name="cmdUnlock" id="cmdUnlock"  class="btn" value="Unlock"/></td>
      </tr>
    </table>
  </form>
  <?php } ?>
</div>
