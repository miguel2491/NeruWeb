
<?php

$id=$_GET['collection_id'];

echo"Este es el id de transacción".$id;


if(isset($_GET['id'])) {
    // id index exists
    $url = 'https://api.mercadopago.com/v1/payments/search?id='.$id.'&access_token=APP_USR-104262097525406-121106-97d90022f6c0f656c2f1be7c476f7b55-499279878';
    $crad=json_decode(file_get_contents($url),true);

    echo 'Este es el id de transacción '.$id;
    var_dump($crad['results'][0]['status']);
}
echo'Estatus existoso'.$crad;

?>