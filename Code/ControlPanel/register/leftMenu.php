<div>
    <span><b>เมนูจัดการเว็บไซต์ทั่วไป</b></span>
    <hr style="margin-top: 5px;margin-bottom:0" />
    <a class="left-group" data-det-group="CONTACT" href="/ControlPanel/register/register.php">รายการผู้ลงทะเบียน <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group" data-det-group="SUBSCRIBE" href="/ControlPanel/register/subscribe.php">Subscriber <i class="fa fa-caret-right pull-right"></i></a>
</div>
<script>
    $(".left-group[data-det-group='<?php echo $_LEFT_MENU_ACTIVE; ?>']").addClass("active");
</script>