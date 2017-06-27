<div id="stdfunctions">
	<pre>
<i title="//Стандартная функция браузерого JavaScript, метод объекта window
//window.alert(s);
//Выводит всплывающее окно с сообщением, переданнным в качестве aргумента
//Если в качестве аргумента была передана не строка, то попытается переобразовать аргумент в строку, вызвав для него метод toString
alert('Пример вывода простой строки');
alert(101); //Пример вывода числа
alert(['one','three','two']); //Пример вывода массива
alert(document.body); //Пример вывода чего-то еще">alert(s)</i>
<i title='//Метод DOM элемента страницы. Добавляет "во внутрь" объекта другой объект.
//Попробуйте например выполнить 
document.body.appendChild(  document.createElement("textarea")  );
//промотав страницу вниз вы увидите, что внизу появилось новое многострочное поле ввода'>appendChild(tagName)</i>
<i title="//Рисует на холсте прямоугольник определенного цвета
var c = document.getElementById('myCanvas');
var ctx = c.getContext('2d');
ctx.fillRect(20, 20, 150, 100);">fillRect()</i>
<i title="//Метод объекта Math
Math.pow(2, 3); //Возводит 2 в третью степень">pow(base, n)</i>
<i title="//Метод объекта Math
Math.sin(Math.PI * 30 / 180); //Получаем синус 30 градусов
//Так как метод ожидает аргумент в радианной мере, умножаем 30 на PI  и делим на 180">sin(radians)</i>
<i title="//Метод объекта Math
Math.cos(Math.PI * 30 / 180); //Получаем косинус 30 градусов
//Так как метод ожидает аргумент в радианной мере, умножаем 30 на PI  и делим на 180">cos(radians)</i>
<i title="//Метод объекта Math
Math.random(); //Вернет случайное дробное число от 0 до 1">random()</i>
<i title="isNaN(x); 		//Вернет true если аргумент - не число и false в противном случае
isNaN(101); 	//Вернет true
isNaN('Hello'); //Вернет false">isNaN()</i>
<i title="//Метод объекта RegExp
//Вернет истину, если строка соответствует регулярному выражению
//примеры
var re = /^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,4}$/mig;
alert(re.test('01/12/2014')); //Выведет false
	alert(re.test('01.12.2014')); //Выведет true">test()</i>
<i title="//Метод объекта Math
//Возвращает квадратный корень аргумента
alert(Math.sqrt(9) ); //Получаем квадратный корень числа 9">sqrt(n)</i>
<i title="//Стандартная функция браузерного javascript
//возвращает то значение, которое ввел пользователь в всплывающее окно
var s = prompt('Введите свое имя');
alert('Вас зовут ' + s );//Выводим только что заданное имя">prompt(s)</i>
<i title="//Стандартная функция javascript
//Пытается определить целое число в переданном аргументе
//Первым аргументом передается строка или число, вторым - основание системы счисления
//Если не передавать второй аргумент, попытается определить систему счисления автоматически
//На момент написания этих строк пока еще остается важным указывать систему счисления явно например при обработке дат
alert(parseInt('09')); //Выведет 0 в Internet Explorer 8 и других старых браузерах, так как в JavaScript два числа с ведущем нулем считаются записью в восьмеричной системе счисления
alert( parseInt('Вас зовут...') );  //выведет NaN (Not a Number - Не число)
alert( parseInt('07') );  //выведет 7">parseInt(s)</i> <i title="//Стандартная функция javascript
//Пытается определить, дробное число в переданном аргументе
//Первым аргументом передается строка или число
alert(parseFloat('0.9')); //Выведет 0.9
alert('Вас зовут...');  //выведет NaN (Not a Number - Не число)">parseFloat(s)</i>
<i title='//Метод объекта Math
//Math.floor(floatNumber);
//Возвращает число, округленное "вниз", то есть
alert(Math.floor(2.9) ); //Выведет 2'>floor(f)</i> 
<i title='//Метод объекта Math
//Math.ceil(floatNumber);
//Возвращает число, округленное "вверх", то есть
alert(Math.ceil(2.1) ); //Выведет 3'>ceil(f)</i>
<i title='//Метод объекта типа String
String.charAt(n)
//Возвращает из строки символ номер n
//Символы при этом нумеруются с нуля
var s = new String("abc"),
		q = "dke";
alert(s.charAt(1) ); //Выведет b
alert(q.charAt(0) ); //Выведет d'>charAt(n)</i>
<i title='//Метод объекта типа String
//Возвращает позицию первого вхождения подстроки substring
//Символы при этом нумеруются с нуля
var s = "abcde",
	substr = "de";
alert(s.indexOf(substr) ); //Выведет 3

