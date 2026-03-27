<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>

<?php

$prdCode = $_GET["ref"];

if(isset($_POST["btnSubmit"])){
    
    $txtPackageName = $_POST["txtPackageName"];
    $txtPackagePrice = $_POST["txtPackagePrice"];
    $txtPackagePower = $_POST["txtPackagePower"];
    $txtPackageArea = $_POST["txtPackageArea"];
    $txtPackageRevenue = $_POST["txtPackageRevenue"];
    $txtPackagePayback = $_POST["txtPackagePayback"];
    $chkActive = $_POST["chkActive"];
    $txtPackageCode = $_POST["txtPackageCode"];
    
    for ($i = 1; $i < count($txtPackageName); $i++)
    {
        $PackageName = $txtPackageName[$i];
        $PackagePrice = $txtPackagePrice[$i];
        $PackagePower = $txtPackagePower[$i];
        $PackageArea = $txtPackageArea[$i];
        $PackageRevenue = $txtPackageRevenue[$i];
        $PackagePayback = $txtPackagePayback[$i];
        $Active = isset($chkActive[$i]) ? 1 : 0;
        $PackageCode = $txtPackageCode[$i];
        
        if(empty($PackageCode)){
            $PackageCode = GenerateNextID("product_package","PackageCode",10,"PACK");
            $sql = "insert into product_package (PackageCode,ProductCode,PackageName,PackagePrice
                        ,Power,Area,Revenue,Payback,Active,CreatedOn,CreatedBy)
                    values(
                    '$PackageCode'
                    ,'$prdCode'
                    ,'$PackageName'
                    ,'$PackagePrice'
                    ,'$PackagePower'
                    ,'$PackageArea'
                    ,'$PackageRevenue'
                    ,'$PackagePayback'
                    ,'$Active'
                    ,NOW()
                    ,'".UserService::UserCode()."'
                    );";
            ExecuteSQL($sql);
        }else{
            $sql = "update product_package set 
                    PackageName = '$PackageName'
                    ,PackagePrice = '$PackagePrice'
                    ,Power = '$PackagePower'
                    ,Area = '$PackageArea'
                    ,Revenue = '$PackageRevenue'
                    ,Payback = '$PackagePayback'
                    ,Active = '$Active'
                    ,UpdatedOn = NOW()
                    ,UpdatedBy = '".UserService::UserCode()."'
                    where PackageCode = '$PackageCode'";
            ExecuteSQL($sql);
        }
    }
    
    
    Redirect("product.php");
    exit();
}



if(!empty($prdCode)){
    $sqlPrd = "select * from product where ProductCode = '$prdCode'";
    $prdQuery = mysql_query($sqlPrd) or die (mysql_error());
    $data = mysql_fetch_assoc($prdQuery);
}

?>


<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <a href="product.php" class="link-history-btn">รายการ<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">แพคเกจ<?php echo $_COG_ITEM_NAME ?></span>

