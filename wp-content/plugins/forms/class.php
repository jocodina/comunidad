<?php

class form {

	//contiente todos los campos del formulario y su tipo de validacion
	var $requeridos=array();

	//arrays para validaciones
	var $array_presencia;
	var $array_obligatorio;
	var $array_excluido;
	var $array_telefono;
	var $array_rut;
	var $array_numero;
	var $array_largo;
	var $array_email;
	var $array_confirm_email;
	var $array_clave;

	//mensajes
	var $mensajes=array();
	var $array_error;
	var $array_defecto;

	//funciones de filtro
	function presencia($var){
		return $var=="presencia"?true:false;
	}
	function telefono($var){
		return $var=="telefono"?true:false;
	}
	function rut($var){
		return $var=="rut"?true:false;
	}
	function numero($var){
		return $var=="numero"?true:false;
	}
	function largo($var){
		return $var=="largo"?true:false;
	}
	function email($var){
		return $var=="email"?true:false;
	}
	function clave($var){
		return $var=="clave"?true:false;
	}
	function obligatorio($var){
		return $var != "excluir" && $var != "null" ? true : false;
	}
	function excluido($var){
		return $var=="excluir"?true:false;
	}

	function verificar() {
			$this->array_presencia = array_filter($this->requeridos, array($this,"presencia"));
			$this->array_obligatorio = array_filter($this->requeridos, array($this,"obligatorio"));
			$this->array_telefono = array_filter($this->requeridos, array($this,"telefono"));
			$this->array_rut = array_filter($this->requeridos, array($this,"rut"));
			$this->array_clave = array_filter($this->requeridos, array($this,"clave"));
			$this->array_numero = array_filter($this->requeridos, array($this,"numero"));
			$this->array_largo = array_filter($this->requeridos, array($this,"largo"));
			$this->array_email = array_filter($this->requeridos, array($this,"email"));
			$this->array_excluido = array_filter($this->requeridos, array($this,"excluido"));
			$this->array_defecto = $this->mensajes['defecto'];
			$this->array_error = $this->mensajes['error'];

		//obtenemos los campos a validar sacando los que excluidos y nulos
		foreach ($this->array_obligatorio as $nombre=>$valor){
			$lista .= $nombre.",";
		}
		$lista_nombre_de_campos = trim($lista, ',');
		return $this->validaciones($lista_nombre_de_campos);
	}