//необязательный параметр offset (отступ) указывает, на сколько символов вправо надо сместиться перед началом поиска
s = "else";
var offset = 1;
alert(s.indexOf("e", offset) ); //Выведет 3
alert(s.indexOf("e") ); //Выведет 0'>indexOf(substring, offset)</i>
<i title='//Метод объекта типа String
//Возвращает подстроку от символа номер start до символа номер end
//Символы при этом нумеруются с нуля
var s = "abcde";
alert(s.substring(0, 1) ); //Выведет a'>substring(start, end)</i>
<i title='//Метод объекта типа String
//String.replace(pattern, replacement);
//Заменяет подстроку pattern строкой replacement.
//Если в качестве pattern передана строка, выполняется замена только первого вхождения
var s = "abecde";
alert(s.replace("e", "D") ); //Выведет abDcde

//Если требуется заменить несколько вхождений, можно использовать регулярные выражения
alert(s.replace(/e/g, "D") ); //Выведет abDcdD

//Часто регулярные выражения используются для сложных замен
//Например требуется вырезать html теги оставив их содержимое
alert(htmlText.replace(/&lt;[^&gt;]+&gt;/mig, "") ); //Выведет только текст содержащийся внутри тегов'>replace(pattern, replacement)</i>
<i title='//Метод объекта типа String
//String.toLowerCase(s);
//Заменяет все прописные символы в строке строчными
//Если в качестве pattern передана строка, выполняется замена только первого вхождения
var s = "abЕcde";
alert(s.toLowerCase(s) ); //Выведет abecde
'>toLowerCase(s)</i>
<i title='//Метод объекта типа String
//String.toUpperCase(s);
//Заменяет все прописные символы в строке строчными
//Если в качестве pattern передана строка, выполняется замена только первого вхождения
var s = "abЕcde";
alert(s.toUpperCase(s) ); //Выведет ABECDE
'>toUpperCase(s)</i>
<i title='//Метод объекта Math
//Math.abs(n);
//Возвращает абсолютное значение (модуль) числа
alert(Math.abs(-5)); //Выведет 5'>abs(n)</i>
<i title='//Метод объекта типа Array
//Array.splice(start, length, newItem1, newItem2, ...);
//Удаляет length элементов массива начиная с позиции start
//Если передано аргументов более двух, третий и последующие вставляются в массив начиная с позиции start
//Метод изменяет тот массив, к которому применен
var a = [0, 1, 2];
a.splice(1, 0, 9);
alert(a); //Выведет 0,1,9,2
a = [0, 1, 2];
a.splice(1, 1, 9);
alert(a); //Выведет 0,9,2'>splice(start, length, newItem1, newItem2, ...)</i>
<i title='//Метод объекта типа String
//String.split(pattern, limit);
//Разбивает строку на массив строк по разделителю pattern
//pattern может быть строкой или регулярным выражением
var s = "one,two,three";
var a = s.split(",");
alert(a[1]); //Выведет two
alert(a[2]); //Выведет three

//Параметр (аргумент) limit задает ограничение на максимальное число элементов в массиве
a = s.split(",", 2);
alert(a[1]); //Выведет two
alert(a[2]); //Выведет undefined'>split(pattern, limit)</i>
<i title='//Метод объекта типа Object
//Object.toString();
//В случае числа возвращает строку содержащую представление числа в десятеричной системе счисления
//В случае массива выводит элементы массива объединенные запятыми. К каждому элементу массива применяется при этом метод toString
//В остальных случаях возвращает строку, иногда содержащую информацию о типе объекта
var s = "one,two,three";
var a = s.split(",");
alert(a.toString()); //Выведет  one,two,three
alert(document.body); //Выведет [object HTMLBodyElement], метод toString вызвался интерпретатором неявно

//Для типов объектов, созданных программистом можно при необходимости переопределить этот метод
function D() {
	this.field= 0;
}
var d = new D();
alert(d); //Выведет [object Object]

//Но если переопределить метод

function C() {
	this.field= 0;
	C.prototype.toString = function() {
		return "This object of the class C";
	}
}
var c = new C();
alert(c); //Выведет This object of the class C'>toString()</i>
<i title='//Метод объекта document
//document.createElement(tagName);
//Создает html элемент типа, указанного в строке tagName
//Практически это значит, что вы можете таким образом создавать 
//в процессе выполнения программы графические кнопки, поля ввода,
//блоки текста, изображения,
//холст для рисования на нем

