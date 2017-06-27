var abcIsInitalize = 0;
var Map = [];
function initAbc(p, obj){
	var s;
	s = '012 3456789\n\r?!,.абвгдеёжзийклмнопрстуфхцчшщъыьэюяЙЦУКЕНГФЫВАПРОЛДЖЭЯЧСМИТЬБЮШЩЗХЪasdfghjklzxcvbnm-+qwertyuiopZXCVBNMASDFGHJKLQWERTYUIOP():/`=*[]\;\'\t~@#$%^&_{}|"<>№';
	if (abcIsInitalize) {
		obj.abc = s;
		obj.m = Map;
		return;
	}
    var i, j, m = [], v, b, k;
    
    if (!validPassword(p, s)) {
        Error("Invalid password");
    }
    for(i = 0; i < s.length; i++){
        m[i] = i;
    }
    j = 0;
    for(i = 0; i < s.length; i++){
        if (j > p.length - 1) {
            j = 0;
        }
        ch = p.charAt(j);   //символ пароля
        di = s.indexOf(ch); //позиция в исходном алфавите
        dI = m[di];			//позиция в новом алфавите
        
        I = m[i];			//позиция символа исходного алфавита в новом алфавите
        v = I + dI;			//новая позиция в новом алфавите
        v = v > s.length  - 1 ? v - s.length  : v;
        
        k = arrIndexOf(m, v);	//В каком элементе m сейчас находится v (какой символ старого алфавита в позиции v?) 
        m[i] = v;
        m[k] = I;
        j++;
    }
    obj.abc = s;
    Map = m;
    obj.m = m;
    abcIsInitalize = 1;
}
function arrIndexOf(arr, v) {
	for(var i = 0; i < arr.length; i++) {
		if (arr[i] == v) {
			return i;
		}
	}
	return -1;
}
function validPassword(p, sAbc) {
	for (var i = 0; i < sz(p); i++) {
		if (!~sAbc.indexOf( p.charAt(i) )) {
			return false;
		}
	}
	return true;
}
function decrypt(s, p) {
	//writeln('Start decrypt');
    s = s.split(';');
    var sz, i, j = 0, xh, cc, r = '', m, L, b, ival = {}, isN;
	initAbc(p, ival);
    for(i = 0; i < s.length; i++){
        j = j < p.length ? j : 0; 
        cc = String(charCode(p, j, ival));
        //writeln('get cc = ' + cc);
        cc = cc.replace('n', '');
        xh = s[i];
        //writeln('get xh = ' + xh);
        if (xh.charAt(0) == 'n') {
			isN = 1;
			xh = xh.replace('n', '');
		} else {
			isN = 0;
		}
		//console.log(fromCharCode(xh, isN, ival));
		//writeln('isN = ' + isN);
		xh = +xh;
		cc = +cc;
        m = xh - cc;
        L = getLimit(xh, ival, isN);
        b = ival.b;
        //writeln('L = ' + L + ', b = ' + b + ', m = ' + m);
        if (m < b) {
			m = L - Math.abs(m - b);
			xh = m;
		} else {
			//writeln('It here');
			xh = m;
		}
        //xh = String.fromCharCode(xh);
        xh = fromCharCode(xh, isN, ival);
        r += String(xh);
        j++;
    }
    return  r;
} 

function crypt(s, p) {
    var sz, i, j = 0, xh, cc, r = [], m, ival = {}, L, b, isN;
    initAbc(p, ival);
    for(i = 0; i < s.length; i++){
        //xh = s.charCodeAt(i);
        xh = String(charCode(s, i, ival));
        if (xh.charAt(0) == 'n') {
			isN = 1;
			xh = xh.replace('n', '');
		} else {
			isN = 0;
		}
		xh = +xh;
//		writeln('xh = ' + xh);
        j = j < p.length ? j : 0;
        cc = String( charCode(p, j, ival) );
//    	writeln('cc = ' + cc);
        cc = cc.replace('n', '');
        cc = +cc;
        m = xh + cc;
        getLimit(m, ival, isN);
        L = ival.L;
//        writeln('L = ' + L);
//        writeln('b = ' + ival.b);
        b = ival.b;
		if (m > L) {
			xh = b + m - L;
//			writeln('m>L, xh = ' +  xh);
		} else {
			xh = m;
//			writeln('m<=L, xh = ' +  xh);
		}
		if (isN) {
			xh = 'n' + xh;
		}
        r.push(xh);
        j++;
    }
    return r.join(';');
}
function fromCharCode(c, isN, o) {
	if (isN) {
		return String.fromCharCode(c);
	}
	var n = arrIndexOf(o.m, c - 1);
	return o.abc.charAt(n);
}
function charCode(s, i, ival) {
	var j, k, b, abc = ival.abc;
	j = abc.indexOf(s.charAt(i));
	if (~j) {
		j = ival.m[j];
		return (j + 1);
	}
	return 'n' + s.charCodeAt(i);
}
function getLimit(m, o, isNative) {
	if (isNative) {
		return getLimitN(m, o);
	}
	o.L = o.abc.length;
	o.b = 1;
	return o.L;
}
function getLimitN(m, o) {
	var C = [9, 125, 1025, 1103], L, b;
	if (m > C[0] && m < C[1]) {
		L = C[1];
		b = C[0];
	} else if(m >= C[2] && m <= C[3]){
		L = C[3];
		b = C[2];
	} else {
		L = 1000000;
		b = 0;
	}
	o.L = L;
	o.b = b;
	return L;
}
//-------------

