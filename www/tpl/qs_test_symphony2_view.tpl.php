<div class="tnwframe">
	<div id="qsSym2THelloScreen">
		<div class="clearfix">&nbsp;</div>
		<p class="tptlabel">Тест на знание Symphony 2</p>
		<p class="tptStartButtonPlace">
			<button id="tsym2startGame" >Пройти тест</button>
		</p>
	</div>
	<div id="qsSym2TDonescreen" class="hide">
		<p class="tpt_done_vspacer">&nbsp;</p>
		<p id="tsym2Success" class="tpt_box_shadow tnw_center tnw_done_msg">Правильно!</p>
		<p id="tsym2SuccessInfo" class="tpt_box_shadow tnw_center tnw_done_msg hide">Не забывайте переодически проходить этот тест по мере чтения новых статей.</p>
	</div>
	<div id="qsSym2TFailscreen" class="hide">
		<p class="tpt_done_vspacer">&nbsp;</p>
		<p id="tsym2Err" class="tpt_box_shadow tpt_center tsym2_fail_msg">Ошибка!</p>
	</div>
	<div id="qsSym2TPlayscreen" class="hide">
		<div class="clearfix">&nbsp;</div>
		<p class="tpttime">Осталось: <span id="tsym2time_left">0</span> сек. <span id="fail_result" style="color:red"></span><span id="good_news" style="color:#009900"></span></p>
		<p class="tpthealth tpt_box_shadow">Health: <span id="tsym2lives"></span></p>
		<p class="tptscore tpt_box_shadow">Score: <span  id="tsym2score"></span></p>
		<p class="tpt_vspacer">&nbsp;</p>
		<p id="tsym2quest" class="tpt_box_shadow tpt_center">&nbsp;</p>
		<p class="tright">
			<input type="button" id="tsym2OK" value="OK">
		</p>
		<p class="tpt_vspacer">&nbsp;</p>
		<textarea id="tsym2answer"  style="width:99%;" rows="5"></textarea>
	</div>
</div>
