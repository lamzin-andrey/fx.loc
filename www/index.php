<?
$r = $_SERVER["DOCUMENT_ROOT"];
include "$r/functions.php"; 
ob_start();
?><p class="tright">
<a href="/download.php" class="dlink" >������� ����� � �������� FastXAMPP</a>
</p>



<p>FastXAMPP - ��� ������� ��� ���-�������������, ���������� � Linux Ubuntu, �������� ������ � XAMPP �������.</p>
<p>���� ������ � ��������� ���� ��� ������ Unity ��������� �������� ��� ������� ��������� ���� �� localhost � ��� ����� �����.</p>
<p>FastXAMPP ������������� � ������������� Linux Mint, Ubuntu, Kubuntu � Xubuntu, ������ ������ ������� ������������ � ����������� ������ FastXAMPP (���� ����� ����) � ������ �� ��� �� ������ �������� ������ �� ��������������� ������� �������� ���� ���� ���������.</p>
<p>FastXAMPP ��� XAMPP 1.8.3-3  ���� ���������� �������� ������������� � ������������� linux, ���������� �� Ubuntu 14.04 LTS</p>
<p>FastXAMPP ��� XAMPP 1.7.4  ���� ���������� �������� ������������� � ������������� linux, ���������� �� Ubuntu 12.04.3 LTS</p>
<p>������ GUI ���������� ���������� � �������� ������ �� localhost � ����������� FastXAMPP ��������� PHP ���������� xdebug � memcached, ������� ��� (��� ��� ���������) � ������������ XAMPP.</p>

<p class="x-vers">XAMPP 1.8.3-3, ���: 
</p><ul class="lstnono">
	<li><div><div class="left"><img src="/img/apache_logo.png"></div> <div class="left mtt">Apache 2.4.7,</div><div class="endfloat"></div></div></li>
	<li><div><div class="left"><img src="/img/php_logo.png"></div> <div class="left mphp">PHP 5.5.9,</div><div class="endfloat"></div></div></li>
	<li><div><div class="left"><img src="/img/mysql_logo.png"></div> <div class="left mmysql">MySQL ������ 5.6.16,  ������ 5.0.11</div><div class="endfloat"></div></div></li>
</ul>

<p class="x-vers">XAMPP 1.7.4, ���: 
</p><ul class="lstnono">
	<li><div><div class="left"><img src="/img/apache_logo.png"></div> <div class="left mtt">Apache 2.2.17,</div><div class="endfloat"></div></div></li>
	<li><div><div class="left"><img src="/img/php_logo.png"></div> <div class="left mphp">PHP 5.3.5,</div><div class="endfloat"></div></div></li>
	<li><div><div class="left"><img src="/img/mysql_logo.png"></div> <div class="left mmysql">MySQL ������ 5.5.8,  ������ 5.0.7</div><div class="endfloat"></div></div></li>
</ul>	
<p></p>
<p class="fx-vers">FastXAMPP ��������� ���������� ��� ��������� ������ php
</p><ul class="lstnono">
	<li><div><div class="left"><img src="/img/xdebug_logo.png"></div> <div class="left mtt">Xdebug,</div><div class="endfloat"></div></div></li>
	<li>
		<div>
			<div class="left"><img src="/img/memcached_logo.png"></div>
			<div class="left memci">Memcached</div><div class="endfloat"></div>
		</div>
	</li>
</ul>	
<p></p>
<p class="fx-vers">FastXAMPP ��������� � ��� ��������� ���� ������</p><p>
<img style="text-align: middle; margin: 5px 27px" src="/img/context.png"><br> ����������� ������ ��������� ��� ���������� XAMPP.
</p>
<p>�� ����� �� ������ "���������" ���������� ������ ���������� ��� �������� ����� �� localhost <br>
<img style="text-align: middle; margin: 5px 27px" src="/img/kde-sets.png">
</p>
<p>� �������� �������� ����� Unity ��-�� ������� � �������� ����� ������ ������ � ���� ������������ ������ � ������������ ��������: <br>
<img style="text-align: middle; margin: 5px 27px" src="/img/unity_small.png">
</p>

<p>
<a href="/download.php" class="dlink" >������� ����� � �������� FastXAMPP</a>
</p>
<?php // /files/fastxampp.1.7.4.tar.gz
	$text_content = ob_get_clean();
	
	include "$r/master.php";
?>
