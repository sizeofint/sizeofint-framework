<?

class Main extends Sys {
	var $headerstrs=array();
	var $contentBuffer="";
    var $pageTitle = "Unnamed";
    var $keyWords = array();
    var $description = "";
    var $headhtml = "";
    var $csss = "";
    var $redi = "";
    var $wr = array();
    var $reparray = array();
    var $viewStates = array();
    var $lastvsname = ''; // !!!
	var $headTagsArr=array();
    public static $htmlheaders = true;
    public static $gzip = true;
    public static $showcopyright = true;

    function Main() {
        $this->wr = array(
            "#SOI_TITLE_" . md5(time() . SOISALT) . "#",
            "#SOI_HEADSTRING_" . md5(time() . SOISALT) . "#",
            "#SOI_JAVASCRIPTTAG_" . md5(time() . SOISALT) . "#",
            "#SOI_CSSTAG_" . md5(time() . SOISALT) . "#",
            "#SOI_KEYWORDS_" . md5(time() . SOISALT) . "#",
            "#SOI_DESCRIPTIONS_" . md5(time() . SOISALT) . "#"
        );
    }

    function repArr() {
		
		
		$this->sortHeadTags();
		
		
        $this->reparray = array(
            "<title>" . $this->pageTitle . "</title>",
            $this->headhtml,
            "",
            $this->csss,
            ((count($this->keyWords) > 1) ? '<meta name="keywords" content="' . implode(",", $this->keyWords) . '" />' : ''),
            (($this->strlen($this->description) > 1) ? '<meta name="description" content="' . mb_substr(preg_replace('/[^a-zა-ჰ0-9\s,\.\-]/i','',$this->description),0,160,"utf8") . '" />' : '')
        );
        return $this->reparray;
    }
	
	function sortHeadTags(){
		$this->headhtml='';
		$helperarr=array();
		foreach($this->headTagsArr as $v){
			$helperarr[]=$v[1];
		}
		arsort($helperarr);
		
		foreach($helperarr as $k=>$v){
			$this->headhtml.=$this->headTagsArr[$k][0] . "\n";
		}
		
	}
	

    function showHead() {
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n";
        echo $this->wr[0] . "\r\n";
        echo $this->wr[5] . "\r\n";
        echo $this->wr[4] . "\r\n";
        echo $this->wr[1] . "\r\n";
        echo $this->wr[3] . "\r\n";
    }

    function showcontent($con) {
		
		if(file_exists(SYSDIRPATH.'/soijs.js'))
			$this->__addHeadTags('<script type="text/javascript" src="'.SYSURI.'/soijs.js"></script>',10000);
		
        $con = str_replace($this->wr, $this->repArr(), $con);
        $con = $this->precessvs($con);
		
		
		
		
		
        echo $con;
    }
	
	
	
	function makeautodesc(){
		$nakedcon=strip_tags($this->contentBuffer);
		
	
	}

    function showTitle() {
        return $this->wr[0];
    }

    function startContent() {

        ob_start();
    }

    function endContent() {

        ob_end_clean();
    }

    function setPagetitle($title) {

        $this->pageTitle = mb_substr($title, 0, 100, UNI);
    }

    function setPageKeywords($keyWordsArray) {

        $this->keyWords = @array_slice($keyWordsArray, 0, 20);
        //$this->keyWords=$keyWordsArray;
    }

    function setPageDecription($description) {

        $this->description = $description;
    }
	
	private function __addHeadTags($tagsi,$prior=0) {
		$this->headTagsArr[]=array($tagsi,$prior);
    }
	

    function addHeadTags($tagsi,$prior=0) {
		$this->__addHeadTags($tagsi,(($prior>999)?999:$prior));
    }

    function addCss($cssfile) {
        $this->csss.='<link type="text/css" href="' . $cssfile . '" rel="stylesheet" />' . "\n";
    }

    function redirect($adrr) {
        $this->redi = $adrr;
    }
	
	function setHeader($hederstr){
		$this->headerstrs[]=$hederstr;
	}
	
	function showheaders(){
		foreach($this->headerstrs as $h){
			header($h);
		}
	}

    function makeRedirect() {
        if ($this->redi) {
            header("Location: " . $this->redi . "");
            exit;
        }
    }
	
	function precessvs($con){
		
		foreach($this->viewStates as $key=>$val)
			$con=str_replace($val['k'],$val['v'],$con);
		
		
		return $con;
	}

    function setViewState($vsname,$v=false) {
		if($v!==false) 
			$this->addVsConByKey($vsname,$v);
		else {
			$this->lastvsname = $vsname;
			ob_start();
		}
    }
	
	
	function addVsConByKey($k,$v){
		if(array_key_exists($k,$this->viewStates))
			$this->viewStates[$k]['v'] = $v;
		else
			$this->viewStates[$k]['v'] = 'ViewStates key not found!';
	}

    function endViewState() {
		if(empty($this->lastvsname)) 
			return false;
        $contenti = ob_get_clean();
		$this->addVsConByKey($this->lastvsname,$contenti);
		$this->lastvsname='';
    }

	/*
	Show saved text by setting text key
	
	@param string $vsname - ViewState key to access string
	@param boolean $ret - true for direct output
	
	@return string returns saved string */
    function showViewState($vsname, $ret = false) {
		$vs_key = "#SOI_VS_" . md5($vsname . time() . SOISALT) . "#";
		$this->viewStates[$vsname]=array("k"=>$vs_key,"v"=>'');
        if($ret)
			return $vs_key;
		echo $vs_key;
    }

}

?>