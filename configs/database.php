<?php
date_default_timezone_set('America/Sao_Paulo');

class Database{
    // Atributos de conexão
    private $host = "localhost";
    private $db_name = "tcc";
    private $username = "root";
    private $password = "lord@12";
    private $charset = "utf8";
    public $conn;
 
    // Define a função que retorna a conexão com o banco de dados
    public function getConnection(){
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset, 
                                $this->username, 
                                $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }    
}

?>