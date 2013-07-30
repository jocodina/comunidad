function  predefinido(){ 
    var county;

    county = localStorage.getItem("county");
    var localGenders =  localStorage.getItem("destacadas");
    var firstload =  localStorage.getItem("recurrente");
      
    $.ajax({
        type: "POST",
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: "ajax_zone_mobile",
            display: "inicio",
            county: county,
            localGenders: localGenders,
            firstLoad: firstload
        },
        dataType: "html",
        beforeSend: function( xhvalr ) {
            $('#firstLoad').height(800).css('display','block');
        },
        success: function(data) {
            $("#infoDragg").html(data);    
            $(".evt").evt();    
                
            js.watchlistDest();
            js.loadStorageTab();
            
            $(".search input").keyup(function(e){
                        if(e.keyCode!=13) js.getResults();
                    });
            $(".search input").bind('keypress', function(e){
                        if(e.keyCode==13){
                            $(".prev").remove();
                            $(".busqlist").prepend('<li class="prev"><a style="background:red;color:white" href="#">Selecciona un resultado con el mouse</a></li>');
                            return false;
                        }
            });

            var parentWidth = $('.content').width();
            $('.tab').css("width", parentWidth);
            
             $(window).resize(function() {
                var parentWidth = $('.content').width();
                var dataPage = $('#nav ul li a.active').attr('data-page');
                $('.tab[data-page="'+dataPage+'"]').width(parentWidth);
            });
              
            $('.flexslider').flexslider({
               
                after:function(slider){
                    var altura = $('.content .tab[data-page="'+ (slider.currentSlide +1) +'"]').outerHeight();
                    $('.content').height(altura);

                    var currentTab = slider.currentSlide +1;
                    $('#nav').find("a").removeClass("active");
                    $('#nav').find('a[data-page="'+(currentTab)+'"]').not('.noSlide').addClass('active');
                    
                    localStorage = ("tab", currentTab);
                    
                    if($('#nav').find("a").hasClass('noSlide')){
                        $('#nav').find("a.noSlide").addClass('active');
                    }
                }
                
            });
               
        },
        error : function() { }
    });
      
}
function savelocal(valor, nombre, limit){
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
function deleteLocal(valor, nombre){
      
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
    move : 0,
    movestart:0,
    moveend:0,
    startelm:0,
    
    menu : function(evento, i){
        
        var scroll = 160 - (($(i).outerWidth()/2) + ($(i).parent().parent().find("li").length * 1));
        var centerPoint = $(i).position().left - scroll
        var ancho = ($(i).parent().parent().find("li").width() * $(i).parent().parent().find("li").length ) + ($(i).parent().parent().find("li").length * 2);
        
        $("#channelLoad").fadeOut('slow');
        $("#programLoad").fadeOut('slow');
        $("#infoDragg").css('opacity','1.0');
        $("#infoDragg").fadeIn('slow');
        $('.configMenu').find('.favoritos').removeClass('current');
        $('.configMenu').find('.ubicacion').removeClass('current');
        $('#nav').find('a').removeClass('noSlide');

//        $("#nav ul").css("width" , ancho);
        $(i).parent().siblings().find("a").removeClass("active");        
        $(i).addClass("active");
        if (centerPoint!=0){
            $("#nav").animate({
                scrollLeft: "+=" + centerPoint
                }, 500);   
            var movePage = $('.content .tab[data-page="'+$(i).attr('data-page')+'"]').position().left;
            var altoPage = $('.content .tab[data-page="'+$(i).attr('data-page')+'"]').height();
            if (altoPage < 378) altoPage = 378;     
            $(".content").css("height", altoPage+"px");
 
            $($('#infoDragg')).animate({
            marginLeft: '-'+ movePage + 'px' 
            }, 700); 
//            
            var dataPage = $(i).attr('data-page');
            localStorage = ("tab", dataPage);
                        
        } 
    },
    getResults : function(){
        if ($(".search input").val().length < 4 ){
            
            $('#programLoad li').remove();
            $("#infoDragg").fadeIn('slow');
        } 
       
        if ($(".search input").val().length > 3 ) {
                $.ajax({
                type: "POST",
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: "ajax_zone_mobile",
                    display: "search_list",
                    palabra: $(".search input").val()
                },
                dataType: "html",
                beforeSend: function( xhvalr ) {
                    $("#infoDragg").css('opacity','0.3');
                    $(".ajaxloader").css('display','block');
                    $("#firstLoad").css('display','block').css('opacity','0.0');
                },
                success: function(data) {
                    $(".content").css('opacity','1.0');
                    $(".ajaxloader").css('display','none');
                    $(".evt").off('click');
                    $("#programLoad").html(data);
                    $(".evt").evt();
                    $("#infoDragg").fadeOut('slow');
                    $("#programLoad").fadeIn('slow');
                    $("#nav").fadeOut('slow');
                    $("#programLoad").find('[data-func]').evt();
                    $('#nav').find('a.active').addClass('noSlide');
                    $('#contentLoad').css('display','none');

                    var altura = $("#programLoad").height();
                    $('.content').height(altura);
                    $("#firstLoad").css('display','none');

                    if ($(".search input").val().length < 4 ){

                        $('#programLoad li').remove();
                        $("#nav").fadeIn('slow');
                        $("#infoDragg").fadeIn('slow');
                    } 
                
                },
                error : function() { }
            });
        }
                
               
                
    },
    codeLatLng : function(position) {

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
                    //city data
                    $("#geocode #actual").html('<span class="textoUb">Tu ubicación actual es: </span><span class="ubicacion">' + ciudad.short_name + '</span><span class="textoUb">Comuna: </span><span class="ubicacion">' + comuna.short_name + '</span>');
      
      
                    if(!localStorage.getItem("county")){

                        localStorage.setItem("ciudad", ciudad.short_name);
                        localStorage.setItem("county", comuna.short_name);
                    }
                
                
                }
            } 
        });
    },
    getDate : function(evento, item){
        var fecha = $(item).find('option:selected').val();
        var gender = $(item).attr("data-gender");
        var channelID = $(item).attr("data-chanel");
      
        localStorage.setItem("date", fecha);
      
        $.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: "ajax_zone_mobile",
                newDate: fecha,
                genero: gender,
                channel: channelID
            },
            dataType: "html",
            beforeSend: function( xhr ) {
                $("#programLoad").css('opacity','0.3');
                $(".ajaxloader").css('display','block');
                $('select[name="fechaSelect"]').remove();
            },
            success: function(data) {
                $(".ajaxloader").hide();
                
                $("#programLoad").html(data);
                $("#programLoad").css('opacity','1.0');
                $('select[name="fechaSelect"]').attr("data-gender",gender);
                $('select[name="fechaSelect"]').attr("data-chanel", channelID);
                var select = $('select[name="fechaSelect"]');
                $('select[name="fechaSelect"]').remove();
                $('#logo').after(select);
                $('select[name="fechaSelect"]').find('option[value="'+ fecha +'"]').attr("selected","selected");
                $('select[name="fechaSelect"]').evt();
                
                
            },
            error : function() { }
        });
    },
    loadContent : function(evento, item){
        var programID = $(item).attr("data-program");
        var startTime = $(item).attr("data-startTime");
        var lastContent =  $(item).attr("data-cont"); 
      
        $.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: "ajax_zone_mobile",
                program: programID,
                startTime: startTime,
                cont: lastContent
            },
            dataType: "html",
            beforeSend: function( xhr ) {
                $("#infoDragg").css('opacity','0.3');
                $("#programLoad").css('opacity','0.3');
                $(".ajaxloader").css('display','block');
                $("#firstLoad").css('display','block');
                $("#firstLoad").css('opacity','0.0');
            },
            success: function(data) {
                $("#contentLoad").css('opacity','1.0');
                $("#contentLoad").css('display','block');
                $("#programLoad").css('display','none');
                $("#firstLoad").css('display','none');
                $('#nav').find('a.active').attr('data-check','true');
                $('#nav').find('a').removeClass('active');
                $(".ajaxloader").hide();
                
                $(".evt").off('click');
                $("#contentLoad").html(data);
                
                $(".evt").evt();
                $("#contentLoad").width($("section.content").width());                 
                
                $("#contentLoad").fadeIn('slow');
                $("#infoDragg").fadeOut('slow');
//                $("#programLoad").fadeOut('slow');
                $("#channelLoad").fadeOut('slow');
                
                $("#nav").hide();
                
                setTimeout(function(){
                    var altura = $("#contentLoad").height();
                    $(".content").css("height",altura+"px");   
                },10000);

                var getlocal = localStorage.getItem("watchlist");
                var ProgramID = $('input#watch').attr('data-program');
                var cont;
                
                if(getlocal != null && getlocal != "" && getlocal != false && getlocal != undefined){
                    var parslocal = JSON.parse(getlocal);

                    $.each(parslocal, function(index, value){
                        cont = index;
                        if(this == ProgramID){
                            $('input#watch').attr("checked",true);
                            $('input#watch').parent().find('label').text("Quitar de favoritos");
                        }   
                    });
                      
                    if(cont >= 5){

                        $('input#watch').not(':checked').attr("disabled","disabled");
                        $('input#watch').not(':checked').parent().find('label').text("Favoritos lleno");
                    }
                }

                $("#selectChange").remove();
                
                $('body').scrollTop(0);
                
            },
            error : function() { }
        });
    },
    loadChannel : function(evento, item) {
      
        var gender = $(item).attr("data-gender");
        var location =$(item).attr("data-location");
        var page = $(item).parent().parent().parent().attr("data-page");
      
        $.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: "ajax_zone_mobile",
                display: "channelList",
                genders: gender,
                location: location,
                dataPage: page
            },
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#infoDragg").css('opacity','0.3');
                $(".ajaxloader").css('display','block');
                $("#firstLoad").css('display','block').css('opacity','0.0');
                
            },
            success: function(data) {
                $("#infoDragg").css('display','none');
                $("#firstLoad").css('display','none');
                $('#nav').find('a.active').addClass('noSlide');
                $(".ajaxloader").hide();


                $("#channelLoad").css('opacity','1.0');
                $(".evt").off('click');
                $("#channelLoad").html(data.out);
                $("#channelLoad").find('li.tab').attr("data-page",data.dataPage);
                $(".evt").evt();
                
                
                $("#channelLoad").width($("section.content").width());                 
                
                $("#channelLoad").fadeIn('slow');
                
                
                
                var altura = $("#channelLoad").height();
                $(".content").css("height",altura+"px");

            },
            error : function() { }
        });
    },
    loadPrograms : function(evento,item){
        var channel = $(item).attr("data-chnid");
        var page = $(item).parent().parent().parent().attr("data-page");
        var today = $(item).attr("data-date");
      
        $.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php#'+ (Math.floor(Math.random() * 10000000)),
            cache: false,
            data: {
                action: "ajax_zone_mobile",
                display: "programList",
                dataPage: page,
                channelID: channel,
                rand : Math.floor(Math.random() * 10000000)
            },
            dataType: "json",
            beforeSend: function( xhr ) {
                $("#channelLoad").css('opacity','0.3');
                $("#infoDragg").css('opacity','0.3');
                $(".ajaxloader").css('display','block');
                $("#firstLoad").css('display','block');
                $("#firstLoad").css('opacity','0.0');
            },
            success: function(data) {
                
                $("#channelLoad").css('display','none');
                $("#firstLoad").css('display','none'); 
                $('#nav').find('a.active').addClass('noSlide');
                
                $(".ajaxloader").hide();
                
                $("#programLoad").css('display','block');
                $("#programLoad").css('opacity','1.0');
                
                $(".evt").off('click');
                $("#programLoad").html(data.out);
                var select = $('select[name="fechaSelect"]');
                $('select[name="fechaSelect"]').remove();
                $('#logo').after(select);
                $(".evt").evt();
                
                $("#programLoad").width($("section.content").width());                 
                
                $("#infoDragg").fadeOut('slow');
//                $("#channelLoad").fadeOut('slow');
                $("#programLoad").fadeIn('slow');

                
                $('a[data-fade="channels"]').attr('data-page',data.dataPage);
                
                var altura = $("#programLoad").height();
                $(".content").css("height",altura+"px");
                
                var Digital = new Date();
                var hours = Digital.getHours();
                var targetHour = $('li.programa').find('a[data-hour="'+hours+'"]');
                if(targetHour.length == 0){
                    targetHour = $('li.programa').find('a[data-hour="'+ (hours + 1) * 1 +'"]')
                }
                var alturaLiHour = $(targetHour).outerHeight();
                
                var offset = $(targetHour).offset();
                window.scrollTo(0, offset.top - (alturaLiHour * 4));
                
                $("#nav").hide();
                $("#channelLoad").css('opacity','1.0');
            },
            error : function() { }
        });
      
    },
    loadDest : function(evento,item){
        $.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: "ajax_zone_mobile",
                display: "preferencias"
            },
            dataType: "html",
            beforeSend: function( xhvalr ) {
                $("#infoDragg").css('opacity','0.3');
                $(".ajaxloader").css('display','block');
            },
            success: function(data) {
                
                $(".ajaxloader").hide();
                
                $(".evt").off('click');
                $("#channelLoad").html(data);
                $(".evt").evt();
                
                $("#channelLoad").width($("section.content").width());                 
                
                $("#infoDragg").fadeOut('slow');
                $("#contentLoad").fadeOut('slow');
                $("#programLoad").fadeOut('slow');
                $("#channelLoad").css('display','block').css('opacity','1.0');
                
                var altura = $("#channelLoad").height();
                $(".content").css("height",altura+"px");
                $("#selectChange").remove();
                
                var localDest = localStorage.getItem("destacadas");
                
                if(localDest != null && localDest != "" && localDest != false && localDest != undefined){
                    var parslocal = JSON.parse(localDest);
                    var check = $('input.categoria');
                    
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
                
                if(localStorage.getItem('recurrente') == null){  
                   localStorage.setItem('recurrente',true);
                   var check = $('input.categoria');
                   
                   check.each(function(index, value){      
                        $(this).attr('checked','checked');
                        savelocal($(this).val(), "destacadas", 11);
                   });
                   
                   
                }
                
                
            },
            error : function() { }
        });
    },
    loadFavoritos : function(evento, item) {

        var getlocal = localStorage.getItem("watchlist");
      
        if(getlocal != null && getlocal != "" && getlocal != false && getlocal != undefined){
            var parslocal = JSON.parse(getlocal);
      
            $.ajax({
                type: "POST",
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: "ajax_zone_mobile",
                    display: "favoritos",
                    programs: parslocal
                },
                dataType: "html",
                beforeSend: function( xhvalr ) {
                    $("#infoDragg").css('opacity','0.3');
                    $("#channelLoad").css('opacity','0.3');
                    $("#programLoad").css('opacity','0.3');
                    $("#contentLoad").css('opacity','0.3');
                    $(".ajaxloader").css('display','block');
                    $("#firstLoad").css('display','block').css('opacity','0.0');
                },
                success: function(data) {
                    $("#firstLoad").css('display','none');
                    $('#nav').css('display','block');
                    $('#nav').find('a.active').addClass('noSlide');
                    $(".ajaxloader").hide();
                
                    $("#programLoad").css('display','block').css('opacity','1.0');
                
                
                    $(".evt").off('click');
                    $("#programLoad").html(data);
                    $(".evt").evt();
                
                    $("#programLoad").width($("section.content").width());                 
                
                    $("#infoDragg").fadeOut('slow');
                    $("#contentLoad").fadeOut('slow');
                    $("#channelLoad").fadeOut('slow');
                    $("#programLoad").fadeIn('slow');
                    
                    $('.configMenu').find('.favoritos').addClass('current');
                
                    var altura = $("#programLoad").height();
                    $(".content").css("height",altura+"px");
                
                    $("#programLoad").css('opacity','1.0');
                    $("#selectChange").remove();
                    
                    $('.configMenu').find('.ubicacion').removeClass('current');
                
                    var localDest = localStorage.getItem("destacadas");
                
                    if(localDest != null && localDest != "" && localDest != false && localDest != undefined){
                        var parslocal = JSON.parse(localDest);
                        var check = $('input.categoria');
                    
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
                
                
                },
                error : function() { }
            });
        }else {
            alert("Usted no ha seleccionado ningún programa favorito");
        }
        $('#nav').find('a').removeClass('noSlide');
    },

    backButton : function(evento, item) {
        var altura;
      
        var dataPage = $(item).attr("data-page");
        $('.search').find('input').val('');
      
        if($(item).attr("data-fade") == "inicio"){
      
            $("#contentLoad").fadeOut('slow');
//            $("#channelLoad").css('display','block');
            $("#infoDragg").css('display','block');
            $("#nav").css('display','block').css('opacity','1.0');
            $("#infoDragg").css('opacity','1.0');
            
            $('header').fadeIn('slow');
            $('#searchHeader').fadeOut('slow');
          
            altura = $('#infoDragg').find('li.tab[data-page="1"]').height();
            $(".content").css("height",altura+"px"); 

          
        }else if ($(item).attr("data-fade") == "channels"){
            $("#programLoad").fadeOut('slow');
            $("#channelLoad").css('display','block');
            $("#channelLoad").css('opacity','1.0');
//            $("#infoDragg").css('display','block');
//            $("#infoDragg").css('opacity','1.0');
            $("#nav").fadeIn('slow');
          
            if($("#channelLoad").height() == 0){
                altura = $('#infoDragg').find('li.tab[data-page="'+dataPage+'"]').height();
                $(".content").css("height",altura+"px"); 
                
//                $('#nav').find('a[data-page="'+dataPage+'"]').trigger('click');
            }
            else{
                altura = $("#channelLoad").outerHeight();
                $(".content").css("height",altura+"px"); 
//                $('#nav').find('a[data-page="'+dataPage+'"]').trigger('click');
            }
        }else if($(item).attr("data-fade") == "last"){
            $("#contentLoad").fadeOut('slow');
            $("#programLoad").css('display','block').css('opacity','1.0');

            altura = $("#programLoad").height();
            $(".content").css("height",altura+"px");
            
        }
        $('#nav').find('a[data-check="true"]').addClass('active').removeAttr('data-check');
        $('.configMenu').find('a').removeClass('current');
        $('#itemsConfig').css('display','block');
        $("#selectChange").remove();
        js.watchlistDest();
      
    },
    checkdata : function(evento,item){
      
        var valor = $(item).val();
        var texto = $('label[for="'+valor+'"]').text();
        var num;
        var targetMenu;
        var targetTab;
      
        if($(item).is(":checked")){    
            savelocal(valor, "destacadas", 11);   
        }
        else {  
            deleteLocal(valor, "destacadas");
        } 
        
        var localDest = localStorage.getItem("destacadas");
            localDest = JSON.parse(localDest);
            
        var county = localStorage.getItem("county");
        
       
        
        $.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php',
            cache: false,
            data: {
                action: "ajax_zone_mobile",
                localGenders: localDest,
                county: county
            },
            dataType: "html",
            beforeSend: function( xhvalr ) {
                
            },
            success: function(data) {
                
                $(".ajaxloader").hide();
                
                $(".evt").off('click change');
                
                $('.tab[data-page="2"]').html('');
                
                $('.tab[data-page="2"]').html(data);
                
                
                $(".evt").evt(); 
            },
            error : function() { }
        });
       
      
      
    }, 
    loadStorageTab : function () { //carga las categorias seleccionadas
      
        var getlocal = localStorage.getItem("destacadas");
        var texto;

      
        if(getlocal != null && getlocal != "" && getlocal != false && getlocal != undefined){
            var parslocal = JSON.parse(getlocal);
   
              
              
                var targetMenu = $('li .cate').find('a#'+texto);
              
                $.ajax({
                    type: "POST",
                    url: '/wp-admin/admin-ajax.php',
                    data: {
                        action: "ajax_zone_mobile",
                        slug: parslocal
                    },
                    dataType: "html",
                    beforeSend: function( xhvalr ) {
                        $(targetMenu).text(texto);
                    },
                    success: function(data) {

                    },
                    error : function() { }
                });
          
          
        }
      
      
    },
    watchlist : function(evento, item){
        var programID = $(item).attr("data-program");
        var save;

        if($(item).is(":checked")){
            savelocal(programID, "watchlist", 6);
            $(item).parent().find('label[for="watch"]').text('Quitar de favoritos');
        }
        else {
            deleteLocal(programID, "watchlist");
            $(item).parent().find('label[for="watch"]').text('Agregar a favoritos');
            $('li.programa').has('a[data-program="'+programID+'"]').fadeOut('slow').remove();
        }
        
//        js.watchlistDest();
        
    },
    watchlistDest : function(){
      
        var getlocal = localStorage.getItem("watchlist");
      
        if(getlocal != null && getlocal != "" && getlocal != false && getlocal != undefined){
            var parslocal = JSON.parse(getlocal);
      
            $.ajax({
                type: "POST",
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: "ajax_zone_mobile",
                    display: "favoritosDest",
                    programs: parslocal
                },
                dataType: "html",
                beforeSend: function( xhvalr ) {

                },
                success: function(data) {
                    $(".evt").off('click');
                    $('#infoDragg').find('li.tab[data-page="9"]').html(data);
                    $(".evt").evt();

                
                },
                error : function() { }
            });
        }else {
            $.ajax({
                type: "POST",
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: "ajax_zone_mobile",
                    display: "destacados",
                    programs: parslocal
                },
                dataType: "html",
                beforeSend: function( xhvalr ) {

                },
                success: function(data) {
                    $(".evt").off('click');
                    $('#infoDragg').find('li.tab[data-page="9"]').html(data);
                    $(".evt").evt();

                
                },
                error : function() { }
            }); 
        }
      
    },
  
    loadUbicacion :function(evento,item){
      
        var comunaLocal = localStorage.getItem("county")? localStorage.getItem("county"): "Santiago";

        $.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: "ajax_zone_mobile",
                display: "ubicacion",
                county: comunaLocal

            },
            dataType: "html",
            beforeSend: function( xhvalr ) {
                $("#infoDragg").css('opacity','0.3');
                $(".ajaxloader").css('display','block');
                $("#firstLoad").css('display','block').css('opacity','0.0');
                $("#channelLoad").css('opacity','0.3');
                $("#programLoad").css('opacity','0.3');
                $("#contentLoad").css('opacity','0.3');
            },
            success: function(data) {
                $('#nav').find('a.active').addClass('noSlide');
                $("#programLoad").css('opacity','1.0');
                $("#firstLoad").css('display','none');
                $('#nav').css('display','block');
                $(".ajaxloader").hide();
                
                $(".evt").off('click');
                $("#programLoad").html(data);
                $(".evt").evt();
                
                $("#programLoad").width($("section.content").width());                 
                
                $("#infoDragg").fadeOut('slow');
                $("#contentLoad").fadeOut('slow');
                $("#channelLoad").fadeOut('slow');
                $("#programLoad").fadeIn('slow');
                $("#programLoad").css("display","block");
                $("#programLoad").css("opacity","1.0");
                
                $('.configMenu').find('.favoritos').removeClass('current');
                $('.configMenu').find('.ubicacion').removeClass('current');
                $(".content").css("height","400px");
                
                $("#programLoad").css('opacity','1.0');
                $("#selectChange").remove();
                
                $('.configMenu').find('.ubicacion').addClass('current');
                
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(js.codeLatLng);
                } 
            },
            error : function() { }
        });
      
      
    },
    
    loadPreferencias : function(evento,item){
        $.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: "ajax_zone_mobile",
                display: "loadPreferencias"

            },
            dataType: "html",
            beforeSend: function( xhvalr ) {
                $("#infoDragg").css('opacity','0.3');
                $(".ajaxloader").css('display','block');
                $("#firstLoad").css('display','block').css('opacity','0.0');
                $("#channelLoad").css('opacity','0.3');
                $("#programLoad").css('opacity','0.3');
                $("#contentLoad").css('opacity','0.3');
            },
            success: function(data) {
                $("#infoDragg").fadeOut('slow');
                $('#nav').find('a.active').addClass('noSlide');
                $("#programLoad").css('opacity','1.0');
                $("#firstLoad").css('display','none');
                $('#nav').css('display','block');
                $(".ajaxloader").hide();
                
                $(".evt").off('click');
                $("#programLoad").html(data);
                $(".evt").evt();
                
                $("#programLoad").width($("section.content").width());                 
                
  
                $("#contentLoad").fadeOut('slow');
                $("#channelLoad").fadeOut('slow');
                $("#programLoad").fadeIn('slow').css("display","block").css("opacity","1.0");

               
            },
            error : function() { }
        });
    },
  
    selectUbicacion : function(evento,item){
      
        var valor = $(item).find("option:selected").val();
      
        $.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: "ajax_zone_mobile",
                display: "selectorUbicacion",
                region: valor
            },
            dataType: "html",
            beforeSend: function( xhvalr ) {
                
            },
            success: function(data) {
                $("select#selectComuna").html(data);
                
            },
            error : function() { }
        });
      
      
    },
    changeLocation : function(evento,item){
        var county = $(item).parent().find("#selectComuna").find("option:selected").val();
        var localGenders =  localStorage.getItem("destacadas");
      
        if(county){
            $.ajax({
                type: "POST",
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: "ajax_zone_mobile",
                    display: "changeLocacion",
                    county: county,
                    localGenders: localGenders
                },
                dataType: "html",
                beforeSend: function( xhvalr ) {

                },
                success: function(data) {
                    
                    
                    js.watchlistDest();
                    js.loadStorageTab();

                    $(".evt").off('click');
                    $("#infoDragg").html(data);
                    $(".evt").evt();
                    
                    var parentWidth = $('.content').width();
                    $('.tab').css("width", parentWidth);

                    $("#programLoad").fadeOut('slow');
                    $('#infoDragg').css('display','block');
                    $("#infoDragg").css('opacity','1.0');

                    $('.configMenu').find('.ubicacion').removeClass('current');
                    
                    localStorage.setItem("county", county);  
                    
                    $('#nav').find('a[data-page="1"]').trigger('click');
                },
                error : function() { }
            });
        }else{
            alert('Debe seleccionar una Región y luego una Comuna')
        }
      
    },
    showSearch : function(evento,item){
      
        $('#searchHeader').fadeIn('slow');
        $(".content").css('opacity','0.1');
        $("#nav").css('display','none');
        $("#itemsConfig").css('display','none');
        $("#programLoad").css('opacity','1.0');
        
        $('.configMenu').find('.favoritos').removeClass('current');
        $('.configMenu').find('.ubicacion').removeClass('current');
      
        $('#nav').find('a').removeClass('noSlide');
        $("#contentLoad").css('display','block').css('opacity','0.0');
        if($("#contentLoad").height() == 0){
            $("#contentLoad").height($('.content').height());
        }
    },
           
    hideSearch : function(evento,item){
        $('#nav').find('a[data-check="true"]').addClass('active').removeAttr('data-check');
        $("#contentLoad").css('display','none').css('opacity','1.0');
        $('#searchHeader').hide('slow');
        $('#programLoad').fadeOut('slow');
        $('header').fadeIn('slow');
        $('#infoDragg').css('display','block').css('opacity','1.0');
        $('#nav').find('a').removeClass('noSlide');
      
        $(".content").css('display','block').css('opacity','1');
        $("#nav").css('display','block').css('opacity','1');
        $("#itemsConfig").css('display','block');
        
        $('.search').find('input').val('');
        
        var altura = $('.tab[data-page="1"]').height();
        $(".flexslider").height(altura);
    }

  
  
}


