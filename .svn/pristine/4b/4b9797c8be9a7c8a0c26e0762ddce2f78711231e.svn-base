var noEvent = {
    alerta:true,
    the_title : null,
    moveto:false,
    destresu:false,
    firstload:false,
    dataGrilla : function(datos){
        $.ajax(
        {
            type :'GET',
            url :'/index.php',
            dataType : 'json',
            data : datos,
            cache:false,
            contentType: "application/json; charset=utf-8",
            beforeSend : function(e){
                $('#boxgrilla li').html("");
                $('#boxgrilla').before('<div class="opacy">Cargando... </div>');
                $('.opacy').animate({
                    opacity:0.7
                })
                e.setRequestHeader("Content-type","application/json; charset=utf-8");
            },
            success : function(e){
                $('#canales ul').html("");
                $('#boxgrilla li').html(e.grilla);
                $('#canales ul').html(e.canales);
                $('.verficha').bind("click", function(e){
                    onClickInClass.verficha(this);
                    return false;
                });
            },
            error : function(e){
                var obj;
                var midato = e.responseText;
                eval("obj="+midato);
                $('#canales ul').html("");
                $('#boxgrilla li').html(obj.grilla);
                $('#canales ul').html(obj.canales);
                $('.verficha').bind("click", function(e){
                    onClickInClass.verficha(this);
                    return false;
                });
            },
            complete: function(e){
                if(noEvent.moveto!=false){
                    mt = noEvent.moveto;
                    $('body')
                    .wait(600,function(){
                        $('.opacy').remove();
                    })
                    .wait(500, function(){
                        $('#boxgrilla,#reloj').animate({
                            scrollLeft: mt + 'px'
                        }, 100);
                    });
                }
                else{
                    $('.opacy').wait(800, function(){
                        var now = new Date();
                        var hour=(now.getHours() * 60) * 4;
                        $('#boxgrilla,#reloj').animate({
                            scrollLeft:  hour+'px'
                        }, 10 );
                    }).wait(3000,function(){
                        $('.opacy').remove();
                    });
                }
                if(noEvent.destresu!=false) $(noEvent.destresu).css('background', '#E11B22').animate({
                    backgroundColor:'#ffcccc'
                }, 1000 );
                $('.logoc').bind("mouseenter", function(e){
                    onMouseEnterLeave.logoc(this, 'stop')
                }).bind("mouseleave", function(e){
                    onMouseEnterLeave.logoc(this, 'resume')
                });
                noEvent.moveto=false;
                noEvent.destresu=false;
            }
        });
    },
    detectFecha : function(){
        if ( $("#boxgrilla").attr("class") ){
            fecha = $("#boxgrilla").attr("class").split("_");
            if (fecha[1]){
                return "&fecha="+fecha[1];
            }
        }
        else {
            return "";
        }
    },
    detectCat : function (){
        if ( $("#canales ul").attr("class") ){
            cate = $("#canales ul").attr("class").split("_");
            if (cate[1]){
                return "&canal_tipo="+cate[1];
            }
        }
        else {
            return "&canal_tipo=cate";
        }
    },
    mascanales : function(n){
        hashDate = noEvent.detectFecha();
        hashCanal = noEvent.detectCat();
        $('#downgrilla').unbind("click")
        var chn = $('#boxgrilla li ul:last').attr('class').split("_");
        chn = chn[1].split(" ");
        menos=-1;
        if (noEvent.firstload==false){
            if (parseInt(chn[0]) >= 10 ){
                menos = 10;
                noEvent.firstload=true;
            }
        }
        chn = parseInt(chn[0])-menos;

        $('#boxgrilla').before('<div class="opacy">Cargando... </div>');
        $('.opacy').wait(1, function(){
            $('.opacy').css('filter','alpha(opacity=80)').css('-moz-opacity','0.8').css('-khtml-opacity','0.8').css('opacity','0.8');
        });
        $.ajax(
        {
            type :'GET',
            url :'/index.php',
            dataType : 'json',
            data :'obt=grilla&comuna='+$("#comunaElegida").val()+'&canal_inicio='+chn+'&canal_cantidad='+ n + hashDate + hashCanal,
            success : function(e){
                $('#boxgrilla li ul:last').after(e.grilla);
                $('#canales li:last').after(e.canales);
            },
            complete: function(){
                $('.opacy').wait(600, function(){
                    $('.opacy').remove();
                    $('#downgrilla').bind('click', function(){
                        onClickInId.downgrilla()
                    });
                });
                $('ul#boxgrilla,#canales').animate({
                    scrollTop: '+=510px'
                }, 300 );
                $('.logoc').bind("mouseenter", function(e){
                    onMouseEnterLeave.logoc(this, 'stop')
                }).bind("mouseleave", function(e){
                    onMouseEnterLeave.logoc(this, 'resume')
                });
            }
        });
    },
    menoscanales : function(n){

        if ($('#boxgrilla').scrollTop()>=1){

            $('#upgrilla').unbind("click")
            $('#boxgrilla').before('<div class="opacy">Cargando... </div>');
            $('.opacy').wait(100, function(){
                $('.opacy').css('filter','alpha(opacity=50)').css('-moz-opacity','0.5').css('-khtml-opacity','0.5').css('opacity','0.5');
            }).wait(200, function(){
                $('.opacy').remove();
                $('#upgrilla').bind('click', function(){
                    onClickInId.upgrilla()
                });
            });
            var chn = $('#boxgrilla li ul:last').attr('class').split("_");
            var chn = chn[1].split(" ");
            chn = chn[0];
            n = chn - n;
            $('#boxgrilla,#canales').animate({
                scrollTop: '-=510px'
            }, 600 );
        //            $('#boxgrilla li > ul:gt('+n+')').remove();
        //            $('#canales li:gt('+n+')').remove();
            
        }
    },
    ahora : function(){
        $('.botoncor, .botonlar').removeClass('active');
        $('#ahora').addClass('active');
        var now = new Date();
        var hour=(now.getHours() * 60) * 4;
        $('ul#boxgrilla , #reloj, #boxprogramas, .horas' ).animate({
            scrollLeft:  hour+'px'
        }, 150 );
    },
    getResults : function(){
        if ($("#searchbox").val().length < 4 ) $('.busqlist').remove();
        $('.resubusq').unbind("click");
        if ($("#searchbox").val().length > 3 ) $.get("/index.php",{
            obt:'search',
            search: $("#searchbox").val()
        }, function(data){
            $('.busqlist').remove();
            list="";
            pogram_id ="";
            $.each(data, function(i, value){
                if (value.ProgramID != pogram_id){

                    if(value.genero=="Estilos & Tendencias"){
                        value.genero="tendencias";
                    }
                    list += '<li><a id="id_'+value.ProgramID+'" href="#" title="Ir a '+value.Title+'" class="resubusq chn_'+value.ChannelID+' starttime_'+value.StartTime+' startdate_'+value.StartDate+' tipo_'+value.genero+'" >'+value.senal+', '+value.Title+'</a></li>'
                }
                pogram_id  = value.ProgramID;
            })
            $("#content #search").append('<ul class="busqlist">'+list+'</ul>');
            if ($("#searchbox").val().length < 4 ) $('.busqlist').remove();
        }, 'json');
        $('.resubusq').die()
        $('.resubusq').live("click",function(e){
            onClickInClass.resubusq(this);
            return false;
        });
    }
}
//funciones que se basan en si la clase css existe en la estructura html
var onClickInClass = {
    regiback : function(){
        $('#warpregi').animate({
            scrollLeft: '-=240px'
        }, 500 );
    },
    regiforw : function(){/*grilla de programación*/
        $('#warpregi').animate({
            scrollLeft: '+=240px'
        }, 500 );
    },
    verficha : function (that){
        $('#ficha').remove();
        if(document.getElementById('boxprogramas')) {
            return false;
        }
        $('.minificha').remove();
        var canal_tipo  = $(that).parent().parent().attr("class").split(' ');
        var chn_prog  = that.id.split('_');
        var chn  = chn_prog[0]
        var prog  = chn_prog[1]
        var clase  = $("#"+that.id).attr('class').split(" ");
        var stime = clase[1].split("_");
        var sdate = clase[2].split("_");
        $.get('/index.php', {
            obt:'minificha',
            channels: chn,
            programs:  prog,
            starttime: stime[1],
            startdate:sdate[1],
            canal_tipo:canal_tipo[2]
        }, function(e){
            $("#reloj").after(e);
        }, 'html');
        $('#cerrarf').live("click",function(e){
            onClickInId.cerrarf(this);
            return false;
        });
    },
    sel_despl : function(that){
        hashDate = noEvent.detectFecha();
        $("#canales ul").attr("class", "").addClass(that.id);
        $('.desplegable li:gt(0)').hide()
        var mostrar = that.id.split("_");
        $('#boxgrilla,#canales').animate({
            scrollTop: '0'
        }, 500 );
        noEvent.dataGrilla('obt=grillacat&canal_tipo='+mostrar[1]+hashDate+'&comuna='+$("#comunaElegida").val());
    },
    sel_date : function(that){
        $('.botoncor, .botonlar').removeClass('active');
        hashCanal = noEvent.detectCat();
        var fecha = that.id.split("_");
        $("#boxgrilla").attr("class", "").addClass(that.id);
        noEvent.dataGrilla('obt=grillaDate&fecha='+fecha[1]+hashCanal+'&comuna='+$("#comunaElegida").val());
        $(that).addClass('active');
        fecha_d = fecha[1];
        mes = mes_abreviado(fecha_d.substring(0,2));
        dia = fecha_d.substring(2,4);
        poner_fecha = dia + " " + mes;
        $(".fecha_grilla").text(poner_fecha);
    },
    sel_date_desp : function(that){
        $('.botoncor, .botonlar').removeClass('active');
        hashCanal = noEvent.detectCat();
        var fecha = that.id.split("_");
        $("#boxgrilla").attr("class", "").addClass(that.id);
        noEvent.dataGrilla('obt=grillaDate&fecha='+fecha[1]+hashCanal+'&comuna='+$("#comunaElegida").val());
        fecha_d = fecha[1];
        mes = mes_abreviado(fecha_d.substring(0,2));
        dia = fecha_d.substring(2,4);
        poner_fecha = dia + " " + mes;
        $(".fecha_grilla").text(poner_fecha);
    },
    resubusq : function(e){
        id = e.id;
        clave = new Array;
        valor = new Array;
        $.each($(e).attr('class').split(" "), function(i, value){
            var arr = value.split("_");
            clave[i] = arr[1];
            valor[i] = arr[1];
        });

        clave.shift() && valor.shift();
        //valor[1]; chn
        //valor[2]; time
        //valor[3]; date
        //valor[4]; genero
        if (valor[4]=="Cine&Series") valor[4]='series';
        ini_hora =  (valor[2].substr(0, 2)-4)*60; //-4 es GTM  en verano y -3 es GTM  en invierno
        if ((valor[2].substr(0, 2)-4)<0){ //-4 es GTM  en verano -3 es GTM  en invierno
            ini_hora =  (24+(valor[2].substr(0, 2)-4))*60; //-4 es GTM en verano
        }
        var ini_min =  valor[2].substr(2,4);
        var left = (parseInt(ini_hora) + parseInt(ini_min))*4;
        noEvent.moveto = left;
        noEvent.destresu = "ul#canal_"+valor[1]+" li.ini_"+left;
        $('#boxgrilla,#canales').animate({
            scrollTop: '0'
        }, 500 );
        noEvent.dataGrilla("obt=gotoresu&hora="+valor[2]+"&fecha="+valor[3]+"&channel="+valor[1]+"&tipo="+valor[4]+'&comuna='+$("#comunaElegida").val());
        $('#ficha').remove();
        $('.busqlist').remove();
    },
    cerrar : function(that){
        $(that).parent("div").hide();
    },
    help: function(){},
    user: function(that){
        $('#comunidad').hide()
        $('#login').show();
        $('#barra-vtr').css('background','url(/wp-content/themes/televisionvtr/img/menuvtrnew/header-log.png) no-repeat');
    },
    cancel: function(that){
        $('#comunidad').show()
        $('#login').hide();
        $('#barra-vtr').css('background','url(/wp-content/themes/televisionvtr/img/menuvtrnew/header-sb.png) no-repeat ');
    },
    eliminar_fan : function(that){
        fi= $(that).attr("id").split("_");
        $.get('/index.php', {
            del_fan:'true',
            hazte_fan: fi[1]
        }, function(e){
            if (e == "true"){
                $(that).parent().parent().remove();
            }
        }, 'json');
    },
    forw : function(){
        $('.wrap').animate({
            scrollLeft:'+=600px'
        }, 500 );
    },
    back :function(){
        $('.wrap').animate({
            scrollLeft:'-=600px'
        }, 500 );
    }
}
//funciones que se basan en si la clase css existe en la estructura html
var onClickInId = {
    sel_cat : function(){
        return false
    },
    cerrarf : function(){
        $("#ficha").remove();
    },
    ahora : function(){
        $('.botoncor, .botonlar').removeClass('active');
        $('#ahora').addClass('active');
        hashDate = noEvent.detectFecha();
        var now = new Date();
        var hour=now.getHours()*60 * 4;
        if (hashDate==""){
            $('ul#boxgrilla , #reloj' ).animate({
                scrollLeft:  hour+'px'
            }, 150 );
        }
        else{
            hashCanal = noEvent.detectCat();
            noEvent.dataGrilla('obt=grilla'+hashCanal+'&comuna='+$("#comunaElegida").val());
        }
        f = new Date();
        dia = f.getDate();
        mes = f.getMonth() + 1;
        var mes_s = String(mes);
        mes = mes_abreviado(mes_s);
        poner_fecha = dia + " " + mes;
        $(".fecha_grilla").text(poner_fecha);
    },
    prime : function(){
        $('.botoncor, .botonlar').removeClass('active');
        $('#prime').addClass('active');
        hashDate = noEvent.detectFecha();
        $("#boxgrilla").attr("class", "");
        if (hashDate==""){
            $('ul#boxgrilla , #reloj' ).animate({
                scrollLeft:  '5280px'
            }, 500 );
        }
        else{
            hashCanal = noEvent.detectCat();
            noEvent.dataGrilla('obt=grilla'+hashCanal+'&comuna='+$("#comunaElegida").val());
            noEvent.moveto = 5280;
        }
    },
    btnback : function(){
        $('#boxprogramas,.horas').animate({
            scrollLeft: '-=240px'
        }, 500 );
    },
    btnforw : function(){/*grilla de programación*/
        $('#boxprogramas,.horas').animate({
            scrollLeft: '+=240px'
        }, 500 );
    },
    btnup : function(){
        $('#canales,#boxprogramas').animate({
            scrollTop: '-=204px'
        }, 300 );
    },
    btndown : function(){
        $('#canales,#boxprogramas').animate({
            scrollTop: '+=204px'
        }, 300 );
    },
    backgrilla : function(){
        $('#ficha').remove();
        $('ul#boxgrilla,#reloj').animate({
            scrollLeft: '-=480px'
        }, 500 );
    },
    forwgrilla : function(){
        $('#ficha').remove();
        $('ul#boxgrilla,#reloj').animate({
            scrollLeft: '+=480px'
        }, 500 );
        if($('#reloj #horas').position().left == '-4800'){
            noEvent.moveto = 1;   
            $('#boxgrilla,#reloj').animate({scrollLeft: '0'}, 100);            
            f = new Date();
            dia = f.getDate()+1;
            mes = f.getMonth() + 1;
            ano = f.getFullYear();        
            dia = dia < 10 ? "0"+String(dia):String(dia);
            mes = mes < 10 ? "0"+String(mes):String(mes);
            ano = String(ano).substring(2,4) 
            $("#fecha_"+ mes+dia+ano).trigger("click") ;
        }        
    },
    upgrilla : function(){
        $('#ficha').remove();
        noEvent.menoscanales(10);
    },
    downgrilla : function(){
        $('#ficha').remove();
        noEvent.mascanales(10);
    },
    loginbox : function(){
        noEvent.html =  $('.registro').clone();
        var codehtml = '<form id="loginform" name="loginform" action="http://televisionvtr.cl/wp-login.php" method="post"><label for="user_login">Nombre de usuario:</label> <input type="text" name="log" id="user_login"> <label for="user_pass">Contraseña:</label> <input type="password" name="pwd" id="user_pass"> <input type="submit" name="submit" value="Ingresar"> <input type="hidden" value="http://televisionvtr.cl/programacion/" name="redirect_to"/><input type="hidden" value="login" name="action"/><input type="hidden" value="1" name="testcookie"/> | <a href="/programacion" title="cancelar login" id="cancelogin">cancelar</a></form>';
        $('.registro').html(codehtml);
        $('#cancelogin').live("click",function(e){
            onClickInId.cancelogin(this);
            return false;
        });
    },
    cancelogin : function(){
        $('.registro').replaceWith( noEvent.html);
    },
    userid : function(){
        $('#userid').val("");
    },
    passid : function(){
        $('#passid').val("");
    }
}
var onMouseEnterLeave = {
    logoc: function(that, status){
        if(status=="stop"){
            noEvent.the_title = $(that).attr("title");
            $(that).attr("rel", $(that).attr("title"));
            $(that).attr("title","" );
            var driver = '<div id="the_driver">'+noEvent.the_title+'</div>'
            $(that).parent().append(driver);
            $("#the_driver").css("display","block");
            $("#the_driver").css("color","#CCC");
            $("#the_driver").css("color","#CCC");
            $("#the_driver strong").css("color","#FFF");
            $("#the_driver").css("background","#646359");
            $("#the_driver").css("width","400px");
            $("#the_driver").css("heigth","80px");
            $("#the_driver").css("position","absolute");
            $("#the_driver").css("margin-top","0");
            $("#the_driver").css("margin-left","70px");
            $("#the_driver").css("z-index","100");
            $("#the_driver").css("padding","5px");
            $("#the_driver").css("border","none");
            $("#the_driver").mouseenter(function(){
                $(".logoc").trigger('mouseenter');
            });
        }
        else{
            $(that).attr("title", $(that).attr("rel"));
            $("#the_driver").remove();
        }
    },
    desplegable: function(that,status){
        if( status == "stop"){
            $('.desplegable li').show();
        }
        else{
            $('.desplegable li:gt(0)').hide();
        }
    },
    desplfecha: function(that,status){
        if( status == "stop"){
            $('.desplfecha li').show();
        }
        else{
            $('.desplfecha li:gt(0)').hide();
        }
    },
    help:function(that, status){
        if( status == "stop"){
            $(that).next().show();
        }
        else{
            $(that).next().hide();
        }
    }
}
var onChangeId = {
    region : function(){
        list="";
        $.get("/index.php",{
            obt:'comuna',
            comuna: $("#region").val()
        }, function(data){
            $.each(data, function(i, value){
                list += '<option valie="'+i+'">'+value+'</option>';
            })
            $("#comuna").html(list);
        }, 'json');
    }
}
$(document).ready(function(){
 var rnd=Math.floor(Math.random()*6);
       $("#logo").addClass("l"+rnd);
       $("#header-late2011-wrapper").addClass("wrapper-t"+rnd);   
       $("#header-late2011-small-wrapper").addClass("color"+rnd);       
       $(".footer_vtr").addClass("footer_vtr-t"+rnd);
    $.each(onClickInClass, function (i) {
        if ($.isFunction(eval("onClickInClass."+i)) && $('*').hasClass(i)){
            $('.'+i).live("click", function(e){
                eval("onClickInClass."+i+"(this)");
                return false;
            });
        }
    });
    $.each(onChangeId, function (i) {
        if ($.isFunction(eval("onChangeId."+i)) && document.getElementById(i)){
            $('#'+i).bind("change", function(e){
                eval("onChangeId."+i+"(this)");
                return false;
            });
        }
    });
    $.each(onClickInId, function (i) {
        if ($.isFunction(eval("onClickInId."+i)) && document.getElementById(i)){
            $('#'+i).bind("click", function(e){
                eval("onClickInId."+i+"(this)");
                return false;
            });
        }
    });
    $.each(onMouseEnterLeave, function (i) {
        if ($.isFunction(eval("onMouseEnterLeave."+i)) && $('*').hasClass(i)){
            $('.'+i).bind("mouseenter", function(e){
                eval("onMouseEnterLeave."+i+"(this, 'stop')")
            }).bind("mouseleave", function(e){
                eval("onMouseEnterLeave."+i+"(this, 'resume')")
            });
        }
    });
    $("#searchbox").keyup(function(e){
        if(e.keyCode!=13) noEvent.getResults();
    });
    $('#searchbox').bind('keypress', function(e){
        if(e.keyCode==13){
            $(".prev").remove();
            $(".busqlist").prepend('<li class="prev"><a style="background:red;color:white" href="#">Selecciona un resultado con el mouse</a></li>');
            return false;
        }
    });
    $("#boxprogramas").mousedown(function(e){
        coor = e.pageX;
        $("#boxprogramas").css('cursor', 'pointer');
        $("#boxprogramas").mousemove(function(e){
            if (coor > e.pageX) var desp = '+=4';else var desp = '-=4';
            $('#boxprogramas').animate({
                scrollLeft: desp+ 'px'
            }, 2 );
            coor = e.pageX;
        });
    }).mouseup(function(i){
        $("#boxprogramas").unbind('mousemove');
        $("#boxprogramas").css('cursor', 'default');
    });
    $('.helpdec').hide();
    $('.footer_contenidos td').each( function(i, value){
        $(value).removeAttr("valign").css("vertical-align","top");
    })
    $('a[rel*=external]').click( function() {
        window.open(this.href);
        return false;
    });
    $('.resubusq').live("click",function(e){
        onClickInClass.resubusq(this);
        return false;
    });
    $('.vod').show();
    noEvent.ahora();
});

