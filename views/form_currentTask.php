<h3>Task List</h3>
<table id="taskList">
<?php
if(count($tasklisttop5) > 0){
	$i=0;
	foreach($tasklisttop5 as $row){ 
		if($row->STATUS < 100){	
		?>
			<tr valign="top">
				<td class="vtip" title="<?php echo $row->TASK.' : '.$row->STATUS.' % ('.$row->TARGET.')'; ?>">
					<?php echo $this->registry->mKnowledge->shortAlinea($row->TASK,'','... ', 40); ?><br/>
					<img src='includes/img/poll.gif' width="<?php echo $row->STATUS*2.5; ?>" height=13>
					<div class="procentTask"><?php echo $row->STATUS; ?> % </div>
					</td>
			</tr>
		<?php
			if(++$i == 5 ) break;
		}
	}
}else{
?>
	<tr>
		<td>Anda tidak mempunyai task</td>
	</tr>
<?php  } ?>
</table>
<a href="index.php?mod=attendance" class="merahBold">+ more</a>