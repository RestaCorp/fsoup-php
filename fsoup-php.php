<?php

/*
 *  fsoup - parse lib
 */

class fudoapi_01Portablecuted3
{
	const VERSION__ = '0.1Portable-cuted3';
	const EDITION__ = 'ENTERPRISE_fsouplib1';
	const UPDATE__  = '11/09/2017 4:26 AM';

	const X_KEY__      = 'pub_0001';
	const ALLOWSTATS__ = true;

	/*
	 *   Отправка данных на сервер Фудо! Чисто для статистики.
	 */
	
	function SendStats(){
		if(fudoapi_01Portablecuted3::ALLOWSTATS__ == true){
		file_get_contents('https://fudo.su/fudoos/serv.sx-1123z_/pub/monitoring/socket/3120/?KEY='.fudoapi_01Portablecuted3::X_KEY__);}
	}
}

class fsouplib
{
	public static $msg = array(
		'empty'=>"Argument : ^^1 , empty!",
		'fs_empty'=>"File : '^^1' , not exist!",
		'fs_notfsoup'=>"File : '^^1', not FSoup!",
	);
	public static $regex = array(
		'ex_match_scope'=>"/(\:)|(\:,)|(\;=)|(\:\.)/",
		'ex_match_comment_single'=>"/;;/",
		'ex_match_comment'=>"/(?:\;\;.+)/",
		'ex_replace_end'=>"/(^\:{1})|(\:\.)/",
		'ex_replace_all'=>"/(^\:{1})|(\:\.)|(\:,)/",
	);
	function add_error_to_array($x = ""){
		if(empty($x)) { return false; }
		fsoup::$last_error = $x;
		fsoup::$errors[] = $x;
		return true;
	}
	function add_error($text = "", $arg = ""){
		if(empty($text)) { return false; }
		if(!empty($arg)) {$arg = explode("$$:", $arg); } else {$arg = array($arg); }
		$x = fsouplib::msg_replace($text, $arg);
		if(empty($x) || $x == false || $x == "false"){ return false; }
		fsouplib::add_error_to_array($x);
		return $x;
	}
	function msg_replace($msgid = "", $arg = array()){
		if(empty($msgid)) { return false; }
		if(empty(fsouplib::$msg[$msgid])) { return false; }
		$x = fsouplib::$msg[$msgid];
		foreach ($arg as $k => $v) {$x = preg_replace("/\^\^".($k+1)."/", $v, $x); }
		return $x;
	}
}

class fsoup extends fsouplib
{
	public static $last_error = '';
	public static $errors = array();
	function parse($x = ""){
		fudoapi_01Portablecuted3::SendStats();
		if(empty($x)) { fsouplib::add_error("empty", "Text"); return false; }
		if(!preg_match(fsouplib::$regex['ex_match_scope'], $x)){ fsouplib::add_error("fs_notfsoup", $file); return false; }
		$x = explode(":,", preg_replace(fsouplib::$regex['ex_replace_end'], "", $x));
		$g = array();
		foreach ($x as $k => $d) {
			if(preg_match(fsouplib::$regex['ex_match_comment_single'], $d)){ $d = preg_replace(fsouplib::$regex['ex_match_comment'], "", $d); }
			$l = explode(";=", preg_replace(fsouplib::$regex['ex_replace_all'], "", trim($d)));
			$g[$l[0]] = $l[1];
		}
		return $g;
	}
	function parse_file($file = ""){
		fudoapi_01Portablecuted3::SendStats();
		if(empty($file)) { fsouplib::add_error("empty", "File"); return false; }
		if(!file_exists($file)) { fsouplib::add_error("fs_empty", $file); return false; }
		return fsoup::parse(file_get_contents($file));
	}
}

?>