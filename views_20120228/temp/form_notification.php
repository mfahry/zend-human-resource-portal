<?php
$dataRec0 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_recommendation',0);

$dataRec2 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_id',2);
$dataReject = NULL;
if(count($dataRec2)>0){ 
	foreach($dataRec2 as $reject){
		$dataReject 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_id',3, $reject->CALENDAR_ID, '', $reject->ABSENTYPE_ID, 'user_recommendation');
	}
}
if(count($dataReject) < 2)
	$dataRec2 	= $dataRec2;
elseif(count($dataReject) >= 2)
	$dataRec2 = NULL;
	
$dataRec3 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_id',1,'','no', '');
$calid		= $this->registry->mCalendar->select_calendarID(date('d'), date('m'), date('Y'));
$dataLembur	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_id',NULL,$calid,'yes',8);
$notification = $this->registry->mComment->get_notification();
 
if((count($dataRec0)>0)||(count($dataRec2)>0)||(count($dataRec3)>=2) || (count($dataLembur) > 0) || (count($notification) > 0)){
?>

<!-- Link script ditaruh disini biar cuma dipanggil klo ada data rekomendasi saja, jadi load webnya ga berat -->
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/skins/dhtmlxwindows_dhx_skyblue.css">
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcommon.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcontainer.js"></script>
<script src="includes/js/createWindowNotif.js"></script>
<div class="dynamic">
  <h3 class="notif">Notifikasi</h3>
  <ul>
    <?php 
	if(count($dataRec0)>0){ 
		$dataRec0 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_recommendation',0, '', '', '', 'calendar_id');
	?>
    <li>
    	
		<script>
        $(function(){			
             $("#gotRecommend").toggle(function() {
                    $(".right_side #gotRecommendContainer").slideDown('slow'); 
                },function(){
                    $(".right_side #gotRecommendContainer").slideUp('slow'); 	
            });
            
            $(document).mouseup(function(e) {
                if($(e.target).parent("#gotRecommend").length==0) {
                    $(".right_side #gotRecommendContainer").slideUp('slow'); 	
                }
            });	
        })
        </script>
        <a href="#" id="gotRecommend">
    	Anda mendapat rekomendasi absen (<?php echo count($dataRec0);?>)</a>
    
    	
          <div id="gotRecommendContainer" class="notifContainer">
            <ol>
              <?php foreach($dataRec0 as $gotRecommend){ ?>
              <li class="gotRecommendLi" id="<?php echo $gotRecommend->CALENDAR_ID.'_'.$gotRecommend->USER_ID.'_'.$gotRecommend->ABSENTYPE_ID; ?>">
              <a href="#"> 
                <b><?php echo $this->registry->mUser->get_fullname($gotRecommend->USER_ID); ?></b> 
                meminta rekomendasi absen <b><?php echo $this->registry->mAbsenType->selectDB_typeAbsen($gotRecommend->ABSENTYPE_ID); ?></b>
                tgl <b><?php echo $this->registry->mCalendar->select_calendarID("", "", "", $gotRecommend->CALENDAR_ID, 1); ?></b>
                </a></li>
              <?php } ?>
            </ol>
          </div>
    </li>
    <?php 
		$this->registry->view->show('window_alertRecommendation');
	}
	
	if(count($dataRec2)>0){ 
		$dataRec2 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_id',2, '', '', '', 'calendar_id');		
	?>
    <li>
		<script>
        $(function(){			
             $("#notifReject").toggle(function() {
                    $(".right_side #rejectContainer").slideDown('slow'); 
                },function(){
                    $(".right_side #rejectContainer").slideUp('slow'); 	
            });
            
            $(document).mouseup(function(e) {
                if($(e.target).parent("#notifReject").length==0) {
                    $(".right_side #rejectContainer").slideUp('slow'); 	
                }
            });	
        })
        </script>
        
        <a href="#" id="notifReject">
    	Rekomendasi absen anda telah ditolak (<?php echo count($dataRec2);?>)</a>
    	
        
          <div id="rejectContainer" class="notifContainer">
            <ol>
              <?php foreach($dataRec2 as $reject){ ?>
              <li class="rejectLi" id="<?php echo $reject->CALENDAR_ID.'_'.$reject->USER_ID.'_'.$reject->ABSENTYPE_ID; ?>">
              <a href="#"> 
                <b><?php echo $this->registry->mUser->get_fullname($reject->USER_RECOMMENDATION); ?></b> menolak rekomendasi absen 
                <b><?php echo $this->registry->mAbsenType->selectDB_typeAbsen($reject->ABSENTYPE_ID); ?></b> anda 
                tgl <b><?php echo $this->registry->mCalendar->select_calendarID("", "", "", $reject->CALENDAR_ID, 1); ?></b>
                </a></li>
              <?php } ?>
            </ol>
          </div>
    </li>
    <?php 
		$this->registry->view->show('window_alertRecommendationReject');
	}
	
	if(count($dataRec3)>=2){ 
		$dataRec3 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_id',1,'','no', '', 'calendar_id');
	?>
    <li>
		<script>
        $(function(){			
             $("#notifApprove").toggle(function() {
                    $(".right_side #approveContainer").slideDown('slow'); 
                },function(){
                    $(".right_side #approveContainer").slideUp('slow'); 	
            });
            
            $(document).mouseup(function(e) {
                if($(e.target).parent("#notifApprove").length==0) {
                    $(".right_side #approveContainer").slideUp('slow'); 	
                }
            });	
        })
        </script>
        
        <a href="#" id="notifApprove">
        Rekomendasi absen anda telah disetujui (<?php echo count($dataRec3);?>)</a>
            
            
          <div id="approveContainer" class="notifContainer">
            <ol>
              <?php foreach($dataRec3 as $approve){ ?>
              <li class="approveLi" id="<?php echo $approve->CALENDAR_ID.'_'.$approve->USER_ID.'_'.$approve->ABSENTYPE_ID; ?>">
              <a href="#"> 
                Rekomendasi absen <b><?php echo $this->registry->mAbsenType->selectDB_typeAbsen($approve->ABSENTYPE_ID); ?></b>, 
                tgl <b><?php echo $this->registry->mCalendar->select_calendarID("", "", "", $approve->CALENDAR_ID, 1); ?></b>
                anda telah disetujui
                </a></li>
              <?php } ?>
            </ol>
          </div>
    </li>
    <?php 
		$this->registry->view->show('window_alertRecommendationAprove');
	} 
	
	if(count($dataLembur) > 0){ ?>
    	<li>Hari ini anda lembur</li>
    <?php 
	}  
	
	if(count($notification) > 0){ ?>
    <li> 
    	<script>
		$(function(){			
			 $("#notifComment").toggle(function() {
					$(".right_side #commentContainer").show(); 
				},function(){
					$(".right_side #commentContainer").hide(); 	
							
			});
		 
			
			$(document).mouseup(function(e) {
				if($(e.target).parent(".notifComment").length==0) {
					$(".right_side #commentContainer").hide(); 	
				}
			});	
		})
		</script>
        <a id="notifComment" href="#" onClick="return false">
    	Anda mendapat komentar(<?php echo count($notification); ?>)</a>
        
      <div id="commentContainer" class="notifContainer">
        <ol>
          <?php foreach($notification as $komen){ ?>
          <li><a href="index.php?mod=index/notifComment/<?php echo $komen->IDENTIFIER; ?>/<?php echo $komen->PARENT_ID; ?>/<?php echo $komen->COMMENT_ID; ?>">
          	<b><?php echo $komen->NAME; ?></b> komentar di <b><?php echo $komen->IDENTIFIER; ?></b> </a></li>
          <?php } ?>
        </ol>
      </div>
      
    </li>
<?php } ?>
  </ul>
</div> 
<?php 	 
} 
?>
