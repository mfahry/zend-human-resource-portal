<script>
$(function(){
      $("#frmCal").validationEngine({
		inlineValidation: false,
		success :  false
	   });
});
</script>
<form method="post" id="frmCal">
  <table>
    <tr>
      <td><?php
				$this->registry->view->type = 'month';
				$this->registry->view->show('combo_date');
			?></td>
      <td><?php 
				$this->registry->view->type = 'year';
				$this->registry->view->show('combo_date'); 
			?></td>
      <td><div class="cmbDiv" style="margin-top:3px;">
          <input type="submit" class="btn" name="smbCal" value="submit" />
        </div></td>
    </tr>
  </table>
</form>
<br />
<?php
	if(isset($_POST['smbCal'])){
		$month = $_POST['cmbMonth'];
		$year = $_POST['cmbYear'];
	}else{
		$month = $this->registry->mCalendar->getMonth();
		$year = $this->registry->mCalendar->getYear();
	}
			
	$firstday = $this->registry->mCalendar->getFirstDayid_calendar($month,$year);
	if($firstday != NULL){
		$monthLabel = array('','January', 'Februari', 'Maret', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		for($z=1;$z<=9;$z++){
			$month = str_replace('0'.$z,$z,$month);
		}

		$header = $monthLabel[$month]." ".$year;
				
		if(($month==1)||($month==3)||($month==5)||($month==7)||($month==8)||($month==10)||($month==12)){
			$cnt = 31;
			/*if(($year%4) == 2){
				$row = 7;
			}else{*/
				if(($firstday == 6)||($firstday == 0)){
					$row = 6;
				}else{
					$row = 5;
				}
			//}
		}else{
			if($month==2){
				if(($year%4) == 0){
					$cnt = 29;
					$row = 4;
				}else{
					$cnt = 28;
					$row = 4;
				}
			}else{
				$cnt = 30;
				if(($firstday == 6)||($firstday == 0)){
					$row = 6;
				}else{
					$row = 5;
				}
			}
		}
	 ?>
<table border="1" cellpadding="1" cellspacing="0">
<tr align="center">
  <th colspan="7"><?php echo $header; ?></th>
</tr>
<tr align="center">
  <th>Senin</th>
  <th>Selasa</th>
  <th>Rabu</th>
  <th>Kamis</th>
  <th>Jumat</th>
  <th>Sabtu</th>
  <th>Minggu</th>
</tr>
<?php
		$dayCnt = 1;
		$iloop = 1;
		$todayid = date('j');
		for($i=1; $i <= $row;$i++){
			echo "<tr align=\"center\">";
						
			for($j=1; $j <= 7;$j++){
				$calid = $this->registry->mCalendar->select_calendarID($dayCnt, $month, $year);
				$stat = $this->registry->mCalendar->select_calendarID('', '', '', $calid, '' ,'status');
				$desc = $this->registry->mCalendar->select_calendarID('', '', '', $calid, '' ,'','desc');
				if($desc == NULL) $desc = "klik untuk edit";
								
				if($stat == 0){
				 	$bgcolor = "#FF0000";
				}else{
					$bgcolor = "#FFFFFF";
				}
								
				if(($iloop >= $firstday)&&($dayCnt <= $cnt)){
					if($bgcolor == "#FF0000") $fontcolor = "#FFFFFF";
									
					if($dayCnt == $todayid)
						echo "<td bgcolor=\"".$bgcolor."\">
						<a href=\"#\" id=\"$calid\" class=\"editCal vtip\" title=\"$desc\" style=\"color:".(($bgcolor == "#FF0000")?"#FFFFFF":"")."\"><b>$dayCnt</b></a></td>";
					else
						echo "<td bgcolor=\"".$bgcolor."\">
						<a href=\"#\" id=\"$calid\" class=\"editCal vtip\" title=\"$desc\" style=\"color:".(($bgcolor == "#FF0000")?"#FFFFFF":"#000000")."\">$dayCnt</a></td>";
						$dayCnt++;
				}else{
					echo "<td bgcolor=\"#CCCCCC\"></td>";
				}
				$iloop++;
			}
			echo "</tr>";
		}
	echo "</table>";
	}else{
		echo "Data Kalendar masih kosong.";
	}
	
	$this->registry->view->show('window_editCalendar');
?>
</div>

<script>
$(function(){
	var dhxWins = null;
	var dhxWins = new dhtmlXWindows();
	dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");
	dhxWins.setSkin("dhx_skyblue"); 		
	
	$('.editCal').live('click',function(){
		var data = $(this).attr("id"); 
		 $("#window_editCalendar").load(location.href+" #window_editCalendar>*",
			{calid : data}, 
			 function(){
				createWindow(); 
				//alert(dataApprove);
		 });  
	})
	
	function createWindow(){
		if (!dhxWins.window("winFin")) {
			document.getElementById("window_editCalendar").style.display = "block";
			var winFin = dhxWins.createWindow("w1", 300, 200, 360, 230);
			winFin.setText("Edit Calendar");
			winFin.setModal(true); 
			winFin.button("park").hide();
			winFin.button("minmax1").hide();
			winFin.button("minmax2").hide();
			winFin.attachEvent("onClose",function(win){
				if (win.getId() == "w1") {
					win.detachObject();
					win.hide();
					winFin.setModal(false);
				}
			})
		}else{
			var w1 = dhxWins.window("winFin");
			w1.show();
		}
		winFin.attachObject("window_editCalendar"); 
	}
});
</script> 
