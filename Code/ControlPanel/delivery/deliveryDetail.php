<?php $_COG_ITEM_CODE = 'DELIVERY'; ?>
<?php include  "../header.php"; ?>
<?php

if (isset($_POST["btnSave"])) {

    $txtSubject = $_POST["txtSubject"];
    $chkActive = isset($_POST["chkActive"]) ? 1 : 0;

    $Code = "";
    $sql = "";
    if (empty($_GET["ref"])) {
        $genID = GenerateNextID("delivery_category", "Code", 5, "D");
        $sql = "insert into delivery_category (Code,Name,Active,CreatedOn,CreatedBy) values(
                '$genID'
                ,'$txtSubject'
                ,$chkActive
                ,NOW()
                ,'" . UserService::UserCode() . "'
            );
        ";
        $Code = $genID;
    } else {
        $sql = "update delivery_category set
                 Name = '$txtSubject'
                ,Active = $chkActive
                ,UpdatedOn = NOW()
                ,UpdatedBy = '" . UserService::UserCode() . "'
                where Code = '" . $_GET["ref"] . "'
        ";
        $Code = $_GET["ref"];
    }
    ExecuteSQLTransaction($sql, "index.php");

    $sql = "delete from delivery_price where Code = '$Code'";
    ExecuteSQL($sql);

    for ($i = 0; $i < count($_POST["weight"]); $i++) {
        $sql = "insert into delivery_price (Code,weight,BKK,PROVINCE_SAME,PROVINCE_DIFF) values(
            '$Code'
            ,'" . $_POST["weight"][$i] . "'
            ,'" . $_POST["BKK"][$i] . "'
            ,'" . $_POST["PROVINCE_SAME"][$i] . "'
            ,'" . $_POST["PROVINCE_DIFF"][$i] . "'
        );";
        ExecuteSQL($sql);
    }
}

if (!empty($_GET["ref"])) {
    $sql = "select * from delivery_category where Code = '" . $_GET["ref"] . "'";
    $data = SelectRow($sql);
}
?>


<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-9">
            <h3 style="margin: 0;"><i class="fa fa-truck fa-fw"></i>
                <span class="analysis-left-menu-desc">ค่าจัดส่ง</span></h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

<div class="mat-box grey-bar">
    <a href="../delivery" class="link-history-btn">ค่าจัดส่ง</a>
    /
    <a href="../delivery" class="link-history-btn">ประเภทการจัดส่ง (บริษัทขนส่ง)</a>
    /
    <span class="link-history-btn">จัดการประเภทการจัดส่ง (บริษัทขนส่ง)</span>

</div>

<style>
    [required] {
        border-left: 2px solid #E65041;
    }
</style>

<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <form method="post" id="form-data">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <span><b><?php echo empty($_GET["ref"]) ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล " . $_GET["ref"] ?></b></span>
                    <hr style="margin-top: 5px;" />
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <label>ชื่อประเภทการจัดส่ง (บริษัทขนส่ง)</label>
                        <input type="text" name="txtSubject" id="txtSubject" value="<?php echo $data["Name"] ?>" class="form-control input-sm" required />
                    </div>
                    <div class="col-sm-4">
                        <b>ใช้งาน / ไม่ใช้งาน</b>

                        <div>
                            <i id="toggle-active" class="fa fa-toggle-on fa-3x text-success hand" style="" onclick="toggleActive(this);"></i>
                            <input type="checkbox" name="chkActive" class="hide" checked="checked" value="" />
                        </div>
                        <script>
                            function toggleActive(obj) {
                                $(obj).toggleClass('fa-toggle-on').toggleClass('fa-toggle-off')
                                    .toggleClass('text-success')
                                    .toggleClass('text-danger').next().click();
                            }
                            <?php if (!empty($_GET["ref"]) && $data["Active"] == 0) { ?>
                                $("#toggle-active").click();
                            <?php } ?>
                        </script>
                    </div>
                </div>

                <hr />

                <style>
                    .table th,
                    .table td {
                        vertical-align: middle !important;
                    }
                </style>
                <label>ตารางค่าจัดส่ง</label>
                <table class="table table-striped">
                    <thead class="text-center">
                        <tr>
                            <th rowspan="2" class="text-center">น้ำหนักสูงสุด (กรัม)</th>
                            <th rowspan="2" class="text-center">น้ำหนักสูงสุด (กิโลกรัม)</th>
                            <th colspan="3" class="text-center">ราคาค่าจัดส่ง (บาท)</th>
                            <th rowspan="2"></th>
                        </tr>
                        <tr>
                            <th>
                                ในกรุงเทพมหานคร
                            </th>
                            <th>
                                ในต่างจังหวัด (จังหวัดเดียวกัน)
                            </th>
                            <th>
                                ข้ามจังหวัด
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "select * from delivery_price where Code = '" . $_GET["ref"] . "'";
                        $dls = SelectRowsArray($sql);
                        foreach ($dls as $d) {
                        ?>
                            <tr>
                                <td>
                                    <input required name="weight[]" value="<?php echo $d["weight"] ?>" onkeyup="weightChange(this);" type="number" class="weight form-control text-right" step="1" />
                                </td>
                                <td class="text-right">
                                    <span class="weight-kg">0</span>
                                </td>
                                <td>
                                    <input required name="BKK[]" value="<?php echo $d["BKK"] ?>" type="number" class="BKK form-control text-right" step="1" />
                                </td>
                                <td>
                                    <input required name="PROVINCE_SAME[]" value="<?php echo $d["PROVINCE_SAME"] ?>" type="number" class="PROVINCE_SAME form-control text-right" step="1" />
                                </td>
                                <td>
                                    <input required name="PROVINCE_DIFF[]" value="<?php echo $d["PROVINCE_DIFF"] ?>" type="number" class="PROVINCE_DIFF form-control text-right" step="1" />
                                </td>
                                <td class="text-center">
                                    <a href="javascript:;" onclick="$(this).closest('tr').remove();">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="100%" class="text-center">
                                <a href="javascript:;" onclick="$(this).closest('tr').before($('.tmp').clone().removeClass('tmp'));">
                                    <i class="fa fa-plus fa-fw"></i>
                                    สร้างรายการ
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div>

                    <button type="submit" name="btnSave" class="btn btn-success">
                        <i class="fa fa-save"></i>
                        บันทึก
                    </button>

                    <a href="../delivery" class="btn btn-danger">
                        ยกเลิก
                    </a>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(".weight").keyup();
        function weightChange(obj) {
            var k = parseInt($(obj).val());
            var kg = isNaN(k) ? 0 : k / 1000;
            $(obj).closest("tr").find(".weight-kg").html(kg);
        }
    </script>
    <table class="hide">
        <tr class="tmp">
            <td>
                <input required name="weight[]" onkeyup="weightChange(this);" type="number" class="weight form-control text-right" step="1" />
            </td>
            <td class="text-right">
                <span class="weight-kg">0</span>
            </td>
            <td>
                <input required name="BKK[]" type="number" class="BKK form-control text-right" step="1" />
            </td>
            <td>
                <input required name="PROVINCE_SAME[]" type="number" class="PROVINCE_SAME form-control text-right" step="1" />
            </td>
            <td>
                <input required name="PROVINCE_DIFF[]" type="number" class="PROVINCE_DIFF form-control text-right" step="1" />
            </td>
            <td class="text-center">
                <a href="javascript:;" onclick="$(this).closest('tr').remove();">
                    <i class="fa fa-trash"></i>
                </a>
            </td>
        </tr>
    </table>
</div>


<?php include  "../footer.php"; ?>