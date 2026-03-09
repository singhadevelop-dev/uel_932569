<?php $_CURRENT_PAGE_CODE = "CATEGORY" ?>
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

        <?php $_mproduct = DataService::getInstance()->GetPortfolio("MASTERDETAIL-PRODUCT")[0]; ?>
        <div class="pt-120 pb-120 md-pt-80 md-pb-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb-50">
                        <div class="sec-title mb-30">
                            <h2 class="title"><?php echo $_Util_PageConfig->GetConfig("CATEGORY")->PageName() ?></h2>
                        </div>
                        <?php echo IncludeDynamicPageHTML($_mproduct["PortDetail"], false) ?>
                    </div>
                </div>
                <div class="row y-middle rs-services services-style13">
                    <?php
                    $index=0;
                    $thisgridcontent = DataService::getInstance()->GetCategory("PRODUCT");
                    foreach ($thisgridcontent as $items) {
                        $index++;
                        $_URL = $_Util_PageConfig->GetConfig("PRODUCT")->PageURLName() . "?cat=" . $items["CategoryCode"];
                    ?>
                        <div class="col-xl-4 col-md-6 mb-20">
                            <div class="services-item">
                                <div class="serial-number"> <?php echo $index > 9 ? $index : "0".$index ?></div>
                                <div class="services-icon">
                                    <a href="<?php echo $_URL ?>"><img src="<?php echo $items["Image2"]; ?>" alt="<?php echo $items["CategoryName"]; ?>"></a>
                                </div>
                                <div class="services-text">
                                    <h4 class="title"><a href="<?php echo $_URL ?>"><?php echo $items["CategoryName"]; ?></a></h4>
                                    <p class="services-txt"><?php echo ConvertNewLine($items["CategoryDetail"]); ?></p>
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