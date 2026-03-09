<?php include  "../header.php"; ?>
<?php 
if(isset($_POST["btnDelete"])){
    $sqlDelete = "delete from gallery where ImageCode = '".$_POST["btnDelete"]."'";
    ExecuteSQL($sqlDelete);
}
if(isset($_POST["btnUpdateImage"])){
    $sqlDelete = "update gallery set
    ImageName = '".$_POST["txtImageName"]."',
    ImageDetail = '".$_POST["txtImageDetail"]."',
    ImagePath = '".$_POST["txtImagePath"]."'
    where ImageCode = '".$_POST["btnUpdateImage"]."'";
    ExecuteSQL($sqlDelete);
    $filePath = $_POST["hddFilePath"];
    unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
}
if(isset($_POST["btnUpload"])){
    $imageCode = GenerateNextID("gallery","ImageCode",10,"G");
    $sqlInsert = "insert into gallery (ImageCode,RefCode,ImagePath,Active,CreatedOn,CreatedBy,ImageName,ImageDetail)
    VALUES(
        '$imageCode',
        'VIDEO',
        '".$_POST["txtImagePath"]."',
        '1',
        NOW(),
        '".UserService::UserCode()."',
        '".$_POST["txtImageName"]."',
        '".$_POST["txtImageDetail"]."'
    );";
    ExecuteSQL($sqlInsert);
}
?>
<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-9">
            <h3 style="margin: 0;"><i class="fa fa-video-camera fa-fw"></i>
                <span class="analysis-left-menu-desc">วีดีโอแกลเลอรี่</span></h3>
        </div>
        <div class="col-sm-3" style="padding-top: 5px;">
        </div>
    </div>
</div>
<div class="mat-box grey-bar">
    <a href="video.php" class="link-history-btn">หน้าจัดการวีดีโอแกลเลอรี่</a>
    /
    <span class="link-history-btn">รายการวีดีโอแกลเลอรี่</span>
</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
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
                <span><b>รายการวีดีโอ</b></span>
                <hr style="margin-top: 5px;" />
                <div class="row">
                    <?php
                    $sql = "select * from gallery where RefCode = 'VIDEO' order by ImageCode";
                    $datas = SelectRows($sql);
                    while($data = $datas->fetch_array()){
                    ?>
                    <div class="col-md-4">
                        <div class="slide-banner image-box">
                            <iframe class="iframe-video" style="width:100%;height:100%;background:#000" src="<?php echo $data["ImagePath"] ?>"></iframe>
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
                                            <h4 class="modal-title">รายละเอียดวีดีโอ</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <p>
                                                        <label>วีดีโอ</label>
                                                        <iframe class="iframe-video" style="width:100%;height:280px;background:#000" src="<?php echo $data["ImagePath"] ?>"></iframe>
                                                    </p>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p>
                                                        <label>URL Youtube</label>
                                                        <div class="input-group">
                                                            <input type="text" placeholder="URL Youtube" class="form-control input-sm require" name="txtImagePath" value="<?php echo $data["ImagePath"] ?>" />
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
                                                    <p>
                                                        <label>คำอธิบายโดยย่อ</label>
                                                        <input type="text" class="form-control input-sm" value="<?php echo $data["ImageName"] ?>" name="txtImageName" />
                                                    </p>
                                                    <p>
                                                        <label>คำอธิบายเพิ่มเติม</label>
                                                        <textarea style="min-height: 90px;" class="form-control input-sm" name="txtImageDetail"><?php echo $data["ImageDetail"] ?></textarea>
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
                    <div class="col-md-4">
                        <form method="post" enctype="multipart/form-data">
                            <div class="slide-banner image-box slide-adder hand" onclick="openModalInsert();" style="position: relative; background-color: #eee;">
                                <div style="position: absolute; left: 0; right: 0; top: 45px; text-align: center;">
                                    <i class="fa fa-plus fa-2x text-muted"></i>
                                </div>
                                <div style="position: absolute; left: 0; right: 0; bottom: 45px; text-align: center;">
                                    <label>คลิกเพื่อเพิ่มวีดีโอ</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <hr style="margin-top: 5px;margin-bottom:5px;" />
                <a href="javascript:;" onclick="$('#modal-howto').modal('show');">
                    <i class="fa fa-search"></i>
                    ดูวิธีการหาลิงค์ยูทูป</a>
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
                                    <img src="assets/how-1.png" style="width:100%" />
                                </p>
                                <p>
                                    3. คัดลอก URL ของวีดีโอ
                                </p>
                                <p>
                                    <img src="assets/how-2.png" style="width:100%" />
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
                        }
                        else if (val.toLowerCase().match("youtu.be")) {
                            val = "https://www.youtube.com/embed/" + val.split("/")[val.split("/").length - 1];
                        }
                        $(obj).prev().val(val);
                        var frame = $(obj).closest(".modal").find(".iframe-video");
                        frame.prop("src", val);
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
                                            <iframe class="iframe-video" style="width:100%;height:280px;background:#000" ></iframe>
                                        </p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p>
                                            <label>URL Youtube</label>
                                            <div class="input-group">
                                                <input type="text" placeholder="URL Youtube" class="form-control input-sm require" name="txtImagePath" value="" />
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
                                        <p>
                                            <label>คำอธิบายโดยย่อ</label>
                                            <input type="text" class="form-control input-sm" name="txtImageName" />
                                        </p>
                                        <p>
                                            <label>คำอธิบายเพิ่มเติม</label>
                                            <textarea style="min-height: 90px;" class="form-control input-sm" name="txtImageDetail"></textarea>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" onclick="return Validate(this,$('#modal-insert'));" class="btn btn-success" name="btnUpload">บันทึก</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>