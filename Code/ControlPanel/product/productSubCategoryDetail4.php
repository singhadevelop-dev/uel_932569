<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>

<?php 

if(isset($_POST["btnSave"])){
    
    $txtSubject = $_POST["txtSubject"];
    $txtSubSubject = $_POST["txtSubSubject"];
    $txtDetail = $_POST["txtDetail"];
    $ddlBrand = $_POST["ddlBrand"];
    $ddlSubCategory = $_POST["ddlSubCategory"];
    $ddlSubCategory3 = $_POST["ddlSubCategory3"];
    $chkActive = isset($_POST["chkActive"]) ? 1 : 0;
    
    $uploadFileTarget = $GLOBALS["ROOT"]."/_content_images/product_subcategory4/";
    $fileUploaded = $_FILES["fileUpload"];
    
    if(!empty($fileUploaded["name"])){
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget);
    }else{
        $fileUploadedPath = $_POST["hddBackUpImage"];
    }
    
    $sql = "";
    if(empty($_GET["ref"])){
        $genID = GenerateNextID("product_sub_category4","SubCategoryCode4",5,"S");
        $sql = "insert into product_sub_category4 (SubCategoryCode4,SubCategoryCode3,SubCategoryCode,SubCategoryName4,SubCategoryDetail,Image,Active,CreatedOn,CreatedBy,CategoryCode) values(
                '$genID'
                ,'$ddlSubCategory3'
                ,'$ddlSubCategory'
                ,'$txtSubject'
                ,'$txtDetail'
                ,'$fileUploadedPath'
                ,$chkActive
                ,NOW()
                ,'".UserService::UserCode()."'
                ,'$ddlBrand'
            );
        ";
    }else{
        $sql = "update product_sub_category4 set
                SubCategoryName4 = '$txtSubject'
                ,SubCategoryDetail = '$txtDetail'
                ,Active = $chkActive
                ,Image = '$fileUploadedPath'
                ,UpdatedOn = NOW()
                ,UpdatedBy = '".UserService::UserCode()."'
                ,CategoryCode = '$ddlBrand'
                ,SubCategoryCode = '$ddlSubCategory'
                ,SubCategoryCode3 = '$ddlSubCategory3'
                where SubCategoryCode4 = '".$_GET["ref"]."'
        ";
    }
    
    ExecuteSQLTransaction($sql,"productSubCategory4.php");
}

if(!empty($_GET["ref"]))
{
    $sql = "select * from product_sub_category4 where SubCategoryCode4 = '".$_GET["ref"]."'";
    $data = SelectRow($sql);
}
?>


<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <a href="productSubCategory4.php" class="link-history-btn">รายการหมวดหมู่ย่อยที่ 4</a>
    /
    <span class="link-history-btn">จัดการหมวดหมู่ย่อยที่ 4</span>

</div>

<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <form method="post" id="form-data" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                

                <div class="row">
                    <div class="col-md-12">
                        <div>
                    <span><b><?php echo empty($_GET["ref"]) ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล ".$_GET["ref"] ?></b></span>
                    <hr style="margin-top: 5px;" />
                    </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label>ชื่อหมวดหมู่ย่อยที 4</label>
                                <input type="text" name="txtSubject" id="txtSubject" maxlength="200" value="<?php echo $data["SubCategoryName4"] ?>" class="form-control input-sm require" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label>หมวดหมู่</label>
                                <select name="ddlBrand" onchange="loadSubCategory(this.value);" class="form-control input-sm require">
                                    <?php echo GetDropDownListOptionWithDefaultSelectedAndCondition("product_category","CategoryCode","CategoryName","กรุณาเลือก",$data["CategoryCode"],"Active = 1 and CategoryGroup='PRODUCT' ") ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label>หมวดหมู่ย่อยที่ 2</label>
                                <select name="ddlSubCategory" id="ddlSubCategory" onchange="loadSubCategory3(this.value);" class="form-control input-sm require">
                                    <option value="">ไม่ระบุ</option>
                                </select>
                            </div>
                            <script>
                                function loadSubCategory(cateCode, setValue) {
                                    $("#ddlSubCategory").load("productSubCategoryLoadData.php?ref=" + cateCode, function () {
                                        if (setValue != undefined) {
                                            $("#ddlSubCategory").val(setValue);
                                        }
                                    });
                                }
                                <?php if(!empty($data["CategoryCode"])){ ?>

                                loadSubCategory('<?php echo $data["CategoryCode"] ?>', '<?php echo $data["SubCategoryCode"] ?>');

                                <?php } ?>
                            </script>
                            <div class="col-sm-4">
                                <label>หมวดหมู่ย่อยที่ 3</label>
                                <select name="ddlSubCategory3" id="ddlSubCategory3" class="form-control input-sm require">
                                    <option value="">ไม่ระบุ</option>
                                </select>
                            </div>
                            <script>
                                function loadSubCategory3(cateCode, setValue) {
                                    $("#ddlSubCategory3").load("productSubCategoryLoadData3.php?ref=" + cateCode, function () {
                                        if (setValue != undefined) {
                                            $("#ddlSubCategory3").val(setValue);
                                        }
                                    });
                                }
                                <?php if(!empty($data["SubCategoryCode"])){ ?>
                                loadSubCategory3('<?php echo $data["SubCategoryCode"] ?>', '<?php echo $data["SubCategoryCode3"] ?>');
                                <?php } ?>
                            </script>
                        </div>
                        

                        <div class="row">
                            <div class="col-sm-12">
                                <label>รายละเอียด / คำอธิบาย</label>
                                <textarea name="txtDetail" id="txtDetail" class="form-control input-sm"><?php echo $data["SubCategoryDetail"] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div>
                            <span><b>รูปภาพหลัก</b></span>
                            <hr style="margin-top: 5px; margin-bottom: 5px;" />
                            <p>
                                <small class="text-danger">*ขนาดภาพที่เหมาะสมที่สุดคือ 850 x 410 pixels</small>
                            </p>

                            <img id="imge-preview" src="<?php echo empty($data["Image"]) ? "https://ipsumimage.appspot.com/850x410,eee" : $data["Image"] ?>" 
                            class="img-responsive hand" onclick="$(this).next().click();"/>


                            <input class="hide" type="file" onchange="$(this).previewImage($('#imge-preview'));"
                                name="fileUpload" id="fileUpload" accept="image/*" />

                            <input type="hidden" name="hddBackUpImage" value="<?php echo $data["Image"] ?>" />


                            <div class="text-center">
                                <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
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
                            <?php if(!empty($_GET["ref"]) && $data["Active"] == 0){ ?>
                            $("#toggle-active").click();
                            <?php } ?>
                        </script>
                    </div>
                </div>

                <hr />

                <div>

                    <button type="submit" name="btnSave" class="btn btn-success" onclick="return Validate(this,$('#form-data'));">
                        <i class="fa fa-save"></i>
                        บันทึก
                    </button>

                    <a href="productSubCategory4.php" class="btn btn-danger">
                        <i class="fa fa-remove"></i>
                        ยกเลิก
                    </a>
                </div>

            </div>
        </div>
    </form>
</div>

<?php include  "../footer.php"; ?>