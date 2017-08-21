<?php
session_start();

require_once 'Libs/limonade/limonade.php';

dispatch('/install', 'install');
function install(){

    if(file_exists('config.php')){
        echo 'aee-soirées is already installed !';
        exit();
    }

    require 'Views/Partials/head.php';
    require 'Views/install.php';
}

dispatch_post('/install', 'performInstall');
function performInstall(){

    if(file_exists('config.php')){
        echo 'aee-soirées is already installed !';
        exit();
    }

    $login = $_POST['login'];
    $password = $_POST['password'];
    $host = $_POST['host'];
    $user = $_POST['user'];
    $dbpassword = $_POST['dbpassword'];
    $name = $_POST['name'];

    $data = "<?php
        define('CONFIG_USER_LOGIN','$login');
        define('CONFIG_USER_PASSWORD', '$password'); \r\n
        define('CONFIG_DATABASE_HOST','$host');
        define('CONFIG_DATABASE_USER','$user');
        define('CONFIG_DATABASE_PASSWORD','$dbpassword');
        define('CONFIG_DATABASE_DBNAME','$name');
    ?>";

    $status = file_put_contents('config.php', $data);
    if($status === false){
        header('Location: ?/install');
    }else{
        header('Location: ?/login');
    }
}

include_once 'config.php';

function checkIfConnected(){
    if(!isset($_SESSION['isConnected']) || $_SESSION['isConnected'] == false){
        header('Location: ?/login');
        exit();
    }
}

dispatch('/', 'admin');
function admin(){

    if(!file_exists('config.php')){
        header('Location: ?/install');
        exit();
    }

    if(isset($_SESSION['isConnected']) && $_SESSION['isConnected'] == true){
        header('Location: ?/dashboard');
    }else{
        header('Location: ?/login');
    }
}

dispatch('login', 'login');
function login(){

    if(!file_exists('config.php')){
        header('Location: ?/install');
        exit();
    }

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
    require 'Repositories/ConfigRepository.php';
    require 'Models/Config.php';

    $drinkRepository = new DrinkRepository();
    $drinks          = $drinkRepository->findAll();

    $configRepository = new ConfigRepository();
    $ticketPrice = $configRepository->findConfigById('ticketPrice');

    require 'Views/prices.php';
}

dispatch('tickets', 'tickets');
function tickets(){
    checkIfConnected();

    require 'Views/Partials/head.php';

    require 'Repositories/ConfigRepository.php';
    require 'Models/Config.php';

    $configRepository = new ConfigRepository();
    $ticketPrice = $configRepository->findConfigById('ticketPrice');

    require 'Repositories/TicketSaleRepository.php';
    require 'Models/TicketSale.php';

    $ticketSaleRepository = new TicketSaleRepository();
    $ticketCount = $ticketSaleRepository->countTicketsSold();
    $estimatedRevenue = $ticketSaleRepository->sumEstimatedRevenue();

    var_dump($ticketCount);

    require 'Views/tickets.php';
}

dispatch('/tickets/sale/:quantity', 'ticketSale');
function ticketSale($quantity){
    checkIfConnected();

    require 'Repositories/TicketSaleRepository.php';
    require 'Models/TicketSale.php';

    require 'Repositories/ConfigRepository.php';
    require 'Models/Config.php';

    $configRepository = new ConfigRepository();
    $ticketPrice = floatval($configRepository->findConfigById('ticketPrice')->getTextValue());

    $quantity = intval($quantity);
    $ticketSale = new TicketSale(time(), $quantity, $ticketPrice, $quantity*$ticketPrice);

    $ticketSaleRepository = new TicketSaleRepository();
    $ticketSaleRepository->addTicketSale($ticketSale);

    header('location: ?/tickets');
}

dispatch_post('ticket/price/set', 'setTicketPrice');
function setTicketPrice(){
    checkIfConnected();

    require 'Repositories/ConfigRepository.php';
    require 'Models/Config.php';

    $configRepository = new ConfigRepository();

    if(empty($_POST['price'])){
        $_POST['price'] = 0;
    }

    $configRepository->setTextValueById('ticketPrice', $_POST['price']);

    header('location: ?/tickets');
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
    require 'Repositories/ConfigRepository.php';
    require 'Models/Config.php';

    $configRepository = new ConfigRepository();
    $ticketPrice = floatval($configRepository->findConfigById('ticketPrice')->getTextValue());

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


dispatch('/config/', 'config');
function config(){
    checkIfConnected();

    require 'Repositories/ConfigRepository.php';
    require 'Models/Config.php';

    $configRepository = new ConfigRepository();

    $displayVariationStatus = $configRepository->findConfigById('displayVariationStatus');
    $cardColor = $configRepository->findConfigById('cardColor');
    $backgroundType = $configRepository->findConfigById('backgroundType');
    $backgroundColor = $configRepository->findConfigById('backgroundColor');
    $displayGraph = $configRepository->findConfigById('displayGraph');

    require 'Views/Partials/head.php';
    require 'Views/config.php';
}

dispatch_post('/config/set/', 'setConfig');
function setConfig(){
    checkIfConnected();

    require 'Repositories/ConfigRepository.php';
    require 'Models/Config.php';

    $configRepository = new ConfigRepository();
    $configRepository->setBooleanValueById('displayVariationStatus', $_POST['displayVariationStatus']);

    if(isset($_POST['cardColor'])){
        $configRepository->setTextValueById('cardColor', $_POST['cardColor']);
    }

    $configRepository->setBooleanValueById('displayGraph', $_POST['displayGraph']);
    $configRepository->setTextValueById('backgroundType', $_POST['backgroundType']);

    if(isset($_POST['backgroundColor'])){
        $configRepository->setTextValueById('backgroundColor', $_POST['backgroundColor']);
    }

    header('Location: ?/config');
}

dispatch('/reset/', 'resetData');
function resetData(){
    checkIfConnected();


    require 'Views/Partials/head.php';
    require 'Views/reset.php';
}

dispatch_post('/reset/confirm', 'resetConfirm');
function resetConfirm(){
    checkIfConnected();

    require 'Repositories/DrinkRepository.php';
    require 'Models/Drink.php';

    require 'Repositories/TicketSaleRepository.php';

    $drinkRepository = new DrinkRepository();
    $ticketSaleRepository = new TicketSaleRepository();

    if(isset($_POST['pwd']) && !empty($_POST['pwd'])){
        if($_POST['pwd'] == CONFIG_USER_PASSWORD){
            $drinkRepository->resetAllDrinks();
            $ticketSaleRepository->clearSales();
        }
    }

    header('Location: ?/reset');
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

dispatch('api/getDisplayConfig/', 'getDisplayConfig');
function getDisplayConfig(){

    require 'Repositories/ConfigRepository.php';
    require 'Models/Config.php';

    header('Content-Type: text/json');

    $configRepository = new ConfigRepository();

    $displayVariationStatus = $configRepository->findConfigById('displayVariationStatus');
    $cardColor = $configRepository->findConfigById('cardColor');
    $backgroundType = $configRepository->findConfigById('backgroundType');
    $backgroundColor = $configRepository->findConfigById('backgroundColor');
    $displayGraph = $configRepository->findConfigById('displayGraph');

    $arr = ["displayVariationStatus" => $displayVariationStatus->getBooleanValue(),
    "cardColor" => $cardColor->getTextValue(),
    "displayGraph" => $displayGraph->getBooleanValue(),
    "backgroundType" => $backgroundType->getTextValue(),
    "backgroundColor" => $backgroundColor->getTextValue()
    ];

    echo json_encode($arr);
}

run();

?>
