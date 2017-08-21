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
                                <h3 class="panel-title"><i class="fa fa-glass"></i> Sales management</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">

                                    <?php
                                    foreach ($drinks as $drink){
                                        $id = $drink->getId();
                                        ?>
                                            <a href="?/sales/add/<?php echo $id ?>" class="btn btn-success btn-lg" style="margin:15px;"><?php echo $drink->getName().' - '.$drink->getCurrentPrice().'t <sub>('.$drink->getSalesCount().')</sub>'; ?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-glass"></i> Drinks</h3>
                                </div>
                                <div class="panel-body">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nombre de ventes</th>
                                                    <th>Revenu estimé</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $totalSalesCount = 0;
                                                $totalEstimatedRevenue = 0;
                                                foreach ($availableDrinks as $drink){

                                                    $totalSalesCount += $drink->getSalesCount();
                                                    $totalEstimatedRevenue += $drink->getEstimatedRevenue();

                                                    ?>

                                                    <tr>
                                                        <td><?php echo $drink->getName(); ?></td>
                                                        <td><?php echo $drink->getSalesCount(); ?></td>
                                                        <td><?php echo $drink->getEstimatedRevenue(); echo ' ('.$drink->getEstimatedRevenue()*$ticketPrice;?> €)</td>
                                                    </tr>
                                                    <?php } ?>

                                                    <tr>
                                                        <th>Total</th>
                                                        <th><?php echo $totalSalesCount ?></th>
                                                        <th><?php echo $totalEstimatedRevenue; echo ' ('.$totalEstimatedRevenue*$ticketPrice;?> €)</th>
                                                    </tr>

                                                </tbody>
                                            </table>

                                    </form>
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