	function validaciones($valores){
		$valores = split(',',$valores);
		$err['error']=false;
		$i=0;

		foreach($valores as $valor) {
                                                            
			// para datos vacios
 			if (in_array($valor,array_keys($this->array_presencia))){
				if (($_POST[$valor]=='default' || $_POST[$valor]=='' || $_POST[$valor]==$this->array_defecto[$i]) || eregi("[^a-z,A-Z,0-9,_]",$_POST[$valor])) {
       				//$_POST[$valor] = str_replace(explode(',', '?,\,/,|,",\',;,.,(,),*,:,<,>,!,|,&,#,%,$,+,@,[,],^,~,`,=,½,¬,{,},·,¿,'), '', $_POST[$valor]);
                                        $_POST[$valor]= ereg_replace("[^a-z,A-Z,0-9,_]","",$_POST[$valor]);
					$err[$valor]=$this->array_error[$valor];
					$this->track_error[$valor]=" alert";
                                        $err['error']=true;
				}
			}
			// para valores solo numericos
			if (is_array($this->array_numero)) {
				if (in_array($valor,array_keys($this->array_numero))){
					if(!is_numeric($_POST[$valor])) {
						$err[$valor]=$this->array_error[$valor];
						$this->track_error[$valor]=" alert";
                                                $err['error']=true;
						unset($_POST[$valor]);

					}
				}
			}
			// para valores de una extension especifica
			if (is_array($this->mensaje_largo)) {
				if ($this->mensaje_largo[$i] != 'null'){
					if(strlen($_POST[$valor])!=$this->mensaje_largo[$valor]){
						$err[$valor]=$this->array_error[$valor];
						$this->track_error[$valor]=" alert";
                                                $err['error']=true;
						unset($_POST[$valor]);
					}
				}
			}
			// para emails
			if(is_array($this->array_email)){
				if (($_POST[$valor]=='default' || $_POST[$valor]=='') || (array_key_exists($valor,$this->array_email) && !eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,6}$",$_POST[$valor]))) {
                                        $_POST[$valor] = str_replace(explode(',', 'ª,¨,Ç,?,\,/,|,",\',;,(,),*,:,<,>,!,|,&,#,%,$,+,[,],^,~,`,=,½,¬,{,},·,¿,'), '', $_POST[$valor]);
					$err[$valor]=$this->array_error[$valor];
					$this->track_error[$valor]=" alert";
                                        $err['error']=true;
					//unset($_POST[$valor]);
				}
			}
			//para rut
			if(is_array($this->array_rut)){
					if (in_array($valor, array_keys($this->array_rut))){
						$arkey = array_keys($this->array_rut);
						$r=$_POST[$arkey[0]]."-".$_POST[$arkey[1]];
						$r=strtoupper(ereg_replace('\.|,|-','',$r));
						$sub_rut=substr($r,0,strlen($r)-1);
						$sub_dv=substr($r,-1);
						$x=2;
						$s=0;
						for ( $i=strlen($sub_rut)-1;$i>=0;$i-- ){
							if ( $x >7 ){
								$x=2;
							}
							$s += $sub_rut[$i]*$x;
							$x++;
						}
						$dv=11-($s%11);
						if ( $dv==10 ){
							$dv='K';
						}
						if ( $dv==11 ){
							$dv='0';
						}
						if ( ($dv!=$sub_dv ) ||( $_POST[$valor]=='default' || $_POST[$valor]=='' )){
								if($num!=$dv){
								$err[$valor]=$this->array_error[$valor];
								$this->track_error[$valor]=" alert";
								unset($_POST[$arkey[0]]);
								unset($_POST[$arkey[1]]);
						}
					}
				}
			}
			if(is_array($this->array_clave)){
				if (in_array($valor, array_keys($this->array_clave))){
					$clavekeys = array_keys($this->array_clave);
					if(($_POST[$clavekeys[0]]!=$_POST[$clavekeys[1]]) || ( $_POST[$clavekeys[0]]=="" || $_POST[$clavekeys[1]]=="") ){
						$err[$valor]=$this->array_error[$valor];
						$this->track_error[$valor]=" alert";
						unset($_POST[$clavekeys[0]]);
						unset($_POST[$clavekeys[1]]);
                                                $err['error']=true;
					}
				}
			}
		$i++;
		}
	if($_POST[clave]) $_POST[clave]=md5($_POST[clave]);
	return $err;
	}

	function text($arg){
		global $estado,$editar;
		//valores por defecto
		$clase="input";
		parse_str($arg);

		if (!isset($name)) {
			print "Error en la creci&oacute;n del formulario";
			return;
		}
		if($_POST[$name]=="default"){$_POST[$name]="";}
		$js=$onfocus?' onfocus="javascript:if(this.value==\''.$value.'\'){this.value=\'\';}"':'';
		$largo = isset($maxlength)?' maxlength="'.$maxlength.'"':'';
		$tabindex = $tab?' tabindex="'.$tab.'"':'';
		$valor = isset($_POST[$name])?$_POST[$name]:$_SESSION[$name];
		$value = isset($_POST[$name]) ||  isset($_SESSION[$name])?' value="'.$valor.'"':' value="'.$value.'"';
		$id = isset($id) ? $id : $name;
		$disabled = $disabled?' disabled="'.$disabled.'"':'';
		$alert = $this->track_error && in_array($name, array_keys($this->track_error))?" ".$this->track_error[$name]:"";
		return '<input id="'.$id.'" type="text" name="'.$name.'" '.$value.' class="'.$clase.$alert.'"'.$tabindex.$largo.$js.$disabled.' />';
	}
	
