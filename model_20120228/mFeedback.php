<?php
class MFeedback{

    private $registry;
    public function __construct($registry){
      $this->registry = $registry;
    }
	public function time_since($original) {
	
		$original = strtotime($original);
		
		$phitdate = array(
			array(60 * 60 * 24 * 365 , 'year'),
			array(60 * 60 * 24 * 30 , 'month'),
			array(60 * 60 * 24 * 7, 'week'),
			array(60 * 60 * 24 , 'day'),
			array(60 * 60 , 'hour'),
			array(60 , 'minute'),
		);
		
		$today = time();
		$since = $today - $original;
		
		if($since < 5){
			$print='a few seconds';
		}else{
			for ($i = 0, $j = count($phitdate); $i < $j; $i++) {
			
				$seconds = $phitdate[$i][0];
				$name = $phitdate[$i][1];
				
				// cek
				if (($count = floor($since / $seconds)) != 0) {
					break;
				}
			}
			
			if($count == 0) $print='a few seconds';
			elseif($count == 1) $print = '1 '.$name.'s';
			else $print =  "$count {$name}s";
			
			if ($i + 1 < $j) {
			// detik
				$seconds2 = $phitdate[$i + 1][0];
				$name2 = $phitdate[$i + 1][1];
				
				// jika detik lebih dari 0
				if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) {
					$print .= ($count2 == 1) ? ', 1 '.$name2 : " and $count2 {$name2}s";
				}
			}
		}
		return $print.' ago';
		// create by PHITIAS
	}

	function get_feedback($fbid = NULL){
		$data = array();
		$query = "SELECT * FROM feedback WHERE feedback_id = '".$fbid."' "; 
	
		$rs = $this->registry->db->Execute($query);
		
		if($rs){
          if($rs->RecordCount() > 0){		  
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data feedback');
        
        return $data;
	
	}
	function shortAlineaFb($string, $length = '',  $start = 75) { 
		if (strlen($string) <= $start) return $string; 
		if ($length) { 
			return substr_replace($string, $start, $length); 
		} else { 
			return substr_replace($string, '', $start); 
		} 
	}
	
}
?>
