$(document).ready(function () {
    var obj = {}


    $("#id_empleado").prop("disabled", "disabled")

    $("#department").change(function () {
        $("#id_empleado").prop("disabled", false)
        obj.action = "getEmployeeByDeparment"
        obj.id_deparment = $(this).val()
        $.post(
            "functions.php",
            obj,
            function (res) {
                let stringHTML = ``
                if (res.length > 0) {
                    $("#id_empleado").attr("data-placeholder", "Seleccione un empleado")
                    stringHTML = res
                        .map(item => {
                            return `
                            <option value="${item.id_empleado}">${item.numero_empleado}</option>
                        `
                        })
                        .join("")
                } else {
                    stringHTML = ``
                    $("#id_empleado").attr("data-placeholder", "Departamento sin empleados")
                }
                $("#id_empleado").html(stringHTML)
                $("#id_empleado").trigger("chosen:updated")
            },
            "JSON"
        )
    })

    $(".chosen-select").chosen({
        no_results_text: "Oops, no se encontraron resultados para: ",
        width: "100%",
    })

    $("#tableUsers").bootstrapTable({
        pagination: true,
        search: true,
    })
  
    $("#newUser").click(function () {
        $("#btnInsertUser").addClass("insert")
        $("#id_empleado").attr("data-placeholder", "Seleccione un empleado")
        $(".modal-title").text("Nuevo Usuario")
        $("#btnInsertUser").text("Insertar")
        $("#formUsers")[0].reset()
        $("#department").val("0").trigger("chosen:updated")
        $("#id_perfil").val("0").trigger("chosen:updated")
        $("#id_empleado").prop("disabled", "disabled")
        $("#id_empleado").val("0").trigger("chosen:updated")
    })

    $(".btnEdit").click(function () {
        let id = $(this).attr("data")
        obj = {
            action: "getUser",
            id_usr: id,
        }
        $.post(
            "functions.php",
            obj,
            function (res) {
                obj.action = "getDepartmentByIdEmployee"
                obj.id_empleado = res.id_empleado
                var idEmp = res.id_empleado
                $.post(
                    "functions.php",
                    obj,
                    function (res) {
                        obj.action = "getEmployeeByDeparment"
                        obj.id_deparment = res[0].department
                        $.post(
                            "functions.php",
                            obj,
                            function (res) {
                                let stringHTML = ``
                                $("#id_empleado").attr("data-placeholder", "Seleccione un empleado")
                                stringHTML = res
                                    .map(item => {
                                        return `
                                            <option value="${item.id_empleado}">${item.numero_empleado}</option>
                                        `
                                    })
                                    .join("")
                                $("#id_empleado").html(stringHTML)
                                $("#id_empleado").val(idEmp)
                                $("#id_empleado").trigger("chosen:updated")
                            },
                            "JSON"
                        )
                        $("#department").val(res[0].department)
                        $("#department").trigger("chosen:updated")
                    },
                    "JSON"
                )

                $("#nombre_usr").val(res.nombre_usr)
                $("#correo_usr").val(res.correo_usr)
                $("#password_usr").val(res.password_usr)
                $("#telefono_usr").val(res.telefono_usr)
                $("#direccion_usr").val(res.direccion_usr)
                $("#id_perfil").val(res.id_perfil)
                $("#id_perfil").trigger("chosen:updated")
                obj = {
                    action: "updateUser",
                    id_usr: id,
                }
            },
            "JSON"
        )
        $("#id_empleado").prop("disabled", false)
        $("#btnInsertUser").removeClass("insert")
        $("#btnInsertUser").addClass("update")
        $(".modal-title").text("Editar Usuario")
        $("#btnInsertUser").text("Editar")
    })

    $(".btnDelete").click(function () {
        let id = $(this).attr("data")
        obj = {
            action: "deleteUser",
            id_usr: id,
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
                                text: "Usuario eliminado correctamente",
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

    $("#btnInsertUser").click(function () {
        if ($(this).hasClass("insert")) {
            obj.action = "insertUser"
        } else if ($(this).hasClass("update")) {
            obj.action = "updateUser"
        }
        $("#modalUsers")
            .find("input")
            .map(function (i, e) {
                obj[e.name] = $(this).val()
            })
        $("#modalUsers")
            .find("select")
            .map(function (i, e) {
                obj[e.name] = $(this).val()
            })

        console.log(obj)
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
                            })
                        } else if (res.status == 2) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Favor de ingresar un correo electronico valido.",
                            })
                        } else if (res.status == 3) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Correo electrico ya esta en uso.",
                            })
                        } else if (res.status == 4) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Inserte un número de telefono valido.",
                            })
                        } else if (res.status == 5) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "El empleado ya ah sido registrado.",
                            })
                        } else if (res.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Usuario ingresado correctamente",
                            }).then(() => {
                                location.reload()
                            })
                        }
                    },
                    "JSON"
                )
                break

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
                            })
                        } else if (res.status == 2) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Favor de ingresar un correo electronico valido.",
                            })
                        } else if (res.status == 4) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Inserte un número de telefono valido.",
                            })
                        } else if (res.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Usuario editado correctamente",
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
