<?php
$sectionid = "SERVICE-Grid-Content-20";
$thismasterdetail = DataService::getInstance()->GetPortfolio("MASTERDETAIL-" . $sectionid)[0];
$taglist = DataService::getInstance()->GetTagMaster("SERVICE");
$thisgridcontent = DataService::getInstance()->GetPortfolio("SERVICE");
?>
<div id="rs-services" class="rs-services services-style20 pt-80 pb-80 sm-pt-40 sm-pb-40 Grid-Content-20">
	<div class="container-fluid">
		<div class="row y-middle">
			<?php 
				foreach ($thisgridcontent as $items) {
					if(!empty($items["PortRefCode"])){
						$_URL = DetailPageURL($items["PortCode"],$items["PortRefCode"]);
					}else{
						$_URL = DetailPageURL($items["PortCode"],$items["PortName"]);
					} 
			?>
				<div class="col-xl-3 col-md-6 xl-mb-30 mb-30">
					<div class="services-item">
						<div class="services-images">
							<img src="<?php echo $items["Image"]; ?>" alt="<?php echo !empty($items["PortDetail2"]) ? $items["PortDetail2"] : $items["PortName"] ?>">
							<div class="services-icon">
								<img src="<?php echo $items["Image2"]; ?>" alt="<?php echo !empty($items["PortDetail2"]) ? $items["PortDetail2"] : $items["PortName"] ?>">
							</div>
						</div>
						<div class="services-text">
							<h5 class="title"><a href="<?php echo $_URL ?>"><?php echo $items["PortName"]; ?></a></h5>
							<p class="services-txt"><?php echo $items["ShortDescription"]; ?></p>
							<div class="services-btn btn-style6">
								<a href="<?php echo $_URL ?>">ดูเพิ่มเติม</a>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>