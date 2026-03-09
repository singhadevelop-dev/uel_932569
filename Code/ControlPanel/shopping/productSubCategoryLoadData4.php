<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "_config.php"; ?>
<?php include "../assets/b4w-framework/UtilService.php"; ?>
 
<option value="">ไม่ระบุ</option>
<?php

$sql = "select m.SubCategoryCode4,m.SubCategoryName4
    from product_sub_category4 m 
    join product_category b on b.CategoryCode = m.CategoryCode
    where m.SubCategoryCode3 = '".$_GET["ref"]."'
    order by m.SubCategoryCode4 ";
$datas = SelectRowsArray($sql);
foreach ($datas as $data) {
?>
<option value="<?php echo $data["SubCategoryCode4"] ?>"><?php echo $data["SubCategoryName4"] ?></option>
<?php } ?>