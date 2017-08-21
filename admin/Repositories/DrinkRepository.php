<?php

Class DrinkRepository {

    private $pdo;

    public function __construct(){
        $this->pdo = new PDO('mysql:host='.CONFIG_DATABASE_HOST.';dbname='.CONFIG_DATABASE_DBNAME.';charset=utf8', CONFIG_DATABASE_USER, CONFIG_DATABASE_PASSWORD);
    }

    /**
    * Update a drink
    **/
    public function flush($drink){

        $id            = $drink->getId();
        $name          = $drink->getName();
        $currentPrice  = $drink->getCurrentPrice();
        $previousPrice = $drink->getPreviousPrice();
        $history       = $drink->getHistory();
        $isEnable      = $drink->isEnable();
        $salesCount       = $drink->getSalesCount();
        $estimatedRevenue = $drink->getEstimatedRevenue();

        $stmt = $this->pdo->prepare("UPDATE drinks SET name = :name, currentPrice = :currentPrice, previousPrice = :previousPrice, history = :history, isEnable = :isEnable, salesCount = :salesCount, estimatedRevenue = :estimatedRevenue WHERE id = :id");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':currentPrice', $currentPrice);
        $stmt->bindParam(':previousPrice', $previousPrice);
        $stmt->bindParam(':history', $history);
        $stmt->bindParam(':isEnable', $isEnable);
        $stmt->bindParam(':salesCount', $salesCount);
        $stmt->bindParam(':estimatedRevenue', $estimatedRevenue);

        $stmt->execute();
    }

    public function resetAllDrinks(){
        $stmt = $this->pdo->prepare("UPDATE drinks SET currentPrice = 0, previousPrice = 0, history = '[]', isEnable = false, salesCount = 0, estimatedRevenue = 0");
        $stmt->execute();
    }

    public function addDrink($drink){

        $name             = $drink->getName();
        $currentPrice     = intval($drink->getCurrentPrice());
        $previousPrice    = $drink->getPreviousPrice();
        $history          = $drink->getHistory();
        $isEnable         = $drink->isEnable();
        $salesCount       = $drink->getSalesCount();
        $estimatedRevenue = $drink->getEstimatedRevenue();

        $stmt = $this->pdo->prepare("INSERT INTO drinks (name, currentPrice, previousPrice, history, isEnable, salesCount, estimatedRevenue) VALUES (:name, :currentPrice, :previousPrice, :history, :isEnable, :salesCount, :estimatedRevenue) ");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':currentPrice', $currentPrice);
        $stmt->bindParam(':previousPrice', $previousPrice);
        $stmt->bindParam(':history', $history);
        $stmt->bindParam(':isEnable', $isEnable);
        $stmt->bindParam(':salesCount', $salesCount);
        $stmt->bindParam(':estimatedRevenue', $estimatedRevenue);

        $stmt->execute();
    }

    public function removeDrinkById($id){
        $id = intval($id);
        var_dump($id);
        $stmt = $this->pdo->prepare("DELETE FROM drinks WHERE id = :id ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    /**
    * Return all drinks
    **/
    public function findAll(){
        $drinks = [];

        $stmt = $this->pdo->prepare("SELECT * FROM drinks");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $drinkResult){
            $drink = new Drink($drinkResult['id'], $drinkResult['name'], $drinkResult['currentPrice'], $drinkResult['previousPrice'], $drinkResult['history'], $drinkResult['isEnable'], $drinkResult['salesCount'], $drinkResult['estimatedRevenue']);
            $drinks[] = $drink;
        }

        return $drinks;
    }

    /**
    * Return all available drinks
    **/
    public function findAllAvailable(){
        $drinks = [];

        $stmt = $this->pdo->prepare("SELECT * FROM drinks WHERE isEnable = true");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $drinkResult){
            $drink = new Drink($drinkResult['id'], $drinkResult['name'], $drinkResult['currentPrice'], $drinkResult['previousPrice'], $drinkResult['history'], $drinkResult['isEnable'], $drinkResult['salesCount'], $drinkResult['estimatedRevenue']);
            $drinks[] = $drink;
        }

        return $drinks;
    }

    /**
    * Return all unavailable drinks
    **/
    public function findAllUnavailable(){
        $drinks = [];

        $stmt = $this->pdo->prepare("SELECT * FROM drinks WHERE isEnable = false");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $drinkResult){
            $drink = new Drink($drinkResult['id'], $drinkResult['name'], $drinkResult['currentPrice'], $drinkResult['previousPrice'], $drinkResult['history'], $drinkResult['isEnable'], $drinkResult['salesCount'], $drinkResult['estimatedRevenue']);
            $drinks[] = $drink;
        }

        return $drinks;
    }

    /**
    * Return a drink
    **/
    public function findDrinkById($id){

        $stmt = $this->pdo->prepare("SELECT * FROM drinks WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $drink = new Drink($result['id'], $result['name'], $result['currentPrice'], $result['previousPrice'], $result['history'], $result['isEnable'], $result['salesCount'], $result['estimatedRevenue']);
        return $drink;
    }

    /**
    * Disable a drink
    **/
    public function disableDrinkById($id){
        $stmt = $this->pdo->prepare("UPDATE drinks SET isEnable = false WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    /**
    * Enable a drink
    **/
    public function enableDrinkById($id){
        $stmt = $this->pdo->prepare("UPDATE drinks SET isEnable = true WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

}
