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
		TestSymphony2.useSkipThershold = true;
		TestSymphony2.skipThershold = 15;
		//Вопросы
		TestSymphony2.quests.push({q:"Вы находитесь в консоли linux, текущая директория - корневая директория проекта симфони 2.6.6. Введите команду для генерации бандла HelloBundle", a:"php app/console generate:bundle --namespace=Acme/HelloBundle"});
		TestSymphony2.quests.push({q:"Что такое Acme?", a:"Имя компании по умолчанию."});
		TestSymphony2.quests.push({q:"Укажите путь к YML файлу конфигурации соединения с базой данных по умолчанию (от корня проекта symfony 2.6.6, например app/config/... или src/Acme/YourBundle/Resources/config/...)", a:"app/config/parameters.yml"});
		TestSymphony2.quests.push({q:"Вы находитесь в консоли linux, текущая директория - корневая директория проекта симфони 2.6.6 Введите команду для создания базы данных", a:"php app/console doctrine:database:create"});
		TestSymphony2.quests.push({q:"Вы находитесь в консоли linux, текущая директория - корневая директория проекта симфони 2.6.6 Введите команду для создания класса модели c именем Product в пакете AcmeHelloBundle содержащей три поля: имя, описание и цена. Типы полей: строка в 255 символов, текст, дробное число.", a:"php app/console doctrine:generate:entity --entity=\"AcmeHelloBundle:Product\" --fields=\"name:string(255) description:text price:float\""});
		TestSymphony2.quests.push({q:"Создалась ли таблица базы данных в результате предыдущей команды?", a:"Нет"});
		TestSymphony2.quests.push({q:"Вы находитесь в консоли linux, текущая директория - корневая директория проекта симфони 2.6.6 Введите команду для генерации таблицы базы данных на основе файлов конфигурации, создавшихся в результате предыдущих действий", a:"php app/console doctrine:schema:update --force"});
		TestSymphony2.quests.push({q:"Вы набираете код внутри метода контроллера, в котором вам доступен класс Product, созданный ранее в этом тесте. Вы хотите получить доступ к методам экземпляра класса EntityManager, присвоив его переменной $em. Введите соответствущую строку php кода.", a:"$em = $this->getDoctrine()->getEntityManager();"});
		TestSymphony2.quests.push({q:"Вы набираете код внутри метода контроллера, в котором вам доступен класс Product, созданный ранее в этом тесте. Вы хотите передать объект $product класса Product экземпляру класса EntityManager (экземпляр у вас уже определен в переменной $em). Введите соответствущую строку php кода.", a:"$em->persist($product);"});
		TestSymphony2.quests.push({q:"Вы набираете код внутри метода контроллера, в котором вам доступен класс Product, созданный ранее в этом тесте. Вы хотите записать последние изенения в базу данных. Введите соответствущую строку php кода.", a:"$em->flush();"});
		TestSymphony2.quests.push({q:"Вы набираете код внутри метода контроллера src/Acme/HelloBundle/Controller/DefaultController.php, в котором вам доступен класс Product, созданный ранее в этом тесте. Вы хотите получить в переменную $repository объект, который предоставит вам методы поиска продуктов по значениям идентификатора и других полей модели. Введите соответствущую строку php кода.", a:"$repository = $this->getDoctrine()->getRepository(\"AcmeHelloBundle:Product\");"});
		TestSymphony2.quests.push({q:"Вы набираете код внутри метода контроллера src/Acme/HelloBundle/Controller/DefaultController.php. Вы хотите получить в переменную $request объект, который предоставит вам методы доступа к переменным POST, GET и сессии (и еще много всего). Введите соответствующую строку php кода.", a:"$request = $this->getRequest();"});
		TestSymphony2.quests.push({q:"Вы набираете код внутри метода контроллера src/Acme/HelloBundle/Controller/DefaultController.php. У вас есть объект $request из предыдущего вопроса. Вам нужен в переменной $session объект, предоставляющий доступ к сессии пользователя. Введите соответствующую строку php кода.", a:"$session = $request->getSession();"});
		TestSymphony2.quests.push({q:"Вы хотите сделать в своем контроллере доступным SecurityContext. Напишите соответствующую инструкцию use (use Symfony\\ ... SecurityContex...; ) подключающую необходимый компонент.", a:"use Symfony\\Component\\Security\\Core\\SecurityContext;"});
		TestSymphony2.quests.push({q:"Вы набираете код внутри метода контроллера src/Acme/HelloBundle/Controller/DefaultController.php, вам доступен SecurityContext и объект $request = $this->getRequest();. Напишите строку php кода, возвращающую true если произошла ошибка аутентификации", a:"$request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)"});
		TestSymphony2.quests.push({q:"Вы набираете код внутри метода контроллера src/Acme/HelloBundle/Controller/DefaultController.php, вам доступен SecurityContext и объект $session = $this->getRequest()->getSession();. Напишите строку php кода, возвращающую из сессии ошибку аутентификации в переменную $error", a:"$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);"});
		TestSymphony2.quests.push({q:"Вы набираете код внутри метода контроллера src/Acme/HelloBundle/Controller/DefaultController.php, вам доступен SecurityContext и объект $session = $this->getRequest()->getSession();. Напишите строку php кода, возвращающую из сессии последнее введенное  в форму логина имя пользователя,  $last_name = ...", a:"$last_name = $session->get(SecurityContext::LAST_USERNAME);"});
		TestSymphony2.quests.push({q:"Вы редактируете файл app/config/security.yml. По умолчанию в настройках безопасности проекта симфони 2.6.6 сконфигурирована защишённая область demo_secured_area. Вы хотите задать конфигурацию безопасности для всего сайта. Как назовёте секцию конфигурации и в какую секцию ее поместите? Ответ дайте в форме section_name в parent_section_name.", a:"secured_area в firewalls"});
		TestSymphony2.quests.push({q:"Вы редактируете файл app/config/security.yml. Вы добавили секцию secured_area в конфигурацию. Вы хотите задать конфигурацию безопасности так, чтобы брандмауер срабатывал при запросе любого url на вашем сайте. Введите соответствующую строку yml конфигурации.", a:"pattern: ^/"});
		TestSymphony2.quests.push({q:"Вы редактируете файл app/config/security.yml. Брандмауер срабатывает при запросе любого url на вашем сайте, но вы хотите дать анонимным пользователям возможность просматривать его страницы. Введите соответствующую строку yml конфигурации.", a:"anonymous: ~"});
		TestSymphony2.quests.push({q:"Вы редактируете файл app/config/security.yml. Что значит значение ключа конфигурации ~?. Например, что значит ~ в строке yml файла 'anonymous: ~'", a:"По умолчанию"});
		TestSymphony2.quests.push({q:"Вы редактируете файл app/config/security.yml. Добавьте в секцию secured_area настройку, указывающую, что вы хотите использовать html форму логина (с путями по умолчанию)", a:"form_login: ~"});
		TestSymphony2.quests.push({q:"Вы редактируете в файле app/config/security.yml секцию form_login. Перечислите через запятую два ключа, задающие пути, использующиеся при действии логина.", a:"check_path, login_path"});
		TestSymphony2.quests.push({q:"Вы редактируете в файле app/config/security.yml секцию form_login. Введите значение ключа login_path по умолчанию.", a:"/login"});
		TestSymphony2.quests.push({q:"Вы редактируете в файле app/config/security.yml секцию form_login. Введите значение ключа check_path по умолчанию.", a:"/login_check"});
		TestSymphony2.quests.push({q:"Вы редактируете в файле app/config/security.yml секцию form_login. Вы задали свои оригинальные значения для путей к форме логина и скрипту проверки успешной аутентификации. Что необходимо ещё сделать в другом файле конфигурации, чтобы логически завершить это действие? Ответ дайте в форме \"***ть *** в файле app/...\"", a:"Указать маршруты в файле app/config/routing.yml"});
		TestSymphony2.quests.push({q:"Надо ли указывать маршруты для путей секции form_login, если их значения оставлены по умолчанию? (Да/Нет)", a:"Да"});
		TestSymphony2.quests.push({q:"Вы работаете в \"свежеустановленом\" проекте симфони 2.6.6, вы не конфигурировали .htaccess  и все url в вашем проекте начинаются с /web/app_dev.php/ или /web/app.php/. Вы добавили аутентификацию пользователя через форму логина и хотите, чтобы при запросе url /web/app_dev.php/logout пользователь \"разлогинился\". Какую минимально необходимую строку надо добавить в секцию secured_area в файле app/config/security.yml?", a:"logout: ~"});
		TestSymphony2.quests.push({q:"Для достижения цели, поставленной в предыдущем вопросе вам надо ещё создать некий маршрут в файле. Какое имя маршрута и в каком файле? Ответ дайте в форме route_name в файле app/....", a:"logout в файле app/config/routing.yml"});
		TestSymphony2.quests.push({q:"Для достижения цели, поставленной в предыдущем вопросе вы создали маршрут logout в файле app/config/routing.yml. В секции logout должна быть минимум одна строка. Наберите её.", a:"pattern: /logout"});
		TestSymphony2.quests.push({q:"Logout заработал, но после разлогина вас перенаправляет на страницу /web/app_dev.php/, а вы хотите на /web/app_dev.php/hello/Anonymous. В каком файле, в какой секции и что надо ввести для этого?. Ответ наберите в виде app/.., section_name, key: value.", a:"app/config/security.yml, logout, target: /hello/Anonymous"});
		TestSymphony2.quests.push({q:"Вы набираете код внутри контроллера. Как получить объект авторизованного пользователя?. ($user = $this->...;)", a:"$user = $this->get(\"security.context\")->getToken()->getUser();"});
		TestSymphony2.quests.push({q:"Вы набираете код внутри контроллера. Вы получили объект авторизованного пользователя в переменную $user с помощью строки кода $user = $this->get(\"security.context\")->getToken()->getUser(); Какой тип переменной $user если пользователь НЕ авторизован?. Ответ дайте в виде имени типа данных php или Symfony, например TestUser, integer, string, bool, array.", a:"string"});
		TestSymphony2.quests.push({q:"Вы набираете код внутри контроллера. Вы получили объект авторизованного пользователя в переменную $user с помощью строки кода $user = $this->get(\"security.context\")->getToken()->getUser(); Вы собираетесь получить объект шифровальшика в переменную $encoder. Введите соответствующую строку php кода ($encoder = ...;).", a:"$encoder = $this->get(\"security.encoder_factory\")->getEncoder($user);"});
		TestSymphony2.quests.push({q:"Вы набираете код внутри контроллера. Вы получили объект шифровальшика в переменную $encoder с помощью строки кода $encoder = $this->get(\"security.encoder_factory\")->getEncoder($user); $user при этом имеет UserInterface. Вы собираетесь зашифровать пароль, хранящийся в переменной $password. Введите соответствующую строку php кода ($password = ...;).", a:"$password = $encoder->encodePassword($password, $user->getSalt());"});
		
		TestSymphony2.quests.push({q:"Вы создали класс CUser, реализующий UserInterface, код этой реализации расположили в src/Acme/HelloBundle/Entity/CUser.php. Теперь вы хотите указать, что пароль для данного типа пользователей следует шифровать алгоритмом bcrypt. Введите соответствующую строку yml конфигурации.", a:"Acme\\HelloBundle\\Entity\\CUser: { algorithm: bcrypt }"});
		TestSymphony2.quests.push({q:"В какой секции yml файла конфигурации должна располагаться строка - ответ на предыдущий вопрос?", a:"encoders"});
		
		TestSymphony2.quests.push({q:"Вы создали класс CUser, реализующий UserInterface, код этой реализации расположили в src/Acme/HelloBundle/Entity/CUser.php. Теперь вы хотите указать, что информацию о пользователях следует хранить в экземплярах именно этого класса. Как называется секция, существующая в дефолтном файле app/config/security.yml в секции security, которую вы будете редактировать для достижения поставленной цели?", a:"providers"});
		TestSymphony2.quests.push({q:"Для достижения цели, поставленной в предыдущем вопросе вы редактируете дочернюю секцию providers provider_name. Перечислите имена трех ключей, которые вам необходимо добавить.", a:"entity, class, property"});
		TestSymphony2.quests.push({q:"Вы создали класс CUser, реализующий UserInterface, код этой реализации расположили в src/Acme/HelloBundle/Entity/CUser.php. Теперь вы хотите указать, что информацию о пользователях следует хранить в экземплярах именно этого класса. Введите значение ключа class в этом случае.", a:"Acme\\HelloBundle\\Entity\\CUser"});
		TestSymphony2.quests.push({q:"Для достижения цели, поставленной в предыдущем вопросе вы должны добавить еще один ключ помимо ключа class, с определеннным значением. Введите эту конкретную строку в yml формате. (Ответ в формате ключ: значение)", a:"property: username"});
		TestSymphony2.quests.push({q:"Как должна называеться секция, в которой должны располагаться ключи  class и property (в контексте четырех посследних вопросов)", a:"entity"});
		TestSymphony2.quests.push({q:"Вы создали класс CUser, реализующий UserInterface, код этой реализации расположили в src/Acme/HelloBundle/Entity/CUser.php. С целью указать, что информацию о пользователях следует хранить в экземплярах именно этого класса вы добавили непосредственно в секцию providers строку entity: { class: Acme\\HelloBundle\\Entity\\CUser, property:username }. Будет ли работать эта конфигурация?", a:"Нет"});
		TestSymphony2.quests.push({q:"Чего не хватает в предыдущей конфигурации? (Ответ одним словом, \"Не хватает ...\")", a:"провайдера"});
		TestSymphony2.quests.push({q:"Вы сгенерировали пакет --namespace=Acme/HelloAnnotationBundle. Вы хотите указать для indexAction шаблон test.html.twig, который лежит в одном каталоге со сгенерированным по умолчанию шаблоном index.html.twig. Введите соответствующую аннотацию @Template", a:"@Template(\"AcmeHelloAnnotationBundle:Default:test.html.twig\")"});
		TestSymphony2.quests.push({q:"Вы набираете код в методе контроллера, хотите вернуть данные array(\"name\" => $name) в json формате. В документации symfony 2.6 для этого используются две строки php кода. Введите первую из них (кавычки в ответе используйте двойные). ($response = ...)", a:"$response = new Response( json_encode( array(\"name\" => $name) ) );"});
		TestSymphony2.quests.push({q:"Вы набираете код в методе контроллера, хотите вернуть данные в json формате. В документации symfony 2.6 для этого используются две строки php кода. Введите вторую из них (кавычки в ответе используйте двойные). ($response->...)", a:"$response->headers->set(\"Content-Type\", \"application/json\");"});
		TestSymphony2.quests.push({q:"Вы работаете в \"свежеустановленом\" проекте симфони 2.6.6, вы не конфигурировали .htaccess  и все url в вашем проекте начинаются с /web/app_dev.php/ или /web/app.php/. Вы указали атрибут html формы action=\"{{ path('acme_user_add') }}\" и хотите чтобы форма отправлялась по адресу /web/app_dev.php/user/add. Введите соответствующую аннотацию. ", a:"@Route(\"/user/add\", name=\"acme_user_add\")"});
		TestSymphony2.quests.push({q:"Вы набираете код в методе контроллера, хотите сделать редирект по маршруту login. Введите соответcтвующую строку php кода. (return ...)", a:"return $this->redirectToRoute(\"login\")"});
		TestSymphony2.quests.push({q:"Вы набираете код в определении модели, хотите сделать обязательным для ввода поле password. Подключите модуль, позволяющий использовать Assert . (use ... AS Assert;)", a:"use Symfony\\Component\\Validator\\Constraints AS Assert;"});
		TestSymphony2.quests.push({q:"Вы набираете код в определении модели, хотите сделать обязательным для ввода поле password. Введите соответcтвующую строку аннотации. (@...)", a:"@Assert\\NotBlank()"});
		TestSymphony2.quests.push({q:"Измените ответ на предыдущий вопрос так, чтобы сообщение о пустом поле пароля сменилось на \"Password required\".", a:"@Assert\\NotBlank(message=\"Password required\")"});
		TestSymphony2.quests.push({q:"Вы набираете код в определении модели. Подключите модуль, позволяющий использовать UniqueEntity . (use Symfony\\...;)", a:"use Symfony\\Brige\\Doctrine\\Validator\\Constraints\\UniqueEntity;"});
		TestSymphony2.quests.push({q:"Вы набираете код в определении модели. В модели есть два поля (one, two), значения каждого из которых должны быть уникальными для каждой записи. Введите соответствующую аннотацию (аннотации) UniqueEntity . (@...[\n@...])", a:"@UniqueEntity(\"one\")\n@UniqueEntity(\"two\")"});
		TestSymphony2.quests.push({q:"Вы набираете код в определении модели. В модели есть два поля (one, two), значения которых должны быть уникальными для каждой записи (составной ключ). Введите соответствующую аннотацию (аннотации) UniqueEntity . (@...[\n@...])", a:"@UniqueEntity(fields={\"one\", \"two\"})"});
		TestSymphony2.quests.push({q:"Вы хотите сделать активацию вновь зарегистрированного пользователя по email. Вам необходимо создать класс, реализующий некий интерфейс. Введите название интерфейса.", a:"UserProviderInterface"});
		TestSymphony2.quests.push({q:"Для достижения цели, поставленной в предыдущем вопросе, вы создали класс Acme/HelloBundle/Entity/CUserProvider.php. Введите название метода, в котором логично седлать проверку на то, активировал уже пользователь свой аккаунт или нет.", a:"loadUserByUsername"});
		TestSymphony2.quests.push({q:"Вы хотите сделать активацию вновь зарегистрированного пользователя по email. Вам необходимо зарегистрировать класс Acme/HelloBundle/Entity/CUserProvider как сервис. Введите название xml файла, в котором логично это сделать. (dirname/...)", a:"src/Acme/HelloBundle/Resources/config/services.xml"});
		TestSymphony2.quests.push({q:"Вы хотите сделать активацию вновь зарегистрированного пользователя по email, для этого вы создали класс, реализующий UserProviderInterface  и зарегистрировали его как сервис в xml файле. Вы хотите, чтобы в конструктор вашего класса передавался экземпляр класса Doctrine. Введите соответствующую строку xml конфигурации. (&lt;argument...)", a:"&lt;argument type=\"service\" id=\"doctrine\" /&gt;"});
		TestSymphony2.quests.push({q:"Вы хотите сделать активацию вновь зарегистрированного пользователя по email, для этого вы создали класс, реализующий UserProviderInterface  и зарегистрировали его как сервис с id=\"my_user_provider\". . Введите имя yml файла конфигурации, имя секции в этом файле, в которых вы укажете необходимость использовать ваш провайдер и yaml конфигурацию одной строкой. Формат ответа: имя файла (app/...), имя секции, provider: { ключ: значение }", a:"app/config/security.yml, providers, provider: { id: my_user_provider }"});
		TestSymphony2.quests.push({q:"Для достижения цели, ок оторой шла речь в предыдущих пяти вопросах, класс модели пользователя должен реализовывать два интерфейса. Перечислите их через запятую", a:"UserInterface, EquatableInterface"});
		TestSymphony2.quests.push({q:"Где проще всего посмотреть пример реализации UserProviderInterface? Ответ - имя класса, входящего в symfony 2.6.6 \"из коробки\"", a:"EntityUserProvider"});
		TestSymphony2.quests.push({q:"Вы набираете код в контроллере. Введите строку php кода, позволяющую получить параметр path маршрута my_personal_route. ($this->...;)", a:"$this->get(\"router\")->getRouteCollection()->get(\"my_personal_route\");"});
		

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
				$('#tsym2Err').html( $('#tsym2Err').html().replace('Ошибка!', 'GAME OVER') );
				if ( !this.beginScreenSets ) {
					this.beginScreenSets = true;
					var o = this;
					setTimeout(
						function () {
							o.setBeginScreen();
						},
						5000
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
			},
			setSkipButtonState: function(is_enabled) {
				$('#tsym2Skip').prop('disabled', !is_enabled);
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
		$('#tsym2Skip').click( function() {
			TestSymphony2.state = C.SKIP_ONE_QUEST;
			TestSymphony2.tick();
		});
	}
})()

