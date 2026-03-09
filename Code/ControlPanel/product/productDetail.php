<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>

<?php

$prdCode = $_GET["ref"];

if(isset($_POST["btnSubmit"])){
    $txtSubject = $_POST["txtSubject"];
    $txtShortDescription = $_POST["txtShortDescription"];
    $txtShortDescription2 = $_POST["txtShortDescription2"];
    $txtDetail = GeneratePageFile($_POST["txtDetail"]);
    $txtDetail2 = GeneratePageFile($_POST["txtDetail2"]);
    $txtDetail3 = GeneratePageFile($_POST["txtDetail3"]);
    $txtDetail4 = GeneratePageFile($_POST["txtDetail4"]);
    $txtDetail5 = GeneratePageFile($_POST["txtDetail5"]);
    $txtDetail6 = GeneratePageFile($_POST["txtDetail6"]);
    $chkActive = isset($_POST["chkActive"]) ? 1 : 0;

    $txtByName = $_POST["txtByName"];
    $txtProductSize = $_POST["txtProductSize"];
    $txtAddress = $_POST["txtAddress"];
    $txtLazada = $_POST["txtLazada"];
    $txtShopee = $_POST["txtShopee"];
    $txtLine = $_POST["txtLine"];


    $txtAmount = doubleval($_POST["txtAmount"]);
    
    $txtRefCode = $_POST["txtRefCode"];
    $txtBasePrice = doubleval(str_replace(",","",$_POST["txtBasePrice"]));
    $txtOldPrice = doubleval(str_replace(",","",$_POST["txtOldPrice"]));
    $txtPrice = doubleval(str_replace(",","",$_POST["txtPrice"]));
    $txtPriceDesc = $_POST["txtPriceDesc"];
    $txtWeight = doubleval(str_replace(",","",$_POST["txtWeight"]));
    
    $choPromotion = isset($_POST["choPromotion"]) ? 1 : 0;
    $choNew = isset($_POST["choNew"]) ? 1 : 0;
    $choRecommend = isset($_POST["choRecommend"]) ? 1 : 0;
    $choHot = isset($_POST["choHot"]) ? 1 : 0;

    $txtRank = $_POST["txtRank"];
    $ddlCategory = $_POST["ddlCategory"];
    $ddlBrand = $_POST["ddlBrand"];
    $ddlModel = $_POST["ddlModel"];
    $ddlSubCategory = $_POST["ddlSubCategory"];
    $ddlSubCategory3 = $_POST["ddlSubCategory3"];
    $ddlSubCategory4 = $_POST["ddlSubCategory4"];
    $txtLatLng = $_POST["txtLatLng"];
    $ddlStatus = $_POST["ddlStatus"];

    $hddFilePathVedio = $_POST["hddFilePathVedio"];

    //ข้อมูลการใช้สอย
    $txtLandArea = doubleval($_POST["txtLandArea"]);
    $txtUsableArea = doubleval($_POST["txtUsableArea"]);
    $txtBedRoom = doubleval($_POST["txtBedRoom"]);
    $txtToilet = doubleval($_POST["txtToilet"]);
    $txtParkingSpace = doubleval($_POST["txtParkingSpace"]);
    $txtFloorNumber = doubleval($_POST["txtFloorNumber"]);
    $txtLivingRoom = doubleval($_POST["txtLivingRoom"]);
    $txtKitchenRoom = doubleval($_POST["txtKitchenRoom"]);
    $txtStartDateType = !empty($_POST["txtStartDate"]) ? new DateTime(ConvertDateTimeDisplayToDateTimeDB($_POST["txtStartDate"])." 00:00:00.000000") : new DateTime();
    $txtStartDate = $txtStartDateType->format('Y-m-d H:i:s');
    $txtEndDateType = !empty($_POST["txtEndDate"]) ? new DateTime(ConvertDateTimeDisplayToDateTimeDB($_POST["txtEndDate"])." 00:00:00.000000") : new DateTime();
    $txtEndDate = $txtEndDateType->format('Y-m-d H:i:s');
    $txtCustomer = $_POST["txtCustomer"];
    $txtTaxInfo = $_POST["txtTaxInfo"];
    $txtVendor = $_POST["txtVendor"];
    $txtCollection = $_POST["txtCollection"];
    $txtBarcode = $_POST["txtBarcode"];
    $txtColorCode = $_POST["txtColorCode"];
    $txtColorCode2 = $_POST["txtColorCode2"];
    
    $allColor = "";
    $chkColor = $_POST["chkTag"];
    for ($i = 0; $i < count($chkColor); $i++)
    {
        $tg = $chkColor[$i];
        if(isset($tg)){
    	    if(!empty($allColor)){
                $allColor .=",";
            }
            $allColor .= $tg;
        }
    }
    
    $allSize = "";
    $chkSize = $_POST["chkSize"];
    for ($i = 0; $i < count($chkSize); $i++)
    {
        $tg = $chkSize[$i];
        if(isset($tg)){
    	    if(!empty($allSize)){
                $allSize .=",";
            }
            $allSize .= $tg;
        }
    }

    $allMat = "";
    $chkMat = $_POST["chkMaterial"];
    for ($i = 0; $i < count($chkMat); $i++)
    {
        $tg = $chkMat[$i];
        if(isset($tg)){
    	    if(!empty($allMat)){
                $allMat .=",";
            }
            $allMat .= $tg;
        }
    }

    $allKeyWord = "";
    $chkKeyWord = $_POST["chkTagKeyWord"];
    for ($i = 0; $i < count($chkKeyWord); $i++)
    {
        $tg = $chkKeyWord[$i];
        if(isset($tg)){
    	    if(!empty($allKeyWord)){
                $allKeyWord .=",";
            }
            $allKeyWord .= $tg;
        }
    }

    $allFacility = "";
    $chkFacility = $_POST["chkFacility"];
    for ($i = 0; $i < count($chkFacility); $i++)
    {
        $tg = $chkFacility[$i];
        if(isset($tg)){
    	    if(!empty($allFacility)){
                $allFacility .=",";
            }
            $allFacility .= $tg;
        }
    }

    $allDesign = "";
    $chkDesign = $_POST["chkDesign"];
    for ($i = 0; $i < count($chkDesign); $i++)
    {
        $tg = $chkDesign[$i];
        if(isset($tg)){
    	    if(!empty($allDesign)){
                $allDesign .=",";
            }
            $allDesign .= $tg;
        }
    }

    $allProjectModel = "";
    $chkProjectModel = $_POST["chkProjectModel"];
    for ($i = 0; $i < count($chkProjectModel); $i++)
    {
        $tg = $chkProjectModel[$i];
        if(isset($tg)){
    	    if(!empty($allProjectModel)){
                $allProjectModel .=",";
            }
            $allProjectModel .= $tg;
        }
    }

    
    //FILE 1
    $fileDownloadTarget =  $GLOBALS["ROOT"]."/_content_files/" . GetCurrentLang() . "/product/";
    $fileDownloadUpload = $_FILES["txtFileUpload"];

    if(!empty($fileDownloadUpload["name"])){
        $fileDownloadUploadPath = $fileDownloadTarget.UploadFile($_FILES["txtFileUpload"],$fileDownloadTarget);
        $fileDownloadName = $fileDownloadUpload["name"];
    }else{
        $fileDownloadUploadPath = $_POST["hddBackUpFileDownload"];
        $fileDownloadName = $_POST["hddBackUpFileDownloadName"];
    }
    //FILE 2
    $fileDownloadUpload2 = $_FILES["txtFileUpload2"];
    if(!empty($fileDownloadUpload2["name"])){
        $fileDownloadUploadPath2 = $fileDownloadTarget.UploadFile($_FILES["txtFileUpload2"],$fileDownloadTarget);      
        $fileDownloadName2 = $fileDownloadUpload2["name"];
    }else{
        $fileDownloadUploadPath2 = $_POST["hddBackUpFileDownload2"];
        $fileDownloadName2 = $_POST["hddBackUpFileDownloadName2"];
    }
    //FILE 3
    $fileDownloadUpload3 = $_FILES["txtFileUpload3"];
    if(!empty($fileDownloadUpload3["name"])){
        $fileDownloadUploadPath3 = $fileDownloadTarget.UploadFile($_FILES["txtFileUpload3"],$fileDownloadTarget);
        $fileDownloadName3 = $fileDownloadUpload3["name"];
    }else{
        $fileDownloadUploadPath3 = $_POST["hddBackUpFileDownload3"];
        $fileDownloadName3 = $_POST["hddBackUpFileDownloadName3"];
    }

   
    $uploadFileTarget =  $GLOBALS["ROOT"]."/_content_images/" . GetCurrentLang() . "/product/";
    $fileUploaded = $_FILES["fileUpload"];
    
    if(!empty($fileUploaded["name"])){
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget);
    }else{
        $fileUploadedPath = $_POST["hddBackUpImage"];
    }

    $uploadFileTarget2 =  $GLOBALS["ROOT"]."/_content_images/" . GetCurrentLang() . "/product/image2";
    $fileUploaded2 = $_FILES["fileUpload2"];
    if(!empty($fileUploaded2["name"])){
        $fileUploadedPath2 = $uploadFileTarget2.UploadFile($_FILES["fileUpload2"],$uploadFileTarget2);
    }else{
        $fileUploadedPath2 = $_POST["hddBackUpImage2"];
    }

    $uploadFileTarget3 =  $GLOBALS["ROOT"]."/_content_images/" . GetCurrentLang() . "/product/image3";
    $fileUploaded3 = $_FILES["fileUpload3"];
    if(!empty($fileUploaded3["name"])){
        $fileUploadedPath3 = $uploadFileTarget3.UploadFile($_FILES["fileUpload3"],$uploadFileTarget3);
    }else{
        $fileUploadedPath3 = $_POST["hddBackUpImage3"];
    }

    $uploadFileTarget4 =  $GLOBALS["ROOT"]."/_content_images/" . GetCurrentLang() . "/product/image4";
    $fileUploaded4 = $_FILES["fileUpload4"];
    if(!empty($fileUploaded4["name"])){
        $fileUploadedPath4 = $uploadFileTarget4.UploadFile($_FILES["fileUpload4"],$uploadFileTarget4);
    }else{
        $fileUploadedPath4 = $_POST["hddBackUpImage4"];
    }

     //Video2 Local Server
     $fileUploadedVideo2 = $_FILES["fileUploadVideo"];
     if(!empty($fileUploadedVideo2["name"])){
         $fileUploadedVideoPath2 = $fileDownloadTarget.UploadFile($_FILES["fileUploadVideo"],$fileDownloadTarget);
     }else{
         $fileUploadedVideoPath2 = $_POST["hddBackUpVideo"];
     }

    if(!empty($prdCode))
    {
        $sqlUpdate = "update product set 
                    ProductName = '$txtSubject'
                    ,ShortDescription = '$txtShortDescription'
                    ,ShortDescription2 = '$txtShortDescription2'
                    ,ProductDetail = '$txtDetail'
                    ,ProductDetail2 = '$txtDetail2'
                    ,ProductDetail3 = '$txtDetail3'
                    ,ProductDetail4 = '$txtDetail4'
                    ,ProductDetail5 = '$txtDetail5'
                    ,ProductDetail6 = '$txtDetail6'
                    ,Image = '$fileUploadedPath'
                    ,Image2='$fileUploadedPath2'
                    ,Image3='$fileUploadedPath3'
                    ,Image4='$fileUploadedPath4'
                    ,Video='$hddFilePathVedio'
                    ,Video2='$fileUploadedVideoPath2'
                    ,FileDownload = '$fileDownloadUploadPath'
                    ,FileDownload2 = '$fileDownloadUploadPath2'
                    ,FileDownload3 = '$fileDownloadUploadPath3'
                    ,FileDownloadName = '$fileDownloadName'
                    ,FileDownloadName2 = '$fileDownloadName2'
                    ,FileDownloadName3 = '$fileDownloadName3'
                    ,Active = '$chkActive'
                    ,UpdatedOn = NOW()
                    ,UpdatedBy = '".UserService::UserCode()."'
                    ,BasePrice = '$txtBasePrice'
                    ,OldPrice = '$txtOldPrice'
                    ,Price = '$txtPrice'
                    ,Hot = '$choHot'
                    ,Promotion = '$choPromotion'
                    ,New = '$choNew'
                    ,Recommend = '$choRecommend'
                    ,Rank = '$txtRank'
                    ,CategoryCode = '$ddlCategory'
                    ,Size = '$allSize'
                    ,Material='$allMat'
                    ,ProductRefCode = '$txtRefCode'
                    ,Color = '$allColor'
                    ,Tag = '$allKeyWord'
                    ,Facility = '$allFacility'
                    ,ProjectModel= '$allProjectModel'
                    ,DesignModel='$allDesign'
                    ,BrandCode = '$ddlBrand'
                    ,ModelCode = '$ddlModel'
                    ,SubCategoryCode = '$ddlSubCategory'
                    ,SubCategoryCode3 = '$ddlSubCategory3'
                    ,SubCategoryCode4 = '$ddlSubCategory4'
                    ,MapLocation = '$txtLatLng'
                    ,Type='$ddlStatus'
                    ,LandArea=$txtLandArea
                    ,UsableArea=$txtUsableArea
                    ,BedRoom=$txtBedRoom
                    ,Toilet=$txtToilet
                    ,ParkingSpace=$txtParkingSpace
                    ,FloorNumber=$txtFloorNumber
                    ,LivingRoom = $txtLivingRoom
                    ,KitchenRoom = $txtKitchenRoom
                    ,ByName = '$txtByName'
                    ,ProductSize = '$txtProductSize'
                    ,Amount = $txtAmount
                    ,Address = '$txtAddress'
                    ,PriceDesc = '$txtPriceDesc'
                    ,StartDate='$txtStartDate'
                    ,EndDate='$txtEndDate'
                    ,Customer='$txtCustomer'
                    ,Weight = '$txtWeight'
                    ,TaxInfo='$txtTaxInfo'
                    ,Vendor='$txtVendor'
                    ,Collection='$txtCollection'
                    ,Barcode='$txtBarcode'
                    ,ColorCode='$txtColorCode'
                    ,ColorCode2='$txtColorCode2'
                    
                    where ProductCode = '$prdCode';
        ";

        ExecuteSQLTransaction($sqlUpdate,"product.php");
    }
    else
    {
        $prdCode = GenerateNextID("product","ProductCode",5,"P");
        $SEQ = GenerateNextOrder("product", "SEQ");
        $sqlInsert = "insert into product (ProductCode,ProductName,ShortDescription,ShortDescription2,ProductDetail,ProductDetail2,ProductDetail3,ProductDetail4,ProductDetail5,ProductDetail6,Image,Image2,Image3,Image4,Video,Video2
                        ,FileDownload,FileDownload2,FileDownload3,FileDownloadName,FileDownloadName2,FileDownloadName3,Active,CreatedOn,CreatedBy
                        ,BasePrice,OldPrice,Price,Hot,Promotion,New,Recommend,Rank,CategoryCode,Size,Material,ProductRefCode
                        ,Color,Tag,Facility,ProjectModel,DesignModel,BrandCode,ModelCode,SubCategoryCode,SubCategoryCode3,SubCategoryCode4,MapLocation,Type
                        ,LandArea,UsableArea,BedRoom,Toilet,ParkingSpace,FloorNumber,LivingRoom,KitchenRoom
                        ,ByName,ProductSize,Amount,Address,PriceDesc,StartDate,EndDate,Customer,Weight,LandingPage
                        ,TaxInfo,Vendor,Collection,Barcode,ColorCode,ColorCode2,SEQ)
                    VALUES(
                        '$prdCode',
                        '$txtSubject',
                        '$txtShortDescription',
                        '$txtShortDescription2',
                        '$txtDetail',
                        '$txtDetail2',
                        '$txtDetail3',
                        '$txtDetail4',
                        '$txtDetail5',
                        '$txtDetail6',
                        '$fileUploadedPath',
                        '$fileUploadedPath2',
                        '$fileUploadedPath3',
                        '$fileUploadedPath4',
                        '$hddFilePathVedio',
                        '$fileUploadedVideoPath2',
                        '$fileDownloadUploadPath',
                        '$fileDownloadUploadPath2',
                        '$fileDownloadUploadPath3',
                        '$fileDownloadName',
                        '$fileDownloadName2',
                        '$fileDownloadName3',
                        '$chkActive',
                        NOW(),
                        '".UserService::UserCode()."'
                        ,'$txtBasePrice'
                        ,'$txtOldPrice'
                        ,'$txtPrice'
                        ,'$choHot'
                        ,'$choPromotion'
                        ,'$choNew'
                        ,'$choRecommend'
                        ,'$txtRank'
                        ,'$ddlCategory'
                        ,'$allSize'
                        ,'$allMat'
                        ,'$txtRefCode'
                        ,'$allColor'
                        ,'$allKeyWord'
                        ,'$allFacility'
                        ,'$allProjectModel'
                        ,'$allDesign'
                        ,'$ddlBrand'
                        ,'$ddlModel'
                        ,'$ddlSubCategory'
                        ,'$ddlSubCategory3'
                        ,'$ddlSubCategory4'
                        ,'$txtLatLng'
                        ,'$ddlStatus'
                        ,$txtLandArea
                        ,$txtUsableArea
                        ,$txtBedRoom
                        ,$txtToilet
                        ,$txtParkingSpace
                        ,$txtFloorNumber
                        ,$txtLivingRoom
                        ,$txtKitchenRoom
                        ,'$txtByName'
                        ,'$txtProductSize'
                        ,$txtAmount
                        ,'$txtAddress'
                        ,'$txtPriceDesc'
                        ,'$txtStartDate'
                        ,'$txtEndDate'
                        ,'$txtCustomer'
                        ,'$txtWeight'
                        ,1
                        ,'$txtTaxInfo'
                        ,'$txtVendor'
                        ,'$txtCollection'
                        ,'$txtBarcode'
                        ,'$txtColorCode'
                        ,'$txtColorCode2'
                        ,$SEQ
                    );";

        ExecuteSQLTransaction($sqlInsert,"product.php");
        
    }
        
    $sqlDeleteColor = "delete from product_properties_mapping where ProductCode = '$prdCode' ";
    ExecuteSQL($sqlDeleteColor);
    
    if($__COG_PROPERTIES_OPTION){
        $chkPropDetail = $_POST["chkPropDetail"];
        for ($i = 0; $i < count($chkPropDetail); $i++)
        {
            $tg = $chkPropDetail[$i];
            if(isset($tg)){

                $sqlInsertColor = "insert into product_properties_mapping (PropCode,ProductCode,Detail)
                                    values(
                                    '$tg',
                                    '$prdCode',
                                    '1'
                                    );";
                ExecuteSQL($sqlInsertColor);
            }
        }
    }
    else
    {
        $txtPropCode = $_POST["txtPropCode"];
        $txtPropDetail = $_POST["txtPropDetail"];
        for ($i = 0; $i < count($txtPropCode); $i++)
        {
            $propCode = $txtPropCode[$i];
            $propDetail = trim($txtPropDetail[$i]);
            if(empty($propDetail))
                continue;
            
            $sqlInsertColor = "insert into product_properties_mapping (PropCode,ProductCode,Detail)
                                    values(
                                    '$propCode',
                                    '$prdCode',
                                    '$propDetail'
                                    );";
            ExecuteSQL($sqlInsertColor);
        }
    }
    
    GenerateHTAccess();
}

