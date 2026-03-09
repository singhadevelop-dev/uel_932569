<?php $_CURRENT_PAGE_CODE = "MOVIE" ?>
<?php include_once "_cogs.php"; ?>
<?php include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/UtilService.php"; ?>
<?php include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/DataService.php"; ?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <?php include_once "_cogs_header.php"; ?>
    <?php include_once "Stylesheet.php"; ?>
</head>

<body class="defult-home">

    <div class="offwrap"></div>

    <!-- Main content Start -->
    <div class="main-content">

        <?php include("template/Header-1.php"); ?>

        <?php include("template/Breadcrumbs-1.php"); ?>

        <div id="rs-project" class="rs-project project-style4 port-orange-modify2 pt-80 pb-80 sm-pt-40 sm-pb-40">
            <div class="container-xl">
                <div class="row">
                    <?php
                    $thisgridcontent = DataService::getInstance()->GetPortfolio("Grid-Content-15");
                    foreach ($thisgridcontent as $gridcontent) {
                    ?>
                        <div class="col-lg-4 col-md-6 mb-30">
                            <div class="ag-feature-box-1 margin-bottom">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="<?php echo $gridcontent["Video"]; ?>"></iframe>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php include("template/Footer-1.php"); ?>

    </div>
    <!-- Main content End -->

    <!-- start scrollUp  -->
    <div id="scrollUp">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- End scrollUp  -->

    <!-- Search Modal Start -->
    <div aria-hidden="true" class="modal fade search-modal" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="search-block clearfix">
                    <form>
                        <div class="form-group">
                            <input class="form-control" placeholder="Search Here..." type="text">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Modal End -->

    <?php include_once "Script.php"; ?>
</body>

</html>