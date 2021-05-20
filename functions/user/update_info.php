<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Credentials: true");
// header('Content-Type: application/json');


// Conexão e configuração do banco de dados
include_once "../../configs/database.php";
$database = new Database();
$db = $database->getConnection();

// Instancia do objeto de usuário
include_once "../../objects/user.php";
$user = new Usuario($db);

// Recebe dados via PUT - Body
$data = json_decode(file_get_contents("php://input"));

// Verifica e armazena dados
if(isset($data->email, $data->current_pwd, $data->phone, $data->cep)){
    $data_pwd = md5($data->current_pwd);
    $user->email = $data->email;
    $user->pwd = $data_pwd; 
    $phone = $data->phone;
    $cep = $data->cep;
}else{
    // Define código de resposta como: 400 Bad Request
    http_response_code(400);   
    die(json_encode(array("message" => "missing_required_data"))); 
}

// Lê o registro
$user->loginUser();

if($user->id != null){
    // Verificando se a senha está correta
    if($user->pwd == $data_pwd){
        // Garante que pelo menos algo esteja sendo alterado
        if($user->phone != $phone || $user->cep != $cep){
            // Tenta alterar os dados
            if($user->updateInfos($phone, $cep)){
                echo json_encode(array("message" => "successful_change"));
            }else{
                // Define código de resposta como: 500 Internal Server Error
                http_response_code(500);       
                echo json_encode(array("message" => "internal_error"));
            }
        }else{
            // Define código de resposta como: 401 Unauthorized
            http_response_code(401);       
            echo json_encode(array("message" => "nothing_to_update"));            
        }
    }else{
        // Define código de resposta como: 401 Unauthorized
        http_response_code(401);
        echo json_encode(array("message" => "invalid_authentication"));
    }
}else{
    // Define código de resposta como: 404 Not Found
    http_response_code(404);
    echo json_encode(array("message" => "not_found"));   
}
?>