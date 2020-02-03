<?php header("Content-Type: application/xml; charset=utf-8");
/*
 **NERÛ
 */
session_start();
//include 'conexion.php';
$us = "wwwnerup_app";
$pw = "U1y(T&ZW%urJ";
$ser = "localhost";
$db = "wwwnerup_neruapp";
$con = new mysqli($ser, $us, $pw, $db);
//recupero datos
$x         = $_POST["datos"];
$k         = explode(",", $x);
$tipo      = $k[0];
//Iniciar Sesión
if ($tipo == "iniciar_sesion") {
  $usuario = strtolower($k[1]);
  $password = password_hash($k[2]);
  $sql    = "SELECT id, id_grupo, activo, stado_pago, status_variable, image_user, password from users where username='$usuario'";
  $res = $con->query($sql);
  $json = array();
  $json['success'] = false;
  $json['msg'] = "Usuario no valido";
  while ($row = mysqli_fetch_array($res)) {
  	$hash = $row['password'];
  	if (password_verify($k[2], $hash)) {
	    $json['success'] = true;
	    $json['msg'] = "Bienvenido ".$usuario;
	} else {
	    $json['success'] = false;
		$json['msg'] = "Contraseña incorrecta ";
	}
    $json[] = array(
      'id' => $row['id'],
      'id_grupo' => $row['id_grupo'],
  		'activo' => $row['activo'],
      'stado_pago' => $row['stado_pago'],
      'status_variable' => $row['status_variable'],
      'imagen' => $row['imagen_user'],
  	);
  }
  //echo $sql;
  echo json_encode($json);
}

if($tipo == "consulta_sesion"){
  $usuario = $k[1];
  $sql = "SELECT * FROM users WHERE id = '$usuario'";
  $res = $con->query($sql);
  $json = array();
  $json['success'] = false;
  $json['msg'] = "Vuelve a iniciar sesión";
  while ($row = mysqli_fetch_array($res)) {
    $json['success'] = true;
    $json['msg'] = "Usuario Existe";
  }
  echo json_encode($json);
}
if ($tipo == "add_codigo_usuario") {
	$usuario = $k[1];
	$codequipo = $k[2];
	$sq = "SELECT id_equipo FROM equipos WHERE codigo='$codequipo'";
  	$re = $con->query($sq);
  	while ($row = mysqli_fetch_array($re)) {
    	$idGrupo = $row['id_equipo'];
  	}
  	$json = array();
  	$json['success'] = false;
  	$json['msg'] = "No valido";
  	
  	$sql3 = html_entity_decode("INSERT INTO equipo_usuarios (id_equipo,id_jugador) VALUES('$idGrupo','$usuario')");
	if ($con->query($sql3) === TRUE) {
    	$json['success'] = true;
    	$json['msg'] = "Se actualizo correctamente";
  	}else{
    	$json['success'] = false;
    	$json['msg'] = "No ha ingresado un código";
  	}   
  	
  	echo json_encode($json);			
}
if ($tipo == "actualiza_usuario") {
  $usuario = $k[1];
  $edad =  $k[2];
  $ciudad = strtolower($k[3]);
  $pocision = strtolower($k[4]);
  $fechaNacimiento = $k[5];
  $sexo = $k[6];
  $imagen = $k[7];
  $codequipo = $k[8];
  $sq = "SELECT id_equipo FROM equipos WHERE codigo='$codequipo'";
  $re = $con->query($sq);
  while ($row = mysqli_fetch_array($re)) {
    $idGrupo = $row['id_equipo'];
  }
  $json = array();
  $json['success'] = false;
  $json['msg'] = "No valido";
  $sql    = "UPDATE users set edad='$edad', ciudad='$ciudad', posicion='$pocision', fecha_nacimiento='$fechaNacimiento', genero='$sexo', image_user='$imagen' WHERE id='$usuario'";
  $result = $con->query($sql);
    if ($con->query($sql) === TRUE) {
      $sql3 = html_entity_decode("INSERT INTO equipo_usuarios (id_equipo,id_jugador) VALUES('$idGrupo','$usuario')");
      if ($con->query($sql3) === TRUE) {
        $json['success'] = true;
        $json['msg'] = "Se actualizo correctamente";
      }else{
        $json['success'] = false;
        $json['msg'] = "Ocurrio un problema al agregar el equipo";
      }
    } else {
      $json['success'] = false;
      $json['msg'] = "Ocurrio un problema, vuelve a intentar ";
    }
  echo json_encode($json);
}
//Prueba
if ($tipo == "add") {
  $nombre = utf8_decode($k[1]);
  $app = utf8_decode($k[2]);
  $apm = utf8_decode($k[3]);
  $usuario = utf8_decode($k[4]);
  $password = password_hash($k[5], PASSWORD_DEFAULT);
  $email = $k[6];
  $sql    = html_entity_decode("INSERT INTO users (nombre,app,apm,username,email,password) VALUES('$nombre','$app','$apm','$usuario','$email','$password')");
  $res = $con->query($sql);

  $json = array();
  $json['success'] = true;
  echo json_encode($json);
}
//Update PASSWORD_DEFAULTif ($tipo == "add") {
if ($tipo == "update_pass") {
  $email = $k[1];
  $password = password_hash($k[2], PASSWORD_DEFAULT);
  $sql    = "SELECT email, password from users where email='$email'";
  $res = $con->query($sql);
  $json = array();
  $json['success'] = false;
  $json['msg'] = "Email no valido";
  while ($row = mysqli_fetch_array($res)) {
  	if($password == $row['password']){
      $json['success'] = false;
      $json['msg'] = "Contraseña anterior, ingrese una nueva";
    }else if($password != $row['password']){
      $sql2 = "UPDATE users set password='$password' where email='$email'";
      $result2 = $con->query($sql2);
      if ($con->query($sql2) === TRUE) {
        $json['success'] = true;
        $json['msg'] = "Se actualizo tu contraseña correctamente";
      } else {
        $json['success'] = false;
        $json['msg'] = "Ocurrio un problema, vuelve a intentar ";
      }
    }
  }
  echo json_encode($json);
}

