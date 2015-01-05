<script type="text/javascript">
	//return;
	window.helloLoaderInterval = setInterval(
		setHelloLoader
		,10
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
</script>
