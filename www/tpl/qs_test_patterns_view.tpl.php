<div class="tnwframe">
	<div id="qsPTHelloScreen">
		<div class="clearfix">&nbsp;</div>
		<p class="tptlabel">Тест на знание паттернов проектироавния</p>
		<p class="tptStartButtonPlace">
			<button id="tptstartGame" >Пройти тест</button>
		</p>
	</div>
	<div id="qsPTDonescreen" class="hide">
		<p class="tpt_done_vspacer">&nbsp;</p>
		<p id="tptSuccess" class="tpt_box_shadow tnw_center tnw_done_msg">Правильно!</p>
		<p id="tptSuccessInfo" class="tpt_box_shadow tnw_center tnw_done_msg hide">Не забывайте переодически проходить этот тест по мере чтения новых статей.</p>
	</div>
	<div id="qsPTFailscreen" class="hide">
		<p class="tpt_done_vspacer">&nbsp;</p>
		<p id="tptErr" class="tpt_box_shadow tpt_center tpt_fail_msg">Ошибка!</p>
	</div>
	<div id="qsPTPlayscreen" class="hide">
		<div class="clearfix">&nbsp;</div>
		<p class="tpttime">Осталось: <span id="tpttime_left">0</span> сек. <span id="fail_result" style="color:red"></span><span id="good_news" style="color:#009900"></span></p>
		<p class="tpthealth tpt_box_shadow">Health: <span id="tptlives"></span></p>
		<p class="tptscore tpt_box_shadow">Score: <span  id="tptscore"></span></p>
		<p class="">&nbsp;</p>
		<p class="tpt_vspacer">&nbsp;</p>
		<p id="tptquest" class="tpt_box_shadow tpt_center">&nbsp;</p>
		<p class="tpt_vspacer">&nbsp;</p>
		<textarea id="tptanswer"  style="width:99%;" rows="5"></textarea>
		<!--p class="tpt_vspacer">&nbsp;</p-->
		<p class="tright">
			<input type="button" id="tptOK" value="OK">
		</p>
		<p class="tpt_vspacer">&nbsp;22</p>
	</div>
</div>
