document.addEventListener('DOMContentLoaded', async () => {

    await axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/definedOptions`)
        .then(response => {
            const data = response.data
            for (const value in data){
                const rows = data[value].map(option => (
                    `<option value="${option.id}">${option.name}</option>`
                ))
                const element = document.querySelector(`#${value}`)
                element.innerHTML = rows.join('')
            }
            $('#nationality').selectpicker('refresh')
            $('#nationality').selectpicker({
                liveSearch: true,
                liveSearchNormalize: true,
                size: 5
            });
        })
        .catch(e => {
            console.log(e)
        })

    const department = document.querySelector('#department')

    department.addEventListener('change', event => {
        const id = department.value
        axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/positions?department=${id}`)
            .then(response => {
                const data = response.data
                const rows = data.map(option => (`<option value="${option.id}">${option.positionName}</option>`))
                const element = document.querySelector(`#position`)
                element.innerHTML = rows.join('')
                $('#position').selectpicker('refresh')
                $('#position').selectpicker({
                    liveSearch: true,
                    liveSearchNormalize: true,
                    size: 5
                });
            })
            .catch(e => {
                console.log(e)
            })
    })

    await axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/departments`)
        .then(response => {
            const data = response.data
            const rows = data.map(option => (`<option value="${option.id}">${option.name}</option>`))
            department.innerHTML = rows.join('')
            $('#department').selectpicker('refresh')
            $('#department').selectpicker({
                liveSearch: true,
                liveSearchNormalize: true,
                size: 5
            });
            const id = department.value
            axios.get(`http://${window.location.hostname}/erp_modulos/rh/Api/positions?department=${id}`)
                .then(response => {
                    const data = response.data
                    const rows = data.map(option => (`<option value="${option.id}">${option.positionName}</option>`))
                    const element = document.querySelector(`#position`)
                    element.innerHTML = rows.join('')
                    $('#position').selectpicker('refresh')
                    $('#position').selectpicker({
                        liveSearch: true,
                        liveSearchNormalize: true,
                        size: 5
                    });
                })
                .catch(e => {
                    console.log(e)
                })
        })
        .catch(e => {
            console.log(e)
        })

    const postal_code = document.querySelector('#postalCode')

    postal_code.addEventListener('change', event => {
        setTimeout(
            axios.get(`https://api-sepomex.hckdrk.mx/query/info_cp/${postal_code.value}?type=simplified`)
                .then(response => {
                    const data = response.data.response
                    const obj = {
                        country: data.pais,
                        city: `${data.ciudad},${data.estado}`
                    }
                    singleValueSetter(obj)
                    const suburb = document.querySelector('#suburb')
                    const options = data.asentamiento.map((data, id) => (
                        `<option id="suburb${id}" value="${data}">${data}</option>`
                    ));
                    suburb.innerHTML = options.join('')
                    $('#suburb').selectpicker('refresh')
                    $('#suburb').selectpicker({
                        liveSearch: true,
                        liveSearchNormalize: true,
                        size: 5
                    });
                })
                .catch(e => {
                    const data = e.response.data
                    const error = [{
                        error: data.code_error,
                        field: 'postalCode',
                        message: data.error_message
                    }]
                    handleErrors({ form:'personalData', data:error })
                })
        , 1000)
    })

    const add_children_btn = document.querySelector('#addChildren')

    add_children_btn.addEventListener('click', event => {
        const children_list = document.querySelector('#children-list')
        const number = children_list.querySelectorAll('li').length === 0 ? 0 : children_list.querySelectorAll('li').length + 1
        const row = itemsFactory(number, 'children')
        children_list.insertAdjacentHTML('beforeend', row)
    })

    const add_school_btn = document.querySelector('#addSchool')

    add_school_btn.addEventListener('click', event => {
        const otherSchool_list = document.querySelector('#otherSchool-list')
        const number = otherSchool_list.querySelectorAll('li').length === 0 ? 0 : otherSchool_list.querySelectorAll('li').length + 1
        const row = itemsFactory(number, 'school')
        otherSchool_list.insertAdjacentHTML('beforeend', row)
    })

    const add_studies_btn = document.querySelector('#addCurrentStudies')

    add_studies_btn.addEventListener('click', event => {
        const studies_list = document.querySelector('#currentStudies-list')
        const number = studies_list.querySelectorAll('li').length === 0 ? 0 : studies_list.querySelectorAll('li').length + 1
        const row = itemsFactory(number, 'study')
        studies_list.insertAdjacentHTML('beforeend', row)
    })

    const add_function_btn = document.querySelector('#addFunction')

    add_function_btn.addEventListener('click', event => {
        const functions_list = document.querySelector('#functions-list')
        const number = functions_list.querySelectorAll('li').length === 0 ? 0 : functions_list.querySelectorAll('li').length + 1
        const row = itemsFactory(number, 'function')
        functions_list.insertAdjacentHTML('beforeend', row)
    })

    const add_software_btn = document.querySelector('#addSoftware')

    add_software_btn.addEventListener('click', event => {
        const software_list = document.querySelector('#software-list')
        const number = software_list.querySelectorAll('li').length === 0 ? 0 : software_list.querySelectorAll('li').length + 1
        const row = itemsFactory(number, 'software')
        software_list.insertAdjacentHTML('beforeend', row)
    })

    const add_language_btn = document.querySelector('#addlanguage')

    add_language_btn.addEventListener('click', event => {
        const languages_list = document.querySelector('#languages-list')
        const number = languages_list.querySelectorAll('li').length === 0 ? 0 : languages_list.querySelectorAll('li').length + 1
        const row = itemsFactory(number, 'language')
        languages_list.insertAdjacentHTML('beforeend', row)
    })

    const add_previous_job_btn = document.querySelector('#addPreviousJob')

    add_previous_job_btn.addEventListener('click', event => {
        const previousJobs_list = document.querySelector('#previousJobs-list')
        const number = previousJobs_list.querySelectorAll('li').length === 0 ? 0 : previousJobs_list.querySelectorAll('li').length + 1
        const row = itemsFactory(number, 'previousJob')
        previousJobs_list.insertAdjacentHTML('beforeend', row)
    })

    const add_reference_btn = document.querySelector('#addReference')

    add_reference_btn.addEventListener('click', event => {
        const references_list = document.querySelector('#references-list')
        const number = references_list.querySelectorAll('li').length === 0 ? 0 : references_list.querySelectorAll('li').length + 1
        const row = itemsFactory(number, 'reference')
        references_list.insertAdjacentHTML('beforeend', row)
    })

    const add_working_relatives_btn = document.querySelector('#addWorkingRelatives')

    add_working_relatives_btn.addEventListener('click', event => {
        const workingRelatives_list = document.querySelector('#workingRelatives-list')
        const number = workingRelatives_list.querySelectorAll('li').length === 0 ? 0 : workingRelatives_list.querySelectorAll('li').length + 1
        const row = itemsFactory(number, 'workingRelative')
        workingRelatives_list.insertAdjacentHTML('beforeend', row)
    })

    const add_other_income_btn = document.querySelector('#addOtherIncome')

    add_other_income_btn.addEventListener('click', event => {
        const otherIncome_list = document.querySelector('#otherIncome-list')
        const number = otherIncome_list.querySelectorAll('li').length === 0 ? 0 : otherIncome_list.querySelectorAll('li').length + 1
        const row = itemsFactory(number, 'otherIncome')
        otherIncome_list.insertAdjacentHTML('beforeend', row)
    })

    const close = document.querySelectorAll('#close')

    close.forEach(exit => {
        exit.addEventListener('click', event => {
            const response = confirm('¿Está seguro que desea salir?')
            if(response){
                history.back();
            }
        })
    })

    const submits = document.querySelectorAll('#submit')

    const forms = document.querySelectorAll('form')

    submits.forEach(submit => {
        submit.addEventListener('click', event => {
            const obj = {}
            forms.forEach(form => {
                const id = form.getAttribute('id')
                const form_data = new FormData(form)
                const data = Object.fromEntries(form_data)
                obj[id] = data
            })

            const children = document.querySelectorAll('.children')

            if(children.length){
                const data = Array.from(children).map(child => {
                    const form_data = new FormData(child)
                    return Object.fromEntries(form_data)
                })
                obj['relativesData'] = {
                    ...obj.relativesData,
                    children: data
                }
            }

            console.log(obj)

            const schools = document.querySelectorAll('.schools')

            if(schools.length){
                const data = Array.from(schools).map(school => {
                    const form_data = new FormData(school)
                    return Object.fromEntries(form_data)
                })
                obj['scholarData'] = {
                    ...obj.scholarData,
                    otherSchools: data
                }
            }

            const studies = document.querySelectorAll('.studies')

            if(studies.length){
                const data = Array.from(studies).map(study => {
                    const form_data = new FormData(study)
                    return Object.fromEntries(form_data)
                })
                obj['scholarData'] = {
                    ...obj.scholarData,
                    currentStudies: data
                }
            }

            const functions = document.querySelectorAll('.functions')

            if(functions.length){
                const data = Array.from(functions).map(func => {
                    const form_data = new FormData(func)
                    return Object.fromEntries(form_data)
                })
                obj['knowledgeData'] = {
                    ...obj.knowledgeData,
                    functions: data
                }
            }

            const softwares = document.querySelectorAll('.softwares')

            if(softwares.length){
                const data = Array.from(softwares).map(software => {
                    const form_data = new FormData(software)
                    return Object.fromEntries(form_data)
                })
                obj['knowledgeData'] = {
                    ...obj.knowledgeData,
                    softwares: data
                }
            }

            const languages = document.querySelectorAll('.languages')

            if(languages.length){
                const data = Array.from(languages).map(language => {
                    const form_data = new FormData(language)
                    return Object.fromEntries(form_data)
                })
                obj['knowledgeData'] = {
                    ...obj.knowledgeData,
                    languages: data
                }
            }

            const previousJobs = document.querySelectorAll('.previousJobs')

            if(previousJobs.length){
                const data = Array.from(previousJobs).map(previousJob => {
                    const form_data = new FormData(previousJob)
                    return Object.fromEntries(form_data)
                })
                obj['previousJobsData'] = data
            }

            const references = document.querySelectorAll('.references')

            if(references.length){
                const data = Array.from(references).map(reference => {
                    const form_data = new FormData(reference)
                    return Object.fromEntries(form_data)
                })
                obj['personalReferencesData'] = data
            }

            const workingRelatives = document.querySelectorAll('.workingRelatives')

            if(workingRelatives.length){
                const data = Array.from(workingRelatives).map(workingRelative => {
                    const form_data = new FormData(workingRelative)
                    return Object.fromEntries(form_data)
                })
                obj['generalData'] = {
                    ...obj.generalData ,
                    workingRelatives: data
                }
            }

            const otherIncomes = document.querySelectorAll('.otherIncomes')

            if(otherIncomes.length){
                const data = Array.from(otherIncomes).map(otherIncome => {
                    const form_data = new FormData(otherIncome)
                    return Object.fromEntries(form_data)
                })
                obj['economicData'] = {
                    ...obj.economicData,
                    otherIncomes: data
                }
            }

            console.log(obj)

            axios.post(`http://${window.location.hostname}/erp_modulos/rh/Api/employees`, obj)
                .then(response => {
                    if (response.data === 1) {
                        location.reload()
                    }
                })
                .catch(e => {
                    handleErrors({ data: e.response.data})
                    const error = document.querySelector('.is-invalid')
                    error.scrollIntoView({
                        behavior: "smooth",
                        block:    "end",
                    })
                })

        })
    })

    const btn_close = document.querySelectorAll('.close')

    btn_close.forEach(btn => {
        btn.addEventListener('click', event => {
            btn.parentElement.remove()
        })
    })



}, true)