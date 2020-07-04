$(document).ready(function () {
    var obj = {}

    $(".chosen-select").chosen({
        no_results_text: "Oops, no se encontraron resultados para: ",
        width: "100%",
    })

    $("#newGroupEmployee").click(function () {
        obj = {
            action: "insertGroupEmployee",
        }
        $("#select-one-id").css("display", "none")
        $(".modal-title").text("Asignar grupo a empleado(s)")
        $("#btnInsertGroupEmployee").text("Asignar")
        $("#id_grupo").val("0").trigger("chosen:updated")
        $("#id_empleado").val("").trigger("chosen:updated")
    })

    $(".btnEditGroupEmployee").click(function () {
        let id = $(this).attr("data")
        obj = {
            action: "getGroupEmployee",
            id: id,
        }
        $.post(
            "functions.php",
            obj,
            function (res) {
                $("#id_grupo").val(res.id_grupo)
                $("#id_empleado_one").val(res.id_empleado)
                $("#id_grupo").trigger("chosen:updated")
                $("#id_empleado_one").trigger("chosen:updated")
                obj = {
                    action: "updateGroupEmployee",
                    id: id,
                }
            },
            "JSON"
        )
        $("#select-many-id").css("display", "none")
        $("#select-one-id").css("display", "block")
        $(".modal-title").text("Editar registro")
        $("#btnInsertGroupEmployee").text("Editar")
    })

    $(".btnDeleteGroupEmployee").click(function () {
        let id = $(this).attr("data")
        obj = {
            action: "deleteGroupEmployee",
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
                                text: "Registro eliminado correctamente",
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

    $("#btnInsertGroupEmployee").click(function () {
        obj.id_grupo = $("#id_grupo").val()
        if ($("#id_empleado").val() == "") {
            obj.id_empleado = 0
        } else {
            obj.id_empleado = $("#id_empleado").val()
        }
        obj.id_empleado_one = $("#id_empleado_one").val()

        console.log(obj)

        switch (obj.action) {
            case "insertGroupEmployee":
                $.post(
                    "functions.php",
                    obj,
                    function (res) {
                        if (res.status == 0) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Campos vacios, favor de llenarlos correctamente",
                            })
                        } else if (res.status == 2) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text:
                                    "El grupo que estas tratando de añadir ya ha sido asignado al empleado",
                            })
                        } else if (res.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Registro añadido correctamente",
                            }).then(() => {
                                location.reload()
                            })
                        }
                    },
                    "JSON"
                )
                break

            case "updateGroupEmployee":
                $.post(
                    "functions.php",
                    obj,
                    function (res) {
                        if (res.status == 0) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Campos vacios, favor de llenarlos correctamente",
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
