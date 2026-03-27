<?php include  "../header.php"; ?>


<?php 

if(isset($_POST["btnSave"])){
    
    for ($i = 0; $i < count($_POST["hddSEQ"]); $i++)
    {
    	$seq = $_POST["hddSEQ"][$i];
        $icon = $_POST["hddIcon"][$i];
        $title = $_POST["txtTitle"][$i];
        $desc = $_POST["txtDescription"][$i];
        
        $sql = "update website_featured set
            Icon = '$icon',
            Title = '$title',
            Description = '$desc'
            where SEQ = '$seq'";
        ExecuteSQL($sql);
        
    }
    
    
}

?>

<link rel="stylesheet" href="/assets/css/factory-icons.css" />

<?php 
    $iconCss = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/assets/css/factory-icons.css");
    $iconArr = explode(".",$iconCss);
    $iconList = array();
    foreach ($iconArr as $i)
    {
        $ic = explode(":before",$i);
    	if(count($ic) == 2){
            array_push($iconList,$ic[0]);
        }
    }
?>

<style>
    .icon-list{
        cursor:pointer;
        padding:20px 0;
    }
    .icon-list i{
        font-size:40px;
        cursor:pointer;
    }
    .icon-list:hover{
        background:#eee;
    }
    .icon-list.active{
        background:#F58512;
        color:#fff;
    }
    .icon-display{
        font-size:70px;
        display:block;
        margin-bottom:10px;
    }
    .icon-highlight{
        background:yellow;
        font-weight:600;
    }
</style>
<script>
    var chooser = null;
    function openChooseIcon(obj, icon) {
        chooser = $(obj);
        chooseIcon($(obj).prev().val());
        $("#modal-icon").modal("show");
    }
    function chooseIcon(icon) {
        $("#modal-icon .icon-list").removeClass("active");
        $("#modal-icon .icon-list[data-icon-class='" + icon + "']").addClass("active");
    }
    function saveChooseIcon() {
        var iconClass = $("#modal-icon .icon-list.active").attr("data-icon-class");
        chooser.prev().val(iconClass);
        chooser.closest(".icon-box").find(".icon-display").attr("class", "icon-display " + iconClass);
        $("#modal-icon").modal("hide");
    }
    function searchIcon(obj) {
        var val = $(obj).val().trim();
        if (val == "") {
            $("#modal-icon .icon-list-container").show();
            $("#modal-icon .icon-list-container .icon-highlight").removeClass("icon-highlight");
            return;
        }

        var icons = $("#modal-icon .search-target");
        icons.each(function () {
            var m = false;
            var iconClass = $(this).attr("data-search");
            if (iconClass.match(val)) {
                $(this).html(iconClass.split(val).join("<span class='icon-highlight'>" + val + "</span>"));
                m = true;
            }
            $(this).closest(".icon-list-container").toggle(m);
        });
    }
    //$(document).ready(function () {
    //    $("#modal-icon").modal("show");
    //});
</script>
<!-- Modal -->
<div id="modal-icon" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <input type="text" name="name" value="" class="form-control pull-right input-sm" onkeyup="searchIcon(this);" style="width:200px;" placeholder="ค้นหา..." />
                <h4 class="modal-title">เลือกไอคอน</h4>
            </div>
            <div class="modal-body" style="max-height:calc(100vh - 180px);overflow-y:auto">
                <div class="row">
                    <?php foreach ($iconList as $icon)
                     {?>
 	                <div class="col-xs-3 icon-list-container text-center" >
                        <div class="icon-list" data-icon-class="<?php echo $icon ?>" onclick="chooseIcon('<?php echo $icon ?>');">
                            <i class="<?php echo $icon ?>"></i>
                            <br />
                            <span class="search-target" data-search="<?php echo str_replace("fc-icon-","",$icon) ?>" style="font-size:12px;">
                                <?php echo str_replace("fc-icon-","",$icon) ?>
                            </span>
                        </div>
                    </div>
                     <?php }
                      ?>
                </div>
            </div>
            <div class="modal-footer">
                
                <button type="button" onclick="saveChooseIcon();" class="btn btn-primary">เลือก</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>

    </div>
</div>


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

    <a href="/ControlPanel/" class="link-history-btn">จัดการเว็บไซต์ทั่วไป</a>
    /
    <span class="link-history-btn">ตั้งค่าแบนเนอร์</span>



</div>
<form method="post" class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row">
        <div class="col-md-3">
            <?php 
                $_LEFT_MENU_ACTIVE = "FEAYURED";
                include $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/home/leftMenu.php"; 
                ?>
        </div>
        <div class="col-md-9">
            <div>
                <button type="submit" name="btnSave" class="btn btn-success btn-sm pull-right" style="margin-top:-8px;">
                    <i class="fa fa-save"></i>
                    บันทึกการเปลี่ยนแปลง
                </button>

                <span><b>อัตลักษณ์ขององค์กร</b></span>
                <hr style="margin-top: 5px;" />

                <?php
                
                $sql = "select * from website_featured order by seq";
                $datas = SelectRows($sql);
                while($data = $datas->fetch_array()){
                ?>

                <div class="row">
                    <div class="col-sm-4 text-center icon-box">
                        <i class="icon-display <?php echo $data["Icon"] ?>"></i>
                        <input type="hidden" name="hddSEQ[]" value="<?php echo $data["SEQ"] ?>" />
                        <input type="hidden" name="hddIcon[]" value="<?php echo $data["Icon"] ?>" />
                        <a href="javascript:;" onclick="openChooseIcon(this)">
                            <i class="fa fa-pencil"></i>
                            เปลี่ยนไอคอน
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>หัวข้อ</label>
                                <input type="text" placeholder="หัวข้อ.." class="form-control require" name="txtTitle[]" value="<?php echo $data["Title"] ?>" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label>คำอธิบาย</label>
                                <textarea class="form-control require" name="txtDescription[]" placeholder="คำอธิบาย..."><?php echo $data["Description"] ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <?php
                }
                ?>

            </div>
        </div>
    </div>
</form>

<form method="post" class="hide">
    <textarea id="txtSortable" name="txtSortable">[]</textarea>
    <input type="submit" id="btnSortable" name="btnSortable" value="" />
</form>

<?php include  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>