<?php include  "../header.php"; ?>
<?php include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/DataService.php"; ?>

<?php


if (isset($_POST["btnPicked"])) {
    $sqlUpdate = "update join_us set
    Required = 0
    where JoinCode = '" . $_POST["btnPicked"] . "'";
    ExecuteSQL($sqlUpdate);
}

if (isset($_POST["btnDeleteRow"])) {
    $sql = "delete from join_us where JoinCode = '" . $_POST["btnDeleteRow"] . "'";
    ExecuteSQL($sql);
}

?>

<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-9">
            <h3 style="margin: 0;">
                <i class="fa fa-edit  fa-fw"></i>
                <span class="analysis-left-menu-desc">แบบสอบถาม</span>
            </h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

<div class="mat-box grey-bar">

    <a href="join.php" class="link-history-btn">แบบสอบถาม</a>
    /
    <span class="link-history-btn">ข้อมูลตอบแบบสอบถาม</span>



</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row">
        <div class="col-md-3 hide">
            <?php
            $_LEFT_MENU_ACTIVE = "REGISTER";
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
                <span><b>รายการลงทะเบียนเข้ามา</b></span>
                <hr style="margin-top: 5px;" />

                <script>
                    // _datatableOptions = {
                    //     "order": [
                    //         [0, "desc"]
                    //     ]
                    // }

                    function changeRedirect(obj) {
                        var pathname = window.location.origin + "" + window.location.pathname;
                        window.location.replace(pathname + "?cat=" + $(obj).val());
                    }
                </script>

                <style>
                    .jquery-datatable th,
                    .jquery-datatable td {
                        max-width: 200px;
                        white-space: nowrap;
                        text-overflow: ellipsis;
                        overflow-x: hidden;
                        vertical-align: top !important;
                    }
                </style>
                <div style="width:100%;overflow-x:auto">
                <table class="jquery-datatable display export-table export-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 20px">#</th>
                            <th>วัน / เวลา</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>โทรศัพท์</th>
                            <th>ตำแหน่ง</th>
                            <th>LineID</th>
                            <th>ชื่อบริษัท</th>
                            <th class="hide">เวลาที่สะดวกในการติดต่อ</th>
                             <th class="hide">ตัวแทนจำหน่ายจังหวัด</th>
                            <th class="hide">ตัวแทนจำหน่ายโชว์รูม</th>
                            <th style="width:100px;" class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="text-center" style="width: 20px">#</th>
                            <th>วัน / เวลา</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>โทรศัพท์</th>
                            <th>ตำแหน่ง</th>
                            <th>LineID</th>
                            <th>ชื่อบริษัท</th>
                            <th class="hide">เวลาที่สะดวกในการติดต่อ</th>
                             <th class="hide">ตัวแทนจำหน่ายจังหวัด</th>
                            <th class="hide">ตัวแทนจำหน่ายโชว์รูม</th>
                            <th class="text-center">รายละเอียด</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php

                        $sql = "select a.* , b.PortCode, b.PortName, b.LineID as line , b.Image from join_us a
                            join portfolio b on a.Type = b.PortCode
                           ";
                        $datas = SelectRowsArray($sql);
                        $index = 1;
                        foreach ($datas as $data) {
                        ?>
                            <tr class="<?php echo $data["Required"] != 1 ? "picked" : "no-picked" ?>">
                                <td class="text-center">
                                    <?php echo $index++ ?>
                                </td>
                                <td><?php echo ConvertDateTimeDBToDateTimeDisplay($data["CreatedOn"]) ?></td>
                                <td><?php echo $data["FirstName"] ?> <?php echo $data["LastName"] ?></td>
                                <td><?php echo $data["Tel"] ?></td>
                                <td><?php echo $data["Position"] ?></td>
                                <td><?php echo $data["LineID"] ?></td>
                                <td class="hide"><?php echo $data["BusinessType"] ?></td>
                                <td class="hide"><?php echo $data["CallTime"] ?></td>
                                
                                 <td><?php echo $data["CompanyName"] ?></td>
                                <td class="hide"><?php echo $data["PortName"] ?></td>
                                <td class="text-center">
                                    <a title="รายละเอียด" href="#" onclick="$('#modal-<?php echo $data["JoinCode"] ?>').modal('show'); return false;">
                                        <i class="fa fa-search"></i>
                                    </a>
                                    <form method="post" style="display:inline">
                                        <button type="submit" class="btn-link" onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');" value="<?php echo $data["JoinCode"] ?>" name="btnDeleteRow">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>


                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>



                
                </div>
            </div>

            <?php

            foreach ($datas as $data) {
            ?>
                <div id="modal-<?php echo $data["JoinCode"] ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog text-left">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">
                                    <div class="" title="ชื่อผู้ติดต่อ">
                                        <i class="fa fa-user fa-fw"></i>
                                        <?php echo $data["FirstName"] ?>
                                        <?php echo $data["LastName"] ?>
                                    </div>
                                </h4>
                            </div>
                            <div class="modal-body">
                                <table class="table table-striped">
                                    <tr>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th class="text-primary"> <?php echo $data["FirstName"] ?>
                                            <?php echo $data["LastName"] ?></th>
                                    </tr>
                                    <tr>
                                        <th>โทรศัพท์</th>
                                        <th class="text-primary"> <?php echo $data["Tel"] ?></th>
                                    </tr>
                                    <tr>
                                        <th>อีเมล์</th>
                                        <th class="text-primary"> <?php echo $data["Email"] ?></th>
                                    </tr>
                                    <tr>
                                        <th>LineID</th>
                                        <th class="text-primary"> <?php echo $data["LineID"] ?></th>
                                    </tr>

                                    <tr>
                                        <th>ตำแหน่ง</th>
                                        <th class="text-primary"> <?php echo $data["Position"] ?></th>
                                    </tr>
                                    <tr>
                                        <th>ชื่อบริษัท</th>
                                        <th class="text-primary"> <?php echo $data["CompanyName"] ?></th>
                                    </tr>
                                    <?php
                                        $sql2 = "select * from join_us a
                                            join portfolio b on a.Business = b.PortCode
                                            where a.JoinCode = '".$data["JoinCode"]."'
                                        ";
                                        $datas2 = SelectRow($sql2);
                                    ?>
                                    <tr>
                                        <th>ประเภทธุรกิจ</th>
                                        <th class="text-primary"> <?php echo $datas2["PortName"] ?></th>
                                    </tr>
                                    <?php
                                        $sql3 = "select * from join_us a
                                            join portfolio b on a.Theme = b.PortCode
                                            where a.JoinCode = '".$data["JoinCode"]."'
                                        ";
                                        $datas3 = SelectRow($sql3);
                                    ?>
                                    <tr>
                                        <th>ธีมองค์กร</th>
                                        <th class="text-primary"> <?php echo $datas3["PortName"] ?></th>
                                    </tr>
                                    <?php
                                        $sql4 = "select * from join_us a
                                            join portfolio b on a.Theme2 = b.PortCode
                                            where a.JoinCode = '".$data["JoinCode"]."'
                                        ";
                                        $datas4 = SelectRow($sql4);
                                    ?>
                                    <tr>
                                        <th>ธีมองค์กร 2</th>
                                        <th class="text-primary"> <?php echo $datas4["PortName"] ?></th>
                                    </tr>
                                    <?php
                                        $sql5 = "select * from join_us a
                                            join portfolio b on a.Theme3 = b.PortCode
                                            where a.JoinCode = '".$data["JoinCode"]."'
                                        ";
                                        $datas5 = SelectRow($sql5);
                                    ?>
                                    <tr>
                                        <th>ธีมองค์กร 3</th>
                                        <th class="text-primary"> <?php echo $datas5["PortName"] ?></th>
                                    </tr>
                                    
                                    <tr>
                                        <th>ธีมองค์กร 4</th>
                                        <th class="text-primary">
                                        <?php 
                                            $sqlProject = " select * from portfolio where Active = 1";
                                            $projects = SelectRowsArray($sqlProject); 
                                            foreach ($projects as $project) {
                                                if( strpos($data["Theme4"],$project["PortCode"]) !== false){  
                                        ?>    
                                                 <li><?php echo ConvertNewLine($project["PortName"]) ?></li>
                                        <?php }} ?>
                                        </th>
                                        
                                    </tr>
                                    
                                    
                                    <?php
                                        $sql7 = "select * from join_us a
                                            join portfolio b on a.Budget = b.PortCode
                                            where a.JoinCode = '".$data["JoinCode"]."'
                                        ";
                                        $datas7 = SelectRow($sql7);
                                    ?>
                                    <tr>
                                        <th>งบประมาณ</th>
                                        <th class="text-primary"> <?php echo $datas7["PortName"] ?></th>
                                    </tr>
                                    <?php
                                        $sql8 = "select * from join_us a
                                            join portfolio b on a.Employee = b.PortCode
                                            where a.JoinCode = '".$data["JoinCode"]."'
                                        ";
                                        $datas8 = SelectRow($sql8);
                                    ?>
                                    <tr>
                                        <th>จำนวนพนักงาน</th>
                                        <th class="text-primary"> <?php echo $datas8["PortName"] ?></th>
                                    </tr>
                                    <tr>
                                        <th>ประเภทสินค้า</th>
                                        <th class="text-primary"> <?php echo $data["PortName"] ?></th>
                                    </tr>
                                    
                                </table>
                                <hr>
                                <h5 style="margin-top: 0">การยืนยันว่าอ่านแล้ว จะทำไม่มีการแจ้งเตือนส่วนบนของระบบจัดการข้อมูล</h5>
                                <form method="post">
                                    <button type="submit" class="btn btn-success" value="<?php echo $data["JoinCode"] ?>" <?php echo $data["Required"] == 1 ? "" : "disabled" ?> name="btnPicked">
                                        <i class="fa fa-check-square-o"></i>
                                        ยืนยันว่าอ่านแล้ว</button>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            <?php
            }

            ?>

        </div>
    </div>
</div>
</div>

<?php include  "../footer.php"; ?>