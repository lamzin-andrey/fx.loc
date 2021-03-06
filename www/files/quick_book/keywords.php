<header>
	<h3>Ключевые слова языка</h3>
</header>
<p>Когда я начинал учиться программировать, меня часто раздражал в учебниках один факт: 
ближе к началу были приведены ключевые слова языка программирования, но они давались "без перевода", при том, 
что если некоторые я мог перевести буквально, другие были сокращениями от неизвестных мне слов. Это раздражало.</p>
<p>Здесь я попытаюсь избавиться от такого недоразумения.</p>
<p>Ниже перечисленны ключевые слова JavaScript (не все, а только те, которые я использую в повседневной практике).
 Наводя на слово курсор (указатель) мыши вы можете прочесть во всплывающей подсказке, как используется это ключевое слово. Если подсказка обрезается, кликнете на слове, описание откроется во всплывающем окне.
 Я старался дать в этих подсказках исчерпывающее определение для людей никогда не программировавших прежде.
Однако, перечитав подсказки я не могу сказать, что блестяще справился с этой задачей. Например, описывая слово with я не мог не упомянуть о том, что в режиме use strict его использование невозможно уже сейчас, однако не стал объяснять что такое "режим use strict". Такие вещи не должны вас смущать, все что вы не поняли во время чтения подсказки должно для вас проясниться по ходу дальнейшего чтения.
</p>
<p>Но сначала давайте разберемся, что такое вообще ключевые слова языка программирования.
Это прежде всего слова, <b><i class="tblack">которые нельзя использовать для именования функций</i></b> (пример функции JavaScript вы уже видели на предыдущей странице и мы еще к функциям вернемся) и 
<b><i class="tblack">переменных</i></b> (что это за зверь разберемся далее).</p>
<p>Это связано с тем, что каждое ключевое слово языка интерпретируется интерпретатором языка совершенно определенным образом. Таких слов чаще всего вообще не много, а я к тому же как сказал выше приведу только те из них, которые использую часто, то есть те, которые смогу вспомнить прямо сейчас.</p>
<p>У меня было небольшое колебание, валить ли в одну кучу собственно ключевые слова языка JavaScript  и 
слова определяющие в нем типы данных, решил валить, так как они соответствуют данному мною же определению</p>
<p>
<? include APP_ROOT . '/files/quick_book/keyworddiv.php';?>
</p>
<p> Если этот текст случится читать человеку занимающимся профессионально веб-разработкой, он скорее всего тут же спросит, где XMLHttpRequest, почему его нет в списке, хотя там есть Array, String и прочие им подобные.</p>
<p> Ответ прост: этот сайт предназначен для освоения человеком азов программирования вообще, а не программирования для web. Если получится, я добавлю раздел азов web-программирования на JavaScript, но это в очень отдаленной перспективе. И то буду очень долго думать, есть ли в этом добавлении раздела смысл: информации в сети по этой теме более чем достаточно, на том же  <a href="http://learn.javascript.ru/" target="_blank">http://learn.javascript.ru/</a></p>
<?=QuickStartHandler::prevnext('security', 'variables');?>

