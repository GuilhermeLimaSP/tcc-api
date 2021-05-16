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

// Instância do objeto de usuário
include_once "../../objects/user.php";
$user = new Usuario($db);

// // Recebe dados via POST - Body
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->name) && !empty($data->email) && !empty($data->pwd) && !empty($data->phone) && !empty($data->cep)){
    // Definindo atributos do novo usuário instanciado
    $user->name = $data->name;
    $user->email = $data->email;
    $user->pwd = md5($data->pwd);
    $user->img = $data->img;
    $user->phone = $data->phone;
    $user->cep = $data->cep;

    // Verifica se o e-mail está disponível
    if($user->IsAvailableEmail()){
        //Tenta criar o usuário
        if($user->createUser()){ 
            // Define código de resposta como: 201 Created
            http_response_code(201);
            echo json_encode(array("message" => "sucess_user_created"));
        }else{
            // Define código de resposta como: 500 Internal Server Error
            http_response_code(500);       
            echo json_encode(array("message" => "failed_user_creation"));
        }
    }else{
        // Define código de resposta como: 200 Ok
        http_response_code(403);       
        echo json_encode(array("message" => "email_already_used"));        
    }
}else{
    // Define código de resposta como: 400 Bad Request
    http_response_code(400);
    echo json_encode(array("message" => "missing_required_data"));
}
?>
