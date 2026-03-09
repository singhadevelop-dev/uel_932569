<?php include_once  "../_master/_master.php"; ?>

<div class="mat-box grey-bar">

    <a href="item.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">รายการสี</span>



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
                <a href="itemColorDetail.php" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการสี
                </a>
                <span><b>รายการสี</b></span>
                <hr style="margin-top: 5px;" />
            </div>

            

            <table class="jquery-datatable display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="width:10px;"></th>
                        <th>ชื่อสี</th>
                        <th style="width:50px;" class="text-center">ใช้งาน</th>
                        <th style="width:50px;" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>ชื่อสี</th>
                        <th class="text-center">ใช้งาน</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    
                    $sql = "select * from tag where TagType = 'COLOR-$_COG_ITEM_CODE' order by TagCode";
                    $datas = SelectRowsArray($sql);
                    foreach ($datas as $data) {
                    ?>
                    <tr>
                        <td class="text-center">
                            <span class="hide"><?php echo $data["TagCode"] ?></span>
                            <i class="fa fa-square" style="color:<?php echo $data["FreeText"] ?>"></i>
                        </td>
                        <td>
                        
                        <?php echo $data["TagName"] ?>

                        </td>
                        <td class="text-center">
                            <?php echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                        </td>
                        <td class="text-center">
                            <a href="itemColor.php?ref=<?php echo $data["TagCode"] ?>">
                                <i class="fa fa-cog"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php include  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>