<?php

require_once "class.php";
require_once "funciones.php";
//require_once "contacto_faq.php";

//------------------------------------------------------------------------ Ver lista
function formulario_lista(){
	global $wpdb,$blog_id;
	$formus = $wpdb->get_results("SELECT * FROM {$wpdb->base_prefix}{$blog_id}_options WHERE option_name LIKE '%formu_plugin_%'");
?>
	<div class="wrap">
		<ul class="subsubsub" style="font-size:1.05em;">
			<li><a href="options-general.php?page=class-form.php"><strong>Lista</strong></a> |</li>
			<li><a href="options-general.php?page=class-form.php&amp;nuevo-formulario=true">Crear Nuevo</a></li>
		</ul>
		<h2>Formularios</h2>
		<table class="form-table">
			<thead>
				<tr>
					<td style="width:80%">Nombre</td>
					<td style="width:10%">Editar</td>
					<td style="width:10%">Borrar</td>
				</tr>
			</thead>
			<tbody>
			<?php
				$lista=array();
				foreach ($formus as $eachForm):
					$nombre = split("_", $eachForm->option_name);
					if (!in_array($nombre[2], $lista)):
			?>
						<tr>
							<td><?php echo $nombre[2] ?></td>
							<td><a href="options-general.php?page=class-form.php&amp;editar-formulario=<?php echo $eachForm->option_name?>&amp;idioma=<?php echo $nombre[3]?>&amp;nombre=<?php echo $nombre[2]?>">Editar</a></td>
							<td><a href="options-general.php?page=forms/class-form.php&amp;borrar=<?php echo $eachForm->option_name?>">Borrar</a></td>
						</tr>
			<?php
					$lista[]=$nombre[2];
					endif;
				endforeach;
			?>
			</tbody>
		</table>
	</div>
<?php
}

