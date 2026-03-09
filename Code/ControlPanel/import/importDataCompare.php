<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include("../header.php") ?>

<?php

$datas = $_POST["txtImportDataToSave"];
$datasArray = json_decode($datas);


if (isset($_POST["btnSave"])) {
    $submitDatas = $_POST["txtImportDataToSave"];
    $submitArray = json_decode($submitDatas);
    $allDatas = array();
    for ($i = 0; $i < count($_POST["RowValid"]); $i++) {
        $RowValid = $_POST["RowValid"][$i];
        if ($RowValid == "VALID") {
            $Data = $submitArray[$i];
            $arrData = array();
            for ($x = 0; $x < 15; $x++) {
                array_push($arrData,$Data[$x]);
            }
            array_push($allDatas,$arrData);
        }
    }

    if(count($allDatas) > 0){
        $sql = "select * from product_category where CategoryGroup = 'PRODUCT'";
        $_cate = SelectRowsArray($sql);
        $cate = array();
        foreach ($_cate as $d) {
            $cate[trim($d["CategoryName"])] = $d["CategoryCode"];
        }

        $sql = "select CONCAT(TRIM(c.CategoryName),'-',TRIM(s.SubCategoryName)) as xKey
        ,s.SubCategoryCode as xValue
        from product_category c
        join product_sub_category s 
        on s.CategoryCode = c.CategoryCode
        where c.CategoryGroup = 'PRODUCT'";

        $_sub_1 = SelectRowsArray($sql);
        $sub_1 = array();
        foreach ($_sub_1 as $d) {
            $sub_1[trim($d["xKey"])] = $d["xValue"];
        }

        $sql = "select CONCAT(TRIM(c.CategoryName),'-',TRIM(s.SubCategoryName),'-',TRIM(x.SubCategoryName3)) as xKey
        ,x.SubCategoryCode3 as xValue
        from product_category c
        join product_sub_category s 
        on s.CategoryCode = c.CategoryCode
        join product_sub_category3 x
        on x.CategoryCode = c.CategoryCode
        and x.SubCategoryCode = s.SubCategoryCode
        where c.CategoryGroup = 'PRODUCT'";

        $_sub_3 = SelectRowsArray($sql);
        $sub_3 = array();
        foreach ($_sub_3 as $d) {
            $sub_3[trim($d["xKey"])] = $d["xValue"];
        }

        //$sql = "select * from product";
        $sql = "select a.ProductCode, a.ProductName , b.CategoryName, c.SubCategoryName, d.SubCategoryName3
            from product a
            left join product_category b 
                on a.CategoryCode = b.CategoryCode
            left join product_sub_category c 
                on a.SubCategoryCode = c.SubCategoryCode
            left join product_sub_category3 d 
                on a.SubCategoryCode3 = d.SubCategoryCode3";
        $_prd = SelectRowsArray($sql);
        $prd = array();
        foreach ($_prd as $d) {
            $prd[trim($d["CategoryName"])."-".trim($d["SubCategoryName"])."-".trim($d["SubCategoryName3"])."-".trim($d["ProductName"])] = $d["ProductCode"];
        }

        $_isUpdate = array();
        foreach ($allDatas as $d) {
            $pName = REP_SGx(trim($d[4]));
            $xCate = trim($d[1]);
            $xSub_1 = $xCate."-".trim($d[2]);
            $xSub_3 = $xSub_1."-".trim($d[3]);
            $xPrd = $xSub_3."-".$pName;

            $codeCate = $cate[$xCate];
            if(empty($codeCate)){
                $codeCate = GenerateNextID("product_category","CategoryCode",5,"C");
                $sql = "insert into product_category (
                    CategoryCode,CategoryName,Active,CreatedOn,CreatedBy,SEQ,CategoryGroup
                ) values(
                    '$codeCate'
                    ,'".trim($d[1])."'
                    ,'1'
                    ,NOW()
                    ,'".UserService::UserCode()."'
                    ,'99'
                    ,'PRODUCT'
                );";
                ExecuteSQL($sql);

                $cate[$xCate] = $codeCate;
            }

            $codeSub_1 = $sub_1[$xSub_1];
            if(empty($codeSub_1)){
                $codeSub_1 = GenerateNextID("product_sub_category","SubCategoryCode",5,"S");
                $sql = "insert into product_sub_category (
                    SubCategoryCode,CategoryCode,SubCategoryName,Active,CreatedOn,CreatedBy,SEQ
                ) values(
                    '$codeSub_1'
                    ,'$codeCate'
                    ,'".trim($d[2])."'
                    ,'1'
                    ,NOW()
                    ,'".UserService::UserCode()."'
                    ,'99'
                );";
                ExecuteSQL($sql);

                $sub_1[$xSub_1] = $codeSub_1;
            }

            $codeSub_3 = $sub_3[$xSub_3];
            if(empty($codeSub_3)){
                $codeSub_3 = GenerateNextID("product_sub_category3","SubCategoryCode3",5,"S");
                $sql = "insert into product_sub_category3 (
                    SubCategoryCode3,SubCategoryCode,CategoryCode,SubCategoryName3,Active,CreatedOn,CreatedBy,SEQ
                ) values(
                    '$codeSub_3'
                    ,'$codeSub_1'
                    ,'$codeCate'
                    ,'".trim($d[3])."'
                    ,'1'
                    ,NOW()
                    ,'".UserService::UserCode()."'
                    ,'99'
                );";
                ExecuteSQL($sql);

                $sub_3[$xSub_3] = $codeSub_3;
            }

            //$codePrd = $prd[$xPrd];
            //$pName = trim($d[4]);
            $codePrd = $prd[$xPrd];
            if(empty($codePrd)){
                $codePrd = GenerateNextID("product","ProductCode",5,"P");
                $sql = "insert into product (
                    ProductCode,ProductRefCode,ProductName,ProductDetail2,ShortDescription
                    ,Price,PriceDesc,CategoryCode,SubCategoryCode,SubCategoryCode3
                    ,Active,CreatedOn,CreatedBy,SEQ
                    ,Address,Image,FileDownload
                ) values(
                    '$codePrd'
                    ,'".trim($d[5])."'
                    ,'".$pName."'
                    ,'".(trim($d[12]))."'
                    ,'".trim($d[11])."'
                    ,'".trim($d[8])."'
                    ,'".trim($d[6])."'
                    ,'$codeCate'
                    ,'$codeSub_1'
                    ,'$codeSub_3'
                    ,'1'
                    ,NOW()
                    ,'".UserService::UserCode()."'
                    ,'99'
                    ,'".trim($d[7])."'
                    ,'".trim($d[9])."'
                    ,'".trim($d[10])."'
                );";
                ExecuteSQL($sql);

                $prd[$xPrd] = $codePrd;
                $_isUpdate[$codePrd] = $codePrd;

            }else if(empty($_isUpdate[$codePrd])){ //เช็คการอัพเดตซ้ำ
                //UPDATE
                $sql = "update product set
                    ProductRefCode = '".trim($d[5])."',
                    ProductName = '". $pName ."',
                    ProductDetail2 = '". GeneratePageFile(trim($d[12]))."',
                    ShortDescription = '".trim($d[11])."',
                    Price = '".trim($d[8])."',
                    PriceDesc = '".trim($d[6])."',
                    CategoryCode = '$codeCate',
                    SubCategoryCode = '$codeSub_1',
                    SubCategoryCode3 = '$codeSub_3',
                    Active=1,
                    UpdatedOn=now(),
                    UpdatedBy='".UserService::UserCode()."',
                    -- SEQ = '99',
                    Address = '".trim($d[7])."',
                    Image = '".trim($d[9])."',
                    FileDownload='".trim($d[10])."'
                    where ProductCode='$codePrd'
                ";
                ExecuteSQL($sql);
                ExecuteSQL("delete from product_properties_mapping WHERE ProductCode='$codePrd'");

                $_isUpdate[$codePrd] = $codePrd;
            }

            $sql = "insert into product_properties_mapping (PropCode,ProductCode,Name,Detail)
            values(
                '".GetGUID()."'
                ,'$codePrd'
                ,'".trim($d[13])."'
                ,'".trim($d[14])."'
            );";
            ExecuteSQL($sql);

            //$x = 1;
        }
    }
    GenerateHTAccess();
    AlertSuccessRedirect("ทำรายการสำเร็จ", "บันทึกเรียบร้อยแล้ว", $GLOBALS["ROOT"] . "/ControlPanel/product/product.php");
}

