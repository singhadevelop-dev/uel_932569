<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>

<?php 

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

$refCode = $_GET["ref"];

if(isset($_POST["btnDelete"])){
    $sqlDelete = "delete from gallery where ImageCode = '".$_POST["btnDelete"]."'";
    ExecuteSQL($sqlDelete);
    
    $filePath = $_POST["hddFilePath"];
    unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
}

if(isset($_POST["btnUpdateImage"])){
    $uploadFileTarget =  $GLOBALS["ROOT"]."/_content_files/product_gallery/";
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
    where ImageCode = '".$_POST["hdfImageCode"]."'";
    ExecuteSQL($sqlDelete);
    
    // $filePath = $_POST["hddFilePath"];
    // unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
}

if(isset($_POST["btnUpload"])){
    
    $uploadFileTarget =  $GLOBALS["ROOT"]."/_content_files/product_gallery/";
    $fileUploaded = $_FILES["fileUpload"];
    
    $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget);
    
    $imageCode = GenerateNextID("gallery","ImageCode",10,"G");
    $max = SelectRow("select IFNULL(max(SEQ),0)+1 as SEQ from gallery where Active=1 and RefCode='$refCode' ");
    $sqlInsert = "insert into gallery (ImageCode,RefCode,ImagePath,Active,CreatedOn,CreatedBy,SEQ)
    VALUES(
        '$imageCode',
        '".$refCode."',
        '$fileUploadedPath',
        '1',
        NOW(),
        '".UserService::UserCode()."',
        ".$max["SEQ"]."
    );";
    ExecuteSQL($sqlInsert);
}


if(!empty($refCode)){
    $sqlPrd = "select * from product where ProductCode = '$refCode'";
    $data = SelectRow($sqlPrd);
}

?>


<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <a href="product.php" class="link-history-btn">รายการ<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">แกลเลอรี่<?php echo $_COG_ITEM_NAME ?> (<?php echo $data["ProductCode"] ?>)</span>

</div>

<div class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row">
        <div class="col-md-12">
            <div>
                <span><b>แกลเลอรี่<?php echo $_COG_ITEM_NAME ?>
                    <span class="text-orange"><?php echo $data["ProductName"] ?></span>

                      </b></span>
                <hr style="margin-top: 5px;" />

                <style>
                    .slide-banner {
                        height: 250px;
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
                    
                            $sqlTags = "select * from tag where TagType = 'COLOR' and Active = 1 order by TagName";
                            $dataTags = SelectRows($sqlTags);
                            $_COLORS = array();
                            foreach ($dataTags as $tag) {
                                $_COLORS[$tag["TagCode"]] = $tag["TagName"];
                            }

                            $sql = "select * from gallery where RefCode = '".$refCode."' order by SEQ";
                            $datas = SelectRows($sql);
                            foreach ($datas as $data) {
                            ?>
                            <div class="col-sm-4 col-lg-4 ui-state-item" data-image-code="<?php echo $data["ImageCode"] ?>">
                                <div class="slide-banner image-box"  style="background-image:url(<?php echo $data["ImagePath"] ?>);">
                                    <i class="fa fa-pencil editer" onclick="openChangeImage('<?php echo $data["ImageCode"] ?>')"></i>
                                    <i class="fa fa-remove remover" onclick="$(this).next().find('input').click();"></i>
                                    <form method="post">
                                        <input type="hidden" name="hddFilePath" value="<?php echo $data["ImagePath"] ?>" />
                                        <input type="submit" onclick="return Confirm(this, 'Are you sure you want delete ?');" class="btn-delete hide" name="btnDelete" value="<?php echo $data["ImageCode"] ?>" />
                                    </form>
                                </div>
                                <div class="text-center">
                                    <?php if(isset($_COLORS[$data["ImageName"]])){ ?>
                                        <label class="text-orange one-line"><?php echo $_COLORS[$data["ImageName"]] ?></label>
                                    <?php }else{ ?>
                                        <!-- <label class="text-muted one-line">[ไม่ระบุกลุ่มรูปภาพ]</label> -->
                                    <?php } ?>
                                    
                                </div>
                            </div>
                            <?php } ?>

                            <div class="col-sm-4 col-lg-4">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="slide-banner image-box slide-adder hand" onclick="$(this).next().click();" style="position: relative; background-image: url('https://ipsumimage.appspot.com/461x461,eee');">

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
                                <small>*ขนาดภาพที่เหมาะสมที่สุดคือ 461 x 461 pixels</small>
                            </b>
                        </div>
                    </div>
                    <script>
                        function uploadBanner(input) {
                            if ($(input).validateUploadImage()) {
                                $("#btn-upload").click();
                            }
                        }
                        $(function () {
                            $("#sortable").sortable({
                                items: ".ui-state-item",
                                placeholder: "slide-banner ui-state-focus col-sm-4 col-lg-4",
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
                            $("#sortable").disableSelection();
                        });
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

<script>
    function openChangeImage(imgId){
        $("#modal-change-gallery").modal('show');
        $("#panel-change-gallery").AlertLoading(true,"โหลดข้อมูล");
        $("#panel-change-gallery").load("_load_productDetailGallery.php",{ref:'<?php echo $refCode ?>',image: imgId},
        function(){

        });
    }
</script>
<div id="modal-change-gallery" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">รายละเอียดรูปภาพ</h4>
                </div>
                <div class="modal-body">
                    <div id="panel-change-gallery">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="btnUpdateImage">บันทึก</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                </div>
            </form>
        </div>

    </div>
</div>

<?php include  "../footer.php"; ?>