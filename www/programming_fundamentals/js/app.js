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
			initSampleTextEditor();
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
			lastTimeLoadFileClick = 0;
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
				} else {
					alert('Fucking Fuck');
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
		//Инициализация
		$(mid).keydown(onKeyDown);
		$(mid).keyup(onKeyUp);
		$(mid).click(showTextCursorCoord);
		$('#scriptFileQsButton').click(sendSaveAs);
		$('#qsEditorSaveAs').click(showSaveAs);
		$('#qsEditorOpenFile').click(showOpenFileDlg);
		$('#qsEditTitleSaveBtn').click(sendRenameFile);
		if (localStorage.getItem('qsLastText')) {
			$(mid).val( localStorage.getItem('qsLastText') );
			setMenuIconState() ;
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
	}
//============ / Простой редактор кода===================================
//====== Словарь кейвордов
	function initKeywordsHelp() {
	}
//====== /Словарь кейвордов
	
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
			if (s === null) {
				s = '';
			}
			s = s.replace(/\n/g, "<br>");
			$('#console').html( $('#console').html() + '<p>' + s + '</p>' );
			$('#console')[0].scrollTop = 1000000;
		}
		window.readln = function(msg) {
			writeln(msg);
			var s = prompt(msg, '');
			writeln(s);
			return s;
		}
	}
	/**
	 * @desc А здесь можно будет что-то красивое и эффектное сделать при желании
	 * */
	function showError(s) {
		alert(s);
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
})(jQuery)
