$(document).ready(function () {
    let obj = {};
    const input = $("#nombrePerfil");
    const checkboxConsultar = $("#consultar :input:checkbox");
    const checkboxInsertar = $("#insertar :input:checkbox");
    const checkboxEditar = $("#editar :input:checkbox");
    const checkboxEliminar = $("#eliminar :input:checkbox");

    $("#newProfile").click(function () {
        obj = {
            action: "insertProfile",
            consultar: [],
            insertar: [],
            editar: [],
            eliminar: [],
        };
        $(".modal-title").text("Nuevo Perfil");
        $("#btnInsertProfile").text("Insertar");
        $("#formProfiles")[0].reset();
    });

    $(".btnEdit").click(function () {
        $("#formProfiles")[0].reset();
        let id = $(this).attr("data");
        let resultConsultar = [];
        let resultInsertar = [];
        let resultEditar = [];
        let resultEliminar = [];
        obj = {
            action: "getProfile",
            id_perfil: id,
        };
        $.post(
            "functions.php",
            obj,
            function (res) {
                $("#nombrePerfil").val(res.nombre_perfil);

                let valuesConsultar = [];
                let consultar = res.consultar;
                checkboxConsultar.each(function (i, e) {
                    valuesConsultar.push(e.value);
                });
                resultConsultar = consultar.filter((value) => valuesConsultar.includes(value));
                resultConsultar.forEach(function (e, i) {
                    $(`#consultar-${e}`).prop("checked", true);
                });

                let valuesInsertar = [];
                let insertar = res.insertar;
                checkboxInsertar.each(function (i, e) {
                    valuesInsertar.push(e.value);
                });
                resultInsertar = insertar.filter((value) => valuesInsertar.includes(value));
                resultInsertar.forEach(function (e, i) {
                    $(`#insertar-${e}`).prop("checked", true);
                });

                let valuesEditar = [];
                let editar = res.editar;
                checkboxEditar.each(function (i, e) {
                    valuesEditar.push(e.value);
                });
                resultEditar = editar.filter((value) => valuesEditar.includes(value));
                resultEditar.forEach(function (e, i) {
                    $(`#editar-${e}`).prop("checked", true);
                });

                let valuesEliminar = [];
                let eliminar = res.eliminar;
                checkboxEliminar.each(function (i, e) {
                    valuesEliminar.push(e.value);
                });
                resultEliminar = eliminar.filter((value) => valuesEliminar.includes(value));
                resultEliminar.forEach(function (e, i) {
                    $(`#eliminar-${e}`).prop("checked", true);
                });

                obj = {
                    action: "updateProfile",
                    id_perfil: id,
                };
            },
            "JSON"
        );
        $(".modal-title").text("Editar Perfil");
        $("#btnInsertProfile").text("Editar");
    });

    $(".btnDelete").click(function () {
        let id = $(this).attr("data");
        obj = {
            action: "deleteProfile",
            id_perfil: id,
        };
        Swal.fire({
            title: "¿Estás seguro?",
            text: "No podrás revertir los cambios.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33 ",
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Eliminar",
        }).then((result) => {
            if (result.value) {
                $.post(
                    "functions.php",
                    obj,
                    function (res) {
                        if (res.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Perfil eliminado correctamente",
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    "JSON"
                );
            }
        });
    });

    $("#modalProfiles").keydown(function (e) {
        let keycode = e.which;
        if (keycode == 13) {
            e.preventDefault();
            return false;
        }
    });

    $("#btnInsertProfile").click(function () {
        obj.consultar = [];
        obj.insertar = [];
        obj.editar = [];
        obj.eliminar = [];

        obj[input.prop("name")] = input.val();

        checkboxConsultar.each(function () {
            if ($(this).prop("checked")) {
                obj.consultar.push($(this).val());
                obj.consultar = obj.consultar.slice(0, checkboxConsultar.length);
            }
        });

        checkboxInsertar.each(function () {
            if ($(this).prop("checked")) {
                obj.insertar.push($(this).val());
                obj.insertar = obj.insertar.slice(0, checkboxInsertar.length);
            }
        });

        checkboxEditar.each(function () {
            if ($(this).prop("checked")) {
                obj.editar.push($(this).val());
                obj.editar = obj.editar.slice(0, checkboxEditar.length);
            }
        });

        checkboxEliminar.each(function () {
            if ($(this).prop("checked")) {
                obj.eliminar.push($(this).val());
                obj.eliminar = obj.eliminar.slice(0, checkboxEliminar.length);
            }
        });

        let objString = JSON.stringify(obj);

        switch (obj.action) {
            case "insertProfile":
                $.ajax({
                    url: "functions.php",
                    type: "post",
                    data: {
                        obj: objString,
                        action: "insertProfile",
                    },
                    success: function (data) {
                        let json = JSON.parse(data);
                        if (json.status == 0) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Favor de ingresar el nombre del perfil.",
                            });
                        } else if (json.status == 2) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "No puedes insertar un perfil sin permisos.",
                            });
                        } else if (json.status == 3) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text:
                                    "Selecciona un modulo a consultar para poder insertar datos en el.",
                            });
                        } else if (json.status == 4) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text:
                                    "Selecciona un modulo a consultar para poder editar datos en el.",
                            });
                        } else if (json.status == 5) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text:
                                    "Selecciona un modulo a consultar para poder eliminar datos en el.",
                            });
                        } else if (json.status == 6) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text:
                                    "No puedes insertar en un modulo donde no puedas consultarlo.",
                            });
                        } else if (json.status == 7) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "No puedes editar en un modulo donde no puedas consultarlo.",
                            });
                        } else if (json.status == 8) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text:
                                    "No puedes eliminar en un modulo donde no puedas consultarlo.",
                            });
                        } else if (json.status == 9) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Este nombre de perfil ya existe.",
                            });
                        } else if (json.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Perfil ingresado correctamente",
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                });
                break;
            case "updateProfile":
                $.ajax({
                    url: "functions.php",
                    type: "post",
                    data: {
                        obj: objString,
                        action: "updateProfile",
                    },
                    success: function (data) {
                        let json = JSON.parse(data);
                        if (json.status == 0) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Favor de ingresar el nombre del perfil.",
                            });
                        } else if (json.status == 2) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "No puedes insertar un perfil sin permisos.",
                            });
                        } else if (json.status == 3) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text:
                                    "Selecciona un modulo a consultar para poder insertar datos en el.",
                            });
                        } else if (json.status == 4) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text:
                                    "Selecciona un modulo a consultar para poder editar datos en el.",
                            });
                        } else if (json.status == 5) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text:
                                    "Selecciona un modulo a consultar para poder eliminar datos en el.",
                            });
                        } else if (json.status == 6) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text:
                                    "No puedes insertar en un modulo donde no puedas consultarlo.",
                            });
                        } else if (json.status == 7) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "No puedes editar en un modulo donde no puedas consultarlo.",
                            });
                        } else if (json.status == 8) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text:
                                    "No puedes eliminar en un modulo donde no puedas consultarlo.",
                            });
                        } else if (json.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Perfil editado correctamente",
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                });
                break;
            default:
                break;
        }
    });
});
