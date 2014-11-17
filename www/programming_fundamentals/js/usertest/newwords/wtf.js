/**
 * @desc Слова, появившиеся на первом занятии
*/
(function () {
	$(document).ready(init);
	function init() {
		TestEngine.quests.push({t:1, q:"function", a:["функция"],	r:0});
		TestEngine.quests.push({t:1, q:"name", a:["имя"],	r:0});
		TestEngine.quests.push({t:1, q:"alert", a:["внимание"],	r:0});
		TestEngine.quests.push({t:1, q:"other", a:["другой"],	r:0});
		//TestNewWordsHandler.shuffle();
	}
})()

