
<?php include_once  "../_master/_master.php"; ?>
<?php 

$uploadFileTarget =  $GLOBALS["ROOT"]."/_content_images/".GetCurrentLang()."/".strtolower($_COG_ITEM_CODE)."/gallery/";
$uploadFileTarget2 =  $GLOBALS["ROOT"]."/_content_images/".GetCurrentLang()."/".strtolower($_COG_ITEM_CODE)."/gallery/backgrond/";
$arrDescription = array('2' => 'รูปแบบห้อง');
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

$portCode = !empty($_GET["ref"]) ? $_GET["ref"] : $_COG_ITEM_CODE;
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

    $fileUploaded2 = $_FILES["fileUploadChange2"];
    if(!empty($fileUploaded2["name"])){
        $fileUploadedPath2 = $uploadFileTarget2.UploadFile($_FILES["fileUploadChange2"],$uploadFileTarget2);
        $filePath2 = $_POST["hddBackUpImageChange2"];
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$filePath2))
        {
            unlink($_SERVER['DOCUMENT_ROOT'].$filePath2);
        }
    }else{
        $fileUploadedPath2 = $_POST["hddBackUpImageChange"];
    }

    $sqlDelete = "update gallery set
    ImageName = '".$_POST["txtImageName"]."',
    ImageName2 = '".$_POST["txtImageName2"]."',
    ImageName3 = '".$_POST["txtImageName3"]."',
    ImageDetail = '".$_POST["txtImageDetail"]."',
    ImagePath = '".$fileUploadedPath."',
    ImagePath2 = '".$fileUploadedPath2."'
    where ImageCode = '".$_POST["btnUpdateImage"]."'";
    ExecuteSQL($sqlDelete);
    // $filePath = $_POST["hddFilePath"];
    // unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
}
if(isset($_POST["btnUpload"])){
    $fileUploaded = $_FILES["fileUpload"];
    $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget);
    $imageCode = GenerateNextID("gallery","ImageCode",10,"G");
    $imageName = REP_SG(pathinfo($fileUploaded["name"], PATHINFO_FILENAME));
    $sqlInsert = "insert into gallery (ImageCode,ImageName,RefCode,ImagePath,ImagePath2,Active,CreatedOn,CreatedBy)
    VALUES(
        '$imageCode',
        '$imageName',
        '$portCode".$_GET["no"]."',
        '$fileUploadedPath',
        '',
        '1',
        NOW(),
        '".UserService::UserCode()."'
    );";
    ExecuteSQL($sqlInsert);
}

function REP_SG($input){
    return str_replace("'","’",$input);
}

if(!empty($portCode)){
    $sqlPrd = "select * from portfolio where PortCode = '$portCode'";
    $data = SelectRow($sqlPrd);
}
?>
<style>
    .text-orange{
        color: orange;
    }
</style>
<div class="mat-box grey-bar">
    <?php if($_COG_ALLOW_LEFT_MENU || $_COG_ALLOW_LEFT_MENU_ITEMS){  ?>
    <a href="<?php echo $_COG_ALLOW_LEFT_MENU_ITEMS ? "item.php" : "masterDetail.php"  ?>" class="link-history-btn">หน้าหลัก<?php echo $_COG_ITEM_NAME ?></a>
    <?php if($_COG_ALLOW_LEFT_MENU_ITEMS){  ?>
    /
    <a href="item.php" class="link-history-btn">รายการ<?php echo $_COG_ITEM_NAME ?></a>
    <?php } ?>
    /
    <?php } ?>
    <span class="link-history-btn">คลังภาพ<?php echo $_COG_ITEM_NAME.(!empty($arrDescription[$_GET["no"]]) ? " (".$arrDescription[$_GET["no"]].")" : "") ?></span>
