<?php
/*
Plugin Name: admin de programacion
Plugin URI: maxvillegas.com
Description: admin de programacion
Version: 1.0
Author: Max Villegas
Author URI: http://mvillegas.com/
*/

function upload_logo($file){
    global $archivo;
	if ($_FILES[$file]["size"]!=""){
	$img_archivo = $_FILES[$file]["tmp_name"];
	$img_tamanio = $_FILES[$file]["size"];
	$img_tipo    = $_FILES[$file]["type"];
	$img_nombre  = $_FILES[$file]["name"];
	$thum= get_theme_root() . '/comunidadtv/img/foto/'.$img_nombre;
	$nails = $img_nombre;
	$_POST[$file]=$nails;
	copy($img_archivo, $thum);
	return $nails;
	}
}
//$_POST, $wpdb_pr->full, $_GET["grillaID"]
function save_data_grilla($vars, $tabla, $id=false) {
    global $wpdb_pr;
    $fields=$wpdb_pr->get_results("SELECT * FROM $tabla", OBJECT); //obtiene todo lo de la tabla full

    foreach ($fields[0] as $k => $v) { 
        $fieldsname[] = $k;

    }
    foreach($vars as $clave => $valor) {
        if (!in_array($clave, $fieldsname)) {
            $clavelist[]=$clave;
        }
        $value_vars .= "'" . $valor . "', ";
        $name_vars .= $clave .", ";
        $pares .= $clave ." = '". $valor ."', ";

    }
    $name_vars=trim($name_vars, ", ");
    $value_vars=trim($value_vars, ", ");
    $pares = trim($pares, ", ");


    if (isset($clavelist)) {
        return array("action"=>"insert", "error"=>$clavelist);
    }
    else {
        if (!$id) {
            $wpdb_pr->query("INSERT INTO $tabla ($name_vars) values ($value_vars)");
            return array("action"=>"insert");
        }
        else {
            $wpdb_pr->query("UPDATE $tabla SET $pares WHERE id = $id");
            return array("action"=>"update");
        }

    }
}

