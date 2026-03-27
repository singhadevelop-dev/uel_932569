<?php include_once  "_config.php"; ?>
<?php include_once  "../_master/_master.php"; ?>
<?php 

$portCode = !empty($_GET["ref"]) ? $_GET["ref"] : $_COG_ITEM_CODE;
if(isset($_POST["btnSortable"])){
    $json = $_POST["txtSortable"];
    $sort = json_decode($json);
    foreach ($sort as $value)
    {
    	$sqlSortUpdate = "update team set
    SEQ = '".$value->seq."'
    where TeamCode = '".$value->code."'";
    ExecuteSQL($sqlSortUpdate);
    }
    
}

if(isset($_POST["btnDelete"])){
    $sqlDelete = "delete from team where TeamCode = '".$_POST["btnDelete"]."'";
    ExecuteSQL($sqlDelete);
    
    $filePath = $_POST["hddFilePath"];
    unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
}

if(isset($_POST["btnUpdateImage"])){
    
    $uploadFileTarget = $GLOBALS["ROOT"]."/_content_images/team/";
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
    
    $sqlDelete = "update team set
    TeamName = '".$_POST["txtTeamName"]."',
    Position = '".$_POST["txtTeamPosition"]."',
    Email = '".$_POST["txtTeamEmail"]."',
    Phone = '".$_POST["txtTeamPhone"]."',
    Image = '".$fileUploadedPath."',
    Facebook='".$_POST["txtFacebook"]."',
    Twitter='".$_POST["txtTwitter"]."',
    Linkedin='".$_POST["txtLinkedin"]."',
    IG='".$_POST["txtIG"]."',
    YoutubeURL='".$_POST["txtYoutubeURL"]."'
    where TeamCode = '".$_POST["btnUpdateImage"]."'";
    ExecuteSQL($sqlDelete);
    // $filePath = $_POST["hddFilePath"];
    // unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
}

if(isset($_POST["btnUpload"])){
    
    $uploadFileTarget = $GLOBALS["ROOT"]."/_content_images/team/";
    $fileUploaded = $_FILES["fileUpload"];
    
    $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget);
    
    $teamCode = GenerateNextID("team","TeamCode",10,"T");
    $sqlInsert = "insert into team (TeamCode,RefCode,Image,Active,CreatedOn,CreatedBy)
    VALUES(
        '$teamCode',
        '$portCode',
        '$fileUploadedPath',
        '1',
        NOW(),
        '".UserService::UserCode()."'
    );";
    ExecuteSQL($sqlInsert);
}

if(!empty($portCode)){
    $sqlPrd = "select PortCode,PortName from portfolio where PortCode = '$portCode'";
    $data = SelectRow($sqlPrd);
}
?>
<div class="mat-box grey-bar">
    
    <a href="item.php" class="link-history-btn">หน้าหลัก<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">ตั้งค่าทีมงานของเรา</span>
