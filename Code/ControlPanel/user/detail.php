<?php $_COG_ITEM_CODE = 'MEMBER'; ?>
<?php include  "../header.php"; ?>

<?php

    if(empty($_GET["ref"])){
        Redirect("../");
    }

?>

<style>
    section {
        float: left;
        width: 100%;
        position: relative;
        padding: 80px 0;
        background: #fff;
        z-index: 1;
    }

    section.middle-padding {
        padding: 50px 0;
    }

    .dasboard-wrap {
        padding-left: 0;
    }

    .flat-hero-container .box-widget-item-header {
        margin-bottom: 10px;
        padding-bottom: 30px;
    }

    .flat-hero-container .box-widget-item-header h3 {
        font-size: 18px;
    }

    .box-widget-item-header {
        padding: 0 0 20px;
        margin: 0 0 25px;
        float: left;
        width: 100%;
        border-bottom: 1px solid #eee;
        position: relative;
    }

    .box-widget-item-header:before {
        font-family: Font Awesome\ 5 Pro;
        content: "\f0d7";
        position: absolute;
        right: 0;
        top: 2px;
        color: #ADC7DD;
    }

    .box-widget-item-header h3 {
        text-align: left;
        font-size: 16px;
        font-weight: 600;
        color: #183c7d;
    }

    .box-widget-item-header h3 i {
        padding-right: 12px;
        font-size: 16px;
        color: #999;
    }

    .box-widget {
        background: #fff;
        border-radius: 4px;
        border: 1px solid #eee;
        float: left;
        width: 100%;
    }

    .no-bor-rad {
        border-radius: 0;
    }

    .profile-edit-container {
        margin: 10px 0;
        float: left;
        width: 100%;
    }

    .profile-edit-container .custom-form label {
        float: left;
        text-align: left;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .profile-edit-container .custom-form label i {
        top: 42px;
    }

    .custom-form.no-icons input,
    .custom-form.no-icons textarea {
        padding-left: 10px;
    }

    .pass-input-wrap span {
        position: absolute;
        right: 20px;
        cursor: pointer;
        bottom: 36px;
        z-index: 10;
    }

    .profile-edit-container.add-list-container {
        margin-top: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #eee;
        float: left;
        width: 100%;
    }

    .profile-edit-container.add-list-container:first-child {
        margin-top: 0;
    }

    .custom-form .log-submit-btn {
        float: left;
        padding: 13px 35px;
        border: none;
        border-radius: 4px;
        color: #fff;
        cursor: pointer;
        -webkit-appearance: none;
        margin-top: 12px;
    }

    /*-------------Forms---------------------------------------*/
    .custom-form {
        float: left;
        width: 100%;
        position: relative;
    }

    .custom-form .nice-select {
        margin-bottom: 20px;
    }

    .custom-form textarea,
    .custom-form input[type="text"],
    .custom-form input[type=email],
    .custom-form input[type=password],
    .custom-form input[type=button] {
        float: left;
        border: 1px solid #eee;
        background: #F7F9FB;
        width: 100%;
        padding: 14px 20px 14px 45px;
        border-radius: 6px;
        color: #666;
        font-size: 13px;
        -webkit-appearance: none;
    }

    .custom-form textarea:focus,
    .custom-form input[type="text"]:focus,
    .custom-form input[type=email]:focus,
    .custom-form input[type=password]:focus {
        background: #fff;
    }

    .custom-form .nice-select input {
        padding-left: 20px;
    }

    .custom-form input::-webkit-input-placeholder,
    .custom-form textarea::-webkit-input-placeholder {
        color: #666;
        font-weight: 500;
        font-size: 13px;
    }

    .custom-form input:-moz-placeholder,
    .custom-form textarea:-moz-placeholder {
        color: #888DA0;
        font-weight: 600;
        font-size: 13px
    }

    .custom-form textarea {
        min-height: 100px;
        resize: none;
        -webkit-appearance: none;
    }

    .custom-form input {
        margin-bottom: 7px;
    }

    .filter-tags input,
    .custom-form .filter-tags input {
        float: left;
        position: relative;
        border: 2px solid #ccc;
        cursor: pointer;
        padding: 0;
        width: 20px;
        height: 20px;
        position: relative;
        color: #fff;
        background: #fff !important;
        -webkit-appearance: none;
    }

    .filter-tags input:checked:after,
    .custom-form .filter-tags input:checked:after {
        font-family: Font Awesome\ 5 Pro;
        content: "\f00c";
        font-size: 12px;
        position: absolute;
        top: 2px;
        left: 2px;
        z-index: 20;
    }

    .filter-tags label,
    .custom-form .filter-tags label {
        float: left;
        padding: 0 10px;
        position: relative;
        top: 4px;
        color: #888DA0;
        font-weight: 600;
        width: auto;
    }

    .custom-form label {
        float: left;
        position: relative;
        width: 100%;
        text-align: left;
        font-weight: 500;
        color: #666;
        color: #878C9F;
        font-size: 13px;
        font-weight: 500;

    }

    .main-register .custom-form label {
        padding-bottom: 12px;
    }

    .custom-form label i {
        padding-right: 12px;
        font-size: 14px;
        position: absolute;
        top: 16px;
        left: 16px;
    }

    .custom-form button {
        outline: none;
        border: none;
        cursor: pointer;
        -webkit-appearance: none;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    input[type=text][disabled='disabled'],
    input[type=text][disabled=''],
    area[disabled='disabled'],
    area[disabled=''] {
        background: #d6d4d4;
    }

    .required,
    [required=''] {
        border-left: 2px solid #E65041 !important;
    }


    /* Hide default HTML checkbox */

    .switch {
        position: relative;
        display: inline-block;
        width: 60px !important;
        height: 34px;
        float: right;
    }


    .switch input {
        display: none;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input.default:checked+.slider {
        background-color: #444;
    }

    input.primary:checked+.slider {
        background-color: #2196F3;
    }

    input.success:checked+.slider {
        background-color: #04AC9C !important;
    }

    input.info:checked+.slider {
        background-color: #3de0f5;
    }

    input.warning:checked+.slider {
        background-color: #FFC107;
    }

    input.danger:checked+.slider {
        background-color: #f44336;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .image-profile{
        border-radius: 10rem;
    }
</style>

<?php
$clientCode = $_GET["ref"];
$data = SelectRow("select * from client where ClientCode='" . $clientCode . "' ");
?>

<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-12">
            <h3 style="margin: 0;">
                <i class="fa fa-users  fa-fw"></i>
                <span class="analysis-left-menu-desc">ข้อมูลสมาชิก <?php echo $data["Name"]." ".$data["LastName"]; ?></span>

            </h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

<div class="mat-box grey-bar">

    <a href="index.php" class="link-history-btn">ข้อมูลรายละเอียดสมาชิก</a>
    /
    <span class="link-history-btn">ข้อมูลสมาชิก</span>

</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row">
        <div class="col-md-12">
            <form id="form-product" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class=" fl-wrap">
                            <div class="profile-edit-container">
                                <div class="custom-form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <img src="<?php echo !empty($data["Image"]) ? $data["Image"] : "../assets/images/user.png" ?>" width="200" height="200" class="image-profile">
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>ชื่อ - สกุล <i class="fa fa-user"></i></label>
                                                            <input type="text" name="FirstName" placeholder="First Name..." value="<?php echo $data["Name"]." ".$data["LastName"]; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-3 hide">
                                                            <label>เพศ<i class="fa fa-transgender"></i> </label>
                                                            <input type="text" value="<?php echo $data["Gender"] == "MALE" ? "ชาย" : ($data["Gender"] == "FEMALE" ? "หญิง" : "อื่นๆ") ?>" readonly>
                                                        </div>
                                                        <div class="col-md-3 hide">
                                                            <label>วันเกิด<i class="fa fa-birthday-cake"></i> </label>
                                                            <input type="text" value="<?php echo ConvertDateDBToDateDisplay($data["Birthday"]) ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>อีเมล<i class="fa fa-envelope"></i> </label>
                                                            <input type="email" name="EmailAddress" placeholder="Email..." value="<?php echo $data["Email"]; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>เบอร์ติดต่อ<i class="fa fa-phone"></i> </label>
                                                            <input type="text" readonly name="Phone" placeholder="Phone..." value="<?php echo $data["Phone"]; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label> ที่อยู่ <i class="fa fa-map-marker"></i> </label>
                                                            <?php 
                                                            $cus_address = (!empty($data["delivery_other"]) ? $data["delivery_other"] . ", " : "")
                                                                .(!empty($data["delivery_district"]) ? "ตำบล/แขวง " . $data["delivery_district"] . " " : "")
                                                                .(!empty($data["delivery_district"]) ? "อำเภอ/เขต " . $data["delivery_prefecture"] . " " : "")
                                                                .(!empty($data["delivery_province"]) ? "จังหวัด " . $data["delivery_province"] . " " : "")
                                                                .$data["delivery_postalnumber"]; 
                                                            ?>
                                                            <input type="text" name="Address" placeholder="Adress..." value="<?php echo $cus_address; ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span><h4>รายการสั่งซื้อทั้งหมด</h4></span>
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
                                                                <th class="text-right">มูลค่า</th>
                                                                <th class="text-center">สถานะ</th>
                                                                <th style="width:100px;" class="text-center">จัดการ</th>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <th style="width:100px;">เลขที่เอกสาร</th>
                                                                <th style="width:120px;">วัน / เวลา</th>
                                                                <th class="text-right">มูลค่า</th>
                                                                <th class="text-center">สถานะ</th>
                                                                <th style="width:100px;" class="text-center">จัดการ</th>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <?php
                                                        
                                                            $sql = "select * from checkout  where ClientID='$clientCode' order by CreatedOn desc";
                                                            $datas = SelectRows($sql);
                                                            foreach ($datas as $data) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $data["CheckOutCode"] ?></td>
                                                                <td><span class="hide"><?php echo $data["CreatedOn"]; ?></span> <?php echo ConvertDateTimeDBToDateTimeDisplay($data["CreatedOn"]) ?></td>
                                                                <td class="text-right"><?php echo number_format($data["Net"],2) ?></td>
                                                                <th class="text-center"><?php echo GetPOStatusDesc($data["StatusCode"]) ?></th>
                                                                <td class="text-center">
                                                                    <a title="รายละเอียด" href="../transaction/transactionDetail.php?mode=user&ref=<?php echo $data["CheckOutCode"] ?>">
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
                                        <div class="col-md-3 hide">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="switch">
                                                        <input name="chkActive" type="checkbox" <?php echo $data["Active"] == 1 ? " checked='checked' " : "" ?> class="success">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div class="col-md-8" >
                                                    <b>ให้ใช้งานร้านค้า / ยกเลิกชั่วคราว</b>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                </from>


        </div>
    </div>
</div>

<?php include  "../footer.php"; ?>