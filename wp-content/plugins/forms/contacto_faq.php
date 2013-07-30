<?php

// CREATE TABLE IF NOT EXISTS `wp_1_contact` (
// `id` int(10) NOT NULL auto_increment,
// `nombre` varchar(100) NOT NULL,
// `email` varchar(100) NOT NULL,
// `subject` varchar(255) NOT NULL,
// `tag` varchar(100) NOT NULL,
// `mensaje` text NOT NULL,
// `fecha` timestamp NOT NULL default CURRENT_TIMESTAMP,
// KEY `id` (`id`)
// ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
//
if ($_GET["agregar_tag"] && $_GET["id"] && $_GET["tag"]){
	$tags=$_GET["tag"];
	$id=$_GET["id"];
	$wpdb->query("UPDATE wp_1_contact SET tag = '$tags' WHERE id=$id" );
	echo json_encode($_GET);
	exit;
}

if ($_GET["agregar_respuesta"] && $_GET["id"] && $_GET["respuesta"]){
	$respuesta = $_GET["respuesta"];
	$id = $_GET["id"];
	$wpdb->query("UPDATE wp_1_contact SET respuesta = '$respuesta' WHERE id = $id" );
	$wpdb->query("UPDATE wp_1_contact SET status = '2' WHERE id = $id" );
	actualizar_contactos();
	$formularios = get_option($option."_es");
	$form  = new form();
	$form->mailto['de'] = get_bloginfo("admin_email");
	$form->mailto['para'] = $_GET['email'];
	$form->mailto['asunto'] = htmlentities(utf8_decode("Gracias por contactarnos"));
	$form->mailto['mensaje'] .= "<html><head><title>Minrel</title>";
	$form->mailto['mensaje'] .= $formularios["email_style"];
	$form->mailto['mensaje'] .= "</head><body>";
	$form->mailto['mensaje'] .= $_GET["respuesta"];
	$form->mailto['mensaje'] .= "</body></html>";
	$form->sendmail();
	echo json_encode($form->mailto);
	exit;
}

function lista_contacto(){
global $wpdb, $blog_id;
	$contact = $wpdb->get_results( "SELECT * FROM wp_1_contact WHERE 1" );
?>
	<div class="wrap">
		<h2><?php _e('Formularios de Contacto Enviados') ?></h2>
		<?php lista_contacto_widget(); ?>
	</div>
<?php
}

function lista_contacto_widget(){
global $wpdb, $blog_id;
	$contact = $wpdb->get_results("SELECT * FROM wp_1_contact WHERE blog_id = $wpdb->blogid");
?>
		<table class="form-table">
			<thead>
				<tr>
					<td style="width: 8%"><strong>Fecha</strong></td>
					<td style="width: 12%"><strong>Autor</strong></td>
					<td style="width: 10%"><strong>Tema</strong></td>
					<td style="width: 25%"><strong>Mensaje</strong></td>
					<td style="width: 15%"><strong>Etiqueta</strong></td>
					<td style="width: 10%"><strong>Estado</strong></td>
					<td style="width: 5%"><strong>Editar</strong></td>
					<td style="width: 5%"><strong>Borrar</strong></td>
				</tr>
			</thead>
			<tbody>
		<?php
			$lista=array();
			foreach ($contact as $eachContact):
			$fecha = split(' ', $eachContact->fecha);
			$fecha = split('-', $fecha[0]);
			$fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
		?>
				<tr>
					<td><?php echo $fecha ?></td>
					<td><?php echo $eachContact->nombre ?></td>
					<td><?php echo $eachContact->subject ?></td>
					<td><?php echo cortar($eachContact->mensaje,75) ?></td>
					<td><?php foreach(explode(", ", $eachContact->tag) as $tag) {echo $tag; }?></td>
					<td><?php echo estado_email($eachContact->status); ?></td>
					<td><a href="admin.php?page=responder&amp;contacto=<?php echo $eachContact->id?>">Editar</a></td>
					<td><a href="admin.php?page=forms/contacto_faq.php&amp;borrar=<?php echo $eachContact->id?>">Borrar</a></td>
				</tr>
		<?php
				$lista[]=$nombre[2];
			endforeach;
		?>
			</tbody>
		</table>
<?php
}

