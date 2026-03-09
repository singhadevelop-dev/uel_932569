<?php $_CURRENT_PAGE_CODE = "ABOUT5" ?>
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

    <div class="main-content">

        <?php include("template/Header-1.php"); ?>

        <?php include("template/Breadcrumbs-1.php"); ?>

        <div class="rs-inner-blog pt-120 pb-105 md-pt-80 md-pb-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-12 md-mb-50 pl-25 md-pl-15">
                        <?php include("MainLeft.php"); ?>
                    </div>
                    <div class="col-lg-9">
                        <div class="rs-choose choose-style3 choose-modify1">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="rs-choose-content">
                                        
                                        <?php
                                        $thisgridcontent = DataService::getInstance()->GetPortfolio("ABOUT5");
                                        foreach ($thisgridcontent as $items) {
                                        ?>
                                            <div class="rs-addon-services d-flex align-items-center mb-38">
                                                <div class="services-icon">
                                                    <h4 class="title mb-0 mt-15 text-white fw-400"><?php echo $items["PortName"] ?></h4>
                                                </div>
                                                <div class="services-text">
                                                    <p class="services-txt mb-0"><?php echo ConvertNewLine($items["ShortDescription"]) ?></p>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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