//------------------------------------------------------------------------ Editar
function formulario_editar(){
	if (!$_GET['idioma']) $_GET['idioma']="es";
	if ($_POST){
		unset($_POST["save-forms"]);
		$nombre_form="formu_plugin_".$_POST["nombre"]."_".$_GET['idioma'];
		update_option($nombre_form, $_POST);
		$nombre_meta="formu_plugin_".$_POST["nombre"]."_meta";
		update_option($nombre_meta, $_POST[name]);
	}
	if (is_array(get_option($_GET["editar-formulario"]))){
		foreach (get_option($_GET["editar-formulario"]) as  $clave => $valor){ $editar->{$clave} = $valor; }
	}
	$campos = get_option($nombre_form="formu_plugin_".$_GET[nombre]."_meta");
?>
<div class="wrap">
	<ul class="subsubsub" style="font-size:1.05em;">
		<li><a href="options-general.php?page=class-form.php">Lista</a> |</li>
		<li><a href="options-general.php?page=class-form.php&amp;nuevo-formulario=true"><strong>Crear Nuevo</strong></a></li>
	</ul>
	<h2>Editar Formulario</h2>
	<ul class="subsubsub">
<?php
	if (!$_GET['idioma']) $_GET['idioma']="es";

	if (!$_GET['nombre']):
		$nombre = $editar->nombre;
	else:
		$nombre = $_GET['nombre'];
	endif;
	$idioma_saved = get_option("qtranslate_enabled_languages");
	if (is_array($idioma_saved)){
		$i==0; foreach($idioma_saved as $links){
			$style=$_GET['idioma']==$links?'style="color:#D54E21"':'';
			$sep = count($idioma_saved)!=$i?' | ':'';
			echo '<li><a '.$style.' href="options-general.php?page=class-form.php&amp;editar-formulario=true&editar=formu_plugin_'.$nombre.'_'.$links.'&idioma='.$links.'&nombre='.$nombre.'" class="idioma-'.$links.'" >'.filtro_label_idiomas($links).'</a>'.$sep.'</li>';
			$i++;
		}
	}
?>
	</ul>
	<form method="post" action="">
		<table class="form-table">
			<tbody>
				<tr>
					<th>Nombre del Formulario</th>
					<td>
						<?php echo $nombre; ?>
						<input type="hidden" name="nombre" value="<?php echo $nombre ?>"/>
					</td>
				</tr>
				<tr>
					<th>M&eacute;todo</th>
					<td><input type="text" name="method" value="<?php echo $editar->method; ?>"/></td>
				</tr>
				<tr>
					<th>Action</th>
					<td><input type="text" name="action"  value="<?php echo $editar->action; ?>" /></td>
				</tr>
				<tr>
					<th>Alerta error</th>
					<td><textarea name="alertas" cols ="50" rows="3"><?php echo $editar->alertas; ?></textarea></td>
				</tr>
				<tr>
					<th>Agradecimientos</th>
					<td><textarea name="mens_ok" cols ="50" rows="3"><?php echo $editar->mens_ok; ?></textarea></td>
				</tr>
			</tbody>
		</table>
		<h3><?php _e('Mail') ?> </h3>
		<table class="form-table">
			<tbody>
				<tr>
					<th>Email Adminsitrador</th>
					<td><input type="text" name="email_admin" value="<?php echo $editar->email_admin; ?>" /></td>
				</tr>
				<tr>
					<th>Copias email </th>
					<td><textarea name="email_copias" cols ="50" rows="2" ><?php echo $editar->email_copias; ?></textarea></td>
				</tr>
				<tr>
					<th>Mensaje email </th>
					<td><textarea name="email_mensaje" cols ="50" rows="5"><?php echo stripslashes($editar->email_mensaje); ?></textarea></td>
				</tr>
				<tr>
					<th>Email css</th>
					<td><textarea name="email_style" cols ="50" rows="5"><?php echo stripslashes($editar->email_style); ?></textarea></td>
				</tr>
			</tbody>
		</table>
		<h3 style="margin-bottom: 0;">Definir campos del formulario (<small><a href="#" class="agregar_campo">Agregar otro campo</a></small>)</h3>
		<table class="form-table">
			<thead>
				<tr>
					<td>Nombre</td>
					<td>Valor</td>
					<td>Tipo</td>
					<td>Tab</td>
					<td>Validaci&oacute;n</td>
					<td>Prev. error</td>
					<td>Mens. error</td>
					<td>Label</td>
					<td>for / id</td>
					<td>fieldset</td>
					<td>Clase</td>
				</tr>
			</thead>
			<tbody id="tbody">
			<?php
				$c = 0;
				if(!is_array($campos)){ $campos = array(""); }
				foreach ($campos as $vuelta):
			?>
				<tr id="campo_<?php echo $c ?>" class="count_fields">
					<td><input type="text" name="name[<?php echo $c ?>]" size="6" value="<?php echo $vuelta; ?>" /></td>
					<td><input type="text" name="value[<?php echo $c ?>]" size="7"  value="<?php echo $editar->value[$c]; ?>" /></td>
					<td><select name="tipo[<?php echo $c ?>]" ><option <?php echo $editar->tipo[$c]=="text"? 'selected="true"':''?> >text</option><option <?php echo $editar->tipo[$c]== "textarea"? 'selected="true"':''?> >textarea</option><option <?php echo $editar->tipo[$c]== "select"? 'selected="true"':''?> >select</option><option <?php echo $editar->tipo[$c]== "checkbox"? 'selected="true"':''?>>checkbox</option><option <?php echo $editar->tipo[$c]== "radiobutton"? 'selected="true"':''?>>radiobutton</option><option <?php echo $editar->tipo[$c]=="hidden"? 'selected="true"':''?>>hidden</option><option <?php echo $editar->tipo[$c]=="submit"? 'selected="true"':''?> >submit</option></select></td>
					<td><input type="text" name="tabindex[<?php echo $c ?>]" size="1"  value="<?php echo $editar->tabindex[$c]; ?>"  /></td>
					<td><select name="requeridos[<?php echo $c ?>]" ><option <?php echo $editar->requeridos[$c]=="ninguna"? 'selected="true"':''?>>ninguna</option><option <?php echo $editar->requeridos[$c]=="presencia"? 'selected="true"':''?>>presencia</option><option <?php echo $editar->requeridos[$c]=="telefono"? 'selected="true"':''?>>telefono</option><option <?php echo $editar->requeridos[$c]=="rut"? 'selected="true"':''?>>rut</option><option <?php echo $editar->requeridos[$c]=="numero"? 'selected="true"':''?>>numero</option><option <?php echo $editar->requeridos[$c]=="email"? 'selected="true"':''?>>email</option><option <?php echo $editar->requeridos[$c]=="clave"? 'selected="true"':''?>>clave</option></select></td>
					<td><input type="text" name="mens_prev[<?php echo $c ?>]"  size="14"  value="<?php echo $editar->mens_prev[$c]; ?>" /></td>
					<td><input type="text" name="mens_error[<?php echo $c ?>]" size="14"  value="<?php echo $editar->mens_error[$c]; ?>"  /></td>
					<td><input type="text" name="label[<?php echo $c ?>]" size="8"  value="<?php echo $editar->label[$c]; ?>"  /></td>
					<td><input type="text" name="forid[<?php echo $c ?>]" size="5"  value="<?php echo $editar->forid[$c]; ?>"  /></td>
					<td><input type="text" name="fieldset[<?php echo $c ?>]" size="5"  value="<?php echo $editar->fieldset[$c]; ?>"  /></td>
					<td><input type="text" name="clase[<?php echo $c ?>]" size="3"  value="<?php echo $editar->clase[$c]; ?>"  /></td>
				</tr>
			<?php $c++; endforeach; ?>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" name="save-forms" id="save-forms" value="Guardar" />
		</p>
	</form>
</div>
<?php
}

