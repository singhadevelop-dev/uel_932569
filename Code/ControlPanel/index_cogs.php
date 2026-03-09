<?php include  "header.php"; ?>
<?php 
if(isset($_POST["btnSave"])){
    $sqlUpdate = "update website set
    cogs_logo_path = '".$_POST["cogs_logo_path"]."'
    ,cogs_logo_width = '".$_POST["cogs_logo_width"]."'
    ,cogs_logo_height = '".$_POST["cogs_logo_height"]."'
    ,cogs_email_host = '".$_POST["cogs_email_host"]."'
    ,cogs_email_username = '".$_POST["cogs_email_username"]."'
    ,cogs_email_password = '".$_POST["cogs_email_password"]."'
    ,cogs_host_name = '".$_POST["cogs_host_name"]."'
    ,cogs_host_extension = '".$_POST["cogs_host_extension"]."'
    ,cogs_google_tag_manager = '".$_POST["cogs_google_tag_manager"]."'
    ,cogs_google_analytics = '".$_POST["cogs_google_analytics"]."'
    ,AppIDPaypal='".$_POST["AppIDPaypal"]."'
    ";
    ExecuteSQL($sqlUpdate);
}

if(isset($_POST["btnConvertPath"])){
    $sqlselect = "select table_name,column_name from page_config_image_path ";
    $path_datas = SelectRowsArray($sqlselect);
    $cogs_image_path_from = $_POST["cogs_image_path_from"];
    $cogs_image_path_to = $_POST["cogs_image_path_to"];
    $_arr_sql = array();
    foreach ($path_datas as $path) {
        $_where_con = " and ".$path["column_name"]." NOT LIKE '".$cogs_image_path_to."%' ";
        if(empty($cogs_image_path_to)){
            $_where_con = " and ".$path["column_name"]." LIKE '".$cogs_image_path_from."%' ";
        }
        array_push($_arr_sql,"update ".$path["table_name"]." set ".$path["column_name"]." = Concat('$cogs_image_path_to','',REPLACE(".$path["column_name"].",'$cogs_image_path_from',''))
        WHERE 1=1
        and ".$path["column_name"]." NOT LIKE 'https://%' 
        and ".$path["column_name"]." NOT LIKE 'http://%' 
        $_where_con
        and ".$path["column_name"]." <> ''");
    }
    ExecuteMultiSQL(join(";",$_arr_sql));
    AlertSuccess("success","Change Path Success.");
}

if(isset($_POST["btnChnageSubPath"])){
    $num = intval($_POST["cogs_root_parent_count"]);
    $str = '<?php 
    $_ROOT_PARENT_COUNT = '.$num.';
    $_ROOT_DIR_ = strpos($_SERVER["HTTP_HOST"], "localhost.") !== false ?  explode("\\\",__DIR__) : explode("/",__DIR__);
    $_ROOT_DIR_CLIENT = "";
    for ($i=$_ROOT_PARENT_COUNT; $i >0 ; $i--) { 
        $_ROOT_DIR_CLIENT .= "/".$_ROOT_DIR_[count($_ROOT_DIR_) - $i];
    }
    $GLOBALS["ROOT"] = $_ROOT_DIR_CLIENT;
    $GLOBALS["DOCUMENT_ROOT"] = __DIR__;
?>';
    $strFileName = "../_cogs.php";
    $fp=fopen($strFileName,'w');
    fwrite($fp, $str);
    fclose($fp);
    Redirect("index_cogs.php");
    //AlertSuccess("success","Change Sub folder Success.");
}


?>
<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-9">
            <h3 style="margin: 0;"><i class="fa fa-cogs fa-fw"></i>
                <span class="analysis-left-menu-desc">คอนฟิกระบบ</span></h3>
        </div>
        <div class="col-sm-3" style="padding-top: 5px;">
        </div>
    </div>
</div>
<div class="mat-box grey-bar">
    <a href="/ControlPanel/index_cogs" class="link-history-btn">System configurations</a>
</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
<div class="alert alert-info">
    <div class="row">
        <div class="col-md-12">
            <style>
                .picked td {
                    background-color: rgba(176, 243, 76, 0.4) !important;
                }
                    .picked td:first-child {
                        border-left: 3px solid rgba(176, 243, 76, 1);
                    }
                .no-picked td {
                    background-color: rgba(255, 0, 0,0.2) !important;
                }
                    .no-picked td:first-child {
                        border-left: 3px solid rgba(255, 0, 0,1);
                    }
            </style>
            <form method="post">
                <?php 
                $sql = "select * from website limit 1";
                $data = SelectRow($sql);
                // $_DEFAULT_MAP_LOCATION = $data["MapLocation"];
                // include("GoogleMap/location.php") 
                ?>
                <span><b>Logo Config</b></span>
                <hr style="margin-top: 5px;" />
                <div class="row">
                    <div class="col-sm-4">
                        <label>Logo Path</label>
                        <input type="text" class="form-control require" name="cogs_logo_path" value="<?php echo $data["cogs_logo_path"] ?>" />
                    </div>
                    <div class="col-sm-4">
                        <label>Logo Width</label>
                        <input type="text" class="form-control require" name="cogs_logo_width" value="<?php echo $data["cogs_logo_width"] ?>" />
                    </div>
                    <div class="col-sm-4">
                        <label>Logo Height</label>
                        <input type="text" class="form-control require" name="cogs_logo_height" value="<?php echo $data["cogs_logo_height"] ?>" />
                    </div>
                </div>
                <br />
                <span><b>Email Config</b></span>
                <hr style="margin-top: 5px;" />
                <div class="row">
                    <div class="col-sm-4">
                        <label>Email Host</label>
                        <input type="text" class="form-control require" name="cogs_email_host" value="<?php echo $data["cogs_email_host"] ?>" />
                    </div>
                    <div class="col-sm-4">
                        <label>Email Username</label>
                        <input type="text" class="form-control require" name="cogs_email_username" value="<?php echo $data["cogs_email_username"] ?>" />
                    </div>
                    <div class="col-sm-4">
                        <label>Email password</label>
                        <input type="text" class="form-control require" name="cogs_email_password" value="<?php echo $data["cogs_email_password"] ?>" />
                    </div>
                </div>
                <br />
                <span><b>Host Config</b></span>
                <hr style="margin-top: 5px;" />
                <div class="row">
                    <div class="col-sm-4">
                        <label>Host Name</label>
                        <input type="text" class="form-control require" name="cogs_host_name" value="<?php echo $data["cogs_host_name"] ?>" />
                    </div>
                    <div class="col-sm-4">
                        <label>Host Extension</label>
                        <input type="text" class="form-control require" name="cogs_host_extension" value="<?php echo $data["cogs_host_extension"] ?>" />
                    </div>
                </div>

                <br />
                <span><b>Paypal Application ID </b></span>
                <hr style="margin-top: 5px;" />
                <div class="row">
                    <div class="col-sm-8">
                        <label>Paypal App ID</label>
                        <input type="text" class="form-control" name="AppIDPaypal" value="<?php echo $data["AppIDPaypal"] ?>" />
                    </div>
                </div>

                <br />
                <span><b>Google Key Config</b></span>
                <hr style="margin-top: 5px;" />
                <div class="row">
                    <div class="col-sm-4">
                        <label>Google Tag Manager</label>
                        <input type="text" class="form-control" name="cogs_google_tag_manager" value="<?php echo $data["cogs_google_tag_manager"] ?>" />
                    </div>
                    <div class="col-sm-4">
                        <label>Google Analytics</label>
                        <input type="text" class="form-control" name="cogs_google_analytics" value="<?php echo $data["cogs_google_analytics"] ?>" />
                    </div>
                </div>

                <hr />
                <button type="submit" class="btn btn-success" onclick="return Validate(this);" name="btnSave">
                    <i class="fa fa-save"></i>
                    บันทึกการเปลี่ยนแปลง
                </button>
                <button type="reset" class="btn btn-warning" name="btnReset">
                    <i class="fa fa-refresh"></i>
                    ยกเลิกการเปลี่ยนแปลง
                </button>
            </form>
        </div>
    </div>
</div>

<div class="alert alert-warning">
    <div class="row">
        <div class="col-sm-12">
            <form method="post">
                <span><b>Image Config Path <span class="text-danger">(เปลี่ยนที่อยู่รูปภาพบางส่วน ไม่รวม column ว่างเปล่า)</span></b></span>
                <hr style="margin-top: 5px;" />
                <div class="row">
                    <div class="col-sm-4">
                        <label>Path From</label>
                        <input type="text" class="form-control" name="cogs_image_path_from" value="" placeholder="/systempath1" />
                    </div>
                    <div class="col-sm-4">
                        <label>Path To</label>
                        <input type="text" class="form-control" name="cogs_image_path_to" value="" placeholder="/systemChange" />
                    </div>
                    <div class="col-sm-4">
                        <br>
                        <button type="submit" onclick="return ValidateChangePath(this);" class="btn btn-primary" onclick="" name="btnConvertPath">
                            <i class="fa fa-exchange"></i>
                                ทำรายการเปลี่ยนแปลงที่อยู่
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?php
                $_TEXT_CONFIGS = file("../_cogs.php", FILE_IGNORE_NEW_LINES);
                $_NUMBER_SUB = 0;
                foreach ($_TEXT_CONFIGS as $key => $value) {
                    if(strpos($value, '$_ROOT_PARENT_COUNT') !== false){
                        $arr = explode("=",$value);
                        $_NUMBER_SUB = intval(trim(str_replace(";","",$arr[1])));
                        break;
                    }
                }
            ?>
            <form method="post">
                <br />
                <span><b>Sub Folder Path <span class="text-danger">(เปลี่ยนจำนวนซับโฟล์เดอร์ย่อยในเว็บไซต์)</span></b></span>
                <hr style="margin-top: 5px;" />
                <div class="row">
                    <div class="col-sm-2">
                        <label>Sub Path Number</label>
                        <input type="number" name="cogs_root_parent_count" class="form-control text-right" value="<?php echo $_NUMBER_SUB ?>" required>
                    </div>
                    <div class="col-sm-3">
                        <br>
                        <button type="submit" class="btn btn-primary" onclick="" name="btnChnageSubPath">
                            <i class="fa fa-folder-open"></i>
                                เปลี่ยนแปลงจำนวนซับโฟลเดอร์ย่อย
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
    
</div>
<script>
    function ValidateChangePath(obj)
    {
        if($("[name='cogs_image_path_from']").val() == "" && $("[name='cogs_image_path_to']").val() == ""){
            AlertError("ไม่มีการระบุ path form และ path to!");
            return false;
        }
        if(AlertConfirm(obj,"ยืนยันรายการ")){
            return true;
        }
        return false;
    }
</script>
<?php include  "footer.php"; ?>