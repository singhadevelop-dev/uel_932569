<?php
$thismasterdetail = DataService::getInstance()->GetPortfolio("MASTERDETAIL-TEAM_2")[0];
$thisgridcontent = DataService::getInstance()->GetPortfolio("TEAM_2");
?>
<?php if ($thismasterdetail["Active"] == 1) { ?>
	<div class="rs-team team-style3 pt-80 pb-80 Our-Team-2" style="background: url(<?php echo $thismasterdetail["Image"] ?>);">
		<div class="container">
			<div class="sec-title text-center mb-80 md-mb-40">
				<h2 class="title"><?php echo $thismasterdetail["ShortDescription"]; ?></h2>
			</div>
			<div class="rs-carousel owl-carousel" data-loop="false" data-items="3" data-margin="30" data-autoplay="false" data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800" data-dots="false" data-nav="false" data-nav-speed="false" data-center-mode="false" data-mobile-device="1" data-mobile-device-nav="false" data-mobile-device-dots="false" data-ipad-device="2" data-ipad-device-nav="false" data-ipad-device-dots="true" data-ipad-device2="2" data-ipad-device-nav2="false" data-ipad-device-dots2="true" data-md-device="3" data-md-device-nav="false" data-md-device-dots="true">
				<?php
				foreach ($thisgridcontent as $team) {
				?>
					<div class="team-item-wrap">
						<div class="team-inner-wrap">
							<div class="image-wrap">
								<img src="<?php echo $team["Image"] ?>" alt="<?php echo $team["PortName"] ?>" class="w-auto">
							</div>
							<div class="team-content">
								<div class="team-info">
									<span class="team-title"><?php echo $thismasterdetail["PortName"] ?></span>
									<h3 class="team-name">
										<?php echo $team["PortName"] ?>
									</h3>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>