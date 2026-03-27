<?php include  "_config.php"; ?>
<?php include "../../assets/b4w-framework/UtilService.php"; ?>
 
<option value="">ไม่ระบุ</option>
<?php

$sql = "select m.*,b.CategoryName 
    from product_sub_category m 
    inner join product_category b on b.CategoryCode = m.CategoryCode
    where m.CategoryCode = '".$_GET["ref"]."'
    order by m.SEQ asc ,m.SubCategoryCode asc" ;
$datas = SelectRowsArray($sql);
foreach ($datas as $data) {
?>
<option value="<?php echo $data["SubCategoryCode"] ?>"><?php echo $data["SubCategoryName"] ?></option>
<?php } ?>