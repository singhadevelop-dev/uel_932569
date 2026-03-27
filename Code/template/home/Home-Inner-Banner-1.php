<?php
$sectionid = "Inner-Banner-1";
$thismasterdetail = DataService::getInstance()->GetPortfolio("MASTERDETAIL-" . $sectionid)[0];
?>
<?php if ($thismasterdetail["Active"] == 1) { ?>
	<div class="rs-cta pt-80 pb-80 sm-pt-40 sm-pb-40 Inner-Banner-1" style="background:url('<?php echo $thismasterdetail["Image"]; ?>');background-position: center center;background-repeat: no-repeat;background-size: cover;">
		<div class="container-xl d-flex justify-content-center align-items-center">
			<div class="call-action bg-white">
				<div class="sec-title text-center">
					<h2 class="title pb-20">
						<?php echo $thismasterdetail["ShortDescription"]; ?>
					</h2>
					<div class="desc pb-20 text-center">
						<?php IncludeDynamicPageHTML($thismasterdetail["PortDetail"], false); ?>
					</div>
					<div class="services-btn btn-style6">
						<a class="readon more" href="<?php echo $thismasterdetail["PortDetail1"]; ?>"><?php echo $thismasterdetail["ByName"]; ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>