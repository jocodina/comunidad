<?php

//$wpdb->registro= $table_prefix.'registro';

function clearPost($array){
	foreach($array as $variable){
    		if(is_array($variable)){
        		clearPost($variable);
		}
		else{
        		$var[]= htmlentities($variable, ENT_NOQUOTES, "UTF-8");
    		}
	return $var;
	}
}
function preguntas_frecuentes_ver() {
global $wpdb,$blog_id;
	if (!$_GET[leng]) $_GET[leng]="es";

		$faqs = $wpdb->get_results("SELECT post_content FROM {$wpdb->base_prefix}{$blog_id}_posts WHERE post_type = 'faq' && post_status='faq'");
		$editar =array_to_object(__unserialize_adtext($faqs[1]->post_content));

			foreach ($editar->pregunta as $l=>$preg){
				foreach ($preg as $val){
					$preguntas[$l][]=stripslashes(utf8_encode(html_entity_decode($val)));
				};
			};

			foreach ($editar->respuesta as $l=>$resp){
				foreach ($resp as $val){
					$respuestas[$l][] = utf8_encode(html_entity_decode(stripslashes($val)));
				};
			};
			foreach ($editar->etiqueta as $l=>$tag){
				foreach ($tag as $val){
					$etiquetas[$l][]=utf8_encode(html_entity_decode(stripslashes($val)));
				};
			};
			if($_GET['tags']){
				foreach ($editar->etiqueta as $l=>$tag){
					$i=0;
					foreach ($tag as $val){
						if (eregi($_GET['tags'], $val)){
							$array_claves[$l][$i]=$i;
						}
						$i++;
					};
				};
			if(is_array($array_claves[$_GET['leng']])) $preguntas[$_GET[leng]] = array_intersect_key($preguntas[$_GET[leng]], $array_claves[$_GET[leng]]);
			if(is_array($array_claves[$_GET['leng']])) $respuestas[$_GET[leng]] = array_intersect_key($respuestas[$_GET[leng]], $array_claves[$_GET[leng]]);
			if(is_array($array_claves[$_GET['leng']])) $etiquetas[$_GET[leng]] = array_intersect_key($etiquetas[$_GET[leng]], $array_claves[$_GET[leng]]);

				sort($preguntas[$_GET[leng]]);
				sort($respuestas[$_GET[leng]]);
				sort($etiquetas[$_GET[leng]]);
			}

			$langs=get_option("qtranslate_enabled_languages");
?>

<div class="wrap">
	<h2><?php _e('FAQ') ?> </h2>
		<dl>
			<?php $c=0; if(is_array($preguntas[$_GET['leng']])) foreach ($preguntas[$_GET[leng]] as $pregunta):?>
			<dt>
				<strong><?php echo $preguntas[$_GET[leng]][$c]; ?></strong>
			</dt>
			<dd>
				<?php echo $respuestas[$_GET[leng]][$c]; ?>
				<strong>Etiquetas: </strong> <input id="tag<?php echo "_".$c; ?>" type="text" value="<?php echo $etiquetas[$_GET[leng]][$c]; ?>" name="tags"  style="border:none" onclick="jQuery('#'+this.id).css('border', '1px solid #0C91FD');" onblur="jQuery('#'+this.id).css('border', 'none');jQuery.getJSON('../index.php',{'etiquetas': this.value }, function(datos){ });" />
			</dd>
			<?php $c++; endforeach;?>
		</dl>
</div>
<?php
}

function actualizar_contactos(){
global $wpdb,$blog_id;
		$contact = $wpdb->get_results("SELECT * FROM wp_1_contact WHERE blog_id = $blog_id");
		foreach($contact as $countContact){
			if ($countContact->status=="0") $numeros_contactos["nuevos"][] = $countContact->status;
			if ($countContact->status=="1") $numeros_contactos["leidos"][] = $countContact->status;
			if ($countContact->status=="2") $numeros_contactos["contestados"][] = $countContact->status;
			$numeros_contactos["total"][] = $countContact->status;
		}
		$numero_contactos["leidos"]= count($numeros_contactos["leidos"]);
		$numero_contactos["contestados"]= count($numeros_contactos["contestados"]);
		$numero_contactos["nuevos"]= count($numeros_contactos["nuevos"]);
		$numero_contactos["total"]= count($numeros_contactos["total"]);
		$numero_contactos=json_encode($numero_contactos);
		$wpdb->query("UPDATE wp_blogs SET comentarios = '$numero_contactos' WHERE blog_id = $blog_id");
}
//contacto
function db_insert_array($vars, $tabla){
	foreach($vars as $nombre_campo => $valor){
		$name_vars .= $nombre_campo .", ";
		$value_vars .= "'".$valor . "', ";
	}
	$name_vars=trim($name_vars, ", ");
	$value_vars=trim($value_vars, ", ");
	$sql_insert = "INSERT INTO $tabla ($name_vars) values ($value_vars)";
	$result = mysql_query($sql_insert);
}
//end contacto

