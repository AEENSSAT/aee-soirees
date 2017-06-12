<?php
session_start();
require_once 'config.php';
require_once 'Libs/limonade/limonade.php';

function checkIfConnected(){
    if(!isset($_SESSION['isConnected']) || $_SESSION['isConnected'] == false){
        header('Location: ?/login');
    }
}

dispatch('/', 'admin');
function admin(){
    if(isset($_SESSION['isConnected']) && $_SESSION['isConnected'] == true){
        header('Location: ?/dashboard');
    }else{
        header('Location: ?/login');
    }
}

dispatch('login', 'login');
function login(){
    require 'Views/Partials/head.php';
    require 'Views/login.php';
}

dispatch_post('login', 'loginPost');
function loginPost(){
    if(isset($_POST) && isset($_POST['login']) && isset($_POST['password'])){
        if($_POST['login'] == CONFIG_USER_LOGIN && $_POST['password'] == CONFIG_USER_PASSWORD){
            $_SESSION['isConnected'] = true;
            header('Location: ?/dashboard');
        }else {
            header('Location: ?/login');
        }
    }else{
        require 'Views/login.php';
    }
}

dispatch('logout', 'logout');
function logout(){
    $_SESSION['isConnected'] = false;
    session_destroy();
    header('Location: ?/login');
}

dispatch('dashboard', 'dashboard');
function dashboard(){
    checkIfConnected();

    require 'Views/Partials/head.php';
    require 'Repositories/DrinkRepository.php';
    require 'Models/Drink.php';
    require 'Repositories/ConfigRepository.php';
    require 'Models/Config.php';

    $drinkRepository   = new DrinkRepository();
    $drinks            = $drinkRepository->findAll();
    $availableDrinks   = $drinkRepository->findAllAvailable();
    $unavailableDrinks = $drinkRepository->findAllUnavailable();

    $configRepository = new ConfigRepository();
    $priceUpConfig    = $configRepository->findConfigById("priceUp");
    $priceDownConfig  = $configRepository->findConfigById("priceDown");

    $priceUpAlert   = $priceUpConfig->getBooleanValue();
    $priceDownAlert = $priceDownConfig->getBooleanValue();

    require 'Views/dashboard.php';
}


dispatch('priceDownAlert/enable', 'enablePriceDownAlert');
function enablePriceDownAlert(){
    checkIfConnected();

    require 'Repositories/ConfigRepository.php';
    require 'Models/Config.php';
    $configRepository = new ConfigRepository();

    if($configRepository->findConfigById("priceUp")->getBooleanValue() == false){
        $configRepository->setBooleanValueById("priceDown", 1);
    }

    header('Location: ?/dashboard');
}

dispatch('priceDownAlert/disable', 'disablePriceDownAlert');
function disablePriceDownAlert(){
    checkIfConnected();

    require 'Repositories/ConfigRepository.php';
    $configRepository = new ConfigRepository();
    $configRepository->setBooleanValueById("priceDown", 0);
    header('Location: ?/dashboard');
}

dispatch('priceUpAlert/enable', 'enablePriceUpAlert');
function enablePriceUpAlert(){
    checkIfConnected();

    require 'Repositories/ConfigRepository.php';
    require 'Models/Config.php';
    $configRepository = new ConfigRepository();

    if($configRepository->findConfigById("priceDown")->getBooleanValue() == false){
        $configRepository->setBooleanValueById("priceUp", 1);
    }

    header('Location: ?/dashboard');
}

dispatch('priceUpAlert/disable', 'disablePriceUpAlert');
function disablePriceUpAlert(){
    checkIfConnected();

    require 'Repositories/ConfigRepository.php';
    $configRepository = new ConfigRepository();
    $configRepository->setBooleanValueById("priceUp", 0);
    header('Location: ?/dashboard');
}


dispatch('prices', 'prices');
function prices(){
    checkIfConnected();

    require 'Views/Partials/head.php';
    require 'Repositories/DrinkRepository.php';
    require 'Models/Drink.php';

    $drinkRepository = new DrinkRepository();
    $drinks          = $drinkRepository->findAll();

    require 'Views/prices.php';
}

dispatch_post('/drink/add', 'addDrink');
function addDrink(){
    checkIfConnected();

    require 'Views/Partials/head.php';
    require 'Repositories/DrinkRepository.php';
    require 'Models/Drink.php';

    if(isset($_POST) && isset($_POST['name']) && isset($_POST['price'])){
        $drinkRepository = new DrinkRepository();
        $drink           = new Drink(null, $_POST['name'], $_POST['price'], 0, "[]", 0, 0, 0);

        $drinkRepository->addDrink($drink);
    }

    header('Location: ?/prices');
}

