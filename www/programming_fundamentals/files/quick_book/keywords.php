<header>
	<h3>Ключевые слова языка.</h3>
</header>
<p>Когда я начинал учиться программировать, меня часто раздражал в учебниках один факт: 
ближе к началу были приведены ключевые слова языка программирования, но они давались "без перевода", при том, 
что если некоторые я мог перевести буквально, другие были сокращениями от неизвестных мне слов. Это раздражало.</p>
<p>Здесь я попытаюсь избавиться от такого недоразумения.</p>
<p>Ниже перечисленны ключевые слова JavaScript (не все, а только те, которые я использую в повседневной практике).
 Наводя на слово курсор (указатель) мыши вы можете прочесть во всплывающей подсказке, как используется это ключевое слово.
</p>
<p>Но сначала давайте разберемся, что такое вообще ключевые слова языка программирования.
Это прежде всего слова, <b><i class="tblack">которые нельзя использовать для именования функций</i></b> (пример функции JavaScript вы уже видели на предыдущей странице и мы еще к функциям вернемся) и 
<b><i class="tblack">переменных</i></b> (что это за зверь разберемся далее).</p>
<p>Это связанно с тем, что каждое ключевое слово языка интерпретируется интерпретатором языка совершенно определенным образом. Таких слов чаще всего вообще не много, а я к томуже как сказал выше приведу только те из них, которые использую часто, то есть те, которые смогу вспомнить прямо сейчас.</p>
<p>У меня было небольшое колебание, валить ли в одну кучу собственно ключевые слова языка JavaScript  и 
слова определяющие в нем типы данных, решил валить, так как они соответствуют данному мною же определению</p>
<p>
	<pre>
<b title="Определяет тип данных (объект типа) массив.

var array = new Array(); //новый пустой массив

Простейшим примером массива может быть последовательность чисел:
var other_massiff = [0,1,2,3,4,5,6,7];//так тоже можно создавать массивы, только имя переменной дурацкое, я использовал его только для того, чтобы показать что необязательно использовать слово array в имени переменной

var third_array = [];// и даже так, и это более предпочтительно, чем первый метод, потому что меньше букв
">Array</b>  <b title='Буквально "хватать".
Используется совместно с try  и finally, например:
try {
	//здесь код, который может создать ошибку интерпретации
} catch(error) {
	//Здесь делаем что-то, чтобы дать понять что так делать не надо, например
	alert("У вас в коде ошибка: " + error.message + " исправьте ее");
} finally {
	//А здесь делаем что-то, что должно быть сделано независимо от того, была ошибка или нет
}

Обычно этот кусок кода сложно понять начинающим, я хочу вернутся к нему при более подробном расмотрении функций.
'>catch</b>  <b title='Буквально "делать".
Используется совместно с  while, например:

do {
	alert("Ха-Ха");
} while (1 == 0);//выполнять тело цикла пока единица равна нулю. Так как равенство в скобках ложно, сообщение будет выведено только один раз.

Можно сказать, что в примере написано "Делать алерт, пока единица равна нулю."
'>do</b>  <b title='Определяет тип данных (объект типа) ошибка.

var error = new Error(); //новая ошибка, но так обычно никто не деллает.
error.message = "Ожидался ;, найден:";

Более жизненный пример, где нибудь в дебрях кода:

throw new Error("Ждали денег, пришел счет!");
Ваш коллега сможет поймать и обработать эту ошибку, наведите курсор на catch чтобы увидеть как.
'>Error</b>
	</pre>
</p>
<div style="width:96%">
<div class="left"><a href="<?=WEB_ROOT?>/quick_start/wtf">Назад - <?=$lang['wtf']?></a></div>
<div class="right"><a href="<?=WEB_ROOT?>/quick_start/keywords">Далее - <?=$lang['keywords']?></a></div>
<div class="clearfix"></div>
</div>
</p>
