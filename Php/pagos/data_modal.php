
<?php
    //se obtienen los datos del modal
    if (isset($_GET['aceptar'])) {
        $correo=$_GET['re_correo'];
        $id=$_GET['id'];
        $status=$_GET['estatus'];
        $monto=$_GET['monto'];
        $fecha=$_GET['fecha'];
        //query de email de pago en la bdd 
       
        //efectuamos consulta
        //tal vez tengas que modificar los datos de la bdd
        $us = "wwwnerup_app";
        $pw = "U1y(T&ZW%urJ";
        $ser = "localhost";
        $db = "wwwnerup_neruapp";
        $con = new mysqli($ser, $us, $pw, $db);
        $sql    = "SELECT * FROM `users` WHERE `email` = '$correo'";
        //descartamos errores en la consulta
        if (!$resultado = $con->query($sql)) {
            echo "Error: La ejecución de la consulta falló debido a: \n";
            echo "Query: " . $sql . "\n";
            echo "Errno: " . $con->errno . "\n";
            echo "Error: " . $con->error . "\n";
            exit;
        }
        else {
            //validamos is el mail tiene coincidencias en la bdd
            if ($resultado->num_rows === 0) {
               echo '<script language="javascript">alert("Tu cuenta de correo no es correcta, Intentalo de nuevo");</script>';
            }
            else {
                //si regresa data actualizamos el estatus y la los datos en la bdd
                $status="1";
                
                update_pago($id,$mail,$status,$cantidad,$fecha);
                echo '<script language="javascript">alert("Estatus actualizado");</script>';
                
            }
           
        }
    }
    //funcion actualizar
    function update_pago($id,$mail,$status,$cantidad,$fecha){
        $us = "wwwnerup_app";
        $pw = "U1y(T&ZW%urJ";
        $ser = "localhost";
        $db = "wwwnerup_neruapp";
        $con = new mysqli($ser, $us, $pw, $db);

        $con = new mysqli($ser, $us, $pw, $db);
        $sql2="UPDATE users SET stado_pago = '$status', `folio_pago` = '$id' WHERE `users`.`email` = '$mail'";
        if (!$resultado = $con->query($sql2)) {
            echo "Error: La ejecución de la consulta falló debido a: \n";
            echo "Query: " . $sql2 . "\n";
            echo "Errno: " . $con->errno . "\n";
            echo "Error: " . $con->error . "\n";
            exit;
        }
        else {
            insert($id,$cantidad,$fecha,$status);
            
        }
    }

        //funcion inserta tabla pagos
        function insert($id,$cantidad,$fecha,$status){
            $us = "wwwnerup_app";
            $pw = "U1y(T&ZW%urJ";
            $ser = "localhost";
            $db = "wwwnerup_neruapp";
            $con = new mysqli($ser, $us, $pw, $db);
    
            $con = new mysqli($ser, $us, $pw, $db);
            $sql3="INSERT INTO pagos (id_pago, monto, fecha_pago, estatus) VALUES ('$id', '$cantidad', '$fecha', '$status')"; 
            if (!$resultado = $con->query($sql3)) {
                echo "Error: La ejecución de la consulta falló debido a: \n";
                echo "Query: " . $sql3 . "\n";
                echo "Errno: " . $con->errno . "\n";
                echo "Error: " . $con->error . "\n";
                exit;
            }
            else {
                echo '<script language="javascript">alert("Cuenta actualizado");</script>';
                header("Location: https://www.nerupsicologia.com/oficial/");
            }
    
        }

  
?>