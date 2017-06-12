<?php

Class ConfigRepository {

    private $pdo;

    public function __construct(){
        $this->pdo = new PDO('mysql:host='.CONFIG_DATABASE_HOST.';dbname='.CONFIG_DATABASE_DBNAME.';charset=utf8', CONFIG_DATABASE_USER, CONFIG_DATABASE_PASSWORD);
    }

    public function findConfigById($id){
        $stmt = $this->pdo->prepare("SELECT * FROM configs WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $config = new Config($result['id'], $result['textValue'], $result['booleanValue']);
        return $config;
    }

    public function setBooleanValueById($id, $value){

        $stmt = $this->pdo->prepare("UPDATE configs SET booleanValue = :booleanValue WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':booleanValue', $value);

        $stmt->execute();
    }

}
