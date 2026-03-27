<div>
    <span><b>เมนูจัดการเว็บไซต์ทั่วไป</b></span>
    <hr style="margin-top: 5px;margin-bottom:0" />
    <a class="left-group" data-det-group="HOME" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/">ข้อมูลทั่วไป <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="QR_CODE" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/qrcode/qrcode.php">QR Code<i class="fa fa-caret-right pull-right"></i></a>
    
    <a class="left-group" data-det-group="SLIDE" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/slide.php">รูปภาพสไลด์ (แบนเนอร์)<i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="SUBSLIDE" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/slidesub.php">รูปภาพสไลด์ (แบนเนอร์ย่อย)<i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="SLIDE" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/slideVideo.php">วีดีโอ (แบนเนอร์)<i class="fa fa-caret-right pull-right"></i></a>

    <a class="left-group" data-det-group="WEBSITE_TERMS" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/policy.php?ref=WEBSITE_TERMS">ข้อกำหนดการใช้งาน <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group" data-det-group="WEBSITE_PRIVACY" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/policy.php?ref=WEBSITE_PRIVACY">นโยบายความเป็นส่วนตัว <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group" data-det-group="WEBSITE_COOKIE" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/policy.php?ref=WEBSITE_COOKIE">นโยบายการเก็บคุกกี้ <i class="fa fa-caret-right pull-right"></i></a>

    <a class="left-group hide" data-det-group="FEAYURED" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/featured.php">อัตลักษณ์ขององค์กร <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="VIDEO" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/video.php">วีดีโอยูทูป <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="MEDIA_LIST" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/media.php">Media List (หน้าแรก) <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="CLIENT" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/partner.php">ลูกค้าของเรา <i class="fa fa-caret-right pull-right"></i></a>
    

    <!-- <a class="left-group" data-det-group="SLIDE_HOME" href="<?php //echo $GLOBALS["ROOT"] ?>/ControlPanel/home/bannerVideo.php?ref=SLIDE_HOME">รูปภาพแบนเนอร์ (หน้าแรก) <i class="fa fa-caret-right pull-right"></i></a> -->
    <?php 
        $sqlPageConfigs = "select * from page_config where Active=1 and PageCode <> 'HOME' and PageCode <> 'COOKIE' and PageCode <> 'PRIVACY' and PageCode <> 'TERMS'  order by SEQ";
        $dataPageConfigs = SelectRowsArray($sqlPageConfigs);
        foreach ($dataPageConfigs as $pcg) {
             ?>
                <a class="left-group" data-det-group="BANNER_<?php echo $pcg["PageCode"] ?>" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/banner.php?ref=BANNER_<?php echo $pcg["PageCode"] ?>">รูปภาพแบนเนอร์ (<?php echo $pcg["PageName"] ?>) <i class="fa fa-caret-right pull-right"></i></a>
             <?php 
        }
    ?>

    <a class="left-group hide" data-det-group="SLIDE" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/slide.php">Section 1 - รูปภาพสไลด์ (แบนเนอร์)<i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="ABOUT" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/about.php">Section 2 - เกี่ยวกับโครงการ<i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="PROPERTY" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/property.php">Section 3 - คุณสมบัติ <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="FACILITY" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/facility.php">Section 4 - สิ่งอำนวยความสะดวก <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="DESIGN" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/design.php">Section 5 - การดีไซน์ <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="PLAN" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/plan.php">Section 6 - แบบแปลน <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="INTERIOR" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/interior.php">Section 7 - การออกแบบภายใน <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="PLACE" href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/home/place.php">Section 8 - สถานที่ใกล้เคียง <i class="fa fa-caret-right pull-right"></i></a>
    
</div>
<script>
    $(".left-group[data-det-group='<?php echo $_LEFT_MENU_ACTIVE; ?>']").addClass("active");
</script>