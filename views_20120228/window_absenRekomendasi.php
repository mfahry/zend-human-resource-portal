<script>
$(function(){
	
	   function buildPrompt(element, message){
		   $.validationEngine.buildPrompt("#formAbsen_s #"+element,"* "+message,"error");
		}
		
		$('.formError').live("click",function() { 
			$(this).hide();
		});
		
		$('#cmdSave').live("click",function() { 
			var boo = true; 
			var tDate =  $('#tDate').val(); 
			var tDatesplit = tDate.split('-');
			
			var regdate = /^\d\d\d\d\-\d\d-\d\d$/; 
			var reg1 = new RegExp(regdate); 
			
		  	var currentTime = new Date();
			var date = currentTime.getDate();
			var month = currentTime.getMonth()+1;
			var year = currentTime.getFullYear();
			
			if(tDatesplit[0] > year+1 || tDatesplit[0] < 2009){
				buildPrompt('tDate', 'Tahun tidak valid.');
				boo = boo && false;
			}
			
			if(tDatesplit[1] > 12){
				buildPrompt('tDate', 'Bulan tidak valid.');
				boo = boo && false;
			}
			
			if(tDatesplit[2] > 31){
				buildPrompt('tDate', 'Tanggal tidak valid.');
				boo = boo && false;
			}
			
			if(tDate == ''){
				buildPrompt('tDate', 'Kolom ini harus diisi.');
				boo = boo && false;
			}  
		
			if(reg1.test(tDate) == false){
				buildPrompt('tDate', 'Format tanggal YYYY-MM-DD.');
				boo = boo && false;
			}  
			
			if(boo){ 
				var submitData = $('#formAbsen_s').serialize();
				$(this).attr('disabled','disabled');
				$(this).addClass('disabled');
				$.ajax({
					type: "POST",
					url: "index.php?mod=recommendation/actAbsensiRekomendasi",
					data: submitData,
					dataType: "html",
					success: function(msg){
						location.href="index.php?mod=recommendation";	
					},
					error: function(XMLHttpRequest, textStatus, errorThrown){
						alert("error:" +XMLHttpRequest);	
						alert("error:" +textStatus);	
						alert("error:" +errorThrown);
					}
					
				}); 
			}
		});	
})
</script>

<div id="window_absenRekomendasi" class="window" style="display:none" align="center">
	<form name="formAbsen_s" id="formAbsen_s" method="post">
		<table width="390" height="185">
			<tr valign="top">
				<td width><label>Nama</label></td>
				<td>:</td>
				<td><?php echo $_POST['username'];?></td>
			</tr>
			<tr valign="top">
				<td width><label>Alasan</label></td>
				<td>:</td>
				<td><?php echo ($_POST['typeid']==2)?"Sakit":"Izin"; ?>	 </td>
			</tr>
			<tr valign="top">
				<td><label>Tanggal</label></td>
				<td>:</td>
				<td><input type="text" name="tDate" id="tDate" /></td>
			</tr>
			<tr valign="top">
			  <td><label>Keterangan</label></td>
			  <td>:</td>
			  <td><textarea name="tDesc" cols="30"></textarea></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td><input type="button" value="Submit" name="cmdSave" id="cmdSave" class="btn" /></td>
			</tr>
	  </table>
		<input type="hidden" name="userid" value="<?php echo $_POST['userid'];?>"  />
		<input type="hidden" name="ket" value="<?php echo $_POST['typeid'];?>"  />
	</form>
	<?php 
		/*if(isset($_POST['submit_s'])){
			$calid = $this->registry->mCalendar->select_calendarID($_POST['cmbDate1'], $_POST['cmbMonth1'], $_POST['txtYear1']);
			$this->registry->mAbsensiHarian->insert_Absen($_POST['userid'], $calid, $this->registry->mCalendar->currentDate(), $_POST['tDesc'], $this->registry->mUser->getIPGuest(), $_POST['ket']);
			echo "<script>location.href=\"index.php?mod=index/daftarAbsensi\";</script>";
		}
*/	?>
</div> 