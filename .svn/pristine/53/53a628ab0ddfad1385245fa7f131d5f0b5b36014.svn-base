// plugins
(function($) {
    $.fn.iePlaceHolder = function(){
        return this.each(function(){
            if( !Modernizr.input.placeholder ) {
                var esto = $(this);
                var placeholder = $(esto).attr('placeholder');
                
                $(esto).val(placeholder);
                
                $(this).blur(function(){
                    if( $(esto).val() == '' || $(esto).val() == placeholder ) {
                        $(esto).val(placeholder);
                    }
                });
                
                $(this).click(function(){
                    if( $(esto).val() == '' || $(esto).val() == placeholder ) {
                        $(esto).val('');
                    }
                });
            }
        });
    }
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
    $.fn.validame = function(options) {
        var settings = {
            target : false,
            async : false,
            ajaxCall : function(formObject, formData) {},
            inEvt : false,
            emptyMessage : 'Debe llenar este campo para continuar',
            emptySelectMessage : 'Debe seleccionar una opción para continuar',
            emailMessage : 'Ingrese un e-mail válido.',
            urlMessage : 'Ingrese un URL válido.',
            radioMessage : 'Debe seleccionar una opción',
            inputErrClass : 'invalidInput',
            spanErrClass : 'formErrMess'
        };
        if ( options ) {$.extend( settings, options );}

        var urlreg = /^http\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?$/,
            formErr = false;

        return this.each(function() {
            var esto = $(this);
            var target = settings.target ? $(settings.target) : $(esto).find('input[type="submit"]');
            
            var requeridos = $(esto).find('input[required]'),
                taReq = $(esto).find('textarea[required]'),
                emails = $(esto).find('input[type="email"]'),
                urls = $(esto).find('input[type="url"]'),
                selects = $(esto).find('select[required]'),
                radios = $(esto).find('input[type="radio"][required]'),
                checkboxs = $(esto).find('input[type="checkbox"][required]'),
                placeholderInputs = $(esto).find('[placeholder]'),
                placeholder = "",
                name = "";
            
            if( settings.inEvt == true ){
                $(esto).find('*').removeClass(settings.inputErrClass);
                $(esto).find('.'+settings.spanErrClass).remove();

                formErr = false;

                requeridos.each(function(){
                    placeholder = $(this).attr('placeholder');
                    if ( $(this).val() == "" || $(this).val() == placeholder) {
                        $(this).addClass(settings.inputErrClass);
                        $(this).after('<span class="'+settings.spanErrClass+'">'+settings.emptyMessage+'</span>');
                        formErr = true;
                    }
                });
                taReq.each(function(){
                    placeholder = $(this).attr('placeholder');
                    if ( $(this).val() == "" || $(this).val() == placeholder) {
                        $(this).addClass(settings.inputErrClass);
                        $(this).after('<span class="'+settings.spanErrClass+'">'+settings.emptyMessage+'</span>');
                        formErr = true;
                    }
                });
                emails.each(function(){
                    var emailval = $(this).val();
                    AtPos = emailval.indexOf("@")
                    StopPos = emailval.lastIndexOf(".")
                    if ( $(this).val() != "" && (AtPos == -1 || StopPos == -1) ) {
                        $(this).addClass(settings.inputErrClass);
                        $(this).after('<span class="'+settings.spanErrClass+'">'+settings.emailMessage+'</span>');
                        formErr = true;
                    }
                });
                urls.each(function(){
                    var urlval = $(this).val();
                    if ( urlreg.test(urlval) == false && urlval != "" ) {
                        $(this).addClass(settings.inputErrClass);
                        $(this).after('<span class="'+settings.spanErrClass+'">'+settings.urlMessage+'</span>');
                        formErr = true;
                    }
                });
                selects.each(function(){
                    if ( $(this).find('option:selected').val() == "" ) {
                        $(this).addClass(settings.inputErrClass);
                        $(this).after('<span class="'+settings.spanErrClass+'">'+settings.emptySelectMessage+'</span>');
                        formErr = true;
                    }
                });
                radios.each(function(){
                    name = $(this).attr('name');
                    if ( $('input[type="radio"][name="'+name+'"]:checked').length == "") {
                        $(this).addClass(settings.inputErrClass);
                        $('input[type="radio"][name="'+name+'"]:first').before('<span class="'+settings.spanErrClass+'">'+settings.radioMessage+'</span>');
                        formErr = true;
                    }
                });
                checkboxs.each(function(){
                    if ( $(this).is(':checked') == false ) {
                        $(this).addClass(settings.inputErrClass);
                        $(this).before('<span class="'+settings.spanErrClass+'">'+settings.radioMessage+'</span>');
                        formErr = true;
                    }
                });
                
                if (formErr != true && settings.async == true) {
                    placeholderInputs.each(function(index, elem){
                        if( $(elem).val() == $(elem).attr('placeholder')  ) { $(elem).val(''); }
                    });
                    var formData = $(esto).serialize();
                    settings.ajaxCall(esto,formData);
                }
                else if (formErr != true && settings.async == false) {
                    placeholderInputs.each(function(index, elem){
                        if( $(elem).val() == $(elem).attr('placeholder')  ) { $(elem).val(''); }
                    });
                    $(esto).submit();
                }
            }

            else {
                $(target).on('click', function(event){
                    event.preventDefault();
                    
                    $(esto).find('*').removeClass(settings.inputErrClass);
                    $(esto).find('.'+settings.spanErrClass).remove();

                    formErr = false;

                    requeridos.each(function(){
                        placeholder = $(this).attr('placeholder');
                        if ( $(this).val() == "" || $(this).val() == placeholder) {
                            $(this).addClass(settings.inputErrClass);
                            $(this).after('<span class="'+settings.spanErrClass+'">'+settings.emptyMessage+'</span>');
                            formErr = true;
                        }
                    });
                    taReq.each(function(){
                        placeholder = $(this).attr('placeholder');
                        if ( $(this).val() == "" || $(this).val() == placeholder) {
                            $(this).addClass(settings.inputErrClass);
                            $(this).after('<span class="'+settings.spanErrClass+'">'+settings.emptyMessage+'</span>');
                            formErr = true;
                        }
                    });
                    emails.each(function(){
                        var emailval = $(this).val();
                        AtPos = emailval.indexOf("@")
                        StopPos = emailval.lastIndexOf(".")
                        if ( $(this).val() != "" && (AtPos == -1 || StopPos == -1) ) {
                            $(this).addClass(settings.inputErrClass);
                            $(this).after('<span class="'+settings.spanErrClass+'">'+settings.emailMessage+'</span>');
                            formErr = true;
                        }
                    });
                    urls.each(function(){
                        var urlval = $(this).val();
                        if ( urlreg.test(urlval) == false && urlval != "" ) {
                            $(this).addClass(settings.inputErrClass);
                            $(this).after('<span class="'+settings.spanErrClass+'">'+settings.urlMessage+'</span>');
                            formErr = true;
                        }
                    });
                    selects.each(function(){
                        if ( $(this).find('option:selected').val() == "" ) {
                            $(this).addClass(settings.inputErrClass);
                            $(this).after('<span class="'+settings.spanErrClass+'">'+settings.emptySelectMessage+'</span>');
                            formErr = true;
                        }
                    });
                    radios.each(function(){
                        name = $(this).attr('name');
                        if ( $('input[type="radio"][name="'+name+'"]:checked').length == "") {
                            $(this).addClass(settings.inputErrClass);
                            $('input[type="radio"][name="'+name+'"]:first').before('<span class="'+settings.spanErrClass+'">'+settings.radioMessage+'</span>');
                            formErr = true;
                        }
                    });
                    checkboxs.each(function(){
                        if ( $(this).is(':checked') == false ) {
                            $(this).addClass(settings.inputErrClass);
                            $(this).before('<span class="'+settings.spanErrClass+'">'+settings.radioMessage+'</span>');
                            formErr = true;
                        }
                    });
                    
                    if (formErr != true && settings.async == true) {
                        placeholderInputs.each(function(index, elem){
                            if( $(elem).val() == $(elem).attr('placeholder')  ) { $(elem).val(''); }
                        });
                        var formData = $(esto).serialize();
                        settings.ajaxCall(esto,formData);
                    }
                    else if (formErr != true && settings.async == false) {
                        placeholderInputs.each(function(index, elem){
                            if( $(elem).val() == $(elem).attr('placeholder')  ) { $(elem).val(''); }
                        });
                        $(esto).submit();
                    }
                });
            }
        });
    }
    $.fn.gac = function(){
           _gaq.push(['_trackPageview', "/goal/"+ $(this).attr("data-goal")+"/"]);
    }
})($);
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