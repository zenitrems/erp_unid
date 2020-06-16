$(document).ready(function () {
    function loginValidate() {
        let obj = {
            accion: "login",
        };

        $("#login-form")
            .find("input")
            .map(function (i, e) {
                obj[$(this).prop("name")] = $(this).val();
            });

        $.post(
            "consultas.php",
            obj,
            function (respuesta) {
                if (respuesta.status == 2) {
                    window.location.href = "../../index.php";
                } else if (respuesta.status == 0) {
                    swal("¡ERROR!", "Campos vacios", "error");
                } else if (respuesta.status == 1) {
                    swal("¡ERROR!", "Correo no registrado", "error");
                } else if (respuesta.status == 3) {
                    swal("¡ERROR!", "Contraseña incorrecta", "error");
                }
            },
            "JSON"
        );
    }

    $("#btn-login").click(function () {
        loginValidate();
    });

    $("#email, #password").keyup(function (e) {
        if (e.keyCode == 13) {
            loginValidate();
        }
    });
});