//Созданные элементы могут быть добавлены "во внутрь" любого существующего на веб-странице элемента, как минимум на странице присутствует
//элемент body - "тело" документа, обратиться к нему можно таким образом:
//document.body
//Пример
var textBlock = document.createElement("div"); //создали текстовый блок
textBlock.innerHTML = "Я создан в программе";        //Текст, который будет внутри этого блока
textBlock.style.color = "red";                       //Пусть он будет красным
textBlock.style.backgroundColor = "black";           //На черном фоне
document.body.appendChild(textBlock);                //Добавим новый элемент в документ
//Если вы выполните этот код и прокрутите страницу в браузере до конца вниз
//вы увидете красный текст на черном фоне

//Если вам известен идентификатор какого-либо текстового блока на странице, можно добавить ваш элемент "во внутрь" его
//Пример
var div = document.createElement("div"); 			//создали текстовый блок
div.innerHTML = "Я тоже создан в программе";        //Текст, который будет внутри этого блока
div.style.color = "red";                       		//Пусть он будет красным
document.getElementById("console").appendChild(div);//Добавим новый элемент в окошко вывода вашей программки

//Возможные значения аргумента tagName можно найти в любом справочнике по языку HTML'>createElement(tagName)</i>

<i title='//Метод объекта document
//document.getElementById(id);
//Возвращает html элемент, имеющий указанный id
//Если элемент найден, с ним можно выполнять различные действия, изменять его свойства, содержимое, удалить его
//Пример
writeln("Здравствуйте!");
var appConsole = document.getElementById("console");//Попробуем найти окошко вывода вашей программки
if (appConsole) {
	with (appConsole.style) {
		color = "#34BF13";               //перекрасим шрифт в зеленый
		backgroundColor = "#2D101C";   //а фон в темно-малиновый
	}
} else {
	alert("Это только на сайте работает!");
}'>getElementById(id)</i>

<i title='//Метод объекта типа Canvas
//Canvas.getContext(contextType);
//Возвращает контекст рисования, 2d или 3d
//на котором уже можно рисовать
//Пример
"use strict"
var canvas = document.createElement("canvas"),       //Создали "холст"
	context, 
	appConsole = document.getElementById("console"); //наше "окошко" вывода приложения
	canvas.width  = 300;               //ширина холста
	canvas.height = 150;               //высота холста
	appConsole.innerHTML = "";         //удаляем из окна вывода приложения все, что там может быть
	appConsole.appendChild(canvas);    //добавляем в окно вывода приложения наш холст, можно начинать рисовать
	
	context = canvas.getContext("2d");   //Получить контекст рисования
	context.fillStyle = "#FF0000";       //Стиль заливки - красный. Проще говоря, будем рисовать красную фигуру.
	//Рисуем прямоугольник с координатами левого верхнего угла x = 10 и y = 10 
	// пикселей и шириной 100 и 110 пикселей
	context.fillRect(10, 10, 100, 110);'>getContext(contextType)</i>

<i title='//Метод объекта типа DOMElement
//DOMElement.removeChild(domElement);
//Удаляет элемент-потомок domElement у  DOMElement-а, для которого вызывается метод
//Например удалим содержимое нашего окошка вывода приложения
//(потом просто обновите страницу)
var appConsole = document.getElementById("console");
var parentElement = appConsole.parentNode;
parentElement.removeChild(appConsole);'>removeChild(domElement)</i>

<i title='//Метод объекта типа Canvas
//Canvas.strokeText(text, x, y);
//Выводит "контур" текста на холсте, начиная от точки x, y'>strokeText(text, x, y)</i>

<i title='//Метод объекта типа Canvas
//Canvas.fillText(text, x, y);
//Выводит "залитый" текст на холсте, начиная от точки x, y'>fillText(text, x, y)</i>

<i title='//Метод объекта типа Canvas
//Canvas.measureText(text);
//Возвращает ширину текста в пикселях'>measureText(text)</i>

<i title='//Метод объекта localStorage
//localStorage.setItem(key, value);
//Сохраняет в локальном хранилище значение value с "именем" key
//Сохраненное значение может быть получено с помощью метода getItem(key)
//Значение хранится, пока пользователь не очистит локальное хранилище браузера
localStorage.setItem("exampleKey", "test");
alert( localStorage.getItem("exampleKey") ); //test
localStorage.removeItem("exampleKey");
alert( localStorage.getItem("exampleKey") ); //null'>setItem(key, value)</i>

<i title='//Метод объекта типа Array
//Array.join(delimiter);
//Соединяет элементы массива в строку, вставляя между ними строку delimeter
var array = [0, 1, 2, 5, "numbers"];
alert (array.join("-")); //0-1-2-5-numbers'>join(delimeter)</i>

<i title="//Метод объекта Math
//Простое округление числа
alert (Math.round(0.5) ); //Получаем 1
alert (Math.round(0.4) ); //Получаем 0">round(floatNumber)</i>
	</pre>
</div>