function REP_SGx($input){
    return str_replace("\"","’’",str_replace("'","’",$input));
}

?>

<style>
    .compare-box {
        max-height: calc(100vh - 280px);
        overflow: auto;
    }

    .table {
        font-size: 12px;
    }

    .table th {
        text-align: center;
        vertical-align: middle !important;
    }

    .table th,
    .table td {
        white-space: nowrap;
    }

    .table .header-1 th,
    .table .header-2 th {
        position: sticky;
        top: 0;
    }

    .table .header-1 th,
    .table .header-2 th,
    .bg-td {
        background-color: #f3f3f3;
        background-image: -webkit-linear-gradient(top, #fefefe, #f3f3f3);
        background-image: -moz-linear-gradient(top, #fefefe, #f3f3f3);
    }


    .table .header-2 th {
        top: 35px;
    }

    .row-valid td {
        background: rgba(182, 255, 0, 0.38);
    }

    .row-invalid td {
        background: rgba(255, 106, 0, 0.27);
    }

    .row-invalid td.cell-invalid {
        background: rgba(230, 80, 65, 0.5);
        color: rgba(230, 80, 65, 1);
        font-weight: 600;
    }
</style>


<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-12">

            <h3 style="margin: 0;">

                <i class="fa fa-file-excel-o fa-fw"></i>
                นำเข้าไฟล์ Excel (ตรวจสอบข้อมูลก่อนบันทึก)

            </h3>
        </div>
    </div>
</div>

<div class="mat-box grey-bar">
    <a href="../product/product.php" class="link-history-btn">รายการผลิตภัณฑ์</a>
    /
    <span class="link-history-btn">นำเข้าไฟล์ Excel</span>
</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">

        <div class="col-md-2">
            <?php
            $_LEFT_MENU_ACTIVE = "IMPORT";
            include "../product/leftMenu.php";
            ?>
        </div>
        <div class="col-md-10">
            <div class="widget">
                <form method="post">
                    <textarea class="hide" name="txtImportDataToSave"><?php echo $datas; ?></textarea>
                    <div class="compare-box">
                        <table class="table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <th>ลำดับ</th>
                                <th>ชื่อหมวดหมู่ชั้นที่ 1</th>
                                <th>ชื่อหมวดหมู่ชั้นที่ 2</th>
                                <th>ชื่อหมวดหมู่ชั้นที่ 3</th>
                                <th>ชื่อสินค้า</th>
                                <th>รหัสสินค้า</th>
                                <th>MPN</th>
                                <th>Brand</th>
                                <th>ราคาสินค้า</th>
                                <th>Picture</th>
                                <th>Datasheet</th>
                                <th>รายละเอียดย่อ</th>
                                <th>รายละเอียดเต็ม</th>
                                <th>หัวข้อฟีเจอร์</th>
                                <th>รายละเอียดฟีเจอร์</th>
                            </thead>
                            <tbody>
                                <?php
                                $RequiredCols = array(1, 2, 3, 4, 7,8,9,10);
                                $validCount = 0;
                                foreach ($datasArray as $row) {
                                    $valid = true;
                                    $rowPK = "";
                                    for ($i = 0; $i < 12; $i++) {
                                        $col =  $row[$i];
                                        $name = $columnArray[$i][0];
                                        $value = trim($col);

                                        if (in_array($i, $RequiredCols) && trim($value) == "") {
                                            $valid = false;
                                        }
                                    }
                                ?>
                                    <tr class="row-<?php echo $valid ? "valid" : "invalid" ?>">
                                        <td class="hide">
                                            <input type="text" name="RowValid[]" value="<?php echo $valid ? "VALID" : "INVALID" ?>" />
                                        </td>


                                        <?php

                                        for ($i = 0; $i < 15; $i++) {
                                            $col =  $row[$i];
                                            $value = trim($col);
                                        ?>

                                            <td class="cell-<?php echo $cellValid ? "valid" : "invalid" ?>">
                                                <?php echo $value ?>
                                            </td>

                                        <?php
                                        }
                                        ?>
                                    </tr>
                                <?php

                                    $allTicketPK[$rowPK] = $rowPK;
                                    if ($valid) {
                                        $validCount++;
                                    }
                                } ?>
                            </tbody>
                        </table>
                        <script>
                            $("#count-result").html("<?php echo $matchedCount; ?>");
                        </script>
                    </div>
                    <div class="pull-right">
                        <button type="submit" name="btnSave" id="btnSave" onclick="return Validate(this);" class="btn btn-primary">
                            <i class="fa fa-save fa-fw"></i>
                            บันทึกข้อมูลลงฐานข้อมูล
                        </button>
                    </div>
                    <b>
                        <small>
                            <span class="text-danger">เปรียบเทียบข้อมูลก่อนบันทึก</span>

                            <span class="text-success">(ข้อมูลพร้อมบันทึก <span id="valid-count">0</span> / <?php echo count($datasArray) ?> รายการ)</span>
                        </small>
                    </b>
                    <br>
                    <br>
                </form>
            </div>
        </div>
    </div>

</div>



<script>
    $("#valid-count").html("<?php echo number_format($validCount, 0) ?>");

    if (parseInt("<?php echo $validCount ?>") == 0) {
        $("#btnSave").attr("disabled", true);
    }
</script>

</div>

<!-- Modal -->
<div id="modal-date-ex" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">คำแนะนำเกี่ยวกกับรูปแบบวันที่</h4>
            </div>
            <div class="modal-body">
                <p>1. วันที่ต้องอยู่ในรูปแบบ <b>DD/MM/YYYY</b> เช่น 31/01/2018 (วันที่ 31 มกราคม 2018)</p>
                <p>2. ใน Excel ช่องที่เป็นวันที่ ต้องมีประเภทของเซลล์เป็นแบบข้อความเท่านั้นจึงจะสามารถใส่วันที่ในรูปแบบดังข้อ 1 ได้ สามารถปรับเปลี่ยนได้โดยการ <b>คลิกขวาที่เซลล์และเปลี่ยนประเภทตามภาพ</b></p>
                <img src="ex_string.png" style="width:100%" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<?php include  "../footer.php"; ?>