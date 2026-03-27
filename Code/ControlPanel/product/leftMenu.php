<?php 

$_COG_ALLOW_HEADER = false;
include  "_config.php"; 
?>

<div>
    <span><b>เมนูข้อมูล<?php echo $_COG_ITEM_NAME ?></b></span>
    <hr style="margin-top: 5px;margin-bottom:0" />
    <a class="left-group" data-det-group="PRODUCT" href="product.php"><?php echo $_COG_ITEM_NAME ?> <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group" data-det-group="CATEGORY" href="productCategory.php">หมวดหมู่ <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="SUBCATEGORY" href="productSubCategory.php">หมวดหมู่ย่อยที่ 2 <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="SUBCATEGORY3" href="productSubCategory3.php">หมวดหมู่ย่อยที่ 3 <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="SUBCATEGORY4" href="productSubCategory4.php">หมวดหมู่ย่อยที่ 4 <i class="fa fa-caret-right pull-right"></i></a>
    
    <a class="left-group hide" data-det-group="TYPE" href="productType.php">ประเภท<?php echo $_COG_ITEM_NAME ?> <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="SERIES" href="productSeries.php">ซีรีย์<?php echo $_COG_ITEM_NAME ?> <i class="fa fa-caret-right pull-right"></i></a>
    
    <a class="left-group hide" data-det-group="BRAND" href="productBrand.php">ยี่ห้อ <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="MODEL" href="productModel.php">รุ่น <i class="fa fa-caret-right pull-right"></i></a>
    
    
    <?php if($__COGS_GLOBAL_CART){ ?>
        <a class="left-group hide" data-det-group="COLOR" href="productColor.php">สี <i class="fa fa-caret-right pull-right"></i></a>
        <a class="left-group hide" data-det-group="SIZE" href="productSize.php">ไซส์ Power <i class="fa fa-caret-right pull-right"></i></a>
    <?php } ?>
    <a class="left-group hide" data-det-group="MATERIAL" href="productMaterial.php">Material <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="PROPERTIES" href="productProperties.php">คุณสมบัติ <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="TAG" href="productTag.php">แท็ก <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group hide" data-det-group="STATUS" href="productStatus.php">สถานะ <i class="fa fa-caret-right pull-right"></i></a>
    <a class="left-group" data-det-group="MASTERDETAIL" href="masterDetail.php">รายละเอียดทั่วไป<i class="fa fa-caret-right pull-right"></i></a>

</div>
<script>
    $(".left-group[data-det-group='<?php echo $_LEFT_MENU_ACTIVE; ?>']").addClass("active");
</script>