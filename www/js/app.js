(function ($, undefined) {
	var guid = '';
	var lang = window.appLang;
	$(document).ready(
		function(){
			setHelloLoader();
			initGuid();
			initConsole();
			initUserTaskList();
			initWinFunctions();
			initTooltipFunctions();
			initKeywordsHelp();
			initSampleTextEditor();
			initSigninButton();
			initSignupButton();
			initComments();
			initScrollSaver();
			initResourcesPage();
			initTaskvariantsPage();
			initMainPage();
			initVewDecisionPage();
			initGetMyTask();
			$('#firstLoaderId').remove();
			$('#firstImgId').remove();
		}
	);
	function setHelloLoader() {
		var W = window, D = document, body = D.getElementsByTagName('body')[0];
		if (!body) {
			return;
		}
		var back = D.createElement('div');
		back.id = "firstLoaderId";
		with (back.style) {
			background = 'url("/img/popup-bg.png")';
			zIndex = 600;
			position = 'fixed';
			left = '0px';
			top = '0px';
			width = body.offsetWidth + 'px';
			height = body.offsetHeight + 'px';
		}
		body.appendChild(back);
		
		var i = D.createElement('img');
		i.id = "firstImgId";
		i.src = '/img/ploader.gif';
		with (i.style) {
			zIndex = 599;
			position = 'fixed';
			left = ( (body.offsetWidth - 66) / 2) + 'px';
			top = ( (body.offsetHeight - 66) / 2) + 'px';
		}
		body.appendChild(i);
		clearInterval( W.helloLoaderInterval );
	}
//============Простой редактор кода=====================================
	/**
	 * Установка позиции курсора в текстовом поле
	**/
	function setCaretPosition(ta, pos)  {
		var input = ta;
		if (input.readOnly) return;	
		if (input.value == "") return;	
		if ((!pos)&&(pos !== 0)) return;
		var f = 0;
		try {f = input.setSelectionRange;}
		catch(e){;}
		if(f)	{
			input.focus();		
			try{
				input.setSelectionRange(pos,pos);
			}catch(e){
				//если находится в контейнере с style="display:none" выдает ошибку
			}
		}else if (input.createTextRange) {
			var range = input.createTextRange();
			range.collapse(true);
			range.moveEnd('character', pos);
			range.moveStart('character', pos);
			range.select();
		}
	}
	/**
	 * Получение позиции курсора в текстовом поле
	**/
	function getCaretPosition(ta)  {
		var input = ta;
		var pos = 0;
		// IE Support
		if (document.selection) {		
			if (input.value.length == 0) return 0;
			ta.focus();
			var sel = document.selection.createRange();
			var clone  = sel.duplicate();
			sel.collapse(true);
			clone.moveToElementText(ta);
			clone.setEndPoint('EndToEnd', sel);
			return (clone.text.length);
			/*input.focus();
			var sel = document.selection.createRange();
			var n = sel.moveStart ('character', -1*input.value.length);
			sel.collapse(true);
			alert(n);
			pos = sel.text.length;
			alert(pos);*/
		}
		// Firefox support
		else if (input.selectionStart || input.selectionStart == '0'){
			pos = input.selectionStart;		
		}
		return pos;
	}
	
	/**
	 * 
	 * Итак, запихать все строки в див или пэ, при получении позиции получаем первый див с определенным классом, 
	 *  далее считаем, который он в нашем контейнере по счету. 
	 * По горизонтали учитываем все html элементы вплоть до того, в котором начинается выделение и считаем количество символов
	 *@desc Получение позиции курсора
	*/
	function getCaretPositionInDiv(div) {
		var sel = window.getSelection();
		var currentDiv = sel.anchorNode;
		var offset = -1;
		if (currentDiv) {
			var pNode = currentDiv.parentNode;
			var deep = 0;
			while (pNode != div) {
				pNode = pNode.parentNode;
				if (!pNode) {
					return offset;
				}
				deep++;
			}
			console.log(pNode);
			var fc = div.firstChild;
			offset = currentDiv.anchorOffset;
		}
		return sel;
	}
	
	window.gcp = getCaretPositionInDiv;
	/**
	 * @desc (Вынесено из initKeywordsHelp) Загрузить слова из специального раздела на странице
	 * @see initKeywordsHelp, initStdFuncsHelp
	 * @param divId
	 * @param tagName
	 * @param Object keyMap
	*/
	function _getKeyMap(divId, tagName, keyMap) {
		var keys = [], sKeys = '', i, j, list, q, key, content, saveContent, aKey;
		// инициализация keyMap
		$('#' + divId + ' pre ' + tagName).each(
			function(i, item) {
				key = $(item).text(), content = $(item).attr('title');
				aKey = key.split('(');
				key = $.trim(aKey[0]);
				keys.push(key);
				keyMap[key] = content;
			}
		);
		sKeys = '|' +  keys.join('|') + '|';
		return sKeys;
	}
	/**
	 * @desc (Вынесено из initKeywordsHelp) Подсветка JS кода
	 * @see _highlightWordsInHelp
	 * @param keyMap - карта слов требующих подсветки в виде массива, получена во время работы  _getKeyMap
	 * @param sKeys  - специальная строка с ключевыми словами, требующими подсветки, результат _getKeyMap
	 * @param sKeysSF - специальная строка с именами стандартных функций, результат _getKeyMap
	 * @param String wrapAsExample - префикс имени функции, в которую будет "завернут" код
	 * 								 если не задано, то код в функцию не заворачивается
	*/
	function _highlightJsCode(content, sKeys, sKeysSF, wrapAsExample) {
		var list, j, copy;
		content = content.replace(/\\"/mig, 'SLASHED_D_QUOTES');
		content = content.replace(/\s?"([^"]*)"/mig, '<span class="strcolor">"$1"</span>');
		content = content.replace(/SLASHED_D_QUOTES/mig, '\\"');
		content = content.replace(/\\\//mig, 'SLASHED_D_QUOTES');
		copy = content;
		content = content.replace(/(\/[^\/]+\/[mig]{1,3})/mig, '<span class="recolor">$1</span>');
		if (copy == content) {
			content = content.replace(/(\/[^\/]+\/)[^\/]]*$/mig, '<span class="recolor">$1</span>');
		}
		content = content.replace(/SLASHED_D_QUOTES/mig, '\\/');
		content = content.replace(/\s?'([^']*)'/mig, '<span class="strcolor">\'$1\'</span>');
		content = content.replace(/(\s?\/\/[^\n]+)\n?$/mig, '<span class="strcolor">$1</span>');
		content = content.replace(/\/\*([^*]*)\*\//mig, '<span class="strcolor">/*$1*/</span>');

		if (wrapAsExample) {
			list = content.split('\n');
			buf = [];
			for (j = 0; j < list.length; j++) {
				if (list[j].length) {
					//if (wrapAsExample) {
					buf.push(' QSTAB ' + list[j]);
					/*} else {
						buf.push(list[j]);
					}*/
				}
			}
			content = 'function ' + wrapAsExample + 'Example() { QSNEW_LINE ' + buf.join(' QSNEW_LINE ') + ' QSNEW_LINE }';
		} else {
			content = content.replace(/\n/g, ' QSNEW_LINE '); //buf.join(' QSNEW_LINE ');
		}
	
		content = content.replace(/\t/gim, ' QSTAB ');
		content = content.replace(/,/gim, ' QSZP ');
		content = content.replace(/:/gim, ' QSDP ');
		content = content.replace(/\./gim, ' QSDOT ');
		content = content.replace(/\(/gim, ' QSBRCK ');
		content = content.replace(/;/gim, ' QSENDOP ');
		list = content.split(/\s/);
		for (j = 0; j < list.length; j++) {
			if (sKeys.indexOf('|' + list[j] + '|') != -1) {
				list[j] = '<b>' + list[j] + '</b>';
			}
			if (sKeysSF.indexOf('|' + list[j] + '|') != -1) {
				list[j] = '<i>' + list[j] + '</i>';
			}
		}
		content = list.join(' ');
		content = content.replace(/ QSTAB /gim, '\t');
		content = content.replace(/ QSNEW_LINE /gim, '\n');
		content = content.replace(/ QSZP /gim, ',');
		content = content.replace(/ QSDP/gim, ':');
		content = content.replace(/ QSDOT /gim, '.');
		content = content.replace(/ QSBRCK /gim, '(');
		content = content.replace(/ QSENDOP /gim, ';');
		return content;
	}
	
	
	function initSampleTextEditor()  {
		var mid = '#qs_editor_s',
			hid = '#qs_editor_hl',
			fileId = -1,
			fileDisplayName = '',
			lastTimeLoadFileClick = 0,
			maxEditorHeight = false,
			enableFunctions = false,
			ContentFunctions = {globals:{}},
			DefaultContentFunctions = _getStdMethods(),
			textCursor = {}.
			lastPos = 0;
		window.SiEd = {};
		if (!$(mid)[0]) {
			return;
		}
		function showTextCursorCoord() {
			var p = getCaretPosition($(mid)[0]),
				s = $(mid).val(), i, res = {x:1, y:1};
				
			for(i = 0; i < p; i++){
				if (s.charAt(i) == '\n') {
					res.y++;
					res.x = 1;
					continue;
				}
				res.x++;
			}
			$('#qsline').text(res.y);
			$('#qscol').text(res.x);
			textCursor = {x:res.x, y:res.y};
			lastPos = p;
			lines(s, res.y);
			return {p:p, s:s};
		}
		function lines(s, n){
			var total = s.split('\n').length, i = 0,
				div = $('#qseLines'), css, h;
			div.html('');
			for (i; i < total; i++) {
				if ((i + 1) == n) {
					css = 'qse_l qse_la';
				} else {
					css = 'qse_l';
				}
				div.append( $('<div class="' + css + '">' + (i + 1) + '</div>') );
			}
			/*if (exists > total) {
				div.html('');
				for (i; i < total; i++) {
					if ((i + 1) == n) {
						css = 'qse_l qse_la';
					} else {
						css = 'qse_l';
					}
					div.append( $('<div class="' + css + '">' + (i + 1) + '</div>') );
				}
			} else {
				div.find('.qse_l').removeClass('qse_la');
				if (exists == total) {
					div.find('.qse_l').eq(n - 1).addClass('qse_la');
				} else {
					for (i = exists; i < total; i++) {
						if ((i + 1) == n) {
							css = 'qse_l qse_la';
						} else {
							css = 'qse_l';
						}
						div.append( $('<div class="' + css + '">' + (i + 1) + '</div>') );
					}
				}
			}*/
			h = ($('#qs_editor_hl').height() + 5) + 'px';
			$('#qseLineWrapper').css('max-height', h);
			$('#qseLines')[0].style.top = (-1 * $('#qs_editor_hl')[0].scrollTop) + 'px';
			if ($('#tabhook')[0]) {
				$('#tabhook')[0].style.height = h;
				$('#tabhook')[0].style.top = $('#qseLines')[0].offsetHeight;
			}
		}
		/**
		* @desc Отображение текста в редакторе с подсветкой ситаксиса
		*/
		function viewHighightEditor() {
			var src = $(mid).val(), s = src, aSrcLines = src.split('\n');
			var pos = getCaretPosition($(mid)[0]);
			var keyMap = {}, keyMapSF = {};
			sKeys = _getKeyMap('keywords', 'b', keyMap);
			sKeysSF = _getKeyMap('stdfunctions', 'i', keyMapSF);
			s = _highlightJsCode(s, sKeys, sKeysSF, false);
			//TODO установить курсор
			var line = textCursor.y - 1,
				offset = textCursor.x - 1, i, j = 0, inTag = 0, ch,
				aLines = s.split('\n'), buf = '', L, found = 0;
			if (aLines[line]){
				L = aLines[line].length;
			} else {
				L = 0;
			}
			for (i = 0; i < L; i++) {
				if (offset == 0 && line == 0) {
					break;
				}
				if (offset == aSrcLines[line].length) {
					found = 1;
					buf = aLines[ line ] + '<span id="qsEditorHl">|</span>';
					break;
				}
				ch = aLines[line][i];
				if (ch == '<' || ch == '&') {
					inTag = 1;
				}
				if (ch == '>' || (ch == ';' && inTag) ) {
					inTag = 0;
					buf += ch;
					continue;
				}
				if (inTag == 0) {
					if (offset == j) {
						buf += '<span id="qsEditorHl">|</span>';
						found = 1;
					}
					j++;
				}
				buf += ch;
			}
			if (!found && aLines.length > line ) {
				aLines[ line ] = '<span id="qsEditorHl">|</span>' + aLines[ line ];
			} else {
				aLines[line] = buf;
			}
			s = aLines.join('<br>\n');
			s = s.replace(/\t/g, '<span class="qsEditorHlTab"> </span>\t');
			$(hid).html(s);
			//$(hid)[0].scrollLeft =  $(mid)[0].scrollLeft + 10;
			var tmpDiv = $('<div class="scroll_helper">Щ</div>');
			$(document.body).append(tmpDiv);
			//tmpDiv.html( aLines[line] );
			var length = tmpDiv.width();
			tmpDiv.remove();
			var dW = (length * textCursor.x) - $(hid)[0].offsetWidth;
			$(hid)[0].scrollLeft = dW;
			
			//$(hid)[0].scrollTop =  $(mid)[0].scrollTop ? $(mid)[0].scrollTop: 0;
			$(hid)[0].scrollTop =  (textCursor.y + 1) * parseInt( $(hid).css('line-height'))  - $(hid).height();
		}
		
		function onKeyDown(e) {
			//Контроль Tab клавиши
			if (e.keyCode == 9) {
				var ta = this, pos = getCaretPosition(ta),
					s = ta.value, tail, q,
				corr = 0;
				if (window.navigator.userAgent.toLowerCase().indexOf('msie') != -1 && s.charAt(pos) == '\n') {
					corr = 1;
				}
				if (pos) {
					q = s.substring(0, pos + corr);
					tail = s.substring(pos + corr, s.length);
					s = q + "\t" + tail;
				} else {
					s += "\t";
				}
				ta.value = s;
				setTimeout(
					function () {
						if (pos) {
							setCaretPosition(ta, pos + 1 + corr);
							textCursor.x++;
						} else {
							ta.focus();
						}
						setMenuIconState();
					}
					, 10
				);
				setTimeout(
					viewHighightEditor
					, 30
				);
				return false;
			} else if (e.keyCode == 13) {//Enter
				setTimeout(
					function () {
						showTextCursorCoord();
					}
					, 10
				);
				var ta = this, pos = getCaretPosition(ta),
					s = ta.value, tail, q, spaces = '', i, j = 0;
				if (pos) {
					for (i = pos - 1; i > -1; i--) {
						if (s.charAt(i) == '\n') {
							j = i + 1;
							break;
						}
					}
					for (i = j; i < pos; i++) {
						if (s.charAt(i) == '\t' || s.charAt(i) == ' ') {
							spaces += s.charAt(i);
						} else {
							break;
						}
					}
					q = s.substring(0, pos);
					tail = s.substring(pos, s.length);
					s = q + "\n" + spaces + tail;
				} else {
					s += "\n";
				}
				ta.value = s;
				setCaretPosition(ta, pos + 1 + spaces.length);
				setTimeout(
					viewHighightEditor
					, 30
				);
				return false;
			} else if (e.keyCode == 68 && e.ctrlKey == true) {//Ctrl + D
				var ta = this, pos = getCaretPosition(ta),
					s = ta.value, tail, q, spaces = '', i, j = 0;
				if (pos) {
					for (i = pos - 1; i > -1; i--) {
						if (s.charAt(i) == '\n') {
							j = i + 1;
							break;
						}
					}
					for (i = j; i < pos; i++) {
						spaces += s.charAt(i);
					}
					q = s.substring(0, pos);
					tail = s.substring(pos, s.length);
					
					s = q + "\n" + spaces + tail;
				} else {
					s += "\n";
				}
				ta.value = s;
				setCaretPosition(ta, pos + 1 + spaces.length);
				setTimeout(
					viewHighightEditor
					, 30
				);
				return false;
			} else if (e.keyCode == 83 && e.ctrlKey == true) {//Ctrl + S
				saveNow();
				setTimeout(
					viewHighightEditor
					, 30
				);
				return false;
			}
			else {
				setTimeout(
					function () {
						setMenuIconState();
						var data = showTextCursorCoord();
						showCodeHint(data);
					}
					, 10
				);
				setTimeout(
					viewHighightEditor
					, 30
				);
			}
		}
		/**
		 * @desc Контроль состояния иконок
		**/
		function setMenuIconState() {
			function setIconExecState() {
				var v = $(mid).val(), i, ch;
				//пока проверяю только контроль блоков, соответствие кол-ва открытых кол-ву закрытых
				if (v.length) {
					var $q_is_open = false,
					$dq_is_open = false,
					$dc_is_open = false,
					$c_is_open = false,
					$in_ignore_block = false,
					oneBlockIsOpen = false,
					$count_open_blocks = 0;
					for (var i = 0; i < v.length; i++) {
						ch = v.charAt(i);
							$ch = ch;
						if (!$in_ignore_block) { //проверить, не начался ли с текущего символа блок игнора
							if ($ch == '"') {
									$dq_is_open = $in_ignore_block = true;
							} else if ($ch == "'") {
								$q_is_open = $in_ignore_block = true;
							} else if ($ch == '/') {
								if (v.charAt(i + 1) == '/') {
									$c_is_open = $in_ignore_block = true;
								} else if (v.charAt(i + 1) == '*') {
									$dc_is_open = $in_ignore_block = true;
								}
							}
							if ($in_ignore_block) {
								continue;
							}
						}
						if ($in_ignore_block) {  //проверить, не закончился ли с текущим символом блок игнора
							if ($q_is_open && $ch == "'") {
								$q_is_open = $in_ignore_block = false;
							} else if ($dq_is_open && $ch == '"') {
								$dq_is_open = $in_ignore_block = false;
							} else if ($c_is_open && $ch == "\n") {
								$c_is_open = $in_ignore_block = false;
							} else if ($dc_is_open && $ch == '/') {
								if (v.charAt(i - 1) == '*') {
									$dc_is_open = $in_ignore_block = false;
								}
							}
							if (!$in_ignore_block) {
								continue;
							}
						}
						if (!$in_ignore_block) { //проверяем на валидность
							if ($ch == '{') {
								$count_open_blocks++;
								oneBlockIsOpen = true;
							}
							if ($ch == '}') {
								$count_open_blocks--;
							}
						}
					}
					if (oneBlockIsOpen && $count_open_blocks == 0) {
						$("#qsEditorContentExec").css('cursor', 'pointer').attr("src", WEB_ROOT + "/img/exec.png")[0].onclick=execNow;
					} else {
						$("#qsEditorContentExec").css('cursor', 'default').attr("src", WEB_ROOT + "/img/exec_d.png")[0].onclick=null;
					}
				}
			}
			setIconExecState();
			
			function setIconSaveState() {
				if (!localStorage) {
					alert(lang['get_actual_browser']);
					return;
				}
				var lastText = localStorage.getItem('qsLastSavedText');
				if ($(mid).val() != lastText) {
					$("#qsEditorSave").css('cursor', 'pointer').attr("src", WEB_ROOT + "/img/save.png")[0].onclick=saveNow;
				} else {
					$("#qsEditorSave").css('cursor', 'default').attr("src", WEB_ROOT + "/img/save_d.png")[0].onclick=null;
				}
			}
			setIconSaveState();
			//setIconSaveAsState();
		}
		//Сохранение файла
		function saveNow() {
			function onFailSaveFile() {
				showError(lang['fail_save_file_try_again']);
			}
			function onSaveFile(data) {
				if (data.status == 'ok') {
					localStorage.setItem('qsLastSavedText', data.text);
					$("#qsEditorSave").css('cursor', 'default').attr("src", WEB_ROOT + "/img/save_d.png")[0].onclick = null;
				} else {
					if (data.requiredFilename != 1) {
						showError(data.msg);
					} else {
						appWindow('saveScriptFormWrapper', lang['information']);
					}
				}
				buildFunctionList();
				saveEditorWidth();
			}
			if (fileId == -1) {
				try {
					var F = eval('(' + $(mid).val() + ')');
					$('#scriptFileNameQs').val(F.name);
					if (!F.name) {
						var name = F.toString().match(/^function\s*([^\s(]+)/)[1];
						$('#scriptFileNameQs').val(name);
					}
				} catch(e) {
					showError(lang['unable_get_function_name_check_code']);
					return;
				}
				appWindow('saveScriptFormWrapper', lang['information']);
			} else if(localStorage.getItem('qsLastSavedText') != $(mid).val()){
				//alert( 'store = |' + localStorage.getItem('qsLastSavedText') + '|, mval=|' +  $(mid).val()  + '|');
				try {
					var F = eval('(' + $(mid).val() + ')');
					if (!F.name) {
						var name = F.toString().match(/^function\s*([^\s(]+)/)[1];
						if (!name) {
							showError(lang['unable_get_function_name_check_code']);
							return;
						}
					}
				} catch(e) {
					showError(lang['unable_get_function_name_check_code']);
					return;
				}
				req({id:fileId, val:$(mid).val()}, onSaveFile, onFailSaveFile, 'saveFile', WEB_ROOT + '/editor/');
			} else {
				$("#qsEditorSave").css('cursor', 'default').attr("src", WEB_ROOT + "/img/save_d.png")[0].onclick=null;
			}
			return false;
		}
		//Запуск скрипта
		function execNow() {
			function showExecuteError(s) {
				alert(s);
			}
			appWindow('fixcon', lang['Output']);
			try {
				eval('(' + $(mid).val().replace('cookie', 'сооkie') + ')()');
			} catch(E) {
				showExecuteError(lang['on_execute_your_script_was_errors'] + ' ' + E.message + ' ' + lang['delete_errors_and_try_again']);
			}
		}
		//Save as , fail
		function onFailSaveNew() {
			showError(lang['fail_save_user_script_try_update']);
		}
		//Save as, success
		function onSaveNew(d) {
			if (d.status == 'ok') {
				fileId = d.id;
				localStorage.setItem('fileId', fileId);
				fileDisplayName = d.display;
				localStorage.setItem('fileDisplayName', fileDisplayName);
				localStorage.setItem('qsLastSavedText', $(mid).val());
				
				$('#currentFileName').text(fileDisplayName);
				appWindowClose();
				$("#qsEditorSave").css('cursor', 'default').attr("src", WEB_ROOT + "/img/save_d.png")[0].onclick = null;
				//TODO добавить в очередь тултипов
				addTooltipMessage(d.message);
				if (d.warning) {
					addTooltipWarning(d.warning);
				}
				buildFunctionList();
				saveEditorWidth();
			} else {
				showError(d.msg);
			}
		}
		//Сохранить как, клик на иконке
		function showSaveAs() {
			fileId = -1;
			fileDisplayName = '';
			$('#scriptFileNameQs').val('');
			$('#scriptDisplayNameQs').val('');
			appWindow('saveScriptFormWrapper', lang['information']);
		}
		//Сохранить как, отправка формы
		function sendSaveAs(evt) {
			if (evt.target.id == 'scriptDisplayNameQs' && evt.keyCode != 13) {
				return true;
			}
			if (!guid && !uid) {
				showError(lang['fail_save_user_script_try_update']);
				return false;
			}
			try {
				var F = eval('(' + $(mid).val() + ')');
				$('#scriptFileNameQs').val(F.name);
			} catch(e) {
				showError(lang['main_function_require']);
				return false;
			}
			if (!F.name) {
				var name = F.toString().match(/^function\s*([^\s(]+)/)[1];
				$('#scriptFileNameQs').val(name);
			}
			if (!$('#scriptFileNameQs').val()) {
				showError(lang['main_function_require']);
				return false;
			}
			req({fileName: $('#scriptFileNameQs').val(), display:$('#scriptDisplayNameQs').val(), content:$(mid).val()}, onSaveNew, onFailSaveNew, 'saveFileAs', WEB_ROOT + '/editor/');
			return false;
		}
		//
		function onKeyUp() {
			//Сохранение в localStorage
			localStorage.setItem('qsLastText', $(mid).val());
			//позиция курсора
			showTextCursorCoord();
		}
		function showOpenFileDlg() {
			function onFailLoadUserFiles() {
				showError(lang["unable_load_file_list_try_later"]);
				appWindowClose();
			}
			function onLoadUserFiles(d) {
				
				function showRemoveFileInput() {
					function onFailRemove() {
						$('#qsBrDlgBg').removeClass('hide').addClass('hide');
						$('#qsBrLoader').removeClass('hide').addClass('hide');
						showError(lang['remove_alien_file_or_other_update_page']);
					}
					function onRemove(d) {
						$('#qsBrDlgBg').removeClass('hide').addClass('hide');
						$('#qsBrLoader').removeClass('hide').addClass('hide');
						if (d.status == 'ok') {
							var obj = $('#titlefile-' + d.id)[0];
							if (obj) {
								$(obj).parents('.file_view').first().remove();
							}
							appWindowClose();
						} else {
							showError(msg);
						}
					}
					var obj = $(this), id;
					if (id = parseInt(obj.data('id'))) {
						if (confirm(lang["confirm_removal_script"])) {
							$('#qsBrDlgBg').removeClass('hide');
							$('#qsBrLoader').removeClass('hide');
							$('#qsBrLoader').css('left', ( $('#qsBrDlgBg').width() - $('#qsBrLoader').width() ) / 2 );
							req({id:id}, onRemove, onFailRemove, 'removeFile', WEB_ROOT + '/editor/');
						}
					}
				}
				
				function showRenameFileInput() {
					var obj = $(this),
						text = obj.parents('.file_view').first().find('.js-file-title').first().text();
					$('#qsEditTitle').val(text);
					$('#qsEditTitleCurrentId').val(obj.data('id'));
					$('#qsBrDlgBg').removeClass('hide');
					$('#qsRenameForm').removeClass('hide');
				}
				$('.no_file').removeClass('hide').addClass('hide');
				if (d.status == 'ok') {
					$('#qs-br ul.js-br-files .file_view').each(
						function (i, item) {
							if (!$(item).hasClass('template')) {
								$(item).remove();
							}
						}
					);
					if (d.list) {
						var jTpl = $('#qs-br ul.js-br-files .template').first(), oTpl = jTpl[0], tpl = jTpl.html(), item, s = '';
						$(d.list).each(
							function (i, data) {
								s = tpl.replace(/\{id\}/g, data.id);
								s = s.replace('{name}', data.display_file_name);
								item = $('<li class="' + oTpl.className + '" data-id="' + data.id + '">' + s +  '</li>');
								item.removeClass('hide');
								item.removeClass('template');
								item.find('.file-remove').click(showRemoveFileInput);
								item.find('.file-rename').click(showRenameFileInput);
								item.find('.js-qsbr-file').click(loadFileContent);
								$('#qs-br ul.js-br-files').first().append(item);
							}
						);
						appWindowClose();
						appWindow('qs-br-wrap', lang['Openfile']);
						$('.file-names-filter').css('width', $('.file-names-filter').width() + 'px');
					} else {
						$('.no_file').removeClass('hide');
					}
					$('#qsBrDlgBg').addClass('hide');
					$('#qsBrLoader').addClass('hide');
				} else {
					showError(d.msg);
				}
			}
			function loadFileContent() {
				function onFailLoadContent() {
					showError(lang['load_file_fail']);
					hideLoader();
				}
				function onLoadContent(d) {
					d = d.row;
					fileId = d.id;
					localStorage.setItem('fileId', fileId);
					fileDisplayName = d.display_file_name;
					$(mid).val(d.file_content);
					$('#currentFileName').text(fileDisplayName);
					localStorage.setItem('fileDisplayName', fileDisplayName);
					onKeyUp();
					if (window.location.href.indexOf('/text_editor') != -1) {
						seInitProjectFunctions();
					} else {
						buildFunctionList();
					}
					hideLoader();
				}
				var id = parseInt($(this).data('id'));
				if (id) {
					if (parseInt(new Date().getTime() / 1000) - lastTimeLoadFileClick > 1) {
						lastTimeLoadFileClick = parseInt(new Date().getTime() / 1000);
						return;
					}
					appWindowClose();
					showLoader();
					req({id:id}, onLoadContent, onFailLoadContent, 'loadFileContent', WEB_ROOT + '/editor/');
				}
			}
			//$('.file-names-filter').attr('style', null);
			appWindow('qs-br-wrap', lang['Openfile']);
			setTimeout(
				function() {
					var obj = document.getElementById('qs-br');
					if (obj) {
						$('#qsBrLoader').css('top', Math.round((obj.offsetHeight - 66)/ 2) + 'px').css('left', Math.round((obj.offsetWidth -66)/ 2)  + 'px' );
						$('.file-names-filter').css('width', (obj.offsetWidth - 1) + 'px');
					}
				}, 10
			);
			//init serach field
			$('#searchFileName')[0].onkeydown = filesFilter;
			// end init serach field
			req({}, onLoadUserFiles, onFailLoadUserFiles, 'loadUserFiles', WEB_ROOT + '/editor/');
		}
		//отправка запроса на переименование файла
		function sendRenameFile(){
			function onFailRename() {
				showError(lang['alien_file_or_other_ipdate_page']);
				$('#qsBrDlgBg').addClass('hide');
				$('#qsRenameForm').addClass('hide');
			}
			function onRename(data) {
				$('#qsBrDlgBg').addClass('hide');
				$('#qsRenameForm').addClass('hide');
				if (data.status == 'ok') {
					var obj;
					if (obj = $('#titlefile-' + data.id)[0]) {
						$(obj).text(data.text);
					}
				} else {
					showError(data.msg);
				}
			}
			var data = {displayText:$('#qsEditTitle').val(), id:$('#qsEditTitleCurrentId').val()}
			if (!data.displayText.length) {
				showError(lang['file_name_require']);
				return;
			}
			req(data, onRename, onFailRename, 'renameFile', WEB_ROOT + '/editor/');
		}
		//Показать диалог назначения связей
		function showProjectSettingDlg(){
			function onFailRename() {//TODO
				showError(lang['alien_file_or_other_ipdate_page']);
				$('#qsBrDlgBg').addClass('hide');
				$('#qsRenameForm').addClass('hide');
			}
			function onSaveRelation(data) {
				$('#qsBrDlgBg').addClass('hide');
				$('#qsRenameForm').addClass('hide');
				if (data.status == 'ok') {
					var obj;
					if (obj = $('#titlefile-' + data.id)[0]) {
						$(obj).text(data.text);
					}
				} else {
					showError(data.msg);
				}
			}
			function _onRelationData(data) {
				$('#qsrdSets')[0].options.length = 0;
				$('#qsrdAll')[0].options.length = 0;
				var exclude = [data.id], sExclude, k = 0;
				$(data.sets).each(
					function (i, obj) {
						$('#qsrdSets')[0].options[k] = new Option(obj.display_file_name, obj.file_id);
						exclude.push(obj.file_id);
						k++;
					}
				);
				sExclude = ',' + exclude.join(',') + ',';
				k = 0;
				$(data.all).each(
					function (i, obj) {
						if ( sExclude.indexOf(',' + obj.id + ',') == -1 ) {
							$('#qsrdAll')[0].options[k] = new Option(obj.display_file_name, obj.id);
							k++;
						}
					}
				);
				appWindow('qsSetRelDlgWrap', lang['Relations_for_file'] + $('#currentFileName').text());
			}
			req({id:fileId}, _onRelationData, defaultAjaxFail, 'loadAssignedFiles', WEB_ROOT + '/editor/');
		}
		//плюшки для редактора
		function _getStdMethods() {
			var object = JSON.parse( String(localStorage.getItem('projstd')) );
			if (!object) {
				object = {};
			}
			object.globals = {};
			//return {globals:{}};//TODO сделать получение так же как с определенными в проекте
			return object;
		}
		/**
		 * @desc Получить имя библиотеки из javaScript кода
		 * Предполагается, в коде определена только одна переменная window.LibName
		*/
		function _getLibName(s) {
			var re = /window\.([A-z0-9_]+)/mi,
				names = s.match(re), name = false;
			if (names && names.length >= 2) {
				name = names[1];
			}
			if (name) {
				return name;
			}
			return 'globals';
		}
		/**
		 * @desc строит список функций, встречающихся в открытом файле
		*/
		function buildFunctionList() {
			var s = $(mid).val(),
				re = /function\s+[A-z0-9_]+\s*\([A-z0-9,'" ]*\)/gi,
				data = s.match(re), cName, fName;
			
			ContentFunctions = {};
			for (cName in DefaultContentFunctions) {
				ContentFunctions[cName] = {}
				for (fName in DefaultContentFunctions[cName]) {
					if (fName == 'std') {
						ContentFunctions[cName].std = true;
						continue;
					}
					ContentFunctions[cName][fName] = {
						name:DefaultContentFunctions[cName][fName].name,
						src:DefaultContentFunctions[cName][fName].src,
						args:[],
						std:DefaultContentFunctions[cName][fName].std,
						showStd:DefaultContentFunctions[cName][fName].showStd
					};
					if (DefaultContentFunctions[cName][fName].args) {
						for (var k = 0; k < DefaultContentFunctions[cName][fName].args.length; k++) {
							ContentFunctions[cName][fName].args.push( DefaultContentFunctions[cName][fName].args[k] );
						}
					}
				}
			}
			//globals
			$(data).each(
				function (i, s) {
					var src = s,
						o = {args:[]},
						j, _name = '', open = 0, ch, nameStart = 0, readArg = 0;
					s = s.replace('function', '');
					var args = s.replace(/.*\(([^)]*)\).*/, '$1');
					var arr = s.split('(');
					o.name = $.trim((arr[0]));
					o.src = src;
					if (args.length) {
						arr = args.split(',');
						$(arr).each(
							function(i, q) {
								q = $.trim(q);
								if(q){
									o.args.push(q);
								}
							}
						);
					}
					ContentFunctions.globals[o.name] = o;
				}
			);
			//window.Lib functions
			re = /[A-z0-9_]+\s*\:\s*function\s*\([A-z0-9,'" ]*\)/gi;
			data = s.match(re);
			var libName = _getLibName(s);
			$(data).each(
				function (i, s) {
					var src = s,
						o = {args:[]},
						j, _name = '', open = 0, ch, nameStart = 0, readArg = 0;
					s = s.replace('function', '');
					var args = s.replace(/.*\(([^)]*)\).*/, '$1');
					var arr = s.split('(');
					o.name = $.trim((arr[0]));
					arr = s.split(':');
					o.name = $.trim((arr[0]));
					o.src = src;
					if (args.length) {
						arr = args.split(',');
						$(arr).each(
							function(i, q) {
								q = $.trim(q);
								if(q){
									o.args.push(q);
								}
							}
						);
					}
					if (!ContentFunctions[libName]) {
						ContentFunctions[libName] = {}
					}
					ContentFunctions[libName][o.name] = o;
				}
			);
			//prototype functions
			re = /[A-z0-9_]+\s*\.\s*prototype\s*\.[A-z0-9_]+\s*=\s*function\s*\([A-z0-9,'" ]*\)/gi;
			data = s.match(re);
			$(data).each(
				function (i, s) {
					var src = s,
						o = {args:[]},
						j, _name = '', open = 0, ch, nameStart = 0, readArg = 0;
					s = s.replace('function', '');
					var args = s.replace(/.*\(([^)]*)\).*/, '$1');
					var arr = s.split('(');
					var q = $.trim((arr[0]));
					arr = q.split('prototype');
					var cName = $.trim((arr[0]));
					cName = $.trim( cName.replace('.', '') );
					o.name = $.trim((arr[1]));
					o.name = $.trim( o.name.replace(/[.=]/gim, '') );
					o.src = src;
					if (args.length) {
						arr = args.split(',');
						$(arr).each(
							function(i, q) {
								q = $.trim(q);
								if(q){
									o.args.push(q);
								}
							}
						);
					}
					if (!ContentFunctions[cName]) {
						ContentFunctions[cName] = {}
					}
					ContentFunctions[cName][o.name] = o;
				}
			);
			
			showContentFunctionsInList();
		}
		/**
		 * @desc Выводит имена функций в списке справа
		*/
		function showContentFunctionsInList() {
			var container = $('#functionlist'), //используя эту переменную позже построим дерево
				cName, fName;
			container.html('');
			for (cName in ContentFunctions) {
				if (cName != 'globals' && !ContentFunctions[cName].std) {
					container = addContentClassInList(cName);
				} else {
					container = $('#functionlist');
				}
				for (fName in ContentFunctions[cName]) {
					if (fName == 'std') {
						continue;
					}
					if ( (ContentFunctions[cName][fName].std && ContentFunctions[cName][fName].showStd) || !ContentFunctions[cName][fName].std ) {
						container.append( $('<li><a href="#" onclick="SiEd.gotoFunctionOnEditor(\'' + fName + '\', \'' + cName + '\'); return false;">' + fName + '</a></li>') );
					}
				}
			}
		}
		/**
		 * Возвращает ссылку на элемент списка, для построения дерева
		 * */
		function addContentClassInList(cName) {
			var root = $('#functionlist'),
				tpl = '<li>\
						<a href="#" class="code_object" onclick="return SiEd.swapVisible(\'' + cName + '\')" id="' + cName + '">' + cName + '</a>\
						<ul id="' + cName + 'M" class="hide code_subc">\
						</ul>\
					  </li>';
			root.append( $(tpl) );
			root = $('#' + cName + 'M');
			return root; //TODO заглушку убрать
		}
		/**
		 * Скрыть или показать список методов в классе
		*/
		window.SiEd.swapVisible = function (cName) {
			var obj = $('#' + cName + 'M');
			if (obj.hasClass('hide')) {
				obj.removeClass('hide')
			} else {
				obj.addClass('hide')
			}
			return false;
		}
		/**
		 * Переход к выбранной в списке справа функции
		 * */
		window.SiEd.gotoFunctionOnEditor = function (name, cName) {
			if (!cName) {
				cName = 'globals';
			}
			if (ContentFunctions[cName][name]) {
				var src = ContentFunctions[cName][name].src,
					s = $(mid).val(),
					caretPos = s.indexOf(src),
					L, T, value;
				if (caretPos != -1) {
					//T = s.split('\n').length;
					s = s.substring(0, caretPos);
					L = s.split('\n').length;
					value = (L - 1) * parseInt($(mid).css('line-height'), 10);
					
					$(mid)[0].scrollTop = 100500;
					setCaretPosition($(mid)[0], caretPos);
					showTextCursorCoord();
					setTimeout(
						function () {
							$(mid)[0].scrollTop = value;
							
						}, 10
					);
				}
			}
		}
		/**
		 * Возвращает ссылку на элемент списка, для построения дерева
		*/
		function showCodeHint(data) {
			var pos = data.p, s = data.s, q = s, L,
			rightCb, rightOb, leftCb, leftOb, i, aName = [], alp = 'abcdefghijklmnopqrstuvwxyz0123456789_$';
			if (pos) {
				s = s.substring(0, pos);
				alp += alp.toUpperCase();
				leftCb = s.lastIndexOf(')');
				leftOb = s.lastIndexOf('(');
				if (leftOb != -1 && leftOb > leftCb) {
					var  start  = 0, proc = 0, fName;
					for (i = leftOb - 1; i > -1; i--) {
						var ch = s.charAt(i);
						if (alp.indexOf(ch) != -1) {
							aName.push(ch);
							start = 1;
						} else if (start) {
							break;
						}
					}
					fName = $.trim( aName.reverse().join('') );
					for (cName in ContentFunctions) {
						for (name in ContentFunctions[cName]) {
							if (name == fName && ContentFunctions[cName][name].args.length) {
								$('#codeTooltip').text( ContentFunctions[cName][name].args.join(', ') ).removeClass('hide');
								//TODO set coordinates
								L = parseInt($(mid).css('line-height'), 10)  *  (s.split('\n').length + 1);
								var top = (L - $(mid)[0].scrollTop + $(mid)[0].offsetTop ) +  'px';
								$('#codeTooltip').css('top', top);
								return;
							}
						}
					}
				}
			}
			$('#codeTooltip').addClass('hide');
		}
		/**
		 * Сохранить ширину редактора на странице text_editor
		*/
		function saveEditorWidth() {
			if (enableFunctions) {
				localStorage.setItem('editorWidth', $('#textEditorArea').width());
			}
		}
		//Инициализация
		$(mid).keydown(onKeyDown);
		$(mid).keyup(onKeyUp);
		$(mid).click(setMenuIconState);
		$(mid).click(showTextCursorCoord);
		$('#scriptFileQsButton').click(sendSaveAs);
		$('#scriptDisplayNameQs').keydown(sendSaveAs);
		$('#qsEditorSaveAs').click(showSaveAs);
		$('#qsEditorOpenFile').click(showOpenFileDlg);
		$('#qsEditTitleSaveBtn').click(sendRenameFile);
		$('#qsEditorSetPro').click(showProjectSettingDlg);
		//Настройка редактора связей
		function seInitProjectDlg() {
			//Существующий файл в выбранный
			function _unlock() {
				$('#qsSetRelDlg select').prop('disabled', null);
				$('#qsSetRelDlg button').prop('disabled', null);
			}
			function _move(src, dest) {
				var id = $(src).val(), 
					opt = $(src + ' option[value=' + id + ']'),
					text = opt.text();
				opt.remove();
				$( dest + ' option[value=' + id + ']').remove();
				$( dest ).append( $('<option value="' + id + '">' + text + '</option>') );
			}
			//Обработка успешного ответа на попытку перемещения
			function _onMove(data) {
				_unlock();
				if (data.status == 'ok') {
					if (data.act == 'fromAll2sets') {
						_move('#qsrdAll', '#qsrdSets');
					}
					if (data.act == 'fromSets2all') {
						_move('#qsrdSets', '#qsrdAll');
					}
				} else {
					showError(data.msg);
				}
			}
			//запрос на перемещение
			function _reqMove(src, cmd) {
				var data = {
					head:fileId,
					ex:$(src)[0].value
				}
				if (!data.ex) {
					return;
				}
				$('#qsSetRelDlg select').prop('disabled', 'disabled');
				$('#qsSetRelDlg button').prop('disabled', 'disabled');
				req(data, _onMove, defaultAjaxFail, cmd);
			}
			$('#qsrdLTR').click(
				function() {
					_reqMove('#qsrdAll', 'fromAll2sets');
				}
			);
			$('#qsrdRTL').click(
				function() {
					_reqMove('#qsrdSets', 'fromSets2all');
				}
			);
		}
		//Загрузка функций из связанных файлов
		function seInitProjectFunctions(std) {
			var csum = localStorage.getItem('prohash' + fileId);
			if (std) {
				csum = localStorage.getItem('prohashstd');
			}
			/**
			 * @desc Сохранение подсказок к функциям связанных файлов в локальное хранилище
			*/
			function _onFileContentsData(response) {
				if (response.nothing == 1) {
					return;
				}
				//получить настройку, показывать ли стандартные функции в списке слева
				var showStd = localStorage.getItem('showStd');
				showStd = showStd ? true : false;
				//alert('Now parse and save in LS');
				var list = response.rows, i, libName, obj;
				var storage = {};
				for (i in list) {
					obj = list[i];
					libName = _getLibName(obj.file_content);
					
					var re = /[A-z0-9_]+\s*\:\s*function\s*\([A-z0-9,'" ]*\)/gi,
						s = obj.file_content,
						data = s.match(re), cName, fName;
					$(data).each(
						function (i, s) {
							var src = s,
								o = {args:[]},
								j, _name = '', open = 0, ch, nameStart = 0, readArg = 0;
							s = s.replace('function', '');
							var args = s.replace(/.*\(([^)]*)\).*/, '$1');
							var arr = s.split('(');
							o.name = $.trim((arr[0]));
							arr = s.split(':');
							o.name = $.trim((arr[0]));
							o.src = src;
							if (std) {
								o.std = std;
								o.showStd = showStd;
							}
							if (args.length) {
								arr = args.split(',');
								$(arr).each(
									function(i, q) {
										q = $.trim(q);
										if(q){
											o.args.push(q);
										}
									}
								);
							}
							if (!storage[libName]) {
								storage[libName] = {}
							}
							storage[libName][o.name] = o;
						}
					);
					
					// begin
					//prototype functions
					re = /[A-z0-9_]+\s*\.\s*prototype\s*\.[A-z0-9_]+\s*=\s*function\s*\([A-z0-9,'" ]*\)/gi;
					data = s.match(re);
					$(data).each(
						function (i, s) {
							var src = s,
								o = {args:[]},
								j, _name = '', open = 0, ch, nameStart = 0, readArg = 0;
							s = s.replace('function', '');
							var args = s.replace(/.*\(([^)]*)\).*/, '$1');
							var arr = s.split('(');
							var q = $.trim((arr[0]));
							arr = q.split('prototype');
							var cName = $.trim((arr[0]));
							cName = $.trim( cName.replace('.', '') );
							o.name = $.trim((arr[1]));
							o.name = $.trim( o.name.replace(/[.=]/gim, '') );
							o.src = src;
							if (std) {
								o.std = std;
								o.showStd = showStd;
							}
							if (args.length) {
								arr = args.split(',');
								$(arr).each(
									function(i, q) {
										q = $.trim(q);
										if(q){
											o.args.push(q);
										}
									}
								);
							}
							if (!storage[cName]) {
								storage[cName] = {}
							}
							storage[cName][o.name] = o;
							
							if (response.std) {
								storage[cName].std = true;
							}
						}
					);
					// /end
					
				}
				var fid = fileId;
				if (response.std) {
					fid = 'std';
				}
				localStorage.setItem('proj' + fid, JSON.stringify(storage));
				localStorage.setItem('prohash' + fid, response.sum);
				_loadFunctionsFromLocalStorage();
			}
			/**
			 * @desc Сравнение локального кеша с удаленным
			*/
			function _onCSumData(data) {
				if (data.sum != csum) {
					//содержимое файлов изменилось - перезагружаем
					if (!std) {
						req({id:fileId}, _onFileContentsData, defaultAjaxFail, 'getCsumAndFlieContents');
					} else {
						req({id:'std'}, _onFileContentsData, defaultAjaxFail, 'getCsumAndFlieContents');
					}
				}
			}
			/**
			 * @desc Загрузка функций в DefaultContentFunctions из локального хранилища
			*/
			function _loadFunctionsFromLocalStorage() {
				var data = JSON.parse( localStorage.getItem('proj' + fileId) ), cName, fName;
				DefaultContentFunctions = _getStdMethods();
				for (cName in data) {
					DefaultContentFunctions[cName] = {};
					for (fName in data[cName]) {
						if (fName == 'std') {
							continue;
						}
						DefaultContentFunctions[cName][fName] = {
							name:data[cName][fName].name,
							src:data[cName][fName].src,
							args:[],
							std:data[cName][fName].std,
							showStd:data[cName][fName].showStd
						};
						for (var k = 0; k < data[cName][fName].args.length; k++) {
							DefaultContentFunctions[cName][fName].args.push( data[cName][fName].args[k] );
						}
					}
				}
				try {
					buildFunctionList();
				} catch(e) {;}
			}
			if (!std) {	
				if (csum) {
					req({id:fileId}, _onCSumData, defaultAjaxFail, 'getCsum');
					_loadFunctionsFromLocalStorage();
				} else {
					req({id:fileId}, _onFileContentsData, defaultAjaxFail, 'getCsumAndFlieContents');
				}
			} else {
				if (csum) {
					req({id:'std'}, _onCSumData, defaultAjaxFail, 'getCsum');
					_loadFunctionsFromLocalStorage();
				} else {
					req({id:'std'}, _onFileContentsData, defaultAjaxFail, 'getCsumAndFlieContents');
				}
			}
		}
		
		//Загрузка последнего содержимого
		if (localStorage.getItem('qsLastText')) {
			$(mid).val( localStorage.getItem('qsLastText') );
			setMenuIconState();
			showTextCursorCoord();
			buildFunctionList();
			if(localStorage.getItem('fileId')) {
				fileId = localStorage.getItem('fileId');
			}
			if(localStorage.getItem('fileDisplayName')) {
				fileDisplayName = localStorage.getItem('fileDisplayName');
				$('#currentFileName').text(fileDisplayName);
			} else {
				try {
					var F = eval('(' + $(mid).val() + ')');
					$('#currentFileName').text(F.name);
					if (!F.name) {
						var name = F.toString().match(/^function\s*([^\s(]+)/)[1];
						$('#scriptFileNameQs').val(name);
					}
				}catch(E){;}
			}
		}
		$(hid).bind('mousewheel', showTextCursorCoord);
		//на странице text_editor
		if (window.location.href.indexOf('/text_editor') != -1) {
			//высота редактора
			enableFunctions = true;
			maxEditorHeight = getViewport().h - 130;
			$('#qs_editor_s').height(  maxEditorHeight + 'px' );
			$('#qseLineWrapper').height( ($('#qs_editor_s').height() + 5) + 'px');
			showTextCursorCoord();
			var w;
			if (w = localStorage.getItem('editorWidth')) {
				//$('#textEditorArea').width(w); 
				$('#qs_editor_hl').css('max-width', w + 'px');
			}
			//загрузка связанных функций
			seInitProjectDlg();
			seInitProjectFunctions(true);
			seInitProjectFunctions();
		}
		//Копирование текста в отображение
		$(hid)[0].onclick = function() { $(mid)[0].focus(); setCaretPosition($(mid)[0], lastPos) };
		$(hid).css( 'height', $(mid).height() + 'px' );
		viewHighightEditor();
	}
//============ / Простой редактор кода==================================
	/**
	 * @desc Фильтр файлов в диалоге открытия файла редактора и диалоге выбора файлов решений
	*/
	function filesFilter() {
		function isFileItem(li) {
			if (li.hasClass('file_view template') || li.hasClass('no_file')) {
				return false;
			}
			return true;
		}
		
		var inp = this, prefix;
		
		switch (inp.id) {
			case 'searchFileFilter':
				prefix = '#ts-br';
				break;
			default:
				prefix = '#qs-br';
		}
		setTimeout(
			function() {
				var s = inp.value;
				if (s.length) {
					$(prefix + ' .js-br-files li').each(
						function (i, item) {
							item = $(item);
							if (!isFileItem(item)) {
								return;
							}
							var name = item.find('.js-file-title').text();
							if (name.indexOf(s) == -1) {
								item.addClass('hide');
							} else {
								item.removeClass('hide');
							}
						}
					);
				} else {
					$(prefix + ' .js-br-files li').each(
						function (i, item) {
							item = $(item);
							if (!isFileItem(item)) {
								return;
							}
							item.removeClass('hide');
						}
					);
				}
			}
			,10
		);
	}
//===========Словари и подсветка для подсказок на страницах статей======
//====== Словарь кейвордов  и стандартных функций
	function initKeywordsHelp() {
		/**
		 * @desc Подсветка синтаксиса для текста в всплывающем окне
		 * @see initKeywordsHelp, initStdFuncsHelp
		 * @param keyMap - карта слов требующих подсветки в виде массива, получена во время работы  _getKeyMap
		 * @param sKeys  - специальная строка с ключевыми словами, требующими подсветки, результат _getKeyMap
		 * @param sKeysSF - специальная строка с именами стандартных функций, результат _getKeyMap
		 * 
		*/
		function _highlightWordsInHelp(keyMap, sKeys, sKeysSF) {
			var i, j,content, saveContent, list, buf;
			for (i in keyMap) {
				saveContent = content = keyMap[i];
				content = _highlightJsCode(content, sKeys, sKeysSF, i);
				keyMap[i] = {hl:content, pl:saveContent};
			}
			return keyMap;
		}
		
		var keyMap = {}, sKeys,
			keyMapSF = {}, sKeysSF,
			i, j, list, q, content, saveContent;
		sKeys = _getKeyMap('keywords', 'b', keyMap);
		//инициализация стд. функций
		sKeysSF = _getKeyMap('stdfunctions', 'i', keyMapSF);
		keyMap = _highlightWordsInHelp(keyMap, sKeys, sKeysSF);
		keyMapSF = _highlightWordsInHelp(keyMapSF, sKeys, sKeysSF);
		
		function onColorWordClick() {
			var km = (this.tagName == 'B' ? keyMap :( this.tagName == 'I' ? keyMapSF : keyMap )); //TODO last keyMap заменить на keyMapUF когда тот появится
			var s = km[$(this).text()].hl;
			if (km[$(this).text()].pl != $(this).attr('title')) {
				s = $(this).attr('title');
			}
			$('#keywordLog').html('<pre style="white-space: pre-wrap; padding:10px; tab-size:2;-moz-tab-size: 2; -o-tab-size:2;">' + s + '</pre>');
			appWindow('keywordLogWrap', lang['information']);
		}
		//Подсветка синтаксиса в примерах кода в комментариях пользователя
		$('.textcontent .vcomments pre').each(
			function (i, pre) {
				var s = $(pre).html().replace(/<br>/g, '\n');
				s = _highlightJsCode(s, sKeys, sKeysSF);
				//s = s.replace(/<br>/g, '\n');
				$(pre).html(s);
			}
		);
		
		//Подсветка синтаксиса в примерах кода в 
		$('.textcontent .vd_content pre').each(
			function (i, pre) {
				var s = $(pre).html().replace(/<br>/g, '\n');
				s = _highlightJsCode(s, sKeys, sKeysSF);
				//s = s.replace(/<br>/g, '\n');
				$(pre).html(s);
			}
		);
		
		//добавление подсветки синтаксиса в подсказки примеров кода
		$('.textcontent pre b, .textcontent pre i').each(
			function (i, b) {
				var km = (b.tagName == 'B' ? keyMap :( b.tagName == 'I' ? keyMapSF : keyMap )); //TODO last keyMap заменить на keyMapUF когда тот появится
				if (km[$(b).text()]) {
					if (!$(b).attr('title') || $(b).attr('title') == '') {
						$(b).attr('title', km[$(b).text()].pl);
					}
					$(b).click(onColorWordClick);
				}
			}
		);
		//добавление номеров строк 
		$('.textcontent pre').each(
			function(i, pre) {
				pre = $(pre);
				var parent = pre.parent(),
					tpl = $('<div class="code_example">\
						<div class="ce_btn"><input class="btn copy_example_btn" type="button" value="' + lang['Copy_this_code'] + '"></div>\
						<div class="ce_ls left"></div>\
						<div class="ce_pre left"></div>\
						<div class="clearfix"></div>\
					</div>');
				if (pre.hasClass('no_lines')) {
					return;
				}
				if (pre.hasClass('no_copy')) {
					tpl = $('<div class="code_example">\
						<div class="ce_ls left"></div>\
						<div class="ce_pre left"></div>\
						<div class="clearfix"></div>\
					</div>');
				}
				pre.after(tpl);
				var n = pre.text().split('\n').length;
				tpl.find('.ce_pre').first()[0].appendChild(pre[0]);
				var c = tpl.find('.ce_ls').first();
				for (var i = 0; i < n; i++) {
					c.append( $('<div class="ce_l">' + (i + 1) + '</div>') );
				}
				tpl.find('.btn').click(
					function() {
						var obj = $(this),
							text = obj.parent().parent().find('pre').text();
						$('#qs_editor_s').val(text);
					}
				);
			}
		);
		
	}
//====== /Словарь кейвордов и стандартных функций
//====== Тултипы
	/**
	 * @desc Уведомления в стиле ubuntu
	 * */
	function initTooltipFunctions() {
		//постановка в очередь сообщений
		if (window.infoMessages) {
			var data = infoMessages, i, k, back_done = 'bg-dark-blue', back_fail = 'bg-rose';
			if (data) {
				setInterval(
					function() {
						if ($('#tooltip').css('opacity') > 0) {
							return;
						}
						for (i in data) {
							for (k in data[i]) {
								if (k.indexOf("_errors") != -1) {
									var css = 'bg-rose';
									if (data[i][k].length) {
										var msg = '<p>' + data[i][k].pop().replace(/\n/g, '<p>');
										
										$('#tooltip').css('opacity', 0.9).
											//css('top', window.scrollY + 'px').
											removeClass(back_done).
											removeClass(back_fail).
											addClass(back_fail)[0].innerHTML = msg;
										return;
									}
								}
								if (k.indexOf("_messages") != -1) {
									var css = 'bg-light-green';
									if (data[i][k].length) {
										var msg = '<p>' + data[i][k].pop().replace(/\n/g, '<p>');
										$('#tooltip').css('opacity', 0.9).
											//css('top', window.scrollY + 'px').
											removeClass(back_done).
											removeClass(back_fail).
											addClass(back_done)[0].innerHTML = msg;
										return;
									}
								}
								
							}
						}
					}, 1000
				);
			}
		}
		//анимация затухания
		var tooltip_show_delay = 10 * 1000,
				interval = 75,
				opacity = 0, counter = 0;
			setInterval(
				function () {
					if ($('#tooltip').css('opacity') > 0) {
						var int = setInterval(
							function () {
								if ($('#tooltip').css('opacity') == 0) {
									counter = opacity = 0;
								} else {
									if (opacity == 0) {
										counter += interval;
									}
									if (counter > tooltip_show_delay) {
										opacity = $('#tooltip').css('opacity');
									}
									if (opacity > 0) {
										opacity -= 0.02;
										if (opacity < 0) {
											opacity = 0;
										}
										$('#tooltip').css('opacity', opacity);
										if (opacity == 0) {
											counter = opacity = 0;
											clearInterval(int);
										}
									}
								}
							},
							interval
						);
					}
				}
				,2*1000
		);
	}
	/**
	 * Добавить предупреждение в очередь тултипа
	**/
	function addTooltipWarning(s)  {
		_addTooltipMsg(s, "errors");
	}
	/**
	 * Добавить сообщение об ошибке в очередь тултипа
	**/
	function addTooltipError(s)  {
		_addTooltipMsg(s, "errors");
	}
	/**
	 * Добавить сообщение в очередь тултипа
	**/
	function addTooltipMessage(s)  {
		_addTooltipMsg(s, "messages");
	}
	/**
	 * @desc Добавить сообщение в очередь тултипа
	 * @param s
	 * @param key "errors"|"messages"
	**/
	function _addTooltipMsg(s, key)  {
		key = "ajax_" + key;
		var data = {};
		data[key] = [s];
		window.infoMessages[parseInt(new Date().getTime()) + Math.random()] = data;
	}
//====== /Тултипы
	/**
	 * @desc Если пользователь неавторизован и у него нет guid надо его указать
	 * */
	function initGuid() {
		function onGuidSuccess(data) {
			window.guid = guid = data.guid;
			$.cookie('guest_id', guid, {expires:100, path: '/'});
		}
		function onGuidFail() {
			setTimeout(
				function () {
					initGuid();
				}, 15*1000
			);
		}
		if (!$.cookie('guest_id')) {
			req({}, onGuidSuccess, onGuidFail, 'getGuid', WEB_ROOT + '/console/');
		} else {
			window.guid = guid = $.cookie('guest_id');
		}
	}
	
	/**
	 * @desc Инициализация вспомогательных функций управления всплывающим окном
	**/
	function initWinFunctions() {
		window.onWinClose = function() {
		}
		$('#uploadScriptShowForm').click(
			function () {
				appWindow('addScriptForm', lang['file_upload'], null, true);
			}
		);
		$('#addScriptForm')[0].onsubmit=function() {
			var filename = '', warning = 0;
			if ( $('#scriptFile')[0].files.length ) {
				filename = $('#scriptFile')[0].files[0].name;
			} else {
				showError(lang['need_select_file']);
				return false;
			}
			$('.tasklist a').each(
				function(i, a) {
					if ($(a).data('srcfn') == filename || $('#scriptDisplayName').val() == $(a).data('fn')) {
						warning = 1;
					}
				}
			);
			if (warning) {
				if (!confirm(lang['want_clone_file'])) {
					return false;
				}
			}
		}
	}
	function initUserTaskList() {
		$('.taskname').click(
			function() {
				var fName = $(this).data('fn');
				if (window[fName] instanceof Function) {
					writeln('=====================================\n\
Запуск "' + $(this).text() + '"\n=====================================\n');
					window[fName]();
				} else {
					showError(lang['function_named'] + fName + ' ' + lang['not_found'] + '. ' + lang['try_upload_yuor_file_again'] + '.');
				}
				return false;
			}
		);
		//remove
		$('.j-remove-task').click(
			function (evt){
				evt.preventDefault();
				function onTaskRemove() {
					window.location.href = window.location.href;
				}
				function onTaskFailRemove() {
					showError(lang['fail_remove_script_msg']);
				}
				if (confirm(lang['confirm_removal_script'])) {
					req({id:$(this).data('id')}, onTaskRemove, onTaskFailRemove, 'removeTask');
				}
			}
		);
		//update
		$('.j-update-task').click(
			function (evt){
				evt.preventDefault();
				$('#edit_id').val($(this).data('id'));
				$('#scriptDisplayName').val($(this).data('name'));
				appWindow('addScriptForm', lang['information'], null, false);
				/*function onTaskUpdate() {
					window.location.href = window.location.href;
				}
				function onTaskFailUpdate() {
					showError(lang['fail_remove_script_msg']);
				}
				req({id:$(this).data('id')}, onTaskRemove, onTaskFailRemove, 'removeTask');*/
			}
		);
	}
	/**
	 * @desc Страница просмотра вариатов
	*/
	function initTaskvariantsPage() {
		if (window.location.href.indexOf('/tasklist') != -1) {
			var h = getViewport().h - 76;
			$('.textcontent').first().height(h + 'px');
			$('.tasklist ul').first().height(h + 'px');
			//Загружает список файлов пользователя и инициализует диалог выбора файлов 
			var variant = Tool.aUrl()[2];
			variant = variant ? variant : 1;
				//Шаблоны
			var tplWrap = '<h4 class="left ts_h4" data-n="{N}">' + lang['Task'] + ' {N}</h4><div class="left ts_gr_buttons">{CONTENT}\
	</div>\
<div class="clearfix"></div>',
				tplLinkNew = '<a class="left ts_qbtn j-tsb-current" data-n="{N}" href="#">' + lang['Set_as_current'] + '</a>',
				tplLinkDone = '<a class="left ts_qbtn j-tsb-done" data-n="{N}" href="#">' + lang['Set_as_done'] + '</a>',
				tplSpanCurr = '<span class="left ts_qbtn_lock_push j-ts-curr" data-n="{N}">' + lang['State_current'] + '</span>',
				tplSpanDone = '<span class="left ts_qbtn_lock_push" >' + lang['State_done'] + '</span>' + 
								'<a class="left ts_qbtn" href="{LINK}">' + lang['View_decision'] + '</a>';
			
			function _loadFileList() {
				/**
				 * @desc
				*/
				function _setAsSelected() {
					var _id =  $(this).parent().parent().data('id'),
						arr = $('#tsfSelected').val().split(','), exists = 0;
					$(arr).each(
						function(i, id) {
							if (_id == id) {
								exists = 1;
							}
						}
					);
					if (!exists) {
						arr.push(_id);
						$('#tsfSelected').val( arr.join(',') );
					}
				}
				function _onLoadFileList(d) {
					$('.no_file').removeClass('hide').addClass('hide');
					if (d.status == 'ok') {
						$('#ts-br ul.js-br-files .file_view').each(
							function (i, item) {
								if (!$(item).hasClass('template')) {
									$(item).remove();
								}
							}
						);
						if (d.list) {
							var jTpl = $('#ts-br ul.js-br-files .template').first(), oTpl = jTpl[0], tpl = jTpl.html(), item, s = '';
							$(d.list).each(
								function (i, data) {
									s = tpl.replace(/\{id\}/g, data.id);
									s = s.replace('{name}', data.display_file_name);
									item = $('<li class="' + oTpl.className + '" data-id="' + data.id + '">' + s +  '</li>');
									item.removeClass('hide');
									item.removeClass('template');
									//item.find('.file-remove').click(showRemoveFileInput);
									//item.find('.file-rename').click(showRenameFileInput);
									item.find('input').change(_setAsSelected);
									$('#ts-br ul.js-br-files').first().append(item);
								}
							);
							appWindowClose();
							appWindow('qs-br-wrap', lang['Select_files']);
						} else {
							$('.no_file').removeClass('hide');
						}
						$('#tsBrDlgBg').addClass('hide');
						$('#tsBrLoader').addClass('hide');
					} else {
						showError(d.msg);
					}
				}
				req({forCompleteTask:1}, _onLoadFileList, defaultAjaxFail, 'loadUserFiles', WEB_ROOT + '/editor');
			}
			
			_loadFileList();
			$('#searchFileFilter')[0].onkeydown = filesFilter;
			/**
			 * @desc Скрыть файлы помеченнные как решенные и скрыть кнопку "Решено" для соотв. задачи
			*/
			function _onSaveSelectedFiles(data){
				$('#ts-br .file_view').each(
					function(i, li) {
						if ( $(li).find('input').first().prop('checked') ) {
							$(li).remove();
						}
					}
				);
				var taskId = $('#tsfTask').val();
				$('.j-tsb-done').each(
					function(i, a) {
						if ($(a).data('n') == taskId) {
							$(a).after( $(tplSpanDone.replace(/\{LINK\}/, WEB_ROOT + '/viewdecisions/' + variant + '/' + taskId)) );
							$(a).remove();
						}
					}
				);
				appWindowClose();
				$('.j-selected-files-filter-area').css('width', null);
			}
			$('#tsfSave').click(
				function() {
					var s = $.trim($('#tsfSelected').val()), task = $('#tsfTask').val();
					if (!s) {
						showError(lang['You_need_select_files']);
						return;
					}
					req({data:s, task:task, variant:variant}, _onSaveSelectedFiles, defaultAjaxFail, 'saveSelectedFiles');
				}
			);
			//append buttons
			/**
			 * @desc Добавляет кнопки действий рядом с заданиями
			*/
			function _onTaskStateData(data) {
				$('h4').each(
					function(i, h4) {
						var n = i + 1, s = tplWrap.replace(/\{N\}/g, n), inner = '', sSearch = '', aSearch = [];
						//получить строку с решенными пользователем задачами
						$(data.done_list).each(
							function(i, row) {
								aSearch.push(row.task);
							}
						);
						sSearch = ',' + aSearch.join(',') + ',';
						//Сформировать нужные кнопки
						if (n == data.current) {
							inner += tplSpanCurr.replace(/\{N\}/, n);
						} else {
							inner += tplLinkNew.replace(/\{N\}/, n);
						}
						if (sSearch.indexOf(',' + n + ',') == -1) {
							inner += tplLinkDone.replace(/\{N\}/, n);
						} else {
							inner += tplSpanDone.replace(/\{LINK\}/, WEB_ROOT + '/viewdecisions/' + variant + '/' + n);
						}
						s = s.replace('{CONTENT}', inner);
						$(h4).after( $(s) );
						$(h4).remove();
					}
				);
				$('.j-tsb-done').click(
					function() {
						$('#tsfTask').val( $(this).data('n') );
						appWindow('ts-br-wrap', lang['Select_files']);
						$('.j-selected-files-filter-area').css('width', $('.file-names-filter').width() + 'px');
						return false;
					}
				);
				function _onClickCurrentLink() {
					function _onSetAsCurrent(data) {
						var span = $('.j-ts-curr');
						if (span[0]) {
							var a = $(tplLinkNew.replace(/\{N\}/g, span.data('n')) );
							a.click( _onClickCurrentLink );
							span.after( a );
							span.remove();
						}
						$('.j-tsb-current').each(
							function(i, a) {
								a = $(a);
								if (a.data('n') == data.id) {
									a.after( $(tplSpanCurr.replace(/\{N\}/g, data.id) ) );
									a.remove();
								}
							}
						);
					}
					req({variant:variant, task:$(this).data('n')}, _onSetAsCurrent, defaultAjaxFail, 'setAsCurrent');
					return false;
				}
				$('.j-tsb-current').click( _onClickCurrentLink );
			}
			req({variant:variant}, _onTaskStateData, defaultAjaxFail, 'getUserTasks');
			
		}
	}
	/**
	 * 
	*/
	function initMainPage() {
		var _host = Tool.host(),
			s = $.trim(window.location.href.replace(/^\//, '').replace(/\/$/, ''));
		if (s == _host) {
			var h = getViewport().h - 39;
			$('.tasklist ul').first().height(h + 'px');
		}
	}
	/**
	 * @desc  Инициализация консоли
	 * */
	function initConsole() {
		window.writeln = function(s) {
			if (s == Infinity || (!s && s !== 0 && s !== '0')) {
				s = '';
			}
			s = String(s).replace(/\n/g, "<br>");
			$('#console').html( $('#console').html() + '<p>' + s + '</p>' );
			$('#console')[0].scrollTop = 1000000;
		}
		window.readln = function(msg) {
			writeln(msg);
			var s = prompt(msg, ''), n = parseFloat(s);
			writeln(s);
			if (n.toString() === s) {
				s = n;
			}
			return s;
		}
	}
	/**
	 * @desc А здесь можно будет что-то красивое и эффектное сделать при желании
	*/
	function showError(s) {
		alert(s);
	}
	/**
	 * @desc Обработка полученного текста задачи
	*/
	function _onTaskData(data) {
		var tmpDiv = '.tmp_task_text_div';
		if (data.msg) {
			showError(data.msg);
			return;
		}
		var div = $('<div class="hide ' + tmpDiv + '"></div>');
		$(document.body).append(div);
		div.html( data.html );
		$('#taskPlacePopUpContent').html('<div class="bg-rose no_has_task">' + lang['you_has_no_tasks'] + '</div>');
		div.find('h4').each(
			function(i, h4) {
				if (data.task == (i + 1)) {
					if (!data.popup) {
						$('#taskPlace').html( $(h4).parent().html() );
					} else {
						$('#taskPlacePopUpContent').html( $(h4).parent().html() );
					}
				}
			}
		);
		if (data.popup) {
			appWindow('taskPlacePopUpWrapper', lang['Your_task']);
		}
	}
	/**
	 * @desc Страница просмотра решений
	*/
	function initVewDecisionPage() {
		if (window.location.href.indexOf('viewdecisions/') == -1) {
			return;
		}
		/**
		 * @desc голосование
		*/
		function _onData(data) {
			if (data.status == 'ok') {
				$('.vdRating').each(
					function(i, span){
						if ($(span).data('id') == data.id) {
							$(span).text(data.v);
						}
					}
				);
			} else {
				showError(data.msg);
			}
		}
		function _sendChangeRating(){
			var obj = $(this), recId = obj.data('id'), sign = 1;
			if (obj.hasClass('decMinus')) {
				sign = -1;
			}
			req({id:recId, sign:sign}, _onData, defaultAjaxFail, 'vdrating');
		}
		$('.decMinus').click(_sendChangeRating);
		$('.incPlus').click(_sendChangeRating);
		function _loadTaskText() {
			var tmpDiv = '.tmp_task_text_div', aUrl = Tool.aUrl(), variant = aUrl[2], task = aUrl[3];
			variant = parseInt(variant);
			task = parseInt(task);
			if (variant && task) {
				$(tmpDiv).remove();
				req({variant:variant, task:task}, _onTaskData, defaultAjaxFail, 'getTask');
			}
		}
		_loadTaskText();
	}
	/**
	 * @desc Подгрузка задания пользователя при нажатии на пункт меню
	*/
	function initGetMyTask() {
		$('#getCurrentTask').click(
			function(){
				var tmpDiv = '.tmp_task_text_div';
				$(tmpDiv).remove();
				req({byUid:1}, _onTaskData, defaultAjaxFail, 'getTask', WEB_ROOT + '/viewdecisions/1/2');
				return false;
			}
		);
	}
	//================Авторизация=======================================
	/**
	 * @desc Формы логина и регистрации
	*/
	function initSigninButton() {
		$('#bSignin').click(
			function() {
				var o = $('#authForm');
				if (o.hasClass('hide')) {
					o.removeClass('hide');
					$('#login').focus();
				} else {
					o.addClass('hide');
				}
				return false;
			}
		);
		function _onSuccess(data) {
			if (data.success == 1) {
				window.location.reload();
			} else {
				showError(lang['user_not_found']);
			}
		}
		function _loginAction() {
			req({email:$('#login').val(), password:$('#password').val()}, _onSuccess, defaultAjaxFail, 'login', WEB_ROOT + '/login');
			return false;
		}
		$('#aop').click(_loginAction);
		$('#password').keydown(
			function (evt) {
				if (evt.keyCode == 13 && $.trim($('#password').val()).length > 0) {
					_loginAction();
				}
			}
		);
	}
	function initSignupButton() {
		function _onSuccess(data) {
			if (data.status == 'ok') {
				showError(data.sError);
				//window.location.reload();
				appWindowClose();
			} else {
				showError(data.sError);
			}
		}
		function showRegForm() {
			$('#authForm').addClass('hide');
			appWindow('regFormWrapper', lang['SignUp']);
			return false;
		}
		$("#regLink").click(showRegForm);
		$("#regLink2").click(showRegForm);
		$("#breg").click(
			function () {
				var pwd = $('#rpassword').val(), pwdC = $('#password_confirm').val(), email = $('#rlogin').val(),
					name = $('#uname').val(), sname = $('#usname').val(), data;
				if (pwd == pwdC && pwd.length && email.length) {
					data = {email:email, password:pwd, pc:pwdC, name: name, sname: sname};
					if ($('#regfstr')[0]) {
						data.regfstr = $('#regfstr').val();
					}
					req(data, _onSuccess, defaultAjaxFail, 'signup', WEB_ROOT + '/login');
				} else {
					showError(lang['email_required'] + ' ' + lang['and_password_required']);
				}
				//appWindowClose();
			}
		);
		$("#refimg").click(
			function(){
				$("#refimg").prop('src', '/programming_fundamentals/img/random?r=' + Math.random());
			}
		);
		function _checkStrongPassword(s) {
			$('#password_validate').removeClass('hide');
			if (/[A-Za-z]+/.test(s) && /[0-9A-Za-z]{6,111}/.test(s) && /[0-9]+/.test(s)) {
				$('#password_validate').removeClass('password_no_equ').addClass('password_equ').text(lang['strong_password']);
			} else {
				$('#password_validate').removeClass('password_equ').addClass('password_no_equ').text(lang['easy_password']);
			}
		}
		function _checkEquivPassword(s) {
			$('#password_equ').removeClass('hide');
			if (s == $('#rpassword').val()) {
				$('#password_equ').removeClass('password_no_equ').addClass('password_equ').text(lang['password_match']);
			} else {
				$('#password_equ').removeClass('password_equ').addClass('password_no_equ').text(lang['password_not_match']);
			}
		}
		$('#rpassword').keydown(
			function(){
				var o = this;
				setTimeout(
					function(){
						_checkStrongPassword(o.value);
					}
					,100
				);
			}
		);
		$('#password_confirm').keydown(
			function(){
				var o = this;
				setTimeout(
					function(){
						_checkEquivPassword(o.value);
					}
					,100
				);
			}
		);
	}
	//================/Авторизация======================================
	//================Комментарии=======================================
	function initComments() {
		function _v(id, v) {
			if (String(v) == 'undefined') {
				v = false;
			}
			if (v !== false) {
				$('#' + id).val(v)
			}
			if ($('#' + id)[0] && $('#' + id).val) {
				return $('#' + id).val();
			}
			return 0;
		} 
		/**
		 * 
		*/
		function _onSuccess(data) {
			hideLoader();
			if (data.status == 'error') {
				showError(data.msg);
				return;
			}
			appWindowClose();
			addTooltipMessage(lang['Your_comment_will_appear_after_accept']);
		}
		if ( ($('#addCommentBtn')[0] && $('#qsAddCommentForm')[0]) || $('#acceptMark')[0] ) {
			$('#addCommentBtn').click(
				function() {
					_v('cmTitle', '');
					_v('cmBody', '');
					_v('commentId', '');
					appWindow('qsAddCommentFormWrap', lang['Add_comment']);
					return false;
				}
			);
			$('.cmv_alink').click(
				function() {
					_v('cmTitle', '');
					_v('cmBody', '');
					_v('commentId', '');
					_v('parentId', $(this).data('id'));
					appWindow('qsAddCommentFormWrap', lang['Add_comment']);
					return false;
				}
			);
			$('#cmSendForm').click(
				function () {
					var data = {
						title:_v('cmTitle'),
						body:_v('cmBody'),
						parent:_v('parentId'),
						id:_v('commentId'),
						skey:_v('skey')
					};
					if ($('#commfstr')[0]) {
						data.commfstr = $('#commfstr').val();
					}
					showLoader();
					req(data, _onSuccess, defaultAjaxFail, 'addComment');
					return false;
				}
			);
			/**
			 * 
			*/
			function _onLoadCommentSuccess(data) {
				if (data.status == 'error') {
					showError(data.msg);
					return;
				}
				_v('cmTitle', data.title);
				_v('cmBody', data.body);
				_v('commentId', data.id);
				hideLoader();
				appWindow('qsAddCommentFormWrap', lang['Edit_comment']);
			}
			function _onLoadCommentAccept(data) {
				$('#qsCmList li[data-id=' +  data.id + ']').remove();
			}
			$('.cmv_elink').click(
				function() {
					var data = {id:$(this).data('id')};
					req(data, _onLoadCommentSuccess, defaultAjaxFail, 'getComment');
					return false;
				}
			);
			
			$('.cmv_acceptlink').click(
				function() {
					var data = {id:$(this).data('id')};
					req(data, _onLoadCommentAccept, defaultAjaxFail, 'acceptComment');
					return false;
				}
			);
		}
		//кнопка показать скрыть комментарии
		if (!$('#acceptMark')[0]) {
			$('#qsCmList').hide();
		}
		$('#comments_title').click(
			function() {
				if ( $('#qsCmList').css('display') == 'none' ) {
					$('#qsCmList').slideDown(500);
					setTimeout(
						function() {
							$('#article').animate({
								//'scrollTop': $('#article')[0].scrollTop + parseInt($('#qsCmList')[0].offsetHeight / 3, 10)
							})
						}
						,150
					);
					
					$('#article').animate({
						'scrollTop': '+=200',
					}, 'slow')
					
				} else {
					$('#qsCmList').slideUp(500);
				}
			}
		);
	}
	//===============/Комментарии=======================================
	
	function initScrollSaver() {
		var current = window.location.href, key = 'savedUrl', saved = localStorage.getItem(key), n, url;
		if ( current.indexOf('?') > current.indexOf('#') ) {
			n = '?';
		} else {
			n = '#';
		}
		url = current.split(n)[0];
		if (current == saved) {
			n = localStorage.getItem(url);
			if (n) {
				$('#article').prop('scrollTop', n);
			}
		}
		localStorage.setItem(key, current);
		if ($('#article')[0]) {
			$('#article')[0].onmousewheel = function () {
				localStorage.setItem(url, $('#article').prop('scrollTop') );
			}
		}
	}
	//ajax helper
	function req(data, success, fail, id, url, method) {
		if (!method) {
			method = 'post';
		}
		data.xhr = 1;
		data.action = id;
		$.ajax({
			dataType:'JSON',
			data:data,
			method:method,
			url:(url ? url : window.location.href),
			success:success,
			error:fail
		});
	}
	function defaultAjaxFail() {
		hideLoader();
		showError(lang['default_error']);
	}
	//====================Ресурсы=======================================
	function initResourcesPage() {
		if ( $('#uploadResShowForm')[0] ) {
			$('#uploadResShowForm').click(
				function() {
					appWindow('addResourceFormWrapper', lang['upload_resource_title']);
				}
			);
			
			$('#btnSearchRes').click(
				function() {
					$('#resFormFilter')[0].submit();
				}
			);
			$('.j-upres').click(
				function() {
					var id = $(this).data('id'),
						name = $(this).data('name');
					$('#res_edit_id').val(id);
					$('#resDisplayName').val(name);
					appWindow('addResourceFormWrapper', lang['update_resource_title']);
				}
			);
			function _onSuccesDelete() {
				window.location.reload();
			}
			$('.j-remres').click(
				function() {
					var id = $(this).data('id');
					if (confirm(lang['confirm_removal_resource'])) {
						req({id:id}, _onSuccesDelete, defaultAjaxFail, 'delete');
					}
				}
			);
			$('.j-taselall').click(
				function() {
					$(this).select();
				}
			);
			$('#addResourceForm')[0].onsubmit = function() {
				if ($('#resFile')[0].files[0].size > 5 * 1024*1024) {
					showError(lang['file_too_big']);
					return false;
				}
			}
		}
	}
	//====================/Ресурсы======================================
})(jQuery)
