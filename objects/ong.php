<?php

class Ong{
    private $conn;

    public $ong_id;
    public $ong_name;
    public $ong_description;
    public $ong_email;
    public $ong_purpose; 
    public $ong_phone;
    public $ong_opening_date; 
    public $ong_business_hours;
    public $ong_img;
    public $ong_rescue_count;
    public $ong_adoptions_count;
    public $ong_likes;
    public $location_cep;
    public $location_address;
    public $location_number;
    public $location_district;
    public $location_state;

    // Construtor com $db como conexão
    public function __construct($db){
        $this->conn = $db;
    }

    public function LoadById($id){
        // Construindo a query
        $query = "SELECT o.id, o.ong_name, o.ong_description, o.ong_email, o.ong_purpose, o.ong_phone, o.ong_opening_date, o.ong_business_hours, o.ong_img, o.location_cep, o.location_address, o.location_number, o.location_district, o.location_state
                        FROM ong o WHERE id = :id;";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Limpando a query;
        $id = htmlspecialchars(strip_tags($id));

        // Atualizando os valores
        $stmt->bindParam(":id", $id);

        // Executando
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->ong_id = $row['id'];
        $this->ong_name = $row['ong_name'];
        $this->ong_description = $row['ong_description'];
        $this->ong_email = $row['ong_email'];
        $this->ong_purpose = $row['ong_purpose'];
        $this->ong_phone = $row['ong_phone'];
        $this->ong_opening_date = $row['ong_opening_date'];
        $this->ong_business_hours = $row['ong_business_hours'];
        $this->ong_img = $row['ong_img'];
        $this->location_cep = $row['location_cep'];
        $this->location_address = $row['location_address'];
        $this->location_number = $row['location_number'];
        $this->location_district = $row['location_district'];
        $this->location_state = $row['location_state'];
        // Missing
        $this->ong_rescue_count = "0";
        $this->ong_adoptions_count = "0";
        $this->ong_likes = "0";
        
        return True;        
    }

    public function getAll(){
         // Construindo a query
         $query = "SELECT   o.id,
                            o.ong_name,
                            o.ong_description, 
                            o.ong_email, 
                            o.ong_purpose, 
                            o.ong_phone, 
                            o.ong_opening_date, 
                            o.ong_business_hours, 
                            o.ong_img, 
                            o.location_cep, 
                            o.location_address, 
                            o.location_number, 
                            o.location_district,
                            o.location_state,
                            (SELECT '0') as ong_rescue_count, 
                            (SELECT '0') as ong_adoptions_count, 
                            (SELECT '0') as ong_likes
                        FROM ong o;";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Executando
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);  
        return $rows;     
    }

}


?>