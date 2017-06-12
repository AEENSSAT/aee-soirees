<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Bourse à la bière</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="">
                    <a href="?/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="?/dashboard"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="?/prices"><i class="fa fa-fw fa-line-chart"></i> Gestion des prix</a>
                    </li>
                    <li>
                        <a href="?/sales"><i class="fa fa-fw fa-glass"></i> Gestion des ventes</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics Overview</small>
                        </h1>
                        <?php
                            if($priceUpAlert){
                                echo "<div class='alert alert-danger' role='alert'>Alerte prix en hausse en cours</div>";
                            }

                            if($priceDownAlert){
                                echo "<div class='alert alert-success' role='alert'>Alerte prix en baisse en cours</div>";
                            }
                         ?>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                <?php foreach ($availableDrinks as $drink){

                    $panelColor = $drink->getCurrentPrice() > $drink->getPreviousPrice() ? "red" : "green";
                    $variationText = $drink->getCurrentPrice() > $drink->getPreviousPrice() ? "prix en hausse" : "prix en baisse";
                    $faLabel = $drink->getCurrentPrice() > $drink->getPreviousPrice() ? "arrow-up" : "arrow-down";

                    ?>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-<?php echo $panelColor; ?>">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-<?php echo $faLabel; ?> fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $drink->getName()." : ".$drink->getCurrentPrice(); ?></div>
                                        <div><?php echo $variationText; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-glass"></i> Available drinks</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>name</th>
                                                <th>currentPrice</th>
                                                <th>previousPrice</th>
                                                <th>history</th>
                                                <th>isEnable</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($availableDrinks as $drink){ ?>
                                            <tr>
                                                <td><?php echo $drink->getId(); ?></td>
                                                <td><?php echo $drink->getName(); ?></td>
                                                <td><?php echo $drink->getCurrentPrice(); ?></td>
                                                <td><?php echo $drink->getPreviousPrice(); ?></td>
                                                <td><?php echo $drink->getHistory(); ?></td>
                                                <td><a href="?/drink/disable/<?php echo $drink->getId(); ?>" class="btn btn-default">Disable</a></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-glass"></i> Unavailable drinks</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>name</th>
                                                <th>currentPrice</th>
                                                <th>previousPrice</th>
                                                <th>history</th>
                                                <th>isEnable</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($unavailableDrinks as $drink){ ?>
                                            <tr>
                                                <td><?php echo $drink->getId(); ?></td>
                                                <td><?php echo $drink->getName(); ?></td>
                                                <td><?php echo $drink->getCurrentPrice(); ?></td>
                                                <td><?php echo $drink->getPreviousPrice(); ?></td>
                                                <td><?php echo $drink->getHistory(); ?></td>
                                                <td><a href="?/drink/enable/<?php echo $drink->getId(); ?>" class="btn btn-default">Enable</a></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-glass"></i> Alertes</h3>
                            </div>
                            <div class="panel-body">
                                <h4>Alerte prix en baisse</h4>
                                <a href="?/priceDownAlert/enable" class="btn btn-success">Activer</a>
                                <a href="?/priceDownAlert/disable" class="btn btn-danger">Desactiver</a>

                                <hr>

                                <h4>Alerte prix en hausse</h4>
                                <a href="?/priceUpAlert/enable" class="btn btn-success">Activer</a>
                                <a href="?/priceUpAlert/disable" class="btn btn-danger">Desactiver</a>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="Assets/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="Assets/js/bootstrap.min.js"></script>

</body>

</html>
