
<style media="screen" ng-if="displayConfig.backgroundType == 'color'">
    body {
        background: {{ displayConfig.backgroundColor }} ;
    }
</style>

<style media="screen" ng-if="displayConfig.backgroundType == 'image'">
    body {
        background: url('client/assets/imgs/bckg.jpg');
        background-size: cover;
    }
</style>

<style media="screen" ng-if="displayConfig.displayVariationStatus == 0">
    .card {
        background: {{ displayConfig.cardColor }} !important;
    }
</style>

<link href="https://fonts.googleapis.com/css?family=Archivo+Black" rel="stylesheet">

<div class="priceAlert priceAlert-up" ng-if="pricesAlerts.priceUpAlert == 1">
    ALERTE PRIX EN HAUSSE
</div>

<div class="priceAlert priceAlert-down" ng-if="pricesAlerts.priceDownAlert == 1">
    ALERTE PRIX EN BAISSE
</div>

<section class="cards">
    <div class="subcard" ng-repeat="(key, drink) in drinksData">

        <div class="card card-red" ng-if="drink.increase && displayConfig.displayVariationStatus == 1">
            <div class="">
                <h2>{{ drink.name }}</h2>
                <h2 ng-if="drink.currentPrice > 1">{{ drink.currentPrice }} tickets</h2>
                <h2 ng-if="drink.currentPrice <= 1">{{ drink.currentPrice }} ticket</h2>
                <span ng-if="displayConfig.displayVariationStatus == 1" class="price-variation">PRIX EN HAUSSE</span>
            </div>
            <i ng-if="displayConfig.displayVariationStatus == 1" class="fa fa-arrow-up fa-5x"></i>
        </div>

        <div class="card card-green" ng-if="!drink.increase && displayConfig.displayVariationStatus == 1">
            <div class="">
                <h2>{{ drink.name }}</h2>
                <h2 ng-if="drink.currentPrice > 1">{{ drink.currentPrice }} tickets</h2>
                <h2 ng-if="drink.currentPrice <= 1">{{ drink.currentPrice }} ticket</h2>
                <span ng-if="displayConfig.displayVariationStatus == 1" class="price-variation">PRIX EN BAISSE</span>
            </div>
            <i ng-if="displayConfig.displayVariationStatus == 1" class="fa fa-arrow-down fa-5x"></i>
        </div>

        <div class="card" ng-if="displayConfig.displayVariationStatus == 0">
            <div class="">
                <h2>{{ drink.name }}</h2>
                <h2 ng-if="drink.currentPrice > 1">{{ drink.currentPrice }} tickets</h2>
                <h2 ng-if="drink.currentPrice <= 1">{{ drink.currentPrice }} ticket</h2>
                <span ng-if="displayConfig.displayVariationStatus == 1" class="price-variation">PRIX EN BAISSE</span>
            </div>
            <i ng-if="displayConfig.displayVariationStatus == 1" class="fa fa-arrow-down fa-5x"></i>
        </div>

    </div>

</section>
<section id="chart" ng-if="displayConfig.displayGraph == 1">
    <canvas id="line" class="chart chart-line" chart-legend="true" chart-data="data" chart-labels="labels" chart-series="series" chart-options="options" chart-colors="colors" chart-dataset-override="datasetOverride" chart-click="onClick" height="500"></canvas>
</section>
