<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
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

if (isset($_GET['tabla']) && array_key_exists($_GET['tabla'], $tables)) {
    $tabla = $_GET['tabla'];
    $classInstance = $tables[$tabla];

    if (isset($_GET['id'])) {
        $classInstance->id = $_GET['id'];
    }

    $result = $classInstance->leer();
    if ($result->num_rows > 0) {
        $dataList = array();
        while ($data = $result->fetch_assoc()) {
            $dataList[] = $data;
        }
        $response[$tabla] = $dataList;
    } else {
        $response[$tabla] = array();
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Tabla no reconocida o no especificada"));
    exit();
}

http_response_code(200);
echo json_encode($response);
?>
