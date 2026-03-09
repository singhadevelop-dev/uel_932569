<?php $_COG_ITEM_CODE = 'DELIVERY'; ?>
<?php include  "../header.php"; ?>
<?php
if (isset($_POST["btnDeleteRow"])) {
    $sql = "delete FROM delivery_category WHERE Code = '" . $_POST["btnDeleteRow"] . "'";
    ExecuteSQL($sql);
}

?>
<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-9">
            <h3 style="margin: 0;">
                <i class="fa fa-truck  fa-fw"></i>
                <span class="analysis-left-menu-desc">ค่าจัดส่ง</span>
            </h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

<div class="mat-box grey-bar">

    <a href="../delivery/" class="link-history-btn">จัดการประเภทการจัดส่ง (บริษัทขนส่ง)</a>
    /
    <span class="link-history-btn">ประเภทการจัดส่ง (บริษัทขนส่ง)</span>



</div>

<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
        <div class="col-md-12">
            <div>
                <a href="deliveryDetail.php" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการประเภทการจัดส่ง (บริษัทขนส่ง)
                </a>
                <span><b>รายการประเภทการจัดส่ง (บริษัทขนส่ง)</b></span>
                <hr style="margin-top: 5px;" />
            </div>

            <div>
                <div>
                    <table class="jquery-datatable display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width: 50px;">รหัส</th>
                                <th>ประเภทการจัดส่ง (บริษัทขนส่ง)</th>
                                <th style="width: 50px;" class="text-center">ใช้งาน</th>
                                <th style="width: 50px;" class="text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th style="width: 50px;">รหัส</th>
                                <th>ประเภทการจัดส่ง (บริษัทขนส่ง)</th>
                                <th style="width: 50px;" class="text-center">ใช้งาน</th>
                                <th style="width: 50px;" class="text-center">จัดการ</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php

                            $sql = "
                            select a.* from delivery_category a
                            where 1 order by a.Name
                        ";
                            $datas = SelectRowsArray($sql);
                            foreach ($datas as $data) {
                            ?>
                                <tr>
                                    <td><?php echo $data["Code"] ?></td>
                                    <td>

                                        <?php echo $data["Name"] ?>

                                    </td>
                                    <td class="text-center">
                                        <?php echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                                    </td>
                                    <td class="text-center">
                                        <form method="post">
                                            <a href="deliveryDetail.php?ref=<?php echo $data["Code"] ?>">
                                                <i class="fa fa-cog"></i>
                                            </a>
                                            <button type="submit" class="btn-link" onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');" value="<?php echo $data["Code"] ?>" name="btnDeleteRow">
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
</div>

<?php include  "../footer.php"; ?>