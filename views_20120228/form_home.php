<script type="text/javascript">
$(function() {
	
	var url = location.href.split('?');
	if(url[1] == null){
		//url =  url[1].split('/');
		//if(url[0] != 'mod=profile'){
			setInterval(function() {  
				$("#left_side").load(location.href+" #left_side>*","");	
			}, 300000);
		//}
	}
	
	$('#frmStatus').submit(function(e){
	
		//submitUpdate();
		if($("#tstatus").val()==''){
			alert("Ding....?");
			return false;
		}else{
			var submitData = $('#frmStatus').serialize();
			$("#flash").show();
			$("#flash").fadeIn(400).html('<img src="includes/img/loading.gif" height="20>');
			$.ajax({
				type: "POST",
				url: "index.php?mod=index/saveStatus",
				data: submitData,
				dataType: "html",
				success: function(msg){
					$("#flash").hide();
					document.getElementById("tstatus").value='';
					document.getElementById("tstatus").focus();
					$("ol.mpart li:first-child").before(msg);
					$("ol.mpart:empty").append(msg);
					$("ol.mpart li:first").slideDown("slow");
					//$("#left_side").load(location.href+" #left_side>*","");
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					alert("error:" +XMLHttpRequest);	
					alert("error:" +textStatus);	
					alert("error:" +errorThrown);
				}
				
			});
			e.preventDefault();
		}
	});
	
	// Delete Wall Update
	
	$('.delete_wall').live("click",function() {
		var data = $(this).attr("id");
		var dataString = 'data='+ data;
		
		if(confirm("Hapus postingan ini?")) {
			$("#loader"+data).show();
			$("#loader"+data).fadeIn(400).html('<img src="includes/img/loading.gif" height="20>');
			
			$.ajax({
				type: "POST",
				url: "index.php?mod=index/deleteStatus",
				data: dataString,
				dataType: "html",
				success: function(html){			
					$("li."+data).slideUp();
					$("#loader"+data).hide();
					$("#left_side").load(location.href+" #left_side>*","");			
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					alert("error:" +XMLHttpRequest);	
					alert("error:" +textStatus);	
					alert("error:" +errorThrown);	
				}
			});
			
		}
		return false;
		
	});
	
	//slide down textarea comment
	$('.comment').live("click",function() {
		var element = $(this);
		var I = element.attr("id");
		$("#slidepanel"+I).slideToggle(300);
		$(this).toggleClass("active");
		$("#textboxcontent"+I).focus();
		return false;
	});
	
	
	//Wall commment Submit
	$('.comment_submit').live("click",function() {
		var element = $(this);
		var Id = element.attr("id");
		var txt = document.getElementById("textboxcontent"+Id).value;
		var dataString = 'textcontent='+ txt + '&com_msgid=' + Id;
			
		
		if(txt==''){
			alert("Ding...?");
		}else{
			$(".flash"+Id).show();
			$(".flash"+Id).fadeIn(400).html('<img src="includes/img/loading.gif" height="20>');
			$.ajax({
				type: "POST",
				url: "index.php?mod=index/commentStatus",
				data: dataString,
				cache: false,
				success: function(html){
				  	$(".loadplace"+Id).append(html);
					$(".flash"+Id).hide();
					document.getElementById("textboxcontent"+Id).value="";
					//$("#left_side").load(location.href+" #left_side>*","");
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					alert("error:" +XMLHttpRequest);	
					alert("error:" +textStatus);	
					alert("error:" +errorThrown);	
				}
			 });
		}
		
		return false;
	});
	
	
	//Wall comment delete	
	$('.cdelete_update').live("click",function() 	{
		var ID = $(this).attr("id");		
		var dataString = 'com_id='+ ID;		
		if(confirm("Hapus comment ini?")){
			$.ajax({
				type: "POST",
				url: "index.php?mod=index/deleteComment",
				data: dataString,
				cache: false,
				success: function(html){				 
					$("#comment"+ID).slideUp();
					$("#left_side").load(location.href+" #left_side>*","");
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					alert("error:" +XMLHttpRequest);	
					alert("error:" +textStatus);	
					alert("error:" +errorThrown);		
				}
			});
		
		}
		return false;
		
	});

	$("#wallPrevious").click(function(){
		$(".loaderPrevWall").fadeIn(400).html('<img src="includes/img/loading.gif" height="20">');	
		//var isClick = 0; 			
		var limitfrom = 0;
		//var limitto = 5;
		
		limitfrom = parseInt($("#limitfrom").val())+1;
		$("#limitfrom").val(limitfrom+5);
		/*if(limitfrom > 16){
			limitfrom = limitfrom+5;
		}
		
		if(isClick == 0){
			limitfrom = $("#limitfrom").val()+1;
		}else{
			limitfrom = limitto+1;
		}
		
			isClick++; */
		//alert($('ol.mpart li:last-child').length);
		var dataString = 'limitfrom='+limitfrom;//+'&limitto='+limitto;
		//alert(dataString);
		$.ajax({
			type: "POST",
			url: "index.php?mod=index/previousWall",
			data: dataString,
			cache: false,
			success: function(msg){				 
				$(".loaderPrevWall").hide();
				$('ol.mpart li:last-child').html($(msg));
				/*$("ol.mpart li:last-child").after(msg);
				$("ol.mpart:empty").append(msg);
				$("ol.mpart li:last").slideDown("slow");*/
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				alert("error:" +XMLHttpRequest);	
				alert("error:" +textStatus);	
				alert("error:" +errorThrown);		
			}
		});
	})
	
});
</script>

