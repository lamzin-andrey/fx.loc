<header>
	<h3>Массивы</h3>
</header>
<p>В задачах могут встречаться упоминания "одномерных", "двумерных", "n-мерных" массивов. Это связано с тем, что задачи писались для решения их на языке Pascal, в котором массив может быть двумерным "на уровне языка". Поэтому не стоит зацикливаться на этих прилагательных.</p>
<h4>Первая задача</h4>
<p>Найти сумму элементов, больших данного числа А (А вводится с клавиатуры).</p>
<pre>
<b>function</b> sumElementsGreatThanA() {
	<span class="strcolor">"use strict"</span>
	<b>var</b> array = [0,5,8,98,256,56,1,-265,0,696], <span class="strcolor">//Абсолютно наобум придумал себе массив
</span>		A = <i>parseFloat</i>(<u>readln</u>(<span class="strcolor">"Введите А"</span>)), i = array.length, sum = 0;
	<b>if</b> (<i>isNaN</i>(A)) {
		<u>writeln</u>(<span class="strcolor">"A должно быть числом!"</span>);
		<b>return</b>;
	}
	<b>while</b> (i--) { <span class="strcolor">//цикл будет выполняться, пока i != 0</span>
		<b>if</b> (array[i] > A) {
			sum += array[i];<span class="strcolor">//Так короче, чем sum = sum + array[i];</span>
		}
	}
	<u>writeln</u>(<span class="strcolor">"S = "</span> + sum);
}
</pre>
<p>Если вы разобрались с предыдущими примерами, этот вряд ли станет для вас непонятным.</p>
<p>Я объявил массив с именем array, поместил туда какие-то произвольные числа. Количество элементов в массиве можно получить используя свойство переменной (объекта типа) <b>Array</b> length. Элементы массива нумеруются от 0 до (array.length - 1). </p>
<p>Так как для решения задачи не имеет значения, проходить массив от начала к хвосту или наоборот, я иду от конца к началу. Это позволяет проверять, прекращать ли цикл, сравнивая i с нулем. Я уже упоминал рассматривая циклы о поведении операции i++, i-- ведет себя также. Если вы пропустили этот фрагмент читая про циклы, я приведу его еще раз:</p>
<pre>
<b>function</b> <u title="Поведение ++">plusPlusBehavior</u>() {
	<b>var</b> a, d, b = 1, c = 1;
	a = b++;<span class="strcolor">//Записали в a значение b, после чего увеличили b на единицу 
</span>	d = ++c;<span class="strcolor">//увеличили c на единицу, после чего записали в d значение c
</span>	<u>writeln</u>(<span class="strcolor">'a = '</span> + a + <span class="strcolor">', b = '</span> + b + <span class="strcolor">', c = '</span> + c + <span class="strcolor">', d = '</span> + d);
}
</pre>
<p>Таким образом, в коде примере sumElementsGreatThanA, в цикле я сначала сравниваю i c нулем, потом уменьшаю его на единицу и лишь потом выполняется тело цикла. Благодаря этому на первой итерации в условии </p>
<p><b>if</b> (array[i] > A) </p>
<p>i равно уже не array.length, а array.length - 1. Таким образом, я корректно прохожу по всем индексам массива, не выходя никогда за его пределы.</p>
<p>В условном операторе я сравниваю i-тый элемент массива с A после чего, если он больше чем A прибавляю его к сумме. В конце вывожу сумму. Все просто и прозаично.</p>
<h4>Вторая задача</h4>
<p>Ввести координаты ферзя и коня и определить: если конь ходит первым, то бьёт ли он ферзя.</p>
<p>Сначала напишу программку, а потом разберем ее, читайте также комментарии в коде. Потом я немного усложню (или скорее упрощу, так как станет меньше кода) реализацию.</p>
<pre>