if ($tipo == "variables_consulta") {
  $stado_variable = $k[1];
  $idUsuario = $k[2];
  $json = array();
  $json['success'] = false;
  $json['msg'] = "Sin Datos";
  if($stado_variable == 0){
    $sql = "SELECT * from variables where status='1'";
  }else{
    $sql = "SELECT ve.id_variable, va.nombre from vareva as ve LEFT JOIN variables as va ON ve.id_variable = va.id_variable where ve.id_usuario='$idUsuario'";
  }
  $res = $con->query($sql);
  while ($row = mysqli_fetch_array($res)) {
    $json['success'] = true;
    $json['msg'] = "Correcto ";
    $json[] = array(
  		'id_variable' => $row['id_variable'],
  		'nombre' => $row['nombre'],
  	);
  }
  echo json_encode($json);
}

if ($tipo == "variables_consulta_indi") {
  $variable = $k[1];
  $json = array();
  $json['success'] = false;
  $json['msg'] = "Sin Datos";
  $sql = "SELECT * FROM variables where id_variable='$variable'";
  $res = $con->query($sql);
  while ($row = mysqli_fetch_array($res)) {
    $json['success'] = true;
    $json['msg'] = "Correcto ";
    $json[] = array(
      'id_variable' => $row['id_variable'],
      'nombre' => $row['nombre'],
      'subti_var' => $row['subtitulo'],
      //'descripcion_var' => $row['descripcion'],
      'ejemplo' => $row['ejemplo'],
  	);
  }
  echo json_encode($json);
}

if ($tipo == "evaluacion_consulta") {
  $variable = $k[1];
  $json = array();
  $json['success'] = false;
  $json['msg'] = "Sin Datos";
  $sql = "SELECT * FROM evaluacion where id_variable='$variable' ";
  $res = $con->query($sql);
  while ($row = mysqli_fetch_array($res)) {
    $json['success'] = true;
    $json['msg'] = "Correcto ";
    $json[] = array(
      'id_evaluacion' => $row['id_evaluacion'],
      'id_variable' => $row['id_variable'],
      'pregunta' => utf8_encode($row['pregunta']),
  	);
  }
  echo json_encode($json);
}

