<?php $_CURRENT_PAGE_CODE = "PROJECT" ?>
<?php include_once "_cogs.php"; ?>
<?php include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/UtilService.php"; ?>
<?php include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/DataService.php"; ?>
<?php
$data = DataService::getInstance()->GetPortfolioByCode($_GET["ref"]);
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

	<!--Preloader start here-->
	<div id="pre-load">
		<div id="loader" class="loader">
			<div class="loader-container">
				<div class="loader-icon"><img src="<?php echo $_Util_WebsitDetail["Image4"] ?>" alt="<?php echo $_Util_WebsitDetail["WebName"] ?>"></div>
			</div>
		</div>
	</div>
	<!--Preloader area end here-->

	<!-- Main content Start -->
	<div class="main-content">

		<?php include("template/Header-1.php"); ?>

		<!-- Slider Section Start -->
		<div class="rs-slider case-slider-style3 pt-80 sm-pt-40">
			<div class="container-xl">
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
		</div>
		<!-- Slider Section End -->

		<!-- Project Details Section Start -->
		<div class="rs-project-details pt-80 pb-80 sm-pt-40 sm-pb-40">
			<div class="container-xl">
				<div class="project-information mb-45">
					<div class="row">
						<div class="col-lg-4 col-md-6 md-mb-30">
							<div class="project-content">
								<div class="project-right-border"></div>
								<h4 class="title">Catagory</h4>
								<div class="description">
									<p><?php echo $data["CategoryName"] ?></p>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 md-mb-30 pl-50 md-pl-15">
							<div class="project-content">
								<div class="project-right-border border-two"></div>
								<h4 class="title">Client</h4>
								<div class="description">
									<p><?php echo $data["Client"] ?></p>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 sm-mb-30">
							<div class="project-content">
								<h4 class="title">Completed Date</h4>
								<div class="description">
									<?php $date = explode(" ", ConvertDateDBToDateDisplayLongFormat($data["PortDateTime"])) ?>
									<p><?php echo $date[0] ?> - <?php echo $date[1] ?> - <?php echo $date[2] ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="project-txt mb-30">
					<?php echo IncludeDynamicPageHTML($data["PortDetail"], true) ?>
				</div>
			</div>
		</div>
		<!-- Project Details Section End -->

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