<?php $_COG_ITEM_CODE = 'TRANSACTION_LIST'; ?>
<?php include  "../header.php"; ?>
<?php 
    $UserCode = UserService::UserCode();
    $sql = " 
        SELECT 
        a.StatusCode
        ,COUNT(a.StatusCode) as StatusCount
        FROM checkout a where a.StatusCode <> 'SUCCESS'
        GROUP BY a.StatusCode
    ";
    $statusCount = SelectRowsArray($sql);
    $__STATUS_LIST = array();
    foreach ($statusCount as $data) {
        $__STATUS_LIST[$data["StatusCode"]] = $data["StatusCount"];
    }
?>
<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-9">
            <h3 style="margin: 0;">
                <i class="fa fa-money fa-fw"></i>
                <span class="analysis-left-menu-desc">รายการสั่งซื้อ</span>
            </h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

<div class="mat-box grey-bar">
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/transaction/" class="link-history-btn">รายการสั่งซื้อ</a>
    /
    <span class="link-history-btn">รายการคำสั่งซื้อ</span>
</div>
<div class="panel-tab-booking" role="tabpanel" data-example-id="togglable-tabs">
    <style>
        .nav-tabs .nav-link {
            color: rgba(0, 0, 0, .8);
        }

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            background-color: #fff;
            border: none;
            border-bottom: solid 2px #036499;
            color: #036499;
        }

        .nav-tabs a[role='tab'] {
            color: rgba(0, 0, 0, .8);
        }

        .nav-tabs>li[role='presentation']{
            border-bottom: solid 1px #ccc; 
        }

        .nav-tabs>li[role='presentation'].active {
            background-color: #fff;
            border: none;
            border-bottom: solid 2px #036499;
            color: #036499;
        }

        .nav-tabs.nav-justified>li>a {
            border-bottom: none;
        }

        #myTabContent-Order .row, #myTabContent-Order .table{
            margin-bottom: 0;
        }
    </style>
    <ul id="order-status-tab" class="nav nav-tabs  nav-justified" role="tablist">
        <?php 
            $_STATUS_CODE = $_GET["status"];
            if(empty($_STATUS_CODE)){
                if($__STATUS_LIST["WAITING"] > 0){
                    $_STATUS_CODE = "WAITING";
                }else if($__STATUS_LIST["PAID"] > 0){
                    $_STATUS_CODE = "PAID";
                }else {
                    $_STATUS_CODE = "SUCCESS";
                }
            }
        ?>
    
        <li role="presentation" class="<?php echo $_STATUS_CODE == "WAITING" ? "active" : "" ?>">
            <a href="#" role="tab" data-toggle="tab"  onclick="_load_orders_list('WAITING');">รอชำระเงิน <?php if(intval($__STATUS_LIST["WAITING"]) > 0){ ?><span class="text-shop">(<?php echo number_format($__STATUS_LIST["WAITING"]); ?>)</span><?php } ?></a>
        </li>
        <li role="presentation" class="<?php echo $_STATUS_CODE == "PAID" ? "active" : "" ?>">
            <a href="#" role="tab" data-toggle="tab" onclick="_load_orders_list('PAID');">ชำระเงินแล้วและรอการจัดส่ง <?php if(intval($__STATUS_LIST["PAID"]) > 0){ ?><span class="text-shop">(<?php echo number_format($__STATUS_LIST["PAID"]); ?>)</span><?php } ?></a>
        </li>
        <li role="presentation" class="<?php echo $_STATUS_CODE == "SUCCESS" ? "active" : "" ?>">
            <a href="#" role="tab" data-toggle="tab"  onclick="_load_orders_list('SUCCESS');">จัดส่งเรียบร้อยแล้ว</a>
        </li>
    </ul>
    <div id="myTabContent-Order" class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="tab_content1" aria-labelledby="profile-tab">
            <div id="panel-order-shop-list" style="position: relative;">
                <div class="mat-box" style="padding: 3rem;">

                </div>
            </div>
            <div id="panel-order-shop-list-temp" style="display: none;">
            </div>
        </div>
    </div>

</div>

<script>
    var __status_code = undefined;
    var __stopScroll = false;
    var __items_number = 0;
    $(document).ready(function(){
        _load_orders_list('<?php echo $_STATUS_CODE ?>');
    });

    function _load_orders_list(status){
        $("#panel-order-shop-list").AlertLoading(true,"โหลดข้อมูล");
        __status_code = status;
        __stopScroll = false;
        __items_number = 0;
        $("#panel-order-shop-list").load("_load_market_orders_list.php?status="+__status_code,function(){
            var n = $(this).find(".item-order").length;
            __items_number += n;
            __stopScroll = false;
        });
    }

    window.onscroll = function(ev) {
        if (!__stopScroll && (window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
            $("#panel-order-shop-list").AlertLoading(true,"โหลดข้อมูล");
            $("#panel-order-shop-list-temp").load("_load_market_orders_list.php?status="+__status_code+"&item="+__items_number,function(){
                var n = $("#panel-order-shop-list-temp").find(".item-order").length;
                if(n > 0){
                    $("#panel-order-shop-list-temp").find(".item-order").each(function( index ) {
                        $("#panel-order-shop-list").append($(this));
                    });
                }
                __items_number += n;
                __stopScroll = (n <= 0);
                $("#panel-order-shop-list").AlertLoading(false);
            });
            __stopScroll = true;
        }
    };

</script>

<?php include  "../footer.php"; ?>