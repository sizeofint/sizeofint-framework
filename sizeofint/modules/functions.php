<?php

function tolinuxtime($tistr){ //dd.mm.yy to linux
	preg_match('/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/i',$tistr,$fg);
$mesntima=mktime(date('H'),date('i'),date('s'),intval($fg[2]),intval($fg[1]),intval($fg[3]));
	
	return $mesntima;
	}
function ustrlen($string) {
    return mb_strlen($string, 'utf8');
}
function randomstringgen() {
    $allowed_symbols = "23456789acdefghkmnpqrsuvwxyz";
    $length = mt_rand(5, 6);
    while (true) {
        //$this->keystring = '';
        for ($i = 0; $i < $length; $i++) {
            $keystring .= $allowed_symbols{ mt_rand(0, strlen($allowed_symbols) - 1) };
        }
        if (!preg_match('/cp|cb|ck|c6|c9|rn|rm|co|do/', $keystring))
            break;
    }
    return $keystring;
}
	
function logtolog($str){
	file_put_contents(SCRDIR."/sizeofint/logs.txt",date('r')." - ".$str."\n\n",FILE_APPEND);
}

function mail_utf8($to, $subject = '(No subject)', $message = '', $header = '') {
  $header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n";
  return mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header.$header_);
}

function makeDescription($tx){

	$tx=strip_tags($tx);
$tx=str_replace("&nbsp;","",$tx);
$textd=preg_replace('/[^a-zA-Zა-ჰ0-9\s]/uis','',$tx);
//$textd=$tx;

	$wordsi=explode(" ",$textd);

	$WordsCount=count($wordsi)<=7?count($wordsi):7;

for($i=0; $i<=$WordsCount; $i++){

		

		$descr.=$wordsi[$i]." ";

		

		

		}

	

	return $descr;

	}


function safeurl($str) {

	//$str.='"';

	//$str=str_replace(array('/'),array(''),$str);

	$str=preg_replace('/[^a-z0-9?-?\s]+/uis',' ',$str);

	
	return $str;

	

	}
function syntaxH($t){
	
	return preg_replace("#<pre([^>]*?)>(.*?)</pre>#ise","'<pre$1>'.syntaxRE('$2').'</pre>'",$t);
	
	}
function syntaxRE($s){
	
	return str_replace("<","&lt;",$s);
	}


?>