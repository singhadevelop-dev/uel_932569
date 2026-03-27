<?php include  "../header.php"; ?>
<?php
$_ALLOW_2_LANGUAGE_MENU = false;
if (isset($_POST["btnSave"])) {
    $PageCode = $_POST["PageCode"];
    $PageName = $_POST["PageName"];
    $PageNameTH = $_POST["PageNameTH"];
    $PageURLName = $_POST["PageURLName"];
    $Title = $_POST["Title"];
    $Description = $_POST["Description"];
    $Keyword = $_POST["Keyword"];
    for ($i = 0; $i < count($PageCode); $i++) {
        $sql = "update page_config set 
                 PageName = '$PageName[$i]'
                ,PageNameTH = '$PageNameTH[$i]'
                ,PageURLName = '".SanitizeURL($PageURLName[$i],true)."'
                ,Title = '$Title[$i]'
                ,Description = '$Description[$i]'
                ,Keyword = '$Keyword[$i]'
                where PageCode = '$PageCode[$i]'
                ";
        ExecuteSQL($sql);
    }
    GenerateHTAccess();
}
?>
<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-9">
            <h3 style="margin: 0;"><i class="fa fa-file-text-o fa-fw"></i>
                <span class="analysis-left-menu-desc">ตั้งค่าหน้าเพจ</span></h3>
        </div>
        <div class="col-sm-3" style="padding-top: 5px;">
        </div>
    </div>
</div>
<div class="mat-box grey-bar">
    <a href="page.php" class="link-history-btn">หน้าหลักตั้งค่าหน้าเพจ</a>
    /
    <span class="link-history-btn">รายการหน้าเพจ</span>
</div>
<form method="post" class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
        <div class="col-md-12">
            <div>
                <button type="submit" name="btnSave" class="btn btn-success btn-sm pull-right" style="margin-top:-8px;">
                    <i class="fa fa-save"></i>
                    บันทึกการเปลี่ยนแปลง
                </button>
                <span><b>รายการหน้าเพจ</b></span>
                <hr style="margin-top: 5px;" />
            </div>
            <style>
                .table th{
                    text-align: center;
                }
                .table th,
                .table td{
                    vertical-align: middle;
                }
            </style>
            <table class="table table-striped table-hover table-bordered small" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Page</th>
                        <th>ชื่อเมนู</th>
                        <?php if ($_ALLOW_2_LANGUAGE_MENU) { ?>
                            <th>ชื่อเมนูภาษาไทย</th>
                        <?php } ?>
                        <th>ชื่อแสดงบน URL</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Keyword</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Page</th>
                        <th>ชื่อเมนู</th>
                        <?php if ($_ALLOW_2_LANGUAGE_MENU) { ?>
                            <th>ชื่อเมนูภาษาไทย</th>
                        <?php } ?>
                        <th>ชื่อแสดงบน URL</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Keyword</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $sql = "select * from page_config where Active=1 order by SEQ";
                    $datas = SelectRows($sql);
                    while ($data = $datas->fetch_array()) {
                    ?>
                        <tr>
                            <td>
                                <span class="hide"><?php echo $data["SEQ"] ?></span>
                                <small><?php echo $data["PageCode"] ?></small>
                                <input type="hidden" name="PageCode[]" value="<?php echo $data["PageCode"] ?>" />
                            </td>
                            <td>
                                <input type="text" name="PageName[]" class="form-control input-sm" value="<?php echo $data["PageName"] ?>" />
                            </td>
                            <?php if ($_ALLOW_2_LANGUAGE_MENU) { ?>
                                <td>
                                    <input type="text" name="PageNameTH[]" class="form-control input-sm" value="<?php echo $data["PageNameTH"] ?>" />
                                </td>
                            <?php } ?>
                            <td>
                                <input type="text" name="PageURLName[]" class="form-control input-sm" value="<?php echo $data["PageURLName"] ?>" />
                            </td>
                            <td>
                                <input type="text" name="Title[]" class="form-control input-sm" value="<?php echo $data["Title"] ?>" />
                            </td>
                            <td>
                                <input type="text" name="Description[]" class="form-control input-sm" value="<?php echo $data["Description"] ?>" />
                            </td>
                            <td>
                                <input type="text" name="Keyword[]" class="form-control input-sm" value="<?php echo $data["Keyword"] ?>" />
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</form>
<?php include  "../footer.php"; ?>