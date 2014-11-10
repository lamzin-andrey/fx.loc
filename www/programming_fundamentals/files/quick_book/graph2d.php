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
<p>Пример работает, однако от него мало толку. Во-первых, холст хочется растянуть как минимум на все окношко вывода приложения, а еще лучше на весь экран. Сделать это довольно просто. 
Сначала задам холсту размер окошка приложения.</p>
<pre>
<b>function</b> createCanvasExample() {
	<span class="strcolor">"use strict"</span>
	<b>var</b> canvas = document.<i>createElement</i>(<span class="strcolor">'canvas'</span>),       <span class="strcolor">//Создали "холст"
</span>		context, 
		appConsole = document.<i>getElementById</i>(<span class="strcolor">'console'</span>); <span class="strcolor">//наше "окошко" вывода приложения
</span>	canvas.width  = appConsole.offsetWidth;               <span class="strcolor">//ширина холста
</span>	canvas.height = appConsole.offsetHeight;               <span class="strcolor">//высота холста
</span>	appConsole.innerHTML = <span class="strcolor">''</span>;         <span class="strcolor">//удаляем из окна вывода приложения все, что там может быть
</span>	appConsole.<i>appendChild</i>(canvas);    <span class="strcolor">//добавляем в окно вывода приложения наш холст, можно начинать рисовать
</span>	
	context = canvas.<i>getContext</i>(<span class="strcolor">"2d"</span>);   <span class="strcolor">//Получить контекст рисования
</span>	context.fillStyle = <span class="strcolor">"#FF0000"</span>;       <span class="strcolor">//Стиль заливки - красный. Проще говоря, будем рисовать красную фигуру.
</span>	<span class="strcolor">//Рисуем прямоугольник с координатами левого верхнего угла x = 10 и y = 10 
</span>	<span class="strcolor">// пикселей и шириной 100 и 110 пикселей
</span>	context.<i>fillRect</i>(0, 0, canvas.width, canvas.height);  
}
</pre>
<p>Здесь я просто заменил числа значениями ширины и высоты окошка консоли вывода приложения, получив их значения, хранящиеся в свойствах DOM элемента offsetWidth  и offsetHeight.</p>
<p>Если надо развернуть ваше графическое приложение на весь экран, можно использовать код:</p>
<pre>
<b>function</b> createCanvasExample() {
	<span class="strcolor">"use strict"</span>
	<b>var</b> canvas = document.<i>createElement</i>(<span class="strcolor">'canvas'</span>),       <span class="strcolor">//Создали "холст"
</span>		context,
		i, firstTextY, text, sz;
	canvas.width  = screen.width;               <span class="strcolor">//ширина холста
</span>	canvas.height = screen.height;              <span class="strcolor">//высота холста
</span>	
	document.body.<i>appendChild</i>(canvas); <span class="strcolor">//добавляем на страницу наш холст, можно начинать рисовать
</span>	<span class="strcolor">//делаем холст "ближе к нам", чтобы он перекрыл все остальное на странице
</span>	canvas.style.zIndex = 5;        
	canvas.style.position = <span class="strcolor">'absolute'</span>;
	canvas.style.top = <span class="strcolor">'0px'</span>;
	canvas.style.left = <span class="strcolor">'0px'</span>;
	
	canvas.onclick = <b>function</b> () { <span class="strcolor">//при клике удаляем его
</span>		document.body.<i>removeChild</i>(canvas);
	}
	context = canvas.<i>getContext</i>(<span class="strcolor">"2d"</span>);   <span class="strcolor">//Получить контекст рисования
</span>	context.fillStyle = <span class="strcolor">"#00AA00"</span>;       <span class="strcolor">//Стиль заливки - темно-зеленый
</span>	<span class="strcolor">//Рисуем прямоугольник на весь холст
</span>	<span class="strcolor">
</span>	context.<i>fillRect</i>(0, 0, canvas.width, canvas.height);
	context.strokeStyle = <span class="strcolor">'#ffffff'</span>;
	context.font = <span class="strcolor">'25px Geneva'</span>;
	text = <span class="strcolor">'Нажмите F11 для перехода в полноэкранный режим'</span>,
		firstTextY = <b>Math</b>.<i>round</i>(screen.height / 2);
	context.<i>strokeText</i>(text, <b>Math</b>.<i>round</i>(screen.width / 2 - context.<i>measureText</i>(text).width / 2),firstTextY);
	context.font = <span class="strcolor">'14px Geneva'</span>;
	context.fillStyle = <span class="strcolor">'#FFFF00'</span>;
	text = <span class="strcolor">'Кликните для закрытия этого зеленого фона!'</span>;
	context.<i>fillText</i>(text, <b>Math</b>.<i>round</i>(screen.width / 2 - context.<i>measureText</i>(text).width / 2),firstTextY + 30);
}
</pre>
<p>В отличии от предыдущего примера я использовал объект screen для того, чтобы получить ширину и высоту экрана и присвоил эти значения в свойства width и height элемента canvas. 
Еще одно отличие в том, что созданный элемент canvas добавляется как потомок не DOM элементу который показывает вывод приложения, а
"корневому" элементу DOM документа - body.</p>
<p>Строки 11 - 14 служат для того, чтобы поместить наш элемент canvas поверх всего остального содержимого страницы, интересующемся подробностями советую погуглить статьи и учебники по css.</p>
<p>Далее, назначаем для обработки клика по холсту анонимную функцию. В ней с помощью метода <i>removeChild</i> удаляем наш холст из документа.</p>
<p>Помимо прямоугольника, на этот раз зеленого, выводим на холсте две надписи разными стилями и цветами. Используем свойства контекста рисования font, strokeStyle и fillStyle для определения размера, семейства и цвета шрифта. После того, как эти параметры заданы, мы можем узнать ширину будущей надписи, хотя она еще не выведена. Для этого используется метод <i>measureText</i>, возвращающая объект, у которого есть свойство width, содержащее ширину текста. Сам текст выводится с помощью методов strokeText и fillText, второй и третий аргументы методов определяют x и y координаты левого верхнего угла надписей.</p>
<p>Я решил не ограничивать себя и использовать весь экран при решении примеров, связанных с графикой. Поэтому стоит оформить этот код в виде функции, так как он сравнительно объемен. При решении примера в коде будет только вызов функции <u>createFullScreenContext</u>.</p>
<div class="ainfo">Конечно, fullScreen здесь достаточно условен, так как пользователь будет вынужден переводить браузер в полноэкранный режим "вручную" нажимая F11, но перевести окно браузера в полноэкранный режим с помощью одного только JavaScript если я не ошибаюсь, нельзя.</div>
<pre>
<b>function</b> <u>createCanvasExample</u>() {
	<span class="strcolor">"use strict"</span>
	<b>function</b> <u>createFullScreenContext</u>(color, parentElement, zIndex) {
		<b>if</b> (!zIndex) {
			zIndex = 5;  <span class="strcolor">//значение по умолчанию
</span>		}
		<b>if</b> (!color) {     <span class="strcolor">//Стиль заливки по умолчанию - темно-зеленый
</span>			color = <span class="strcolor">'#00AA00'</span>;
		}
		<b>if</b> (!parentElement) {
			parentElement = document.body;  <span class="strcolor">//значение по умолчанию
</span>		}
	    <b>var</b> canvas = document.<i>createElement</i>(<span class="strcolor">'canvas'</span>),       <span class="strcolor">//Создали "холст"
</span>		    context,
		    i, firstTextY, text, sz;
	        canvas.width  = screen.width;               <span class="strcolor">//ширина холста
</span>	        canvas.height = screen.height;              <span class="strcolor">//высота холста
</span>	
		parentElement.<i>appendChild</i>(canvas); <span class="strcolor">//добавляем на страницу наш холст, можно начинать рисовать
</span>		<span class="strcolor">//делаем холст "ближе к нам", чтобы он перекрыл все остальное на странице
</span>		canvas.style.zIndex = zIndex;
		canvas.style.position = <span class="strcolor">'absolute'</span>;
		canvas.style.top = <span class="strcolor">'0px'</span>;
		canvas.style.left = <span class="strcolor">'0px'</span>;
	
		context = canvas.<i>getContext</i>(<span class="strcolor">"2d"</span>);   <span class="strcolor">//Получить контекст рисования
</span>		context.fillStyle = color;  
		<span class="strcolor">//Рисуем прямоугольник на весь холст
</span>		context.<i>fillRect</i>(0, 0, canvas.width, canvas.height);
		<b>return</b> {context:context, canvas:canvas};
	}
	<b>var</b> _2d = <u>createFullScreenContext</u>();
	_2d.canvas.onclick = <b>function</b>() {
		document.body.<i>removeChild</i>(_2d.canvas);
	}
}
</pre>
<p>Функция <u>createFullScreenContext</u> может принимать три необязательных параметра: цвет заливки, DOM элемент к которому будет добавлен холст и zIndex на случай, если вдруг понадобится поместить очередной холст "над предыдущим". Впрочем, я постараюсь обходиться одним холстом.
Функция <u>createFullScreenContext</u> возвращает объект из двух свойств - в первом контекст рисования, во втором холст, чтобы его можно было удалить. Код, удаляющий холст при клике мышью я по понятным причинам вынес из функции: вряд ли понадобится удалять холст именно таким образом как сейчас, при клике в произвольной точке.
</p>
<p>На этом подготовку к решению примера по 2D графике можно было бы считать законченной, но это не совсем так. Почему, станет после прчтения текста  задания.</p>
<p>Задача: Создать окно в рамке  на фоне, заполненном псевдографическим символом #178 зеленого цвета, с текстом из файла.
По клавишам управления курсором выполнять скроллинг текста в окне на одну строку вверх или вниз.</p>
<p>Здесь у нас небольшая загвоздка: браузерный JavaScript не может работать с текстом из файла, расположенного на вашем компьютере.
Однако, некоторая альтернатива у нас есть. Опишу её в прокомментированом фрагменте кода далее, добавив при необходимости более развернутые комментарии после описания.</p>
function pseudoFileExample() {
	var appConsole = document.getElementById('console'), //наше "окошко" вывода приложения
		textInput  = document.createElement('textarea'), //Создали элемент для ввода многострочного текста
		nameInput  = document.createElement('input'),    //Создали элемент для ввода многострочного текста
		saveButton = document.createElement('button');   //Создали кнопку "Сохранить"
	textInput.style = "width:99%; resize:none; height:480px;";
	textInput.id = "pseudofileContent";
	nameInput.style = "width:99%";
	nameInput.id = "pseudofileName";
	saveButton.id = "pseudofileSaveButton";
	saveButton.align = "right";
	appConsole.innerHTML = '';
	appConsole.appendChild(textInput);
	appConsole.appendChild(nameInput);
	appConsole.appendChild(saveButton);
}
<div style="width:96%">
<div class="left"><?=QuickStartHandler::aback('arrays')?></div>
<div class="right"><?=QuickStartHandler::anext('graph2d')?></div>
<div class="clearfix"></div>
</div>
