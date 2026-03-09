<?php 
include_once "../../_cogs.php";
include_once  "../assets/b4w-framework/UtilService.php"; 

$year = $_GET["year"];
$month = $_GET["month"];
$groupBy = $_GET["group"];
$whereData = "";
if(!UserService::_IsAdmin()){
    $whereData .= " and item.ShopCode='".UserService::UserCode()."' ";
}
if(!empty($month)){
    $whereData .= " and month(po.CreatedOn) ='$month' ";
}

if($groupBy == ""){
    $sqlProduct = "select p.ProductCode,p.ProductName,p.Image
    ,SUM(cart.QTY) as QTY,SUM(cart.Total) as Total
    from cart
    join product p
        on p.ProductCode = cart.ProductCode
    join checkout po
        on cart.CheckOutCode = po.CheckOutCode
    where po.StatusCode='SUCCESS' and year(po.CreatedOn)='$year' $whereData
        group by p.ProductCode,p.ProductName,p.Image ";
    $dataPrd = SelectRowsArray($sqlProduct);

    $sqlWeb = "select 
                 SUM(po.Total) as Total
                ,SUM(po.DeliveryPrice) as DeliveryPrice
                ,SUM(po.Net) as Net
                from checkout po
                where po.StatusCode='SUCCESS' and year(po.CreatedOn)='$year' $whereData
                limit 1
            ";
    $dataWeb = SelectRow($sqlWeb);

    $round = 0;
    if(count($dataPrd) > 0)
    {
        $round++;
    ?>
        <div class="row">
        <div class="col-md-12">
            <div class="bg-white mb-3">
                <div class="px-3 pb-3">
                    <div class="row" style="margin-bottom: 0px;">
                        <div class="col-md-12">
                            <table class="table table-check-list" style="margin-bottom: 0px;">
                                <thead>
                                    <tr>
                                        <td colspan="3" style="width: 75%;">
                                            <div>
                                                <label class="text-shop">สรุปยอดขายทั้งหมด</label>
                                            </div>
                                        </td>
                                        <td class="text-right td-p-price text-header">
                                            <div class="text-desc">
                                                <b class="text-shop"> สำเร็จแล้ว</b>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php 
                                        foreach ($dataPrd as $cart) {
                                    ?>
                                    <tr>
                                        <td class="td-image">
                                            <img src="<?php echo ResizeImage($cart["Image"],60) ?>" width="40" height="40" class="image-product">
                                        </td>
                                        <td class="td-p-name">
                                            <div class="two-line">
                                                <label class="text-shop"><?php echo $cart["ProductName"] ?></label>
                                            </div>
                                        </td>
                                        <td class="td-p-name">
                                            <div class="text-shop">x <?php echo number_format($cart["QTY"]) ?></div>
                                        </td>
                                        <td class="text-right td-p-price">
                                            <div class="text-shop">฿<?php echo number_format($cart["Total"]) ?></div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="p-3">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-9 col-lg-9 text-right">
                                <div class="pl-5 pt-1">
                                    ยอดรวมสินค้า:
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 text-right">
                                <div class="text-shop"><b><?php echo number_format($dataWeb["Total"]) ?></b></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-9 col-lg-9 text-right">
                                <div class="pl-5 pt-1">
                                    ค่าจัดส่ง:
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 text-right">
                                <div class="text-shop"><b><?php echo number_format($dataWeb["DeliveryPrice"]) ?></b></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-9 col-lg-9 text-right">
                                <div class="pl-5 pt-1">
                                    ยอดรวมทั้งสิ้น:
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 text-right">
                                <h3 class="text-shop" style="margin-bottom: 0px;margin-top: 0px;"><b><?php echo number_format($dataWeb["Net"]) ?></b></้>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    
<?php }else if($groupBy == "CATEGORY"){
    
    $sqlProduct = "select p.ProductCode,p.ProductName,p.Image,p.CategoryCode 
        ,SUM(cart.QTY) as QTY,SUM(cart.Total) as Total
        from cart
        join product p
            on p.ProductCode = cart.ProductCode
        join checkout po
            on cart.CheckOutCode = po.CheckOutCode
        where po.StatusCode='SUCCESS' and year(po.CreatedOn)='$year' $whereData
            group by p.ProductCode,p.ProductName,p.Image,p.CategoryCode ";
    $dataPrd = SelectRowsArray($sqlProduct);

    $sqlShop = "select p.CategoryCode ,cat.CategoryName, cat.Image
                ,SUM(cart.QTY) as QTY,SUM(cart.Total) as Total
                from cart
                join product p
                    on p.ProductCode = cart.ProductCode
                join checkout po
                    on cart.CheckOutCode = po.CheckOutCode
                left join product_category cat 
                    on cat.CategoryCode = p.CategoryCode
                where po.StatusCode='SUCCESS' and year(po.CreatedOn)='$year' $whereData
                    group by p.CategoryCode ,cat.CategoryName ,cat.Image
            ";
    $dataCategory = SelectRowsArray($sqlShop);

    $_CART_LIST = array();
    foreach ($dataPrd as $cart) {
        if(!isset($_CART_LIST[$cart["CategoryCode"]])){
            $_CART_LIST[$cart["CategoryCode"]] = array();
        }
        array_push($_CART_LIST[$cart["CategoryCode"]],$cart);
    }
    $round = 0;
    foreach ($dataCategory as $cat)
    {
        $round++;
?>

    <div class="row">
        <div class="col-md-12">
            <div class="bg-white mb-3">
                <div class="px-3 pb-3">
                    <div class="row" style="margin-bottom: 0px;">
                        <div class="col-md-12">
                            <table class="table table-check-list" style="margin-bottom: 0px;">
                                <thead>
                                    <tr>
                                        <td colspan="3" style="width: 75%;">
                                            <div>
                                                <?php if(!empty($cat["Image"])){ ?>
                                                <img src="<?php echo ResizeImage($cat["Image"],30) ?>"
                                                    class="shadow-sm" width="30" height="30"
                                                    style="object-fit: cover;border-radius: 50%;">
                                                    &nbsp;
                                                <?php } ?>
                                                <b class="text-shop"><?php echo $cat["CategoryName"] ?></b>
                                            </div>
                                        </td>
                                        <td class="text-right td-p-price text-header">
                                            <div class="text-desc">
                                                <b class="text-shop"> สำเร็จแล้ว</b>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php 
                                        foreach ($_CART_LIST[$cat["CategoryCode"]] as $cart) {
                                    ?>
                                    <tr>
                                        <td class="td-image">
                                            <img src="<?php echo ResizeImage($cart["Image"],60) ?>" width="40" height="40" class="image-product">
                                        </td>
                                        <td class="td-p-name">
                                            <div class="two-line">
                                                <label class="text-shop"><?php echo $cart["ProductName"] ?></label>
                                            </div>
                                        </td>
                                        <td class="td-p-name">
                                            <div class="text-shop">x <?php echo number_format($cart["QTY"]) ?></div>
                                        </td>
                                        <td class="text-right td-p-price">
                                            <div class="text-shop">฿<?php echo number_format($cart["Total"]) ?></div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="p-3">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-9 col-lg-9 text-right">
                                <div class="pl-5 pt-1">
                                    ยอดรวมสินค้า:
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 text-right">
                                <h3 class="text-shop" style="margin-bottom: 0px;margin-top: 0px;"><b><?php echo number_format($cat["Total"]) ?></b></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
<?php
} ?>

<?php 
    if($round <= 0){
?>
    <div style="padding: 2rem;">
        <div class="alert alert-warning text-center">
        <b>ไม่พบรายการยอดขาย.</b>
        </div>
    </div>
    
<?php } ?>
