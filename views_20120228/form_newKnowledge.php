<h3 style="">Recent Knowledge</h3>
<ul>
<?php
$newKnowledge = $this->registry->mKnowledge->get_newKnowledge();
if(count($newKnowledge) > 0){
	foreach($newKnowledge as $row){	
		if($this->registry->mUser->isLoggedOn()==TRUE && $row->CAT_ID == 5){
	?>			
        <li class="thumb">
        	<div class="thumb" style="float:left; margin:0px 8px 2px 0px; position:static;">
			<img width="65" height="65" src="includes/img/photo/<?php echo $row->PHOTO; ?>" title="<?php echo $row->UNAME; ?>" class="vtip"/> 
            </div>
            <div style="color:#A5A5A5; font-size:10px;"><?php echo $row->DATE; ?> 
            <a href="index.php?mod=knowledge/category/<?php echo $row->CAT_ID; ?>"><?php echo $row->CAT_NAME; ?></a></div>
            <div class="title_knowledge">
			<a style="color:#CC3300;" href="index.php?mod=knowledge/detail/<?php echo $row->CAT_ID; ?>/<?php echo $row->KNOWLEDGE_ID; ?>"><?php echo $row->JUDUL; ?></a>
            </div>
        </li>
<?php
		}elseif($row->CAT_ID != 5){
	?>			
        <li class="thumb">
        	<div class="thumb" style="float:left; margin:0px 8px 2px 0px; position:static;">
			<img width="65" height="65" src="includes/img/photo/<?php echo $row->PHOTO; ?>" title="<?php echo $row->UNAME; ?>" class="vtip"/> 
            </div>
            <div style="color:#A5A5A5; font-size:10px;"><?php echo $row->DATE; ?> 
            <a href="index.php?mod=knowledge/category/<?php echo $row->CAT_ID; ?>"><?php echo $row->CAT_NAME; ?></a></div>
            <div class="title_knowledge">
			<a style="color:#CC3300;" href="index.php?mod=knowledge/detail/<?php echo $row->CAT_ID; ?>/<?php echo $row->KNOWLEDGE_ID; ?>"><?php echo $row->JUDUL; ?></a>
            </div>
        </li>
<?php
		}
	}
}
?>
</ul> 