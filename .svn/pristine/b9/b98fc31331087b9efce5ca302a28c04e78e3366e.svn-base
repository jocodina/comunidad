<?php

/*
  Plugin Name: VTR Header and Footer
  Plugin URI: maxvillegas.com
  Description: Admin de Header y Footer
  Version: 3.0
  Author: Max Villegas
  Author URI: http://mvillegas.com/
 */

function header_footer() {
    global $ida;
    if ($_POST['reset_header']) {
        update_option('header_css', $_POST["header_css"]);
        update_option('header_html', $_POST["header_html"]);    
        $varGuadado = '<p  style="width:300px; padding: 10px; display:block;background:#ffffc3;" >Nuevo Header guardado correctamente</p>';
        $_POST['reset']=true;
    }
    if ($_POST['reset_footer']) {
        update_option('footer_css', $_POST["footer_css"]);
        update_option('footer_html', $_POST["footer_html"]);        
        $varGuadado = '<p  style="width:300px; padding: 10px; display:block;background:#ffffc3;">nuevo Footer guardado correctamente</p>';        
        $_POST['reset']=true;        
    }
    if ($_POST['reset']) {
          $html = base64_encode($ida->getcurl(get_option('header_html')));
          set_transient("header2011", $html, 60 * 60 * 12);
           
          $html = base64_encode($ida->getcurl(get_option('footer_html')));
          set_transient("footer2011", $html, 60 * 60 * 12);
          
          $varGuadado = '<p  style="width:300px; padding: 10px; display:block;background:#ffffc3;">Header Footer actualizados</p>';        
    }

    echo '<div class="wrap">
      <h2>Adminsitrador de Header y Footer</h2>        
        '.$varGuadado.'
      <h2>Header</h2>
              <form action="" method="post" >
              <label style="width:400px;display:block;" for="header_css">header css (dirección de hoja de estilo) <input size="60" id="header_css" type="text" name="header_css" value="' . get_option('header_css') . '"></label><br />
              <label style="width:400px;display:block;" for="header_html">header html (dirección de html a almacenar) <input size="60" id="header_html" type="text" name="header_html" value="' . get_option('header_html') . '"></label><br />
              <input type="submit" name="reset_header" value="Guardar">
              </form>
      <h2>Footer</h2>
              <form action="" method="post" >
              <label style="width:400px;display:block;" for="footer_css">footer css (dirección de hoja de estilo)<input size="60" id="footer_css" type="text" name="footer_css" value="' . get_option('footer_css') . '"></label><br />
              <label style="width:400px;display:block;" for="footer_html">footer html (dirección de html a almacenar) <input size="60" id="footer_html" type="text" name="footer_html" value="' . get_option('footer_html') . '"></label><br />
              <input type="submit" name="reset_footer" value="Guardar">
              </form>
      <h2>Reset Tarnsient </h2>
              <form action="" method="post" >
              <label for="reset">Actualizar ahora (eliminar caché 12hrs) <input id="reset" type="submit" name="reset" value="Reset"></alabel>
              </form>
     </div>';
}

function menuHeaderAdmin() {
    add_menu_page('Header Footer', 'Header Footer', 8, __FILE__, 'header_footer');
}

add_action('admin_menu', 'menuHeaderAdmin');
?>