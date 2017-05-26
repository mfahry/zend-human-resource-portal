
<div height="20%" id='window_editCategory' class="window" style="display:none">
<SCRIPT>
$(function() {	    
	$('.formError').live("click",function() { 
		$(this).hide();
	});
	
	$('#SubmitEditCategory').live("click",function() {
		 	var boo = true;
			if($("#tCatName").val()==""){
				$.validationEngine.buildPrompt("#formAdminEditCategory #tCatName","* Kolom ini harus diisi","error");	
				boo = boo & false;
			}
			
			if($("#publish").val()==""){
				$.validationEngine.buildPrompt("#formAdminEditCategory #publish","* Kolom ini harus diisi","error");	
				boo = boo & false;
			}
			
			if(boo){
				var submitData = $('#formAdminEditCategory').serialize();
				$(this).addClass("disabled");
				$(this).attr("disabled","disabled"); 
				$.ajax({
					type: "POST",
					url: "index.php?mod=setting/saveCategory",
					data: submitData,
					dataType: "html",
					success: function(msg){
						location.href="index.php?mod=setting";	
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

</SCRIPT>
<?php 				
$CategoryName = "";
$pubType = "";
if(isset($_POST['ket']) && $_POST['ket']=='edit'){
	$dataCategory = $this->registry->mNewsCategory->selectNamePublish($_POST['id']);
	foreach($dataCategory as $data){
		$CategoryName = $data->CAT_NAME;
		$pubType = $data->PUBLISHTYPE;
	}
}
?>
  <form  id='formAdminEditCategory' method="post" name="formAdminEditCategory">
  	<input type="hidden" name="ket" value="<?php echo $_POST['ket']; ?>" />
  	<input type="hidden" name="catid" value="<?php echo $_POST['id']; ?>" />
    <table>
      <tr valign="top">
        <td><label>Nama Kategori</label></td>
        <td>:</td>
        <td><input name="tCatName" type="text" id="tCatName" class="validate[required]"  value="<?php echo $CategoryName; ?>"/></td>
      <tr valign="top">
        <td><label>Publikasi</label></td>
        <td>:</td>
        <td><select name="publish" id="publish" class="validate[required]">
            <option value=""> -- Pilih Status -- </option>
            <option value="0" <?php echo ($pubType=='0')?'selected':'';	?>> Tidak</option>
            <option value="1" <?php echo ($pubType=='1')?'selected':''; ?>> Umum</option>
            <option value="2" <?php echo ($pubType=='2')?'selected':''; ?>> Internal</option>
          </select></td>
      </tr>
      <tr>
        <td colspan="2"></td>
        <td><input type="button" class="btn" name="SubmitEditCategory" id="SubmitEditCategory" value="<?php echo ($_POST['ket'] == 'edit')?'Update':'Add';?>" /></td>
      </tr>
    </table>
  </form>
</div>
