<div class="rs-contact contact-style1 contact-modify2 pt-80 pb-80 sm-pt-40 sm-pb-40 Contact-Detail-2">
	<div class="container-xl">
		<div class="sec-title text-center mb-40 md-mb-20">
			<h2 class="title text-red-2"><?php echo $_Util_WebsitDetail["WebName"] ?></h2>
		</div>
		<div class="row y-middle justify-content-center">
			<div class="col-lg-4 rs-contact contact-style5">
				<div class="row">
					<div class="col-xl-12 mb-30">
						<div class="contact-box">
							<div class="contact-icon">
								<img src="assets/images/location.png" alt="images">
							</div>
							<div class="content-text">
								<p class="services-txt"><?php echo $_Util_WebsitDetail["Address"] ?></p>
							</div>
						</div>
					</div>
					<div class="col-xl-12 mb-30">
						<div class="contact-box">
							<div class="contact-icon">
								<img src="assets/images/phone.png" alt="images">
							</div>
							<div class="content-text">
								<p class="services-txt">
									<a href="tel:<?php echo $_Util_WebsitDetail["Phone"] ?>"><?php echo $_Util_WebsitDetail["Phone"] ?></a>
								</p>
							</div>
						</div>
					</div>
					<div class="col-xl-12 mb-30">
						<div class="contact-box">
							<div class="contact-icon">
								<img src="assets/images/fax.png" alt="images">
							</div>
							<div class="content-text">
								<p class="services-txt">
									<a href="tel:<?php echo $_Util_WebsitDetail["Fax"] ?>"><?php echo $_Util_WebsitDetail["Fax"] ?></a>
								</p>
							</div>
						</div>
					</div>
					<div class="col-xl-12 ">
						<div class="contact-box">
							<div class="contact-icon">
								<img src="assets/images/email.png" alt="images">
							</div>
							<div class="content-text">
								<p class="services-txt">
									<a href="mailto:<?php echo $_Util_WebsitDetail["Email"] ?>"><?php echo $_Util_WebsitDetail["Email"] ?></a>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			$sql = "select * from portfolio where PortType='MASTERDETAIL-CONTACT-FORM-3' and Active=1";
			$acontact3 = SelectRow($sql);
			?>
			<div class="col-lg-8">
				<div class="contact-section">
					<div class="contact-wrap">
						<form id="contact-form-submit" method="post" action="mailer.php">
							<fieldset>
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 mb-30">
										<input class="from-control" type="text" id="first_name" name="first_name" placeholder="<?php echo $acontact3["Status"] ?>" required="">
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 mb-30">
										<input class="from-control" type="text" id="company" name="company" placeholder="<?php echo $acontact3["Fax"] ?>" required="">
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 mb-30">
										<input class="from-control" type="text" id="email" name="email" placeholder="<?php echo $acontact3["Email"] ?>" required="">
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 mb-30">
										<input class="from-control" type="text" id="phone" name="phone" placeholder="<?php echo $acontact3["Phone"] ?>" required="">
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 mb-30">
										<input class="from-control" type="text" id="subject" name="subject" placeholder="<?php echo $acontact3["Mobile"] ?>" required="">
									</div>
									<div class="col-lg-12 mb-30">
										<textarea class="from-control" id="message" name="message" placeholder="<?php echo $acontact3["Address"] ?>" required=""></textarea>
									</div>
								</div>
								<div class="btn-part">
									<div class="form-group mb-0">
										<input class="readon more" type="submit" value="<?php echo $acontact3["PortDetail1"] ?>">
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="contact-map">
	<iframe src="https://www.google.com/maps/embed?pb=<?php echo $_Util_WebsitDetail["MapLocation"] ?>" style="height:450px;width:100%;border:none;margin-bottom:-8px"></iframe>
</div>