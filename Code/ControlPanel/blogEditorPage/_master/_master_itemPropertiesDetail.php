<?php include_once  "../_master/_master.php"; ?>

<?php 

if(isset($_POST["btnSave"])){
    
    $txtSubject = $_POST["txtSubject"];
    $txtIcon = $_POST["txtIcon"];
    $chkActive = isset($_POST["chkActive"]) ? 1 : 0;

    $uploadFileTarget = "/ControlPanel/assets/images/properties/";
    $fileUploaded = $_FILES["fileUpload"];
    if(!empty($fileUploaded["name"])){
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget);
    }else{
        $fileUploadedPath = $_POST["hddBackUpImage"];
    }
    
    $sql = "";
    if(empty($_GET["ref"])){
        $genID = GenerateNextID("product_properties","PropCode",5,"PR");
        $sql = "insert into product_properties (PropCode,PropName,PropIcon,Active,CreatedOn,CreatedBy,PropGroup,Image) values(
                '$genID'
                ,'$txtSubject'
                ,'$txtIcon'
                ,$chkActive
                ,NOW()
                ,'".UserService::UserCode()."'
                ,'$_COG_ITEM_CODE'
                ,'$fileUploadedPath'
            );
        ";
    }else{
        $sql = "update product_properties set
                PropName = '$txtSubject'
                ,PropIcon = '$txtIcon'
                ,Active = $chkActive
                ,UpdatedOn = NOW()
                ,UpdatedBy = '".UserService::UserCode()."'
                ,Image='$fileUploadedPath'
                where PropCode = '".$_GET["ref"]."'
        ";
    }
    
    ExecuteSQLTransaction($sql,"itemProperties.php");
}

if(!empty($_GET["ref"]))
{
    $sql = "select * from product_properties where PropCode = '".$_GET["ref"]."'";
    $data = SelectRow($sql);
}
?>

<div class="mat-box grey-bar">

    <a href="item.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <a href="itemProperties.php" class="link-history-btn">รายการคุณสมบัติ</a>
    /
    <span class="link-history-btn">จัดการข้อมูลคุณสมบัติ</span>



