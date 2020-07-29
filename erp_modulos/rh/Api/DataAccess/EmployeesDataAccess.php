<?php

namespace Api\DataAccess;

use Api\Connectors\DatabaseConnector;
use PDO;
use PDOException;

class EmployeesDataAccess
{

    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = (new DatabaseConnector())->connection();
    }

    public function select($id)
    {
        $stmt = $this->dbConnection->prepare
        ('
        SELECT emp.id AS id
            ,department
            ,dept.name AS departmentName
            ,position
            ,pue.positionName AS positionName 
            ,desiredSalary
            ,approvedSalary
            ,est.name AS STATUS
            ,recruitmentDate
            ,recordStatus
            ,lastname
            ,mothersLastname
            ,emp.name AS name
            ,birthDate
            ,telephone
            ,nac.name AS nationality
            ,postalCode
            ,address
            ,suburb
            ,birthPlace
            ,height
            ,weight
            ,esc.name AS maritalStatus
            ,otherGender
            ,gen.name AS gender
            ,viv.name AS livesWith
            ,dep.name AS dependOn
            ,number
        FROM empleados_rh emp
        JOIN departamentos_rh dept ON emp.department = dept.id
        JOIN puestos_empleados_rh pue ON emp.position = pue.id
        JOIN estatus_empleados_rh est ON emp.STATUS = est.id
        JOIN nacionalidad_empleados_rh nac ON emp.nationality = nac.id
        JOIN estado_civil_empleados_rh esc ON emp.maritalStatus = esc.id
        JOIN genero_empleados_rh gen ON emp.gender = gen.id
        JOIN vive_con_empleados_rh viv ON emp.maritalStatus = viv.id
        JOIN depende_de_empleados_rh dep ON emp.dependOn = dep.id
        WHERE recordStatus = 1
        AND emp.id = ?
        ');
        try {
            $stmt->execute(array($id));
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function selectAll()
    {
        $stmt = $this->dbConnection->query
        ('
        SELECT emp.id AS id
            ,department
            ,dept.name AS departmentName
            ,position
            ,pue.positionName AS positionName 
            ,desiredSalary
            ,approvedSalary
            ,est.name AS STATUS
            ,recruitmentDate
            ,recordStatus
            ,lastname
            ,mothersLastname
            ,emp.name AS name
            ,birthDate
            ,telephone
            ,nac.name AS nationality
            ,postalCode
            ,address
            ,suburb
            ,birthPlace
            ,height
            ,weight
            ,esc.name AS maritalStatus
            ,otherGender
            ,gen.name AS gender
            ,viv.name AS livesWith
            ,dep.name AS dependOn
            ,number
        FROM empleados_rh emp
        JOIN departamentos_rh dept ON emp.department = dept.id
        JOIN puestos_empleados_rh pue ON emp.position = pue.id
        JOIN estatus_empleados_rh est ON emp.STATUS = est.id
        JOIN nacionalidad_empleados_rh nac ON emp.nationality = nac.id
        JOIN estado_civil_empleados_rh esc ON emp.maritalStatus = esc.id
        JOIN genero_empleados_rh gen ON emp.gender = gen.id
        JOIN vive_con_empleados_rh viv ON emp.maritalStatus = viv.id
        JOIN depende_de_empleados_rh dep ON emp.dependOn = dep.id
        WHERE recordStatus = 1
        ');
        try {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    public function selectAllSupervisorsByDepartment($department)
    {
        $stmt = $this->dbConnection->prepare
        ('
        SELECT emp.id AS id
            ,department
            ,dept.name AS departmentName
            ,position
            ,pue.positionName AS positionName 
            ,desiredSalary
            ,approvedSalary
            ,est.name AS STATUS
            ,recruitmentDate
            ,recordStatus
            ,lastname
            ,mothersLastname
            ,emp.name AS name
            ,birthDate
            ,telephone
            ,nac.name AS nationality
            ,postalCode
            ,address
            ,suburb
            ,birthPlace
            ,height
            ,weight
            ,esc.name AS maritalStatus
            ,otherGender
            ,gen.name AS gender
            ,viv.name AS livesWith
            ,dep.name AS dependOn
            ,number
        FROM empleados_rh emp
        JOIN departamentos_rh dept ON emp.department = dept.id
        JOIN puestos_empleados_rh pue ON emp.position = pue.id
        JOIN estatus_empleados_rh est ON emp.STATUS = est.id
        JOIN nacionalidad_empleados_rh nac ON emp.nationality = nac.id
        JOIN estado_civil_empleados_rh esc ON emp.maritalStatus = esc.id
        JOIN genero_empleados_rh gen ON emp.gender = gen.id
        JOIN vive_con_empleados_rh viv ON emp.maritalStatus = viv.id
        JOIN depende_de_empleados_rh dep ON emp.dependOn = dep.id
        WHERE recordStatus = 1
        AND pue.positionIsSupervisor = 1
        AND dept.id = ?
        ');
        try {
            $stmt->execute(array($department));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert($data)
    {
        $values = json_decode($data, true);

        try {

            $array = Array();

            foreach ($values as $value){
                $array = array_merge($array, $value);
            }

            $array['recordStatus'] = 1;

            $newArray = array_map(function ($array){
                if(is_numeric($array)){
                    return trim(floatval($array));
                }
                if(empty($array)){
                    return NULL;
                }
                return trim($array);
            }, $array);

            $newArray['number'] = $this->getEmployeeNumber($array);

            $params = array('department', 'position', 'desiredSalary', 'approvedSalary', 'status', 'recruitmentDate', 'recordStatus', 'lastname', 'mothersLastname', 'name', 'birthDate', 'telephone', 'nationality', 'postalCode', 'address', 'suburb', 'birthPlace', 'height', 'weight', 'maritalStatus', 'otherGender', 'gender','livesWith', 'dependOn', 'number');

            $response = $this->insertion($newArray, $params, 'sp_insert_employee');

            $newArray['employeeId'] =  $response->fetch(PDO::FETCH_OBJ)->id;

            $paramsDoc = array('curp', 'afore', 'rfc', 'nss', 'militarPrimer', 'passport', 'driversLicence', 'driversLicenceNumber', 'foreignDocuments', 'employeeId');

            $this->insertion($newArray, $paramsDoc, 'sp_insert_documentation');

            $paramsHealth= array('employeeId', 'health', 'chronicDisease', 'chronicDiseaseName', 'sport', 'sportName', 'hobby', 'socialClub', 'socialClubName');

            $this->insertion($newArray, $paramsHealth, 'sp_insert_health');

            $paramsRelatives = array('employeeId', 'fatherName', 'fatherAddress', 'fatherJob', 'fatherStatus', 'motherName', 'motherAddress', 'motherJob', 'motherStatus', 'spouseName', 'spouseAddress', 'spouseJob', 'spouseStatus');

            $this->insertion($newArray, $paramsRelatives, 'sp_insert_relative');

            $paramsScholarship = array('employeeId', 'elementarySchoolName', 'elementarySchoolAddress', 'elementarySchoolFrom', 'elementarySchoolTo', 'elementarySchoolDegree', 'juniorHighName', 'juniorHighAddress', 'juniorHighFrom', 'juniorHighTo', 'juniorHighDegree', 'highSchoolName', 'highSchoolAddress', 'highSchoolFrom', 'highSchoolTo', 'highSchoolDegree', 'professionalSchoolName', 'professionalSchoolTo', 'professionalSchoolFrom', 'professionalSchoolAddress', 'professionalSchoolDegree');

            $this->insertion($newArray, $paramsScholarship, 'sp_insert_scholarship');

            $paramsGeneral = array('employeeId', 'isBonded', 'isBondedAgency', 'isUnionized', 'isUnionizedUnion', 'startingDate', 'isInsured', 'isInsuredAgency', 'canTravel', 'canTravelReason', 'canMove', 'canMoveReason');

            $this->insertion($newArray, $paramsGeneral, 'sp_insert_general');

            $paramsEconomic = array('employeeId', 'workingSpouse', 'workingSpouseSalary', 'ownedHouse', 'ownedHouseValue', 'payRent', 'payRentValue', 'ownCar', 'ownCarModel', 'hasDebts', 'hasDebtsValue', 'monthlyExpenses');

            $insertion = $this->insertion($newArray, $paramsEconomic, 'sp_insert_economic');

            $paramsGeneral = array('employeeId', 'isBonded', 'isBondedAgency', 'isUnionized', 'isUnionizedUnion', 'startingDate', 'isInsured', 'isInsuredAgency', 'canTravel', 'canTravelReason', 'canMove', 'canMoveReason');

            $this->insertion($newArray, $paramsGeneral, 'sp_insert_general');

            $paramsEconomic = array('employeeId', 'workingSpouse', 'workingSpouseSalary', 'ownedHouse', 'ownedHouseValue', 'payRent', 'payRentValue', 'ownCar', 'ownCarModel', 'hasDebts', 'hasDebtsValue', 'monthlyExpenses');

            $insertion = $this->insertion($newArray, $paramsEconomic, 'sp_insert_economic');

            return $insertion->rowCount();

        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function disable($id)
    {
        $stmt = $this->dbConnection->prepare('UPDATE empleados_rh SET recordStatus = 0 WHERE id = ?');
        try {
            $stmt->execute(array($id));
            return $stmt->rowCount();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function  insertion($values, $params, $procedureName){

        $queryValues  = array();

        foreach ($params as $param){
            $queryValues[":$param"] = $values[$param];
        }

        $query = "CALL $procedureName(".implode(", ",array_keys($queryValues)).")";

        $stmt = $this->dbConnection->prepare($query);

        $stmt->execute($queryValues);

        //print_r('execute '.$procedureName);

        $stmt->debugDumpParams();

        return $stmt;
    }

    public function getEmployeeNumber($array)
    {
        return 'E'.$array['department'].$array['position'].time();
    }

}
