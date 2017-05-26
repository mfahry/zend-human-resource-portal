<?php
/*******************************************************************************
 *  CONNECTION DATABASE						* versi 1.0			               *
 *******************************************************************************
 *  nama file      : DbClose.php                                               *
 *  tanggal revisi : 27-07-2006                                                *
 *  Support		   : PHP 5.00                                                  *
 *  Catatan:                                                                   *
 *  --------                                                                   *
 *  - Versi Awal 					            							   *
 *    Melakukan pemutusan koneksi dengan database yang digunakan               *
 *******************************************************************************/

require_once("DbVar.php");

switch($cfg_DBname){
	case "mysql" :
	{   
		/*************************************************************************************
	    KONEKSI KE DB MYSQL
		**************************************************************************************/
		require_once("MysqlCls/mysql.cls.php");
		$classDb->Close();
		break;
	}
	case "odbc" :
	{
		require_once("ODBCAccess/ODBCAccess.Cls.php");
		$classDb->Close();
		break;
	}
	default :
	{
 		echo "Nama DBMS Tidak Terdefinisi di variabel \"$cfg_DBname\" dalam file \"DbVar.php\"";
	}
}

?>