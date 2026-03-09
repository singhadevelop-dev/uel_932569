<?php $_COG_ITEM_CODE = 'SHOPPING'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>
<?php $IsBrandImg = false; ?>

<?php 

if(isset($_POST["btnSave"])){

    $genID = empty($_GET["ref"]) ? GenerateNextID("product_brand","BrandCode",5,"B") : $_GET["ref"];
    
    $txtSubject = $_POST["txtSubject"];
    $txtDetail = $_POST["txtDetail"];

    $txtSubject2 = $_POST["txtSubject2"];
    $txtBrandDetail2 = $_POST["txtBrandDetail2"];
    $txtBrandLink2 = $_POST["txtBrandLink2"];

    $txtSubject3 = $_POST["txtSubject3"];
    $txtBrandDetail3 = $_POST["txtBrandDetail3"];
    $txtBrandLink3 = $_POST["txtBrandLink3"];

    $chkActive = isset($_POST["chkActive"]) ? 1 : 0;
    
    $uploadFileTarget = $GLOBALS["ROOT"]."/_content_files/brand/";
    $fileUploaded = $_FILES["fileUpload"];
    if(!empty($fileUploaded["name"])){
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget,$genID);
    }else{
        $fileUploadedPath = $_POST["hddBackUpImage"];
    }

    $fileUploaded2 = $_FILES["fileUpload2"];
    if(!empty($fileUploaded2["name"])){
        $fileUploadedPath2 = $uploadFileTarget.UploadFile($_FILES["fileUpload2"],$uploadFileTarget,$genID."-2");
    }else{
        $fileUploadedPath2 = $_POST["hddBackUpImage2"];
    }

    $fileUploaded3 = $_FILES["fileUpload3"];
    if(!empty($fileUploaded3["name"])){
        $fileUploadedPath3 = $uploadFileTarget.UploadFile($_FILES["fileUpload3"],$uploadFileTarget,$genID."-3");
    }else{
        $fileUploadedPath3 = $_POST["hddBackUpImage3"];
    }
    
    $sql = "";
    if(empty($_GET["ref"])){
        //$genID = GenerateNextID("product_brand","BrandCode",5,"B");
        $sql = "insert into product_brand (BrandCode,BrandName,BrandName2,BrandName3,BrandDetail,BrandDetail2,BrandDetail3,
        Image,Image2,Image3,BrandLink2,BrandLink3,Active,CreatedOn,CreatedBy) values(
                '$genID'
                ,'$txtSubject'
                ,'$txtSubject2'
                ,'$txtSubject3'
                ,'$txtDetail'
                ,'$txtBrandDetail2'
                ,'$txtBrandDetail3'
                ,'$fileUploadedPath'
                ,'$fileUploadedPath2'
                ,'$fileUploadedPath3'
                ,'$txtBrandLink2'
                ,'$txtBrandLink3'
                ,$chkActive
                ,NOW()
                ,'".UserService::UserCode()."'
            );
        ";
    }else{
        $sql = "update product_brand set
                 BrandName = '$txtSubject'
                ,BrandName2 = '$txtSubject2'
                ,BrandName3 = '$txtSubject3'
                ,BrandDetail = '$txtDetail'
                ,BrandDetail2 = '$txtBrandDetail2'
                ,BrandDetail3 = '$txtBrandDetail3'
                ,BrandLink2 = '$txtBrandLink2'
                ,BrandLink3 = '$txtBrandLink3'
                ,Active = $chkActive
                ,Image = '$fileUploadedPath'
                ,Image2 = '$fileUploadedPath2'
                ,Image3 = '$fileUploadedPath3'
                
                ,UpdatedOn = NOW()
                ,UpdatedBy = '".UserService::UserCode()."'
                where BrandCode = '".$_GET["ref"]."'
        ";
    }
    
    ExecuteSQLTransaction($sql,"productBrand.php");
}

if(!empty($_GET["ref"]))
{
    $sql = "select * from product_brand where BrandCode = '".$_GET["ref"]."'";
    $data = SelectRow($sql);
}
?>

<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <a href="productBrand.php" class="link-history-btn">รายการยี่ห้อ<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">จัดการยี่ห้อ<?php echo $_COG_ITEM_NAME ?></span>

</div>

