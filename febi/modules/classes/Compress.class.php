<?php
class Compress extends Sys {
	var $ctype='';
	function __construct() {
       $this->ctype = $this->detect_compression_type();
   	}
	function compress_output_gzip($output) {
    	return gzencode($output, 1);
	}
	
	function compress_output_deflate($output) {
		return gzdeflate($output, 1);
	}
	
	private function detect_compression_type() {
		$accept = getenv('HTTP_ACCEPT_ENCODING');
		if (!extension_loaded('zlib'))
			return 'nozip';
		if (strpos($accept, 'gzip') !== false)
			return "gzip";
		if (strpos($accept, 'deflate') !== false)
			return "deflate";
		return 'nozip';
	}
	
	public function start_compress() {
		if ($this->ctype == 'gzip') {
			header("Content-Encoding: gzip");
			ob_start(array($this, 'compress_output_gzip'));
		} else
		if ($this->ctype == 'deflate') {
			header("Content-Encoding: deflate");
			ob_start(array($this, 'compress_output_deflate'));
		} else {
			ob_start();
		}
	}
	
	
	public function compress_end($add = '') {
		$nozip=false;
		$Contents = ob_get_contents();
		$gzib_file = strlen($Contents);
	
	
		if ($this->ctype == 'gzip') {
			$method = 'gzip';
			$gzib_file_out = strlen(gzencode($Contents, 1));
		} else
		if ($this->ctype == 'deflate') {
			$method = 'deflate';
			$gzib_file_out = strlen(gzdeflate($Contents, 1));
		} else
		if ($this->ctype == 'nozip') {
			$gzib_file_out = strlen($Contents);
			$nozip = true;
		}
	
		$gzib_pro = round(100 - (100 / ($gzib_file / $gzib_file_out)), 1);
		if ($gzib_pro > 0 && $gzib_pro < 100) {
	//echo $method.': '.$gzib_pro.'%<br/>'; 
			echo $add;
		}
		if ($nozip)
			echo "gzip Off" . $add;
	}


}