<b>function</b> <u>chessStep</u>() {
	<b>var</b> chessBoard = [],<span class="strcolor">//Это будет шахматная доска
</span>	knightCoordinates = <u>readln</u>(<span class="strcolor">'Введите позицию коня, например e2 или h8'</span>), 
	queenCoordinates  = <u>readln</u>(<span class="strcolor">'Введите позицию ферзя, например a1 или f5'</span>),
	i, j, <span class="strcolor">//для цикла и для преобразования координат фигур из "шахматного" формата в цифровой
</span>	newI, newJ, <span class="strcolor">//для хранения новых координат коня
</span>	errorMessage = <span class="strcolor">"Введите позиции фигур как принято в шахматах, например e2 или  e4"</span>,
	successMessage = <span class="strcolor">"Конь съел ферзя!"</span>,
	failMessage    = <span class="strcolor">"Конь не волк, в поле убежал"</span>,
	letters = <span class="strcolor">'abcdefgh'</span>; <span class="strcolor">//буквы, используемые на доске для обозначения клеток
</span>	<b>if</b> (knightCoordinates.length != 2 || queenCoordinates.length != 2) {
		<u>writeln</u>(errorMessage);
		<b>return</b>;
	}
	<span class="strcolor">//создаем в оперативной памяти шахматную доску )
</span>	<b>for</b> (i = 0; i < 8; i++) { <span class="strcolor">//Чтобы можно было обращаться например  chessBoard[0][1]
</span>		chessBoard.push( [] ); <span class="strcolor">//сделаем каждый элемент массива пустым массивом
</span>		<b>for</b> (j = 0; j < 8; j++) {
			chessBoard[i].push(<span class="strcolor">''</span>); <span class="strcolor">//Забиваю пустыми строками
</span>

		}
	}
	<span class="strcolor">//Установим ферзя
	queenCoordinates = queenCoordinates.<i title="Возвращает строку как queenCoordinates, но все символы строчные">toLowerCase()</i>;
</span>	i = letters.<i>indexOf</i>( queenCoordinates.<i>charAt</i>(0) );
	j = <i>parseInt</i>(queenCoordinates.<i>charAt</i>(1), 10) - 1;
	<b>if</b> (i < 0 || <i>isNaN</i>(j) || j < 0 || j > 7) {<span class="strcolor">//координаты фигур по вертикали и горизонтали должны быть в пределах [0-7]
</span>		<u>writeln</u>(errorMessage);
		<b>return</b>;
	}
	chessBoard[i][j] = <span class="strcolor">'Q'</span>;<span class="strcolor">//Записали в клетку, что там стоит ферзь. Цвет фигур в задаче необязательно учитывать
</span>	<span class="strcolor">//Установим коня
</span>	i = letters.<i>indexOf</i>( knightCoordinates.<i>charAt</i>(0) );
	j = <i>parseInt</i>(knightCoordinates.<i>charAt</i>(1), 10) - 1;
	<b>if</b> (i < 0 || <i>isNaN</i>(j) || j < 0 || j > 7) {<span class="strcolor">//координаты фигур по вертикали и горизонтали должны быть в пределах [0-7]
</span>		<u>writeln</u>(errorMessage);
		<b>return</b>;
	}
	<span class="strcolor">//И проверяем все возможные позиции коня, "сверху" и по часовой стрелке.
</span>	newI = i + 1;
	newJ = j + 2;
	<b>if</b> (newI < 8 && newJ < 8) {<span class="strcolor">//не вышли ли за пределы доски?
</span>		<b>if</b> (chessBoard[newI][newJ] == <span class="strcolor">'Q'</span>) {<span class="strcolor">//Если там стоит ферзь
</span>			<u>writeln</u>(successMessage);
			<b>return</b>;
		}
	}
	newI = i + 2;
	newJ = j + 1;
	<b>if</b> (newI < 8 && newJ < 8) {<span class="strcolor">//не вышли ли за пределы доски?
</span>		<b>if</b> (chessBoard[newI][newJ] == <span class="strcolor">'Q'</span>) {<span class="strcolor">//Если там стоит ферзь
</span>			<u>writeln</u>(successMessage);
			<b>return</b>;
		}
	}
	newI = i + 2;
	newJ = j - 1;
	<b>if</b> (newI < 8 && newJ > -1) {<span class="strcolor">//не вышли ли за пределы доски?
</span>		<b>if</b> (chessBoard[newI][newJ] == <span class="strcolor">'Q'</span>) {<span class="strcolor">//Если там стоит ферзь
</span>			<u>writeln</u>(successMessage);
			<b>return</b>;
		}
	}
	newI = i + 1;
	newJ = j - 2;
	<b>if</b> (newI < 8 && newJ > -1) {<span class="strcolor">//не вышли ли за пределы доски?
</span>		<b>if</b> (chessBoard[newI][newJ] == <span class="strcolor">'Q'</span>) {<span class="strcolor">//Если там стоит ферзь
</span>			<u>writeln</u>(successMessage);
			<b>return</b>;
		}
	}
	newI = i - 1;
	newJ = j - 2;
	<b>if</b> (newI > -1 && newJ > -1) {<span class="strcolor">//не вышли ли за пределы доски?
</span>		<b>if</b> (chessBoard[newI][newJ] == <span class="strcolor">'Q'</span>) {<span class="strcolor">//Если там стоит ферзь
</span>			<u>writeln</u>(successMessage);
			<b>return</b>;
		}
	}
	newI = i - 2;
	newJ = j - 1;
	<b>if</b> (newI > -1 && newJ > -1) {<span class="strcolor">//не вышли ли за пределы доски?
</span>		<b>if</b> (chessBoard[newI][newJ] == <span class="strcolor">'Q'</span>) {<span class="strcolor">//Если там стоит ферзь
</span>			<u>writeln</u>(successMessage);
			<b>return</b>;
		}
	}
	newI = i - 2;
	newJ = j + 1;
	<b>if</b> (newI > -1 && newJ < 8) {<span class="strcolor">//не вышли ли за пределы доски?
</span>		<b>if</b> (chessBoard[newI][newJ] == <span class="strcolor">'Q'</span>) {<span class="strcolor">//Если там стоит ферзь
</span>			<u>writeln</u>(successMessage);
			<b>return</b>;
		}
	}
	newI = i - 1;
	newJ = j + 2;
	<b>if</b> (newI > -1 && newJ < 8) {<span class="strcolor">//не вышли ли за пределы доски?
</span>		<b>if</b> (chessBoard[newI][newJ] == <span class="strcolor">'Q'</span>) {<span class="strcolor">//Если там стоит ферзь
</span>			<u>writeln</u>(successMessage);
			<b>return</b>;
		}
	}
	<u>writeln</u>(failMessage);
}
</pre>
<p>От ключевого слова <b>var</b> до первой точки с запятой вам должно быть уже все понятно, объявляю переменные, в комментариях рядом пишу, зачем они нужны. В переменной chessBoard буду хранить информацию о позициях фигур на доске, но для начала я определяю её (инициализую её) пустым массивом. К требуемой мне в работе инициализации этого массива я приступаю после того, как убеждаюсь что позиции коня и ферзя заданы строками, состоящими из двух символов. В цикле я добавляю в наш пустой массив восемь массивов, состоящих из восьми элементов - пустых строк. Это позволит записывать в эти элементы информацию о том, какая фигура стоит на данной позиции, например я мог бы записать туда словосочетание "белый конь". Правда, в реальной программе я скорее всего присвоил каждой фигуре уникальный номер (с учетом цвета) и записывал бы его. </p>
<p>После того, как "доска"готова, я устанавливаю на ней ферзя. Программа ожидает, что пользователь будет вводить позиции фигур так, как это принято записывать в шахматах, например "a2". Но ничто не мешает ввести пользователю вместо "h5" "H5", поэтому я привожу введенную строку к нижнему регистру (то есть все прописные буквы заменяю строчными), воспользовавшись для этого методом <b>String</b> <i>toLowerCase</i>. В полученном значении я получаю первый (точнее нулевой) символ методом <b>charAt</b> и смотрю, есть ли такой символ в строке letters, содержащей допустимые для ввода буквы. Второй символ переменной queenCoordinates ожидаем как число, поэтому я использую функцию <b>parseInt</b>. </p>
<p>Таким образом, я преобразовал строку из queenCoordinates в два целых значения и поместил их в переменные i  и j. Значения этих переменных должны быть от нуля до семи включительно (элементы массива нумеруются с нуля), и я проверяю это с помощью условного оператора <b>if</b>, выводя в случае несоответствия диапазону строку, хранящуюся в переменной errorMessage, после чего завершаю выполнение программы с помощью служебного слова <b>return</b>. Если значения укладываются в нужный мне диапазон, продолжаем выполнение программы, записываем в соответствующую клетку доски значение 'Q'. Это будет нам говорить о том, что на данной клетке стоит ферзь.</p>
<p>Далее, абсолютно аналогично тому, как это делалось для ферзя, получаем координаты коня. Если они также укладываются в диапазон от нуля до семи, начинаю последоватенльно вычислять все возможные ходы конем по часовой стрелке. Если после одного из вычислений в ячейке массива newJ, newI записан символ 'Q', можно завершить вычисления - ферзь "съеден". Иначе - ферзь не может быть взят конем, вывожу соответствующее сообщение и на этом все.</p>
<p>Программка работает, однако, здесь у меня много повторяющегося кода. Преобразовании позиции фигур в координаты массива chessBoard просится в отдельную функцию, с восемью очень похожими друг на друга участками кода проверки не вышел ли конь за пределы доски и не съел ли ферзя тоже неадо что-то делать.</p>
<p>Я введу вспомогательный массив steps и перепишу свое решение так:</p>
<pre>

