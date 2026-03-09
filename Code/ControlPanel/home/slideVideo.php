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

//video
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
            if(file_exists($_SERVER['DOCUMENT_ROOT'].$filePath))
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
        $sqlInsert = "insert into gallery (ImageCode,RefCode,ImagePath,ImagePath2,ImagePath3,Active,CreatedOn,CreatedBy)
        VALUES(
            '$imageCode',
            '$_COG_REF_CODE',
            '',
            '$fileUploadedPath',
            '',
            '1',
            NOW(),
            '".UserService::UserCode()."'
        );";
        ExecuteSQL($sqlInsert);
    }
}

//youtube
if(isset($_POST["btnDeleteVideoYoutube"])){
    $sqlDelete = "update gallery set ImagePath3='' where ImageCode = '".$_POST["btnDeleteVideoYoutube"]."'";
    ExecuteSQL($sqlDelete);
}

if(isset($_POST["btnUploadVideoYoutube"])){
    $data = GetGalleryData($_COG_REF_CODE);
    if($data !== false)
    {
        $fileUploadedPath = $_POST["txtImagePathVideo"];

        $sqlDelete = "update gallery set
        ImagePath3 = '".$fileUploadedPath."'
        where ImageCode = '".$data["ImageCode"]."'";
        ExecuteSQL($sqlDelete);
    }
    else
    {
        $fileUploadedPath = $_POST["txtImagePathVideo"];
        $imageCode = GenerateNextID("gallery","ImageCode",10,"G");
        $sqlInsert = "insert into gallery (ImageCode,RefCode,ImagePath,ImagePath2,ImagePath3,Active,CreatedOn,CreatedBy)
        VALUES(
            '$imageCode',
            '$_COG_REF_CODE',
            '',
            '',
            '$fileUploadedPath',
            '1',
            NOW(),
            '".UserService::UserCode()."'
        );";
        ExecuteSQL($sqlInsert);
    }
}

if(isset($_POST["btnUpdateDetail"])){
    $data = GetGalleryData($_COG_REF_CODE);
    if($data !== false)
    {
        $txtImageName = $_POST["txtImageName"];
        $txtImageDetail = $_POST["txtImageDetail"];

        $sqlDelete = "update gallery set
        ImageName = '".$txtImageName."'
        ,ImageDetail = '".$txtImageDetail."'
        where ImageCode = '".$data["ImageCode"]."'";
        ExecuteSQL($sqlDelete);
    }
    else
    {
        $imageCode = GenerateNextID("gallery","ImageCode",10,"G");
        $sqlInsert = "insert into gallery (ImageCode,RefCode,ImagePath,ImagePath2,ImagePath3,ImageName,ImageDetail,Active,CreatedOn,CreatedBy)
        VALUES(
            '$imageCode',
            '$_COG_REF_CODE',
            '',
            '',
            '',
            '$txtImageName',
            '$txtImageDetail',
            '1',
            NOW(),
            '".UserService::UserCode()."'
        );";
        ExecuteSQL($sqlInsert);
    }
}


