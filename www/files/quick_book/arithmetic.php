<header>
	<h3>Арифметические операции</h3>
</header>
<h4>Простые вычисления</h4>
<p>Вычислить</p>
<p><?=QuickStartHandler::tim(24, 1, 1)?></p>
<p>Здесь все просто, вспоминаем про приоритеты математических операций, в любом компиляторе или интерпретаторе они точно такие же.
То есть деление и умножение выполняются раньше сложения и вычитания. Скобки имеют наивысший приоритет.
Значит, пишем
<pre>
	<b>function</b> example_1() {
		<b>var</b> x = <u>readln</u>('Введите x'),
			y = <u>readln</u>('Введите y');
		<b>var</b> result = ( (x + y) / (x*x - x*y) ) - ( (3*x + y) / (y*y - x*x) );
		<u>writeln</u>('Результат: ' + result);
	}
</pre>
</p>
<div class="pfont11">
	<p>Проверив для x = 12 и y = 45 мы можем убедиться, что: </p>
	<p>12 + 45 = 57</p>
	<p>144 - 540 = -396</p>
			
	<p>36 + 45 = 81</p>
	<p>2025 - 144 = 1881</p>
			
	<p>57/-396=−0,143939394</p>
	<p>81/1881=0,043062201</p>
	<p>−0,143939394 - 0,043062201 = −0,187001595</p>
</div>
<p>Что полностью соответствует выводу приложения в "псевдоокне". Однако, успокаиваться рано.</p>
<p>Запустим пример и введем в качестве x и y единицы. Результат будет не очень хороший: мы ожидаем получить какое-то числовое значение, но мы видем в выводе: <pre class="no_lines"><b>NaN</b></pre></p>
<p>Происходит это потому, что я совершенно не учел в примере, что в результате вычисления выражений в знаменателе может получиться 0.</p>
<div class="ainfo">Например в  C/C++ или Pascal, при такой ситуации возникла бы ошибка при выполнении программы - там деление на 0 это невозможно. Но в JavaScript в таком случае получается специальное значние "Бесконечность" - Infinity. Однако, вычесть из одной бесконечности другую мы не можем, в результате у нас получается другое специальное значение: NaN - "не число". </div>
<p>Добавлю контроль того, что получается в знаменателе, а заодно и контроль вводимых значений:
<pre>
	<b>function</b> example_1() {
		<b title='Denominator - знаменатель, говорит гугл транслятор'>var</b> x = <i title='Стандартная функция, приводит свой аргумент к целому числу'>parseInt</i>( <u>readln</u>('Введите x') ),
			y = <i title='Стандартная функция, приводит свой аргумент к дробному числу'>parseFloat</i>( <u>readln</u>('Введите y') ),
			denominator_1 = x*x - x*y,
			denominator_2 = y*y - x*x;
			<b>if</b>(<i title='не число?'>isNaN</i>(x) || <i title='не число?'>isNaN</i>(y) ) {//если x не число или y не число
				<u>writeln</u>('x и y должны быть числами!');
				<b>return</b>;
			}
			<b title='//Восклицательный знак перед именем переменной - оператор алгебры логики "Не".'>if</b>(!denominator_1 || !denominator_2 ) {
				<u>writeln</u>('Деление на 0! Аварийный выход.');
				<b>return</b>;
			}
		<b>var</b> result = ( (x + y) / denominator_1 ) - ( (3*x + y) / denominator_2 );
		<u>writeln</u>('Результат: ' + result);
	}
</pre></p>
<p>Я привожу х к целому числу, y к дробному. Если бы пришлось писать подобную функцию на практике я бы скорее всего привел к дробному в обоих случаях. Но у меня появился шанс рассказать о стандартной функции parseInt  и я не стал его упускать.
Эта функция берет свой аргумент и пытается опознать в нем целое число.
Самостоятельно добавьте в текст программки несколько строк вида  <pre class="no_lines"><u>writeln</u>('value = ' + <i>parseInt</i>(a));</pre>
</p>
<p>вместо a используйте различные строковые значения (строковые константы), например 
'123adsafdads', 'dsadss1123', 'a5'. </p>
<p>parseInt может принимать второй аргумент. Он указывает основание системы счисления, например <pre class="no_lines"><i>parseInt</i>('a5', 16);</pre> вернет число, в отличии от parseInt('a5'). Потому что а в шестнадцатиричной системе счисления вполне допустимая цифра, а если не передавать второй аргумент, parseInt пытается работать в десятиричной.</p>
<p>parseFloat - это почти та же история. Только она пытается получить дробное число из строки. Для отделения целой части числа от дробной в программироании используется точка. </p>
<p>isNaN - смотрите подсказку к <pre class="no_lines"><b>NaN</b></pre></p>
<p>Две прямых линии - оператор алгебры логики "Или" </p>
<p>Восклицательный знак перед именем переменной - оператор алгебры логики "Не". Его использование пожалуй стоит рассмотреть чуть подробнее.
<pre>
<b>function</b> ifExample () {
	<b>var</b> a = <b>false</b>, b = <b>true</b>; <span class="strcolor">//Записали в а значение "Ложь", в b "Истина"
</span>	<b>if</b> (!a) { <span class="strcolor">//Если не а
</span>		<i>alert</i>(<span class="strcolor">"а- ложно"</span>);
	}
	<b>if</b> (b) { <span class="strcolor">//Если b
</span>		<i>alert</i>(<span class="strcolor">"b - истинно"</span>);
	}
	<span class="strcolor">//Условие !a будет также выполняться, если a равно 0, '0', '' (пустой строке), NaN, undefined
</span>}