dispatch('/drink/remove/:id', 'removeDrink');
function removeDrink($id){
    checkIfConnected();

    require 'Views/Partials/head.php';
    require 'Repositories/DrinkRepository.php';

    $drinkRepository = new DrinkRepository();
    $drinkRepository->removeDrinkById($id);

    header('Location: ?/prices');
}

dispatch_post('/drink/setPrice', 'changeDrinkPrice');
function changeDrinkPrice(){
    checkIfConnected();

    require 'Repositories/DrinkRepository.php';
    require 'Models/Drink.php';

    if(isset($_POST) && isset($_POST['id']) && isset($_POST['newPrice'])){

        $drinkRepository = new DrinkRepository();
        $drink           = $drinkRepository->findDrinkById($_POST['id']);

        $history   = json_decode($drink->getHistory(), true);
        $history[] = $drink->getCurrentPrice();
        $drink->setHistory(json_encode($history));

        $drink->setPreviousPrice($drink->getCurrentPrice());
        $drink->setCurrentPrice($_POST['newPrice']);

        $drinkRepository->flush($drink);
    }

    header('Location: ?/prices');
}

dispatch('/drink/disable/:id', 'disableDrink');
function disableDrink($id){
    checkIfConnected();

    require 'Repositories/DrinkRepository.php';
    require 'Models/Drink.php';

    $drinkRepository = new DrinkRepository();
    $drinkRepository->disableDrinkById($id);

    if(parse_url($_SERVER["HTTP_REFERER"])["query"] != null){
        header('Location: ?'.parse_url($_SERVER["HTTP_REFERER"])["query"]);
    }else{
        header('Location: ?/dashboard');
    }
}

dispatch('/drink/enable/:id', 'enableDrink');
function enableDrink($id){
    checkIfConnected();

    require 'Repositories/DrinkRepository.php';
    require 'Models/Drink.php';

    $drinkRepository = new DrinkRepository();
    $drinkRepository->enableDrinkById($id);

    if(parse_url($_SERVER["HTTP_REFERER"])["query"] != null){
        header('Location: ?'.parse_url($_SERVER["HTTP_REFERER"])["query"]);
    }else{
        header('Location: ?/dashboard');
    }
}

dispatch('/sales', 'sales');
function sales(){
    checkIfConnected();

    require 'Views/Partials/head.php';
    require 'Repositories/DrinkRepository.php';
    require 'Models/Drink.php';

    $drinkRepository = new DrinkRepository();
    $drinks = $drinkRepository->findAllAvailable();
    $availableDrinks = $drinkRepository->findAll();

    require 'Views/sales.php';
}

dispatch('/sales/add/:id', 'addSale');
function addSale($id){
    checkIfConnected();

    require 'Repositories/DrinkRepository.php';
    require 'Models/Drink.php';

    $drinkRepository = new DrinkRepository();
    $drink           = $drinkRepository->findDrinkById($id);

    $drink->setSalesCount($drink->getSalesCount()+1);
    $drink->setEstimatedRevenue($drink->getEstimatedRevenue() + $drink->getCurrentPrice());

    $drinkRepository->flush($drink);
    header('Location: ?/sales');
}


dispatch('api/getDrinkData/', 'getDrinkData');
function getDrinkData(){
    require 'Repositories/DrinkRepository.php';
    require 'Models/Drink.php';

    header('Content-Type: text/json');

    $drinkRepository = new DrinkRepository();
    $drinks          = $drinkRepository->findAll();

    $jsonDrinks = "[";

    foreach ($drinks as $key => $drink){
        $jsonDrinks .= $drink->toJSON();
        if($key+1 != count($drinks)){
            $jsonDrinks .= ",";
        }
    }

    $jsonDrinks .= "]";
    echo $jsonDrinks;
}


dispatch('api/getLiveData/', 'getLiveData');
function getLiveData(){
    require 'Repositories/DrinkRepository.php';
    require 'Models/Drink.php';

    header('Content-Type: text/json');

    $drinkRepository = new DrinkRepository();
    $drinks          = $drinkRepository->findAll();

    $jsonDrinks = "[";

    foreach ($drinks as $key => $drink){
        $jsonDrinks .= $drink->toJSON();
        if($key+1 != count($drinks)){
            $jsonDrinks .= ",";
        }
    }

    $jsonDrinks .= "]";
    echo $jsonDrinks;
}

dispatch('api/getAlertsData/', 'getAlertsData');
function getAlertsData(){
    require 'Repositories/ConfigRepository.php';
    require 'Models/Config.php';

    header('Content-Type: text/json');

    $configRepository = new ConfigRepository();
    $priceUpConfig    = $configRepository->findConfigById("priceUp");
    $priceDownConfig  = $configRepository->findConfigById("priceDown");

    echo '{"priceUpAlert":'. $priceUpConfig->getBooleanValue().', "priceDownAlert" : '.$priceDownConfig->getBooleanValue().'}';
}

run();

?>
