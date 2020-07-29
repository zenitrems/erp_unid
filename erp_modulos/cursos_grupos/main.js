$(document).ready(function () {
    var obj = {}

    $(".chosen-select").chosen({
        no_results_text: "Oops, no se encontraron resultados para: ",
        width: "100%",
    })

    $("#tableCoursesGroups").bootstrapTable({
        pagination: true,
        search: true,
    })

    $("#newCourseEmployee").click(function () {
        obj = {
            action: "insertCourseEmployee",
        }
        $(".modal-title").text("Añadir nuevo curso a grupo")
        $("#btnInsertCourseEmployee").text("Añadir")
        $("#grupo_many").css("display", "block")
        $("#grupo_one").css("display", "none")
        $("#select-status").css("display", "none")
        $("#id_curso").val("0").trigger("chosen:updated")
        $("#id_grupo_many").val("").trigger("chosen:updated")
    })

    $(".btnEdit").click(function () {
        let id = $(this).attr("data")
        obj = {
            action: "getCourseEmployee",
            id: id,
        }
        $.post(
            "functions.php",
            obj,
            function (res) {
                $("#id_grupo_one").val(res.id_grupo)
                $("#id_curso").val(res.id_curso)
                $("#status_curso").val(res.status_curso)
                $("#id_grupo_one").trigger("chosen:updated")
                $("#id_curso").trigger("chosen:updated")
                $("#status_curso").trigger("chosen:updated")
                obj = {
                    action: "updateCourseEmployee",
                    id: id,
                }
            },
            "JSON"
        )
        $(".modal-title").text("Editar")
        $("#btnInsertCourseEmployee").text("Editar")
        $("#grupo_one").css("display", "block")
        $("#select-status").css("display", "block")
        $("#grupo_many").css("display", "none")
    })

    $(".btnDelete").click(function () {
        let id = $(this).attr("data")
        obj = {
            action: "deleteCourseEmployee",
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

    $("#btnInsertCourseEmployee").click(function () {
        if ($("#id_grupo_many").val() == "") {
            obj.id_grupo_many = 0
        } else {
            obj.id_grupo_many = $("#id_grupo_many").val()
        }

        obj.id_curso = $("#id_curso").val()
        obj.id_grupo_one = $("#id_grupo_one").val()
        obj.status_curso = $("#status_curso").val()

        console.log(obj)

        switch (obj.action) {
            case "insertCourseEmployee":
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
                                text: "El curso que estas tratando de añadir ya ha sido asignado al grupo",
                            })
                        } else if (res.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Registro ingresado correctamente",
                            }).then(() => {
                                location.reload()
                            })
                        }
                    },
                    "JSON"
                )
                break

            case "updateCourseEmployee":
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
                                text: "Favor de editar algún dato",
                            })
                        } else if (res.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Registro editado correctamente",
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
