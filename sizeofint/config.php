<?php
	ini_set("display_errors",true);
	define("SCRFOL","");
	define("SCRDIR",$_SERVER['DOCUMENT_ROOT'].SCRFOL);
	define("SYSDIR",basename(dirname(__FILE__)));
	define("SYSURI",SCRFOL.'/'.SYSDIR);
	define("SYSDIRPATH",SCRDIR.'/'.SYSDIR);
	define("UNI","utf8");
	define("GZIP",true);
	define("DBUSER","");  //leave it empty if you do not want to use database
	define("DBPASS",'');
	define("DBSERVER","localhost");
	define("DBNAME","dbname");
	define("PASSSTR","123");
	define("SOISALT",'123');
?>
