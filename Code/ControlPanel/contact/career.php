<?php include  "../header.php"; ?>

<?php 


if(isset($_POST["btnPicked"])){
    $sqlUpdate = "update career set
    Picked = 1
    where CareerCode = '".$_POST["btnPicked"]."'";
    ExecuteSQL($sqlUpdate);
    
}

if(isset($_POST["btnDeleteRow"])){
    $sql = "delete from career where CareerCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
}

?>

<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-9">
            <h3 style="margin: 0;">

                <i class="fa fa-users fa-fw"></i>
                <span class="analysis-left-menu-desc">ผู้ลงทะเบียน</span>

            </h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

<div class="mat-box grey-bar">

    <a href="contact.php" class="link-history-btn">ผู้ลงทะเบียน</a>
    /
    <span class="link-history-btn">ข้อมูลผู้ติดต่อ</span>

</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row">
        <div class="col-md-2 hide">
            <?php 
                $_LEFT_MENU_ACTIVE = "CAREER";
                include "leftMenu.php"; 
                ?>
        </div>
        <div class="col-md-12">
            <style>
            .picked td {
                background-color: rgba(176, 243, 76, 0.4) !important;
            }

            .picked td:first-child {
                border-left: 3px solid rgba(176, 243, 76, 1);
            }

            .no-picked td {
                background-color: rgba(255, 0, 0, 0.2) !important;
            }

            .no-picked td:first-child {
                border-left: 3px solid rgba(255, 0, 0, 1);
            }
            </style>
            <div>
                <span><b>รายการผู้ลงทะเบียน</b></span>
                <hr style="margin-top: 5px;" />

                <script>
                _datatableOptions = {
                    "order": [
                        [0, "desc"]
                    ],
                    // dom: 'Bfrtip',
                    // buttons: [{ extend: 'excelHtml5', title: 'ผู้เข้ามาสมัคร' , exportOptions: { columns: [ 1, 2, 3, 4, 5, 6 ]} },
                    //     //'copyHtml5',
                    //     //'excelHtml5',
                    //     // 'csvHtml5',
                    //     // 'pdfHtml5'
                    // ]
                }
                </script>
                <table class="jquery-datatable display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="hide">time db</th>
                            <th>วัน / เวลา</th>
                            <th>ชื่อผู้ลงทะเบียน</th>
                            <th class="">จำนวนที่ต้องการแสกน</th>
                            <th style="width:100px;" class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="hide">time db</th>
                            <th>วัน / เวลา</th>
                            <th>ชื่อผู้ลงทะเบียน</th>
                            <th class="">จำนวนที่ต้องการแสกน</th>
                            <th class="text-center">รายละเอียด</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                    
                        $sql = "select a.*
                         from career a
                         where Active=1
                        order by CreatedOn desc";
                        $datas = SelectRowsArray($sql);
                        foreach ($datas as $data) {
                        ?>
                        <tr class="<?php echo $data["Picked"] == 1 ? "picked" : "no-picked" ?>">
                            <td class="hide"><?php echo $data["CreatedOn"]; ?></td>
                            <td><?php echo ConvertDateTimeDBToDateTimeDisplay($data["CreatedOn"]) ?></td>
                            <td><?php echo $data["Name"]." ".$data["LastName"] ?></td>
                            <td class=""><?php echo !empty($data["Amount"]) ? $data["Amount"] : "-" ?></td>
                            <td class="text-center">
                                <a title="รายละเอียด" href="#"
                                    onclick="$('#modal-<?php echo $data["CareerCode"] ?>').modal('show'); return false;">
                                    <i class="fa fa-search"></i>
                                </a>

                                <form method="post" style="display:inline">
                                    <button type="submit" class="btn-link"
                                        onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                        value="<?php echo $data["CareerCode"] ?>" name="btnDeleteRow">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                <div id="modal-<?php echo $data["CareerCode"] ?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog text-left">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">
                                                    <p class="" title="ชื่อผู้ติดต่อ">
                                                        <i class="fa fa-user fa-fw"></i>
                                                        <?php echo $data["Name"]." ".$data["LastName"] ?>
                                                    </p>
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <!-- <div class="row">
                                                    <div class="col-md-4">ตำแหน่งที่ต้องการสมัคร</div>
                                                    <div class="col-md-8"><b><?php //echo !empty($data["Position"]) ? $data["Position"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">เงินเดือนที่ต้องการ</div>
                                                    <div class="col-md-8"><b><?php //echo !empty($data["Salary"]) ? $data["Salary"] : "-" ?></b></div>
                                                </div> -->
                                                <div class="row">
                                                    <div class="col-md-4">ชื่อ-นามสกุล</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Name"]) ? $data["Name"]." ".$data["LastName"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">บัตรประจำตัวประชาชนเลขที่</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["IDCard"]) ? $data["IDCard"] : "-" ?></b></div>
                                                </div>
                                                <!-- <div class="row">
                                                    <div class="col-md-4">ส่วนสูง</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Height"]) ? $data["Height"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">น้ำหนัก</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Weight"]) ? $data["Weight"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">วัน/เดือน/ปีเกิด</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Birthday"]) ? $data["Birthday"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">อายุ</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Age"]) ? $data["Age"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">สีผิว</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["SkinColor"]) ? $data["SkinColor"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">เชื้อชาติ</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Race"]) ? $data["Race"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">สัญชาติ</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Nationality"]) ? $data["Nationality"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ศาสนา</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Religion"]) ? $data["Religion"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ที่อยู่ปัจจุบันบ้านเลขที่</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["HouseNumber"]) ? $data["HouseNumber"] : "-" ?></b></div>
                                                </div> -->
                                                <div class="row">
                                                    <div class="col-md-4">เบอร์โทร</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Phone"]) ? $data["Phone"] : "-" ?></b></div>
                                                </div>
                                                <!-- <div class="row">
                                                    <div class="col-md-4">อีเมล</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Email"]) ? $data["Email"] : "-" ?></b></div>
                                                </div> -->
                                                <div class="row">
                                                    <div class="col-md-4">ไอดีไลน์</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["LineID"]) ? $data["LineID"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">จังหวัด</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["HouseRegistration"]) ? $data["HouseRegistration"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">จำนวนที่ต้องการแสกน</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Amount"]) ? $data["Amount"] : "-" ?></b></div>
                                                </div>
                                                <!-- 
                                                <div class="row">
                                                    <div class="col-md-4">สถานภาพ</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["MaritalStatus"]) ? $data["MaritalStatus"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ชื่อ–นามสกุล (บิดา)</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Father"]) ? $data["Father"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">มีชีวิต/ถึงแก่กรรม</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["FatherStatus"]) ? $data["FatherStatus"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">อายุ</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["FatherAge"]) ? $data["FatherAge"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ที่อยู่</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["FatherAddress"]) ? $data["FatherAddress"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">อาชีพ</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["FatherCareer"]) ? $data["FatherCareer"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">เบอร์โทร</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["FatherPhone"]) ? $data["FatherPhone"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ชื่อ–นามสกุล (มารดา)</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Mother"]) ? $data["Mother"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">มีชีวิต/ถึงแก่กรรม</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["MotherStatus"]) ? $data["MotherStatus"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">อายุ</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["MotherAge"]) ? $data["MotherAge"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ที่อยู่</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["MotherAddress"]) ? $data["MotherAddress"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">อาชีพ</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["MotherCareer"]) ? $data["MotherCareer"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">เบอร์โทร</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["MotherPhone"]) ? $data["MotherPhone"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">จบการศึกษา</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["University"]) ? $data["University"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ปีการศึกษา</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Year"]) ? $data["Year"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">คณะวิชา</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Faculty"]) ? $data["Faculty"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">สาขาวิชา</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Major"]) ? $data["Major"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">คะแนนเฉลี่ย</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Score"]) ? $data["Score"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ภาษาอังกฤษ</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["EnglishSkill"]) ? $data["EnglishSkill"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ภาษาอื่นๆ</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["LanguageSkill"]) ? $data["LanguageSkill"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ความรู้ทางคอมพิวเตอร์</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["ComputerSkill"]) ? $data["ComputerSkill"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">พิมพ์ดีดไทย</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["KeyboardThai"]) ? $data["KeyboardThai"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">พิมพ์ดีดอังกฤษ</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["KeyboardEnglish"]) ? $data["KeyboardEnglish"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">รถยนต์</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Car"]) ? $data["Car"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ใบขับขี่</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["DriverLicense"]) ? $data["DriverLicense"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ชื่อสถานที่ทำงานเดิม</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["OldCompany"]) ? $data["OldCompany"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ตำแหน่ง</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["OldPosition"]) ? $data["OldPosition"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">เงินเดือน</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["OldSalary"]) ? $data["OldSalary"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ระยะเวลาการทำงาน</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["OldWorkingTime"]) ? $data["OldWorkingTime"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">สาเหตุที่ออก</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["OldReason"]) ? $data["OldReason"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ชื่อสถานที่ทำงานปัจจุบัน</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["CurrentCompany"]) ? $data["CurrentCompany"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ผู้แนะนำ</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Adviser"]) ? $data["Adviser"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ความสัมพันธ์</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["AdviserRelationship"]) ? $data["AdviserRelationship"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">สถานที่ทำงาน</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["AdviserWorkplace"]) ? $data["AdviserWorkplace"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ที่อยู่</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["AdviserAddress"]) ? $data["AdviserAddress"] : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">เบอร์โทร</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["AdviserPhone"]) ? $data["AdviserPhone"] : "-" ?></b></div>
                                                </div> -->
                                                <!-- <div class="row">
                                                    <div class="col-md-4">หัวข้อ</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Position"]) ? $data["Position"] : "-" ?></b></div>
                                                </div> -->
                                                <!-- <div class="row">
                                                    <div class="col-md-4">เริ่มงาน</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["StartWork"]) ? $data["StartWork"] : "-" ?></b></div>
                                                </div> -->
                                                <div class="row">
                                                    <div class="col-md-4">รายละเอียด</div>
                                                    <div class="col-md-8"><b><?php echo !empty($data["Message"]) ? ConvertNewLine($data["Message"]) : "-" ?></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">ไฟล์แนบ</div>
                                                    <div class="col-md-8">
                                                        <a href="<?php echo !empty($data["Image"]) ? $data["Image"] : "#" ?>" class="" target="_bank">ข้อมูลใบเอกสารผู้ค้าสลาก</a>
                                                        <!-- <img src="<?php echo $data["Image"] ?>" alt="profile" style="width: 150px;height: 150px;object-fit: cover;"> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post">
                                                    <span class="pull-left" title="วัน / เวลา"">
                                                        <i class="fa fa-calendar fa-fw"></i>
                                                        <?php echo ConvertDateTimeDBToDateTimeDisplay($data["CreatedOn"]) ?>
                                                    </span>
                                                    <button type="submit"
                                                        class="btn btn-success <?php echo $data["Picked"] == 1 ? "hide" : "" ?>"
                                                        value="<?php echo $data["CareerCode"] ?>" name="btnPicked">
                                                        <i class="fa fa-check-square-o"></i>
                                                        ยืนยันว่าอ่านแล้ว</button>
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
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