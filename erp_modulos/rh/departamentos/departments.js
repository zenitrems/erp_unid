document.addEventListener('DOMContentLoaded', async () => {

    const table = document.querySelector('#table-dep')

    await axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/departments`)
        .then(response => {
            const rows = response.data.map((data, id) => (
                `<tr>
                 <th scope="row" id=${id}>${id}</th>
                 <td data=${data.id}>${data.name}</td>
                 <td>
                 <button class="btn btn-sm btn-primary" id="btn-edit" data-toggle="modal" data-target="#modal-edit" data=${data.id}  data-name="${data.name}">Editar</button>
                 <button class="btn btn-sm btn-danger" id="btn-delete" data-toggle="modal" data-target="#modal-delete" data=${data.id} data-name="${data.name}">Eliminar</button>
                 </td>
                 </tr>`
            ));
            table.innerHTML += rows.join('')
            $('#table-dep').bootstrapTable({
                pagination: true
            })
        })
        .catch(e => {
            console.log(e)
        })

    const submit = document.querySelector('#submit')

    const form = document.querySelector('#form-dep')

    submit.addEventListener('click', event => {
        const form_data = new FormData(form)
        const data = Object.fromEntries(form_data)
        data['positionIsSupervisor'] = data['positionIsSupervisor'] ? data['positionIsSupervisor'] : 0

        axios.post(`http://${window.location.hostname}/erp_modulos/rh/Api/departments`, data)
            .then(response => {
                if (response.data === 1) {
                    location.reload()
                }
            })
            .catch(e => {
                handleErrors({form:'form-dep', data:e.response.data})
            })
    })

    const btn_delete_yes = document.querySelector('#modal-btn-si')

    btn_delete_yes.addEventListener('click', event => {
        const id = btn_delete_yes.getAttribute('data')
        axios.delete(`http://${window.location.hostname}/erp_modulos/rh/Api/departments/${id}`)
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

            const id = btn.getAttribute('data')

            axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/departments/${id}`)
                .then(response => {
                    const name = response.data.name
                    const label = document.querySelector('#edit-label')
                    label.innerHTML = `Editar ${name}`
                    const input = document.querySelector('#edit-name')
                    input.value = name
                    $('#edit-name').popover('dispose')
                    input.classList.remove('is-invalid')
                    const edit_form = document.querySelector('#form-edit-dep')
                    edit_form.setAttribute('data', id)
                })
                .catch(e => {
                    console.log(e)
                })
        })
    })

    const submit_edit = document.querySelector('#submit-edit')

    const edit_form = document.querySelector('#form-edit-dep')

    submit_edit.addEventListener('click', event => {
        const form_data = new FormData(edit_form)
        const data = JSON.stringify(Object.fromEntries(form_data))

        const id = edit_form.getAttribute('data')

        axios.put(`http://${window.location.hostname}/erp_modulos/rh/Api/departments/${id}`, data)
            .then(response => {
                if (response.data === 1) {
                    location.reload()
                }
                if (response.data === 0) {
                    $("#modal-edit").modal('hide');
                }
            })
            .catch(e => {
                handleErrors({form: 'form-edit-dep', data: e.response.data})
            })
    })

}, true)