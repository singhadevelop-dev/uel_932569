<?php include  "../header.php"; ?>
<?php 
$_COG_REF_CODE = $_GET['ref'];
$uploadFileTarget =  $GLOBALS["ROOT"]."/_content_images/home_banner_featured/";

function GetGalleryData($_REF_CODE)
{
    $sql = "select * from gallery where RefCode = '$_REF_CODE' order by SEQ";
    $data = SelectRow($sql);
    return $data;
}

if(isset($_POST["btnDelete"])){
    $sqlDelete = "update gallery set ImagePath='' where ImageCode = '".$_POST["btnDelete"]."'";
    ExecuteSQL($sqlDelete);
    $filePath = $_POST["hddFilePath"];
    unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
}
if(isset($_POST["btnUpload"])){
    $data = GetGalleryData($_COG_REF_CODE);
    if($data !== false)
    {
        $fileUploaded = $_FILES["fileUpload"];
        if(!empty($fileUploaded["name"])){
            $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget);
            $filePath = $_POST["hddBackUpImage"];
            if(file_exists($_SERVER['DOCUMENT_ROOT'].$filePath))
            {
                unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
            }
        }else{
            $fileUploadedPath = $_POST["hddBackUpImage"];
        }

        $sqlDelete = "update gallery set
        ImagePath = '".$fileUploadedPath."'
        where ImageCode = '".$data["ImageCode"]."'";
        ExecuteSQL($sqlDelete);
    }
    else
    {
        $fileUploaded = $_FILES["fileUpload"];
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget);
        $imageCode = GenerateNextID("gallery","ImageCode",10,"G");
        $sqlInsert = "insert into gallery (ImageCode,RefCode,ImagePath,ImagePath2,Active,CreatedOn,CreatedBy)
        VALUES(
            '$imageCode',
            '$_COG_REF_CODE',
            '$fileUploadedPath',
            '',
            '1',
            NOW(),
            '".UserService::UserCode()."'
        );";
        ExecuteSQL($sqlInsert);
    }
}

//image 3
if(isset($_POST["btnDelete3"])){
    $sqlDelete = "update gallery set ImagePath3='' where ImageCode = '".$_POST["btnDelete3"]."'";
    ExecuteSQL($sqlDelete);
    $filePath = $_POST["hddFilePath3"];
    unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
}
if(isset($_POST["btnUpload3"])){
    $uploadFileTarget =  $GLOBALS["ROOT"]."/_content_images/home_banner_featured/image3/";
    $data = GetGalleryData($_COG_REF_CODE);
    if($data !== false)
    {
        $fileUploaded = $_FILES["fileUpload3"];
        if(!empty($fileUploaded["name"])){
            $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload3"],$uploadFileTarget);
            $filePath = $_POST["hddBackUpImage"];
            if(!empty($filePath) && file_exists($_SERVER['DOCUMENT_ROOT'].$filePath))
            {
                unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
            }
        }else{
            $fileUploadedPath = $_POST["hddBackUpImage"];
        }

        $sqlDelete = "update gallery set
        ImagePath3 = '".$fileUploadedPath."'
        where ImageCode = '".$data["ImageCode"]."'";
        ExecuteSQL($sqlDelete);
    }
    else
    {
        $fileUploaded = $_FILES["fileUpload3"];
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget);
        $imageCode = GenerateNextID("gallery","ImageCode",10,"G");
        $sqlInsert = "insert into gallery (ImageCode,RefCode,ImagePath,ImagePath3,Active,CreatedOn,CreatedBy)
        VALUES(
            '$imageCode',
            '$_COG_REF_CODE',
            '$fileUploadedPath',
            '',
            '1',
            NOW(),
            '".UserService::UserCode()."'
        );";
        ExecuteSQL($sqlInsert);
    }
}

