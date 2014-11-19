/**
 * @desc Инициализация окошка для показа теста на новые слова
 * */
(function () {
	$(document).ready(init);
	function init() {
		$('#patternTestRun').click(
			function() {
				appWindow('qs-test-patterns-wrap', 'Проверь себя');
				$('.popup-content').addClass('bgnone');//TODO удалить класс при закрытии окна
				$('#qs-test-patterns').css('background', 'url("' + WEB_ROOT + '/img/wordtest/bg3.png")');
			}
		);
	}
})()
