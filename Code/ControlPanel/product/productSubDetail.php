<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>
<?php 
$get_ref = $_GET["ref"];

if(isset($_POST["btnDeleteRow"])){
    //$sql = "update product_properties set Active=0 where PropCode = '".$_POST["btnDeleteRow"]."'";
    $sql = "DELETE FROM `product_sub_detail` WHERE `ProductCode`='$get_ref' and `SubDetailCode`='".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
}
?>

<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">รายการหัวข้อรายละเอียด</span>



</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
        <div class="col-md-2">
            <?php 
            $_LEFT_MENU_ACTIVE = "PRODUCT";
            include "leftMenu.php"; 
            ?>
        </div>
        <div class="col-md-10">
            <div>
                <a href="productSubDetailDetail.php?ref=<?php echo $get_ref ?>" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการหัวข้อรายละเอียด
                </a>
                <span><b>รายการหัวข้อรายละเอียด</b></span>
                <hr style="margin-top: 5px;" />
            </div>

            
            <table 
                data-sortable-table="product_sub_detail"
                data-sortable-column-seq="SEQ"
                data-sortable-column-key="SubDetailCode"
                class="jquery-datatable sortable-table table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width:50px;">รหัส</th>
                        <th>กลุ่ม</th>
                        <th>หัวข้อรายละเอียด</th>
                        <th style="width:50px;" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>รหัส</th>
                        <th>กลุ่ม</th>
                        <th>หัวข้อรายละเอียด</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `product_sub_detail` WHERE `ProductCode`='$get_ref' order by SEQ";
                    $datas = SelectRows($sql);
                    foreach ($datas as $data) {
                    ?>
                    <tr data-sortable-row-key="<?php echo $data["SubDetailCode"] ?>">
                        <td><?php echo $data["SubDetailCode"] ?></td>
                        <td>
                        <?php echo $data["GroupName"] ?>
                        </td>
                        <td>
                        <?php echo $data["SubDetailName"] ?>
                        </td>
                        <td class="text-center sortable-hide-item">
                            <a href="productSubDetailDetail.php?ref=<?php echo $get_ref ?>&ref2=<?php echo $data["SubDetailCode"] ?>">
                                <i class="fa fa-cog"></i>
                            </a>
                            <form method="post" style="display:inline">
                                <button type="submit" class="btn-link" 
                                    onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                    value="<?php echo $data["SubDetailCode"] ?>" name="btnDeleteRow">
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



<?php include  "../footer.php"; ?>