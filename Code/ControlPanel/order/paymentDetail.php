<?php $_COG_ITEM_CODE = 'ORDER'; ?>
<?php include  "../header.php"; ?>
<?php 

if(isset($_POST["btnSave"])){
    
    $txtBankName = $_POST["txtBankName"];
    $txtBranch = $_POST["txtBranch"];
    $txtNumber = $_POST["txtNumber"];
    $txtAccountName = $_POST["txtAccountName"];
    $txtType = $_POST["txtType"];
    $chkActive = isset($_POST["chkActive"]) ? 1 : 0;
    
    $uploadFileTarget =  $GLOBALS["ROOT"]."/_content_images/bank/";
    $fileUploaded = $_FILES["fileUpload"];
    
    if(!empty($fileUploaded["name"])){
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget);
    }else{
        $fileUploadedPath = $_POST["hddBackUpImage"];
    }
    
    $sql = "";
    if(empty($_GET["ref"])){
        $genID = GenerateNextID("bank","BankCode",5,"B");
        $sql = "insert into bank (BankCode,BankGroup,BankName,AccountName
                    ,Branch,Number,Type,Image,Active,CreatedOn,CreatedBy) values(
                '$genID'
                ,'BANK'
                ,'$txtBankName'
                ,'$txtAccountName'
                ,'$txtBranch'
                ,'$txtNumber'
                ,'$txtType'
                ,'$fileUploadedPath'
                ,$chkActive
                ,NOW()
                ,'".UserService::UserCode()."'
            );
        ";
    }else{
        $sql = "update bank set
                BankName = '$txtBankName'
                ,AccountName = '$txtAccountName'
                ,Branch = '$txtBranch'
                ,Number = '$txtNumber'
                ,Type = '$txtType'
                ,Image = '$fileUploadedPath'
                ,Active = $chkActive
                ,UpdatedOn = NOW()
                ,UpdatedBy = '".UserService::UserCode()."'
                where BankCode = '".$_GET["ref"]."'
        ";
    }
    
    ExecuteSQLTransaction($sql,"payment.php");
}

if(!empty($_GET["ref"]))
{
    $sql = "select * from bank where BankCode = '".$_GET["ref"]."'";
    $data = SelectRow($sql);
}
?>


<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-9">
            <h3 style="margin: 0;"><i class="fa fa-shopping-cart fa-fw"></i>
                <span class="analysis-left-menu-desc">การสั่งซื้อ</span></h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

<div class="mat-box grey-bar">

    <a href="payment.php" class="link-history-btn">การสั่งซื้อ</a>
    /
    <a href="payment.php" class="link-history-btn">การชำระเงิน</a>
    /
    <span class="link-history-btn">จัดการบัญชีธนาคาร</span>



</div>

<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <form method="post" id="form-data" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-10">
                        <div>
                            <span><b><?php echo empty($_GET["ref"]) ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล ".$_GET["ref"] ?></b></span>
                            <hr style="margin-top: 5px;" />
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <label>ชื่อธนาคาร</label>
                                <input type="text" name="txtBankName" id="txtBankName" value="<?php echo $data["BankName"] ?>" class="form-control input-sm require" />
                            </div>
                            <div class="col-sm-6">
                                <label>สาขา</label>
                                <input type="text" name="txtBranch" id="txtBranch" value="<?php echo $data["Branch"] ?>" class="form-control input-sm require" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>เลขที่บัญชี</label>
                                <input type="text" name="txtNumber" id="txtNumber" value="<?php echo $data["Number"] ?>" class="form-control input-sm require" />
                            </div>
                            <div class="col-sm-6">
                                <label>ชื่อบัญชี</label>
                                <input type="text" name="txtAccountName" id="txtAccountName" value="<?php echo $data["AccountName"] ?>" class="form-control input-sm require" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>ประเภทบัญชี</label>
                                <input type="text" name="txtType" id="txtType" value="<?php echo $data["Type"] ?>" class="form-control input-sm require" />
                            </div>
                        </div>

                        <br />

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
                    <div class="col-md-2">
                        <div>
                            <span><b>โลโก้ธนาคาร</b></span>
                            <hr style="margin-top: 5px; margin-bottom: 5px;" />
                            <p>
                                <small class="text-danger">*ขนาดภาพที่เหมาะสมที่สุดคือ 90 x 35 pixels</small>
                            </p>

                            <img id="imge-preview" style="width:100%" src="<?php echo empty($data["Image"]) ? "https://ipsumimage.appspot.com/90x35,eee" : $data["Image"] ?>" 
                            class="img-responsive hand" onclick="$(this).next().click();"/>


                            <input class="hide" type="file" onchange="$(this).previewImage($('#imge-preview'));"
                                name="fileUpload" id="fileUpload" accept="image/*" />

                            <input type="hidden" name="hddBackUpImage" value="<?php echo $data["Image"] ?>" />


                            <div class="text-center">
                                <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                            </div>
                        </div>
                    </div>

                </div>

                <hr />

                <div>

                    <button type="submit" name="btnSave" class="btn btn-success" onclick="return Validate(this,$('#form-data'));">
                        <i class="fa fa-save"></i>
                        บันทึก
                    </button>

                    <a href="payment.php" class="btn btn-danger">
                        <i class="fa fa-remove"></i>
                        ยกเลิก
                    </a>
                </div>



            </div>
        </div>
    </form>
</div>


<?php include  "../footer.php"; ?>