(function($) {
    $.fn.wait = function(option, options) {
        milli = 1000;
        if (option && (typeof option == 'function' || isNaN(option)) ) {
            options = option;
        } else if (option) {
            milli = option;
        }
        // set defaults
        var defaults = {
            msec: milli,
            onEnd: options
        },
        settings = $.extend({},defaults, options);

        if(typeof settings.onEnd == 'function') {
            this.each(function() {
                setTimeout(settings.onEnd, settings.msec);
            });
            return this;
        } else {
            return this.queue('fx',
                function() {
                    var self = this;
                    setTimeout(function() {
                        $.dequeue(self);
                    },settings.msec);
                });
        }

    }
})(jQuery);
(function(jQuery){

    // We override the animation for all of these color styles
    jQuery.each(['backgroundColor', 'borderBottomColor', 'borderLeftColor', 'borderRightColor', 'borderTopColor', 'color', 'outlineColor'], function(i,attr){
        jQuery.fx.step[attr] = function(fx){
            if ( fx.state == 0 ) {
                fx.start = getColor( fx.elem, attr );
                fx.end = getRGB( fx.end );
            }
            fx.elem.style[attr] = "rgb(" + [
            Math.max(Math.min( parseInt((fx.pos * (fx.end[0] - fx.start[0])) + fx.start[0]), 255), 0),
            Math.max(Math.min( parseInt((fx.pos * (fx.end[1] - fx.start[1])) + fx.start[1]), 255), 0),
            Math.max(Math.min( parseInt((fx.pos * (fx.end[2] - fx.start[2])) + fx.start[2]), 255), 0)
            ].join(",") + ")";
        }
    });
    function getRGB(color) {
        var result;
        if ( color && color.constructor == Array && color.length == 3 )
            return color;
        if (result = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(color))
            return [parseInt(result[1]), parseInt(result[2]), parseInt(result[3])];
        if (result = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(color))
            return [parseFloat(result[1])*2.55, parseFloat(result[2])*2.55, parseFloat(result[3])*2.55];

        if (result = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(color))
            return [parseInt(result[1],16), parseInt(result[2],16), parseInt(result[3],16)];

        if (result = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(color))
            return [parseInt(result[1]+result[1],16), parseInt(result[2]+result[2],16), parseInt(result[3]+result[3],16)];

        return colors[jQuery.trim(color).toLowerCase()];
    }

    function getColor(elem, attr) {
        var color;
        do {
            color = jQuery.curCSS(elem, attr);
            if ( color != '' && color != 'transparent' || jQuery.nodeName(elem, "body") )
                break;
            attr = "backgroundColor";
        } while ( elem = elem.parentNode );
        return getRGB(color);
    };
    var colors = {
        aqua:[0,255,255],
        azure:[240,255,255],
        beige:[245,245,220],
        black:[0,0,0],
        blue:[0,0,255],
        brown:[165,42,42],
        cyan:[0,255,255],
        darkblue:[0,0,139],
        darkcyan:[0,139,139],
        darkgrey:[169,169,169],
        darkgreen:[0,100,0],
        darkkhaki:[189,183,107],
        darkmagenta:[139,0,139],
        darkolivegreen:[85,107,47],
        darkorange:[255,140,0],
        darkorchid:[153,50,204],
        darkred:[139,0,0],
        darksalmon:[233,150,122],
        darkviolet:[148,0,211],
        fuchsia:[255,0,255],
        gold:[255,215,0],
        green:[0,128,0],
        indigo:[75,0,130],
        khaki:[240,230,140],
        lightblue:[173,216,230],
        lightcyan:[224,255,255],
        lightgreen:[144,238,144],
        lightgrey:[211,211,211],
        lightpink:[255,182,193],
        lightyellow:[255,255,224],
        lime:[0,255,0],
        magenta:[255,0,255],
        maroon:[128,0,0],
        navy:[0,0,128],
        olive:[128,128,0],
        orange:[255,165,0],
        pink:[255,192,203],
        purple:[128,0,128],
        violet:[128,0,128],
        red:[255,0,0],
        silver:[192,192,192],
        white:[255,255,255],
        yellow:[255,255,0]
    };
})(jQuery);

function mes_abreviado(n){
    switch (n){
        case "01":
            mes = "Ene";
            break;
        case "02":
            mes = "Feb";
            break;
        case "03":
            mes = "Mar";
            break;
        case "04":
            mes = "Abr";
            break;
        case "05":
            mes = "May";
            break;
        case "06":
            mes = "Jun";
            break;
        case "07":
            mes = "Jul";
            break;
        case "08":
            mes = "Ago";
            break;
        case "09":
            mes = "Sept";
            break;
        case "1":
            mes = "Ene";
            break;
        case "2":
            mes = "Feb";
            break;
        case "3":
            mes = "Mar";
            break;
        case "4":
            mes = "Abr";
            break;
        case "5":
            mes = "May";
            break;
        case "6":
            mes = "Jun";
            break;
        case "7":
            mes = "Jul";
            break;
        case "8":
            mes = "Ago";
            break;
        case "9":
            mes = "Sept";
            break;
        case "10":
            mes = "Oct";
            break;
        case "11":
            mes = "Nov";
            break;
        case "12":
            mes = "Dic";
            break;
    }
    return mes;
}
/* max villegas */