</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
        <?php if($_COG_ALLOW_LEFT_MENU && empty($_GET["ref"])){ ?>
        <div class="col-md-2">
            <?php include_once  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/blogEditorPage/_master/_master_leftMenu.php"; ?>
        </div>
        <?php } ?>
        <div class="col-md-<?php echo $_COG_ALLOW_LEFT_MENU && empty($_GET["ref"]) ? "10" : "12" ?>">
            <div>
                <span><b>คลังภาพ<?php echo $_COG_ITEM_NAME ?>
                    <span class="text-orange"><?php echo $data["PortName"].(!empty($arrDescription[$_GET["no"]]) ? " (".$arrDescription[$_GET["no"]].")" : "") ?></span>
                      </b></span>
                <hr style="margin-top: 5px;" />
                <style>
                    .slide-banner {
                        /* width: 100%; */
                        height: 218px;
                        position:relative;
                    }
                    .slide-banner .remover,
                    .slide-banner  .editer{
                        position:absolute;
                        right:-8px;
                        top:-8px;
                        width:26px;
                        height:26px;
                        border-radius:50%;
                        background:#000;
                        color:#fff;
                        text-align:center;
                        font-size:17px;
                        padding-top:2px;
                        z-index:10;
                        cursor:pointer;
                        border:1px solid #fff;
                    }
                    .slide-banner .remover:hover,
                    .slide-banner  .editer:hover{
                        background:#F58512;
                    }
                    .slide-banner  .editer{
                        right:20px;
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
                            $sql = "select * from gallery where RefCode = '".$portCode.$_GET["no"]."' order by SEQ, ImageCode";
                            $datas = SelectRows($sql);
                            while($data = $datas->fetch_array()){
                            ?>
                            <div class="col-sm-4 col-lg-3 ui-state-item" data-image-code="<?php echo $data["ImageCode"] ?>">
                                <div class="slide-banner image-box"  style="background-image:url(<?php echo $data["ImagePath"] ?>);">
                                    <i class="fa fa-pencil editer" onclick="$('#modal-<?php echo $data["ImageCode"] ?>').modal('show');"></i>
                                    <i class="fa fa-remove remover" onclick="$(this).next().find('input').click();"></i>
                                    <form  method="post">
                                        <input type="hidden" name="hddFilePath" value="<?php echo $data["ImagePath"] ?>" />
                                        <input type="submit" onclick="return Confirm(this, 'Are you sure you want delete ?');" class="btn-delete hide" name="btnDelete" value="<?php echo $data["ImageCode"] ?>" />
                                    </form>
                                </div>
                                <?php if($_COG_ALLOW_GALLERY_NAME){ ?>
                                <div class="text-center">
                                    <label class="text-orange one-line" title="<?php echo $data["ImageName"] ?>"><?php echo $data["ImageName"] ?></label>
                                </div>
                                <?php } ?>
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
                                                            <span><b>รูปหลัก<?php echo $_COG_ITEM_NAME ?></b></span>
                                                            <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                                            <p>
                                                                <div id="imge-preview-<?php echo $data["ImageCode"] ?>" class="image-box hand" onclick="$(this).next().click();"
                                                            style="width: 100%; height: 218px;margin-bottom:5px; background-image: url(<?php echo $data["ImagePath"] ?>), url('https://ipsumimage.appspot.com/520x610,eee')">
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
                                                                            <div id="imge-preview2-<?php echo $data["ImageCode"] ?>" class="image-box hand" onclick="$(this).next().click();"
                                                                            style="width: 100%; height: 300px;object-fit: cover;margin-bottom:5px; background-image: url(<?php echo $data["ImagePath2"] ?>), url('https://ipsumimage.appspot.com/1920x1080,eee')">
                                                                        </div>
                                                                        <input class="hide" type="file" onchange="$(this).validateUploadImage($('#imge-preview2-<?php echo $data["ImageCode"] ?>'));"
                                                                        name="fileUploadChange2" accept="image/*" />
                                                                        <input type="hidden" name="hddBackUpImageChange3" value="<?php echo $data["ImagePath2"] ?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 <?php echo ($_COG_ALLOW_GALLERY_NAME || $_COG_ALLOW_GALLERY_DETAIL || $_COG_ALLOW_GALLERY_LINKWEB ? "" : "hide") ?>">
                                                            <?php if($_COG_ALLOW_GALLERY_NAME){ ?>
                                                            <p>
                                                                <label>คำอธิบายโดยย่อ</label>
                                                                <input type="text" class="form-control input-sm" name="txtImageName" value="<?php echo $data["ImageName"] ?>" />
                                                            </p>
                                                            <?php } ?>
                                                            <?php if($_COG_ALLOW_GALLERY_DETAIL){ ?>
                                                            <p>
                                                                <label>คำอธิบายเพิ่มเติม</label>
                                                                <textarea style="min-height:90px;" class="form-control input-sm" name="txtImageName2"><?php echo $data["ImageName2"] ?></textarea>
                                                            </p>
                                                            <?php } ?>
                                                            <?php if($_COG_ALLOW_GALLERY_DETAIL2){ ?>
                                                            <p>
                                                                <label>รายละเอียด</label>
                                                                <textarea style="min-height:90px;" class="form-control input-sm" name="txtImageName3"><?php echo $data["ImageName3"] ?></textarea>
                                                            </p>
                                                            <?php } ?>
                                                            <?php if($_COG_ALLOW_GALLERY_LINKWEB){ ?>
                                                            <p>
                                                                <label>Url ลิ้งเว็บ</label>
                                                                <input type="text" class="form-control input-sm" name="txtImageDetail" value="<?php echo $data["ImageDetail"] ?>" />
                                                            </p>
                                                            <?php } ?>
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
                                    <div class="slide-banner image-box slide-adder hand" onclick="$(this).next().click();" style="position:relative; background-image: url('https://ipsumimage.appspot.com/1200x900,eee');">
                                        <div style="position:absolute;left:0;right:0;top:20px;text-align:center;">
                                            <i class="fa fa-plus fa-2x text-muted"></i>
                                        </div>
                                        <div style="position:absolute;left:0;right:0;bottom:20px;text-align:center;">
                                            <small>
                                            คลิกเพื่ออัพโหลดรุปภาพ</small>
                                        </div>
                                    </div>
                                    <input class="hide" type="file" onchange="uploadBanner(this);"
                                        name="fileUpload" id="fileUpload" accept="image/*" />
                                    <input type="submit"  id="btn-upload" name="btnUpload" class="hide" value="" />
                                </form>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <b class="text-danger">
                                <small>*ขนาดภาพที่เหมาะสมที่สุดคือ 1200 x 900 pixels</small>
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