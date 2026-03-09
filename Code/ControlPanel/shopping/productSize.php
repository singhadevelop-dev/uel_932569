<?php $_COG_ITEM_CODE = 'SHOPPING'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>
<?php 
if(isset($_POST["btnDeleteRow"])){
    $sql = "update tag set Active=0 where TagType='SIZE' and TagCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
}
?>

<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">ไซส์ ของ<?php echo $_COG_ITEM_NAME ?></span>

</div>

<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
       <div class="col-md-3">
            <?php 
            $_LEFT_MENU_ACTIVE = "SIZE";
            include "leftMenu.php"; 
            ?>
        </div>
        <div class="col-md-9">
            <div>
                <a href="productSizeDetail.php" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการไซส์
                </a>
                <span><b>รายการไซส์</b></span>
                <hr style="margin-top: 5px;" />
            </div>

            

            <table data-sortable-table="tag"
                data-sortable-column-seq="SEQ"
                data-sortable-column-key="TagCode"
                class="jquery-datatable sortable-table table table-striped table-hover"
             cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ชื่อไซส์</th>
                        <!-- <th style="width:50px;" class="text-center">ใช้งาน</th> -->
                        <th style="width:50px;" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ชื่อไซส์</th>
                        <!-- <th class="text-center">ใช้งาน</th> -->
                        <th class="text-center">จัดการ</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    
                    $sql = "select * from tag where TagType = 'SIZE' and Active=1 order by SEQ,TagCode";
                    $datas = SelectRowsArray($sql);
                    foreach ($datas as $data) {
                    ?>
                    <tr data-sortable-row-key="<?php echo $data["TagCode"] ?>">
                        <td>
                        <span class="hide"><?php echo $data["TagCode"] ?></span>
                          

                        <?php echo $data["TagName"] ?>

                        </td>
                        <!-- <td class="text-center">
                            <?php //echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                        </td> -->
                        <td class="text-center">
                            <a href="productSizeDetail.php?ref=<?php echo $data["TagCode"] ?>">
                                <i class="fa fa-cog"></i>
                            </a>
                            <form method="post" style="display:inline">
                                <button type="submit" class="btn-link" 
                                    onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                    value="<?php echo $data["TagCode"] ?>" name="btnDeleteRow">
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