</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <form method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <span><b><?php echo empty($_GET["ref"]) ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล ".$_GET["ref"] ?></b></span>
                    <hr style="margin-top: 5px;" />
                </div>

                <div class="row">
                <div class="col-md-9">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>
                                    ชื่อคุณสมบัติ
                                </label>
                                <input type="text" name="txtSubject" id="txtSubject" value="<?php echo $data["PropName"] ?>" class="form-control input-sm require" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
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
                    </div>
                    <?php if($_COG_PROPERTIES_IMAGE){ ?>
                    <div class="col-md-3">
                        <div>
                            <span><b>รุปภาพหลัก</b></span>
                            <hr style="margin-top: 5px; margin-bottom: 5px;" />
                            <p>
                                <small class="text-danger">*ขนาดภาพที่เหมาะสมที่สุดคือ 34 x 34 pixels</small>
                            </p>
                            <img id="imge-preview" style="width:80px;height:80px;object-fit:cover;" src="<?php echo empty($data["Image"]) ? "https://ipsumimage.appspot.com/34x34,eee" : $data["Image"] ?>" 
                            class="img-responsive hand" onclick="$(this).next().click();"/>
                            <input class="hide" type="file" onchange="$(this).previewImage($('#imge-preview'));"
                                name="fileUpload" id="fileUpload" accept="image/*" />
                            <input type="hidden" name="hddBackUpImage" value="<?php echo $data["Image"] ?>" />
                            <div class="text-center">
                                <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <label class="hide">
                    เลือกไอคอน
                <b style="color: #E65041;">*</b>
                </label>
                <input type="text" id="txtIcon" name="txtIcon" value="" class="hide" />
                <style>
                    .et-examples{
                        max-height:300px;
                        overflow-y:auto;
                        margin:0;
                    }
                    .et-examples .box1 {
                        padding: 0;
                        border: 1px solid #e5e5e5;
                        font-size: 13px;
                        cursor:pointer;
                    }

                        .et-examples .box1:hover {
                            background: #eee;
                        }

                        .et-examples .box1.active {
                            border-color: #7ecf2e;
                            color: #7ecf2e;
                        }

                        .et-examples .box1.active > span {
                            border-color: #7ecf2e;
                        }

                        .et-examples .box1 > span {
                            display: inline-block;
                            margin-right: 5px;
                            min-width: 70px;
                            min-height: 70px;
                            border-right: 1px solid #f1f1f1;
                            line-height: 70px;
                            text-align: center;
                            font-size: 32px;
                        }
                </style>
                <div class="et-examples row hide">
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-mobile"></span>&nbsp;icon-mobile</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-laptop"></span>&nbsp;icon-laptop</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-desktop"></span>&nbsp;icon-desktop</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-tablet"></span>&nbsp;icon-tablet</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-phone"></span>&nbsp;icon-phone</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-document"></span>&nbsp;icon-document</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-documents"></span>&nbsp;icon-documents</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-search"></span>&nbsp;icon-search</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-clipboard"></span>&nbsp;icon-clipboard</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-newspaper"></span>&nbsp;icon-newspaper</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-notebook"></span>&nbsp;icon-notebook</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-book-open"></span>&nbsp;icon-book-open</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-browser"></span>&nbsp;icon-browser</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-calendar"></span>&nbsp;icon-calendar</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-presentation"></span>&nbsp;icon-presentation</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-picture"></span>&nbsp;icon-picture</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-pictures"></span>&nbsp;icon-pictures</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-video"></span>&nbsp;icon-video</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-camera"></span>&nbsp;icon-camera</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-printer"></span>&nbsp;icon-printer</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-toolbox"></span>&nbsp;icon-toolbox</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-briefcase"></span>&nbsp;icon-briefcase</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-wallet"></span>&nbsp;icon-wallet</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-gift"></span>&nbsp;icon-gift</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-bargraph"></span>&nbsp;icon-bargraph</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-grid"></span>&nbsp;icon-grid</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-expand"></span>&nbsp;icon-expand</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-focus"></span>&nbsp;icon-focus</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-edit"></span>&nbsp;icon-edit</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-adjustments"></span>&nbsp;icon-adjustments</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-ribbon"></span>&nbsp;icon-ribbon</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-hourglass"></span>&nbsp;icon-hourglass</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-lock"></span>&nbsp;icon-lock</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-megaphone"></span>&nbsp;icon-megaphone</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-shield"></span>&nbsp;icon-shield</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-trophy"></span>&nbsp;icon-trophy</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-flag"></span>&nbsp;icon-flag</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-map"></span>&nbsp;icon-map</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-puzzle"></span>&nbsp;icon-puzzle</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-basket"></span>&nbsp;icon-basket</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-envelope"></span>&nbsp;icon-envelope</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-streetsign"></span>&nbsp;icon-streetsign</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-telescope"></span>&nbsp;icon-telescope</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-gears"></span>&nbsp;icon-gears</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-key"></span>&nbsp;icon-key</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-paperclip"></span>&nbsp;icon-paperclip</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-attachment"></span>&nbsp;icon-attachment</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-pricetags"></span>&nbsp;icon-pricetags</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-lightbulb"></span>&nbsp;icon-lightbulb</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-layers"></span>&nbsp;icon-layers</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-pencil"></span>&nbsp;icon-pencil</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-tools"></span>&nbsp;icon-tools</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-tools-2"></span>&nbsp;icon-tools-2</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-scissors"></span>&nbsp;icon-scissors</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-paintbrush"></span>&nbsp;icon-paintbrush</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-magnifying-glass"></span>&nbsp;icon-magnifying-glass</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-circle-compass"></span>&nbsp;icon-circle-compass</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-linegraph"></span>&nbsp;icon-linegraph</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-mic"></span>&nbsp;icon-mic</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-strategy"></span>&nbsp;icon-strategy</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-beaker"></span>&nbsp;icon-beaker</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-caution"></span>&nbsp;icon-caution</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-recycle"></span>&nbsp;icon-recycle</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-anchor"></span>&nbsp;icon-anchor</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-profile-male"></span>&nbsp;icon-profile-male</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-profile-female"></span>&nbsp;icon-profile-female</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-bike"></span>&nbsp;icon-bike</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-wine"></span>&nbsp;icon-wine</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-hotairballoon"></span>&nbsp;icon-hotairballoon</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-globe"></span>&nbsp;icon-globe</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-genius"></span>&nbsp;icon-genius</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-map-pin"></span>&nbsp;icon-map-pin</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-dial"></span>&nbsp;icon-dial</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-chat"></span>&nbsp;icon-chat</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-heart"></span>&nbsp;icon-heart</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-cloud"></span>&nbsp;icon-cloud</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-upload"></span>&nbsp;icon-upload</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-download"></span>&nbsp;icon-download</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-target"></span>&nbsp;icon-target</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-hazardous"></span>&nbsp;icon-hazardous</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-piechart"></span>&nbsp;icon-piechart</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-speedometer"></span>&nbsp;icon-speedometer</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-global"></span>&nbsp;icon-global</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-compass"></span>&nbsp;icon-compass</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-lifesaver"></span>&nbsp;icon-lifesaver</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-clock"></span>&nbsp;icon-clock</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-aperture"></span>&nbsp;icon-aperture</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-quote"></span>&nbsp;icon-quote</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-scope"></span>&nbsp;icon-scope</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-alarmclock"></span>&nbsp;icon-alarmclock</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-refresh"></span>&nbsp;icon-refresh</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-happy"></span>&nbsp;icon-happy</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-sad"></span>&nbsp;icon-sad</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-facebook"></span>&nbsp;icon-facebook</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-twitter"></span>&nbsp;icon-twitter</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-googleplus"></span>&nbsp;icon-googleplus</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-rss"></span>&nbsp;icon-rss</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-tumblr"></span>&nbsp;icon-tumblr</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-linkedin"></span>&nbsp;icon-linkedin</span>
                    <span class="box1 col-xs-6 col-sm-4"><span aria-hidden="true" class="icon-dribbble"></span>&nbsp;icon-dribbble</span>

                </div>
                <script>
                    $(".et-examples .box1").click(function () {
                         $(".et-examples .box1").removeClass("active");
                         $(this).addClass("active");
                         $("#txtIcon").val($(this).find("span:first").attr("class"));
                    });
                    <?php if(!empty($_GET["ref"])){ ?>
                    $(".et-examples .box1 .<?php echo $data["PropIcon"] ?>").closest(".box1").click();
                    <?php } ?>
                </script>

                <hr />

                <div>

                    <button type="submit" name="btnSave" class="btn btn-success" onclick="return validateSave(this);">
                        <i class="fa fa-save"></i>
                        บันทึก
                    </button>

                    <a href="itemProperties.php" class="btn btn-danger">
                        <i class="fa fa-remove"></i>
                        ยกเลิก
                    </a>
                </div>


                <script>
                    function validateSave(sender) {
                        var msg = [];
                        if ($("#txtSubject").val().trim() == "") {
                            msg.push("ชื่อคุณสมบัติ");
                        }
                        //if ($("#txtIcon").val().trim() == "") {
                        //    msg.push("เลือกไอคอน");
                        //}
                        if (msg.length > 0) {
                            swal('Please fill in all required fields.', msg.join("\n").split(":").join(""), 'warning');
                            return false;
                        }
                        return Confirm(sender, "Comfirm to continue");
                    }
                </script>

            </div>
        </div>
    </form>
</div>





<?php include  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>