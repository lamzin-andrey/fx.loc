<div id="stdfunctions">
	<pre>
<i title="//Стандартная функция браузерого JavaScript, метод объекта window.
//Выводит всплывающее окно с сообщением, переданнным в качестве aргумента
//Если в качестве аргумента была передана не строка, то попытается переобразовать его в строку, вызвав метод toString.
alert('Пример вывода простой строки');
alert(101); //Пример вывода числа
alert(['one','three','two']); //Пример вывода массива
alert(document.body); //Пример вывода чего-то еще
">alert(s)</i>  <i title='//Метод DOM объекта. Добавляет объекту потомка, определяемого строкой tagName.
//Попробуйте например выполнить 

document.body.appendChild(  document.createElement("textarea")  );

//промотав страницу вниз вы увидите, что внизу появилось новое меогострочное поле ввода

'>appendChild(tagName)</i> <i title="//Рисует на холсте прямоугольник определенного цвета
var c = document.getElementById('myCanvas');
var ctx = c.getContext('2d');
ctx.fillRect(20, 20, 150, 100);
">fillRect()</i>
'>appendChild(tagName)</i> <i title="//Метод объекта Math
Math.pow(2, 3); //Возводит 2 в третью степень
">pow(base, n)</i>
'>appendChild(tagName)</i> <i title="//Метод объекта Math
Math.sin(Math.PI * 30 / 180); //Получаем синус 30 градусов
//Так как метод ожидает аргумент в радианной мере, умножаем 30 на PI  и делим на 180 
">sin(radians)</i>
'>appendChild(tagName)</i> <i title="//Метод объекта Math
Math.cos(Math.PI * 30 / 180); //Получаем косинус 30 градусов
//Так как метод ожидает аргумент в радианной мере, умножаем 30 на PI  и делим на 180 
">cos(radians)</i>
'>appendChild(tagName)</i> <i title="//Метод объекта Math
Math.random(); //Вернет случайное дробное число от 0 до 1
">random()</i>
'>appendChild(tagName)</i> <i title="
isNaN(x); 		//Вернет true если аргумент - не число и false в противном случае
isNaN(101); 	//Вернет true
isNaN('Hello'); //Вернет false

">isNaN()</i> <i title="//Метод объекта RegExp
//Вернет истину, если строка соответствует регулярному выражению
//примеры
var re = /^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,4}$/mig;
alert(re.test('01/12/2014')); //Выведет false
	alert(re.test('01.12.2014')); //Выведет true
">test()</i>  <i title="//Метод объекта Math
//Возвращает квадратный корень аргумента
alert(Math.sqrt(9) ); //Получаем квадратный корень числа 9
">sqrt(n)</i>
	</pre>
</div>
