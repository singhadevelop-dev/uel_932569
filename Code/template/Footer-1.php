<footer id="rs-footer" class="rs-footer footer-main-home" style="background-image: url(<?php echo $_Util_WebsitDetail["Image3"] ?>);">
	<div class="footer-top">
		<div class="container-xl">
			<div class="row">
				<div class="col-lg-3 pr-20 md-pr-15 md-mb-20">
					<div class="footer-logo mb-30 md-mb-30">
						<a href="<?php echo $_Util_PageConfig->GetConfig("HOME")->PageURLName() ?>">
							<img src="<?php echo $_Util_WebsitDetail["Image2"] ?>" alt="<?php echo $_Util_WebsitDetail["WebName"] ?>">
						</a>
					</div>
					<div class="textwidget">
						<p class="pb-20"><?php echo ConvertNewLine($_Util_WebsitDetail["Description"]) ?></p>
						<p class="pb-25"><strong><?php echo $_Util_WebsitDetail["HourWork"] ?></strong></p>
					</div>
				</div>
				<div class="col-lg-3 md-mb-10">
					<h3 class="footer-title"></h3>
					<ul class="address-widget">
						<li>
							<i class="fi fi-rr-map-marker-home"></i>
							<div class="desc">
								<?php echo ConvertNewLine($_Util_WebsitDetail["Address"]) ?>
							</div>
						</li>
						<li>
							<i class="fi fi-rr-phone-call"></i>
							<!-- <img style="position: absolute; left: 0;" src="fax.png" alt=""> -->
							<div class="desc">
								<a href="tel:<?php echo $_Util_WebsitDetail["Phone"] ?>"><?php echo $_Util_WebsitDetail["Phone"] ?></a>
							</div>
						</li>
						<li>
							<i class="fi fi-rr-envelope-plus"></i>
							<div class="desc">
								<a href="mailto:<?php echo $_Util_WebsitDetail["Email"] ?>"><?php echo $_Util_WebsitDetail["Email"] ?></a>
							</div>
						</li>
						<li>
							<!-- <i class="fi fi-rr-phone-call"></i> -->
							<img style="position: absolute; left: 0;" src="fax.png" alt="">
							<div class="desc">
								<a href="tel:<?php echo $_Util_WebsitDetail["Fax"] ?>"><?php echo $_Util_WebsitDetail["Fax"] ?></a>
							</div>
						</li>
					</ul>
				</div>
				<div class="col-lg-3 md-mb-10">
					<h3 class="footer-title">Quick Links</h3>
					<ul class="site-map">
						<li>
							<a href="<?php echo $_Util_PageConfig->GetConfig("ABOUT")->PageURLName() ?>">
								<?php echo $_Util_PageConfig->GetConfig("ABOUT")->PageName() ?>
							</a>
						</li>
						<li>
							<a href="<?php echo $_Util_PageConfig->GetConfig("CATEGORY")->PageURLName() ?>">
								<?php echo $_Util_PageConfig->GetConfig("CATEGORY")->PageName() ?>
							</a>
						</li>
						<li>
							<a href="<?php echo $_Util_PageConfig->GetConfig("CONTACT")->PageURLName() ?>">
								<?php echo $_Util_PageConfig->GetConfig("CONTACT")->PageName() ?>
							</a>
						</li>
					</ul>
				</div>
				<div class="col-lg-3">
					<h3 class="footer-title">POLICY INFORMATION</h3>
					<ul class="site-map mb-30">
						<li>
							<a href="<?php echo $_Util_PageConfig->GetConfig("COOKIE")->PageURLName() ?>">
								<?php echo $_Util_PageConfig->GetConfig("COOKIE")->PageName() ?>
							</a>
						</li>
						<li>
							<a href="<?php echo $_Util_PageConfig->GetConfig("PRIVACY")->PageURLName() ?>">
								<?php echo $_Util_PageConfig->GetConfig("PRIVACY")->PageName() ?>
							</a>
						</li>
						<li>
							<a href="<?php echo $_Util_PageConfig->GetConfig("TERMS")->PageURLName() ?>">
								<?php echo $_Util_PageConfig->GetConfig("TERMS")->PageName() ?>
							</a>
						</li>
					</ul>
					<ul class="footer-social md-mb-30">
						<li><a href="<?php echo $_Util_WebsitDetail["FacebookURL"] ?>" target="_blank"><img src="assets/images/20.png" alt="Facebook"></a></li>
						<li><a href="<?php echo $_Util_WebsitDetail["Googleplus"] ?>" target="_blank"><img style="width: 38px; height: 38px;" src="teams.png" alt="teams"></a></li>
						<li><a href="<?php echo $_Util_WebsitDetail["YoutubeURL"] ?>" target="_blank"><img src="assets/images/22.png" alt="Youtube"></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container-xl">
			<div class="row y-middle">
				<div class="col-lg-8 md-mb-10 text-lg-end text-center order-last">
					<ul class="copy-right-menu">
						<li><a href="<?php echo $_Util_PageConfig->GetConfig("ABOUT")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("ABOUT")->PageName() ?></a> </li>
						<li><a href="<?php echo $_Util_PageConfig->GetConfig("CATEGORY")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("CATEGORY")->PageName() ?></a> </li>
						<li><a href="<?php echo $_Util_PageConfig->GetConfig("CONTACT")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("CONTACT")->PageName() ?></a> </li>
					</ul>
				</div>
				<div class="col-lg-4">
					<div class="copyright text-lg-start text-center">
						<p>© <?php echo date("Y"); ?> <?php echo $uri = $_SERVER['HTTP_HOST']; ?> ALL RIGHTS RESERVED. <span style="display:none;">รับทำเว็บไซต์ by <a href="https://www.singhadevelop.co.th/" target="blank">SiNGHADEVELOP CO.,LTD.</a></span></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- <ul class="sticky-buttons -large -right-center -space -slide">
	<li class="white blue">
		<a href="<?php echo $_Util_WebsitDetail["FacebookURL"] ?>" data-type="facebook">
			<span class="sb-icon fab fa-facebook"></span>
			<span class="sb-label"><?php echo $_Util_WebsitDetail["Facebook"] ?></span>
		</a>
	</li>
	<li class="white green">
		<a href="<?php echo $_Util_WebsitDetail["LineIDURL"] ?>" data-type="line">
			<span class="sb-icon fab fa-line"></span>
			<span class="sb-label"><?php echo $_Util_WebsitDetail["LineID"] ?></span>
		</a>
	</li>
	<li class="white cyan">
		<a href="<?php echo $_Util_WebsitDetail["TwitterURL"] ?>" data-type="twitter">
			<span class="sb-icon fab fa-twitter"></span>
			<span class="sb-label"><?php echo $_Util_WebsitDetail["Twitter"] ?></span>
		</a>
	</li>
</ul> -->

<script>
	$("#contact-form-submit").submit(function() {
		AlertLoading(true, "Send message");
		var dataFrom = new FormData($("#contact-form-submit")[0]);
		PostFormDataAPI("ControlPanel/api/contact/", dataFrom, function(data, method, ele) {
			if (data.status == "OK") {
				$('#contact-form-submit')[0].reset();
				AlertSuccess("Send success");
			} else {
				AlertError(data.message == undefined ? data : data.message);
			}
			AlertLoading(false);
		});
		return false;
	});
</script>

<script>
	$("#subscribe").submit(function() {
		AlertLoading(true, "Send message");
		var dataFrom = new FormData($("#subscribe")[0]);
		PostFormDataAPI("ControlPanel/api/contact/", dataFrom, function(data, method, ele) {

			if (data.status == "OK") {
				$('#subscribe')[0].reset();
				AlertSuccess("Send success");
			} else {
				AlertError(data.message == undefined ? data : data.message);
			}
			AlertLoading(false);
		});
		return false;
	});
</script>