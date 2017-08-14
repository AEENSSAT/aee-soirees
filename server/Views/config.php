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
                                <h3 class="panel-title"><i class="fa fa-glass"></i> Affichage</h3>
                            </div>
                            <div class="panel-body">
                                <form class="" action="?/config/set/" method="post">
                                    <div class="">
                                        <label>Afficher les variations de prix</label>

                                        <div class="inputRadio">
                                            <input id="displayVariationStatusYes" type="radio" name="displayVariationStatus" value="1" <?php if($displayVariationStatus->getBooleanValue() == 1){ echo 'checked="checked"'; } ?> />
                                            <label for="displayVariationStatusYes">Oui</label>
                                        </div>

                                        <div class="inputRadio">
                                            <input id="displayVariationStatusNo" type="radio" name="displayVariationStatus" value="0" <?php if($displayVariationStatus->getBooleanValue() == 0){ echo 'checked="checked"'; } ?> />
                                            <label for="displayVariationStatusNo">Non</label>
                                        </div>

                                        <hr>
                                    </div>

                                    <?php if($displayVariationStatus->getBooleanValue() == 0){ ?>

                                    <div class="">
                                        <label>Couleur de fond des cartes</label>
                                            <input type="color" name="cardColor" value="<?php echo $cardColor->getTextValue(); ?>" />
                                        <hr>
                                    </div>

                                    <?php } ?>

                                    <div class="">
                                        <label>Afficher le graphique</label>

                                        <div class="inputRadio">
                                            <input id="displayGraphYes" type="radio" name="displayGraph" value="1" <?php if($displayGraph->getBooleanValue() == 1){ echo 'checked="checked"'; } ?> />
                                            <label for="displayGraphYes">Oui</label>
                                        </div>

                                        <div class="inputRadio">
                                            <input id="displayGraphNo" type="radio" name="displayGraph" value="0" <?php if($displayGraph->getBooleanValue() == 0){ echo 'checked="checked"'; } ?> />
                                            <label for="displayGraphNo">Non</label>
                                        </div>

                                        <hr>
                                    </div>

                                    <div class="">
                                        <label>Type de fond</label>

                                        <div class="inputRadio">
                                            <input id="backgroundTypeColor" type="radio" name="backgroundType" value="color" <?php if($backgroundType->getTextValue() == 'color'){ echo 'checked="checked"'; } ?> />
                                            <label for="backgroundTypeColor">Couleur</label>
                                        </div>

                                        <div class="inputRadio">
                                            <input id="backgroundTypeImage" type="radio" name="backgroundType" value="image" <?php if($backgroundType->getTextValue() == 'image'){ echo 'checked="checked"'; } ?> />
                                            <label for="backgroundTypeImage">Image</label>
                                        </div>

                                        <hr>
                                    </div>

                                    <?php if($backgroundType->getTextValue() == 'color'){ ?>

                                    <div class="">
                                        <label>Couleur de fond</label>
                                            <input type="color" name="backgroundColor" value="<?php echo $backgroundColor->getTextValue(); ?>" />
                                        <hr>
                                    </div>

                                    <?php } ?>

                                    <input type="submit" name="" value="Enregistrer">
                                </form>

                                <!--$backgroundType
                                $backgroundColor
                                $displayGraph-->
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
