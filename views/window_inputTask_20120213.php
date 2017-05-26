<script language="javascript" src="includes/JQuery/script/validation_engine.js"></script>
<script language="javascript" src="includes/JQuery/script/validation_engine-id.js"></script>
<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/validation_engine.css"/> 
<!--script language="javascript" src="includes/JQuery/jquery.autocomplete.js"></script-->
<script language="javascript" src="includes/js/validasi.js"></script>
<link type="text/css" href="includes/JQuery/ui/css/blitzer/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="includes/JQuery/ui/js/jquery-ui-1.8.16.custom.min.js"></script>
<script>
$(function() {
	var availableTags = [
		"ActionScript",
		"AppleScript",
		"Asp",
		"BASIC",
		"C",
		"C++",
		"Clojure",
		"COBOL",
		"ColdFusion",
		"Erlang",
		"Fortran",
		"Groovy",
		"Haskell",
		"Java",
		"JavaScript",
		"Lisp",
		"Perl",
		"PHP",
		"Python",
		"Ruby",
		"Scala",
		"Scheme"
	];
				
	$("#frmWindowInputTask").validationEngine({
		inlineValidation: false,
		success : function(){add_r();}	  
	});
	
	$("#projectName").hide();

	$("#inputTask").keyup(function(){
		if($("#inputTask").val() != "#@" && $("#inputTask").val() != "@#"
				&& $("#inputTask").val() != "@#[" && $("#inputTask").val() != "@#["
				&& $("#inputTask").val() != "[@#" && $("#inputTask").val() != "[@#"
				&& $("#inputTask").val() != "@[#" && $("#inputTask").val() != "@[#"
				&& $("#inputTask").val() != "@[" && $("#inputTask").val() != "[@"
				&& $("#inputTask").val() != "#[" && $("#inputTask").val() != "[#"){
				
			if($("#inputTask").val().match(/.*\=+$/)){
				showTime();
			}else 
			if($("#inputTask").val().match(/\#.*/)){
				$.ajax({
					type	: 'post',
					url		: 'views/window_taskAuto.php',
					data	: 'task='+$("#inputTask").val().match(/\#.*/),
					success	: function(msg){
						$("#projectName").show();
						$("#projectName").html(msg);
					}
				});				
			}else 
			if($("#inputTask").val().match(/\@.*/)){
				$.ajax({
					type	: 'post',
					url		: 'views/window_userAuto.php',
					data	: 'usr='+$("#inputTask").val().match(/\@.*/),
					success	: function(msg){
						$("#projectName").show();
						$("#projectName").html(msg);
					}
				});
			}else 
			if($("#inputTask").val().match(/\[.*/)){
				$("#inputTask").autocomplete({
					source: availableTags,
					autoFocus: true
				});
				/*$.ajax({
					type	: 'post',
					url		: 'views/window_taskAuto.php',
					data	: 'task='+$("#inputTask").val().match(/\[.* /),
					success	: function(msg){
						$("#projectName").show();
						$("#projectName").html(msg);
					}
				});*/
			}else 
			if($("#inputTask").val().match(/\<.*/)){
				$.ajax({
					type	: 'post',
					url		: 'views/window_userAuto.php',
					data	: 'usr='+$("#inputTask").val().match(/\<.*/),
					success	: function(msg){
						$("#projectName").show();
						$("#projectName").html(msg);
					}
				});
			}else{
				$("#projectName").hide();
			}
		}else{
			$("#projectName").hide();
		}
	});
	var usr = '';
	var tsk = '';
	
	$("#prosentaseTask").blur(function(){
		valid(this,'numbers');
	}).keyup(function(){
		valid(this,'numbers');
	});
});

function datePick(){ 
	$("#taskCal").focus();
}

function addTask(tsk){
	inputTask = $("#inputTask").val().replace($("#inputTask").val().match(/\[.*/), "")+'['+tsk+'] ';
	$("#inputTask").val(inputTask.replace($("#inputTask").val().match(/\#.*/), ""));
	$("#inputTask").focus();
	$("#projectName").hide();
}

function addUsr(usr){
	inputTask = $("#inputTask").val().replace($("#inputTask").val().match(/\@.*/), "")+'<'+usr+'> ';
	$("#inputTask").val(inputTask.replace($("#inputTask").val().match(/\<.*/), ""));
	$("#inputTask").val($("#inputTask").val().replace("><", ","));
	$("#inputTask").val($("#inputTask").val().replace("> <", ","));
	$("#inputTask").focus();
	$("#projectName").hide();
}

function showTime() {
   myDate = new Date();
   
   day		= myDate.getDate();
   month	= myDate.getMonth()+1;
   year		= myDate.getFullYear();   
   hours	= myDate.getHours();
   minutes	= myDate.getMinutes();
   seconds	= myDate.getSeconds();
   
   // tampilan
   if (hours < 10)   hours   = "0" + hours;
   if (minutes < 10) minutes = "0" + minutes;
   if (seconds < 10) seconds = "0" + seconds;
   
   // hasilnya
   //target = year+"-"+month+"-"+day+" "+hours+":"+minutes+":"+seconds;
   target = year+"-"+month+"-"+day+" 17:00:00";
   $("#inputTask").val($("#inputTask").val().replace("=", "")+'('+target+') ');
}
</script>
<style>
.divAuto{
	background:#fff;
	border: 1px solid #ccc;
	position:absolute;
	display:block;
	max-height:100px;
	height:auto !important;
	height:30px;
	overflow:auto;
	padding:3px;
	word-wrap: break-word;
}
</style>
<div id = "windowInputTask" class="window" style="display:none;" align="left"> 
	<form name="frmWindowInputTask" id="frmWindowInputTask" method="post" >
		<blockquote><i>ketik `[` atau `#` untuk autosuggest nama project<br />
		ketik `@` untuk autosuggest nama team<br />
		ketik `=` untuk memasukkan tanggal target</i></blockquote>
		<br />
		<table>
		  <tr valign="top">
			<td> Isikan task anda </td>
			<td> : </td>
			<td><textarea name="inputTask" id="inputTask" class="validate[required,custom[noSpecialCaracters],length[3,150]]" cols="50"></textarea>
			<div id="projectName" class="divAuto">
			</div>
			</td>
		  </tr>
		  <tr valign="top">
			<td> Prosentase Task </td>
			<td> : </td>
			<td><input name="prosentaseTask" id="prosentaseTask" type="text" class="validate[required,custom[onlyNumber],length[1,3]] text-input"  style="width:50px;">
			  % </td>
		  </tr>
		  <tr valign="top" style="display:none;">
			<td> Prioritas Task </td>
			<td> : </td>
			<td><input name="priorityTask" id="priorityTask" type="text"  class="validate[required,custom[onlyNumber] text-input"  style="width:50px;" value='1'>
			</td>
		  </tr>
		 <tr valign="top">
			<td colspan="2"></td> 
			<td><input name="submitTask" type="submit" class="btn" value="submit" id="submitTask"></td>
		  </tr>
		</table>
	</form>
</div>
