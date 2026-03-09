<?php $_CURRENT_PAGE_CODE = "PRIVACY" ?>
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

		<div id="rs-single-shop" class="rs-single-shop pt-120 pb-105 md-pt-80 md-pb-65">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<?php echo IncludeDynamicPageHTML("WEBSITE_PRIVACY", false); ?>
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