<link rel="STYLESHEET" type="text/css" href="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxtabbar.css">
<script  src="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxcommon.js"></script>
<script  src="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxtabbar.js"></script>
<script src="includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxcontainer.js"></script>

<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxcommon.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgridcell.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_start.js"></script>

<script type="text/javascript" src="includes/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxdataprocessor.js"></script>

<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/skins/dhtmlxwindows_dhx_skyblue.css">
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcommon.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcontainer.js"></script>
<link type="text/css" href="includes/JQuery/ui/css/custom-theme/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
<script type="text/javascript" src="includes/JQuery/ui/js/jquery-ui-1.8.14.custom.min.js"></script>

<div style="width:930px;">
	<div id="a_tabbar" style="width:650px; height:400px;float:left;">

		<?php 
			
		$datatask = $this->registry->mTask->selectDB_orgteam($_SESSION['userid']);		
		//print_r($datatask );	
		
		if(count($datatask)>0){
			$i=1;		
					
			foreach($datatask as $data){ 
			
		?>

		<div id='<?php echo 'html_'.$i; ?>'>
			<?php 

					 $this->registry->view->orgid=$data->ORGANIZATION_ID;
					 $this->registry->view->show('grid_organization');
					 
			
			?>
			
		</div>

		<?php 
						$nameOrg[$i]=$data->NAME;
						$i++;						
						}//close for each
					}//close if count > 0
		?>

		<?php
		echo '<script>';
		echo '	tabbar = new dhtmlXTabBar("a_tabbar", "top");';
		echo '	tabbar.setSkin("dhx_skyblue");';
		echo '	tabbar.setImagePath("includes/dhtmlx/dhtmlxTabbar/codebase/imgs/");';
		echo '	tabbar.enableAutoSize(true, true);';

		for ($j=1; $j<$i; $j++){
			echo '	tabbar.addTab("a'.$j.'", "'.$nameOrg[$j].'", "150px");';
			echo '	tabbar.setContent("a'.$j.'","html_'.$j.'");';
		}

		/*echo '	tabbar.addTab("a1", "Task", "150px");';echo '	tabbar.setContent("a1","html_1");';
		echo '	tabbar.addTab("a2", "Status Rekomendasi", "150px");';

		echo '	tabbar.setContent("a2","html_2");';
		*/

		if($tabActive==1)
			echo '	tabbar.setTabActive("a1");';


		echo '</script>';
		?>
	</div>
	<div style="width:185px; height:400px; float:right; border:1px solid #ccc;padding:5px;">
		<style>
		.watermark{
			font-style:italic;
			color:#ccc;
		}
		#dialogFolder th.left{
			text-align:center;
			font-size:14px;
			padding:3px;
			color:#fff;
			background: #666;
		}
		#dialogFolder th.right{
			text-align:center;
			font-size:14px;
			padding:3px;
			color:#fff;
			background: #666;
		}
		#dialogFolder td{
			padding:3px;
			border: 1px solid #ccc;
			border-collapse: collapse;
		}
		.fakefile{
			position:relative;
			top:-25px;
		}
		</style>
		<script>
		function HandleFileButtonClick()
		{
			//document.formUpload.upFile.click();
			//document.formUpload.txtFakeText.value = document.formUpload.upFile.value;
			//$("#upFile").click();
		}
		</script>
		UPLOAD FILE<br /><br />
		<form id="formUpload" name="formUpload" action="" method="post" enctype="multipart/form-data">
			<div style="width:100%;display:block;padding-bottom:10px;clear:both;">
				Direktori:<br />
				<img src="includes/img/btnFolder.png" id="folder" />
				<input style="width:100%;" name="fakeFolder" id="fakeFolder" value="" readonly />
				<input name="fakeFolderId" id="fakeFolderId" value="" type="" />
				<input name="parentid" id="parentid" value="" type="" />
			</div>
			<br />
			<div style="width:100%;display:block;padding-bottom:10px;clear:both;">
				File:<br />
				<input id="upFile" name="upFile" type="file" value="" size="1" style="opacity:0;filter:alpha(opacity=0);width:80px;" class="file" />
				<div class="fakefile">
					<img src="includes/img/btnFile.png" id="btnFile" />
					<input style="width:100%;" name="txtFakeText" id="txtFakeText" value="" readonly />
				</div>
			</div>
			<div style="width:100%;display:block;padding-bottom:10px;clear:both;" class="fakefile">
				<input id="btnUp" name="btnUp" type="button" value="UPLOAD" />
			</div>
			<br />
			<div id="dialogFolder" style="display:none;">
				<div style="max-height:300px;overflow:auto;">
					<table>
						<tr>
							<th class="left" width="400">Nama Folder</th>
						</tr>
						<?php
						$folder = $this->registry->mUpload->folderList();
						
						if(count($folder)>0){
							foreach($folder as $data){
								?>
								<tr>
									<td>- <a href="javascript:void(0);" onclick="pilih('<?=$data->FOLDER_NAME?>','<?=$data->FOLDER_ID?>','<?=$data->FOLDER_PARENT?>');"><?=$data->FOLDER_NAME?></a></td>
								</tr>
								<?php
								$parent = $this->registry->mUpload->folderParent($data->FOLDER_ID);
								if(count($parent)>0){
									foreach($parent as $pdata){
									?>
										<tr>
											<td>&nbsp;&nbsp;&nbsp;- <a href="javascript:void(0);" onclick="pilih('<?=$pdata->FOLDER_NAME?>','<?=$pdata->FOLDER_ID?>','<?=$pdata->FOLDER_PARENT?>');"><?=$pdata->FOLDER_NAME?></a></td>
										</tr>
									<?php
									}
								}
							}
						}
						?>
					</table>
				</div>
				<br />
				<input id="btnNew" name="btnNew" type="button" value="TAMBAH FOLDER BARU" />
				<br />
				<div id="divbaru" style="padding-top:5px;width:460px;">
				<hr />
					<div style="float:left;width:100px;padding-top:5px;">Folder Name</div>
					<div style="float:left;width:350px;">
						: <input id="dirbaru" name="dirbaru" value="" style="width:300px;" />
					</div>
					<div style="clear:both;height:5px;"></div>
					<div style="float:left;width:100px;padding-top:5px;">Folder Parent</div>
					<div style="float:left;width:350px;">
					: 
					<?php
					/*
					$dirc   = '/mnt/Kerja';
					$files1 = scandir($dirc);
					echo "<pre>";
					print_r($files1);
					echo "</pre>";
					echo count($files1);
					*/
					
					$parentNew = $this->registry->mUpload->folderParent("0");
					
					echo "<select name=\"folderparent\" id=\"folderparent\">";
					echo '<option value="0">NO PARENT</option>';
					if(count($parentNew)>0){
						foreach($parentNew as $pNew){
							echo '<option value="'.$pNew->FOLDER_ID.'">'.$pNew->FOLDER_NAME.'</option>';
						}
					}
					echo "</select>";
					?>
					</div>
					<div style="clear:both;height:10px;"></div>
					<div style="float:left;width:100px;padding-top:5px;"></div>
					<div style="float:left;width:350px;">&nbsp; <input id="simpanNew" value="SIMPAN FOLDER BARU" type="button" /></div>
					<div style="clear:both;"></div>
					<input id="fakebaru" name="fakebaru" value="" type="text" style="width:0px;height:0px;border:0;background:none;" class="none" />
				</div>
			</div>
		</form>
		<script>
		$(function(){
			$("#dirbaru").watermark('watermark','Masukkan nama direktori baru');
			$("#divbaru").hide();
			$("#txtFakeText").hide();
			$("#fakeFolder").hide();
			$("#fakeFolderId").hide();
			$("#parentid").hide();
			
			$("#btnFile").click(function(){
				$("#upFile").click();
			});
			
			/*$("#direktori").change(function(){
				if($("#direktori").val()=="baru"){
					$("#divbaru").show("fast");
				} else {
					$("#divbaru").hide("fast");
				}
			});*/
			
			$("#btnUp").click(function(){
				if($("#fakeFolder").val()==''){
					alert("Pilih direktori file!");
					$("#fakeFolder").click();
				}else if(($("#fakeFolderId").val()=="new") && ($("#dirbaru").val()=='Masukkan nama direktori baru')){
					alert("Masukkan nama direktori baru!");
					$("#dirbaru").focus();
					return false;
				}else if($("#upFile").val()==''){
					alert("Pilih file!");
					$("#txtFakeText").focus();
				}else{
					$("#formUpload").submit();
				}
			});
			
			$("#upFile").change(function(){
				$("#txtFakeText").show();
				$("#txtFakeText").val($("#upFile").val());
			});
			
			/*$("#folderid").click(function(){
				$("#fakeFolder").show();
				$("#fakeFolder").val($("#fldrName").val());
				$("#fakeFolderId").val($("#folderid").val());
				$("#dialogFolder").dialog("close");
			});*/
			
			$("#simpanNew").click(function(){
				if( $("#dirbaru").val() =='Masukkan nama direktori baru'){
					alert('Masukkan nama direktori baru');
					$("#dirbaru").focus();
				} else {
					$("#fakeFolder").show();
					$("#fakeFolder").val($("#dirbaru").val());
					$("#fakeFolderId").val("new");
					$("#parentid").val($("#folderparent").val());
					$("#dialogFolder").dialog("close");
				}
			});
			
			$("#folder").click(function(){
				$("#dialogFolder").dialog({
					width	: 500,
					height	: 400,
					title	: 'Folder List',
					modal	:true
				});
			});
			
			$("#btnNew").click(function(){
				$("#divbaru").show();
				$("#fakebaru").focus();
				$("#dirbaru").focus();
			});
		});
		
		function pilih(name,id,parent){
			$("#fakeFolder").show();
			$("#fakeFolder").val(name);
			$("#fakeFolderId").val(id);
			$("#dialogFolder").dialog("close");
			$("#parentid").val(parent);
		}
		</script>
		<?php
		if(isset($_POST['fakeFolderId'])){
			$folderId = $_POST['fakeFolderId'];
			$folder = $_POST['fakeFolder'];
			$parentfolder 	= $_POST['parentid'];
			
			if($folderId == 'new'){				
				$folderId = $this->registry->mUpload->folderBaru($folder,$parentfolder);
			}
			
			$qParent = $this->registry->mUpload->folderName($parentfolder);
			if($qParent){
				if(count($qParent)>0){
					foreach($qParent as $qPrnt){
						$foldername .= $qPrnt->FOLDER_NAME;
					}
				}
				$dir = "upload/$foldername/$folder/";
			} else {
				$dir = "upload/".$folder."/";
			}
			
			//echo "$dir<pre>";
			//print_r($_FILES['upFile']);
			
			$namafile = basename($_FILES['upFile']['name']);
			
			list($fname,$fext) =  explode('.', $namafile);
			$fext = strtolower($fext);
			$namafile = $fname."_".date("YmdHis").".".$fext;
			$namafileori = $fname;
			$filetype = $fext;

			$destfile = $dir.$namafile;
			
			$upload = @move_uploaded_file($_FILES['upFile']['tmp_name'], $destfile);
			
			//echo $destfile." ~ ".$upload;
			
			if($upload){				
				chmod($destfile, 0777);
					
				$this->registry->mUpload->UploadFile($folderId,$namafile,$namafileori,$filetype);
				
				echo "<script>
						alert('Upload file berhasil.');
						location.href= '?mod=recommendation';
					</script>";
			} else {
				echo "<script>
						alert('Upload file gagal !!!');
						location.href= '?mod=recommendation';
					</script>";
			}
		}
		?>
	</div>
</div>