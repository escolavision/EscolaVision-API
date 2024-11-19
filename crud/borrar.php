<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
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

    if (isset($datos['id'])) {
        $classInstance->id = $datos['id'];

        if ($classInstance->borrar()) {
            http_response_code(200);
            $response["message"] = "El usuario con ID " . $classInstance->id . " de la tabla " . ucfirst($tabla) . " fue borrado con éxito o no se encuentra en el sistema.";
        } else {
            http_response_code(503);
            $response["message"] = "No se puede borrar el usuario con ID " . $classInstance->id . " de la tabla " . ucfirst($tabla) . " o está referenciado en otra tabla.";
        }
    } else {
        http_response_code(400);
        $response["message"] = "ID no especificado.";
    }
} else {
    http_response_code(400);
    $response["message"] = "Tabla no reconocida o no especificada.";
}

// Devolver la respuesta JSON
echo json_encode($response);
?>