$(function(){


    // llamados propios

    predefinido();
    
    $(".search input").keyup(function(e){
                        if(e.keyCode!=13) js.getResults();

        
                    });
    $(".search input").bind('keypress', function(e){
            if(e.keyCode==13){
                $(".prev").remove();
                $(".busqlist").prepend('<li class="prev"><a style="background:red;color:white" href="#">Selecciona un resultado con el mouse</a></li>');
                return false;
            }
    });


    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(js.codeLatLng);
    } 


    //Da altura inicial a content

    setTimeout(function(){
        var altura = $('.content .tab[data-page="1"]').outerHeight();   

        $('.content').height(altura); 
        $('#firstLoad').height(altura);
        $('#firstLoad').fadeOut('slow');
    },10000);
  
});

(function($) {
    $.fn.evt = function(){
        $.each(this,function(i,item) {
            if ( $.isFunction(eval("js." + $(item).attr("data-func")))){
                var event = $(item).attr("data-event")==undefined?"click":$(this).attr("data-event");
                
                if(event=="mouseenter" || event == "mouseleave"){
                    $(item).on("mouseenter",function(e){
                        eval("js."+$(item).attr("data-func") +"(e, item, true)");
                        e.preventDefault();
                        
                          
                    }).on("mouseleave",function(e){
                        eval("js."+$(item).attr("data-func") +"(e, item, false)");
                        e.preventDefault();
                          
                    })
                }else{
                    $(item).on(event, function(e){                       
                        eval("js."+  $(item).attr("data-func") +"(e, item)");
                        e.preventDefault();   
                        
                    }) 
                }
                
                
            }
        });
    }
    $.fn.display = function(params){
        $.each(this,function(i,item) {
            eval("params.target."+ params.func + "(this)");
        })
    }
    $.fn.doit = function(params){
        if (document.getElementById($(this).attr("id"))) eval("params.target."+ params.func + "(this)");
    }
    $.fn.flickr = function(params){
        if ( $.ide('#'+$(this).attr("id") ) ){
            params.el=this;
            var clase = $(this).attr("class")
            alb = clase.split("_");
            if (alb[1]==""){
                alb[1] = params.photoset;
            }
        
            $.ajax({
                url:'http://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=' + params.apiKey + '&photoset_id='+alb[1]+'&extras=url_sq,url_o,url_m,original_format&format=json&jsoncallback=?',
                dataType:'json',
                error :function(){
                    total = 1;
                    globales.datos = data;
                },
                success:function(data){
                    if (data.photoset!=undefined){
                        var output="";
                        $.each(data.photoset.photo, function(i,item){
                            if(i<parseInt(params.items)){
                                output += '<a target="_blank" href="http://www.flickr.com/photos/consejocultura/'+item.id+'/lightbox/" rel="external" id="photo_'+item.id+'" title="'+item.title+'">';
                                output += '<img src="'+ item.url_sq +'" alt="'+ item.title +'" /></a>';
                            }
                        });
                        $(params.el).html(output);
                    }
                }
            })
        }
    }
    $.fn.atts = function(target){
        return $(i).attr('data-'+target)
    }
    //FlexSlider: Object Instance
    $.flexslider = function(el, options) {
        var slider = el;

        slider.init = function() {
            slider.vars = $.extend({}, $.flexslider.defaults, options);
            slider.data('flexslider', true);
            slider.container = $('.slides', slider);
            slider.slides = $('.slides > li', slider);
            slider.count = slider.slides.length;
            slider.animating = false;
            slider.currentSlide = slider.vars.slideToStart;
            slider.animatingTo = slider.currentSlide;
            slider.atEnd = (slider.currentSlide == 0) ? true : false;
            slider.eventType = ('ontouchstart' in document.documentElement) ? 'touchstart' : 'click';
            slider.cloneCount = 0;
            slider.cloneOffset = 0;
            slider.manualPause = false;
            slider.vertical = (slider.vars.slideDirection == "vertical");
            slider.prop = (slider.vertical) ? "top" : "marginLeft";
            slider.args = {};
      
            //Test for webbkit CSS3 Animations
//            slider.transitions = "webkitTransition" in document.body.style;
//            if (slider.transitions) slider.prop = "-webkit-transform";
      
            //Test for controlsContainer
            if (slider.vars.controlsContainer != "") {
                slider.controlsContainer = $(slider.vars.controlsContainer).eq($('.slides').index(slider.container));
                slider.containerExists = slider.controlsContainer.length > 0;
            }
            //Test for manualControls
            if (slider.vars.manualControls != "") {
                slider.manualControls = $(slider.vars.manualControls, ((slider.containerExists) ? slider.controlsContainer : slider));
                slider.manualExists = slider.manualControls.length > 0;
            }
      
            ///////////////////////////////////////////////////////////////////
            // FlexSlider: Randomize Slides
            if (slider.vars.randomize) {
                slider.slides.sort(function() {
                    return (Math.round(Math.random())-0.5);
                });
                slider.container.empty().append(slider.slides);
            }
            ///////////////////////////////////////////////////////////////////
      
            ///////////////////////////////////////////////////////////////////
            // FlexSlider: Slider Animation Initialize
            if (slider.vars.animation.toLowerCase() == "slide") {
                if (slider.transitions) {
                    slider.setTransition(0);
                }
                slider.css({
                    "overflow": "hidden"
                });
                if (slider.vars.animationLoop) {
                    slider.cloneCount = 2;
                    slider.cloneOffset = 1;
                    slider.container.append(slider.slides.filter(':first').clone().addClass('clone')).prepend(slider.slides.filter(':last').clone().addClass('clone'));
                }
                //create newSlides to capture possible clones
                slider.newSlides = $('.slides > li', slider);
                var sliderOffset = (-1 * (slider.currentSlide + slider.cloneOffset));
                if (slider.vertical) {
                    slider.newSlides.css({
                        "display": "block", 
                        "width": "100%", 
                        "float": "left"
                    });
                    slider.container.height((slider.count + slider.cloneCount) * 200 + "%").css("position", "absolute").width("100%");
                    //Timeout function to give browser enough time to get proper height initially
                    setTimeout(function() {
                        slider.css({
                            "position": "relative"
                        }).height(slider.slides.filter(':first').height());
                        slider.args[slider.prop] = (slider.transitions) ? "translate3d(0," + sliderOffset * slider.height() + "px,0)" : sliderOffset * slider.height() + "px";
                        slider.container.css(slider.args);
                    }, 100);

                } else {
                    slider.args[slider.prop] = (slider.transitions) ? "translate3d(" + sliderOffset * slider.width() + "px,0,0)" : sliderOffset * slider.width() + "px";
                    slider.container.width((slider.count + slider.cloneCount) * 200 + "%").css(slider.args);
                    //Timeout function to give browser enough time to get proper width initially
                    setTimeout(function() {
                        slider.newSlides.width(slider.width()).css({
                            "float": "left", 
                            "display": "block"
                        });
                    }, 100);
                }
        
            } else { //Default to fade
                //Not supporting fade CSS3 transitions right now
                slider.transitions = false;
                slider.slides.css({
                    "width": "100%", 
                    "float": "left", 
                    "marginRight": "-100%"
                }).eq(slider.currentSlide).fadeIn(slider.vars.animationDuration); 
            }
            ///////////////////////////////////////////////////////////////////
      
            ///////////////////////////////////////////////////////////////////
            // FlexSlider: Control Nav
            if (slider.vars.controlNav) {
                if (slider.manualExists) {
                    slider.controlNav = slider.manualControls;
                } else {
                    var controlNavScaffold = $('<ol class="flex-control-nav"></ol>');
                    var j = 1;
                    for (var i = 0; i < slider.count; i++) {
                        controlNavScaffold.append('<li><a>' + j + '</a></li>');
                        j++;
                    }

                    if (slider.containerExists) {
                        $(slider.controlsContainer).append(controlNavScaffold);
                        slider.controlNav = $('.flex-control-nav li a', slider.controlsContainer);
                    } else {
                        slider.append(controlNavScaffold);
                        slider.controlNav = $('.flex-control-nav li a', slider);
                    }
                }

                slider.controlNav.eq(slider.currentSlide).addClass('active');

                slider.controlNav.bind(slider.eventType, function(event) {
                    event.preventDefault();
                    if (!$(this).hasClass('active')) {
                        (slider.controlNav.index($(this)) > slider.currentSlide) ? slider.direction = "next" : slider.direction = "prev";
                        slider.flexAnimate(slider.controlNav.index($(this)), slider.vars.pauseOnAction);
                    }
                });
            }
            ///////////////////////////////////////////////////////////////////
      
            //////////////////////////////////////////////////////////////////
            //FlexSlider: Direction Nav
            if (slider.vars.directionNav) {
                var directionNavScaffold = $('<ul class="flex-direction-nav"><li><a class="prev" href="#">' + slider.vars.prevText + '</a></li><li><a class="next" href="#">' + slider.vars.nextText + '</a></li></ul>');
        
                if (slider.containerExists) {
                    $(slider.controlsContainer).append(directionNavScaffold);
                    slider.directionNav = $('.flex-direction-nav li a', slider.controlsContainer);
                } else {
                    slider.append(directionNavScaffold);
                    slider.directionNav = $('.flex-direction-nav li a', slider);
                }
        
                //Set initial disable styles if necessary
                if (!slider.vars.animationLoop) {
                    if (slider.currentSlide == 0) {
                        slider.directionNav.filter('.prev').addClass('disabled');
                    } else if (slider.currentSlide == slider.count - 1) {
                        slider.directionNav.filter('.next').addClass('disabled');
                    }
                }
        
                slider.directionNav.bind(slider.eventType, function(event) {
                    event.preventDefault();
                    var target = ($(this).hasClass('next')) ? slider.getTarget('next') : slider.getTarget('prev');
          
                    if (slider.canAdvance(target)) {
                        slider.flexAnimate(target, slider.vars.pauseOnAction);
                    }
                });
            }
            //////////////////////////////////////////////////////////////////
      
            //////////////////////////////////////////////////////////////////
            //FlexSlider: Keyboard Nav
            if (slider.vars.keyboardNav && $('ul.slides').length == 1) {
                function keyboardMove(event) {
                    if (slider.animating) {
                        return;
                    } else if (event.keyCode != 39 && event.keyCode != 37){
                        return;
                    } else {
                        if (event.keyCode == 39) {
                            var target = slider.getTarget('next');
                        } else if (event.keyCode == 37){
                            var target = slider.getTarget('prev');
                        }
        
                        if (slider.canAdvance(target)) {
                            slider.flexAnimate(target, slider.vars.pauseOnAction);
                        }
                    }
                }
                $(document).bind('keyup', keyboardMove);
            }
            //////////////////////////////////////////////////////////////////
      
            ///////////////////////////////////////////////////////////////////
            // FlexSlider: Mousewheel interaction
            if (slider.vars.mousewheel) {
                slider.mousewheelEvent = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel";
                slider.bind(slider.mousewheelEvent, function(e) {
                    e.preventDefault();
                    e = e ? e : window.event;
                    var wheelData = e.detail ? e.detail * -1 : e.wheelDelta / 40,
                    target = (wheelData < 0) ? slider.getTarget('next') : slider.getTarget('prev');
          
                    if (slider.canAdvance(target)) {
                        slider.flexAnimate(target, slider.vars.pauseOnAction);
                    }
                });
            }
            ///////////////////////////////////////////////////////////////////
      
            //////////////////////////////////////////////////////////////////
            //FlexSlider: Slideshow Setup
            if (slider.vars.slideshow) {
                //pauseOnHover
                if (slider.vars.pauseOnHover && slider.vars.slideshow) {
                    slider.hover(function() {
                        slider.pause();
                    }, function() {
                        if (!slider.manualPause) {
                            slider.resume();
                        }
                    });
                }

                //Initialize animation
                slider.animatedSlides = setInterval(slider.animateSlides, slider.vars.slideshowSpeed);
            }
            //////////////////////////////////////////////////////////////////
      
            //////////////////////////////////////////////////////////////////
            //FlexSlider: Pause/Play
            if (slider.vars.pausePlay) {
                var pausePlayScaffold = $('<div class="flex-pauseplay"><span></span></div>');
      
                if (slider.containerExists) {
                    slider.controlsContainer.append(pausePlayScaffold);
                    slider.pausePlay = $('.flex-pauseplay span', slider.controlsContainer);
                } else {
                    slider.append(pausePlayScaffold);
                    slider.pausePlay = $('.flex-pauseplay span', slider);
                }
        
                var pausePlayState = (slider.vars.slideshow) ? 'pause' : 'play';
                slider.pausePlay.addClass(pausePlayState).text((pausePlayState == 'pause') ? slider.vars.pauseText : slider.vars.playText);
        
                slider.pausePlay.bind(slider.eventType, function(event) {
                    event.preventDefault();
                    if ($(this).hasClass('pause')) {
                        slider.pause();
                        slider.manualPause = true;
                    } else {
                        slider.resume();
                        slider.manualPause = false;
                    }
                });
            }
            //////////////////////////////////////////////////////////////////
      
            //////////////////////////////////////////////////////////////////
            //FlexSlider:Touch Swip Gestures
            //Some brilliant concepts adapted from the following sources
            //Source: TouchSwipe - http://www.netcu.de/jquery-touchwipe-iphone-ipad-library
            //Source: SwipeJS - http://swipejs.com
//            if ('ontouchstart' in document.documentElement) {
//                //For brevity, variables are named for x-axis scrolling
//                //The variables are then swapped if vertical sliding is applied
//                //This reduces redundant code...I think :)
//                //If debugging, recognize variables are named for horizontal scrolling
//                var startX,
//                startY,
//                offset,
//                cwidth,
//                dx,
//                startT,
//                scrolling = false;
//              
//                slider.each(function() {
//                    if ('ontouchstart' in document.documentElement) {
//                        this.addEventListener('touchstart', onTouchStart, false);
//                    }
//                });
//        
//                function onTouchStart(e) {
//                    
//                    if (slider.animating) {
//                        e.preventDefault();
//                    } else if (e.touches.length == 1) {
//                        slider.pause();
//                        cwidth = (slider.vertical) ? slider.height() : slider.width();
//                        startT = Number(new Date());
//                        offset = (slider.vertical) ? (slider.currentSlide + slider.cloneOffset) * slider.height() : (slider.currentSlide + slider.cloneOffset) * slider.width();
//                        startX = (slider.vertical) ? e.touches[0].pageY : e.touches[0].pageX;
//                        startY = (slider.vertical) ? e.touches[0].pageX : e.touches[0].pageY;
//                        slider.setTransition(0);
//
//                        this.addEventListener('touchmove', onTouchMove, false);
//                        this.addEventListener('touchend', onTouchEnd, false);
//                    }
//                }
//
//                function onTouchMove(e) {
//                    dx = (slider.vertical) ? startX - e.touches[0].pageY : startX - e.touches[0].pageX;
//                    scrolling = (slider.vertical) ? (Math.abs(dx) < Math.abs(e.touches[0].pageX - startY)) : (Math.abs(dx) < Math.abs(e.touches[0].pageY - startY));
//
//                    if (!scrolling) {
//                        e.preventDefault();
//                        if (slider.vars.animation == "slide" && slider.transitions) {
//                            if (!slider.vars.animationLoop) {
//                                dx = dx/((slider.currentSlide == 0 && dx < 0 || slider.currentSlide == slider.count - 1 && dx > 0) ? (Math.abs(dx)/cwidth+2) : 1);
//                            }
//                            slider.args[slider.prop] = (slider.vertical) ? "translate3d(0," + (-offset - dx) + "px,0)": "translate3d(" + (-offset - dx) + "px,0,0)";
//                            slider.container.css(slider.args);
//                        }
//                    }
//                }
//        
//                function onTouchEnd(e) {
//                    slider.animating = false;
//                    if (slider.animatingTo == slider.currentSlide && !scrolling && !(dx == null)) {
//                        var target = (dx > 0) ? slider.getTarget('next') : slider.getTarget('prev');
//                        if (slider.canAdvance(target) && Number(new Date()) - startT < 550 && Math.abs(dx) > 20 || Math.abs(dx) > cwidth/2) {
//                            slider.flexAnimate(target, slider.vars.pauseOnAction);
//                        } else {
//                            slider.flexAnimate(slider.currentSlide, slider.vars.pauseOnAction);
//                        }
//                    }
//          
//                    //Finish the touch by undoing the touch session
//                    this.removeEventListener('touchmove', onTouchMove, false);
//                    this.removeEventListener('touchend', onTouchEnd, false);
//                    startX = null;
//                    startY = null;
//                    dx = null;
//                    offset = null;
//                }
//            }
            //////////////////////////////////////////////////////////////////
      
            //////////////////////////////////////////////////////////////////
            //FlexSlider: Resize Functions (If necessary)
//            if (slider.vars.animation.toLowerCase() == "slide") {
//                $(window).resize(function(){
//                    if (!slider.animating) {
//                        if (slider.vertical) {
//                            slider.height(slider.slides.filter(':first').height());
//                            slider.args[slider.prop] = (-1 * (slider.currentSlide + slider.cloneOffset))* slider.slides.filter(':first').height() + "px";
//                            if (slider.transitions) {
//                                slider.setTransition(0);
//                                slider.args[slider.prop] = (slider.vertical) ? "translate3d(0," + slider.args[slider.prop] + ",0)" : "translate3d(" + slider.args[slider.prop] + ",0,0)";
//                            }
//                            slider.container.css(slider.args);
//                        } else {
//                            slider.newSlides.width(slider.width());
//                            slider.args[slider.prop] = (-1 * (slider.currentSlide + slider.cloneOffset))* slider.width() + "px";
//                            if (slider.transitions) {
//                                slider.setTransition(0);
//                                slider.args[slider.prop] = (slider.vertical) ? "translate3d(0," + slider.args[slider.prop] + ",0)" : "translate3d(" + slider.args[slider.prop] + ",0,0)";
//                            }
//                            slider.container.css(slider.args);
//                        }
//                    }
//                });
//            }
            //////////////////////////////////////////////////////////////////
      
            //////////////////////////////////////////////////////////////////
            //FlexSlider: Destroy the slider entity
            //Destory is not included in the minified version right now, but this is a working function for anyone who wants to include it.
            //Simply bind the actions you need from this function into a function in the start() callback to the event of your chosing
            /*
      slider.destroy = function() {
        slider.pause();
        if (slider.controlNav && slider.vars.manualControls == "") slider.controlNav.closest('.flex-control-nav').remove();
        if (slider.directionNav) slider.directionNav.closest('.flex-direction-nav').remove();
        if (slider.vars.pausePlay) slider.pausePlay.closest('.flex-pauseplay').remove();
        if (slider.vars.keyboardNav && $('ul.slides').length == 1) $(document).unbind('keyup', keyboardMove);
        if (slider.vars.mousewheel) slider.unbind(slider.mousewheelEvent);
        if (slider.transitions) slider.each(function(){this.removeEventListener('touchstart', onTouchStart, false);});
        if (slider.vars.animation == "slide" && slider.vars.animationLoop) slider.newSlides.filter('.clone').remove();
        if (slider.vertical) slider.height("auto");
        slider.slides.hide();
        slider.removeData('flexslider');
      }
      */
            //////////////////////////////////////////////////////////////////
      
            //FlexSlider: start() Callback
            slider.vars.start(slider);
        }
    
        //FlexSlider: Animation Actions
        slider.flexAnimate = function(target, pause) {
            if (!slider.animating) {
                //Animating flag
                slider.animating = true;
        
                //FlexSlider: before() animation Callback
                slider.animatingTo = target;
                slider.vars.before(slider);
        
                //Optional paramter to pause slider when making an anmiation call
                if (pause) {
                    slider.pause();
                }
        
                //Update controlNav   
                if (slider.vars.controlNav) {
                    slider.controlNav.removeClass('active').eq(target).addClass('active');
                }
        
                //Is the slider at either end
                slider.atEnd = (target == 0 || target == slider.count - 1) ? true : false;
                if (!slider.vars.animationLoop && slider.vars.directionNav) {
                    if (target == 0) {
                        slider.directionNav.removeClass('disabled').filter('.prev').addClass('disabled');
                    } else if (target == slider.count - 1) {
                        slider.directionNav.removeClass('disabled').filter('.next').addClass('disabled');
                    } else {
                        slider.directionNav.removeClass('disabled');
                    }
                }
        
                if (!slider.vars.animationLoop && target == slider.count - 1) {
                    slider.pause();
                    //FlexSlider: end() of cycle Callback
                    slider.vars.end(slider);
                }
        
                if (slider.vars.animation.toLowerCase() == "slide") {
                    var dimension = (slider.vertical) ? slider.slides.filter(':first').height() : slider.slides.filter(':first').width();
          
                    if (slider.currentSlide == 0 && target == slider.count - 1 && slider.vars.animationLoop && slider.direction != "next") {
                        slider.slideString = "0px";
                    } else if (slider.currentSlide == slider.count - 1 && target == 0 && slider.vars.animationLoop && slider.direction != "prev") {
                        slider.slideString = (-1 * (slider.count + 1)) * dimension + "px";
                    } else {
                        slider.slideString = (-1 * (target + slider.cloneOffset)) * dimension + "px";
                    }
                    slider.args[slider.prop] = slider.slideString;

                    if (slider.transitions) {
                        slider.setTransition(slider.vars.animationDuration); 
                        slider.args[slider.prop] = (slider.vertical) ? "translate3d(0," + slider.slideString + ",0)" : "translate3d(" + slider.slideString + ",0,0)";
                        slider.container.css(slider.args).one("webkitTransitionEnd transitionend", function(){
                            slider.wrapup(dimension);
                        });   
                    } else {
                        slider.container.animate(slider.args, slider.vars.animationDuration, function(){
                            slider.wrapup(dimension);
                        });
                    }
                } else { //Default to Fade
                    slider.slides.eq(slider.currentSlide).fadeOut(slider.vars.animationDuration);
                    slider.slides.eq(target).fadeIn(slider.vars.animationDuration, function() {
                        slider.wrapup();
                    });
                }
            }
        }
    
        //FlexSlider: Function to minify redundant animation actions
        slider.wrapup = function(dimension) {
            if (slider.vars.animation == "slide") {
                //Jump the slider if necessary
                if (slider.currentSlide == 0 && slider.animatingTo == slider.count - 1 && slider.vars.animationLoop) {
                    slider.args[slider.prop] = (-1 * slider.count) * dimension + "px";
                    if (slider.transitions) {
                        slider.setTransition(0);
                        slider.args[slider.prop] = (slider.vertical) ? "translate3d(0," + slider.args[slider.prop] + ",0)" : "translate3d(" + slider.args[slider.prop] + ",0,0)";
                    }
                    slider.container.css(slider.args);
                } else if (slider.currentSlide == slider.count - 1 && slider.animatingTo == 0 && slider.vars.animationLoop) {
                    slider.args[slider.prop] = -1 * dimension + "px";
                    if (slider.transitions) {
                        slider.setTransition(0);
                        slider.args[slider.prop] = (slider.vertical) ? "translate3d(0," + slider.args[slider.prop] + ",0)" : "translate3d(" + slider.args[slider.prop] + ",0,0)";
                    }
                    slider.container.css(slider.args);
                }
            }
            slider.animating = false;
            slider.currentSlide = slider.animatingTo;
            //FlexSlider: after() animation Callback
            slider.vars.after(slider);
        }
    
        //FlexSlider: Automatic Slideshow
        slider.animateSlides = function() {
            if (!slider.animating) {
                slider.flexAnimate(slider.getTarget("next"));
            }
        }
    
        //FlexSlider: Automatic Slideshow Pause
        slider.pause = function() {
            clearInterval(slider.animatedSlides);
            if (slider.vars.pausePlay) {
                slider.pausePlay.removeClass('pause').addClass('play').text(slider.vars.playText);
            }
        }
    
        //FlexSlider: Automatic Slideshow Start/Resume
        slider.resume = function() {
            slider.animatedSlides = setInterval(slider.animateSlides, slider.vars.slideshowSpeed);
            if (slider.vars.pausePlay) {
                slider.pausePlay.removeClass('play').addClass('pause').text(slider.vars.pauseText);
            }
        }
    
        //FlexSlider: Helper function for non-looping sliders
        slider.canAdvance = function(target) {
            if (!slider.vars.animationLoop && slider.atEnd) {
                if (slider.currentSlide == 0 && target == slider.count - 1 && slider.direction != "next") {
                    return false;
                } else if (slider.currentSlide == slider.count - 1 && target == 0 && slider.direction == "next") {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }  
        }
    
        //FlexSlider: Helper function to determine animation target
        slider.getTarget = function(dir) {
            slider.currentSlide = ($('#nav').find('a.active').not('.noSlide').attr('data-page')) - 1;
            if($('#nav').find("a").hasClass('noSlide')){
                
            }
            slider.direction = dir;
            if (dir == "next") {
                return (slider.currentSlide == slider.count - 1) ? 0 : slider.currentSlide + 1;
            } else {
                return (slider.currentSlide == 0) ? slider.count - 1 : slider.currentSlide - 1;
            }
        }
    
        //FlexSlider: Helper function to set CSS3 transitions
        slider.setTransition = function(dur) {
            slider.container.css({
                '-webkit-transition-duration': (dur/1000) + "s"
                });
        }

        //FlexSlider: Initialize
        slider.init();
    }
  
    //FlexSlider: Default Settings
    $.flexslider.defaults = {
        animation: "slide",              //String: Select your animation type, "fade" or "slide"
        slideDirection: "horizontal",   //String: Select the sliding direction, "horizontal" or "vertical"
        slideshow: false,                //Boolean: Animate slider automatically
        slideshowSpeed: 7000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
        animationDuration: 600,         //Integer: Set the speed of animations, in milliseconds
        directionNav: false,             //Boolean: Create navigation for previous/next navigation? (true/false)
        controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
        keyboardNav: true,              //Boolean: Allow slider navigating via keyboard left/right keys
        mousewheel: false,              //Boolean: Allow slider navigating via mousewheel
        prevText: "Previous",           //String: Set the text for the "previous" directionNav item
        nextText: "Next",               //String: Set the text for the "next" directionNav item
        pausePlay: false,               //Boolean: Create pause/play dynamic element
        pauseText: 'Pause',             //String: Set the text for the "pause" pausePlay item
        playText: 'Play',               //String: Set the text for the "play" pausePlay item
        randomize: false,               //Boolean: Randomize slide order
        slideToStart: 0,                //Integer: The slide that the slider should start on. Array notation (0 = first slide)
        animationLoop: false,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
        pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
        pauseOnHover: true,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
        controlsContainer: "",          //Selector: Declare which container the navigation elements should be appended too. Default container is the flexSlider element. Example use would be ".flexslider-container", "#container", etc. If the given element is not found, the default action will be taken.
        manualControls: "",             //Selector: Declare custom control navigation. Example would be ".flex-control-nav li" or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
        start: function(){},            //Callback: function(slider) - Fires when the slider loads the first slide
        before: function(){},           //Callback: function(slider) - Fires asynchronously with each slider animation
        after: function(){},            //Callback: function(slider) - Fires after each slider animation completes
        end: function(){}               //Callback: function(slider) - Fires when the slider reaches the last slide (asynchronous)
    }
  
    //FlexSlider: Plugin Function
    $.fn.flexslider = function(options) {
        return this.each(function() {
            if ($(this).find('.slides li').length == 1) {
                $(this).find('.slides li').fadeIn(400);
            }
            else if ($(this).data('flexslider') != true) {
                new $.flexslider($(this), options);
            }
        });
    } 
 
   
})($);





