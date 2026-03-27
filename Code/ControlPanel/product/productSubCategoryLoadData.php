<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "_config.php"; ?>
<?php include "../assets/b4w-framework/UtilService.php"; ?>
 
<option value="">ไม่ระบุ</option>
<?php

$sql = "select m.*,b.CategoryName from product_sub_category m , product_category b 
                    where b.CategoryCode = m.CategoryCode and m.CategoryCode = '".$_GET["ref"]."'
                    order by m.SubCategoryCode";
$datas = SelectRowsArray($sql);
foreach ($datas as $data) {
?>
<option value="<?php echo $data["SubCategoryCode"] ?>"><?php echo $data["SubCategoryName"] ?></option>
<?php } ?>