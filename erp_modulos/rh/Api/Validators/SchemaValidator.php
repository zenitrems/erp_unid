<?php

namespace Api\Validators;

use Opis\JsonSchema\{
    Validator, Schema
};

class SchemaValidator
{

    public function validateSchema($data, $schemaName)
    {
        $values = json_decode($data);
        $schema = '';

        if($schemaName == 'departments'){
            $schema = Schema::fromJsonString(file_get_contents(__DIR__ . '/../Schemas/DepartmentsSchema.json'));
        }

        if($schemaName == 'employees'){
            $schema = Schema::fromJsonString(file_get_contents(__DIR__ . '/../Schemas/EmployeesSchema.json'));
        }

        if($schemaName == 'positions'){
            $schema = Schema::fromJsonString(file_get_contents(__DIR__ . '/../Schemas/WorkingPositionSchema.json'));
        }

        if($schemaName == 'vacations'){
            $schema = Schema::fromJsonString(file_get_contents(__DIR__ . '/../Schemas/VacationsSchema.json'));
        }

        $validator = new Validator();
        $result = $validator->schemaValidation($values, $schema, -1);

        if ($result->isValid()) {
            return true;
        } else {
            return ($this->formatErrors($result));
        }
    }

    public function formatErrors($result)
    {
        $errors = [];
        foreach ($result->getErrors() as $error) {
            $pointer = $error->dataPointer();
            $obj = (object)array(
                'error' => $error->keyword(),
                'field' => end($pointer),
                'message' => $this->getErrorMessages($error->keyword())
            );
            array_push($errors, $obj);
        };
        return $errors;
    }

    public function getErrorMessages($keyword)
    {
        $messages = json_decode(file_get_contents(__DIR__ . '/ErrorMessages.json'));
        return isset($messages->$keyword) ? $messages->$keyword : 'Dato no valido';
    }

}