if ($tipo == "guardar_evaluacion") {
  $variable = $k[1];
  $evaluacion = $k[2];
  $resultado = $k[3];
  $resultado2 = $k[4];
  $tipoP = $k[5];
  if($resultado2 == 'undefined'){
    $resultado2 = "0";
  }
  $idusuario = $k[6];
  if($variable == "2" || $variable == "3" || $variable == "4" || $variable == "5"){
    switch ($resultado) {
      case '0':
        $resultado = "0";
      break;
      case '1':
        $resultado = "2";
      break;
      case '2':
        $resultado = "4";
      break;
      case '3':
        $resultado = "6";
      break;
      case '4':
        $resultado = "8";
      break;
      case '5':
        $resultado = "10";
      break;
      case '6':
        $resultado = "9";
      break;
      case '7':
        $resultado = "7";
      break;
      case '8':
        $resultado = "5";
      break;
      case '9':
        $resultado = "3";
      break;
      case '10':
        $resultado = "1";
      break;
    }
    switch ($resultado2) {
      case '0':
        $resultado2 = "0";
      break;
      case '1':
        $resultado2 = "2";
      break;
      case '2':
        $resultado2 = "4";
      break;
      case '3':
        $resultado2 = "6";
      break;
      case '4':
        $resultado2 = "8";
      break;
      case '5':
        $resultado2 = "10";
      break;
      case '6':
        $resultado2 = "9";
      break;
      case '7':
        $resultado2 = "7";
      break;
      case '8':
        $resultado2 = "5";
      break;
      case '9':
        $resultado2 = "3";
      break;
      case '10':
        $resultado2 = "1";
      break;
    }
  }
  $sql    = html_entity_decode("INSERT INTO vareva (id_variable, id_eva, id_usuario, resultado, resultado2, tipoP, status, status_trabajar) VALUES('$variable','$evaluacion','$idusuario','$resultado', '$resultado2','$tipoP','1','0')");
  $res = $con->query($sql);
  $json = array();
  $json['success'] = true;
  echo json_encode($json);
}

if ($tipo == "guarda_objetivo") {
  $idusuario = $k[1];
  $objetivo = utf8_decode($k[2]);
  $obj_gen_mp = utf8_decode($k[3]);
  $obj_mp_fisico = utf8_decode($k[4]);
  $obj_mp_tec = utf8_decode($k[5]);
  $obj_mp_psi = utf8_decode($k[6]);
  $obj_lp_fisico = utf8_decode($k[7]);
  $obj_lp_tec = utf8_decode($k[8]);
  $obj_lp_psi = utf8_decode($k[9]);
  $sql    = html_entity_decode("INSERT INTO objetivo (id_usuario, objetivo, objetivo_gen_lp, objetivo_mp_fisico, objetivo_mp_tecnicos, objetivo_mp_psicologicos, objetivo_lp_fisico, objetivo_lp_tecnicos, objetivo_lp_psicologicos) VALUES('$idusuario','$objetivo','$obj_gen_mp','$obj_mp_fisico','$obj_mp_tec','$obj_mp_psi','$obj_lp_fisico','$obj_lp_tec','$obj_lp_psi')");
  $res = $con->query($sql);
  $json = array();
  $json['success'] = true;
  echo json_encode($json);
}

