var app = angular.module('bourseALaBiere', ["ngRoute", "chart.js"]);

app.config(function($routeProvider) {
    $routeProvider.
    when('/', {
        templateUrl: 'views/home.php',
        controller: 'homeController'
    })
    .otherwise({
        redirectTo: '/'
    });
});
