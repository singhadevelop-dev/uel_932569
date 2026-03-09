<?php $_COG_ITEM_CODE = 'TRANSACTION'; ?>
<?php include  "../header.php"; ?>

<?php 


if(isset($_POST["btnPicked"])){
    $sqlUpdate = "update member set
    Picked = 1
    where MemberCode = '".$_POST["btnPicked"]."'";
    ExecuteSQL($sqlUpdate);
    
}
?>

<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-9">
            <h3 style="margin: 0;">

                <i class="fa fa-dollar fa-fw"></i>
                <span class="analysis-left-menu-desc">รายการสั่งซื้อทั้งหมด</span>

            </h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

<div class="mat-box grey-bar">

    <a href="transaction.php" class="link-history-btn">รายการสั่งซื้อทั้งหมด</a>
    /
    <span class="link-history-btn">รายการสั่งซื้อ</span>



</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row">
        <div class="col-md-2 hide">
            <?php 
            $_LEFT_MENU_ACTIVE = "TARNSACTION";
            include "leftMenu.php"; 
            ?>
        </div>
        <div class="col-md-12">
            <style>
                .picked td{
                    background-color:rgba(176, 243, 76, 0.4) !important;
                }
                .picked td:first-child {
                    border-left:3px solid rgba(176, 243, 76, 1);
                }
                .no-picked td{
                    background-color:rgba(255, 0, 0,0.2) !important;
                }
                .no-picked td:first-child {
                    border-left:3px solid rgba(255, 0, 0,1);
                }
            </style>
            <div>
                <span><b>รายการสั่งซื้อทั้งหมด</b></span>
                <hr style="margin-top: 5px;" />

                <script>
                    _datatableOptions = {
                        "order": [[1, "desc"]]
                    }
                </script>
                <table class="jquery-datatable display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:100px;">เลขที่เอกสาร</th>
                            <th style="width:120px;">วัน / เวลา</th>
                            <th>ชื่อผู้ติดต่อ</th>
                            <th class="text-right">มูลค่า</th>
                            <!-- <th style="width:80px;">ส่งโดย</th> -->
                            <th class="text-center">สถานะ</th>
                            <th style="width:100px;" class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th style="width:100px;">เลขที่เอกสาร</th>
                            <th style="width:120px;">วัน / เวลา</th>
                            <th>ชื่อผู้ติดต่อ</th>
                            <th class="text-right">มูลค่า</th>
                            <!-- <th style="width:80px;">ส่งโดย</th> -->
                            <th class="text-center">สถานะ</th>
                            <th style="width:100px;" class="text-center">จัดการ</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                    
                        $sql = "select a.* , b.province_name, c.Name as shipping_name
                            from checkout a 
                            left join tbl_r_province b on a.DelivieryCode = b.province_id
                            left join delivery_category c on a.DelivieryCode = c.Code
                            order by a.CreatedOn desc";
                        $datas = SelectRows($sql);
                        foreach ($datas as $data) {
                        ?>
                        <tr>
                            <td><?php echo $data["CheckOutCode"] ?></td>
                            <td><span class="hide"><?php echo $data["CreatedOn"]; ?></span> <?php echo ConvertDateTimeDBToDateTimeDisplay($data["CreatedOn"]) ?></td>
                            <td>
                                <?php echo $data["Name"] ?>
                                <br />
                                <small><i class="fa fa-phone"></i> 
                                <?php echo $data["Phone"] ?></small>
                                <small><i class="fa fa-envelope-o"></i> 
                                <?php echo $data["Email"] ?></small>
                            </td>
                            <td class="text-right"><?php echo number_format($data["Net"],2) ?></td>
                            <!-- <td><?php echo $data["shipping_name"] ?></td> -->
                            <th class="text-center <?php echo $data["StatusCode"] == "CANCEL" ? "text-danger" : "" ?>"><?php echo GetPOStatusDesc($data["StatusCode"]) ?></th>
                            <td class="text-center">
                                <a title="รายละเอียด" href="transactionDetail.php?ref=<?php echo $data["CheckOutCode"] ?>">
                                    <i class="fa fa-search"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php include  "../footer.php"; ?>