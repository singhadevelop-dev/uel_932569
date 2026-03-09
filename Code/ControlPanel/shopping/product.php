<?php $_COG_ITEM_CODE = 'SHOPPING'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>
<?php 
$_ProductImg_1 = true;
$_ProductImg_2 = false;
if(isset($_POST["btnDeleteRow"])){
    $sql = "delete from shopping where ProductCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
    $sql = "delete from gallery where RefCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
    $sql = "delete from product_properties_mapping where ProductCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
}
if(isset($_POST["btnChageLandingPage"])){
    $sql = "update shopping set LandingPage=".$_POST["txtLandingPage"]." where ProductCode = '".$_POST["txtProductCode"]."'";
    ExecuteSQL($sql);
}
?>
<div class="mat-box grey-bar">
    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    
    <span class="link-history-btn">รายการ<?php echo $_COG_ITEM_NAME ?></span>
</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
        <?php if($_COG_ALLOW_LEFT_MENU){ ?>
        <div class="col-md-2">
            <?php 
            $_LEFT_MENU_ACTIVE = "SHOPPING";
            include "leftMenu.php"; 
            ?>
        </div>
        <?php } ?>
        <div class="col-md-<?php echo $_COG_ALLOW_LEFT_MENU ? "10" : "12" ?>">
            <div>
                <a href="productDetail.php" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการ<?php echo $_COG_ITEM_NAME ?>
                </a>
                <span><b>รายการ<?php echo $_COG_ITEM_NAME ?></b></span>
                <hr style="margin-top: 5px;" />
                <table style="width: 100%;"
                    data-sortable-table="product"
                    data-sortable-column-seq="SEQ"
                    data-sortable-column-key="ProductCode"
                    class="jquery-datatable sortable-table table table-striped table-hover">
                <thead>
                    <tr>
                        <!-- <th style="width:50px;">รหัส</th> -->
                        <th class="" style="width:80px;">SKU</th>
                        <th class="text-center" style="min-width:100px;">ชื่อ<?php echo $_COG_ITEM_NAME ?></th>
                        <!-- <th>ชื่อลูกค้า</th> -->
                        <th style="max-width:80px;" class="text-center">กลุ่มสินค้า</th>
                        <th class="">หมวดหมู่</th>
                        <?php if($__COGS_GLOBAL_CART){ ?>
                        <!-- <th>น้ำหนัก (กรัม)</th> -->
                        <?php } ?>
                        <th style="width:15px;" class="text-center hide" title="แสดงที่หน้าแรก">โชว์หน้าแรก</th>
                        <th class="text-right hide">ราคาต่อหน่วย</th>
                        <th class="text-right">สินค้าคงเหลือ</th>
                        <th style="width:30px;" class="text-center">ใช้งาน</th>
                        <th style="width:50px;" class="text-center hide">Ranking</th>
                        <th style="width:100px;" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <!-- <th style="width:50px;" >รหัส</th> -->
                        <th class="">SKU</th>
                        <th class="text-center">ชื่อ<?php echo $_COG_ITEM_NAME ?></th>
                        <!-- <th>ชื่อลูกค้า</th> -->
                        <th style="max-width:80px;" class="text-center">กลุ่มสินค้า</th>
                        <th class="">หมวดหมู่</th>
                        <?php if($__COGS_GLOBAL_CART){ ?>
                        <!-- <th>น้ำหนัก (กรัม)</th> -->
                        <?php } ?>
                        <th style="width:15px;" class="text-center hide">โชว์หน้าแรก</th>
                        <th class="text-right hide">ราคาต่อหน่วย</th>
                        <th class="text-right">สินค้าคงเหลือ</th>
                        <th style="width:30px;" class="text-center">ใช้งาน</th>
                        <th style="width:50px;" class="text-center hide">Ranking</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $sql = "select p.*,c.CategoryName, d.SubCategoryName 
                            ,e.BrandCode , e.BrandName
                            from shopping p
                            left join product_category c
                            on c.CategoryCode = p.CategoryCode
                            left join product_sub_category d
                                on p.SubCategoryCode = d.SubCategoryCode
                            left join product_brand e
                                on p.BrandCode = e.BrandCode
                            order by p.ProductCode";
                    $datas = SelectRows($sql);
                    foreach ($datas as $data) {
                    ?>
                    <tr data-sortable-row-key="<?php echo $data["ProductCode"] ?>">
                        <!-- <td class=""><?php echo $data["ProductCode"] ?></td> -->
                        <td class=""><?php echo !empty($data["ProductRefCode"]) ? $data["ProductRefCode"] : "N/A" ?></td>
                        <td class="text-center">
                        <?php //echo empty($data["BrandName"]) ? "<i class='text-muted'>[ไม่ได้ระบุ]</i>" : "<span class='text-primary'>".$data["BrandName"]."</span>" ?><?php echo $data["ProductName"] ?>
                        </td>
                        <!-- <td>
                            <?php //echo $data["Customer"] ?>
                        </td> -->
                        <td class="text-center">
                            <?php echo $data["New"] == 1 ? "<b class='text-primary'>ใหม่</b>" : "" ?>
                            <?php //echo $data["Promotion"] == 1 ? "<b class='text-success'>โปรโมชั่น</b>".($data["Hot"] == 1 ? "," : "" ) : "" ?>
                            <?php // echo $data["Hot"] == 1 ? "<b class='text-danger'>ขายดี</b>" : "" ?>
                        </td>
                        <td class=""><?php echo empty($data["CategoryName"]) ? "<i class='text-muted'>ไม่พบหมวดหมู่</i>" : $data["CategoryName"] ?></td>
                        <?php if($__COGS_GLOBAL_CART){ ?>
                        <!-- <td class="text-center sortable-hide-item">
                            <?php //echo empty($data["Weight"]) ? "<i class='text-muted'>ไม่ได้ระบุ</i>" : number_format($data["Weight"],2) ?>
                        </td> -->
                        <?php } ?>
                        <td class="text-center sortable-hide-item hide">
                            <i id="toggle-active" class="fa fa-2x hand <?php echo $data["LandingPage"] == 1 ? "fa-toggle-on text-success" : "fa-toggle-off text-danger" ?> " onclick="toggleActive(this,'<?php echo $data['ProductCode'] ?>','<?php echo $data['LandingPage'] ?>');"></i>
                        </td>
                        <td class="text-right sortable-hide-item hide">
                            <?php echo $data["Price"] <= 0 ? "<label class='text-danger'>".number_format($data["Price"],2)."</label>" : "<label class='text-primary'>". number_format($data["Price"],2) ."</label>" ?>
                        </td>
                        <td class="text-right sortable-hide-item">
                            <?php echo $data["Amount"] <= 0 ? "<label class='text-danger'>0</label>" : "<label class='text-success'>". number_format($data["Amount"]) ."</label>" ?>
                        </td>
                        <td class="text-center sortable-hide-item">
                            <?php echo $data["Active"] == 1 ? "Active" : "Inactive" ?>
                        </td>
                        <td class="text-center sortable-hide-item hide">
                            <?php echo $data["Rank"]  ?>
                        </td>
                        <td class="text-center sortable-hide-item">
                            <a class="" title="แกลเลอรี่" href="productDetailGallery.php?ref=<?php echo $data["ProductCode"] ?>">
                                <i class="fa fa-picture-o"></i>
                            </a>
                            <a class="hide" title="แปลนบ้าน" style="margin-left:8px;" href="productHighlight.php?ref=<?php echo $data["ProductCode"] ?>">
                                <i class="fa fa-th-list"></i>
                            </a>
                            <?php if ($_ProductImg_2) { ?>
                            <a title="Unit Plan" style="margin-left:8px;" href="productDetailGallery3.php?ref=<?php echo $data["ProductCode"] ?>">
                                <i class="fa fa-picture-o"></i>
                            </a>
                            <?php } ?>
                            <a title="แก้ไขข้อมูล" style="margin-left:8px;" href="productDetail.php?ref=<?php echo $data["ProductCode"] ?>">
                                <i class="fa fa-cog"></i>
                            </a>
                            <form method="post" style="display:inline">
                                <button type="submit" class="btn-link" 
                                    onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                    value="<?php echo $data["ProductCode"] ?>" name="btnDeleteRow">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<form action="" method="post" class="hide">
    <input type="text" name="txtLandingPage" id="txtLandingPage">
    <input type="text" name="txtProductCode" id="txtProductCode">
    <button id="btnChageLandingPage" name="btnChageLandingPage" type="submit"></button>
</form>

<script>
     function toggleActive(obj,p,lg) {
        
        $(obj).toggleClass('fa-toggle-on').toggleClass('fa-toggle-off')
        .toggleClass('text-success')
        .toggleClass('text-danger');
        $("#txtProductCode").val(p);
        $("#txtLandingPage").val(lg == 1 ? 0 : 1);
        $("#btnChageLandingPage").click();
    }
</script>
<?php include  "../footer.php"; ?>