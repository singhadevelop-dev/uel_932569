<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>

<?php 

if(isset($_POST["btnSave"])){
    
    $txtSubject = $_POST["txtSubject"];
    $txtDetail = $_POST["txtDetail"];
    $txtColorCode = $_POST["txtColorCode"];
    $chkActive = isset($_POST["chkActive"]) ? 1 : 0;
    
    $sql = "";
    if(empty($_GET["ref"])){
        $genID = GenerateNextID("tag","TagCode",5,"T");
        $sql = "insert into tag (TagCode,TagName,TagDetail,Active,CreatedOn,CreatedBy,FreeText,TagType) values(
                '$genID'
                ,'$txtSubject'
                ,'$txtDetail'
                ,$chkActive
                ,NOW()
                ,'".UserService::UserCode()."'
                ,'$txtColorCode'
                ,'SIZE'
            );
        ";
    }else{
        $sql = "update tag set
                TagName = '$txtSubject'
                ,TagDetail = '$txtDetail'
                ,Active = $chkActive
                ,UpdatedOn = NOW()
                ,UpdatedBy = '".UserService::UserCode()."'
                ,FreeText = '$txtColorCode'
                where TagCode = '".$_GET["ref"]."'
        ";
    }
    
    ExecuteSQLTransaction($sql,"productSize.php");
}

if(!empty($_GET["ref"]))
{
    $sql = "select * from tag where TagCode = '".$_GET["ref"]."'";
    $data = SelectRow($sql);
}
?>



<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <a href="productSize.php" class="link-history-btn">รายการไซส์</a>
    /
    <span class="link-history-btn">จัดการข้อมูลไซส์ ของ<?php echo $_COG_ITEM_NAME ?></span>

</div>

<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <form method="post" id="form-data">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <span><b><?php echo empty($_GET["ref"]) ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล ".$_GET["ref"] ?></b></span>
                    <hr style="margin-top: 5px;" />
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <label>ชื่อไซส์</label>
                        <input type="text" name="txtSubject" id="txtSubject" value="<?php echo $data["TagName"] ?>" class="form-control input-sm require" />
                    </div>
                </div>

                <div class="row hide">
                    <div class="col-sm-12">
                        <label>รายละเอียด / คำอธิบาย</label>
                        <textarea name="txtDetail" id="txtDetail" class="form-control input-sm"><?php echo $data["TagDetail"] ?></textarea>
                    </div>
                </div>

                <div class="row hide">
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

                <hr />

                <div>

                    <button type="submit" name="btnSave" class="btn btn-success" onclick="return Validate(this,$('#form-data'));">
                        <i class="fa fa-save"></i>
                        บันทึก
                    </button>

                    <a href="productSize.php" class="btn btn-danger">
                        <i class="fa fa-remove"></i>
                        ยกเลิก
                    </a>
                </div>



            </div>
        </div>
    </form>
</div>

<?php include  "../footer.php"; ?>