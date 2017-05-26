<?php
if(isset($_SESSION['userid'])){

foreach($knowledge as $artikel){
		$id = $artikel->KNOWLEDGE_ID;
		$judul = $artikel->JUDUL;
		$deskripsi = $artikel->DESKRIPSI;
		$file = $artikel->FILE;
		$tanggal = $artikel->DATE;
		$kategori_id = $artikel->CAT_ID;
?>
<script>
window.dhx_globalImgPath = "includes/dhtmlx/dhtmlxCombo/codebase/imgs/";
</script>
<link rel="STYLESHEET" type="text/css" href="includes/dhtmlx/dhtmlxCombo/codebase/dhtmlxcombo.css">
<script  src="includes/dhtmlx/dhtmlxCombo/codebase/dhtmlxcommon.js"></script>
<script  src="includes/dhtmlx/dhtmlxCombo/codebase/dhtmlxcombo.js"></script>

<!-- ===============editor================ -->
<script type="text/javascript" src="includes/dhtmlx/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<div id="update" width="850" height="600" style="display:none">
  <form action="index.php?mod=knowledge/updateknowledge/<?php echo $id;?>" method="post" enctype="multipart/form-data" name="artikel">
    <table width="850">
      <tr>
        <td>Judul :</td>
        <td><input type="text" name="judul" id="tulisjudul" width="200px" value="<?php echo $judul; ?>"/></td>
      </tr>
      <tr>
        <td>Deskripsi :</td>
        <td><textarea name="deskripsi" id="textarea" cols="80" rows="15" width="80%"><?php echo $deskripsi;?></textarea></td>
      </tr>
      <tr>
        <td>Kategori :</td>
		<?php
			$ini=$this->registry->mCategoryList->selectCategoryList(NULL,$kategori_id);
			foreach($ini as $dia){
				$oke = $dia->CAT_NAME;
			}
		?>
        <td><select name="kategori" size="1" width="200" id="combo_zone1" value="<?php echo $oke;?>">
            <?php
			echo "<option>$oke</option>"; 
	  $data = $this->registry->mCategoryList->selectCategoryList();
	  foreach($data as $kategori){
			$namajenis = $kategori->CAT_NAME;
			echo "<option>$namajenis</option>"; 
	  }
	  ?>
          </select></td>
      <tr>
        <td>Upload :</td>
        <td><input type="file" name="fileField" id="fileField" /></td>
	  </tr>
	  <tr>
		<td></td>
		<td>
		<?php
		if(!empty($file)){
		echo "KETERANGAN: File Upload lama <a href=\"includes/File/$file\" target=\"_blank\" > $file </a>";
        }
		?>
		</td>
		<br>
      </tr>
      <tr>
        <td colspan="2"><div align="center">
            <input type="submit" name="button" id="button" value="Update" class="btn">
          </div></td>
      </tr>
    </table>
  </form>
</div>
<?php
	}
}
?>
<script>
var dhxWins = new dhtmlXWindows();
dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");
dhxWins.setSkin("dhx_skyblue");
document.getElementById("update").style.display = "none";
var winFin = dhxWins.createWindow("w1", 250, 100, 800, 700);
winFin.attachObject("update");
winFin.setText("Update Knowledge");
winFin.setModal(false);
winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");
winFin.allowResize(true);


var z = dhtmlXComboFromSelect("combo_zone1");
z.readonly(0);

if (document.location.protocol == 'file:') {
	alert("The examples might not work properly on the local file system due to security settings in your browser. Please use a real webserver.");
}

</script>