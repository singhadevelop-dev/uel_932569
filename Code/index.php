<?php $_CURRENT_PAGE_CODE = "HOME" ?>
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

	<!-- Main content Start -->
	<div class="main-content">

		<?php include("template/Header-1.php"); ?>

		<?php include("template/home/Banner-5.php"); ?>

		<!-- <//?php include("template/home/Home-Grid-Content-4.php"); ?> -->
		<?php $sectionid = "Grid-Content-4"; ?>
		<?php $thismasterdetail = DataService::getInstance()->GetPortfolio("MASTERDETAIL-" . $sectionid)[0]; ?>
		<?php if ($thismasterdetail["Active"] == 1) { ?>
			<div id="rs-blog" class="rs-blog blog-main-home pt-80 pb-80 Grid-Content-4" style="background-image: url(<?php echo $thismasterdetail["Image"]; ?>);">
				<div class="container">
					<div class="sec-title text-center mb-45 md-mb-25">
						<h2 class="title">
							<?php echo $thismasterdetail["ShortDescription"]; ?>
						</h2>
					</div>
					<div class="row">
						<?php $thisgridcontent = DataService::getInstance()->GetPortfolio($sectionid, "", "", "", " a.PortDateTime desc ", "3");
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
					<div class="text-center mt-45 md-mt-25">
						<div class="services-btn btn-style6">
							<a href="<?php echo $_Util_PageConfig->GetConfig("BLOG")->PageURLName() ?>">See More</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php include("template/home/Home-Grid-Content-20.php"); ?>

		<?php include("template/home/Home-Inner-Banner-1.php"); ?>

		<!-- <//?php include("template/home/Home-Grid-Content-15.php"); ?> -->
		<?php
		$sectionid = "Grid-Content-15";
		$thismasterdetail = DataService::getInstance()->GetPortfolio("MASTERDETAIL-" . $sectionid)[0];
		$taglist = DataService::getInstance()->GetCategory("PROJECT");
		$thisgridcontent = DataService::getInstance()->GetPortfolio("Grid-Content-15");
		?>
		<?php if ($thismasterdetail["Active"] == 1) { ?>
			<div id="rs-project" class="rs-project project-style4 port-orange-modify2 pt-80 pb-80 sm-pt-40 sm-pb-40 Grid-Content-15">
				<div class="container-xl">
					<div class="sec-title text-center mb-40 md-mb-20">
						<h2 class="title"><?php echo $thismasterdetail["ShortDescription"]; ?></h2>
					</div>
					<div class="row mb-40 md-mb-20">
						<?php foreach (array_slice($thisgridcontent, 0, 3) as $gridcontent) {
						?>
							<div class="col-lg-4 col-md-6 mb-30">
								<div class="ag-feature-box-1 margin-bottom">
									<div class="embed-responsive embed-responsive-16by9">
										<iframe class="embed-responsive-item" src="<?php echo $gridcontent["Video"]; ?>"></iframe>
									</div>
									<div class="clearfix"></div>
									<div class="text-box padding-2 text-center">
										<h4>
											<img src="assets/images/18.png" style="width:auto;" alt="<?php echo $gridcontent["PortName"]; ?>">
											<?php echo $gridcontent["PortName"]; ?>
										</h4>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="text-center">
						<div class="btn-part">
							<a class="readon more seemore" href="<?php echo $_Util_PageConfig->GetConfig("MOVIE")->PageURLName() ?>">See More</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>


		<?php include("template/home/Home-Our-Team-2.php"); ?>

		<?php include("template/home/Home-Contact-Form-3.php"); ?>

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