function admin_canales_list(){
    global $wpdb, $wpdb_pr, $ida;
    
    if($_GET["borrar"]){
        $grillaID =  $_GET["grillaID"];
        $dataID =  $_GET["dataID"];
        

         $wpdb_pr->query("DELETE FROM $wpdb_pr->full WHERE id = $grillaID");            
//         $wpdb_pr->query("DELETE FROM $wpdb_pr->chn_web WHERE id = $dataID");
         $datos_guardados="<p>Canal eliminado exitosamente</p>";
    }
    
    if($_POST["guardar"]){ 
        upload_logo('imagen');
        upload_logo('imagentrans');
        upload_logo('imagen40x40');
        $varsData["codigo"] = $_POST["codigo"];
        $varsData["senal"] = $_POST["senal"];
        $varsData["imagen"] = $_POST["imagen"];
        $varsData["imagentrans"] = $_POST["imagentrans"];
        $varsData["imagen40x40"] = $_POST["imagen40x40"];
        $varsData["genero"] = $_POST["genero"];
        $varsData["driver"] = $_POST["driver"];        
        if (!$_POST["imagen"]){unset($varsData["imagen"]);}
        if (!$_POST["imagentrans"]){unset($varsData["imagentrans"]);}
        if (!$_POST["imagen40x40"]){unset($varsData["imagen40x40"]);}
        
        unset($_POST["senal"],$_POST["imagen"],$_POST["imagentrans"],$_POST["imagen40x40"], $_POST["genero"],$_POST["driver"], $_POST["guardar"]); 
        $r1 = save_data_grilla($varsData, $wpdb_pr->chn_web, $_GET["dataID"]); 
        $r2 = save_data_grilla($_POST, $wpdb_pr->full, $_GET["grillaID"]);         
        
        if ($r1['action'] =="update" && $r2['action'] =="update" ){
            $datos_guardados="<p>Canal guardado exitosamente</p>";
        }
     }
     
    if($_POST["save"]){ 
        upload_logo('imagen');
        upload_logo('imagentrans');
        upload_logo('imagen40x40');
        $varsData["codigo"] = $_POST["codigo"];
        $varsData["senal"] = $_POST["senal"];
        $varsData["imagen"] = $_POST["imagen"];
        $varsData["imagentrans"] = $_POST["imagentrans"];
        $varsData["imagen40x40"] = $_POST["imagen40x40"];
        $varsData["genero"] = $_POST["genero"];
        $varsData["driver"] = $_POST["driver"];        

        if (!$_POST["imagen"]){unset($varsData["imagen"]);}  
        if (!$_POST["imagentrans"]){unset($varsData["imagentrans"]);}
        if (!$_POST["imagen40x40"]){unset($varsData["imagen40x40"]);}
        
        unset($_POST["senal"],$_POST["imagen"],$_POST["imagentrans"],$_POST["imagen40x40"], $_POST["genero"],$_POST["driver"], $_POST["save"]); 
        $r1 = save_data_grilla($varsData, $wpdb_pr->chn_web); 
        $r2 = save_data_grilla($_POST, $wpdb_pr->full);         
        if ($r1['action'] =="insert" && $r2['action'] =="insert" ){
            $datos_guardados="<p>Canal creado exitosamente</p>";
        }
     }     
    if(!$_GET["editar"] && !$_GET["add"]){
    $_GET['obt'] = true;

      $query =  ("SELECT $wpdb_pr->full.codigo,  $wpdb_pr->full.id as grillaID, $wpdb_pr->chn_web.id as dataID, senal, categoria, imagen, imagentrans, imagen40x40, genero, driver, tipo, santiago, grupo FROM $wpdb_pr->full INNER JOIN $wpdb_pr->chn_web
      ON ($wpdb_pr->chn_web.codigo = $wpdb_pr->full.codigo) WHERE genero != 'Compra de Eventos' GROUP BY  $wpdb_pr->chn_web.id  ORDER BY codigo, santiago ASC");
      $r = $wpdb_pr->get_results($query, 'OBJECT');


    echo '
  <div class="wrap">
      <h2>Administrador grilla <small>(<a href="/wp-admin/admin.php?page=util_admin_grilla/util_admin_grilla.php&add=new" title="Agrega otro canal">Agregar canal</a>)</small></h2>
      <p><a href="/wp-admin/admin.php?page=util_admin_grilla/util_admin_grilla.php&grilla=full">Volver</a> </p>  
          '.$datos_guardados.'
    <table cellspacing="0" class="widefat post fixed">
	<thead>
        
	<tr>
	<th style="width:30px" class="manage-column" scope="col">nº</th>
	<th style="width:70px" class="manage-column" scope="col">Logo</th>
	<th style="width:100px" class="manage-column" scope="col">Channel ID</th>
	<th style="width:30px" class="manage-column" scope="col">Nº Stgo</th>                        
	<th style="width:200px" class="manage-column" scope="col">Señal</th>
	<th style="width:200px" class="manage-column" scope="col">Género</th>        
	<th style="" class="manage-column" scope="col">Categoría</th>
	<th style="" class="manage-column" scope="col">Editar</th>
	<th style="" class="manage-column" scope="col">Borrar</th>
	</tr>
	</thead>
        
	<tfoot>
	<tr>
	<th style="width:30px" class="manage-column" scope="col">nº</th>
	<th style="width:70px" class="manage-column" scope="col">Logo</th>
	<th style="width:100px" class="manage-column" scope="col">Channel ID</th>
	<th style="width:30px" class="manage-column" scope="col">Nº Stgo</th>                        
	<th style="width:200px" class="manage-column" scope="col">Señal</th>
	<th style="width:200px" class="manage-column" scope="col">Género</th>        
	<th style="" class="manage-column" scope="col">Categoría</th>
	<th style="" class="manage-column" scope="col">Editar</th>
	<th style="" class="manage-column" scope="col">Borrar</th>
	</tr>
	</tfoot><tbody>';
    
    
    
	
	$i=1;                        
    foreach ($r as $canal) {
        echo '<tr valign="top" class="alternate author-other status-publish " id="chn-'.$canal->codigo.'">
            <td>'.$i.'</td>
            <td><img src="/wp-content/themes/comunidadtv/img/foto/' .  $canal->imagen . '" width="48" /></td>
            <td>' . $canal->codigo . '</td> 
            <td>' . $canal->santiago . '</td>                                            
            <td>' . $canal->senal . '</td>
            <td>' . $ida->cortar($canal->genero, 20 ) . '</td>                
            <td>' . $canal->categoria . '</td>
            <td><a href="/wp-admin/admin.php?page=util_admin_grilla/util_admin_grilla.php&editar='.$canal->codigo.'&dataID='.$canal->dataID.'&grillaID='.$canal->grillaID.'">editar</a></td>
            <td><a href="/wp-admin/admin.php?page=util_admin_grilla/util_admin_grilla.php&borrar='.$canal->codigo.'&dataID='.$canal->dataID.'&grillaID='.$canal->grillaID.'">borrar</a></td>            
            </tr>
            ';
			$i++;
    }
    echo "</tbody><table></div>";
    }
    
    if($_GET["editar"]){
        $dataID = $_GET["dataID"];
        $grillaID = $_GET["grillaID"];
        
        $queryData =  ("SELECT * FROM $wpdb_pr->chn_web WHERE id = $dataID");
        $queryGrilla =  ("SELECT * FROM $wpdb_pr->full WHERE id = $grillaID");
        $r1 = $wpdb_pr->get_results($queryData, 'ARRAY_A');
        $r2 = $wpdb_pr->get_results($queryGrilla, 'ARRAY_A');       
        
        foreach ($r1 as $r1data){
            foreach ($r1data as $key => $value) {
                $typeInput = "text";
                if ($key == "genero"){ 
                    
                    if ($value=="Cine&Series") $default1 = "selected"; 
                    else unset($default1);
                    
                    if ($value=="Infantil") $default2 = "selected";
                    else unset($default2);
                    
                    if ($value=="Deportes") $default3 = "selected";
                    else unset($default3);
                    
                    
                    if ($value=="Musica") $default4 = "selected";
                    else unset($default4);
                    
                    if ($value=="Estilos & Tendencias") $default5 = "selected";
                    else unset($default5);
                    
                    if ($value=="Cultural") $default6 = "selected";
                    else unset($default6);
                    
                    if ($value=="Noticias") $default7 = "selected";
                    else unset($default7);
                    
                    if ($value=="Nacional") $default8 = "selected";
                    else unset($default8);
                    
                    if ($value=="Internacional") $default9 = "selected";
                    else unset($default9);
                    
                    if ($value=="Adulto") $default10 = "selected";
                    else unset($default10);
                    
                    if ($value=="Alta Definición") $default11 = "selected";
                    else unset($default11);   

                    if ($value=="Servicios") $default12 = "selected";
                    else unset($default12);     
                    
                    if ($value=="Compra de Eventos") $default13 = "selected";
                    else unset($default13);                         
                    
                    
                    $options = '<option value="">Selecciona una categoría</option>';                                        
                    $options .= '<option value="Cine&Series"'.$default1.'>Series & Películas</option>';
                    $options .= '<option value="Infantil"'.$default2.'>Infantil</option>';                    
                    $options .= '<option value="Deportes"'.$default3.'>Deportes</option>';                    
                    $options .= '<option value="Musica"'.$default4.'>Música</option>';      
                    $options .= '<option value="Estilos & Tendencias"'.$default5.'>Tendencias</option>';                          
                    $options .= '<option value="Cultural"'.$default6.'>Cultura</option>';                    
                    $options .= '<option value="Noticias"'.$default7.'>Noticias</option>';                                        
                    $options .= '<option value="Nacional"'.$default8.'>Nacional</option>';                                                            
                    $options .= '<option value="Internacional"'.$default9.'>Internacional</option>';                    
                    $options .= '<option value="Adulto"'.$default10.'>Adulto</option>';
                    $options .= '<option value="Alta Definición"'.$default11.'>Alta Definición</option>';                    
                    $options .= '<option value="Servicios"'.$default12.'>Servicios</option>';                                        
                    $options .= '<option value="Compra de Eventos"'.$default13.'>Compra de Eventos</option>';                                                            
                    $campos_data .= '<label><span style="display:block; float:left; width:100px;">'.$key.'</span> <select name="'.$key.'">'.$options.'</select></label>'."<br />";  
                    
                }
                if ($key == "imagen" || $key == 'imagentrans' || $key == "imagen40x40"){$typeInput = "file"; $img = '<img src="/wp-content/themes/comunidadtv/img/foto/' .  $value . '" width="20" />';}else{$img = "";}
                
                if ($key == "driver"){ $campos_data .= '<label><span style="display:block; float:left; width:100px;">'.$key.'</span>  <textarea name="'.$key.'" rows="6" cols="30">'.$value.'</textarea></label>'; }
                
                if ($key != "id" AND $key != "genero" AND $key != "delay" AND $key != "descripcion" AND $key != "driver") $campos_data .= '<label><span style="display:block; float:left; width:100px;">'.$key.'</span> '.$img.' <input size="20" type="'.$typeInput.'" name="'.$key.'" value="'.$value.'" /></label>'."<br />";  
            }
              
        }
        
        foreach ($r2 as $r2data){
            foreach ($r2data as $k => $v) {            
//                if ($k == "tipo"){ 
//                    if ($v=="Básico") $default1 = "selected"; 
//                    else unset($default1);
//                    
//                    if ($v=="Con d-Box") $default2 = "selected";
//                    else unset($default2);
//                    
//                    $options = '<option value="">Selecciona una opción</option>';                                        
//                    $options .= '<option value="Básico"'.$default1.'>Básico</option>';
//                    $options .= '<option value="Con d-Box"'.$default2.'>Con d-Box</option>';                    
//                   
//                    $campos_grilla .= '<label><span style="display:block; float:left; width:100px;">'.$k.'</span> <select name="'.$k.'">'.$options.'</select></label>'."<br />";  
//                    
//                }   
                if ($k == "categoria"){ 
                    if ($v=="Básico") $default1 = "selected"; 
                    else unset($default1);
                    
                    if ($v=="Premium") $default2 = "selected";
                    else unset($default2);
                    
                    $options = '<option value="">Selecciona una opción</option>';                                        
                    $options .= '<option value="Básico"'.$default1.'>Básico</option>';
                    $options .= '<option value="Premium"'.$default2.'>Premium</option>';                    
                   
                    $campos_grilla .= '<label><span style="display:block; float:left; width:100px;">'.$k.'</span> <select name="'.$k.'">'.$options.'</select></label>'."<br />";  
                    
                }                  
                  if ($k!= "id" and $k!= "codigo" and $k!= "tipo" and   $k!= "grupo" and $k!= "categoria") $campos_grilla .= '<label><span style="display:block; float:left; width:100px;">'.$k.' </span> <input size="20" name="'.$k.'" value="'.$v.'" /></label>'."<br />";  
            }
        }
        

        echo '<div class="wrap">
                  <h2>Administrador grilla <small>(<a href="/wp-admin/admin.php?page=util_admin_grilla/util_admin_grilla.php&add=new" title="Agrega otro canal">Agregar canal</a>)</small></h2>
                  <p><a href="/wp-admin/admin.php?page=util_admin_grilla/util_admin_grilla.php&grilla=full">Volver</a> </p>  
                   '.$datos_guardados.'                      
                  <form action="" method="post"  enctype="multipart/form-data">
                  <fieldset>
                  <legend><h3>Datos comunes de canal</h3></legend>
                  '.$campos_data.'
                  </fiedset>
                  <fieldset>
                  <legend><h3>Datos específicos de canal</h3></legend>
                  '.$campos_grilla.'
                  </fiedset>                  
                  <input type="submit" name="guardar" value="Enviar" />
                  </form>
        </div>';
    }
    
    
    if ($_GET["add"]=="new"){
        echo '<div class="wrap">
              <h2>Administrador grilla <small>(<a href="/wp-admin/admin.php?page=util_admin_grilla/util_admin_grilla.php&add=new" title="Agrega otro canal">Agregar canal</a>)</small></h2>
              <p><a href="/wp-admin/admin.php?page=util_admin_grilla/util_admin_grilla.php&grilla=full">Volver</a> </p>  
                    '.$datos_guardados.'                  
                  <form enctype="multipart/form-data" method="post" action="">
                  <fieldset>
                  <legend><h3>Datos comunes de canal</h3></legend>
                  <label><span style="display:block; float:left; width:100px;">codigo</span>  
                  <input type="text" value="" name="codigo" size="20"></label><br><label><span style="display:block; float:left; width:100px;">senal</span>  <input type="text" value="" name="senal" size="20"></label><br><label><span style="display:block; float:left; width:100px;">imagen</span> <input type="file" value="" name="imagen" size="20"></label><br><label><span style="display:block; float:left; width:100px;">genero</span> <select name="genero"><option value="">Selecciona una categoría</option><option value="Cine&amp;Series">Series &amp; Películas</option><option value="Infantil">Infantil</option><option value="Deportes">Deportes</option><option value="Musica">Música</option><option value="Estilos &amp; Tendencias">Tendencias</option><option value="Cultural">Cultura</option><option value="Noticias">Noticias</option><option value="Nacional">Nacional</option><option value="Internacional">Internacional</option><option value="Adulto">Adulto</option><option value="Alta Definición">Alta Definición</option></select></label><br><label><span style="display:block; float:left; width:100px;">driver</span>  <textarea cols="30" rows="6" name="driver"></textarea></label>
                  
                  <fieldset>
                  <legend><h3>Datos específicos de canal</h3></legend>
                  <label><span style="display:block; float:left; width:100px;">categoria</span> <select name="categoria"><option value="">Selecciona una opción</option>
                  <option  value="Básico">Básico</option><option value="Premium">Premium</option></select></label><br>
                  <label><span style="display:block; float:left; width:100px;">arica </span> <input value="" name="arica" size="20"></label><br><label><span style="display:block; float:left; width:100px;">iquique </span> <input value="" name="iquique" size="20"></label><br><label><span style="display:block; float:left; width:100px;">calama </span> <input value="" name="calama" size="20"></label><br><label><span style="display:block; float:left; width:100px;">antofagasta </span> <input value="" name="antofagasta" size="20"></label><br><label><span style="display:block; float:left; width:100px;">tocopilla </span> <input value="" name="tocopilla" size="20"></label><br><label><span style="display:block; float:left; width:100px;">copiapo </span> <input value="" name="copiapo" size="20"></label><br><label><span style="display:block; float:left; width:100px;">vallenar </span> <input value="" name="vallenar" size="20"></label><br><label><span style="display:block; float:left; width:100px;">el_salvador </span> <input value="" name="el_salvador" size="20"></label><br><label><span style="display:block; float:left; width:100px;">la_serena </span> <input value="" name="la_serena" size="20"></label><br><label><span style="display:block; float:left; width:100px;">illapel </span> <input value="" name="illapel" size="20"></label><br><label><span style="display:block; float:left; width:100px;">aconcagua </span> <input value="" name="aconcagua" size="20"></label><br><label><span style="display:block; float:left; width:100px;">vina_del_mar </span> <input value="" name="vina_del_mar" size="20"></label><br><label><span style="display:block; float:left; width:100px;">san_antonio </span> <input value="" name="san_antonio" size="20"></label><br><label><span style="display:block; float:left; width:100px;">la_ligua </span> <input value="" name="la_ligua" size="20"></label><br><label><span style="display:block; float:left; width:100px;">rancagua </span> <input value="" name="rancagua" size="20"></label><br><label><span style="display:block; float:left; width:100px;">san_fernando </span> <input value="" name="san_fernando" size="20"></label><br><label><span style="display:block; float:left; width:100px;">santiago </span> <input value="" name="santiago" size="20"></label><br><label><span style="display:block; float:left; width:100px;">talca </span> <input value="" name="talca" size="20"></label><br><label><span style="display:block; float:left; width:100px;">curico </span> <input value="" name="curico" size="20"></label><br><label><span style="display:block; float:left; width:100px;">chillan </span> <input value="" name="chillan" size="20"></label><br><label><span style="display:block; float:left; width:100px;">linares </span> <input value="" name="linares" size="20"></label><br><label><span style="display:block; float:left; width:100px;">san_carlos </span> <input value="" name="san_carlos" size="20"></label><br><label><span style="display:block; float:left; width:100px;">constitucion </span> <input value="" name="constitucion" size="20"></label><br><label><span style="display:block; float:left; width:100px;">parral </span> <input value="" name="parral" size="20"></label><br><label><span style="display:block; float:left; width:100px;">cauquenes </span> <input value="" name="cauquenes" size="20"></label><br><label><span style="display:block; float:left; width:100px;">los_angeles </span> <input value="" name="los_angeles" size="20"></label><br><label><span style="display:block; float:left; width:100px;">concepcion </span> <input value="" name="concepcion" size="20"></label><br><label><span style="display:block; float:left; width:100px;">angol </span> <input value="" name="angol" size="20"></label><br><label><span style="display:block; float:left; width:100px;">victoria </span> <input value="" name="victoria" size="20"></label><br><label><span style="display:block; float:left; width:100px;">temuco </span> <input value="" name="temuco" size="20"></label><br><label><span style="display:block; float:left; width:100px;">valdivia </span> <input value="" name="valdivia" size="20"></label><br><label><span style="display:block; float:left; width:100px;">osorno </span> <input value="" name="osorno" size="20"></label><br><label><span style="display:block; float:left; width:100px;">puerto_montt </span> <input value="" name="puerto_montt" size="20"></label><br><label><span style="display:block; float:left; width:100px;">ancud </span> <input value="" name="ancud" size="20"></label><br><label><span style="display:block; float:left; width:100px;">castro </span> <input value="" name="castro" size="20"></label><br><label><span style="display:block; float:left; width:100px;">coyhaique </span> <input value="" name="coyhaique" size="20"></label><br>
                                    
                  <input type="submit" value="Guardar" name="save">
                  
        </fieldset></fieldset></form></div>';
    }
    
}

function menuAdminGrilla() {
    add_menu_page('Admin Grilla', 'Admin Grilla', 8, __FILE__, 'admin_canales_list');
}

add_action('admin_menu', 'menuAdminGrilla');
?>