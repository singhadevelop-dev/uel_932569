<?php $_COG_ITEM_CODE = 'ORDER'; ?>
<?php include  "../header.php"; ?>
<?php 

if(isset($_POST["btnSave"])){
    $SEQ = $_POST["SEQ"];
    $Active = $_POST["Active"];
    $Value = $_POST["Value"];
    for ($i = 0; $i < count($Active); $i++)
    {
    	$sql = "update order_channel set 
                 Value = '$Value[$i]'
                ,Active = '$Active[$i]'
                where SEQ = '$SEQ[$i]'
                ";
        ExecuteSQL($sql);
    }
    
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
    <span class="link-history-btn">ช่องทางการสั่งซื้อ</span>



</div>

<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <form method="post" class="row">
        <div class="col-md-3">
            <?php 
            $_LEFT_MENU_ACTIVE = "CHANNEL";
            include "leftMenu.php"; 
            ?>
        </div>
        <div class="col-md-9">
            <div>
                <button type="submit" name="btnSave" class="btn btn-success btn-sm pull-right" style="margin-top: -8px;">
                    <i class="fa fa-save"></i>
                    บันทึกการเปลี่ยนแปลง
                </button>

                <span><b>รายการช่องทางการสั่งซื้อ</b></span>
                <hr style="margin-top: 5px;" />
            </div>



            <table class="jquery-datatable display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="width: 50px;">ใช้งาน</th>
                        <th style="width: 100px;">ช่องทาง</th>
                        <th class="text-right">ตั้งค่า</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th style="width: 50px;">ใช้งาน</th>
                        <th style="width: 100px;">ช่องทาง</th>
                        <th class="text-right">ตั้งค่า</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    
                    $sql = "select * from order_channel order by SEQ";
                    $datas = SelectRowsArray($sql);
                    foreach($datas as $data){
                    ?>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" onchange="checkboxChange(this);" <?php echo $data["Active"] == 1 ? "checked" : "" ?> value="" />
                            <input type="hidden" name="Active[]" class="hdd-active" value="<?php echo $data["Active"]?>" />
                            <input type="hidden" name="SEQ[]" value="<?php echo $data["SEQ"] ?>" />
                        </td>
                        <td><?php echo $data["Name"] ?></td>
                        <td>
                            <input type="text"
                                placeholder="ตัวอย่าง : <?php echo $data["Example"] ?>"
                                class="form-control input-sm" name="Value[]" value="<?php echo $data["Value"] ?>" />

                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <script>
                function checkboxChange(obj) {
                    if (obj.checked) {
                        $(obj).closest("tr").find(".hdd-active").val(1);
                    } else {
                        $(obj).closest("tr").find(".hdd-active").val(0);
                    }
                }
            </script>

        </div>
    </form>
</div>

<?php include  "../footer.php"; ?>