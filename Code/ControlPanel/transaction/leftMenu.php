<div>
    <span><b>เมนูเกียวกับการขาย</b></span>
    <hr style="margin-top: 5px;margin-bottom:0" />
    <a class="left-group" data-det-group="TARNSACTION" href="transaction.php">รายการสั่งซื้อ <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group" data-det-group="PAYMENT" href="payment.php">รายการแจ้งชำระเงิน <i class="fa fa-caret-right pull-right"></i></a>
</div>
<script>
    $(".left-group[data-det-group='<?php echo $_LEFT_MENU_ACTIVE; ?>']").addClass("active");
</script>