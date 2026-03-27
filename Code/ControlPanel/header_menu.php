<style>
    .overflow-left-bar {
        max-height: 300px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .analysis-left-toggle-active .overflow-left-bar {
        max-height: none;
    }

    .analysis-left-menu.active {
        color: #F58512;
        text-decoration: none;
        background: #eee;
        font-weight: 600;
    }
</style>
<div class="analysis-left-group">
    เมนูจัดการ
</div>
<div class="overflow-left-bar-x">

    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/" data-key="HOME" class="analysis-left-menu">
        <i class="fa fa-home fa-fw"></i>
        <span class="analysis-left-menu-desc">จัดการเว็บไซต์ทั่วไป</span>
    </a>

    <?php if ($__COGS_GLOBAL_CART) { ?>
        <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/order/payment.php" data-key="ORDER" class="analysis-left-menu hide">
            <i class="fa fa-shopping-cart fa-fw"></i>
            <span class="analysis-left-menu-desc">ช่องทางชำระเงิน</span>
        </a>
        <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/delivery/" data-key="DELIVERY" class="analysis-left-menu hide">
            <i class="fa fa-truck fa-fw"></i>
            <span class="analysis-left-menu-desc">การจัดส่ง</span>
        </a>
    <?php } ?>

    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/pageConfig/page.php" data-key="CONFIG_PAGE" class="analysis-left-menu">
        <i class="fa fa-file-text-o fa-fw"></i>
        <span class="analysis-left-menu-desc">ตั้งค่าหน้าเพจ</span>
    </a>
    <!-- <a href="<?php //echo $GLOBALS["ROOT"] 
                    ?>/ControlPanel/video/video.php" data-key="VIDEO" class="analysis-left-menu hide">
        <i class="fa fa-video-camera fa-fw"></i>
        <span class="analysis-left-menu-desc">วีดีโอแกลเลอรี่</span>
    </a> -->

</div>

<div class="analysis-left-group">
    เมนูหน้าแรก
</div>
<div class="overflow-left-bar-x">
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/blogEditorPage/Grid-Content-4/item.php" data-key="Grid-Content-4" class="analysis-left-menu">
        <i class="fa fa-newspaper-o" aria-hidden="true"></i>
        <span class="analysis-left-menu-desc">News</span>
    </a>
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/blogEditorPage/Grid-Content-20/masterDetail.php" data-key="Grid-Content-20" class="analysis-left-menu">
        <i class="fa fa-th" aria-hidden="true"></i>
        <span class="analysis-left-menu-desc">Category</span>
    </a>
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/blogEditorPage/Inner-Banner-1/masterDetail.php" data-key="Inner-Banner-1" class="analysis-left-menu">
        <i class="fa fa-file-image-o" aria-hidden="true"></i>
        <span class="analysis-left-menu-desc">Inner Banner</span>
    </a>
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/blogEditorPage/Grid-Content-15/item.php" data-key="Grid-Content-15" class="analysis-left-menu">
        <i class="fa fa-file-movie-o" aria-hidden="true"></i>
        <span class="analysis-left-menu-desc">VIDEO</span>
    </a>
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/blogEditorPage/team_2/masterDetail.php" data-key="TEAM_2" class="analysis-left-menu">
        <i class="fa fa-th" aria-hidden="true"></i>
        <span class="analysis-left-menu-desc">Support</span>
    </a>
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/blogEditorPage/Contact-Form-3/masterDetail.php" data-key="CONTACT-FORM-3" class="analysis-left-menu">
        <i class="fa fa-phone fa-fw"></i>
        <span class="analysis-left-menu-desc">Contact</span>
    </a>

</div>

<div class="analysis-left-group">
    เมนูหน้าอื่น ๆ
</div>
<div class="overflow-left-bar-x">
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/blogEditorPage/about/masterDetail.php" data-key="ABOUT" class="analysis-left-menu">
        <i class="fa fa-info-circle fa-fw"></i>
        <span class="analysis-left-menu-desc">About Us</span>
    </a>
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/blogEditorPage/about2/masterDetail.php" data-key="ABOUT2" class="analysis-left-menu">
        <i class="fa fa-info-circle fa-fw"></i>
        <span class="analysis-left-menu-desc">Message</span>
    </a>
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/blogEditorPage/about3/item.php" data-key="ABOUT3" class="analysis-left-menu">
        <i class="fa fa-handshake-o fa-fw"></i>
        <span class="analysis-left-menu-desc">Partnership</span>
    </a>
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/blogEditorPage/about4/item.php" data-key="ABOUT4" class="analysis-left-menu">
        <i class="fa fa-handshake-o fa-fw"></i>
        <span class="analysis-left-menu-desc">ASEAN Support</span>
    </a>
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/blogEditorPage/about5/item.php" data-key="ABOUT5" class="analysis-left-menu">
        <i class="fa fa-history fa-fw"></i>
        <span class="analysis-left-menu-desc">History</span>
    </a>
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/product/product.php" data-key="PRODUCT" class="analysis-left-menu">
        <i class="fa fa-cubes" aria-hidden="true"></i>
        <span class="analysis-left-menu-desc">Product</span>
    </a>
</div>

<div class="analysis-left-group">
    เมนูทำรายการ
</div>
<?php if ($__COGS_GLOBAL_CART) { ?>
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/transaction/" data-key="TRANSACTION_LIST" class="analysis-left-menu hide">
        <i class="fa fa-money fa-fw"></i>
        <span class="analysis-left-menu-desc">รายการสั่งซื้อ</span>
    </a>
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/transaction/transaction.php" data-key="TRANSACTION" class="analysis-left-menu hide">
        <i class="fa fa-dollar fa-fw"></i>
        <span class="analysis-left-menu-desc">รายการสั่งซื้อทั้งหมด</span>
    </a>
<?php } ?>

<?php if ($__COGS_GLOBAL_MEMBER) { ?>
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/user/" data-key="MEMBER" class="analysis-left-menu hide">
        <i class="fa fa-users fa-fw"></i>
        <span class="analysis-left-menu-desc">ข้อมูลสมาชิก</span>
    </a>
<?php } ?>

<a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/transaction/payment.php" data-key="PAYMENT_ACTION" class="analysis-left-menu hide">
    <i class="fa fa-user fa-fw"></i>
    <span class="analysis-left-menu-desc">ผู้เข้ามาแจ้งชำระ</span>
</a>
<a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/contact/contact.php" data-key="CONTACT_ACTION" class="analysis-left-menu">
    <i class="fa fa-user fa-fw"></i>
    <span class="analysis-left-menu-desc">ผู้เข้ามาติดต่อ</span>
</a>
<a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/register/register.php" data-key="REGISTER" class="analysis-left-menu hide">
    <i class="fa fa-file fa-fw"></i>
    <span class="analysis-left-menu-desc">ผู้ลงทะเบียน</span>
</a>
<a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/register/sampleform.php" data-key="SAMPLE" class="analysis-left-menu hide">
    <i class="fa fa-file-o fa-fw"></i>
    <span class="analysis-left-menu-desc">SAMPLE FORM</span>
</a>
<a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/contact/subscribe.php" data-key="SUBSCRIBE" class="analysis-left-menu hide">
    <i class="fa fa-eye fa-fw"></i>
    <span class="analysis-left-menu-desc">Subscribe</span>
</a>
<a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/contact/career.php" data-key="CAREER_ACTION" class="analysis-left-menu hide">
    <i class="fa fa-graduation-cap fa-fw"></i>
    <span class="analysis-left-menu-desc">ผู้สมัครงาน</span>
</a>
<?php if ($__COGS_GLOBAL_CART) { ?>
    <div class="analysis-left-group hide">
        รายงาน
    </div>
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/report/reporttotalpay.php" data-key="SALE_REPORT" class="analysis-left-menu hide">
        <i class="fa fa-bar-chart fa-fw"></i>
        <span class="analysis-left-menu-desc">รายงานยอดขาย</span>
    </a>
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/report/reportsummary.php" data-key="SALE_TOTAL" class="analysis-left-menu hide">
        <i class="fa fa-bar-chart fa-fw"></i>
        <span class="analysis-left-menu-desc">รายงานสรุปยอดขาย</span>
    </a>
<?php } ?>
<?php if (UserService::_IsSuperAdmin()) { ?>
    <div class="analysis-left-group">
        เมนูคอนฟิกระบบ
    </div>
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/index_cogs.php" class="analysis-left-menu">
        <i class="fa fa-cogs fa-fw"></i>
        <span class="analysis-left-menu-desc">คอนฟิกระบบ</span>
    </a>
<?php } ?>

<script>
    $(document).ready(function() {
        <?php
        if (!empty($_COG_ITEM_CODE)) { ?>
            $("a.analysis-left-menu[data-key='<?php echo $_COG_ITEM_CODE ?>']").addClass("active");
        <?php } else { ?>
            var url = window.location.href;
            var targets = $("a.analysis-left-menu");
            targets.sort(function(a, b) {
                return $(b).attr("href").length - $(a).attr("href").length;
            });
            $(targets).each(function(index) {
                if (url.indexOf($(this).attr("href")) > -1) {
                    $(this).addClass("active");
                    return false;
                }
            });
        <?php } ?>
        $(".mat-box.analysis-left").animate({
            scrollTop: $(".analysis-left-menu.active").offset().top - 95
        }, 400);
    });
</script>