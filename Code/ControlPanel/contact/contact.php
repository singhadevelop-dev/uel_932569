<?php include  "../header.php"; ?>

<?php 


if(isset($_POST["btnPicked"])){
    $sqlUpdate = "update member set
    Picked = 1
    where MemberCode = '".$_POST["btnPicked"]."'";
    ExecuteSQL($sqlUpdate);
    
}

if(isset($_POST["btnDeleteRow"])){
    $sql = "delete from member where MemberCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
}

?>

<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-9">
            <h3 style="margin: 0;">

                <i class="fa fa-users fa-fw"></i>
                <span class="analysis-left-menu-desc">ผู้เข้ามาติดต่อ</span>

            </h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

<div class="mat-box grey-bar">

    <a href="contact.php" class="link-history-btn">ผู้เข้ามาติดต่อ</a>
    /
    <span class="link-history-btn">ข้อมูลผู้ติดต่อ</span>

</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row">
        <div class="col-md-2 hide">
            <?php 
                $_LEFT_MENU_ACTIVE = "CONTACT";
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
                <span><b>รายการการติดต่อเข้ามา</b></span>
                <hr style="margin-top: 5px;" />

                <script>
                _datatableOptions = {
                    "order": [
                        [0, "desc"]
                    ],
                    // dom: 'Bfrtip',
                    // buttons: [{ extend: 'excelHtml5', title: 'ผู้เข้ามาติดต่อ' , exportOptions: { columns: [ 1, 2, 3, 4, 5, 6 ]} },
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
                            <th>ชื่อผู้ติดต่อ</th>
                            <th class="">หัวข้อที่ติดต่อ</th>
                            <th class="hide">ชื่อหน่วยงาน</th>
                            <th class="hide">อีเมล</th>
                            <th style="width:100px;" class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="hide">time db</th>
                            <th>วัน / เวลา</th>
                            <th>ชื่อผู้ติดต่อ</th>
                            <th class="">หัวข้อที่ติดต่อ</th>
                            <th class="hide">ชื่อหน่วยงาน</th>
                            <th class="hide">อีเมล</th>
                            <th class="text-center">รายละเอียด</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                    
                        $sql = "select a.*
                         from member a
                         where a.MemberType = 'CONTACT' 
                        order by a.CreatedOn desc";
                        $datas = SelectRowsArray($sql);
                        foreach ($datas as $data) {
                        ?>
                        <tr class="<?php echo $data["Picked"] == 1 ? "picked" : "no-picked" ?>">
                            <td class="hide"><?php echo $data["CreatedOn"]; ?></td>
                            <td><?php echo ConvertDateTimeDBToDateTimeDisplay($data["CreatedOn"]) ?></td>
                            <td><?php echo $data["MemberName"]." ".$data["MemberName2"] ?></td>
                            <td class=""><?php echo !empty($data["Subject"]) ? $data["Subject"] : "-" ?></td>
                            <td class="hide"><?php echo $data["Company"] ?></td>
                            <td class="hide"><?php echo $data["Email"] ?></td>
                            <td class="text-center">
                                <a title="รายละเอียด" href="#"
                                    onclick="$('#modal-<?php echo $data["MemberCode"] ?>').modal('show'); return false;">
                                    <i class="fa fa-search"></i>
                                </a>

                                <form method="post" style="display:inline">
                                    <button type="submit" class="btn-link"
                                        onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                        value="<?php echo $data["MemberCode"] ?>" name="btnDeleteRow">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                <div id="modal-<?php echo $data["MemberCode"] ?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog text-left">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">
                                                    <p class="" title="ชื่อผู้ติดต่อ">
                                                        <i class="fa fa-user fa-fw"></i>
                                                        <?php echo $data["MemberName"]." ".$data["MemberName2"] ?>
                                                    </p>
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <?php echo ConvertNewLine($data["Message"]) ?>
                                                <hr />
                                                <p class="" title="หัวข้อ">
                                                    <i class="fa fa-tasks fa-fw"></i>
                                                    หัวข้อที่ติดต่อ: <b class="text-primary"><?php echo !empty($data["Subject"]) ? $data["Subject"] : "-" ?></b>
                                                </p>
                                                <p class="" title="Company name">
                                                    <i class="fa fa-building fa-fw"></i>
                                                    Company name: <b class="text-primary"><?php echo !empty($data["Company"]) ? $data["Company"] : "-" ?></b>
                                                </p>
                                                <p class="hide" title="Department">
                                                    <i class="fa fa-building fa-fw"></i>
                                                    Department: <b class="text-primary"><?php echo !empty($data["Department"]) ? $data["Department"] : "-" ?></b>
                                                </p>
                                                <p class="hide" title="Country">
                                                    <i class="fa fa-map fa-fw"></i>
                                                    Country: <b class="text-primary"><?php echo $data["Address"] ?></b>
                                                </p>
                                                <p title="อีเมล">
                                                    <i class="fa fa-envelope fa-fw"></i>
                                                    Email: <b class="text-primary"><?php echo !empty($data["Email"]) ? $data["Email"] : "-" ?></b>
                                                </p>
                                                <p class="" title="เบอร์มือถีอ">
                                                    <i class="fa fa-phone fa-fw"></i>
                                                    Phone: <b class="text-primary"><?php echo !empty($data["Phone"]) ? $data["Phone"] : "-"  ?></b>
                                                </p>
                                                <p class="hide" title="เพศ">
                                                    <i class="fa fa-transgender fa-fw"></i>
                                                    เพศ: <b class="text-primary"><?php echo $data["Gender"] ?></b>
                                                </p>
                                                <p class="hide" title="line id">
                                                    <i class="fa fa-bullhorn fa-fw"></i>
                                                    <?php echo $data["LineID"] ?>
                                                </p>
                                                <p class="" title="วัน / เวลา"">
                                                    <i class="fa fa-calendar fa-fw"></i>
                                                    วัน / เวลา: <b class="text-primary"><?php echo ConvertDateTimeDBToDateTimeDisplay($data["CreatedOn"]) ?></b>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post">
                                                    <button type="submit"
                                                        class="btn btn-success <?php echo $data["Picked"] == 1 ? "hide" : "" ?>"
                                                        value="<?php echo $data["MemberCode"] ?>" name="btnPicked">
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