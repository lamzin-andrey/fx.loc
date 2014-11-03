<header>
	<h3>Программирование 2D графики</h3>
</header>
<div class="ainfo">
Все рассмотренные до сих пор примеры почти не зависят от среды, в которой выполняется JavaScript. Если вам вдруг пришла бы в голову идея запустить эти программки например как сценарий
WScript для windows, от вас бы потребовалось только определить четыре функции: alert, prompt, writeln и  readln так, чтобы они принимали от пользователя значение или выводили его куда-нибудь.
Решения задач по программированию 2D графики будут привязаны к браузерному JavaScript гораздо сильнее. Я буду использовать элемент DOM canvas (холст), но не собираюсь вдаваться в подробности, что такое DOM.
Об этом в сети великое множество информации, а я здесь осваиваю азы программирования и информация о DOM, как мне кажется, к азам программирования отношение имеет мало.
DOM элемент canvas хорош в контексте освоения азов программирования тем, что имеет многие функции, которые очень похожи на 
соответствующие функции для отрисовки графических примитивов в других языках программирования, например C++ или Pascal.
</div>
<h4>Как добавить холст, на котором будем рисовать</h4>
<p>Перед тем, как пытаться программировать графику в браузерном JavaScript, надо получить контекст существующего на веб-странице элемента 
canvas. В нашем случае на странице такого элемента нет вообще, но мы можем создать новый, чтобы получить его контекст. Контекст будет получен в виде объекта. А у этого объекта уже будут доступны множество
методов и свойств, описание которых вы можете видеть на сайте <?=QuickStartHandler::a('http://www.w3schools.com/jsref/dom_obj_canvas.asp', 'w3schools.com')?> </p>
<p>Вы можете выполнить на нашем сайте этот код:</p>
<pre>
<b>function</b> createCanvasExample() {
	<span class="strcolor">"use strict"</span>
	<b>var</b> canvas = document.<i>createElement</i>(<span class="strcolor">'canvas'</span>),       <span class="strcolor">//Создали "холст"
</span>		context, 
		appConsole = document.<i>getElementById</i>(<span class="strcolor">'console'</span>); <span class="strcolor">//наше "окошко" вывода приложения
</span>	canvas.width  = 300;               <span class="strcolor">//ширина холста
</span>	canvas.height = 150;               <span class="strcolor">//высота холста
</span>	appConsole.innerHTML = <span class="strcolor">''</span>;         <span class="strcolor">//удаляем из окна вывода приложения все, что там может быть
</span>	appConsole.<i>appendChild</i>(canvas);    <span class="strcolor">//добавляем в окно вывода приложения наш холст, можно начинать рисовать
</span>	
	context = canvas.<i>getContext</i>(<span class="strcolor">"2d"</span>);   <span class="strcolor">//Получить контекст рисования
</span>	context.fillStyle = <span class="strcolor">"#FF0000"</span>;       <span class="strcolor">//Стиль заливки - красный. Проще говоря, будем рисовать красную фигуру.
</span>	<span class="strcolor">//Рисуем прямоугольник с координатами левого верхнего угла x = 10 и y = 10 
</span>	<span class="strcolor">// пикселей и шириной 100 и 110 пикселей
</span>	context.<i>fillRect</i>(10, 10, 100, 110);  
}
</pre>
<p>В этом коде много нового. Объект document доступен в JavaScript программе, которая выполняется в браузере у него есть свои свойства и методы.
Меня сейчас интересуют два из них. Первый, createElement служит для того, чтобы создать новый DOM элемент. 
Так как мне нужен холст, я передаю этому методу как аргумент строку 'canvas'. Полученный в результате вызова объект холста позволяет менять его свойства. Я изменил свойства ширина и высота, чтобы иметь возможность видеть то, что я буду рисовать на этом холсте.</p>
<p>Окошко, в котором мы видим вывод наших примеров имеет идентификатор "console". Используя метод объекта document <i>getElementById</i> мы можем получить переменную, с помощью которой можем взаимодействовать с ним. 
Первым делом я устанавливаю свойство innerHTML равным пустой строке. Это уничтожит все содержимое, которое может быть в этом окошке. </p>
<p>Затем вызываю метод <i>appendChild</i>, который есть у всех DOM элементов, в том числе и у того, на который ссылается наша переменная appConsole. На этом необходимые манипуляции с DOM заканчиваются, элемент холст создан, можно начинать рисование.
В этом примере я просто вывожу прямоугольник, чтобы убедится, что все работает.</p>
<p>Для начала мне надо получить контекст рисования. Я делаю это с помощью функции <i>getContext</i>, передавая ей как аргумент строку "2d", чтобы указать, что я буду работать с 2D графикой.</p>
<p>Далее я устанавливаю свойство объекта контекста fillRect в цвет, который выбрал для цвета прямоугольника и отрисовываю его вызвав метод <i>fillRect</i>.</p>
<div style="width:96%">
<div class="left"><?=QuickStartHandler::aback('arrays')?></div>
<div class="right"><?=QuickStartHandler::anext('graph2d')?></div>
<div class="clearfix"></div>
</div>
