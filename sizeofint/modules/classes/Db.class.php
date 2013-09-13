<?php

class Db extends mysqli {

	private $sqlresobj=null;
	function __construct($dbser,$dbusr,$dbpss,$dbnm){
		parent::__construct($dbser, $dbusr, $dbpss, $dbnm);
		if ($this->connect_error) 
            return false;
        

        $this->query("/*!40101 SET NAMES 'utf8' */");
        return true;
	}
	

    function disconnect() {
        $this->close();
    }

    function fetch($curobject=false) {
		if (is_object($curobject))
            return $curobject->fetch_array(MYSQLI_ASSOC); // MYSQLI_ASSOC, MYSQLI_NUM, or MYSQLI_BOTH.
        return false;
    }

    function query($q) {
        return parent::query($q);
    }

    function sqlvar($va, $inti = false) {
        if ($inti === true)
            return intval($va);
        return $this->real_escape_string($va);
    }

    function insertid() {
        return $this->insert_id;
    }

    function lasterror() {
        return $this->error;
    }

    function numrows($sqlresorse) {
        return $sqlresorse->num_rows;
    }

    function affected_rows() {
        return $this->affected_rows;
    }

    static function _f($param) {
        if (count($param) != 3)
            return 'ERROR!';
        $attrs = array();

        $attrs = explode('" ', $param[2]);

        $atrstring = "";
        foreach ($attrs as $atr) {
            $atrt = trim($atr);
            if (preg_match('#^(style|src|align|href)#i', $atrt))
                if (substr($atrt, -1, 1) != '"')
                    $atrstring.=' ' . $atrt . '"';
                else
                    $atrstring.=' ' . $atrt;
        }
        return '<' . $param[1] . $atrstring . '>';
    }

    function parse_xss($str) {
        $str = str_replace("'", "\"", $str);
        $str = preg_replace('/<script[\d\D]*?>[\d\D]*?<\/script>/i', '', $str);
        $str = preg_replace(
                array(
            '#script#i',
            '#alert#i')
                , array(
            '',
            ''), $str);
        $str = preg_replace_callback('#<([a-z0-9]+)\s+([^>]+)*>#i', 'Db::_f', $str);

        return $str;
    }
	

}

?>