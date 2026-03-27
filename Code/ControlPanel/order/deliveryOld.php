<?php $_COG_ITEM_CODE = 'ORDER'; ?>
<?php include  "../header.php"; ?>
<?php
if(isset($_POST["btnChangType"])){
    $sqlUpdate = "update website set
    DeliveryType = '".$_POST["rdo-deliverytype"]."'
    ";
    ExecuteSQL($sqlUpdate);
}

if(isset($_POST["btnDeleteRow"])){
    $sql = "DELETE FROM `delivery_type` WHERE `Code` = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
}

$sqlWeb = "select * from website limit 1";
$dataWeb = SelectRow($sqlWeb);
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
    <span class="link-history-btn">ประเภทการจัดส่ง</span>



</div>

<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
        <div class="col-md-2">
            <?php 
            $_LEFT_MENU_ACTIVE = "DELIVERY";
            include "leftMenu.php";
            ?>
        </div>
        <div class="col-md-10">
            <div>
                <a href="deliveryDetail.php" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการประเภทการจัดส่ง
                </a>
                <span><b>รายการประเภทการจัดส่ง</b></span>
                <hr style="margin-top: 5px;" />
            </div>

            <form action="delivery.php" method="post">
                <div class="hide">
                    <div class="text-primary">
                    <label>
                        <input type="radio" name="rdo-deliverytype" id="rdo-deliverytype-OPTION" value="OPTION" onchange="return ChangType();"
                        <?php echo $dataWeb["DeliveryType"] == "OPTION" ? ' checked="checked" ' : "" ?> />
                        &nbsp;คิดตามประเภทการจัดส่ง</label>
                    </div>
                    <br>
                    <div>
                        <table class="jquery-datatable display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">รหัส</th>
                                    <th>ประเภทการจัดส่ง</th>
                                    <th style="width: 100px;" class="text-right">ค่าจัดส่ง</th>
                                    <th style="width: 50px;" class="text-center">ใช้งาน</th>
                                    <th style="width: 50px;" class="text-center">จัดการ</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="width: 50px;">รหัส</th>
                                    <th>ประเภทการจัดส่ง</th>
                                    <th style="width: 100px;" class="text-right">ค่าจัดส่ง</th>
                                    <th style="width: 50px;" class="text-center">ใช้งาน</th>
                                    <th style="width: 50px;" class="text-center">จัดการ</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                            
                                $sql = "select * from delivery_type where DeliveryType = 'OPTION' order by Code";
                                $datas = SelectRowsArray($sql);
                                foreach($datas as $data){
                                ?>
                                <tr>
                                    <td><?php echo $data["Code"] ?></td>
                                    <td>

                                        <?php echo $data["Name"] ?>

                                    </td>
                                    <td class="text-right"><?php echo number_format($data["Price"]) ?></td>
                                    <td class="text-center">
                                        <?php echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="deliveryDetail.php?ref=<?php echo $data["Code"] ?>">
                                            <i class="fa fa-cog"></i>
                                        </a>
                                        <button type="submit" class="btn-link" 
                                            onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                            value="<?php echo $data["Code"] ?>" name="btnDeleteRow">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <hr />
                </div>

                <div class="">
                    <div class="text-primary">
                        <label><input type="radio" name="rdo-deliverytype" id="rdo-deliverytype-RATE" value="RATE" onchange="return ChangType();"
                            <?php echo $dataWeb["DeliveryType"] == "RATE" ? ' checked="checked" ' : "" ?> />
                            &nbsp;คิดตามจำนวนชิ้น</label>
                    </div>
                    <br>
                    <div>
                        <table class="jquery-datatable display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">รหัส</th>
                                    <th class="hide">ประเภทการจัดส่ง</th>
                                    <th style="width: 100px;" class="text-right">ขั้นต่ำ (ชิ้น)</th>
                                    <th style="width: 100px;" class="text-right">ค่าจัดส่ง</th>
                                    <th style="width: 50px;" class="text-center">ใช้งาน</th>
                                    <th style="width: 50px;" class="text-center">จัดการ</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="width: 50px;">รหัส</th>
                                    <th class="hide">ประเภทการจัดส่ง</th>
                                    <th style="width: 100px;" class="text-right">ขั้นต่ำ (ชิ้น)</th>
                                    <th style="width: 100px;" class="text-right">ค่าจัดส่ง</th>
                                    <th style="width: 50px;" class="text-center">ใช้งาน</th>
                                    <th style="width: 50px;" class="text-center">จัดการ</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                            
                                $sql = "select * from delivery_type where DeliveryType = 'RATE' order by Unit";
                                $datas = SelectRowsArray($sql);
                                foreach($datas as $data){
                                ?>
                                <tr>
                                    <td><?php echo $data["Code"] ?></td>
                                    <td class="hide">
                                        <?php echo $data["Name"] ?>
                                    </td>
                                    <td class="text-right"><?php echo number_format($data["Unit"]) ?></td>
                                    <td class="text-right"><?php echo number_format($data["Price"]) ?></td>
                                    <td class="text-center">
                                        <?php echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="deliveryDetail.php?ref=<?php echo $data["Code"] ?>">
                                            <i class="fa fa-cog"></i>
                                        </a>
                                        <button type="submit" class="btn-link" 
                                            onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                            value="<?php echo $data["Code"] ?>" name="btnDeleteRow">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="hide">
                    <input type="submit" name="btnChangType" id="btnChangType" value="" />
                    <input type="hidden" name="hddDefaultType" id="hddDefaultType" value="<?php echo $dataWeb["DeliveryType"] ?>" />
                    <script>
                        function ChangType() {
                            if (confirm("ยืนยันการเปลียนแปลงหรือไม่ ?")) {
                                $("#btnChangType").click();
                                return true;
                            } else {
                                var type = $("#hddDefaultType").val();
                                $("[name='rdo-deliverytype']").prop("checked", false);
                                $("#rdo-deliverytype-" + type).prop("checked", true);
                                return false;
                            }
                        }
                    </script>
                </div>
                
            </form>
        </div>
    </div>
</div>



<?php include  "../footer.php"; ?>