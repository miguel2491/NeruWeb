//se recogen los valores de la transaccion

var folio = document.getElementById("folio").value;
var estado = document.getElementById("estado").value;
var correo = document.getElementById("correo").value;
var id = "";
var usuario_mail = "";
var iterar = 0;
//se cambia el valor del estado de pago 
if (estado == "approved" || estado == "aprobado") {
    $("#estado").val("1");
    get_mail();
} else
    $("#estado").val("0");

//buscar email de pago en bdd


function get_mail() {
    var email = document.getElementById("correo").value;
    $.ajax({
        url: $('#buscar').val() + '/' + email,
        type: 'GET',
        data: '',
        success: function(data) {
            var obj = data;
            if (obj == null || obj == 'undefined' || obj == '') {
                $("#email2").val('');
                document.getElementById("primera").style.display = 'block';
                document.getElementById("segunda").style.display = 'none';
                iterar = iterar + 1;
                mostrar();

            } else {
                id = obj[0].id;
                usuario_mail = obj[0].email;
                if (email == usuario_mail) {
                    //llamar función update
                    update();
                }
            }
        }


    });

}
//muestra form para ingresar correo neru
function mostrar() {
    document.getElementById("form").style.display = 'block';
}

//valida boton aceptar form
$('#validar').click(function() {

    var msg = '';

    get_mail2();
});
//realiza la busqueda del email
function get_mail2() {
    var email = document.getElementById("email2").value;

    $.ajax({
        url: $('#buscar').val() + '/' + email,
        type: 'GET',
        data: '',
        success: function(data) {
            var obj = data;
            //var array = $.parseJSON(data);
            if (obj == null || obj == 'undefined' || obj == '') {
                if (iterar > 1) {
                    $("#email2").val("");
                    document.getElementById("primera").style.display = 'none';
                    document.getElementById("segunda").style.display = 'block';
                    mostrar();
                }
                //
            } else {
                id = obj[0].id;
                usuario_mail = obj[0].email;
                if (email == usuario_mail) {
                    //llamar función update
                    update();
                }
            }
        }


    });

}

//funcion actualizar
function update() {

    var msg = '';
    var get_url = $("#url_actualizar").val() + '/' + id;
    var type_method = 'PUT';
    data_request = {
        stado_pago: $('#estado').val(),
        folio_pago: $('#folio').val(),
    }
    console.log(data_request);
    $.ajax({
        url: get_url,
        type: type_method,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
        },
        data: data_request,
        success: function(data) {
            if (data.status == 'fail') {

                toastr.error(data.message);

                setTimeout("redireccionar()", 5000); //tiempo expresado en milisegundos
            } else {
                toastr.success(data.message);
                setTimeout(function() {
                    window.location.href = "http://nerupsicologia.com/app/public/home";
                }, 5000);

            }
        },

        error: function(jqXHR, textStatus, errorThrown) {
            var data = JSON.parse(jqXHR.responseText);

            if (jqXHR.status == 400) {
                toastr.error('', data.message);
            }

            if (jqXHR.status == 401) {
                location.reload();
            }

            if (jqXHR.status == 422) {
                $.each(data.errors, function(key, value) {
                    if (msg == '') {
                        msg = value[0] + '<br>';
                    } else {
                        msg += value[0] + '<br>';
                    }

                });

                toastr.error(msg);
            }
        }
    });
}