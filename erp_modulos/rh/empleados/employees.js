document.addEventListener('DOMContentLoaded', async () => {

    const table = document.querySelector('#table-emp')

    await axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/employees`)
        .then(response => {
            const rows = response.data.map((data, id) => (
                `<tr class="d-flex" style="text-align: justify">
                 <th scope="row" id=${id}>${id + 1}</th>
                 <td class="col-2" data=${data.id}>${data.STATUS}</td>
                 <td class="col" data=${data.id}>${data.position}</td>
                 <td class="col-2" data=${data.id}>${data.lastname}</td>
                 <td class="col-2" data=${data.id}>${data.mothersLastname}</td>
                 <td class="col-2" data=${data.id}>${data.name}</td>
                 <td class="col-2">
                 <button class="btn btn-sm btn-primary" id="btn-edit" data-toggle="modal" data-target="#modal-edit" data=${data.id}  data-name="${data.name}">Editar</button>
                 <button class="btn btn-sm btn-danger" id="btn-delete" data-toggle="modal" data-target="#modal-delete" data=${data.id} data-name="${data.name}">Eliminar</button>
                 </td>
                 </tr>`
            ));
            table.innerHTML += rows.join('')
        })
        .catch(e => {
            console.log(e)
        })

    const btn_delete_yes = document.querySelector('#modal-btn-si')

    btn_delete_yes.addEventListener('click', event => {
        const id = btn_delete_yes.getAttribute('data')
        axios.delete(`http://${window.location.hostname}/erp_modulos/rh/Api/employees/${id}`)
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

}, true)