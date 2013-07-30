function inicial(){
        
        var hash = location.hash
        //inicializa la funcion evt
        $(".evt").evt();
        
        //obtenemos la geolocalizacion
        if (navigator.geolocation) { 
                navigator.geolocation.getCurrentPosition(js.getLocation, js.errorCallback);

        }

        
        //carga destacados
        if(hash){
           js.loadfichaHash(); 
        }else{
           js.loadCarruselDestacado(); 
        }
        
        //buscador
        $("#buscador").keyup(function(e){   
               if(e.keyCode!=13) js.getResultsSearch();
                    });
        //carrusel automatico            
        js.intervalo = setInterval(function(){js.automaticCarrousel();}, 7000);           
        
        //setea el ancho de la caja, y configura el carrusel
        setTimeout(function(){
            js.totalWidth();
            js.carousel();
        },1000);  
        
        
        //escondemos el splash despues de la carga total del sitio
        $(window).load(function() {
            $('#splash').hide();
        });

        

        //plugin para crear textura en la caja
//        $('#mainCont').noisy({
//            intensity: 1, 
//            size: 100, 
//            opacity: 0.08,
//            monochrome: true
//        });

        //setea el ancho de la caja y configura el carrusel por cada vez que el ancho de la pantalla es modificado
        $(window).resize(function() {
                        js.totalWidth();
                        js.carousel();
        });
      
}
//funcion para guardar en localstorage
function savelocalTablet(valor, nombre, limit){
    var nuevovalor = new Array();
    var getlocal = localStorage.getItem(nombre);
      
    if(getlocal != null && getlocal != "" && getlocal != false && getlocal != undefined){
        var parslocal = JSON.parse(getlocal);
        var cont;
            
        $.each(parslocal, function(index, value){
            cont = index;
            if(valor == value){
                return false;
            }
            nuevovalor[index] = value;
        });
        cont++;
        if(cont < limit){
            nuevovalor[cont] = valor;
            localStorage.setItem(nombre, JSON.stringify(nuevovalor));
            cont++;
        }else{
            alert('Ya tienes la cantidad máxima de favoritos.');
            $('.watch[data-program="'+valor+'"]').change(function(event) {
                event.preventDefault();
            });   
            $('.watch[data-program="'+valor+'"]').attr('checked', false);
        }
            
            
        return cont;
    }
    else {
        var saveLocal = new Array();
        saveLocal[0] = valor; 
        localStorage.setItem(nombre, JSON.stringify(saveLocal));
        return 1;
    }
      
      
}
//funcion para eliminar de localStorage
function deleteLocalTablet(valor, nombre){
      
    var getlocal = localStorage.getItem(nombre);
    var newVal = new Array();
    var cont;
      
    if(getlocal != null && getlocal != "" && getlocal != false && getlocal != undefined){
        var parslocal = JSON.parse(getlocal);
        var contador = 0;
        $.each(parslocal, function(index, value){
            cont = index;
            if(value != valor && value != null && value != undefined && value != false){
                newVal[contador] = value;
                contador++;
            }
        });
          
        if(cont == 0){
            localStorage.removeItem(nombre);
        }else{
            localStorage.setItem(nombre, JSON.stringify(newVal));
        }
         
    }
      
}
var js = {
    intervalo : false,
    totalWidth : function(){
        
        $('.tab').width($('#mainCont').width());
        var widths = $('.tab').first().width();
        var dataTab = $('#nav').find('.current').attr('data-tab');
        var totalWidth = widths * 3;
        var totalHeight = $(window).height();
        
        $('.container').height(totalHeight).css('overflow','hidden');
        
        var heights = $('.container').height();
        var guiaHeadHeader = $('.guiaHeader').outerHeight();
        $('#catNav').height(heights - 130);
        $('#guiaContent').height(heights - 130);
        $('#mainGuiaCont').height(heights - 130 - 65);
        
        $('#tabs').width(totalWidth);
        var left;
        
        left = widths * (dataTab - 1);
        
        $('#tabs').css('left','-'+left+'px');

    },
    carousel : function(){
        var ul = $('.innerCarrousel ul'),
            ulParent = $(ul).parent();
        var totalWidth = $(ulParent).width();
        
        var liWidth = $(ul).children().first().outerWidth(true);
        var liCount = $(ul).children().length;
        var total = (liWidth * liCount) + 10 + 30;
        
        $.each(ul , function(index, element){
            $(this).width(totalWidth);
        });
        
        $(ul).children().removeAttr("style");
        $(ul).children().width(totalWidth * 0.3075);
        $(ul).children().css('margin-right',totalWidth * 0.020);
        
        liWidth = $(ul).children().first().outerWidth(true);
        liCount = $(ul).children().length;
        total = (liWidth * liCount) + 10 + 30;
        
        $(ul).width(total + liWidth);
        
//        $(ul).find('li').addClass('normal');
        $(ul).find('li.current').width($(ul).children().first().width() + 30);
//        $(ul).find('li.current').removeClass('normal');
//        $(ul).find('li:first').removeClass('normal');
//        $(ul).find('li:last').removeClass('normal');
       
    },
    touchEvents : function(){
        var ul = $('#mainCont');
        var firstTouch;
        var direccion;
        var inicialPosition;
        var coordenada;
        
        $(ul).on('touchstart', 'ul[data-carrusel]', function(event){
                var touch = event.originalEvent.touches[0] || event.originalEvent.changedTouches[0];
                firstTouch = touch.pageX;
                
//                inicialPosition = $(this).position().left - $(this).parents('.tab').position().left;
//                $(this).removeClass('transition');  

            });
        $(ul).on('touchmove', 'ul[data-carrusel]', function(event){
                event.preventDefault();
                var touch = event.originalEvent.touches[0] || event.originalEvent.changedTouches[0];
                direccion = touch.pageX - firstTouch;
                coordenada = direccion + inicialPosition ;

//                $(this).css('left',coordenada);
            });
        $(ul).on('touchend', 'ul[data-carrusel]', function(event){
            var touch = event.originalEvent.touches[0] || event.originalEvent.changedTouches[0];
//            $(this).addClass('transition');
              direccion = touch.pageX - firstTouch;
                if(Math.abs(direccion) > 150){
                   event.preventDefault();
                   js.makeTheMove(direccion);
                }
//                else{
//                   $(this).css('left',inicialPosition); 
//                }
                
            });    
        
    },
    makeTheMove : function(direccion){
        var currentTab = $('#nav').find('a.current').attr('data-tab');
        var dataCarrusel;
        if(currentTab == '1'){
            dataCarrusel = 1;
        }
        else if(currentTab == '3'){
            dataCarrusel = 2;
        }
        var ul = $('.innerCarrousel ul[data-carrusel="'+dataCarrusel+'"]');
        var currentLi = $(ul).find('li.current');
        
        if(direccion > 0){             
            $(currentLi).prev().trigger('click');
        }else{
         
            $(currentLi).next().trigger('click');
        }

    },
    tabChange : function(item){
        $('#tabs').css('height','auto');
        $('.innerCarrousel ul[data-carrusel="1"]').on('click', function(){
            clearInterval(js.intervalo);
        });
        
        var tabDestino = $(item).attr('data-tab');
        var anchoTab = $(".tab").first().width();
        var liAjustes = $('li.ajustes').find('a');
        var movimiento;

        if($(liAjustes).hasClass('active')){
            $(liAjustes).removeClass('active');
            $(liAjustes).next().css('display','none');
        }
        
        $('#callFicha').hide();
        $('#tabs').css('display','block');

        $('#nav').find('.current').removeClass('current');
        $(item).addClass('current');
        
        movimiento = anchoTab * (tabDestino - 1);
        $("#tabs").css({
            left: '-'+movimiento+'px'
            });
        
            
        if(tabDestino == '2'){
             js.loadGuia();
             $('.tab[data-tab="1"]').html('');
             $('.tab[data-tab="3"]').html('');
        }else if(tabDestino == '1'){
             js.loadCarruselDestacado();
             $('.tab[data-tab="2"]').html('');
             $('.tab[data-tab="3"]').html('');
             clearInterval(js.intervalo);
        }else if(tabDestino == '3'){
             js.loadFavoritosTab();
             $('.tab[data-tab="2"]').html('');
             $('.tab[data-tab="1"]').html('');
        }

        var currentTab = $(item).attr('data-tab');    

        if(currentTab == 1){
            $('.innerCarrousel').find('ul[data-carrusel="2"]').hide();
            $('.innerCarrousel').find('ul[data-carrusel="1"]').show();
        }else if(currentTab == 3){
            $('.innerCarrousel').find('ul[data-carrusel="1"]').hide();
            $('.innerCarrousel').find('ul[data-carrusel="2"]').show();
        }    
            
        js.totalWidth();
        js.carousel();
        js.marcaFavoritos();
        
    },
    sameHeight : function(){
        var tabHeight = $('#mainCont').outerHeight();
        
        $('#catNav ul').height(tabHeight);

    },
    buscador : function(item){
        var blockHeight = $('#mainCont').height(),
            halfWidth;
        
        if($('#buscador').val()){
            $('#buscador').val('');
        }
        
        blockHeight = blockHeight + $('#nav').height();
        $('#callFicha').hide();
        $('.blocker').fadeIn('slow').height($('.container').height() - 65);
//        $('#tabs').css('display','none');
        
        $('li.ajustes a.ajustesIcon').removeAttr('data-func');
        
        if($('li.ajustes a').hasClass('active')){
            $('li.ajustes a').removeClass('active');
            $('li.ajustes a').next().css('display','none');
            $('li.ajustes a').removeAttr('data-func');
        }
        
        $(item).css('display','none');
        $(item).parent().find('#buscador').fadeIn('slow');
        
        

    },
    getResultsSearch : function(){
        
        $('.searchContent').fadeIn('slow');
        halfWidth = ($('.searchContent').width()) / 2;
        $('.searchContent').css('margin-left','-'+halfWidth+'px')
        
        var search = $('#buscador').val();
        
        if(search.length > 3){

        var hostname = window.location.hostname;
        
        $.ajax({
        type: "GET",
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: "ajax_tablet",
            search: search, 
            county: localStorage.getItem("county"),
            format: 'json',
            date: 'no'
        },
        dataType: "json",
        beforeSend: function( xhvalr ) {
            $('.searchContent').html('');
            $('.searchContent').append('<img class="ajaxLoad" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/ajax-loader.gif" />');
        },
        success: function(data) {
        var halfWidth;
        var html = "";
        var ciudad;

        if(data != null){
            html+= '<div class="innerSearch">';
            html += '<ul>';
            $.each(data, function(key, value) {
                ciudad = data[key].city;
                ciudad = ciudad.toLowerCase();
                
                html += '<li class="evtSearch" data-func="loadFicha" data-program="'+data[key].programid+'" data-allProg = "'+data[key].allprograms+'">';
                html += '<div class="searchWrap">';
                html += '<div class="channel">';
                html += '<img class="channelImg" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/foto/'+data[key].imagen+'" />';
                html += '<span class="channelData">';
                html += '<span class="channelTitle">'+data[key].senal+'</span>';
                html += '<span class="channelNum"><strong>'+ data[key][ciudad] +'</strong></span> ';
                html += '</span>';
                html += '</div>';
                html += '<div class="program">';
                html += '<span class="programTitle">'+data[key].title+'</span>';
                html += '<span class="programDate">'+data[key].startime+' a '+data[key].endtime+'</span>';
                html += '</div>';  
                html += '</div>';
                html += '</li>';
             });
            html += '</ul>';
            html+= '</div>';
            html +='<a class="closeFicha evtSearch" data-func="cerrarFicha">Cerrar</a>';
        }else{
                html += '<p class="error">No se han encontrado resultados</p>';
        }
      
        $('.searchContent').html(html);
        $('.searchContent').css('opacity','1.0');
        $('.evtSearch').evt();
   
        },
        error : function() { 

        }
    });
    }    
        
    },
    searchClose : function(item){
        $(item).next().fadeOut('slow');
        $(item).hide();
        $('.searchContent').hide();
        $('#buscador').css('display','none');
        $('#search').show('');
        
        $('li.ajustes a.ajustesIcon').attr('data-func','menuAjustes');
        $('#tabs').css('height','auto');
    },
    loadfichaHash : function(){
        alert('ok');
        var hash = location.hash.split('&');
        var programid = hash[0].split('=');
        programid = programid[1];
        
        var programidHorario = hash[1].split('=');
        programidHorario = programidHorario[1];
        var ficha = 'si';
        var hostname = window.location.hostname;
        
        $.ajax({
        type: "GET",
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: "ajax_tablet",
            programid: programid, 
            width:780,
            height: 300,
            county: localStorage.getItem("county"),
            date: 'no',
            format: 'json'
        },
        dataType: "json",
        beforeSend: function( xhvalr ) {
            $('.blocker').height($('.container').height());
            $('.blocker').show();
            $('.blocker').append('<img class="ajaxLoad" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/ajax-loader.gif" />');
        },
        success: function(data) {
                var html = "";
                var p = "";
                var permalink;
                
                $('.blocker').hide();
                $('.blocker').html('');
                
                html +='<section id="infoFichaCompleta">';
                html += '<div class="relativeWrapp fichaDescription">';
                html +='<div class="metaFicha">';
                html +='<div id="wrapperFicha">';
                
                if(data[0].ficha == '1'){
                    html +='<img class="poster" src="'+data[0].imagedest+'" />';
                }
                else{
                        if(data[0].genero == 'series-peliculas'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaSeriesLong.jpg" />';
                        }else if(data[0].genero == 'tendencias'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaTendenciasLong.jpg" />';
                        }else if(data[0].genero == 'Alta Definición'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaHDLong.jpg" />';
                        }else if(data[0].genero == 'Cultural'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaCulturaLong.jpg" />';
                        }else if(data[0].genero == 'Noticias'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaNoticiasLong.jpg" />';
                        }else if(data[0].genero == 'Musica'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaMusicaLong.jpg" />';
                        }else if(data[0].genero == 'Infantil'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaInfantilLong.jpg" />';
                        }else if(data[0].genero == 'Nacional'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaNcionalLong.jpg" />';
                        }else if(data[0].genero == 'Deportes'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaDeportesLong.jpg" />';
                        }else if(data[0].genero == 'Adulto'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaAdultoLong.jpg" />';
                        }else if(data[0].genero == 'Internacional'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaInternacionalLong.jpg" />';
                        }else if(data[0].genero == 'Compra de Eventos'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaCompraLong.jpg" />';
                        }                 
                }
                html +='<div class="fichaWrap">';
                html +='<h1>'+data[0].title;
                if(data[0].mpaarating != 'none'){
                    html +='<span class="clasificacion">'+data[0].mpaarating+'</span>';
                }
                html +='</h1>';
                permalink = data[0].permalink;
                if(permalink == undefined){
                    permalink = 'http://'+hostname;
                }

                html +='<ul class="sociales">';
                html +='<li><a href="http://www.facebook.com/share.php?u='+permalink+'&title='+data[0].title+'" target="_blank"><img src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/facebook.png" /></a></li>';
                html +='<li><a href="http://twitter.com/home?status=Estoy viendo la ficha de +'+data[0].title+' desde mi Tablet: +'+permalink+' %23GuíaTV" target="_blank"><img src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/twitter.png" /></a></li>';
                html += '<li><input data-program="'+data[0].programid+'" type="checkbox" class="favorito newEvt watch" data-event="change" name="favoritos" data-func="addFavorito" value=""/></li>';
                html +='</ul>';
                html +='<div class="datosFicha">';
                if(data[0].gender){
                  html +='<div class="dataWrap">Género: <span class="resultDato">'+data[0].gender+'</span></div>';  
                }
                if(data[0].ano){
                    html +='<div class="dataWrap">Año: <span class="resultDato">'+data[0].ano+'</span></div>';
                }
                if(data[0].director){
                    html +='<div class="dataWrap">Director: <span class="resultDato">'+data[0].director+'</span></div>';
                }
                if(data[0].actor1 || data[0].actor2 || data[0].actor3 || data[0].actor4 || data[0].actor5 || data[0].actor6){
                    html += '<div class="dataWrap">Protagonistas: <span class="resultDato">';
                    if(data[0].actor1 != undefined){
                        p += data[0].actor1+', ';
                    }
                    if(data[0].actor2 != undefined){
                        p += data[0].actor2+', ';
                    }
                    if(data[0].actor3 != undefined){
                        p += data[0].actor3+', ';
                    }
                    if(data[0].actor4 != undefined){
                        p += data[0].actor4+', ';
                    }
                    if(data[0].actor5 != undefined){
                        p += data[0].actor5+', ';
                    }
                    if(data[0].actor6 != undefined){
                        p += data[0].actor6+', ';
                    }
                    p = p.substring(0, p.length-2)
                    html += p+'.';
                    html += '</span></div>';
                }
                html +='</div>';
                if(data[0].description){
                   html += '<p>'+data[0].description+'</p>'; 
                }
                html +='</div>';
                html +='</div>';
                html +='</div>';
                html += '<div class="scrollbar">';
                html += '<div class="scroll">';
                html += '</div>';
                html += '</div>';
                html +='</div>';
                html += '<div class="relativeWrapp fichaHorarios">';
                html +='<div id="horariosFicha">';
                html +='</div>';
                html += '<div class="scrollbar">';
                html += '<div class="scroll">';
                html += '</div>';
                html += '</div>';
                html +='</div>';
                
                
                html +='</section>';
                html +='<a class="closeFicha newEvt" data-func="cerrarFicha">Cerrar</a>';

                $('#mainCont').css('opacity','1.0');
                $('#tabs').css('display','none');
                //si el buscador está activado, vuelve a su estado normal.
                $('.searchContent').hide();
                $('.blocker').hide();
                $('#buscador').css('display','none');
                $('#search').fadeIn('slow');
                $('#horariosFicha').css('opacity','1.0');
                $('li.ajustes a.ajustesIcon').attr('data-func','menuAjustes');
                
                $('#callFicha').html(html).show();
                $('.newEvt').evt();
                
                
                
                js.marcaFavoritos('ficha');
                js.cargaHorarioInicio(programidHorario, ficha);
                setTimeout(function(){
                    js.scrollBar('.metaFicha');
                },2000)
                
                
            
        },
        error : function() { 

        }
    });        
        
        
        
    }
    ,
    loadFicha : function(item){
        var programid = $(item).attr('data-program');
        var programidHorario = $(item).attr('data-allProg');
        var ficha = 'si';
        var hostname = window.location.hostname;
        
        $.ajax({
        type: "GET",
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: "ajax_tablet",
            programid: programid, 
            width:780,
            height: 300,
            county: localStorage.getItem("county"),
            date: 'no',
            format: 'json'
        },
        dataType: "json",
        beforeSend: function( xhvalr ) {
            $('.blocker').height($('.container').height());
            $('.blocker').show();
            $('.blocker').append('<img class="ajaxLoad" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/ajax-loader.gif" />');
        },
        success: function(data) {
                var html = "";
                var p = "";
                var permalink;
                
                $('.blocker').hide();
                $('.blocker').html('');
                
                html +='<section id="infoFichaCompleta">';
                html += '<div class="relativeWrapp fichaDescription">';
                html +='<div class="metaFicha">';
                html +='<div id="wrapperFicha">';
                
                if(data[0].ficha == '1'){
                    html +='<img class="poster" src="'+data[0].imagedest+'" />';
                }
                else{
                        if(data[0].genero == 'series-peliculas'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaSeriesLong.jpg" />';
                        }else if(data[0].genero == 'tendencias'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaTendenciasLong.jpg" />';
                        }else if(data[0].genero == 'Alta Definición'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaHDLong.jpg" />';
                        }else if(data[0].genero == 'Cultural'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaCulturaLong.jpg" />';
                        }else if(data[0].genero == 'Noticias'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaNoticiasLong.jpg" />';
                        }else if(data[0].genero == 'Musica'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaMusicaLong.jpg" />';
                        }else if(data[0].genero == 'Infantil'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaInfantilLong.jpg" />';
                        }else if(data[0].genero == 'Nacional'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaNcionalLong.jpg" />';
                        }else if(data[0].genero == 'Deportes'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaDeportesLong.jpg" />';
                        }else if(data[0].genero == 'Adulto'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaAdultoLong.jpg" />';
                        }else if(data[0].genero == 'Internacional'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaInternacionalLong.jpg" />';
                        }else if(data[0].genero == 'Compra de Eventos'){
                            html +='<img class="poster" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaCompraLong.jpg" />';
                        }                 
                }
                html +='<div class="fichaWrap">';
                html +='<h1>'+data[0].title;
                if(data[0].mpaarating != 'none'){
                    html +='<span class="clasificacion">'+data[0].mpaarating+'</span>';
                }
                html +='</h1>';
                permalink = data[0].permalink;
                if(permalink == undefined){
                    permalink = 'http://'+hostname;
                }

                html +='<ul class="sociales">';
                html +='<li><a href="http://www.facebook.com/share.php?u='+permalink+'&title='+data[0].title+'" target="_blank"><img src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/facebook.png" /></a></li>';
                html +='<li><a href="http://twitter.com/home?status=Estoy viendo la ficha de +'+data[0].title+' desde mi Tablet: +'+permalink+' %23GuíaTV" target="_blank"><img src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/twitter.png" /></a></li>';
                html += '<li><input data-program="'+data[0].programid+'" type="checkbox" class="favorito newEvt watch" data-event="change" name="favoritos" data-func="addFavorito" value=""/></li>';
                html +='</ul>';
                html +='<div class="datosFicha">';
                if(data[0].gender){
                  html +='<div class="dataWrap">Género: <span class="resultDato">'+data[0].gender+'</span></div>';  
                }
                if(data[0].ano){
                    html +='<div class="dataWrap">Año: <span class="resultDato">'+data[0].ano+'</span></div>';
                }
                if(data[0].director){
                    html +='<div class="dataWrap">Director: <span class="resultDato">'+data[0].director+'</span></div>';
                }
                if(data[0].actor1 || data[0].actor2 || data[0].actor3 || data[0].actor4 || data[0].actor5 || data[0].actor6){
                    html += '<div class="dataWrap">Protagonistas: <span class="resultDato">';
                    if(data[0].actor1 != undefined){
                        p += data[0].actor1+', ';
                    }
                    if(data[0].actor2 != undefined){
                        p += data[0].actor2+', ';
                    }
                    if(data[0].actor3 != undefined){
                        p += data[0].actor3+', ';
                    }
                    if(data[0].actor4 != undefined){
                        p += data[0].actor4+', ';
                    }
                    if(data[0].actor5 != undefined){
                        p += data[0].actor5+', ';
                    }
                    if(data[0].actor6 != undefined){
                        p += data[0].actor6+', ';
                    }
                    p = p.substring(0, p.length-2)
                    html += p+'.';
                    html += '</span></div>';
                }
                html +='</div>';
                if(data[0].description){
                   html += '<p>'+data[0].description+'</p>'; 
                }
                html +='</div>';
                html +='</div>';
                html +='</div>';
                html += '<div class="scrollbar">';
                html += '<div class="scroll">';
                html += '</div>';
                html += '</div>';
                html +='</div>';
                html += '<div class="relativeWrapp fichaHorarios">';
                html +='<div id="horariosFicha">';
                html +='</div>';
                html += '<div class="scrollbar">';
                html += '<div class="scroll">';
                html += '</div>';
                html += '</div>';
                html +='</div>';
                
                
                html +='</section>';
                html +='<a class="closeFicha newEvt" data-func="cerrarFicha">Cerrar</a>';

                $('#mainCont').css('opacity','1.0');
                $('#tabs').css('height','0px');
                //si el buscador está activado, vuelve a su estado normal.
                $('.searchContent').hide();
                $('.blocker').hide();
                $('#buscador').css('display','none');
                $('#search').fadeIn('slow');
                $('#horariosFicha').css('opacity','1.0');
                $('li.ajustes a.ajustesIcon').attr('data-func','menuAjustes');
                
                $('#callFicha').html(html).show();
                $('.newEvt').evt();
                
                
                
                js.marcaFavoritos('ficha');
                js.cargaHorarioInicio(programidHorario, ficha);
                setTimeout(function(){
                    js.scrollBar('.metaFicha');
                },2000)
                
                
            
        },
        error : function() { 

        }
    });
    },
    loadFichaInicio : function(item){
        $('.innerCarrousel ul[data-carrusel="1"]').on('touchstart', function(){
            clearInterval(js.intervalo);
        });
        var programID = $(item).attr('data-program');
        var programidHorario = $(item).attr('data-allProg');
        var ulType = $(item).parent().attr('data-carrusel');
        var ul = $(".innerCarrousel ul[data-carrusel="+ulType+"]");
        var liLength = $(ul).find('li').length;
        var liWidthNormal = $(ul).find('li:first').width();
        var liWidthCurrent = $(ul).find('li.current').width();
        var currentLi = $(ul).find('li.current');
        var liPosition = $(item).attr('data-col');
        var liLast = $(ul).find('li:last-child').prev();
        var liFirst = $(ul).find('li:first-child').next();
        var liPrimero = $(ul).find('li:first-child');
        var liClone;
        var liclonar;
        var ulWidth;

         
        
        
        $(ul).find('li:last').prev().addClass('ultimo');
        $(ul).find('li:first').next().addClass('primero');

        $(currentLi).width(liWidthNormal); 
        $(ul).find('li.current').removeClass('current');

        $(item).addClass('current');
        $(item).width(liWidthCurrent);

        var newCurrentLi = $(ul).find('li.current');
        var newliPosition = $(newCurrentLi).position().left;
        
        if(liLength > 2){
         if($(item).hasClass('primero')){  
             
                 ulWidth = $(ul).width();
                 $(ul).width(ulWidth + liWidthCurrent);

                 liclonar = $(ul).find('li.clonarLeft');
                 liClone = $(liclonar).clone();
                 $(liClone).removeClass('clonarLeft').removeClass('ultimo').removeClass('clonarRight');
                 $(liclonar).prev().addClass('clonarLeft');
                 $(liclonar).removeClass('clonarLeft');
                 $(ul).find('li:first').before(liClone);


                 $('.evtNew').off('click');
                 $('.evtNew').evt();
                 $('.evtFav').off('click');
                 $('.evtFav').evt();
                 $(item).removeClass('primero');
                 liFirst = $(ul).find('li:first');
                 $(liFirst).next().addClass('primero');
                 $(liFirst).removeClass('ultimo');
                 liLast = $(ul).find('li:last');
                 $(liLast).prev().addClass('ultimo');

                 newCurrentLi = $(ul).find('li.current');
                newliPosition = $(newCurrentLi).position().left;

                $(ul).css({
                    left: (newliPosition *-1) +( $(currentLi).outerWidth(true) ) + 'px'
                 });
            
             

          }else if ($(item).hasClass('ultimo')){ 
                 ulWidth = $(ul).width();
                 $(ul).width(ulWidth + liWidthCurrent);

                 liclonar = $(ul).find('li.clonarRight');
                 liClone = $(liclonar).clone();
                 $(liClone).removeClass('clonarRight').removeClass('primero').removeClass('clonarLeft');
                 $(liclonar).next().addClass('clonarRight');
                 $(liclonar).removeClass('clonarRight');
                 $(ul).find('li:last').after(liClone);

                 $('.evtNew').off('click');
                 $('.evtNew').evt();
                 $('.evtFav').off('click');
                 $('.evtFav').evt();
                 $(item).removeClass('ultimo');
                 liLast = $(ul).find('li:last');
                 $(liLast).prev().addClass('ultimo');
                 $(liFirst).removeClass('primero');
                 liFirst = $(ul).find('li:first');
                 $(liFirst).next().addClass('primero');

                newCurrentLi = $(ul).find('li.current');
                newliPosition = $(newCurrentLi).position().left;

                $(ul).css({
                    left: (newliPosition *-1) +( $(currentLi).outerWidth(true) ) + 'px'
                 });
             

          }else{
             $(ul).css({
                left:  (newliPosition *-1) +( $(currentLi).outerWidth(true) ) + 'px'
             }); 
          } 
        }else{
            $(ul).css({
                left:  (newliPosition *-1) +( $(currentLi).outerWidth(true) ) + 'px'
             }); 
        }
//-------------------------------------------------------------------------------FICHA INICIO   

         js.cargaFichaInicio(programID); 
//-------------------------------------------------------------------------------HORARIOS INICIO 
         js.cargaHorarioInicio(programidHorario); 
  
    },
    menuAjustes : function(item){
        
        if($(item).hasClass('active')){
            $(item).removeClass('active');
            $(item).next().css('display','none');
        }else{
           $(item).addClass('active');
           $(item).next().css('display','block'); 
        }
    },
    cargaFichaInicio : function(programID, type){
        var currentTab = $('#nav').find('li').find('a.current').attr('data-tab');
        var hostname = window.location.hostname;
        
        if(type == 'destacado'){
            currentTab = 1;
        } 
        else if(type == 'favorito'){
            currentTab = 3;
        }

        $.ajax({
            type: "GET",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: "ajax_tablet",
                programid: programID,
                date: 'no',
                county: localStorage.getItem("county"),
                format: 'json'
            },
            dataType: "json",
            beforeSend: function( xhvalr ) {
                $('#tabs').find('li[data-tab="'+currentTab+'"]').find('#infoFicha').find('.metaFicha').html('');
                $('#tabs').find('li[data-tab="'+currentTab+'"]').find('#infoFicha').find('.metaFicha').append('<img class="ajaxLoad" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/ajax-loader.gif" />');
            },
            success: function(data) {
                var html = '<div id="wrapperFicha">';
                var permalink
                var p = "";
                
                if(data != null){
                    html += '<h1>'+data[0].title;
                    if(data[0].mpaarating != 'none'){
                        html += '<span class="clasificacion">'+data[0].mpaarating+'</span>';
                    }
                    html += '</h1>';
                    permalink = data[0].permalink;
                    if(permalink == undefined){
                        permalink = 'http://'+hostname;
                    }
                    html += '<ul class="sociales">';
                    html += '<li><a href="http://www.facebook.com/share.php?u='+permalink+'&title='+data[0].title+'" target="_blank"><img src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/facebook.png" /></a></li>';
                    html += '<li><a href="http://twitter.com/home?status=Estoy viendo la ficha de +'+data[0].title+' desde mi Tablet: +'+permalink+' %23GuíaTV"" target="_blank"><img src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/twitter.png" /></a></li>';
                    html += '<li><input data-program="'+data[0].programid+'" type="checkbox" class="favorito Watchevt watch" data-event="change" name="favoritos" data-func="addFavorito" value=""/></li>';
                    html += '</ul>';
                    html += '<div class="datosFicha">';
                    if(data[0].gender){
                        html += '<div class="dataWrap">Género: <span class="resultDato">'+data[0].gender+'</span></div>';
                    }
                    if(data[0].ano){
                        html += '<div class="dataWrap">Año: <span class="resultDato">'+data[0].ano+'</span></div>';
                    }
                    if(data[0].director){
                        html += '<div class="dataWrap">Director: <span class="resultDato">'+data[0].director+'</span></div>';
                    }
                    if(data[0].actor1 || data[0].actor2 || data[0].actor3 || data[0].actor4 || data[0].actor5 || data[0].actor6){
                        html += '<div class="dataWrap">Protagonistas: <span class="resultDato">';
                        if(data[0].actor1 != undefined){
                            p += data[0].actor1+', ';
                        }
                        if(data[0].actor2 != undefined){
                            p += data[0].actor2+', ';
                        }
                        if(data[0].actor3 != undefined){
                            p += data[0].actor3+', ';
                        }
                        if(data[0].actor4 != undefined){
                            p += data[0].actor4+', ';
                        }
                        if(data[0].actor5 != undefined){
                            p += data[0].actor5+', ';
                        }
                        if(data[0].actor6 != undefined){
                            p += data[0].actor6+', ';
                        }
                        p = p.substring(0, p.length-2);
                        html += p+'.';
                        html += '</span></div>';
                    }
                    html += '</div>';
                    if(data[0].description){
                        html += '<p>'+data[0].description+'</p>';
                    }
                    html += '</div>';
                    
                    

                    $('#tabs').find('li[data-tab="'+currentTab+'"]').find('#infoFicha').find('.metaFicha').css('opacity','1.0');
                    $('#tabs').find('li[data-tab="'+currentTab+'"]').find('#infoFicha').find('.metaFicha').html(html);
                    js.marcaFavoritos(); 
                    $('.Watchevt').evt();
                    js.scrollBar($('.metaFicha'));
//                    js.svgFallBack();
                }
            },
            error : function() { }
        });
    },
    cargaHorarioInicio : function(programID, ficha, type){
        var currentTab = $('#nav').find('li').find('a.current').attr('data-tab');
        var hostname = window.location.hostname;
        
        if(type == 'destacado'){
            currentTab = 1;
        } 
        else if(type == 'favorito'){
            currentTab = 3;
        }
        
        if(!ficha){
            ficha = "";
        }
        
        $.ajax({
            type: "GET",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: "ajax_tablet",
                programid: programID,
                date: 'no',
                agrupar: 'no',
                horarios: true,
                county: localStorage.getItem("county"),
                format: 'json'
            },
            dataType: "json",
            beforeSend: function( xhvalr ) {
                $('#tabs').find('li[data-tab="'+currentTab+'"]').find('#infoFicha').find('#horariosFicha').html('');
                $('#tabs').find('li[data-tab="'+currentTab+'"]').find('#infoFicha').find('#horariosFicha').addClass('empty');
                $('#horariosFicha').append('<img class="ajaxLoad" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/ajax-loader.gif" />');
                
            },
            success: function(data) {

                if( data != null){
                   
                var html = '<div id="wrapperFicha" class="horarios">';
                var hostname = window.location.hostname;
                var date = "";
                var time = "";
                var ciudad;
                
                html += '<h3>horarios</h3>';
                html += '<ul>';
                $.each(data, function(key, value) {
                    ciudad = data[key].city;
                    ciudad = ciudad.toLowerCase();

                    if(data[key][ciudad] != undefined ){
                        html += '<li>';
//                        if(data[key].tipo == 'Con d-Box'){
//                           html += '<span class="onDemand">Vealo en Vtr Ondemand</span>'; 
//                        }else{
                           html += '<span class="dia">'+data[key].horariodate+'</span>';
                           html += '<span class="hora">'+data[key].startime+'</span>'; 
//                        }
                        
                        html += '<span class="canal">Canal '+data[key][ciudad]+'</span>';
                        html += '</li>';
                    }

                });
                html += '</ul>';            
                
                if(ficha == 'si'){
                    $('#infoFichaCompleta').find('#horariosFicha').html(html)
                    $('#infoFichaCompleta').find('#horariosFicha').removeClass('empty');
                }else{
                    $('#tabs').find('li[data-tab="'+currentTab+'"]').find('#infoFicha').find('#horariosFicha').css('opacity','1.0');
                    $('#tabs').find('li[data-tab="'+currentTab+'"]').find('#infoFicha').find('#horariosFicha').html(html);
                    $('#tabs').find('li[data-tab="'+currentTab+'"]').find('#infoFicha').find('#horariosFicha').removeClass('empty');
                    
                }
                html += '</div>';
               $('#horariosFicha').find('ul:empty').append('<div class="noResults"><p>En estos momentos no hay canales que transmitan éste programa en tu ciudad</p></div>');
                }else{
                    if($('#horariosFicha').hasClass('empty')){
     
                        $('#horariosFicha').html('<h3>horarios</h3><div class="noResults"><p>En estos momentos no hay programación para este programa.</p></div>');
                        $('#horariosFicha').removeClass('empty');
                    }else{
                        
                    }
                    $('#horariosFicha').find('ul:empty').append('<div class="noResults"><p>En estos momentos no hay canales que transmitan éste programa en tu ciudad</p></div>');
                    
                }
                js.scrollBar($('#horariosFicha'));
            },
            error : function() { }
        });
      
    },
    addFavorito : function(item){
        var programID = $(item).attr("data-program");
        
        if($(item).is(":checked")){
            savelocalTablet(programID, "favoritos", 6);
            js.loadFavoritosTab();
            
        }
        else {
             deleteLocalTablet(programID, "favoritos");
             js.loadFavoritosTab();
        }
        
     
        
    },  
    marcaFavoritos : function(ficha){
        var currentTab = $('#nav').find('a.current').attr('data-tab');
        var favoritos = localStorage.getItem("favoritos");
        var parslocal;
        var cont = 0;
        var programID;
        if(currentTab == 1 || currentTab == 3){
            programID = $('#tabs').find('li[data-tab="'+currentTab+'"]').find('input.watch').attr('data-program');

             if(favoritos != null && favoritos != "" && favoritos != false && favoritos != undefined){
                 parslocal = JSON.parse(favoritos);
                 $.each(parslocal, function(index, value){
                            cont = index;
                            if(this == programID){
                                $('#tabs').find('li[data-tab="'+currentTab+'"]').find('input.watch[data-program="'+programID+'"]').attr("checked",true);
                            }   
                 });
                   
             }

        }
        else if(currentTab == 2 && ficha != 'ficha'){
            var allprogramsID = new Array();
            
            $.each($('#tabs').find('li[data-tab="'+currentTab+'"]').find('input.watch'), function(index, value){
                allprogramsID[cont] = $(this).attr('data-program');
                cont++;
            });
            
            if(favoritos != null && favoritos != "" && favoritos != false && favoritos != undefined){
                 parslocal = JSON.parse(favoritos);
                 $.each(parslocal, function(index, value){
                            cont = index;
                            
                            $.each(allprogramsID, function(i, valor){
                                if(value == this){
                                $('#tabs').find('li[data-tab="'+currentTab+'"]').find('input.watch[data-program="'+value+'"]').attr("checked",true);
                            }   
                            });
                            
                 });
                 if(cont >= 5){
//                            $('input.watch').not(':checked').attr("disabled","disabled");
                 }   
             }
            
        }
        else if(ficha == 'ficha'){
            programID = $('#infoFichaCompleta').find('input.watch').attr('data-program');

             if(favoritos != null && favoritos != "" && favoritos != false && favoritos != undefined){
                 parslocal = JSON.parse(favoritos);
                 $.each(parslocal, function(index, value){
                            cont = index;
                            if(this == programID){
                                $('#infoFichaCompleta').find('input.watch[data-program="'+programID+'"]').attr("checked",true);
                            }   
                 });
                 if(cont >= 5){
                            $('#infoFichaCompleta').find('input.watch').not(':checked').attr("disabled","disabled");
                 }   
             }
        }

    },
    loadCarruselDestacado : function(){
        $.ajax({
        type: "GET",
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: "ajax_tablet",
            display: "inicio",
            destacados: true,
            date: 'no',
            height: '250',
            width: '450',
            county: localStorage.getItem("county"),
            format: 'json'
        },
        dataType: "json",
        beforeSend: function( xhvalr ) {
            $('.ajaxLoader').show();
        },
        success: function(data) {
            $('.ajaxLoader').hide();
            var html = "";
            var cont = 0;
            var currentClass = '';
            
            //oculta el carrusel de favoritos al inicio
            $('.innerCarrousel').find('ul[data-carrusel="2"]').hide();
            
            html += '<div id="carrousel">';
            html += '<div class="innerCarrousel"><ul class="transition" data-carrusel="1">';
            $.each(data, function(key, value) {
                if(cont == 1){
                    currentClass = 'current';
                }else if(cont == 0){
                    currentClass = 'clonarRight';
                }else{
                    currentClass = 'else';
                }   
                html += '<li class="slide fourcol evtNew '+currentClass+'" data-col="0" data-program="'+data[key].programid+'" data-allProg = "'+data[key].allprograms+'" data-func="loadFichaInicio"><figure><img src="'+data[key].imagedest+'" /><figcaption class="fichaTitle"><div class="wrap"><h2>'+data[key].title+'</h2><span>'+data[key].senal+'</span></div></figcaption></figure></li>';
                cont++;
            });
            html += '</ul>';  
            html += '</div>';
            
            html += '<div id="infoFicha">';
            html += '<div class="relativeWrapp fichaDescription">';
            html += '<div class="metaFicha">';

            html += '</div>';
            html += '<div class="scrollbar">';
            html += '<div class="scroll">';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="relativeWrapp fichaHorarios">';
            html += '<div id="horariosFicha">';
            
            html += '</div>';
            html += '<div class="scrollbar">';
            html += '<div class="scroll">';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            
            $('#tabs li[data-tab="1"]').html(html);
            $('.innerCarrousel ul').find('li:last').addClass('clonarLeft');
            $(".evtNew").evt(); 
            js.carousel();
            var programid = $('.innerCarrousel').find('ul[data-carrusel="1"]').find('li.current').attr('data-program');
            var programidHorario = $('.innerCarrousel').find('ul[data-carrusel="1"]').find('li.current').attr('data-allProg');
            js.cargaFichaInicio(programid, 'destacado');
            js.cargaHorarioInicio(programidHorario, '', 'destacado');
            
        },
        error : function() { }
    });
    },
    loadFavoritosTab : function(){
        var getlocal = localStorage.getItem('favoritos');
        var programid;
      
        if(getlocal != null && getlocal != "" && getlocal != false && getlocal != undefined){
            var parslocal = JSON.parse(getlocal);
            programid = parslocal.join(',');
        }else{
            programid = 0;
        }
        
        $.ajax({
        type: "GET",
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: "ajax_tablet",
            display: "inicio",
            date: 'no',
            programid : programid,
            county: localStorage.getItem("county"),
            favoritos: true,
            height: '250',
            width: '450',
            format: 'json'
        },
        dataType: "json",
        beforeSend: function( xhvalr ) {
            $('.ajaxLoader').show();
        },
        success: function(data) {
            $('.ajaxLoader').hide();
            var html = "";
            var cont = 0;
            var currentClass = '';
            var hostname = window.location.hostname;
            
            if(data != null){
                html += '<div id="carrousel">';
                html += '<div class="innerCarrousel"><ul class="transition" data-carrusel="2">';
                $.each(data, function(key, value) {
                    
                    var imgSrc = data[key].imagedest;
                    
                    if(cont == 1){
                        currentClass = 'current';
                    }else if(cont == 0){
                        currentClass = 'clonarRight';
                    }else{
                        currentClass = 'else';
                    } 
                    
                    if(data[key].ficha == 'no'){
                        
                        if(data[key].genero == 'series-peliculas'){
                            imgSrc = 'http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaSeries.jpg';
                        }else if(data[key].genero == 'tendencias'){
                            imgSrc = 'http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaTendencias.jpg';
                        }else if(data[key].genero == 'Alta Definición'){
                            imgSrc = 'http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaHD.jpg';
                        }else if(data[key].genero == 'Cultural'){
                            imgSrc = 'http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaCultura.jpg';
                        }else if(data[key].genero == 'Noticias'){
                            imgSrc = 'http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaNoticias.jpg';
                        }else if(data[key].genero == 'Musica'){
                            imgSrc = 'http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaMusica.jpg';
                        }else if(data[key].genero == 'Infantil'){
                            imgSrc = 'http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaInfantil.jpg';
                        }else if(data[key].genero == 'Nacional'){
                            imgSrc = 'http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaNcional.jpg';
                        }else if(data[key].genero == 'Deportes'){
                            imgSrc = 'http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaDeportes.jpg';
                        }else if(data[key].genero == 'Adulto'){
                            imgSrc = 'http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaAdulto.jpg';
                        }else if(data[key].genero == 'Internacional'){
                            imgSrc = 'http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaInternacional.jpg';
                        }else if(data[key].genero == 'Compra de Eventos'){
                            imgSrc = 'http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/tramaCompra.jpg';
                        }
                    }
                        html += '<li class="slide fourcol evtFav '+currentClass+'" data-col="0" data-program="'+data[key].programid+'" data-allProg = "'+data[key].allprograms+'" data-gender="'+data[key].genero+'" data-func="loadFichaInicio"><figure><img src="'+imgSrc+'" /><figcaption class="fichaTitle"><div class="wrap"><h2>'+data[key].title+'</h2><span>'+data[key].senal+'</span></div></figcaption></figure></li>';
                    cont++;
                });
                
                html += '</ul>';  
                html += '</div>';

                html += '<div id="infoFicha">';
                html += '<div class="relativeWrapp fichaDescription">';
                html += '<div class="metaFicha">';
                html += '</div>';
                html += '<div class="scrollbar">';
                html += '<div class="scroll">';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '<div class="relativeWrapp fichaHorarios">';
                html += '<div id="horariosFicha">';
                html += '</div>';
                html += '<div class="scrollbar">';
                html += '<div class="scroll">';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                $('#tabs li[data-tab="3"]').html(html);
                $('.innerCarrousel ul').find('li:last').addClass('clonarLeft');
                var lastLi = $('.innerCarrousel ul').find('li:last-child').addClass('clonarLeft');
                if(cont == 1){
                    var onlyLi = $('.innerCarrousel ul').find('li');
                    
                    $(onlyLi).addClass('current');
                    $(onlyLi).parent().css('left',onlyLi.outerWidth(true)+'px');
                }
                $(".evtFav").evt(); 
                js.carousel();
                var programid = $('.innerCarrousel').find('ul[data-carrusel="2"]').find('li.current').attr('data-program');
                var programidHorario = $('.innerCarrousel').find('ul[data-carrusel="2"]').find('li.current').attr('data-allProg');
                js.cargaFichaInicio(programid, 'favorito');
                js.cargaHorarioInicio(programidHorario,'', 'favorito');
                }else{
                  $('#tabs li[data-tab="3"]').html('<p class="error">No has seleccionado ningún programa como favorito.</p>');
                  localStorage.removeItem('favoritos');
                }

        },
        error : function() {
        
    }
    });
        
    },
    loadGuia : function(gender){
        if(!gender){
            gender = "";
        }
        var hostname = window.location.hostname;
        $.ajax({
        type: "GET",
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: "ajax_tablet",
            when: 'now',
            genre: gender,
            county: localStorage.getItem("county"),
            format: 'json'
        },
        dataType: "json",
        beforeSend: function( xhvalr ) {
            $('.ajaxLoader').show();
        },
        success: function(data) {
            $('.ajaxLoader').hide();
            var html = "";
            var today;
            
            if(data != null){

                html +='<div id="catNav" class="lista">';
                html +='<ul id="catList">';          
                html +='</ul>';
                html +='</div>';
                html +='<div id="guiaContent">';
                html +='<div class="guiaHeader">';
                html +='<div class="selectionDate">';
                today = data[0].today;
                today = today.split(' ');
                html +='<h2>'+today[0].charAt(0).toUpperCase()+ today[0].slice(1)+'</h2>';
                html +='<span>'+today[1]+' '+today[2].charAt(0).toUpperCase()+ today[2].slice(1)+'</span>';
                html +='<select id="calendario" class="evtGuia" data-func="loadDates" data-event="change">';
                html += data[0].options;
                html +='</select>';
                html +='</div>';
                html +='<div class="horarioGuia">';
                html +='<span>Horarios:</span>';
                html +='<select id="selectHorario" class="selectClass evtGuia" data-func="loadDates" data-event="change">';
                html +='<option value="now">A esta hora</option>';
                html +='<option value="tostart">Por Comenzar</option>';
                html +='<option value="prime">En la noche</option>';
                html +='</select>';
                html +='</div>';
                html +='</div>';
                html += '<div class="relativeWrapp guiaTv">';
                html +='<div id="mainGuiaCont" class="lista">';

                html +='</div>';
                html += '<div class="scrollbar">';
                html += '<div class="scroll">';
                html += '</div>';
                html += '</div>';
                html +='</div>';
                html +='</div>';

                $('#tabs li[data-tab="2"]').html(html);
                $('#mainGuiaCont').css('opacity','1.0');

                js.loadGuiaContent();
                js.categoriesList();
                js.totalWidth();
            }
        },
        error : function() { }
    });
    },
    categoriesList : function() {
            var html = "";
            var localGenders = localStorage.getItem("categorias");
            var dataGender;
            var num;
            var itemsarray = [];

            if(localGenders != null && localGenders != "" && localGenders != false && localGenders != undefined){
                var parslocal = JSON.parse(localGenders);
                html +='<li><a class="cat num_1 evtGuia current" href="#" data-all="ok" data-gender="" data-func="loadGender">Todas las Categorías</a></li>';
                
                $.each(parslocal, function(index, value){
                    dataGender = value;
                    if(value == 'series-peliculas'){ num = 2;value = 'Cine y Series';}
                    else if(value == 'infantil'){num = 3;}
                    else if(value == 'deportes'){num = 4;}
                    else if(value == 'musica'){num = 5;}
                    else if(value == 'tendencias'){num = 6;}
                    else if(value == 'cultural'){num = 7;value = 'Cultura'}
                    else if(value == 'noticias'){num = 8;}
                    else if(value == 'nacional'){num = 11;}
                    else if(value == 'intern'){ num = 12;value = 'Internacional';}
                    else if(value == 'adulto'){num = 13;}
                    else if(value == 'compra-eventos'){num = 14; value = 'Eventos Pagados';}
                    itemsarray[value] = '<li><a class="cat num_'+num+' evtGuia" href="#" data-gender="'+dataGender+'" data-func="loadGender">'+value.charAt(0).toUpperCase()+ value.slice(1)+'</a></li>';
                });
                if(typeof(itemsarray['Cine y Series']) != 'undefined')
                    html += itemsarray['Cine y Series'];
                html +='<li><a class="cat num_10 evtGuia" href="#" data-cat="premium" data-func="loadGender">Premium</a></li>';
                if(typeof(itemsarray['Eventos Pagados']) != 'undefined')
                    html += itemsarray['Eventos Pagados'];
                if(typeof(itemsarray['deportes']) != 'undefined')
                    html += itemsarray['deportes'];
                if(typeof(itemsarray['infantil']) != 'undefined')
                    html += itemsarray['infantil'];
                if(typeof(itemsarray['Cultura']) != 'undefined')
                    html += itemsarray['Cultura'];
                if(typeof(itemsarray['musica']) != 'undefined')
                    html += itemsarray['musica'];
                if(typeof(itemsarray['tendencias']) != 'undefined')
                    html += itemsarray['tendencias'];
                if(typeof(itemsarray['noticias']) != 'undefined')
                    html += itemsarray['noticias'];
                if(typeof(itemsarray['nacional']) != 'undefined')
                    html += itemsarray['nacional'];
                if(typeof(itemsarray['Internacional']) != 'undefined')
                    html += itemsarray['Internacional'];
                html +='<li><a class="cat num_9 evtGuia" href="#" data-gender="hd" data-func="loadGender">HD</a></li>';
                if(typeof(itemsarray['adulto']) != 'undefined')
                    html += itemsarray['adulto'];
                

            }else if (localStorage.getItem('recurrente') == null){
                html +='<li><a class="cat num_1 evtGuia current" href="#" data-all="ok" data-gender="" data-func="loadGender">Todas las Categorías</a></li>';
                html +='<li><a class="cat num_2 evtGuia" href="#" data-gender="series-peliculas" data-func="loadGender">Cine y Series</a></li>';
                html +='<li><a class="cat num_10 evtGuia" href="#" data-cat="premium" data-func="loadGender">Premium</a></li>';
                html +='<li><a class="cat num_14 evtGuia" href="#" data-gender="compra-eventos" data-func="loadGender">Eventos Pagados</a></li>';
                html +='<li><a class="cat num_4 evtGuia" href="#" data-gender="deportes" data-func="loadGender">Deportes</a></li>';
                html +='<li><a class="cat num_3 evtGuia" href="#" data-gender="infantil" data-func="loadGender">Infantil</a></li>';
                html +='<li><a class="cat num_7 evtGuia" href="#" data-gender="cultural" data-func="loadGender">Cultura</a></li>';
                html +='<li><a class="cat num_5 evtGuia" href="#" data-gender="musica" data-func="loadGender">Música</a></li>';
                html +='<li><a class="cat num_6 evtGuia" href="#" data-gender="tendencias" data-func="loadGender">Tendencias</a></li>';
                html +='<li><a class="cat num_8 evtGuia" href="#" data-gender="noticias" data-func="loadGender">Noticias</a></li>';
                html +='<li><a class="cat num_11 evtGuia" href="#" data-gender="nacional" data-func="loadGender">Nacional</a></li>';
                html +='<li><a class="cat num_12 evtGuia" href="#" data-gender="intern" data-func="loadGender">Internacional</a></li>';
                html +='<li><a class="cat num_9 evtGuia" href="#" data-gender="hd" data-func="loadGender">HD</a></li>';
                html +='<li><a class="cat num_13 evtGuia" href="#" data-gender="adulto" data-func="loadGender">Adulto</a></li>';
                
            }else if (localStorage.getItem('recurrente') == true || localStorage.getItem("categorias") == null){
                html +='<li><a class="cat num_1 evtGuia current" href="#" data-all="ok" data-gender="" data-func="loadGender">Todas las Categorías</a></li>';
                html +='<li><a class="cat num_10 evtGuia" href="#" data-cat="premium" data-func="loadGender">Premium</a></li>';
                html +='<li><a class="cat num_9 evtGuia" href="#" data-gender="hd" data-func="loadGender">HD</a></li>';
            }
             
            

            $('#catList').html(html);
            $('.evtGuia').evt();

    },
    loadGuiaContent : function(){
        var genders = new Array();
        var gender;
        var cont = 0;
        var category;
        var lastLi = $('#catList').find('a.current').length;
        
        //---------------------------------------------------------------------------Obtiene Gender
        if($('#catList').find('a.current').attr('data-all') == "ok"){
            genders = "";   
        }
        else{
            var li = $('#catList').find('li');
            $.each(li, function(index, element) {
                if($(element).find('a.current').attr('data-gender') != undefined && $(element).find('a.current').attr('data-gender') != ""){
                    genders[cont] = $(element).find('a.current').attr('data-gender');
                    cont++;
                }
            });

           gender = genders.join(',');
           category =  $('#catList').find('a.current[data-cat]').attr('data-cat');
           if(category == 'premium'){
               $('#catList').find('a[data-all]').removeClass('current');
           }
        }
        
        
        if(!gender){
            gender = "";
        }
        if(!category){
            category = "";
        }
        if(gender != ""){
           var currentGender = gender.split(','); 
        }
        
        //---------------------------------------------------------------------------Obtiene Fecha
        var dateSelected = $('#calendario').find('option:selected').val();
        
        if(!dateSelected){
            dateSelected = "";
        }
        //---------------------------------------------------------------------------Obtiene Horario      
        var timeSelected = $('#selectHorario').find('option:selected').val();
        if(!timeSelected){
            timeSelected = "";
        }
        //---------------------------------------------------------------------------LLamado de datos
        
        var hostname = window.location.hostname;
        
        $.ajax({
        type: "GET",
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: "ajax_tablet",
            when: timeSelected,
            genre: gender,
            date: dateSelected,
            category: category,
            county: localStorage.getItem("county"),
            guia: true,
            format: 'json'
        },
        dataType: "json",
        beforeSend: function( xhvalr ) {
            $('#mainGuiaCont').html('');
            $('#mainGuiaCont').append('<img class="ajaxLoad" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/ajax-loader.gif" />');
        },
        success: function(data) {

            if(data != null){
                var html = '<div id="wrapperFicha">';
                var ciudad;
                
                var today;
                today = data[0].today;
                today = today.split(' ');

                if(dateSelected){
                    var dia = today[0].charAt(0).toUpperCase()+ today[0].slice(1);
                    var numDia = today[1];
                    var mes = today[2].charAt(0).toUpperCase()+ today[2].slice(1);
                    $('.selectionDate').find('h2').html(dia);
                    $('.selectionDate').find('span').html(numDia+' '+mes);
                }

                html +='<ul>';
                $.each(data, function(key, value) {
                    ciudad = data[key].city;
                    ciudad = ciudad.toLowerCase();
                    if(data[key][ciudad] != undefined){
                        html +='<li>';
                        html +='<div class="channel">';
                        html +='<img class="channelImg" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/foto/'+data[key].imagen+'" />';
                        html +='<div class="channelData">';
                        html +='<span class="channelTitle">'+data[key].senal+'</span>';
                        html +='<span class="channelNum"><strong>'+data[key][ciudad]+'</strong></span>'; 
                        html +='</div>';
                        html +='</div>';
                        html +='<a href="" class="evtFicha" data-program="'+data[key].programid+'" data-allProg="'+data[key].allprograms+'" data-func="loadFicha">';
                        html +='<span class="program">';
                        html +='<span class="programTitle"><strong>'+data[key].title+'</strong></span>';
                        html +='<span class="programDate">'+data[key].startime+' a '+data[key].endtime+'</span>';
                        html +='<span class="programMeta">';
                        if(data[key].ficha == '1' && data[key].ficha != 'no'){
                            html +='<span class="ficha"><img src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/fichaIcon.png" /></span>';
                        }
                        if(data[key].mpaarating && data[key].mpaarating != 'none'){
                            html +='<span class="clasificacion">'+data[key].mpaarating+'</span>'; 
                        }
                        html +='</span>'; 
                        html +='</span>';   
                        html +='</a>';
                        html +='<input data-program="'+data[key].programid+'" data-func="addFavorito" type="checkbox" class="favorito evtFicha watch" data-event="change" name="favoritos"  value=""/>';
                        html +='</li>';
                    }
                    
                });
                html +='</ul>';
                html +='</div>';


                $('#mainGuiaCont').html(html);
                $('#mainGuiaCont').css('opacity','1.0');
                
                
                $('.evtFicha').evt();
                js.marcaFavoritos();
                setTimeout(function(){
                    js.scrollBar('#mainGuiaCont');
                }, 5000);
                
            }else{
                $('#mainGuiaCont').html('<p class="error">No se han encontrado canales o programas en la categoría seleccionada, horario o día.</p>');
                $('#mainGuiaCont').css('opacity','1.0');
            }
            
            $('#mainGuiaCont').find('ul:empty').append('<p class="error">No se han encontrado canales o programas de la categoría especificada en tu ciudad.</p>');
            
        },
        error : function() { 

        }
    });
    },
    loadGender : function(item){
          
        if($(item).hasClass('current')){ 
            $(item).removeClass('current'); 
        }else{
            $(item).addClass('current');
        }
        if(!$(item).attr('data-all')){
            $(item).parent().parent().find('a[data-all]').removeClass('current');
        }else{
            $(item).parent().parent().find('a.current').not($(item)).removeClass('current');
        }
        if($(item).parent().parent().find('a.current').length == 0 ){
            $(item).parent().parent().find('a[data-all]').addClass('current');
        }

       js.loadGuiaContent();
    },
    loadDates : function(item){
       js.loadGuiaContent(); 
    },
    loadUbicacion : function (item){
        var html = "";
        var hostname = window.location.hostname;
        var blockHeight = $('#mainCont').height(),
            halfWidth;
        $('li.ajustes a.ajustesIcon').removeAttr('data-func');
        $('#tabs').css('height','0px');
        $('#callFicha').hide();
        $('.blocker').show().height($('.container').height());
         $.ajax({
        type: "GET",
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: "ajax_tablet",
            county: localStorage.getItem("county"),
            when:'now',
            regiones: 'regiones',
            format: 'json'
        },
        dataType: "json",
        beforeSend: function( xhvalr ) {
            $('.ajaxLoader').show();
            $('.searchContent').html('');
            $('.searchContent').append('<img class="ajaxLoad" src="http://'+hostname+'/wp-content/themes/comunidadtv/img/tablet/ajax-loader.gif" />');
        },
        success: function(data) {
            $('.ajaxLoader').hide();
            html += '<div id="selectUbicacion">';
            html += '<span class="ubicacion">Tu ubicación actual es: '+localStorage.getItem("ciudad")+'</span>';
            html += '<span class="ubicacion">Tu grilla actual es: '+localStorage.getItem("county")+'</span>';
            html += '<select id="region" class="selectClass evtRegion" data-func="selectComuna" data-event="change">';
            html += '<option value="">Seleccione su Región</option>';
            html += data[0].regiones;
            html += '</select>';
            html += '<select id="comuna" class="selectClass">';
            html += '<option value="">Selecciona tu Comuna</option>'
            html += '</select>';
            html += '<a href="" class="evtChange" data-func="changeCity">Guardar</a>';
            html += '<a href="" class="evtChange" data-func="resetAll">Reiniciar</a>';
            html += '</div>';
            html += '<a class="closeFicha evtRegion" data-func="cerrarFicha">Cerrar</a>';

            $(item).parent().parent().hide();
            $(item).parent().parent().parent().find('a').removeClass('active');


            halfWidth = $('.searchContent').width() / 2;
            $('.searchContent').css('margin-left','-'+halfWidth+'px')

            $('.searchContent').html(html);
            $('.searchContent').show();
            $('.evtRegion').evt();
            $('.evtChange').evt();
   
        },
        error : function() { 

        }
    });
        
    },
    selectComuna : function(item){
        var valor = $(item).find("option:selected").val();
        $.ajax({
            type: "GET",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: "ajax_tablet",
                comuna: valor,
                when: 'now',
                format: 'json'
            },
            dataType: "json",
            beforeSend: function( xhvalr ) {
                
            },
            success: function(data) {
                var html = "";
                html += data[0].comunas;
                $("select#comuna").html(html);
                
            },
            error : function() { }
        });
    },
    changeCity : function(item){
        var county = $(item).parent().find("#comuna").find("option:selected").val();
        var city = $(item).parent().find("#region").find("option:selected").text();
        if(county){
            localStorage.setItem("ciudad", city);
            localStorage.setItem("county", county);
            localStorage.removeItem("reset");
            inicial();
            $('#nav').find('a[data-tab="1"]').trigger('click');
            $('.searchContent').hide();
            $('.blocker').hide();
            $('li.ajustes a.ajustesIcon').attr('data-func','menuAjustes');
            $('#tabs').css('height','auto');
            $('.innerCarrousel ul').css('display','block');
        }else{
            alert('Debe seleccionar una Región y luego una Comuna')
        }
      
    },
    loadCategorias : function(item){
        var html = "";
        var blockHeight = $(window).height() - 130,
            halfWidth;
            
            html += '<div class="innerSearch">';
            html += '<ul id="categoriesAdmin">';
            html += '<li class="catAdmin num_2">Cine y series<input class="checkCategory evtCategories" data-func="addCategories" data-event="change" type="checkbox" value="series-peliculas"></li>';
            html += '<li class="catAdmin num_14">Eventos pagados<input class="checkCategory evtCategories" data-func="addCategories" data-event="change" type="checkbox" value="compra-eventos"></li>';
            html += '<li class="catAdmin num_4">Deportes<input class="checkCategory evtCategories" data-func="addCategories" data-event="change" type="checkbox" value="deportes"></li>';
            html += '<li class="catAdmin num_3">Infantil<input class="checkCategory evtCategories" data-func="addCategories" data-event="change" type="checkbox" value="infantil"></li>';
            html += '<li class="catAdmin num_7">Cultura<input class="checkCategory evtCategories" data-func="addCategories" data-event="change" type="checkbox" value="cultural"></li>';
            html += '<li class="catAdmin num_5">Música<input class="checkCategory evtCategories" data-func="addCategories" data-event="change" type="checkbox" value="musica"></li>';
            html += '<li class="catAdmin num_6">Tendencias<input class="checkCategory evtCategories" data-func="addCategories" data-event="change" type="checkbox" value="tendencias"></li>';
            html += '<li class="catAdmin num_8">Noticias<input class="checkCategory evtCategories" data-func="addCategories" data-event="change" type="checkbox" value="noticias"></li>';
            html += '<li class="catAdmin num_11">Nacional<input class="checkCategory evtCategories" data-func="addCategories" data-event="change" type="checkbox" value="nacional"></li>';
            html += '<li class="catAdmin num_12">Internacional<input class="checkCategory evtCategories" data-func="addCategories" data-event="change" type="checkbox" value="intern"></li>';
            html += '<li class="catAdmin num_13">Adulto<input class="checkCategory evtCategories" data-func="addCategories" data-event="change" type="checkbox" value="adulto"></li>';
            html += '</ul>';
            html += '</div>';
            html += '<a class="closeFicha evtCategories" data-func="cerrarFicha">Cerrar</a>';

            $(item).parent().parent().hide();
            $(item).parent().parent().parent().find('a').removeClass('active');

            blockHeight = blockHeight + $('#nav').height();
            $('#callFicha').hide();
            $('.blocker').show('').height(blockHeight);
            
            halfWidth = ($('.searchContent').width()) / 2;
            $('.searchContent').css('margin-left','-'+halfWidth+'px')
            
            $('.searchContent').html(html);
            $('.searchContent').show();
            $('.evtCategories').evt();
            
            js.adminCategories();

    },
    adminCategories : function(){
        
        var localGenders = localStorage.getItem("categorias");
        var check = $('input.checkCategory');
        
        if(localGenders != null && localGenders != "" && localGenders != false && localGenders != undefined){
                    var parslocal = JSON.parse(localGenders);

                    $.each(parslocal, function(index, value){
                        var val = value;
                            
                        check.each(function(index, value){
                            if($(this).val() == val){
                                $(this).attr('checked','checked');
                                return false;         
                            }
                        });
                    });
                    
        }
        else if(localStorage.getItem('recurrente') == null){
           localStorage.setItem('recurrente',true);
           check.each(function(index, value){
                $(this).attr('checked','checked');
                savelocalTablet($(this).val(), "categorias", 11);
           });
        }
    },
    addCategories : function(item){
        var val = $(item).val();
        if($(item).is(":checked")){
            savelocalTablet(val, "categorias", 11)
            js.categoriesList();
        }
        else {
             deleteLocalTablet(val, "categorias");
             js.categoriesList();
        }

    },
    getLocation : function(position){
        var lat = position.coords.latitude;
        var lng = position.coords.longitude; 
    
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(lat, lng);
        geocoder.geocode({
            'latLng': latlng
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {

                if (results[1]) {
                    //formatted address
                    //find country name
                    for (var i=0; i<results[0].address_components.length; i++) {
                        for (var b=0;b<results[0].address_components[i].types.length;b++) {

                            //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
                            if (results[0].address_components[i].types[b] == "administrative_area_level_3") {
                                //this is the object you are looking for
                                comuna= results[0].address_components[i];
                                break;
                            }
                            if (results[0].address_components[i].types[b] == "administrative_area_level_2") {
                                //this is the object you are looking for
                                ciudad= results[0].address_components[i];
                                break;
                            }
                        }
                    }
                                
                    //si no existe una ciudad en local storage, agrega la actual
                    if(!localStorage.getItem("county") && !localStorage.getItem("reset")){
                        localStorage.setItem("ciudad", ciudad.short_name);
                        localStorage.setItem("county", comuna.short_name);
                        localStorage.removeItem("reset");
                    }
                
                }
                
            }
            
        });
    },
    errorCallback : function(error){
        switch(error.code) 
            {
                    case error.TIMEOUT:
                            if(!localStorage.getItem("county")){
                                localStorage.setItem("ciudad", 'Santiago');
                                localStorage.setItem("county", 'Santiago');
                                localStorage.setItem("reset", 'reset');
                            }
                            break;
                    case error.POSITION_UNAVAILABLE:
                            if(!localStorage.getItem("county")){
                                localStorage.setItem("ciudad", 'Santiago');
                                localStorage.setItem("county", 'Santiago');
                                localStorage.setItem("reset", 'reset');
                            }
                            break;
                    case error.PERMISSION_DENIED:
                            if(!localStorage.getItem("county")){
                                localStorage.setItem("ciudad", 'Santiago');
                                localStorage.setItem("county", 'Santiago');
                                localStorage.setItem("reset", 'reset');
                            }
                            break;
                    case error.UNKNOWN_ERROR:
                            if(!localStorage.getItem("county")){
                                localStorage.setItem("ciudad", 'Santiago');
                                localStorage.setItem("county", 'Santiago');
                                localStorage.setItem("reset", 'reset');
                            }
                            break;
            }
    },
    automaticCarrousel : function(){
        var ul = $('.innerCarrousel ul[data-carrusel="1"]');
        var currentLi = $(ul).find('li.current');

        $(currentLi).next().trigger('click');
    },
    cerrarFicha : function(item){
        $('#callFicha').hide();
        $('.searchContent').hide();
        $('.blocker').hide();
        $('#buscador').css('display','none');
        $('#search').show();
        $('li.ajustes a.ajustesIcon').attr('data-func','menuAjustes');
        $('#tabs').css('height','auto');
    },
    
    scrollBar : function(element){
//        var currentScroll = 0;
        var wrapperFicha = $(element).find('#wrapperFicha');
        var eHeight = $(element).height();
        var sHeight = $(element).prop('scrollHeight');
        var sbHeight = (eHeight * 100) / sHeight;
        var alturafinal = (eHeight * (sbHeight / 100) );
        
        var relativeWrap = $(element).parent();
        var scroll = $(relativeWrap).find('.scrollbar');
        var scrollbar = $(relativeWrap).find('.scrollbar .scroll');    

        $(scroll).height(eHeight);
        $(scrollbar).height(alturafinal);
        
        if($(scrollbar).height() >=  $(scroll).height()){
            $(scroll).hide();
        }else{
            $(scroll).show();
        }
        
        $(element).on('scroll touchend', function() { 
                var sTop = $(element).scrollTop();
                var result = sTop * (sbHeight / 100);
                $(scrollbar).css('top', result+'px');
        });
        
    },
    svgFallBack : function() {
            if( !Modernizr.svg ) { 
                var svgObjects = $('[data-svgFallback]');
                $.each(svgObjects, function(i, elm){
                    $(elm).attr('src', $(elm).attr('data-svgFallback'));
                });
            }
        },
    linkMensaje : function(item){
        var mensaje = $(item).attr('data-mensaje');
        alert(mensaje);
    },
    resetAll : function(item){
        localStorage.removeItem('ciudad');
        localStorage.removeItem('county');
        inicial();
        $('#nav').find('a[data-tab="1"]').trigger('click');
        $('.searchContent').hide();
        $('.blocker').hide();
        $('li.ajustes a.ajustesIcon').attr('data-func','menuAjustes');
        $('#tabs').css('height','auto');
        $('.innerCarrousel ul').css('display','block');
    }
    

}

$(function(){

inicial();
js.touchEvents();

});

(function($) {
    $.fn.evt = function(){
        $.each(this,function(i,item) {
            if ( $.isFunction( js[$(item).attr("data-func")] )){
                var event = $(item).attr("data-event")==undefined?"click":$(this).attr("data-event");
                $(item).off(event);
                $(item).on(event, function(e){
                   js[$(item).attr("data-func")].call(e,item)
                   if($(item).attr("data-prevent")==undefined) e.preventDefault();
                });
            }
        });
    }
    
})($);
