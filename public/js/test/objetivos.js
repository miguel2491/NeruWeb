$(document).ready(function() {
    var dataTable_datos;
    var id = 0;
    var bt_tooltip;
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    setTimeout(function() {
        $('.tooltips').tooltip();
    }, 2000);
    toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        positionClass: "toast-top-full-width",
        timeOut: 3000
    };

    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    dataTable_datos =
        $("#table-datos").dataTable({
            "bDeferRender": true,
            "iDisplayLength": 10,
            "bProcessing": true,
            "sAjaxSource": $('#url_listado').val(),
            "fnServerData": function(sSource, aoData, fnCallback, oSettings) {
                oSettings.jqXHR = $.ajax({
                    "dataType": 'json',
                    "type": "GET",
                    "url": sSource,
                    "success": fnCallback,
                    "error": function(jqXHR, textStatus, errorThrown) {
                        var data = jqXHR.responseJSON;
                        /*
                        if (jqXHR.status == 401 || jqXHR.status == 500) {
                            location.reload();
                        }*/
                    }
                });
            },
            "bAutoWidth": false,
            //"bFilter": false,
            "aoColumns": [{
                "mData": "id_objetivo"
            },{
                "mData": "usuario",
                "bSortable": true,
                "mRender": function(data, type, full) {
                    var usuario = full.nombre;
                    return usuario;
                }
            },{
                "mData": "objetivo",
                "bSortable": true,
                "mRender": function(data, type, full) {
                    var objetivo = full.objetivo;
                    return objetivo;
                }
            },{
                "mData": "status",
                "bSortable": true,
                "mRender": function(data, type, full) {
                  var Activo = full.status == 1 ? '<i class="fa fa-check text-navy"></i>' : '<i class="fa fa-times text-navy"></i>';
                  return Activo;
                }
            }, {
                "mData": "Acciones",
                "bSortable": false,
                "mRender": function(data, type, full) {
                    var bttnDelete = '<button class="btn btn-danger btn-xs" id="bttn_modal_delete" data-id="' + full.id_objetivo + '" data-target="#modal_delete"  data-toggle="modal" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></button>';
                    var bttnUpdate = '<button class="btn btn-warning btn-xs" id="bttn_modal_update"  data-id="' + full.id_actividad + '"  data-target="#ModalSave" data-toggle="modal" title="Editar"><i class="glyphicon glyphicon-edit"></i></button> ';
                    return bttnDelete;
                }
            }, ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $("td:eq(0), td:eq(2)", nRow).attr('align', 'center');
            },
            "aLengthMenu": [
                [5, 10, -1],
                [5, 10, "Todo"]
            ],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Registros del _START_ al _END_  total: _TOTAL_ ",
                "sInfoEmpty": "Sin registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

    $('#ModalSave').on('shown.bs.modal', function() {
        $(this).find('[autofocus]').focus();
    });
    $("#ModalSave").on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        id = typeof button.data('id') != "undefined" ? button.data('id') : 0;
        if (id != 0) {
            $.ajax({
                url: $('#url_datosget').val() + '/' + id,
                type: 'GET',
                data: '',
                success: function(data) {
                    var obj = data;
                    $('#variable_actividad').val(obj.id_variable).change();
                    $('#id_actividad').val(obj.id_actividad);
                    $('#descripcion_actividad').val(obj.descripcion);
                    $('#resultado_valor').val(obj.valor_resultado);
                    $('#duracion_actividad').val(obj.duracion);
                    $("input[name=activo_actividad]").iCheck(obj.status == 1 ? 'check' : 'uncheck');
                }

            });
        }

    });
    $("#modal_delete").on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        id = typeof button.data('id') != "undefined" ? button.data('id') : 0;
    });
    $('#ModalSave').on('show.bs.modal', function(e) {
        $('#variable_actividad').val("");
        $("input[name=active]").iCheck('uncheck');
    });
    $('#saveform').click(function() {
        var msg = '';
        var get_url = id == 0 ? $("#url_guardar").val() : $("#url_actualizar").val() + '/' + id;
        var type_method = id == 0 ? 'POST' : 'PUT';
        data_request = {
            id_actividad: id,
            id_variable: $('#variable_actividad option:selected').val() == undefined ? '0' : $('#variable_actividad option:selected').val(),
            descripcion: $('#descripcion_actividad').val(),
            valor_resultado: $('#resultado_valor').val(),
            duracion: $('#duracion_actividad').val(),
            status: $('input:checkbox[name=activo_actividad]:checked').val() == undefined ? 0 : 1,
        }

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
                } else {
                    toastr.success(data.message);
                    dataTable_datos._fnAjaxUpdate();
                    $("#ModalSave").modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
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
    });
    $('#btn_eliminar').click(function() {
        //var id = $('#delpoliza').val();

        $.ajax({
            url: $("#url_eliminar").val() + '/' + id,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
            },
            dataType: 'json',
            success: function(data) {
                if (data.status == 'fail') {
                    toastr.error(data.message);
                } else {
                    dataTable_datos._fnAjaxUpdate();
                }

                $("#modal_delete").modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var data = JSON.parse(jqXHR.responseText);
                if (jqXHR.status == 400) {
                    toastr.error('', data.message);
                }

                if (jqXHR.status == 401) {
                    location.reload();
                }
            }
        });
    });

    $.ajax({
        "dataType": 'json',
        "type": "GET",
        "url": $("#url_tipo_variable").val(),
        "success": function(data) {
            var tipo_variable_actividad = data;
            var itemTipoA = [];
            tipo_variable_actividad.forEach(function(item, index) {
                itemTipoA.push({ id: item.id_variable, text: item.nombre });
            });

            $('#variable_actividad')
                .select2({
                    width: '100%',
                    data: itemTipoA,
                    placeholder: {
                        id: '-1',
                        text: 'Seleccione'
                    },
                    allowClear: true,
                });

            $('#variable_actividad').val(-1).change();
        },
        "error": function(jqXHR, textStatus, errorThrown) {
            var data = jqXHR.responseJSON;

            if (jqXHR.status == 401) {
                location.reload();
            }
        }
    });
});
