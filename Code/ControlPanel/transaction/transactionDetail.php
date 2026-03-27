<?php $_COG_ITEM_CODE = 'TRANSACTION'; ?>
<?php include  "../header.php"; ?>

<?php 

$POCode = $_GET["ref"];

if(isset($_POST["btnUpdate"])){
    $sqlUpdate = "update checkout set
    StatusCode = '".$_POST["ddlStatus"]."'
    where CheckOutCode = '$POCode'";
    ExecuteSQL($sqlUpdate);
    
}

$sqlPO = "select a.* , b.Name as shipping_name
    from checkout a
    left join delivery_category b on a.DelivieryCode = b.Code
    where CheckOutCode = '$POCode'";
$dataPO = SelectRow($sqlPO);
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
    <?php $pageBack = $_GET["b"] == "order" ? "../transaction/" : "transaction.php" ?>
    <a href="<?php echo $pageBack ?>" class="link-history-btn">เกี่ยวกับการขาย</a>
    /
    <a href="<?php echo $pageBack ?>" class="link-history-btn">รายการสั่งซื้อ</a>
    /
    <span class="link-history-btn">รายละเอียดและการจัดการเลขที่เอกสาร <?php echo $PO ?></span>


</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row" style="margin:0">
        <div class="col-sm-9">
            <span><b>ใบสั่งซื้อเลขที่เอกสาร <?php echo $PO ?></b></span>
        </div>
        <div class="col-sm-3">
            <form method="post" class="input-group">
                <select class="form-control input-sm" name="ddlStatus" id="ddlStatus">
                    <option value="WAITING" <?php echo $dataPO["StatusCode"] == "WAITING" ? "selected" : "" ?>>รอชำระเงิน</option>
                    <option value="PAID" <?php echo $dataPO["StatusCode"] == "PAID" ? "selected" : "" ?>>ชำระเงินแล้วและรอการจัดส่ง</option>
                    <option value="SUCCESS" <?php echo $dataPO["StatusCode"] == "SUCCESS" ? "selected" : "" ?>>จัดส่งเรียบร้อยแล้ว</option>
                    <option value="CANCEL" <?php echo $dataPO["StatusCode"] == "CANCEL" ? "selected" : "" ?>>ยกเลิก</option>
                </select>
                <span class="input-group-addon hand" style="background:#009688;border-color:#009688;color:#fff" onclick="$(this).next().click();">
                    <i class="fa fa-save"></i>
                </span>
                <input type="submit" class="hide" name="btnUpdate" onclick="return statusChange(this);" name="name" value="" />
            </form>
            <script>
                function statusChange(sender) {
                    return Confirm(sender, "ต้องการปรับสถานะใบสั่งซื้อเป็น <b>" + $("#ddlStatus option:selected").text() + "</b> ใช่หรือไม่");
                }
            </script>
        </div>
    </div>

    
    <hr style="margin-top: 5px;" />

    <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">

    <style>
        .pad-bottom {
            padding-bottom: 10px;
        }

        .font-promp {
            font-family: 'Prompt',"Helvetica Neue",Helvetica,Arial,sans-serif;
        }

        [required] {
            border-left: 3px solid #101010;
        }

        .text-danger {
            color: #E65041;
        }

        @media(max-width:768px) {
            .sp-order-summary {
                padding: 10px;
            }
        }

        .sheet {
            border-radius: 5px;
            border: 1px solid;
            border-color: #e5e6e9 #dfe0e4 #d0d1d5;
            background: #fff;
            padding: 30px;
        }
    </style>

    <section class="sec-padding">
        <div class="font-promp">
            <?php
                $sql = "select * from cart_address where CheckOutCode = '".$dataPO["CheckOutCode"]."' ";
                $datas = SelectRowsArray($sql);
                $delivery = Find($datas,array('AddressType' => 'DELIVERY'));
                $document = Find($datas,array('AddressType' => 'DOCUMENT'));
            ?>

            <div class="sheet">
                <div class="row">
                    <div class="col-sm-6">
                        <img src="<?php echo SystemConfig::cogs_logo_path() ?>" width="<?php echo SystemConfig::cogs_logo_width() ?>" height="<?php echo SystemConfig::cogs_logo_height() ?>"  />
                    </div>
                    <div class="col-sm-6 text-right">
                        <h1 class="font-promp" style="margin: 0">ใบสั่งซื้อ</h1>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-sm-6">
                        <p>
                            <b>ถึงคุณ</b>
                            <?php echo $dataPO["Name"] ?>
                        </p>
                        <p>
                            <b>เบอร์โทร</b>
                            <?php echo $dataPO["Phone"] ?>
                        </p>
                        <p>
                            <b>อีเมล</b>
                            <?php echo $dataPO["Email"] ?>
                        </p>
                        <p>
                            <b>ที่อยู่จัดส่งของ</b>
                            <?php echo $dataPO["Name"] ?> 
                            <?php echo empty($document["Company"]) || $document["Company"] == "-" ? "" : $document["Company"]; ?>
                            <?php echo $dataPO["Address"] ?>
                        </p>
                        <p>
                            <b>รายละเอียด</b>
                            <?php echo ConvertNewLine($dataPO["Detail"]) ?>
                        </p>
                    </div>
                    <div class="col-sm-6 text-right">
                        <table style="width: 100%">
                            <tr>
                                <td style="text-align: right;">
                                    <p>
                                        <b>เลขที่</b>
                                    </p>
                                </td>
                                <td style="width: 200px; text-align: right">
                                    <p>
                                        <b><?php echo $dataPO["CheckOutCode"] ?></h5>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">
                                    <p>
                                        <b>วันที่</b>
                                    </p>
                                </td>
                                <td style="width: 200px; text-align: right">
                                    <p>
                                        <?php echo ConvertDateDBToDateDisplay($dataPO["CreatedOn"]) ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">
                                    <p>
                                        <b>สถานะการชำระเงิน</b>
                                    </p>
                                </td>
                                <td style="width: 200px; text-align: right">
                                    <p>
                                        <b style="color: #ED639C; font-size: 18px;">
                                            <span><?php echo GetPOStatusDesc($dataPO["StatusCode"]) ?></span>
                                        </b>
                                    </p>
                                </td>
                            </tr>
                            <!-- <tr>
                                <td style="text-align: right;">
                                    <p>
                                        <b>ช่องทางเลือกชำระ</b>
                                    </p>
                                </td>
                                <td style="width: 200px; text-align: right">
                                    <p>
                                        <b style="color: #ED639C; font-size: 18px;">
                                            <span><?php echo GetPOPaymentMethodDesc($dataPO["PaymentType"]); ?></span>
                                        </b>
                                    </p>
                                </td>
                            </tr> -->
                            <!-- <tr>
                                <td style="text-align: right;">
                                    <p>
                                        <b>บริษัทขนส่ง</b>
                                    </p>
                                </td>
                                <td style="width: 200px; text-align: right">
                                    <p>
                                        <?php echo $dataPO["shipping_name"] ?>
                                    </p>
                                </td>
                            </tr> -->
                        </table>
                    </div>
                </div>

                <br />
                <br />

                <div class="row">
                    <div class="col-md-12">


                        <div class="table-responsive">

                            <table class="sp-cart" style="width: 100%; table-layout: fixed">

                                <tr>
                                    <th style="width: 100px;"></th>
                                    <th>ชื่อสินค้า</th>
                                    <th style="width: 10%;" class="text-right">ราคา</th>
                                    <th style="width: 10%;" class="text-right">จำนวน</th>
                                    <th style="width: 10%;" class="text-right">ราคารวม</th>
                                </tr>
                                <?php 

                                
                                $sqlItem = "select p.*,c.Price as CartPrice ,c.QTY,c.Total,c.SEQ as CARTSEQ
                                                , co.TagName as ColorName, si.TagName as SizeName
                                            from cart c
                                            left join product p on p.ProductCode = c.ProductCode 
                                            left join tag co on c.Color = co.TagCode and co.TagType = 'COLOR'
                                            left join tag si on c.Size = si.TagCode and si.TagType = 'SIZE'
                                where c.CheckOutCode = '$POCode'";
                                $dataItems = SelectRows($sqlItem);

                                // $sqlProp = "select  cart.SEQ,prop.PropName,map.Detail
                                //         from product_properties prop
                                //         INNER join product_properties_mapping map
                                //             on map.PropCode = prop.PropCode 
                                //         inner join cart  
                                //             on map.ProductCode = cart.ProductCode
                                //         where cart.CheckOutCode = '$POCode' and cart.CheckOutCode <> ''
                                //         order by cart.SEQ,prop.SEQ";
                                // $dataProps = SelectRowsArray($sqlProp);
                                // $__PROP_DATAS = array();
                                // foreach ($dataProps as $prop) {
                                //     if(!isset($__PROP_DATAS[$prop["SEQ"]])){
                                //         $__PROP_DATAS[$prop["SEQ"]] = array();
                                //     }
                                //     array_push($__PROP_DATAS[$prop["SEQ"]],$prop);
                                // }
                                
                                foreach ($dataItems as $cart) 
                                {
                                ?>

                                <tr>
                                    <td class="pro-img">
                                        <img style="width:80px;" src="<?php echo $cart["Image"] ?>" alt="<?php echo $cart["ProductName"] ?>">
                                    </td>
                                    <td class="pro-title">
                                        <h6><b><?php echo $cart["ProductName"] ?></b> <br>
                                        SKU: <?php echo $cart["ProductRefCode"] ?>
                                        <!-- <?php if(!empty($cart["ColorName"])){ ?>
                                         สี: <?php echo $cart["ColorName"] ?> <br>
                                        <?php } ?>
                                        <?php if(!empty($cart["SizeName"])){ ?>
                                        ไซด์: <?php echo $cart["SizeName"] ?>
                                        <?php } ?> -->
                                        <!-- <?php  //foreach ($__PROP_DATAS[$cart["CARTSEQ"]] as $prop) { ?>
                                            <?php //echo $prop["PropName"] ?>: <?php //echo $prop["Detail"] ?> <br>
                                        <?php //} ?> -->
                                        </h6>
                                    </td>
                                    <td class="pro-price text-right">
                                        <h6><?php echo number_format($cart["CartPrice"],2) ?></h6>
                                    </td>
                                    <td class="pro-price text-right">
                                        <h6><?php echo number_format($cart["QTY"]) ?></h6>
                                    </td>
                                    <td class="total  text-right">
                                        <h6><?php echo number_format($cart["Total"],2) ?></h6>
                                    </td>
                                </tr>

                                <?php } ?>
                            </table>

                        </div>
                    </div>
                    <!--end item-->

                </div>


                <div class="divider-line solid light"></div>
                <div class="row">

                    <div class="col-md-8 col-sm-8 col-xs-12">
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <ul class="sp-cart-total">
                            <!-- <li>
                                <div class="pull-left title">ราคารวม</div>
                                <div class="pull-right price"><?php echo number_format($dataPO["Total"],2) ?></div>
                            </li>
                            <li>
                                <div class="pull-left title">ส่วนลด</div>
                                <div class="pull-right price"><?php echo number_format($dataPO["DisCount"],2) ?></div>
                            </li> -->
                            <!-- <li>
                                <div class="pull-left title">Tax</div>
                                <div class="pull-right price"><?php //echo number_format($dataPO["Tax"],2) ?></div>
                            </li> -->
                            <!-- <li>
                                <div class="pull-left title">ค่าจัดส่ง</div>
                                <div class="pull-right price"><?php echo number_format($dataPO["DeliveryPrice"],2) ?></div>
                            </li> -->
                            <li>
                                <div class="pull-left title">รวมทั้งสิ้น</div>
                                <div class="pull-right price"><b><?php echo number_format($dataPO["Net"],2) ?></b></div>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <!--end item-->

                </div>

            </div>
        </div>
    </section>
    <div class="clearfix"></div>
</div>

<?php include  "../footer.php"; ?>