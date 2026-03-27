<!-- Breadcrumbs Start -->
<?php 
	$sql = "select * from gallery where RefCode='BANNER_$_CURRENT_PAGE_CODE' and Active=1";
	$banner = SelectRow($sql);
?>
<div class="rs-breadcrumbs img1" style="background: url(<?php echo $banner["ImagePath"] ?>);">
	<div class="container-xl">
		<div class="breadcrumbs-inner">
			<h1 class="page-title">
				<?php echo $_Util_PageConfig->GetConfig($_CURRENT_PAGE_CODE)->PageName() ?>
			</h1>
			<span class="sub-text"><?php echo $_Util_WebsitDetail["WebName"] ?></span>
		</div>
	</div>
</div>
<!-- Breadcrumbs End -->