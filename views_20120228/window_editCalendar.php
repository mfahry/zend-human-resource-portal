<?php 
$tgl = NULL;
$stat = NULL;
$desc = NULL;
if(isset($_POST['calid'])){ 
	$queCal = $this->registry->mCalendar->selectCalDay($_POST['calid']);
	foreach($queCal as $dataCal){
		$tgl = $dataCal->NAME_DAY.", ".$dataCal->DATE."-".$dataCal->MONTH."_".$dataCal->YEAR;
		$desc = $dataCal->DESC;
		$stat = $dataCal->STATUS;
	}
}
?> 
<script>
$(function(){
	$('#smbEditCal').live("click",function() {
		 
			var submitData = $('#frmEditCalendar').serialize();
			$(this).addClass("disabled");
			$(this).attr("disabled","disabled"); 
			$.ajax({
				type: "POST",
				url: "index.php?mod=setting/saveCalendar",
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
	});	
})
</script>
<div id="window_editCalendar" class="window" style="display:none">
	<form method="post" id="frmEditCalendar" name="frmEditCalendar"> 
		<input type="hidden" name="calid" value="<?php echo $_POST['calid']?>" />
		<table border="0">
			<tr>
				<td><label>Hari/Tanggal</label></td>
				<td>:</td>
				<td><?php echo $tgl; ?></td>
			</tr>
			<tr>
				<td><label>Status</label></td>
				<td>:</td>
				<td><?php
				$this->registry->view->stat = $stat;
				$this->registry->view->show('combo_dayStatus');
				?></td>
			</tr>
			<tr>
				<td><label>Keterangan</label></td>
				<td>:</td>
				<td><textarea name="txaDescCal"><?php echo $desc; ?></textarea></td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td>
					<input type="button" name="smbEditCal" id="smbEditCal" value="Submit" class="btn"  /> 
				</td>
			</tr>
		</table>
	</form>
</div>