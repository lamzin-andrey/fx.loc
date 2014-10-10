<?php
	@session_start();
	$currlang = @$_SESSION["lang"];
	$r = $_SERVER["DOCUMENT_ROOT"];
	include_once "$r/style.php";
	$langtpl = "$r/tpl/lang.tpl.php";
	$headtpl = "$r/tpl/header.tpl.php";
	$contenttpl = "$r/tpl/content.tpl.php";
	$footertpl = "$r/tpl/footer.tpl.php";
	
	$baseTitle= "FastXAMPP - запуск XAMPP в linux с gui + xdebug + memcached + удобный интерфейс для Ubuntu Linux";
	if ($currlang == "en/")
		$baseTitle= "FastXAMPP - XAMPP + xdebug + memcached + user-friendly interface for Ubuntu Linux";
?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
		<title><?php print $baseTitle; if ($title)print "| $title"; ?> </title>
		<link rel="stylesheet" type="text/css" href="/css/<?=$bst?>.css" />
	</head>
	<body>
		<div class="couter">
			<div class="cinner">
				<div class="langs"><? include $langtpl; ?></div>
				<div class="mainhead"><? include $headtpl; ?></div>
				<div class="content"><? include $contenttpl; ?></div>
				<div class="footer"><? include $footertpl; ?></div>
			</div>
		</div>
	</body>
</html>
