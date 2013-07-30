		// General functions
		function getEl(x){
			return document.getElementById(x);
		}
		// Call-back functions of Admotion TV Player
		function myOnContent() {
		}
		//Marca cuando se hace play en un video, se debe reemplazar nombre_del_video por el que se está invocando
		function myOnPlay() {
		titulo = admplayer.getSWF().getCurrentContent().title;
		titulo1 = titulo.replace(/[ ]/gi,"_");
		titulo2 = titulo1.replace(/[']/gi,"");
		titulo3 = titulo2.replace(/[,]/gi,"");
		play(titulo3)
		}
		//Marca cuando se hace pause en un video, se debe reemplazar nombre_del_video por el que se está invocando
		function myOnPause() {
		titulo = admplayer.getSWF().getCurrentContent().title;
		titulo1 = titulo.replace(/[ ]/gi,"_");
		titulo2 = titulo1.replace(/[']/gi,"");
		titulo3 = titulo2.replace(/[,]/gi,"");
		stop(titulo3)
		}

		function myOnReady() {
		//	alert('onReady');
		}			 
		function myOnResize() {
		}
		//Inicializa el video, debo reemplazar nombre_del_video por el que se está invocando
		function myOnPlayStart() {
		titulo = admplayer.getSWF().getCurrentContent().title;
		titulo1 = titulo.replace(/[ ]/gi,"_");
		titulo2 = titulo1.replace(/[']/gi,"");
		titulo3 = titulo2.replace(/[,]/gi,"");
		start(21413,'vod',titulo3,admplayer.getSWF().getCurrentContent().length,false,true);
		}
		
		function myOnNewPlaylist() { // This function displays the Player's playlist.
			var i,
				t = '';
			for(i=1; i<admplayer.getSWF().getPlaylist().length; i++) {
				t += '<a href="#destacadosvtr" onclick="javascript:admplayer.getSWF().playContentById('+admplayer.getSWF().getPlaylist()[i]['id']+')">';
				t += '<img src="'+admplayer.getSWF().getPlaylist()[i]['thumbnailLarge']+'" width="80" height="50" align="left" hspace="5" />' +  admplayer.getSWF().getPlaylist()[i]['title'] + '</a>';
			};
//			getEl('menuTV').innerHTML = '<strong>Te Recomendamos:</strong><br /><br />' + t;
			getEl('menuTV').innerHTML = '' + t;
		}
		
		// Call-back functions of Flajax.
		function flajaxLoad() {
			getEl("flajax").call(resourceContent, "flajaxOnResponse","GET", null);
		}
		function flajaxIOError(o) {
			//alert("error: " + o);
		}
		function flajaxSecurityError(o) {
			//alert("error security "+  o);
		}
		function flajaxOnResponse(o) {
			dataSource = eval(o) ;
			admplayer = new ADMPlayer(resourcePlayer, 'jsapiplayer', 302, 255, paramsPlayer, events, dataSource); 
			// Player is embedded as soon as the Content Resource (parameter o) is grabbed by the Flajax.
		}
		
		// Admotion TV resources definition
/*		
		var resourceContent = 'http://takeout.dmmotion.com/Content/Programming/1249/Structure?view=JSON&unit=item&attributes=id,title,description,media,thumbnailLarge,length&paging=1,2',
			resourcePlayer = 'http://takeout.dmmotion.com/Delivery/Programming/1249/showSkin=1/idSkin=216';
*/
		var resourceContent = 'http://takeout.dmmotion.com/Content/Programming/1272/Playlist/18752/Structure?view=JSON&unit=item&attributes=id,title,description,media,thumbnailLarge,length&paging=1,1',
			resourcePlayer = 'http://takeout.dmmotion.com/Delivery/Programming/1272/showSkin=1/idSkin=216';
		
		// Admotion TV Player initialization parameters.
		var paramsPlayer = { allowscriptaccess: 'always', allowfullscreen: 'true', wmode: 'window'},
			events = { onReady: 'myOnReady', onResize: 'myOnResize', onPlay: 'myOnPlay', onPlayStart: 'myOnPlayStart', onPause: 'myOnPause', onNewContent:'myOnContent', onNewPlayList:'myOnNewPlaylist' },
			admplayer,
			dataSource;
		
		// Flajax component acquisition
		var flashvars = {
		};
		var params = {
			menu: "false",
			scale: "noScale",
			allowFullscreen: "false",
			allowScriptaccess: "always",
			bgcolor: "#FFFFFF"
		};
		var attributes = {
			id:"flajax"
		};
		swfobject.embedSWF("flajax/flajax.swf", "flajaxHolder", "1", "1", "9.0.0", null, flashvars, params, attributes);
