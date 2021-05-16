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

// Verifica e armazena campos
if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    // Define código de resposta como: 400 Bad Request
    http_response_code(400);     
    die(json_encode(array("message" => "missing_required_data")));
}

// Lê o registro
$ong->LoadById($id);

if($ong->ong_id != null){
    // Popula o array
    $ong_data = array(
        "id" => $ong->ong_id,
        "ong_name" => $ong->ong_name,
        "ong_description" => $ong->ong_description,
        "ong_email" => $ong->ong_email,
        "ong_purpose" => $ong->ong_purpose,
        "ong_phone" => $ong->ong_phone,
        "ong_opening_date" => $ong->ong_opening_date,
        "ong_business_hours" => $ong->ong_business_hours,
        "ong_img" => $ong->ong_img,
        "location_cep" => $ong->location_cep,
        "location_address" => $ong->location_address,
        "location_number" => $ong->location_number,
        "location_district" => $ong->location_district,
        "location_state" => $ong->location_state,
        "ong_rescue_count" => $ong->ong_rescue_count,
        "ong_adoptions_count" => $ong->ong_adoptions_count,
        "ong_likes" => $ong->ong_likes
    );

    // Define código de resposta como: 200 Ok
    http_response_code(200);
    echo json_encode($ong_data);
}else{
    // Define código de resposta como: 404 Not Found
    http_response_code(404);
    echo json_encode(array("message" => "not_found"));   
}
?>
