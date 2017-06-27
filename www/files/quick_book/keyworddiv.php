<div id="keywords">
	<pre class="no_copy">
<b title="//Определяет тип данных (объект типа) массив.

var array = new Array(); //новый пустой массив

//Простейшим примером массива может быть последовательность чисел:
var other_massiff = [0,1,2,3,4,5,6,7];//так тоже можно создавать массивы, только имя переменной дурацкое, я использовал его только для того, чтобы показать что необязательно использовать слово array в имени переменной

var third_array = [];// и даже так, и это более предпочтительно, чем первый метод, потому что меньше букв
">Array</b>  <b title='//Буквально "прервать".  Используется для прерывания цикла.
//Например, у нас есть массив (см. Array) из пятидесяти строк, и мы ищем в нем строку "Труба"). Мы не знаем, какое по счету оно в массиве, может быть и первым, а может последним.
//Тогда, если мы нашли это слово, нет смысла перебирать элементы массива дальше.
for (var i = 0; i < 50; i++) {
	if (array[i] == "Труба") {
		break; //Нашли, выходим.
	}
}

//См. также switch
'>break</b>  <b title='//Используется вместе с switch. См. подсказку к нему'>case</b>  <b title='//Буквально "хватать".
//Используется совместно с try  и finally, например:
try {
	//здесь код, который может создать ошибку интерпретации
} catch(error) {
	//Здесь делаем что-то, чтобы дать понять что так делать не надо, например
	alert("У вас в коде ошибка: " + error.message + " исправьте ее");
} finally {
	//А здесь делаем что-то, что должно быть сделано независимо от того, была ошибка или нет
}
//Подробнее читайте <a href="//javascript.ru/try-catch" target="_blank">javascript.ru</a>
'>catch</b>  <b title='//Буквально "продолжать". Используется для перехода к следующей итерации цикла.
//Например, у нас есть массив (см. Array) из большого количества длинных строк (по своей сути текстов), и мы ищем в массиве строку, содержащую слова "Труба", "серым", "костяной"). Так как строки - элементы массива длинные, функция проверки наличия подстроки может работать сравнительно долго.
//В подобных ситуациях есть смысл использования слова continue
for (var i = 0; i < arr.length; i++) {
	if (array[i].<i>indexOf</i>("Труба") == -1) {
		continue; //Раз нет первого слова, остальные можно не искать, переходим к строке i + 1
	}
}
'>continue</b>  <b title='//Используется вместе с switch. См. подсказку к нему'>default</b>  <b title='//Определяет тип данных (объект типа) дата.
//Несложно догадаться, для чего используется

var date = new Date();
alert("Сегодня " + date.getDate() + " / " + date.getMonth() + " / " + date.getYear() + "\nВремя: " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds());
'>Date</b>  <b title='//Буквально "делать".
//Используется совместно с  while, например:

do {
	alert("Ха-Ха");
} while (1 == 0);//выполнять тело цикла пока единица равна нулю. Так как равенство в скобках ложно, сообщение будет выведено только один раз.

//Можно сказать, что в примере написано "Делать алерт, пока единица равна нулю."
'>do</b> <b title='//Определяет тип данных (объект типа) ошибка.

var error = new Error(); //новая ошибка, но так обычно никто не делает.
error.message = "Ожидался ;, найден:";

//Более жизненный пример, где нибудь в дебрях кода:

throw new Error("Ждали денег, пришел счет!");
//Ваш коллега сможет поймать и обработать эту ошибку, наведите курсор на catch чтобы увидеть как.
'>Error</b>  <b title='//Буквально "иначе".

//Используется вместе с if, например:

if (sum >= 5.2) {
	//... тут списали со счета
	alert("Покупка оплачена");
} else {
	alert("На вашем счете не хватает средств.");
}
'>else</b>  <b title='//Определяет тип данных (объект типа) функция.

var F = new Function(); //новая функция, но так обычно никто не делает.

//Более жизненный пример, где-нибудь в дебрях кода:

if (f instanceof Function) {//если f - это функция
	f(); //вызвать ее.
}
'>Function</b>  <b title='//Буквально "ложь". Значение, получающееся в результате операций сравнения (>, <. ==, ===, !=):

alert(1 == 0); //Выведет false потому что единица не равна нулю

//Это значение может быть присвоено переменной:

var x = false;
alert(x);//Выведет false
'>false</b>  <b title='//Буквально "в заключении". См. catch'>finally</b>  <b title='//Буквально "для". Один из способов определить (описать) цикл в программе, например:

