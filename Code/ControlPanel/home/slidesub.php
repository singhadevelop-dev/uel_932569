<?php include  "../header.php"; ?>


<?php 

$uploadFileTarget =  $GLOBALS["ROOT"]."/_content_images/home_banner_slider/";
$uploadFileTarget2 =  $GLOBALS["ROOT"]."/_content_images/home_banner_slider/image2/";
$uploadFileTarget3 =  $GLOBALS["ROOT"]."/_content_images/home_banner_slider/image3/";
$uploadFileTarget4 =  $GLOBALS["ROOT"]."/_content_images/home_banner_slider/image4/";

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
    $filePath3 = $_POST["hddFilePath3"];
    if(!empty($filePath3))
    {
        unlink($_SERVER['DOCUMENT_ROOT'].$filePath3);
    }
}

if(isset($_POST["btnUpdateImage"])){
    $fileUploaded = $_FILES["fileUploadChange"];
    $fileUploaded2 = $_FILES["fileUploadChange2"];
    $fileUploaded3 = $_FILES["fileUploadChange3"];
    $fileUploaded4 = $_FILES["fileUploadChange4"];
    //image1
    if(!empty($fileUploaded["name"])){
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUploadChange"],$uploadFileTarget);
        
        $filePath = $_POST["hddBackUpImageChange"];
        if(!empty($filePath) && file_exists($_SERVER['DOCUMENT_ROOT'].$filePath))
        {
            unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
        }
    }else{
        $fileUploadedPath = $_POST["hddBackUpImageChange"];
    }
    //image2
    if(!empty($fileUploaded2["name"])){
        $fileUploadedPath2 = $uploadFileTarget2.UploadFile($_FILES["fileUploadChange2"],$uploadFileTarget2);
        
        $filePath2 = $_POST["hddBackUpImageChange2"];
        if(!empty($filePath2) && file_exists($_SERVER['DOCUMENT_ROOT'].$filePath2))
        {
            unlink($_SERVER['DOCUMENT_ROOT'].$filePath2);
        }
    }else{
        $fileUploadedPath2 = $_POST["hddBackUpImageChange2"];
    }
    //image3
    if(!empty($fileUploaded3["name"])){
        $fileUploadedPath3 = $uploadFileTarget3.UploadFile($_FILES["fileUploadChange3"],$uploadFileTarget3);
        
        $filePath3 = $_POST["hddBackUpImageChange3"];
        if(!empty($filePath3) && file_exists($_SERVER['DOCUMENT_ROOT'].$filePath3))
        {
            unlink($_SERVER['DOCUMENT_ROOT'].$filePath3);
        }
    }else{
        $fileUploadedPath3 = $_POST["hddBackUpImageChange3"];
    }
    //image4
    if(!empty($fileUploaded4["name"])){
        $fileUploadedPath4 = $uploadFileTarget4.UploadFile($_FILES["fileUploadChange4"],$uploadFileTarget4);
        
        $filePath4 = $_POST["hddBackUpImageChange4"];
        if(!empty($filePath4) && file_exists($_SERVER['DOCUMENT_ROOT'].$filePath4))
        {
            unlink($_SERVER['DOCUMENT_ROOT'].$filePath4);
        }
    }else{
        $fileUploadedPath4 = $_POST["hddBackUpImageChange4"];
    }
    
    $sqlDelete = "update gallery set
    ImageName = '".$_POST["txtImageName"]."',
    ImageName2 = '".$_POST["txtImageName2"]."',
    ImageDetail = '".$_POST["txtImageDetail"]."',
    ImagePath = '".$fileUploadedPath."',
    ImagePath2='".$fileUploadedPath2."',
    ImagePath3='".$fileUploadedPath3."',
    ImagePath4='".$fileUploadedPath4."'
    where ImageCode = '".$_POST["btnUpdateImage"]."'";
    ExecuteSQL($sqlDelete);
    
    // $filePath = $_POST["hddFilePath"];
    // unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
}

