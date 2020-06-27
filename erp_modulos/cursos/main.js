$(document).ready(function () {
    var obj = {}

    $("#fecha_inicio").change(function () {
        if (this.value == "") {
            $("#fecha_final").attr("disabled", "disabled")
        } else {
            renderDatePickerFinal(this.value)
        }
    })

    $("#fecha_inicio").daterangepicker({
        singleDatePicker: true,
        minDate: moment(),
        locale: {
            format: "YYYY/MM/DD",
            daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            monthNames: [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Augosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre",
            ],
            applyLabel: "Ok",
            cancelLabel: "Cancelar",
        },
    })

    function renderDatePickerFinal(minDateFinal) {
        $("#fecha_final").removeAttr("disabled")
        $("#fecha_final").daterangepicker({
            singleDatePicker: true,
            minDate: minDateFinal,
            locale: {
                format: "YYYY/MM/DD",
                daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                monthNames: [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Augosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre",
                ],
                applyLabel: "Ok",
                cancelLabel: "Cancelar",
            },
        })
    }

    $("#dias_curso").chosen({
        disable_search_threshold: 12,
        width: "100%",
    })

    $("#horario_curso").timepicker({
        timeFormat: "h:i A",
        listWidth: 1,
        minTime: "7:00am",
        maxTime: "11:30pm",
        setTime: new Date(),
    })

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1)
    }

    $("#newCourse").click(function () {
        obj = {
            action: "insertCourse",
        }
        $(".modal-title").text("Nuevo Curso")
        $("#btnInsertCourse").text("Insertar")
        $("#formCourses")[0].reset()
        $("#horario_curso").timepicker("setTime", new Date())
        $("#dias_curso").val("").trigger("chosen:updated")
    })

    $(".btnEdit").click(function () {
        let id = $(this).attr("data")
        obj = {
            action: "getCourse",
            id_curso: id,
        }
        $.post(
            "functions.php",
            obj,
            function (res) {
                let arrayDays = res.dias_curso.split(", ")
                $("#nombre_curso").val(capitalizeFirstLetter(res.nombre_curso))
                $("#fecha_inicio").val(res.fecha_inicio)
                $("#fecha_final").val(res.fecha_final)
                $("#duracion_curso").val(res.duracion_curso)
                $("#dias_curso").val(arrayDays)
                $("#horario_curso").val(res.horario_curso)
                $("#dias_curso").trigger("chosen:updated")
                obj = {
                    action: "updateCourse",
                    id_curso: id,
                }
            },
            "JSON"
        )
        $(".modal-title").text("Editar Curso")
        $("#btnInsertCourse").text("Editar")
    })

    $(".btnDelete").click(function () {
        let id = $(this).attr("data")
        obj = {
            action: "deleteCourse",
            id_curso: id,
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
                                text: "Curso eliminado correctamente",
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

    $("#btnInsertCourse").click(function () {
        obj.nombre_curso = $("#nombre_curso").val()
        obj.fecha_inicio = $("#fecha_inicio").val()
        obj.fecha_final = $("#fecha_final").val()
        obj.duracion_curso = $("#duracion_curso").val()
        obj.horario_curso = $("#horario_curso").val()
        if ($("#dias_curso").val() == "") {
            obj.dias_curso = 0
        } else {
            obj.dias_curso = $("#dias_curso").val()
        }

        console.log(obj)

        switch (obj.action) {
            case "insertCourse":
                $.post(
                    "functions.php",
                    obj,
                    function (res) {
                        if (res.status == 0) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Campos vacios, favor de llenarlos correctamente.",
                            })
                        } else if (res.status == 2) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "El curso que estas tratando de ingresar, ya existe",
                            })
                        } else if (res.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Curso ingresado correctamente",
                            }).then(() => {
                                location.reload()
                            })
                        }
                    },
                    "JSON"
                )
                break

            case "updateCourse":
                $.post(
                    "functions.php",
                    obj,
                    function (res) {
                        if (res.status == 0) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Campos vacios, favor de llenarlos correctamente.",
                            })
                        } else if (res.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Curso editado correctamente",
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
