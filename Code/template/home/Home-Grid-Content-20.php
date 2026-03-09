<?php
$sectionid = "Grid-Content-20";
$thismasterdetail = DataService::getInstance()->GetPortfolio("MASTERDETAIL-" . $sectionid)[0];
$taglist = DataService::getInstance()->GetTagMaster($sectionid);
$thisgridcontent = DataService::getInstance()->GetCategory("PRODUCT");
if ($thismasterdetail["Active"] == 1) {
?>
	<div id="rs-services" class="rs-services services-style20 pt-80 pb-80 sm-pt-40 sm-pb-40 Grid-Content-20" style="background-image: url('<?php echo $thismasterdetail["Image"]; ?>');">
		<div class="container-xl">
			<div class="sec-title text-center mb-80 md-mb-40">
				<h2 class="title"><?php echo $thismasterdetail["ShortDescription"]; ?></h2>
			</div>
			<div class="row y-middle">
				<?php
				foreach ($thisgridcontent as $items) {
					$_URL = $_Util_PageConfig->GetConfig("PRODUCT")->PageURLName()."?cat=".$items["CategoryCode"];
				?>
					<div class="col-xl-4 col-md-6 xl-mb-30 mb-30">
						<div class="services-item">
							<div class="services-images">
								<img src="<?php echo $items["Image"]; ?>" alt="<?php echo $items["CategoryName"]; ?>">
								<div class="services-icon">
									<img src="<?php echo $items["Image2"]; ?>" alt="<?php echo $items["CategoryName"]; ?>">
								</div>
							</div>
							<div class="services-text">
								<h5 class="title"><a href="<?php echo $_URL ?>"><?php echo $items["CategoryName"]; ?></a></h5>
								<p class="services-txt"><?php echo ConvertNewLine($items["CategoryDetail"]); ?></p>
								<div class="services-btn btn-style6">
									<a href="<?php echo $_URL ?>">Read More</a>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>