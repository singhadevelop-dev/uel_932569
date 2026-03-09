<?php $sectionid = "ABOUT-TIMELINE-CONTENT-1"; ?>
<?php $thismasterdetail = DataService::getInstance()->GetPortfolio("MASTERDETAIL-" . $sectionid)[0]; ?>
<div class="pt-80 pb-80 sm-pt-40 sm-pb-40 bg5 About-Timeline-Content-1" id="style-1" style="background: url(<?php echo $thismasterdetail["Image"]?>) !important;">
	<div class="container-xl">
		<div class="sec-title text-center mb-40 md-mb-20">
			<span class="sub-text"><?php echo $thismasterdetail["PortName"]; ?></span>
			<h2 class="title"><?php echo $thismasterdetail["ShortDescription"]; ?></h2>
		</div>
		<div class="section-body">
			<div class="row">					
				<div class="col-md-12">
					<div class="quick-timeline" data-source="php" data-items="3" data-style="1"></div>
				</div>
			</div>
		</div>
	</div>
</div>