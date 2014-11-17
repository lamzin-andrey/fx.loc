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
			setQuest: function(v, answers, rule){
				$('#answer').val('');
				$('#variants').html('');
				$("#quest").text(v);
				if (!rule) {
					$('#answer').removeClass('hide');
					$('#send').removeClass('hide');
					$('#variants').innerHTML = '';
					return;
				}
				$('#answer').addClass('hide');
				$('#send').addClass('hide');
				$(answers).each(
					function(i, questText) {
						var btn = document.createElement('button');
						//$(btn).data('n', i).text(questText);
						btn.setAttribute('data-n', i);
						$(btn).text(questText);
						$(btn).click(
							function(evt) {
								$('#answer').val( evt.target.getAttribute('data-n') );
								TestEngine.state = C.CHECK_ONE_RESULT;
							}
						);
						$('#variants').append( btn );
					}
				);
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
