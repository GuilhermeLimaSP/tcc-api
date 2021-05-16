<?php

class Report{
    private $conn;

    public $id;
    public $ong_id;
    public $author_id;
    public $animal_type;
    public $animal_description;
    public $animal_situation;
    public $animal_photo;
    public $location_cep;
    public $location_address;
    public $location_number;
    public $location_district;
    public $location_state;
    public $location_photo;
    public $location_observation;
    public $report_date_accepted;
    public $report_situation;
    public $report_img;

    // Construtor com $db como conexão
    public function __construct($db){
        $this->conn = $db;
    } 

    public function LoadById($id){
        // Construindo a query
        $query = "SELECT    ar.id,
                            ar.ong_id,
                            ar.animal_type, 
                            ar.animal_description, 
                            ar.animal_situation, 
                            ar.animal_photo, 
                            ar.location_cep, 
                            ar.location_address, 
                            ar.location_number, 
                            ar.location_district, 
                            ar.location_state, 
                            ar.location_photo, 
                            ar.location_observation, 
                            ar.report_situation,
                            ar.report_date_accepted,
                            ar.report_img
                        FROM animal_report ar
                            WHERE ar.id = :id";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Limpando a query;
        $id = htmlspecialchars(strip_tags($id));

        // Atualizando os valores
        $stmt->bindParam(":id", $id);

        // Executando
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        $this->ong_id = $row['ong_id'];
        $this->animal_type = $row['animal_type'];
        $this->animal_description = $row['animal_description'];
        $this->animal_situation = $row['animal_situation'];
        $this->animal_photo = $row['animal_photo'];
        $this->location_cep = $row['location_cep'];
        $this->location_address = $row['location_address'];
        $this->location_number = $row['location_number'];
        $this->location_district = $row['location_district'];
        $this->location_state = $row['location_state'];
        $this->location_photo = $row['location_photo'];
        $this->location_observation = $row['location_observation'];
        $this->report_situation = $row['report_situation'];
        $this->report_date_accepted = $row['report_date_accepted'];
        $this->report_img = $row['report_img'];
        
        return True;        
    }

    public function getAll(){
         // Construindo a query
         $query = "SELECT   ar.id,
                            ar.ong_id,
                            ar.animal_type, 
                            ar.animal_description, 
                            ar.animal_situation, 
                            ar.animal_photo, 
                            ar.location_cep, 
                            ar.location_address, 
                            ar.location_number, 
                            ar.location_district, 
                            ar.location_state, 
                            ar.location_photo, 
                            ar.location_observation, 
                            ar.report_date_accepted,
                            ar.report_situation,
                            ar.report_date_accepted,
                            ar.report_img
                        FROM animal_report ar";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Executando
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);  

        return $rows;     
    }

    function createReport(){
        // Construindo a query
        $query = "INSERT INTO animal_report (author_id, ong_id, animal_type, animal_description, animal_situation, animal_photo, location_cep, location_address, location_number, location_district, location_state, location_photo, location_observation, report_date_accepted, report_situation, report_comments, report_img)
                                VALUES (:author_id, :ong_id, :animal_type, :animal_description, :animal_situation, :animal_photo, :location_cep, :location_address, :location_number, :location_district, :location_state, :location_photo, :location_observation, :report_date_accepted, :report_situation, :report_comments, :report_img);";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Limpando a query;
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->ong_id = 0;
        $this->animal_type = htmlspecialchars(strip_tags($this->animal_type));
        $this->animal_description = htmlspecialchars(strip_tags($this->animal_description));
        $this->animal_situation = htmlspecialchars(strip_tags($this->animal_situation));
        $this->animal_photo = htmlspecialchars(strip_tags($this->animal_photo));
        $this->location_cep = htmlspecialchars(strip_tags($this->location_cep));
        $this->location_address = htmlspecialchars(strip_tags($this->location_address));
        $this->location_number = htmlspecialchars(strip_tags($this->location_number));
        $this->location_district = htmlspecialchars(strip_tags($this->location_district));
        $this->location_state = htmlspecialchars(strip_tags($this->location_state));
        $this->location_photo = htmlspecialchars(strip_tags($this->location_photo));
        $this->location_observation = htmlspecialchars(strip_tags($this->location_observation));
        $this->report_date_accepted = "0000-00-00";
        $this->report_situation = "waiting_for_ong";
        $this->report_comments = "";
        $this->report_img = "";

        // Atualizando os valores
        $stmt->bindParam(":author_id", $this->author_id);
        $stmt->bindParam(":ong_id", $this->ong_id);
        $stmt->bindParam(":animal_type", $this->animal_type);
        $stmt->bindParam(":animal_description", $this->animal_description);
        $stmt->bindParam(":animal_situation", $this->animal_situation);
        $stmt->bindParam(":animal_photo", $this->animal_photo);
        $stmt->bindParam(":location_cep", $this->location_cep);
        $stmt->bindParam(":location_address", $this->location_address);
        $stmt->bindParam(":location_number", $this->location_number);
        $stmt->bindParam(":location_district", $this->location_district);
        $stmt->bindParam(":location_state", $this->location_state);
        $stmt->bindParam(":location_photo", $this->location_photo);
        $stmt->bindParam(":location_observation", $this->location_observation);
        $stmt->bindParam(":report_date_accepted", $this->report_date_accepted);
        $stmt->bindParam(":report_situation", $this->report_situation);
        $stmt->bindParam(":report_comments", $this->report_comments);
        $stmt->bindParam(":report_img", $this->report_img);
    

        // Executa a query
        if($stmt->execute()){
            return True;
        }

        return False;
    }

    function loginUser(){
        // Construindo a query
        $query = "SELECT * FROM user WHERE email = :email LIMIT 1";

        // Preparando a query
        $stmt = $this->conn->prepare($query);
        
        // Atualizando os valores
        $stmt->bindParam("email", $this->email);

        // Executa a query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->pwd = $row['pwd'];
        $this->phone = $row['phone']; 
        $this->cep = $row['cep']; 
        $this->created_at = $row['created_at']; 
    }

}

 
?>