<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>


<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">รายการประเภท</span>



</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
        <div class="col-md-3">
            <?php 
            $_LEFT_MENU_ACTIVE = "TYPE";
            include "leftMenu.php"; 
            ?>
        </div>
        <div class="col-md-9">
            <div>
                <a href="productTypeDetail.php" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการประเภท
                </a>
                <span><b>รายการประเภท</b></span>
                <hr style="margin-top: 5px;" />
            </div>

            <table 
                data-sortable-table="tag"
                data-sortable-column-seq="SEQ"
                data-sortable-column-key="TagCode"
                class="jquery-datatable sortable-table table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width:50px;">รหัส</th>
                        <th>ประเภท</th>
                        <th style="width:50px;" class="text-center">ใช้งาน</th>
                        <th style="width:50px;" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>รหัส</th>
                        <th>ประเภท</th>
                        <th class="text-center">ใช้งาน</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    
                    $sql = "select * from tag where TagType='TYPE' order by SEQ";
                    $datas = SelectRows($sql);
                    foreach ($datas as $data) {
                    ?>
                    <tr data-sortable-row-key="<?php echo $data["TagCode"] ?>">
                        <td><?php echo $data["TagCode"] ?></td>
                        <td>
                        <?php echo $data["TagName"] ?>
                        </td>
                        <td class="text-center sortable-hide-item">
                            <?php echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                        </td>
                        <td class="text-center sortable-hide-item">
                            <a href="productStatusDetail.php?ref=<?php echo $data["TagCode"] ?>">
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



<?php include  "../footer.php"; ?>