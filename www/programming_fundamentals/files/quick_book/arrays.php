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
<p>Сначала напишу программку, а потом разберем ее, читайте такж комментарии в коде</p>
<pre>

<b>function</b> chessStep() {
	<b>var</b> chessBoard = [],<span class="strcolor">//Это будет шахматная доска
</span>	knightCoordinates = <u>readln</u>(<span class="strcolor">'Введите позицию коня'</span>), 
	queenCoordinates  = <u>readln</u>(<span class="strcolor">'Введите позицию ферзя'</span>),
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
</span>		chessBoard.push( [] ); <span class="strcolor">//сделаем каждый элемент массива массивом с одним элементом
</span>		<b>for</b> (j = 0; j < 8; j++) {
			chessBoard[i].push(<span class="strcolor">''</span>); <span class="strcolor">//Забиваю пустыми значениями
</span>		}
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
<p></p>
<div style="width:96%">
<div class="left"><?=QuickStartHandler::aback("strings")?></div>
<div class="right"><a href="<?=WEB_ROOT?>/quick_start/arrays">Далее - <?=$lang['arrays']?></a></div>
<div class="clearfix"></div>
</div>
