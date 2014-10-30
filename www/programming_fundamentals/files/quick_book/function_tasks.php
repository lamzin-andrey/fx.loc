<header>
	<h3>Задачи на функции</h3>
</header>
<div class="ainfo">В текстах заданий могут упоминаться "процедуры". Это связанно с тем, что задачки задумывались для языка программирования Паскаль, в нем функция, не возвращающая значение вызывающей программе называется процедурой. В JavaScript такого понятия нет, если нам не надо возвращать значения из функции, мы его просто не возвращаем.</div>
<h4>Первая задача</h4>
<p>Составить функцию для нахождения наименьшего нечетного натурального делителя k (k != 1) любого заданного натурального числа n. </p>
<pre>
<b>function</b> example_6_1() {
	<b>var</b> n = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">'Введите целое число N'</span>) ), r;
	<b>if</b> (<i>isNaN</i>(n)) {
		<u>writeln</u>(<span class="strcolor">'Недопустимое значение'</span>);
		<b>return</b>;
	}
	
	<b>function</b> <u title="Получить наименьший делитель">getMinimumDivider</u>(n) {
		<b>var</b> i, result;
		<b>for</b> (i = 3; i < n; i = i + 2) {
			result = n / i;
			<b>if</b> (result == <b>Math</b>.<i>floor</i>(n / i)) {
				<b>return</b> i;
			}
		}
		<b>return</b> <b>false</b>;
	}
	
	<b>if</b> ( r = <u title="Получить наименьший делитель">getMinimumDivider</u>(n) ) {
		<u>writeln</u>(<span class="strcolor">"Наименьший нечетный делитель числа "</span> + n + <span class="strcolor">" равен "</span> + r);
	} <b>else</b> {
		<u>writeln</u>(<span class="strcolor">"У числа "</span> + n + <span class="strcolor">" не существует нечетного делителя в пределах (1,"</span> + n + <span class="strcolor">")"</span>);
	}
}
</pre>
<p>Здесь я уже привычно получаю введенное с клавиатуры значение и привожу его к целому числу. Если это оказалось не числом, вывожу сообщение об ошибке и завершаю программу.</p>
<p>Однако логику нахождения наименьшего нечетного делителя я перенес в функцию getMinimumDivider. Алгоритм в функции проще не придумаешь: в цикле <b>for</b> от 3 до n - 1 включительно делю заданное число n на i (думаю и для кого уже не новость, что i принимает значения от 3 до n - 1, однако обратите внимание, что в данном цикле оно изменяется с шагом 2, чтобы все числа были нечетными (мы ищем нечетный делитель) ). Как только частное n / i становится равно своему же округлению вниз (floor округляет вниз, то есть <b>Math</b>.<i>floor</i>(3.9) вернет 3), считаем, что мы нашли то, что искали. Возвращаем i, используя <b>return</b>. Если найти наименьший делитель не удалось (все попытки разделить n на i отдают дробный результат), возвращаем из функции <b>false</b>.</p>
<p>Далее, я вызываю функцию getMinimumDivider и проверяю , не равно ли возвращенное ей значение <b>false</b>. Фрагмент кода </p>
<p><b>if</b> ( r = <u title="Получить наименьший делитель">getMinimumDivider</u>(n) ) {...</p>
<p> работает так же как сработал бы код</p>
<p>r = <u title="Получить наименьший делитель">getMinimumDivider</u>(n);</p>
<p><b>if</b> (r) {...</p>
<p>Напомню, что при передаче в круглые скобки после <b>if</b> переменной <b>if</b> работает так: если переменная равна <b>false</b>, <b>null</b>, 0, <b>NaN</b>, <b>undefined</b> или пустой строке <span class="strcolor">''</span>, то вход в блок в фигурных скобках сразу после <b>if</b>(...) не произойдет. </p>
<p>То есть блок</p>
<p><b>if</b> ( r = <u title="Получить наименьший делитель">getMinimumDivider</u>(n) ) {...</p>
<p>работает так: вычисляется <u title="Получить наименьший делитель">getMinimumDivider</u>(n), вычисленное значение помещается в r, значение в обрабатывается условным оператором <b>if</b>.</p>
<h4>Вторая задача</h4>
<p>Дано четное число n > 2. Проверить для него гипотезу Гольдбаха: каждое  четное n представляется в виде суммы двух простых чисел. </p>
<pre>
<b>function</b> <u>example_6_2</u>() {
	<span class="strcolor">"use strict"</span>
	<b>var</b> n = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">'Введите четное целое число N > 2'</span>) ), inputErrorMessage = <span class="strcolor">'Было введено недопустимое значение, выход'</span>,
		r, a, b;
	<b>if</b> (<i>isNaN</i>(n)) {
		<u>writeln</u>(inputErrorMessage);
		<b>return</b>;
	}
	r = ( <b>Math</b>.<i>floor</i>(n / 2) === (n / 2));<span class="strcolor">//n - четное число?
</span>	<b>if</b> (!r) {
		<u>writeln</u>(inputErrorMessage);
		<b>return</b>;
	}
	<b>if</b> (n < 4 ) {
		<u>writeln</u>(inputErrorMessage);
		<b>return</b>;
	}
	<span class="strcolor">//n - простое число?
</span>	<b>function</b> <u title="n - простое число?">isSimpleNumber</u>(n) {
		<b>var</b> x = 2, ctrl1, ctrl2;
		<b>for</b> (x; x < n; x = x + 1) {
			ctrl1 = n / x;
			ctrl2 = <b>Math</b>.<i>floor</i>(ctrl1);
			<b>if</b> (ctrl1 == ctrl2) {
				<b>return</b> <b>false</b>;
			}
		}
		<b>return</b> <b>true</b>;
	}
	<span class="strcolor">//Получить следующее простое, большее чем аргумент. Аргумент - простое число.
</span>	<b>function</b> <u title="Получить следующее простое, большее чем n">getNextSimpleNumber</u>(n) {
		<b>var</b> firstSimpleNumbers = [2,3,5,7,11,13,17,19,23,29,31,37,41], i, D, x;
		<b>if</b> (n < 41) {
			<b>for</b> (i = 0; i < firstSimpleNumbers.length; i++) {
				<b>if</b> (firstSimpleNumbers[i] > n) {
					<b>return</b> firstSimpleNumbers[i];
				}
			}
		} <b>else</b> <b>if</b> (n > 41 && n < 1601 ) {
			D = 1 - 4*(41 - n); <span class="strcolor">//Дискриминант</span>
			x = (-1 + Math.sqrt(D)) / 2;
			n = x * x + x + 41;
			<b>return</b> n;
		} <b>else</b> {
			n += 2;
			<b>if</b> (n / 2 == <b>Math</b>.<i>ceil</i>( n / 2)) { <span class="strcolor">//вдруг было передано четное n
</span>				n += 1;
			}
			<b>while</b> (true) {
				<b>if</b> (<u title="n - простое число?">isSimpleNumber</u>(n)) {
					<b>return</b> n;
				}
				n += 2;
			}
		}
	}
	b = 2;
	a = n - b;
	<b>while</b> (!(<u title="a - простое число?">isSimpleNumber</u>(a) && <u title="b - простое число?">isSimpleNumber</u>(b)) ) {<span class="strcolor">//пока a и b не простые числа
</span>		b = <u title="Получить следующее простое, большее чем b">getNextSimpleNumber</u>(b);
		<b>if</b> (b > n) {
			<u>writeln</u>(<span class="strcolor">"Не удалось найти два простых слагаемых для n = "</span> + n);
			<b>return</b>;
		}
		a = n - b;
	}
	<u>writeln</u>(n + <span class="strcolor">" состоит из двух простых слагаемых "</span> + a + <span class="strcolor">" и "</span> + b);
}
</pre>
<p>Для решения задачи мне понадобится функция, определяющая, простое ли число n. Я назвал её isSimpleNumber. 
Также понятно, что недостаточно вычесть из четного n первое попавшееся простое число, чтобы осталось еще одн простое. 
Об этом говорит тот факт, что вычтя из шести (четное число) двойку (простое число) я получу непростое число четыре. 
Значит, мне нужна функция, которая возвращает очередное простое число. Я назову ее getNextSimpleNumber. 
Я не математик, но я могу увеличивать каждое простое число большее двойки на два и проверять, а не получилось ли простое. 
Однако, решая эти примеры я познакомился с формулой F = x*x + x + 41 котрая дает простые числа при x принадлежащем интервалу [0, 40). 
Простых чисел от двух до сорока одного немного, поэтому я выписал их в массив. 
Если функция getNextSimpleNumber получает аргумент мньше 41, она просто проходит по этому массиву, иначе хочется использовать формулу.
Но я могу это сделать когда n не больше чем значение F(39) = 1601, так как F(40) дает непростое число. 40 * 40 + 40 + 41 = 1681.
Также, мне необходимо найти x чтобы получить F(x + 1). Значит, мне нужна еще одна функция, решающее квадратное уравнение.
Впрочем, здесь частный случай, когда коэффициенты квадратного уравнения a и b равны единицам, C всегда равно 41 - n, и я жду корень больший 0.
Это упрощает задачу и я не стал выносить ее в отдельную функцию. В случае, когда n >= 1601 я начинаю увеличивать аргумент на два и проверять, а не получилось ли простое число.
</p>
<p>После того, как обе вспомогательных функций реализованы, поиск простых чисел , сумма которых дает заданное n становится простым. Я отнимаю от n наименьшее простое число 2 и запускаю цикл, который выполняется до тех пор, пока оба слагаемых не станут простыми числами.
Если в процессе очередное простое число оказалось больше, чем n я вывожу сообщение, что для заданного n не удалось найти два простых слагаемых.</p>
<h4>Рекурсия, поведение аргументов функции, понятие о тестировании кода</h4>
<p>Есть задача: дано n различных натуральных чисел. Напечатать все перестановки этих чисел.</p>
<p>Для того, чтобы понять мое решение этой задачи, надо иметь представление о рекурсивных алгоритмах а также о том, как ведут себя аргументы, передаваемые функциям. Начну с аргументов, потому что это проще.</p>
<p>Пусть есть функция, которая принимает в качестве аргументов массив, объект, число и строку.</p>
<pre>
<b>function</b> <u title="Пример поведения аргументов">argumentsBehaviorExample</u> () {
	<span class="strcolor">"use strict"</span>
	<b>var</b> my_array = [1, 2, 3],
		my_object = {x:1, y:2},
		n = <b>new</b> <b>Number</b>(5),
		s = <b>new</b> <b>String</b>(<span class="strcolor">'Hello'</span>);
	<b>function</b> <u title="Просто функция">F</u>(array, object, number, string) {
		array[0] = 99;
		object.x = 99;
		number = 99;
		string = <span class="strcolor">'99'</span>;
	}
	<u>writeln</u>(<span class="strcolor">"my_array[0] = "</span> + my_array[0] + <span class="strcolor">", my_object.x = "</span> + my_object.x + <span class="strcolor">", n = "</span> + n + <span class="strcolor">", s = "</span> + s);
	<u title="Просто функция">F</u>(my_array, my_object, n, s);
	<u>writeln</u>(<span class="strcolor">"my_array[0] = "</span> + my_array[0] + <span class="strcolor">", my_object.x = "</span> + my_object.x + <span class="strcolor">", n = "</span> + n + <span class="strcolor">", s = "</span> + s);
}
</pre>
<p>Я специально использовал при определении (инициализации) переменных n и s конструкторы, чтобы убедится, что в данном случае их использование или не использование не играет никакой роли.
Мы видим, что после вызова функции F значения переменных массив и объект изменились, а значения переменных строка и число не изменилось.
Это надо учитывать при передаче функции параметров при ее вызове.</p>
<p>Перейдем к рекурсии. При решении третьего примера по теме Циклы я уже описывал функцию вычисления факториала. Напомню свое решение:</p>
<pre>
<b>function</b> <u>factorial</u>(n) {
		n = <i>parseInt</i>(n);
		<b>if</b> (!n) {
			n = 0;
		}
		<b>if</b> (n < 2) {
			<b>return</b> 1;
		}
		<b>var</b> result = 1;
		<b>for</b> (<b>var</b> i = 1; i <= n; i++) {
			result = result * i;
		}
		<b>return</b> result;
	}
</pre>
<p>Привожу аругмент к целому числу. Если это вдруг оказалось не число, принимаю его равным нулю. Если число меньше двух, возвращаю единицу, так как 0! равен 1. Далее от единицы до n включительно умножаю значение i на результат и запоминаю это произведение в результате. Результат возвращаю, это факториал числа n.</p>
<p>Но можно посчитать факториал и другим способом, используя рекурсию.</p>
<pre>
<b>function</b> <u title="Пример рекурсивного вычисления факториала">recursiveFactorialExample</u>() {
	<span class="strcolor">"use strict"</span>
	<b>var</b> n = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">'Введите n'</span>) );
	<b>if</b> (<i>isNaN</i>(n)) {
		n = 0;
	}
	<b>var</b> f = <u title="Рекурсивное вычисление факториала">recursiveFactorial</u>(n);
	<b>function</b> <u title="Рекурсивное вычисление факториала">recursiveFactorial</u>(n) {
		<b>if</b> (<i>isNaN</i>(n)) {
			n = 0;
		}
		<b>if</b> (n < 2) {
			<b>return</b> 1;
		}
		<b>return</b> n * <u title="Рекурсивное вычисление факториала">recursiveFactorial</u>(n - 1);
	}
	<u>writeln</u>(<span class="strcolor">"Факториал "</span> + n + <span class="strcolor">" = "</span>  + f);
}
</pre>
<p>Здесь я пользуюсь тем, что факториал любого числа n равен n умноженное на факториал n - 1. При этом факториал нуля равен 1, единицы соответственно тоже (1 * 0! = 1). Поэтому я внутри функции recursiveFactorial беру аргумент, и умножаю его на результат вызова функции recursiveFactorial которой передаю свой аргумент минус единица.</p>
<p>Функция, которая в процессе своей работы вызывает саму себя, называется <b class="tblack">рекурсивной</b>.</p>
<p>Перейдем теперь к решению задачи (дано n различных натуральных чисел. Напечатать все перестановки этих чисел).
Мое решение этой задачи вряд ли можно считать эталоном в смысле производительности алогритма, но зато оно мое собственное и ниже мы убедимся, что оно еще и верное.
</p>
<p>Очевидно, что наиболее простым представляется частный случай, когда n = 2 (n < 2 не рассматриваю, так как там переставлять нечего).
В этом случае всего два варианта перестановки: исходный и отраженный. Имея понятие о рекурсивных функциях, довольно легко догадаться, что для любого n > 2 можно 
просто переставить два числа в исходном множестве, а потом передать полученное сочетание в рекурсивную функцию, которая сделает то же самое, но будет работать с  n - 1 элементом.
Вот что я имею ввиду (красным обозначены элементы, которые будут переставлены):
</p>
<p>Первый вызов функции</p>
<p class="tred">1,2,3,4, ...</p>
<p>Следующий вызов функции:</p>
<p>1,2,<span class="tred">3,4, ...</span></p>
<p>Следующий вызов функции:</p>
<p>1,2,3,<span class="tred">4, ...</span></p>
<p>И так далее...</p>
<p></p>
<pre>
<b>function</b> combinations() {
	<b>var</b> s = <b>String</b>(<u>readln</u>(<span class="strcolor">"Введите несколько чисел разделяя их запятой"</span>)),
		array = s.<i>split</i>(<span class="strcolor">","</span>), i, ctrl;
	<b>for</b> (i = 0; i < array.length; i++) {
		ctrl = <i>parseInt</i>(array[i]);
		<b>if</b> (<i>isNaN</i>(ctrl) || ctrl != array[i]) {
			<u>writeln</u>(<span class="strcolor">"Недопустимые данные. Выход"</span>);
			<b>return</b>;
		}
	}
	<b>function</b> writeVariants(array, n) {
		<b>if</b> (!n) {
			n = 0;
		}
		<b>var</b> lim, i, j, b;
		lim = (array.length - n) * (array.length - n - 1) + (array.length - n - 1);
		<b>if</b> (array.length - n < 2) {
			<b>return</b>;
		}
		<span class="strcolor">//writeln("Вывод: (lim = " + lim + ")");
</span>		<b>for</b> (i = 0, j = n; i <= lim; i++, j++) {
			<b>if</b> (j == array.length - 1) {
				array[j] = b;
				<b>if</b> (i < lim || n == 0) {
					<u>writeln</u>(array.<i>toString</i>());
				}
				writeVariants(array, n + 1);
				j = n - 1;
				<b>continue</b>;
			}
			<b>if</b> (j == n) {
				b = array[j];
			}
			array[j] = array[j + 1];
			
			<span class="strcolor">//writeln('"' + array.toString() + '"');
</span>		}
	}
	<u>writeln</u>(<span class="strcolor">"Сочетания:"</span>);
	writeVariants(array);
}
</pre>
<p></p>
<p></p>
<div style="width:96%">
<div class="left"><a href="<?=WEB_ROOT?>/quick_start/cycles">Назад - <?=$lang['cycles']?></a></div>
<div class="right"><a href="<?=WEB_ROOT?>/quick_start/arrays">Далее - <?=$lang['arrays']?></a></div>
<div class="clearfix"></div>
</div>
