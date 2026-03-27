<?php
$sectionid = "Grid-Content-15";
$thismasterdetail = DataService::getInstance()->GetPortfolio("MASTERDETAIL-" . $sectionid)[0];
$taglist = DataService::getInstance()->GetCategory("PROJECT");
$thisgridcontent = DataService::getInstance()->GetPortfolio("Grid-Content-15");
?>
<div id="rs-project" class="rs-project project-style4 port-orange-modify2 pt-80 pb-80 sm-pt-40 sm-pb-40 Grid-Content-15">
	<div class="container-xl">
		<div class="sec-title text-center mb-40 md-mb-20">
			<span class="sub-text"><?php echo $thismasterdetail["PortName"]; ?></span>
			<h2 class="title"><?php echo $thismasterdetail["ShortDescription"]; ?></h2>
		</div>
		<div class="row mb-40 md-mb-20">
			<?php
			foreach ($thisgridcontent as $gridcontent) {
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