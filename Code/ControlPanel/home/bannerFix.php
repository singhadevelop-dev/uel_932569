<?php include  "../header.php"; ?>
<?php 
$_COG_REF_CODE = !empty($_GET['ref']) ? $_GET['ref'] : "SLIDE";
$uploadFileTarget =  $GLOBALS["ROOT"]."/_content_images/home_banner_featured/";

function GetGalleryData($_REF_CODE)
{
    $sql = "select * from gallery where RefCode = '$_REF_CODE' order by SEQ";
    $data = SelectRow($sql);
    return $data;
}

if(isset($_POST["btnUpdateDetail"])){

    $data = GetGalleryData($_COG_REF_CODE."1");
    $imageCode = $data !== false ? $data["ImageCode"] : GenerateNextID("gallery","ImageCode",10,"A");
    $txtImageName = $_POST["txtImageName"];
    $txtImageName2 = $_POST["txtImageName2"];
    $txtImageDetail = $_POST["txtImageDetail"];
    $cuurentDateTime = GetCurrentStringDateTimeServer();
    $fileUploaded = $_FILES["fileUpload"];
    if(!empty($fileUploaded["name"])){
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget,$imageCode);
        $fileUploadedPath = parse_url( $fileUploadedPath, PHP_URL_PATH)."?vs=".$cuurentDateTime;
    }else{
        $fileUploadedPath = $_POST["hddBackUpImage"];
    }
    if($data !== false)
    {
        $sqlDelete = "update gallery set
        ImageName = '".$txtImageName."'
        ,ImageName2 = '".$txtImageName2."'
        ,ImageDetail = '".$txtImageDetail."'
        ,ImagePath='$fileUploadedPath'
        where ImageCode = '".$data["ImageCode"]."'";
        ExecuteSQL($sqlDelete);
    }
    else
    {
        $sqlInsert = "insert into gallery (ImageCode,RefCode,ImagePath,ImagePath2,ImagePath3,ImageName,ImageDetail,Active,CreatedOn,CreatedBy)
        VALUES(
            '$imageCode',
            '".($_COG_REF_CODE."1")."',
            '$fileUploadedPath',
            '',
            '',
            '$txtImageName',
            '$txtImageName2',
            '$txtImageDetail',
            '1',
            NOW(),
            '".UserService::UserCode()."'
        );";
        ExecuteSQL($sqlInsert);
    }

    $data = GetGalleryData($_COG_REF_CODE."2");
    $imageCode = $data !== false ? $data["ImageCode"] : GenerateNextID("gallery","ImageCode",10,"B");
    $txtImageName = $_POST["txtImageNamex"];
    $txtImageName2 = $_POST["txtImageNamex2"];
    $txtImageDetail = $_POST["txtImageDetailx"];
    $fileUploaded2 = $_FILES["fileUpload2"];
    if(!empty($fileUploaded2["name"])){
        $fileUploadedPath2 = $uploadFileTarget.UploadFile($_FILES["fileUpload2"],$uploadFileTarget,$imageCode);
        $fileUploadedPath2 = parse_url( $fileUploadedPath2, PHP_URL_PATH)."?vs=".$cuurentDateTime;
    }else{
        $fileUploadedPath2 = $_POST["hddBackUpImage2"];
    }
    if($data !== false)
    {
        $sqlDelete = "update gallery set
        ImageName = '".$txtImageName."'
        ,ImageName2 = '".$txtImageName2."'
        ,ImageDetail = '".$txtImageDetail."'
        ,ImagePath='$fileUploadedPath2'
        where ImageCode = '".$data["ImageCode"]."'";
        ExecuteSQL($sqlDelete);
    }
    else
    {
        
        $sqlInsert = "insert into gallery (ImageCode,RefCode,ImagePath,ImagePath2,ImagePath3,ImageName,ImageName,ImageDetail,Active,CreatedOn,CreatedBy)
        VALUES(
            '$imageCode',
            '".($_COG_REF_CODE."2")."',
            '$fileUploadedPath2',
            '',
            '',
            '$txtImageName',
            '$txtImageName2',
            '$txtImageDetail',
            '1',
            NOW(),
            '".UserService::UserCode()."'
        );";
        ExecuteSQL($sqlInsert);
    }
}


?>
 <style>
    .slide-banner {
        height: 400px;
        position: relative;
    }
        .slide-banner .remover,
        .slide-banner .editer {
            position: absolute;
            right: -8px;
            top: -8px;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: #000;
            color: #fff;
            text-align: center;
            font-size: 17px;
            padding-top: 2px;
            z-index: 10;
            cursor: pointer;
            border: 1px solid #fff;
        }
            .slide-banner .remover:hover,
            .slide-banner .editer:hover {
                background: #F58512;
            }
        .slide-banner .editer {
            /*right: 20px;*/
        }
        .ui-state-item{
            cursor:pointer;
        }
        .ui-state-focus{
            outline:2px dashed orange;
            border-radius:3px;
        }
