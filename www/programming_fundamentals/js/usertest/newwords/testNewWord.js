/**
 * @desc Инициализация окошка для показа теста на новые слова
 * */
(function () {
	$(document).ready(init);
	function reinitTest() {
		TestNewWords.reset(1);
	}
	function init() {
		$('#runTest').click(
			function() {
				appWindow('qs-test-new-word-wrap', 'Проверь себя', reinitTest);
				$('.popup-content').addClass('bgnone');//TODO удалить класс при закрытии окна
				$('#qs-test-new-word').css('background', 'url("' + WEB_ROOT + '/img/wordtest/bg0.png")');
			}
		);
	}
})()
