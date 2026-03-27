<?php include_once  "../_master/_master.php"; ?>

<div class="mat-box grey-bar">

    <a href="item.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">รายการคุณสมบัติ</span>



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
                <a href="itemPropertiesDetail.php" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการคุณสมบัติ
                </a>
                <span><b>รายการคุณสมบัติ</b></span>
                <hr style="margin-top: 5px;" />
            </div>

            

            <table 
                data-sortable-table="product_properties"
                data-sortable-column-seq="SEQ"
                data-sortable-column-key="PropCode"
                class="jquery-datatable sortable-table table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width:50px;">รหัส</th>
                        <!--<th style="width:50px;" class="hide">ไอคอน</th>-->
                        <th>คุณสมบัติ</th>
                        <th style="width:50px;" class="text-center">ใช้งาน</th>
                        <th style="width:50px;" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>รหัส</th>
                        <!--<th class="hide">ไอคอน</th>-->
                        <th>คุณสมบัติ</th>
                        <th class="text-center">ใช้งาน</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    
                    $sql = "select * from product_properties where Active=1 and PropGroup='$_COG_ITEM_CODE' order by SEQ";
                    $datas = SelectRows($sql);
                    foreach ($datas as $data) {
                    ?>
                    <tr data-sortable-row-key="<?php echo $data["PropCode"] ?>">
                        <td><?php echo $data["PropCode"] ?></td>
                        <!--<td class="text-center hide">
                            <i class="<?php echo $data["PropIcon"] ?>"></i>
                        </td>-->
                        <td>
                        <?php echo $data["PropName"] ?>
                        </td>
                        <td class="text-center sortable-hide-item">
                            <?php echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                        </td>
                        <td class="text-center sortable-hide-item">
                            <a href="itemPropertiesDetail.php?ref=<?php echo $data["PropCode"] ?>">
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