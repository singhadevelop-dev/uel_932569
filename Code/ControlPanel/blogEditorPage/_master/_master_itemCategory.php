<?php include_once  "../_master/_master.php"; ?>
<?php 
if(isset($_POST["btnDeleteRow"])){
    $sql = "delete from product_category where CategoryCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
    $sql = "update product set CategoryCode = '' where CategoryCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
}
?>
<div class="mat-box grey-bar">
    <a href="item.php" class="link-history-btn">หน้าหลัก<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">รายการ<?php echo $_COG_ITEM_NAME ?></span>
</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
        <?php if($_COG_ALLOW_LEFT_MENU){ ?>
        <div class="col-md-2">
            <?php include_once  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/blogEditorPage/_master/_master_leftMenu.php"; ?>
        </div>
        <?php } ?>
        <div class="col-md-<?php echo $_COG_ALLOW_LEFT_MENU ? "10" : "12" ?>">
            <div>
                <a href="itemCategoryDetail.php" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการ<?php echo $_COG_ITEM_NAME ?>
                </a>
                <span><b>รายการ<?php echo $_COG_ITEM_NAME ?></b></span>
                <hr style="margin-top: 5px;" />
                <table
                    data-sortable-table="product_category"
                    data-sortable-column-seq="SEQ"
                    data-sortable-column-key="CategoryCode"
                    class="jquery-datatable sortable-table table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width:50px;">รหัส</th>
                        <th>ชื่อ<?php echo $_COG_ALLOW_CATEGORY ? "หมวดหมู่" : "" ?><?php echo $_COG_ITEM_NAME ?></th>
                        <th style="width:50px;" class="text-center">ใช้งาน</th>
                        <th style="width:50px;" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>รหัส</th>
                        <th>ชื่อ<?php echo $_COG_ALLOW_CATEGORY ? "หมวดหมู่" : "" ?><?php echo $_COG_ITEM_NAME ?></th>
                        <th class="text-center">ใช้งาน</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $sql = "select * from product_category where CategoryGroup = '".$_COG_ITEM_CODE."' order by seq";
                    $datas = SelectRows($sql);
                    while($data = $datas->fetch_array()){
                    ?>
                    <tr data-sortable-row-key="<?php echo $data["CategoryCode"] ?>">
                        <td><?php echo $data["CategoryCode"] ?></td>
                        <td>
                        <?php echo $data["CategoryName"] ?>
                        </td>
                        <td class="text-center sortable-hide-item">
                            <?php echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                        </td>
                        <td class="text-center sortable-hide-item">
                            <a href="itemCategoryDetail.php?ref=<?php echo $data["CategoryCode"] ?>">
                                <i class="fa fa-cog"></i>
                            </a>
                            <form method="post" style="display:inline">
                                <button type="submit" class="btn-link" 
                                    onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                    value="<?php echo $data["CategoryCode"] ?>" name="btnDeleteRow">
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
<?php include  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>