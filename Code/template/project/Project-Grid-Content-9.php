<?php $sectionid = "PROJECT-Grid-Content-9"; ?>
<div id="rs-project" class="rs-project project-style2 project-modify1 pt-80 pb-80 sm-pt-40 sm-pb-40 Grid-Content-9">
	<div class="container-xl">
		<?php $thismasterdetail = DataService::getInstance()->GetPortfolio("MASTERDETAIL-" . $sectionid)[0]; ?>
		<div class="sec-title text-center mb-40 md-mb-20">
			<span class="sub-text"><?php echo $thismasterdetail["PortName"]; ?></span>
			<h2 class="title"><?php echo $thismasterdetail["ShortDescription"]; ?></h2>
		</div>
		<div class="row">
			<?php
			$i = 1;
			$thisgridcontent = DataService::getInstance()->GetPortfolio("PROJECT");
			foreach ($thisgridcontent as $items) {
				if ($i % 2 == 0) {
					$class = "";
					$number = "even";
				} else {
					$class = "mb-30";
					$number = "odd";
				}
				
				if(!empty($items["PortRefCode"])){
					$_URL = DetailPageURL($items["PortCode"],$items["PortRefCode"]);
				}else{
					$_URL = DetailPageURL($items["PortCode"],$items["PortName"]);
				}
			?>
				<?php if ($number = "odd") { ?>
					<div class="col-lg-4 col-md-6 md-mb-30">
					<?php } ?>
					<div class="project-item <?php echo ($number = "even") ? "mb-30" : ""; ?>">
						<div class="project-img">
							<img src="<?php echo $items["Image"]; ?>" class="w-100" alt="<?php echo !empty($items["PortDetail2"]) ? $items["PortDetail2"] : $items["PortName"] ?>">
						</div>
						<div class="project-content">
							<div class="p-icon"><a href="<?php echo $_URL ?>"><i class="fi fi-rr-arrow-small-right"></i></a></div>
							<div class="project-inner">
								<h3 class="title"><a href="<?php echo $_URL ?>"><?php echo $items["PortName"]; ?></a></h3>
								<span class="category"><a href="<?php echo $_URL ?>"><?php echo $items["CategoryName"]; ?></a></span>
							</div>
						</div>
					</div>
					<?php if ($number = "odd") { ?>
					</div>
				<?php } ?>
			<?php $i++;
			} ?>
		</div>
	</div>
</div>