if(!empty($prdCode)){
    $sqlPrd = "select * from product where ProductCode = '$prdCode'";
    $data = SelectRow($sqlPrd);
}

?>

<style>
    .product-ranking-container{display:none}
    .product-promotion-container{display:none}
    .product-new-container{display:none}
    .product-recommend-container{display:none}
    .product-bestseller-container{display:none}
    .product-material-container{display:none}
    .product-file-container{display:none}
    .product-location-container{display:none}
    .product-tag-container{display:none}
    .product-size-container{display:none}
    .product-color-container{display:none}
    <?php if(!$__COGS_GLOBAL_CART){ ?>
    /* .product-size-container{display:none}
    .product-color-container{display:none} */
    <?php } ?>
</style>


<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <a href="product.php" class="link-history-btn">รายการ<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">จัดการข้อมูล<?php echo $_COG_ITEM_NAME ?></span>

</div>

<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <form id="form-product" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-9">
                        <div>
                            <span><b><?php echo empty($_GET["ref"]) ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล ".$_GET["ref"] ?></b></span>
                            <hr style="margin-top: 5px;" />
                        </div>
                        <div class="row">
                            <div class="col-sm-3 hide">
                                    <label>รหัส<?php echo $_COG_ITEM_NAME ?> / SKU</label>
                                    <input type="text" placeholder="รหัส<?php echo $_COG_ITEM_NAME ?>..." name="txtRefCode" id="txtRefCode" value="<?php echo $data["ProductRefCode"] ?>" class="form-control input-sm" />
                                </div>
                            <div class="col-sm-6">
                                <label>ชื่อ<?php echo $_COG_ITEM_NAME ?></label>
                                <input type="text" placeholder="ชื่อ<?php echo $_COG_ITEM_NAME ?>..." name="txtSubject" id="txtSubject" value="<?php echo $data["ProductName"] ?>" class="form-control input-sm require" />
                            </div>
                            <div class="col-sm-6">
                                <label>หมวดหมู่</label>
                                <!-- onchange="loadSubCategory(this.value);" -->
                                <select name="ddlCategory"   class="form-control input-sm require">
                                    <?php echo GetDropDownListOptionWithDefaultSelectedAndCondition("product_category","CategoryCode","CategoryName","กรุณาเลือก",$data["CategoryCode"],"Active = 1 and CategoryGroup = 'PRODUCT'") ?>
                                </select>
                            </div>
                            <div class="col-sm-3 hide">
                                <label>หมวดหมู่ย่อยที่ 2</label>
                                <!-- onchange="loadSubCategory3(this.value);"  -->
                                <select name="ddlSubCategory" id="ddlSubCategory" class="form-control input-sm require">
                                    <option value="">ไม่ระบุ</option>
                                </select>
                            </div>
                            <script>
                                function loadSubCategory(cateCode, setValue) {
                                    $("#ddlSubCategory").load("productSubCategoryLoadData.php?ref=" + cateCode, function () {
                                        if (setValue != undefined) {
                                            $("#ddlSubCategory").val(setValue);
                                        }
                                    });
                                }
                                <?php if(!empty($prdCode)){ ?>

                                loadSubCategory('<?php echo $data["CategoryCode"] ?>', '<?php echo $data["SubCategoryCode"] ?>');

                                <?php } ?>
                            </script>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 hide">
                                <label>หมวดหมู่ย่อยที่ 3</label>
                                <!-- onchange="loadSubCategory4(this.value);" -->
                                <select name="ddlSubCategory3" id="ddlSubCategory3"  class="form-control input-sm require">
                                    <option value="">ไม่ระบุ</option>
                                </select>
                            </div>

                        </div>
                        <div class="row hide">
                            <div class="col-sm-6 hide">
                                <label>หมวดหมู่<?php echo $_COG_ITEM_NAME ?> ย่อยที่ 4</label>
                                <select name="ddlSubCategory4" id="ddlSubCategory4" class="form-control input-sm require">
                                    <option value="">ไม่ระบุ</option>
                                </select>
                            </div>
                            <script>
                                function loadSubCategory3(cateCode, setValue) {
                                    $("#ddlSubCategory3").load("productSubCategoryLoadData3.php?ref=" + cateCode, function () {
                                        if (setValue != undefined) {
                                            $("#ddlSubCategory3").val(setValue);
                                        }
                                    });
                                }
                                function loadSubCategory4(cateCode, setValue) {
                                    $("#ddlSubCategory4").load("productSubCategoryLoadData4.php?ref=" + cateCode, function () {
                                        if (setValue != undefined) {
                                            $("#ddlSubCategory4").val(setValue);
                                        }
                                    });
                                }
                                <?php if(!empty($data["SubCategoryCode"])){ ?>
                                    loadSubCategory3('<?php echo $data["SubCategoryCode"] ?>', '<?php echo $data["SubCategoryCode3"] ?>');
                                <?php } ?>
                                <?php if(!empty($data["SubCategoryCode3"])){ ?>
                                    loadSubCategory4('<?php echo $data["SubCategoryCode3"] ?>', '<?php echo $data["SubCategoryCode4"] ?>');
                                <?php } ?>
                            </script>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <label>รายละเอียดย่อ</label>
                                <textarea name="txtShortDescription" id="txtShortDescription" class="form-control input-sm" rows="4"><?php echo $data["ShortDescription"] ?></textarea>
                            </div>
                        </div>
                        
                        <div class="row hide">
                            <div class="col-sm-4">
                                <label>ยี่ห้อ</label>
                                <!-- onchange="loadModel(this.value);" -->
                                <select name="ddlBrand"  class="form-control input-sm require">
                                    <?php //echo GetDropDownListOptionWithDefaultSelectedAndCondition("product_brand","BrandCode","BrandName","ไม่ระบุ",$data["BrandCode"],"Active = 1") ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label>รุ่น<?php echo $_COG_ITEM_NAME ?></label>
                                <select name="ddlModel" id="ddlModel" class="form-control input-sm">
                                    <option value="">ไม่ระบุ</option>
                                </select>
                            </div>
                            <script>
                                function loadModel(brandCode, setValue) {
                                    $("#ddlModel").load("productModelLoadData.php?ref=" + brandCode, function () {
                                        if (setValue != undefined) {
                                            $("#ddlModel").val(setValue);
                                        }
                                    });
                                }
                                <?php if(!empty($prdCode)){ ?>

                                loadModel('<?php echo $data["BrandCode"] ?>', '<?php echo $data["ModelCode"] ?>');

                                <?php } ?>
                            </script>

                        </div>

                        <div class="row hide">
                            <!-- <div class="col-sm-6">
                                <label>บริษัทก่อสร้าง</label>
                                <input type="text" placeholder="บริษัทก่อสร้าง..." name="txtByName" id="txtByName" value="<?php echo $data["ByName"] ?>" class="form-control input-sm require" />
                            </div> -->
                            <div class="col-sm-3 hide">
                                <label>ขนาดพื้นที่โครงการ</label>
                                <input type="text" placeholder="ขนาด..." name="txtProductSize" id="txtProductSize" value="<?php echo $data["ProductSize"] ?>" class="form-control input-sm require" />
                            </div>
                            <div class="col-sm-3">
                                <!-- <label>จำนวน (ยูนิต)</label> -->
                                <label>จำนวนสินค้า (คงเหลือ)</label>
                                <input type="number" placeholder="จำนวนคงเหลือ..." name="txtAmount" id="txtAmount" value="<?php echo $data["Amount"] ?>" class="form-control input-sm text-right require" />
                            </div>
                            <div class="col-sm-8">
                                <label>&nbsp;</label>
                                <div style="color:red">
                                    <b><i>* ระบบจะตัดจำนวนลงอัตโนมัติเมื่อสินค้าถูกสั่งซื้อ</i></b>
                                </div>
                            </div>
                        </div>
                        <div class="row hide">
                            <div class="col-sm-12">
                                <label>ที่ตั้งโครงการ</label>
                                <textarea name="txtAddress" id="txtAddress" class="form-control input-sm require" rows="4"><?php echo $data["Address"] ?></textarea>
                            </div>
                        </div>


                        <?php if($__COGS_GLOBAL_CART){ ?>
                        <div class="alert alert-info hide">
                            <h4><b>การกำหนดราคาสินค้า</b></h4>
                            <div class="row">
                                <div class="col-sm-4 hide">
                                    <label>ราคาต้นทุน</label>
                                    <span class="text-muted">(บาท)</span>
                                    <input type="number" step="1" placeholder="ราคาต้นทุน..." name="txtBasePrice" id="txtBasePrice" value="<?php echo empty($data["BasePrice"]) ? "0" : $data["BasePrice"] ?>" class="form-control input-sm" />
                                </div>
                                <div class="col-sm-4">
                                    <label>ราคาเดิม</label>
                                    <!-- <span class="text-muted">(บาท)</span> -->
                                    <input type="text" step="1" placeholder="ราคาเดิม..." name="txtOldPrice" id="txtOldPrice" value="<?php echo number_format($data["OldPrice"],2) ?>" class="form-control input-sm require text-right" onkeypress="IsKeyNumber(event);" onchange="IsFormatNumber(this);" />
                                </div>
                                <div class="col-sm-4">
                                    <label>ราคาใหม่ (ราคา Sale)</label>
                                    <!-- <span class="text-muted">(บาท)</span> -->
                                    <input type="text" step="1" placeholder="ราคา..." name="txtPrice" id="txtPrice" value="<?php echo number_format($data["Price"],2) ?>" class="form-control input-sm require text-right" onkeypress="IsKeyNumber(event);" onchange="IsFormatNumber(this);" />
                                </div>
                            </div>
                            <!-- <p class="label label-danger hide">
                                <b>** ราคาต้นทุนจะไม่ถูกนำไปแสดงในหน้าสินค้า</b>
                            </p> -->
                            <!-- <br /> -->
                            <p class="label label-danger">
                                <b>** หากไม่มีการ Sale ให้ระบุราคาในช่องราคาเดิม และราคาใหม่เท่ากัน</b>
                            </p>
                        </div>
                        <?php if(false){ ?>
                        <div class="alert alert-warning">
                            <h4 style="margin-bottom:10px"><b>น้ำหนักสินค้า</b></h4>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>น้ำหนักต่อ 1 หน่วย</label>
                                    <span class="text-danger">(กรัม)</span>
                                    <input type="number" step="1" onchange="weightCal(this);" onkeyup="weightChange(this);" placeholder="น้ำหนัก (กรัม)..." name="txtWeight" id="txtWeight" value="<?php echo $data["Weight"] ?>" class="form-control input-sm require" />
                                </div>
                                <div class="col-sm-6">
                                    <label>คิดเป็นกิโลกรัม (กิโลกรัม)</label>
                                    <span class="text-muted"></span>
                                    <input type="text" readonly placeholder="คิดเป็นกิโลกรัม..." name="txtWeightKG" id="txtWeightKG" value="0" class="form-control input-sm require" />
                                </div>
                            </div>
                            <div class="w-cal"></div>
                        </div>
                        <script>
                            
                            function weightChange(obj) {
                                var k = parseInt($(obj).val());
                                var kg = isNaN(k) ? 0 : k / 1000;
                                $("#txtWeightKG").val(kg);
                            }
                            function weightCal(obj){
                                $(".w-cal").load("productDetailDeliveryCal.php?w=" + $("#txtWeight").val());
                            }
                            $("#txtWeight").keyup().change();
                        </script>
                        <?php } ?>
                        <?php } ?>
                        
                        <!-- home detail -->
                        <!-- <br> -->
                        <div class="alert alert-info hide">
                            <span class="text-primary"><b>ข้อมูลการใช้สอย</b></span>
                            <hr style="margin-top: 5px;" />
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>แบบบ้าน</label>
                                    <!-- <select name="ddlCategory" class="form-control input-sm require">
                                        <?php //echo GetDropDownListOptionWithDefaultSelectedAndCondition("product_category","CategoryCode","CategoryName","กรุณาเลือก",$data["CategoryCode"],"Active = 1 and CategoryGroup = 'PRODUCT'") ?>
                                    </select> -->
                                </div>
                                <div class="col-sm-4">
                                    <label>พื้นที่ใช้สอย (ตารางเมตร)</label>
                                    <input type="number" placeholder="" name="txtUsableArea" id="txtUsableArea" value="<?php echo $data["UsableArea"] ?>" class="form-control input-sm text-right require" />
                                </div>
                                <div class="col-sm-4">
                                    <label>ขนาดที่ดิน (ตารางวา)</label>
                                    <input type="number" placeholder="" name="txtLandArea" id="txtLandArea" value="<?php echo $data["LandArea"] ?>" class="form-control input-sm text-right require" />
                                </div>
                                <div class="col-sm-4 hide">
                                    <label>จำนวนชั้น</label>
                                    <input type="number" placeholder="" name="txtFloorNumber" id="txtFloorNumber" value="<?php echo $data["FloorNumber"] ?>" class="form-control input-sm text-right require" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>ห้องนอน</label>
                                    <input type="number" placeholder="" name="txtBedRoom" id="txtBedRoom" value="<?php echo $data["BedRoom"] ?>" class="form-control input-sm text-right require" />
                                </div>
                                <div class="col-sm-4">
                                    <label>ห้องน้ำ</label>
                                    <input type="number" placeholder="" name="txtToilet" id="txtToilet" value="<?php echo $data["Toilet"] ?>" class="form-control input-sm text-right require" />
                                </div>
                                <div class="col-sm-4">
                                    <label>ห้องรับแขก</label>
                                    <input type="number" placeholder="" name="txtLivingRoom" id="txtLivingRoom" value="<?php echo $data["LivingRoom"] ?>" class="form-control input-sm text-right require" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>ห้องครัว</label>
                                    <input type="number" placeholder="" name="txtKitchenRoom" id="txtKitchenRoom" value="<?php echo $data["KitchenRoom"] ?>" class="form-control input-sm text-right require" />
                                </div>
                                <div class="col-sm-4">
                                    <label>ที่จอดรถ</label>
                                    <input type="number" placeholder="" name="txtParkingSpace" id="txtParkingSpace" value="<?php echo $data["ParkingSpace"] ?>" class="form-control input-sm text-right require" />
                                </div>
                            </div>

                        </div>
                        <!-- <br> -->
                        <div class="alert alert-warning hide">
                           
                            <span class="text-primary"><b>ข้อมูลโครงการ</b></span>
                            <hr style="margin-top: 5px;" />
                            <div class="row ">
                                <div class="col-sm-6">
                                    <label>ชื่อลูกค้า</label>
                                    <input type="text" placeholder="ชื่อลูกค้า..." name="txtCustomer" id="txtCustomer" value="<?php echo $data["Customer"] ?>" class="form-control input-sm require" />
                                </div>
                                <div class="col-sm-6">
                                    <label>บริษัทที่ปรึกษาโครงการ</label>
                                    <input type="text" placeholder="บริษัทที่ปรึกษาโครงการ..." name="txtByName" id="txtByName" value="<?php echo $data["ByName"] ?>" class="form-control input-sm require" />
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-sm-4">
                                    <label>มูลค่าโครงการ</label>
                                    <input type="text" placeholder="มูลค่าโครงการ..." name="txtPriceDesc" id="txtPriceDesc" value="<?php echo $data["PriceDesc"] ?>" class="form-control input-sm require" />
                                </div>
                                <div class="col-sm-4">
                                    <label>วันที่เริ่มงาน</label>
                                    <div class="input-group">
                                        <input name="txtStartDate" type="text" placeholder="เริ่ม..." class="form-control date-picker require" autocomplete="off"
                                            value="<?php echo ConvertDateDBToDateDisplay($data["StartDate"]); ?>" />
                                        <span class="input-group-addon hand">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label>กำหนดเสร็จ</label>
                                    <div class="input-group">
                                        <input name="txtEndDate" type="text" placeholder="ถึง..." class="form-control date-picker require" autocomplete="off"
                                            value="<?php echo ConvertDateDBToDateDisplay($data["EndDate"]); ?>" />
                                        <span class="input-group-addon hand">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                          
                            
                            <span class="text-primary"><b>ข้อมูลเพิ่มเติม</b></span>
                            <hr style="margin-top: 5px;" />
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Availability</label>
                                    <select name="ddlStatus" class="form-control input-sm">
                                        <?php echo GetDropDownListOptionWithDefaultSelectedAndCondition("tag","TagCode","TagName","กรุณาเลือก",$data["Type"],"TagType = 'PRODUCT_STATUS'") ?>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label>Tax Info</label>
                                    <input type="text" placeholder="Tax Info..." name="txtTaxInfo" id="txtTaxInfo" value="<?php echo $data["TaxInfo"] ?>" class="form-control input-sm" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Vendor</label>
                                    <input type="text" placeholder="Vendor..." name="txtVendor" id="txtVendor" value="<?php echo $data["Vendor"] ?>" class="form-control input-sm" />
                                </div>
                                <div class="col-sm-4">
                                    <label>Collection</label>
                                    <input type="text" placeholder="Collection..." name="txtCollection" id="txtCollection" value="<?php echo $data["Collection"] ?>" class="form-control input-sm" />
                                </div>
                                <div class="col-sm-4">
                                    <label>Barcode</label>
                                    <input type="text" placeholder="Barcode..." name="txtBarcode" id="txtBarcode" value="<?php echo $data["Barcode"] ?>" class="form-control input-sm" />
                                </div>
                            </div>
                            <br>
                            <div class="hide">
                                <?php if($__COG_PROPERTIES_OPTION){ ?>
                                <div class="">
                                    <span><b>ข้อมูลฟังก์ชั่น<?php echo $_COG_ITEM_NAME ?></b></span>
                                    <hr style="margin-top: 5px; margin-bottom: 10px;" />
                                    <div class="row">
                                        <?php
                                            $sqlTags = "select prop.*,map.Detail 
                                                    from product_properties prop
                                                    left join product_properties_mapping map
                                                        on map.PropCode = prop.PropCode 
                                                        and map.ProductCode = '".$prdCode."'
                                                    where prop.Active = 1 
                                                        and prop.PropGroup = '$_COG_ITEM_CODE'
                                                    order by prop.SEQ";
                                            $dataTags = SelectRowsArray($sqlTags);
                                            foreach ($dataTags  as $tag) {
                                            ?>
                                            <div class="col-sm-6" onclick="$(this).find('input').click();">
                                                <input onclick="event.stopPropagation();" class="chk-project-model" type="checkbox" <?php echo !empty($tag["Detail"]) ? "checked" : "" ?> name="chkPropDetail[]" id="chk-<?php echo $tag["PropCode"] ?>" value="<?php echo $tag["PropCode"] ?>" />
                                                <label onclick="event.stopPropagation();" for="chk-<?php echo $tag["PropCode"] ?>" class="hand"><span class="text-primary"><?php echo $tag["PropName"]; ?></span></label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                        </div>
                        
                        <div class="hide">
                            <span><b>ฟังก์ชั่นบ้าน
                            </b></span>
                            <hr style="margin-top: 5px; margin-bottom: 10px;" />
                            <div class="row">
                                <?php
                                    $sqlTags = "select a.PortCode,a.PortName,a.CategoryCode,b.CategoryName,a.Image 
                                        FROM portfolio a
                                        left join product_category b on a.CategoryCode = b.CategoryCode
                                        WHERE a.Active=1 and a.PortType='PROJECTMODEL' ";
                                    $dataTags = SelectRowsArray($sqlTags);
                                    foreach ($dataTags  as $tag) {
                                    ?>
                                    <div class="col-sm-12" onclick="$(this).find('input').click();">
                                        <input onclick="event.stopPropagation();" class="chk-project-model" type="checkbox" <?php echo strpos($data["ProjectModel"],$tag["PortCode"]) !== false ? "checked" : "" ?> name="chkProjectModel[]" id="chk-<?php echo $tag["PortCode"] ?>" value="<?php echo $tag["PortCode"] ?>" />
                                        <label onclick="event.stopPropagation();" for="chk-<?php echo $tag["PortCode"] ?>" class="hand"><span class="text-primary">[<?php echo $tag["CategoryName"]; ?>]</span> <?php echo $tag["PortName"]; ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="hide">
                            <span><b>สิ่งอำนวยความสะดวก
                            </b></span>
                            <hr style="margin-top: 5px; margin-bottom: 10px;" />
                            <div class="row">
                                <?php
                                    $sqlTags = "select PortCode,PortName,Image FROM portfolio WHERE Active=1 and PortType='FACILITY'";
                                    $dataTags = SelectRowsArray($sqlTags);
                                    foreach ($dataTags  as $tag) {
                                    ?>
                                    <div class="col-sm-6" onclick="$(this).find('input').click();">
                                        <input onclick="event.stopPropagation();" class="chk-facility" type="checkbox" <?php echo strpos($data["Facility"],$tag["PortCode"]) !== false ? "checked" : "" ?> name="chkFacility[]" id="chk-<?php echo $tag["PortCode"] ?>" value="<?php echo $tag["PortCode"] ?>" />
                                        <label onclick="event.stopPropagation();" for="chk-<?php echo $tag["PortCode"] ?>" class="hand"><?php echo $tag["PortName"] ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="hide">
                            <span><b>การออกแบบ
                            </b></span>
                            <hr style="margin-top: 5px; margin-bottom: 10px;" />
                            <div class="row">
                                <?php
                                    $sqlTags = "select PortCode,PortName,Image FROM portfolio WHERE Active=1 and PortType='DESIGN'";
                                    $dataTags = SelectRowsArray($sqlTags);
                                    foreach ($dataTags  as $tag) {
                                    ?>
                                    <div class="col-sm-6" onclick="$(this).find('input').click();">
                                        <input onclick="event.stopPropagation();" class="chk-design" type="checkbox" <?php echo strpos($data["DesignModel"],$tag["PortCode"]) !== false ? "checked" : "" ?> name="chkDesign[]" id="chk-<?php echo $tag["PortCode"] ?>" value="<?php echo $tag["PortCode"] ?>" />
                                        <label onclick="event.stopPropagation();" for="chk-<?php echo $tag["PortCode"] ?>" class="hand"><?php echo $tag["PortName"] ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- <br /><br /> -->
                        <div class="row hide">
                            <div class="col-sm-4">
                                <label>Lazada</label>
                                <input type="text" name="txtLazada" id="txtLazada" value="<?php echo $data["Lazada"] ?>" class="form-control input-sm" />
                            </div>
                            <div class="col-sm-4">
                                <label>Shopee</label>
                                <input type="text" name="txtShopee" id="txtShopee" value="<?php echo $data["Shopee"] ?>" class="form-control input-sm" />
                            </div>
                            <div class="col-sm-4">
                                <label>Line</label>
                                <input type="text" name="txtLine" id="txtLine" value="<?php echo $data["Line"] ?>" class="form-control input-sm" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 summernote-container">
                                <label>รายละเอียด</label>
                                <?php 
                                // =============== HTML EDITOR =============== 
                                $_HTML_EDITOR_NAME = "txtDetail";
                                $_HTML_EDITOR_CONTENT_ID = $data["ProductDetail"];
                                include $GLOBALS['DOCUMENT_ROOT'].'/ControlPanel/HtmlEditor/HtmlEditor.php'; 
                                ?>
                            </div>
                        </div>

                        <div class="row hide">
                            <div class="col-sm-12 summernote-container">
                                <!-- <label>รายละเอียด 2</label> -->
                                <label>INGREDIENT</label>
                                <?php 
                                // =============== HTML EDITOR =============== 
                                $_HTML_EDITOR_NAME = "txtDetail2";
                                $_HTML_EDITOR_CONTENT_ID = $data["ProductDetail2"];
                                include $GLOBALS['DOCUMENT_ROOT'].'/ControlPanel/HtmlEditor/HtmlEditor.php'; 
                                ?>
                            </div>
                        </div>
                        <div class="row hide">
                            <div class="col-sm-12 summernote-container">
                                <!-- <label>รายละเอียด 3</label> -->
                                <label>FEATURES</label>
                                <?php 
                                // =============== HTML EDITOR =============== 
                                $_HTML_EDITOR_NAME = "txtDetail3";
                                $_HTML_EDITOR_CONTENT_ID = $data["ProductDetail3"];
                                include $GLOBALS['DOCUMENT_ROOT'].'/ControlPanel/HtmlEditor/HtmlEditor.php'; 
                                ?>
                            </div>
                        </div>
                        <div class="row hide">
                            <div class="col-sm-12 summernote-container">
                                <!-- <label>รายละเอียด 3</label> -->
                                <label>HOW TO USE</label>
                                <?php 
                                // =============== HTML EDITOR =============== 
                                $_HTML_EDITOR_NAME = "txtDetail4";
                                $_HTML_EDITOR_CONTENT_ID = $data["ProductDetail4"];
                                include $GLOBALS['DOCUMENT_ROOT'].'/ControlPanel/HtmlEditor/HtmlEditor.php'; 
                                ?>
                            </div>
                        </div>

                        <div class=" hide">
                            <div class="col-sm-12 summernote-container">
                                <label>CETIFICATE</label>
                                <?php 
                                // =============== HTML EDITOR =============== 
                                $_HTML_EDITOR_NAME = "txtDetail5";
                                $_HTML_EDITOR_CONTENT_ID = $data["ProductDetail5"];
                                include $GLOBALS['DOCUMENT_ROOT'].'/ControlPanel/HtmlEditor/HtmlEditor.php'; 
                                ?>
                            </div>
                        </div>

                        <hr style="margin-top: 5px; margin-bottom: 10px;" />
                        <!-- image 4 -->
                        <div class="row hide">
                           <div class="col-md-12">
                                <br>
                                <!-- <span><b>รูปภาพแบนเนอร์</b></span> -->
                                <span><b>Highlight แสดงที่หน้าแรก<span class="text-danger">*คอนเทนต์จะแสดงที่หน้าแรก เมื่อเปิดโหมด Highlight</span></b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                <p>
                                    <small class="text-danger">*ขนาดภาพที่เหมาะสมที่สุดคือ 1200 x 900 pixels</small>
                                </p>
                                <div class="slide-banner" style="height: 400px;">
                                    <img id="imge-preview4" class="image-box hand" onclick="$(this).next().click();"
                                    src="<?php echo empty($data["Image4"]) ? "../assets/images/default/1200x900.png" : $data["Image4"] ?>"
                                    style="margin:0 auto; width: 100%; height: 400px;margin-bottom:15px;">
                                    </img>
                                    <input class="hide" type="file" onchange="$(this).previewImage($('#imge-preview4'));$(this).closest('.slide-banner').find('.remover').removeClass('hide')"
                                        name="fileUpload4" id="fileUpload4" accept="image/*" />
                                    <input type="hidden" name="hddBackUpImage4" value="<?php echo $data["Image4"] ?>" />
                                    <div class="text-center">
                                        <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                                    </div>
                                    <i class="fa fa-trash remover <?php echo empty($data["Image4"]) ? "hide" : "" ?>" onclick="deleteImage(this);"></i>
                                </div>
                            </div>
                        </div>
                        <div class="hide">
                            <div class="col-sm-12 summernote-container">
                                <label>รายละเอียด Highlight</label>
                                <?php 
                                // =============== HTML EDITOR =============== 
                                $_HTML_EDITOR_NAME = "txtDetail6";
                                $_HTML_EDITOR_CONTENT_ID = $data["ProductDetail6"];
                                include $GLOBALS['DOCUMENT_ROOT'].'/ControlPanel/HtmlEditor/HtmlEditor.php'; 
                                ?>
                            </div>
                        </div>
                        
                        <div class="row hide">
                            <div class="col-sm-12">
                                <label>รายละเอียดย่อ 2</label>
                                <textarea name="txtShortDescription2" id="txtShortDescription2" class="form-control input-sm require" rows="4"><?php echo $data["ShortDescription2"] ?></textarea>
                            </div>
                        </div>

                        <div class="row hide">
                            <div class="col-sm-6">
                                <label>สีพื้นหลังภาพ Highlight</label>
                                <input type="color" name="txtColorCode" id="txtColorCode" value="<?php echo $data["ColorCode"] ?>" class="form-control input-sm require" />
                            </div>
                            <div class="col-sm-6">
                                <label>สีพื้นหลังรายละเอียด Highlight</label>
                                <input type="color" name="txtColorCode2" id="txtColorCode2" value="<?php echo $data["ColorCode2"] ?>" class="form-control input-sm require" />
                            </div>
                        </div>

                        

                        
                        <?php if(!$__COG_PROPERTIES_OPTION){ ?>
                        <div class="hide">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3>
                                        <small class="text-danger">*กรอกเฉพาะคุณสมบัติที่ตรงกับ<?php echo $_COG_ITEM_NAME ?></small>
                                    </h3>
                                        <hr style="margin-top: 5px;" />
                                        <div>
                                            <table class="table table-striped">
                                                <?php
                                    
                                                $sql = "select prop.*,map.Detail 
                                                from product_properties prop
                                                left join product_properties_mapping map
                                                    on map.PropCode = prop.PropCode 
                                                    and map.ProductCode = '".$prdCode."'
                                                where prop.Active = 1 
                                                    and prop.PropGroup = '$_COG_ITEM_CODE'
                                                order by prop.SEQ";
                                                $dataProps = SelectRows($sql);
                                                foreach ($dataProps as $dataProp) {
                                                ?>
                                                <tr>
                                                    <th class="text-right" style="width: 200px; vertical-align: middle; padding-right: 30px; color: #ed2437"><?php echo $dataProp["PropName"] ?>&nbsp;&nbsp;<i class="fa <?php echo $dataProp["PropIcon"] ?>"></i></th>
                                                    <td>
                                                        <?php
                                                            if(!empty($dataProp["PropSelected"])){
                                                        ?>
                                                            <select name="txtPropDetail[]" class="form-control input-sm">
                                                                <?php echo GetDropDownListOptionWithDefaultSelectedAndCondition("tag","TagCode","TagName","",$dataProp["Detail"],"TagType = '".$dataProp["PropSelected"]."'") ?>
                                                            </select>
                                                        <?php }else{ ?>
                                                            <textarea name="txtPropDetail[]" style="min-height:30px;" class="form-control input-sm"><?php echo $dataProp["Detail"] ?></textarea>
                                                        <?php } ?>
                                                        <input type="hidden" name="txtPropCode[]" value="<?php echo $dataProp["PropCode"] ?>" />
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </table>
                                        </div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <br />

                        <style>
                            .tag-panel {
                                border-bottom: 1px solid #ccc;
                                margin-bottom: 0;
                                padding: 3px 10px;
                                cursor: pointer;
                            }

                                .tag-panel:hover {
                                    background: #eee;
                                }
                        </style>

                        <div class="product-color-container">

                            <span><b>สีที่มี
                            <span class="text-danger">*เลือกอย่างน้อย 1 รายการ
                            </span>
                            </b></span>
                            <hr style="margin-top: 5px; margin-bottom: 10px;" />

                            <div class="row">
                            <?php
                        
                            $sqlTags = "select * from tag where TagType = 'COLOR' and Active = 1 order by TagName";
                        
                            $dataTags = SelectRows($sqlTags);
                            foreach ($dataTags as $tag) {
                            ?>
                            <div class="col-sm-6" onclick="$(this).find('input').click();">
                                <input onclick="event.stopPropagation();" class="chk-tag" type="checkbox" <?php echo strpos($data["Color"],$tag["TagCode"]) !== false ? "checked" : "" ?> name="chkTag[]" id="chk-<?php echo $tag["TagCode"] ?>" value="<?php echo $tag["TagCode"] ?>" />
                                <label onclick="event.stopPropagation();" for="chk-<?php echo $tag["TagCode"] ?>" class="hand">&nbsp;<i class="fa fa-square" style="color: <?php echo $tag["FreeText"] ?>;"></i>&nbsp;&nbsp;<?php echo $tag["TagName"] ?></label>
                            </div>
                            <?php } ?>
                            </div>

                        </div>

                        <div class="product-material-container">

                            <span><b>Material ที่มี
                            <span class="text-danger">*เลือกอย่างน้อย 1 รายการ
                            </span>
                            </b></span>
                            <hr style="margin-top: 5px; margin-bottom: 10px;" />

                            <div class="row">
                            <?php
                        
                            $sqlTags = "select * from tag where TagType = 'MATERIAL' and Active = 1 order by TagName";
                        
                            $dataTags = SelectRows($sqlTags);
                            foreach ($dataTags as $tag) {
                                $chechTag = strpos($tag["TagCode"], $data["Material"]);
                            ?>
                            <div class="col-sm-6" onclick="$(this).find('input').click();">
                                <input onclick="event.stopPropagation();" class="chk-material" type="checkbox" <?php echo strpos($data["Material"],$tag["TagCode"]) !== false ? "checked" : "" ?> name="chkMaterial[]" id="chk-<?php echo $tag["TagCode"] ?>" value="<?php echo $tag["TagCode"] ?>" />
                                <label onclick="event.stopPropagation();" for="chk-<?php echo $tag["TagCode"] ?>" class="hand"><?php echo $tag["TagName"] ?></label>
                            </div>
                            <?php } ?>
                            </div>

                        </div>

                        <div class="product-size-container">

                            <span><b>
                                ไซส์ที่มี
                            <span class="text-danger">*เลือกอย่างน้อย 1 รายการ
                            </span>
                            </b></span>
                            <hr style="margin-top: 5px; margin-bottom: 10px;" />

                            <div class="row">
                            <?php
                        
                            $sqlTags = "select * from tag where TagType = 'SIZE' and Active = 1 order by SEQ,TagName";
                        
                            $dataTags = SelectRows($sqlTags);
                            foreach ($dataTags as $tag) {
                            ?>
                            <div class="col-sm-6" onclick="$(this).find('input').click();">
                                <input onclick="event.stopPropagation();" class="chk-size" type="checkbox" <?php echo strpos($data["Size"],$tag["TagCode"]) !== false ? "checked" : "" ?> name="chkSize[]" id="chk-<?php echo $tag["TagCode"] ?>" value="<?php echo $tag["TagCode"] ?>" />
                                <label onclick="event.stopPropagation();" for="chk-<?php echo $tag["TagCode"] ?>" class="hand"><?php echo $tag["TagName"] ?></label>
                            </div>
                            <?php } ?>
                            </div>

                        </div>

                        <div class="product-tag-container">
                            <span><b>แท็ก
                            <span class="text-danger">*เลือกอย่างน้อย 1 รายการ
                            </span>
                            </b></span>
                            <hr style="margin-top: 5px; margin-bottom: 10px;" />
                            <div class="row">
                                <?php
                                    $sqlTags = "select * from tag where Active = 1 and TagType = 'PRODUCT' order by TagName";
                                    $dataTags = SelectRowsArray($sqlTags);
                                    foreach ($dataTags  as $tag) {
                                    ?>
                                    <div class="col-sm-6" onclick="$(this).find('input').click();">
                                        <input onclick="event.stopPropagation();" class="chk-tag-keyword" type="checkbox" <?php echo strpos($data["Tag"],$tag["TagCode"]) !== false ? "checked" : "" ?> name="chkTagKeyWord[]" id="chk-<?php echo $tag["TagCode"] ?>" value="<?php echo $tag["TagCode"] ?>" />
                                        <label onclick="event.stopPropagation();" for="chk-<?php echo $tag["TagCode"] ?>" class="hand"><?php echo $tag["TagName"] ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">

                        <div>
                            <!-- image 1 -->
                            <div>
                                <span><b>รูปภาพหลัก</b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                <p>
                                    <small class="text-danger">*ขนาดภาพที่เหมาะสมที่สุดคือ 570 x 679 pixels</small>
                                </p>
                                <div id="imge-preview" class="image-box hand" onclick="$(this).next().click();"
                                style="margin:0 auto; width: 200px; height: 230px;margin-bottom:15px; background-image: url(<?php echo $data["Image"] ?>), url('../assets/images/default/570x679.png')">
                                </div>
                                <input class="hide" type="file" onchange="$(this).previewImage($('#imge-preview'));"
                                    name="fileUpload" id="fileUpload" accept="image/*" />
                                <input type="hidden" name="hddBackUpImage" value="<?php echo $data["Image"] ?>" />
                                <div class="text-center">
                                    <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                                </div>
                            </div>

                            <!-- image 2 -->
                            <div class="hide">
                                <span><b>รูปภาพรอง</b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                <p>
                                    <small class="text-danger">*ขนาดภาพที่เหมาะสมที่สุดคือ 800 x 800 pixels</small>
                                </p>
                                <div id="imge-preview-2" class="image-box hand" onclick="$(this).next().click();"
                                style="margin:0 auto; width: 200px; height: 230px;margin-bottom:15px; background-image: url(<?php echo $data["Image2"] ?>), url('https://ipsumimage.appspot.com/800x800,eee')">
                                </div>
                                <input class="hide" type="file" onchange="$(this).previewImage($('#imge-preview-2'));"
                                    name="fileUpload2" id="fileUpload2" accept="image/*" />
                                <input type="hidden" name="hddBackUpImage2" value="<?php echo $data["Image2"] ?>" />
                                <div class="text-center">
                                    <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                                </div>
                            </div>

                            <!-- image 3 -->
                            <div class="hide">
                                <br>
                                <span><b>รูปภาพปกวีดีโอ</b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                <p>
                                    <small class="text-danger">*ขนาดภาพที่เหมาะสมที่สุดคือ 558 x 369 pixels</small>
                                </p>

                                <div id="imge-preview3" class="image-box hand" onclick="$(this).next().click();"
                                style="margin:0 auto; width: 200px; height: 230px;margin-bottom:15px; background-image: url(<?php echo $data["Image3"] ?>), url('https://ipsumimage.appspot.com/558x369,eee')">
                                </div>

                                <input class="hide" type="file" onchange="$(this).previewImage($('#imge-preview3'));"
                                    name="fileUpload3" id="fileUpload3" accept="image/*" />

                                <input type="hidden" name="hddBackUpImage3" value="<?php echo $data["Image3"] ?>" />

                                <div class="text-center">
                                    <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพ</small>
                                </div>
                            </div>

                            
                            <div class="hide">
                                <span>
                                    <b>
                                        <a href="javascript:;" onclick="$('#modal-howto').modal('show');">
                                            <i class="fa fa-search"></i>
                                            เพิ่มวีดีโอ ดูวิธีการหาลิงค์ยูทูป
                                        </a>
                                    </b>
                                </span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                <div class="row">
                                    <div class="col-md-12">
                                        <div>
                                            <style>
                                                .slide-banner {
                                                    width: 100%;
                                                    height: 200px;
                                                    position: relative;
                                                }

                                                .slide-banner .remover,
                                                .slide-banner .editer {
                                                    position: absolute;
                                                    right: -8px;
                                                    top: -8px;
                                                    width: 26px;
                                                    height: 26px;
                                                    border-radius: 50%;
                                                    background: #000;
                                                    color: #fff;
                                                    text-align: center;
                                                    font-size: 17px;
                                                    padding-top: 2px;
                                                    z-index: 10;
                                                    cursor: pointer;
                                                    border: 1px solid #fff;
                                                }

                                                .slide-banner .remover:hover,
                                                .slide-banner .editer:hover {
                                                    background: #F58512;
                                                }

                                                .slide-banner .editer {
                                                    right: 20px;
                                                }
                                            </style>
                                            <div class="row panel-video">

                                                <div class="panel-video-display col-xs-12 <?php echo !empty($data["Video"]) ? "" : "hide" ?>">
                                                    <div class="slide-banner image-box">
                                                        <iframe class="iframe-video-diaplay" style="width:100%;height:100%;background:#000" src="<?php echo $data["Video"] ?>"></iframe>
                                                        <i class="fa fa-trash remover" onclick="$(this).next().click();"></i>
                                                        <input type="button" onclick="confirmDeleteVedio(this);" class="btn-delete hide" name="btnDelete" value="" />
                                                        <input type="hidden" name="hddFilePathVedio" value="<?php echo $data["Video"] ?>" />
                                                    </div>
                                                </div>
                                                
                                                <div class="panel-video-add col-xs-12 <?php echo empty($data["Video"]) ? "" : "hide" ?>">
                                                    <form method="post" enctype="multipart/form-data">
                                                        <div class="slide-banner image-box slide-adder hand" onclick="openModalInsert();" style="position: relative; background-color: #eee;">
                                                            <div style="position: absolute; left: 0; right: 0; top: 75px; text-align: center;">
                                                                <i class="fa fa-video fa-5x text-muted"></i>
                                                            </div>
                                                            <div style="position: absolute; left: 0; right: 0; bottom: 75px; text-align: center;">
                                                                <small>คลิกเพื่อเพิ่มวีดีโอ</small>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- Modal -->
                                            <div id="modal-howto" class="modal fade" role="dialog">
                                                <div class="modal-dialog modal-lg">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">วิธีการหาลิงค์ยูทูป</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>1. ไปที่ <a target="_blank" href="https://www.youtube.com">https://www.youtube.com</a></p>
                                                            <p>
                                                                2. ค้นหาและคลิกเพื่อดูวีดีโอที่คุณต้องการเพิ่ม เช่น
                                                            </p>
                                                            <p>
                                                                <img src="../video/assets/how-1.png" style="width:100%" />
                                                            </p>
                                                            <p>
                                                                3. คัดลอก URL ของวีดีโอ
                                                            </p>
                                                            <p>
                                                                <img src="../video/assets/how-2.png" style="width:100%" />
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                function openModalInsert() {
                                                    $("#modal-insert").modal("show");
                                                }

                                                function onchangeVideoInsert(obj) {
                                                    var val = $(obj).prev().val();
                                                    if (val.toLowerCase().match("youtube.com") && val.toLowerCase().match("v=")) {
                                                        val = "https://www.youtube.com/embed/" + getUrlVars(val)["v"]; //val.split("v=")[val.split("v=").length - 1];
                                                    } else if (val.toLowerCase().match("youtu.be")) {
                                                        val = "https://www.youtube.com/embed/" + val.split("/")[val.split("/").length - 1];
                                                    }
                                                    $(obj).prev().val(val);
                                                    var frame = $(obj).closest(".modal").find(".iframe-video");
                                                    frame.prop("src", val);
                                                }

                                                function getUrlVars(val)
                                                {
                                                    var vars = [], hash;
                                                    var hashes = val.slice(val.indexOf('?') + 1).split('&');
                                                    for(var i = 0; i < hashes.length; i++)
                                                    {
                                                        hash = hashes[i].split('=');
                                                        vars.push(hash[0]);
                                                        vars[hash[0]] = hash[1];
                                                    }
                                                    return vars;
                                                }

                                                function confirmDeleteVedio(obj)
                                                {
                                                    if(Confirm(obj, 'Are you sure you want delete ?'))
                                                    {
                                                        var frame = $(obj).closest(".modal").find(".iframe-video");
                                                        frame.prop("src", "");
                                                        $(obj).next().val("");
                                                        //$("[name='txtImagePathVideo']").val("");
                                                        var panelVideo = $(obj).closest('.panel-video');
                                                        $(panelVideo).find('.panel-video-display').addClass('hide');
                                                        $(panelVideo).find('.panel-video-add').removeClass('hide');
                                                        
                                                    }
                                                }

                                                function onchangeVideoDiaplayForSave(obj) {
                                                    if(Validate(obj,$('#modal-insert')))
                                                    {
                                                        var val = $(obj).closest('.modal-dialog').find("[name='txtImagePathVideo']").val();
                                                        if (val.toLowerCase().match("youtube.com") && val.toLowerCase().match("v=")) {
                                                            val = "https://www.youtube.com/embed/" + getUrlVars(val)["v"]; //val.split("v=")[val.split("v=").length - 1];
                                                        } else if (val.toLowerCase().match("youtu.be")) {
                                                            val = "https://www.youtube.com/embed/" + val.split("/")[val.split("/").length - 1];
                                                        }
                                                        var frame = $(".iframe-video-diaplay");
                                                        $(frame).closest('.slide-banner').find('[name="hddFilePathVedio"]').val(val);
                                                        frame.prop("src", val);
                                                        var panelVideo = $(frame).closest('.panel-video');
                                                        $(panelVideo).find('.panel-video-display').removeClass('hide');
                                                        $(panelVideo).find('.panel-video-add').addClass('hide');
                                                        $("#modal-insert").modal("hide");

                                                    }
                                                }

                                            </script>
                                            <!-- Modal -->
                                            <div id="modal-insert" class="modal fade" role="dialog">
                                                <div class="modal-dialog  modal-lg">
                                                    <!-- Modal content-->
                                                    <form method="post" class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">เพิ่มลิงค์ของวีดีโอ</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <p>
                                                                        <label>วีดีโอ</label>
                                                                        <iframe class="iframe-video" style="width:100%;height:280px;background:#000"></iframe>
                                                                    </p>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <p>
                                                                        <label>URL Youtube</label>
                                                                        <div class="input-group">
                                                                            <input type="text" placeholder="URL Youtube" class="form-control input-sm require" name="txtImagePathVideo" value="<?php echo $data["Video"] ?>" />
                                                                            <span class="input-group-addon hand" onclick="onchangeVideoInsert(this);">
                                                                                <i class="fa fa-refresh"></i>
                                                                            </span>
                                                                        </div>
                                                                    </p>
                                                                    <p>
                                                                        <b class="text-danger">
                                                                            ** เมื่อกรอก URL แล้วกดปุ่ม <i class="fa fa-refresh"></i> หาก URL ถูกต้องวีดีโอของคุณจะปรากฏในด้านซ้าย
                                                                        </b>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <span onclick="onchangeVideoDiaplayForSave(this);" class="btn btn-success">บันทึก</span>
                                                            <!-- <button type="submit" onclick="return Validate(this,$('#modal-insert'));" class="btn btn-success" value="VIDEO" name="btnUpload">บันทึก</button> -->
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="hide">
                                <span><b>วีดีโอแนะนำสินค้า</b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                <div class="row panel-video">

                                    <div class="panel-video-display col-xs-12 <?php echo !empty($data["Video2"]) ? "" : "hide" ?>">
                                        <div class="slide-banner image-box">
                                            <style>
                                                .slide-banner {
                                                    width: 100%;
                                                    height: 300px;
                                                    position: relative;
                                                }

                                                .slide-banner .remover,
                                                .slide-banner .editer {
                                                    position: absolute;
                                                    right: -8px;
                                                    top: -8px;
                                                    width: 26px;
                                                    height: 26px;
                                                    border-radius: 50%;
                                                    background: #000;
                                                    color: #fff;
                                                    text-align: center;
                                                    font-size: 17px;
                                                    padding-top: 2px;
                                                    z-index: 10;
                                                    cursor: pointer;
                                                    border: 1px solid #fff;
                                                }

                                                .slide-banner .remover:hover,
                                                .slide-banner .editer:hover {
                                                    background: #F58512;
                                                }

                                                .slide-banner .editer {
                                                    right: 20px;
                                                }
                                            </style>
                                            <video class="slide-banner video-local-server" controls=""  muted="" style="object-fit:cover;border-radius: 5px;">
                                                <source src="<?php echo $data["Video2"] ?>">
                                            </video>
                                            <i class="fa fa-pencil editer <?php echo !empty($data["Video2"]) ? "" : "hide" ?>" onclick="$(this).closest('.panel-video').find('input[type=file]').click();"></i>
                                            <i class="fa fa-remove remover <?php echo !empty($data["Video2"]) ? "" : "hide" ?>" onclick="deleteVideoLocal(this);"></i>
                                            
                                        </div>
                                    </div>

                                    <div class="panel-video-add col-xs-12 <?php echo empty($data["Video2"]) ? "" : "hide" ?>">
                                        <div class="slide-banner image-box slide-adder hand" onclick="$(this).closest('.panel-video').find('input[type=file]').click();" style="position: relative; background-color: #eee;">
                                            <div style="position: absolute; left: 0; right: 0; top: 75px; text-align: center;">
                                                <i class="fa fa-video fa-5x text-muted"></i>
                                            </div>
                                            <div style="position: absolute; left: 0; right: 0; bottom: 150px; text-align: center;">
                                                <small>คลิกเพื่อเพิ่มวีดีโอ</small>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="hide" type="file" onchange="uploadBannerVideo(this);" name="fileUploadVideo" accept="video/*" />
                                    <input type="hidden" name="hddBackUpVideo" value="<?php echo $data["Video2"] ?>" />

                                </div>
                                <script>
                                    function uploadBannerVideo(input) {
                                        if ($(input).validateUploadVideo($(".video-local-server"))) {
                                            var target = $(input).closest(".panel-video");
                                            $(target).find('.panel-video-display').removeClass("hide");
                                            $(target).find('.editer').removeClass("hide");
                                            $(target).find('.remover').removeClass("hide");
                                            $(target).find('.panel-video-add').addClass("hide");
                                        }
                                        else
                                        {
                                            $(input).val("");
                                        }
                                    }
                                    function deleteVideoLocal(obj){
                                        if(AlertConfirm(obj,"Comfirm delete?")){
                                            var target = $(obj).closest(".panel-video");
                                            $(target).find('input[type=file]').val('');
                                            $(target).find('input[name=hddBackUpVideo]').val('');
                                            $(target).find(".video-local-server source").attr("src","");
                                            $(target).find('.panel-video-display').addClass("hide");
                                            $(target).find('.editer').addClass("hide");
                                            $(target).find('.remover').addClass("hide");
                                            $(target).find('.panel-video-add').removeClass("hide");
                                        }
                                    }
                                </script>
                            </div>

                            <div class="product-active-container">

                                <br />
                                <span><b>ใช้งาน / ไม่ใช้งาน</b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />

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

                            <div class="product-promotion-container">
                                <br />
                                <!-- <span><b>Promotion</b></span> -->
                                <span><b>Collection</b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />

                                <div>
                                    <i id="toggle-Promotion" class="fa fa-toggle-on fa-3x text-primary hand" onclick="togglePromotion(this);"></i>
                                    <input type="checkbox" name="choPromotion" class="hide" checked="checked" value="" />
                                </div>
                                <script>
                                    function togglePromotion(obj) {
                                        $(obj).toggleClass('fa-toggle-on').toggleClass('fa-toggle-off')
                                        .toggleClass('text-primary')
                                        .toggleClass('text-danger').next().click();
                                    }
                                    <?php if(!empty($_GET["ref"]) && $data["Promotion"] == 0){ ?>
                                    $("#toggle-Promotion").click();
                                    <?php } ?>
                                </script>
                            </div>

                            <div class="product-new-container">
                                <br />
                                <span><b>สินค้ามาใหม่</b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />

                                <div>
                                    <i id="toggle-new" class="fa fa-toggle-on fa-3x text-primary hand" style="" onclick="toggleNew(this);"></i>
                                    <input type="checkbox" name="choNew" class="hide" checked="checked" value="" />
                                </div>
                                <script>
                                    function toggleNew(obj) {
                                        $(obj).toggleClass('fa-toggle-on').toggleClass('fa-toggle-off')
                                        .toggleClass('text-primary')
                                        .toggleClass('text-danger').next().click();
                                    }
                                    <?php if(!empty($_GET["ref"]) && $data["New"] == 0){ ?>
                                    $("#toggle-new").click();
                                    <?php } ?>
                                </script>
                            </div>

                            <div class="product-recommend-container">
                                <br />
                                <!-- <span><b>สินค้าแนะนำ</b></span> -->
                                <span><b>Highlight</b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                <div>
                                    <i id="toggle-recommend" class="fa fa-toggle-on fa-3x text-primary hand" style="" onclick="toggleRecommend(this);"></i>
                                    <input type="checkbox" name="choRecommend" class="hide" checked="checked" value="" />
                                </div>
                                <script>
                                    function toggleRecommend(obj) {
                                        $(obj).toggleClass('fa-toggle-on').toggleClass('fa-toggle-off')
                                        .toggleClass('text-primary')
                                        .toggleClass('text-danger').next().click();
                                    }
                                    <?php if(!empty($_GET["ref"]) && $data["Recommend"] == 0 || empty($_GET["ref"])){ ?>
                                    $("#toggle-recommend").click();
                                    <?php } ?>
                                </script>
                            </div>

                            <div class="product-bestseller-container">
                                <br />
                                <!-- <span><b>สินค้ายอดนิยม</b></span> -->
                                <span><b>best seller</b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />

                                <div>
                                    <i id="toggle-hot" class="fa fa-toggle-on fa-3x text-primary hand" style="" onclick="toggleHot(this);"></i>
                                    <input type="checkbox" name="choHot" class="hide" checked="checked" value="" />
                                </div>
                                <script>
                                    function toggleHot(obj) {
                                        $(obj).toggleClass('fa-toggle-on').toggleClass('fa-toggle-off')
                                        .toggleClass('text-primary')
                                        .toggleClass('text-danger').next().click();
                                    }
                                    <?php if(!empty($_GET["ref"]) && $data["Hot"] == 0){ ?>
                                    $("#toggle-hot").click();
                                    <?php } ?>
                                </script>
                            </div>

                            <div class="product-ranking-container">
                                <br />
                                <span><b>Most Popular Ranking</b></span>
                                <hr style="margin-top: 5px; margin-bottom: 5px;" />

                                <style>
                                    .star-panel .gold,
                                    .star-panel:hover .fa-star{
                                        color:gold;
                                    }
                                    .star-panel .grey,
                                    .star-panel .fa-star:hover ~ .fa-star{
                                        color:#aaa;
                                    }

                                </style>

                                <?php $rank = empty($data["Rank"]) ? 3 : intval($data["Rank"]); ?>

                                <div class="star-panel">
                                    <i class="fa fa-2x fa-star hand <?php echo $rank >= 1 ? "gold" : "grey" ?>" data-rank="1"></i>
                                    <i class="fa fa-2x fa-star hand <?php echo $rank >= 2 ? "gold" : "grey" ?>" data-rank="2"></i>
                                    <i class="fa fa-2x fa-star hand <?php echo $rank >= 3 ? "gold" : "grey" ?>" data-rank="3"></i>
                                    <i class="fa fa-2x fa-star hand <?php echo $rank >= 4 ? "gold" : "grey" ?>" data-rank="4"></i>
                                    <i class="fa fa-2x fa-star hand <?php echo $rank >= 5 ? "gold" : "grey" ?>" data-rank="5"></i>
                                </div>
                                <script>
                                    $(".star-panel .fa-star").click(function () {
                                        $("#txtRank").val($(this).attr("data-rank"));
                                        $(this).removeClass("grey").removeClass("gold").addClass("gold");
                                        $(this).prevAll().removeClass("grey").removeClass("gold").addClass("gold");
                                        $(this).nextAll().removeClass("grey").removeClass("gold").addClass("grey");
                                    });
                                </script>

                                <input type="hidden" id="txtRank" name="txtRank" value="<?php echo $rank ?>" />

                            </div>

                            <div class="product-file-container">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <br />
                                        <span><b>ไฟล์ให้ดาวน์โหลด 1</b></span>
                                        <hr style="margin-top: 5px; margin-bottom: 5px;" />

                                        <input type="file" name="txtFileUpload" value="" accept="application/msword, application/vnd.ms-excel, application/pdf, image/*" onchange="validateUploadFileUpload(this);" />
                                        
                                        <?php if(!empty($data["FileDownload"])){ ?>
                                        <div style="margin-top:5px;">
                                            <b class="text-success">เคยอัพโหลดไฟล์แล้ว 
                                                <a target="_blank" href="<?php echo $data["FileDownload"]; ?>">
                                                    <i class="fa fa-download"></i>
                                                    ดาวน์โหลด</a>
                                            </b>
                                        </div>
                                        <?php } ?>
                                        <input type="hidden" name="hddBackUpFileDownload" value="<?php echo $data["FileDownload"] ?>" />
                                        <input type="hidden" name="hddBackUpFileDownloadName" value="<?php echo $data["FileDownloadName"] ?>" />
                                    </div>
                                </div>      
                            </div>

                            <div class="product-file-container hide">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <br />
                                        <span><b>ไฟล์ให้ดาวน์โหลด 2</b></span>
                                        <hr style="margin-top: 5px; margin-bottom: 5px;" />

                                        <input type="file" name="txtFileUpload2" value="" accept="application/msword, application/vnd.ms-excel, application/pdf, image/*" onchange="validateUploadFileUpload(this);" />
                                        
                                        <?php if(!empty($data["FileDownload2"])){ ?>
                                        <div style="margin-top:5px;">
                                            <b class="text-success">เคยอัพโหลดไฟล์แล้ว 
                                                <a target="_blank" href="<?php echo $data["FileDownload2"]; ?>">
                                                    <i class="fa fa-download"></i>
                                                    ดาวน์โหลด</a>
                                            </b>
                                        </div>
                                        <?php } ?>
                                        <input type="hidden" name="hddBackUpFileDownload2" value="<?php echo $data["FileDownload2"] ?>" />
                                        <input type="hidden" name="hddBackUpFileDownloadName2" value="<?php echo $data["FileDownloadName2"] ?>" />
                                    </div>
                                </div>      
                            </div>

                            <div class="product-file-container hide">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <br />
                                        <span><b>ไฟล์ให้ดาวน์โหลด 3</b></span>
                                        <hr style="margin-top: 5px; margin-bottom: 5px;" />

                                        <input type="file" name="txtFileUpload3" value="" accept=".pdf" onchange="validateUploadFileUpload(this);" />
                                        
                                        <?php if(!empty($data["FileDownload3"])){ ?>
                                        <div style="margin-top:5px;">
                                            <b class="text-success">เคยอัพโหลดไฟล์แล้ว 
                                                <a target="_blank" href="<?php echo $data["FileDownload3"]; ?>">
                                                    <i class="fa fa-download"></i>
                                                    ดาวน์โหลด</a>
                                            </b>
                                        </div>
                                        <?php } ?>
                                        <input type="hidden" name="hddBackUpFileDownload3" value="<?php echo $data["FileDownload3"] ?>" />
                                        <input type="hidden" name="hddBackUpFileDownloadName3" value="<?php echo $data["FileDownloadName3"] ?>" />
                                    </div>
                                </div>      
                            </div>

                            <script>
                                function validateUploadFileUpload(obj)
                                {
                                    var file = $(obj).get(0).files[0];
                                    var maxSize = 60000000;
                                    if (file.size > maxSize) {
                                        $(obj).val("");
                                        swal("Invalid file size", "Maximum image size is 60 MB.", "error");
                                    }
                                }
                            </script>
                                
                            <?php 
                                if(false){
                                    include($GLOBALS['DOCUMENT_ROOT']."/ControlPanel/GoogleMap/location.php") 
                                ?>
                                <div class="product-location-container">
                                    <div style="margin-top: 5px;" class="">
                                        <br />
                                        <span><b>ตำแหน่งบนแผนที่ (Latitude - Logitude)</b></span>
                                        <hr style="margin-top: 5px; margin-bottom: 5px;" />
                                        <input readonly type="text" class="lat-lng form-control require input-sm" style="display:inline-block;float:left;margin-right:5px;width:200px;" value="<?php echo $data["MapLocation"] ?>" />
                                        <button type="button" class="btn btn-primary btn-sm" onclick="openSuperGridGoogleMapMap(this);">
                                            <i class="fa fa-map-marker text-danger"></i>
                                            ค้นหาตำแหน่งบนแผนที่
                                        </button>
                                        <input type="text" class="lat-lng hide" name="txtLatLng" value="<?php echo $data["MapLocation"] ?>" />
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <hr />

                <div>

                    <button type="submit" name="btnSubmit" class="btn btn-success" onclick="return validateSave(this);">
                        <i class="fa fa-save"></i>
                        บันทึก
                    </button>

                    <script>
                        function validateSave(sender) {
                            var msg = [];
                            var elt = $('#form-product').find(".require:visible");
                            $(elt).each(function () {
                                if ($(this).val().trim() == "") {
                                    var html = $(this).parent().find("label").html();
                                    msg.push(html);
                                }
                            });
                            // if ($(".product-color-container").is(":visible") && $(".chk-tag:checked").length == 0) {
                            //     msg.push("เลือกสีอย่างน้อย 1 รายการ");
                            // }
                            // if ($(".product-size-container").is(":visible") && $(".chk-size:checked").length == 0) {
                            //     msg.push("เลือกไซส์ที่มี อย่างน้อย 1 รายการ");
                            // }

                            // if ($(".product-material-container").is(":visible") && $(".chk-material:checked").length == 0) {
                            //     msg.push("เลือก Material อย่างน้อย 1 รายการ");
                            // }

                            // if ($(".product-tag-container").is(":visible") && $(".chk-tag-keyword:checked").length == 0) {
                            //     msg.push("เลือกแท็กอย่างน้อย 1 รายการ");
                            // }
                            if (msg.length > 0) {
                                swal('Please fill in all required fields.', msg.join("\n").split(":").join(""), 'warning');
                                return false;
                            }

                            return Confirm(sender, "Comfirm to continue");
                        }
                    </script>

                    <a href="product.php" class="btn btn-danger">
                        <i class="fa fa-remove"></i>
                        ยกเลิก
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>

    function deleteImage(obj){
        if(AlertConfirm(obj,"Confirm ?")){
            var target = $(obj).closest('.slide-banner');
            $(target).find("input[type='file']").val("");
            $(target).find("input[type='hidden']").val("");
            var _size = $(target).find("img").data("size");
            if(_size == "" || _size == undefined){
                _size = "1200x900";
            }
            $(target).find("img").attr("src","https://ipsumimage.appspot.com/"+_size+",eee");
            $(target).find(".remover").addClass("hide");
        }
    }

</script>

<?php include  "../footer.php"; ?>