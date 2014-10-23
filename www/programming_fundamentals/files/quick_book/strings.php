<header>
	<h3>Строки</h3>
</header>
<p>Строковая переменная может быть объявлена в JavaScript коде используя одинарные или двойные кавычки</p>
<pre>
<b>function</b> <u title="определение строковых пременных">defineStringVar</u>() {
	<b>var</b> name = <span class="strcolor">'Василий'</span>, surname = <span class="strcolor">"Теркин"</span>;
}
</pre>
<p>Никакой разницы в переменных name  и surname для интерпретатора JavaScript нет.</p>
<h4>Первое задание</h4>
<p>Дан произвольный текст. Отредактировать текст так, чтобы:
<ul class="nomark">
	<li>a) между словами был ровно один пробел;</li>
	<li>b) предложения в тексте разделялись ровно двумя пробелами.</li></p>
</ul>
<p>Для начала прочитайте исходный код программы, я старался писать очень подробные комментарии</p>
<pre>
<b>function</b> textCorrector() {
	<b>var</b> s = <span class="strcolor">''</span>, text = <span class="strcolor">''</span>;
	<b>while</b> (s != <span class="strcolor">'endtext'</span>) {<span class="strcolor">//для начала считаем текст
</span>		s = <u>readln</u>(<span class="strcolor">'Введите предложение текста, для окончания ввода введите слово endtext'</span>);
		<b>if</b> (s == <span class="strcolor">'endtext'</span>) {<span class="strcolor">//Выходим до того, как присоединили 'endtext'
</span>	 		<b>break</b>;
		}
		text += s + <span class="strcolor">"\n"</span>; <span class="strcolor">//строки разделяем символами перехода на новую строку (\n)
</span>	}
	<b>var</b> endSimbols = <span class="strcolor">'.!?'</span>,     <span class="strcolor">//символы, которыми может заканчиваться предложение
</span>		breakSimbols = <span class="strcolor">' \t\n'</span>, <span class="strcolor">//символы, которыми могут отделяться друг от друга слова и предложения
</span>		i = 0, <span class="strcolor">//счетчик для цикла
</span>		char,  <span class="strcolor">//буду хранить очередной символ
</span>		result = <span class="strcolor">''</span>, <span class="strcolor">//текст, который получится в результате работы программы
</span>		previousIsBreak = <b>false</b>, <span class="strcolor">//принимает true, когда предыдущий символ найден в breakSimbols
</span>		previousChar = <span class="strcolor">'8'</span>; <span class="strcolor">//предыдущий символ. мне подойдет любое значение не входящее в endSimbols и breakSimbols
</span>	<b>for</b> (i; i < text.length; i++) {
		char = text.<i title="Возвращает из строки символ номер такой-то">charAt</i>(i);<span class="strcolor">//получили очередной символ.
</span>		<b>if</b> (!previousIsBreak && breakSimbols.<i title="Возвращает позицию подстроки в строке">indexOf</i>(char) != -1) {
			previousIsBreak = <b>true</b>;
			char = <span class="strcolor">' '</span>;<span class="strcolor">//присваиваем символу пробел, так как слова и предложения по условию задачи должны разделяться пробелами
</span>			<b>if</b> (i - 1 > -1) {
				previousChar = text.<i title="Возвращает из строки символ номер такой-то">charAt</i>(i - 1);
			}
			<b>if</b> (endSimbols.<i title="Возвращает позицию подстроки в строке">indexOf</i>(previousChar) != -1) { <span class="strcolor">//если предыдущим символом было окончание предложения
</span>				char += <span class="strcolor">' '</span>; <span class="strcolor">//добавить еще один пробел
</span>			}
			result = result + char;
			<b>continue</b>; <span class="strcolor">// и перехожу к следующей итерации
</span>		}
		<b>if</b> (breakSimbols.indexOf(char) == -1) { <span class="strcolor">//если это не символ разрывающий слово или строку
</span>			result += char;           <span class="strcolor">//добавим его в результат
</span>			previousIsBreak = <b>false</b>;  <span class="strcolor">//и запомним, что предыдущий символ - не символ разрыва
</span>		}
	}
	<u>writeln</u>(<span class="strcolor">"Исходный текст:\n"</span> + text);
	<u>writeln</u>(<span class="strcolor">"\n====================================\n"</span>);
	<u>writeln</u>(<span class="strcolor">"Результат:\n"</span> + result);
}
</pre>
<p>В первых строках программы (в первом цикле <b>while</b>) я показываю диалог для ввода строки текста. И продолжаю это делать до тех пор, пока пользователь не введет специальную строку endtext (я выбрал значение endtext, но в принципе это могло бы быть любым значением).</p>
<p>Каждую введенную пользователем строку я прикрепляю к переменной text. Когда этот процесс завершен, я перехожу к анализу строки. Я немного упростил себе задачу, прняв, что слова могут состоять из любых символов кроме пробела, символа разрыва строки \n и символа табуляции \t. По-хорошему надо было бы дополнить этот набор всевозможными скобками и кавычками, но мне что-то сегодня лень ). Энтузиасты могут заняться этим самостоятельно.</p>
<p>Итак, я определил переменную, в которой содержу все символы, встретив который можно заключить, что слово закончилось, переменную, в которой держу символы, которыми может заканчиваться предложение, переменную, которая будет принимать значение истина, если мы встретили символ, не входящий в слово, переменную счетчик для цикла и переменную для хранения результата.</p>
<p>Далее, я прохожу по введенному тексту от начала до конца (я использую свойство length объекта типа String чтобы определить длину текста в символах). Позиции символов нумеруются с нуля до (length - 1), поэтому условие окончания цикла записано i < text.length  а не i <= text.length.</p>
<p>Чтобы получить очередной символ строки я использую метод объекта типа String сharAt. Описание всех свойств и методов, которые есть у переменных (объектов) типа String вы можете прочесть на сайте <a href="http://javascript.ru/String" target="_blank">javasript.ru</a>.</p>
<p>Получив значение очередного символа я первым делом проверяю, не был ли предыдущий символом разрыва строки и не входит ли текущий символ в группу символов разрыва строки?
<p><b>if</b> (!previousIsBreak && breakSimbols.<i title="Возвращает позицию подстроки в строке">indexOf</i>(char) != -1) {</p>
<p>Я использую для этого метод indexOf. Метод возвращает позицию первого символа переданной в качестве аргумента подстроки в строке, для которой он вызывается. Если подстрока в строке не найдена, метод вернет значение -1, иначе вернет порядковый номер символа. Напомню еще раз, что символы в строке нумеруются с нуля.</p>
<p>Если условие (его можно еще "перевести" как "предыдущий символ был частью слова или предложения и текущий - не часть слова или предложения") выполнилось, я первым делом запоминаю для будущей итерации, что у нас текущий символ - символ разрыва. То, что у нас сейчас текущее, в следующей итерации станет предыдущим. Поэтому я присваиваю переменной previousIsBreak значение <b>true</b>. Текущему символу char я присваиваю значение "пробел" (" "), так как слова по условиям задачи должны разделяться пробелом, а символом разрыва могли быть и другие символы.</p>
<p>В следующем условном операторе</p>
<p><b>if</b> (i - 1 > -1) </p>
<p>проверяю, существует ли предыдущий символ (например при i== 0 (i равном 0) его не существует). А если существует, получаю его и проверяю, не входит ли он в число символов, которыми может закончиться предложение. Если входит, добавляю к своей переменной char еще один пробел, так как слова должны быть разделены двумя пробелами по условию задачи. После чего добавляю char к результирующей строке и перехожу к следующей итерации используя слово <b>continue</b>. </p>
<p>Далее, так как я установил previousIsBreak в <b>true</b> я не войду в условие в 19-ой строке, пока не встречу символ не являющийся символом разрыва. Тогда я войду в условие </p>
<p><b>if</b> (breakSimbols.<i title="Возвращает позицию подстроки в строке">indexOf</i>(char) == -1) </p>
<p>где добавлю этот очередной символ к строке - результату и заодно сброшу логическую переменную previousIsBreak в <b>false</b>. Таким образом, даже если где-то будет более чем один пробел между словами или всего один пробел между предложениями, в результате все равно их будет ровно сколько, сколько требует задача.</p>
<p>Ну и в конце концов я вывожу оба текста: тот, что был введен и тот, что получился после обработки.</p>
<h4>Преимущества использования методов объекта типа String. Немного о регулярных выражениях</h4>
<p>Рассмотрим следующую задачу:</p>
<p>Дана строка символов. Преобразовать ее,  заменив все двоеточия (:), встречающиеся среди первых  n/2 символов, на точку с запятой (;), и заменив точками все восклицательные знаки, встречающиеся среди символов, стоящих после n/2 символов.</p>
<p>Я мог бы решить эту задачу подобно предыдущей: пройти всю строку по символьно, заменяя двоеточие на точку с запятой в первой части и делая требуемую замену во второй части.</p>
<p>Но эта задача прекрасный кандидат на то, чтобы использовать только методы класса String при ее решении.</p>
<pre>
<b>function</b> replaceSimbols() {
	<b>var</b> inputText = <span class="strcolor">'Я сказал: Чтобы не маяться с вводом с клавиатуры, напишу строку один раз.'</span>,
		middle = <b>Math</b>.<i>floor</i>(inputText.length / 2), <span class="strcolor">//середина строки, чтобы избежать дробного числа округлили вниз
</span>		head = inputText.<i title="Первый аргумент - номер первого символа подстроки, второй, номер последнего символа подстроки">substring</i>(0, middle), <span class="strcolor">//подстрока от начала до середины
</span>		tail = inputText.<i title="Вернет подстроку от символа номер middle до конца строки tail">substring</i>(middle); <span class="strcolor">//подстрока от середины до конца
</span>	head = head.<i title="Заменит в head символ  : на символ ;">replace</i>(<span class="strcolor">':'</span>, <span class="strcolor">';'</span>); <span class="strcolor">//заменили  двоеточие на точку с запятой
</span>	tail = tail.<i title="Заменит в tail символ  . на символ !">replace</i>(<span class="strcolor">'.'</span>, <span class="strcolor">'!'</span>); <span class="strcolor">//заменили  точку на восклицательный знак
</span>	<u>writeln</u>(head + tail);
}
</pre>
<p>Здесь первым делом я определил какую-то строку, содержащую двоеточие и точку.</p>
<p>Затем, я использовал округление вниз числа, равного длине строки разделенной на два, чтобы определить середину строки. Далее, я использовал метод <i>substring</i> чтобы получить первую половину строки и вторую. Я поместил их в переменные, которые назвал "голова" и "хвост" (head и tail). Ну и в конце концов я вызвал для этих переменных метод <b>String</b> <i>replace</i>, который возвращает значение той переменной, для которой он вызван, заменив однако подстроку переданную в первом аргументе на подстроку переданную во втором аргументе.</p>
<p>Этот код получился более кратким, чем если бы я попытался проделать все это в цикле. Но еще важнее то, что как правило чем больше код использует для реализации алогритма методов стандартных классов, тем быстрее он работает. Поясню последнее предложение: если есть возможность заменить в вашем алгоритме участок кода не содержащий вызовов методов стандартных объектов JavaScript на код, содержащий такие вызовы, сделайте это и вы наверняка ускорите работу своей программы.</p>
<p>Однако, что было бы, если бы в моем примере строка заканчивалась многоточием? Или содержала бы два предложения заканчивающихся точкой?</p>
<p>Вы можете изменить в коде значение переменной inputText и убедиться, что в таком случае будет заменена только первая точка. Но этого можно избежать, если передать replace в качестве первого аргумента не строку, а <b class="tblack">регулярное выражение</b>. Регулярные выражения - штука непростая. Вы можете прочитать о них <a href="http://javascript.ru/RegExp" target="_blank">здесь</a>, <a href="http://javascript.ru/basic/regular-expression+" target="_blank">здесь</a>, <a href="http://learn.javascript.ru/regular-expressions-javascript" target="_blank">здесь</a> и <a href="http://javascript.ru/tutorial/regexp-specials" target="_blank">здесь</a>. Но мне для моей цели нужны очень простые регулярные выражения:</p>
<pre>
<b>function</b> replaceSimbols() {
	<b>var</b> inputText = <span class="strcolor">'Я сказал: Чтобы не маяться с вводом с клавиатуры, напишу строку один раз. А это еще предложение.'</span>,
		middle = <b>Math</b>.<i>floor</i>(inputText.length / 2), <span class="strcolor">//середина строки, чтобы избежать дробного числа округлили вниз
</span>		head = inputText.<i title="Первый аргумент - номер первого символа подстроки, второй, номер последнего символа подстроки">substring</i>(0, middle), <span class="strcolor">//подстрока от начала до середины
</span>		tail = inputText.<i title="Вернет подстроку от символа номер middle до конца строки tail">substring</i>(middle); <span class="strcolor">//пдстрока от середины до конца
</span>	head = head.<i title="Заменит в head все символы  : на символы ;">replace</i>(<span class="recolor">/:/g</span>, <span class="strcolor">';'</span>); <span class="strcolor">//заменили все двоеточия на точки с запятыми
</span>	tail = tail.<i title="Заменит в tail все символы  . на символы !">replace</i>(<span class="recolor">/\./g</span>, <span class="strcolor">'!'</span>); <span class="strcolor">//заменили все точки на восклицательные знаки
</span>	<u>writeln</u>(head + tail);
}
</pre>
<p>В head.replace я использую простейшее регулярное выражение вместо подстроки ':'. Оно выглядит как /:/g</p>
<p>В JavaScript регулярное выражение можно определить записав его шаблон между символами / и /. Так как меня интересует двоеточие в строке, его я и пишу между символами //. Символ g после закрывающего / говорит о том, что надо заменить все вхождения описанного между // шаблона.</p>
<p>В tail.replace чуточку сложнее: дело в том, что символ '.' в шаблоне регулярных выражений имеет специальное значение "любой символ". Поэтому, чтобы показать, что я имею ввиду именно точку, а не любой символ я поставил перед точкой обратный слеш \.</p>
<h4>Третье задание</h4>
<p>Присвоить литерным переменным с2, с1 и с0 соответственно левую, среднюю и правую цифры трехзначного числа k.</p>
<p>Ну тут все очень просто:</p>
<pre>
<b>function</b> parseThreeNumber () {
	<span class="strcolor">"use strict"</span>
	<b>var</b> k = <i>parseInt</i>( <u>readln</u>(<span class="strcolor">"Введите трехзначное целое число"</span>) ),
		c0, c1, c2, errorMessage = <span class="strcolor">'k не целое трехзначное целое число!'</span>, s;
	<b>if</b> (!k) {
		<u>writeln</u>(errorMessage);
		<b>return</b>;
	}
	s = <b>String</b>(k);
	<b>if</b> (s.length != 3) {
		<u>writeln</u>(errorMessage);
		<b>return</b>;
	}
	c2 = s.<i>charAt</i>(0);
	c1 = s.<i>charAt</i>(1);
	c0 = s.<i>charAt</i>(2);
}
</pre>
<p>В этом примере может быть неясен только один момент:</p>
<pre>s = <b>String</b>(k);</pre>
<p>Дело в том, что для чтения введенной пользователем переменной k мы используем <i>parseInt</i>, чтобы обеспечить контроль за вводимым значением. Благодаря этому в переменную k записывается объект типа <b>Number</b>. Но у таких объектов нет свойства length, которое можно использовать, чтобы определить количество знаков в числе. Поэтому я вызываю <b class="tblack">конструктор</b> <b>String</b> и передаю ему наше число k. В результате в переменную s запишется строка, а для неё мы уже можем вызвать метод <b>String</b> <i>charAt</i>.</p>
<div class="ainfo">Заодно здесь можно разъяснить что такое "литерная переменная" из текста задачи. Дело в том, что эти задачки писались для выполнения на языках программирования Pascal или C++. В этих языках нельзя, как в JavaScript объявить переменную, а потом хранить в ней значение любого типа. Там если вы объявили переменную типа строка, значит в ней могут быть только строки, если объявил переменную типа целое число, значит в ней могут быть только целые числа. А если вам надо хранить один символ строки, для этого можно использовать переменные специального типа, который и назван литерным.</div>
<p></p>
<div style="width:96%">
<div class="left"><a href="<?=WEB_ROOT?>/quick_start/cycles">Назад - <?=$lang['cycles']?></a></div>
<div class="right"><a href="<?=WEB_ROOT?>/quick_start/arrays">Далее - <?=$lang['arrays']?></a></div>
<div class="clearfix"></div>
</div>