	function confirm_mail($arg){
		global $estado,$editar;
		//valores por defecto
		$clase="input";
		parse_str($arg);

		if (!isset($name)) {
			print "Error en la creci&oacute;n del formulario";
			return;
		}
		if($_POST[$name]=="default"){$_POST[$name]="";}
		if($_POST[$name] != $_POST[$confirm]){$_POST[$name]="";}
		
		$js=$onfocus?' onfocus="javascript:if(this.value==\''.$value.'\'){this.value=\'\';}"':'';
		$largo = isset($maxlength)?' maxlength="'.$maxlength.'"':'';
		$tabindex = $tab?' tabindex="'.$tab.'"':'';
		$valor = isset($_POST[$name])?$_POST[$name]:$_SESSION[$name];
		$value = isset($_POST[$name]) ||  isset($_SESSION[$name])?' value="'.$valor.'"':' value="'.$value.'"';
		$id = isset($id) ? $id : $name;
		$disabled = $disabled?' disabled="'.$disabled.'"':'';
		$alert = $this->track_error && in_array($name, array_keys($this->track_error))?" ".$this->track_error[$name]:"";
		return '<input id="'.$id.'" type="text" name="'.$name.'" '.$value.' class="'.$clase.$alert.'"'.$tabindex.$largo.$js.$disabled.' />';
	}
	
	function get_region($arg){
		parse_str($arg);
		$region = $_POST[$name];
		if($region){
			return $region;
		}else{
			return array();
		}
	}

	function select($arg,$options){
		global $estado,$editar;
			
		//valores por defecto
		$value="";
		$clase = "input";
		parse_str($arg);

		if (!isset($name)) {
			print "Error en la creacion del formulario";
			return;
		}
		$tabindex = isset($tab)?' tabindex="'.$tab.'"':'';
		$alert = $this->track_error && in_array($name, array_keys($this->track_error))?" ".$this->track_error[$name]:"";
		$disable = isset($disable)?' disabled="disabled"':"";
		$out .= '<select name="'.$name.'" id="'.$name.'" class="'.$clase.$alert.'" '.$tabindex.$disable.' >';
		if (!$def) $out .= '<option value="default">Elige una opci&oacute;n</option>';

		$i=0;
		foreach ((array)$options as $option_name=>$option_value){
			$valor = isset($_POST[$name])?$_POST[$name]:$_SESSION[$name];
			$values=$value=='fixvalue'?$option_value:$option_name;
			if ($_POST){
				$default=$values==$valor ?' selected="selected"':"";
			}
			else{
				$default=$values==$selected ?' selected="selected"':"";
			}
			$out .= '<option'.$default. ' value="'.$values.'">'.$option_value.'</option>';
		$i++;
		}
		$out .= '</select>';

		return $out; 
	}

	function hidden($name, $value){
		return '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
	}

	function password($arg){
		parse_str($arg);
		$alert = $this->track_error && in_array($name, array_keys($this->track_error))?" ".$this->track_error[$name]:"";
		return '<input type="password" id="'.$name.'" name="'.$name.'"  class="'.$clase.$alert.'" value="" tabindex="'.$tab.'" maxlength="'.$maxlength.'"/>';
	}

	function checkbox($arg){
		global $estado;
		//valores por defecto
		$value="";
		$clase="input";
		parse_str($arg);

		$alert = $this->track_error &&  in_array($name, array_keys($this->track_error))?" ".$this->track_error[$name]:"";
		$id = isset($id) ? $id : $name;
		$valor = isset($_POST[$name]) ? $_POST[$name] : $_SESSION[$name];
		$default = isset($selected) && $selected == $value ? ' checked' : '';
		return '<input type="checkbox" id="'.$id.'" name="'.$name.'" value="'.$value.'"  tabindex="'.$tab.'" class="'.$clase.$alert.'" '.$default.' '.$disabled.' />';
	}

