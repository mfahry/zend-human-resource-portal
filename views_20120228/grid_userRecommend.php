 <link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/skins/dhtmlxwindows_dhx_skyblue.css">
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcommon.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcontainer.js"></script>

<script type="text/javascript">
$(function() {
      $("#formuserRecommend").validationEngine({
		inlineValidation: false,
		success :  false
		// promptPosition: "bottomLeft"
	   });
	    

	var dhxWins = null;
	var dhxWins = new dhtmlXWindows();
	dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");
	dhxWins.setSkin("dhx_skyblue"); 		
	
	$('.detailrec').click(function(){
		var data = $(this).attr("id"); 
		data = data.split('_');
		 $("#window_recommendationDetail").load(location.href+" #window_recommendationDetail>*",
			{calid : data[0],
			userid : data[1],
			absentype : data[2]}, 
			 function(){
				createWindow0(); 
				//alert(dataApprove);
		 });  
	})
	
	function createWindow0(){
		var dhxWins = null;
		var dhxWins = new dhtmlXWindows();
		dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");
		dhxWins.setSkin("dhx_skyblue"); 		 
		 
		if (!dhxWins.window("winFin")) { 
			var winFin = dhxWins.createWindow("w1", 400, 200, 400, 300);
			winFin.setText("Detail Recommendation");
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
		winFin.attachObject("window_recommendationDetail"); 
	}	
})
</script>
<form name="formuserRecommend" id="formuserRecommend" method="post" action="index.php?mod=reporting/userRecommend">
  <table width="873" style="margin-left:0px;">
    <tr>
      <?php if($_SESSION['position_id'] == 1 || $_SESSION['level_id']==2){ ?>
      <td><?php $this->registry->view->show("combo_user"); ?></td> 
     <?php } ?> 
      <td width="43"><?php 
				$this->registry->view->type="month";
				$this->registry->view->show("combo_date");?></td>
      <td width="43"><?php 
				$this->registry->view->type="year";
				$this->registry->view->show("combo_date");?></td>
      <td width="590"><input type="submit" name="submitDetail" class="btn" value="submit"/></td> 
    </tr>
  </table>
</form>

 <table id="gridUserRecomend">
  <tr>
    <th width="30">#</th>
    <th width="110">Nama</th>
    <th width="70">Jenis Absen</th> 
    <th width="80">Tanggal Rekomendasi</th>
    <th width="150">Keterangan</th>
    <th width="100">Status</th>
  </tr>
  <?php 
	$i 			= 1; 	
	if(count($userReclist)>0){
		foreach($userReclist as $data){ 
	?>
  <tr>
    <td><?php echo $i++;  ?></td>
    <td><?php echo $this->registry->mUser->get_fullName($data->USER_ID); ?></td>
    <td> <?php echo $this->registry->mAbsenType->selectDB_typeAbsen($data->ABSENTYPE_ID);?>  </td> 
	<td>
    	<a href="#detail" class="detailrec" id="<?php echo $data->CALENDAR_ID.'_'.$data->USER_ID.'_'.$data->ABSENTYPE_ID;?>">
    	<?php echo ($data->CALENDAR_ID!=NULL)?$this->registry->mCalendar->get_fullDate($data->CALENDAR_ID):'-'; ?>
        </a>
    </td>
    <td><?php echo $data->START_DESC; ?></td>
    <td><?php echo ($data->CALENDAR_ID!=NULL)?$this->registry->mAbsenTemp->count_activeStatus($data->USER_ID,$data->CALENDAR_ID, $data->ABSENTYPE_ID):'-'; ?></td>
  </tr>
  <?php	
		}
	} 
?>
</table>
<script>
	grid = new dhtmlXGridFromTable("gridUserRecomend");
	grid.setImagePath("includes/dhtmlx/dhtmlxGrid/imgs/");
	grid.setSkin("dhx_black");
	grid.enableAutoWidth(true,900,500);
	grid.enableAutoHeight(true, 600,600);
	grid.setSizes();
	grid.setColTypes("ro,ro,ro,ro,ro,ro,ro"); 
</script>


<?php  
$this->registry->view->show('window_recommendationDetail');  
 ?>