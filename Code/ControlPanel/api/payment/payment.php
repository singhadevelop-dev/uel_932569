<?php include_once "../../../_cogs.php"; ?>
<?php include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/UtilService.php"; ?>
<?php $_SOURCE_VERSION = "?vs=1.1"; ?>
<?php 
	
    if(empty($_GET["ref"])){
        Redirect("../../../");
        exit();
	}
	if(empty($_Util_WebsitDetail["merchant_id"]) || empty($_Util_WebsitDetail["secret_key"])
		|| empty($_Util_WebsitDetail["currency"]) || empty($_Util_WebsitDetail["payment_url"]) 
		|| empty($_Util_WebsitDetail["version"]))
	{
            //Redirect("../../../");
            echo "<script>location.href = '../../../Success.php?ref=".$_GET["ref"]."'</script>";
			exit();
	}

    $refCode = base64_decode($_GET["ref"]);
    $sql = "select CheckOutCode,Total,Tax,DeliveryPrice,Net,ClientID,Email,Name from checkout where CheckOutCode='$refCode' and StatusCode='WAITING'  ";
    $data = SelectRow($sql);
    if($data === false)
    {
        Redirect("../../../");
        exit();
    }
    
	if($_Util_WebsitDetail["active123"] == 0){
		echo "<script>location.href = '../../../Success.php?ref=".$_GET["ref"]."'</script>";
    }
    
    $sqlProduct = "select p.*
                    ,c.CategoryName
                    ,s.SubCategoryName
                    ,cart.QTY,cart.Price as CartPrice,cart.Total,cart.SEQ													  
                        from cart
                    join product p
                    on p.ProductCode = cart.ProductCode
                    join product_category c														
                    on c.CategoryCode = p.CategoryCode
                    join product_sub_category s
                    on s.SubCategoryCode = p.SubCategoryCode
                    where cart.CheckOutCode='".$data["CheckOutCode"]."' 
                        order by p.seq,p.ProductCode,cart.SEQ";
    $dataPrd = SelectRowsArray($sqlProduct);
    $productArr = array();
    foreach ($dataPrd as $product) {
       array_push($productArr,$product["ProductRefCode"]);
    }
    $productRefCode = join(",",$productArr);
    
	//Merchant's account information
	$merchant_id = $_Util_WebsitDetail["merchant_id"];//"JT04";			//Get MerchantID when opening account with 2C2P
	$secret_key = $_Util_WebsitDetail["secret_key"];//"QnmrnH6QE23N";	//Get SecretKey from 2C2P PGW Dashboard
	
	//Transaction information
	$payment_description  = $productRefCode." - ".$data["Name"];
	$order_id  = $data["CheckOutCode"];
	$currency = $_Util_WebsitDetail["currency"];//"764" => THB;
	$amount  = str_pad(str_replace(".","",str_replace(",","",number_format($data["Net"],2))), 12, "0", STR_PAD_LEFT); //'000000045000';
		
	//Request information
	$version = $_Util_WebsitDetail["version"];//"8.5";	
	$payment_url = $_Util_WebsitDetail["payment_url"];//"https://demo2.2c2p.com/2C2PFrontEnd/RedirectV3/payment";
    //Frontend return url for 2C2P PGW to redirect
    $result_url_1 = "https://".$_SERVER['HTTP_HOST'].$GLOBALS["ROOT"]."/ControlPanel/api/payment/result.php";
    //Backend return url for 2C2P PGW to notify payment result 
    $result_url_2 = $result_url_1;

    $default_lang = "th";

	//Construct signature string
	$params = $version.$merchant_id.$payment_description.$order_id.$currency.$amount.$result_url_1.$result_url_2.$default_lang;
	$hash_value = hash_hmac('sha256',$params, $secret_key,false);	//Compute hash value
?>

<html> 
    <head>
        <script>
            var _root_path_includelibrary = "<?php echo $GLOBALS["ROOT"] ?>";
        </script>
        <script src="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/assets/js/jquery.min.js<?php echo $_SOURCE_VERSION ?>" type="text/javascript"></script>
        <link href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/assets/b4w-library/datetimepicker/bootstrap-datetimepicker.css<?php echo $_SOURCE_VERSION ?>" rel="stylesheet" />
        <script src="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/assets/b4w-library/datetimepicker/bootstrap-datetimepicker.js<?php echo $_SOURCE_VERSION ?>"></script>
        <link href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/assets/b4w-library/sweet-alert/sweetalert.css<?php echo $_SOURCE_VERSION ?>" rel="stylesheet" type="text/css">
        <script src="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/assets/b4w-library/sweet-alert/sweetalert.min.js<?php echo $_SOURCE_VERSION ?>"></script>
        <script src="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/assets/b4w-library/script-center/PostAPI.js?vs=1.20"></script>
    </head>
	<body>
	<img alt="" src="<?php echo ResizeImage($GLOBALS["ROOT"]."/images/logo/logo.png", 500) ?>" style="position: fixed;margin: 5% auto;left: 0;right: 0;object-fit: cover;">
	<form id="myform" method="post" action="<?php echo $payment_url ?>" style="display: none;">
		
        <input type="hidden" name="version" value="<?php echo $version ?>"/>
		<input type="text" name="merchant_id" value="<?php echo $merchant_id ?>"/>
		<input type="hidden" name="currency" value="<?php echo $currency ?>"/>
		<input type="hidden" name="result_url_1" value="<?php echo $result_url_1 ?>"/>
        <input type="hidden" name="result_url_2" value="<?php echo $result_url_2 ?>"/>
        <input type="hidden" name="hash_value" value="<?php echo $hash_value ?>"/>
        <input type="hidden" name="default_lang" value="<?php echo $default_lang ?>"/>
    	PRODUCT INFO : <input type="text" name="payment_description" value="<?php echo $payment_description ?>"  readonly/><br/>
		ORDER NO : <input type="text" name="order_id" value="<?php echo $order_id ?>"  readonly/><br/>
		AMOUNT: <input type="text" name="amount" value="<?php echo $amount ?>" readonly/><br/>
		<input type="submit" name="submit" value="Confirm" />

	</form>  
	
    <script type="text/javascript">
        $(document).ready(function(){
            AlertLoading(true,"123 payment process");
            $("[name='submit']").click();
        });
	</script>
	</body>
	</html>

