<?php $_COG_ITEM_CODE = "PRODUCT"; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>
<?php 

$_COG_ALLOW_MASTER_TITLE = true;
$_COG_ALLOW_MASTER_GALLERY = true;
$_COG_ALLOW_MASTER_GALLERY2 = false;
$_COG_ALLOW_MASTER_VIDEO = false;
$_COG_ALLOW_MASTER_HTML_EDITOR = false;
$_COG_ALLOW_MASTER_SHORT_DESCRIPTION = true;

$keyRefCode = "MASTERDETAIL-".$_COG_ITEM_CODE;

if(isset($_POST["btnSave"])){
    
    //Image
    $txtSubject = $_POST["txtSubject"];
    $uploadFileTarget =  $GLOBALS["ROOT"]."/_content_images/".strtolower($_COG_ITEM_CODE)."/";
    $fileUploaded = $_FILES["fileUpload"];
    $hddFilePathVedio = $_POST["hddFilePathVedio"];
    $txtShortDescription = $_POST["txtShortDescription"];
    if(!empty($fileUploaded["name"])){
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget,$portCode);
    }else{
        $fileUploadedPath = $_POST["hddBackUpImage"];
    }
    $cuurentDateTime = GetCurrentStringDateTimeServer();
    if(!empty($fileUploadedPath))
    {
        $fileUploadedPath = parse_url( $fileUploadedPath, PHP_URL_PATH)."?vs=".$cuurentDateTime;
    }

    //Image2
    $uploadFileTarget2 =  $GLOBALS["ROOT"]."/_content_images/".strtolower($_COG_ITEM_CODE)."/";
    $fileUploaded2 = $_FILES["fileUpload2"];
    if(!empty($fileUploaded2["name"])){
        $fileUploadedPath2 = $uploadFileTarget2.UploadFile($_FILES["fileUpload2"],$uploadFileTarget2,$portCode);
    }else{
        $fileUploadedPath2 = $_POST["hddBackUpImage2"];
    }
    if(!empty($fileUploadedPath2))
    {
        $fileUploadedPath2 = parse_url( $fileUploadedPath2, PHP_URL_PATH)."?vs=".$cuurentDateTime;
    }

    $txtDetail = GeneratePageFile($_POST["txtDetail"],$keyRefCode);
    $dataOld =  SelectRow("select PortType from portfolio where PortType='$keyRefCode' ");
    if($dataOld !== false)
    {
        $sqlUpdate = "update portfolio set 
         PortName='$txtSubject'
        ,PortDetail='$txtDetail'
        ,Image = '$fileUploadedPath'
        ,Image2 = '$fileUploadedPath2'
        ,Video='$hddFilePathVedio'
        ,ShortDescription='$txtShortDescription'
         where PortType='$keyRefCode' ";
    }
    else
    {
        
        $portCode = GenerateNextID("portfolio","PortCode",5,"M");

        $sqlUpdate = "insert into portfolio (PortCode,PortName,PortDetail,Image,Image2,Video,Active,CreatedOn,CreatedBy,PortType,ShortDescription)
            VALUES(
                '$portCode',
                '$txtSubject',
                '$txtDetail',
                '$fileUploadedPath',
                '$fileUploadedPath2',
                '$hddFilePathVedio',
                '1',
                NOW(),
                '".UserService::UserCode()."',
                '$keyRefCode',
                '$txtShortDescription'
            );";
    }

    ExecuteSQL($sqlUpdate);
}

$sql = "select * from portfolio where PortType='$keyRefCode' limit 1";
$data = SelectRow($sql);

?>
<div class="mat-box grey-bar">
    <a href="product.php" class="link-history-btn">หน้าหลัก<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">รายละเอียดของ<?php echo $_COG_ITEM_NAME ?></span>
