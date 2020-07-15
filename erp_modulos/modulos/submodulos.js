$(document).ready(function () {
  var obj = {};

  //BOOTSTRAP TABLES
  $("#tablesubmodulos").bootstrapTable({
      pagination: true,
      search: true,
  })

  //Equiz
  $(".chosen-select").chosen({
    no_results_text: "Oops, no se encontraron resultados para: ",
    width: "100%"
  });

  //Listo btnInsertar
  $("#btn-newS").click(function () {
    obj = {
      accion: "insertSubmodulo"
    };
    //listos
    $("#id_submoduloInDiv").css("display", "none");
    $("#id_submoduloManyDiv").css("display", "block");
    $("#exampleModalLabelS").text("Asignar Submódulos a Módulo Principal");
    $("#btn-formS").text("Asignar");
    $("#id_submodulo").val("").trigger("chosen:updated");
    $("#id_moduloP").val("").trigger("chosen:updated");
    $("#id_submoduloIn").val("0").trigger("chosen:updated");
  });

  //Pendiente
  $(".btnEditSubmodulo").click(function () {
    let id = $(this).attr("data");
    obj = {
      accion: "getSubmodulo",
      id: id
    };
    $.post(
      "consultas.php",
      obj,
      function (respuesta) {
        $("#id_moduloP").val(respuesta.id_modulo_principal);
        $("#id_submoduloIn").val(respuesta.id_submodulo);

        $("#id_moduloP").trigger("chosen:updated");
        $("#id_submoduloIn").trigger("chosen:updated");

        obj = {
          accion: "updateSubmodulo",
          id: id
        };
      },
      "JSON"
    );

    $("#btn-formS").removeClass("insertar");
    $("#btn-formS").addClass("editar");
    $("#id_submoduloInDiv").css("display", "block");
    $("#id_submoduloManyDiv").css("display", "none");
    $("#exampleModalLabelS").text("Editar Submódulo");
    $("#btn-formS").text("Editar");
    $("#id_submodulo").val("").trigger("chosen:updated");
  });

  //Ya quedo
  $(".btnDeleteSubmodulo").click(function () {
    let id = $(this).attr("data");
    obj = {
      accion: "deleteSubmodulo",
      id: id
    };
    swal({
      title: "¿Estás seguro?",
      text: "El modulo será eliminado",
      icon: "warning",
      buttons: true,
      dangerMode: true
    }).then(willDelete => {
      if (willDelete) {
        $.post(
          "consultas.php",
          obj,
          function (respuesta) {
            if (respuesta.status == 1) {
              swal("Éxito", "Módulo eliminado correctamente", "success").then(
                willDelete => {
                  location.reload();
                }
              );
            } else {
              swal({
                title: "Oops...",
                text: "¡Algo salió mal!",
                icon: "error"
              });
            }
          },
          "JSON"
        );
      }
    });
  });

  //Insert y Update
  $("#btn-formS").click(function () {
    if ($("#id_submodulo").val() == "") {
      obj.id_submodulo = 0;
    } else {
      obj.id_submodulo = $("#id_submodulo").val();
    }

    obj.id_moduloP = $("#id_moduloP").val();
    obj.id_submoduloIn = $("#id_submoduloIn").val();

    // console.log(obj)

    switch (obj.accion) {
      case "insertSubmodulo":
        $.post(
          "consultas.php",
          obj,
          function (respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            } else if (respuesta.status == 2) {
              swal("¡ERROR!", "Este submódulo ya esta asignado", "error");
            } else if (respuesta.status == 1) {
              swal("Éxito", "Módulo añadido correctamente", "success").then(
                () => {
                  location.reload();
                }
              );
            } else {
              swal({
                title: "Oops...",
                text: "¡Algo salió mal!",
                icon: "error"
              });
            }
          },
          "JSON"
        );
        break;

      case "updateSubmodulo":
        $.post(
          "consultas.php",
          obj,
          function (respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            } else if (respuesta.status == 2) {
              swal("¡ERROR!", "Este submódulo ya esta asignado", "error");
            } else if (respuesta.status == 1) {
              swal("Éxito", "Registro actualizado correctamente", "success").then(
                () => {
                  location.reload();
                }
              );
            } else {
              swal({
                title: "Oops...",
                text: "¡Algo salió mal!",
                icon: "error"
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