	function radio($arg){
		global $estado;
		//valores por defecto
		$value="";
		$clase="input";
		parse_str($arg);

		$alert = $this->track_error &&  in_array($name, array_keys($this->track_error))?" ".$this->track_error[$name]:"";
		$valor = isset($_POST[$name]) ? $_POST[$name] : $_SESSION[$name];
		$default=(isset($selected) && $selected == $value && !$_POST) || ($_POST[$name]==$value) ? ' checked' : "";
		return '<input type="radio" id="'.$id.'" name="'.$name.'" value="'.$value.'"  tabindex="'.$tab.'" class="'.$clase.$alert.'" '.$default.' '.$disabled.' />';
	}

	function textarea($arg){
		global $estado,$editar;
		//valores por defecto
		$clase="input";
		parse_str($arg);
		if (!isset($name)) {
			print "Error en la creción del formulario";
			return;
		}
		$alert = $this->track_error &&  in_array($name, array_keys($this->track_error))?" ".$this->track_error[$name]:"";
		$valor = isset($_POST[$name])?$_POST[$name]:$_SESSION[$name];
		$value = isset($_POST[$name]) ||  isset($_SESSION[$name])?$valor:$value;
		return '<textarea name="'.$name.'" tabindex="'.$tab.'" cols="'.$cols.'" rows="'.$rows.'" class="'.$clase.$alert.'" id="'.$id.'">'.stripslashes( $value ).'</textarea> ';
	}

	function file($arg){
		parse_str($arg);
		return  '<input type="file" name="'.$name.'" id="'.$name.'" tabindex="'.$tab.'" />';
	}

	function borrar($valores){
		$valores = split(',',$valores);
		$this->ini();
		foreach($valores as $valor){
			unset($_SESSION[$valor]);
			unset($_POST[$valor]);
			unset($_GET[$valor]);
		}
		return;
	}

	function ini(){
		session_start();	 			//iniciamos session
		session_cache_limiter('nocache');		//no permite que el cliente guarde contenido en su cache
		session_name("dataform"); 		  	//le damos un nombre a la sesión con la cual trabajar eventualmente para identificarla
	}

	function registrar($valores){
		$valores = split(',',$valores);
		$this->ini();

		foreach($valores as $valor){
		$_SESSION[$valor]= $_POST[$valor];
		}
	}

	function savesession($valores){
		$this->ini();
		foreach($valores as $name=>$valor){
		$_SESSION[$name]= $valor;
		}
	}
	function delsession($valores){
		$this->ini();
		foreach($valores as $name=>$valor){
			unset($_SESSION[$name]);
		}
	}

	function eliminar() {
		$this->ini();
		session_unset();							// Destruye todas las variables de la sesion
		session_destroy();							// Finalmente, destruye la sesión
	}

	function getarray($valores){
		$this->ini();
		$valores = split(',',$valores);
		foreach($valores as $valor){
			$save[$valor]=$_SESSION[$valor];
		}
	return $save;
	}
	function arraytosave($valores){
		$this->ini();
		foreach ($_SESSION as $name=>$value){
		$save[$name]=$value;
		}
	return $save;
	}

	function sendmail(){
		$para  = $this->mailto['para'];
		$asunto = $this->mailto['asunto'];
		$mensaje = $this->mailto['mensaje'];
		$de = $this->mailto['de'];
		$cc = $this->mailto['cc'];
		$bcc = $this->mailto['bcc'];

		// Para enviar correo HTML, la cabecera Content-type debe definirse
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
		$cabeceras .= 'MIME-Version: 1.0'. "\r\n";
		$cabeceras .= 'X-Mailer: ClassFormPHP Mailer'. "\r\n";


		// Cabeceras adicionales
		// $cabeceras .= 'To:'. $para . "\r\n";
		$cabeceras .= 'From:'. $de . "\r\n";
		$cabeceras .= 'Cc:'. $cc . "\r\n";
		$cabeceras .= 'Bcc:'. $bcc . "\r\n";
		// Enviarlo
		wp_mail($para, $asunto, $mensaje, $cabeceras);
	}

	// formulario
	function form(){
	}

}// endclass
?>
