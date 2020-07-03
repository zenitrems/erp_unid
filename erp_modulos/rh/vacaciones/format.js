document.addEventListener('DOMContentLoaded', async () => {

    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');
    const employeeId = document.querySelector('#employee').value

    const getDate = (stringDate) => {
        const date = new Date(stringDate.replace(/-/g, '\/'));
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString("es-ES", options)
    }

    const toTitleCase = (string) => {
        return string.replace(
            /\w\S*/g,
            (txt) => (txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase())
        );
    }

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
        const available_days = document.querySelector('#availableDays')
        available_days.innerHTML = eyear
        return eyear.innerHTML = rows.join('')
    }

    if(id){
        await  axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/vacations/${id}`)
            .then(response => {
                const data = response.data
                if(employeeId !== data.employeeId && employeeId !== data.vacationSupervisor) {
                    window.location = `http://${window.location.hostname}/erp_modulos/rh/vacaciones/`
                }
                const date = document.querySelector('#date')
                date.innerHTML = `A ${getDate(data.vacationRequested)}`
                axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/employees/${data.vacationSupervisor}`)
                    .then(response => {
                        const supervisorName = document.querySelector('#supervisorName')
                        supervisorName.innerHTML = toTitleCase(response.data.lastname.concat(' ', response.data.mothersLastname, ' ', response.data.name))
                        const supervisorPosition = document.querySelector('#supervisorPosition')
                        supervisorPosition.innerHTML = toTitleCase(response.data.positionName)
                    })
                    .catch(e => {
                        console.log(e)
                    })
                axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/employees/${data.employeeId}`)
                    .then(response => {
                        const days = document.querySelector('#days')
                        days.innerHTML = availableDays(response.data)
                    })
                    .catch(e => {
                        console.log(e)
                    })

                const from = document.querySelector('#from')
                from.innerHTML = getDate(data.vacationFrom)

                const to = document.querySelector('#to')
                to.innerHTML = getDate(data.vacationTo)

                const name = document.querySelector('#name')
                name.innerHTML = toTitleCase(data.employeeLastname.concat(' ', data.employeeMothersLastname, ' ', data.employeeName))

                const position = document.querySelector('#position')
                position.innerHTML = toTitleCase(data.employeePositionName)
            })
            .catch(e => {
                console.log(e)
            })
    }

    const back = document.querySelector('#back')
    const print = document.querySelector('#print')
    const download = document.querySelector('#download')

    back.addEventListener('click', evt => {
        window.location = `http://${window.location.hostname}/erp_modulos/rh/vacaciones/`
    })

    download.addEventListener('click', evt => {

        var draw = kendo.drawing;

        draw.drawDOM($("#format-body"))
            .done(function(root) {
                draw.pdf.saveAs(root, `solicitud-vacaciones-${id}.pdf`);
            });
    })

    print.addEventListener('click', evt => {
        $("#format-body").printThis()
    });


}, true)