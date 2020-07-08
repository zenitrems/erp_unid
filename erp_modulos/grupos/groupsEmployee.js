$(document).ready(function () {
    var obj = {}

    $("#id_grupo").change(function () {
        obj.action = "getCursosByGrupo"
        obj.id_grupo = $("#id_grupo").val()
        $.post(
            "functions.php",
            obj,
            function (res) {
                let stringHTML = ``
                if (res.length > 0) {
                    $("#id_curso_many").attr("data-placeholder", "Selecciona curso(s)")
                    stringHTML = res
                        .map((item) => {
                            return `
                            <option value="${item.id_curso}">${item.nombre_curso}</option>
                        `
                        })
                        .join("")
                } else {
                    stringHTML = ``
                    $("#id_curso_many").attr(
                        "data-placeholder",
                        "El grupo seleccionado no cuenta con ningún curso"
                    )
                    $("#id_curso_one").attr(
                        "data-placeholder",
                        "El grupo seleccionado no cuenta con ningún curso"
                    )
                }
                $("#id_curso_many").html(stringHTML)
                $("#id_curso_one").html(stringHTML)
                $("#id_curso_many").trigger("chosen:updated")
                $("#id_curso_one").trigger("chosen:updated")
            },
            "JSON"
        )
    })

    $(".chosen-select").chosen({
        no_results_text: "Oops, no se encontraron resultados para: ",
        width: "100%",
    })

    $("#newGroupEmployee").click(function () {
        $("#btnInsertGroupEmployee").addClass("insert")
        $("#id_curso_many").attr("data-placeholder", "Selecciona curso(s)")
        $("#select-one-id").css("display", "none")
        $("#select-many-id").css("display", "block")
        $("#select-one-curso").css("display", "none")
        $("#select-many-cursos").css("display", "block")
        $("#select-status").css("display", "none")
        $(".modal-title").text("Asignar grupo a empleado(s)")
        $("#btnInsertGroupEmployee").text("Asignar")
        $("#id_grupo").val("0").trigger("chosen:updated")
        $("#id_curso_many").val("").trigger("chosen:updated")
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
                obj.action = "getCursosByGrupo"
                obj.id_grupo = res.id_grupo
                var idCurso = res.id_curso
                $.post(
                    "functions.php",
                    obj,
                    function (res) {
                        stringHTML = res
                            .map((item) => {
                                return `
                                    <option value="${item.id_curso}">${item.nombre_curso}</option>
                                `
                            })
                            .join("")
                        $("#id_curso_one").html(stringHTML)
                        $("#id_curso_one").val(idCurso)
                        $("#id_curso_one").trigger("chosen:updated")
                    },
                    "JSON"
                )
                $("#id_grupo").val(res.id_grupo)
                $("#id_empleado_one").val(res.id_empleado)
                $("#id_curso_one").val(res.id_curso)
                $("#status_curso").val(res.status_empleadoCurso)
                $("#id_grupo").trigger("chosen:updated")
                $("#id_empleado_one").trigger("chosen:updated")
                $("#id_curso_one").trigger("chosen:updated")
                $("#status_curso").trigger("chosen:updated")
            },
            "JSON"
        )
        $("#btnInsertGroupEmployee").removeClass("insert")
        $("#btnInsertGroupEmployee").addClass("update")
        $("#select-many-id").css("display", "none")
        $("#select-one-id").css("display", "block")
        $("#select-one-curso").css("display", "block")
        $("#select-many-cursos").css("display", "none")
        $("#select-status").css("display", "block")
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
        if ($(this).hasClass("insert")) {
            obj.action = "insertGroupEmployee"
        } else if ($(this).hasClass("update")) {
            obj.action = "updateGroupEmployee"
        }
        obj.id_grupo = $("#id_grupo").val()
        if ($("#id_empleado").val() == "") {
            obj.id_empleado = 0
        } else {
            obj.id_empleado = $("#id_empleado").val()
        }
        if ($("#id_curso_many").val() == "") {
            obj.id_curso_many = 0
        } else {
            obj.id_curso_many = $("#id_curso_many").val()
        }
        
        obj.id_empleado_one = $("#id_empleado_one").val()
        obj.id_curso_one = $("#id_curso_one").val()
        obj.status_empleadoCurso = $("#status_curso").val()

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
                                    "El curso que estas tratando de añadir ya ha sido asignado al empleado(s)",
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
                        } else if (res.status == 2) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text:
                                    "El curso que estas tratando de añadir ya ha sido asignado al empleado",
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
