<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>
<link rel="stylesheet" type="text/css" href="../../vendor/fontawesome-free/css/all.min.css">
<link rel="stylesheet" type="text/css" href="../../vendor/animate/animate.min.css"> 
<?php 
$get_ref = $_GET["ref"];
$get_ref2 = $_GET["ref2"];

// echo "Debug : $get_ref, $get_ref2</ br>";

if(isset($_POST["btnSave"])){
    
// echo "Debug : btnSave</ br>";
    
    $ddlGroup = $_POST['ddlGroup']; 
    $txtSubject = $_POST["txtSubject"];
    $txtSubDetail = GeneratePageFile($_POST["txtSubDetail"]);
    //$txtShortDescription = $_POST["txtShortDescription"];
    $chkActive = isset($_POST["chkActive"]) ? 1 : 0;
    
    $sql = "";
    if(empty($get_ref2)){
        $genID = GenerateNextID("product_sub_detail","SubDetailCode",5,"SD");
        $sql = "
        INSERT INTO `product_sub_detail`
        (`ProductCode`, `SubDetailCode`, `SubDetailName`, `SubDetail`, `CreatedOn`, `CreatedBy`, `GroupName`) 
        VALUES 
        ('$get_ref','$genID','$txtSubject','$txtSubDetail',NOW(),'".UserService::UserCode()."','$ddlGroup')";

    }else{
        $sql = "update product_sub_detail set
                SubDetailName = '$txtSubject'
                ,GroupName = '$ddlGroup'
                ,SubDetail='$txtSubDetail'
                ,UpdatedOn = NOW()
                ,UpdatedBy = '".UserService::UserCode()."'
                where SubDetailCode = '".$get_ref2."'
        ";
    }
// echo "Debug : $sql</ br>";
    
    ExecuteSQLTransaction($sql,"productSubDetail.php?ref=$get_ref");
}

if(!empty($get_ref2))
{

    $sql = "select * from product_sub_detail where SubDetailCode = '".$get_ref2."' ";
// echo "Debug : $sql</ br>";
    $data = SelectRow($sql);
}
?>

<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <a href="productSubDetail.php?ref=<?php echo $get_ref ?>" class="link-history-btn">รายการหัวข้อรายละเอียด</a>
    /
    <span class="link-history-btn">จัดการข้อมูลหัวข้อรายละเอียด</span>



</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <form method="post">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <span><b><?php echo empty($get_ref2) ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล ".$get_ref2 ?></b></span>
                    <hr style="margin-top: 5px;" />
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-md-6">
                                <label>กลุ่มหัวข้อรายละเอียด</label>
                                <select name="ddlGroup" id="ddlGroup" class="form-control input-sm require">
                                    <option value="INGREDIENT" <?php echo $data["GroupName"] == "INGREDIENT" ? "selected" : "" ?> >INGREDIENT</option>
                                    <option value="FEATURES" <?php echo $data["GroupName"] == "FEATURES" ? "selected" : "" ?> >FEATURES</option>
                                    <option value="HOW TO USE" <?php echo $data["GroupName"] == "HOW TO USE" ? "selected" : "" ?> >HOW TO USE</option>
                                    <option value="CETIFICATE" <?php echo $data["GroupName"] == "CETIFICATE" ? "selected" : "" ?> >CETIFICATE</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>ชื่อหัวข้อรายละเอียด</label>
                                <input type="text" name="txtSubject" id="txtSubject" value="<?php echo $data["SubDetailName"] ?>" class="form-control input-sm require" />
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 summernote-container">
                        <label>รายละเอียด</label>
                        <?php 
                        // =============== HTML EDITOR =============== 
                        $_HTML_EDITOR_NAME = "txtSubDetail";
                        $_HTML_EDITOR_CONTENT_ID = $data["SubDetail"];
                        include $GLOBALS['DOCUMENT_ROOT'].'/ControlPanel/HtmlEditor/HtmlEditor.php'; 
                        ?>
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
                            <?php if(!empty($get_ref2) && $data["Active"] == 0){ ?>
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

                    <a href="productSubDetail.php?ref=<?php echo $get_ref ?>" class="btn btn-danger">
                        <i class="fa fa-remove"></i>
                        ยกเลิก
                    </a>
                </div>


                <script>
                    function validateSave(sender) {
                        var msg = [];
                        if ($("#txtSubject").val().trim() == "") {
                            msg.push("ชื่อหัวข้อรายละเอียด");
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