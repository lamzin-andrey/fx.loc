<?php
function query($cmd, &$numRows = 0, &$affectedRows = 0) {
	$link = setConnection();
	$lCmd = strtolower($cmd);
	$insert = 0;
	if (strpos($lCmd, 'insert') === 0) {
		$insert = 1;
	}
	global $dberror; 
	global $dbaffectedrows; 
	global $dbnumrows;
	$res = mysql_query($cmd);
	$data = array();
	$dberror = mysql_error();
	if ($dberror) {
		if (defined('DEV_MODE')) {
			var_dump($dberror);
			echo "\n<hr>\n$cmd<hr>\n";
		}
		mysql_close($link);
		return $data;
	}
	
	$numRows = $dbnumrows = @mysql_num_rows($res);
	
	if ($dbnumrows ) {
		while ($row = mysql_fetch_array($res)) {
			$rec =array();
			foreach ($row as $k=>$i) {				
				if (strval((int) $k) != strval($k)) {
					$rec[$k] = htmlspecialchars_decode($i);
				}
			}
			$data[] = $rec;
		}
	}
	$affectedRows = $dbaffectedrows = mysql_affected_rows();
	if ($insert) {
		$id = mysql_insert_id();
		mysql_close($link);
		return $id; 
	}
	mysql_close($link);
	return $data;
}
function dbrow($cmd, &$numRows = null) {
	$link = setConnection();
	$data = query($cmd, $numRows);
	if ($numRows) {
		//mysql_close($link);
		return $data[0];
	}
	//mysql_close($link);
	return array();
}
function dbvalue($cmd) {
	$link = setConnection();
    $res = mysql_query($cmd);
    if (@mysql_num_rows($res) != 0) {
		$val = mysql_result($res, 0, 0);
		mysql_close($link);
    	return $val;
    }
    mysql_close($link);
    return false;
}
function setConnection() {
	$link = mysql_connect('localhost', 'root', '123456') or die('Error connect to mysql');
	mysql_select_db('fc') or die('Error select db');
	mysql_query('SET NAMES UTF8');
	return $link;
}
function db_escape(&$s) {
	$s = mysql_escape_string($s);
	return $s;
}
?>
