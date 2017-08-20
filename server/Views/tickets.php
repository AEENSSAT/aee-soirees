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
                <a class="navbar-brand" href="index.html">Soirées AEE</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="">
                    <a href="?/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <?php require 'Views/Partials/menu.php';?>
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
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-glass"></i> Vente de tickets</h3>
                            </div>
                            <div class="panel-body button-grid" >

                                <?php
                                    for ($i=1;$i<=10;$i++) {
                                ?>

                                <a href="?/tickets/sale/<?php echo $i ?>" class="btn btn-success btn-lg btn-sales"><?php echo $i; ?></a>

                                <?php } ?>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-glass"></i> Statistiques de vente</h3>
                            </div>
                            <div class="panel-body">
                                Nombre de tickets vendus : <strong><?php echo $ticketCount; ?></strong> <br>
                                Revenus estimés : <strong><?php echo round($estimatedRevenue, 1); ?>€</strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-glass"></i> Valeur d'un ticket</h3>
                            </div>
                            <div class="panel-body">
                                <form action="?/ticket/price/set" method="post">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon2">Prix</span><input class="form-control" type="text" name="price" value="<?php echo $ticketPrice->getTextValue(); ?>">
                                    </div>
                                    <br>
                                    <button class="btn btn-default btn-block" style="width:100%;" type="submit">Go!</button>
                                </form>
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
