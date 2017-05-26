<?php
/*******************************************************************************
 *  CONNECTION DATABASE						* versi 1.0			               *
 *******************************************************************************
 *  nama file      : DbConnection.php                                          *
 *  tanggal revisi : 27-07-2006                                                *
 *  Support		   : PHP 5.00                                                  *
 *  Catatan:                                                                   *
 *  --------                                                                   *
 *  - Versi Awal                                							   *
 *    Melakukan koneksi dengan database yang digunakan                         *
 *    Mengenai sintak pengaksesan Query masing-masing DB tidak di bahas        *
 *    atau di definisikan disini karena modul ini hanya membuat Resource       *
 *    koneksinya saja ke masing-masing database.                               *
 *******************************************************************************/

require_once("DbVar.php");

switch($cfg_DBname){
	case "mysql" :
	{   
		/*************************************************************************************
	    KONEKSI KE DB MYSQL
		Melakukan pemilihan ke 1 Data Base MySQL melalui Resource koneksi 
		yang telah didefinisikan di dalam class.
		sintak pemilihan :
		
		" mysql_connection(array("db" => 1,"dbclass" => "MySqlDb")) "
		
		sintak tersebut untuk memilih data base default yang didefinisikan 
		di config.var sehingga saat inisialisasi halamat memanggil modul koneksi ini 
		maka akan selalu menggunakan database default yang telah diaktifkan
		
		untuk mengganti database default yang akan digunakan tambahkan dulu sintak dibawah ini
		
		" mysql_connection(array("db" => 1,"dbclass" => "MySqlDb","database" => "nama_database")) "
		
		dengan mengisi nama database nya
		**************************************************************************************/
		require_once("MysqlCls/Mysql.Cls.php");
		if (!mysql_connection(array("db" => 1,"dbclass" => "MySqlDb"))){
		 	echo "Gagal Koneksi Ke \"$cfg_DBDatabase\" MySQL Database";
		}
		break;
	}
	case "odbc" :
	{
		require_once("ODBCAccess/ODBCAccess.Cls.php");
		if (!ODBCConn($cfg_DBDatabase)){
		 	echo "Gagal Koneksi Ke \"$cfg_DBDatabase\" ODBC Database";
		}
		
		break;	
	
	}
	case "Adodb5" :
	{	
		if ($cfg_DBDatabase=="oracle"){
			/*
			* DATABASE ENVIRONMENT 
			*/
			$ORACLE_LIB = 'oracle/adodb.inc.php';
			$PAGER_LIB  = 'oracle/adodb-pager.inc.php';
			/*
				Connection
			*/
			include_once($ORACLE_LIB);
			include_once($PAGER_LIB);
			//echo $ORACLE_LIB;
			global $CONN;
			$CONN = ADONewConnection('oci8i');
			//echo "".$cfg_DBHost." - ".$cfg_DBUser."-".$cfg_DBPassword."";
			$CONN->Connect($cfg_DBHost, $cfg_DBUser, $cfg_DBPassword, $cfg_DBService);
		}else if ($cfg_DBDatabase=="mysql"){
			include("adodb5/adodb.inc.php");
			
			global $CONN;

			$CONN = ADONewConnection('mysql');    # create a connection
			$CONN->PConnect($cfg_DBHost, $cfg_DBUser, $cfg_DBPassword, $cfg_DBService);
			//$CONN->debug=true;
			
			/*
			$rs = $CONN->Execute('select * from user');
			print "<pre>";
			print_r($rs->GetRows());
			print "</pre>";*/
			
			//$classDB= new ADOConnection;
		}
		break;	
	
	}
	default :
	{
 		echo "Nama DBMS Tidak Terdefinisi di variabel \"$cfg_DBname\" dalam file \"DbVar.php\"";
	}
}

?>