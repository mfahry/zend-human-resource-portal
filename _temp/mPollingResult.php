<?php
class MPollingResult{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
    }


	function insertDB_pollingResult($poll_id, $pollc_id, $user_id, $ip){
		$query = "INSERT INTO polling_result(polling_id, pollc_id, user_id, ip_address, start_dtm)
					VALUES(".$poll_id.",'".$pollc_id."', '".$user_id."', '".$ip."', now())";
		$rs = $this->conn->Execute($query);
	}

}
?>