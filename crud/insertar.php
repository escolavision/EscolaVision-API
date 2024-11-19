<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type");

include_once '../basedatos/EscolaVision.php';
include_once '../tablas/Alumnos.php';
include_once '../tablas/Area.php';
include_once '../tablas/Profesor.php';
include_once '../tablas/Preguntas.php';
include_once '../tablas/Intentos.php';
include_once '../tablas/PxA.php';
include_once '../tablas/Test.php';

$database = new EscolaVision();
$conex = $database->dameConexion();

$tables = [
    "alumnos" => new Alumnos($conex),
    "areas" => new Area($conex),
    "profesores" => new Profesor($conex),
    "preguntas" => new Preguntas($conex),
    "intentos" => new Intentos($conex),
    "pxa" => new PxA($conex),
    "tests" => new Test($conex)
];

$response = array();

// Leer los datos del cuerpo de la solicitud
$datos = json_decode(file_get_contents("php://input"), true);

// Verificar que se hayan pasado los parámetros necesarios
if (isset($datos['tabla']) && array_key_exists($datos['tabla'], $tables)) {
    $tabla = $datos['tabla'];
    $classInstance = $tables[$tabla];
    // Verificar que se hayan pasado los datos requeridos para la inserción
    if (isset($datos['datos'])) {
        foreach ($datos['datos'] as $key => $value) {
            $classInstance->{$key} = $value; // Asignar cada dato al objeto
        }

        if ($classInstance->insertar()) {
            http_response_code(201);
            $response["message"] = "El registro de la tabla " . ucfirst($tabla) . " fue creado con éxito.";
        } else {
            http_response_code(503);
            $response["message"] = "No se puede crear el registro en la tabla " . ucfirst($tabla) . ".";
        }
    } else {
        http_response_code(400);
        $response["message"] = "Datos no especificados para la inserción.";
    }
} else {
    http_response_code(400);
    $response["message"] = "Tabla no reconocida o no especificada.";
}

// Devolver la respuesta JSON
echo json_encode($response);
?>