//------------------------------------------------------------------------ Nuevo formulario
function formulario_nuevo(){
?>
<div class="wrap">
	<ul class="subsubsub" style="font-size:1.05em;">
		<li><a href="options-general.php?page=class-form.php">Lista</a> |</li>
		<li><a href="options-general.php?page=class-form.php&amp;nuevo-formulario=true"><strong>Crear Nuevo</strong></a></li>
	</ul>
	<h2>Nuevo Formulario</h2>
	<ul class="subsubsub">
	<?php
		if (!$_GET['idioma']) $_GET['idioma']="es";
		if ($_POST){
			unset($_POST["save-forms"]);
			$nombre_form = "formu_plugin_".$_POST["nombre"]."_".$_GET["idioma"];
			update_option($nombre_form, $_POST);
			$nombre_meta="formu_plugin_".$_POST["nombre"]."_meta";
			update_option($nombre_meta, $_POST[name]);

			if (is_array(get_option($_GET["editar-formulario"]))){
				foreach (get_option($_GET["editar-formulario"]) as  $clave => $valor){ $editar->{$clave} = $valor; }
			}
			$campos = get_option($nombre_form="formu_plugin_".$_GET[nombre]."_meta");
		}
		$idioma_saved = get_option("qtranslate_enabled_languages");
		$i = 1; foreach($idioma_saved as $links){
			$style = $_GET['idioma'] == $links ?'style="color:#D54E21"':'';
			$sep = count($idioma_saved)!=$i?' | ':'';
			echo '<li><a '.$style.' href="options-general.php?page=class-form.php&amp;nuevo-formulario=true&idioma='.$links.'" class="idioma-'.$links.'" >'.filtro_label_idiomas($links).'</a>'.$sep.'</li>';
			$i++;
		}
	?>
	</ul>
	<form method="post" action="">
		<table class="form-table">
			<tbody>
				<tr>
					<th>Nombre del Formulario<br /></th>
					<td><input type="text" name="nombre" value="<?php echo $_POST["nombre"]?>" /></td>
				</tr>
				<tr>
					<th>M&eacute;todo</th>
					<td><input type="text" name="method"  value="<?php echo $_POST["method"]?>" /></td>
				</tr>
				<tr>
					<th>Action</th>
					<td><input type="text" name="action" value="<?php echo $_POST["action"]?>" /></td>
				</tr>
				<tr>
					<th>Alerta error</th>
					<td><textarea name="alertas" cols ="50" rows="3"><?php echo $_POST["alertas"]?></textarea></td>
				</tr>
				<tr>
					<th>Agradecimientos</th>
					<td><textarea name="mens_ok" cols ="50" rows="3"><?php echo $_POST["mens_ok"]?></textarea></td>
				</tr>
			</tbody>
		</table>
		<h3><?php _e('Mail') ?> </h3>
		<table class="form-table">
			<tbody>
				<tr>
					<th>Email Adminsitrador</th>
					<td><input type="text" name="email_admin" value="<?php echo $_POST["email_admin"]?>" /></td>
				</tr>
				<tr>
					<th>Copias email </th>
					<td><textarea name="email_copias" cols ="50" rows="2"><?php echo $_POST["email_copias"]?></textarea></td>
				</tr>
				<tr>
					<th>Mensaje email </th>
					<td><textarea name="email_mensaje" cols ="50" rows="5"><?php echo $_POST["email_mensaje"]?></textarea></td>
				</tr>
				<tr>
					<th>Email css</th>
					<td><textarea name="email_style" cols ="50" rows="5"><?php echo $_POST["email_style"]?></textarea></td>
				</tr>
			</tbody>
		</table>
		<h3 style="margin-bottom: 0;">Definir campos del formulario (<small><a href="#" class="agregar_campo">Agregar otro campo</a></small>)</h3>
		<table class="form-table">
			<thead>
				<tr>
					<td>Nombre</td>
					<td>Valor</td>
					<td>Tipo</td>
					<td>Tab</td>
					<td>Validaci&oacute;n</td>
					<td>Prev. error</td>
					<td>Mens. error</td>
					<td>Label</td>
					<td>for / id</td>
					<td>fieldset</td>
					<td>Clase</td>
				</tr>
			</thead>
			<tbody id="tbody">
<?php
	if($_POST["save-forms"]){
			$c = 0;
			if(!is_array($campos)){ $campos = array(""); }
			foreach ($campos as $vuelta):
?>
				<tr id="campo_<?php echo $c ?>" class="count_fields">
					<td><input type="text" name="name[<?php echo $c ?>]" size="6" value="<?php echo $vuelta; ?>" /></td>
					<td><input type="text" name="value[<?php echo $c ?>]" size="7"  value="<?php echo $editar->value[$c]; ?>" /></td>
					<td><select name="tipo[<?php echo $c ?>]" ><option <?php echo $editar->tipo[$c]=="text"? 'selected="true"':''?> >text</option><option <?php echo $editar->tipo[$c]== "textarea"? 'selected="true"':''?> >textarea</option><option <?php echo $editar->tipo[$c]== "select"? 'selected="true"':''?> >select</option><option <?php echo $editar->tipo[$c]== "checkbox"? 'selected="true"':''?>>checkbox</option><option <?php echo $editar->tipo[$c]== "radiobutton"? 'selected="true"':''?>>radiobutton</option><option <?php echo $editar->tipo[$c]=="hidden"? 'selected="true"':''?>>hidden</option><option <?php echo $editar->tipo[$c]=="submit"? 'selected="true"':''?> >submit</option></select></td>
					<td><input type="text" name="tabindex[<?php echo $c ?>]" size="1"  value="<?php echo $editar->tabindex[$c]; ?>"  /></td>
					<td><select name="requeridos[<?php echo $c ?>]" ><option <?php echo $editar->requeridos[$c]=="ninguna"? 'selected="true"':''?>>ninguna</option><option <?php echo $editar->requeridos[$c]=="presencia"? 'selected="true"':''?>>presencia</option><option <?php echo $editar->requeridos[$c]=="telefono"? 'selected="true"':''?>>telefono</option><option <?php echo $editar->requeridos[$c]=="rut"? 'selected="true"':''?>>rut</option><option <?php echo $editar->requeridos[$c]=="numero"? 'selected="true"':''?>>numero</option><option <?php echo $editar->requeridos[$c]=="email"? 'selected="true"':''?>>email</option><option <?php echo $editar->requeridos[$c]=="clave"? 'selected="true"':''?>>clave</option></select></td>
					<td><input type="text" name="mens_prev[<?php echo $c ?>]"  size="14"  value="<?php echo $editar->mens_prev[$c]; ?>" /></td>
					<td><input type="text" name="mens_error[<?php echo $c ?>]" size="14"  value="<?php echo $editar->mens_error[$c]; ?>"  /></td>
					<td><input type="text" name="label[<?php echo $c ?>]" size="8"  value="<?php echo $editar->label[$c]; ?>"  /></td>
					<td><input type="text" name="forid[<?php echo $c ?>]" size="5"  value="<?php echo $editar->forid[$c]; ?>"  /></td>
					<td><input type="text" name="fieldset[<?php echo $c ?>]" size="5"  value="<?php echo $editar->fieldset[$c]; ?>"  /></td>
					<td><input type="text" name="clase[<?php echo $c ?>]" size="3"  value="<?php echo $editar->clase[$c]; ?>"  /></td>
				</tr>
<?php 
			$c++; endforeach;
	}
	else{
?>
				<tr id="campo_0" class="count_fields">
					<td><input type="text" name="name[0]" size="6" value="<?php echo $_POST["name"][0]?>" /></td>
					<td><input type="text" name="value[0]" size="7" value="<?php echo $_POST["value"][0]?>" /></td>
					<td>
						<select name="tipo[0]" >
							<option>text</option>
							<option>textarea</option>
							<option>select</option>
							<option>checkbox</option>
							<option>radiobutton</option>
							<option>hidden</option>
							<option>submit</option>
						</select>
					</td>
					<td><input type="text" name="tabindex[0]" size="1" value="<?php echo $_POST["tabindex"][0]?>" /></td>
					<td>
						<select name="requeridos[0]" >
							<option>ninguna</option>
							<option>presencia</option>
							<option>telefono</option>
							<option>rut</option>
							<option>numero</option>
							<option>email</option>
							<option>clave</option>
						</select>
					</td>
					<td><input type="text" name="mens_prev[0]"  size="14" value="<?php echo $_POST["mens_prev"][0]?>" /></td>
					<td><input type="text" name="mens_error[0]" size="14" value="<?php echo $_POST["mens_error"][0]?>" /></td>
					<td><input type="text" name="label[0]" size="8" value="<?php echo $_POST["label"][0]?>" /></td>
					<td><input type="text" name="forid[0]" size="5" value="<?php echo $_POST["forid"][0]?>" /></td>
					<td><input type="text" name="fieldset[0]" size="5" value="<?php echo $_POST["fieldset"][0]?>" /></td>
					<td><input type="text" name="clase[0]" size="3" value="<?php echo $_POST["clase"][0]?>" /></td>
				</tr>
<?php 
	}
?>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" name="save-forms" id="save-forms" value="Guardar" />
		</p>
	</form>
</div>
<?php
}


function admin_formu(){
	if (!$_GET['editar-formulario'] && !$_GET['nuevo-formulario'] ){
		add_options_page('Formularios', 'Formularios', 8, basename(__FILE__), 'formulario_lista');
	}
	if ($_GET['page']=='class-form.php' && $_GET['borrar']){
		formulario_eliminar();
	}
	if ($_GET['nuevo-formulario']){
		add_options_page('Formularios', 'Formularios', 8, basename(__FILE__), 'formulario_nuevo');
	}
	if ($_GET['editar-formulario']){
		add_options_page('Formularios', 'Formularios', 8, basename(__FILE__), 'formulario_editar');
	}
	if ($_GET['page']=="class-form.php"){
		add_action('admin_head', 'add_js_formularios');
	}
}

add_action('admin_menu', 'admin_formu');


?>
