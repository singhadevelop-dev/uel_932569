<?php $_COG_ITEM_CODE = 'ORDER'; ?>
<?php include  "../header.php"; ?>

<?php 

if(isset($_POST["btnSavePayPal"])){
    $sql = "update bank set
      AccountName = '".$_POST["txtPayPalEmail"]."'
     ,Number = '".$_POST["txtPayPalMerchant"]."'
     where BankGroup = 'PAYPAL'";
    ExecuteSQL($sql);
}

if(isset($_POST["btnDeleteRow"])){
    $sql = "delete from bank where BankCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
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
    <span class="link-history-btn">การชำระเงิน</span>
</div>

<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
       <div class="col-md-2">
            <?php 
            $_LEFT_MENU_ACTIVE = "PAYMENT";
            include "leftMenu.php"; 
            ?>
        </div>
        <div class="col-md-10">
            <div>
                <a href="paymentDetail.php" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการบัญชีธนาคาร
                </a>
                <span><b>รายการบัญชีธนาคาร</b></span>
                <hr style="margin-top: 5px;" />
            </div>

            

            <table class="jquery-datatable display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="width:90px;"></th>
                        <th>ธนาคาร / สาขา</th>
                        <th>เลขที่บัญชี / ชื่อบัญชี / ประเภท</th>
                        <th style="width:50px;" class="text-center">ใช้งาน</th>
                        <th style="width:50px;" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th style="width:90px;"></th>
                        <th>ธนาคาร / สาขา</th>
                        <th>เลขที่บัญชี / ชื่อบัญชี / ประเภท</th>
                        <th style="width:50px;" class="text-center">ใช้งาน</th>
                        <th style="width:50px;" class="text-center">จัดการ</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    
                    $sql = "select * from bank where BankGroup = 'BANK' order by BankCode";
                    $datas = SelectRowsArray($sql);
                    foreach($datas as $data){
                    ?>
                    <tr>
                        <td>
                            <span class="hide">
                                <?php echo $data["BankCode"] ?>
                            </span>
                            <img src="<?php echo $data["Image"] ?>" style="width:100%" />
                        </td>
                        <td>
                        
                        <?php echo $data["BankName"] ?>
                        <br /><?php echo $data["Branch"] ?>
                        </td>
                        <td>
                        
                        <?php echo $data["Number"] ?>
                        <br />ชื่อบัญชี
                        <?php echo $data["AccountName"] ?> 
                        ประเภท
                        <?php echo $data["Type"] ?>
                        </td>
                        <td class="text-center">
                            <?php echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                        </td>
                        <td class="text-center">
                            <a href="paymentDetail.php?ref=<?php echo $data["BankCode"] ?>">
                                <i class="fa fa-cog"></i>
                            </a>

                            <form method="post" style="display:inline">
                                <button type="submit" class="btn-link" 
                                    onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                    value="<?php echo $data["BankCode"] ?>" name="btnDeleteRow">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <br />
            <div class="">
                <span class=""><b>รายการบัญชีอื่นๆ</b></span>
                <hr class="" style="margin-top: 5px;" />

                <?php 
                $sql = "select * from bank where BankGroup = 'PAYPAL'";
                $dataPayPal = SelectRow($sql);
                ?>

                <form method="post" class="panel panel-primary ">
                    <div class="panel-heading">
                        บัญชี PayPal
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 hide">
                                <label>อีเมล์บัญชีผู้ขาย PayPal</label>
                                <input type="email" placeholder="Email.." name="txtPayPalEmail"  class="form-control"  value="<?php echo $dataPayPal["AccountName"] ?>" />
                            </div>
                            <div class="col-md-12">
                                <label>ID ผู้ค้า PayPal</label>
                                <input type="text" placeholder="ID ผู้ค้า.." name="txtPayPalMerchant" class="form-control"  value="<?php echo $dataPayPal["Number"] ?>" />
                            </div>
                        </div>
                        <?php if(!empty($dataPayPal["Number"]) && !empty($_Util_WebsitDetail["AppIDPaypal"])){?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        <div style="display:none;">
                                            <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $_Util_WebsitDetail["AppIDPaypal"]; ?>&merchant-id=<?php echo $dataPayPal["Number"]; ?>&currency=THB&commit=true"></script>
                                            <div id="paypal-button-container"></div>
                                            <script>
                                                
                                                paypal.Buttons(
                                                {
                                                    createOrder: function(data, actions) {
                                                        return actions.order.create({
                                                            purchase_units: [{
                                                                amount: {
                                                                    value: '0.00'
                                                                }
                                                            }]
                                                        });
                                                    }
                                                }).render('#paypal-button-container');
                                                
                                                
                                                setTimeout(() => {
                                                    var panelStatus = $("#panel-alert-status-account");
                                                    if($("#paypal-button-container").find("iframe").length > 0)
                                                    {
                                                        $(panelStatus).removeClass("alert-warning").addClass("alert-success");
                                                        $(panelStatus).html("ID ผู้ค้า PayPal ถูกต้อง");
                                                    }
                                                }, 1500);
                                            </script>
                                        </div>
                                        <div id="panel-alert-status-account" style="margin-bottom: 0px;" class="alert alert-warning text-center" role="alert"> ID ผู้ค้า PayPal ไม่ถูกต้อง!</div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-success" name="btnSavePayPal">
                            <i class="fa fa-save"></i>
                            บันทึกบัญชี PayPal
                        </button>
                        <span name="btnDocumentExalple" class="btn btn-info" data-toggle="modal"
                            data-target="#examplePaypalConfigModal">
                            <i class="fa fa-book"></i>
                            คู่มือการตั้งค่า ID ผู้ค้า
                        </span>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="examplePaypalConfigModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">ตัวอย่างการตั้งค่า Paypal (จะใช้งานได้ก็ต่อเมื่อ
                    เปิดบัญชีเป็นแบบ Business แล้วเท่านั้น)</h4>
            </div>
            <div class="modal-body text-center">

                <p>1.ไปที่เว็บไซต์ <span style="color: #0000ff;"><a style="color: #0000ff;" target="_blank"
                            href="https://www.paypal.com">https://www.paypal.com</a></span>&nbsp;Log in เข้าสู่ระบบ</p>
                <p><img class="alignnone size-medium wp-image-12075"
                        src="https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting01-620x306.png"
                        alt="" width="620" height="306"
                        srcset="https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting01-620x306.png 620w, https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting01-920x454.png 920w, https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting01-400x197.png 400w, https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting01-1014x500.png 1014w, https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting01.png 1385w"
                        sizes="(max-width: 620px) 100vw, 620px"></p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>2.ไปที่ด้านบน คลิกที่ตั้งค่า &gt; <strong>เลือกข้อมูล และการตั้งค่า</strong><br>
                    <img class="alignnone size-medium wp-image-12076"
                        src="https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting02-620x352.png"
                        alt="" width="620" height="352"
                        srcset="https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting02-620x352.png 620w, https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting02-920x522.png 920w, https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting02-400x227.png 400w, https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting02-882x500.png 882w, https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting02.png 1268w"
                        sizes="(max-width: 620px) 100vw, 620px"></p>
                <p>&nbsp;</p>
                <p>3.ในส่วนของ <strong>ข้อมูลธุรกิจ</strong> จะเห็นบรรทัดล่างสุด คือ <strong>ID บัญชีผู้ค้า</strong>
                    ให้ทำการจดไว้ เพื่อนำไปใส่ในระบบหลังบ้าน Web Application</p>
                <p><img class="alignnone size-medium wp-image-12077"
                        src="https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting-03-620x374.png"
                        alt="" width="620" height="374"
                        srcset="https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting-03-620x374.png 620w, https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting-03-920x555.png 920w, https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting-03-400x241.png 400w, https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting-03-829x500.png 829w, https://www.makewebeasy.com/blog/wp-content/uploads/2016/07/PayPal-Setting-03.png 1210w"
                        sizes="(max-width: 620px) 100vw, 620px"></p>
                <p>&nbsp;</p>
            </div>

        </div>
    </div>
</div>


<?php include  "../footer.php"; ?>