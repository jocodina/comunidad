function idajs() {
    this.init = function(){ $('.evt').evt(); };
    this.init();
}
idajs.prototype = {};

var js;
// DOM Ready
$(function(){
    js = new idajs();
    $('form').validame();
    

});

// plugins
(function($) {
    $.fn.evt = function(){
        $.each(this,function(i,item) {
            if ( $.isFunction( js[$(item).attr("data-func")] )){
                var event = $(item).attr("data-event")==undefined?"click":$(this).attr("data-event");
                $(item).off(event);
                $(item).on(event, $.proxy(js[$(item).attr("data-func")], js) );
            }
        });
    };
})($);


//////////////////////////////////////////////////////////////////////////////// Validame


(function($){
    $.validame = function(el, options){
        // @TODO preparar validador para formularios de varios pasos
        var validator = this;
        validator.$el = $(el);
        validator.el = el;
        
        validator.settings = {};

        validator.$el.data("validame", validator);
        
        // seteo el boton de submit
        validator.$tarjetBtn = validator.$el.find('input[type="submit"]');
        
        validator.youAreNotValid = function(inputObj){
            $(inputObj).addClass('invalidInput');
            $(inputObj).after('<span class="errMess">Debe llenar esto</span>');
        };
        validator.youAreNotValidGroup = function(inputSample){
            $(inputSample).parents('ul').after('<span class="errMess">Debe llenar esto</span>');
        };
        
        validator.validateTextInput = function(inputObj){
            if( $(inputObj).val() && $(inputObj).val() != $(inputObj).attr('placeholder') ){ return true; }
            else {
                validator.youAreNotValid(inputObj);
                return false;
            }
        };
        validator.validateEmailInput = function(inputObj){
            var emailval = $(inputObj).val();
            var AtPos = emailval.indexOf("@");
            var StopPos = emailval.lastIndexOf(".");
            if( $(inputObj).val() == "" || (AtPos == -1 || StopPos == -1)){
                validator.youAreNotValid(inputObj);
                return false;
            } else {
                return true;
            }
        };
        validator.validateUrlInput = function(inputObj){
            var urlreg = /^http\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?$/;
            var urlval = $(inputObj).val();
            if ( urlreg.test(urlval) == false || urlval == "" ) {
                validator.youAreNotValid(inputObj);
                return false;
            }
            else {
                return true;
            }
        };
        validator.validateSelect = function(inputObj){
            if( $(inputObj).val() ) { return true }
            else { 
                validator.youAreNotValid(inputObj);
                return false;
            }
        };
        validator.validateCheckBoxInputs = function(inputSet){
            var valid = true;
           $(inputSet).each(function(index, value){
               var withTheSameName = $('input[type="'+ value.type +'"][name="'+ value.name +'"]');
               if( $(withTheSameName).is(':checked') == false ){
                   validator.youAreNotValidGroup( $(value.element) );
                   valid = false;
                   $(withTheSameName).attr('required', 'required');
               }
               else { $(withTheSameName).removeAttr('required'); }
               // @TODO retirar el atributo required de los inputs
           });
           return valid;
        };
        validator.getGroupArray = function(supergroup){
            var output = new Array();
            $.each( supergroup, function(index, elemIhope){
                if( $(elemIhope).attr('name') != $(supergroup[ index -1 ]).attr('name') ) { 
                    output.push({ 
                        element : $(elemIhope),
                        type : $(elemIhope).attr('type'),
                        name : $(elemIhope).attr('name')  
                    });
                }
            });
            return output;
        };
        
        validator.validateForm = function(){
            // @TODO Validacion html5 nativa
            var textInputs = validator.$el.find('input[type="text"][required]');
            var emailInputs = validator.$el.find('input[type="email"][required]');
            var urlInputs = validator.$el.find('input[type="url"][required]');
            var textareas = validator.$el.find('textarea[required]');
            var selects = validator.$el.find('select[required]');
            var checkboxes = validator.getGroupArray( validator.$el.find('input[type="checkbox"][required]') );
            var radios = validator.getGroupArray( validator.$el.find('input[type="radio"][required]') );
            
            var valid = true;
            
            $('.invalidInput').removeClass('invalidInput');
            $('.errMess').remove();
            
            $.each( textInputs, function(index, elem){ if( validator.validateTextInput(elem) == false ) { valid = false; } });
            $.each( emailInputs, function(index, elem){ if( validator.validateEmailInput(elem) == false ) { valid = false; } });
            $.each( urlInputs, function(index, elem){ if( validator.validateUrlInput(elem) == false ) { valid = false; } });
            $.each( textareas, function(index, elem){ if( validator.validateTextInput(elem) == false ) { valid = false; } });
            $.each( selects, function(index, elem){ if( validator.validateSelect(elem) == false ) { valid = false; } });
            if( validator.validateCheckBoxInputs(checkboxes) == false ) { valid = false; }
            if( validator.validateCheckBoxInputs(radios) == false ) { valid = false; }
            
            return valid;
        }
        
        validator.init = function(){
            // @TODO implementar options para incrementar la personalizacion del plugin
            // @TODO dejar opcion al usuario si quiere validar en change o click o si no quiere validad at all
            validator.$tarjetBtn.on( 'click', function(e){
                e.preventDefault();
                if( validator.validateForm() ) { }
            } );
            
        };
        validator.init();
    };
    
    //////// se inicializa
    $.fn.validame = function(options){ return this.each(function(){ (new $.validame(this, options)); }); };
})(jQuery);