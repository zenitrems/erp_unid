<?php include __DIR__ . "/../common/session.php"; ?>
<!DOCTYPE html>
<html lang="mx">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,
    user-scalable=no, shrink-to-fit=no"/>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="/main.css" />
    <link rel="stylesheet" href="form.css" />

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src=" ../common/factory.js"></script>
    <script type="text/javascript" src="form.js"></script>

    <title>Módulos</title>
</head>

<body>
<!-- Full Container -->
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
    <?php include(ROOT_PATH . "/includes/navbar.php"); ?>
    <!-- Container app main -->
    <div class="app-main">
        <?php include(ROOT_PATH . "/includes/sidenav.php"); ?>
        <!-- App Content -->
        <div class="app-main__outer">
            <!-- Content -->
            <div class="app-main__inner">
                <div class="app-page-title">
                    <div class="page-title-actions">
                        <div class="container">
                            <div class="save" style="width:100%; text-align: right;">
                                <button type="button" id="close" class="btn btn-lg btn-danger">Cerrar</button>
                                <button type="button" id="submit" class="btn btn-lg btn-success">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container main-container col-12">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <a href="#" class="stretched-link text-dark text-decoration-none " style="position: relative;"
                                   data-toggle="collapse" data-target="#collapseOne">
                                    <h6 class="mb-0">Datos básicos
                                        <i class="fa" style="float: right;"></i>
                                    </h6>
                                </a>
                            </div>

                            <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <form id="basicData">
                                            <div class="form-row">
                                                <div class="form-group col-6">
                                                    <label for="department">Departamento:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <select class="form-control" data-live-search="true" id="department" name="department">
                                                            <option>Selecionar</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="position">Puesto:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <select class="form-control" data-live-search="true" id="position" name="position">
                                                            <option>Selecionar</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-6">
                                                    <label for="desiredSalary">Sueldo mensual deseado:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input type="number" class="form-control" id="desiredSalary"
                                                               name="desiredSalary" value="0.0">
                                                    </div>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="approvedSalary">Sueldo mensual aprobado:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input type="number" class="form-control input-sm" id="desiredSalary"
                                                               name="approvedSalary" value="0.0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-6">
                                                    <label for="Status">Estatus:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <select class="form-control" id="status" name="status">
                                                            <option>Choose</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="recruitmentDate">Fecha de contratación:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="date" class="form-control input-sm" id="recruitmentDate"
                                                               name="recruitmentDate">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <a href="#" class="stretched-link text-dark text-decoration-none " style="position: relative;"
                                   data-toggle="collapse" data-target="#collapseTwo">
                                    <h6 class="mb-0">Datos personales
                                        <i class="fa" style="float: right;"></i>
                                    </h6>
                                </a>
                            </div>

                            <div id="collapseTwo" class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <form id="personalData">
                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <label for="lastname">Apellido paterno:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="lastname" name="lastname">
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="mothersLastname">Apellido materno:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="mothersLastname"
                                                               name="mothersLastname">
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="name">Nombre(s):</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="name" name="name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <label for="birthDate">Fecha de nacimiento:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="date" class="form-control" id="birthDate" name="birthDate">
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="telephone">Telefono:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="telephone" name="telephone"
                                                               pattern="[0-9.]+">
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="nationality">Nacionalidad:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <select class="form-control" data-live-search="true" id="nationality" name="nationality">
                                                            <option>Choose</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <label for="postalCode">Código Postal:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="postalCode" name="postalCode">
                                                    </div>
                                                </div>
                                                <div class="form-group col-5">
                                                    <label for="address">Domicilio:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="address" name="address">
                                                    </div>
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="suburb">Colonia:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <select class="form-control" data-live-search="true" id="suburb" name="suburb">
                                                            <option value="0">Selecionar</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <label for="country">País:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="country" name="country" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="city">Ciudad, estado:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="city" name="city" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="birthPlace">Lugar de nacimiento:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="birthPlace" name="birthPlace">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <label for="heightwe">Estatura:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">cm</span>
                                                        </div>
                                                        <input type="number" class="form-control input-sm" id="height" name="height" value="0.0">
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="weight">Peso:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">kg</span>
                                                        </div>
                                                        <input type="number" class="form-control input-sm" id="weight" name="weight" value="0.0">
                                                    </div>
                                                </div>
                                                <div class="form-group col-4" id="gender">
                                                    <label for="gender">Genero:</label>
                                                    <div class="form-check-inline">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="gender0" name="gender"
                                                                   value="0" checked/>
                                                            <label class="form-check-label" for="gender">Hombre</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="gender1" name="gender"
                                                                   value="1"/>
                                                            <label class="form-check-label" for="gender">Mujer</label>
                                                        </div>
                                                        <div class="form-check form-check-inline" style="width: 55%">
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                        <input class="form-check-input" type="radio" id="gender2"
                                                                               name="gender" value="2"/>
                                                                        <label class="form-check-label" for="gender">Otro:</label>
                                                                    </div>
                                                                </div>
                                                                <input type="text" class="form-control" id="otherGender"
                                                                       name="otherGender">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <label for="maritalStatus">Estado civil:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <select class="form-control" id="maritalStatus" name="maritalStatus">
                                                            <option>Choose</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="livesWith">Vive con:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <select class="form-control" id="livesWith" name="livesWith">
                                                            <option>Choose</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="dependOn">Personas que dependen de usted:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <select class="form-control" id="dependOn" name="dependOn">
                                                            <option>Choose</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <a href="#" class="stretched-link text-dark text-decoration-none " style="position: relative;"
                                   data-toggle="collapse" data-target="#collapseThree">
                                    <h6 class="mb-0">Documentación
                                        <i class="fa" style="float: right;"></i>
                                    </h6>
                                </a>
                            </div>

                            <div id="collapseThree" class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <form id="documentationData">
                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <label for="curp">Clave única de registro de población (CURP):</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="curp" name="curp">
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="afore">AFORE:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="afore" name="afore">
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="rfc">Reg. Fed. de contribuyentes (RFC):</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="rfc" name="rfc">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <label for="nss">Número de seguridad social (NSS):</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="nss" name="nss">
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="militarPrimer">Cartilla de servicio militar No. :</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="militarPrimer" name="militarPrimer">
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="passport">Pasaporte No. :</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="passport" name="passport">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-4" id="driversLicence">
                                                    <label for="driversLicence">¿Tiene licencia de conducir?:</label>
                                                    <div class="form-check-inline">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="driversLicence0" name="driversLicence"
                                                                   value="0" checked/>
                                                            <label class="form-check-label" for="driversLicence">No</label>
                                                        </div>
                                                        <div class="form-check form-check-inline text-inline">
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                        <input class="form-check-input" type="radio" id="driversLicence1"
                                                                               name="driversLicence" value="1"/>
                                                                        <label class="form-check-label" for="driversLicence">Si (Tipo):</label>
                                                                    </div>
                                                                </div>
                                                                <input type="text" class="form-control" id="driversLicenceType"
                                                                       name="driversLicenceNumber">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="driversLicenceNumber">Número de licencia:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="driversLicenceNumber" name="driversLicenceNumber">
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="foreignDocuments">Documentos que le permiten trabajar en el país:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="foreignDocuments" name="foreignDocuments">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingFour">
                                <a href="#" class="stretched-link text-dark text-decoration-none " style="position: relative;"
                                   data-toggle="collapse" data-target="#collapseFour">
                                    <h6 class="mb-0">Estado de salud y Hábitos personales
                                        <i class="fa" style="float: right;"></i>
                                    </h6>
                                </a>
                            </div>

                            <div id="collapseFour" class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <form id="healthData">
                                            <div class="form-row">
                                                <div class="form-group col-4" id="health">
                                                    <label for="health">Estado de salud actual:</label>
                                                    <div class="form-check-inline">
                                                        <div class="form-check form-check-inline" style="padding-right: 20px">
                                                            <input class="form-check-input" type="radio" id="health0" name="health"
                                                                   value="0" checked/>
                                                            <label class="form-check-label" for="health">Bueno</label>
                                                        </div>
                                                        <div class="form-check form-check-inline" style="padding-right: 20px">
                                                            <input class="form-check-input" type="radio" id="health1" name="health"
                                                                   value="1"/>
                                                            <label class="form-check-label" for="health">Regular</label>
                                                        </div>
                                                        <div class="form-check form-check-inline" style="padding-right: 20px">
                                                            <input class="form-check-input" type="radio" id="health1" name="health"
                                                                   value="1"/>
                                                            <label class="form-check-label" for="health">Malo</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-4" id="chronicDisease">
                                                    <label for="chronicDisease">¿Padece alguna enfermedad crónica?:</label>
                                                    <div class="form-check-inline">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="chronicDisease0" name="chronicDisease"
                                                                   value="0" checked/>
                                                            <label class="form-check-label" for="chronicDisease">No</label>
                                                        </div>
                                                        <div class="form-check form-check-inline text-inline">
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                        <input class="form-check-input" type="radio" id="chronicDisease1"
                                                                               name="chronicDisease" value="1"/>
                                                                        <label class="form-check-label" for="chronicDisease">Si (Explique):</label>
                                                                    </div>
                                                                </div>
                                                                <input type="text" class="form-control" id="chronicDiseaseName"
                                                                       name="chronicDiseaseName">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="sport">¿Práctica algún deporte?:</label>
                                                    <div class="form-check-inline">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="sport0" name="sport"
                                                                   value="0" checked/>
                                                            <label class="form-check-label" for="sport">No</label>
                                                        </div>
                                                        <div class="form-check form-check-inline text-inline">
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                        <input class="form-check-input" type="radio" id="sport1"
                                                                               name="sport" value="1"/>
                                                                        <label class="form-check-label" for="sport">Si (Nombre):</label>
                                                                    </div>
                                                                </div>
                                                                <input type="text" class="form-control" id="sportName"
                                                                       name="sportName">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <label for="lifeGoal">¿Cuál es su meta en la vida?:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <textarea class="form-control" id="lifeGoal" name="lifeGoal" rows="1"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="hobby">Pasatiempo favorito:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="hobby" name="hobby">
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="socialClub">¿Pertenece a algún club social o deportivo?:</label>
                                                    <div class="form-check-inline">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="socialClub0" name="socialClub"
                                                                   value="0" checked/>
                                                            <label class="form-check-label" for="socialClub">No</label>
                                                        </div>
                                                        <div class="form-check form-check-inline text-inline">
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                        <input class="form-check-input" type="radio" id="socialClub1"
                                                                               name="socialClub" value="1"/>
                                                                        <label class="form-check-label" for="socialClub">Si (Nombre):</label>
                                                                    </div>
                                                                </div>
                                                                <input type="text" class="form-control" id="socialClubName"
                                                                       name="socialClubName">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingFive">
                                <a href="#" class="stretched-link text-dark text-decoration-none " style="position: relative;"
                                   data-toggle="collapse" data-target="#collapseFive">
                                    <h6 class="mb-0">Datos familiares
                                        <i class="fa" style="float: right;"></i>
                                    </h6>
                                </a>
                            </div>

                            <div id="collapseFive" class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <form id="relativesData">
                                            <label for="father">Padre:</label>
                                            <div class="form-row">
                                                <div class="form-group col-3">
                                                    <label for="fatherName">Nombre:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="fatherName" name="fatherName">
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="fatherAddress">Domicilio:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="fatherAddress" name="fatherAddress">
                                                    </div>
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="fatherJob">Ocupación:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="fatherJob" name="fatherJob">
                                                    </div>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label for="fatherStatus">Condición:</label>
                                                    <div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="fatherStatus0" name="fatherStatus"
                                                                   value="0" checked/>
                                                            <label class="form-check-label" for="fatherStatus">Vivo</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="fatherStatus1" name="fatherStatus"
                                                                   value="1"/>
                                                            <label class="form-check-label" for="fatherStatus">Finado</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="mother">Madre:</label>
                                            <div class="form-row">
                                                <div class="form-group col-3">
                                                    <label for="motherName">Nombre:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="motherName" name="motherName">
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="fatherAddress">Domicilio:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="motherAddress" name="motherAddress">
                                                    </div>
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="fatherJob">Ocupación:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="motherJob" name="motherJob">
                                                    </div>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label for="motherStatus">Condición:</label>
                                                    <div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="motherStatus0" name="motherStatus"
                                                                   value="0" checked/>
                                                            <label class="form-check-label" for="motherStatus">Vivo</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="motherStatus1" name="motherStatus"
                                                                   value="1"/>
                                                            <label class="form-check-label" for="motherStatus">Finado</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="spouse">Esposa (o):</label>
                                            <div class="form-row">
                                                <div class="form-group col-3">
                                                    <label for="spouseName">Nombre:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="spouseName" name="spouseName">
                                                    </div>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label for="spouseAddress">Domicilio:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="spouseAddress" name="spouseAddress">
                                                    </div>
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="spouseJob">Ocupación:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="spouseJob" name="spouseJob">
                                                    </div>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label for="spouseStatus">Condición:</label>
                                                    <div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="spouseStatus0" name="spouseStatus"
                                                                   value="0" checked/>
                                                            <label class="form-check-label" for="spouseStatus">Vivo</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="spouseStatus1" name="spouseStatus"
                                                                   value="1"/>
                                                            <label class="form-check-label" for="spouseStatus">Finado</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <label for="children">Hijos:</label>
                                        <ol class="list-group" id="children-list">
                                        </ol>
                                        <div class="row">
                                            <div class="col text-center">
                                                <button type="button" class="btn btn-light" id="addChildren">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingSix">
                                <a href="#" class="stretched-link text-dark text-decoration-none " style="position: relative;"
                                   data-toggle="collapse" data-target="#collapseSix">
                                    <h6 class="mb-0">Escolaridad
                                        <i class="fa" style="float: right;"></i>
                                    </h6>
                                </a>
                            </div>

                            <div id="collapseSix" class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <form id="scholarData">
                                            <label for="elementarySchool">Primaria:</label>
                                            <div class="form-row">
                                                <div class="form-group col-3">
                                                    <label for="elementarySchoolName">Nombre escuela:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="elementarySchoolName" name="elementarySchoolName">
                                                    </div>
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="elementarySchoolAddress">Dirección:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="elementarySchoolAddress" name="elementarySchoolAddress">
                                                    </div>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label for="elementarySchoolFrom">De:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="date" class="form-control" id="elementarySchoolFrom" name="elementarySchoolFrom">
                                                    </div>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label for="elementarySchoolTo">A:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="date" class="form-control" id="elementarySchoolTo" name="elementarySchoolTo">
                                                    </div>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label for="elementarySchoolDegree">Titulo recibido:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="elementarySchoolDegree" name="elementarySchoolDegree">
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="juniorHigh">Secundaria:</label>
                                            <div class="form-row">
                                                <div class="form-group col-3">
                                                    <label for="juniorHighName">Nombre escuela:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="juniorHighName" name="juniorHighName">
                                                    </div>
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="juniorHighAddress">Dirección:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="juniorHighAddress" name="juniorHighAddress">
                                                    </div>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label for="juniorHighFrom">De:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="date" class="form-control" id="juniorHighFrom" name="juniorHighFrom">
                                                    </div>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label for="juniorHighTo">A:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="date" class="form-control" id="juniorHighTo" name="juniorHighTo">
                                                    </div>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label for="juniorHighDegree">Titulo recibido:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="juniorHighDegree" name="juniorHighDegree">
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="highSchool">Preparatoria:</label>
                                            <div class="form-row">
                                                <div class="form-group col-3">
                                                    <label for="highSchoolName">Nombre escuela:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="highSchoolName" name="highSchoolName">
                                                    </div>
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="highSchoolAddress">Dirección:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="highSchoolAddress" name="highSchoolAddress">
                                                    </div>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label for="highSchoolFrom">De:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="date" class="form-control" id="highSchoolFrom" name="highSchoolFrom">
                                                    </div>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label for="highSchoolTo">A:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="date" class="form-control" id="highSchoolTo" name="highSchoolTo">
                                                    </div>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label for="highSchoolDegree">Titulo recibido:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="highSchoolDegree" name="highSchoolDegree">
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="professionalSchool">Profesional:</label>
                                            <div class="form-row">
                                                <div class="form-group col-3">
                                                    <label for="professionalSchoolName">Nombre escuela:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="professionalSchoolName" name="professionalSchoolName">
                                                    </div>
                                                </div>
                                                <div class="form-group col-3">
                                                    <label for="professionalSchoolAddress">Dirección:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="professionalSchoolAddress" name="professionalSchoolAddress">
                                                    </div>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label for="professionalSchoolFrom">De:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="date" class="form-control" id="professionalSchoolFrom" name="professionalSchoolFrom">
                                                    </div>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label for="professionalSchoolTo">A:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="date" class="form-control" id="professionalSchoolTo" name="professionalSchoolTo">
                                                    </div>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label for="professionalSchoolDegree">Titulo recibido:</label>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <input type="text" class="form-control" id="professionalSchoolDegree" name="professionalSchoolDegree">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <label for="otherSchool">Comercial u otras:</label>
                                        <ol class="list-group" id="otherSchool-list">
                                        </ol>
                                        <div class="row">
                                            <div class="col text-center">
                                                <button type="button" class="btn btn-light" id="addSchool">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <label for="currentStudies">Estudios que esta efectuando en la actualidad:</label>
                                        <ol class="list-group" id="currentStudies-list">
                                        </ol>
                                        <div class="row">
                                            <div class="col text-center">
                                                <button type="button" class="btn btn-light" id="addCurrentStudies">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingSeven">
                                <a href="#" class="stretched-link text-dark text-decoration-none " style="position: relative;"
                                   data-toggle="collapse" data-target="#collapseSeven">
                                    <h6 class="mb-0">Conocimientos Generales
                                        <i class="fa" style="float: right;"></i>
                                    </h6>
                                </a>
                            </div>

                            <div id="collapseSeven" class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="form-row">
                                            <div class="form-group col" style="padding-right: 20px;">
                                                <label for="functionsName">Trabajos o funciones que domina:</label>
                                                <ol class="list-group" id="functions-list">
                                                </ol>
                                                <div class="col text-center">
                                                    <button type="button" class="btn btn-light btn-sm" id="addFunction" style="height: 32px;">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="form-group col" style="padding-right: 20px;">
                                                <label for="softwareName">Software que conoce:</label>
                                                <ol class="list-group" id="software-list">
                                                </ol>
                                                <div class="col text-center">
                                                    <button type="button" class="btn btn-light btn-sm" id="addSoftware" style="height: 32px;">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="form-group col">
                                                <label for="languageName">Idiomas que domina:</label>
                                                <ol class="list-group" id="languages-list">
                                                </ol>
                                                <div class="col text-center" >
                                                    <button type="button" class="btn btn-light btn-sm" id="addlanguage" style="height: 32px;">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingEight">
                                <a href="#" class="stretched-link text-dark text-decoration-none " style="position: relative;"
                                   data-toggle="collapse" data-target="#collapseEight">
                                    <h6 class="mb-0">Empleos anteriores
                                        <i class="fa" style="float: right;"></i>
                                    </h6>
                                </a>
                            </div>

                            <div id="collapseEight" class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <ol class="list-group" id="previousJobs-list">
                                        </ol>
                                        <div class="col text-center" >
                                            <button type="button" class="btn btn-light btn-sm" id="addPreviousJob" style="height: 32px;">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingNine">
                                <a href="#" class="stretched-link text-dark text-decoration-none " style="position: relative;"
                                   data-toggle="collapse" data-target="#collapseNine">
                                    <h6 class="mb-0">Referencias personales (no incluir a jefes anteriores)
                                        <i class="fa" style="float: right;"></i>
                                    </h6>
                                </a>
                            </div>

                            <div id="collapseNine" class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <ol class="list-group" id="references-list">
                                        </ol>
                                        <div class="col text-center" >
                                            <button type="button" class="btn btn-light btn-sm" id="addReference" style="height: 32px;">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingTen">
                                <a href="#" class="stretched-link text-dark text-decoration-none " style="position: relative;"
                                   data-toggle="collapse" data-target="#collapseTen">
                                    <h6 class="mb-0">Datos generales
                                        <i class="fa" style="float: right;"></i>
                                    </h6>
                                </a>
                            </div>

                            <div id="collapseTen" class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <form id="generalData">
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <div class="form-row">
                                                        <div class="form-group col-4" id="bonded">
                                                            <label for="isBonded">¿Ha estado afianzado?:</label>
                                                            <div class="form-check-inline">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" id="isBonded0" name="isBonded"
                                                                           value="0" checked/>
                                                                    <label class="form-check-label" for="bonded0">No</label>
                                                                </div>
                                                                <div class="form-check form-check-inline text-inline">
                                                                    <div class="input-group input-group-sm">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input class="form-check-input" type="radio" id="isBonded1"
                                                                                       name="isBonded" value="1"/>
                                                                                <label class="form-check-label" for="isBonded1">Si (Agencía):</label>
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" class="form-control" id="isBondedAgency"
                                                                               name="isBondedAgency">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-4" id="unionized">
                                                            <label for="isUnionized">¿Ha estado afiliado a algún sindicado?:</label>
                                                            <div class="form-check-inline">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" id="isUnionized0" name="isUnionized"
                                                                           value="0" checked/>
                                                                    <label class="form-check-label" for="isUnionized0">No</label>
                                                                </div>
                                                                <div class="form-check form-check-inline text-inline">
                                                                    <div class="input-group input-group-sm">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input class="form-check-input" type="radio" id="isUnionized1"
                                                                                       name="isUnionized" value="1"/>
                                                                                <label class="form-check-label" for="isUnionized1">Si (Agencía):</label>
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" class="form-control" id="isUnionizedUnion"
                                                                               name="isUnionizedUnion">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-4">
                                                            <label for="startingDate">¿Fecha en que podría presentarse a trabajar?:</label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input type="date" class="form-control input-sm" id="startingDate"
                                                                       name="startingDate">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-4" id="insured">
                                                            <label for="isInsured">¿Tiene seguro de vida?:</label>
                                                            <div class="form-check-inline">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" id="isInsured0" name="isInsured"
                                                                           value="0" checked/>
                                                                    <label class="form-check-label" for="isInsured0">No</label>
                                                                </div>
                                                                <div class="form-check form-check-inline text-inline">
                                                                    <div class="input-group input-group-sm">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input class="form-check-input" type="radio" id="isInsured1"
                                                                                       name="isInsured" value="1"/>
                                                                                <label class="form-check-label" for="isInsured1">Si (Agencía):</label>
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" class="form-control" id="isInsuredAgency"
                                                                               name="isInsuredAgency"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-4" id="travel">
                                                            <label for="canTravel">¿Puede viajar?:</label>
                                                            <div class="form-check-inline">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" id="canTravel0" name="canTravel"
                                                                           value="0" checked/>
                                                                    <label class="form-check-label" for="canTravel0">No</label>
                                                                </div>
                                                                <div class="form-check form-check-inline text-inline">
                                                                    <div class="input-group input-group-sm">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input class="form-check-input" type="radio" id="canTravel1"
                                                                                       name="canTravel" value="1"/>
                                                                                <label class="form-check-label" for="canTravel1">Si (Razon):</label>
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" class="form-control" id="canTravelReason"
                                                                               name="canTravelReason"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-4" id="canMove">
                                                            <label for="canMove">¿Esta dispuesto a cambiar de lugar de residencia?:</label>
                                                            <div class="form-check-inline">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" id="canMove0" name="canMove"
                                                                           value="0" checked/>
                                                                    <label class="form-check-label" for="canMove0">No</label>
                                                                </div>
                                                                <div class="form-check form-check-inline text-inline">
                                                                    <div class="input-group input-group-sm">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input class="form-check-input" type="radio" id="canMove1"
                                                                                       name="canMove" value="1"/>
                                                                                <label class="form-check-label" for="canMove1">Si (Razon):</label>
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" class="form-control" id="canMoveReason"
                                                                               name="canMoveReason"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <label for="workingRelatives">¿Tiene parientes trabajando en esta empresa?:</label>
                                        <ol class="list-group" id="workingRelatives-list">
                                        </ol>
                                        <div class="col text-center" >
                                            <button type="button" class="btn btn-light btn-sm" id="addWorkingRelatives" style="height: 32px;">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingEleven">
                                <a href="#" class="stretched-link text-dark text-decoration-none " style="position: relative;"
                                   data-toggle="collapse" data-target="#collapseEleven">
                                    <h6 class="mb-0">Datos económicos
                                        <i class="fa" style="float: right;"></i>
                                    </h6>
                                </a>
                            </div>

                            <div id="collapseEleven" class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="container">
                                        <form id="economicData">
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <div class="form-row">
                                                        <div class="form-group col-4" id="workingSpouse">
                                                            <label for="workingSpouse">¿Su conyuge trabaja?:</label>
                                                            <div class="form-check-inline">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" id="workingSpouse0" name="workingSpouse"
                                                                           value="0" checked/>
                                                                    <label class="form-check-label" for="workingSpouse0">No</label>
                                                                </div>
                                                                <div class="form-check form-check-inline text-inline">
                                                                    <div class="input-group input-group-sm">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input class="form-check-input" type="radio" id="workingSpouse1"
                                                                                       name="workingSpouse" value="1"/>
                                                                                <label class="form-check-label" for="workingSpouse1">Si (Percepción Mensual):</label>
                                                                            </div>
                                                                        </div>
                                                                        <input type="number" class="form-control" id="workingSpouseSalary"
                                                                               name="workingSpouseSalary" value="0.0">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-4" id="ownedHouse">
                                                            <label for="ownedHouse">¿Tiene casa propia?:</label>
                                                            <div class="form-check-inline">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" id="ownedHouse0" name="ownedHouse"
                                                                           value="0" checked/>
                                                                    <label class="form-check-label" for="ownedHouse0">No</label>
                                                                </div>
                                                                <div class="form-check form-check-inline text-inline">
                                                                    <div class="input-group input-group-sm">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input class="form-check-input" type="radio" id="ownedHouse1"
                                                                                       name="ownedHouse" value="1"/>
                                                                                <label class="form-check-label" for="ownedHouse1">Si (Valor Aprox.):</label>
                                                                            </div>
                                                                        </div>
                                                                        <input type="number" class="form-control" id="ownedHouseValue"
                                                                               name="ownedHouseValue" value="0.0">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-4" id="payRent">
                                                            <label for="payRent">¿Paga renta?:</label>
                                                            <div class="form-check-inline">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" id="payRent0" name="payRent"
                                                                           value="0" checked/>
                                                                    <label class="form-check-label" for="payRent0">No</label>
                                                                </div>
                                                                <div class="form-check form-check-inline text-inline">
                                                                    <div class="input-group input-group-sm">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input class="form-check-input" type="radio" id="payRent1"
                                                                                       name="payRent" value="1"/>
                                                                                <label class="form-check-label" for="payRent1">Si (Renta Mensual.):</label>
                                                                            </div>
                                                                        </div>
                                                                        <input type="number" class="form-control" id="payRentValue"
                                                                               name="payRentValue" value="0.0">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-4" id="ownCar">
                                                            <label for="ownCar">¿Tiene automovil propio?:</label>
                                                            <div class="form-check-inline">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" id="ownCar0" name="ownCar"
                                                                           value="0" checked/>
                                                                    <label class="form-check-label" for="ownCar0">No</label>
                                                                </div>
                                                                <div class="form-check form-check-inline text-inline">
                                                                    <div class="input-group input-group-sm">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input class="form-check-input" type="radio" id="ownCar1"
                                                                                       name="ownCar" value="1"/>
                                                                                <label class="form-check-label" for="ownCar1">Si (Modelo):</label>
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" class="form-control" id="ownCarModel"
                                                                               name="ownCarModel">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-4" id="hasDebts">
                                                            <label for="hasDebts">¿Tiene deudas?:</label>
                                                            <div class="form-check-inline">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" id="hasDebts0" name="hasDebts"
                                                                           value="0" checked/>
                                                                    <label class="form-check-label" for="hasDebts0">No</label>
                                                                </div>
                                                                <div class="form-check form-check-inline text-inline">
                                                                    <div class="input-group input-group-sm">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input class="form-check-input" type="radio" id="hasDebts1"
                                                                                       name="hasDebts" value="1"/>
                                                                                <label class="form-check-label" for="hasDebts1">Si (Importe):</label>
                                                                            </div>
                                                                        </div>
                                                                        <input type="number" class="form-control" id="hasDebtsValue"
                                                                               name="hasDebtsValue" value="0.0">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-4" id="monthlyExpenses">
                                                            <label for="monthlyExpenses">¿A cuanto ascienden sus gastos mensuales?:</label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">$</span>
                                                                </div>
                                                                <input type="number" class="form-control" id="monthlyExpenses"
                                                                       name="monthlyExpenses" value="0.0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <label for="otherIncome">Otros ingresos:</label>
                                        <ol class="list-group" id="otherIncome-list">
                                        </ol>
                                        <div class="col text-center" >
                                            <button type="button" class="btn btn-light btn-sm" id="addOtherIncome" style="height: 32px;">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="save" style="width:100%; text-align:center;">
                            <button type="button" id="close" class="btn btn-lg btn-danger">Cerrar</button>
                            <button type="button" id="submit" class="btn btn-lg btn-success">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <!-- /App Content -->
    </div>
    <!-- /Container app main -->
</div>
<!-- /Full Container -->
</body>
</html>