function formulario_eliminar(){
	delete_option($_GET['borrar']);
}

//estado email
function estado_email($status){
	if($status==0) $status = "No le&iacute;do";
	if($status==1) $status = "Le&iacute;do";
	if($status==2) $status = "Contestado";
	return $status;
}

function formulario_contacto($option){
global $wpdb,$blog_id;
	add_action('wp_head', 'add_css');
	$i = 0;
	$formularios = get_blog_option(1,"formu_plugin_".$option."_".detectar_idioma());
	if(empty($formularios) || $formularios=="") $formularios = get_blog_option(1,"formu_plugin_".$option."_es");
	$names = get_blog_option(1,"formu_plugin_".$option."_meta");
	$form  = new form();
	$form->tipos = array_combine($names, $formularios['tipo']);

	if ($_POST):
		$form->requeridos = array_combine( $names ,$formularios['requeridos']);
		$form->mensajes=array(
			"error" => array_combine( $names, $formularios['mens_error']),
			"defecto" => array_combine  ( $names, $formularios['mens_prev'])
		);
		$verificar = $form->verificar();
	endif;
	//imprime el mensaje de error
	if ($_POST && is_array($form->track_error)):
		echo '<div class="mens error"><p>'.$formularios['alertas'].'</p></div>';
	endif;

	if ($_POST && !is_array($form->track_error)):
		echo '<div class="mens ok"><p>'.$formularios['mens_ok'].'</p></div>';

		//contacto
		if (in_array("contactar", $names)){
			unset($_POST['contactar']);
			$_POST['blog_id'] = $blog_id;
			$_POST['tag'] = "";
			$_POST['status'] = "0";
			//db_insert_array($_POST, 'wp_1_contact');
			$wpdb->insert('wp_1_contact', $_POST );
			actualizar_contactos();
		}
		//end contacto

		if($formularios['email_admin']){
			$form->mailto['de']=$formularios['email_admin'];
			$form->mailto['para']=$_POST['email'];
			$form->mailto['asunto']=htmlentities(utf8_decode("Gracias por contactarnos"));
			$form->mailto['mensaje'] .= "<html><head><title>Minrel</title>";
			$form->mailto['mensaje'] .= $formularios["email_style"];
			$form->mailto['mensaje'] .= "</head><body>";
			$form->mailto['mensaje'] .= htmlentities(utf8_decode($formularios["email_mensaje"]));
			$form->mailto['mensaje'] .= "</body></html>";
			$form->sendmail();

			$form->mailto['de']=$_POST['email'];
			$form->mailto['para']=$formularios['email_admin'];
			$form->mailto['bcc']=$formularios['email_copias'];
			$form->mailto['asunto']="Contacto Web";
			$form->mailto['mensaje'] .= "<html><head><title>Minrel</title>";
			$form->mailto['mensaje'] .= $formularios["email_style"];
			$form->mailto['mensaje'] .= "</head><body>";
			$form->mailto['mensaje']="<p>Administrador: <br> ".$_POST['nombre']." se ha contactado con Minrel</p>";
			foreach($formularios as $k_send=>$v_send){
				if($k_send=="name"){
					$n = 0; foreach($v_send as $name_send){
						if($name_send!="contactar"){ 
							$send_email .= "<li>".$formularios["label"][$n].": ".$_POST[$name_send]."</li>";
						}
					$n++; }
				}
			}
			$form->mailto['mensaje'] .= "<ul>".$send_email."</ul>";
			$form->mailto['mensaje'] .= "</head><body>";
			$form->sendmail();
		}
	endif;

	if (($_POST && is_array($form->track_error)) || !$_POST):
		foreach($form->tipos as $key=>$val){
			$valor = $formularios['value'][$i];
			$tab = $formularios['tabindex'][$i];
			$label = $formularios['label'][$i];
			$forid = $formularios['forid'][$i];
			$clase = $formularios['clase'][$i];
			$fieldset = $formularios['fieldset'][$i];
			$mens_prev = $formularios['mens_prev'][$i];
			if($val=="text"){
				$f = '<label for="'.$forid.'">'.$label.': </label>';
				$f .= $form->text("name=$key&id=$forid&value=$valor&tab=$tab&clase=$clase");
				$f .= $verificar[$key]?"<samp class='alert'>".$verificar[$key]."</samp>" : "<samp>".$mens_prev."</samp>";
			}
			if($val=="textarea"){
				$f = '<label for="'.$forid.'">'.$label.': </label>';
				$f .= $form->textarea("name=$key&id=$forid&tab=$tab&value=".$valor."&clase=$clase&cols=40&rows=10");
			}
			if($val=="select"){
				$f = '<label for="'.$forid.'">'.$label.': </label>';
				$valor = eregi_replace(', ', ',', $valor);
				$valor = split(',', $valor);
				$f .= $form->select("name=$key&id=$key&value=fixvalue&clase=$clase&tab=$tab", $valor);
				$f .= $verificar[$key] ?" <samp class='alert'>".$verificar[$key]."</samp>" : "<samp>".$mens_prev."</samp>";
			}
			if($val=="checkbox"){
				$f = '<label for="'.$forid.'">';
				$f .= $form->checkbox("name=$key&id=$key&tab=9&clase=$clase&value=$valor&selected=octubre&disabled=disabled");
				$f .= $label.'</label>';
			}
			if($val=="radiobutton"){
				$f = '<label for="'.$forid.'">';
				$f .= $form->radio("name=$key&id=$key&tab=9&clase=$clase&value=$valor&selected=octubre&disabled=disabled");
				$f .= $label.'</label>';
			}
			if($val=="hidden"){
				$f = $form->hidden($key, $valor);
			}
			if($val=="submit"){
				$f = '<fieldset class="botones"><input type="submit" name="'.$key.'" id="'.$key.'" value="'.$valor.'" class="'.$clase.'" /></fieldset>';
			}
			$f2 .= $f;
			if(!$group){
				$group =  $fieldset;
			}
			if($fieldset!=$group){
				$fprint .= wrap("fieldset",wrap("h3",$group).$field);
				$f2 = $f;
			}
			if($fieldset==$group){
				$fieldx = $f2;
			}
			$group = $fieldset;
			$field = $f2;
			$i++;
		}
		$fprint .= wrap("fieldset",wrap("h3",$fieldset).$field);
		$fprint = "<div class=\"form\"><form action='$formularios[action]' id='$formularios[nombre]' method='$formularios[method]'>".$fprint."</form></div>";

		//esto tiene que ser dinamico
		if(eregi ('/contacto/', $_SERVER['REQUEST_URI'])){
			echo $fprint;
		}
	endif;
}

