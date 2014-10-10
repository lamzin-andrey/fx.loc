<?php
$current_page = "/";
function stars($n, $max = 5) {
	ob_start();
	?><table><tr><? 
		for ($i = 0; $i < $max; $i++) {
		?><td><img width="16" src="/img/<? if ($i < $n)  print "gold"; else print "grays"; ?>.png"/></td><?
		} ?></tr></table><?
	$r =  ob_get_clean();
	return $r;
}

function clang() {
	global $current_page;
	$url = $_SERVER["REQUEST_URI"];
	$a = explode("?", $url);
	if (@$_GET["c"] == "en") {
		@session_start();
		$_SESSION["lang"] = "en/";
		$a[0] = str_replace("en/", "", $a[0]);
		$a[0] .= $_SESSION["lang"];
		$url = $a[0];
		header("location: $url");
		die;
	}
	if (@$_GET["c"] == "ru") {
		@session_start();
		$_SESSION["lang"] = "";
		$url = $_SERVER["REQUEST_URI"];
		$a = explode("?", $url);
		$a[0] = str_replace("en/", "", $a[0]);
		$url = $a[0];
		header("location: $url");
		die;
	}
	$url = $a[0];
	$current_page = $url;
}
clang();