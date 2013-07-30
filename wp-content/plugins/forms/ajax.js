var classForm = {
	agregar_campo : function(){
		var i = jQuery('.count_fields').length;
		var copiaCampo = jQuery('#campo_0').clone();
		jQuery('#campo_'+(i-1)).after('<tr id="campo_'+i+'" class="count_fields form-field">'+copiaCampo[0].innerHTML.replace(/_1/g, '_'+parseInt(i+1)).replace(/_0/g, '_'+parseInt(i)).replace(/\[1/g, '['+parseInt(i+1)).replace(/\[0]/g,'['+parseInt(i)+']').replace(/1-/g, parseInt(i+1)+'-')+'</tr>');
	},
	guardar_tag : function(){
		jQuery.getJSON("../index.php",{agregar_tag:"true",id:jQuery("#idtag").val(), tag: jQuery("#tags").val() }, function(datos){
			txtorig = jQuery("#guardar_tag").next().text();
			jQuery("#guardar_tag").next().html("Etiquetas guardadas");
			classForm.time = setInterval(classForm.fadeout,2000);
		});
	},
	fadeout : function(){
			jQuery("#guardar_tag").next().fadeOut();
			clearInterval(classForm.time);
			classForm.time = setInterval(classForm.fadein,1000);
	},
	fadein : function(){
			jQuery("#guardar_tag").next().text(txtorig).fadeIn();
			clearInterval(classForm.time);
	},
	guardar_respuesta : function(){
		jQuery.getJSON("../index.php",{
				agregar_respuesta:"true",
				id:jQuery("#idtag").val(),
				respuesta: jQuery("#respuesta").val(),
				email: jQuery("#email").val(),
			}, function(datos){
				jQuery("#guardar_respuesta").after("<span>Su respuesta fue enviada exitósamente</span>")
				classForm.time = setInterval(classForm.respuestaout,2000);
			}
		);
	},
	respuestaout : function(){
			jQuery("#guardar_respuesta").next().fadeOut();
			clearInterval(classForm.time);
	},
}
jQuery(document).ready( function() {
	jQuery.each(classForm, function (i) {//detecta eventos al hacer click sobre un elemento con clase css presente en el objeto classForm
		if (jQuery.isFunction(classForm[i]) && jQuery('*').hasClass(classForm[i])){
			jQuery('.'+i).bind("click", function(e){eval("classForm."+i+"(e)");return false;});
		}
	});
});
jQuery.extend({
	id : function(id) {
		var id = id.split("#");
		return document.getElementById(id[1])?true:false;
	}
});