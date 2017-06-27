function task2() {
	function writeln(s) {
		alert(s);
  	}
	function readln(s) {
		return prompt(s);
  	}
	var n = parseInt(readln('Введите n'));	
	if (isNaN(n) || (!n && n !== 0 && n !== '0')) {
		writeln('n должно быть числом');
		return;
	}
	
	function fc(n) {
		if (n === 0 || n === '0' || n == 1) {
			return 1;
		}
		return n * fc(n - 1);
	}
	var r = fc(n);	
	writeln(n + "! = " + r);
}
