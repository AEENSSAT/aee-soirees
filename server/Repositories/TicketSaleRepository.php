<?php

Class TicketSaleRepository {

    private $pdo;

    public function __construct(){
        $this->pdo = new PDO('mysql:host='.CONFIG_DATABASE_HOST.';dbname='.CONFIG_DATABASE_DBNAME.';charset=utf8', CONFIG_DATABASE_USER, CONFIG_DATABASE_PASSWORD);
    }

    public function addTicketSale($ticketSale){

        $timestamp = $ticketSale->getTimestamp();
        $quantity = $ticketSale->getQuantity();
        $ticketPrice = $ticketSale->getTicketPrice();
        $price = $ticketSale->getPrice();

        $stmt = $this->pdo->prepare("INSERT INTO ticketsSale (timestamp, quantity, ticketPrice, price) VALUES (:timestamp, :quantity, :ticketPrice, :price)");
        $stmt->bindParam(':timestamp', $timestamp);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':ticketPrice', $ticketPrice);
        $stmt->bindParam(':price', $price);

        $stmt->execute();
    }

    public function countTicketsSold(){
        $stmt = $this->pdo->prepare("SELECT SUM(quantity) as ticketsSold FROM ticketsSale");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result[0]['ticketsSold'];
    }

    public function sumEstimatedRevenue(){
        $stmt = $this->pdo->prepare("SELECT SUM(price) as estimatedRevenue FROM ticketsSale");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result[0]['estimatedRevenue'];
    }

    public function clearSales(){
        $stmt = $this->pdo->prepare("TRUNCATE TABLE ticketsSale");
        $stmt->execute();
    }
}
