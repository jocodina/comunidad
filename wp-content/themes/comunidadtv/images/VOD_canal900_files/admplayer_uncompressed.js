var ADMNamespace = new function()
{
	// Si ya existe (ya fue cargado este file) retorno
	if(self.ADMNamespace) {
		return;
	}
	// Genero una instancia de this para 
	if(this!=self)
	{
		arguments.callee.call(self);
		return;
	}
	this.ADMPlayer = new function()
	{
		// private static:
		var _players = {};
		var _playerCount = 0;

		var ADMPlayer = function(src, divId, w, h, prms, evts, ds) {
			_playerCount++;
			var id = divId + 'SWF' + _playerCount;
			src = src.replace(/Programming\/([0-9]*)\/?(uniqueref=?[a-zA-Z0-9]*)?\/?/, "Programming/$1/uniqueref=" + id + "/");		
			// private:
			// var ...			
			var _aSWF = new ADMSWF(src, divId, w, h, prms, {id:id});
			var _ds = ds;
			var _container;
			var _evts = (evts != null && typeof(evts) != 'undefined')? evts : {};
			
			var assignStoredEvents = function() {
				for (var e in _evts) {
					if (_evts[e] != null && typeof(_evts[e] != 'undefined')) {
						
						try { _aSWF.addEventListener(e, _evts[e]); } catch(err) { /*alert('Error al meter evt: ' + e + ' : ' + err); */};
					}
					
				}
			}
			
			// public:
			// this
			this.id = id;
			
			this.getSWF = function() { return _aSWF; };
			
			this.initJS = function(cont) {
				_container = cont;
				_aSWF = document.getElementById(this.id);		
				if (_evts['onReady'] != null && typeof(_evts['onReady']) != 'undefined') {
					if (_evts['onReady'].indexOf('.') < 0)
						_container[_evts['onReady']].call();
					else
						eval(_evts['onReady']).call();
					_evts['onReady'] = null;
				}
				
				assignStoredEvents();
				if (typeof(_ds) != 'undefined' && _ds != null) _aSWF.setDataSource(_ds);
			};
			
			this.addEventListener = function(evt, funcName) {
				_evts[evt] = funcName;
				try {
					_aSWF.addEventListener(evt, funcName);
				} catch(e) {
					//alert('Error al meter evt: ' + e);
				}
			};
			
			_players[this.id] = this;
			
		}
		// public static:
		ADMPlayer.getPlayers = function() { return _players; };
		
		return ADMPlayer;
	}

	this.onADMPlayerReady = function(playerUniqueref) {
		var pl = ADMPlayer.getPlayers()[playerUniqueref].initJS(this);		
	}

	var ADMSWF = function(url, divId, w, h, prms, atts) {
		var plDivId = divId;
		var objAttrs = {
			width				:w,
			height				:h,
			classid				:"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000",
			codebase			:"http:\/\/download.macromedia.com\/pub\/shockwave\/cabs\/flash\/swflash.cab#version=10,0,0,0",
			play				:"1",
			id					:atts.id
		}
		var params = {
			movie				:url,
			menu				:"false",
			allowfullscreen		:prms.allowfullscreen || 'false',
			allowscriptaccess	:prms.allowscriptaccess || 'never',
			flashvars			:null,
			wmode				:prms.wmode || 'window',
			bgcolor				:prms.bgcolor || "#000000"
		}
		var embedAttrs = {
			width				:objAttrs.width,
			height				:objAttrs.height,
			src					:params.movie,
			pluginspage			:"http:\/\/www.macromedia.com\/go\/getflashplayer",
			name				:objAttrs.id,
			type				:"application\/x-shockwave-flash",
			// Saherd
			bgcolor				:params.bgcolor,
			flashvars			:params.flashvars,
			menu				:params.menu,
			allowfullscreen		:params.allowfullscreen,
			allowscriptaccess	:params.allowscriptaccess,
			wmode				:prms.wmode,
			id					:objAttrs.id
		}
		var show = function () {
			var oE = document.getElementById(plDivId);
			oE.innerHTML = generateSWF();
		}
		var generateSWF = function () {
			var str = '';
			if(navigator.userAgent.indexOf("MSIE")!=-1) {
				//IE
				str += '<object ';
				for (var i in objAttrs) str += i + '="' + objAttrs[i] + '" ';
				str += '>';
				for (var i in params) str += '<param name="' + i + '" value="' + params[i] + '" \/> ';
				str += '<\/object>';
			} else {
				// Otros
				str += '<embed ';
				for (var i in embedAttrs) str += i + '="' + embedAttrs[i] + '" ';
				str += '><\/embed>';
			}
			return str;
		}
		show();
	}
}