</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row">
        <?php if($_COG_ALLOW_LEFT_MENU){ ?>
        <div class="col-md-2">
            <?php
              $_LEFT_MENU_ACTIVE = "MASTERDETAIL";
              include "leftMenu.php"; 
             ?>
        </div>
        <?php } ?>
        <div class="col-md-<?php echo $_COG_ALLOW_LEFT_MENU ? "10" : "12" ?>">
            <form method="post" enctype="multipart/form-data">
                <?php if($_COG_ALLOW_MASTER_TITLE){ ?>
                    <div class="row">
                        <div class="col-sm-10">
                            <label>หัวข้อ<?php echo $_COG_ITEM_NAME ?></label>
                            <input type="text" placeholder="หัวข้อ<?php echo $_COG_ITEM_NAME ?>..." name="txtSubject" id="txtSubject" value="<?php echo $data["PortName"] ?>" class="form-control input-sm require" />
                        </div>
                    </div>
                <?php } ?>

                <div class="row">
                    <?php if($_COG_ALLOW_MASTER_VIDEO){ ?>
                        <div class="col-md-6">
                            <div>
                                <a href="javascript:;" class="pull-right" onclick="$('#modal-howto').modal('show');">
                                    <i class="fa fa-search"></i>
                                    ดูวิธีการหาลิงค์ยูทูป</a>
                                <span><b>วีดีโอ<?php echo $_COG_ITEM_NAME ?></b></span>
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

                                                <div class="panel-video-display col-xs-12 <?php echo !empty($data["Video"]) ? "" : "hide" ?>">
                                                    <div class="slide-banner image-box">
                                                        <iframe class="iframe-video-diaplay" style="width:100%;height:100%;background:#000" src="<?php echo $data["Video"] ?>"></iframe>
                                                        <i class="fa fa-trash remover" onclick="$(this).next().click();"></i>
                                                        <input type="button" onclick="confirmDeleteVedio(this);" class="btn-delete hide" name="btnDelete" value="" />
                                                        <input type="hidden" name="hddFilePathVedio" value="<?php echo $data["Video"] ?>" />
                                                    </div>
                                                </div>
                                                
                                                <div class="panel-video-add col-xs-12 <?php echo empty($data["Video"]) ? "" : "hide" ?>">
                                                    
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
                                                                <img src="../../video/assets/how-1.png" style="width:100%" />
                                                            </p>
                                                            <p>
                                                                3. คัดลอก URL ของวีดีโอ
                                                            </p>
                                                            <p>
                                                                <img src="../../video/assets/how-2.png" style="width:100%" />
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
                                                    <div class="modal-content">
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
                                                                            <input type="text" placeholder="URL Youtube" class="form-control input-sm require" name="txtImagePathVideo" value="<?php echo $data["Video"] ?>" />
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
                                                            <span onclick="onchangeVideoDiaplayForSave(this);" class="btn btn-success">บันทึก</span>
                                                            <!-- <button type="submit" onclick="return Validate(this,$('#modal-insert'));" class="btn btn-success" value="VIDEO" name="btnUpload">บันทึก</button> -->
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if($_COG_ALLOW_MASTER_GALLERY){ ?>
                        <div class="col-md-6">
                            <div>
                                <span><b>รูปหลัก</b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                <img id="imge-preview" class="slide-banner" style="object-fit: cover;height: 300px;width: 100%;"
                                    src="<?php echo empty($data["Image"]) ? "https://ipsumimage.appspot.com/1200x900,eee" : $data["Image"] ?>"
                                    class="img-responsive hand" onclick="$(this).next().click();" />
                                <input class="hide" type="file" onchange="$(this).validateUploadImage($('#imge-preview'));"
                                    name="fileUpload" id="fileUpload" accept="image/*" />
                                <input type="hidden" name="hddBackUpImage" value="<?php echo $data["Image"] ?>" />
                                <div class="text-center">
                                    <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if($_COG_ALLOW_MASTER_GALLERY2){ ?>
                        <div class="col-md-6">
                            <div>
                                <span><b>รูปภาพรอง<?php echo $_COG_ITEM_NAME ?></b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                <img id="imge-preview2" class="slide-banner" style="object-fit: cover;height: 300px;width: 100%;"
                                    src="<?php echo empty($data["Image2"]) ? "https://ipsumimage.appspot.com/1200x900,eee" : $data["Image2"] ?>"
                                    class="img-responsive hand" onclick="$(this).next().click();" />
                                <input class="hide" type="file" onchange="$(this).validateUploadImage($('#imge-preview2'));"
                                    name="fileUpload2" id="fileUpload2" accept="image/*" />
                                <input type="hidden" name="hddBackUpImage2" value="<?php echo $data["Image2"] ?>" />
                                <div class="text-center">
                                    <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if($_COG_ALLOW_MASTER_SHORT_DESCRIPTION){ ?>
                        <div class="col-sm-12">
                            <span><b>รายละเอียดแบบย่อ</b></span>
                            <hr style="margin-top: 5px; margin-bottom: 5px;" />
                            <style>
                            .shortdescription-box{
                                height:150px!important;
                            }
                            </style>
                            <textarea name="txtShortDescription" id="txtShortDescription" class="form-control input-sm area-box-fix shortdescription-box"><?php echo $data["ShortDescription"] ?></textarea>
                        </div>
                    <?php } ?>
                </div>
            
                <?php if($_COG_ALLOW_MASTER_HTML_EDITOR){ ?>
                <hr style="margin-top: 5px;" />
                <div class="row">
                    <div class="col-sm-12 summernote-container">
                        <label>รายละเอียด</label>
                        <?php 
                        // =============== HTML EDITOR =============== 
                        $_HTML_EDITOR_NAME = "txtDetail";
                        $_HTML_EDITOR_CONTENT_ID = $data["PortDetail"];
                        include $GLOBALS['DOCUMENT_ROOT'].'/ControlPanel/HtmlEditor/HtmlEditor.php'; 
                        ?>
                    </div>
                </div>
               
                <?php } ?>

                <hr />
                <button type="submit" class="btn btn-success" onclick="return Validate(this);"
                    name="btnSave">
                    <i class="fa fa-save"></i>
                    บันทึกการเปลี่ยนแปลง
                </button>
                <button type="button" onclick="location.reload();" class="btn btn-warning" name="btnReset">
                    <i class="fa fa-refresh"></i>
                    ยกเลิกการเปลี่ยนแปลง
                </button>
            </form>
        </div>
    </div>

    <?php include  "../footer.php"; ?>