<?php
if(isset($_SESSION['userid'])){
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
		// strikethrough,styleselect,formatselect,cut,copy,paste,pastetext,pasteword,|,search,replace,|,cleanup,help,advhr,,|,ltr,rtl
		theme_advanced_buttons1 : "save,newdocument,preview,fullscreen,print,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,code,|,insertdate,inserttime,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media",
		//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "includes/css/content.css",

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

<div id="knowledge" style="display:none; padding:15px; z-index:99999; background:#fff;">
  <form action="index.php?mod=knowledge/UploadArtikel" method="post" enctype="multipart/form-data" name="artikel">
    <table>
      <tr valign="top">
        <td><label>Judul</label></td>
        <td>:</td>
        <td><input type="text" name="judul" id="tulisjudul" style="width:100%;" /></td>
      </tr>
      <tr valign="top">
        <td><label>Deskripsi</label></td>
        <td>:</td>
        <td><textarea name="deskripsi" id="textarea" style="width:90%; height:300px;"></textarea></td>
      </tr>
      <tr valign="top">
        <td><label>Kategori</label></td>
        <td>:</td>
        <td><select name="kategori" size="1" width="200" id="combo_zone1">
            <?php
	  $data = $this->registry->mCategoryList->selectCategoryList();
	  foreach($data as $kategori){
			$namajenis = $kategori->CAT_NAME;
			echo "<option>$namajenis</option>"; 
	  }
	  ?>
          </select></td>
      <tr valign="top">
        <td><label>Upload</label></td>
        <td>:</td>
        <td><input type="file" name="fileField" id="fileField" /></td>
        <br>
      </tr>
      <tr>
        <td colspan="2"></td>
        <td>
            <input type="submit" name="button" id="button" value="Upload" class="btn" onclick="index.php?mod=knowledge/AddCategory">
        </td>
      </tr>
    </table>
  </form>
</div>
<?php
}
?>
<script>
var dhxWins = new dhtmlXWindows();
dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");
dhxWins.setSkin("dhx_skyblue");
document.getElementById("knowledge").style.display = "none";
var winFin = dhxWins.createWindow("w1", 0, 0, 700, 500);
winFin.attachObject("knowledge");
winFin.setText("Upload Knowledge");
winFin.setModal(true);
winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");
winFin.allowResize(true);
winFin.centerOnScreen();
winFin.bringToTop();

var z = dhtmlXComboFromSelect("combo_zone1");
z.readonly(0);


if (document.location.protocol == 'file:') {
	alert("The examples might not work properly on the local file system due to security settings in your browser. Please use a real webserver.");
}
/*
function tulis(){
var select = document.getElementById("combo_zone1");
	if (select.value!=""){
		window.location.href = "index.php?mod=knowledge/AddCategory? select=" + select;
	}
}
tulis();
*/
</script>