<b>function</b> <u>chessStep</u>() {
	<span class="strcolor">"use strict"</span>
	<b>var</b> chessBoard = [],<span class="strcolor">//Это будет шахматная доска
</span>	knightCoordinates = <u>readln</u>(<span class="strcolor">'Введите позицию коня, например e2 или h8'</span>), 
	queenCoordinates  = <u>readln</u>(<span class="strcolor">'Введите позицию ферзя, например a1 или f5'</span>),
	i, j, m, n,  <span class="strcolor">//для цикла и для преобразования координат фигур из "шахматного" формата в цифровой
</span>	newI, newJ, <span class="strcolor">//для хранения новых координат коня
</span>	errorMessage = <span class="strcolor">"Введите позиции фигур как принято в шахматах, например e2 или  e4"</span>,
	successMessage = <span class="strcolor">"Конь съел ферзя!"</span>,
	failMessage    = <span class="strcolor">"Конь не волк, в поле убежал"</span>,
	letters = <span class="strcolor">'abcdefgh'</span>, <span class="strcolor">//буквы, используемые на доске для обозначения клеток
</span>	steps = [-2, -1, 1, 2]; <span class="strcolor">//буду использовать для проверки "ходов конем"
</span>	<b>if</b> (knightCoordinates.length != 2 || queenCoordinates.length != 2) {
		<u>writeln</u>(errorMessage);
		<b>return</b>;
	}
	<span class="strcolor">//создаем в оперативной памяти шахматную доску )
</span>	<b>for</b> (i = 0; i < 8; i++) { <span class="strcolor">//Чтобы можно было обращаться например  chessBoard[0][1]
</span>		chessBoard.push( [] ); <span class="strcolor">//сделаем каждый элемент массива пустым массивом
</span>		<b>for</b> (j = 0; j < 8; j++) {
			chessBoard[i].push(<span class="strcolor">''</span>); <span class="strcolor">//Забиваю пустыми строками
</span>		}
	}
	<b>function</b> <u title="Установить фигуру">setFigure</u>(figureCoordinates, letter) {
</span>		figureCoordinates = figureCoordinates.<i title="Возвращает строку как figureCoordinates, но все символы строчные">toLowerCase</i>();
		i = letters.<i>indexOf</i>( figureCoordinates.<i>charAt</i>(0) );
		j = <i>parseInt</i>(figureCoordinates.<i>charAt</i>(1), 10) - 1;
		<b>if</b> (i < 0 || <i>isNaN</i>(j) || j < 0 || j > 7) {<span class="strcolor">//координаты фигур по вертикали и горизонтали должны быть в пределах [0-7]
</span>			<u>writeln</u>(errorMessage);
			<b>return</b> <b>false</b>;
		}
		chessBoard[i][j] = letter;<span class="strcolor">//Записали в клетку, что там стоит ферзь. Цвет фигур в задаче необязательно учитывать
</span>		<b>return</b> <b>true</b>;
	}
	<span class="strcolor">//Установим ферзя
</span>	<b>if</b> ( !<u title="Установить фигуру">setFigure</u>(queenCoordinates, <span class="strcolor">'Q'</span>) ) { <span class="strcolor">//не удалось установить фигуру
</span>		<b>return</b>; <span class="strcolor">//выходим
</span>	}
	<span class="strcolor">//Установим коня
</span>	<b>if</b> ( !<u title="Установить фигуру">setFigure</u>(knightCoordinates, <span class="strcolor">'K'</span>) ) { <span class="strcolor">//не удалось установить фигуру
</span>		<b>return</b>; <span class="strcolor">//выходим
</span>	}
	<span class="strcolor">//И проверяем все возможные позиции коня, "сверху" и по часовой стрелке.
</span>	<b>for</b> (m = 0; m < steps.length; m++) {
		newI = steps[m];  <span class="strcolor">//сюда пока что поместим "приращение"
</span>		<b>for</b> (n = 0; n < steps.length; n++) {
			newJ = steps[n];  <span class="strcolor">//сюда пока что поместим "приращение"
</span>			<b>if</b> ( <b>Math</b>.<i title="Модуль аргумента">abs</i>(newI) == <b>Math</b>.<i title="Модуль аргумента">abs</i>(newJ) ) { <span class="strcolor">//конь ходит буквой 'Г', значит приращения не могут быть равны
</span>				<b>continue</b>;
			}
			<span class="strcolor">//прибавим приращения к позиции коня
</span>			newI = i + newI;
			newJ = j + newJ;
			<b>if</b> (newI > -1 && newJ < 8 && newI < 8 && newJ > -1) {<span class="strcolor">//не вышли ли за пределы доски?
</span>				<b>if</b> (chessBoard[newI][newJ] == <span class="strcolor">'Q'</span>) {<span class="strcolor">//Если там стоит ферзь
</span>					<u>writeln</u>(successMessage);
					<b>return</b>;
				}
			}
			
		}
	}
	<u>writeln</u>(failMessage);
}
</pre>
<p>Добавленный цикл по элементам массива steps делает всю ту же работу, которую раньше выполняли восемь блоков <b>if</b>. Я поместил один из таких блоков внутрь вложенного цикла и сделал проверку диапазона значений newJ, newI более универсальной. В остальном код этого цикла достаточно прост для понимания, вопросов быть не должно.</p>
<p>О функции setFigure. Так как она определена внутри функции chessStep, это дает возможность использовать все переменные, определенные внутри chessStep. Вам может показаться, что я противоречу своему же совету всюду использовать слово <b>var</b>. Но это не так, ведь я не определяю внутри setFigure ни одной новой переменной. </p>
<p>Однако я еще вернусь к этой функции, когда буду решать пример по теме "Подпрограммы". </p>
<p>Перехожу к третьей подзадаче</p>
<h4>Удаление элементов</h4>
<p>Задание: удалить строку с номером k и столбец с номером m.</p>
<p>Очевидно, речь идет о двумерном массиве, таком как наша шахматная доска. Чтобы было визуально видно, что мы действительно удалим строку и столбец, добавим функции вывода элементов массива на экран, а сами элементы на этот раз заполним не пустыми строками</p>
<pre>
<b>function</b> <u title="Пример удаления строки и столбца">removeRowAndColumnExample</u>() {
	<b>var</b> array = [], i, j, 
		k, m,
		ARRAY_SIZE = 8; <span class="strcolor">//По привычке оставшейся от прошлого примера взял размерность 8 на 8
</span>	<span class="strcolor">//заполним массив случайными цифрами от 0 до 9
</span>	<b>for</b> (i = 0; i < ARRAY_SIZE; i++) {
		array.push([]);
		<b>for</b> (j = 0; j < ARRAY_SIZE; j++) {
			m = <b>String</b>( <b>Math</b>.<i title="Возвращает случайное дробное число от 0 до 1">random</i>() );
			m = m.<i>charAt</i>(3) ? m.<i>charAt</i>(3) : <span class="strcolor">'0'</span>; <span class="strcolor">//Почему именно третий? На самом деле от фонаря, мне ведь не важно что конкретно будт в массиве
</span>			array[i].push(m);
		}
	}
	<b>function</b> <u title="Печать массива">printArray</u>() {
		<b>var</b> i, j, s = <span class="strcolor">""</span>, L = array.length; <span class="strcolor">//чтобы не переписывать неожиданно значения i j во внешней функции
</span>		<b>for</b> (i = 0; i < L; i++) {
			<b>for</b> (j = 0; j < array[i].length; j++) {
				s += array[i][j] + <span class="strcolor">' '</span>;
			}
			s += <span class="strcolor">"\n"</span>;
		}
		<u>writeln</u>(s);
	}
	k = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">"Введите номер строки k, строки нумеруются с нуля"</span>) );
	m = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">"Введите номер столбца m, столбцы нумеруются с нуля"</span>) );
	<b>if</b> (<i>isNaN</i>(k) || <i>isNaN</i>(m) || m < 0 || k < 0 || k > ARRAY_SIZE - 1 || m > ARRAY_SIZE - 1) {
		<u>writeln</u>(<span class="strcolor">"Размер масива "</span> + ARRAY_SIZE + <span class="strcolor">" на "</span> + ARRAY_SIZE  + <span class="strcolor">", заданые вами индексы выходят за его пределы"</span>);
		<b>return</b>;
	}
	<u>writeln</u>(<span class="strcolor">"Массив до удаления"</span>);
	<u title="Печать массива">printArray</u>();
	<span class="strcolor">//удалаем сначала строку, так как это позволит делать меньше итераций при удалении столбца
</span>	array.<i title="Удалить в массиве элементы от индекса k один">splice</i>(k, 1);
	//удаляем столбец
	<b>for</b> (i = 0; i < array.length; i++) {
		array[i].<i title="Удалить в массиве элементы от индекса m один">splice</i>(m, 1);
	}
	<u>writeln</u>(<span class="strcolor">"Массив после удаления"</span>);
	<u title="Печать массива">printArray</u>();
}