//controller
//window.onload = init;
document.addEventListener('deviceready', init, false);
function init() {
	alert('RUN');
	//все скрины в div.screenWrapper
	window.W = window;
	window.D = document;
	W.root = '';
	W.app = {L:'лопата'};
    if (W.uid){
		alert('Ye, it uid = ' + W.uid);
        hideScreens();
        alert('after hideScr()');
        /*show(hRepeatPwdScreen);
        alert('after show()');*/
    }
    repeatPwdBtn.onclick = onRP;
    mainForm.onsubmit = onMainSubmit;
    /** @var HtmlInput iBody текстовое поле  */
    /** @var HtmlInput iTitle Тайтл письма   */
    /** @var HtmlInput iRepeatPwd Ввод пароля при перезагрузки страницы авторизованным пользователем  */
    /** @var HtmlInput iCurrentPostId идентификатор текущего поста  */    
    /** @var HtmlInput iLogin Форма регистрации, поле ввода логина  */
    /** @var HtmlInput iPwd   Форма регистрации, поле ввода пароля  */
    /** @var HtmlInput iPwdConfirm Форма регистрации, поле повтора пароля */
    /** @var HtmlInput iAgree Форма регистрации, чекбокс согласия с условиями использования сайта*/
    
    /** @var HtmlDivElement hError блок с сообщением об ошибке */
    /** @var HtmlDivElement hErrorText Сообщение об ошибке     */
    /** @var HtmlDivElement hMessage блок с сообщением         */
    /** @var HtmlDivElement hMessageText Сообщение             */
    
    /** @var HtmlDivElement hViewPostScreen блок всех элементов связанных с просмотром поста*/
    /** @var HtmlDivElement hEditPostScreen блок всех элементов связанных с созданием / редактированием поста*/
    /** @var HtmlDivElement hSignUpScreen блок всех элементов связанных с регистрацией пользователя */
    /** @var HtmlDivElement hSignInScreen блок всех элементов связанных с логином пользователя */
    /** @var HtmlDivElement hRepeatPwdScreen блок всех элементов связанных с повторным вводом пароля пользователем после перезагрузки страницы */
    /** @var HtmlDivElement hNovelScreen блок всех элементов связанных с экраном-заглушкой */
    
    /** @var HtmlDivElement hPostTextView  статичный текст поста */
    /** @var HtmlDivElement hPostTitleView статичный тайтл поста */
    
    nextPostBtnBtm.onclick = nextPostBtn.onclick = onNextPost;
    newPostBtn.onclick = onNewPost;
    //viewPostBtn.onclick = onViewPost;//TODO
    editPostBtnBtm.onclick = editPostBtn.onclick = onEditPost;
    registerNowBtn.onclick = onRegisterNowClick;
    sendRegisterDataBtn.onclick = onSendRegisterDataClick;
    signInBtn.onclick = onSignInClick;
    textCommentBtn.onclick = onSendCommentClick;
    //history.pushState(null, null, '/c/');
    W.onpopstate =  onBackButton;
}
function onNewPost() {
	iCurrentPostId.value = 0;
	hideScreens();
	iTitle.value = '';
	iBody.value = '';
	show(hEditPostScreen);
}
function onBackButton(evt) {
	evt.preventDefault;
	hideScreens();
	show(hNovelScreen);
	success('Ваш комментарий появитсья после проверки модератором');
	W.scrollTo(0, 0);
}
function onSendCommentClick() {
	hideScreens();
	show(hNovelScreen);
	setTimeout(function(){
		success('Ваш комментарий появится после проверки модератором');
		W.scrollTo(0, 0);
	}, 3 * 1000);
	return false;
}
function onSignInClick() {
	var o = {'iLlogin':1, 'iLpwd':1};
	_map(o, 1);
	W.app.pwd = o.iLpwd;
	_post(o, onSuccessLogin, '/signin.php');
	return false;
}
function onSuccessLogin(data) {
	if (!data.error) {
		W.password = W.app.pwd;
		if (data.id > 0) {
			postDataDoneHandler(data);
		} else {
			hideScreens();
			show(hEditPostScreen);
			success(data.message);//Напишите свой первый пост
		}
	} else {
		W.scrollTo(0, 0);
		error(data.error);
	}
}
function onSendRegisterDataClick() {
	var o = {'iLogin':1, 'iPwd':1, 'iPwdConfirm':1, 'iAgree':1}; 
	_map(o, 1);
	app.pwd = o.iPwd;
	_post(o, onSendRegisterData, '/signup.php');
	return false;
}
function onSendRegisterData(data) {
	if (!data.error) {
		success(data.message);
		setTimeout(function(){
			hideScreens();
			iCurrentPostId.value = 0;
			W.password = app.pwd;
			success('Создайте свою первую запись');
			show(hEditPostScreen);
		}, 5 * 1000);
	} else {
		error(data.error);
	}
}
function onRegisterNowClick() {
	hideScreens();
	show(hSignUpScreen);
	W.scrollTo(0, 0);
	return false;
}
function onEditPost() {
	hideScreens();
	show(hEditPostScreen);
}
function onNextPost() {
	var id = iCurrentPostId.value;
	id = id ? id : 0;
	_get(postDataDoneHandler, '/nextpost.php?id=' + id);
}
function onMainSubmit() {
	var o = {'iBody':1, 'iTitle':1, 'iCurrentPostId':1};
	_map(o, 1);
	try {
		o.iBody = crypt(W.app.L + o.iBody, W.password);
	} catch(e) {
		if (e.message == 'Invalid password') {
			error("Пароль содержит недопустимые символы");
			throw e;
		} else {
			throw e;
		}
	}
	try {
		o.iTitle = crypt(o.iTitle, W.password);
	} catch(e) {
		if (e.message == 'Invalid password') {
			error("Пароль содержит недопустимые символы");
			throw e;
		} else {
			throw e;
		}
	}
	_post(o, onSaveEditFormDataUserAction, '/post.php');
	return false;
}
function onSaveEditFormDataUserAction(data) {
	postDataDoneHandler(data);
}
/**
 * @description Нажатие на кнопке Надо ввести пароль для продолжения
 */
