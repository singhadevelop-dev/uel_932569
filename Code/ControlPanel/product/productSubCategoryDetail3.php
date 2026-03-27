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
    $chkActive = isset($_POST["chkActive"]) ? 1 : 0;
    
    $uploadFileTarget = $GLOBALS["ROOT"]."/_content_images/product_subcategory3/";
    $fileUploaded = $_FILES["fileUpload"];
    
    if(!empty($fileUploaded["name"])){
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget);
    }else{
        $fileUploadedPath = $_POST["hddBackUpImage"];
    }
    
    $sql = "";
    if(empty($_GET["ref"])){
        $genID = GenerateNextID("product_sub_category3","SubCategoryCode3",5,"S");
        $sql = "insert into product_sub_category3 (SubCategoryCode3,SubCategoryCode,SubCategoryName3,SubCategoryDetail,Image,Active,CreatedOn,CreatedBy,CategoryCode) values(
                '$genID'
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
        $sql = "update product_sub_category3 set
                SubCategoryName3 = '$txtSubject'
                ,SubCategoryDetail = '$txtDetail'
                ,Active = $chkActive
                ,Image = '$fileUploadedPath'
                ,UpdatedOn = NOW()
                ,UpdatedBy = '".UserService::UserCode()."'
                ,CategoryCode = '$ddlBrand'
                ,SubCategoryCode = '$ddlSubCategory'
                where SubCategoryCode3 = '".$_GET["ref"]."'
        ";
    }
    
    ExecuteSQLTransaction($sql,"productSubCategory3.php");
}

if(!empty($_GET["ref"]))
{
    $sql = "select * from product_sub_category3 where SubCategoryCode3 = '".$_GET["ref"]."'";
    $data = SelectRow($sql);
}
?>


<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <a href="productSubCategory3.php" class="link-history-btn">รายการหมวดหมู่ย่อยที่ 3</a>
    /
    <span class="link-history-btn">จัดการหมวดหมู่ย่อยที่ 3</span>

</div>

<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <form method="post" id="form-data" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                

                <div class="row">
                    <div class="col-md-9">
                        <div>
                    <span><b><?php echo empty($_GET["ref"]) ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล ".$_GET["ref"] ?></b></span>
                    <hr style="margin-top: 5px;" />
                    </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label>ชื่อหมวดหมู่ย่อยที 3</label>
                                <input type="text" name="txtSubject" id="txtSubject" value="<?php echo $data["SubCategoryName3"] ?>" class="form-control input-sm require" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>หมวดหมู่</label>
                                <select name="ddlBrand" onchange="loadSubCategory(this.value);" class="form-control input-sm require">
                                    <?php echo GetDropDownListOptionWithDefaultSelectedAndCondition("product_category","CategoryCode","CategoryName","กรุณาเลือก",$data["CategoryCode"],"Active = 1 and CategoryGroup='PRODUCT' ") ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label>หมวดหมู่ย่อยที่ 2</label>
                                <select name="ddlSubCategory" id="ddlSubCategory" class="form-control input-sm require">
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
                        </div>
                        <div class="row hide">
                            <div class="col-sm-12">
                                <label>รายละเอียด / คำอธิบาย</label>
                                <textarea name="txtDetail" id="txtDetail" class="form-control input-sm"><?php echo $data["SubCategoryDetail"] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 hide">
                        <div>
                            <span><b>รูปภาพหลัก</b></span>
                            <hr style="margin-top: 5px; margin-bottom: 5px;" />
                            <p>
                                <small class="text-danger">*ขนาดภาพที่เหมาะสมที่สุดคือ 558 x 446 pixels</small>
                            </p>

                            <img id="imge-preview" src="<?php echo empty($data["Image"]) ? "https://ipsumimage.appspot.com/558x446,eee" : $data["Image"] ?>" 
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

                    <a href="productSubCategory3.php" class="btn btn-danger">
                        <i class="fa fa-remove"></i>
                        ยกเลิก
                    </a>
                </div>

            </div>
        </div>
    </form>
</div>

<?php include  "../footer.php"; ?>