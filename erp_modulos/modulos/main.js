$(document).ready(function () {
    var obj = {};
    
    //Previene cerrar el modal con tecla Enter
    $("#modalModulos").keydown(function (e) {
        let keycode = e.which;
        if (keycode == 13) {
            e.preventDefault();
            return false;
        }
    });

    //Accion de boton para insertar en la vista
    $("#btn-new").click(function () {
        obj = {
            accion: "insertModulo"
        };
        $("#btn-form").text("Insertar");
        $("#exampleModalLabel").text("Insertar Módulo");
        $("#modulos-form")[0].reset();
    });

    //Accion de boton editar 
    $(".btn-edit").click(function () {
        let id = $(this).attr("data");
        obj = {
            accion: "getModulo",
            modulo: id
        };
        $.post("consultas.php", obj, function (respuesta) {
            // console.log(respuesta.id);
            $(".nombre_modulo").val(respuesta.nombre_modulo);
            $("#icono_modulo").val(respuesta.icono_modulo);
            obj = {
                accion: "updateModulo",
                modulo: id
            };
        }, "JSON");
        $("#btn-form").text("Editar");
        $("#exampleModalLabel").text("Editar Módulo");
        $("#modulos-form")[0].reset();
    });

    //Accion de boton Eliminar
    $(".btn-delete").click(function () {
        let id_modulo = $(this).attr("data");
        obj = {
            accion: "deleteModulo",
            modulo: id_modulo
        };
        swal({
            title: "¿Estás seguro?",
            text: "El modulo será eliminado",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(willDelete => {
            if (willDelete) {
                $.post("consultas.php", obj, function (respuesta) {
                    if (respuesta.status == 1) {
                        swal("Éxito", "Módulo eliminado correctamente", "success").then((willDelete) => {
                            location.reload();
                        });
                        // location.reload();
                    } else {
                        swal({
                            title: 'Oops...',
                            text: '¡Algo salió mal!',
                            icon: "error",
                        });
                    }
                }, "JSON");
            }
        });
    });

    //Accion de boton dentro de modal, dependiendo si es Editar o Insertar
    $("#btn-form").click(function (e) {
        
        $("#modulos-form").find("input").map(function (i, e) {
            obj[$(this).prop("name")] = $(this).val();
        });
        $("#modulos-form").find("select").map(function (i, e) {
                obj[e.name] = $(this).val();
            });
        switch (obj.accion) {
            case "insertModulo":
                $.post("consultas.php", obj, function (respuesta) {
                    if (respuesta.status == 0) {
                        swal("¡ERROR!", "Campos vacios", "error");
                        // console.log('eeeeeeeeeeeee');
                    } else if (respuesta.status == 1) {
                        // console.log('nuevo');
                        swal("Éxito", "Módulo añadido correctamente", "success").then(() => {
                            location.reload();
                        });
                    } else {
                        swal({
                            title: 'Oops...',
                            text: '¡Algo salió mal!',
                            icon: "error",
                        });
                    }
                }, "JSON");
                break;
            case "updateModulo":
                $.post("consultas.php", obj, function (respuesta) {

                    if (respuesta.status == 0) {
                        swal("¡ERROR!", "Campos vacios", "error");
                    } else if (respuesta.status == 1) {
                        swal("Éxito", "Módulo editado correctamente", "success").then(() => {
                            location.reload();
                            // $(location).attr('href','index.php'); 
                        });
                    } else {
                        swal({
                            title: 'Oops...',
                            text: '¡Algo salió mal!',
                            icon: "error",
                        });
                    }
                }, "JSON");
                break;

            default:
                break;
        }
    });

});