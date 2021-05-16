<?php

class Animal{
    private $conn;

    public $id;
    public $ong_id;
    public $animal_name;
    public $animal_description;
    public $animal_type;
    public $animal_age;
    public $animal_gender;
    public $animal_photo;
    public $animal_race;
    public $animal_weight;
    public $animal_category; 

    // Construtor com $db como conexão
    public function __construct($db){
        $this->conn = $db;
    }

    public function LoadById($id){
        // Construindo a query
        $query = "SELECT aa.id, aa.ong_id, aa.animal_name, aa.animal_description, aa.animal_type, animal_age, animal_gender, animal_gender, animal_photo, animal_race, animal_weight, animal_category
                        FROM animal_adoption aa WHERE id = :id";

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
        $this->animal_name = $row['animal_name'];
        $this->animal_description = $row['animal_description'];
        $this->animal_type = $row['animal_type'];
        $this->animal_age = $row['animal_age'];
        $this->animal_gender = $row['animal_gender'];
        $this->animal_photo = $row['animal_photo'];
        $this->animal_race = $row['animal_race'];
        $this->animal_weight = $row['animal_weight'];
        $this->animal_category = $row['animal_category'];
        
        return True;        
    }

    public function getAll(){
         // Construindo a query
         $query = "SELECT aa.id, aa.ong_id, aa.animal_name, aa.animal_description, aa.animal_type, animal_age, animal_gender, animal_gender, animal_photo, animal_race, animal_weight, animal_category
                        FROM animal_adoption aa";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Executando
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);  
        return $rows;     
    }

}


?>