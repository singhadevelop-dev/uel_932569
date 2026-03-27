<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>
<?php $IsCatImg = true; ?>
<?php $IsCatIcon = true; ?>
<link rel="stylesheet" type="text/css" href="../../vendor/fontawesome-free/css/all.min.css">
<link rel="stylesheet" type="text/css" href="../../vendor/animate/animate.min.css">

<?php

if (isset($_POST["btnSave"])) {

    $txtSubject = $_POST["txtSubject"];
    $txtSubSubject = $_POST["txtSubSubject"];
    $txtDetail = $_POST["txtDetail"];
    $hddBackUpIcon = $_POST["hddBackUpIcon"];
    $chkActive = isset($_POST["chkActive"]) ? 1 : 0;
    $chkReady2Wear = isset($_POST["chkReady2Wear"]) ? 1 : 0;
    $chkAccessories = isset($_POST["chkAccessories"]) ? 1 : 0;

    $uploadFileTarget =  $GLOBALS["ROOT"] . "/_content_images/" . GetCurrentLang() . "/product_category/";
    $fileUploaded = $_FILES["fileUpload"];
    $fileUploaded2 = $_FILES["fileUpload2"];

    if (!empty($fileUploaded["name"])) {
        $fileUploadedPath = $uploadFileTarget . UploadFile($_FILES["fileUpload"], $uploadFileTarget);
    } else {
        $fileUploadedPath = $_POST["hddBackUpImage"];
    }

    if (!empty($fileUploaded2["name"])) {
        $fileUploadedPath2 = $uploadFileTarget . UploadFile($_FILES["fileUpload2"], $uploadFileTarget);
    } else {
        $fileUploadedPath2 = $_POST["hddBackUpImage2"];
    }

    $sql = "";
    if (empty($_GET["ref"])) {
        $genID = GenerateNextID("product_category", "CategoryCode", 5, "C");
        $sql = "insert into product_category (CategoryCode,CategoryName,CategoryDetail,Ready2Wear,Accessories,Active,CreatedOn,CreatedBy,CategorySubName,Image,Image2,ImageIcon,CategoryGroup)values(
                '$genID'
                ,'$txtSubject'
                ,'$txtDetail'
                ,$chkReady2Wear
                ,$chkAccessories
                ,$chkActive
                ,NOW()
                ,'" . UserService::UserCode() . "'
                ,'$txtSubSubject'
                ,'$fileUploadedPath'
                ,'$fileUploadedPath2'
                ,'$hddBackUpIcon'
                ,'PRODUCT'
            );
        ";
    } else {
        $sql = "update product_category set
                CategoryName = '$txtSubject'
                ,CategoryDetail = '$txtDetail'
                ,Ready2Wear = $chkReady2Wear
                ,Accessories = $chkAccessories
                ,Active = $chkActive
                ,UpdatedOn = NOW()
                ,UpdatedBy = '" . UserService::UserCode() . "'
                ,CategorySubName = '$txtSubSubject'
                ,Image = '$fileUploadedPath'
                ,Image2 = '$fileUploadedPath2'
                ,ImageIcon = '$hddBackUpIcon'
                where CategoryCode = '" . $_GET["ref"] . "'
        ";
    }

    ExecuteSQLTransaction($sql, "productCategory.php");
}

if (!empty($_GET["ref"])) {
    $sql = "select * from product_category where CategoryCode = '" . $_GET["ref"] . "'";
    $data = SelectRow($sql);
}
?>

<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <a href="productCategory.php" class="link-history-btn">รายการหมวดหมู่<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">จัดการหมวดหมู่<?php echo $_COG_ITEM_NAME ?></span>

</div>

