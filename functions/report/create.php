<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conexão e configuração do banco de dados
include_once "../../configs/database.php";
$database = new Database();
$db = $database->getConnection();

// Instancia do objeto de usuário
include_once "../../objects/report.php";
$report = new Report($db);

// // Recebe dados via POST - Body
$data = json_decode(file_get_contents("php://input"));

if( !empty($data->author_id) && !empty($data->animal_type) && !empty($data->animal_description) && !empty($data->animal_situation) &&
    !empty($data->animal_photo) && !empty($data->location_cep) && !empty($data->location_address) && !empty($data->location_number) && !empty($data->location_district) &&
    !empty($data->location_state) && !empty($data->location_photo) && !empty($data->location_observation)){

    // Definindo atributos do novo report instanciado
    $report->author_id = $data->author_id;
    $report->animal_type = $data->animal_type;
    $report->animal_description = $data->animal_description;
    $report->animal_situation = $data->animal_situation;
    $report->animal_photo = $data->animal_photo;
    $report->location_cep = $data->location_cep;
    $report->location_address = $data->location_address;
    $report->location_number = $data->location_number;
    $report->location_district = $data->location_district;
    $report->location_state = $data->location_state;
    $report->location_photo = $data->location_photo;
    $report->location_observation = $data->location_observation;

    // Tenta criar o report
    if($report->createReport()){
        //Tenta criar o report
        http_response_code(201);
        echo json_encode(array("message" => "sucess_user_created"));
    }else{
        // Define código de resposta como: 500 Internal Server Error
        http_response_code(500);       
        echo json_encode(array("message" => "internal_server_error"));        
    }
}else{
    // Define código de resposta como: 400 Bad Request
    http_response_code(400);
    echo json_encode(array("message" => "missing_required_data"));
}
?>
