/**
 * Базовая конфигурация теста
 * */
(function () {
	$(document).ready(init);
	function init() {
		TestEngine.view = {
			setScore:function(v){
				$("#score").text(v);
			},
			setTime: function(v){
				$("#time_left").text(v);
			},
			clearPrevStatus: function() {
				$("#fail_result").text('');
				$("#good_news").text('');
			},
			setQuest: function(v){
				$("#quest").text(v);
			},
			setBeginScreen: function(v){},
			setGameScreen: function(){
				$("#startGame").prop('disabled', true);
			},
			setLives: function(){},
			setDoneOneAnswerScreen: function(){
				$("#good_news").text('WoW!');
				return 2;
			},
			setFailOneAnswerScreen: function(){
				$("#fail_result").text('WRONG!!!!');
				return 2;
			},
			setGameOverScreen: function(){
				$("#fail_result").text('GAME OVER');
				$("#startGame").prop('disabled', false);
			},
			getAnswer: function(){
				return $('#answer').val();
			},
			setWinScreen: function(){
				$("#good_news").text('ПОБЕДА');
				$("#startGame").prop('disabled', false);
			}
		};
		
		TestEngine.limit = 30 * 1000;
		TestEngine.time  = 30 * 1000;
		
		TestEngine.init();
		var C = TestEngine.C;
		$("#startGame").prop('disabled', false);
		$('#startGame').click( function() {
			TestEngine.state = C.START_GAME;
		});
		$('#send').click( function() {
			TestEngine.state = C.CHECK_ONE_RESULT;
		});
	}
})()
