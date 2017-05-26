<?php 
echo isset($message)?$this->registry->view->show($message):''; 
$harian = 0;
?>

<SCRIPT language="javascript" src="includes/JQuery/script/validation_engine.js"></SCRIPT>
<SCRIPT language="javascript" src="includes/JQuery/script/validation_engine-id.js"></SCRIPT>
<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/validation_engine.css"/> 

<SCRIPT>
$(function() {
	$("#frmAttendanceLeave").validationEngine({
		inlineValidation: false,
		success : false	  
	});
	   
});
</SCRIPT>
<form name="frmAttendanceLeave" id="frmAttendanceLeave" method="post" action="index.php?mod=attendance/leave">
  <!--actAbsenKeluar-->
  <table class="tableForm">
      <tr valign="top">
        <th colspan="3" class="thForm">Absen Keluar</th>
      </tr>
      <tr valign="top"> 
        <td><label>Jenis Absen</label></td>
        <td><label>:</label></td>
        <td>
        <?php   
        
        $cekHarian=$this->registry->mAbsensiHarian->cekCalendarHarian(1, $date, $month, $year, $_SESSION['userid']);
        if($cekHarian != 0){
            foreach ($cekHarian as $data){
                $harian = $data->ABSENSIHARIAN_ID;
            } 
        }
        $this->registry->view->rec = 13;
        $this->registry->view->show("radio_absenType");
                  
        ?>    
        </td>
      </tr>
    <tr valign="top"> 
      <td><label>Keterangan</label></td>
      <td><label>:</label></td>
      <td>
          <textarea name="tNote" id="tNote" class="validate[required,length[3,255]]" cols="45"></textarea>
        </td>
    </tr>
    <tr>
      <td colspan="2">
      	<input name="harianID" type="hidden" value="<?php echo $harian; ?>" />
        <!--<input name="tTime" type="hidden" value="<?php //echo $nowTime; ?>" />
        <input name="tAbsen" type="hidden" value="1" />
        <input name="ipAddress" type="hidden" value="<?php //echo $ip; ?>" />--></td>
      <td><input type="submit" name="submitAbsenOut" class="btn"  value="Submit"/></td>
    </tr>
  </table>
</form>