$data =  GetGalleryData($_COG_REF_CODE);

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
                <div class="col-md-6 hide">
                   
                        <div>
                            <a href="javascript:;" class="pull-right" onclick="$('#modal-howto').modal('show');">
                                    <i class="fa fa-search"></i>
                                    ดูวิธีการหาลิงค์ยูทูป
                            </a>
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

                                            <div class="panel-video-display col-xs-12 <?php echo !empty($data["ImagePath3"]) ? "" : "hide" ?>">
                                                <div class="slide-banner image-box">
                                                <iframe class="iframe-video-diaplay" style="width:100%;height:100%;background:#000" src="<?php echo $data["ImagePath3"] ?>"></iframe>
                                                    <?php if(!empty($data["ImagePath3"])){  ?> 
                                                        <i class="fa fa-pencil editer" onclick="openModalInsert();"></i>
                                                        <i class="fa fa-remove remover" onclick="$(this).parent().find('input[type=submit]').click();"></i>
                                                        <form method="post">
                                                            <input type="hidden" name="hddFilePathVideo" value="<?php echo $data["ImagePath3"] ?>" />
                                                            <input type="submit" onclick="return Confirm(this, 'Are you sure you want delete ?');" class="btn-delete hide" name="btnDeleteVideoYoutube" value="<?php echo $data["ImageCode"] ?>" />
                                                        </form>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            
                                            <div class="panel-video-add col-xs-12 <?php echo empty($data["ImagePath3"]) ? "" : "hide" ?>">
                                                <div class="slide-banner image-box slide-adder hand" onclick="openModalInsert();" style="position: relative; background-color: #eee;">
                                                    <div style="position: absolute; left: 0; right: 0; top: 75px; text-align: center;">
                                                        <i class="fa fa-video fa-5x text-muted"></i>
                                                    </div>
                                                    <div style="position: absolute; left: 0; right: 0; bottom: 150px; text-align: center;">
                                                        <small>คลิกเพื่อเพิ่มวีดีโอ</small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Modal -->
                        <div id="modal-howto" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">วิธีการหาลิงค์ยูทูป</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>1. ไปที่ <a target="_blank" href="https://www.youtube.com">https://www.youtube.com</a></p>
                                        <p>
                                            2. ค้นหาและคลิกเพื่อดูวีดีโอที่คุณต้องการเพิ่ม เช่น
                                        </p>
                                        <p>
                                            <img src="../video/assets/how-1.png" style="width:100%" />
                                        </p>
                                        <p>
                                            3. คัดลอก URL ของวีดีโอ
                                        </p>
                                        <p>
                                            <img src="../video/assets/how-2.png" style="width:100%" />
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            function openModalInsert() {
                                $("#modal-insert").modal("show");
                            }

                            function onchangeVideoInsert(obj) {
                                var val = $(obj).prev().val();
                                if (val.toLowerCase().match("youtube.com") && val.toLowerCase().match("v=")) {
                                    val = "https://www.youtube.com/embed/" + val.split("v=")[val.split("v=").length - 1];
                                } else if (val.toLowerCase().match("youtu.be")) {
                                    val = "https://www.youtube.com/embed/" + val.split("/")[val.split("/").length - 1];
                                }
                                $(obj).prev().val(val);
                                var frame = $(obj).closest(".modal").find(".iframe-video");
                                frame.prop("src", val);
                            }

                            function confirmDeleteVedio(obj)
                            {
                                if(Confirm(obj, 'Are you sure you want delete ?'))
                                {
                                    var frame = $(obj).closest(".modal").find(".iframe-video");
                                    frame.prop("src", "");
                                    $(obj).prev().val("");
                                    //$("[name='txtImagePathVideo']").val("");
                                    var panelVideo = $(obj).closest('.panel-video');
                                    $(panelVideo).find('.panel-video-display').addClass('hide');
                                    $(panelVideo).find('.panel-video-add').removeClass('hide');
                                    
                                }
                            }

                            function onchangeVideoDiaplayForSave(obj) {
                                if($("[name='txtImagePathVideo']").val().trim() != "")
                                {
                                    var val = $(obj).closest('.modal-dialog').find("[name='txtImagePathVideo']").val();
                                    if (val.toLowerCase().match("youtube.com") && val.toLowerCase().match("v=")) {
                                        val = "https://www.youtube.com/embed/" + val.split("v=")[val.split("v=").length - 1];
                                    } else if (val.toLowerCase().match("youtu.be")) {
                                        val = "https://www.youtube.com/embed/" + val.split("/")[val.split("/").length - 1];
                                    }
                                    var frame = $(".iframe-video-diaplay");
                                    $(frame).closest('.slide-banner').find('[name="hddFilePathVedio"]').val(val);
                                    frame.prop("src", val);
                                    var panelVideo = $(frame).closest('.panel-video');
                                    $(panelVideo).find('.panel-video-display').removeClass('hide');
                                    $(panelVideo).find('.panel-video-add').addClass('hide');
                                    $("#modal-insert").modal("hide");

                                }
                            }

                        </script>
                        <!-- Modal -->
                        <div id="modal-insert" class="modal fade" role="dialog">
                            <div class="modal-dialog  modal-lg">
                                <!-- Modal content-->
                                <form method="post" class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">เพิ่มลิงค์ของวีดีโอ</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>
                                                    <label>วีดีโอ</label>
                                                    <iframe class="iframe-video" style="width:100%;height:280px;background:#000"></iframe>
                                                </p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p>
                                                    <label>URL Youtube</label>
                                                    <div class="input-group">
                                                        <input type="text" placeholder="URL Youtube" class="form-control input-sm require" name="txtImagePathVideo" value="<?php echo $data["ImagePath3"] ?>" />
                                                        <span class="input-group-addon hand" onclick="onchangeVideoInsert(this);">
                                                            <i class="fa fa-refresh"></i>
                                                        </span>
                                                    </div>
                                                </p>
                                                <p>
                                                    <b class="text-danger">
                                                        ** เมื่อกรอก URL แล้วกดปุ่ม <i class="fa fa-refresh"></i> หาก URL ถูกต้องวีดีโอของคุณจะปรากฏในด้านซ้าย
                                                    </b>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- <span onclick="onchangeVideoDiaplayForSave(this);" class="btn btn-success">บันทึก</span> -->
                                        <button type="submit" onclick="return Validate(this,$('#modal-insert'));" class="btn btn-success" value="VIDEO" name="btnUploadVideoYoutube">บันทึก</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
                <div class="col-md-6 hide">
                    
                        <div>
                            <span><b>วีดีโอพื้นหลัง</b></span>
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
                                                    <video class="slide-banner" autoplay="" loop="" muted="" style="object-fit:cover;border-radius: 5px;">
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
            </div>
            <form method="post">
                <div class="row hide">
                    <div class="col-sm-12 col-lg-12">
                        <p>
                            <label>คำอธิบายโดยย่อ</label>
                            <input type="text" class="form-control input-sm" name="txtImageName" value="<?php echo $data["ImageName"] ?>" />
                        </p>
                        <p>
                            <label>คำอธิบายเพิ่มเติม</label>
                            <textarea style="min-height:90px;" class="form-control input-sm" name="txtImageDetail"><?php echo $data["ImageDetail"] ?></textarea>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" value="<?php echo $data["ImageCode"] ?>" class="btn btn-success" name="btnUpdateDetail">บันทึกคำอธิบาย</button>
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