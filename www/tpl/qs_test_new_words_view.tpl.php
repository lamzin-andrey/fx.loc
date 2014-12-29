<div class="tnwframe">
	<div id="qsTNWHelloScreen">
		<div class="clearfix">&nbsp;</div>
		<p class="tnwlabel">Проверьте себя,<br> знаете ли вы значение слов, использующихся в программном коде на уже прочтенных страницах.</p>
		<p class="tnwStartButtonPlace">
			<button id="tnwstartGame" >Пройти тест</button>
		</p>
	</div>
	<div id="qsTNWDonescreen" class="hide">
		<p class="tnw_done_vspacer">&nbsp;</p>
		<p id="tnwSuccess" class="box_shadow tnw_center tnw_done_msg">Правильно!</p>
		<p id="tnwSuccessInfo" class="box_shadow tnw_center tnw_done_msg hide">Не забывайте переодически проходить этот тест по мере чтения новых статей.</p>
	</div>
	<div id="qsTNWFailscreen" class="hide">
		<p class="tnw_done_vspacer">&nbsp;</p>
		<p id="tnwErr" class="box_shadow tnw_center tnw_fail_msg">Ошибка!</p>
	</div>
	<div id="qsTNWPlayscreen" class="hide">
		<div class="clearfix">&nbsp;</div>
		<p class="tnwtime">Осталось: <span id="time_left">0</span> сек. <span id="fail_result" style="color:red"></span><span id="good_news" style="color:#009900"></span></p>
		<p class="tnwhealth box_shadow">Health: <span id="lives"></span></p>
		<p class="tnwscore box_shadow">Score: <span  id="score"></span></p>
		<p class="">&nbsp;</p>
		<p id="quest_prefix" class="box_shadow tnw_center">Что значит:</p>
		<p class="tnw_vspacer">&nbsp;</p>
		<p id="quest" class="box_shadow tnw_center">&nbsp;</p>
		<textarea id="tnwanswer" class="hide" style="width:99%;" rows="20"></textarea>
		<p class="tnw_vspacer">&nbsp;</p>
		<div id="variants" class="tnw_center">
			<button>&nbsp;</button>
			<button>&nbsp;</button>
		</div>
	</div>
</div>
