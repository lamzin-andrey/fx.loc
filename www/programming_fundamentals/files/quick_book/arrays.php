<header>
	<h3>Массивы</h3>
</header>
<p>В задачах могут встречаться упоминания "одномерных", "двумерных", "n-мерных" массивов. Это связано с тем, что задачи писались для решения их на языке Pascal, в котором массив может быть двумерным "на уровне языка". Поэтому не стоит зацикливаться на этих прилагательных.</p>
<h4>Первая задача</h4>
<p>Найти сумму элементов, больших данного числа А (А вводится с клавиатуры).</p>
<pre>
<b>function</b> sumElementsGreatThanA() {
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
<p>Так как для решения задачи не имеет значения, проходить массив от начала к хвосту или наоборот, я иду от конца к началу. Это позволяет проверять, прекращать ди цикл, сравнивая i с нулем. Я уже упоминал рассматривая циклы о поведении операции i++, i-- ведет себя также. Если вы пропустили этот фрагмент читая про циклы, я приведу его еще раз:</p>
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
function chessStep() {
	var chessBoard = [],//Это будет шахматная доска
	knightCoordinates = readln('Введите позицию коня'), 
	queenCoordinates  = readln('Введите позицию ферзя'),
	i = 0, //для цикла
	errorMessage = "Введите позиции фигур как принято в шахматах, например e2 или  e4",
	messageSuccess = "Конь съел ферзя!",
	messageFail    = "Конь не волк, в поле убежал",
	letters = 'abcdefgh'; //буквы, используемые на доске для обозначения клеток
	if (knightCoordinates.length != 2 || queenCoordinates.length != 2) {
		writeln(errorMessage);
		return;
	}
	for (i; i < 8; i++) { //Чтобы можно было обращаться например  chessBoard[0][1]
		chessBoard.push( [''] ); //сделаем каждый элемент массива массивом с одним элементом
	}
	
}
<p></p>
<div style="width:96%">
<div class="left"><a href="<?=WEB_ROOT?>/quick_start/cycles">Назад - <?=$lang['cycles']?></a></div>
<div class="right"><a href="<?=WEB_ROOT?>/quick_start/arrays">Далее - <?=$lang['arrays']?></a></div>
<div class="clearfix"></div>
</div>
