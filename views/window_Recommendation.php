<!--for hrd																															-->
<div id="window_fullRecommendation" class="window" style="display:<?php echo ($_SESSION['level_id']==3)?'block':'none';?>" align="center">
    <link rel="stylesheet" type="text/css" href="includes/JQuery/styles/validationEngine.jquery.css">
    <script type="text/javascript" src="includes/JQuery/script/validation_engine.js"></script>
    <script type="text/javascript" src="includes/JQuery/script/validation_engine-id.js"></script> 
    
    <link rel="stylesheet" type="text/css"  href="includes/JQuery/styles/timeEntry.css" />
    <script type="text/javascript" src="includes/JQuery/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="includes/JQuery/script/timeEntry.js"></script>
    
    <link rel="STYLESHEET" type="text/css" href="includes/dhtmlx/dhtmlxCalendar/codebase/dhtmlxcalendar.css">
    <script> window.dhx_globalImgPath = "includes/dhtmlx/dhtmlxCalendar/codebase/imgs/"; </script>
    <script  src="includes/dhtmlx/dhtmlxCalendar/codebase/dhtmlxcommon.js"></script>
    <script  src="includes/dhtmlx/dhtmlxCalendar/codebase/dhtmlxcalendar.js"></script>
<script>

	var mCal1,mCal2, cal;
	 
	window.onload = function() {
		 
		mCal1 = new dhtmlxCalendarObject('calinput1', true, {
			isWinHeader: true, 
			isMonthEditable: true 
		});
		mCal1.setDateFormat("%d/%m/%Y"); 
		
		mCal2 = new dhtmlxCalendarObject('calinput2', true, {
			isWinHeader: true, 
			isMonthEditable: true 
		});
		mCal2.setDateFormat("%d/%m/%Y"); 

	} 
	 
</script>
<script type="text/javascript">
$(function () {
	$('#tjam1').timeEntry({
		spinnerImage: 'includes/JQuery/images/timeEntry/spinnerText.png',
		show24Hours: true,
		useMouseWheel: true
		//defaultTime: new Date(0, 0, 0, 17, 0, 0)
	});
	$('#tjam2').timeEntry({
		spinnerImage: 'includes/JQuery/images/timeEntry/spinnerText.png',
		show24Hours: true,
		useMouseWheel: true
		//defaultTime: new Date(0, 0, 0, 17, 0, 0)
	}); 
	 
});
</script> 
<script type="text/javascript">
$(function() {
      $("#formwindow_fullRecommendation").validationEngine({
		inlineValidation: false,
		success :  function(){ 
			if($("#tjam1").val()=="00:00")
				$.validationEngine.buildPrompt("#formwindow_fullRecommendation #tjam1","* Jam '00:00' tidak diperbolehkan","error");	
			
			if($('#cmbUser').val().length < 2)
				$.validationEngine.buildPrompt("#formwindow_fullRecommendation #cmbUser","* Minimal pilih 2 pegawai","error");	
			//$('#window_fullRecommendation').load(location.href+' #window_fullRecommendation>*','');
			var cal2 = $('#absen_2').css('visibility');
			//alert(cal2);
			if(cal2 == 'visible'){
				if($("#calinput2").val()=="")
					$.validationEngine.buildPrompt("#formwindow_fullRecommendation #calinput2","* Tanggal harus diisi","error");
				if($("#tjam2").val()=="")
					$.validationEngine.buildPrompt("#formwindow_fullRecommendation #tjam2","* Jam harus diisi","error");
				if($("#tjam2").val()=="00:00")
					$.validationEngine.buildPrompt("#formwindow_fullRecommendation #tjam2","* Jam '00:00' tidak diperbolehkan","error");		
			}
		} 
	  });
	   
});
</script>
<?php
if(count($datauser)>0){
	foreach($datauser as $data){	
		$userid		= $data->USER_ID;
		$username 	= $data->NAME;
		$lev_name	= $data->LEV_NAME;
		$email 		= $data->EMAIL;
	}
}
if(isset($message))
	echo '<center>'.$message.'</center>';
?> 

   <form name="formwindow_fullRecommendation" id="formwindow_fullRecommendation" method="post" action="index.php?mod=recommendation/submitfullRecommendation">
    <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
    <table border="0" width="430" height="80%" style="font-family: Courier New; font-size:14px;">
      <tr valign="top">
        <td width="122" height="20"><label>Nama</label></td>
        <td width="12">:</td>
        <td colspan="2"><?php echo $username ?></td>
      </tr>
      <tr valign="top">
        <td height="20"><label>Level</label></td>
        <td>:</td>
        <td colspan="2" valign="top"><?php echo $lev_name; ?></td>
      </tr>
      <tr valign="top">
        <td height="20"><label>Jenis Absen</label></td>
        <td>:</td>
        <td colspan="2"><?php
					$this->registry->view->rec = 0;
					$this->registry->view->show('radio_absenType');
					?>
                    </td>
      </tr>
      <tr valign="top">
        <td height="24"><label>Tanggal/Jam</label></td>
        <td>:</td>
        <td width="153"> 
        	<input type="text" id="calinput1" name="calinput1" readonly="readonly" class="validate[required]"/>
        </td>
        <td width="125">
        	<input name="time1" type="text" value="" id="tjam1" style="width:40px;" class="validate[required]"/> </td>
      </tr> 
      <tr id="absen_2" style="visibility:hidden;">
            <td height="24" colspan="2"></td>
            <td> 
            	<input type="text" id="calinput2" name="calinput2" readonly="readonly" />
            </td>
            <td><input name="time2" type="text" value="" id="tjam2" style="width:40px;"/></td>
        </tr>
      <tr valign="top">
        <td height="37"><label>Keterangan </label></td>
        <td>:</td>
        <td colspan="2"><textarea name="tKet" id="tKet" cols="45"   class="validate[optional,length[3,255]]"></textarea></td>
      </tr>
      <tr valign="top">
        <td height="20"><label>Rekomendasi</label></td>
        <td>:</td>
        <td colspan="2" class="vtip" title="NB : HRD merekomendasikan minimal 2 pegawai.">
		<?php $this->registry->view->show('combo_user'); ?>
         </td> 
      </tr>
      <tr>
        <td height="26" colspan="2"></td>
        <td colspan="2"><input type="submit" name="submitRecomend" value="Submit" class="btn"  > </td>
      </tr>
    </table>
  </form>
</div>
