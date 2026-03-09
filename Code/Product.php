<?php $_CURRENT_PAGE_CODE = "PRODUCT" ?>
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

		<div class="pt-120 pb-120 md-pt-80 md-pb-80">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-12 md-mb-50 pl-25 md-pl-15 rs-inner-blog">
						<div class="rs-faq faq-style1 p-0">
							<div class="faq-content p-0">
								<div id="accordion" class="accordion">
									<!-- <?php
											$index = 0;
											$_cats = DataService::getInstance()->GetCategory("PRODUCT");
											foreach ($_cats as $_cat) {
												$_URL = $_Util_PageConfig->GetConfig("PRODUCT")->PageURLName() . "?cat=" . $items["CategoryCode"];
												$index++;
											?>
										<div class="card">
											<div class="card-header">
												<a class="card-link collapsed"
													href="<?php echo $_URL ?>"
													data-bs-toggle="collapse"
													data-bs-target="#collapse<?php echo $index ?>"
													aria-expanded="false">
													<?php echo $_cat["CategoryName"] ?>
												</a>
											</div>
											<div id="collapse<?php echo $index ?>" class="collapse" data-bs-parent="#accordion">
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
									<?php } ?> -->

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
													data-bs-toggle="collapse <?php echo $_GET["cat"] == $_cat["CategoryCode"] ? "" : "collapsed" ?>"
													data-bs-target="#collapse<?php echo $index ?>"
													aria-expanded="<?php echo $_GET["cat"] == $_cat["CategoryCode"] ? "true" : "false" ?>"
													onclick="window.location.href=this.href; return false;">
													<?php echo $_cat["CategoryName"] ?>
												</a>
											</div>

											<div id="collapse<?php echo $index ?>" class="collapse <?php echo $_GET["cat"] == $_cat["CategoryCode"] ? "show" : "" ?>" data-bs-parent="#accordion">
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
						<div class="rs-services services-style10">
							<div class="row">
								<?php
								$thisgridcontent = DataService::getInstance()->GetProduct($_GET["cat"]);
								foreach ($thisgridcontent as $items) {
									$_URL = DetailPageURL($items["ProductCode"], $items["ProductName"]);
								?>
									<div class="col-lg-12 col-md-12 mb-20">
										<div class="services-item">
											<div class="services-icon md-mb-30">
												<img src="<?php echo $items["Image"]; ?>" alt="<?php echo $items["ProductName"]; ?>">
											</div>
											<div class="services-content">
												<h3 class="title"><a href="<?php echo $_URL ?>"><?php echo $items["ProductName"]; ?></a></h3>
												<p class="services-txt"><?php echo ConvertNewLine($items["ShortDescription"]); ?></p>
												<div class="services-btn btn-style4">
													<a class="btn-text" href="<?php echo $_URL ?>">Read More<i class="fi fi-rr-arrow-small-right"></i></a>
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