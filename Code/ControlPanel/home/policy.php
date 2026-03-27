<?php include  "../header.php"; ?>
<?php 
$_COG_REF_CODE = $_GET['ref'];
$_TITLE = array(
    'WEBSITE_TERMS' => 'Terms & Condition',
    'WEBSITE_PRIVACY' => 'Privacy Policy',
    'WEBSITE_COOKIE' => 'Cookie Policy'
);
if(isset($_POST["btnSave"])){
    $txtDetail = GeneratePageFile($_POST["txtDetail"],$_COG_REF_CODE);
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
    <span class="link-history-btn">ตั้งค่า <?php echo $_TITLE[$_COG_REF_CODE] ?></span>
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
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12 summernote-container">
                        <label>รายละเอียด <?php echo $_TITLE[$_COG_REF_CODE] ?></label>
                        <?php 
                        // =============== HTML EDITOR =============== 
                        $_HTML_EDITOR_NAME = "txtDetail";
                        $_HTML_EDITOR_CONTENT_ID = $_COG_REF_CODE;
                        include $GLOBALS['DOCUMENT_ROOT'].'/ControlPanel/HtmlEditor/HtmlEditor.php'; 
                        ?>
                    </div>
                </div>
                <hr />
                <button type="submit" class="btn btn-success" name="btnSave">
                    <i class="fa fa-save"></i>
                    บันทึกการเปลี่ยนแปลง
                </button>
                <button type="button" onclick="location.reload();" class="btn btn-warning" name="btnReset">
                    <i class="fa fa-refresh"></i>
                    ยกเลิกการเปลี่ยนแปลง
                </button>
            </form>
        </div>
    </div>
</div>

<?php include  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>