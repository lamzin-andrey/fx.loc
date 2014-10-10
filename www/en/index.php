<?
$r = $_SERVER["DOCUMENT_ROOT"];
include "$r/functions.php"; 
ob_start();
?><p class="tright">
<a href="/download.php" class="dlink" >Download FastXAMPP</a>
</p><p>FastXAMPP - is a tool for web developers working in Linux Ubuntu, which makes working with XAMPP more convenient.</p>
<p>Menu icon in the system tray or panel Unity allows you to add or delete another site on localhost in three mouse clicks.</p>
<p>FastXAMPP was tested in Linux Mint, Ubuntu, Kubuntu and Xubuntu.

List of versions of each operation system and features  FastXAMPP (if any) in each of them you can read clicking on the link the main menu of this page.</p>
<p>The greatest usability utility gives  linux, based on Ubuntu 12.04.3 LTS, but it also works in versions based on Ubuntu 13.10.</p>
<p>The archive includes XAMPP 1.7.4, it: 
<ul class="lstnono">
	<li><div><div class="left"><img src="/img/apache_logo.png" /></div> <div class="left mtt">Apache 2.2.17,</div><div class="endfloat"></div></div></li>
	<li><div><div class="left"><img src="/img/php_logo.png" /></div> <div class="left mphp">PHP 5.3.5,</div><div class="endfloat"></div></div></li>
	<li><div><div class="left"><img src="/img/mysql_logo.png" /></div> <div class="left mmysql">MySQL server 5.5.8,  client 5.0.7</div><div class="endfloat"></div></div></li>
</ul>	
</p>
<p>The archive also includes extensions for the specified version of PHP:
<ul class="lstnono">
	<li><div><div class="left"><img src="/img/xdebug_logo.png" /></div> <div class="left mtt">Xdebug,</div><div class="endfloat"></div></div></li>
	<li>
		<div>
			<div class="left"><img src="/img/memcached_logo.png" /></div>
			<div class="left memci">Memcached</div><div class="endfloat"></div>
		</div>
	</li>
</ul>	
</p>
<p>FastXAMPP adds to your system tray the icon,<br/>
<img src="/img/en_menu.png" style="text-align: middle; margin: 5px 27px"/><br> which allows you to quickly start or stop XAMPP.
</p>
<p>By clicking on the item "Settings" dialog appears to add or remove a site on local host.<br/>
<img src="/img/en_dialog.png" style="text-align: middle; margin: 5px 27px"/>
</p>
<p>Version for Unity shell: <br/>
<img src="/img/unity_small.png" style="text-align: middle; margin: 5px 27px"/>
</p>
<p>
<a href="/download.php" class="dlink" >Download FastXAMPP</a>
</p>
<?php // /files/fastxampp.1.7.4.tar.gz
	$text_content = ob_get_clean();
	
	include "$r/master.php";
?>
