<?php
class MCalendar{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
	}

	function monthname($month){
		switch($month){
			case 1		: $monthNM='Januari';break;
			case 2		: $monthNM='Februari';break;
			case 3		: $monthNM='Maret';break;
			case 4		: $monthNM='April';break;
			case 5		: $monthNM='Mei';break;
			case 6		: $monthNM='Juni';break;
			case 7		: $monthNM='Juli';break;
			case 8		: $monthNM='Agustus';break;
			case 9		: $monthNM='September';	break;
			case 10		: $monthNM='Oktober';break;
			case 11		: $monthNM='November';break;
			case 12		: $monthNM='Desember';break;
		}
		//echo $month;
		return $monthNM;
	}

	function selectDateStatus($tgl, $bulan, $tahun){
    	$query = "SELECT max( calendar_id ) as calendar_id FROM calendar WHERE calendar_id < ( SELECT calendar_id FROM calendar WHERE ( date =? AND MONTH =? AND year =? ) ) AND STATUS =1 ";
        $data = array();
    	$stmt = $this->registry->db->Prepare($query);
    	$arrBinding[0] = $tgl;
    	$arrBinding[1] = $bulan;
    	$arrBinding[2] = $tahun;

    	//echo "<br>*selectDateStatus:".$query."<br>#".$tgl." #".$bulan."# ".$tahun;
    	$rs = $this->registry->db->Execute($stmt,$arrBinding);
		if($rs){
		
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
			
          }//else throw new Exception('Data Calendar kosong');
        }else throw new Exception('Gagal mengambil data calendar');

        return $data;
	}

	function selectDateStatusYesterday($tgl, $bulan, $tahun){
    	$query = "SELECT * FROM calendar
                WHERE calendar_id = (
                  SELECT max( calendar_id ) as calendar_id
                  FROM calendar WHERE calendar_id < (
                      SELECT calendar_id FROM calendar
                      WHERE ( date =? AND MONTH =? AND year =? ))
                  AND STATUS =1 )";

    	$stmt = $this->registry->db->Prepare($query);
    	$arrBinding[0] = $tgl;
    	$arrBinding[1] = $bulan;
    	$arrBinding[2] = $tahun;

    	//echo "<br>*selectDateStatus:".$query."<br>";
    	$rs = $this->registry->db->Execute($stmt,$arrBinding);
    	if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;

            }
          }else{
            $data = 'Data news_category kosong';
          }
        }else{
          $data = 'Gagal mengambil data news_category';
        }
		return $data;
	}


	function selectCalId($cal_id = NULL, $date1 = NULL, $date2 = NULL, $month = NULL, $year = NULL){
    	$query = " SELECT * FROM calendar WHERE ";
		$data = array();
    	if($cal_id != NULL){
    		$query .= "calendar_id = ?";
    		$stmt = $this->registry->db->Prepare($query);
    		$arrBinding[0] = $cal_id;
    	}

    	if(($month == NULL) && ($year != NULL)){
    		$query .= "year = ?";
    		$stmt = $this->registry->db->Prepare($query);
    		$arrBinding[0] = $year ;
    	}elseif(($date1 == NULL) && ($date2 == NULL) && ($month != NULL) && ($year != NULL)){
    		$query .= "month = ? AND year = ?";
    		$stmt = $this->registry->db->Prepare($query);
    		$arrBinding[0] = $month;
    		$arrBinding[1] = $year;
    	}elseif(($date1 != NULL) && ($date2 == NULL) && ($month != NULL) && ($year != NULL)){
    		$query .= "date = ? AND month = ? AND year = ?";
    		$stmt = $this->registry->db->Prepare($query);
    		$arrBinding[0] = $date1;
    		$arrBinding[1] = $month;
    		$arrBinding[2] = $year;
    	}
		
    	if(($date1 != NULL) && ($date2 != NULL) && ($month != NULL) && ($year != NULL)){
    		$query .= "date BETWEEN ? AND ? AND month = ? AND year = ?";
    		$stmt = $this->registry->db->Prepare($query);
    		$arrBinding[0] = $date1;
    		$arrBinding[1] = $date2;
    		$arrBinding[2] = $month;
    		$arrBinding[3] = $year;
    	}elseif(($date1 != NULL) && ($date2 != NULL) && ($month != NULL) && ($year == NULL)){
    		$query .= "date BETWEEN ? AND ? AND month = ?";
    		$stmt = $this->registry->db->Prepare($query);
    		$arrBinding[0] = $date1;
    		$arrBinding[1] = $date2;
    		$arrBinding[2] = $month; 
    	}
    	//echo $query." ".$date1." ".$date2." ".$year." ".$month."<br>";
    	$rs = $this->registry->db->Execute($stmt,$arrBinding);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }//else throw new Exception('Data Calendar kosong');
        }else throw new Exception('Gagal mengambil data Calender');

        return $data;
	}

	function select_calendarID($tgl = NULL, $bulan = NULL, $tahun = NULL, $calID = NULL, $getFullDate = NULL, $status = NULL, $desc = NULL){
    	# kalau mau calendar id nya saja berdasarkan $tgl, $bln dan $thn , isi parameter $tgl, $bln dan $thn saja. yang lain NULL -- select_calendarID($tgl, $bln, $thn)
    	# kalau mau dapetin semua field berdasarkan calendar id, isi parameter $calID saja. yg lain NULL -- select_calendarID("", "", "", $calID)
    	# kalau mau dapetin fulldate berdasarkan calendar id(return "tgl-bln-thn"), isi parameter $calID dan $getFullDate = 1. yg lain NULL -- select_calendarID("", "", "", $calID, 1)
    	$id = array();
		$query = "SELECT * FROM calendar b ";
	
    	if(($tgl != NULL) && ($bulan != NULL) && ($tahun != NULL) && ($calID == NULL) && ($getFullDate == NULL)){
    		$query .= "WHERE b.date=? AND b.month=? AND b.year=?;";
			//echo $query."<br> $tgl, $bulan, $tahun";

    		$stmt = $this->registry->db->Prepare($query);
    		$arrBinding[0] = $tgl;
    		$arrBinding[1] = $bulan;
    		$arrBinding[2] = $tahun;

    		$rs = $this->registry->db->Execute($stmt,$arrBinding);

    		while($data = $rs->FetchNextObject()){
    			$id=$data->CALENDAR_ID;
    		}

    		if($id == NULL) return 0;
    		else			return $id;
    	}else{
    		if(($calID != NULL) && ($tgl == NULL) && ($bulan == NULL) && ($tahun == NULL))
    			$query .= "WHERE calendar_id = ".$calID;
			//echo $query."<br> $tgl, $bulan, $tahun";

    		if($status != NULL){
    			$rs = $this->registry->db->Execute($query);
    			while($data = $rs->FetchNextObject()){
    				$stat = $data->STATUS;
    			}

    			return $stat;
    		}
    		if($getFullDate != NULL){
    			$rs = $this->registry->db->Execute($query);
    			while($data = $rs->FetchNextObject()){
    				$tgl = $data->DATE;
    				$bln = $data->MONTH;
    				$thn = $data->YEAR;
    			}
    			return $tgl."-".$bln."-".$thn;
    		}else{
    			if($desc != NULL){
    				$rs = $this->registry->db->Execute($query);
    				while($data = $rs->FetchNextObject()){
    					$desc = $data->DESC;
    				}
    				return $desc;
    			}else{
    				$rs = $this->registry->db->Execute($query);
    				if($rs){
					  if($rs->RecordCount() > 0){
						while($row = $rs->FetchNextObject()){
						  $data[] = $row;

						}
					  }else throw new Exception('Data kosong');
					}else throw new Exception('Gagal mengambil data');

					return $data;
    			}
    		}
    	}
	}
 	
	public function get_calendarID($d, $m, $y){
		$data = NULL;
		$query = "SELECT calendar_id FROM calendar WHERE date = ".$d." AND month = ".$m." AND year = ".$y;
    	$rs = $this->registry->db->Execute($query);
		//echo $query;
    	if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data = $row->CALENDAR_ID;

            }
          }
        }else throw new Exception('Gagal mengambil data get_calendarID');
		return $data;
		
	}

	function cekMaxCalendarOut($tgl, $bulan, $tahun, $userid = NULL) {
		$data = array();
    	$query = "  SELECT max( b.calendar_id ) AS calendar_id, a.date, a.month, a.year, c.*, b.absensiharian_id, d.type_name
    				FROM calendar a JOIN absensiharian b ON a.calendar_id = b.calendar_id
    				JOIN absensiout c ON b.absensiharian_id = c.absensiharian_id
					JOIN absen_type d ON c.out_type = d.type_id
    				WHERE a.calendar_id < ( SELECT calendar_id FROM calendar WHERE ( date =? AND MONTH =? AND year =? ) )
    				AND a.status =1 AND ( c.out_timeend IS NULL OR c.out_timeend = '00:00:00' )";
    	if(!empty($userid)){
    	$query = $query." AND b.user_id=?";
    	}

    	$query = $query." GROUP BY b.calendar_id";

    	$stmt = $this->registry->db->Prepare($query);
    	$arrBinding[0] = $tgl;
    	$arrBinding[1] = $bulan;
    	$arrBinding[2] = $tahun;

    	if(!empty($userid)){
    		$arrBinding[3] = $userid;
    	}
    	$rs = $this->registry->db->Execute($stmt,$arrBinding);
    	if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;

            }
          }
        }else throw new Exception('Gagal mengambil data cekMaxCalendarOut');
    	//echo $query."<br>*********tgl: ".$tgl." ## ".$bulan." ## ".$tahun." ## ".$userid." ...";

		return $data;
	}

	function selectDB_monthCalendar($calendar){
		$calendar = mysql_real_escape_string($calendar);

		$query = "SELECT DISTINCT(".$calendar.") AS typeCalendar FROM calendar ORDER BY ".$calendar." ASC";
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else{
          throw new Exception('Gagal mengambil data');
        }
		return $data;
	}

	function firstDayOfweek(){
		$query = " SELECT date_sub( curdate( ) , INTERVAL WEEKDAY( curdate( ) ) -0 DAY ) AS firstDayOfweek ";
		$rs = $this->registry->db->Execute($query);
		while($data = $rs->FetchNextObject()){
			$fdw = $data->FIRSTDAYOFWEEK;
		}
		return $fdw;
	}

	function getDateYesterday(){
		$yesterday=date("d-m-Y", time()-86400);
		return $yesterday;
	}

	function getTime(){
		# Ambil waktu server terkini
		$dat_server = mktime(date("G"), date("i"), date("s"), date("n"), date("j"), date("Y"));
		# Ambil perbedaan waktu server dengan GMT
		$diff_gmt = substr(date("O",$dat_server),1,2);
		# karena perbedaan waktu adalah dalam jam, maka kita jadikan detik
		$datdif_gmt = 60 * 60 * $diff_gmt;

		# Hitung perbedaannya
		if (substr(date("O",$dat_server),0,1) == '+') $dat_gmt = $dat_server - $datdif_gmt;
		else $dat_gmt = $dat_server + $datdif_gmt;

		# Hitung perbedaan GMT dengan waktu Indonesia (GMT+7)
		$datdif_id = 60 * 60 * 7;
		$dat_id = $dat_gmt + $datdif_id;
		$currentTime = date("H:i:s", $dat_id);
		
		return $currentTime;
	}

	function currentDate($format = 'd-m-Y'){
		return date($format);
	}

	function getDate(){
		return date('d');
	}

	function getMonth(){
		return date('m');
	}

	function getYear(){
		return date('Y');
	}

      function selectDistinct_calendar($distinct = TRUE, $cal1 = NULL, $cal2 = NULL, $max = FALSE){
			if($distinct == TRUE){
				$query = "SELECT DISTINCT(year), month FROM calendar";
				$rs = $this->registry->db->Execute($query);
				return $rs;
			}elseif($max == TRUE){
				$query = "SELECT MAX(MONTH) AS month, year FROM calendar";
				$rs = $this->registry->db->Execute($query);
				return $rs;
			}else{
				$query = "SELECT `date` FROM calendar
						   WHERE calendar_id BETWEEN ".$cal1." AND ".$cal2."
						   AND status = 1";
				$rs = $this->registry->db->Execute($query);
				$cnt = $rs->RecordCount();
				return $cnt;
			}
		}

     function getMaxDayid_Calendar(){
			$query = "SELECT day_id FROM calendar WHERE calendar_id IN(SELECT MAX(calendar_id) FROM calendar)";
			$rs = $this->registry->db->Execute($query);//echo $query;
			while($data = $rs->FetchNextObject()){
			     return $data->DAY_ID;
            }
		}

     function insertDB_calendar(){

		$year = $this->getYear()+1;
		$dayid = $this->getMaxDayid_Calendar();
		for($i= 1;$i<=12;$i++){
			$month[$i] =$i;

			if(($month[$i]==1)||($month[$i]==3)||($month[$i]==5)||($month[$i]==7)||($month[$i]==8)||($month[$i]==10)||($month[$i]==12)){
				$cnt = 31;
			}else{
				if($month[$i]==2){
					if(($year%4) == 0){
						$cnt = 29;
					}else{
						$cnt = 28;
								}
				}else{
					$cnt = 30;
				}
			}

			for($j=1; $j<=$cnt; $j++){
				$dayid = $dayid+1;
				if($dayid == 7){
					$dayid = 0;
				}
				if(($dayid==0)||($dayid==6)){
					$status = 0;
				}else{
					$status = 1;
				}
				$query = "INSERT INTO calendar(date, month, year, day_id, status)
					VALUES(".$j.", ".$month[$i].", ".$year.", ".$dayid.", ".$status.")";
						//echo $query."<br>";
				$rs = $this->registry->db->Execute($query);
                                //echo $query."#".$year."#".$dayid."<br>";
			}

		}

    }

        function getFirstDayid_calendar($month, $year){
		$query = "SELECT day_id FROM calendar WHERE date = 1 AND month = ? AND year = ?";

		$stmt = $this->registry->db->Prepare($query);
		$arrBinding[0] = $month;
		$arrBinding[1] = $year;

		$rs = $this->registry->db->Execute($stmt,$arrBinding);
		while($data = $rs->FetchNextObject()){
			return $data->DAY_ID;
		}
	}

	function selectCal_day($calid = NULL){
		$query = "SELECT * FROM calendar c JOIN day d ON c.day_id = d.day_id";

		if($calid != NULL) $query .= " WHERE c.calendar_id = ".$calid;
		$rs = $this->registry->db->Execute($query);
		return $rs;
	}

    function updateDb_calendar($calid, $stat, $desc = NULL){
		$query = "UPDATE calendar c SET c.status = '".$stat."'";
		if($desc != NULL) $query .= ", c.desc = '".$desc."' ";

		$query .= "WHERE c.calendar_id = ".$calid;
		//echo $query;
                $rs = $this->registry->db->Execute($query);
	}

	function selectTgl($cal_id = NULL, $userid=NULL, $userRecomendation=NULL){
    	$data = array();

		$query = " select date,month,year from calendar c join absen_temp a where c.calendar_id = a.calendar_id AND a.calendar_id = ? AND a.user_id = ? AND a.user_recommendation= ?";
		
		$stmt = $this->registry->db->Prepare($query);
		
		$arrBinding[0] = $cal_id; 
		$arrBinding[1] = $userid;
		$arrBinding[2] = $userRecomendation;
		
		$rs = $this->registry->db->Execute($stmt,$arrBinding);
		
		if($rs){
			if($rs->RecordCount() > 0 ){
				while($row = $rs->FetchNextObject()){
					$data[] = $row; 
				}
			}
		}else throw new Exception('gagal mengambil data');
		return $data;
	}
	
	//last edited by de_haynain
	function selectCalDay($calid = NULL){
		$data = array();
		$query = "SELECT * FROM calendar c JOIN day d ON c.day_id = d.day_id";

		if($calid != NULL) $query .= " WHERE c.calendar_id = ".$calid;
		$rs = $this->registry->db->Execute($query);
		if($rs){
			if($rs->RecordCount() > 0){
				while($row = $rs->FetchNextObject()){
					$data[] = $row;
				}
			}
		}else throw new Exception('gagal mengambil data');
		
		return $data;
	}
	
	 function updateDbCalendar($calid, $stat, $desc = NULL){
		$data = array();
		$query = "UPDATE calendar c SET c.status = '".$stat."'";
		if($desc != NULL) $query .= ", c.desc = '".$desc."' ";

		$query .= "WHERE c.calendar_id = ".$calid;
		
        $rs = $this->registry->db->Execute($query);
		if($rs){
			if($rs->RecordCount() > 0){
				while($row = $rs->FetchNextObject()){
					$data[] = $row;
				}
			}
		}else throw new Exception();
		
		return $data;
	}
	
	public function get_fullDate($calid){
		$data = NULL;
		$query = "SELECT date, month, year FROM calendar WHERE calendar_id = ".$calid;
        $rs = $this->registry->db->Execute($query);
		if($rs){
			if($rs->RecordCount() > 0){
				while($row = $rs->FetchNextObject()){
					$data = $row->DATE.'-'.$row->MONTH.'-'.$row->YEAR;
				}
			}
		}else throw new Exception('gagal mengambil data full date '.$query);
		
		return $data;
	}
}
?>