if ($tipo == "update_usuario_variables") {
  $idusuario = $k[1];
  $sql2 = "UPDATE users set status_variable='1' where id='$idusuario'";
  $res2 = $con->query($sql2);
  $json = array();
  $json['success'] = true;
  echo json_encode($json);
}
if ($tipo == "actualiza_variables") {
  $idVar = $k[1];
  $idVar2 = $k[2];
  $idusuario = $k[3];
  $sql = "UPDATE vareva set status_trabajar='1' where id_usuario='$idusuario' and id_variable='$idVar'";
  $res = $con->query($sql);
  $sql2 = "UPDATE vareva set status_trabajar='1' where id_usuario='$idusuario' and id_variable='$idVar2'";
  $res2 = $con->query($sql2);
  $json = array();
  $json['success'] = true;
  echo json_encode($json);
}
if ($tipo == "variables_usuario") {
  $idusuario = $k[1];
  $json = array();
  $json['success'] = false;
  $json['msg'] = "Sin Datos";
  $sql = "SELECT ve.id_variable, ve.id_eva,ve.status,ve.status_trabajar, ve.resultado, ve.resultado2, v.nombre FROM vareva as ve LEFT JOIN variables as v ON ve.id_variable = v.id_variable WHERE ve.id_usuario='$idusuario' ORDER BY ve.resultado";
  $res = $con->query($sql);
  while ($row = mysqli_fetch_array($res)) {
    $json['success'] = true;
    $json['msg'] = "Correcto ";
    $json[] = array(
      'id_variable' => $row['id_variable'],
      'id_evaluacion' => $row['id_eva'],
      'status' => $row['status'],
      'status_trabajar' => $row['status_trabajar'],
      'resultado' => $row['resultado'],
      'resultado2' => $row['resultado2'],
      'nombre' => $row['nombre'],
  	);
  }
  echo json_encode($json);
}
if ($tipo == "actividad_individual") {
  $idvariable = $k[1];
  $json = array();
  $json['success'] = false;
  $json['msg'] = "realiza una actividad por dia";
  //$sql = "SELECT ac.*, v.nombre as nombre_variable FROM actividad as ac LEFT JOIN variables as v ON ac.id_variable = v.id_variable WHERE ac.id_variable='$idvariable'";
if($idvariable == "3"){
  $sql = "SELECT v.nombre,i.id_instrucciones ,i.descripcion FROM instrucciones as i LEFT JOIN actividad as a ON a.id_actividad=i.id_actividad LEFT JOIN variables as v ON v.id_variable=a.id_variable WHERE a.id_variable='$idvariable' OR a.id_variable= 9 OR a.id_variable= 10";
}else{
    $sql = "SELECT v.nombre,i.id_instrucciones ,i.descripcion FROM instrucciones as i LEFT JOIN actividad as a ON a.id_actividad=i.id_actividad LEFT JOIN variables as v ON v.id_variable=a.id_variable WHERE a.id_variable='$idvariable'";
}

  $res = $con->query($sql);
  while ($row = mysqli_fetch_array($res)) {
    $json['success'] = true;
    $json['msg'] = "Correcto ";
    $json[] = array(
      'id_instrucciones' => $row['id_instrucciones'],
      'descripcion' => utf8_encode($row['descripcion']),
      'nombre_variable' => utf8_encode($row['nombre']),
  	);
  }
  echo json_encode($json);
}
if ($tipo == "actividad_instruccion") {
  $idactividad = $k[1];
  $idusuario = $k[2];
  $idvariable = $k[3];
  $json = array();
  $json['success'] = false;
  $json['msg'] = "Sin Datos";
  $sql = "SELECT * FROM instrucciones WHERE id_instrucciones='$idactividad'";
  $res = $con->query($sql);
  while ($row = mysqli_fetch_array($res)) {
    $json['success'] = true;
    $json['msg'] = "Correcto ";
    $json[] = array(
      'id_instrucciones' => $row['id_instrucciones'],
      'descripcion' => utf8_encode($row['descripcion']),
      'audio' => $row['audio'],
  	);
  }
  $sql2 = "SELECT fecha_actividad FROM vareva WHERE id_variable='$idvariable' AND id_usuario='$idusuario'";
  $res2 = $con->query($sql2);
  while ($row2 = mysqli_fetch_array($res2)) {
    if($row2['fecha_actividad'] == NULL){
        $fechaActual = date("Y-m-d");
        $sql3 = "UPDATE vareva set fecha_actividad='$fechaActual' where id_variable='$idvariable' AND id_usuario='$idusuario'";
        $result3 = $con->query($sql3);
        if ($con->query($sql3) === TRUE) {
            //echo "update";
        }
    }
  }
  echo json_encode($json);
}