//image 4
if(isset($_POST["btnDelete4"])){
    $sqlDelete = "update gallery set ImagePath4='' where ImageCode = '".$_POST["btnDelete4"]."'";
    ExecuteSQL($sqlDelete);
    $filePath = $_POST["hddFilePath4"];
    unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
}
if(isset($_POST["btnUpload4"])){
    $uploadFileTarget =  $GLOBALS["ROOT"]."/_content_images/home_banner_featured/image4/";
    $data = GetGalleryData($_COG_REF_CODE);
    if($data !== false)
    {
        $fileUploaded = $_FILES["fileUpload4"];
        if(!empty($fileUploaded["name"])){
            $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload4"],$uploadFileTarget);
            $filePath = $_POST["hddBackUpImage4"];
            if(!empty($filePath) && file_exists($_SERVER['DOCUMENT_ROOT'].$filePath))
            {
                unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
            }
        }else{
            $fileUploadedPath = $_POST["hddBackUpImage"];
        }

        $sqlDelete = "update gallery set
        ImagePath4 = '".$fileUploadedPath."'
        where ImageCode = '".$data["ImageCode"]."'";
        ExecuteSQL($sqlDelete);
    }
    else
    {
        $fileUploaded = $_FILES["fileUpload4"];
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget);
        $imageCode = GenerateNextID("gallery","ImageCode",10,"G");
        $sqlInsert = "insert into gallery (ImageCode,RefCode,ImagePath,ImagePath4,Active,CreatedOn,CreatedBy)
        VALUES(
            '$imageCode',
            '$_COG_REF_CODE',
            '$fileUploadedPath',
            '',
            '1',
            NOW(),
            '".UserService::UserCode()."'
        );";
        ExecuteSQL($sqlInsert);
    }
}

if(isset($_POST["btnDeleteVideo"])){
    $sqlDelete = "update gallery set ImagePath2='' where ImageCode = '".$_POST["btnDeleteVideo"]."'";
    ExecuteSQL($sqlDelete);
    $filePath = $_POST["hddFilePathVideo"];
    unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
}

if(isset($_POST["btnUploadVideo"])){
    $data = GetGalleryData($_COG_REF_CODE);
    if($data !== false)
    {
        $fileUploaded = $_FILES["fileUploadVideo"];
        if(!empty($fileUploaded["name"])){
            $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUploadVideo"],$uploadFileTarget);
            $filePath = $_POST["hddBackUpVideo"];
            if(!empty($filePath) && file_exists($_SERVER['DOCUMENT_ROOT'].$filePath))
            {
                unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
            }
        }else{
            $fileUploadedPath = $_POST["hddBackUpVideo"];
        }

        $sqlDelete = "update gallery set
        ImagePath2 = '".$fileUploadedPath."'
        where ImageCode = '".$data["ImageCode"]."'";
        ExecuteSQL($sqlDelete);
    }
    else
    {
        $fileUploaded = $_FILES["fileUploadVideo"];
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUploadVideo"],$uploadFileTarget);
        $imageCode = GenerateNextID("gallery","ImageCode",10,"G");
        $sqlInsert = "insert into gallery (ImageCode,RefCode,ImagePath,ImagePath2,Active,CreatedOn,CreatedBy)
        VALUES(
            '$imageCode',
            '$_COG_REF_CODE',
            '',
            '$fileUploadedPath',
            '1',
            NOW(),
            '".UserService::UserCode()."'
        );";
        ExecuteSQL($sqlInsert);
    }
}

$sql = "select * from gallery where RefCode = '$_COG_REF_CODE' order by SEQ";
$data = SelectRow($sql);

