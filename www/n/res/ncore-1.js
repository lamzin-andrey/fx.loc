function NCore() {
	var dBtn = d.createElement('input');
	dBtn.type = 'button';
	dBtn.value = 'Reload dev res';
	dBtn.onclick = function() {
		localStorage.removeItem('nlib-1');
		localStorage.removeItem('ncore-1');
		window.location.href = window.location.href;
	};
	try {
		document.documentElement.requestFullScreen();
	} catch(E) {
		var h = screen.height;
		$('div').each(function(i, j) {
			try {
				d.body.removeChild(j);
			}catch(R){}
		});
		h = h > 240 && h < 320 ? 320 : h;
		h = h < 240 ? 240 : h;
		$(d.body).append($('<div id="main" style="border:1px blue solid; min-height:' + h + 'px;"></div>'));
		main.appendChild(dBtn);
		
		w.onscroll = hideScrollBar;
		setInterval(hideScrollBar, 1000);
		
		function hideScrollBar() {
			if (w.scrollY <= 0) {
				hideAndroidBrowserUrlBar();
			}
		}
		
		
			
		hideAndroidBrowserUrlBar();
		
		if (isAndroidBrowserv2()) {
			//offSwypeActions();
		}
		//m(w.navigator.userAgent);
		/*setInterval(function(){
			m('h = ' + screen.height + ', Top = ' + w.scrollY);
		}, 1000);*/
		
		function isAndroidBrowserv2() {
			if (~w.navigator.userAgent.indexOf('Android 2.')) {
				return true;
			}
			return false;
		}
		function hideAndroidBrowserUrlBar() {
			d.body.style['min-height'] = screen.height + 'px';
			w.scrollTo(0, 1);
		}
	}
	
	/*function offSwypeActions() {
		$('div').each(function(i, j) {
			try {
				d.body.removeChild(j);
			}catch(R){}
		}
		);
		return;
		w.addEventListener('touchstart', function(evt) {
				evt.preventDefault();
				onStartTouch(evt);
				evt.stopImmediatePropagation();
			}, false);
		w.addEventListener('touchend', function(evt) {
			evt.preventDefault();
			onEndTouch(evt);
			evt.stopImmediatePropagation();
			
		}, false);
		w.addEventListener('touchmove', function(evt) {
			evt.preventDefault();
			onTouch(evt);
			evt.stopImmediatePropagation();
			
		}, false);
		
		d.addEventListener('touchstart', function(evt) {
				evt.preventDefault();
				onStartTouch(evt);
				evt.stopImmediatePropagation();
			}, false);
		d.addEventListener('touchend', function(evt) {
			evt.preventDefault();
			onEndTouch(evt);
			evt.stopImmediatePropagation();
			
		}, false);
		d.addEventListener('touchmove', function(evt) {
			evt.preventDefault();
			onTouch(evt);
			evt.stopImmediatePropagation();
			
		}, false);
		
		d.body.addEventListener('touchstart', function(evt) {
				evt.preventDefault();
				onStartTouch(evt);
				evt.stopImmediatePropagation();
			}, false);
		d.body.addEventListener('touchend', function(evt) {
			evt.preventDefault();
			onEndTouch(evt);
			evt.stopImmediatePropagation();
			
		}, false);
		d.body.addEventListener('touchmove', function(evt) {
			evt.preventDefault();
			onTouch(evt);
			evt.stopImmediatePropagation();
			
		}, false);
	}
	
	function onStartTouch(evt) {
		m('was start touch');
	}
	function onEndTouch(evt) {
		m('was end touch');
	}
	function onTouch() {
		m('was  touch');
	}*/
}
