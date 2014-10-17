<header>
	<h3>Ветвление</h3>
</header>
<h4>Использование if ... else </h4>
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
</span>		result = <b>Math</b>.<i title='Возводит первый аргумент в степень второй аргумент'>pow</i>(2, -1*x) / (x*x - 9) ;
	}
	<u>writeln</u>(<span class="strcolor">'Результат: '</span> + result);
}
</pre>
<p>Особенно объяснять тут мне кажется нечего. Больше или равно записывается как >=, меньше или равно как <=, не равно как !=. Надеюсь очевидно, что больше и меньше пишутся > и <. Проверка на равенство пишется как == или ===, про второй случай чуть подробнее написано в конце раздела <a href="<?=WEB_ROOT?>/quick_start/datatypes"><?=$lang['datatypes']?></a></p>
<p>Перейду к следующему заданию:  Определить правильность даты, введенной с клавиатуры (число – от 1 до 31, месяц – от 1 до 12). Если введены некорректные данные, то сообщить об этом.</p>
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
<p>Здесь я использую массив daysInMonth, чтобы контролировать, не выходит ли заданное пользователем значение дня месяца за пределы существующих в заданном им же месяце дней. 
Я создал массив из тринадцати элементов, в каждый из которых я поместил количество дней, соответствующее месяцу номер такой-то.
Из тринадцати, а не из двенадцати, потому что элементы массивов нумеруются с нуля. 
Я мог бы использовать двенадцать элементов, а  в условии <b>if</b> написать daysInMonth[month - 1] вместо daysInMonth[month]</p>
<p>В условии <b>if</b> этого примера я воспользовался тем, как работает оператор ||. У меня логическое выражение с шестью слагаемыми, два первых - это вызов isNaN с различными аргументами, остальные - проверки на вхождение заданных значений в нужные мне пределы. Пользователь может ввести в качестве номера месяца число более 12, ему ничего не мешает это сделать.
Но тогда daysInMonth[month] будет равно <b>undefined</b>  и условие day > daysInMonth[month] не будет иметь смысла, а во многих других языках программирования попытка получить несуществующий элемент массива привела бы к ошибке. 
</p>
<p>Но оператор || работает так, что как только выполняется одно из условий передаваемых в качестве слагаемых, дальнейшая проверка не выполняется. В самом деле, зачем это делать: логическое ИЛИ (||) истинно если истинно хотя бы одно из входящих в него значений. Таким образом, если пользователь вводит номер месяца от не равный интервалу [1,12] интерпретатор JavaScript просто не дойдет до последнего слагаемого! Таким образом, программа работает корректно.</p>
<p>В задании ничего не сказано о такой важной составляющей даты как год. Поэтому я поместил в февраль 29 дней, так как год может быть високосным. Но так как тема этого упражнения - условные операторы, я немного усложню задачу и добавлю ввод года, так как определение високосный ли данный год это просто прекрасный пример использования условных операторов. 
Если год без остатка делится на 4, он високосный. Но, если он при этом делится без остатка на 100, но не делится на 400 - он не високосный.
Добавлю соответствующую функцию определения високосности года  и код, который перепишет значение количества дней в феврале в зависимости от этого.</p>
<pre>
<b>function</b> example_2_2() {
	<b>var</b> day = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">'Введите число месяца, от 1 до 31'</span>) ),
	month = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">'Введите номер месяца от 1 до 12'</span>) ),
	year  = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">'Введите номер года'</span>) ),
	daysInMonth = [0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];<span class="strcolor">//дней в месяцах</span>
	
	<b>function</b> <u title='високосный ли год?'>isLeapYear</u>(year) {
		<b>var</b> y = <b>Number</b>(year);
		<b>if</b> (y % 4 == 0) {
			<b>if</b> (y % 100 == 0){
				<b>if</b> (y % 400 == 0) {
					<b>return</b> <b>true</b>;
				}
				<b>return</b> <b>false</b>;
			}			
			<b>return</b> <b>true</b>;
		}
		<b>return</b> <b>false</b>;
	}
	
	<b>if</b>(<u title='високосный ли год?'>isLeapYear</u>(year)) {
		daysInMonth[2] = 29;
	}
	
</span>	<b>if</b>(<i>isNaN</i>(day) || <i>isNaN</i>(month) || <i>isNaN</i>(year) || day < 1 || month < 1 || month > 12 || day > daysInMonth[month]) {
		<u>writeln</u>(<span class="strcolor">'Некорректные данные!'</span>);
		<b>return</b>;
	}
	<u>writeln</u>(day + <span class="strcolor">' / '</span> + month + <span class="strcolor">' / '</span> + year + <span class="strcolor">' - Хорошая дата ;-)'</span>);
}
</pre>
<h4>Тернарный оператор</h4>
<p>Очередное задание выглядит так: Логической переменной b присвоить значение <b>true</b>, если числа а и b равны и <b>false</b> в противном случае. </p>
<p>Сделать это в JavaScript очень просто:</p>
<pre>
<b>function</b> example_2_3() {
	<b>var</b> x = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">'Введите x'</span>) ),
		y = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">'Введите y'</span>) ),
		b;
	b = (x == y);<span class="strcolor">//В переменную b помещаем результат операции сравнения ==</span>
	<u>writeln</u>(<span class="strcolor">'b = '</span> + b);
}
</pre>
<p>Но, что было бы, если бы нас просили поместить в переменную b значение 100 если a равно b  и 500 в противном случае? Можно было бы использовать уже привычный нам подход:</p>
<pre>
<b>function</b> example_2_3_1() {
	<b>var</b> x = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">'Введите x'</span>) ),
		y = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">'Введите y'</span>) ),
		b;
	<b>if</b> (x == y) {
		b = 100;
	} <b>else</b> {
		b = 500;
	}

	<u>writeln</u>(<span class="strcolor">'b = '</span> + b);
}
</pre>
<p>А можно написать вот так:</p>
<pre>
<b>function</b> example_2_3_1() {
	<b>var</b> x = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">'Введите x'</span>) ),
		y = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">'Введите y'</span>) ),
		b;
	b = x == y ? 100 : 500; //<span class="strcolor">//с тем же успехом</span>
	<u>writeln</u>(<span class="strcolor">'b = '</span> + b);
}
</pre>
<p>Тернарный оператор Условие?Истинно:Ложно возврашает значение получающееся в результате вычисления выражения (или как у меня готовое значение) между ?  и : если условие перед ? выполняется.
Если условие перед ? не выполняется, возвращается результат вычисления выражения (или как у меня готовое значение) после :. Тернарным он называется, потому что принимает три операнда (условие и два выражения).</p>
<h4>Испольование switch</h4>
<p>Когда надо выполнить определенные действия если значение переменной равно какому-то из длинного перечня значений, удобно использовать операторы switch ... case ... default</p>
<pre>
<b>function</b> switchExample() {
	<b>var</b> surname = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">'Введите известную фамилию'</span>) );
	<b>switch</b> (surname) {
		<b>case</b> <span class="strcolor">'Гагарин'</span>:
			<u>writeln</u>(<span class="strcolor">'Первый космонавт'</span>);
			<b>break</b>;
		<b>case</b> <span class="strcolor">'Путин'</span>:
			<u>writeln</u>(<span class="strcolor">'Президент'</span>);
			<b>break</b>;
		<b>default</b>:
			<u>writeln</u>(<span class="strcolor">'Не знаю, кто это.'</span>);
			<b>break</b>;
	}
}
</pre>
<p></p>
