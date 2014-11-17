var TestEngine = {
	quests:[
		{q:"Что такое осень?", a:"Это небо"},
		{q:"Переведите: Я буду читать", a:"I will read"},
		{q:"Как зовут певца?", a:"Zadolbal!"},
		{t:1, q:"Один в поле... ", 
			a:["Не пойман", "Не вор", "Не воин", "Биткоин"],
			r:2
		}
	],
	minTime: 30 * 1000,
	maxTime: 500 * 1000,
	limit:   5 * 1000,
	time:    5 * 1000,
	defaultScorePerAnswer : 10,
	score:0,
	beginLives : 2,
	lives : 2,
	failAnswerDelay: 1,
	successAnswerDelay: 1,
	//end config
	C:{
		NOT_BEGIN:0,
		GET_QUEST:1,
		START_GAME:2,
		WAIT_ANSWER:5,
		CHECK_ONE_RESULT:10,
		SUCCESS_ONE_RESULT:11,
		SUCCESS_RESULT_SHOWING:12,
		FAIL_RESULT:15,
		FAIL_RESULT_SHOWING:16,
		GAME_OVER:20,
		WIN:25
	},
	//end constants
	viewIfc: { //view required functions
		setScore:0/*funciton(){}*/,
		setTime: 0,
		setQuest: 0,
		setBeginScreen: 0,
		setGameScreen: 0,
		setLives: 0,
		setDoneOneAnswerScreen:0,
		setDoneOneAnswerScreen: 0,  //return time delay success screen
		setFailOneAnswerScreen: 0,  //return time delay fail screen
		setGameOverScreen: 0,
		getAnswer: 0,               // (!) must return answer text or answer variant number
		clearPrevStatus:0           // can clear "Wrong" or "Success" messages
	},
	//end view interface
	iterator:-1,
	interval:null,
	state : 0,
	init:function() {
		var data = {};
		/*if (!this.checkView(data)) {
			throw new Error("view required functions: " + data.join(','));
		}*/
		//alert(this.iterator + ', LABEL_1');
		var o = this;
		this.interval = setInterval(
			function() {
				switch (o.state) {
					case o.C.WIN:
						o.winner();
						break;
					case o.C.CHECK_ONE_RESULT:
						o.checkOneResult();
						break;
					case o.C.WAIT_ANSWER:
						o.decrementTime();
						break;
					case o.C.SUCCESS_RESULT_SHOWING:
						o.decrementSuccessResultTime();
					case o.C.FAIL_RESULT_SHOWING:
						o.decrementFailResultTime();
						break;
					case o.C.FAIL_RESULT:
						o.checkLives();
						break;
					case o.C.SUCCESS_ONE_RESULT:
						o.incrementScores();
						break;
					case o.C.GAME_OVER:
						o.lives = o.beginLives;
						o.time = o.limit;
						o.iterator = -1;
						o.view.setQuest('');
						o.view.setGameOverScreen();
						break;
					case o.C.GET_QUEST:	
					case o.C.START_GAME:
						o.time = o.limit;
						o.view.setTime(o.limit / 1000);
						o.view.clearPrevStatus();
						if (o.state == o.C.START_GAME) {
							o.view.setLives(o.beginLives);
							o.view.setScore(0);
							o.score = 0;
							o.view.setGameScreen();
							o.state == o.C.GET_QUEST;
						}
						o.nextQuest();
						break;
				}
			}, 1000
		);
	},
	decrementTime: function() {
		this.time = this.time - 1 * 1000;
		if (this.time > 0) {
			this.view.setTime(this.time / 1000);
		} else {
			this.view.setTime(this.time / 1000);
			this.state = this.C.FAIL_RESULT;
		}
	},
	decrementFailResultTime: function() {
		this.failAnswerDelay--;
		if (this.failAnswerDelay <= 0) {
			this.failAnswerDelay = 1;
			this.state = this.C.GET_QUEST;
		}
	},
	checkLives: function() {
		if (this.lives--) {
			var d = parseInt(this.view.setFailOneAnswerScreen(), 10);
			this.failAnswerDelay = d ? d : this.failAnswerDelay;
			this.view.setLives(this.lives);
			this.state = this.C.FAIL_RESULT_SHOWING;
			this.time = this.limit;
			if (!this.lives) {
				this.state = this.C.GAME_OVER;
			}
		} else {
			this.state = this.C.GAME_OVER;
		}
	},
	nextQuest: function() {
		this.iterator++;
		if (this.iterator == this.quests.length) {
			this.state = this.C.WIN;
		} else {
			this.view.setQuest(this.quests[this.iterator].q, this.quests[this.iterator].a, this.quests[this.iterator].r);
			this.state = this.C.WAIT_ANSWER;
		}
	},
	checkOneResult: function() {
		var quest = this.quests[this.iterator], type = quest.t;
		if (!type) {
			//for q/a only
			if (String(this.view.getAnswer()).toLowerCase() == this.quests[this.iterator].a.toLowerCase()) {
				this.state = this.C.SUCCESS_ONE_RESULT;
			} else {
				this.state = this.C.FAIL_RESULT;
			}
		} else {
			if (quest.r == this.view.getAnswer()) {
				this.state = this.C.SUCCESS_ONE_RESULT;
			} else {
				this.state = this.C.FAIL_RESULT;
			}
		}
	},
	incrementScores: function() {
		this.score += this.defaultScorePerAnswer;
		this.view.setScore(this.score);
		var d = parseInt(this.view.setDoneOneAnswerScreen(), 10);
		this.successAnswerDelay = d ? d : this.successAnswerDelay;
		this.state = this.C.SUCCESS_RESULT_SHOWING;
	},
	decrementSuccessResultTime:function() {
		this.successAnswerDelay--;
		if (this.successAnswerDelay <= 0) {
			this.successAnswerDela = 1;
			if (this.iterator + 1 == this.quests.length) {
				this.state = this.C.WIN;
			} else {
				this.state = this.C.GET_QUEST;
			}
		}
	},
	winner: function() {
		this.view.setWinScreen();
	}
};