<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <form method="post" id="form-data" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                

                <div class="row">
                    <div class="col-md-<?php echo $IsBrandImg ? "8" : "12" ?>">
                        <div>
                            <span><b><?php echo empty($_GET["ref"]) ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล <span class='link-history-btn'>".$data["BrandName"]."</span> " ?></b></span>
                            <hr style="margin-top: 5px;" />
                        </div>

                        <div class="row">
                            <div class="col-sm-8">
                                <label>ชื่อยี่ห้อ<?php echo $_COG_ITEM_NAME ?></label>
                                <input type="text" name="txtSubject" id="txtSubject" value="<?php echo $data["BrandName"] ?>" class="form-control input-sm require" />
                            </div>
                        </div>

                        <div class="row hide">
                            <div class="col-sm-12">
                                <label>รายละเอียด / คำอธิบาย</label>
                                <textarea name="txtDetail" id="txtDetail" class="form-control input-sm"><?php echo $data["BrandDetail"] ?></textarea>
                            </div>
                        </div>

                        
                        <div class="row hide">
                            <div class="col-md-12">
                                <div>
                                    <span><b>รูปภาพที 2</b></span>
                                    <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                    <p>
                                        <small class="text-danger">*ขนาดภาพที่เหมาะสมที่สุดคือ 295 x 263 pixels</small>
                                    </p>
                                    <img id="imge-preview2" src="<?php echo empty($data["Image2"]) ? "https://ipsumimage.appspot.com/295x263,eee" : $data["Image2"] ?>" 
                                    class="img-responsive hand" onclick="$(this).next().click();"/>
                                    <input class="hide" type="file" onchange="$(this).previewImage($('#imge-preview2'));"
                                        name="fileUpload2" id="fileUpload2" accept="image/*" />

                                    <input type="hidden" name="hddBackUpImage2" value="<?php echo $data["Image2"] ?>" />
                                    <div class="text-center">
                                        <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                                    </div>
                                </div>
                                <p>
                                    <label for="">หัวข้อ 2</label>
                                    <input type="text" name="txtSubject2" value="<?php echo $data["BrandName2"] ?>" class="form-control input-sm ">
                                </p>
                                <p>
                                    <label for="">คำอธิบายแบบย่อ 2</label>
                                    <input type="text" name="txtBrandDetail2" value="<?php echo $data["BrandDetail2"] ?>" class="form-control input-sm ">
                                </p>
                                <p>
                                    <label for="">ลิ้งเว็บไซต์</label>
                                    <input type="text" name="txtBrandLink2" value="<?php echo $data["BrandLink2"] ?>" class="form-control input-sm ">
                                </p>
                            </div>
                        </div>
                        
                        <div class="row hide">
                            <div class="col-md-12">
                                <div>
                                    <span><b>รูปภาพที 3</b></span>
                                    <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                    <p>
                                        <small class="text-danger">*ขนาดภาพที่เหมาะสมที่สุดคือ 295 x 526 pixels</small>
                                    </p>

                                    <img id="imge-preview3" src="<?php echo empty($data["Image3"]) ? "https://ipsumimage.appspot.com/295x526,eee" : $data["Image3"] ?>" 
                                    class="img-responsive hand" onclick="$(this).next().click();"/>


                                    <input class="hide" type="file" onchange="$(this).previewImage($('#imge-preview3'));"
                                        name="fileUpload3" id="fileUpload3" accept="image/*" />

                                    <input type="hidden" name="hddBackUpImage3" value="<?php echo $data["Image3"] ?>" />

                                    <div class="text-center">
                                        <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                                    </div>
                                </div>
                                <p>
                                    <label for="">หัวข้อ 3</label>
                                    <input type="text" name="txtSubject3" value="<?php echo $data["BrandName3"] ?>" class="form-control input-sm ">
                                </p>
                                <p>
                                    <label for="">คำอธิบายแบบย่อ 3</label>
                                    <input type="text" name="txtBrandDetail3" value="<?php echo $data["BrandDetail3"] ?>" class="form-control input-sm ">
                                </p>
                                <p>
                                    <label for="">ลิ้งเว็บไซต์</label>
                                    <input type="text" name="txtBrandLink3" value="<?php echo $data["BrandLink3"] ?>" class="form-control input-sm ">
                                </p>
                            </div>
                        </div>

                        <br />

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
                    <div class="col-md-4 <?php echo $IsBrandImg ? "" : "hide" ?>">
                        <div>
                            <span><b>รูปภาพหลัก</b></span>
                            <hr style="margin-top: 5px; margin-bottom: 5px;" />
                            <p>
                                <small class="text-danger">*ขนาดภาพที่เหมาะสมที่สุดคือ 295 x 263 pixels</small>
                            </p>

                            <img id="imge-preview" src="<?php echo empty($data["Image"]) ? "https://ipsumimage.appspot.com/295x263,eee" : $data["Image"] ?>" 
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





                <hr />

                <div>

                    <button type="submit" name="btnSave" class="btn btn-success" onclick="return Validate(this,$('#form-data'));">
                        <i class="fa fa-save"></i>
                        บันทึก
                    </button>

                    <a href="productBrand.php" class="btn btn-danger">
                        <i class="fa fa-remove"></i>
                        ยกเลิก
                    </a>
                </div>



            </div>
        </div>
    </form>
</div>


<?php include  "../footer.php"; ?>