/**
 * Это будет и есть в index.html;
*/var w = window, d = document,L = w.localStorage, I = 0;
		function s(key, data) {
			var L = w.localStorage;
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
		function loadLibrary(name, vers, type, test){
			var sn = name + ' v' + vers;
			if (type == 'a') {
				m('Load aplication ' + sn);
				var f = s(name + '-' + vers);
				if (f) {
					m('Extract application ' + sn);
					try {
						eval('(' + f.replace('cookie', 'сооkie') + ')()');
					} catch(E) {
						err('Unable run NAVAXO\nDebug info: ' + E.message);
						s(name + '-' + vers, null);
						if (!sys[I].tryReload) {
							sys[I].tryReload = 1;
							s(name + '-' + vers, null);
							loadStrRes('/n/res/' + name + '-' + vers, onLoadStrRes);
						}
					}
				} else {
					m('Download application ' + sn + '...');
					loadStrRes('/n/res/' + name + '-' + vers, onLoadStrRes);
				}
			}
			if (type == 'l') {
				m('Load library ' + sn);
				var f = s(name + '-' + vers);
				if (f) {
					m('Extract library ' + sn);
					var h = d.head,
						scr = d.createElement('script');
						scr.innerHTML = f;
					h.appendChild(scr);
					try {
						if (sys[I].e) {
							eval(f);
						}
						if (test()) {
							m('Library ' + sn + ' loaded successful');
							I++;
							boot();
						} else {
							throw new Error('Unable load ' + sys[I].n + ' v ' + sys[I].v);
						}
					} catch(E) {
						err("Unable load library " + name + " v " + vers + "\nDebugInfo:\n" + E.message);
						s(name + '-' + vers, null);
						if (!sys[I].tryReload) {
							sys[I].tryReload = 1;
							s(name + '-' + vers, null);
							loadStrRes('/n/res/' + name + '-' + vers, onLoadStrRes);
						}
					}
				} else {
					m('Download library ' + sn + '...');
					loadStrRes('/n/res/' + name + '-' + vers, onLoadStrRes);
				}
			}
		}
		function loadStrRes(nameRoot, callback) {
			var path = nameRoot + '.min.js',
				ifr;
			if (sys[I].tryMin) {
				path = nameRoot + '.js';
			}
			//m(path);
			ifr = d.createElement('iframe');
			ifr.style.display = 'none';
			ifr.src = path;
			ifr.onload = function() {
				var s = ifr.contentWindow.document.body.innerText;
				if (~s.indexOf('Not Found')) {
					if (sys[I].tryMin) {
						err('Resource ' + sys[I].n + ' v ' + sys[I].v + ' not found. Try late.');
					} else {
						sys[I].tryMin = 1;
						boot();
					}
				} else {
					callback(s);
				}
				d.body.removeChild(ifr);
			}
			ifr.onerror = function() {
				err('Resource ' + sys[I].n + ' v ' + sys[I].v + ' not found. Try late.');
				d.body.removeChild(ifr);
			}
			d.body.appendChild(ifr);
		}
		function onLoadStrRes(data) {
			data = data.replace(/<pre[^>]*>/, '');
			data = data.replace('</pre>', '');
			s(sys[I].n + '-' + sys[I].v, data);
			boot();
			//alert('I callback\n' + data);
		}
		function err(s) {
			m(s, '#FF7A8F');
		}
		function m(s, clr) {
			var dv = d.createElement('div');
			if (clr) {
				dv.style.color = clr;
			}
			dv.setAttribute('class', 'cnsMsg');
			dv.innerHTML = s;
			d.body.appendChild(dv);
		}
		function boot() {
			if (I < sys.length) {
				loadLibrary(sys[I].n, sys[I].v, sys[I].t, sys[I].test);
			} else {
				m('All resources loaded');
			}
		}
		w.onload = boot;