</pre></p>
<h4>Вычисления с использованием математических функций</h4>
<p>Вычислить</p>
<p><?=QuickStartHandler::tim(24, 1, 2)?></p>
<p>Пример мало чем отличается от предыдущего, однако тут появилась функция косинуса угла. Также, нам понадобится вычислить квадратный корень. Возьмем предыдущий пример и немного перепишем его для данной нам формулы.
<pre>
	<b>function</b> example_2() {
		<b>var</b> alpha = <i title='Стандартная функция, приводит свой аргумент к целому числу'>parseInt</i>( <u>readln</u>('Введите угол альфа в градусах') ),
					cosAlpha = <b>Math</b>.<i>cos</i>(<b>Math</b>.PI * alpha/ 180);
			denominator_1 = 1 + cosAlpha,
			denominator_2 = 1 - cosAlpha;
			<b>if</b>(<i title='не число?'>isNaN</i>(alpha) ) {//если альфа не число
				<u>writeln</u>('альфа должны быть числом!');
				<b>return</b>;
			}
			<b title='//Восклицательный знак перед именем переменной - оператор алгебры логики "Не".'>if</b>(!denominator_1 || !denominator_2 ) {
				<u>writeln</u>('Деление на 0! Аварийный выход.');
				<b>return</b>;
			}
		<b>var</b> result = <b>Math</b>.<i title='square root  - квадратный корень'>sqrt</i>(denominator_2 / denominator_1) - <b>Math</b>.<i title='square root  - квадратный корень'>sqrt</i>(denominator_1 / denominator_2);
		<u>writeln</u>('Результат: ' + result);
	}
</pre>
</p>
<p>Так как я работаю только с косинусом введенного числа, я тут же получаю его с помощью объекта Math, вызвав его метод cos. Наверное не ошибусь, если скажу, что большинство из нас привыкло измерять углы в градусах. Но Math.cos ждет от нас радианы. Я перевожу его в радианы, умножив на 3,14 и разделив на 180. </p>
<p>Ну и далее я использую метод Math.sqrt для того, чтобы извлечь квадратный корень. Остальные моменты примера вам должныбыть понятны, если это не так, вернитись к предыдущему примеру.</p>
<h4>Задачка на сообразительность</h4>
<p>Дано действительное число x. Не пользуясь никакими другими арифметическими операциями, кроме умножения, сложения и вычитания, вычислить за минимальное число операций <?=QuickStartHandler::tim(24, 1, 3)?></p>
<p>Посчитаем, сколько операций выполняется при простом вычислении.</p>
<pre class="no_lines">
	<b>var</b> result = 2 * x * x * x * x - 3 * x * x * x  + 4 * x * x - 5 * x + 6; //15 (операция присваивания = - тоже операция)
</pre>
<p>Но мы можем преобразовать выражение:</p>
<pre class="no_lines">
	<b>var</b> result = 2 * x * x * (x * x + 2) + 6 - x * (3 * x * x + 5); //12 операций
</pre>
<p>В полном коде проверю, не ошибся ли я с преобразованием.</p>
<pre>
	<b>function</b> example_3() {
		<b>var</b> x = <i title='Стандартная функция, приводит свой аргумент к целому числу'>parseInt</i>( <u>readln</u>('Введите х') );
		<b>if</b>(<i title='не число?'>isNaN</i>(x) ) {//если x не число
			<u>writeln</u>('x должен быть числом!');
			<b>return</b>;
		}
		<b>var</b> result = 2 * x * x * (x * x + 2) + 6 - x * (3 * x * x + 5),
		controlResult = 2 * x * x * x * x - 3 * x * x * x  + 4 * x * x - 5 * x + 6;
		<b>if</b> (result != controlResult) {
			<i>alert</i>('Видимо что-то не так!');
		}
		<u>writeln</u>('Результат: ' + result);
	}
</pre>
<?=QuickStartHandler::prevnext('begin', 'branching');?>