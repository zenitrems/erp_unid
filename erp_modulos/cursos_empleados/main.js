$(document).ready(function () {
    var obj = {};

    $(".chosen-select").chosen({
        no_results_text: "Oops, no se encontraron resultados para: ",
        width: "100%",
    });

    $(".btnDiploma").click(function () {
        let empleado = $(this).attr("data");
        let curso = $(this).attr("name");
        obj = {
            action: "createCertificate",
            empleado: empleado,
            curso: curso
        };
        $.post(
            "functions.php",
            obj,
            function (res) {
                if(res.status == 1){
                    console.log('hola');
                    console.log(res.empleado);
                    console.log(res.curso);
                }else{
                    console.log('adios');
                }
            },
            "JSON"
        );
    });


    $("#newCourseEmployee").click(function () {
        obj = {
            action: "insertCourseEmployee",
        };
        $(".modal-title").text("Añadir nuevo curso a empleado");
        $("#btnInsertCourseEmployee").text("Añadir");
        $("#status_curso").css('display','none');
        $("#label_status").css('display','none');
        $("#formCoursesEmployee")[0].reset();
    });

    $(".btnEdit").click(function () {
        let id = $(this).attr("data");
        obj = {
            action: "getCourseEmployee",
            id: id,
        };
        $.post(
            "functions.php",
            obj,
            function (res) {
                $(".status_curso").val(res.status_curso);
                $("#id_empleado").val(res.id_empleado);
                $("#id_curso").val(res.id_curso);
                $("#id_empleado").trigger("chosen:updated");
                $("#id_curso").trigger("chosen:updated");
                obj = {
                    action: "updateCourseEmployee",
                    id: id,
                };
            },
            "JSON"
        );
        $(".modal-title").text("Editar");
        $("#btnInsertCourseEmployee").text("Editar");
        $("#status_curso").css('display','block');
        $("#label_status").css('display','block');
        $("#formCoursesEmployee")[0].reset();
    });

    $(".btnDelete").click(function () {
        let id = $(this).attr("data");
        obj = {
            action: "deleteCourseEmployee",
            id: id,
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
                                text: "Registro eliminado correctamente",
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

    $("#btnInsertCourseEmployee").click(function () {
        $("#modal")
            .find("select")
            .map(function (i, e) {
                obj[e.name] = $(this).val();
            });

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
                            });
                        } else if (res.status == 2) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text:
                                    "El curso que estas tratando de añadir ya ah sido asignado al empleado",
                            });
                        } else if (res.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Registro ingresado correctamente",
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    "JSON"
                );
                break;

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
                            });
                        } else if (res.status == 2) {
                            Swal.fire({
                                icon: "error",
                                title: "Error...",
                                text: "Favor de editar algún dato",
                            });
                        } else if (res.status == 1) {
                            Swal.fire({
                                icon: "success",
                                title: "¡Perfecto!",
                                text: "Registro editado correctamente",
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
