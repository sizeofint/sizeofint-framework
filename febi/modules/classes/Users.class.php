<?
class Users extends Sys {
	var  $loged=false;
	var $username="";
	var $maili="";
	var $name="";
	var $lastname="";
	var $statusi=0;
	var $userid=0;
	function Users(){
		
		}
	function checkauth(){
		if($_SESSION['auth']) {
			$this->loged=true;
			$this->username=$_SESSION['username'];
			$this->maili=$_SESSION['maili'];
			$this->name=$_SESSION['name'];
			$this->lastname=$_SESSION['lastname'];
			$this->userid=$_SESSION['uid'];
			$this->statusi=$_SESSION['statusi'];
			}
		}
	
	
	function addUser($name,$lastname,$username,$pass,$mail,$regdate,$statusi){
		global $db;
		
		if($db->query("insert into sizeofint_users(name,lastname,username,mail,statusi,pass,regdate) values ('".$name."','".$lastname."','".$username."','".$mail."','".$statusi."','".$this->passGenerator($pass)."','".time()."')")) return true;
		return false;
		}
	
	function passGenerator($usertype){
		
		return md5(PASSSTR.$usertype);
		
		
		}
	function auth($mail,$pass){
		if($this->loged) return true;
		global $db;
		
		$q=$db->fetch($db->query("select * from sizeofint_users where mail='".$db->sqlvar($mail)."'"));
		if($q['pass']==$this->passGenerator($pass)) { 
		$this->name=$_SESSION['name']=$q['name'];
		$this->lastname=$_SESSION['lastname']=$q['lastname'];
		$this->statusi=$_SESSION['statusi']=$q['statusi'];
		$this->username=$_SESSION['username']=$q['username'];
		$this->maili=$_SESSION['maili']=$q['mail'];
		$this->userid=$_SESSION['uid']=$q['id'];
		$this->loged=true;
		$_SESSION['auth']=1;
	    return true;
		 }
		return false;		
		}
	function logOut(){
		
unset($_SESSION['name'],$_SESSION['lastname'],$_SESSION['statusi'],$_SESSION['username'],$_SESSION['auth'],$_SESSION['uid']);
$this->loged=false;
		
		return true;
		}
	
	function isAuth(){
		
		if($this->loged===true && $_SESSION['auth']==1) return true;
		
		return false;
		}
	function isAdmin(){
		
		if($this->statusi==1 && $_SESSION['statusi']==1) return true;
		return false;
		}
	
	
	
	
	
	
	
	}
?>