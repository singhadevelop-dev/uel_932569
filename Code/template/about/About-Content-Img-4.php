<?php
      $sql = "select * from portfolio where PortType='MASTERDETAIL-ABOUT-CONTENT-IMG-4'"; 
      $data = SelectRow($sql);
?>
<div id="rs-about" class="rs-about about-style5 Content-Img-4">
	<div class="row no-gutters">
		<div class="col-lg-6 about-image">
			<img src="<?php echo $data["Image"] ?>" alt="<?php echo $data['PortName'] ?>">
		</div>
		<div class="col-lg-6">
			<div class="about-content-wrap"  style="background-image: url(<?php echo $data["Image2"] ?>);">
				<div class="sec-title">
					<h2 class="title pb-23"><?php echo $data['PortName'] ?></h2>
					<div class="desc Editor"><?php IncludeDynamicPageHTML($data["PortDetail"],false)  ?></div>
				</div>
			</div>
		</div>
	</div>
</div>
