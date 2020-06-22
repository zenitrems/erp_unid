
const itemsFactory = (number, type, $data) => {
    switch (true) {
        case (type === 'children'):
            return(
            `<li class="list-group-item" id="childrenName${number}">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="removeElement(event);">
                    &times;
                </button>
                <form class="children" id="children${number}">
                    <div class="form-row">
                        <div class="form-group col-10">
                            <label for="childrenName${number}">Nombre y apellidos:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="childrenName${number}" name="childrenName">
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <label for="childrenAge${number}">Edad:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="number" class="form-control" id="childrenAge${number}" name="childrenAge">
                            </div>
                        </div>
                    </div>
                </form>
            </li>`
            )
        break;

        case (type === 'school'):
            return(
            `<li class="list-group-item" id="otherSchool${number}">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="removeElement(event)">
                    &times;
                </button>
                 <form class="schools" id="school${number}">
                    <div class="form-row">
                        <div class="form-group col-3">
                            <label for="otherSchoolName${number}">Nombre escuela:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="otherSchoolName${number}" name="otherSchoolName">
                            </div>
                        </div>
                        <div class="form-group col-3">
                            <label for="otherSchoolAddress${number}">Dirección:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="otherSchoolAddress${number}" name="otherSchoolAddress">
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <label for="otherSchoolFrom${number}">De:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="date" class="form-control" id="otherSchoolFrom${number}" name="otherSchoolFrom">
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <label for="otherSchoolTo${number}">A:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="date" class="form-control" id="otherSchoolTo${number}" name="otherSchoolTo">
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <label for="otherSchoolDegree${number}">Titulo recibido:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="otherSchoolDegree${number}" name="otherSchoolDegree">
                            </div>
                        </div>
                    </div>
                </form>
            </li>`
            )
        break;

        case (type === 'study'):
            return(
                `<li class="list-group-item" id="currentStudies${number}">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="removeElement(event)">
                    &times;
                </button>
                <form class="studies" id="currentStudies${number}">
                    <div class="form-row">
                        <div class="form-group col-3">
                            <label for="currentStudiesName${number}">Nombre escuela:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="currentStudiesName${number}" name="currentStudiesName">
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <label for="currentStudiesScheduleFrom${number}">Horario de:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="time" class="form-control" id="currentStudiesScheduleFrom${number}" name="currentStudiesScheduleFrom">
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <label for="currentStudiesScheduleTo${number}">Horario a:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="time" class="form-control" id="currentStudiesScheduleTo${number}" name="currentStudiesScheduleTo">
                            </div>
                        </div>
                        <div class="form-group col-3">
                            <label for="currentStudiesDegree${number}">Curso o carrera:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="currentStudiesDegree${number}" name="currentStudiesDegree">
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <label for="currentStudiesGrade${number}">Grado:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="currentStudiesGrade${number}" name="currentStudiesGrade">
                            </div>
                        </div>
                    </div>
                </form>  
            </li>`
            )
        break;

        case (type === 'function'):
            return(
            `<li class="list-group-item" id="functions${number}">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="removeElement(event)">
                    &times;
                </button>
                <form class="functions" id="function${number}">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="functionName${number}" name="functionName">
                            </div>
                        </div>
                    </div>
                </form>
            </li>`
            )
        break;

        case (type === 'software'):
            return(
            `<li class="list-group-item" id="software${number}">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="removeElement(event)">
                    &times;
                </button>
                <form class="softwares" id="software${number}">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="softwareName${number}" name="softwareName">
                            </div>
                        </div>
                    </div>
                </form>
            </li>`
            )
        break;

        case (type === 'language'):
            return(
            `<li class="list-group-item" id="language${number}">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="removeElement(event)">
                    &times;
                </button>
                <form class="languages" id="language${number}">
                    <div class="form-row">
                        <div class="form-group col-8">
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="languageName${number}" name="languageName">
                            </div>
                        </div>
                        <div class="form-group col">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                </div>
                                <input type="number" class="form-control input-sm" id="languagePercent${number}" name="languagePercent">
                            </div>
                        </div>
                    </div>
                </form>
            </li>`
            )
        break;

        case (type === 'previousJob'):
            return(
            `<li class="list-group-item" id="previousJob${number}">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="removeElement(event)">
                    &times;
                </button>
                <form class="previousJobs" id="previousJob${number}">
                    <div class="form-row">
                        <div class="form-group col-3">
                            <label for="previousCompanyName${number}">Nombre de la empresa:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="previousCompanyName${number}" name="previousCompanyName">
                            </div>
                        </div>
                        <div class="form-group col-4">
                            <label for="previousCompanyNameAddress${number}">Dirección:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="previousCompanyNameAddress${number}" name="previousCompanyNameAddress">
                            </div>
                        </div>
                        <div class="form-group col-3">
                            <label for="previousCompanyTelephone${number}">Telefono:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="previousCompanyTelephone${number}" name="previousCompanyTelephone"
                                       pattern="[0-9.]+">
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <label for="previousCompanyPosition${number}">Puesto desempeñado:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="previousCompanyPosition${number}" name="previousCompanyPosition">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-2">
                            <label for="previousCompanyFrom${number}">Prestó sus servicios de:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="date" class="form-control" id="previousCompanyFrom${number}" name="previousCompanyFrom">
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <label for="previousCompanyTo${number}">Prestó sus servicios a:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="date" class="form-control" id="previousCompanyTo${number}" name="previousCompanyTo">
                            </div>
                        </div>
                        <div class="form-group col-4">
                            <label for="previousCompanyReferences${number}">¿Podemos solicitar informes de usted?:</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="previousCompanyReferences0${number}" name="previousCompanyReferences"
                                           value="0"/>
                                    <label class="form-check-label" for="previousCompanyReferences0${number}">SI</label>
                                </div>
                                <div class="form-check form-check-inline text-inline">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input class="form-check-input" type="radio" id="previousCompanyReferences1${number}"
                                                       name="previousCompanyReferences" value="1"/>
                                                <label class="form-check-label" for="previousCompanyReferences${number}">No (Razones):</label>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" id="previousCompanyReferencesReasons${number}"
                                               name="previousCompanyReferencesReasons">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-4">
                            <label for="previousCompanyComments${number}">Comentarios de sus jefe:</label>
                            <div class="input-group input-group-sm mb-3">
                                <textarea class="form-control" id="previousCompanyComments${number}" name="previousCompanyComments" rows="1"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-2">
                            <label for="previousCompanyInitialSalary${number}">Sueldo mensual inicial:</label>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" class="form-control" id="previousCompanyInitialSalary${number}"
                                       name="previousCompanyInitialSalary" value="0.0">
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <label for="previousCompanyFinalSalary${number}">Sueldo mensual final:</label>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" class="form-control" id="previousCompanyFinalSalary${number}"
                                       name="previousCompanyFinalSalary" value="0.0">
                            </div>
                        </div>
                        <div class="form-group col-5">
                            <label for="previousCompanySeparation${number}">Motivo de separación:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="previousCompanySeparation${number}" 
                                name="previousCompanySeparation">
                            </div>
                        </div>
                        <div class="form-group col-3">
                            <label for="previousCompanyChiefName${number}">Nombre de jefe directo:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="previousCompanyChiefName${number}" 
                                name="previousCompanyChiefName">
                            </div>
                        </div>
                    </div>
                </form>
            </li>`
            )
        break;

        case (type === 'reference'):
            return(
            `<li class="list-group-item" id="reference${number}">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="removeElement(event)">
                    &times;
                </button>
                <form class="references" id="reference${number}">
                    <div class="form-row">
                        <div class="form-group col-3">
                            <label for="referenceName${number}">Nombre completo:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="referenceName${number}" name="referenceName">
                            </div>
                        </div>
                        <div class="form-group col-3">
                            <label for="referenceAddress${number}">Domicilio:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="referenceAddress${number}" name="referenceAddress">
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <label for="referencePhone${number}">Telefono:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="referencePhone${number}" name="referencePhone"
                                       pattern="[0-9.]+">
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <label for="referenceOccupation${number}">Ocupación:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="referenceOccupation${number}" name="referenceOccupation"
                                       pattern="[0-9.]+">
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <label for="referenceTime${number}">Tiempo de conocerlo:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="referenceTime${number}" name="referenceTime"
                                       pattern="[0-9.]+">
                            </div>
                        </div>
                    </div>
                </form>
            </li>`
            )
        break;

        case (type === 'workingRelative'):
            return(
            `<li class="list-group-item" id="workingRelative${number}">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="removeElement(event)">
                    &times;
                </button>
                <form class="workingRelatives" id="workingRelative${number}">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="workingRelativeName${number}">Nombre completo:</label>
                            <div class="input-group input-group-sm mb-">
                                <input type="text" class="form-control" id="workingRelativeName${number}" name="workingRelativeName">
                            </div>
                        </div>
                        <div class="form-group col-3">
                            <label for="workingRelativeOccupation${number}">Puesto:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="workingRelativeOccupation${number}" 
                                name="workingRelativeOccupation">
                            </div>
                        </div>
                        <div class="form-group col-3">
                            <label for="workingRelativeRelationship${number}">Parentesco:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" id="workingRelativeRelationship${number}" 
                                name="workingRelativeRelationship">
                            </div>
                        </div>
                    </div>
                </form>
            </li>`
            )
        break;

        case (type === 'otherIncome'):
            return(
            `<li class="list-group-item" id="otherIncome${number}">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="removeElement(event)">
                    &times;
                </button>
                <form class="otherIncomes" id="otherIncome${number}">
                     <div class="form-row">
                        <div class="form-group col-9">
                            <label for="otherIncomeDescription${number}">Descripción:</label>
                            <div class="input-group input-group-sm mb-">
                                <input type="text" class="form-control" id="otherIncomeDescription${number}" name="otherIncomeDescription">
                            </div>
                        </div>
                        <div class="form-group col-3">
                            <label for="otherIncomeValue${number}">Importe mensual:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="number" class="form-control" id="otherIncomeValue${number}" name="otherIncomeValue" value="0.0">
                            </div>
                        </div>
                    </div>
                </form>
            </li>`
            )
        break;

        case (type === 'supervisePosition'):
            return(
                `<li class="list-group-item" id="otherIncome${number}">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="removeElement(event)">
                    &times;
                </button>
                <form class="otherIncomes" id="otherIncome${number}">
                     <div class="form-row">
                        <div class="form-group col-9">
                            <label for="otherIncomeDescription${number}">Descripción:</label>
                            <div class="input-group input-group-sm mb-">
                                <input type="text" class="form-control" id="otherIncomeDescription${number}" name="otherIncomeDescription">
                            </div>
                        </div>
                        <div class="form-group col-3">
                            <label for="otherIncomeValue${number}">Importe mensual:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="number" class="form-control" id="otherIncomeValue${number}" name="otherIncomeValue" value="0.0">
                            </div>
                        </div>
                    </div>
                </form>
            </li>`
            )
            break;


        default:
            return('')
        break;
    }
}

const removeElement = (event) => {
    const btn = event.target.parentElement
    btn.remove();
}

const handleErrors = ( { form, data }) => {
    data.forEach(error => {
        const formId = form ? `#${form}` : ''
        const field = document.querySelector(`${formId} [name=${error.field}]`)
        field.classList.add('is-invalid')
        $(`${formId} [name=${error.field}]`).popover({
            content: error.message,
            placement: 'bottom',
            trigger: 'hover',
            delay: {show: 0, hide: 100}
        });
        field.addEventListener('change', event => {
            field.classList.remove('is-invalid')
            $(`#${form} [name=${error.field}]`).popover('dispose')
        })
    })
}

const singleValueSetter = (data) => {
    try{
        for (const value in data) {
            const input = document.querySelector(`#${value}`)
            input.value = data[value]
        }
        return true
    } catch (e) {
        return false
        console.log(e)
    }
}
