<?php include_once  "../_master/_master.php"; ?>

<?php 

if(isset($_POST["btnSave"])){
    
    $txtSubject = $_POST["txtSubject"];
    $chkActive = isset($_POST["chkActive"]) ? 1 : 0;
    
    $sql = "";
    if(empty($_GET["ref"])){
        $genID = GenerateNextID("area_road","RoadCode",5,"R");
        $sql = "insert into area_road (RoadCode,RoadName,Active,CreatedOn,CreatedBy,RoadGroup) values(
                '$genID'
                ,'$txtSubject'
                ,$chkActive
                ,NOW()
                ,'".UserService::UserCode()."'
                ,'$_COG_ITEM_CODE'
            );
        ";
    }else{
        $sql = "update area_road set
                RoadName = '$txtSubject'
                ,Active = $chkActive
                ,UpdatedOn = NOW()
                ,UpdatedBy = '".UserService::UserCode()."'
                where RoadCode = '".$_GET["ref"]."'
        ";
    }
    
    ExecuteSQLTransaction($sql,"itemRoad.php");
}

if(!empty($_GET["ref"]))
{
    $sql = "select * from area_road where RoadCode = '".$_GET["ref"]."'";
    $data = SelectRow($sql);
}
$_COG_ALLOW_ROAD_NAME = !empty($_COG_ALLOW_ROAD_NAME) ? $_COG_ALLOW_ROAD_NAME : "ชื่อถนน";
?>



<div class="mat-box grey-bar">

    <a href="item.php" class="link-history-btn">หน้าหลัก<?php echo $_COG_ITEM_NAME ?></a>
    /
    <a href="itemRoad.php" class="link-history-btn">รายการ<?php echo $_COG_ALLOW_LEFT_MENU_ROAD ? "ถนน" : "" ?><?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">จัดการข้อมูล<?php echo $_COG_ALLOW_LEFT_MENU_ROAD ? "ถนน" : "" ?><?php echo $_COG_ITEM_NAME ?></span>
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
                        <label><?php echo $_COG_ALLOW_ROAD_NAME ?></label>
                        <input type="text" name="txtSubject" id="txtSubject" value="<?php echo $data["RoadName"] ?>" class="form-control input-sm require" />
                    </div>
                    <div class="col-sm-6 text-right">
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

                    <a href="itemRoad.php" class="btn btn-danger">
                        <i class="fa fa-remove"></i>
                        ยกเลิก
                    </a>
                </div>



            </div>
        </div>
    </form>
</div>


<?php include  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>