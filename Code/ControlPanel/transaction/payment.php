<?php $_COG_ITEM_CODE = 'PAYMENT_ACTION'; ?>
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
                <span class="analysis-left-menu-desc">เกี่ยวกับการขาย</span>

            </h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

<div class="mat-box grey-bar">

    <a href="transaction.php" class="link-history-btn">เกี่ยวกับการขาย</a>
    /
    <span class="link-history-btn">รายการสั่งซื้อ</span>



</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row">
        <div class="col-md-2 hide">
            <?php 
            $_LEFT_MENU_ACTIVE = "PAYMENT";
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
                <span><b>รายการแจ้งชำระเงิน</b></span>
                <hr style="margin-top: 5px;" />

                <script>
                    _datatableOptions = {
                        "order": [[0, "desc"]]
                    }
                </script>
                <table class="jquery-datatable display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>วัน / เวลา</th>
                            <th>ชื่อผู้ติดต่อ</th>
                            <th>เลขที่เอกสารใบสั่งซื้อ</th>
                            <th style="width:150px;" class="text-center">การชำระเงิน</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>วัน / เวลา</th>
                            <th>ชื่อผู้ติดต่อ</th>
                            <th>เลขที่เอกสารใบสั่งซื้อ</th>
                            <th class="text-center">การชำระเงิน</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                    
                        $sql = "select m.*,b.BankName from member m
                        left join bank b on m.BankCode = b.BankCode
                        where MemberType = 'PAYMENT' 
                        order by CreatedOn desc";
                        $datas = SelectRows($sql);
                        foreach ($datas as $key => $data) {
                        ?>
                        <tr class="<?php echo $data["Picked"] == 1 ? "picked" : "no-picked" ?>">
                            <td><span class="hide"><?php echo $data["CreatedOn"]; ?></span> <?php echo ConvertDateTimeDBToDateTimeDisplay($data["CreatedOn"]) ?></td>
                            <td><?php echo $data["MemberName"]." ".$data["MemberName2"] ?></td>
                            <td><a target="_blank" title="รายละเอียด" href="transactionDetail.php?ref=<?php echo $data["CheckOutCode"] ?>">
                                    <i class="fa fa-file-text-o"></i>
                                    <?php echo $data["CheckOutCode"] ?>
                                </a>

                            </td>
                            <td class="text-center">
                                <a title="รายละเอียด" href="#" onclick="$('#modal-<?php echo $data["MemberCode"] ?>').modal('show'); return false;">
                                    <i class="fa fa-search"></i>
                                    รายละเอียด
                                </a>

                                <div id="modal-<?php echo $data["MemberCode"] ?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog text-left">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">การแจ้งชำระเงินเลขที่เอกสารใบสั่งซื้อ <?php echo $data["CheckOutCode"] ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="<?php echo empty($data["Subject"]) ? "hide" : ""; ?>">
                                                    <!-- <b>Paypal Order ID</b>  -->
                                                    <b>Subject</b>
                                                    : <?php echo $data["Subject"] ?>
                                                </p>
                                                <p>
                                                    <b>Purchase Order</b> : <a target="_blank" title="รายละเอียด" href="transactionDetail.php?ref=<?php echo $data["CheckOutCode"] ?>">
                                                        <i class="fa fa-file-text-o"></i>
                                                        <?php echo $data["CheckOutCode"] ?>
                                                    </a>
                                                </p>
                                                <p class="hide">
                                                    <b>Bank Account</b> : <?php echo empty($data["BankName"]) ? "ไม่ระบุ" : $data["BankName"] ?>
                                                </p>
                                                <p class="hide">
                                                    <b>Payment Amount</b> : <?php echo $data["PaymentAmount"] ?>
                                                </p>
                                                <p class="hide">
                                                    <b>Payment Date</b> : <?php echo $data["PaymentDate"] ?>
                                                </p>
                                                <p class="hide">
                                                    <b>Payment Time</b> : <?php echo $data["PaymentTime"] ?>
                                                </p>
                                                <p>
                                                    <b>Message</b> : <?php echo ConvertNewLine($data["Message"]) ?>
                                                </p>
                                                <p class="<?php echo empty($data["Picture"]) ? "hide" : ""; ?>">
                                                    <b>File</b> : <a href="<?php echo $data["Picture"] ?>" target="_blank">คลิกที่นี่เพื่อดูไฟล์ที่1</a>
                                                </p>
                                                <p class="<?php echo empty($data["Picture2"]) ? "hide" : ""; ?>">
                                                    <b>File2</b> : <a href="<?php echo $data["Picture2"] ?>" target="_blank">คลิกที่นี่เพื่อดูไฟล์ที่2</a>
                                                </p>
                                                <hr />
                                                <p>
                                                    <i class="fa fa-user fa-fw"></i>
                                                    <?php echo $data["MemberName"]." ".$data["MemberName2"] ?>
                                                </p>
                                                <p class="">
                                                    <i class="fa fa-envelope fa-fw"></i>
                                                    <?php echo $data["Email"] ?>
                                                </p>
                                                <p class="">
                                                    <i class="fa fa-phone fa-fw"></i>
                                                    <?php echo $data["Phone"] ?>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post">
                                                    <button type="submit" class="btn btn-success <?php echo $data["Picked"] == 1 ? "hide" : "" ?>" value="<?php echo $data["MemberCode"] ?>" name="btnPicked">
                                                        <i class="fa fa-check-square-o"></i>
                                                        ยืนยันว่าอ่านแล้ว</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </form>
                                               
                                            </div>
                                        </div>

                                    </div>
                                </div>
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