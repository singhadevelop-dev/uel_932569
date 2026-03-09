<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include("../header.php") ?>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
<script>
    var uploadFormDataAPI = "<?php echo $GLOBALS["ROOT"] ?>/excel_upload_util/uploadAPI.php";
    var uploadFormDataSaveResultAPI = "<?php echo $GLOBALS["ROOT"] ?>/excel_upload_util/uploadAPISaveData.php";
</script>
<script src="<?php echo $GLOBALS["ROOT"] ?>/excel_upload_util/jquery.form.min.js" type="text/javascript"></script>
<script src="<?php echo $GLOBALS["ROOT"] ?>/excel_upload_util/import-excel.js?vs=2.0" type="text/javascript"></script>


<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-12">

            <h3 style="margin: 0;">

                <i class="fa fa-file-excel-o fa-fw"></i>
                นำเข้าไฟล์ข้อมูลด้วย Excel

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

    <style>
        .wg-progress-container {
            margin-top: 10px;
            height: 5px;
            background: #ddd;
        }

        .wg-progress {
            height: 5px;
            background: #1ABC9C;
            width: 0;
        }

        .bGreen[disabled] {
            opacity: 0.5;
        }

        #div-excel-result {
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 10px;
            background: #fefefe;
            overflow: auto;
            max-height: calc(100vh - 200px);
            position: relative;
        }

        #div-excel-result table {
            width: 100%;
            margin: 0;
            font-size: 12px;
        }

        #div-excel-result table tr th,
        #div-excel-result table tr td {
            white-space: nowrap;
        }

        #div-excel-result table .header-1 th {
            position: sticky;
            top: 0;
        }

        #div-excel-result table .header-2 th {
            position: sticky;
            top: 35px;
        }


        #div-excel-result table tr th {
            background: #F9F9F9;
            text-align: center;
            vertical-align: middle;
        }

        #div-excel-result table tr.row-success {
            background: rgba(164, 233, 65, 0.5);
        }

        #div-excel-result table tr.row-error {
            background: rgba(255, 158, 126, 0.5);
        }
    </style>

    <div class="row">

        <div class="col-md-2">
            <?php
            $_LEFT_MENU_ACTIVE = "IMPORT";
            include "../product/leftMenu.php";
            ?>
        </div>
        <div class="col-md-10">
            <div class="material" style="border-radius: 0 0 3px 3px">
                <div class="widget">
                    <div class="formRow">


                        <h5><b class="text-success">ขั้นตอนที่ 1</b>
                            :
                            ดาวน์โหลดไฟล์ Excel Template และทำการกรอกข้อมูล
                        </h5>

                        <hr />

                        <?php

                        //include_once "../../excel_upload_util/template.php";

                        ?>

                        <div style="margin-top: 10px; font-weight: 600;">
                            <a href="<?php echo $GLOBALS["ROOT"] ?>/excel_upload_util/Import Tracking.xlsx" class="text-primary" download="Import Tracking Form-<?php echo GetCurrentDateTimeServer() ?>.xlsx">คลิกที่นี่เพื่อดาวน์โหลดไฟล์ [Import Data Form-<?php echo GetCurrentDateTimeServer() ?>.xlsx]</a>
                        </div>


                        <br />

                        <h5><b class="text-success">ขั้นตอนที่ 2</b>
                            :
                            เมื่อกรอกข้อมูลเสร็จสิ้นแล้วให้อัพโหลดไฟล์โดยคลิกที่ปุ่มอัพโหลดไฟล์ด้านล่างนี้
                        </h5>

                        <hr />


                        <div style="margin-top: 10px;">
                            <span style="float: right; margin-top: 10px;">Upload progress : <span class="wg-progress-percent">0</span> percent.</span>
                            <input type="button" value="Upload File" onclick="GenerateFormDataV2();" class="btn btn-primary btn-sm" />
                        </div>
                        <div class="wg-progress-container">
                            <div class="wg-progress"></div>
                        </div>


                        <br />

                        <h5><b class="text-success">ขั้นตอนที่ 3</b>
                            :
                            ตรวจสอบข้อมูล
                        </h5>

                        <hr />

                        <div id="div-excel-result">


                            <div style="color: #ef5a29; padding: 20px;"><b>กรุณาทำการอัพโหลดไฟล์ก่อน</b></div>
                        </div>

                        <table class="hide" id="table-template">
                            <tr class="text-left">
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
                            </tr>
                        </table>
                        <br />

                        <h5><b class="text-success">ขั้นตอนที่ 4</b>
                            :
                            เปรียบเทียบข้อมูลก่อนบันทึกจริง
                        </h5>

                        <hr />
                        <form method="post" action="importDataCompare.php" style="margin-top: 10px;">

                            <div class="hide" style="margin-bottom: 10px;">
                                <b><u>หมายเหตุ</u></b>
                                <br />
                                <b>ระบบจะใช้ข้อมูล แถวที่พื้นหลังเป็น <u style="color: #93d03e">สีเขียว</u> เท่านั้น จะไม่ใช้งานแถวที่เป็น <u style="color: #eb7e5a">สีแดง</u>
                                </b>
                            </div>

                            <textarea id="txtImportDataToSave" class="form-control hide" name="txtImportDataToSave"></textarea>
                            <button type="submit" disabled id="btnSaveUploadData" class="btn btn-success">
                                เปรียบเทียบข้อมูล
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include  "../footer.php"; ?>