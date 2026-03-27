<?php include_once  "../_master/_master.php"; ?>


<?php 

if(isset($_POST["btnDeleteRow"])){
    $sql = "delete from tag where TagCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
}

?>


<div class="mat-box grey-bar">
    <a href="item.php" class="link-history-btn">หน้าหลัก<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">แท็ก<?php echo $_COG_ITEM_NAME ?></span>
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
                <a href="itemTagDetail.php" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการแท็ก
                </a>
                <span><b>รายการแท็ก</b></span>
                <hr style="margin-top: 5px;" />
            </div>

            <table class="jquery-datatable display" 
            cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ชื่อแท็ก</th>
                        <th style="width:50px;" class="text-center">ใช้งาน</th>
                        <th style="width:50px;" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ชื่อแท็ก</th>
                        <th class="text-center">ใช้งาน</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    
                    $sql = "select * from tag where TagType = '$_COG_ITEM_CODE' order by TagCode";
                    $datas = SelectRowsArray($sql);
                    foreach ($datas as $data) {
                    ?>
                    <tr>
                        <td>
                        <?php echo $data["TagName"] ?>

                        </td>
                        <td class="text-center">
                            <?php echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                        </td>
                        <td class="text-center">
                            <a href="itemTagDetail.php?ref=<?php echo $data["TagCode"] ?>">
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



<?php include  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>