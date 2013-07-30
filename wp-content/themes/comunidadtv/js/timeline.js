var tl = {
    contingencia: '',
    contingenciafamosos: '',

    twittercomunidad : function(){
        if($('#tweets').length != 0){
            var key = $('#tweets').attr('data-twitter');
            var count = 30;
            if(key){
                key = key.split(',');
                key = key.join(" OR ");
            }
            $.ajax({
                url:'http://search.twitter.com/search.json',
                data:{
                    q: key,
                    result_type : 'recent',
                    rpp: count,
                    lang: 'es'
                },
                dataType:"jsonp",
                jsonp:"callback",
                jsonpCallback:"contingencia"
            })  
        } 
     
    },
    
    twitterfamosos : function(){
        if($('#mas-famosos').length != 0){
            var key = $('#mas-famosos').attr('data-twitter');
            var count = 30;
            if(key){
                key = key.split(',');
                key = key.join(" OR ");
            }
            $.ajax({
                url:'http://search.twitter.com/search.json',
                data:{
                    q: key,
                    result_type : 'recent',
                    rpp: count,
                    lang: 'es'
                },
                dataType:"jsonp",
                jsonp:"callback",
                jsonpCallback:"contingenciafamosos"
            })  
        } 
     
    },
    
    timeline : function(){
           $('#tweets').html(tl.contingencia);
           $('#mas-famosos').html(tl.contingenciafamosos);
           
           tl.inter = setInterval(function(){
                if($( "#tweets li").length < 10 ) {
                    clearInterval(tl.inter);
                }
                $("#tweets li:first-child").slideUp();
                $("#tweets li:first-child").remove();
               
            }, 10000);
    }

}

function contingencia(tw) {
    var content;
    var newContent;
    
    $.each(tw.results,function(ii,itemtw){
        content = itemtw.text.substring(0, 150);
        newContent = content.replace(/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&~\?\/.=]+/g, function(url) {
            return url.link(url);
        });
        newContent = newContent.replace(/[@]+[A-Za-z0-9-_]+/g, function(u) {
            var username = u.replace("@","")
            return u.link("http://twitter.com/"+username);
        });
        newContent = newContent.replace(/[#]+[A-Za-z0-9-_]+/g, function(t) {
            var tag = t.replace("#","%23")
            return t.link("http://search.twitter.com/search?q="+tag);
        });
        tl.contingencia += '<li><p><img src=" '+ itemtw.profile_image_url +' ">'+  newContent +' por '+  itemtw.from_user  +'</p></li>';                
    });
}

function contingenciafamosos(tw) {
    var content;
    var newContent;
    
    $.each(tw.results,function(ii,itemtw){
        content = itemtw.text.substring(0, 150);
        newContent = content.replace(/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&~\?\/.=]+/g, function(url) {
            return url.link(url);
        });
        newContent = newContent.replace(/[@]+[A-Za-z0-9-_]+/g, function(u) {
            var username = u.replace("@","")
            return u.link("http://twitter.com/"+username);
        });
        newContent = newContent.replace(/[#]+[A-Za-z0-9-_]+/g, function(t) {
            var tag = t.replace("#","%23")
            return t.link("http://search.twitter.com/search?q="+tag);
        });
        tl.contingenciafamosos += '<li><p><img src=" '+ itemtw.profile_image_url +' ">'+  newContent +' por '+  itemtw.from_user  +'</p></li>';
    });
}

$(function(){
    tl.twittercomunidad();
    tl.twitterfamosos();
    setTimeout(function(){
        tl.timeline()
    },5500);
});
