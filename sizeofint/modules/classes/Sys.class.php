<?
class Sys {
	const VERSION="0510";
	const FNAME="SizeOfInt Framework";
	
	function __construct(){}
	
	function getSystemInfo(){
		echo VERSION.'<br/>';
		
		echo FNAME;
		
	}
	
	function strlen($string,$u='utf8') {
		return mb_strlen($string,$u);
	}
	
	
	
	
	
	
	
	
	}

?>