function responder(){
	global $wpdb,$blog_id;
	$id = $_GET['contacto'];
	$contact = $wpdb->get_row("SELECT * FROM wp_1_contact WHERE id = $id" );
	if ($contact->status==0) {
		$wpdb->query("UPDATE wp_1_contact SET status = 1 WHERE id = $id" );
	}
	actualizar_contactos();
?>
<div class="wrap">
	<form method="post" action="">
		<input type="hidden" name="idtag" id="idtag" value="<?php echo $contact->id; ?>" />
		<input type="hidden" name="email" id="email" value="<?php echo $contact->email; ?>" />
		<table class="form-table">
			<tr>
				<th>Autor </th>
				<td><?php echo $contact->nombre; ?></td>
			</tr>
			<tr>
				<th>Tema<br /> </th>
				<td><?php echo $contact->subject; ?></td>
			</tr>
			<tr>
				<th>Mensaje<br /> </th>
				<td><?php echo $contact->mensaje; ?></td>
			</tr>
			<tr>
				<th>email</th>
				<td><?php echo $contact->email; ?></td>
			</tr>
			<tr>
				<th>Etiquetas</th>
				<td>
					<input type="text" name="tag" id="tags" value="<?php echo $contact->tag; ?>" /> <input type="button" class="guardar_tag" id="guardar_tag" value="Guardar">
					<samp>Palabras separadas por comas. Ejemplo: Comercio, Visa</samp>
				</td>
			</tr>
			<tr>
				<th>Respuesta</th>
				<td>
					<textarea name="respuesta" id ="respuesta" cols ="60" rows="15"><?php echo $contact->respuesta; ?></textarea><br />
					<input type="button" class="guardar_respuesta" id="guardar_respuesta" value="Responder">
				</td>
			</tr>
		</table>
	</form>
</div>
<?php
}

function contacto_eliminar(){
	global $wpdb, $blog_id;
	$wpdb->query("DELETE FROM wp_1_contact WHERE id = $_GET[borrar]");
}

function lista_admin_contacto(){
?>
	<div class="wrap">
		<h2><?php _e('Formularios de Contacto Enviados') ?></h2>
		<?php lista_admin_contacto_widget(); ?>
	</div>
<?php
}

function lista_admin_contacto_widget($cantidad = 1000){
global $wpdb,$blog_id;
?>
		<table class="form-table">
			<thead>
				<tr>
					<td><strong>Unidad</strong></td>
					<td><strong>Tipo</strong></td>
					<td><strong>Nuevos</strong></td>
					<td><strong>Le&iacute;dos</strong></td>
					<td><strong>Contestados</strong></td>
					<td><strong>Total</strong></td>
				</tr>
			</thead>
			<tbody>
		<?php
			$blog_comments = $wpdb->get_results( "SELECT `tipo`, `pais`, `ciudad`, `comentarios`, `blog_id` FROM wp_blogs WHERE 1");
			$lista = array(); $i = 0;
			foreach ($blog_comments as $eachBlog):
			$comentarios = json_decode($eachBlog->comentarios);
			if($cantidad):
				if($i<$cantidad):
					$lugar = $eachBlog->tipo=="consulado" ? $eachBlog->ciudad . ", ". $eachBlog->pais : $eachBlog->pais ;
		?>
				<tr>
					<td><a href="<?php echo $wpdb->get_var("SELECT option_value FROM wp_".$eachBlog->blog_id."_options WHERE option_name = 'siteurl'"); ?>wp-admin/admin.php?page=forms/contacto_faq.php" title="Ver Correos"><?php echo $lugar ?></a></td>
					<td><?php echo $eachBlog->tipo?></td>
					<td class="tCent"><?php echo $comentarios->nuevos?  $comentarios->nuevos: "0" ?></td>
					<td class="tCent"><?php echo $comentarios->leidos ? $comentarios->leidos:"0"?></td>
					<td class="tCent"><?php echo $comentarios->contestados ? $comentarios->contestados: "0" ?></td>
					<td class="tCent"><?php echo $comentarios->total  ? $comentarios->total: "0" ?></td>
				</tr>
		<?php endif; endif; $i++; endforeach; ?>
			</tbody>
		</table>
<?php
}

function admin_formu_contacto(){
	add_menu_page('Contactos', 'Contactos', 8, __FILE__, 'lista_contacto');
	add_submenu_page(__FILE__, 'Contactos', 'Resumen Admin Contactos ', 8, "lista_admin_contacto", 'lista_admin_contacto');
	if ($_GET['page']=='forms/contacto_faq.php' && $_GET['borrar']){
		contacto_eliminar();
	}
	if ($_GET['page']=='responder'){
		add_submenu_page(__FILE__, 'Formularios', 'Responder Contacto', 8, "responder", 'responder');
	}
}

add_action('admin_menu', 'admin_formu_contacto');

?>