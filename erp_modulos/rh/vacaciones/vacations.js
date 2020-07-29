document.addEventListener('DOMContentLoaded', async () => {

    const employee = document.querySelector('#employee')
    const userId = document.querySelector('#user').value
    const employeeId = document.querySelector('#employeeId')
    const vacationSupervisor = document.querySelector('#vacationSupervisor')
    const table = document.querySelector('#table-vac-body')
    const newVacacation = document.querySelector('#new')
    const form = document.querySelector('#form-vac')

    const getDate = (stringDate) => {
        const date = new Date(stringDate.replace(/-/g, '\/'));
        const options = {year: 'numeric', month: 'long', day: 'numeric'};
        return date.toLocaleDateString("es-ES", options)
    }

    const reset = () => {
        $("#vacationSupervisor").val($("#vacationSupervisor option:first").val()).selectpicker('refresh');
        const day = moment().add(1, 'days')
        $('#vacationDate').data('daterangepicker').setStartDate(day.format('L'));
        $('#vacationDate').data('daterangepicker').setEndDate(day.add(1, 'days').format('L'));
    }

    newVacacation.addEventListener('click', event => {
        reset()
        submit.setAttribute('data-method', 'submit')
        form.setAttribute('data', '')
        document.querySelector('#submit-label').innerHTML = 'Crear solicitud de vacaciones'

    })

    const employeeData = await axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/employees/${employee.value}`)
        .then(response => {
            employeeId.value = `${response.data.lastname.concat(' ', response.data.mothersLastname, ' ', response.data.name)} (${response.data.number})`
            return response.data.recruitmentDate ? response.data : window.location = `http://${window.location.hostname}/403.html`
        })
        .catch(e => {
            console.log(e)
            return null
        })

    await axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/positions/${employeeData.position}`)
        .then(response => {
            if (response.data.positionIsSupervisor !== "1") {
                const vacationPending = document.querySelector('#vacationPending')
                vacationPending.remove()
            }
        })
        .catch(e => {
            console.log(e)
        })

    const vacationsData = await axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/vacations?employee=${employeeData.id}`)
        .then(response => (response.data))
        .catch(e => {
            console.log(e)
            return null
        })

    const supervisorsData = await axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/employees?department=${employeeData.department}&supervisors=1`)
        .then(response => (response.data))
        .catch(e => {
            console.log(e)
        })

    const availableDays = (employeeData) => {
        const edate = new Date(employeeData.recruitmentDate)
        const eyear = new Date().getFullYear() - edate.getFullYear();

        if (eyear === 1) {
            return eyear * 6
        }
        if (eyear > 1 && eyear < 5) {
            return 6 + ((eyear - 1) * 2)
        }
        if (eyear >= 5) {
            return 12 + (parseInt(eyear / 5) * 2)
        }
        return eyear
    }

    const rows = supervisorsData.map(option => {
        if (option.id !== employeeData.id) {
            return (`<option value="${option.id}">${option.lastname.concat(' ', option.mothersLastname, ' ', option.name)} (${option.number})</option>`)
        }
    })

    vacationSupervisor.innerHTML = rows.join('')
    const days = availableDays(employeeData)
    const available_days = document.querySelector('#availableDays')
    available_days.innerHTML = days
    $('#vacationSupervisor').selectpicker('refresh')
        .selectpicker({
            liveSearch: true,
            liveSearchNormalize: true,
            size: 5
        });

    $('#vacationDate').daterangepicker({
        isInvalidDate: (date) => {
            return (date.day() === 0 || date.day() === 6 || date.format('L') === moment().format('L'));
        },
        maxSpan: {
            "days": days
        },
        autoApply: true,
        minDate: moment().add(1, 'days'),
    }, (startDate, endDate, period) => {
        $('#vacationDate').val(startDate.format('L') + ' – ' + endDate.format('L'))
    });

    const manageVacation = () => {
        const btn_approve = document.querySelectorAll('#btn-approve')
        btn_approve.forEach(btn => {
            btn.addEventListener('click', event => {
                const id = btn.getAttribute('data')
                axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/vacations/${id}`)
                    .then(response => {
                        const data = response.data
                        const name = `${data.employeeLastname.concat(' ', data.employeeMothersLastname, ' ', data.employeeName)}`
                        var start = moment(data.vacationFrom);
                        var end = moment(data.vacationTo);
                        const days = end.diff(start, "days")
                        Swal.fire({
                            title: '<strong>Aprobar solicitud</strong>',
                            icon: 'info',
                            html: `<p><strong>Solicitado:</strong> ${getDate(data.vacationRequested)}</p>
                                   <p><strong>Empleado:</strong> ${name}</p>
                                   <p><strong>De fecha:</strong> ${getDate(data.vacationFrom)}</p>
                                   <p><strong>A fecha:</strong> ${getDate(data.vacationTo)}</p>
                                   <p><strong>Días solicitados:</strong> ${days}</p>
                                    `,
                            showCloseButton: true,
                            showCancelButton: true,
                            focusConfirm: false,
                            confirmButtonText:
                                '<i class="fa fa-thumbs-up"></i> Aprobar!',
                            confirmButtonAriaLabel: 'Thumbs up, great!',
                            cancelButtonText:
                                '<i class="fa fa-thumbs-down"></i>',
                            cancelButtonAriaLabel: 'Thumbs down'
                        }).then((result) => {
                            if (result.value) {
                                const putData = {}
                                putData.vacationTo = data.vacationTo
                                putData.vacationFrom = data.vacationFrom
                                putData.vacationStatus = '1'
                                putData.vacationSupervisor = data.vacationSupervisor
                                axios.put(`http://${window.location.hostname}/erp_modulos/rh/Api/vacations/${id}`, putData)
                                    .then(response => {
                                        if (response.data === 1) {
                                            Swal.fire(
                                                'Aprobado!',
                                            )
                                            location.reload()
                                        }
                                    })
                                    .catch(e => {
                                        handleErrors({form: 'form-vac', data: e.response.data})
                                    })
                            } else if (result.dismiss === Swal.DismissReason.cancel)
                                Swal.fire({
                                    title: 'Motivo de rechazo',
                                    input: 'textarea',
                                    inputAttributes: {
                                        autocapitalize: 'off'
                                    },
                                    showCancelButton: false,
                                    confirmButtonText: 'Enviar',
                                    allowOutsideClick: false,
                                    preConfirm: (comment) => {
                                        const putData = {}
                                        putData.vacationTo = data.vacationTo
                                        putData.vacationFrom = data.vacationFrom
                                        putData.vacationStatus = '2'
                                        putData.vacationSupervisor = data.vacationSupervisor
                                        putData.vacationRejectedComment = comment
                                        console.log(putData)
                                        axios.put(`http://${window.location.hostname}/erp_modulos/rh/Api/vacations/${id}`, putData)
                                            .then(response => {
                                                if (response.data === 1) {
                                                    Swal.fire(
                                                        'Rechazado!',
                                                    )
                                                    location.reload()
                                                }
                                            })
                                            .catch(e => {
                                                handleErrors({form: 'form-vac', data: e.response.data})
                                            })
                                    },
                                })
                        })
                    })
                    .catch(e => {
                        console.log(e)
                    })
            })
        })
    }

    const vacationRequested = (vacationsData) => {
        const rows = vacationsData.map((data, id) => {
            if (data.employeeId === employeeData.id && data.vacationStatus === "0") {
                return (
                    `<tr>
                    <td scope="row" style="text-align: center"></td>
                    <td data=${data.id}>${data.employeeLastname.concat(' ', data.employeeMothersLastname, ' ', data.employeeName)}</td>
                    <td data=${data.id}>${data.vacationFrom}</td>
                    <td data=${data.id}>${data.vacationTo}</td>
                    <td data=${data.id}>${data.departmentName}</td>
                    <td>
                    <a href="http://${window.location.hostname}/erp_modulos/rh/vacaciones/format.php?id=${data.id}"><button class="btn btn-sm btn-info" id="btn-view" data=${data.id}  data-tip="tooltip" title="Detalle"><i class="fas fa-eye"></i></button></a>
                    <button class="btn btn-sm btn-primary" id="btn-edit" data-toggle="modal" data-name="${data.employeeLastname.concat(' ', data.employeeMothersLastname, ' ', data.employeeName)}" data-tip="tooltip" title="Editar" data-target="#modal-submit" data=${data.id}><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger" id="btn-delete" data-toggle="modal" data-name="${data.employeeLastname.concat(' ', data.employeeMothersLastname, ' ', data.employeeName)}" data-tip="tooltip" title="Eliminar" data-target="#modal-delete" data=${data.id}><i class="fas fa-trash-alt"></i></button>
                    </td>
                    </tr>`
                )
            }
        });
        table.innerHTML = rows.join('')
        $('#table-vac').bootstrapTable({
            pagination: true,
            search: true
        }).bootstrapTable('refresh')
        $('[data-tip="tooltip"]').tooltip()
    }

    const vacationPending = (vacationsData) => {
        const rows = vacationsData.map((data, id) => {
            if (data.employeeId !== employeeData.id && data.vacationStatus === "0") {
                return (
                    `<tr>
                    <td scope="row" style="text-align: center"></td>
                    <td data=${data.id}>${data.employeeLastname.concat(' ', data.employeeMothersLastname, ' ', data.employeeName)}</td>
                    <td data=${data.id}>${data.vacationFrom}</td>
                    <td data=${data.id}>${data.vacationTo}</td>
                    <td data=${data.id}>${data.departmentName}</td>
                    <td>
                    <a href="http://${window.location.hostname}/erp_modulos/rh/vacaciones/format.php?id=${data.id}"><button class="btn btn-sm btn-info" id="btn-view" data=${data.id}  data-tip="tooltip" title="Detalle"><i class="fas fa-eye"></i></button></a>
                    <button class="btn btn-sm btn-warning" id="btn-approve" data-name="${data.employeeLastname.concat(' ', data.employeeMothersLastname, ' ', data.employeeName)}" data-tip="tooltip" title="Validar" data=${data.id}><i class="fas fa-thumbs-up"></i> <i class="fas fa-thumbs-down fa-flip-horizontal"></i></button>
                    </td>
                    </tr>`
                )
            }
        });
        table.innerHTML = rows.join('')
        $('#table-vac').bootstrapTable({
            pagination: true,
            search: true
        }).bootstrapTable('refresh')
        $('[data-tip="tooltip"]').tooltip()
    }

    const vacationValidated = (vacationsData) => {
        const rows = vacationsData.map((data, id) => {
            if (data.vacationStatus !== "0") {
                return (
                    `<tr class="${data.vacationStatus === "1" ? 'table-success' : 'table-danger'}">
                    <td scope="row" style="text-align: center"></td>
                    <td data=${data.id}>${data.employeeLastname.concat(' ', data.employeeMothersLastname, ' ', data.employeeName)}</td>
                    <td data=${data.id}>${data.vacationFrom}</td>
                    <td data=${data.id}>${data.vacationTo}</td>
                    <td data=${data.id}>${data.departmentName}</td>
                    <td>
                    <a href="http://${window.location.hostname}/erp_modulos/rh/vacaciones/format.php?id=${data.id}"><button class="btn btn-sm btn-info" id="btn-view" data=${data.id}  data-tip="tooltip" title="Detalle"><i class="fas fa-eye"></i></button></a>
                    </td>
                    </tr>`
                )
            }

                });
                table.innerHTML = rows.join('')
                $('#table-vac').bootstrapTable({
                    pagination: true,
                    search: true
                }).bootstrapTable('refresh')
                $('[data-tip="tooltip"]').tooltip()
            }

            vacationRequested(vacationsData)

            const vacationDisplay = document.querySelectorAll('[name="vacationDisplay"]')

            vacationDisplay.forEach(display => {
                display.addEventListener('click', event => {
                    switch (document.querySelector('input[name="vacationDisplay"]:checked').value) {

                        case 'vacationRequested':
                            vacationRequested(vacationsData)
                            break;

                        case 'vacationPending':
                            vacationPending(vacationsData)
                            manageVacation()
                            break;

                        case 'vacationValidated' :
                            vacationValidated(vacationsData)
                            break;

                        default:
                            break;
                    }
                })
            })

            const submit = document.querySelector('#submit')

            const postData = (form_data) => {
                const data = Object.fromEntries(form_data)
                data.employeeId = employeeData['id']
                data.vacationRequested = new Date().toISOString().slice(0, 10)
                data.vacationFrom = $("#vacationDate").data('daterangepicker').startDate.format('YYYY-MM-DD')
                data.vacationTo = $("#vacationDate").data('daterangepicker').endDate.format('YYYY-MM-DD')
                data.vacationUser = userId

                console.log(data)

                axios.post(
            `http://${window.location.hostname}/erp_modulos/rh/Api/vacations`, data)
            .then(response => {
            if (response.data === 1) {
            location.reload()
            }
            })
            .catch(e => {
            handleErrors({form: 'form-vac', data: e.response.data})
            })
            }

        const updateData = (form_data, id) => {
            const data = Object.fromEntries(form_data)
            data.vacationFrom = $("#vacationDate").data('daterangepicker').startDate.format('YYYY-MM-DD')
            data.vacationTo = $("#vacationDate").data('daterangepicker').endDate.format('YYYY-MM-DD')
            data.vacationStatus = '0'

            console.log(data)

            axios.put(`http://${window.location.hostname}/erp_modulos/rh/Api/vacations/${id}`, data)
                .then(response => {
                    if (response.data === 1) {
                        location.reload()
                    }
                })
                .catch(e => {
                    handleErrors({form: 'form-pos', data: e.response.data})
                })
        }

        submit.addEventListener('click', event => {
            const method = submit.getAttribute('data-method')
            const form_data = new FormData(form)
            switch (method) {
                case 'submit':
                    postData(form_data)
                    break;
                case 'edit':
                    const id = form.getAttribute('data')
                    updateData(form_data, id)
                    break;
            }
        })

        const btn_delete_yes = document.querySelector('#modal-btn-si')

        btn_delete_yes.addEventListener('click', event => {
            const id = btn_delete_yes.getAttribute('data')
            axios.delete(`http://${window.location.hostname}/erp_modulos/rh/Api/vacations/${id}`)
                .then(response => {
                    if (response.data === 1) {
                        location.reload()
                    }
                })
                .catch(e => {
                    console.log(e)
                })
        })

        const btn_delete = document.querySelectorAll('#btn-delete')

        btn_delete.forEach(btn => {
            const id = btn.getAttribute('data')
            const name = btn.getAttribute('data-name')
            btn.addEventListener('click', event => {
                btn_delete_yes.setAttribute('data', id)
                const label = document.querySelector('#confirm-label')
                label.innerHTML = `¿Eliminar la solicitud de ${name}?`
            })
        })

        const btn_delete_no = document.querySelector('#modal-btn-no')

        btn_delete_no.addEventListener('click', event => {
            $("#modal-delete").modal('hide');
        })

        const btn_edit = document.querySelectorAll('#btn-edit')

        btn_edit.forEach(btn => {
            btn.addEventListener('click', event => {
                reset()
                const id = btn.getAttribute('data')
                axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/vacations/${id}`)
                    .then(response => {
                        const data = response.data
                        $('#vacationDate').val(data.vacationFrom + ' – ' + data.vacationTo).selectpicker('refresh');
                        $('#vacationDate').data('daterangepicker').setStartDate(moment(data.vacationFrom).format('L'));
                        $('#vacationDate').data('daterangepicker').setEndDate(moment(data.vacationTo).format('L'));
                        const supervisor = parseInt(data.vacationSupervisor)
                        $("#vacationSupervisor").val(supervisor).selectpicker('refresh')
                        submit.setAttribute('data-method', 'edit')
                        document.querySelector('#submit-label').innerHTML = ' Editar solicitud de vacaciones'
                        form.setAttribute('data', data.id)
                    })
                    .catch(e => {
                        console.log(e)
                    })
            })
        })

    }, true
)