<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <form method="post" id="form-data" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">


                <div class="row">
                    <div class="col-md-9">
                        <div>
                            <span><b><?php echo empty($_GET["ref"]) ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล " . $_GET["ref"] ?></b></span>
                            <hr style="margin-top: 5px;" />
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <label>ชื่อหมวดหมู่<?php echo $_COG_ITEM_NAME ?></label>
                                <input type="text" name="txtSubject" id="txtSubject" value="<?php echo $data["CategoryName"] ?>" class="form-control input-sm require" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <label>รายละเอียด / คำอธิบาย</label>
                                <textarea name="txtDetail" id="txtDetail" class="form-control input-sm"><?php echo $data["CategoryDetail"] ?></textarea>
                            </div>
                        </div>

                        <br />

                        <div class="row">
                            <div class="col-md-3 hide">
                                <b>Ready-to-wear</b>
                                <div>
                                    <i id="toggle-ready2wear" class="fa fa-toggle-on fa-3x text-success hand" onclick="toggleReady2wear(this);"></i>
                                    <input type="checkbox" name="chkReady2Wear" class="hide" checked="checked" value="" />
                                </div>
                                <script>
                                    function toggleReady2wear(obj) {
                                        $(obj).toggleClass('fa-toggle-on').toggleClass('fa-toggle-off')
                                            .toggleClass('text-success')
                                            .toggleClass('text-danger').next().click();
                                    }
                                    <?php if ($data["Ready2Wear"] == 0) { ?>
                                        $("#toggle-ready2wear").click();
                                    <?php } ?>
                                </script>
                            </div>
                            <div class="col-md-3 hide">
                                <b>Accessories</b>
                                <div>
                                    <i id="toggle-accessories" class="fa fa-toggle-on fa-3x text-success hand" onclick="toggleAccessories(this);"></i>
                                    <input type="checkbox" name="chkAccessories" class="hide" checked="checked" value="" />
                                </div>
                                <script>
                                    function toggleAccessories(obj) {
                                        $(obj).toggleClass('fa-toggle-on').toggleClass('fa-toggle-off')
                                            .toggleClass('text-success')
                                            .toggleClass('text-danger').next().click();
                                    }
                                    <?php if ($data["Accessories"] == 0) { ?>
                                        $("#toggle-accessories").click();
                                    <?php } ?>
                                </script>
                            </div>
                            <div class="col-md-3">
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

                    </div>
                    <div class="col-md-3 <?php echo $IsCatImg ? "" : "hide" ?>">
                        <div>
                            <span><b>รุปภาพหลัก</b></span>
                            <hr style="margin-top: 5px; margin-bottom: 5px;" />
                            <p>
                                <small class="text-danger">*ขนาดภาพที่เหมาะสมที่สุดคือ 380 x 225 pixels</small>
                            </p>

                            <img id="imge-preview" src="<?php echo empty($data["Image"]) ? "../assets/images/default/380x225.png" : $data["Image"] ?>"
                                class="img-responsive hand" onclick="$(this).next().click();" />


                            <input class="hide" type="file" onchange="$(this).previewImage($('#imge-preview'));"
                                name="fileUpload" id="fileUpload" accept="image/*" />

                            <input type="hidden" name="hddBackUpImage" value="<?php echo $data["Image"] ?>" />


                            <div class="text-center">
                                <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                            </div>
                        </div>

                        <?php if ($IsCatIcon) { ?>
                            <div>
                                <br>
                                <span><b>รูปภาพไอคอน</b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                <p>
                                    <small class="text-danger">*ขนาดภาพที่เหมาะสมที่สุดคือ 100 x 100 pixels</small>
                                </p>
                                <img id="imge-preview2" src="<?php echo empty($data["Image2"]) ? "https://dummyimage.com/100x100" : $data["Image2"] ?>"
                                    class="img-responsive hand" onclick="$(this).next().click();" />
                                <input class="hide" type="file" onchange="$(this).previewImage($('#imge-preview2'));"
                                    name="fileUpload2" id="fileUpload2" accept="image/*" />
                                <input type="hidden" name="hddBackUpImage2" value="<?php echo $data["Image2"] ?>" />
                                <div class="text-center">
                                    <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                                </div>
                            </div>
                        <?php } ?>


                    </div>
                </div>

                <hr />

                <div>

                    <button type="submit" name="btnSave" class="btn btn-success" onclick="return Validate(this,$('#form-data'));">
                        <i class="fa fa-save"></i>
                        บันทึก
                    </button>

                    <a href="productCategory.php" class="btn btn-danger">
                        <i class="fa fa-remove"></i>
                        ยกเลิก
                    </a>
                </div>



            </div>
        </div>
    </form>
</div>



<?php include  "../footer.php"; ?>