if(isset($_POST["btnUpload"])){
    
    $fileUploaded = $_FILES["fileUpload"];
    
    $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget);
    
    $sqlMax = "select MAX(SEQ) as xMax from gallery where RefCode = 'SUBSLIDE'";
    $dataMax = SelectRow($sqlMax);
    $num = empty($dataMax["xMax"]) ? 0 : intval($dataMax["xMax"]);
    $num++;

    $imageCode = GenerateNextID("gallery","ImageCode",10,"G");
    $sqlInsert = "insert into gallery (SEQ,ImageCode,RefCode,ImagePath,ImagePath2,ImagePath3,ImagePath4,Active,CreatedOn,CreatedBy)
    VALUES(
        '$num',
        '$imageCode',
        'SUBSLIDE',
        '$fileUploadedPath',
        '',
        '',
        '',
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
    <span class="link-history-btn">ตั้งค่ารูปภาพสไลด์ (Pop Up)</span>
</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row">
        <div class="col-md-3">
            <?php 
                $_LEFT_MENU_ACTIVE = "SUBSLIDE";
                include $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/home/leftMenu.php"; 
                ?>
        </div>
        <div class="col-md-9">
            <div>
                <span><b>รายการรูปภาพสไลด์</b></span>
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
                        /* .slide-banner .editer {
                            right: 20px;
                        } */
                        
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
                    
                            $sql = "select * from gallery where RefCode = 'SUBSLIDE' order by SEQ";
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
                                        <input type="hidden" name="hddFilePath3" value="<?php echo $data["ImagePath3"] ?>" />
                                        <input type="submit" onclick="return Confirm(this, 'Are you sure you want delete ?');" class="btn-delete hide" name="btnDelete" value="<?php echo $data["ImageCode"] ?>" />
                                    </form>
                                </div>
                                <div id="modal-<?php echo $data["ImageCode"] ?>" class="modal fade modal-update-cover" role="dialog">
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
                                                            <div>
                                                                <span><b>รูปภาพหลัก<?php echo $_COG_ITEM_NAME ?></b></span>
                                                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                                                <div class="row" style="padding-top: 10px;">
                                                                    <div class="col-md-12">
                                                                        <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพใหม่</small>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                            <div id="imge-preview-<?php echo $data["ImageCode"] ?>" class="image-box hand" onclick="$(this).next().click();"
                                                                            style="width: 100%; height: 300px;object-fit: cover;margin-bottom:5px; background-image: url(<?php echo $data["ImagePath"] ?>), url('https://ipsumimage.appspot.com/1920x1080,eee')">
                                                                        </div>
                                                                        <input class="hide" type="file" onchange="$(this).validateUploadImage($('#imge-preview-<?php echo $data["ImageCode"] ?>'));"
                                                                        name="fileUploadChange" accept="image/*" />
                                                                        <input type="hidden" name="hddBackUpImageChange" value="<?php echo $data["ImagePath"] ?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-lg-12">
                                                            <div>
                                                                <span><b>รูปภาพรอง <?php echo $_COG_ITEM_NAME ?></b></span>
                                                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                                                <div class="row" style="padding-top: 10px;">
                                                                    <div class="col-md-12">
                                                                        <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพใหม่</small>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                            <div id="imge-preview2-<?php echo $data["ImageCode"] ?>" class="image-box hand" onclick="$(this).next().click();"
                                                                            style="width: 100%; height: 300px;object-fit: cover;margin-bottom:5px; background-image: url(<?php echo $data["ImagePath2"] ?>), url('https://ipsumimage.appspot.com/1920x1080,eee')">
                                                                        </div>
                                                                        <input class="hide" type="file" onchange="$(this).validateUploadImage($('#imge-preview2-<?php echo $data["ImageCode"] ?>'));"
                                                                        name="fileUploadChange2" accept="image/*" />
                                                                        <input type="hidden" name="hddBackUpImageChange2" value="<?php echo $data["ImagePath2"] ?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-lg-12 hide">
                                                            <div>
                                                                <span><b>รูปพื้นหลัง<?php echo $_COG_ITEM_NAME ?></b></span>
                                                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                                                <div class="row" style="padding-top: 10px;">
                                                                    <div class="col-md-12">
                                                                        <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพใหม่</small>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                            <div id="imge-preview3-<?php echo $data["ImageCode"] ?>" class="image-box hand" onclick="$(this).next().click();"
                                                                            style="width: 100%; height: 300px;object-fit: cover;margin-bottom:5px; background-image: url(<?php echo $data["ImagePath3"] ?>), url('https://ipsumimage.appspot.com/1920x1080,eee')">
                                                                        </div>
                                                                        <input class="hide" type="file" onchange="$(this).validateUploadImage($('#imge-preview3-<?php echo $data["ImageCode"] ?>'));"
                                                                        name="fileUploadChange3" accept="image/*" />
                                                                        <input type="hidden" name="hddBackUpImageChange3" value="<?php echo $data["ImagePath3"] ?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-lg-6 hide">
                                                            <div>
                                                                <span><b>รูปพื้นหลัง 3 <?php echo $_COG_ITEM_NAME ?></b></span>
                                                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                                                <div class="row" style="padding-top: 10px;">
                                                                    <div class="col-md-12">
                                                                        <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพใหม่</small>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                            <div id="imge-preview4-<?php echo $data["ImageCode"] ?>" class="image-box hand" onclick="$(this).next().click();"
                                                                            style="width: 100%; height: 300px;object-fit: cover;margin-bottom:5px; background-image: url(<?php echo $data["ImagePath4"] ?>), url('https://ipsumimage.appspot.com/1920x1080,eee')">
                                                                        </div>
                                                                        <input class="hide" type="file" onchange="$(this).validateUploadImage($('#imge-preview4-<?php echo $data["ImageCode"] ?>'));"
                                                                        name="fileUploadChange4" accept="image/*" />
                                                                        <input type="hidden" name="hddBackUpImageChange4" value="<?php echo $data["ImagePath4"] ?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-lg-12">
                                                            <div>
                                                                <span><b>ข้อมูลเพิ่มเติม<?php echo $_COG_ITEM_NAME ?></b></span>
                                                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                                                <div class="row" style="padding-top: 10px;">
                                                                    <div class="col-md-12">
                                                                        <small>คำอธิบายเพิ่มเติมเกี่ยวกับภาพ</small>
                                                                    </div>
                                                                </div>
                                                                <p class="">
                                                                    <label>คำอธิบายโดยย่อ</label>
                                                                    <input type="text" class="form-control input-sm" name="txtImageName" value="<?php echo $data["ImageName"] ?>" />
                                                                </p>
                                                                <p class="">
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

                            <div class="col-sm-4 col-lg-3 hide">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="slide-banner image-box slide-adder hand" onclick="$(this).next().click();" style="position: relative; background-image: url('https://ipsumimage.appspot.com/766x551,eee');">

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
                            <p>
                                <b class="text-success">
                                    <i class="fa fa-info-circle"></i>
                                    ลากรูปภาพเพื่อสลับตำแหน่ง
                                </b>
                            </p>
                            <b class="text-danger">
                                <small>*ขนาดภาพที่เหมาะสมที่สุดคือ 766 x 551 pixels</small>
                            </b>
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