<script>
	function _changeLang(lang) {
		const urlSearchParams = new URLSearchParams(window.location.search);
		const params = Object.fromEntries(urlSearchParams.entries());

		var src = "_change_lang.php?lang=" + lang;
		src += "&p=<?php echo $_CURRENT_PAGE_CODE  ?>";
		for (var key in params) {
			src += "&" + key + "=" + params[key];
		}

		location.href = src;
	}
</script>
<?php $_lang = empty($_COOKIE["_WEB_LANG"]) ? "EN" : $_COOKIE["_WEB_LANG"]; ?>
<div class="full-width-header">
	<!--Header Start-->
	<header id="rs-header" class="rs-header">
		<!-- Toolbar Area Start -->
		<div class="toolbar-area topbar-style1 hidden-md">
			<div class="container-fluid">
				<div class="row rs-vertical-middle">
					<div class="col-lg-7">
						<div class="toolbar-contact">
							<ul class="rs-contact-info">
								<li>
									<i class="fi fi-rr-envelope-plus"></i>
									<a href="mailto:<?php echo $_Util_WebsitDetail["Email"] ?>"><?php echo $_Util_WebsitDetail["Email"] ?></a>
								</li>
								<li>
									<i class="fi fi-rr-phone-call"></i>
									<a href="tel:<?php echo $_Util_WebsitDetail["Phone"] ?>"> <?php echo $_Util_WebsitDetail["Phone"] ?></a>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-5">
						<div class="toolbar-sl-share">
							<ul class="clearfix">
								<li class="opening"> <em><i class="fi fi-rr-time-add"></i> <?php echo $_Util_WebsitDetail["HourWork"] ?></em> </li>
								<li>
									<a href="<?php echo $_Util_WebsitDetail["FacebookURL"] ?>" target="_blank">
										<img src="assets/images/20.png" alt="Facebook" width="25">
									</a>
								</li>
								<li>
									<a href="<?php echo $_Util_WebsitDetail["Googleplus"] ?>" target="_blank">
										<img src="teams.png" alt="teams" width="25">
									</a>
								</li>
								<li>
									<a href="<?php echo $_Util_WebsitDetail["YoutubeURL"] ?>" target="_blank">
										<img src="assets/images/22.png" alt="Youtube" width="25">
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Toolbar Area End -->

		<!-- Menu Start -->
		<div class="menu-area menu-sticky">
			<div class="container-fluid">
				<div class="row-table">
					<div class="col-cell header-logo">
						<div class="logo-area">
							<a href="<?php echo $_Util_PageConfig->GetConfig("HOME")->PageURLName() ?>">
								<img class="normal-logo" src="<?php echo $_Util_WebsitDetail["Image"] ?>" alt="<?php echo $_Util_WebsitDetail["WebName"] ?>">
								<img class="sticky-logo" src="<?php echo $_Util_WebsitDetail["Image"] ?>" alt="<?php echo $_Util_WebsitDetail["WebName"] ?>">
							</a>
						</div>
						<h1 class="h1-logo d-none d-xl-block"><?php echo $_Util_WebsitDetail["WebName"] ?></h1>
					</div>
					<div class="col-cell">
						<div class="rs-menu-area">
							<div class="main-menu">
								<nav class="rs-menu hidden-md">
									<ul class="nav-menu onepage-menu">
										<li class="<?php echo $_CURRENT_PAGE_CODE == "HOME" ? 'current-menu-item' : '' ?>">
											<a href="<?php echo $_Util_PageConfig->GetConfig("HOME")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("HOME")->PageName() ?></a>
										</li>
										<li class="<?php echo $_CURRENT_PAGE_CODE == "ABOUT" || $_CURRENT_PAGE_CODE == "ABOUT2" || $_CURRENT_PAGE_CODE == "ABOUT3" || $_CURRENT_PAGE_CODE == "ABOUT4" || $_CURRENT_PAGE_CODE == "ABOUT5" ? 'current-menu-item' : '' ?>">
											<a href="<?php echo $_Util_PageConfig->GetConfig("ABOUT")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("ABOUT")->PageName() ?></a>
										</li>
										<!-- <li class="<?php echo $_CURRENT_PAGE_CODE == "MOVIE" ? 'current-menu-item' : '' ?>">
											<a href="<?php echo $_Util_PageConfig->GetConfig("MOVIE")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("MOVIE")->PageName() ?></a>
										</li> -->
										<li class="<?php echo $_CURRENT_PAGE_CODE == "CATEGORY" || $_CURRENT_PAGE_CODE == "PRODUCT" ? 'current-menu-item' : '' ?>">
											<a href="<?php echo $_Util_PageConfig->GetConfig("CATEGORY")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("CATEGORY")->PageName() ?></a>
										</li>
										<li class="<?php echo $_CURRENT_PAGE_CODE == "CONTACT" ? 'current-menu-item' : '' ?>">
											<a href="<?php echo $_Util_PageConfig->GetConfig("CONTACT")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("CONTACT")->PageName() ?></a>
										</li>
									</ul> <!-- //.nav-menu -->
								</nav>
							</div> <!-- //.main-menu -->
						</div>
					</div>
					<div class="col-cell">
						<div class="expand-btn-inner">
							<ul class="LanguageMenu">
								<li class="logo-2 d-none d-xl-block">
									<img class="logo" src="<?php echo $_Util_WebsitDetail["Image5"] ?>" alt="<?php echo $_Util_WebsitDetail["WebName"] ?>">
								</li>
								<li class="header-section search-parent">
									<div class="btn-group Language">
										<div class="dropdown">
											<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
												<?php if ($_lang == "TH") { ?>
													<img src="assets/images/th.png" style="max-height:20px;" alt=""> TH
												<?php }	?>
												<?php if ($_lang == "EN") { ?>
													<img src="assets/images/en.png" style="max-height:20px;" alt=""> EN
												<?php }	?>
												<?php if ($_lang == "IN") { ?>
													<img src="assets/images/in.png" style="max-height:20px;" alt=""> IN
												<?php }	?>
												<?php if ($_lang == "VN") { ?>
													<img src="assets/images/vn.png" style="max-height:20px;" alt=""> VN
												<?php }	?>
											</button>
											<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
												<li>
													<a class="dropdown-item" href="javascript:_changeLang('EN');">
														<img src="assets/images/en.png" style="max-height:20px;" alt=""> EN
													</a>
												</li>
												<li>
													<a class="dropdown-item" href="javascript:_changeLang('TH');">
														<img src="assets/images/th.png" style="max-height:20px;" alt=""> TH
													</a>
												</li>
												<li>
													<a class="dropdown-item" href="javascript:_changeLang('IN');">
														<img src="assets/images/in.png" style="max-height:20px;" alt=""> IN
													</a>
												</li>
												<li>
													<a class="dropdown-item" href="javascript:_changeLang('VN');">
														<img src="assets/images/vn.png" style="max-height:20px;" alt=""> VN
													</a>
												</li>
											</ul>
										</div>
									</div>
								</li>
								<li class="humburger">
									<a id="nav-expander" class="nav-expander bar" href="#">
										<div class="bar">
											<span class="dot1"></span>
											<span class="dot2"></span>
											<span class="dot3"></span>
											<!-- <span class="dot4"></span>
											<span class="dot5"></span>
											<span class="dot6"></span>
											<span class="dot7"></span>
											<span class="dot8"></span>
											<span class="dot9"></span> -->
										</div>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Menu End -->

		<!-- Canvas Mobile Menu start -->
		<nav class="right_menu_togle mobile-navbar-menu" id="mobile-navbar-menu">
			<div class="close-btn">
				<a id="nav-close2" class="nav-close">
					<div class="line">
						<span class="line1"></span>
						<span class="line2"></span>
					</div>
				</a>
			</div>
			<ul class="nav-menu">
				<li class="<?php echo $_CURRENT_PAGE_CODE == "HOME" ? 'current-menu-item' : '' ?>">
					<a href="<?php echo $_Util_PageConfig->GetConfig("HOME")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("HOME")->PageName() ?></a>
				</li>
				<li class="<?php echo $_CURRENT_PAGE_CODE == "ABOUT" ? 'current-menu-item' : '' ?>">
					<a href="<?php echo $_Util_PageConfig->GetConfig("ABOUT")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("ABOUT")->PageName() ?></a>
				</li>
				<li class="<?php echo $_CURRENT_PAGE_CODE == "CATEGORY" || $_CURRENT_PAGE_CODE == "PRODUCT" ? 'current-menu-item' : '' ?>">
					<a href="<?php echo $_Util_PageConfig->GetConfig("CATEGORY")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("CATEGORY")->PageName() ?></a>
				</li>
				<!-- <li class="<?php echo $_CURRENT_PAGE_CODE == "SERVICE" ? 'current-menu-item' : '' ?>">
					<a href="<?php echo $_Util_PageConfig->GetConfig("SERVICE")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("SERVICE")->PageName() ?></a>
				</li>
				<li class="<?php echo $_CURRENT_PAGE_CODE == "PROJECT" ? 'current-menu-item' : '' ?>">
					<a href="<?php echo $_Util_PageConfig->GetConfig("PROJECT")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("PROJECT")->PageName() ?></a>
				</li> -->

				<li class="<?php echo $_CURRENT_PAGE_CODE == "CONTACT" ? 'current-menu-item' : '' ?>">
					<a href="<?php echo $_Util_PageConfig->GetConfig("CONTACT")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("CONTACT")->PageName() ?></a>
				</li>
			</ul> <!-- //.nav-menu -->
			<!-- //.nav-menu -->

			<!-- //.nav-menu -->
			<div class="canvas-contact">
				<div class="address-area">
					<div class="address-list">
						<div class="info-icon">
							<i class="fi fi-rr-map-marker-home"></i>
						</div>
						<div class="info-content">
							<h4 class="title">Contact</h4>
							<em><?php echo ConvertNewLine($_Util_WebsitDetail["Address"]) ?></em>
						</div>
					</div>
					<div class="address-list">
						<div class="info-icon">
							<i class="fi fi-rr-envelope-plus"></i>
						</div>
						<div class="info-content">
							<h4 class="title">Email</h4>
							<em><a href="mailto:<?php echo $_Util_WebsitDetail["Email"] ?>"><?php echo $_Util_WebsitDetail["Email"] ?></a></em>
						</div>
					</div>
					<div class="address-list">
						<div class="info-icon">
							<i class="fi fi-rr-phone-call"></i>
						</div>
						<div class="info-content">
							<h4 class="title">Free Call</h4>
							<em><?php echo $_Util_WebsitDetail["Phone"] ?></em>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<!-- Canvas Menu end -->
	</header>
	<!--Header End-->
</div>