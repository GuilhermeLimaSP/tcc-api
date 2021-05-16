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

// Instância do objeto de ong
include_once "../../objects/ong.php";
$ong = new Ong($db);

// Solicita todas a ONGs
$allOngs = $ong->getAll();
if(count($allOngs) >= 1){
    // Define código de resposta como: 200 Ok
    http_response_code(200);
    echo json_encode($allOngs);
}else{
    // Define código de resposta como: 500 Internal Server Error
    http_response_code(500);
    echo json_encode(array("message" => "internal_error"));   
}
?>
