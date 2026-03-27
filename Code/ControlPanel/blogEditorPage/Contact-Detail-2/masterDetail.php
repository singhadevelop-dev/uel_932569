<?php include_once  "_config.php"; ?>
<?php //include_once  "../_master/_master_detail.php"; ?>

<?php include_once  "../_master/_master.php"; ?>

<?php 
$keyRefCode = "MASTERDETAIL-".$_COG_ITEM_CODE;

if(isset($_POST["btnSave"])){
    
    $dataOld =  SelectRow("select PortCode,PortType from portfolio where PortType='$keyRefCode' ");
    $portCode = ($dataOld !== false) ? $dataOld["PortCode"]  : GenerateNextID("portfolio","PortCode",5,"M");
    
    //Image
    $txtSubject = $_POST["txtSubject"];
    $txtYear = $_POST["txtYear"];
    $uploadFileTarget =  $GLOBALS["ROOT"]."/_content_images/".GetCurrentLang()."/".strtolower($_COG_ITEM_CODE)."/";
    $fileUploaded = $_FILES["fileUpload"];
    $hddFilePathVedio = $_POST["hddFilePathVedio"];
    $txtShortDescription = $_POST["txtShortDescription"];
    $fileUploadDetail = $_FILES["txtFileUpload"];
    $txtLinkWeb = $_POST["txtLinkWeb"];
    $txtByName = $_POST["txtByName"];
    $chkActive = !$_COG_ALLOW_MASTER_ACTIVE ? 1 : (isset($_POST["chkActive"]) ? 1 : 0);

    $cuurentDateTime = GetCurrentStringDateTimeServer();
    if(!empty($fileUploaded["name"])){
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget,$portCode);
        $fileUploadedPath = parse_url( $fileUploadedPath, PHP_URL_PATH)."?vs=".$cuurentDateTime;
    }else{
        $fileUploadedPath = $_POST["hddBackUpImage"];
    }

    $uploadFileTargetDetail =  $GLOBALS["ROOT"]."/_content_images/".GetCurrentLang()."/".strtolower($_COG_ITEM_CODE)."/fileUpload/";
    if(!empty($fileUploadDetail["name"])){
        $fileUploadedPathDetail = $uploadFileTargetDetail.UploadFile($_FILES["txtFileUpload"],$uploadFileTargetDetail,$portCode);
        $fileNameUpdate = REP_SG($fileUploadDetail["name"]);
    }else{
        $fileUploadedPathDetail = $_POST["hddBackUpFileDownload"];
        $fileNameUpdate = REP_SG($_POST["hddBackUpFileDownloadName"]);
    }

    //Image2
    $uploadFileTarget2 =  $GLOBALS["ROOT"]."/_content_images/".GetCurrentLang()."/".strtolower($_COG_ITEM_CODE)."/";
    $fileUploaded2 = $_FILES["fileUpload2"];
    if(!empty($fileUploaded2["name"])){
        $fileUploadedPath2 = $uploadFileTarget2.UploadFile($_FILES["fileUpload2"],$uploadFileTarget2,$portCode."-Image2");
        $fileUploadedPath2 = parse_url( $fileUploadedPath2, PHP_URL_PATH)."?vs=".$cuurentDateTime;
    }else{
        $fileUploadedPath2 = $_POST["hddBackUpImage2"];
    }

    //Image3
    $uploadFileTarget3 =  $GLOBALS["ROOT"]."/_content_images/".GetCurrentLang()."/".strtolower($_COG_ITEM_CODE)."/";
    $fileUploaded3 = $_FILES["fileUpload3"];
    if(!empty($fileUploaded3["name"])){
        $fileUploadedPath3 = $uploadFileTarget3.UploadFile($_FILES["fileUpload3"],$uploadFileTarget3,$portCode."-Image3");
        $fileUploadedPath3 = parse_url( $fileUploadedPath3, PHP_URL_PATH)."?vs=".$cuurentDateTime;
    }else{
        $fileUploadedPath3 = $_POST["hddBackUpImage3"];
    }

    //Video2 Local Server
    $fileUploadedVideo2 = $_FILES["fileUploadVideo"];
    if(!empty($fileUploadedVideo2["name"])){
        $fileUploadedVideoPath2 = $uploadFileTargetDetail.UploadFile($_FILES["fileUploadVideo"],$uploadFileTargetDetail,$portCode."-video2");
        $fileUploadedVideoPath2 = parse_url( $fileUploadedVideoPath2, PHP_URL_PATH)."?vs=".$cuurentDateTime;
    }else{
        $fileUploadedVideoPath2 = $_POST["hddBackUpVideo"];
    }


    $txtDetail = $_COG_ALLOW_MASTER_HTML_EDITOR ? GeneratePageFile($_POST["txtDetail"],$keyRefCode) : "";
    $txtDetail2 = $_COG_ALLOW_MASTER_HTML_EDITOR2 ? GeneratePageFile($_POST["txtDetailHTML2"],$keyRefCode."-2") : "";

    
    if($dataOld !== false)
    {
        $sqlUpdate = "update portfolio set 
         PortName = '$txtSubject'
        ,PortDetail='$txtDetail'
        ,PortHtml2='$txtDetail2'
        ,Image = '$fileUploadedPath'
        ,Image2 = '$fileUploadedPath2'
        ,Image3 = '$fileUploadedPath3'
        ,Video='$hddFilePathVedio'
        ,Video2='$fileUploadedVideoPath2'
        ,ShortDescription='$txtShortDescription'
        ,FileDownload='$fileUploadedPathDetail'
        ,FileDownloadName='$fileNameUpdate'
        ,PortDetail1='$txtLinkWeb'
        ,Year='$txtYear'
        ,ByName='$txtByName'
        ,Active=$chkActive
         where PortType='$keyRefCode' ";
    }
    else
    {
        $sqlUpdate = "insert into portfolio (PortCode,PortName,PortDetail,PortHtml2,Image,Image2,Image3,Video,FileDownload,FileDownloadName,Active,CreatedOn,CreatedBy,PortType,ShortDescription,PortDetail1,Year,ByName)
            VALUES(
                '$portCode',
                '$txtSubject',
                '$txtDetail',
                '$txtDetail2',
                '$fileUploadedPath',
                '$fileUploadedPath2',
                '$fileUploadedPath3',
                '$hddFilePathVedio',
                '$fileUploadedPathDetail',
                '$fileNameUpdate',
                '$chkActive',
                NOW(),
                '".UserService::UserCode()."',
                '$keyRefCode',
                '$txtShortDescription',
                '$txtLinkWeb',
                '$txtYear',
                '$txtByName'
            );";
    }

    ExecuteSQL($sqlUpdate);
}

