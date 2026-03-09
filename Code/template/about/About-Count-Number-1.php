<?php 
	$sql = "select * from portfolio where PortType='MASTERDETAIL-ABOUT_COUNT_NUMBER_1' and Active=1";
	$Mcount = SelectRow($sql);
?>
<div class="rs-counter counter-style1 bg2 pt-80 pb-80 sm-pt-40 sm-pb-40 Count-Number-1" style="background: url(<?php echo $Mcount["Image"] ?>);">
	<div class="container-xl">
		<div class="row y-middle">
			<div class="col-lg-6 md-mb-50">
				<div class="sec-title">
					<span class="sub-text">Number talks</span>
					<h2 class="title  pb-20"><?php echo $Mcount["PortName"] ?></h2>
					<div class="desc desc2 Editor"><?php echo ConvertNewLine($Mcount["ShortDescription"]) ?></div>
					<div class="btn-part">
						<a class="readon more contact" href="<?php echo !empty($Mcount["PortDtail1"]) ? $Mcount["PortDtail1"] : "#" ?>">Contact Now</a>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="row">
					<?php
						$sql = "select * from portfolio where PortType='ABOUT_COUNT_NUMBER_1' and Active=1 order by SEQ,PortCode";
						$counts = SelectRowsArray($sql);
						foreach($counts as $count){
					?>
					<div class="col-xl-6 col-md-6 col-sm-6 mb-30">
						<div class="rs-counter-list"> 
							<div class="count-text">
								<div class="count-number">
									<span class="rs-count"><?php echo number_format($count["Amount"],0) ?></span>
									<span class="prefix"><?php echo $count["ShortDescription"] ?></span>	
								</div>
								<span class="title">  <?php echo $count["PortName"] ?></span>	
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>