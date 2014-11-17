/**
 * Базовая конфигурация теста
 * */
(function () {
	$(document).ready(init);
	
	function random(min, max) {
		max = parseInt(max, 10);
		min = parseInt(min, 10);
		max = max ? max : 0;
		min = min ? min : 0;
		var n = Math.random();
		n = Math.round(n * Math.pow(10, String(max).length ) );
		if (n < min) {
			n += min;
		}
		if (n > max) {
			n = n % max + min;
		}
		return n;
	}
	
	function init() {
		window.TestNewWordsHandler = {};
		window.TestNewWordsHandler.shuffle = function() {
			var L = TestEngine.quests.length, i = L, j, o, arr = TestEngine.quests, word, src;
			while (i--) {
				o = arr[i];
				j = random(0, L - 1);
				while (i == j) {
					j = random(0, L - 1);
				}
				word = arr[j].a[ arr[j].r ];
				src  = arr[i].a[0];
				j = random(0, 2);
				if (j == 2) {
					j = 1;
				}
				TestEngine.quests[i].r = j;
				TestEngine.quests[i].a[j] = src;
				j++;
				if (j > 1) {
					j = 0;
				}
				TestEngine.quests[i].a[j] = word;
			}
			//console.log(arr);
		}
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
				$("#quest").text('Что значит: ' + v);
				if (String(rule) == "undefined") {
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
			setLives: function(v) {
				$("#lives").text(v);
			},
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
