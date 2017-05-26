 
  <script>
	$(function() { 
	   
	   function buildPrompt(element, message){
		   $.validationEngine.buildPrompt("#form_useredit #"+element,"* "+message,"error");
		}
		
		$('.formError').live("click",function() { 
			$(this).hide();
		});
		
		$('#cmdEditUser').live("click",function() { 
			var boo = true; 
			var tUser_id =  $('#tUser_id').val();
			var leveluser_id =  $('#leveluser_id').val();
			var tName =  $('#tName').val();
			var tEmail =  $('#tEmail').val();
			var tHire =  $('#tHire').val();
			var tPhone =  $('#tPhone').val();
			var regmail = /^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/;
			var regdate = /^\d\d\d\d\-\d\d-\d\d$/;
			var regphone = /^[0-9\-\(\)\ ]+$/;
			var reg1 = new RegExp(regmail);
			var reg2 = new RegExp(regdate);
			var reg3 = new RegExp(regphone);
		 
			if(tUser_id == ''){
				buildPrompt('tUser_id', 'Kolom ini harus diisi.');
				boo = boo && false;
			}
				
			if(leveluser_id == ''){
				buildPrompt('leveluser_id', 'Kolom ini harus diisi.');
				boo = boo && false;
			} 
			
			if(tName == ''){
				buildPrompt('tName', 'Kolom ini harus diisi.');
				boo = boo && false;
			} 
			 
			if(tEmail != '' && reg1.test(tEmail) == false){
				buildPrompt('tEmail', 'Alamat email tidak valid.');
				boo = boo && false;
			} 
		
			if(tHire != '' && reg2.test(tHire) == false){
				buildPrompt('tHire', 'Format tanggal YYYY-MM-DD.');
				boo = boo && false;
			} 
			
			if(tPhone != '' && reg3.test(tPhone) == false){
				buildPrompt('tPhone', 'Format telepon tidak valid.');
				boo = boo && false;
			} 
			
			if(boo){
				//alert('boo');
				var submitData = $('#form_useredit').serialize();
				$(this).attr('disabled','disabled');
				$(this).addClass('disabled');
				$.ajax({
					type: "POST",
					url: "index.php?mod=staffing/saveUser",
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
<div id='window_user' class="window" style="display:none">
  <?php if(isset($_POST['userid']) && isset($_POST['winDesc']))	{ 
  
	if($_POST['winDesc'] == 'edit'){
		$datauserid = $this->registry->mUser->selectDB_userID($_POST['userid']);
		foreach($datauserid as $data){
			$userid 	= $data->USER_ID;
			$nama 		= $data->NAME;
			$email 		= $data->EMAIL;
			$hire_dtm	= $data->HIRE_DATE;
			$addr 		= $data->ALAMAT;
			$phone 		= $data->PHONE; 
			$level		= $data->LEVEL_ID;
			$status		= $data->HRDSTATUS;	
			$foto = $data->PHOTO;	 
		}
	} 
?>
  <!-- FORM Edit User-->
  <form id='form_useredit' method="post" name="form_useredit">
    <table>
      <tr>
        <td><label>User Id</label></td>
        <td>:</td>
        <td><input name="tUser_id" type="text" id="tUser_id" class="validate[required]" value="<?php echo ($_POST['winDesc'] == 'edit')? $userid : '';?>"/>
          <input name="hUser_id" type="hidden" value="<?php echo ($_POST['winDesc'] == 'edit')? $userid : '';?>"/>
          <input name="setWindowActive" type="hidden" value="<?php echo $_POST['winDesc'];?>"/></td>
      </tr>
      <tr>
        <td><label>Level</label></td>
        <td>:</td>
        <td><?php 
		if($_POST['winDesc'] == 'edit')
			$this->registry->view->level = $level;
		
		$this->registry->view->show('combo_level'); 
		?></td>
      </tr>
      <tr>
        <td><label>Nama</label></td>
        <td>:</td>
        <td><input type="text" name="tName" id="tName" class="validate[required,custom[onlyLetter]]" value="<?php  echo ($_POST['winDesc'] == 'edit')? $nama : ''; ?>" /></td>
      </tr>
      <tr>
        <td><label>E-mail</label></td>
        <td>:</td>
        <td><input type="text" name="tEmail" id="tEmail" class="validate[optional,custom[email]]" value="<?php  echo ($_POST['winDesc'] == 'edit')? $email : ''; ?>"/></td>
      </tr>
      <tr>
        <td><label>Tanggal Masuk</label></td>
        <td>:</td>
        <td><input name="tHire" type="text"  id="tHire" class="validate[optional]" value="<?php  echo ($_POST['winDesc'] == 'edit')? $hire_dtm : ''; ?>"/></td>
      </tr>
      <tr>
        <td><label>Alamat</label></td>
        <td>:</td>
        <td><textarea name="addr" id="addr" class="validate[optional]" cols="24"><?php  echo ($_POST['winDesc'] == 'edit')? $addr : ''; ?>
</textarea></td>
      </tr>
      <tr>
        <td><label>Phone</label></td>
        <td>:</td>
        <td><input type="text" name="tPhone" id="tPhone" class="validate[optional,custom[telephone]]" value="<?php  echo ($_POST['winDesc'] == 'edit')? $phone  : ''; ?>"></td>
      </tr>
      <?php if($_POST['winDesc'] == 'edit'){ ?>
      <tr>
        <td><label>Status Pegawai</label></td>
        <td>:</td>
        <td><select name="HRDstat" id="HRDstat" class="validate[required]">
            <option value=""> -- Pilih Status -- </option>
            <option value="0" <?php  echo (isset($status)&&$status == 0)? 'selected' : ''; ?>> Tidak Aktif</option>
            <option value="1" <?php  echo (isset($status)&&$status == 1)? 'selected' : ''; ?>> Aktif</option>
          </select></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="2"></td>
        <td> 
          <input type="button" name="cmdEditUser" id="cmdEditUser" class="btn" value="<?php echo ($_POST['winDesc'] == 'edit')?'Update':'Add';?>" />
         </td>
      </tr>
    </table>
  </form>
  <?php } ?>
</div>
