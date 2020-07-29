document.addEventListener('DOMContentLoaded', async () => {

    const table = document.querySelector('#table-pos')

    await axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/positions`)
        .then(response => {
            const rows = response.data.map((data, id) => (
                `<tr style="text-align: justify">
                 <th scope="row" style="text-align: center" id=${id}>${id + 1}</th>
                 <td data=${data.id}>${data.positionName}</td>
                 <td data=${data.id}>${data.departmentName}</td>
                 <td data=${data.id}>${data.positionIsSupervisor == 0 ? '&#10006' : '&#10004'}</td>
                 <td> 
                 <button class="btn btn-sm btn-primary" id="btn-edit" data-toggle="modal" data-name="${data.positionName}" data-tip="tooltip" title="Editar" data-target="#modal-edit" data=${data.id}><i class="fas fa-edit"></i></button>
                 <button class="btn btn-sm btn-danger" id="btn-delete" data-toggle="modal" data-name="${data.positionName}" data-tip="tooltip" title="Eliminar" data-target="#modal-delete" data=${data.id}><i class="fas fa-trash-alt"></i></button>
                 </td>
                 </tr>`
            ));
            table.innerHTML += rows.join('')
            $('#table-pos').bootstrapTable({
                pagination: true,
                search: true
            })
            $('[data-tip="tooltip"]').tooltip()
        })
        .catch(e => {
            console.log(e)
        })

    await axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/departments`)
        .then(response => {
            const data = response.data
            const rows = data.map(option => (`<option value="${option.id}">${option.name}</option>`))
            const element = document.querySelector(`#positionDepartment`)
            const edit_element = document.querySelector(`#edit-positionDepartment`)
            element.innerHTML = rows.join('')
            edit_element.innerHTML = rows.join('')
            $('#positionDepartment').selectpicker({
                liveSearch: true,
                liveSearchNormalize: true,
                size: 5
            });
            $('#edit-positionDepartment').selectpicker({
                liveSearch: true,
                liveSearchNormalize: true,
                size: 5
            });
        })
        .catch(e => {
            console.log(e)
        })

    const submit = document.querySelector('#submit')

    const form =  document.querySelector('#form-pos')

    submit.addEventListener('click', event => {
        const form_data = new FormData(form)
        const data = Object.fromEntries(form_data)
        data.positionIsSupervisor = data.positionIsSupervisor ? data.positionIsSupervisor : 0

        axios.post(`http://${window.location.hostname}/erp_modulos/rh/Api/positions`, data)
            .then(response => {
                if (response.data === 1) {
                    location.reload()
                }
            })
            .catch(e => {
                handleErrors({form:'form-pos', data:e.response.data})
            })
    })

    const btn_delete_yes = document.querySelector('#modal-btn-si')

    btn_delete_yes.addEventListener('click', event => {
        const id = btn_delete_yes.getAttribute('data')
        axios.delete(`http://${window.location.hostname}/erp_modulos/rh/Api/positions/${id}`)
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
            label.innerHTML = `¿Eliminar ${name}?`
        })
    })

    const btn_delete_no = document.querySelector('#modal-btn-no')

    btn_delete_no.addEventListener('click', event => {
        $("#modal-delete").modal('hide');
    })

    const btn_edit = document.querySelectorAll('#btn-edit')

    btn_edit.forEach(btn => {
        btn.addEventListener('click', event => {
            document.querySelector('#form-edit-pos').reset()
            const id = btn.getAttribute('data')

            axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/positions/${id}`)
                .then(response => {
                    const name = response.data.positionName
                    const department = response.data.positionDepartment
                    const supervisor = parseInt(response.data.positionIsSupervisor)
                    const label = document.querySelector('#edit-label')
                    label.innerHTML = `Editar ${name}`
                    const input = document.querySelector('#edit-positionName')
                    input.value = name
                    const select = document.querySelector('#edit-positionDepartment')
                    select.value = department
                    $('#edit-positionDepartment').selectpicker('refresh')
                    const check = document.querySelector('#edit-positionIsSupervisor')
                    check.checked = supervisor
                    $('#edit-name').popover('dispose')
                    input.classList.remove('is-invalid')
                    const edit_form = document.querySelector('#form-edit-pos')
                    edit_form.setAttribute('data', id)
                })
                .catch(e => {
                    console.log(e)
                })
        })
    })

    const submit_edit = document.querySelector('#submit-edit')

    const edit_form = document.querySelector('#form-edit-pos')

    submit_edit.addEventListener('click', event => {
        const form_data = new FormData(edit_form)
        const data = Object.fromEntries(form_data)
        const id = edit_form.getAttribute('data')
        data.positionIsSupervisor = data.positionIsSupervisor ? data.positionIsSupervisor : 0

        axios.put(`http://${window.location.hostname}/erp_modulos/rh/Api/positions/${id}`, data)
            .then(response => {
                if (response.data === 1) {
                    location.reload()
                }
                if (response.data === 0) {
                    $("#modal-edit").modal('hide');
                }
            })
            .catch(e => {
                handleErrors({form: 'form-edit-pos', data: e.response.data})
            })
    })

    /*
        const isSupervisor = document.querySelector('#positionIsSupervisor')

        isSupervisor.addEventListener('click', event => {
            if(isSupervisor.checked){
                const modalBody = document.querySelector('.modal-body')
                const template = '<lable>Puestos que supervisa</lable>'
                modalBody.innerHTML += template
            }
        }
        )

     */


}, true)