function onRP() {
	W.password = iRepeatPwd.value;
	_get(onGetLastPost, '/lastpost.php');
	return false;
}
function onGetLastPost(data){
	postDataDoneHandler(data);
}

//- end controller

//-- View --
/**
 * @description Устанавливает данные поста в форму и read-only  представлениек поста
*/
function postDataDoneHandler(data) {
	if (!data.error) {
		var isValidData = setCurrentPostData(data.id, data.text, data.title);
		if (isValidData) {
			hideScreens();
			show(hViewPostScreen);
			if (data.message) {
				success(data.message);
			}
		} else {
			Map = [];
			abcIsInitalize = 0;
			error('Неверный пароль!');
		}
	} else {
		if (data.state && data.state == 'showform') {
			hideScreens();
			show(hEditPostScreen);
		} else {
			error(data.error);
		}
	}
}
function error(s) {
	hide(hMessage);
	if (s.length > 0) {
		hErrorText.innerText = s;
		show(hError);
	} else {
		hide(hError);
	}
}
function success(s) {
	hide(hError);
	if (s.length > 0) {
		hMessageText.innerText = s;
		show(hMessage);
	} else {
		hide(hMessage);
	}
}
function setCurrentPostData(id, body, title){
	var v = '';
	try {
		v = decrypt(body, W.password);
	} catch(e) {
		if (e.message == 'Invalid password') {
			error("Пароль содержит недопустимые символы");
			throw "e";
		} else {
			throw e;
		}
	}
	if (v.indexOf(W.app.L) === 0) {
		iBody.value = D.getElementById('hPostTextView').innerHTML  = v.replace(W.app.L, '');
		try {
			iTitle.value = D.getElementById('hPostTitleView').innerHTML = decrypt(title, W.password);
		} catch(e) {
			if (e.message == 'Invalid password') {
				error("Пароль содержит недопустимые символы");
				throw e;
			}
		}
		iCurrentPostId.value = id;
		
		D.getElementById('hPostTextView').innerHTML = '<p>' + D.getElementById('hPostTextView').innerHTML.replace(/\n/mig, '</p><p>') + '</p>';
		D.getElementById('hPostTitleView').innerHTML = '<p>' + D.getElementById('hPostTitleView').innerHTML.replace(/\n/mig, '</p><p>') + '</p>';
		
		return true;
	}
	return false;
}
function hideScreens() {
	var ls = D.getElementsByClassName('screenWrapper'), i, scr;
	alert('Found ' + sz(ls) + ' screens...');
	for (i = 0; i < sz(ls); i++) {
		scr = $$(ls[i], 'div')[0];
		if (scr.tagName == 'DIV') {
			alert('Will hide src ' + scr.id);
			hide(scr);
		}
	}
}
//- end View

