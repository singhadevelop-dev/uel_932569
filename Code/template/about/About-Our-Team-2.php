<?php 
	$sql = "select * from portfolio where PortType='MASTERDETAIL-ABOUT_TEAM_2' and Active=1";
	$Mteam = SelectRow($sql);
?>
<div class="rs-team team-style3 bg11 pt-80 pb-80 sm-pt-40 sm-pb-40 Our-Team-2" style="background: url(<?php echo $Mteam["Image"] ?>);">
	<div class="container-xl">
		<div class="sec-title text-center mb-40 md-mb-20">
			<span class="sub-text"><?php echo $_Util_PageConfig->GetConfig("TEAM")->PageName() ?></span>
			<h2 class="title"><?php echo $Mteam["PortName"] ?></h2>
		</div>
		<div class="rs-carousel owl-carousel" data-loop="true" data-items="3" data-margin="30" data-autoplay="true" data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800" data-dots="false" data-nav="false" data-nav-speed="false" data-center-mode="false" data-mobile-device="1" data-mobile-device-nav="false" data-mobile-device-dots="false" data-ipad-device="2" data-ipad-device-nav="false" data-ipad-device-dots="true" data-ipad-device2="2" data-ipad-device-nav2="false" data-ipad-device-dots2="true" data-md-device="3" data-md-device-nav="false" data-md-device-dots="true">
			<?php 
				$sql = "select * from team where RefCode='ABOUT_TEAM_2' and Active=1 order by SEQ,TeamCode";
				$teams = SelectRowsArray($sql);
				foreach($teams as $team){
			?>
			<div class="team-item-wrap">
				<div class="team-inner-wrap">
					<div class="image-wrap">
						<a href="javascript:;"><img src="<?php echo $team["Image"] ?>" alt="<?php echo $team["TeamName"] ?>"></a>
					</div>
					<div class="team-content">
						<div class="team-info">
							<h3 class="team-name">
								<a href="javascript:;"><?php echo $team["TeamName"] ?></a>
							</h3>
							<span class="team-title"><?php echo $team["Position"] ?></span>
						</div>
						<div class="plus-team">
							<div class="social-icons">
								<a href="<?php echo !empty($team["Facebook"]) ? $team["Facebook"] : "#" ?>"><i class="fab fa-facebook"></i></a>                               
								<a href="<?php echo !empty($team["IG"]) ? $team["IG"] : "#" ?>"><i class="fab fa-instagram"></i></a>                               
								<a href="<?php echo !empty($team["Twitter"]) ? $team["Twitter"] : "#" ?>"><i class="fab fa-twitter"></i></a>                               
								<a href="<?php echo !empty($team["Linkedin"]) ? $team["Linkedin"] : "#" ?>"><i class="fab fa-linkedin"></i></a>                               
							</div>
							<i class="fi fi-rr-share share-i"></i>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