function REP_SG($input){
    return str_replace("'","’",$input);
}

$sql = "select * from portfolio where PortType='$keyRefCode' limit 1";
$data = SelectRow($sql);

?>
<div class="mat-box grey-bar">
    <a href="<?php echo $_COG_ALLOW_LEFT_MENU_ITEMS ? "item.php" : "masterDetail.php"  ?>" class="link-history-btn">หน้าหลัก<?php echo $_COG_ITEM_NAME ?></a>
    <?php if($_COG_ALLOW_LEFT_MENU && $_COG_ALLOW_LEFT_MENU_ITEMS){  ?>
    /
    <a href="item.php" class="link-history-btn">รายการ<?php echo $_COG_ITEM_NAME ?></a>
    <?php } ?>
    /
    <span class="link-history-btn">จัดการข้อมูล<?php echo $_COG_ITEM_NAME ?></span>
</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row">
        <?php if($_COG_ALLOW_LEFT_MENU){ ?>
        <div class="col-md-2">
            <?php include_once  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/blogEditorPage/_master/_master_leftMenu.php"; ?>
        </div>
        <?php } ?>
        <div class="col-md-<?php echo $_COG_ALLOW_LEFT_MENU ? "10" : "12" ?>">
            <form method="post" enctype="multipart/form-data">
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
                                                        val = "https://www.youtube.com/embed/" + getUrlVars(val)["v"]; //val.split("v=")[val.split("v=").length - 1];
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
                                                        $(obj).next().val("");
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
                                                            val = "https://www.youtube.com/embed/"  + getUrlVars(val)["v"] //val.split("v=")[val.split("v=").length - 1];
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

                                                function getUrlVars(val)
                                                {
                                                    var vars = [], hash;
                                                    var hashes = val.slice(val.indexOf('?') + 1).split('&');
                                                    for(var i = 0; i < hashes.length; i++)
                                                    {
                                                        hash = hashes[i].split('=');
                                                        vars.push(hash[0]);
                                                        vars[hash[0]] = hash[1];
                                                    }
                                                    return vars;
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
                    <?php if($_COG_ALLOW_MASTER_VIDEO2){ ?>
                        <div class="col-md-6">
                            <span><b>วีดีโอ<?php echo $_COG_ITEM_NAME ?></b></span>
                            <hr style="margin-top: 5px; margin-bottom: 5px;" />
                            <div class="row panel-video">

                                <div class="panel-video-display col-xs-12 <?php echo !empty($data["Video2"]) ? "" : "hide" ?>">
                                    <div class="slide-banner image-box">
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
                                        <video  class="slide-banner video-local-server" controls=""  muted="" style="object-fit:cover;border-radius: 5px;">
                                            <source src="<?php echo $data["Video2"] ?>">
                                        </video>
                                        <i class="fa fa-pencil editer <?php echo !empty($data["Video2"]) ? "" : "hide" ?>" onclick="$(this).closest('.panel-video').find('input[type=file]').click();"></i>
                                        <i class="fa fa-remove remover <?php echo !empty($data["Video2"]) ? "" : "hide" ?>" onclick="deleteVideoLocal(this);"></i>
                                        
                                    </div>
                                </div>

                                <div class="panel-video-add col-xs-12 <?php echo empty($data["Video2"]) ? "" : "hide" ?>">
                                    <div class="slide-banner image-box slide-adder hand" onclick="$(this).closest('.panel-video').find('input[type=file]').click();" style="position: relative; background-color: #eee;">
                                        <div style="position: absolute; left: 0; right: 0; top: 75px; text-align: center;">
                                            <i class="fa fa-video fa-5x text-muted"></i>
                                        </div>
                                        <div style="position: absolute; left: 0; right: 0; bottom: 150px; text-align: center;">
                                            <small>คลิกเพื่อเพิ่มวีดีโอ</small>
                                        </div>
                                    </div>
                                </div>
                                <input class="hide" type="file" onchange="uploadBannerVideo(this);" name="fileUploadVideo" accept="video/*" />
                                <input type="hidden" name="hddBackUpVideo" value="<?php echo $data["Video2"] ?>" />

                            </div>
                            <script>
                                function uploadBannerVideo(input) {
                                    if ($(input).validateUploadVideo($(".video-local-server"))) {
                                        var target = $(input).closest(".panel-video");
                                        $(target).find('.panel-video-display').removeClass("hide");
                                        $(target).find('.editer').removeClass("hide");
                                        $(target).find('.remover').removeClass("hide");
                                        $(target).find('.panel-video-add').addClass("hide");
                                    }
                                    else
                                    {
                                        $(input).val("");
                                    }
                                }
                                function deleteVideoLocal(obj){
                                    if(AlertConfirm(obj,"Comfirm delete?")){
                                        var target = $(obj).closest(".panel-video");
                                        $(target).find('input[type=file]').val('');
                                        $(target).find('input[name=hddBackUpVideo]').val('');
                                        $(target).find(".video-local-server source").attr("src","");
                                        $(target).find('.panel-video-display').addClass("hide");
                                        $(target).find('.editer').addClass("hide");
                                        $(target).find('.remover').addClass("hide");
                                        $(target).find('.panel-video-add').removeClass("hide");
                                    }
                                }
                            </script>
                        </div>
                    <?php } ?>
                    <?php if($_COG_ALLOW_MASTER_GALLERY){ ?>
                        <div class="col-md-6">
                            <div>
                                <span><b>รูปภาพ<?php echo $_COG_ITEM_NAME ?></b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                <?php $_IMAGE_SIZE = !empty($_COG_ALLOW_MASTER_GALLERY_SIZE) ? $_COG_ALLOW_MASTER_GALLERY_SIZE : "1200x900" ?>
                                <img id="imge-preview" class="slide-banner" style="object-fit: cover;height: 300px;width: 100%;background-color: #eee;"
                                    src="<?php echo empty($data["Image"]) ? "https://ipsumimage.appspot.com/$_IMAGE_SIZE,eee" : $data["Image"] ?>"
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
                    <?php if($_COG_ALLOW_MASTER_GALLERY3){ ?>
                        <div class="col-md-6">
                            <div>
                                <span><b>รูปภาพรอง<?php echo $_COG_ITEM_NAME ?></b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                <img id="imge-preview3" class="slide-banner" style="object-fit: cover;height: 300px;width: 100%;"
                                    src="<?php echo empty($data["Image3"]) ? "https://ipsumimage.appspot.com/1200x900,eee" : $data["Image3"] ?>"
                                    class="img-responsive hand" onclick="$(this).next().click();" />
                                <input class="hide" type="file" onchange="$(this).validateUploadImage($('#imge-preview3'));"
                                    name="fileUpload3" id="fileUpload3" accept="image/*" />
                                <input type="hidden" name="hddBackUpImage3" value="<?php echo $data["Image3"] ?>" />
                                <div class="text-center">
                                    <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                
                <?php if($_COG_ALLOW_MASTER_TITLE || $_COG_ALLOW_MASTER_YEAR){ ?>
                    <div class="row">
                        <?php if($_COG_ALLOW_MASTER_TITLE){ ?>
                            <div class="col-sm-<?php echo $_COG_ALLOW_MASTER_YEAR ? "8" : "10" ?>">
                                <label>หัวข้อ<?php echo $_COG_ITEM_NAME ?></label>
                                <!-- <input type="text" placeholder="หัวข้อ<?php //echo $_COG_ITEM_NAME ?>..." name="txtSubject" id="txtSubject" value="<?php //echo $data["PortName"] ?>" class="form-control input-sm require" /> -->
                                <textarea name="txtSubject" id="txtSubject" placeholder="หัวข้อ<?php echo $_COG_ITEM_NAME ?>..." class="form-control input-sm area-box-fix require"><?php echo $data["PortName"] ?></textarea>
                            </div>
                        <?php } ?>
                        <?php if($_COG_ALLOW_MASTER_YEAR){ ?>
                            <div class="col-sm-4">
                                <label>ปี<?php echo $_COG_ITEM_NAME ?></label>
                                <input type="text" placeholder="ปี<?php echo $_COG_ITEM_NAME ?>..." name="txtYear" id="txtYear" value="<?php echo $data["Year"] ?>" class="form-control input-sm require" />
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if($_COG_ALLOW_MASTER_AUTHOR){ ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <label>ชื่อผู้เขียน (ชื่อที่ใช้แสดง)</label>
                            <input type="text" placeholder="โดย..." name="txtByName" id="txtByName" value="<?php echo  empty($data["ByName"]) ? UserService::UserFullName() : $data["ByName"] ?>" class="form-control input-sm require" />
                        </div>
                    </div>
                <?php } ?>
                
                <?php if($_COG_ALLOW_MASTER_SHORT_DESCRIPTION){ ?>
                    <div class="row">
                        <div class="col-sm-10">
                            <span><b>รายละเอียดแบบย่อ<?php echo $_COG_ITEM_NAME ?></b></span>
                            <hr style="margin-top: 5px; margin-bottom: 5px;" />
                            <style>
                            .shortdescription-box{
                                height:150px!important;
                            }
                            </style>
                            <textarea name="txtShortDescription" id="txtShortDescription" class="form-control input-sm area-box-fix shortdescription-box require"><?php echo $data["ShortDescription"] ?></textarea>
                        </div>
                    </div>
                <?php } ?>
                <?php if($_COG_ALLOW_MASTER_FILE_DOWNLOAD){ ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <span><b>ไฟล์ให้ดาวน์โหลด</b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                <input type="file" name="txtFileUpload" value="" onchange="validateUploadFileUpload(this);" />
                                <script>
                                    function validateUploadFileUpload(obj)
                                    {
                                        var file = $(obj).get(0).files[0];
                                        var maxSize = 60000000;
                                        if (file.size > maxSize) {
                                            $(obj).val("");
                                            swal("Invalid file size", "Maximum image size is 60 MB.", "error");
                                        }
                                    }

                                </script>
                                <?php if(!empty($data["FileDownload"])){ ?>
                                <div style="margin-top:5px;">
                                    <b class="text-success">เคยอัพโหลดไฟล์แล้ว 
                                        <a target="_blank" href="<?php echo $data["FileDownload"]; ?>">
                                            <i class="fa fa-download"></i>
                                            ดาวน์โหลด</a>
                                    </b>
                                </div>
                                <?php } ?>
                                <input type="hidden" name="hddBackUpFileDownload" value="<?php echo $data["FileDownload"] ?>" />
                                <input type="hidden" name="hddBackUpFileDownloadName" value="<?php echo $data["FileDownloadName"] ?>">
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if($_COG_ALLOW_MASTER_MAPLOCATION){ ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <label>ที่อยู่บน Google map</label>
                            <input type="text" class="form-control" name="txtLatLng"
                                placeholder="https://www.google.co.th/maps/"
                                value="<?php echo $data["MapLocation"] ?>" />
                            <?php 
                            //include($GLOBALS['DOCUMENT_ROOT']."/ControlPanel/GoogleMap/location.php") 
                            ?>
                            <!-- <div class="product-location-container">
                                <div style="margin-top: 5px;" class="">
                                    <br />
                                    <span><b>ตำแหน่งบนแผนที่ (Latitude - Logitude)</b></span>
                                    <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                    <input readonly type="text" class="lat-lng form-control require input-sm" style="display:inline-block;float:left;margin-right:5px;width:200px;" value="<?php echo $data["MapLocation"] ?>" />
                                    <button type="button" class="btn btn-primary btn-sm" onclick="openSuperGridGoogleMapMap(this);">
                                        <i class="fa fa-map-marker text-danger"></i>
                                        ค้นหาตำแหน่งบนแผนที่
                                    </button>
                                    <input type="text" class="lat-lng hide" name="txtLatLng" value="<?php //echo $data["MapLocation"] ?>" />
                                </div>
                            </div> -->
                        </div>
                    </div>
                <?php } ?>
            
                <?php if($_COG_ALLOW_MASTER_LINK){ ?>
                    <div class="row">
                        <div class="col-sm-10">
                            <label>ลิ้งเว็บ</label>
                            <input type="text" placeholder="ลิ้งเว็บ..." name="txtLinkWeb" id="txtLinkWeb" value="<?php echo  $data["PortDetail1"] ?>" class="form-control input-sm" />
                        </div>
                    </div>
                <?php } ?>

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

                <?php if($_COG_ALLOW_MASTER_HTML_EDITOR2){ ?>
                    <hr style="margin-top: 5px;" />

                    <div class="row">
                        <div class="col-sm-12 summernote-container">
                            <label>รายละเอียด 2</label>
                            <?php 
                            // =============== HTML EDITOR =============== 
                            $_HTML_EDITOR_NAME = "txtDetailHTML2";
                            $_HTML_EDITOR_CONTENT_ID = $data["PortHtml2"];
                            include $GLOBALS['DOCUMENT_ROOT'].'/ControlPanel/HtmlEditor/HtmlEditor.php'; 
                            ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if($_COG_ALLOW_MASTER_ACTIVE){ ?>
                <div>
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
                    <?php if(!empty($data["PortCode"]) && $data["Active"] == 0){ ?>
                        $("#toggle-active").click();
                        <?php } ?>
                    </script>
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

    <?php include_once  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>