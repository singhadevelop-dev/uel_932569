<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>
<link rel="stylesheet" type="text/css" href="../../vendor/fontawesome-free/css/all.min.css">
<link rel="stylesheet" type="text/css" href="../../vendor/animate/animate.min.css"> 
<?php 

if(isset($_POST["btnSave"])){
    
    $txtSubject = $_POST["txtSubject"];
    $txtShortDescription = $_POST["txtShortDescription"];
    $txtIcon = $_POST["hddBackUpIcon"];
    $chkActive = isset($_POST["chkActive"]) ? 1 : 0;
    
    $sql = "";
    if(empty($_GET["ref"])){
        $genID = GenerateNextID("product_properties","PropCode",5,"PR");
        $sql = "insert into product_properties (PropCode,PropName,PropIcon,Active,ShortDescription,CreatedOn,CreatedBy,PropGroup) values(
                '$genID'
                ,'$txtSubject'
                ,'$txtIcon'
                ,$chkActive
                ,'". REP_SG_GLOBAL($txtShortDescription) ."'
                ,NOW()
                ,'".UserService::UserCode()."'
                ,'$_COG_ITEM_CODE'
            );
        ";
    }else{
        $sql = "update product_properties set
                PropName = '$txtSubject'
                ,PropIcon = '$txtIcon'
                ,Active = $chkActive
                ,ShortDescription='". REP_SG_GLOBAL($txtShortDescription) ."'
                ,UpdatedOn = NOW()
                ,UpdatedBy = '".UserService::UserCode()."'
                ,PropGroup='$_COG_ITEM_CODE'
                where PropCode = '".$_GET["ref"]."'
        ";
    }
    
    ExecuteSQLTransaction($sql,"productProperties.php");
}

if(!empty($_GET["ref"]))
{
    $sql = "select * from product_properties where PropCode = '".$_GET["ref"]."' and PropGroup='$_COG_ITEM_CODE' ";
    $data = SelectRow($sql);
}
?>

<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <a href="productProperties.php" class="link-history-btn">รายการคุณสมบัติ</a>
    /
    <span class="link-history-btn">จัดการข้อมูลคุณสมบัติ</span>



