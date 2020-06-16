$(document).ready(function () {
    var obj = {};

    $(".btnModulo").click(function (e) {
        e.preventDefault();
        console.log("hola");
    });

    $("#newUser").click(function () {
        obj = {
            action: "insertUser",
        };
        $(".modal-title").text("Nuevo Usuario");
        $("#btnInsertUser").text("Insertar");
        $("#formUsers")[0].reset();
    });

    $(".btnEdit").click(function () {
        let id = $(this).attr("data");
        obj = {
            action: "getUser",
            id_usr: id,
        };
        $.post(
            "functions.php",
            obj,
            function (res) {
                $("#nombre_usr").val(res.nombre_usr);
                $("#correo_usr").val(res.correo_usr);
                $("#password_usr").val(res.password_usr);
                $("#telefono_usr").val(res.telefono_usr);
                $("#direccion_usr").val(res.direccion_usr);
                $("#id_perfil").val(res.id_perfil);
                obj = {
                    action: "updateUser",
                    id_usr: id,
                };
            },
            "JSON"
        );
        $(".modal-title").text("Editar Usuario");
        $("#btnInsertUser").text("Editar");
    });

    $(".btnDelete").click(function () {
        let id = $(this).attr("data");
        obj = {
            action: "deleteUser",
            id_usr: id,
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
                                text: "Usuario eliminado correctamente",
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

    $("#btnInsertUser").click(function () {
        $("#modalUsers")
            .find("input")
            .map(function (i, e) {
                obj[e.name] = $(this).val();
            });
        $("#modalUsers")
            .find("select")
            .map(function (i, e) {
                obj[e.name] = $(this).val();
            });

        switch (obj.action) {
            case "insertUser":
                $.post(
                    "functions.php",
                    obj,
                    function (res) {
                        if (res.status == 0) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Campos vacios, favor de llenarlos correctamente.",
                            });
                        } else if (res.status == 2) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Favor de ingresar un correo electronico valido.",
                            });
                        } else if (res.status == 3) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Correo electrico ya esta en uso.",
                            });
                        } else if (res.status == 4) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Inserte un número de telefono valido.",
                            });
                        } else if (res.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Usuario ingresado correctamente",
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    "JSON"
                );
                break;

            case "updateUser":
                $.post(
                    "functions.php",
                    obj,
                    function (res) {
                        if (res.status == 0) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Campos vacios, favor de llenarlos correctamente.",
                            });
                        } else if (res.status == 2) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Favor de ingresar un correo electronico valido.",
                            });
                        } else if (res.status == 4) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Inserte un número de telefono valido.",
                            });
                        } else if (res.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Usuario editado correctamente",
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    "JSON"
                );
                break;

            default:
                break;
        }
    });
});
