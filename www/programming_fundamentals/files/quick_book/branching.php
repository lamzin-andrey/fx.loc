<header>
	<h3>Арифметические операции</h3>
</header>
<h4>Простые вычисления</h4>
<p>Вычислить</p>
<p><?=QuickStartHandler::tim(23, 2, 1);?></p>
<pre>
<b>function</b> example_2_1() {
	<b>var</b> x = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">'Введите х'</span>) );
	<b>if</b>(<i>isNaN</i>(x) ) {<span class="strcolor">//если x не число
</span>		<u>writeln</u>(<span class="strcolor">'x должен быть числом!'</span>);
		<b>return</b>;
	}
	<b>var</b> result;
	<b>if</b> (x >= -7) {<span class="strcolor">//Если x больше или равен -7 
</span>		result = -1 * x*x;
	} <b>else</b> {<span class="strcolor">//Иначе... 
</span>		result = <b>Math</b>.<i>pow</i>(2, -1*x) / (x*x - 9) ;
	}
	<u>writeln</u>(<span class="strcolor">'Результат: '</span> + result);
}
</pre>
<p>Овобенно объяснять тут мне кажется нечего. Больше или равно записывается как >=, меньше или равно как <=, не равно как !=. Надеюсь очевидно, что больше и меньше пишутся > и <. Проверка на равенство пишется как == или ===, про второй случай чуть подробнее написано в конце раздела <a href="<?=WEB_ROOT?>/quick_start/datatypes"><?=$lang['datatypes']?></a></p>
<p>Перейду к следующему заданию:  Определить правильность даты, введенной с клавиатуры (число – от 1 до 31, месяц – от 1 до 12). Если введены некорректные данные, то сообщить об этом</p>
<pre>
<b>function</b> example_2_2() {
	<b>var</b> day = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">'Введите число месяца, от 1 до 31'</span>) );
	<b>var</b> month = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">'Введите номер месяца от 1 до 12'</span>) );
	<b>var</b> daysInMonth = [0, 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];<span class="strcolor">//дней в месяцах
</span>	<b>if</b>(<i>isNaN</i>(day) || <i>isNaN</i>(month) || day < 1 || month < 1 || month > 12 || day > daysInMonth[month]) {
		<u>writeln</u>(<span class="strcolor">'Некорректные данные!'</span>);
		<b>return</b>;
	}
	<u>writeln</u>(day + <span class="strcolor">' / '</span> + month + <span class="strcolor">' - Хорошая дата ;-)'</span>);
}
</pre>
