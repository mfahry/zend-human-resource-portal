<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/slider.slick.css" />
<script type="text/javascript" src="includes/JQuery/jquery-ui-1.7.1.custom.min.js"></script>
<script type="text/javascript" src="includes/JQuery/script/slider.slick.pngFix.js"></script>
<script type="text/javascript" src="includes/JQuery/script/slider.slick.mop.js"></script>
<script>
$(document).ready(function(){
	
	$("#slider").mopSlider({
		'w':800,
		'h':122,
		'sldW':500,
		'btnW':200,
		'itemMgn':20,
		'indi':"&Phi;",
		'type':'tutorialzine', //black / paper / 
		'shuffle':0
	});
	
});
</script>
<div class="clear"></div>

<div class="containerSlider">
  <div id="slider">
    <?php 
foreach($newKnowledge as $row) { 
		if($this->registry->mUser->isLoggedOn()==TRUE && $row->CAT_ID == 5){?>
    <div class="product">
      <div class="thumb"> <img width="90" height="90" src="includes/img/photo/<?php echo $row->PHOTO; ?>"  title="<?php echo $row->UNAME; ?>" class="vtip" /> </div>
      <div style="color:#A5A5A5; font-size:10px;"><?php echo $row->DATE; ?> 
      <a href="index.php?mod=knowledge/category/<?php echo $row->CAT_ID; ?>" style="color:#74797E;"><?php echo $row->CAT_NAME; ?></a> </div>
      <div class="title_knowledge"> <a href="index.php?mod=knowledge/detail/<?php echo $row->CAT_ID; ?>/<?php echo $row->KNOWLEDGE_ID; ?>"><?php echo $row->JUDUL; ?></a> </div>
     </div>
    <?php } elseif($row->CAT_ID != 5){?>
    <div class="product">
      <div class="thumb"> <img width="90" height="90" src="includes/img/photo/<?php echo $row->PHOTO; ?>"  title="<?php echo $row->UNAME; ?>" class="vtip" /> </div>
      <div style="color:#A5A5A5; font-size:10px;"><?php echo $row->DATE; ?> 
      <a href="index.php?mod=knowledge/category/<?php echo $row->CAT_ID; ?>" style="color:#74797E;"><?php echo $row->CAT_NAME; ?></a> </div>
      <div class="title_knowledge"> <a href="index.php?mod=knowledge/detail/<?php echo $row->CAT_ID; ?>/<?php echo $row->KNOWLEDGE_ID; ?>"><?php echo $row->JUDUL; ?></a> </div>
     </div>
    <?php
	}
}?>
  </div>
</div>
<div class="clear"></div>
</div>
