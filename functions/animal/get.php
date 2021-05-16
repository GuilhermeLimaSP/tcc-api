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

// Verifica e armazena campos
if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    // Define código de resposta como: 400 Bad Request
    http_response_code(400);     
    die(json_encode(array("message" => "missing_required_data")));
}

// Lê o registro
$animal->LoadById($id);

if($animal->id != null){
    // Popula o array
    $animal_data = array(
        "id" => $animal->id,
        "ong_id" => $animal->ong_id,
        "animal_name" => $animal->animal_name,
        "animal_description" => $animal->animal_description,
        "animal_type" => $animal->animal_type,
        "animal_age" => $animal->animal_age,
        "animal_gender" => $animal->animal_gender,
        "animal_photo" => $animal->animal_photo,
        "animal_race" => $animal->animal_race,
        "animal_weight" => $animal->animal_weight,
        "animal_category" => $animal->animal_category
    );

    // Define código de resposta como: 200 Ok
    http_response_code(200);
    echo json_encode($animal_data);
}else{
    // Define código de resposta como: 404 Not Found
    http_response_code(404);
    echo json_encode(array("message" => "not_found"));   
}

?>
