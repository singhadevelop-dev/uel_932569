<?php $_COG_ITEM_CODE = 'SUBSCRIBE'; ?>
<?php include  "../header.php"; ?>
<?php include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/UtilService.php"; ?>
<?php include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/DataService.php"; ?>

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
                <i class="fa fa-list fa-fw"></i>
                <span class="analysis-left-menu-desc">จองแพ็คเกจทัวร์</span>
            </h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

<div class="mat-box grey-bar">

    <a href="subscribe.php" class="link-history-btn">จองแพ็คเกจทัวร์</a>
    /
    <span class="link-history-btn">ข้อมูลผู้ต้องการจองแพ็คเกจทัวร์</span>



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
                <span><b>รายการติดต่อเข้ามา</b></span>
                <hr style="margin-top: 5px;" />

                <script>
                _datatableOptions = {
                    "order": [
                        [0, "desc"]
                    ]
                }

                function changeRedirect(obj) {
                    var pathname = window.location.origin + "" + window.location.pathname;
                    window.location.replace(pathname + "?cat=" + $(obj).val());
                }

                $(document).ready(function() {
                    setTimeout(function() {
                        var ddlselect_cat = $("<div />", {
                            "id": "DataTables_Table_0_filter_select_cat",
                            class: "dataTables_filter",
                        });
                        $(ddlselect_cat).append("<label>เลือกบริการ:&nbsp;&nbsp;</label>");
                        $(ddlselect_cat).append($("#ddlCategorySelect"));
                        $(ddlselect_cat).append("&nbsp;&nbsp;&nbsp;");
                        $("#DataTables_Table_0_filter").after($(ddlselect_cat));
                    }, 800);
                });

                </script>

                <?php
                    $CatCode = $_GET["cat"];
                 ?>
                <div style="display:none;">
                    <select id="ddlCategorySelect" onchange="changeRedirect(this);" style="min-height: 25px;">
                        <option value="" <?php echo empty($CatCode)  ? 'selected="selected"' : '' ?>>ทั้งหมด</option>
                        <?php foreach (DataService::getInstance()->GetProduct("") as $data) { ?>
                            <option value="<?php echo $data["ProductCode"] ?>" <?php echo $CatCode == $data["ProductCode"]  ? 'selected="selected"' : '' ?>>
                                 <?php echo $data["ProductName"] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                
                <table class="jquery-datatable display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>วัน / เวลา</th>
                            <th>หัวข้อการติดต่อ</th>
                            <th>ชื่อผู้ติดต่อ</th>
                            <th>จำนวน</th>
                            <th style="width:100px;" class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>วัน / เวลา</th>
                            <th>หัวข้อการติดต่อ</th>
                            <th>ชื่อผู้ติดต่อ</th>
                            <th>จำนวน</th>
                            <th class="text-center">รายละเอียด</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $sql = "select a.*
                            ,pro.ProductName as SubjectDetail
                            from member a
                            left join product pro on a.ProductCode = pro.ProductCode
                            where a.MemberType = 'BOOKING' 
                         ";
                        if(!empty($CatCode))
                        {
                            $sql .= " and a.ProductCode='$CatCode'  ";
                        }
                        $sql .= " order by a.CreatedOn desc ";
                        $datas = SelectRowsArray($sql);
                        foreach ($datas as $data) {
                        ?>
                        <tr class="<?php echo $data["Picked"] == 1 ? "picked" : "no-picked" ?>">
                            <td><span class="hide"><?php echo $data["CreatedOn"]; ?></span>
                                <?php echo ConvertDateTimeDBToDateTimeDisplay($data["CreatedOn"]) ?></td>
                            <td><?php echo $data["SubjectDetail"] ?></td>
                            <td><?php echo $data["MemberName"] ?></td>
                            <td class="text-right"><?php echo number_format($data["Amount"]) ?></td>
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
                                                        <?php echo $data["MemberName"] ?>
                                                    </p>
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <?php echo ConvertNewLine($data["Message"]) ?>
                                                <hr />
                                                <p class="" title="หัวข้อการติดต่อ">
                                                    <i class="fa fa-newspaper-o fa-fw"></i>
                                                    <?php echo $data["SubjectDetail"] ?>
                                                </p>
                                                <p class="hide" title="บริษัท">
                                                    <i class="fa fa-building fa-fw"></i>
                                                    <?php echo $data["Company"] ?>
                                                </p>
                                                <p class="hide">
                                                    <i class="fa fa-map fa-fw"></i>
                                                    <?php echo $data["Address"] ?>
                                                </p>
                                                <p title="อีเมล" class="hide">
                                                    <i class="fa fa-envelope fa-fw"></i>
                                                    <?php echo $data["Email"] ?>
                                                </p>
                                                <p class="" title="เบอร์มือถีอ">
                                                    <i class="fa fa-phone fa-fw"></i>
                                                    <?php echo $data["Phone"] ?>
                                                </p>
                                                <p class="" title="ผู้ใหญ่">
                                                    <i class="fa fa-user-circle fa-fw"></i>
                                                    ผู้ใหญ่ <?php echo $data["Adult"] ?> ท่าน
                                                </p>
                                                <p class="" title="เด็ก">
                                                    <i class="fa fa-user-o fa-fw"></i>
                                                    เด็ก <?php echo $data["Child"] ?> ท่าน
                                                </p>
                                                <p class="" title="วัน / เวลา"">
                                                    <i class="fa fa-calendar fa-fw"></i>
                                                    <?php echo ConvertDateTimeDBToDateTimeDisplay($data["CreatedOn"]) ?>
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