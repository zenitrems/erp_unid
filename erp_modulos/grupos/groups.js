$(document).ready(function () {
    var obj = {}

    $("#newGroup").click(function () {
        obj = {
            action: "insertGroup",
        }
        $(".modal-title").text("Añadir nuevo grupo")
        $("#btnInsertGroup").text("Añadir")
        $("#formGroups")[0].reset()
    })

    $("#tableGroups").bootstrapTable({
        pagination: true,
        search: true,
    })

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1)
    }

    $(".btnEdit").click(function () {
        let id = $(this).attr("data")
        obj = {
            action: "getGroup",
            id: id,
        }
        $.post(
            "functions.php",
            obj,
            function (res) {
                $("#nombre_grupo").val(capitalizeFirstLetter(res.nombre_grupo))
                obj = {
                    action: "updateGroup",
                    id: id,
                }
            },
            "JSON"
        )
        $(".modal-title").text("Editar grupo")
        $("#btnInsertGroup").text("Editar")
    })

    $(".btnDelete").click(function () {
        let id = $(this).attr("data")
        obj = {
            action: "deleteGroup",
            id: id,
        }
        Swal.fire({
            title: "¿Estás seguro?",
            text: "No podrás revertir los cambios.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33 ",
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Eliminar",
        }).then(result => {
            if (result.value) {
                $.post(
                    "functions.php",
                    obj,
                    function (res) {
                        if (res.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Grupo eliminado correctamente",
                            }).then(() => {
                                location.reload()
                            })
                        }
                    },
                    "JSON"
                )
            }
        })
    })

    $("#btnInsertGroup").click(function () {
        obj.nombre_grupo = $("#nombre_grupo").val()

        switch (obj.action) {
            case "insertGroup":
                $.post(
                    "functions.php",
                    obj,
                    function (res) {
                        if (res.status == 0) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Campo vacio, favor de llenarlo correctamente",
                            })
                        } else if (res.status == 2) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "El grupo que estas tratando de añadir ya existe",
                            })
                        } else if (res.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Grupo ingresado correctamente",
                            }).then(() => {
                                location.reload()
                            })
                        }
                    },
                    "JSON"
                )
                break

            case "updateGroup":
                $.post(
                    "functions.php",
                    obj,
                    function (res) {
                        if (res.status == 0) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Campo vacio, favor de llenarlo correctamente",
                            })
                        } else if (res.status == 2) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Favor de editar el nombre de lo contrario, cancele la operación",
                            })
                        } else if (res.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Grupo editado correctamente",
                            }).then(() => {
                                location.reload()
                            })
                        }
                    },
                    "JSON"
                )
                break

            default:
                break
        }
    })
})