//выводим пять раз слово "ура!"
for (var i = 0; i < 5; i++) {//начало тела цикла
	alert("ура!, это раз номер " + (i + 1));
}//конец тела цикла

//for (var i = 0; i < 5; i++) можно понимать как "Для переменной i, меньшей пяти выполнять код в теле цикла и увеличивать ее на единицу".

//То есть, мы могли бы записать и так:

var i = 0;//присвоить переменной значение 0
for (i; i < 5; i++) { //для i меньшей 5 выполнять тело цикла и увеличивать ее после этого на единицу
	//...
}
//результат был бы тот же.
//См. также подсказку на слове in
'>for</b>

<b title='//Определяет функцию. Пример:

function myFunction(argument_1, argument_2) {//начало определения функции
	//код расположенный здесь (внутри определения или тела функции) можно использовать в программе снова и снова
}//конец определения функции
//Аргументов функции может быть сколько угодно, может и не быть, все зависит от целей, для которых мы ее определяем.

//Функция может быть анонимной (не иметь имени)
//Такие функции обычно используют как обработчики наступления каких-то событий, например

//раз в пять секунд писать "прошло пять секунд...", через час прекратить
var count = 0, intervalHandle = setInterval(
	function () {
		writeln("прошло пять секунд...");
		count++;
		if (count > 720) {
			clearInterval(intervalHandle);
		}
	}, 
	5*1000
);
'>function</b>  <b title='//Буквально "если".

//Можно навести курсор мыши на else и прочесть о нем там.
//"Имейте только ввиду, что if может использоваться без else, а else без if - нет"  &copy; капитан Очевидность.
'>if</b>  <b title='//Буквально "в". Используется вместе с for

//Один из способов организовать цикл. На практике обычно используется для обхода "простого" объекта (см. подсказку к слову Object).

//Например, код
var obj = {type:"Посуда", name:"Тарелка", price:400}

for (var i in obj) {
	alert( "i = \"" + i + "\", obj[i] = \"" + obj[i] + "\"");
}

/*выведет:
"type" = "Посуда"
"name" = "Тарелка"
"price" = "400"*/
'>in</b>  <b title='//Используется для проверки типа переменной. Например:

var a_function = function(a, b) { //Определили функцию
	return Math.pow(a, b);
}
var array = new Array(); //Определили массив
var s = "Приветы"; //Определили строку

alert( a_function instanceof Function ); //Выведет true
alert( array instanceof Function ); //Выведет false
alert( s instanceof Function ); //Выведет false

alert( a_function instanceof Array ); //Выведет true
alert( array instanceof Array ); //Выведет false
alert( s instanceof Array ); //Выведет false 

//Думаю, из кода выше принцип ясен. Но есть одно но!
alert(s instanceof String ); //Выведет false!
//Если бы строка былв определена с использованием new String вывело бы true

//И еще более неприятно:
alert( a_function instanceof Object ); //Выведет true
alert( array instanceof Object ); //Выведет true
alert( s instanceof Object ); //Выведет false если s = "";  и true если s = new String();

//Поэтому приходится комбинировать использование instanceof и стандартной функции языка typeof

alert("s IS " +  (typeof(s))); //Выведет s IS string если s = "";  и s IS object если s = new String();

//Поэкспериментировать с typeof вы можете самостоятельно
'>instanceof</b>  <b title='//Буквально "Бесконечность". Используется для обозначения бесконечно большого числа.

//Например код

var i = 1;
i = i << 30; //получаем довольно большое число, про операцию << будет дальше
i = Math.pow(i,i);//возводим это большое число в степень равную ему самому.
alert(i);//выведет Infinity
'>Infinity</b>  <b title='//Специальный объект языка. В нем собраны математические функции, такие как синус, косинус, округление и прочие.
//Пример использования:
alert(Math.sin(Math.PI * 30 / 180));// выведет... почти верное значение синуса 30 градусов.
'>Math</b>  <b title='//Not a Number - специальное значение, которое может принять объект типа Number
//Например, попытаемся получить число из тарелки
var n = new Number("Тарелка");
alert(n); //выведет NaN

//Особенность значения в том, что с ним нельзя сравнивать "обычно".
alert(n == NaN); //выведет false

//Для проверки, NaN объект или не NaN иcпользуйте стандартную функцию isNaN
alert(isNaN(n)); //выведет true
'>NaN</b>  <b title='//Определяет тип данных (объект типа) число. Например