</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <form method="post">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <span><b><?php echo empty($_GET["ref"]) ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล ".$_GET["ref"] ?></b></span>
                    <hr style="margin-top: 5px;" />
                </div>

                <div class="row">
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-md-12">
                                <label>ชื่อคุณสมบัติ</label>
                                <input type="text" name="txtSubject" id="txtSubject" value="<?php echo $data["PropName"] ?>" class="form-control input-sm require" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>รายละเอียดโดยย่อ</label>
                                <textarea name="txtShortDescription" id="txtShortDescription" rows="3"  class="form-control input-sm"><?php echo $data["ShortDescription"] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div>
                            <div class="text-center"><b>ไอคอนหลัก</b></span>
                            <div class="service-item-box icon-effect-1 icon-effect-1a text-center">
                                <style>
                                    .icon-effect-1 .hi-icon{
                                        border-color: #cc0617;
                                        background-color: transparent;
                                        border: 2px solid #cc0617;
                                        -webkit-transition: background 0.2s, color 0.2s;
                                        -moz-transition: background 0.2s, color 0.2s;
                                        -ms-transition: background 0.2s, color 0.2s;
                                        -o-transition: background 0.2s, color 0.2s;
                                        transition: background 0.2s, color 0.2s;
                                    }
                                    .service-item-box i {
                                        /* display: block; */
                                        font-size: 24px;
                                        line-height: 70px;
                                        color: #fff;
                                    }
                                    .hi-icon {
                                        display: inline-block;
                                        font-size: 0px;
                                        cursor: pointer;
                                        width: 70px;
                                        height: 70px;
                                        -webkit-border-radius: 50%;
                                        border-radius: 50%;
                                        text-align: center;
                                        position: relative;
                                        z-index: 1;
                                        color: #fff;
                                    }

                                    .icon {
                                        font-family: Stroke-Gap-Icons;
                                        speak: none;
                                        font-style: normal;
                                        font-weight: 400;
                                        font-variant: normal;
                                        text-transform: none;
                                        line-height: 1;
                                        -webkit-font-smoothing: antialiased;
                                        -moz-osx-font-smoothing: grayscale;
                                    }

                                    .icon-effect-1 .hi-icon:hover {
                                        background: #111111;
                                        color: #fff;
                                        border-color: transparent;
                                    }

                                    .icon-effect-1 .hi-icon:hover:after {
                                        -webkit-transform: scale(1);
                                        -moz-transform: scale(1);
                                        -ms-transform: scale(1);
                                        -o-transform: scale(1);
                                        transform: scale(1);
                                        opacity: 1;
                                    }

                                    .icon-effect-1 .hi-icon:after {
                                        top: -5px;
                                        left: -5px;
                                        padding: 5px;
                                        -webkit-box-shadow: 0 0 0 2px #111;
                                        -moz-box-shadow: 0 0 0 2px #111;
                                        -ms-box-shadow: 0 0 0 2px #111;
                                        box-shadow: 0 0 0 2px #111;
                                        -webkit-transition: transform 0.2s, opacity 0.2s;
                                        -moz-transition: transform 0.2s, opacity 0.2s;
                                        -ms-transition: transform 0.2s, opacity 0.2s;
                                        -o-transition: transform 0.2s, opacity 0.2s;
                                        transition: transform 0.2s, opacity 0.2s;
                                        -webkit-transform: scale(0.8);
                                        -moz-transform: scale(0.8);
                                        -ms-transform: scale(0.8);
                                        -o-transform: scale(0.8);
                                        transform: scale(0.8);
                                        opacity: 0;
                                    }

                                    .hi-icon:after {
                                        pointer-events: none;
                                        position: absolute;
                                        width: 100%;
                                        height: 100%;
                                        -webkit-border-radius: 50%;
                                        border-radius: 50%;
                                        content: '';
                                        -webkit-box-sizing: content-box;
                                        -moz-box-sizing: content-box;
                                        box-sizing: content-box;
                                    }
                                    .icon-effect-1 .hi-icon {
                                        color: #cc0617;
                                        border-color: #cc0617;
                                    }


                                </style>
                                <i id="icon-preview" onclick="$('#modal-seelct-icon').modal('show');" class="fa  hi-icon <?php echo !empty($data["PropIcon"]) ? $data["PropIcon"] : "" ?>"></i>
                                <input type="hidden" name="hddBackUpIcon" value="<?php echo $data["PropIcon"] ?>" />
                                <div class="text-center">
                                    <small>คลิกด้านบนรูปเพื่อเลือกไอคอน</small>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div id="modal-seelct-icon" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog  modal-lg">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">คลิ๊กเลือกไอคอน</h4>
                                        </div>
                                        <div class="modal-body">
                                            <style>
                                                #modal-panel-select-icon > i{
                                                    margin: 5px;
                                                }
                                                .one-line-title {
                                                    overflow-x: hidden;
                                                    white-space: nowrap;
                                                    text-overflow: ellipsis;
                                                    overflow-y: hidden;
                                                    font-size: 12px;
                                                    color:gray;
                                                }
                                            </style>
                                            <script>
                                                function selectMainHiIcon(obj)
                                                {
                                                    var icon = $(obj).attr("data-code");
                                                    var iconold = $("[name='hddBackUpIcon']").val();
                                                    $("#icon-preview").removeClass(iconold).addClass(icon);
                                                    $("[name='hddBackUpIcon']").val(icon);
                                                    $("#modal-seelct-icon").modal('hide');
                                                }
                                            </script>
                                            <div id="modal-panel-select-icon" class="service-item-box icon-effect-1 icon-effect-1a text-center">
                                                <div class="row">
                                                    <?php
                                                        $__ICONS_ARR = array("fa-car","fa-lightbulb","fa-gas-pump","fa-music","fa-search","fa-envelope","fa-heart","fa-star","fa-user","fa-users","fa-user-md","fa-graduation-cap","fa-film","fa-th-large","fa-th","fa-th-list","fa-check","fa-times","fa-search-plus","fa-search-minus","fa-power-off","fa-signal","fa-cog","fa-trash","fa-home","fa-file","fa-clock-o","fa-road","fa-download","fa-inbox","fa-repeat","fa-refresh","fa-list-alt","fa-lock","fa-flag","fa-headphones","fa-volume-off","fa-volume-down","fa-volume-up","fa-qrcode","fa-barcode","fa-tag","fa-tags","fa-book","fa-bookmark","fa-print","fa-camera","fa-font","fa-bold","fa-italic","fa-text-height","fa-text-width","fa-align-left","fa-align-center","fa-align-right","fa-align-justify","fa-list","fa-indent","fa-video-camera","fa-picture-o","fa-map-marker","fa-adjust","fa-tint","fa-pencil-square-o","fa-step-backward","fa-fast-backward","fa-backward","fa-play","fa-pause","fa-stop","fa-forward","fa-fast-forward","fa-step-forward","fa-eject","fa-chevron-left","fa-chevron-right","fa-plus-circle","fa-minus-circle","fa-check-circle","fa-question-circle","fa-info-circle","fa-crosshairs","fa-ban","fa-arrow-left","fa-arrow-right","fa-arrow-up","fa-arrow-down","fa-mail-forward","fa-share","fa-expand","fa-compress","fa-plus","fa-minus","fa-asterisk","fa-exclamation-circle","fa-gift","fa-leaf","fa-fire","fa-eye","fa-eye-slash","fa-warning","fa-plane","fa-calendar","fa-random","fa-comment","fa-magnet","fa-chevron-up","fa-chevron-down","fa-retweet","fa-shopping-cart","fa-folder","fa-folder-open","fa-line-chart","fa-bar-chart","fa-camera-retro","fa-key","fa-cogs","fa-comments","fa-star-half","fa-heart","fa-thumb-tack","fa-trophy","fa-upload","fa-phone","fa-phone-square","fa-unlock","fa-credit-card","fa-feed","fa-bullhorn","fa-bell","fa-certificate","fa-hand-o-right","fa-hand-o-left","fa-hand-o-up","fa-hand-o-down","fa-arrow-circle-left","fa-arrow-circle-right","fa-arrow-circle-up","fa-arrow-circle-down","fa-globe","fa-wrench","fa-tasks","fa-filter","fa-briefcase","fa-arrows-alt","fa-link","fa-cloud","fa-flask","fa-cut","fa-files-o","fa-paperclip","fa-floppy-o","fa-square","fa-bars","fa-list-ul","fa-list-ol","fa-truck","fa-money","fa-caret-down","fa-caret-up","fa-caret-left","fa-caret-right","fa-unsorted","fa-sort-desc","fa-sort-up","fa-envelope","fa-file-text","fa-building","fa-desktop","fa-laptop","fa-mobile-phone","fa-folder","fa-folder-open","fa-keyboard-o");
                                                        // if(!isset($__ICONS_ARR)){
                                                        //     $__ICONS_ARR = array("fa-american-sign-language-interpreting","fa-glass","fa-music","fa-search","fa-envelope-o","fa-heart","fa-star","fa-star-o","fa-user","fa-users","fa-user-md","fa-graduation-cap","fa-film","fa-th-large","fa-th","fa-th-list","fa-check","fa-times","fa-search-plus","fa-search-minus","fa-power-off","fa-signal","fa-cog","fa-trash-o","fa-home","fa-file-o","fa-clock-o","fa-road","fa-download","fa-arrow-circle-o-down","fa-arrow-circle-o-up","fa-inbox","fa-repeat","fa-refresh","fa-list-alt","fa-lock","fa-flag","fa-headphones","fa-volume-off","fa-volume-down","fa-volume-up","fa-qrcode","fa-barcode","fa-tag","fa-tags","fa-book","fa-bookmark","fa-print","fa-camera","fa-font","fa-bold","fa-italic","fa-text-height","fa-text-width","fa-align-left","fa-align-center","fa-align-right","fa-align-justify","fa-list","fa-indent","fa-video-camera","fa-picture-o","fa-pencil","fa-map-marker","fa-adjust","fa-tint","fa-pencil-square-o","fa-share-square-o","fa-check-square-o","fa-arrows","fa-step-backward","fa-fast-backward","fa-backward","fa-play","fa-pause","fa-stop","fa-forward","fa-fast-forward","fa-step-forward","fa-eject","fa-chevron-left","fa-chevron-right","fa-plus-circle","fa-minus-circle","fa-check-circle","fa-question-circle","fa-info-circle","fa-crosshairs","fa-times-circle-o","fa-check-circle-o","fa-ban","fa-arrow-left","fa-arrow-right","fa-arrow-up","fa-arrow-down","fa-mail-forward","fa-share","fa-expand","fa-compress","fa-plus","fa-minus","fa-asterisk","fa-exclamation-circle","fa-gift","fa-leaf","fa-fire","fa-eye","fa-eye-slash","fa-warning","fa-plane","fa-calendar","fa-random","fa-comment","fa-magnet","fa-chevron-up","fa-chevron-down","fa-retweet","fa-shopping-cart","fa-folder","fa-folder-open","fa-arrows-v","fa-arrows-h","fa-line-chart","fa-bar-chart","fa-twitter-square","fa-facebook-square","fa-camera-retro","fa-key","fa-cogs","fa-comments","fa-thumbs-o-up","fa-thumbs-o-down","fa-star-half","fa-heart-o","fa-sign-out","fa-linkedin-square","fa-thumb-tack","fa-external-link","fa-sign-in","fa-trophy","fa-github-square","fa-upload","fa-phone","fa-square-o","fa-bookmark-o","fa-phone-square","fa-twitter","fa-facebook","fa-github","fa-unlock","fa-credit-card","fa-feed","fa-bullhorn","fa-bell","fa-certificate","fa-hand-o-right","fa-hand-o-left","fa-hand-o-up","fa-hand-o-down","fa-arrow-circle-left","fa-arrow-circle-right","fa-arrow-circle-up","fa-arrow-circle-down","fa-globe","fa-wrench","fa-tasks","fa-filter","fa-briefcase","fa-arrows-alt","fa-link","fa-cloud","fa-flask","fa-cut","fa-files-o","fa-paperclip","fa-floppy-o","fa-square","fa-bars","fa-list-ul","fa-list-ol","fa-truck","fa-pinterest","fa-google-plus-square","fa-google-plus","fa-money","fa-caret-down","fa-caret-up","fa-caret-left","fa-caret-right","fa-shield","fa-unsorted","fa-sort-desc","fa-sort-up","fa-envelope","fa-linkedin","fa-dashboard","fa-exchange","fa-cloud-download","fa-cloud-upload","fa-bell-o","fa-cutlery","fa-file-text-o","fa-building-o","fa-desktop","fa-laptop","fa-mobile-phone","fa-mail-reply","fa-github-alt","fa-folder-o","fa-folder-open-o","fa-keyboard-o");
                                                        // }
                                                        $_Prefix = explode("-",$__ICONS_ARR[0])[0]; 
                                                        foreach ($__ICONS_ARR as $key) {
                                                            $__faName = str_replace("$_Prefix-","",$key);
                                                    ?>
                                                        <div class="col-md-1" title="<?php echo $__faName; ?>">
                                                            <i class="fa hi-icon <?php echo $key; ?>" data-code="<?php echo $key; ?>" onclick="selectMainHiIcon(this);"></i>
                                                            <div class="one-line-title"><?php echo $__faName; ?></div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-right hide">
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

                    <button type="submit" name="btnSave" class="btn btn-success" onclick="return validateSave(this);">
                        <i class="fa fa-save"></i>
                        บันทึก
                    </button>

                    <a href="productProperties.php" class="btn btn-danger">
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



<?php include "../footer.php"; ?>