</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <form id="form-product" method="post">
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-12">
                        <div>
                        
                            <span><b>จัดการข้อมูลแพคเกจ<?php echo $_COG_ITEM_NAME ?> 
                                <span class="text-orange">
                                    <?php echo $data["ProductName"] ?> (<?php echo $data["ProductCode"] ?>)
                                </span>
                                  </b></span>
                            <hr style="margin-top: 5px;margin-bottom:0;" />
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <div class="mat-box package-template" style="border-color:#333;display:none;">
                            <div class="pull-right">
                                <input type="checkbox" value="" checked="checked" name="chkActive[]" />
                                <label>ใช้งานแพคเกจ</label>
                            </div>
                            <h4 style="margin:0">
                                <b>
                                    Package:
                                    <span class="text-danger">New package</span>
                                </b>
                            </h4>
                            <hr  style="margin:10px 0"/>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>ชื่อเพคเกจ</label>
                                    <input type="text" placeholder="ชื่อเพคเกจ..." name="txtPackageName[]" value="" class="form-control input-sm require" />
                                </div>
                                <div class="col-sm-6">
                                    <label>ราคาเพคเกจ (บาท)</label>
                                    <input type="number" step="0.01" placeholder="ราคาเพคเกจ..." name="txtPackagePrice[]" value="0" class="form-control input-sm require text-right" />
                                </div>
                            </div>
                            <table class="table table-striped">
                                <tr>
                                    <th>รายละเอียด</th>
                                    <th style="width: 150px;" class="text-right">ค่า</th>
                                </tr>
                                <tr>
                                    <td>กำลังไฟ (kW)
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" value="0" name="txtPackagePower[]" class="form-control input-sm require text-right" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>พื้นที่ติดตั้ง (ตรม.)
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" value="0" name="txtPackageArea[]" class="form-control input-sm require text-right" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>รายได้ค่าไฟฟ้า (บาท)
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" value="0" name="txtPackageRevenue[]" class="form-control input-sm require text-right" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>ระยะเวลาคืนทุน (ปี)
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" value="0" name="txtPackagePayback[]" class="form-control input-sm require text-right" />
                                    </td>
                                </tr>
                            </table>

                            <span class="btn btn-danger btn-sm btn-remove-package" onclick="removePackage(this);">
                                <i class="fa fa-trash"></i>
                                ลบแพคเกจ
                            </span>

                            

                            <input type="hidden" name="txtPackageCode[]" value="" />
                        </div>


                        <?php 
                        
                        $sqlPack = "select * from product_package where ProductCode = '$prdCode'";
                        $dataPack = SelectRows($sqlPack);
                        while($pack = mysql_fetch_array($dataPack)){
                        ?>
                        <div class="mat-box" style="border-color:#333;">
                            <div class="pull-right">
                                <input type="checkbox" value="" <?php echo $pack["Active"] == 1 ? "checked" : "" ?> name="chkActive[]" />
                                <label>ใช้งานแพคเกจ</label>
                            </div>
                            <h4 style="margin:0">
                                <b>
                                    Package:
                                    <span class="text-success"><?php echo $pack["PackageName"] ?></span>
                                </b>
                            </h4>
                            <hr  style="margin:10px 0"/>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>ชื่อเพคเกจ</label>
                                    <input type="text" placeholder="ชื่อเพคเกจ..." name="txtPackageName[]" value="<?php echo $pack["PackageName"] ?>" class="form-control input-sm require" />
                                </div>
                                <div class="col-sm-6">
                                    <label>ราคาเพคเกจ (บาท)</label>
                                    <input type="number" step="0.01" placeholder="ราคาเพคเกจ..." name="txtPackagePrice[]" value="<?php echo $pack["PackagePrice"] ?>" class="form-control input-sm require text-right" />
                                </div>
                            </div>
                            <table class="table table-striped">
                                <tr>
                                    <th>รายละเอียด</th>
                                    <th style="width: 150px;" class="text-right">ค่า</th>
                                </tr>
                                <tr>
                                    <td>กำลังไฟ (kW)
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" value="<?php echo $pack["Power"] ?>" name="txtPackagePower[]" class="form-control input-sm require text-right" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>พื้นที่ติดตั้ง (ตรม.)
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" value="<?php echo $pack["Area"] ?>" name="txtPackageArea[]" class="form-control input-sm require text-right" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>รายได้ค่าไฟฟ้า (บาท)
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" value="<?php echo $pack["Revenue"] ?>" name="txtPackageRevenue[]" class="form-control input-sm require text-right" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>ระยะเวลาคืนทุน (ปี)
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" value="<?php echo $pack["Payback"] ?>" name="txtPackagePayback[]" class="form-control input-sm require text-right" />
                                    </td>
                                </tr>
                            </table>


                            

                            <input type="hidden" name="txtPackageCode[]" value="<?php echo $pack["PackageCode"] ?>" />
                        </div>
                        <?php } ?>

                        <div class="package-container"></div>

                        <a href="#" onclick="addPackage(); return false;">
                            <i class="fa fa-plus"></i>
                            เพิ่มแพคเกจ
                        </a>

                         <script>
                             function addPackage() {
                                 var container = $(".package-container");
                                 var tmp = $(".package-template:first").clone();
                                 tmp.find("input[type='text']").val("");
                                 tmp.find("input[type='number']").val("0");
                                 tmp.find(".btn-remove-package").show();;
                                 tmp.show().appendTo(container);
                             }
                             function removePackage(obj) {
                                 $(obj).closest(".mat-box").remove();
                             }
                        </script>

                    </div>
                </div>

                <hr />

                <div>

                    <button type="submit" name="btnSubmit" class="btn btn-success" onclick="return Validate(this,$('#form-product'));">
                        <i class="fa fa-save"></i>
                        บันทึก
                    </button>

                    <a href="product.php" class="btn btn-danger">
                        <i class="fa fa-remove"></i>
                        ยกเลิก
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<?php include  "../footer.php"; ?>