?>
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
            
            <div class="row">

                <div class="col-md-6">
                    <form method="post" enctype="multipart/form-data">
                        <div>
                            <span><b>วีดีโอ</b></span>
                            <hr style="margin-top: 5px; margin-bottom: 5px;" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        <style>
                                            .slide-banner {
                                                width: 100%;
                                                height: 300px;
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
                                                right: 20px;
                                            }
                                        </style>
                                        <div class="row panel-video">

                                            <div class="panel-video-display col-xs-12 <?php echo !empty($data["ImagePath2"]) ? "" : "hide" ?>">
                                                <div class="slide-banner image-box">
                                                    <video class="slide-banner" controls="" autoplay="" muted="" style="object-fit:cover;border-radius: 5px;">
                                                        <source src="<?php echo $data["ImagePath2"] ?>">
                                                    </video>
                                                    <?php if(!empty($data["ImagePath2"])){  ?> 
                                                        <i class="fa fa-pencil editer" onclick="$(this).closest('.panel-video').find('input[type=file]').click();"></i>
                                                        <i class="fa fa-remove remover" onclick="$(this).parent().find('input[type=submit]').click();"></i>
                                                        <form method="post">
                                                            <input type="hidden" name="hddFilePathVideo" value="<?php echo $data["ImagePath2"] ?>" />
                                                            <input type="submit" onclick="return Confirm(this, 'Are you sure you want delete ?');" class="btn-delete hide" name="btnDeleteVideo" value="<?php echo $data["ImageCode"] ?>" />
                                                        </form>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            
                                            <div class="panel-video-add col-xs-12 <?php echo empty($data["ImagePath2"]) ? "" : "hide" ?>">
                                                <div class="slide-banner image-box slide-adder hand" onclick="$(this).closest('.panel-video').find('input[type=file]').click();" style="position: relative; background-color: #eee;">
                                                    <div style="position: absolute; left: 0; right: 0; top: 75px; text-align: center;">
                                                        <i class="fa fa-video fa-5x text-muted"></i>
                                                    </div>
                                                    <div style="position: absolute; left: 0; right: 0; bottom: 150px; text-align: center;">
                                                        <small>คลิกเพื่อเพิ่มวีดีโอ</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <form method="post" enctype="multipart/form-data">
                                                <input class="hide" type="file" onchange="uploadBannerVideo(this);"
                                                    name="fileUploadVideo" id="fileUploadVideo" accept="video/*" />
                                                <input type="hidden" name="hddBackUpVideo" value="<?php echo $data["ImagePath2"] ?>" />
                                                <input type="submit" id="btn-upload-video" name="btnUploadVideo" class="hide" value="" />
                                            </form> 

                                        </div>

                                        <script>
                                            function uploadBannerVideo(input) {
                                                if ($(input).validateUploadVideo()) {
                                                    $("#btn-upload-video").click();
                                                }
                                            }
                                        </script>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                        <div>
                            <span><b>รูปภาพหลัก</b></span>
                            <hr style="margin-top: 5px; margin-bottom: 5px;" />
                            <div class="slide-banner image-box"
                                <?php if(empty($data["ImagePath"])){  ?> 
                                onclick="$(this).next().find('input[type=file]').click();"
                                <?php } ?>
                                style="background-image:url(<?php echo empty($data["ImagePath"]) ? "https://ipsumimage.appspot.com/1200x900,eee" : $data["ImagePath"] ?>);">
                                <?php if(!empty($data["ImagePath"])){  ?> 
                                    <i class="fa fa-pencil editer" onclick="$(this).parent().next().find('input[type=file]').click();"></i>
                                    <i class="fa fa-remove remover" onclick="$(this).next().find('input[type=submit]').click();"></i>
                                    <form method="post">
                                        <input type="hidden" name="hddFilePath" value="<?php echo $data["ImagePath"] ?>" />
                                        <input type="submit" onclick="return Confirm(this, 'Are you sure you want delete ?');" class="btn-delete hide" name="btnDelete" value="<?php echo $data["ImageCode"] ?>" />
                                    </form>
                                <?php } ?>
                            </div>
                            <form method="post" enctype="multipart/form-data">
                                <input class="hide" type="file" onchange="uploadBanner(this);"
                                    name="fileUpload" id="fileUpload" accept="image/*" />
                                <input type="hidden" name="hddBackUpImage" value="<?php echo $data["ImagePath"] ?>" />
                                <input type="submit" id="btn-upload" name="btnUpload" class="hide" value="" />
                                <?php if(empty($data["ImagePath"])){ ?>
                                    <div class="text-center">
                                        <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                                    </div>
                                <?php } ?>
                                <script>
                                    function uploadBanner(input) {
                                        if ($(input).validateUploadImage()) {
                                            $("#btn-upload").click();
                                        }
                                    }
                                </script>
                                </form>
                        </div>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                        <div>
                            <span><b>รูปภาพรอง 1</b></span>
                            <hr style="margin-top: 5px; margin-bottom: 5px;" />
                            <div class="slide-banner image-box"
                                <?php if(empty($data["ImagePath3"])){  ?> 
                                onclick="$(this).next().find('input[type=file]').click();"
                                <?php } ?>
                                style="background-image:url(<?php echo empty($data["ImagePath3"]) ? "https://ipsumimage.appspot.com/1200x900,eee" : $data["ImagePath3"] ?>);">
                                <?php if(!empty($data["ImagePath3"])){  ?> 
                                    <i class="fa fa-pencil editer" onclick="$(this).parent().next().find('input[type=file]').click();"></i>
                                    <i class="fa fa-remove remover" onclick="$(this).next().find('input[type=submit]').click();"></i>
                                    <form method="post">
                                        <input type="hidden" name="hddFilePath3" value="<?php echo $data["ImagePath3"] ?>" />
                                        <input type="submit" onclick="return Confirm(this, 'Are you sure you want delete ?');" class="btn-delete hide" name="btnDelete3" value="<?php echo $data["ImageCode"] ?>" />
                                    </form>
                                <?php } ?>
                            </div>
                            <form method="post" enctype="multipart/form-data">
                                <input class="hide" type="file" onchange="uploadBanner3(this);"
                                    name="fileUpload3" id="fileUpload3" accept="image/*" />
                                <input type="hidden" name="hddBackUpImage3" value="<?php echo $data["ImagePath3"] ?>" />
                                <input type="submit" id="btn-upload3" name="btnUpload3" class="hide" value="" />
                                <?php if(empty($data["ImagePath3"])){ ?>
                                    <div class="text-center">
                                        <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                                    </div>
                                <?php } ?>
                                <script>
                                    function uploadBanner3(input) {
                                        if ($(input).validateUploadImage()) {
                                            $("#btn-upload3").click();
                                        }
                                    }
                                </script>
                            </form>
                        </div>
                    
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <span><b>รูปภาพรอง 2</b></span>
                        <hr style="margin-top: 5px; margin-bottom: 5px;" />
                        <div class="slide-banner image-box"
                            <?php if(empty($data["ImagePath4"])){  ?> 
                            onclick="$(this).next().find('input[type=file]').click();"
                            <?php } ?>
                            style="background-image:url(<?php echo empty($data["ImagePath4"]) ? "https://ipsumimage.appspot.com/1200x900,eee" : $data["ImagePath4"] ?>);">
                            <?php if(!empty($data["ImagePath4"])){  ?> 
                                <i class="fa fa-pencil editer" onclick="$(this).parent().next().find('input[type=file]').click();"></i>
                                <i class="fa fa-remove remover" onclick="$(this).next().find('input[type=submit]').click();"></i>
                                <form method="post">
                                    <input type="hidden" name="hddFilePath4" value="<?php echo $data["ImagePath4"] ?>" />
                                    <input type="submit" onclick="return Confirm(this, 'Are you sure you want delete ?');" class="btn-delete hide" name="btnDelete4" value="<?php echo $data["ImageCode"] ?>" />
                                </form>
                            <?php } ?>
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            <input class="hide" type="file" onchange="uploadBanner4(this);"
                                name="fileUpload4" id="fileUpload4" accept="image/*" />
                            <input type="hidden" name="hddBackUpImage4" value="<?php echo $data["ImagePath4"] ?>" />
                            <input type="submit" id="btn-upload4" name="btnUpload4" class="hide" value="" />
                            <?php if(empty($data["ImagePath4"])){ ?>
                                <div class="text-center">
                                    <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                                </div>
                            <?php } ?>
                            <script>
                                function uploadBanner4(input) {
                                    if ($(input).validateUploadImage()) {
                                        $("#btn-upload4").click();
                                    }
                                }
                            </script>
                        </form>
                    </div>
                </div>             
            </div>
            
        </div>
    </div>
</div>

<?php include  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>