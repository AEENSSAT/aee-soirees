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
                                            <?php
                                            foreach ($drinks as $drink){
                                                $id = $drink->getId();
                                                ?>

                                                <tr>
                                                    <td><?php echo $drink->getId(); ?></td>
                                                    <td><?php echo $drink->getName(); ?></td>
                                                    <td>
                                                        <form action="?/drink/setPrice" method="post">
                                                            <div class="input-group">
                                                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                                                <input class="form-control" type="text" name="newPrice" style="min-width: 100px;" value="<?php echo $drink->getCurrentPrice(); ?>">
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-default" type="submit">Go!</button>
                                                                </span>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    <td><?php echo $drink->getPreviousPrice(); ?></td>
                                                    <td><?php echo $drink->getHistory(); ?></td>

                                                    <?php
                                                    if($drink->isEnable()){
                                                        echo "<td><a href='?/drink/disable/$id' class='btn btn-default btn-danger'>Disable</a></td>";
                                                    }else{
                                                        echo "<td><a href='?/drink/enable/$id' class='btn btn-default btn-success'>Enable</a></td>";
                                                    }

                                                    ?>


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

                        <div class="col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-glass"></i> Boissons</h3>
                                </div>
                                <div class="panel-body">
                                    <form action="?/drink/add" method="post">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon2">Nom</span><input class="form-control" type="text" name="name" value="">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon2">Prix</span><input class="form-control" type="text" name="price" value="">
                                        </div>
                                        <br>
                                        <button class="btn btn-default btn-block" style="width:100%;" type="submit">Go!</button>
                                        <hr>
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>name</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($drinks as $drink){
                                                    $id = $drink->getId();
                                                    ?>

                                                    <tr>
                                                        <td><?php echo $drink->getName(); ?></td>
                                                        <td><a href='?/drink/remove/<?php echo $id ?>' class='btn btn-default btn-danger'>Remove</a></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

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
