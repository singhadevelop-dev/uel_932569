<?php include  "../header.php"; ?>

<?php 

if(isset($_POST["btnDelete"])){
    $sqlDelete = "delete from gallery where ImageCode = '".$_POST["btnDelete"]."'";
    ExecuteSQL($sqlDelete);
    
    $filePath = $_POST["hddFilePath"];
    unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
}

if(isset($_POST["btnUpdateImage"])){
    $uploadFileTarget = $GLOBALS["ROOT"]."/_content_images/client/";
    $fileUploaded = $_FILES["fileUploadChange"];
    
    if(!empty($fileUploaded["name"])){
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUploadChange"],$uploadFileTarget);
        
        $filePath = $_POST["hddBackUpImageChange"];
        unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
    }else{
        $fileUploadedPath = $_POST["hddBackUpImageChange"];
    }
    
    $sqlDelete = "update gallery set
    ImageName = '".$_POST["txtImageName"]."',
    ImageDetail = '".$_POST["txtImageDetail"]."',
    ImagePath = '".$fileUploadedPath."'
    where ImageCode = '".$_POST["btnUpdateImage"]."'";
    ExecuteSQL($sqlDelete);
    
    $filePath = $_POST["hddFilePath"];
    unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
}

if(isset($_POST["btnUpload"])){
    
    $uploadFileTarget = $GLOBALS["ROOT"]."/ControlPanel/assets/images/client/";
    $fileUploaded = $_FILES["fileUpload"];
    
    $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget);
    
    $imageCode = GenerateNextID("gallery","ImageCode",10,"G");
    $sqlInsert = "insert into gallery (ImageCode,RefCode,ImagePath,Active,CreatedOn,CreatedBy)
    VALUES(
        '$imageCode',
        'CLIENT',
        '$fileUploadedPath',
        '1',
        NOW(),
        '".UserService::UserCode()."'
    );";
    ExecuteSQL($sqlInsert);
}

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
    <span class="link-history-btn">ตั้งค่าลูกค้าของเรา</span>



</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row">
        <div class="col-md-3">
            <?php 
                $_LEFT_MENU_ACTIVE = "CLIENT";
                include $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/home/leftMenu.php"; 
                ?>
        </div>
        <div class="col-md-9">
            <div>
                <span><b>รายการลูกค้าของเรา (Slide)</b></span>
                <hr style="margin-top: 5px;" />

                <style>
                    .slide-banner {
                        width: 100%;
                        height: 170px;
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

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>รูปภาพทั้งหมด</b>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <?php
                    
                            $sql = "select * from gallery where RefCode = 'CLIENT' order by ImageCode";
                            $datas = SelectRows($sql);
                            while($data = $datas->fetch_array()){
                            ?>
                            <div class="col-sm-4 col-lg-3">
                                <div class="slide-banner image-box"  style="background-image:url(<?php echo $data["ImagePath"] ?>);">
                                    <i class="fa fa-pencil editer" onclick="$('#modal-<?php echo $data["ImageCode"] ?>').modal('show');"></i>
                                    <i class="fa fa-remove remover" onclick="$(this).next().find('input[type=submit]').click();"></i>
                                    <form method="post">
                                        <input type="hidden" name="hddFilePath" value="<?php echo $data["ImagePath"] ?>" />
                                        <input type="submit" onclick="return Confirm(this, 'Are you sure you want delete ?');" class="btn-delete hide" name="btnDelete" value="<?php echo $data["ImageCode"] ?>" />
                                    </form>
                                </div>
                                <div id="modal-<?php echo $data["ImageCode"] ?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog modal-lg">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <form method="post" enctype="multipart/form-data">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">รายละเอียดรูปภาพ</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-4 col-lg-3">
                                                            <p>
                                                                <div id="imge-preview-<?php echo $data["ImageCode"] ?>" class="image-box hand" onclick="$(this).next().click();"
                                                            style="width: 100%; height: 150px;margin-bottom:5px; background-image: url(<?php echo $data["ImagePath"] ?>), url('https://ipsumimage.appspot.com/750x1300,eee')">
                                                                </div>


                                                                <input class="hide" type="file" onchange="$(this).validateUploadImage($('#imge-preview-<?php echo $data["ImageCode"] ?>'));"
                                                            name="fileUploadChange" accept="image/*" />

                                                                <input type="hidden" name="hddBackUpImageChange" value="<?php echo $data["ImagePath"] ?>" />


                                                                <div>
                                                                    <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพใหม่</small>
                                                                </div>
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-8 col-lg-9">
                                                            <p class="hide">
                                                                <label>คำอธิบายโดยย่อ</label>
                                                                <input type="text" class="form-control input-sm" name="txtImageName" value="<?php echo $data["ImageName"] ?>" />
                                                            </p>
                                                            <p>
                                                                <label>Url ลิ้งเว็บ</label>
                                                                <input type="text" class="form-control input-sm" name="txtImageDetail" value="<?php echo $data["ImageDetail"] ?>" />
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" value="<?php echo $data["ImageCode"] ?>" class="btn btn-success" name="btnUpdateImage">บันทึก</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="col-sm-4 col-lg-3">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="slide-banner image-box slide-adder hand" onclick="$(this).next().click();" style="position: relative; background-image: url('https://ipsumimage.appspot.com/520x520,eee');">

                                        <div style="position: absolute; left: 0; right: 0; top: 20px; text-align: center;">
                                            <i class="fa fa-plus fa-2x text-muted"></i>
                                        </div>

                                        <div style="position: absolute; left: 0; right: 0; bottom: 20px; text-align: center;">
                                            <small>คลิกเพื่ออัพโหลดรุปภาพ</small>
                                        </div>

                                    </div>
                                    <input class="hide" type="file" onchange="uploadBanner(this);"
                                        name="fileUpload" id="fileUpload" accept="image/*" />

                                    <input type="submit" id="btn-upload" name="btnUpload" class="hide" value="" />
                                </form>
                            </div>


                        </div>
                        <div class="panel-footer">
                            <b class="text-danger">
                                <small>*ขนาดภาพที่เหมาะสมที่สุดคือ 520 x 480 pixels</small>
                            </b>
                        </div>
                    </div>
                    <script>
                        function uploadBanner(input) {
                            if ($(input).validateUploadImage()) {
                                $("#btn-upload").click();
                            }
                        }
                    </script>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>