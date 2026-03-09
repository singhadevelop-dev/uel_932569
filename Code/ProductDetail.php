<?php $_CURRENT_PAGE_CODE = "PRODUCT" ?>
<?php include_once "_cogs.php"; ?>
<?php include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/UtilService.php"; ?>
<?php include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/DataService.php"; ?>
<?php
$product = DataService::getInstance()->GetProduct("", $_GET["ref"])[0];
$_tags = array();
$dataTags = DataService::getInstance()->GetTagMaster($_CURRENT_PAGE_CODE);
foreach ($dataTags as $tag) {
	if (strpos($product["Tag"], $tag["TagCode"]) !== false) {
		array_push($_tags, $tag["TagName"]);
	}
}

$_CURRENT_PAGE_HEADER = array(
	'URL' => DetailPageURL($product["ProductCode"], $product["ProductName"]),
	'TITLE' => !empty($product["Title"]) ? $product["Title"] : $product["ProductName"],
	'IMAGE' => $product["Image"],
	'DESCRIPTION' => !empty($product["Description"]) ? $product["Description"] : $product["ShortDescription"],
	'KEYWORD' => !empty($product["Keyword"]) ? $product["Keyword"] : join(",", $_tags)
);

$__REF_CAT = $product["CategoryCode"];

?>
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

		<div id="rs-single-shop" class="rs-single-shop pt-120 pb-105 md-pt-80 md-pb-65">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-12 md-mb-50 pl-25 md-pl-15 rs-inner-blog">
						<div class="rs-faq faq-style1 p-0">
							<div class="faq-content p-0">
								<div id="accordion" class="accordion">
									<?php
									$index = 0;
									$_cats = DataService::getInstance()->GetCategory("PRODUCT");
									foreach ($_cats as $_cat) {
										$_URL = $_Util_PageConfig->GetConfig("PRODUCT")->PageURLName() . "?cat=" . $_cat["CategoryCode"];
										$index++;
									?>
										<div class="card">
											<div class="card-header">
												<a href="<?php echo $_URL ?>"
													class="card-link"
													data-bs-toggle="collapse <?php echo $product["CategoryCode"] == $_cat["CategoryCode"] ? "" : "collapsed" ?>"
													data-bs-target="#collapse<?php echo $index ?>"
													aria-expanded="<?php echo $product["CategoryCode"] == $_cat["CategoryCode"] ? "true" : "false" ?>"
													onclick="window.location.href=this.href; return false;">
													<?php echo $_cat["CategoryName"] ?>
												</a>
											</div>

											<div id="collapse<?php echo $index ?>" class="collapse <?php echo $product["CategoryCode"] == $_cat["CategoryCode"] ? "show" : "" ?>" data-bs-parent="#accordion">
												<div class="card-body categories">
													<ul>
														<?php
														$_products = DataService::getInstance()->GetProduct($_cat["CategoryCode"]);
														foreach ($_products as $_product) {
															$_URL = DetailPageURL($_product["ProductCode"], $_product["ProductName"]);
														?>
															<li>
																<a href="<?php echo $_URL ?>"><?php echo $_product["ProductName"] ?></a>
															</li>
														<?php } ?>
													</ul>
												</div>
											</div>
										</div>
									<?php } ?>

								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-9">
						<div class="single-price-info pl-30 sm-pl-0">
							<h4 class="product-title"><?php echo $product["ProductName"] ?></h4>
							<div class="mb-30">
								<?php echo IncludeDynamicPageHTML($product["ProductDetail"], false) ?>
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