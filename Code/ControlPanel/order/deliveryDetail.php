<?php $_COG_ITEM_CODE = 'ORDER'; ?>
<?php include  "../header.php"; ?>
<?php 

if(isset($_POST["btnSave"])){
    
    $txtSubject = $_POST["txtSubject"];
    $txtPrice = $_POST["txtPrice"];
    $chkActive = isset($_POST["chkActive"]) ? 1 : 0;
    $Unit = $_POST["txtUnit"];
    $DeliveryType = $_POST["rdo-deliverytype"];
    
    $sql = "";
    if(empty($_GET["ref"])){
        $genID = GenerateNextID("delivery_type","Code",5,"D");
        $sql = "insert into delivery_type (Code,Name,Price,Active,CreatedOn,CreatedBy,Unit,DeliveryType) values(
                '$genID'
                ,'$txtSubject'
                ,'$txtPrice'
                ,$chkActive
                ,NOW()
                ,'".UserService::UserCode()."'
                ,'$Unit'
                ,'$DeliveryType'
            );
        ";
    }else{
        $sql = "update delivery_type set
                Name = '$txtSubject'
                ,Price = '$txtPrice'
                ,Active = $chkActive
                ,Unit = '$Unit'
                ,DeliveryType = '$DeliveryType'
                ,UpdatedOn = NOW()
                ,UpdatedBy = '".UserService::UserCode()."'
                where Code = '".$_GET["ref"]."'
        ";
    }
    
    ExecuteSQLTransaction($sql,"delivery.php");
}

if(!empty($_GET["ref"]))
{
    $sql = "select * from delivery_type where Code = '".$_GET["ref"]."'";
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
    <a href="delivery.php" class="link-history-btn">ประเภทการจัดส่ง</a>
    /
    <span class="link-history-btn">จัดการประเภทการจัดส่ง</span>



</div>

<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <form method="post" id="form-data">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <span><b><?php echo empty($_GET["ref"]) ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล ".$_GET["ref"] ?></b></span>
                    <hr style="margin-top: 5px;" />
                </div>
                
                <div class="row hide">
                    <div class="col-sm-12 text-primary">
                        <span class="hide">
                        <label>
                            <input type="radio" name="rdo-deliverytype" id="rdo-deliverytype-OPTION" value="OPTION" onchange="ChangType();"
                            <?php echo !empty($_GET["ref"]) && $data["DeliveryType"] == "OPTION" ? ' checked="checked" ' : "" ?> />
                            &nbsp;คิดตามประเภทการจัดส่ง</label>
                            &nbsp;&nbsp;&nbsp;
                        </span>
                        
                        <span>
                        <label><input type="radio" name="rdo-deliverytype" id="rdo-deliverytype-RATE" value="RATE" onchange="ChangType();"
                            <?php echo !empty($_GET["ref"]) && $data["DeliveryType"] == "RATE" ? ' checked="checked" ' : ( empty($_GET["ref"]) ? ' checked="checked" ' : "") ?> />
                            &nbsp;คิดตามจำนวนชิ้น</label>
                        </span>
                    </div>
                </div>

                <div class="row hide">
                    <div class="col-sm-6 hide">
                        <label>ประเภทประเภทการจัดส่ง</label>
                        <input type="text" name="txtSubject" id="txtSubject" value="<?php echo $data["Name"] ?>" class="form-control input-sm require" />
                    </div>
                  
                </div>

                 <div class="row">
                    <div class="col-sm-4 display-type-RATE 
                    <?php echo !empty($_GET["ref"]) && $data["DeliveryType"] == "OPTION" ? ' hide ' : (empty($_GET["ref"]) ? ' hide ' : "") ?>">
                        <label>จำนวนชิ้นขั้นต่ำ</label>
                        <input type="number" step="1" name="txtUnit" id="txtUnit" value="<?php echo $data["Unit"] ?>" class="form-control input-sm require"
                            data-default="<?php echo !empty($_GET["ref"]) && $data["DeliveryType"] == "OPTION" ? '9999' : (empty($_GET["ref"]) ? '1' : $data["Unit"]) ?>" />
                    </div>
                    <div class="col-sm-4">
                        <label>ราคาการจัดส่ง</label>
                        <input type="number" min="0" step="1" name="txtPrice" id="txtPrice" value="<?php echo $data["Price"] ?>" class="form-control input-sm require text-right" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
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

                    <a href="delivery.php" class="btn btn-danger">
                        <i class="fa fa-remove"></i>
                        ยกเลิก
                    </a>
                </div>


                <script>
                    function ChangType() {

                        if ($("[name='rdo-deliverytype']:checked").val() == "OPTION") {
                            $(".display-type-RATE").addClass('hide');
                            var value = $("#txtUnit").val();
                            $("#txtUnit").attr('data-default', value);
                            $("#txtUnit").val('9999');
                        } else if ($("[name='rdo-deliverytype']:checked").val() == "RATE") {
                            $(".display-type-RATE").removeClass('hide');
                            $("#txtUnit").val($("#txtUnit").attr('data-default'));
                        }
                    }
                    ChangType();
                </script>
            </div>
        </div>
    </form>
</div>


<?php include  "../footer.php"; ?>