<form name="frmStatus" id="frmStatus">
  <span class="loader"></span>
  <div class="wrapTstatus">
    <textarea cols="30" name="tstatus" id="tstatus"></textarea>
    <input type="submit"  value="Tampilkan"  id="btnstatus" name="submit" class="btn" />
    <div class="clear"></div>
  </div>
</form>
<div style="height:7px">
  <div id="flash" align="left"></div>
</div>
<ol class="mpart">
  <?php	
if(count($dataUnion) > 0):
	foreach($dataUnion as $data):
		if($data->CONTENT != NULL){	?>
  <li class="<?php echo $data->IDENTITY.'-'.$data->ID; ?>" style="padding-top:10px;"> 
  	<img width="65" height="65" src="includes/img/photo/<?php echo $data->PHOTO; ?>"/>
    <div style="padding-left: 77px;"> 
    	<a href="#" onclick="return false;"><?php echo ucfirst($data->NAME); ?></a>
      <?php
		if(($data->IDENTITY!= "attendance_in") && ($data->IDENTITY!= "attendance_out")&&($data->IDENTITY!= "attendance_summary")&&
			($data->IDENTITY!= "attendance_leave")&&($data->IDENTITY!= "attendance_back") &&($data->IDENTITY!= "knowledge")){
			
			if($data->USERID == $_SESSION['userid']){
				?>
				<div id="loader<?php echo $data->IDENTITY.'-'.$data->ID; ?>"></div>
				<a href="#"  style="float:right;" id="<?php echo $data->IDENTITY.'-'.$data->ID; ?>" class="delete_wall">x</a>
				<?php	
			}
		}
		
		if($data->IDENTITY == 'knowledge'){?>
      <h2><?php echo $data->TITLE; ?></h2>
      <p><?php echo $this->registry->mKnowledge->shortAlinea($data->CONTENT,'','<br><a href="index.php?mod=knowledge/detail/'.$data->CAT_ID.'/'.$data->ID.'"> Selengkapnya...</a>'); ?></p>
      
	  <?php 	
		}else{ ?>
      <p><?php echo $data->CONTENT; ?></p>
      <?php 
		}
		
		$datawall = $this->registry->mComment->selectDB_comment($data->ID, $data->IDENTITY); 
         ?>
      <div class="date">
        <h3 style="float:left;"> 
			<?php echo $this->registry->mTask->time_since($data->TANGGAL); ?> in 
        	<a href="#" onclick="return false;"><?php echo $data->IDENTITY; ?></a> 
        </h3>
        <h3>
        <a href="#" class="comment" id="<?php echo $data->IDENTITY.'-'.$data->ID; ?>">comments (<?php echo count($datawall);?>)</a>
        </h3>
        <div class="clear"></div>
      </div>
      <div class="loadplace<?php echo $data->IDENTITY.'-'.$data->ID; ?>">
        <?php 
			if(count($datawall) > 0){
				foreach($datawall as $wall){
					echo '<div class="comment_load" id="comment'.$data->IDENTITY.'-'.$wall->COMMENT_ID.'">';
					echo '<img width="50" height="50" src="includes/img/photo/'.$wall->PHOTO.'"/>';
					echo '<a href="#">'.$wall->NAME.'</a> '.$wall->CONTENT;
					if($wall->USER_ID == $_SESSION['userid']){
						echo '<a href="#" id="'.$data->IDENTITY.'-'.$wall->COMMENT_ID.'" class="cdelete_update"  style="float:right;" >x</a><br>';
					}
					 
					echo '<h3>'.$this->registry->mTask->time_since($wall->INPUT_DTM).'</h3>';
					echo '</div>';
				}	
			}
		?>
      </div>
      <div class="flash<?php echo $data->IDENTITY.'-'.$data->ID; ?>"></div>
      <div class='panel' id="slidepanel<?php echo $data->IDENTITY.'-'.$data->ID; ?>">
        <form method="post" name="<?php echo $data->IDENTITY.'-'.$data->ID; ?>" class="frmComment">
      	<div class="wrapTstatus">
          <textarea id="textboxcontent<?php echo $data->IDENTITY.'-'.$data->ID; ?>" class="comment_txt"></textarea>
          <input type="submit" value="Comment" class="comment_submit btn" id="<?php echo $data->IDENTITY.'-'.$data->ID; ?>"/>
          <div class="clear"></div>
  		 </div>
       </form>
      </div>
    </div> 
  </li>
  <?php
		}
	endforeach;
endif;
	?>
</ol>
<br />
<input type="hidden" id="limitfrom" value="15" />
<div id="wallPrevious">Lihat Sebelumnya <font size="+2">&crarr;</font> <span class="loaderPrevWall" style="float:right"></span></div>
