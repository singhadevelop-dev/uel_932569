<div>
    <span><b>เมนูจัดการเว็บไซต์ทั่วไป</b></span>
    <hr style="margin-top: 5px;margin-bottom:0" />
    <a class="left-group" data-det-group="PAYMENT" href="payment.php">การชำระเงิน <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="CHANNEL" href="orderChannel.php">ช่องทางการสั่งซื้อ <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="DELIVERY" href="delivery.php">ประเภทการจัดส่ง <i class="fa fa-caret-right pull-right"></i></a>
</div>
<script>
    $(".left-group[data-det-group='<?php echo $_LEFT_MENU_ACTIVE; ?>']").addClass("active");
</script>