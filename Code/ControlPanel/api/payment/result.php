<?php include_once "../../../_cogs.php"; ?>
<?php include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/UtilService.php"; ?>
<?php  
	////full response
  	// $response = file_get_contents('php://input');
	// echo "Response:<br/><textarea style='width:100%;height:80px'>".$response."</textarea>"; 

	$sql = "select CheckOutCode from checkout where CheckOutCode='".$_REQUEST["order_id"]."' ";
    $data = SelectRow($sql);
    if($data === false)
    {
        Redirect($GLOBALS["ROOT"]."/".$_Util_PageConfig->GetConfig("HOME")->PageURLName());
        exit();
	}

	//each response params:
	$version = $_REQUEST["version"];
	$request_timestamp = $_REQUEST["request_timestamp"];
	$merchant_id = $_REQUEST["merchant_id"];
	$currency = $_REQUEST["currency"];
	$order_id = $_REQUEST["order_id"];
	$amount = $_REQUEST["amount"];
	$invoice_no = $_REQUEST["invoice_no"];
	$transaction_ref = $_REQUEST["transaction_ref"];
	$approval_code = $_REQUEST["approval_code"];
	$eci = $_REQUEST["eci"];
	$transaction_datetime = $_REQUEST["transaction_datetime"];
	$payment_channel = $_REQUEST["payment_channel"];
	$payment_status = $_REQUEST["payment_status"];
	$channel_response_code = $_REQUEST["channel_response_code"];
	$channel_response_desc = $_REQUEST["channel_response_desc"];
	$masked_pan = $_REQUEST["masked_pan"];
	$stored_card_unique_id = $_REQUEST["stored_card_unique_id"];
	$backend_invoice = $_REQUEST["backend_invoice"];
	$paid_channel = $_REQUEST["paid_channel"];
	$recurring_unique_id = $_REQUEST["recurring_unique_id"];
	$paid_agent = $_REQUEST["paid_agent"];
	$payment_scheme = $_REQUEST["payment_scheme"];
	$user_defined_1 = $_REQUEST["user_defined_1"];
	$user_defined_2 = $_REQUEST["user_defined_2"];
	$user_defined_3 = $_REQUEST["user_defined_3"];
	$user_defined_4 = $_REQUEST["user_defined_4"];
	$user_defined_5 = $_REQUEST["user_defined_5"];
	$browser_info = $_REQUEST["browser_info"];
	$ippPeriod = $_REQUEST["ippPeriod"];
	$ippInterestType = $_REQUEST["ippInterestType"];
	$ippInterestRate = $_REQUEST["ippInterestRate"];
	$ippMerchantAbsorbRate = $_REQUEST["ippMerchantAbsorbRate"];
	$payment_scheme = $_REQUEST["payment_scheme"];
	$process_by = $_REQUEST["process_by"];
	$sub_merchant_list = $_REQUEST["sub_merchant_list"];
	$hash_value = $_REQUEST["hash_value"]; 
	  
	//check response hash value (for security, hash value validation is Mandatory)
	$checkHashStr = $version . $request_timestamp . $merchant_id . $order_id . 
	$invoice_no . $currency . $amount . $transaction_ref . $approval_code . 
	$eci . $transaction_datetime . $payment_channel . $payment_status . 
	$channel_response_code . $channel_response_desc . $masked_pan . 
	$stored_card_unique_id . $backend_invoice . $paid_channel . $paid_agent . 
	$recurring_unique_id . $user_defined_1 . $user_defined_2 . $user_defined_3 . 
	$user_defined_4 . $user_defined_5 . $browser_info . $ippPeriod . 
	$ippInterestType . $ippInterestRate . $ippMerchantAbsorbRate . $payment_scheme .
	$process_by . $sub_merchant_list;
	  
	$SECRETKEY = $_Util_WebsitDetail["secret_key"];//"QnmrnH6QE23N";
    $checkHash = hash_hmac('sha256',$checkHashStr, $SECRETKEY,false); 
	//echo "checkHash: ".$checkHash."<br/><br/>";

	
	try {
		ExecuteSQL("insert into checkout_log(CheckOutCode,Status,StatusDesc,ResultData,CreatedOn) 
			VALUES ('$order_id','$payment_status','$channel_response_desc','".json_encode($_REQUEST,JSON_UNESCAPED_UNICODE)."',now())");
	} catch (Exception $ex) {
		try {
			SendMailControlPanel("anuponchaisiri@gmail.com",json_encode($_REQUEST,JSON_UNESCAPED_UNICODE),"[".(!empty($invoice_no) ? $invoice_no : $backend_invoice)."]LOG PAYMENT(".$ex->getMessage().") "." จาก ".$_Util_WebsitDetail["WebName"],"anuponchaisiri@gmail.com","",$_Util_WebsitDetail);
		} catch (Exception $exx) {
		}
	}
if(strcmp(strtolower($hash_value), strtolower($checkHash))==0){
	//echo "Hash check = success. it is safe to use this response data.";
	$sql = " select CheckOutCode,StatusCode from checkout where CheckOutCode='$order_id' ";
    $data = SelectRow($sql);
    if($data === false)
    {
        Redirect($GLOBALS["ROOT"]."/".$_Util_PageConfig->GetConfig("HOME")->PageURLName());
        exit();
	}
	$StatusCode = $data["StatusCode"];
	$_send_email = false;
	//Check and Update
	// 000 => Payment Successful
	// 001 => Payment Pending
	// 002 => Payment Rejected
	// 003 => Payment was canceled by user
	// 999 => Payment Failed
	if($StatusCode != "PAID" && $StatusCode != "SUCCESS" && $StatusCode != "COMPLETE"){
		if($payment_status == "000")//Payment Successful
		{
			$StatusCode = "PAID";
			$_send_email = true;
		}else if($payment_status == "002" || $payment_status == "003"){
			$StatusCode = "CANCEL";
			$_send_email = true;
		}
	}
	

	$sqlUpdate = "
		update checkout set 
			 StatusCode='$StatusCode'
			,UpdatedOn=now()
			,Pay123_payment_status='$payment_status'
			,Pay123_request_timestamp='$request_timestamp'
			,Pay123_merchant_id='$merchant_id'
			,Pay123_transaction_datetime='$transaction_datetime'
			,Pay123_paid_channel='$paid_channel'
			,Pay123_paid_agent='$paid_agent'
		where CheckOutCode='".$data["CheckOutCode"]."'
	";
	ExecuteSQL($sqlUpdate);
	if($_send_email){
		SendEmailPO($data["CheckOutCode"],"อีเมล์แจ้งสถานะใบสั่งซื้อเลขที่: ".$data["CheckOutCode"]);
	}
	$refCode = base64_encode($data["CheckOutCode"]);
	echo "<script>location.href = '".$GLOBALS["ROOT"]."/Success.php?ref=$refCode'</script>";
}
else{
	//echo "Hash check = failed. do not use this response data.";
	if(!empty($order_id)){
		$refCode = base64_encode($invoice_no);
		echo "<script>location.href = '".$GLOBALS["ROOT"]."/Success.php?ref=$refCode'</script>";
	}else{
		echo "failed. do not use this response data.";
	}
	
}
  	
?>

 