var n = new Number(10);//Создали объект типа Number но так никто не делает. Все делают var n = 10;
alert(n);//выведет 10
'>Number</b>  <b title='//Буквально "новый". Пришло скорее всего из языка C/С++ где подразумевало команду выделить новый участок памяти.
//Может использоваться при создании переменной любого встроенного или определенного программистом типа данных, например Object, String, Number, Array, Function, но для некоторых стандартных типов объектов есть более лаконичные варианты.
//Например:
var arr = []; /*эквивалентно*/ var arr = new Array();
var obj = {}; /*эквивалентно*/ var obj = new Object();
var str = ""; /*почти эквивалентно*/ var str = new String();
var num = 0; /*почти эквивалентно*/ var num = new Number(0);

//Почему строки и числа "почти эквивалентны" - можно прочесть в подсказке об instanceof

//На практике new чаще используется только для создания объектов типов, определенных программистом, например:

//Создадим (определим) тип объекта "Сфера"
function Sphere(x, y, z, r) {//три координаты центра и радиус
	this.x = x;
	this.y = y;
	this.z = z;
	this.r = r;
}
//Создадим два объекта типа сфера:
var sphere_1 = new Sphere(1, 2, 3, 4),
	sphere_2 = new Sphere(5, 6, 7, 8);
alert(sphere_1.x);
alert(sphere_2.x);

'>new</b>  <b title='//Буквально "ноль". Но это не ноль! 
//Это значение используется как "Вообще ничего".
//В программировании ноль - это вполне конкретное значение.
//Поэтому код

alert(0 === null);

//выведет false (ложь).

'>null</b>  <b title='//Определяет тип данных (объект типа) Простой объект. 
//На самом деле этот тип данных называется просто Объект, но я буду использовать всюду словосочетание "Простой объект", 
//чтобы избежать путаницы, так как в JavaScript практически вообще всё можно назвать объектом и вы при этом очень редко ошибетесь. 
//Простыми объектами удобно описывать реальные и 
//абстрактные сущности или предметы.

//Например
var sphere = new Object();//Создали простой объект, который будет описывать сферу в пространстве. 
//Сфера характеризуется координатами центра и радиусом.
sphere.x = 5;
sphere.y = 0;
sphere.z = 10;
sphere.r = 2;
//Теперь наш объект описывает сферу. x, y, z, r называются полями или свойствами объекта.

//Однако, так никто не делает. Пишут более коротко:

var sphere = {x:5, y:0, z:10, r:2}; //C тем же результатом.

//Кроме простых значений, значениями свойств объекта могут быть функции. Например:
sphere.isIntersect = function(sphere2) {
	//здеcь может быть код, проверяющий, пересекаются ли поверхности сферы sphere2  и сферы для которой вызван метод isIntersect
	//Получить значения "собственных" свойств можно используя слово this
	alert(this.x);
}
sphere.isIntersect(sphere);//Выведет 5

'>Object</b>  <b title='//Буквально "прототип". Свойство, которое есть у любой функции JavaScript.

//Используется для реализации наследования. Например (сначала прочтите подсказку для ключевого слова Object),у нас в программе должно быть много объектов-сфер.
//Чтобы не определять функцию isIntersect для каждого объекта сферы мы можем слегка изменить код из подсказки про Object.

var Sphere = function (x, y, z, r) { //Здесь создали новый тип объекта, Sphere
		this.x = x; //Эта и следующие строки, чтобы он вел себя как простые объекты из подсказки про объекты
		this.y = y;
		this.z = z;
		this.r = r;
	}
	Sphere.prototype.isIntersect = function(sphere2) { //а метод (функцию) добавим прототипу объекта Sphere
	//здеcь может быть код, проверяющий, пересекаются ли поверхности сферы sphere2  и сферы для которой вызван метод isIntersect
	//Получить значения "собственных" свойств можно используя слово this
	alert(this.x);
}

var sphere = new Sphere(5, 0, 10, 2);
var sphere2 = new Sphere(7, 0, 10, 2);

sphere.isIntersect();//Выведет 5
sphere2.isIntersect();//Выведет 7

