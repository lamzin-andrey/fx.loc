<header>
	<h3>Арифметические операции</h3>
</header>
<p>Вычислить</p>
<p><?=QuickStartHandler::tim(24, 1, 1)?></p>
<p>Здесь все просто, вспоминаем про приоритеты математических операций, в любом компиляторе или интерпретаторе они точно такие же.
То есть деление и умножение выполняются раньше сложения и вычитания. Скобки имеют наивсший приоритет.
Значит, пишем
<pre>
	<b>function</b> example_1() {
		<b>var</b> x = <u>readln</u>('Введите x'),
			y = <u>readln</u>('Введите y');
		<b>var</b> result = ( (x + y) / (x*x - x*y) ) - ( (3*x + y) / (y*y - x*x) );
		// 12 + 45 = 57
		// 144 - 540 = -396
		
		// 36 + 45 = 81
		// 2025 - 144 = 1881
		
		//57/-396=−0,143939394
		//81/1881=0,043062201
		<u>writeln</u>('Результат: ' + result);
	}
</pre>
</p>

<div style="width:96%">
<div class="left"><a href="<?=WEB_ROOT?>/quick_start/datatypes">Назад - <?=$lang['datatypes']?></a></div>
<div class="right"><a href="<?=WEB_ROOT?>/quick_start/exception">Далее - <?=$lang['exception_st']?></a></div>
<div class="clearfix"></div>
</div>
