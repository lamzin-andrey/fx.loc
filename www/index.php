<?
$r = $_SERVER["DOCUMENT_ROOT"];
include "$r/functions.php"; 
ob_start();
?><p class="tright">
<a href="/download.php" class="dlink" >Скачать архив с утилитой FastXAMPP</a>
</p>



<p>FastXAMPP - это утилита для веб-разработчиков, работающих в Linux Ubuntu, делающая работу с XAMPP удобнее.</p>
<p>Меню значка в системном трее или панели Unity позволяет добавить или удалить очередной сайт на localhost в три клика мышью.</p>
<p>FastXAMPP протестирован в диструбутивах Linux Mint, Ubuntu, Kubuntu и Xubuntu, список версий каждого диструбутива и особенности работы FastXAMPP (если такие есть) в каждой из них вы можете прочесть пройдя по соответствующим ссылкам главного меню этой странички.</p>
<p>FastXAMPP для XAMPP 1.8.3-3  дает наибольшее удобство использования в диструбутивах linux, основанных на Ubuntu 14.04 LTS</p>
<p>FastXAMPP для XAMPP 1.7.4  дает наибольшее удобство использования в диструбутивах linux, основанных на Ubuntu 12.04.3 LTS</p>
<p>Помимо GUI интерфейса добавления и удаления сайтов на localhost в диструбутив FastXAMPP добавлены PHP расширения xdebug и memcached, которых нет (или они отключены) в диструбутиве XAMPP.</p>

<p class="x-vers">XAMPP 1.8.3-3, это: 
</p><ul class="lstnono">
	<li><div><div class="left"><img src="/img/apache_logo.png"></div> <div class="left mtt">Apache 2.4.7,</div><div class="endfloat"></div></div></li>
	<li><div><div class="left"><img src="/img/php_logo.png"></div> <div class="left mphp">PHP 5.5.9,</div><div class="endfloat"></div></div></li>
	<li><div><div class="left"><img src="/img/mysql_logo.png"></div> <div class="left mmysql">MySQL сервер 5.6.16,  клиент 5.0.11</div><div class="endfloat"></div></div></li>
</ul>

<p class="x-vers">XAMPP 1.7.4, это: 
</p><ul class="lstnono">
	<li><div><div class="left"><img src="/img/apache_logo.png"></div> <div class="left mtt">Apache 2.2.17,</div><div class="endfloat"></div></div></li>
	<li><div><div class="left"><img src="/img/php_logo.png"></div> <div class="left mphp">PHP 5.3.5,</div><div class="endfloat"></div></div></li>
	<li><div><div class="left"><img src="/img/mysql_logo.png"></div> <div class="left mmysql">MySQL сервер 5.5.8,  клиент 5.0.7</div><div class="endfloat"></div></div></li>
</ul>	
<p></p>
<p class="fx-vers">FastXAMPP добавляет расширения для указанных версий php
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
<p class="fx-vers">FastXAMPP добавляет в ваш системный трей значок</p><p>
<img style="text-align: middle; margin: 5px 27px" src="/img/context.png"><br> позволяющий быстро запустить или остановить XAMPP.
</p>
<p>По клику на пункте "Настройки" появляется диалог добавления или удаления сайта на localhost <br>
<img style="text-align: middle; margin: 5px 27px" src="/img/kde-sets.png">
</p>
<p>В оболочке рабочего стола Unity из-за проблем с системым треем вместо значка в трее используется диалог с аналогичными пунктами: <br>
<img style="text-align: middle; margin: 5px 27px" src="/img/unity_small.png">
</p>

<p>
<a href="/download.php" class="dlink" >Скачать архив с утилитой FastXAMPP</a>
</p>
<?php // /files/fastxampp.1.7.4.tar.gz
	$text_content = ob_get_clean();
	
	include "$r/master.php";
?>