</style>
<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-9">
            <h3 style="margin: 0;"><i class="fa fa-home fa-fw"></i>
                <span class="analysis-left-menu-desc">จัดการเว็บไซต์ทั่วไป</span></h3>
        </div>
        <div class="col-sm-3" style="padding-top: 5px;">
        </div>
    </div>
</div>
<div class="mat-box grey-bar">
    <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/" class="link-history-btn">จัดการเว็บไซต์ทั่วไป</a>
    /
    <span class="link-history-btn">ตั้งค่าแบนเนอร์</span>
</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
        <div class="col-md-3">
            <?php 
                $_LEFT_MENU_ACTIVE = "$_COG_REF_CODE";
                include $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/home/leftMenu.php"; 
                ?>
        </div>
        <div class="col-md-9">

            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <?php $data =  GetGalleryData($_COG_REF_CODE."1"); ?>
                        <div>
                            <span><b>รูปภาพ 1 </b></span>
                            <hr style="margin-top: 5px; margin-bottom: 5px;" />
                            <p>
                                <?php $image_size = "660x563" ?>
                                <small class="text-danger">*ขนาดภาพที่เหมาะสมที่สุดคือ <?php echo $image_size ?> pixels</small>
                            </p>
                            <img id="imge-preview" data-size="<?php echo $image_size ?>" style="background-color: #eae8e8;" src="<?php echo empty($data["ImagePath"]) ? "../assets/images/default/$image_size.png" : $data["ImagePath"] ?>" 
                            class="img-responsive hand" onclick="$(this).next().click();"/>
                            <input class="hide" type="file" onchange="$(this).validateUploadImage($('#imge-preview'));"
                                name="fileUpload" id="fileUpload" accept="image/*" />
                            <input type="hidden" name="hddBackUpImage" value="<?php echo $data["ImagePath"] ?>" />
                            <div class="text-center">
                                <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <p>
                                    <label>คำอธิบายโดยย่อ</label>
                                    <input type="text" class="form-control input-sm" name="txtImageName" value="<?php echo $data["ImageName"] ?>" />
                                </p>
                                <p>
                                    <label>คำอธิบายเพิ่มเติม</label>
                                    <textarea style="min-height:90px;" class="form-control input-sm" name="txtImageName2"><?php echo $data["ImageName2"] ?></textarea>
                                </p>
                                <p>
                                    <label>ลิ้งเว็บ</label>
                                    <input type="text" class="form-control input-sm" name="txtImageDetail" value="<?php echo $data["ImageDetail"] ?>" />
                                </p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <?php $data =  GetGalleryData($_COG_REF_CODE."2"); ?>
                        <div>
                            <span><b>รูปภาพ 2 </b></span>
                            <hr style="margin-top: 5px; margin-bottom: 5px;" />
                            <p>
                                <?php $image_size = "660x563" ?>
                                <small class="text-danger">*ขนาดภาพที่เหมาะสมที่สุดคือ <?php echo $image_size ?> pixels</small>
                            </p>
                            <img id="imge-preview-2" data-size="<?php echo $image_size ?>" style="background-color: #eae8e8;" src="<?php echo empty($data["ImagePath"]) ? "../assets/images/default/$image_size.png" : $data["ImagePath"] ?>" 
                            class="img-responsive hand" onclick="$(this).next().click();"/>
                            <input class="hide" type="file" onchange="$(this).validateUploadImage($('#imge-preview-2'));"
                                name="fileUpload2" id="fileUpload2" accept="image/*" />
                            <input type="hidden" name="hddBackUpImage2" value="<?php echo $data["ImagePath"] ?>" />
                            <div class="text-center">
                                <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <p>
                                    <label>คำอธิบายโดยย่อ</label>
                                    <input type="text" class="form-control input-sm" name="txtImageNamex" value="<?php echo $data["ImageName"] ?>" />
                                </p>
                                <p>
                                    <label>คำอธิบายเพิ่มเติม</label>
                                    <textarea style="min-height:90px;" class="form-control input-sm" name="txtImageNamex2"><?php echo $data["ImageName2"] ?></textarea>
                                </p>
                                <p>
                                    <label>ลิ้งเว็บ</label>
                                    <input type="text" class="form-control input-sm" name="txtImageDetailx" value="<?php echo $data["ImageDetail"] ?>" />
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success" name="btnUpdateDetail">บันทึกคำอธิบาย</button>
                        <button type="button" onclick="location.reload();" class="btn btn-warning" name="btnReset">
                            <i class="fa fa-refresh"></i>
                            ยกเลิกการเปลี่ยนแปลง
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>