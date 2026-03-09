<?php $_CURRENT_PAGE_CODE = "BLOG" ?>
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

		<?php
		$thisgridcontent = DataService::getInstance()->GetCategory("Grid-Content-4");
		foreach ($thisgridcontent as $item) {
		?>
			<div id="rs-blog" class="rs-blog blog-main-home pt-80 pb-80 Grid-Content-4">
				<div class="container">
					<div class="sec-title mb-45 md-mb-25">
						<span class="sub-text text-red-2"><?php echo $_Util_WebsitDetail["WebName"] ?></span>
						<h2 class="title"><?php echo $item["CategoryName"]; ?></h2>
					</div>
					<div class="row">
						<?php
						$thisgridcontent = DataService::getInstance()->GetPortfolio("Grid-Content-4", $item["CategoryCode"]);
						foreach ($thisgridcontent as $items) {
							$_URL = DetailPageURL($items["PortCode"], $items["PortName"]);
						?>
							<div class="col-lg-4 col-md-6 mb-30">
								<div class="blog-item">
									<div class="image-wrap">
										<a href="<?php echo $_URL ?>"><img src="<?php echo $items["Image"]; ?>" alt=""></a>
									</div>
									<div class="blog-content">
										<ul class="blog-meta">
											<li class="date"><i class="fa fa-calendar"></i><?php echo ConvertDateDBToDateDisplayLongFormat($items["PortDateTime"]); ?></li>
										</ul>
										<h3 class="blog-title"><a href="<?php echo $_URL ?>"><?php echo $items["PortName"]; ?></a></h3>
										<div class="services-btn btn-style6"><a href="<?php echo $_URL ?>">Read More</a></div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>

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