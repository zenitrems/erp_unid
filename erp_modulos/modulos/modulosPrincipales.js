$(document).ready(function () {
  var obj = {};

  //Previene cerrar el modal con tecla Enter
  $("#modalModulosPrincipales").keydown(function (e) {
    let keycode = e.which;
    if (keycode == 13) {
      e.preventDefault();
      return false;
    }
  });

    $("#tablemodulosPrincipales").bootstrapTable({
        pagination: true,
        search: true,
    })

  //Accion de boton para insertar en la vista
  $("#btn-newMP").click(function () {
    obj = {
      accion: "insertModuloP"
    };
    $("#btn-formMP").text("Insertar");
    $("#exampleModalLabelMP").text("Insertar Módulo Principal");
    $("#modulosP-form")[0].reset();
  });

  //Accion de boton editar
  $(".btnEditModuloP").click(function () {
    let id = $(this).attr("data");
    obj = {
      accion: "getModuloP",
      id_modulo_principal: id
    };
    $.post(
      "consultas.php",
      obj,
      function (respuesta) {
        // console.log(respuesta.id);
        $(".nombre_modulo_principal").val(respuesta.nombre_modulo_principal);
        obj = {
          accion: "updateModuloP",
          id_modulo_principal: id
        };
      },
      "JSON"
    );
    $("#btn-formMP").text("Editar");
    $("#exampleModalLabelMP").text("Editar Módulo Principal");
    $("#modulosP-form")[0].reset();
  });

  //Accion de boton Eliminar
  $(".btnDeleteModuloP").click(function () {
    let id_modulo_principal = $(this).attr("data");
    obj = {
      accion: "deleteModuloP",
      id_modulo_principal: id_modulo_principal
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
              // location.reload();
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

  //Accion de boton dentro de modal, dependiendo si es Editar o Insertar
  $("#btn-formMP").click(function (e) {
    $("#modulosP-form")
      .find("input")
      .map(function (i, e) {
        obj[$(this).prop("name")] = $(this).val();
      });
    switch (obj.accion) {
      case "insertModuloP":
        $.post(
          "consultas.php",
          obj,
          function (respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            } else if (respuesta.status == 1) {
              swal("Éxito", "Módulo añadido correctamente", "success").then(
                () => {
                  location.reload();
                }
              );
            } else if (respuesta.status == 2) {
              swal("¡ERROR!", "El módulo ya existe", "error");
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
      case "updateModuloP":
        $.post(
          "consultas.php",
          obj,
          function (respuesta) {
            if (respuesta.status == 0) {
              swal("¡ERROR!", "Campos vacios", "error");
            } else if (respuesta.status == 1) {
              swal("Éxito", "Módulo editado correctamente", "success").then(
                () => {
                  location.reload();
                  // $(location).attr('href','index.php');
                }
              );
            } else if (respuesta.status == 2) {
              swal("¡ERROR!", "El módulo ya existe", "error");
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
