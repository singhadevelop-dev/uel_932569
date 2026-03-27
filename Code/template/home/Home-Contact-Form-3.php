<?php
$sql = "select * from portfolio where PortType='MASTERDETAIL-CONTACT-FORM-3' and Active=1";
$acontact3 = SelectRow($sql);
?>
<?php if ($acontact3["Active"] == 1) { ?>
	<div id="rs-contact" class="rs-contact contact-style4 pt-80 pb-80 sm-pt-40 sm-pb-40 About-Contact-Form-3" style="background: url(<?php echo $acontact3["Image"] ?>) !important;">
		<div class="background-bg-wrap">
			<!-- <div class="background-overlay"></div> -->
		</div>
		<div class="container-xl">
			<div class="row y-middle">
				<div class="col-lg-6 pr-150 md-pr-15 md-mb-50">
					<div class="requset-services-wrap">
						<div class="sec-title">
							<h2 class="title pb-20"><?php echo ConvertNewLine($acontact3["PortName"]) ?></h2>
							<div class="desc pb-40"><?php echo ConvertNewLine($acontact3["ShortDescription"]) ?></div>
							<div class="address-wrap videos-icons-style2">
								<div class="address-icon">
									<i class="fa fa-phone"></i>
									<!-- <i class=""><img src="assets/images/fax.png" alt="images"></i> -->

								</div>
								<div class="inner-txt">
									<span class="sub-text"><?php echo $acontact3["Year"] ?></span>
									<h2 class="title"><a href="tel:<?php echo $_Util_WebsitDetail["Phone"] ?>"><?php echo $_Util_WebsitDetail["Phone"] ?></a></h2>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="requset-services-wrap">
						<div class="title-heading mb-32">
							<h3 class="title"><?php echo $acontact3["ByName"] ?></h3>
						</div>
						<div class="contact-wrap">
							<form id="contact-form-submit" method="post" action="mailer.php">
								<fieldset>
									<div class="row">
										<div class="col-lg-12 mb-25">
											<input class="from-control" type="text" id="first_name" name="first_name" placeholder="<?php echo $acontact3["Status"] ?>" required="">
										</div>
										<div class="col-lg-12 mb-25">
											<input class="from-control" type="text" id="company" name="company" placeholder="<?php echo $acontact3["Fax"] ?>" required="">
										</div>
										<div class="col-lg-12 mb-25">
											<input class="from-control" type="text" id="phone" name="subject" placeholder="<?php echo $acontact3["Mobile"] ?>" required="">
										</div>
										<div class="col-lg-12 mb-25">
											<input class="from-control" type="text" id="email" name="email" placeholder="<?php echo $acontact3["Email"] ?>" required="">
										</div>
										<div class="col-lg-12 mb-25">
											<input class="from-control" type="text" id="phone" name="phone" placeholder="<?php echo $acontact3["Phone"] ?>" required="">
										</div>

										<div class="col-lg-12 mb-20">
											<textarea class="from-control" id="message" name="message" placeholder="<?php echo $acontact3["Address"] ?>" required=""></textarea>
										</div>
									</div>
									<div class="form-button paste-submit">
										<p class="submit-form">
											<input class="submit" type="submit" value="<?php echo $acontact3["PortDetail1"] ?>">
										</p>
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>