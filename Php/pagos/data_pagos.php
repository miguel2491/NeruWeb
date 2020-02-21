<?php 
    //id de prueba
        //exitoso
        //$id="5960809230"; 
        //rechazado
        //$id=" 5960795785"; 
        $id=$_GET['collection_id'];//el folio se obtiene con un get
        //$status=$_GET['collection_status'];
        //url de consulta info id

        $url='https://api.mercadopago.com/v1/payments/search?id='.$id.'&access_token=APP_USR-7626992358892349-011717-eca4e780bea376ff5859b1ac90ab739a-331107277';
        $array=json_decode(file_get_contents($url),true);
        //se extraen los valores status, folio y mail del cliente
        $status=$array['results'][0]['status'];
        $cantidad=$array['results'][0]['transaction_details']['total_paid_amount'];
        $mail=$array['results'][0]['payer']['email'];
 
        //se valida el status de pago
        
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

        //$fecha=$fecha." ".$hora;
        

        if($status=="approved" || $status=="aprobado"){
            //si es positivo se cambia el valor de estaus
            $status="1";
            actualizar_pagos($status,$mail,$id,$cantidad,$fecha);
            //se valida que el mail del pago sea igual que el de la bdd
            
        }
        else {
            //en caso del que pago no sea aprobado se actualiza el estus y el registro en al bdd
            $status="0";
            echo '<script language="javascript">alert("Tu pago fue rechado o esta en proceso. Intentelo más tarde.");</script>';
            insert($id,$cantidad,$fecha,$status,$mail);
        }
        
        

        function actualizar_pagos($status,$mail,$id,$cantidad,$fecha){
            $valor_busqueda=validar($mail);
            if ($valor_busqueda==true) {
                insert($id,$cantidad,$fecha,$status,$mail);
            }
            else{
                form_data($status,$id,$cantidad,$fecha);
            }
        }

        

        function form_data($status,$id,$cantidad,$fecha){
            ?>

                    <body style="background-color: red;">
                        <div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="text-align: center;">
                            <div class="modal-dialog modal-dialog-centered " role="document">
                                <div class="modal-content ">
                                    <div class="modal-header text-center">
                                        <h5 class="modal-title " id="exampleModalCenterTitle">El correo de pago no coincide con nuestros registros.</h5>

                                    </div>
                                    <div class="modal-body">

                                        <form action="data_modal.php" method="POST" >
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">Introduce tu correo de NERU</label>
                                                <input type="email" class="form-control" id="re_correo" name="re_correo" placeholder="tucorreoelectrónico@server.com">
                                                <input type="hidden" class="form-control" id="id" name="id" value='<?php echo $id;?>'>
                                                <input type="hidden" class="form-control" id="estatus" name="estatus" value='<?php echo $status;?>'>
                                                <input type="hidden" class="form-control" id="monto" name="monto" value='<?php echo $cantidad;?>'>' 
                                                <input type="hidden" class="form-control" id="fecha" name="fecha" value='<?php echo $fecha;?>'>'                                           
                                                <hr>
                                                <button type="submit" class="btn btn-danger" name="aceptar">Aceptar</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal" name="Cancelar">Cancelar</button>
                                        
                                            </div>
                                            
                                        </form>
                                    </div>
                                    <div class="modal-footer " >
                                        <div class="col">
                                           
                                        </div>
                                        <div class="col">
                                            
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </body>
                    

                <?php

        }

    //funcion actualizar pago
    function update_pago($status,$id,$mail){
        //tal vez tengas que modificar los datos de la bdd
        $us = "wwwnerup_app";
        $pw = "U1y(T&ZW%urJ";
        $ser = "localhost";
        $db = "wwwnerup_neruapp";
        $con = new mysqli($ser, $us, $pw, $db);

        $con = new mysqli($ser, $us, $pw, $db);

        $url='https://api.mercadopago.com/v1/payments/search?id='.$id.'&access_token=APP_USR-7626992358892349-011717-eca4e780bea376ff5859b1ac90ab739a-331107277';
        $array=json_decode(file_get_contents($url),true);
        //se extraen los valores status, folio y mail del cliente
        $status=$array['results'][0]['status'];
        $cantidad=$array['results'][0]['transaction_details']['total_paid_amount'];
        $mail=$array['results'][0]['payer']['email'];

        if($status=="approved" || $status=="aprobado")
            $status="1";
        else{
            $status="0";
            $id="";
        }
          
        $sql2="UPDATE users SET stado_pago = '$status', folio_pago = '$id' WHERE users.email = '$mail'";
        if (!$resultado = $con->query($sql2)) {
            echo "Error: La ejecución de la consulta falló debido a: \n";
            echo "Query: " . $sql2 . "\n";
            echo "Errno: " . $con->errno . "\n";
            echo "Error: " . $con->error . "\n";
            exit;
        }
        else {
            
            echo '<script language="javascript">alert("Cuenta actualizado. Regresa a NeruApp y entra a Menú");</script>';
            header("Location: https://www.nerupsicologia.com/oficial/");
        }
    }

    //funcion inserta tabla pagos
    function insert($id,$cantidad,$fecha,$status,$mail){
        $us = "wwwnerup_app";
        $pw = "U1y(T&ZW%urJ";
        $ser = "localhost";
        $db = "wwwnerup_neruapp";
        $con = new mysqli($ser, $us, $pw, $db);

        $con = new mysqli($ser, $us, $pw, $db);

        if($mail=="")
            $mail="Pago rechazado";

        if($cantidad=="")
            $cantidad="0";
        $sql3="INSERT INTO pagos (id_pago, monto, fecha_pago, estatus,correo) VALUES ('$id', '$cantidad', '$fecha', '$status', '$mail')"; 
        if (!$resultado = $con->query($sql3)) {
            echo "Error: La ejecución de la consulta falló debido a: \n";
            echo "Query: " . $sql3 . "\n";
            echo "Errno: " . $con->errno . "\n";
            echo "Error: " . $con->error . "\n";
            exit;
        }
        else {
            update_pago($status,$id,$mail);
            
        }

    }
    //valida el correo de pago con el de la bdd
    function validar($mail){
        //datos de conexión
        $us = "wwwnerup_app";
        $pw = "U1y(T&ZW%urJ";
        $ser = "localhost";
        $db = "wwwnerup_neruapp";
        $con = new mysqli($ser, $us, $pw, $db);
       
        //validamos que no haya error en la conexion
        if ($con->connect_errno) {
            echo "Error: Fallo al conectarse a MySQL debido a: \n";
            echo "Errno: " . $con->connect_errno . "\n";
            echo "Error: " . $con->connect_error . "\n";
        }
        else {
            //
            // $mail="susylaonda94@gmail.com";correo de prueba bdd
            //el mail de pago se busca en la bdd
            $sql = "SELECT * from users where email='$mail'";
            //se valida que no haya errores en la consulta
            if (!$resultado = $con->query($sql)) {
                echo "Error: La ejecución de la consulta falló debido a: \n";
                echo "Query: " . $sql . "\n";
                echo "Errno: " . $con->errno . "\n";
                echo "Error: " . $con->error . "\n";
                
            }
            else {
                //si el mail no existe en la bdd se solicita que ingrese el correo de logue de neru
                //el form esta en obra negra
                if ($resultado->num_rows === 0) {
                    return false;
                }
                else {
                    return true;
                    //si los correos coinciden se actualiza la base
                }
            }
        }
    }



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
</head>



</html>

<script>
    $(document).ready(function() {
        $("#exampleModalCenter").modal("show");
    });

    

    
</script>
