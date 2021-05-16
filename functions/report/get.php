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

// Instância do objeto de report
include_once "../../objects/report.php";
$report = new Report($db);

// Verifica e armazena campos
if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    // Define código de resposta como: 400 Bad Request
    http_response_code(400);     
    die(json_encode(array("message" => "missing_required_data")));
}

// Carrega o registro
$report->LoadById($id); 
 
if($report->id != null){
    // Popula o array
    $report_data = array(
        "id" => $report->id,
        "ong_id" => $report->ong_id,
        "animal_type" => $report->animal_type,
        "animal_description" => $report->animal_description,
        "animal_situation" => $report->animal_situation,
        "animal_photo" => $report->animal_photo,
        "location_cep" => $report->location_cep,
        "location_address" => $report->location_address,
        "location_district" => $report->location_district,
        "location_state" => $report->location_state,
        "location_photo" => $report->location_photo,
        "location_observation" => $report->location_observation,
        "report_situation" => $report->report_situation,
        "report_date_accepted" => $report->report_date_accepted,
        "report_img" => $report->report_img
    );

    // Define código de resposta como: 200 Ok
    http_response_code(200);
    echo json_encode($report_data);
}else{
    // Define código de resposta como: 404 Not Found
    http_response_code(404);
    echo json_encode(array("message" => "not_found"));   
}

?>
