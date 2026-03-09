<?php $_CURRENT_PAGE_CODE = "ABOUT3" ?>
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
                        <div class="rs-choose choose-style4 choose-modify1">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="rs-choose-content">

                                        <?php
                                        $thisgridcontent = DataService::getInstance()->GetPortfolio("ABOUT3");
                                        foreach ($thisgridcontent as $items) {
                                        ?>
                                            <div class="rs-addon-services mb-38">
                                                <div class="services-icon md-mb-30">
                                                    <img src="<?php echo $items["Image"] ?>" alt="<?php echo $items["PortName"] ?>">
                                                </div>
                                                <div class="services-text">
                                                    <h4 class="title"><?php echo $items["PortName"] ?></h4>
                                                    <div class="contact-box mb-10 d-flex">
                                                        <div class="contact-icon">
                                                            <img src="assets/images/location.png" alt="images">
                                                        </div>
                                                        <div class="content-text">
                                                            <p class="services-txt">ADD : <?php echo ConvertNewLine($items["Address"]) ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="contact-box mb-10 d-flex">
                                                        <div class="contact-icon">
                                                            <img src="assets/images/phone.png" alt="images">
                                                        </div>
                                                        <div class="content-text">
                                                            <p class="services-txt">TEL : <?php echo $items["Phone"] ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="contact-box mb-10 d-flex">
                                                        <div class="contact-icon">
                                                            <img src="assets/images/fax.png" alt="images">
                                                        </div>
                                                        <div class="content-text">
                                                            <p class="services-txt">FAX : <?php echo $items["Fax"] ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="contact-box mb-10 d-flex">
                                                        <div class="contact-icon">
                                                            <img src="assets/images/link.png" alt="images">
                                                        </div>
                                                        <div class="content-text">
                                                            <p class="services-txt">URL : <a href="<?php echo $items["PortDetail1"] ?>" target="_blank"><?php echo $items["PortDetail1"] ?></a></p>
                                                        </div>
                                                    </div>
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