if ($tipo == "resultados_evaluacion") {
  $id_usuario = $k[1];
  $json = array();
  $json['success'] = false;
  $json['msg'] = "Sin Datos";
  $sql = "SELECT eva.pregunta, vari.nombre as variname, vare.id_variable, vare.resultado, vare.resultado2, us.nombre, us.app, us.apm, us.edad, us.ciudad, us.fecha_nacimiento, us.posicion, us.genero FROM users as us LEFT JOIN vareva as vare ON vare.id_usuario = us.id LEFT JOIN variables as vari ON vari.id_variable = vare.id_variable LEFT JOIN evaluacion as eva ON eva.id_variable = vari.id_variable WHERE us.id='$id_usuario'";
  //$sql = "SELECT eva.pregunta, vari.nombre as variname, vare.id_variable, vare.resultado, vare.resultado2, us.nombre, us.app, us.apm, us.edad, us.ciudad, us.fecha_nacimiento, us.posicion, us.genero FROM evaluacion as eva LEFT JOIN variables as vari ON eva.id_variable = vari.id_variable LEFT JOIN vareva as vare ON vare.id_variable = vari.id_variable LEFT JOIN users as us ON vare.id_usuario = us.id WHERE vare.id_usuario='$id_usuario'";
  $res = $con->query($sql);
    $json['success'] = true;
    while ($row = mysqli_fetch_array($res)) {
    $json['msg'] = "Correcto ";
    $json[] = array(
      'id_variable' => $row['id_variable'],
      'variable' => utf8_encode($row['variname']),
      'pregunta' => utf8_encode($row['pregunta']),
      'resultado' => $row['resultado'],
      'resultado2' => $row['resultado2'],
      'nombre' => $row['nombre'],
      'app' => $row['app'],
      'apm' => $row['apm'],
      'edad' => $row['edad'],
      'ciudad' => $row['ciudad'],
      'fecha_nacimiento' => $row['fecha_nacimiento'],
      'posicion' => $row['posicion'],
      'genero' => $row['genero'],

  	);
  }
  echo json_encode($json);
}

if ($tipo == "resultados_objetivos") {
  $id_usuario = $k[1];
  $json = array();
  $json['success'] = false;
  $json['msg'] = "Sin Datos";
  $sql = "SELECT * FROM objetivo WHERE id_usuario='$id_usuario'";
  $res = $con->query($sql);
  while ($row = mysqli_fetch_array($res)) {
    $json['success'] = true;
    $json['msg'] = "Correcto ";
    $json[] = array(
      'objetivo' => $row['objetivo'],
      'objetivo_gen_lp' => $row['objetivo_gen_lp'],
      'objetivo_mp_fisico' => $row['objetivo_mp_fisico'],
      'objetivo_mp_tecnicos' => $row['objetivo_mp_tecnicos'],
      'objetivo_mp_psicologicos' => $row['objetivo_mp_psicologicos'],
      'objetivo_lp_fisico' => $row['objetivo_lp_fisico'],
      'objetivo_lp_psicologicos' => $row['objetivo_lp_psicologicos'],
      'objetivo_lp_tecnicos' => $row['objetivo_lp_tecnicos'],
      'status' => $row['status']
  	);
  }
  echo json_encode($json);
}
if ($tipo == "guarda_equipo") {
  $id_usuario = $k[1];
  $nombreEq = utf8_decode($k[2]);
  $nombreDT = utf8_decode($k[3]);
  $liga = utf8_decode($k[4]);
  $numeroJugadores = $k[5];
  $imgEq = $k[6];
  $json = array();
  $json['success'] = false;
  $json['msg'] = "Sin Datos";
  $digits = 4;
  $codigo = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
  $sql    = html_entity_decode("INSERT INTO equipos (id_jugador,nombre_equipo,nombre_entrenador,liga,numero_jugadores,codigo,imagenEquipo) VALUES('$id_usuario','$nombreEq','$nombreDT','$liga','$numeroJugadores','$codigo','base64_decode($imgEq)')");
  //$result = $con->query($sql);
    if ($con->query($sql) === TRUE) {
      
      $json['msg'] = $codigo;
  		//ZAZ
      	$sql2 = "SELECT * FROM equipos WHERE codigo='$codigo'";
    	$res2 = $con->query($sql2);
    	while ($row2 = mysqli_fetch_array($res2)) {
  			$idEquipo = $row2['id_equipo'];
  			$sql3 = "UPDATE users set id_grupo='$idEquipo' WHERE id='$id_usuario'";
	  		//$result2 = $con->query($sql2);
	    	if ($con->query($sql3) === TRUE) {
	    		$json['success'] = true;		
	    	}	
  		}
  		    
    } else {
      $json['success'] = false;
      $json['msg'] = "Ocurrio un problema, vuelve a intentar ";
    }
  echo json_encode($json);
}
if ($tipo == "consulta_equipo") {
  $id_usuario = $k[1];
  $json = array();
  $jsonJg = array();
  $json['success'] = false;
  $json['msg'] = "Sin Datos";
  $sql    = "SELECT id_grupo FROM users WHERE id='$id_usuario' AND id_grupo != 0";
  $res = $con->query($sql);
  while ($row = mysqli_fetch_array($res)) {
  	$json['success'] = true;
    $json['msg'] = "Se encontro información relacionada a tu Equipo";
    $id_equipo = $row['id_grupo'];
    $sql2 = "SELECT * FROM equipos WHERE id_equipo='$id_equipo'";
    $res2 = $con->query($sql2);
    while ($row2 = mysqli_fetch_array($res2)) {
    	$json['equipo'] = array(
    	  'id_equipo' => $row2['id_equipo'],	
	      'nombre_equipo' => utf8_decode($row2['nombre_equipo']),
	      'nombre_entrenador' => utf8_decode($row2['nombre_entrenador']),
	      'liga' => utf8_decode($row2['liga']),
	      'numero_jugadores' => $row2['numero_jugadores'],
	      'codigo' => $row2['codigo'],
	      'imagenEquipo' => base64_encode($row2['imagenEquipo'])
	  	);
    }
    /**/
  }
  
  $sql3 = "SELECT u.nombre, eu.id_jugador FROM equipo_usuarios as eu JOIN users as u ON u.id=eu.id_jugador WHERE eu.id_equipo = '$id_equipo'";
    $res3 = $con->query($sql3);
  	while ($row3 = mysqli_fetch_array($res3)) {
  		$jsonJg[] = array(
	      'nombre_jugador' => utf8_decode($row3['nombre']),
	      'id_jugador' => $row3['id_jugador']
	  	);
  	}
  	$json['jugadores'] = $jsonJg;
  echo json_encode($json);
}

