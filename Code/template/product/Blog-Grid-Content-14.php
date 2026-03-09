<?php
$sectionid = "BLOG-Grid-Content-14";
$thismasterdetail = DataService::getInstance()->GetPortfolio("MASTERDETAIL-" . $sectionid)[0];
$taglist = DataService::getInstance()->GetTagMaster("BLOG");
$thisgridcontent = DataService::getInstance()->GetPortfolio("BLOG");
?>
<div id="rs-project" class="rs-project project-style2 project-modify2 Grid-Content-14">
	<div class="rs-carousel owl-carousel" data-loop="true" data-items="4" data-margin="0" data-autoplay="true" data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800" data-dots="false" data-nav="false" data-nav-speed="false" data-center-mode="false" data-mobile-device="1" data-mobile-device-nav="false" data-mobile-device-dots="false" data-ipad-device="2" data-ipad-device-nav="false" data-ipad-device-dots="false" data-ipad-device2="2" data-ipad-device-nav2="false" data-ipad-device-dots2="false" data-md-device="4" data-md-device-nav="false" data-md-device-dots="false">
		<?php 
			foreach ($thisgridcontent as $items) { 
				if(!empty($items["PortRefCode"])){
					$_URL = DetailPageURL($items["PortCode"],$items["PortRefCode"]);
				}else{
					$_URL = DetailPageURL($items["PortCode"],$items["PortName"]);
				}
			?>
			<div class="project-item">
				<div class="project-img">
					<img src="<?php echo $items["Image"]; ?>" alt="<?php echo !empty($items["PortDetail2"]) ? $items["PortDetail2"] : $items["PortName"] ?>">
				</div>
				<div class="project-content">
					<div class="p-icon"><a href="<?php echo $_URL ?>"><i class="fi fi-rr-arrow-small-right"></i></a></div>
					<div class="project-inner">
						<span class="category"><a href="<?php echo $_URL ?>"><?php echo $items["CategoryName"]; ?></a></span>
						<h3 class="title"><a href="<?php echo $_URL ?>"><?php echo $items["PortName"]; ?></a></h3>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>