'>prototype</b>  <b title='//Определяет тип данных (объект типа) "регулярное выражение". Например:
var re = new RegExp("^[0-9]{1,2}\\.[0-9]{1,2}\\.[0-9]{1,4}$");//Но так стараются не делать, см. ниже
//Здесь первый аргумент - это строка - шаблон регулярного выражения. Что такое "шаблон регулярного выражения"  - это отдельная тема, которую в эту подсказку втиснуть вряд ли возможно.
//Скажу лишь, что в этом примере задан шаблон, которому соответствуют записи вида 00.00.0000 и его можно использовать для проверки, пришла ли в программу дата в правильном формате.

//Помимо строки шаблона в RegExp() можно передавать второй аргумент - символы "m", "g" или "i" но об этом тоже наверное позже

//Если шаблон-строку не планируется формировать "на лету" (в процессе выполнения программы)
//то обычно люди используют запись
var re = /^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,4}$/igm;
//чтобы писать меньше.
//второй аргумент передается в этом случае после последнего слэша, в примере он не нужен но и вреда по большому счету не приносит.

//Ну и напоследок, для наглядности:

alert(re.test("01/12/2014")); //Выведет false
alert(re.test("01.12.2014")); //Выведет true
'>RegExp</b>

<b title='//Буквально "Возврат". Используется внутри функции, чтобы прервать ее выполнение и (возможно) вернуть вызвавшей программе результат работы функции. Например:

function aPlusB(a, b){ //функция складывает два числа
	if (isNaN(a) || isNaN(b)) { //если один из операндов - не число, можно дальше не тратить машинное время
		return;
	}
	var sum = a + b;
	return sum;
}

alert( aPlusB(1,5) ); //Выведет 6
alert( aPlusB(1,"не число") );//Выведет undefined, так как вернули нечто неопределенное.
'>return</b>  <b title='//Определяет тип данных (объект типа) строка. Например:

var s = new String("Что это такое"); //Создали новую переменную типа "объект строка",но так никто не делает

var s = "Что это такое";  //дает тот же эффект
'>String</b>  <b title='//Буквально "переключатель". 
	switch (surname) {
		case "Гагарин":
			alert("Первый космонавт");
			break; //Если не ставить break и surname == "Гагарин" то alert про президента тоже будет выведен
		case "Путин":
			alert("Президент");
			break; //Если не ставить break и surname == "Путин" то alert "Не знаю, кто это" тоже будет выведен
		default:  //"Не знаю, кто это" вылезет, если surname не равно ни "Путин" ни "Гагарин"
			writeln("Не знаю, кто это.");
			break;
	}

'>switch</b>  <b title='//Буквально "этот". Используется в коде функций, оппределенных, как часть объекта для доступа к свойствам и другим функциям <strong class=tblack>этого</strong> объекта. 
//Пример см. в подсказке для Object
//
'>this</b>  <b title='//Буквально "бросать". Пример см. в подсказке для Error
'>throw</b>  <b title='//Буквально "пытаться". Пример см. в подсказке для catch
'>try</b>  <b title='//Буквально "истина". Читайте подсказку к false, true ее антипод.'>true</b>  <b title='//Буквально "Неопределено". Специальное значение, которому равна любая переменная, которой не присвоено значение. Например

var x;
alert(x); //Выведет undefined

//Также как и NaN это значение нельзя присвоить, и с ним нельзя сравнить. Однако, стандарной функции подобной isNaN не предусмотрено.
'>undefined</b>  <b title='//Сокращение от variable - переменная. Пример:

var x, y = 102; //Объявили переменные x и y, y определили - присвоили ей значение 102
alert(x); //Выведет  undefined (неопределено)
alert(y); //Выведет 102

//Хотя вы можете "обнаружить", что объявление 

x, y = 10;

//ведет себя точно также, лучше возьмите себе за правило всегда объявлять переменные используя слово var.

//Это сэкономит нервных клеток вам и вашим коллегам.'>var</b>  <b title='//Буквально "с". От этого слова JavaScript скоро избавится, оно уже недоступно в режиме "use strict". Однако не в режиме "use strict" на мой взгляд лет пять для его использования у нас точно есть ;-).
//Используется для упрощения доступа к полям или свойствам объекта (см. подсказку для Object).

//Пример использования:

var obj = {z:1, x:5};
with (obj) {
	alert(z);//Выведет 1
	alert(x);//Выведет 5
}
'>with</b>  <b title='//Буквально "пока". Один из способов определить (описать) цикл. Например
var i = 0;
while (i < 5) { //Пока  i меньше пяти
	alert(i);
	i++;
}
'>while</b>
	</pre>
</div>
