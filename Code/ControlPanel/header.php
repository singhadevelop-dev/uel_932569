<?php 

$_ALLOW_SESSION = true;
include_once realpath(__DIR__ . '/..')."/_cogs.php";
include  $GLOBALS["DOCUMENT_ROOT"]."/ControlPanel/assets/b4w-framework/UtilService.php";
if(!UserService::_IsLoggedIn() || !UserService::_IsAdmin()){
    Redirect($GLOBALS["ROOT"]."/ControlPanel/login.php");
    exit();
}

$__COGS_GLOBAL_CART = true;
$__COGS_GLOBAL_MEMBER = true;

?>
<!-- === BEGIN HEADER === -->
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <!-- Title -->
    <title>Website & Application Control Panel V2</title>
    <?php include  $GLOBALS["DOCUMENT_ROOT"]."/ControlPanel/assets/b4w-framework/IncludeLibrary.php"; ?>
</head>
<body class="qrcdr">
<input type="hidden" id="qrcdr-relative" value="">
    <style>
        /* #imge-preview {
            width: 100%;
        } */
        .at-loading {
            position: fixed;
            top: 0px;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.46);
            z-index: 2000;
            text-align: center;
            display: none;
        }
        .at-loading .at-loading-content {
            padding: 10px;
            border-radius: 10px;
            background: #fff;
            margin: 20px auto;
            width: auto;
            display: inline-block;
            box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .at-loading .at-loading-content img {
            width: 20px;
            margin-right: 5px;
        }

        .badge-primary {
            color: #fff;
            background-color: #007bff;
        }
        /* .badge {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        } */

        .bg-shop{
            background: #036499!important;
        }
        .text-shop{
            color: #036499!important;
        }
        .mb-3, .my-3 {
            margin-bottom: 1rem!important;
        }
        .p-3 {
            padding: 1rem!important;
        }
        .pt-3, .py-3 {
            padding-top: 1rem!important;
        }
        .pl-3, .px-3 {
            padding-left: 1rem!important;
        }
        .pb-3, .py-3 {
            padding-bottom: 1rem!important;
        }
        .pr-3, .px-3 {
            padding-right: 1rem!important;
        }

        .pl-5, .px-5 {
            padding-left: 3rem!important;
        }
        .pt-1, .py-1 {
            padding-top: .25rem!important;
        }
        .mb-4, .my-4 {
            margin-bottom: 1.5rem!important;
        }

        .bg-white {
            background-color: #fff!important;
        }
        .table-check-list > thead > tr > td {
            border-top: none;
        }
        a.unlink{
            text-decoration: none;
        }
        .btn-order {
            border-radius: 0;
            min-width: 13rem;
        }
        .table-check-list{
            /* table-layout: fixed; */
        }
        .td-image{
            width: 120px;
            padding-left: 45px!important;
        }
        .td-p-name{
            width: auto;
        }
        .td-p-price{
            width: 150px;
        }
        [readonly]{
            background: #eee!important;
        }
        
    </style>

    <div class="at-loading">
        <div class="at-loading-content">
            <img src="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/assets/images/loading.gif" alt="Alternate Text" />
            กำลังโหลด
        </div>
    </div>
    <nav class="navbar navbar-default z-depth-1 navbar-fixed-top" style="margin-bottom: 10px;">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" style="display: inline-block; white-space: nowrap; margin-top: -13px; width: auto; margin-right: 10px;"
                    href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/">
                    <!-- <i class="fa fa-desktop pull-left" style="color: #F58512; margin-right: 15px; margin-top: 4px; font-size: 40px;"></i> -->
                    <img style="margin-right: 10px; margin-top: 4px; width: 40px;float:left" src="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/assets/images/cp.png"/>
                    <span class="nav-desc">
                        <small style="font-size: 12px;"><b><?php echo $_Util_WebsitDetail["WebName"] ?></b></small>
                        <br />
                        <span style="color: #F58512;">Control Panel</span>
                    </span>
                </a>
            </div>
            <style>
                .nav-icon {
                    margin-right: 10px;
                    padding: 6px;
                    width: 40px;
                    height: 40px;
                    text-align: center;
                    font-size: 24px;
                    margin-top: -9px;
                    background: #eee;
                    border-radius: 50%;
                    position: relative;
                }
                    .nav-icon .badge {
                        position: absolute;
                        right: -10px;
                        top: -3px;
                        background: #E65041;
                    }
                @media(min-width:768px) {
                    .nav-icon {
                        float: left;
                    }
                }
            </style>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right analysis-top-menu">
                    <!--<li data-link="ControlPanel"><a href="/ControlPanel/">
                        <i class="fa fa-desktop"></i>
                        Control Panel</a></li>-->
                    <script>
                        function _changeLang(lang) {
                            var src = "<?php echo $GLOBALS["ROOT"] ?>/_change_lang.php?lang=" + lang;
                            src += "&url=" + encodeURIComponent(location.href);
                            location.href = src;
                        }
                    </script>

                    <?php
                        $_lang = empty($_COOKIE["_WEB_LANG"]) ? "EN" : $_COOKIE["_WEB_LANG"];
                    ?>

                    <li class="" title="เปลี่ยนภาษา" style="width: auto;padding-top: 1rem;">
                        <a href="javascript:_changeLang('EN');" style="display: inline-block;padding: 5px;color: <?php echo $_lang == "EN" ? "red" : "#bdb4b4" ?>;"><b>EN</b></a> |
                        <a href="javascript:_changeLang('TH');" style="display: inline-block;padding: 5px;color: <?php echo $_lang == "TH" ? "red" : "#bdb4b4" ?>;"><b>TH</b></a> |
				        <a href="javascript:_changeLang('IN');" style="display: inline-block;padding: 5px;color: <?php echo $_lang == "IN" ? "red" : "#bdb4b4" ?>;"><b>IN</b></a> |
                        <a href="javascript:_changeLang('VN');" style="display: inline-block;padding: 5px;color: <?php echo $_lang == "VN" ? "red" : "#bdb4b4" ?>;"><b>VN</b></a> 
                     </li>

                    <li class="" title="เปิดหน้าเว็บไซต์">
                        <a href="<?php echo empty($GLOBALS["ROOT"]) ? "/" : $GLOBALS["ROOT"] ?>" target="_blank">
                            <i class="fa fa-desktop fa-2x nav-icon" style="font-size: 24px;padding-top:8px"></i>
                        </a>
                    </li>

                    <?php if($__COGS_GLOBAL_CART){ ?>
                    <li title="รายการแจ้งชำระเงิน" class="hide">
                        <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/transaction/payment.php">
                            <?php
                            // $sqlCountWaitingPO = "select CheckOutCode from member where MemberType = 'PAYMENT' and Picked = 0";
                            // $datasCountWaitingPO = SelectRows($sqlCountWaitingPO);
                            // $numCountWaitingPO = $datasCountWaitingPO->num_rows;
                            ?>
                            <i class="fa fa-dollar fa-2x nav-icon" style="font-size: 24px;"><b class="badge <?php echo $numCountWaitingPO == 0 ? "hide" : "" ?>"><?php echo $numCountWaitingPO; ?></b></i>
                        </a>
                    </li>
                    <li title="รายการสั่งซื้อ" class="hide">
                        <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/transaction/">
                            <?php
                            //   $sqlCountWaitingPO = "select count(CheckOutCode) as num_rows from checkout where StatusCode = 'WAITING'";
                            //   $numCountWaitingPO = intval(SelectRow($sqlCountWaitingPO)["num_rows"]);
                            ?>
                            <i class="fa fa-shopping-cart fa-2x nav-icon" style="font-size: 24px;"><b class="badge <?php echo $numCountWaitingPO == 0 ? "hide" : "" ?>"><?php echo $numCountWaitingPO; ?></b></i>
                        </a>
                    </li>
                    <?php } ?>
                    <li title="ผู้ติดต่อเข้ามายังเว็บไซต์" class="">
                        <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/contact/contact.php">
                            <?php
                                $sqlCountNotPick = "select count(MemberCode) as num_rows from member where MemberType = 'CONTACT' and Picked <> 1";
                                $numCountNotPick = intval(SelectRow($sqlCountNotPick)["num_rows"]);
                            ?>
                            <i class="fa fa-envelope fa-2x nav-icon" style="font-size: 24px;"><b class="badge <?php echo $numCountNotPick == 0 ? "hide" : "" ?>"><?php echo $numCountNotPick; ?></b></i>
                        </a>
                    </li>
                    <li title="ผู้ติดตามเว็บไซต์" class="hide">
                        <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/contact/subscribe.php">
                            <?php
                                $sqlCountNotPick = "select count(MemberCode) as num_rows from member where MemberType = 'SUBSCRIBE' and Picked <> 1";
                                $numCountNotPick = intval(SelectRow($sqlCountNotPick)["num_rows"]);
                            ?>
                            <i class="fa fa-eye fa-2x nav-icon" style="font-size: 24px;"><b class="badge <?php echo $numCountNotPick == 0 ? "hide" : "" ?>"><?php echo $numCountNotPick; ?></b></i>
                        </a>
                    </li>
                    <li title="ผู้ลงทะเบียน" class="hide">
                        <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/register/register.php">
                            <?php
                                // $sqlCountNotPick = "select count(MemberCode) as num_rows  from member where MemberType = 'REGISTER' and Picked <> 1 ";
                                // $numCountNotPick = intval(SelectRow($sqlCountNotPick)["num_rows"]);
                            ?>
                            <i class="fa fa-file fa-2x nav-icon" style="font-size: 24px;"><b class="badge <?php //echo $numCountNotPick == 0 ? "hide" : "" ?>"><?php //echo $numCountNotPick; ?></b></i>
                        </a>
                    </li>
                    <!-- <li title="SAMPLE FORM" class="hide">
                        <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/register/sampleform.php">
                            <?php
                                // $sqlCountNotPick = "select count(MemberCode) as num_rows  from member where MemberType = 'SAMPLE' and Picked <> 1 ";
                                // $numCountNotPick = intval(SelectRow($sqlCountNotPick)["num_rows"]);
                            ?>
                            <i class="fa fa-file-o fa-2x nav-icon" style="font-size: 24px;"><b class="badge <?php //echo $numCountNotPick == 0 ? "hide" : "" ?>"><?php //echo $numCountNotPick; ?></b></i>
                        </a>
                    </li> -->
                    <li title="ผู้สมัครงาน" class="hide">
                        <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/contact/career.php">
                            <?php
                                //  $sqlCountNotPick = "select count(CareerCode) as num_rows from career where Active=1 and Picked <> 1";
                                //  $numCountNotPick = intval(SelectRow($sqlCountNotPick)["num_rows"]);
                            ?>
                            <i class="fa fa-graduation-cap fa-2x nav-icon" style="font-size: 24px;"><b class="badge <?php //echo $numCountNotPick == 0 ? "hide" : "" ?>"><?php //echo $numCountNotPick; ?></b></i>
                        </a>
                    </li>
                    <!-- <li title="จองแพ็คเกจทัวร์" class="hide">
                        <a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/register/subscribe.php">
                            <?php
                            // $sqlCountNotPick = "select MemberCode from member where MemberType = 'BOOKING' and Picked <> 1";
                            // $datasCountNotPick = SelectRows($sqlCountNotPick);
                            // $numCountNotPick = $datasCountNotPick->num_rows;
                            ?>
                            <i class="fa fa-list fa-2x nav-icon" style="font-size: 24px;"><b class="badge <?php //echo $numCountNotPick == 0 ? "hide" : "" ?>"><?php //echo $numCountNotPick; ?></b></i>
                        </a>
                    </li> -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-2x nav-icon"></i>
                            <?php echo UserService::UserFullName() ?>
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/changePassword.php">Change password</a></li>
                            <li><a href="<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/logout.php">Sign out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script>
        function analysisTopMenu(link) {
            $(".analysis-top-menu li[data-link='" + link + "']").addClass("active");
        }
    </script>
    <div class="analysis-left-toggle" onclick="$('body').toggleClass('analysis-left-toggle-active');$(window).resize();">
        <i class="fa fa-chevron-left"></i>
    </div>
    <div class="analysis-main-container">
        <div class="mat-box analysis-left">
            <?php include "header_menu.php" ?>
        </div>
        <div class="analysis-right">
