<?php include  "../header.php"; ?>
<?php 
$_COG_REF_CODE = $_GET['ref'];
$uploadFileTarget =  $GLOBALS["ROOT"]."/_content_images/".GetCurrentLang()."/"."home_banner_featured/";
if(isset($_POST["btnSortable"])){
    $json = $_POST["txtSortable"];
    $sort = json_decode($json);
    foreach ($sort as $value)
    {
    	$sqlSortUpdate = "update gallery set
    SEQ = '".$value->seq."'
    where ImageCode = '".$value->code."'";
    ExecuteSQL($sqlSortUpdate);
    }
}
if(isset($_POST["btnDelete"])){
    $sqlDelete = "delete from gallery where ImageCode = '".$_POST["btnDelete"]."'";
    ExecuteSQL($sqlDelete);
    $filePath = $_POST["hddFilePath"];
    unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
}
if(isset($_POST["btnUpdateImage"])){
    $fileUploaded = $_FILES["fileUploadChange"];
    if(!empty($fileUploaded["name"])){
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUploadChange"],$uploadFileTarget);
        $filePath = $_POST["hddBackUpImageChange"];
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$filePath))
        {
            unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
        }
    }else{
        $fileUploadedPath = $_POST["hddBackUpImageChange"];
    }
    $sqlDelete = "update gallery set
    ImageName = '".$_POST["txtImageName"]."',
    ImageDetail = '".$_POST["txtImageDetail"]."',
    ImagePath = '".$fileUploadedPath."'
    where ImageCode = '".$_POST["btnUpdateImage"]."'";
    ExecuteSQL($sqlDelete);
    // $filePath = $_POST["hddFilePath"];
    // unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
}
if(isset($_POST["btnUpload"])){
    $fileUploaded = $_FILES["fileUpload"];
    $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget);
    $imageCode = GenerateNextID("gallery","ImageCode",10,"G");
    $sqlInsert = "insert into gallery (ImageCode,RefCode,ImagePath,Active,CreatedOn,CreatedBy)
    VALUES(
        '$imageCode',
        '$_COG_REF_CODE',
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
            <div>
                <span><b>รายการแบนเนอร์ (Slide)</b></span>
                <hr style="margin-top: 5px;" />
                <style>
                    .slide-banner {
                        height: 150px;
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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>รูปภาพทั้งหมด</b>
                    </div>
                    <div class="panel-body">
                        <div class="row" id="sortable">
                            <?php
                            $sql = "select * from gallery where RefCode = '$_COG_REF_CODE' order by SEQ";
                            $datas = SelectRows($sql);
                            $xCountItem = 0;
                            while($data = $datas->fetch_array()){
                                $xCountItem++;
                            ?>
                            <div class="col-sm-4 col-lg-3 ui-state-item" data-image-code="<?php echo $data["ImageCode"] ?>">
                                <div class="slide-banner image-box"  style="background-image:url(<?php echo $data["ImagePath"] ?>);">
                                    <i class="fa fa-pencil editer" onclick="$('#modal-<?php echo $data["ImageCode"] ?>').modal('show');"></i>
                                    <i class="fa fa-remove remover hide" onclick="$(this).next().find('input[type=submit]').click();"></i>
                                    <form method="post">
                                        <input type="hidden" name="hddFilePath" value="<?php echo $data["ImagePath"] ?>" />
                                        <!-- <input type="submit" onclick="return Confirm(this, 'Are you sure you want delete ?');" class="btn-delete hide" name="btnDelete" value="<?php echo $data["ImageCode"] ?>" /> -->
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
                                                        <div class="col-sm-12 col-lg-12">
                                                            <p>
                                                                <div id="imge-preview-<?php echo $data["ImageCode"] ?>" class="image-box hand" onclick="$(this).next().click();"
                                                            style="width: 100%; height: 300px;object-fit: cover;margin-bottom:5px; background-image: url(<?php echo $data["ImagePath"] ?>), url('https://ipsumimage.appspot.com/1920x1080,eee')">
                                                                </div>
                                                                <input class="hide" type="file" onchange="$(this).validateUploadImage($('#imge-preview-<?php echo $data["ImageCode"] ?>'));"
                                                            name="fileUploadChange" accept="image/*" />
                                                                <input type="hidden" name="hddBackUpImageChange" value="<?php echo $data["ImagePath"] ?>" />
                                                                <div>
                                                                    <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพใหม่</small>
                                                                </div>
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-12 col-lg-12 hide">
                                                            <p class="hide">
                                                                <label>คำอธิบายโดยย่อ</label>
                                                                <input type="text" class="form-control input-sm" name="txtImageName" value="<?php echo $data["ImageName"] ?>" />
                                                            </p>
                                                            <p>
                                                                <label>คำอธิบายเพิ่มเติม</label>
                                                                <textarea style="min-height:90px;" class="form-control input-sm" name="txtImageDetail"><?php echo $data["ImageDetail"] ?></textarea>
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
                            <div class="col-sm-4 col-lg-3 <?php echo $xCountItem == 0 ? : "hide" ?>">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="slide-banner image-box slide-adder hand" onclick="$(this).next().click();" style="position: relative; background-image: url('https://ipsumimage.appspot.com/1920x1080,eee');">
                                        <div style="position: absolute; left: 0; right: 0; top: 20px; text-align: center;">
                                            <i class="fa fa-plus fa-2x text-muted"></i>
                                        </div>
                                        <div style="position: absolute; left: 0; right: 0; bottom: 20px; text-align: center;">
                                            <small>คลิกเพื่ออัพโหลดรูปภาพ</small>
                                        </div>
                                    </div>
                                    <input class="hide" type="file" onchange="uploadBanner(this);"
                                        name="fileUpload" id="fileUpload" accept="image/*" />
                                    <input type="submit" id="btn-upload" name="btnUpload" class="hide" value="" />
                                </form>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <p class="hide">
                                <b class="text-success">
                                    <i class="fa fa-info-circle"></i>
                                    ลากรูปภาพเพื่อสลับตำแหน่ง
                                </b>
                            </p>
                            <b class="text-danger">
                                <small>*ขนาดภาพที่เหมาะสมที่สุดคือ 1920 x 1080 pixels</small>
                            </b>
                        </div>
                    </div>
                    <script>
                        function uploadBanner(input) {
                            if ($(input).validateUploadImage()) {
                                $("#btn-upload").click();
                            }
                        }
                          $( function() {
                              $("#sortable").sortable({
                                  items: ".ui-state-item",
                                  placeholder: "slide-banner ui-state-focus col-sm-4 col-lg-3",
                                  stop: function () {
                                      var arrSort = [];
                                      $("#sortable .ui-state-item").each(function (inx) {
                                          arrSort.push({
                                              code: $(this).attr("data-image-code"),
                                              seq: inx
                                          });
                                      });
                                      $("#txtSortable").val(JSON.stringify(arrSort));
                                      $("#btnSortable").click();
                                  }
                              });
                              $( "#sortable" ).disableSelection();
                          } );
                      </script>
                </div>
            </div>
        </div>
    </div>
</div>
<form method="post" class="hide">
    <textarea id="txtSortable" name="txtSortable">[]</textarea>
    <input type="submit" id="btnSortable" name="btnSortable" value="" />
</form>
<?php include  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>