if ($tipo == "equipo_estadisticas") {
	$tipo_estadistica = $k[1];
	$equipo = $k[2];
	$json = array();
	$json['success'] = false;
	$json['msg'] = "Sin Datos";
	$sql = "SELECT * FROM equipo_usuarios WHERE id_equipo='$equipo'";
	$res = $con->query($sql);
	while ($row = mysqli_fetch_array($res)) {
		$id_usuario = $row['id_jugador'];		
		$json['success'] = true;
		$json['msg'] = "Datos";
		$sql2 = "SELECT * FROM vareva WHERE id_usuario='$id_usuario'";
		$res2 = $con->query($sql2);
		while ($row2 = mysqli_fetch_array($res2)) {
			$json[] = array(
	      		'id_usuario' => $row2['id_usuario'],
	      		'id_variable' => $row2['id_variable'],
	      		'resultado' => $row2['resultado'],
	      		'resultado2' => $row2['resultado2'],
	  		);
		}
	}
	echo json_encode($json);
}
//VIDEOS RV
if ($tipo == "consulta_vr") {
  $json = array();
  $json['success'] = false;
  $json['msg'] = "Sin Datos";
  $sql = "SELECT * FROM realidad_virtual WHERE status_video=1";
  $res = $con->query($sql);
  while ($row = mysqli_fetch_array($res)) {
    $json['success'] = success;
      $json[] = array(
            'id_video' => $row['id_video'],
            'descripcion' => $row['descripcion'],
            'url_video' => $row['url_video'],
            'status_video' => $row['status_video'],
        );
  }
  echo json_encode($json);
}

//Enviar Notificacion
if ($tipo == 'recibir_msj') {
    $tip = security($_POST['type']);
    $tit = security($_POST['titulo']);
    $nd  = security($_POST['dest']);
    $app = security($_POST['app']);
    //$tapp==security($_POST['dest']);
    if ($tip == "G") {
        $dest = security($_POST['grupo']);
    } elseif ($tip == "P") {
        $dest = security($_POST['plata']);
    } elseif ($tip == "U") {
        $dest = security($_POST['dest']);
    } else {
        $dest = security($_POST['group1']);
    }
    //$destino=$dest;
    $msj = security($_POST['mensaje']);
    $msj = html_entity_decode($msj);

    if (!empty($tip) && !empty($tit) && !empty($msj)) {
        //$dest = 'pruebarevW';
        if ($tip == "G") {
            enviagcm($tip, $tit, $msj, $dest);
            echo "Mensaje Enviado|" . $tip . "|" . $tit . "|" . $msj . "|" . $dest . "|" . $tip . "|" . $reid;
        } else {
            enviagcm($tip, $tit, $msj, $dest, "", $app);
            echo "Resp|" . $tip . "|" . $tit . "|" . $msj . "|" . $nd . "|" . $dest;
        }
    } else {echo "E|faltan datos|" . $tip . "|" . $tit . "|" . $msj . "|" . $nd;}

}
