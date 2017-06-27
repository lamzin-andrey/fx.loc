$(appSearchInit);
function appSearchOnKeyPress() {
	var s = $('#searchApp').val();
	$('#appsList a').each(function(i, j){
		j = $(j);
		if (!~j.text().indexOf(s)) {
			j.addClass('hide');
		} else {
			j.removeClass('hide');
		}
	});
}
function appSearchInit() {
	$('#searchApp').bind('keydown',function(){
		setTimeout(function(){
			appSearchOnKeyPress();
		},100);
	});
}
