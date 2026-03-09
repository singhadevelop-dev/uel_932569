<div class="rs-slider slider-style6">
	<div class="slider slider-slide-1">
		<?php
		$sql = "select * from gallery where RefCode = 'SLIDE' order by SEQ ";
		$banners = SelectRowsArray($sql);
		$index = 0;
		foreach ($banners as $banner) {
			$index++;
		?>
			<div class="slider-item">
				<img src="<?php echo $banner["ImagePath"] ?>" class="w-100" alt="<?php echo $_Util_WebsitDetail["WebName"] ?>">
			</div>
		<?php } ?>
	</div>
</div>