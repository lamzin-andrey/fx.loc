/**
 * Базовая конфигурация теста на знание слов, использующихся в тексте программ
 * */
(function () {
	$(document).ready(init);
	
	function init() {
		/**
		 * @desc Объект хранящий функцию shuffle для инициализации "неправильных" вариантов слов
		*/
		window.TestNewWordsHandler = {};
		/**
		 * @desc Добавляет к каждому слову неправильный вариант ответа, переставляет варианты ответа на вопрос
		*/
		window.TestNewWordsHandler.shuffle = function() {
			var L = TestNewWords.quests.length, i = L, j, o, arr = TestNewWords.quests, word, src;
			while (i--) {
				o = arr[i];
				j = TestNewWords.random(0, L - 1);
				while (i == j) {
					j = TestNewWords.random(0, L - 1);
				}
				word = arr[j].a[ arr[j].r ];
				src  = arr[i].a[ arr[i].r ];
				j = TestNewWords.random(0, 500) % 2;
				if (j) {
					j = 1;
				}
				TestNewWords.quests[i].r = j;
				TestNewWords.quests[i].a[j] = src;
				j++;
				if (j > 1) {
					j = 0;
				}
				TestNewWords.quests[i].a[j] = word;
			}
			//console.log(arr);
		}
		/** @var глобальный объект - экземпляр базового конфигуратора теста на новые слова*/
		window.TestNewWords = new TestEngine();
		TestNewWords.randomize = true; //вопросы будут выводится случайным образом
		/** @desc Объект реализующий интерфейс представления данных теста, через него тест взаимодействует с DOM */
		TestNewWords.view = {
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
								TestNewWords.state = C.CHECK_ONE_RESULT;
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
		TestNewWords.configTime(5);	//Конфигурация
		TestNewWords.init();		//Запуск
		var C = TestNewWords.C;		//для более быстрого доступа
		$("#startGame").prop('disabled', false); //кнопку "Начать тест" сделаем пока ннедоступной
		/** @desc Взаимодействие пользователя с тестом*/
		$('#startGame').click( function() {      
			TestNewWords.state = C.START_GAME;
		});
		$('#send').click( function() {
			TestNewWords.state = C.CHECK_ONE_RESULT;
		});
	}
})()
