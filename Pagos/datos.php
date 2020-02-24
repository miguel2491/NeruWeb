<?php

require '../vendor/autoload.php';

\Stripe\Stripe::setApiKey("sk_test_Cprj2qWu5JVFNiHGMeiEHYk500peF4Dv8s");
//PUBLIC-->pk_test_2PMRp2cAIBNUzKJCCA019Hht00fij5xxYk
//SECRET-->sk_test_Cprj2qWu5JVFNiHGMeiEHYk500peF4Dv8s
//APIS ACTIVAS
//public=======>pk_live_bV6udjyyYZfi6dlrt8I0XvoI000G8PJaDZ
//secret=======>sk_test_Cprj2qWu5JVFNiHGMeiEHYk500peF4Dv8s
$token = $_POST["stripeToken"];
$email  = $_POST['email'];
$hoy = getdate();
        $dia=$hoy['mday'];
        $mes=$hoy['mon'];
        $ano=$hoy['year'];
        $hr=$hoy['hours'];
        $min=$hoy['minutes'];
        $sec=$hoy['seconds'];

        if($mes>0&&$mes<10)
            $mes="0".$mes;
        if($dia>0&&$dia<10)
            $dia="0".$dia;
        if($hr>0&&$hr<10)
            $hr="0".$hr;
        if($sec>0&&$sec<10)
            $sec="0".$sec;
        if($min>0&&$min<10)
            $min="0".$min;
           
        $fecha= $ano."-".$mes."-".$dia;
        $hora= $hr.":".$min.":".$sec;
$charge = \Stripe\Charge::create([
    "amount" => 50000,
    "currency" => "mxn",
    "description" => "Pago Neru Test 1",
    "source" => $token
]); 
//Agregar Pago
$us = "wwwnerup_app";
$pw = "U1y(T&ZW%urJ";
$ser = "localhost";
$db = "wwwnerup_neruapp";
/*
$us = "root";
$pw = "";
$ser = "localhost";
$db = "db_neru";
*/
$con = new mysqli($ser, $us, $pw, $db);

$estatuss = $charge['status'] == "succeeded" ? 1:0;
$sql = html_entity_decode("INSERT INTO pagos (id_pago,monto, fecha_pago, estatus, correo) VALUES('$token',500,'$fecha',$estatuss,'$email')");
if ($con->query($sql) === TRUE) {
    $sq = "SELECT id FROM users WHERE email='$email'";
    $re = $con->query($sq);
    while ($row = mysqli_fetch_array($re)) {
        $idUsuario = $row['id'];
        $sql2 = "UPDATE users set stado_pago='1' WHERE id='$idUsuario'";
        $result = $con->query($sql2);
        if ($con->query($sql2) === TRUE) {
            $json['success'] = true;
            $json['msg'] = "Actualizaria Status de usuario correctamente";
        }
    }
}else{
    $json['success'] = false;
    $json['msg'] = "No ha ingresado un código";
}   

//*****/
header("Location: http://nerupsicologia.com/app/Pagos/pagoExitoso.php");
//echo "-->".$email."<->".$token."<---->".$charge['status']."<-------------->".json_encode($json);
?>