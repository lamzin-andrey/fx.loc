(function ($, undefined) {
	var guid = '';
	var lang = window.appLang;
	$(document).ready(
		function(){
			initGuid();
			initConsole();
			initUserTaskList();
			initWinFunctions();
			initTooltipFunctions();
			initKeywordsHelp();
			//initStdFuncsHelp();
			initSampleTextEditor();
			initSigninButton();
			initSignupButton();
		}
	);
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
	function initSampleTextEditor()  {
		var mid = '#qs_editor_s',
			fileId = -1,
			fileDisplayName = '',
			lastTimeLoadFileClick = 0,
			maxEditorHeight = false,
			enableFunctions = false,
			ContentFunctions = {globals:{}},
			DefaultContentFunctions = {globals:{}};
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
			lines(s, res.y);
			return {p:p, s:s};
		}
		function lines(s, n){
			var total = s.split('\n').length, i = 0,
				div = $('#qseLines'), css;/*, exists = div.find('.qse_l').length;*/
			div.html('');
			for (i; i < total; i++) {
				if ((i + 1) == n) {
					css = 'qse_l qse_la';
				} else {
					css = 'qse_l';
				}
				div.append( $('<div class="' + css + '">' + (i + 1) + '</div>') );
			}
			//console.log('total = ' + total + ', exists = ' + exists);
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
			//console.log();
			$('#qseLineWrapper').css('max-height', ($('#qs_editor_s').height() + 5) + 'px');
			$('#qseLines')[0].style.top = (-1 * $('#qs_editor_s')[0].scrollTop) + 'px';
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
						} else {
							ta.focus();
						}
						setMenuIconState();
					}
					, 10
				);
				return true;
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
					//console.log('j = ' + j + ', pos = ' + pos);
					for (i = j; i < pos; i++) {
						if (s.charAt(i) == '\t' || s.charAt(i) == ' ') {
							spaces += s.charAt(i);
						} else {
							break;
						}
					}
					//console.log('sp = "' + spaces + '"');
					q = s.substring(0, pos);
					tail = s.substring(pos, s.length);
					s = q + "\n" + spaces + tail;
				} else {
					s += "\n";
				}
				ta.value = s;
				setCaretPosition(ta, pos + 1 + spaces.length);
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
					//console.log('j = ' + j + ', pos = ' + pos);
					for (i = j; i < pos; i++) {
						spaces += s.charAt(i);
					}
					//console.log('sp = "' + spaces + '"');
					q = s.substring(0, pos);
					tail = s.substring(pos, s.length);
					
					s = q + "\n" + spaces + tail;
				} else {
					s += "\n";
				}
				ta.value = s;
				setCaretPosition(ta, pos + 1 + spaces.length);
				return false;
			} else if (e.keyCode == 83 && e.ctrlKey == true) {//Ctrl + S
				saveNow();
				return false;
			}
			else {
				//console.log(e);
				setTimeout(
					function () {
						setMenuIconState();
						var data = showTextCursorCoord();
						showCodeHint(data);
					}
					, 10
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
				eval('(' + $(mid).val() + ')()');
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
		function sendSaveAs() {
			if(!guid && !uid) {
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
						if (d.status == 'ok') {
							var obj = $('#titlefile-' + d.id)[0];
							if (obj) {
								$(obj).parents('.file_view').first().remove();
							}
						} else {
							showError(msg);
						}
					}
					var obj = $(this), id;
					if (id = parseInt(obj.data('id'))) {
						if (confirm(lang["confirm_removal_script"])) {
							$('#qsBrDlgBg').removeClass('hide');
							$('#qsBrLoader').removeClass('hide');
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
					buildFunctionList();
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
			$('.file-names-filter').attr('style', null);
			appWindow('qs-br-wrap', lang['Openfile']);
			setTimeout(
				function() {
					var obj = document.getElementById('appWindowPopup');
					if (obj) {
						$('#qsBrLoader').css('top', Math.round((obj.offsetHeight - 66)/ 2)).css('left', Math.round((obj.offsetWidth -66)/ 2));
						$('.file-names-filter').css('width', (obj.offsetWidth - 1) + 'px');
					}
				}, 10
			);
			//init serach field
			$('#searchFileName')[0].onkeydown = function () {
				function isFileItem(li) {
					if (li.hasClass('file_view template') || li.hasClass('no_file')) {
						return false;
					}
					return true;
				}
				
				var inp = this;
				setTimeout(
					function() {
						var s = inp.value;
						if (s.length) {
							$('.js-br-files li').each(
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
							$('.js-br-files li').each(
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
		//плюшки для редактора
		/**
		 * @desc строит список функций, встречающихся в открытом файле
		*/
		function buildFunctionList() {
			var s = $(mid).val(),
				re = /function\s+[A-z0-9]+\s*\([A-z0-9,'" ]*\)/gi,
				data = s.match(re), cName, fName;
			//console.log(data);
			
			ContentFunctions = {};
			for (cName in DefaultContentFunctions) {
				ContentFunctions[cName] = {}
				for (fName in DefaultContentFunctions[cName]) {
					ContentFunctions[cName][fName] = {
						name:DefaultContentFunctions[cName][fName].name,
						src:DefaultContentFunctions[cName][fName].src,
					};
					for (var k = 0; k < DefaultContentFunctions[cName][fName].args.length; k++) {
						ContentFunctions[cName][fName].args.push( DefaultContentFunctions[cName][fName].args[k] );
					}
				}
			}
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
					//console.log(args);
					if (args.length) {
						arr = args.split(',');
						$(arr).each(
							function(i, q) {
								q = $.trim(q);
								if (q) {
									o.args.push(q);
								}
							}
						);
					}
					ContentFunctions.globals[o.name] = o;
				}
			);
			//console.log(ContentFunctions);
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
				if (cName != 'globals') {
					container = addContentClassInList(cName);
				}
				for (fName in ContentFunctions[cName]) {
					container.append( $('<li><a href="#" onclick="SiEd.gotoFunctionOnEditor(\'' + fName + '\'); return false;">' + fName + '</a></li>') );
				}
			}
		}
		/**
		 * Возвращает ссылку на элемент списка, для построения дерева
		 * */
		function addContentClassInList(cName) {
			return $('#functionlist'); //TODO заглушку убрать
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
					//console.log(caretPos);
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
					//console.log(fName);
					for (cName in ContentFunctions) {
						for (name in ContentFunctions[cName]) {
							if (name == fName && ContentFunctions[cName][name].args.length) {
								//console.log('found');
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
		$('#qsEditorSaveAs').click(showSaveAs);
		$('#qsEditorOpenFile').click(showOpenFileDlg);
		$('#qsEditTitleSaveBtn').click(sendRenameFile);
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
		$(mid).bind('mousewheel', showTextCursorCoord);
		/*setInterval(
		 function() {
			 showTextCursorCoord();
		 },10
		);*/
		//высота редактора на странице text_editor
		if (window.location.href.indexOf('/text_editor') != -1) {
			enableFunctions = true;
			maxEditorHeight = getViewport().h - 130;
			$('#qs_editor_s').height(  maxEditorHeight + 'px' );
			$('#qseLineWrapper').height( ($('#qs_editor_s').height() + 5) + 'px');
			showTextCursorCoord();
			var w;
			if (w = localStorage.getItem('editorWidth')) {
				$('#textEditorArea').width(w)  + 'px'; 
			}
		}
	}
//============ / Простой редактор кода==================================

//===========Словари и подсветка для подсказок на страницах статей======
//====== Словарь кейвордов  и стандартных функций
	function initKeywordsHelp() {
		/**
		 * @desc Загрузить слова из специального раздела на странице
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
		 * @desc Подсветка синтаксиса для текста в всплывающем окне
		 * @see initKeywordsHelp, initStdFuncsHelp
		 * @param keyMap - карта слов требующих подсветки в виде массива, получена во время работы  _getKeyMap
		 * @param sKeys  - специальная строка с ключевыми словами, требующими подсветки, результат _getKeyMap
		 * @param sKeysSF - специальная строка с именами стандартных функций , результат _getKeyMap
		 * 
		*/
		function _highlightWordsInHelp(keyMap, sKeys, sKeysSF) {
			var i, j,content, saveContent, list, buf;
			for (i in keyMap) {
				saveContent = content = keyMap[i];
				content = content.replace(/\\"/mig, 'SLASHED_D_QUOTES');
				content = content.replace(/\s?"([^"]*)"/mig, '<span class="strcolor"> "$1"</span>');
				content = content.replace(/SLASHED_D_QUOTES/mig, '\\"');
				content = content.replace(/\\\//mig, 'SLASHED_D_QUOTES');
				copy = content;
				content = content.replace(/(\/[^\/]+\/[mig]{1,3})/mig, '<span class="recolor"> $1 </span>');
				if (copy == content) {
					content = content.replace(/(\/[^\/]+\/)[^\/]]*$/mig, '<span class="recolor"> $1 </span>');
				}
				content = content.replace(/SLASHED_D_QUOTES/mig, '\\/');
				content = content.replace(/\s?'([^']*)'/mig, '<span class="strcolor"> \'$1\'</span>');
				content = content.replace(/\s?\/\/([^\n]+)\n?$/mig, '<span class="strcolor">//$1</span>\n');
				content = content.replace(/\/\*([^*]*)\*\//mig, '<span class="strcolor">/*$1*/</span>');
				list = content.split('\n');
				buf = [];
				for (j = 0; j < list.length; j++) {
					if (list[j].length) {
						buf.push(' QSTAB ' + list[j]);
					}
				}
				content = 'function ' + i + 'Example() { QSNEW_LINE ' + buf.join(' QSNEW_LINE ') + ' QSNEW_LINE }';
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
						//console.log(window.infoMessages);
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
		$("#regLink").click(
			function () {
				$('#authForm').addClass('hide');
				appWindow('regFormWrapper', lang['SignUp']);
			}
		);
		$("#breg").click(
			function () {
				var pwd = $('#rpassword').val(), pwdC = $('#password_confirm').val(), email = $('#rlogin').val(),
					name = $('#uname').val(), sname = $('#usname').val();
				if (pwd == pwdC && pwd.length && email.length) {
					req({email:email, password:pwd, pc:pwdC, name: name, sname: sname}, _onSuccess, defaultAjaxFail, 'signup', WEB_ROOT + '/login');
				} else {
					showError(lang['email_required'] + ' ' + lang['and_password_required']);
				}
				//appWindowClose();
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
	//================/Авторизация=======================================
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
		showError(lang['default_error']);
	}
})(jQuery)
