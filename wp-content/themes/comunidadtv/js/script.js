var js = {
    changeTab : function(item){
        var target = $(item).attr('data-num');
        var obj = $('#widget_twitter .tab_content[data-num="'+  target  +'"]');
        
        $('#widget_twitter .tab_content').css('display','none');
        $(item).parent().parent().find('li').removeClass('active');
        
        obj.fadeIn();
        $(item).parent().addClass('active');

    },
    control_destacados : function(e,item){
        var tab = $(e).attr("data-tab") 
        $(e).parent().parent().parent().prev().find('li[data-tab="'+tab+'"]').fadeIn().siblings().hide()
        $(e).parent().parent().addClass("active").siblings().removeClass('active');
    },
    pestaDest: function(e, item){
        var tab = $(e).attr("data-tab") 
        $(e).parent().parent().parent().parent().find('div[data-tab="'+tab+'"]').fadeIn().siblings(".destacadostabs").hide()
        $(e).parent().addClass("active").siblings().removeClass('active');        
    },
    ToggleVODmenu : function(item){
        $(item).parent().find('.sub-menu').toggle('fast');
    },
    tabmost : function(e){
        var tab = $(e).attr("data-tab") 
        $(e).parent().parent().next().find('div[data-tab="'+tab+'"]').fadeIn().siblings().hide()
        $(e).parent().addClass("active").siblings().removeClass('active');        
    },
    lightboxGallery : function (item){
        ancho =  window.innerWidth/2;
        alto = window.innerinnerHeight/2;
        scrollOffset = $(window).scrollTop();
        $.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action : 'ajax_vod',
                func : 'lightboxGallery',
                pid: $(item).attr('data-pid'),
                imagen: $(item).attr('data-image')
            },
            dataType: "json",
            success: function( data ) {
                var left = ancho - ((data.width - 20)/2);
                $('body').append('<div class="fancybox-wrap fancybox-desktop fancybox-type-image fancybox-opened" style="width:'+(data.width - 20)+'px; left:'+left+'px;top:'+(scrollOffset + 20)+'px"></div>');
                $('.fancybox-wrap').append(data.out);
                $('body').append('<div id="fancybox-overlay" class="overlay-fixed evtnew" data-func="closelightbox"></div>');
                $('.evtnew').evt();
            },
            error : function() {}
        });
    },
    closelightbox : function(){
        $('.fancybox-wrap').remove();
        $('#fancybox-overlay').remove()
    },
    ajaxpagination : function(item){
        var offset = $(item).parent().find('.item-row').length;
        var term = $(item).attr('data-cat');
        var postnotin = $(item).attr('data-notin');
        var func = $(item).attr('data-ajax');
        var search = $(item).attr('data-search');
        
        $.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action : 'ajax_vod',
                func : func,
                offset: offset,
                term: term,
                noin: postnotin,
                search: search,
                pagination: false
            },
            dataType: "html",
            beforeSend: function( xhr ) {
                $(item).parent().css('opacity','0.3');
            },
            success: function( data ) {
                $(item).parent().css('opacity','1.0');
                if(data){
                    $(item).before(data);
                }else{
                    $(item).html('No se encuentran más entradas.')
                    $(item).removeClass('evt');
                }
                twttr.widgets.load();
                FB.XFBML.parse();
            },
            error : function() {

            }
        });
        
    },
    ajaxFilter : function(item){
        var ptype = $(item).attr('data-ptype');
        var tax = $(item).attr('data-taxonomy');
        var cat = $(item).attr('data-term');
        var search = $(item).attr('data-search');
      
        $(item).parent().find('button').removeClass('active');
        $(item).addClass('active');
     
        $.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action : 'ajax_vod',
                func : 'searchPagination',
                offset: 0,
                term: ptype,
                tax: tax,
                cat: cat,
                search: search,
                pagination: true
            },
            dataType: "html",
            beforeSend: function( xhr ) {
                $(item).parent().parent().find('.result').css('opacity','0.3');
            },
            success: function( data ) {
                $(item).parent().parent().find('.result').css('opacity','1.0');
                if(data){
                    $(item).parent().parent().find('.result').html(data);
                }else{
                    $(item).parent().parent().find('.result').html('<p>No se han encontrado datos para <strong>'+$(item).text()+'</strong> para el término de búsqueda <strong>"'+search+'"</strong></p>');
                }
                $('.evt').evt();
                twttr.widgets.load();
                FB.XFBML.parse();
            },
            error : function() {

            }
        });
      
      
    },
    canalesCarrusel : function($container){
        var liWidth = $container.find('img').outerWidth(true),
        countli = $container.find('img').length,
        containerWidth = liWidth * countli;
            
        $container.width(containerWidth);
    },
    movevod : function(item){
        var canales = $('.canales-on-demand-img');
        var liWidth = canales.find('img').outerWidth(true);
        var containerWidth = $(item).parent().width();
        var position = canales.position();
        
        var offset = (containerWidth - canales.width()) + 30;
        
        if(($(item).hasClass('right')) && (position.left >= offset)){
            
            canales.animate({
                left: '+=-'+liWidth
            });
        }else if(($(item).hasClass('left')) && (position.left < 0)){
            canales.animate({
                left: '+='+liWidth
            });
        }
        
    }
}

$(function(){
    $('.evt').evt();
    $("#vtr_hoy article.alpha").equalHeights();
    $(".vod-contenido .grid_2").equalHeights();
    
    
    js.canalesCarrusel($(".canales-on-demand-img"));

    $('.stand').hover(
        function () {
            var tooltip = $(this).next();
            tooltip.fadeIn();
            tooltip.animate({
                opacity: 1,
                top: '60'
            });
        },
        function () {
            var tooltip = $(this).next();
            tooltip.fadeOut();
            tooltip.animate({
                opacity: 0,
                top: '100'
            });
        }
        );
    
});

// plugins
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
    $.fn.equalHeights = function(minHeight, maxHeight) {
        var tallest = (minHeight) ? minHeight : 0;
        this.each(function() {
            if($(this).height() > tallest) {
                tallest = $(this).height();
            }
        });
        if((maxHeight) && tallest > maxHeight) tallest = maxHeight;
        return this.each(function() {
            $(this).height(tallest);
        });
    }
})($);

