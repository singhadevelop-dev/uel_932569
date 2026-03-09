<?php
$sectionid = "Grid-Content-19";
$thismasterdetail = DataService::getInstance()->GetPortfolio("MASTERDETAIL-" . $sectionid)[0];
$taglist = DataService::getInstance()->GetTagMaster($sectionid);
$thisgridcontent = DataService::getInstance()->GetPortfolio($sectionid);
if ($thismasterdetail["Active"] == 1) {
?>
	<div id="rs-project" class="rs-project project-style9 pt-80 pb-80 sm-pt-40 sm-pb-40 Grid-Content-19">
		<div class="container-xl">
			<div class="sec-title text-center mb-60 md-mb-40">
				<h2 class="title"><?php echo $thismasterdetail["PortName"]; ?></h2>
			</div>
		</div>
		<div class="slider project-slide-2">
			<?php foreach ($thisgridcontent as $items) { ?>
				<div class="grid-item">
					<div class="project-item">
						<div class="project-img">
							<img src="<?php echo $items["Image"]; ?>" alt="<?php echo $items["PortName"]; ?>">
						</div>
						<div class="project-content">
							<div class="project-inner">
								<h3 class="title"><?php echo $items["PortName"]; ?></h3>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
<?php } ?>
<!-- Project Section End -->