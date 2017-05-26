<h3>All Knowledge</h3>
<ul>
<?php
$data = $this->registry->mCategoryList->selectCategoryList(NULL,NULL);
foreach($data as $category){
	$nama = $category->CAT_NAME;
	$idcat = $category->NC_ID;
			
	$jumlah = $this->registry->mKnowledge->jumlahCategory($idcat);
		if($this->registry->mUser->isLoggedOn()==TRUE && $category->NC_ID == 5){
			echo "<li><a href=\"index.php?mod=knowledge/category/$idcat\" title=\"$nama\">$nama($jumlah)</a></li>";	
		}elseif($category->NC_ID != 5){
			echo "<li><a href=\"index.php?mod=knowledge/category/$idcat\" title=\"$nama\">$nama($jumlah)</a></li>";		
		}
	}
?>
</ul>