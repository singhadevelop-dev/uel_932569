<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "_config.php"; ?>
<?php include "../assets/b4w-framework/UtilService.php"; ?>
 
<option value="">ไม่ระบุ</option>
<?php

$sql = "select m.SubCategoryCode3,m.SubCategoryName3
    from product_sub_category3 m 
    join product_category b on b.CategoryCode = m.CategoryCode
    where m.SubCategoryCode = '".$_GET["ref"]."'
    order by m.SubCategoryCode3";
$datas = SelectRowsArray($sql);
foreach ($datas as $data) {
?>
<option value="<?php echo $data["SubCategoryCode3"] ?>"><?php echo $data["SubCategoryName3"] ?></option>
<?php } ?>