<?php
/*
  Template Name: Programacion
 */
session_start();

$_POST['region'] = str_replace(explode(',', 'ª,¨,Ç,?,\,/,|,",\',;,(,),*,:,<,>,!,|,&,#,%,$,+,[,],^,~,`,=,½,¬,{,},·,¿,'), '', $_POST['region']);
$_POST['comuna'] = str_replace(explode(',', 'ª,¨,Ç,?,\,/,|,",\',;,(,),*,:,<,>,!,|,&,#,%,$,+,[,],^,~,`,=,½,¬,{,},·,¿,'), '', $_POST['comuna']);

if (!empty($_POST['comuna'])) {
    $_SESSION['comuna'] = $_POST['comuna'];
} else {
    if (!isset($_SESSION['comuna'])) {
        $_SESSION['comuna'] = 'Santiago';
    }
}
require_once(ABSPATH . "/wp-content/plugins/forms/class.php");
?>
<?php get_header(); ?>
<div id="main" class="programacion-canales">			
    <div id="content" class="grid_12 alpha">
        <div class="page">
            <?php echo $ida->breadcrumb(); ?>
            <form action="" method="post">
                <div class="registro rounded cf">
                    <label for="region">¿Quieres personalizar tu programacion? Regi&oacute;n</label>
                    <?php $form = new form();
                    print $form->select("name=region&id=region&clase=formu&tab=13", region());
                    ?>
                    <label for="comuna">Comuna</label>
<?php print $form->select("name=comuna&id=comuna&value=fixvalue&clase=formu&tab=14", comunas($form->get_region('name=region'))); ?>
                    <input type="hidden" name="producto" id="producto" value="default" />
                    <input type="hidden" name="dbox" id="dbox" value="default" />
                    <input type="hidden" name="comunaElegida" id="comunaElegida" value="<?php echo $_SESSION['comuna']; ?>" />
                    <input type="submit" name="update-ajax" value="Ver" class="Ver" />
                </div>
            </form>
            <div class="botonera cf">
                <div class="despbox">
                    <span class="quever"> qu&eacute; ver </span>
                    <ul class="rounded desplegable">
                        <li class="ie"><a id="sel_cat" class="sel_despl" href="#" title="elige la categoría">elige la categoría</a></li>
<?php selector_canales(); ?>
                    </ul>
                </div>
                <span class="cuando"> cuándo </span> <a href="#" class="botoncor" id="ahora">ahora</a><a href="#" class="botonlar" id="prime"> esta noche </a><a href="#" class="botoncor sel_date" id="fecha_<?php echo date("mdy", mktime(0, 0, 0, date(m), date(d) + 1, date(y))); ?>"> mañana </a><a href="#"  id="fecha_<?php echo date("mdy", mktime(0, 0, 0, date(m), date(d) + 2, date(y))); ?>" class="botoncor sel_date"><?php echo fecha(2, "D") . ' ' . fecha(2, "d"); ?></a><div class="despbox2 cf"><ul class="rounded desplfecha"><?php selector_fechas_13(); ?></ul></div>
                <div id="search" class="programacion-search">
                    <form id="busqueda" class="cf" action="" method="get" name="formulario">
                        <label class="buscar" for="searchbox">buscar</label><input name="searchbox" id="searchbox" type="text" value="tu programa" onClick="this.value=''" />
                    </form>
                </div>
            </div>
            <div id="programacion" class="container_3 cf">
                <ul id="boxcanales">
                    <li style="z-index: 25; width: 107px; position: relative;">
                        <div class="fecha_grilla"><?php echo Date("j") . " " . mes_abreviado(Date("M")); ?></div>
                        <a id="backgrilla" title="ir a hora anterior">Anterior &raquo;</a>
                        <div id="canales">
                            <ul>
<?php echo canales(0, 20, "cate", false, $_SESSION['comuna']); ?>
                            </ul>
                        </div>
                    </li>
                </ul>
                <div id="reloj">
<?php echo horario(); ?>
                </div>
                <ul id="boxgrilla">
                    <li>
<?php echo grilla(0, 20, "cate", false, false, false, $_SESSION['comuna']); ?>
                    </li>
                </ul>
                <ul id="barrascroll">
                    <li><a id="forwgrilla" title="ir a siguiente hora">siguiente &raquo;</a></li>
                    <li><a id="upgrilla" title="ir a canales de arriba">arriba &raquo;</a></li>
                    <li class="btnbajo"><a id="downgrilla" title="ir a canales de abajoa">abajo &raquo;</a></li>
                </ul>
            </div>
            <div class="cali" >
                <p><strong>Calificación:</strong> <span class="discla">(*) La grilla está sujeta a modificaciones por parte de VTR</span></p>
                <dl>
                    <dt>-G-</dt>
                    <dd>: Todo espectador</dd>
                    <dt>-PG-</dt>
                    <dd>: Para todo espectador con atención de adultos</dd>
                    <dt>-PG13-</dt>
                    <dd>: Mayores de 14 años</dd>
                </dl>
                <dl>
                    <dt>-R-</dt>
                    <dd>: Recomendado para mayores de 18 años</dd>
                    <dt>-NC17-</dt>
                    <dd>: Adultos</dd>
                    <dt>-NR-</dt>
                    <dd>: Sin calificación</dd>
                </dl>
            </div>
            <a class="btnegro rounded" href="./grilla-de-canales-por-ciudad/">ver grilla de canales por ciudades &raquo;</a>
            <div id="legales">
                <?php if (!is_user_logged_in()): ?>
                    <?php echo get_post_meta(1563, 'condiciones', true); ?>
                <?php else: ?>
                    <?php echo get_post_meta(1563, 'condiciones_registrado', true); ?>
<?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>