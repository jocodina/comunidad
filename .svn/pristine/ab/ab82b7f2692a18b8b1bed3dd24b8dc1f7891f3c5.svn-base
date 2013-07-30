jQuery(document).ready(function($){

	function onLoadHomeSlider(objt) {
		if(objt == "go"){
			var target = "target='_blank'"; 
		}else{
			var target = ""; 
		}
		var titulo = $(".destacados-tabs #tab-1_id").html();
		var imagen = $(".destacados-tabs #tab-1_imagen").html();
		var parrafo = $(".destacados-tabs .tab-1_info a").html();
		var link = $(".destacados-tabs #tab-1_link").val();
		$(".destacados-posters #tab-1 h1").html("<a href='"+link+"' "+target+">"+titulo+"</a>");
		$(".destacados-posters #tab-1 img").attr("src", imagen);
		$(".destacados-posters #tab-1 p").html("<a href='"+link+"'><p>"+parrafo+"</p></a>");
		$(".destacados-tabs ul li").removeClass("active");
		$(".destacados-tabs ul li:nth-child(1)").addClass("active");
	};
	function onLoadConrtols(){
		$('a[class$=titulo]').click(function(){
			$(".destacados-tabs ul li").removeClass("active");
			$(this).parent().parent().attr("class", "active");
			var href = $(this).attr("href");
			var patron = "#";
			var numeroTab = href.replace(patron,'');
			var titulo = $(this).html();
			var link = $(this).parent().parent().find(".permalink").val();
			var info = $("."+numeroTab+"_info").find("a").html();
			var imagen = $("#"+numeroTab+"_imagen").html();
			var logo = $("#"+numeroTab+"_logo").html();
			var time = $("#"+numeroTab+"_time").html();
			$("#tab-1 img").attr("src", imagen);
			$("#tab-1 img").attr("alt", titulo);
			$("#tab-1 h1").html("<a href='"+link+"'>"+titulo+"</a>");
			$("#tab-1 p").html("<a href='"+link+"'>"+info+"</a>");
			$("#tab-1 .logo").html(logo);
			$("#tab-1 .time").html(time);
		});
		$('a[class$=tituloP]').click(function(){
			$(".destacados-tabs ul li").removeClass("active");
			$(this).parent().parent().attr("class", "active");
			var href = $(this).attr("href");
			var patron = "#";
			var numeroTab = href.replace(patron,'');
			var titulo = $(this).parent().parent().find("h2").find("a").html();
			var link = $(this).parent().parent().find(".permalink").val();
			var info = $("."+numeroTab+"_info").find("a").html();
			var imagen = $("#"+numeroTab+"_imagen").html();
			var logo = $("#"+numeroTab+"_logo").html();
			var time = $("#"+numeroTab+"_time").html();
			$("#tab-1 img").attr("src", imagen);
			$("#tab-1 img").attr("alt", titulo);
			$("#tab-1 h1").html("<a href='"+link+"' >"+titulo+"</a>");
			$("#tab-1 p").html("<a href='"+link+"'>"+info+"</a>");
			$("#tab-1 .logo").html(logo);
			$("#tab-1 .time").html(time);
		});
	}
	onLoadHomeSlider("load");
	onLoadConrtols();


	$("#go").click(function(e){
		var goimg = $("#go img").attr("src");
		var si = $(this).attr("class");
		if(si != "activo"){
			goimg = goimg.replace(".png", "-active.png");
			$("#go img").attr("src", goimg);
			$(this).addClass("activo");
		}
		var vodimg = $("#vod img").attr("src");
		$("#vod").removeClass("activo");
		vodimg = vodimg.replace("-active.png",".png");
		$("#vod img").attr("src", vodimg);
		
		var destacadosimg = $("#destacados img").attr("src");
		$("#destacados").removeClass("activo");
		destacadosimg = destacadosimg.replace("-active.png",".png");
		$("#destacados img").attr("src", destacadosimg);

		var DESTACADOStabs = $("#destacados-des-tabs").html();
		var VODtabs = $("#destacados-vod-tabs").html();
		var GOtabs = $("#destacados-go-tabs").html();
		$(".destacados-tabs").html(GOtabs);
		$("#destacados-des-tabs").html(DESTACADOStabs);
		$("#destacados-vod-tabs").html(VODtabs);
		$("#destacados-go-tabs").html(GOtabs);

		onLoadHomeSlider("go");	
		onLoadConrtols();
		e.preventDefault();
        e.stopPropagation();
	});

	$("#vod").click(function(e){
		var vodimg = $("#vod img").attr("src");
		var si = $(this).attr("class");
		if(si != "activo"){
			vodimg = vodimg.replace(".png", "-active.png");
			$("#vod img").attr("src", vodimg);
			$(this).addClass("activo");
		}
		var goimg = $("#go img").attr("src");
		$("#go").removeClass("activo");
		goimg = goimg.replace("-active.png", ".png");
		$("#go img").attr("src", goimg);		

		var destacadosimg = $("#destacados img").attr("src");
		$("#destacados").removeClass("activo");
		destacadosimg = destacadosimg.replace("-active.png",".png");
		$("#destacados img").attr("src", destacadosimg);

		var DESTACADOStabs = $("#destacados-des-tabs").html();
		var VODtabs = $("#destacados-vod-tabs").html();
		var GOtabs = $("#destacados-go-tabs").html();
		$(".destacados-tabs").html(VODtabs);
		$("#destacados-des-tabs").html(DESTACADOStabs);
		$("#destacados-vod-tabs").html(VODtabs);
		$("#destacados-go-tabs").html(GOtabs);
		onLoadHomeSlider("vod");	
		onLoadConrtols();
		e.preventDefault();
        e.stopPropagation();
	});

	$('#display-video-container').click(function(event) {		
		$('#video-container').slideToggle('fast');
	});
	
	$("#destacados").click(function(e){
		var destacadosimg = $("#destacados img").attr("src");
		var si = $(this).attr("class");
		if(si != "activo"){
			destacadosimg = destacadosimg.replace(".png", "-active.png");
			$("#destacados img").attr("src", destacadosimg);
			$(this).addClass("activo");
		}
		var vodimg = $("#vod img").attr("src");
		$("#vod").removeClass("activo");
		vodimg = vodimg.replace("-active.png",".png");
		$("#vod img").attr("src", vodimg);

		var goimg = $("#go img").attr("src");
		$("#go").removeClass("activo");
		goimg = goimg.replace("-active.png", ".png");
		$("#go img").attr("src", goimg);

		var DESTACADOStabs = $("#destacados-des-tabs").html();
		var VODtabs = $("#destacados-vod-tabs").html();
		var GOtabs = $("#destacados-go-tabs").html();
		$(".destacados-tabs").html(DESTACADOStabs);
		$("#destacados-des-tabs").html(DESTACADOStabs);
		$("#destacados-vod-tabs").html(VODtabs);
		$("#destacados-go-tabs").html(GOtabs);
		onLoadHomeSlider("destacados");	
		onLoadConrtols();
		e.preventDefault();
        e.stopPropagation();
	});
	/*
	*FIN
	*/

	$(".button-see-social").live('click', function(event) {
		$('.social-sharers').fadeOut('fast');
		$(this).next().fadeIn('fast', function(){
			$(this).css('z-index', '99');
		});
		$(this).addClass('button-see-social-active');
		$(this).removeClass('button-see-social');
		if ($(".fb-like").length > 0) {
		    if (typeof (FB) != 'undefined') {
		        FB.init({ status: true, cookie: true, xfbml: true });
		    } else {
		        $.getScript("http://connect.facebook.net/es_ES/all.js#xfbml=1", function () {
		            FB.init({ status: true, cookie: true, xfbml: true });
		        });
		    }
		} 
	});	

	$('.button-see-social-active').live('click', function(event) {		
		$('.social-sharers').fadeOut('fast');
		$(this).addClass('button-see-social');
		$(this).removeClass('button-see-social-active');
	});

	// Tabbed Interfaces
	$(".tab_content").hide();
	$("ul.tabs").each(function() {
	    $(this).find('li:first').addClass("active");
	    $(this).next('.tab_container').find('.tab_content:first').show();
	});

	$('.menu-item').hover(function() {		
		$(this).find('.sub-menu').slideDown('fast');
	}, function() {
		$(this).find('.sub-menu').slideUp('fast');
	});

	$('.sub-menu').parent('li').addClass('dropdown');

	$("ul.tabs li a").click(function() {
	    var cTab = $(this).closest('li');
	    cTab.siblings('li').removeClass("active");
	    cTab.addClass("active");
	    cTab.closest('ul.tabs').nextAll('.tab_container:first').find('.tab_content').hide();

	    var activeTab = $(this).attr("href"); 
	    $(activeTab).fadeIn(); 
	    return false;
	});

	var param = document.URL.split('#')[1];	 	    
	
	$('#'+param).fadeIn();

	$(".gallery-icon a").fancybox();
	
	$(".fancybox").fancybox();

	$('.sub-menu').css("display", "none");

	 	$('.categoria-menu').click(function(){
	 		$(this).next('ul').toggle("slow");
	 	});	
	if(undefined != queryvar) {
		var queryvar = "FROM: franciniamaral";
	}    
		var query  = escape(queryvar),
    	url = "http://search.twitter.com/search.json?callback=?&q=" + query;
    	''	
	$.getJSON(url, function(data){		
	  $.each(data.results, function(i, tweet){
	  	tweetText = tweet.text;
	  	tweetText = tweetText.replace(/http:\/\/\S+/g, '<a href="$&" target="_blank">$&</a>');
    	tweetText = tweetText.replace(/(@)(\w+)/g, ' $1<a href="http://twitter.com/$2" target="_blank">$2</a>');
    	tweetText = tweetText.replace(/(#)(\w+)/g, ' $1<a href="http://search.twitter.com/search?q=%23$2" target="_blank">$2</a>');
	    $('#mas-famosos').append("<li><p><img src=' "+tweet.profile_image_url+" ' /> " + tweetText + " por " + tweet.from_user_name + "</p></li>");
	  });
	});	
	if(undefined != vtrfeed) {
		var vtrfeed = "FROM: VTRTelevision";
	}
	var query  = escape(vtrfeed),
	url = "http://search.twitter.com/search.json?callback=?&q=" + query;
	''	
	$.getJSON(url, function(data){		
	  $.each(data.results, function(i, tweet){
	  	tweetText = tweet.text;
	  	tweetText = tweetText.replace(/http:\/\/\S+/g, '<a href="$&" target="_blank">$&</a>');
    	tweetText = tweetText.replace(/(@)(\w+)/g, ' $1<a href="http://twitter.com/$2" target="_blank">$2</a>');
    	tweetText = tweetText.replace(/(#)(\w+)/g, ' $1<a href="http://search.twitter.com/search?q=%23$2" target="_blank">$2</a>');
	    $('#tweets').append("<li><p><img src=' "+tweet.profile_image_url+" ' /> " + tweetText + " por " + tweet.from_user_name + "</p></li>");
	  });
	});

	function autoScroll() {
	    var itemHeight = $('#tweets li').outerHeight();
	    
	    var moveFactor = parseInt($('#tweets').css('top')) + itemHeight;
	   
	    $('#tweets').animate({
	        'top' : moveFactor
	    }, 'slow', 'linear', function(){
	        $("#tweets li:first").before($("#tweets li:last"));            
	        $('#tweets').css({'top' : '-6em'});
	    });
	};
	var moveScroll = setInterval(autoScroll, 6000);

	function autoScrollFamosos() {
	    var itemHeight = $('#mas-famosos li').outerHeight();
	    
	    var moveFactor = parseInt($('#mas-famosos').css('top')) + itemHeight;
	   
	    $('#mas-famosos').animate({
	        'top' : moveFactor
	    }, 'slow', 'linear', function(){
	        $("#mas-famosos li:first").before($("#mas-famosos li:last"));            
	        $('#mas-famosos').css({'top' : '-6em'});
	    });
	};	
	var moveScroll = setInterval(autoScrollFamosos, 6000);

});

jQuery.fbInit = function(app_id) {
    window.fbAsyncInit = function() {
        FB.init({
            appId      : 434342906607120, // App ID
            status     : true, // check login status
            cookie     : true, // enable cookies to allow the server to access the session
            xfbml      : true  // parse XFBML
        });
    };

    // Load the SDK Asynchronously
    (function(d){
        var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
        js = d.createElement('script'); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/es_ES/all.js";
        d.getElementsByTagName('head')[0].appendChild(js);
    }(document));

    $('<div />').attr('id','fb-root').appendTo('body');
};

