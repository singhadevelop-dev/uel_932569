<?php $_CURRENT_PAGE_CODE = "REVIEW" ?>
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
	
	<?php include("template/Header-2.php"); ?>
	<?php include("template/Breadcrumbs-1.php"); ?>
	<?php include("template/review/Review-5.php"); ?>
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