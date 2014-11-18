/**
 * @desc Инициализация окошка для показа теста на новые слова
 * */
(function () {
	$(document).ready(init);
	function init() {
		$('#runTest').click(
			function() {
				appWindow('qs-test-new-word-wrap', 'Проверь себя');
				$('.popup-content').addClass('bgnone');//TODO удалить класс при закрытии окна
				$('#qs-test-new-word').css('background', 'url("' + WEB_ROOT + '/img/wordtest/bg0.png")');
			}
		);
	}
})()
