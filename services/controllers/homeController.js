app.controller('homeController', function($scope, $interval,$http) {
    $scope.drinks = [];

    $scope.labels = [];
    $scope.series = ['Biere', 'Punch', 'test'];

    $scope.drinksData = {};

    $scope.pricesAlert = {"priceUpAlert":1, "priceDownAlert" : 0};

    //@todo : remplir les données au demarrage avec les données du serveur
    $scope.data = [
        [],
        []
    ];

    $scope.diagramSize = 45;

    $scope.colors = ["#3498db", "#f1c40f", "#c0392b", "#9b59b6", "#d35400", "#2c3e50", "#2ecc71", "#7f8c8d"];

    $scope.datasetOverride = [{ yAxisID: 'y-axis-1'}];
    $scope.options = {
        scales: {
            yAxes: [
                {
                    id: 'y-axis-1',
                    type: 'linear',
                    display: true,
                    position: 'left'
                }
            ]
        },
        elements: {
            line: {
                    fill: false,
                    borderWidth: 5
            }
        },
        legend: {display: true, labels:{fontSize:20}}
    };

    Chart.defaults.global.animation.duration = 0;
    Chart.defaults.global.maintainAspectRatio = false;

    $scope.sendDrinksDataRequest = function(){
        $http({
            method: 'GET',
            url: '/server/?/api/getDrinkData/'
        }).then(function successCallback(response) {
            $scope.series = [];
            for(var drink in response.data){
                if(response.data[drink].isEnable == 1){
                    $scope.series.push(response.data[drink].name);
                    if($scope.data[drink] == null){
                        $scope.data[drink] = [];
                    }
                    $scope.data[drink].push(response.data[drink].currentPrice);
                }else{
                    $scope.data[drink].push(null);
                }

                if($scope.data[drink].length > $scope.diagramSize){
                    $scope.data[drink].shift();
                }
                if($scope.labels.length > $scope.diagramSize){
                    $scope.labels.shift();
                }
            }

            $scope.labels.push(" ");

        }, function errorCallback(response) {
            console.error(response);
        });
    }

    $scope.sendDrinksLiveDataRequest = function(){
        $http({
            method: 'GET',
            url: '/server/?/api/getDrinkData/'
        }).then(function successCallback(response) {
            $scope.updateDrinksData(response.data);
        }, function errorCallback(response) {
            console.error(response);
        });
    }

    $scope.sendAlertRequest = function(){
        $http({
            method: 'GET',
            url: '/server/?/api/getAlertsData/'
        }).then(function successCallback(response) {
            $scope.pricesAlerts = response.data;
        }, function errorCallback(response) {
            console.error(response);
        });
    }

    $scope.sendDrinksDataRequest();
    $interval(function () {
        $scope.sendDrinksDataRequest();
    }, 20000);

    $scope.sendDrinksLiveDataRequest();
    $interval(function () {
        $scope.sendDrinksLiveDataRequest();
    }, 1000);

    $scope.sendAlertRequest();
    $interval(function () {
        $scope.sendAlertRequest();
    }, 1000);

    $scope.updateDrinksData = function(drinks){

        $scope.drinksData = [];

        for(var drink in drinks){
            if(drinks[drink].isEnable == 1){
                console.log('----');
                console.log('current' + drinks[drink].currentPrice);
                console.log('previous' + drinks[drink].previousPrice);
                if(parseInt(drinks[drink].currentPrice) > parseInt(drinks[drink].previousPrice)){
                    drinks[drink].increase = true;
                }else{
                    drinks[drink].increase = false;
                }
                $scope.drinksData.push(drinks[drink]);
            }
        }

    }
});
