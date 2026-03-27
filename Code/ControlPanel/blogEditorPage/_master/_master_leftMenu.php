<?php 
$_CUR_URL_FILE = strtoupper(basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']));
// $_ALL_MENU = array(
//     array("ITEM","item.php",$_COG_ITEM_NAME)
// );
$_ALL_MENU = array();
if($_COG_ALLOW_LEFT_MENU_ITEMS){
    array_push($_ALL_MENU,array("ITEM","item.php",$_COG_ITEM_NAME));
}
if($_COG_ALLOW_CATEGORY){
    array_push($_ALL_MENU,array("CATEGORY","itemCategory.php","หมวดหมู่"));
}
if($_COG_ALLOW_CATEGORY_SUB){
    array_push($_ALL_MENU,array("CATEGORY2","itemSubCategory.php","หมวดหมู่ย่อย"));
}


if($_COG_ALLOW_LEFT_MENU_TEAM){
    array_push($_ALL_MENU,array("TEAM","itemTeam.php","ทีมของเรา"));
}

if($_COG_ALLOW_PROPERTIES){
    array_push($_ALL_MENU,array("PROPERTIES","itemProperties.php","คุณสมบัติ"));
}

if($_COG_ALLOW_TAG){
    array_push($_ALL_MENU,array("TAG","itemTag.php","แท็ก"));
}
if($_COG_ALLOW_ROAD){
    array_push($_ALL_MENU,array("ROAD","itemRoad.php", !empty($_COG_ALLOW_ROAD_NAME) ?  $_COG_ALLOW_ROAD_NAME : "ถนน"));
}
if($_COG_ALLOW_LEFT_FEEDBACK){
    array_push($_ALL_MENU,array("REVIEW","itemFeedBack.php","รีวิว"));
}
if($_COG_ALLOW_MASTER_DETAIL){
    array_push($_ALL_MENU,array("MASTERDETAIL","masterDetail.php","ข้อมูลรายละเอียด"));
}
if($_COG_ALLOW_LEFT_MENU_GALLERY){
    array_push($_ALL_MENU,array("GALLERY","itemDetailGallery.php","รูปภาพ"));
}
if($_COG_ALLOW_LEFT_MENU_FEEDBACK){
    array_push($_ALL_MENU,array("FEEDBACK","itemFeedBack.php","รายการผลตอบ"));
}
if($_COG_ALLOW_LEFT_MENU_EXCEL){
    array_push($_ALL_MENU,array("EXCEL","itemImportExcel.php","นำเข้าข้อมูลด้วย Excel"));
}
?>
<div>
    <span><b>เมนูข้อมูล</b></span>
    <hr style="margin-top: 5px;margin-bottom:0" />
    <?php foreach ($_ALL_MENU as $value)
      { 
            $active = strpos($_CUR_URL_FILE, strtoupper($value[1])) !== false ? "active" : "";
    ?>
    	<a class="left-group <?php echo $active ?>" data-det-group="<?php echo $value[0] ?>" href="<?php echo $value[1] ?>"><?php echo $value[2] ?> <i class="fa fa-caret-right pull-right"></i></a>
    <?php } ?>
</div>