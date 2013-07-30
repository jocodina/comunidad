<?php
/*
  Template Name: Grilla
 */
?><?php
$user_id = usuario();
if ($user_id!=0) {
    $user_data = edit_udata();
}
require_once(ABSPATH . "/wp-content/plugins/forms/class.php");
?>
<?php get_header(); ?>
<div id="main" class="programacion-canales">			
    <div id="content" class="grid_12 alpha">
        <div class="page">
            <?php echo $ida->breadcrumb(); ?>
            <div id="centroreg" class="grid_3">
                <h2>Señales de televisión vtr a nivel nacional</h2><a href="../" class="btnegro rounded">volver a programación</a>
            </div>
            <div id="gridtodo" class="cf">
                <ul id="reglist">
                    <li class="btn">
                        <a id="backregi" class="regiback" href="#" title="atrás"></a>
                    </li>
                    <li>Arica</li>
                    <li>Iquique</li>
                    <li>Tocopilla</li>
                    <li>Calama</li>
                    <li>Antofagasta</li>
                    <li>El Salvador</li>
                    <li>Copiapo</li>
                    <li>Vallenar</li>
                    <li>La Serena</li>
                    <li>Illapel</li>
                    <li>La Ligua</li>
                    <li>Aconcagua</li>
                    <li>Viña del mar</li>
                    <li>San Antonio</li>                
                    <li>Santiago</li>
                    <li>Rancagua</li>
                    <li>San Fernando</li>
                    <li>Curicó</li>
                    <li>Talca</li>
                    <li>Linares </li>
                    <li>Parral</li>
                    <li>Cauquenes</li>
                    <li>Chillán </li>             
                    <li>San Carlos</li>
                    <li>Constitución</li>
                    <li>Concepcion</li>
                    <li>Los Angeles</li>
                    <li>Angol</li>
                    <li>Victoria</li>
                    <li>Temuco</li>
                    <li>Valdivia</li>
                    <li>Osorno</li>
                    <li>Puerto Montt</li>
                    <li>Ancud</li>
                    <li>Castro</li>
                    <li>Coyhaique</li>
                    <li class="btn2">
                        <a id="backregi2" class="regiback" href="#" title="atrás"></a>
                    </li>
                </ul>
                <div id="warpregi">
                    <div id="slideregi" class="ancho cf">
                        <?php canalesregion(); ?>
                    </div>

                </div>
                <a  id="forwregi" class="regiforw" href="#">adelante</a>
                <a  id="forwregi2" class="regiforw" href="#">adelante</a>
            </div>
            <div id="legales">
                <p>
                    - Oferta de canales sujeta a factibilidad técnica y comercial. <br />
                    - Los contenidos y las señales de la programación de VTR pueden ser modificados.
                </p>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
