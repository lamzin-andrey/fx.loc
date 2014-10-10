<? 
ob_start();
@session_start();
$linktext = "Скачайте и распакуйте архив, после чего запустите файл Setup.";
if ( @$_SESSION["lang"] == "en/" ) {
	$linktext = "Extract this archive, and run the Setup.";
}
?>


<div class="couter tou2"><div class="cinner tin2 pt12">
<p>
	<table><tbody>
<tr>
<td colspan="2" align="right" class="dlink b">
			FastXAMPP, XAMPP 1.8.3-3, PHP 5.5.9 (linux 64 bit) ~ 145 Мб
		</td>
</tr>
<tr>
		<td>
			<img src="/img/d.png">
		</td>
		<td style="padding-bottom:5px">
			<a title="Download and extract the archive" href="https://drive.google.com/file/d/0B4iNGN_yK6gNd09XR0pPakRoeTA/edit?usp=sharing" target="blank" class="dlink">Скачайте и распакуйте архив, после чего запустите файл Setup.</a>
		</td>
	</tr></tbody></table>
	 
</p> 
</div></div>


<div class="couter tou2"><div class="cinner tin2 pt12">
<p>
	<table><tbody>
<tr>
<td colspan="2" align="right" class="dlink b">
			FastXAMPP для XAMPP 1.8.3-3  (linux 64 bit) ~ 20 Мб
		</td>
</tr>
<tr>
		<td>
			<img src="/img/d.png">
		</td>
		<td style="padding-bottom:5px">
			<a title="Download and extract the archive" href="http://seostat.xclan.ru/64-fastXAMPP-for-XAMPP-1.8.3-3-light.tar.gz" target="blank" class="dlink">Скачайте и распакуйте архив, после чего запустите файл Setup.</a>
		</td>
	</tr></tbody></table>
	 
</p> 
</div></div>

<div class="couter tou2"><div class="cinner tin2 pt12">
<p>
	<table><tbody>
<tr>
<td colspan="2" align="right" class="dlink b">
			FastXAMPP для XAMPP 1.8.3-3  (linux 32 bit) ~ 10 Мб
		</td>
</tr>
<tr>
		<td>
			<img src="/img/d.png">
		</td>
		<td style="padding-bottom:5px">
			<a title="Download and extract the archive" href="http://seostat.xclan.ru/fastXAMPP-for-XAMPP-1.8.3-light.tar.gz" target="blank" class="dlink">Скачайте и распакуйте архив, после чего запустите файл Setup.</a>
		</td>
	</tr></tbody></table>
	 
</p> 
</div></div>

<div class="couter tou2"><div class="cinner tin2 pt12">
<p>
	<table><tbody>
<tr>
<td colspan="2" align="right" class="dlink b">
			FastXAMPP, XAMPP 1.8.3-3, PHP 5.5.9 (linux 32 bit) ~ 130 Мб
		</td>
</tr>
<tr>
		<td>
			<img src="/img/d.png">
		</td>
		<td style="padding-bottom:5px">
			<a title="Download and extract the archive" href="https://drive.google.com/file/d/0B4iNGN_yK6gNNHFIZnhLaE9XNms/edit?usp=sharing" target="blank" class="dlink">Скачайте и распакуйте архив, после чего запустите файл Setup.</a>
		</td>
	</tr></tbody></table>
	 
</p> 
</div></div>

<div class="couter tou2"><div class="cinner tin2 pt12">
<p>
	<table><tbody>
<tr>
<td colspan="2" align="right" class="dlink b">
			FastXAMPP, XAMPP 1.7.1, PHP 5.3.5 (linux 32 bit)
		</td>
</tr>
<tr>

		<td>
			<img src="/img/d.png">
		</td>
		<td style="padding-bottom:5px">
			<a title="Download and extract the archive" href="http://seostat.xclan.ru/fastxampp.1.7.4.tar.gz" class="dlink">Скачайте и распакуйте архив, после чего запустите файл Setup.</a>
		</td>
	</tr></tbody></table>
	 
</p> 
</div></div>


<?php // /files/fastxampp.1.7.4.tar.gz
	$text_content = ob_get_clean();
	$r = $_SERVER["DOCUMENT_ROOT"];
	include "$r/master.php";
?>
