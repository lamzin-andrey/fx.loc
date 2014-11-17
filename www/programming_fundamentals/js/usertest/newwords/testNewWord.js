/**
 * @desc Инициализация окошка для показа теста на новые слова
 * */
(function () {
	$(document).ready(init);
	function init() {
		$('#runTest').click(
			function() {
				appWindow('qs-test-new-word-wrap', 'Проверь себя');
			}
		);
	}
})()
