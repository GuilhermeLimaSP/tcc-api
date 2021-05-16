<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// Conexão e configuração do banco de dados
include_once "../../configs/database.php";
$database = new Database();
$db = $database->getConnection();

// Instância do objeto de animal
include_once "../../objects/animal.php";
$animal = new Animal($db);

// Solicita todas a ONGs
$allAnimal = $animal->getAll();
if(count($allAnimal) >= 1){
    // Define código de resposta como: 200 Ok
    http_response_code(200);
    echo json_encode($allAnimal);
}else{
    // Define código de resposta como: 500 Internal Server Error
    http_response_code(500);
    echo json_encode(array("message" => "internal_error"));   
}
?>
