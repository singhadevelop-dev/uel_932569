<?php $_CURRENT_PAGE_CODE = "BLOG" ?>
<?php include_once "_cogs.php"; ?>
<?php include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/UtilService.php"; ?>
<?php include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/DataService.php"; ?>
<?php
$data = DataService::getInstance()->GetPortfolioByCode($_GET["ref"]);
$_tags = array();
$_tags_code = array();
$dataTags = DataService::getInstance()->GetTagMaster($_CURRENT_PAGE_CODE);
foreach ($dataTags as $tag) {
	if (strpos($data["Tag"], $tag["TagCode"]) !== false) {
		array_push($_tags, $tag["TagName"]);
		array_push($_tags_code, $tag["TagCode"]);
	}
}
$_CURRENT_PAGE_HEADER = array(
	'URL' => DetailPageURL($data["PortCode"], $data["PortName"]),
	'TITLE' => $data["PortName"] . (!empty($data["Title"]) ? "," . $data["Title"] : ""),
	'IMAGE' => $data["Image"],
	'DESCRIPTION' => !empty($data["Description"]) ? $data["Description"] : $data["ShortDescription"],
	'KEYWORD' => count($_tags) <= 0 ? $data["PortName"] : join(",", $_tags)
);
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

		<div class="rs-inner-blog pt-80 pb-80 sm-pt-40 sm-pb-40">
			<div class="container-xl">
				<div class="row">
					<div class="col-lg-12 md-mb-50">
						<div class="blog-details">
							<!-- Slider Section Start -->
							<div class="rs-slider pb-25 case-slider-style3">
								<div class="rs-carousel owl-carousel" data-loop="true" data-items="1" data-margin="0" data-autoplay="true" data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800" data-dots="false" data-nav="false" data-nav-speed="false" data-center-mode="false" data-mobile-device="1" data-mobile-device-nav="false" data-mobile-device-dots="false" data-ipad-device="1" data-ipad-device-nav="true" data-ipad-device-dots="false" data-ipad-device2="1" data-ipad-device-nav2="true" data-ipad-device-dots2="false" data-md-device="1" data-md-device-nav="true" data-md-device-dots="false">
									<?php
									$index = 0;
									foreach (DataService::getInstance()->GetGalleryMaster($data["PortCode"]) as $gallery) {
										$index++;
									?>
										<div class="slider-img">
											<img src="<?php echo $gallery["ImagePath"] ?>" alt="<?php echo $gallery["ImageName"] ?>">
										</div>
									<?php } ?>
									<?php if ($index <= 0) { ?>
										<div class="slider-img">
											<img src="<?php echo $data["Image"] ?>" alt="<?php echo !empty($data["PortDetail2"]) ? $data["PortDetail2"] : $data["PortName"] ?>">
										</div>
									<?php } ?>
								</div>
							</div>
							<!-- Slider Section End -->
							<div class="blog-full">
								<div class="blog-content-full">
									<?php echo IncludeDynamicPageHTML($data["PortDetail"], true) ?>
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

	<!-- Footer Start -->

	<!-- Footer End -->

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