</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
        <?php if($_COG_ALLOW_LEFT_MENU){ ?>
        <div class="col-md-2">
            <?php include_once  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/blogEditorPage/_master/_master_leftMenu.php"; ?>
        </div>
        <?php } ?>
        <div class="col-md-<?php echo $_COG_ALLOW_LEFT_MENU ? "10" : "12" ?>">
            <div>
                <span><b>ตั้งค่าทีมงานของเรา
                    <span class="text-orange"><?php echo $data["PortName"] ?></span>
                      </b></span>
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
                            .title-team{
                                min-height: 20px;
                            }
                    </style>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>รูปภาพทีมของเราทั้งหมด 
                            &nbsp;<span class="text-orange"><?php echo $data["TeamName"] ?></span></span>
                            </b>
                        </div>
                        <div class="panel-body">

                            <div class="row"  id="sortable">
                                <?php
                        
                                $sql = "select * from team where RefCode = '$portCode' order by SEQ";
                                $datas = SelectRows($sql);
                                foreach ($datas as $data) {
                                ?>
                                <div class="col-sm-4 col-lg-3 ui-state-item" data-image-code="<?php echo $data["TeamCode"] ?>">
                                    <div class="slide-banner image-box"  style="background-image:url(<?php echo $data["Image"] ?>);">
                                        <i class="fa fa-pencil editer" onclick="$('#modal-<?php echo $data["TeamCode"] ?>').modal('show');"></i>
                                        <i class="fa fa-trash remover" onclick="$(this).next().find('input').click();"></i>
                                        <form method="post">
                                            <input type="hidden" name="hddFilePath" value="<?php echo $data["Image"] ?>" />
                                            <input type="submit" onclick="return Confirm(this, 'Are you sure you want delete ?');" class="btn-delete hide" name="btnDelete" value="<?php echo $data["TeamCode"] ?>" />
                                        </form>
                                    </div>
                                    <div class="text-center">
                                        <label class="text-orange one-line title-team" title="<?php echo $data["ImageName"] ?>"><?php echo $data["TeamName"] ?></label>
                                    </div>
                                    <div id="modal-<?php echo $data["TeamCode"] ?>" class="modal fade" role="dialog">
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
                                                                    <div id="imge-preview-<?php echo $data["TeamCode"] ?>" class="image-box hand" onclick="$(this).next().click();"
                                                                style="width: 100%; height: 250px;margin-bottom:5px; background-image: url(<?php echo $data["Image"] ?>), url('https://ipsumimage.appspot.com/360x504,eee')">
                                                                    </div>


                                                                    <input class="hide" type="file" onchange="$(this).previewImage($('#imge-preview-<?php echo $data["TeamCode"] ?>'));"
                                                                name="fileUploadChange" accept="image/*" />

                                                                    <input type="hidden" name="hddBackUpImageChange" value="<?php echo $data["Image"] ?>" />


                                                                    <div>
                                                                        <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพใหม่</small>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-8 col-lg-9">
                                                                <p>
                                                                    <label>ชื่อ</label>
                                                                    <input type="text" class="form-control input-sm require " name="txtTeamName" value="<?php echo $data["TeamName"] ?>" required />
                                                                </p>
                                                                <p class="">
                                                                    <label>ตำแหน่ง</label>
                                                                    <input type="text" class="form-control input-sm require" name="txtTeamPosition" value="<?php echo $data["Position"] ?>" required/>
                                                                </p>
                                                                <p class="hide">
                                                                    <label>Email</label>
                                                                    <input type="email" class="form-control input-sm" name="txtTeamEmail" value="<?php echo $data["Email"] ?>" placeholder="example@email.com"  />
                                                                </p>
                                                                <p class="hide">
                                                                    <label>Phone</label>
                                                                    <input type="text" class="form-control input-sm" name="txtTeamPhone" value="<?php echo $data["Phone"] ?>"  />
                                                                </p>
                                                                <br>
                                                                <style>
                                                                .panel-social-media .col-sm-6{
                                                                    margin-bottom: 10px;
                                                                }
                                                                </style>
                                                                <div class="panel-social-media hide">
                                                                    <span><b>ข้อมูลการติดต่อ</b></span>
                                                                    <hr style="margin-top: 5px;" />
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <label>FaceBook</label>
                                                                            <input type="text" placeholder="Facebook..." name="txtFacebook" id="txtFacebook"
                                                                                value="<?php echo $data["Facebook"] ?>" class="form-control input-sm" />
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <label>Twitter</label>
                                                                            <input type="text" placeholder="Twitter..." name="txtTwitter" id="txtTwitter"
                                                                                value="<?php echo $data["Twitter"] ?>" class="form-control input-sm" />
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <label>Instagram</label>
                                                                            <input type="text" placeholder="instagram..." name="txtIG" id="txtIG"
                                                                                value="<?php echo $data["IG"] ?>" class="form-control input-sm" />
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <label>Linkedin</label>
                                                                            <input type="text" placeholder="Linkedin..." name="txtLinkedin" id="txtLinkedin"
                                                                                value="<?php echo $data["Linkedin"] ?>" class="form-control input-sm" />
                                                                        </div>
                                                                        <div class="col-sm-6 hide">
                                                                            <label>Youtube</label>
                                                                            <input type="text" placeholder="Youtube..." name="txtYoutubeURL" id="txtYoutubeURL"
                                                                                value="<?php echo $data["YoutubeURL"] ?>" class="form-control input-sm" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" value="<?php echo $data["TeamCode"] ?>" class="btn btn-success" name="btnUpdateImage">บันทึก</button>
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
                                        <div class="slide-banner image-box slide-adder hand" onclick="$(this).next().click();" style="position: relative; background-image: url('https://ipsumimage.appspot.com/360x504,eee');">

                                            <div style="position: absolute; left: 0; right: 0; top: 20px; text-align: center;">
                                                <i class="fa fa-plus fa-2x text-muted"></i>
                                            </div>

                                            <div style="position: absolute; left: 0; right: 0; bottom: 20px; text-align: center;">
                                                <small>คลิกเพื่ออัพโหลดรุปภาพ</small>
                                            </div>

                                        </div>
                                        <input class="hide" type="file" onchange="uploadBanner();"
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
                                    <small>*ขนาดภาพที่เหมาะสมที่สุดคือ 600 x 800 pixels</small>
                                </b>
                            </div>
                        </div>
                        <script>
                            function uploadBanner() {
                                $("#btn-upload").click();
                            }
                            $(function () {
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

<?php include  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>