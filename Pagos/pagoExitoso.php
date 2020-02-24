<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        #pelota {
  position: absolute;
  animation: rebota 1s alternate infinite ease-out;
}

@-webkit-keyframes rebota {
  0% {
    top: 580px;
    height: 50px;
  }
  10% {
    top: 540px;
    height: 100px;
  }
  100% {
    top: 280px;
    height: 100px;
  }
}
body{
  background: url('img/banner.png') no-repeat fixed center;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  height: 100%;
  width: 100%;
  color:white; 
}
#text-leyenda{
    margin-top:2%;
    color:white;
    font-weight:bold;
    text-transform:uppercase;
    font-size:24px;
}
@media screen and (max-width: 800px) {
    #pelota{
        margin-left:35%;
    }
    #logo{
        width:250px;
        height:200px;
        margin-left:20%;
    }
    #menuHome{
        margin-left:30%;
    }
    #text-leyenda{
        font-size:12px;
        text-align:center;
    }
    .link_c{
        background:red;
        color:white;
    }
}
    </style>
    <title>NERU APP</title>
</head>
<body>
    <div class="container text-center" id="page-principal"> 
        <div class="row">
            <div class="col-xs-12">
                <img src="img/balon.png" alt="" height="50px" width="100px" id="pelota">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <img src="img/logo_neru.png" alt="" height="300px" width="400px" id="logo">
            </div>
        </div>
        <div class="row" id="text-leyenda">
            <label>Solo abre la aplicación en el home y podras acceder a tus secciones
            <br/>Tu pago se realizó con éxito</label>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <img src="img/menu_home.png" alt="" height="350px" width="200px" id="menuHome">
            </div>
        </div>
        <div style="margin-top:5%">
            <a href="https://www.nerupsicologia.com/oficial/" class="btn btn-alert link_c">Continuar</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    
</body>
</html>