//=================AJAX HELPERS=========================================
function  _map(data, read) {
	var $obj, obj, i;
	for (i in data) {
		$obj = $(i);
		//obj = $obj[0];
		obj = $obj;
		if (obj) {
			if (obj.tagName == 'INPUT' || obj.tagName == 'TEXTAREA') {
				if (!read) {
					obj.value = data[i];
				} else {
					if (obj.type == 'checkbox') {
						data[i] = obj.checked;
					} else {
						data[i] = obj.value;
					}
				}
			} else {
				if (!read) {
					if (obj.type == 'checkbox') {
						var v = data[i] == 'false' ? false: data[i];
						v = v ? true : false;
						obj.checked = v;
					} else {
						obj.innerText = data[i];
					}
				} else {
					data[i] = obj.innerText;
				}
			}
		}
	}
}
function _get(onSuccess, url, onFail) {
	_restreq('get', {}, onSuccess, url, onFail)
}
function _delete(onSuccess, url, onFail) {
	_restreq('post', {}, onSuccess, url, onFail)
}
function _post(data, onSuccess, url, onFail) {
	var list = document.getElementsByTagName('meta'), i, t;
	for (i = 0; i < list.length; i++) {
		if (attr(list[i], 'name') == 'app') {
			t = attr(list[i], 'content');
			break;
		}
	}
	if (t) {
		data._token = t;
		_restreq('post', data, onSuccess, url, onFail)
	}
}
function _patch(data, onSuccess, url, onFail) {
	_restreq('patch', data, onSuccess, url, onFail)
}
function _put(data, onSuccess, url, onFail) {
	_restreq('put', data, onSuccess, url, onFail)
}
function _restreq(method, data, onSuccess, url, onFail) {
	/*$('#preloader').show();
	$('#preloader').width(screen.width);
	$('#preloader').height(screen.height);
	$('#preloader div').css('margin-top', Math.round((screen.height - 350) / 2) + 'px');
	*/
	if (!url) {
		url = window.location.href;
	} else {
		url = W.root + url;
	}
	if (!onFail) {
		onFail = defaultFail;
	}
	switch (method) {
		case 'put':
		case 'patch':
		case 'delete':
			break;
	}
	/*$.ajax({
		method: method,
		data:data,
		url:url,
		dataType:'json',
		success:onSuccess,
		error:onFail
	});*/
	pureAjax(url, data, onSuccess, onFail, method);
}


/**
 * @desc Аякс запрос к серверу, заменен на работу с localStorage
*/
function pureAjax(url, data, onSuccess, onFail, method) {
	url = url.split('?')[0];
	switch (url) {
		case '/lastpost.php':
			data = getLastPost();
			onSuccess(data);
			break;
		case '/post.php':
			data = savePost(data);
			onSuccess(data);
			break;
		case '/nextpost.php':
			data = getNextPost();
			onSuccess(data);
			break
	}
}

//=============Альтернатива серверу =================================
var posts = 'posts',
	postOffest = 1;
function getLastPost() {
	var data = storage(posts);
	if (!data || !data.length) {
		return {'state': 'showform', 'error': 1};
	}
	return data[data.length - 1];
}
function savePost(data) {
	var aData = storage(posts);
	aData = aData || [];
	data = {id:data.id, text:data.iBody, title:data.iTitle};
	aData.push(data);
	storage(posts, aData);
	return data;
}
function getNextPost() {
	var data = storage(posts);
	if (!data || !data.length) {
		data = [];
	}
	postOffest++;
	if (data[data.length - postOffest]) {
		return data[data.length - postOffest];
	}
	return {error: 'Вы уже редактируете самую раннюю запись'};
}
//===================================================================


function defaultFail(data) {
	W.requestSended = 0;
	error('Не удалось обработать запрос, попробуйте снова');
}
//========Local Storage ==============
/**
 * @description Индексирует массив по указанному полю
 * @param {Array} data
 * @param {String} id = 'id'
 * @return {Object};
*/
function storage(key, data) {
	var L = window.localStorage;
	if (L) {
		if (data === null) {
			L.removeItem(key);
		}
		if (!(data instanceof String)) {
			data = JSON.stringify(data);
		}
		if (!data) {
			data = L.getItem(key);
			if (data) {
				try {
					data = JSON.parse(data);
				} catch(e){;}
			}
		} else {
			L.setItem(key, data);
		}
	}
	return data;
}
