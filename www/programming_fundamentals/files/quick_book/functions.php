<header>
	<h3>Функции</h3>
</header>
<p>Я писал, что переменные в программировании - это всё. Я не отказываюсь от своих слов, но добавлю, что функции в программировании - это всё остальное!</p>
<p>Итак, что это такое и для чего это нужно? Чтобы ответить на вопрос что это, давайте спросим, а что такое компьютерная программа? Можно понимать программу как записанную последовательность команд, которая будет выполнена компьютером в той же последовательности, в какой она записана. В реальных программах таких команд может быть очень много. Как правило, для описания какого-то действия требуется более одной. Программист может группировать такие команды в группы, может давать этим группам имя (в JavaScript может и не давать!) и работать дальше с этими группами команд, используя заданное имя. Так как команды обычно работают с какими-то данными, функция может принимать неограниченное число аргументов (собственно, данных).</p> <p>Перейдем к тому, для чего это нужно. Чаще всего функции в программировании используются для описания действий, которые в ходе работы программы должны выполнятся неоднократно. 
Например, если вы пишете скрипты для сайта, вам может понадобится часто определять анонимен ли пользователь просматривающий ваш сайт или авторизован. При отправке комментария, при попытке сменить фото в профиле да и мало ли еще где.</p>
<div class="ainfo">Вообще говоря, здравомыслящие люди часто используют для программирования сайтов готовые решения, в некоторых из них перечисленные проверки могут быть сделаны так, что прикладному программисту не надо об этом заботиться, но функция для проверки авторизации и аутентификации пользователя в них все равно доступны для использования прикладным программистом.</div>
<p>Если вы пишете игру, вам может например понадобится функция проверки не пересеклись ли управляемые игроком персонажи с другими персонажами или стенами  и т. д. Логично оформить это часто повторяющееся действие как функцию. Для описания (в программировании принято писать "для определения") функции на практике часто используется следующий код:</p>
<p><pre>
<b>function</b> <u>myFunction</u>(argument_1, argument_2) {//начало определения функции
	//код расположенный здесь (внутри определения или тела функции) можно использовать в программе снова и снова
}//конец определения функции
</pre></p><p>
Например. вы программируете билиард, у вас может быть функция с именем isIntersect ("пересекается ли?"). 
Она будет принимать два аргумента, описывающих шары, для которых надо проверить, столкнулись они или нет.
(Напомню, что для выполнения примеров кода на этом сайте вы должны "заворачивать" их в одну "главную функцию" с любым в принципе именем. Я так и сделаю. Наводите мышь на все цветные слова в этом примере, это должно многое прояснить. Жирно-синее можно кликать)
<pre>
<b>function</b> <u title='main значит "главный"'>main</u>() {//главная функция
	<b title='Как эта переменная получает значение и где изменяется пока оставим за кадром'>var</b> quantityBallsOnCanvas;//Количество шаров на сукне
	<b title='Как эта переменная получает значение и где изменяется пока оставим за кадром'>var</b> aBalls = <b>new</b> <b>Array</b>();//Массив с данными о координатах шаров
	<b title='Вернет истину если шары столкнулись и ложь если это не так'>function</b> <u title='Пересекаются?'>isIntersect</u>(ball_1, ball_2) {
		<b title='Возводит число в квадрат'>function</b> <u title='Квадрат (сокращение от square)'>sq</u>(x) {
			<b>return</b> x*x;
		}
		//мне достаточно проверить, меньше ли расстояние между центрами сфер чем радиус сферы
		//вообще такие псевдонимы для аргументов как a и b- плохая практика, имена переменных должны быть понятны
		//но для математических и физических формул я считаю, вполне допустимо
		<b>var</b> a = ball_1, b = ball_2,
			d = <b>Math</b>.<i title='Квадратный корень'>sqrt</i>( <u title='Квадрат (сокращение от square)'>sq</u>(a.x - b.x) + <u title='Квадрат (сокращение от square)'>sq</u>(a.y - b.y) + <u title='Квадрат (сокращение от square)'>sq</u>(a.z - b.z) );
		<b>if</b> (d < 2*a.r) {//если расстояние между центрами шаров меньше чем диаметр шара
			<b>return</b> <b>true</b>; //значит пересеклись
		} <b>else</b> {
			<b>return</b> <b>false</b>; //значит не пересеклись
		}
	}
	<b>for</b>(<b title='А это просто переменная - счетчик'>var</b> i = 1; i < quantityBallsOnCanvas; i++) { //проверяем все шары попарно
		<b>if</b> ( <u title='Берем все шары по два и проверяем их'>isIntersect</u>(aBalls[i], aBalls[i - 1]) ) {//если пересеклись
			//тут обрабатываем столкновение
		}
	}
}
</pre></p><p>Прочтите все подсказки к подсвеченным словам. Когда у вас не останется вопросов, что значит каждое из них, перечитайте этот пример кода.
Думаю, вам должно быть все понятно. Единственные вопросы которые могут возникнуть, должны касаться a.x - b.x  и т д.
Прочтите подсказку к ключевому слову <pre><b>Object</b></pre> чтобы снять вопросы.</p>
<p>Может быть правда еще один вопрос, почему если запустить этот пример кода в редакторе внизу, ошибок не выдается, но и видимого результата нет никакого? 
Потому, что этот код просто демонстрирует определение и использование функций, он не выполняет работу реально. Единственное, что там должно реально работать, это функция isIntersect. Но так как размер массива aBalls равен нулю (мы ведь ничего не помещаем в него!), программе просто нечего обрабатывать!</p>

<p>Если остались вопросы, по поводу функций читайте здесь <a href="http://javascript.ru/function-syntax" target="_blank"/>javascript.ru</a></p>
<p>Также посмотрите на мои подсказки к ключевым словам <pre><b>function</b>

<b>Function</b></pre></p>
<div style="width:96%">
<div class="left"><a href="<?=WEB_ROOT?>/quick_start/datatypes">Назад - <?=$lang['datatypes']?></a></div>
<div class="right"><a href="<?=WEB_ROOT?>/quick_start/begin">Далее - <?=$lang['begin']?></a></div>
<div class="clearfix"></div>
</div>
