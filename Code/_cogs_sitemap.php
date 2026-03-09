<?php 
$sql = "select ImageName,ImagePath,ImagePath2,ImageDetail from gallery where RefCode = 'BANNER_$_CURRENT_PAGE_CODE'";
$siteBanner = SelectRow($sql);
?>




<section class="header-inner header-inner-menu bg-overlay-black-50" style="background-image: url('<?php echo $siteBanner["ImagePath"]?>');">
		<div class="container position-relative">
			<div class="row d-flex justify-content-center position-relative">
				<div class="col-md-8">
					<div class="header-inner-title text-center">
						<h1 class="text-white fw-normal text-uppercase"><?php echo $_Util_PageConfig->GetConfig($_CURRENT_PAGE_CODE)->PageName() ?></h1>
						<p class="text-white mb-0"><?php echo $_Util_PageConfig->GetConfig($_CURRENT_PAGE_CODE)->Description() ?></p>
					</div>
				</div>
			</div>
		</div>
	</section>