function get_formulario_contacto($option){
global $wpdb,$blog_id;
	add_action('wp_head', 'add_css');
	$i = 0;
	$formularios = get_blog_option(1,"formu_plugin_".$option."_".detectar_idioma());
	$names = get_blog_option(1,"formu_plugin_".$option."_meta");
	$form  = new form();
	$form->tipos = array_combine($names, $formularios['tipo']);

	if ($_POST):
		$form->requeridos = array_combine( $names ,$formularios['requeridos']);
		$form->mensajes=array(
			"error" => array_combine( $names, $formularios['mens_error']),
			"defecto" => array_combine  ( $names, $formularios['mens_prev'])
		);
		$verificar = $form->verificar();
	endif;
	//imprime el mensaje de error
	if ($_POST && is_array($form->track_error)):
		return '<div class="mens error"><p>'.$formularios['alertas'].'</p></div>';
	endif;

	if ($_POST && !is_array($form->track_error)):
		return '<div class="mens ok"><p>'.$formularios['mens_ok'].'</p></div>';

		//contacto
		if (in_array("contactar", $names)){
			unset($_POST['contactar']);
			$_POST['blog_id'] = $blog_id;
			$_POST['tag'] = "";
			$_POST['status'] = "0";
			//db_insert_array($_POST, 'wp_1_contact');
			$wpdb->insert('wp_1_contact', $_POST );
			actualizar_contactos();
		}
		//end contacto

		if($formularios['email_admin']){
			$form->mailto['de']=$formularios['email_admin'];
			$form->mailto['para']=$_POST['email'];
			$form->mailto['asunto']=htmlentities(utf8_decode("Gracias por contactarnos"));
			$form->mailto['mensaje'] .= "<html><head><title>Minrel</title>";
			$form->mailto['mensaje'] .= $formularios["email_style"];
			$form->mailto['mensaje'] .= "</head><body>";
			$form->mailto['mensaje'] .= htmlentities(utf8_decode($formularios["email_mensaje"]));
			$form->mailto['mensaje'] .= "</body></html>";
			$form->sendmail();

			$form->mailto['de']=$_POST['email'];
			$form->mailto['para']=$formularios['email_admin'];
			$form->mailto['bcc']=$formularios['email_copias'];
			$form->mailto['asunto']="Contacto Web";
			$form->mailto['mensaje'] .= "<html><head><title>Minrel</title>";
			$form->mailto['mensaje'] .= $formularios["email_style"];
			$form->mailto['mensaje'] .= "</head><body>";
			$form->mailto['mensaje']="<p>Administrador: <br> ".$_POST['nombre']." se ha contactado con Minrel<br>
						  Nombre: ".htmlentities(utf8_decode($_POST['nombre']))."<br>
						  Email: ".$_POST['email']."<br>
						  Mensaje: ".htmlentities(utf8_decode($_POST['mensaje']))."<br></p>";
			$form->mailto['mensaje'] .= "</head><body>";
			$form->sendmail();
		}
	endif;


	if (($_POST && is_array($form->track_error)) || !$_POST):
		foreach($form->tipos as $key=>$val){
			$valor = $formularios['value'][$i];
			$tab = $formularios['tabindex'][$i];
			$label = $formularios['label'][$i];
			$forid = $formularios['forid'][$i];
			$clase = $formularios['clase'][$i];
			$fieldset = $formularios['fieldset'][$i];
			$mens_prev = $formularios['mens_prev'][$i];
			if($val=="text"){
				$f = '<label for="'.$forid.'">'.$label.': </label>';
				$f .= $form->text("name=$key&id=$forid&value=$valor&tab=$tab&clase=$clase");
				$f .= $verificar[$key]?"<samp class='alert'>".$verificar[$key]."</samp>" : "<samp>".$mens_prev."</samp>";
			}
			if($val=="textarea"){
				$f = '<label for="'.$forid.'">'.$label.': </label>';
				$f .= $form->textarea("name=$key&id=$forid&tab=$tab&value=".$valor."&clase=$clase&cols=40&rows=10");
			}
			if($val=="select"){
				$f = '<label for="'.$forid.'">'.$label.': </label>';
				$valor = eregi_replace(', ', ',', $valor);
				$valor = split(',', $valor);
				$f .= $form->select("name=$key&id=$key&value=fixvalue&clase=$clase&tab=$tab", $valor);
				$f .= $verificar[$key] ?" <samp class='alert'>".$verificar[$key]."</samp>" : "<samp>".$mens_prev."</samp>";
			}
			if($val=="checkbox"){
				$f = '<label for="'.$forid.'">';
				$f .= $form->checkbox("name=$key&id=$key&tab=9&clase=$clase&value=$valor&selected=octubre&disabled=disabled");
				$f .= $label.'</label>';
			}
			if($val=="radiobutton"){
				$f = '<label for="'.$forid.'">';
				$f .= $form->radio("name=$key&id=$key&tab=9&clase=$clase&value=$valor&selected=octubre&disabled=disabled");
				$f .= $label.'</label>';
			}
			if($val=="hidden"){
				$f = $form->hidden($key, $valor);
			}
			if($val=="submit"){
				$f = '<fieldset class="botones"><input type="submit" name="'.$key.'" id="'.$key.'" value="'.$valor.'" class="'.$clase.'" /></fieldset>';
			}
			$f2 .= $f;
			if(!$group){
				$group =  $fieldset;
			}
			if($fieldset!=$group){
				$fprint .= wrap("fieldset",wrap("h3",$group).$field);
				$f2 = $f;
			}
			if($fieldset==$group){
				$fieldx = $f2;
			}
			$group = $fieldset;
			$field = $f2;
			$i++;
		}
		$fprint .= wrap("fieldset",wrap("h3",$fieldset).$field);
		$fprint = "<div class=\"form\"><form action='$formularios[action]' id='$formularios[nombre]' method='$formularios[method]'>".$fprint."</form></div>";

		//esto tiene que ser dinamico
		if(eregi ('/contacto/', $_SERVER['REQUEST_URI'])){
			return $fprint;
		}
	endif;
}

function wrap($tag,$text){
	return "<$tag>$text</$tag>";
}
?>