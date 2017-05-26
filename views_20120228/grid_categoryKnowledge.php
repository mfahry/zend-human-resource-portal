<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxcommon.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgridcell.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_start.js"></script>

<script>
$(function(){

	var dhxWins = null;
	var dhxWins = new dhtmlXWindows();
	dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");
	dhxWins.setSkin("dhx_skyblue"); 		
	
	$('.modify').click(function(){
		var data = $(this).attr("id"); 
		data = data.split('_');
		 $("#window_editCategory").load(location.href+" #window_editCategory>*",
			{ket : data[0],
			id : data[1]}, 
			 function(){
				createWindow0(); 
				//alert(dataApprove);
		 });  
	})
	
	function createWindow0(){
		if (!dhxWins.window("winFin")) {
			document.getElementById("window_editCategory").style.display = "block";
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
		winFin.attachObject("window_editCategory"); 
	}	
})
</script>
<a href="#add" class="modify" id="add_0">Tambah Kategori</a>
<table id="adminNewsCategory">
  <tr>
    <th width="50">#</th>
    <th width="150">Nama</th>
    <th width="75">Publikasi</th>
    <th width="75">Jml Knowledge</th>
    <th width="100">Aksi</th>
  </tr>
  <?php
		$i=0;
		$category = $this->registry->mNewsCategory->selectNewsCategory();
		foreach($category as $data){
			$i++;
			$count = $this->registry->mKnowledge->ShowArtikel($data->NC_ID);
	?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo $data->CAT_NAME; ?></td>
    <td><?php 
		if($data->PUBLISHTYPE == 0) echo 'Tidak';
		elseif($data->PUBLISHTYPE == 1) echo 'Umum';
		elseif($data->PUBLISHTYPE == 2) echo 'Internal'; 
	?></td>
    <td><?php echo count($count); ?></td>
    <td><a href="#edit" id="edit_<?php echo $data->NC_ID; ?>" class="modify"> Edit </a> | 
    <!--<a href="index.php?mod=setting/deleteCategory/<?php //echo $data->NC_ID; ?>" class="merah"> Delete </a>!--> 
      <a href="#" onclick="deleteCategory(<?php echo $data->NC_ID; ?>)">Delete</a></td>
  </tr>
  <?php
		}
	?>
</table>
 <?php $this->registry->view->show('window_editCategory'); ?>
<script>
grid = new dhtmlXGridFromTable("adminNewsCategory");
grid.setImagePath("includes/dhtmlx/dhtmlxGrid/codebase/imgs/");
grid.setSkin("dhx_skyblue");
grid.enableAutoWidth(true,550,550);
grid.enableAutoHeight(true, 600,600);
grid.setSizes();
grid.setColTypes("ro,ro,ro,ro,ro,ro");

function deleteCategory(catID) {
	var ind1 = confirm("Yakin menghapus kategori ini?");
	if(ind1){
	location.href = "index.php?mod=setting/deleteCategory/"+catID;
	}
}
</script>