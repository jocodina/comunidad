function splide(content,loadFrom,defaultImage)
{
      /**fix some ie issues with the menu**/
      $("#topnav li>div").css({zIndex:888}).parent().css({zIndex:777})  ;
      
      var count = 7;
      var baseLeft = 210; 
      var move = 0;
      var moving = false;
      var auxbox = null;
      var boxes = [
                    {mL:"0px",st:6,sl:0,zIndex:5,ratio:"0.57",index:0,w:0,h:0,src:"",href:""},
                    {mL:"0px",st:6,sl:10,zIndex:6,ratio:"0.71",index:1,w:0,h:0,src:"",href:""},
                    {mL:"0px",st:1,sl:16,zIndex:7,ratio:"0.85",index:2,w:0,h:0,src:"",href:""},
                    {mL:"0px",st:0,sl:0,zIndex:8,ratio:"1.0",index:3,w:0,h:0,src:"",href:""},
                    {mL:"0px",st:1,sl:-16,zIndex:7,ratio:"0.85",index:4,w:0,h:0,src:"",href:""},
                    {mL:"0px",st:6,sl:-10,zIndex:6,ratio:"0.71",index:5,w:0,h:0,src:"",href:""},
                    {mL:"0px",st:6,sl:0,zIndex:5,ratio:"0.57",index:6,w:0,h:0,src:"",href:""},
                    
                  ];
                         
      $container = $("<div class='splide-container splide-container-loading'></div>").appendTo(content);
      
      $.ajax({
        type: "GET",
	      url: loadFrom,
        dataType: "json",
      	success: function(data) {
      	    var i = 0;
      	     var filtered= [];
      	     $.each( data, function(indexInArray, obj){
                var since = mysqlTimeStampToDate(obj.desde);
                var until = mysqlTimeStampToDate(obj.hasta);
                var ahora = new Date();
                if((since<ahora && ahora < until))
                {
                  if(filtered.length<7)
                    filtered.push(obj);
                }                                        				                       			
             });  
           var falta = 7 - filtered.length;
           
           for(i = 0;i<falta; ++i)
           {
            filtered.push({src:defaultImage,callurl:"#",target:""});
           }                              
             
            res = filtered.splice(2,3);
            filtered.reverse();
            res.reverse();
            $.each(res,function(index,obj){ filtered.push(obj);});
             
            i = 0; 
            $.each(filtered,function(index,obj){
        				boxes[i].src = obj.src;
                boxes[i].href = obj.callurl;
                boxes[i].target = obj.target;
                        				
        				++i;
      			});
      			
      		
            init();  
                 
      	},
      	error:function(XMLHttpRequest, textStatus, errorThrown)
      	{
          alert("Error:"+textStatus);
        }
      });
      var loadedCount = 0;
           
      function init()
      {
           $container.removeClass("splide-container-loading"); 
          $prev= $("<a class='splide-prev' href='#'></a>").bind("click",goElementsNext).appendTo($container);
          $nxt = $("<a class='splide-next' href='#'></a>").bind("click",goElementsPrev).appendTo($container); 
            
                  
          for(var i=0; i<count; ++i)
          {
            boxes[i].mL = (baseLeft -70*i - (91*boxes[i].ratio) + boxes[i].sl )+"px";
            boxes[i].mT =  (-129*boxes[i].ratio + boxes[i].st)+"px";
            boxes[i].w =  (182*boxes[i].ratio) +"px";
            boxes[i].h =  (258*boxes[i].ratio) +"px",
            boxes[i].o = $("<div><a href='"+boxes[i].href+"' target='"+boxes[i].target+"'></a></div>")
                .addClass("splide-element element-img-"+i)
                .css({
                  width:boxes[i].w,
                  height:boxes[i].h,
                  backgroundColor:"#000",
                  border:"1px solid #fff",
                  opacity:"1",
                  position:"absolute",
                  top:"50%",
                  marginTop: boxes[i].mT,
                  left:"50%",
                  marginLeft:boxes[i].mL,
                  zIndex: boxes[i].zIndex,
                  textAlign:"center",
                  opacity:1
                })                              
                .data("index",i)
                .bind("click",onElementClick)                              
                .appendTo($container)
                .hide()
                .fadeIn("fast")
               ;
                
                 var img = new Image();
                 $(img)                 
                 .appendTo( boxes[i].o.find("a") )
                 .hide()
                 .load(function(){
                     $(this).hide();
                     $(this).fadeIn("slow");
                 })
                 .css({border:"none", width:"100%",height:"100%"})
                 .attr('src', boxes[i].src);  
                    
                
                 
                                           
          }
       }  
             
       function onElementClick(ev)
       {          
          
          if(moving || move!=0)
          {
                      
            return false;
          }
          
          move = $(this).data("index") -3;          
          if(move>0)
          {
          
            --move;     
            goElementsNext();
             
          } 
          else if(move<0)
          {
           
            ++move;           
            goElementsPrev();
             
          }
          else if(move == 0 && $(this).find("a").attr("href")!="#")
          {
                                  
            return true;            
          
          }
          
          return false;         
                      
        }
        function goElementsNext(){
          moving = true;  
          auxbox = boxes[0].o.clone().bind("click",onElementClick);
          auxbox.css({marginLeft:boxes[6].o.css("margin-left"),zIndex:boxes[6].zIndex});
          auxbox.appendTo($container);  
          
          $nxt.unbind("click",goElementsPrev)
          $prev.unbind("click",goElementsNext)      
     
          for(i = 6; i>0; i--){
            boxes[i].o.animate({
              width:boxes[i-1].w,
              height:boxes[i-1].h,
              marginLeft:boxes[i-1].mL,
              marginTop:boxes[i-1].mT             
             },elementSpeed(),"linear",(i-1==0)?onNextComplete:dummy).css("z-index",boxes[i-1].zIndex+1 );
          }
          
        }
        function goElementsPrev(){
          moving = true; 
          auxbox = boxes[6].o.clone().bind("click",onElementClick);
          auxbox.css({marginLeft:boxes[0].o.css("margin-left"),zIndex:boxes[0].zIndex});
          auxbox.appendTo($container);
        
          $nxt.unbind("click",goElementsPrev)
          $prev.unbind("click",goElementsNext) 
 
          for(i = 0; i<6; i++){
            boxes[i].o.animate({
              width:boxes[i+1].w,
              height:boxes[i+1].h,
              marginLeft:boxes[i+1].mL,
              marginTop:boxes[i+1].mT             
             },elementSpeed(),"linear",(i+1==6)?onPrevComplete:dummy).css("z-index",boxes[i+1].zIndex+1 );
          }
        }
        function onPrevComplete()
        {
          boxes[6].o.remove();
          boxes[6].o = null;
          for(i=6;i>0;--i){
            boxes[i].o = boxes[i-1].o;
            boxes[i].o.data("index",i);
          }          
          boxes[6].o.css("z-index",boxes[6].zIndex);
          boxes[0].o = auxbox;
          boxes[0].o.data("index",0)  
          if(move==0)
          { 
            $nxt.bind("click",goElementsPrev)
            $prev.bind("click",goElementsNext);
          }
          else if(move<0)
          {
            move++;
            goElementsPrev();
          }
          moving = false;                         
        }
        function onNextComplete()
        {
          boxes[0].o.remove();
          boxes[0].o = null;
          for(i=0;i<6;++i){
            boxes[i].o = boxes[i+1].o;
            boxes[i].o.data("index",i);
            
          }          
          boxes[0].o.css("z-index",boxes[0].zIndex);
          boxes[6].o = auxbox;
          boxes[6].o.data("index",6)
          if(move==0)
          { 
            $nxt.bind("click",goElementsPrev);
            $prev.bind("click",goElementsNext);
          }
          else if(move>0)
          {
            move--;
            goElementsNext();
          }  
          moving = false;
        }
        function dummy(){}
        function elementSpeed(){
         switch(move)
         {
            case 3:
            case -3:
              return 200;
            break;
            case 2:
            case -2:
              return 300;
            break;
            case 1:
            case -1:
            case 0:
              return 600;
            break;            
         }
        }
        function mysqlTimeStampToDate(timestamp) {
          //function parses mysql datetime string and returns javascript Date object
          //input has to be in this format: 2007-06-05 15:26:02
          var regex=/^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9]) (?:([0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$/;
          var parts=timestamp.replace(regex,"$1 $2 $3 $4 $5 $6").split(' ');
          return new Date(parts[0],parts[1]-1,parts[2],parts[3],parts[4],parts[5]);
        }
       
}