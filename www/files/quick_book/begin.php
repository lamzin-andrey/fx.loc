<header>
	<h3>Начинаем выполнять примеры</h3>
</header>
<p>Итак можно приступать. Вы знаете, что такое переменные и функции, имеете представление о типах объектов, которые хранятся в ваших переменных и знаете, 
где посмотреть какие методы и свойства есть у ваших переменных.</p>
<p>Я буду здесь выполнять с подробными комментариями один из вариантов заданий, которые вы можете видеть пройдя по ссылке <a href="<?=WEB_ROOT?>/tasklist/">Список задач</a></p>
<p>Это задачи различных вузов, которые мне удалось найти в интернете и те, которые у меня остались после учебы.</p>
<p>Почти все они придумывались в расчете на то, что учащиеся будут писать консольные приложения. 
Типичное консольное приложение работает так: приглашает пользователя ввести какие-то данные, которые надо обработать, выводит результат и заканчивает на этом свою работу.
</p>
<p>В браузерном JavaScript есть подходящие для реализации такого приложения средства: методы объекта window alert  и prompt.
Но в контексте наших задач у них есть небольшой недостаток в сравнении с командной строкой windows или терминалом unix:
эти консоли сохраняют в процессе сеанса запуска все, что вы ввели ранее и что выводила программа.
Это полезно, например если ваша программка дала сбой, вы видите что вы вводили в последний раз.
</p>
<div class="ainfo">Вообще-то для таких дел существуют инструменты называемые отладчиками, но на первых порах консоль это тоже очень хорошо.</div>
<p>Поэтому вы можете использовать на этом сайте вместо alert  и prompt функции writeln  и readln. Названия я позаимствовал из Паскаля, но это не принципиально.</p>
<p>Для наглядной разницы можете выполнить в консоли два примера:
<pre>
	<b>function</b> <u title='используем стандартные'>useAlertPrompt</u>() {
		<b>var</b> v = <i title='Предлагает пользователю ввести значение'>prompt</i>('Сколько вам лет');
		v  = <i title='анализировать целое число'>parseInt</i>(v);
		<b>if</b>(!<i title=''>isNaN</i>(v)) {
			<i title='Выводит окно с сообщением'>alert</i>('Вам ' + v + ' лет!');
		} <b>else</b> {
			<i title='Выводит окно с сообщением'>alert</i>('Ну и не надо!');
		}
	}
</pre>
</p>
<p>И то же самое с использованием writeln  и readln
<pre>
	<b>function</b> <u title='используем стандартные'>useReadWrite</u>() {
		<b>var</b> v = <u title='На этом сайте предлагает пользователю ввести значение'>readln</u>('Сколько вам лет');
		v  = <i title='анализировать целое число'>parseInt</i>(v);
		<b>if</b>(!<i title=''>isNaN</i>(v)) {
			<u title='На этом сайте выводит в консоль вывода что вам надо ввести'>writeln</u>('Вам ' + v + ' лет!');
		} <b>else</b> {
			<u title='На этом сайте выводит в консоль вывода что вам надо ввести'>writeln</u>('Ну и не надо!');
		}
	}
</pre>
</p>
<?=QuickStartHandler::prevnext('functions', 'arithmetic');?>
