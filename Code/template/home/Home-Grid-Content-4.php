<?php $sectionid = "Grid-Content-4"; ?>
<?php $thismasterdetail = DataService::getInstance()->GetPortfolio("MASTERDETAIL-" . $sectionid)[0]; ?>
<div id="rs-blog" class="rs-blog blog-main-home pt-80 pb-80 Grid-Content-4" style="background-image: url(<?php echo $thismasterdetail["Image"]; ?>);">
	<div class="container">
		<div class="sec-title text-center mb-45 md-mb-25">
			<span class="sub-text">
				<?php echo $thismasterdetail["PortName"]; ?>
			</span>
			<h2 class="title">
				<?php echo $thismasterdetail["ShortDescription"]; ?>
			</h2>
		</div>
		<div class="row">
			<?php
			$thisgridcontent = DataService::getInstance()->GetPortfolio($sectionid, "", "", "", " a.PortDateTime desc ", "3");
			foreach ($thisgridcontent as $items) {
				$_URL = DetailPageURL($items["PortCode"], $items["PortName"]);
			?>
				<div class="col-lg-4 col-md-6 mb-30">
					<div class="blog-item">
						<div class="image-wrap">
							<a href="<?php echo $_URL ?>"><img src="<?php echo $items["Image"]; ?>" alt=""></a>
						</div>
						<div class="blog-content">
							<ul class="blog-meta">
								<li class="date"><i class="fa fa-calendar"></i><?php echo ConvertDateDBToDateDisplayLongFormat($items["PortDateTime"]); ?></li>
							</ul>
							<h3 class="blog-title"><a href="<?php echo $_URL ?>"><?php echo $items["PortName"]; ?></a></h3>
							<div class="blog-button"><a href="<?php echo $_URL ?>">Read More</a></div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<div class="text-center mt-45 md-mt-25">
			<div class="btn-part">
				<a class="readon more seemore" href="<?php echo $_Util_PageConfig->GetConfig("BLOG")->PageURLName() ?>">See More</a>
			</div>
		</div>
	</div>
</div>