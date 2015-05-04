/**
 * Базовая конфигурация теста на знание Symphony2
 * */
(function () {
	$(document).ready(init);
	
	function init() {
		/** @var глобальный объект - экземпляр базового конфигуратора теста по паттернам*/
		window.TestSymphony2 = new TestEngine();
		TestSymphony2.configTime(60);	//Конфигурация
		TestSymphony2.defaultScorePerAnswer = 10;
		//Вопросы
		TestSymphony2.quests.push({q:"Вы находитесь в консоли linux, текущая директория - корневая директории проекта симфони 2.3. Введите команду для генерации бандла HelloBundle", a:"php app/console generate:bundle --namespace=Acme/HelloBundle"});
		TestSymphony2.quests.push({q:"Что такое Acme?", a:"Имя компании по умолчанию."});
		
		
		//TestSymphony2.randomize = true; //вопросы будут выводится случайным образом
		/** @desc Объект реализующий интерфейс представления данных теста, через него тест взаимодействует с DOM */
			TestSymphony2.view = {
			setScore:function(v){
				$("#tsym2score").text(v);
			},
			setTime: function(v){
				$("#tsym2time_left").text(v);
			},
			clearPrevStatus: function() {
				$('#qsSym2TPlayscreen').removeClass('hide');
				$('#qsSym2TDonescreen').addClass('hide');
				$('#qsSym2TFailscreen').addClass('hide');
			},
			setQuest: function(v, answers, rule) {
				if (v == '') {
					v = '&nbsp;';
				}
				$('#tsym2answer').val('');
				$("#tsym2quest").html(v);
				if (String(rule) == "undefined") {
					return;
				}
			},
			setBeginScreen: function(v){
				$('#qsSym2TFailscreen').addClass('hide');
				$('#qsSym2TPlayscreen').addClass('hide');
				$('#qsSym2THelloScreen').removeClass('hide');
				$("#tsym2startGame").prop('disabled', false);
				TestSymphony2.state = 0;
			},
			setGameScreen: function(){
				$("#tsym2startGame").prop('disabled', true);
				this.beginScreenSets = false;
			},
			setLives: function(v) {
				$("#tsym2lives").text(v);
			},
			setDoneOneAnswerScreen: function(){
				$('#qsSym2TPlayscreen').addClass('hide');
				$('#qsSym2TDonescreen').removeClass('hide');
				if (!$('#tsym2SuccessInfo').hasClass('hide')) {
					$('#tsym2SuccessInfo').addClass('hide');
				}
				$('#tsym2Success').html('Правильно!');
				return 1;
			},
			setFailOneAnswerScreen: function(answer){
				$('#tsym2Err').html('Ошибка!<br><span style="font-size:9px;color:green;">Правильный ответ</span><br><span style="font-size:14px;">' + answer + '</span>');
				$('#qsSym2TPlayscreen').addClass('hide');
				$('#qsSym2TFailscreen').removeClass('hide');
				return 5;
			},
			setGameOverScreen: function(){
				$('#tsym2Err').text('GAME OVER');
				if ( !this.beginScreenSets ) {
					this.beginScreenSets = true;
					var o = this;
					setTimeout(
						function () {
							o.setBeginScreen();
						},
						2000
					);
				}
			},
			getAnswer: function(){
				return $('#tsym2answer').val();
			},
			setWinScreen: function(){
				this.clearPrevStatus();
				var s = 'Очень хорошо!';
				if (TestSymphony2.lives == 1) {
					s = 'Хорошо!';
				}
				$('#tsym2Success').html(s);
				$('#tsym2SuccessInfo').removeClass('hide');
				$('#qsSym2TPlayscreen').addClass('hide');
				$('#qsSym2TDonescreen').removeClass('hide');
				//$("#tsym2startGame").prop('disabled', false);
				var o = this;
				TestSymphony2.state = 0;
				setTimeout(
					function () {
						o.setBeginScreen();
					},
					5000
				);
			}
		};
		
		TestSymphony2.init();		//Запуск
		var C = TestSymphony2.C;		//для более быстрого доступа
		$("#tsym2startGame").prop('disabled', false); //кнопку "Начать тест" сделаем пока ннедоступной
		
		
		/** @desc Взаимодействие пользователя с тестом*/
		$('#tsym2startGame').click( function() {
			$("#qsSym2TPlayscreen").removeClass('hide');
			$("#qsSym2THelloScreen").addClass('hide');
			TestSymphony2.state = C.START_GAME;
			TestSymphony2.tick();
		});
		$('#tsym2OK').click( function() {
			TestSymphony2.state = C.CHECK_ONE_RESULT;
			TestSymphony2.tick();
			TestSymphony2.tick();
		});
	}
})()