</pre>
<p>Обратите внимание в объявлении переменных на переменную ARRAY_SIZE. Я использовал только буквы в верхнем регистре для её именования, чтобы дать понять людям, которые будут читать мой код позже, что это <b class="tblack">именованная константа</b>. К сожалению, JavaScript не поддерживает именованные константы на уровне языка. Во многих других языках, используя специальный синтаксис, можно определить именованную константу по всем правилам. Переписать ее значение далее в коде программы было бы невозможно. Однако именно в этих языках родилась традиция давать имена константе большими буквами - чтобы можно было с первого взгляда понять, что это значение не может менятся в процессе выполнения программы и не стоит даже пытаться присвоить что-то этой "переменной". В JavaScript ничего не мешает переписать значение ARRAY_SIZE в коде ниже, но обычно программисты понимают, видя имя в верхнем регистре, что этого делать не надо.</p>
<p>Зачем вообще нужна эта константа в моем примере? В тексте задачи ничего не сказано о размере, который должен иметь массив, из которого надо удалить строку и столбец. Решая задачу, программист должен быть готов к тому, что вскоре условия задачи изменятся (спросите любого програмиста, это происходит достаточно часто). Если бы в моем примере была не учебная задача а задача из реальной жизни, вполне могло бы случиться, что завтра мне жестко зададут условие, что массив должен быть 256 на 256 элементов, а послезавтра потребуют, чтобы размерность массива вводилась пользователем с клавиатуры.</p>
<p>Так как при инициализации массива я использую значение из ARRAY_SIZE, мне достаточно изменить в первом случае её инициализацию, а во втором используя автозамену редактора кода всюду заменить ARRAY_SIZE на arraySize  и добавить получение значения arraySize  с клавиатуры.</p>
<p>Далее, после объявления переменных, я заполняю массив случайными значениями. Метод <b>Math</b> <i>random</i> возвращает дробное число от 0 до 1. Однако, я хочу чтобы моя матрица (двумерный массив) аккуратно смотрелась на экране. Поэтому я буду заполнять ее однозначными числами. Я преобразовываю результат работы <i>random</i> в строку и используя тернарную операцию получаю третий символ этой строки, если он существует, если не существует беру 0.</p>
<p>Функция printArray просто проходит по всем элементам массива array, а так как каждый такой элемент является массивом, содержащим в каждом элементе ячейку "строки" прямоугольной матрицы, то во вложенном цикле проходим по такой "строке", собирая все значения в строку s. Для читаемого отображения после каждой "строки" матрицы добавляем в s символ перевода строки '\n'. </p>
<p>Далее, получаем номера удаляемой строки и удаляемого столбца нашего массива, если они выходят за пределы массива, выводим соответствующее сообщение и выходим. </p>
<p>Далее, первым делом удаляем строку двумерного массива, используя метод объекта типа <b>Array</b> <i>splice</i>. Этот метод возвращает копию массива, для которого он вызван, но удаляет в этой копии элементы с индекса указанного в первом аргументе, в количестве, указанном во втором аргументе. Подробнее о методе <i>split</i> можно прочесть <?=QuickStartHandler::a('http://javascript.ru/Array/splice', 'здесь') ?>. Удалить столбец немного сложнее: надо удалить соответствующий элемент в каждом элементе-массиве массива array. Заключительный цикл в коде программки выполняет эту задачу. </p>
<p>В конце вывожу массив еще раз, чтобы было наглядно видно, что мы действительно удалили строку и столбец.</p>
<div style="width:96%">
<div class="left"><?=QuickStartHandler::aback("strings")?></div>
<div class="right"><?=QuickStartHandler::anext("function_tasks")?></div>
<div class="clearfix"></div>
</div>
