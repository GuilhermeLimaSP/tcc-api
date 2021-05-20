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

// Instancia do objeto de usuário
include_once "../../objects/user.php";
$user = new Usuario($db);

// Verifica e armazena dados
if(isset($_GET['email'], $_GET['pwd'])){
    $email = $_GET['email'];
    $data_pwd = md5($_GET['pwd']);
}else{
    // Define código de resposta como: 400 Bad Request
    http_response_code(400);   
    die(json_encode(array("message" => "missing_required_data"))); 
}

// Define atributos a serem verificados no objeto de usuário
$user->email = $email;
$user->pwd = $data_pwd; 

// Lê o registro
$user->loginUser();

if($user->id != null){
    // Verifica a senha
    if($user->pwd == $data_pwd){
        // Solicita a atualização do perfil
        $user->getProfile();

        // Popula o array
        $user_data = array(
            "nome" => $user->name, 
            "email" => $user->email,
            "img" => $user->img,
            "phone" => $user->phone,
            "cep" => $user->cep,
            "reports" => $user->reports,
            "created_at" => $user->created_at,
        );

        // Define código de resposta como: 200 Ok
        http_response_code(200);
        echo json_encode($user_data);
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