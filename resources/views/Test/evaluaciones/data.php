<?php
/*
 **NERÛ
 */
session_start();
//include 'conexion.php';
$us = "resoluci_tec";
$pw = "2491miguel";
$ser = "162.241.2.36";
$db = "resoluci_neruapp";
$con = new mysqli($ser, $us, $pw, $db);
//recupero datos
$x         = $_POST["datos"];
$k         = explode(",", $x);
$tipo      = $k[0];
//Iniciar Sesión
if ($tipo == "iniciar_sesion") {
  $usuario = strtolower($k[1]);
  $password = password_hash($k[2], PASSWORD_DEFAULT);
  $sql    = "SELECT id, id_grupo, activo, stado_pago, status_variable from users where username='$usuario'";
  $res = $con->query($sql);
  $json = array();
  $json['success'] = false;
  $json['msg'] = "Usuario no valido";
  while ($row = mysqli_fetch_array($res)) {
    $json['success'] = true;
    $json['msg'] = "Bienvenido ".$usuario;
    $json[] = array(
      'id' => $row['id'],
      'id_grupo' => $row['id_grupo'],
  		'activo' => $row['activo'],
      'stado_pago' => $row['stado_pago'],
      'status_variable' => $row['status_variable'],
  	);
  }
  echo json_encode($json);
}
//Prueba
if ($tipo == "add") {
  $nombre = $k[1];
  $app = $k[2];
  $apm = $k[3];
  $usuario = $k[4];
  $password = password_hash($k[5], PASSWORD_DEFAULT);
  $email = $k[6];
  $sql    = html_entity_decode("INSERT INTO resoluci_neruapp.users (nombre,app,apm,username,email,password) VALUES('$nombre','$app','$apm','$usuario','$email','$password')");
  $res = $con->query($sql);
  $json = array();
  /*while ($row = mysqli_fetch_array($res)) {
  	$json[] = array(
  		'nombre' => $row['nombre'],
  		'username' => $row['username'],
  	);
  }*/

  $json['success'] = true;
  echo json_encode($json);
}
//Update PASSWORD_DEFAULTif ($tipo == "add") {
if ($tipo == "update_pass") {
  $email = $k[1];
  $password = password_hash($k[2], PASSWORD_DEFAULT);
  $sql    = "SELECT email, password from resoluci_neruapp.users where email='$email'";
  $res = $con->query($sql);
  $json = array();
  $json['success'] = false;
  $json['msg'] = "Email no valido";
  while ($row = mysqli_fetch_array($res)) {
  	if($password == $row['password']){
      $json['success'] = false;
      $json['msg'] = "Contraseña anterior, ingrese una nueva";
    }else if($password != $row['password']){
      $sql2 = "UPDATE resoluci_neruapp.users set password='$password' where email='$email'";
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
    $sql = "SELECT id_variable, nombre from variables where status='1'";
  }else{
    $sql = "SELECT ve.id_variable, va.nombre from vareva LEFT JOIN variables as va ON ve.id_variable = va.id_variable where ve.id_usuario='$idUsuario'";
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
