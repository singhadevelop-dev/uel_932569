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

                <i class="fa fa-eye fa-fw"></i>
                <span class="analysis-left-menu-desc">ผู้ติดตามเว็บไซต์</span>

            </h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

<div class="mat-box grey-bar">

    <a href="subscribe.php" class="link-history-btn">ผู้ติดตามเว็บไซต์</a>
    /
    <span class="link-history-btn">ข้อมูลผู้ติดตามเว็บไซต์</span>



</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row">
        <div class="col-md-2 hide">
            <?php 
                $_LEFT_MENU_ACTIVE = "SUBSCRIBE";
                include "leftMenu.php"; 
                ?>
        </div>
        <div class="col-md-12">
            <style>
                .picked td{
                    background-color:rgba(176, 243, 76, 0.4) !important;
                }
                .picked td:first-child {
                    border-left:3px solid rgba(176, 243, 76, 1);
                }
                .no-picked td{
                    background-color:rgba(255, 0, 0,0.2) !important;
                }
                .no-picked td:first-child {
                    border-left:3px solid rgba(255, 0, 0,1);
                }
            </style>
            <div>
                <span><b>รายการรับข้อมูลผู้ติดตามเว็บไซต์</b></span>
                <hr style="margin-top: 5px;" />

                <script>
                    _datatableOptions = {
                        "order": [[0, "desc"]]
                    }
                </script>
                <table class="jquery-datatable display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>วัน / เวลา</th>
                            <!-- <th>ชื่อผู้ติดต่อ</th> -->
                            <th class="">อีเมล</th>
                            <!-- <th>หัวข้อการติดต่อ</th> -->
                            <th style="width:100px;" class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>วัน / เวลา</th>
                            <!-- <th class="">ชื่อผู้ติดต่อ</th> -->
                            <th class="">อีเมล</th>
                            <!-- <th>หัวข้อการติดต่อ</th> -->
                            <th class="text-center">รายละเอียด</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                    
                        $sql = "select * from member where MemberType = 'SUBSCRIBE' order by CreatedOn desc";
                        $datas = SelectRowsArray($sql);
                        foreach ($datas as $data) {
                        ?>
                        <tr class="<?php echo $data["Picked"] == 1 ? "picked" : "no-picked" ?>">
                            <td><span class="hide"><?php echo $data["CreatedOn"]; ?></span> <?php echo ConvertDateTimeDBToDateTimeDisplay($data["CreatedOn"]) ?></td>
                            <!-- <td><?php echo $data["MemberName"] ?></td> -->
                            <td><?php echo $data["Email"]; ?></td>
                            <!-- <td><?php //echo $data["Subject"] ?></td> -->
                            <td class="text-center">
                                <a title="รายละเอียด" href="#" onclick="$('#modal-<?php echo $data["MemberCode"] ?>').modal('show'); return false;">
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
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"><?php echo $data["Subject"] ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <!-- <?php //echo ConvertNewLine($data["Message"]) ?>
                                                <hr /> -->
                                                <p class="hide">
                                                    <i class="fa fa-user fa-fw"></i>
                                                    <?php echo $data["MemberName"] ?>
                                                </p>
                                                <p class="hide">
                                                    <i class="fa fa-building fa-fw"></i>
                                                    <?php echo $data["Company"] ?>
                                                </p>
                                                <p class="hide">
                                                    <i class="fa fa-map fa-fw"></i>
                                                    <?php echo $data["Address"] ?>
                                                </p>
                                                <p>
                                                    <i class="fa fa-envelope fa-fw"></i>
                                                    <?php echo $data["Email"] ?>
                                                </p>
                                                <p class="hide">
                                                    <i class="fa fa-phone fa-fw"></i>
                                                    <?php echo $data["Phone"] ?>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post">
                                                    <button type="submit" class="btn btn-success <?php echo $data["Picked"] == 1 ? "hide" : "" ?>" value="<?php echo $data["MemberCode"] ?>" name="btnPicked">
                                                        <i class="fa fa-check-square-o"></i>
                                                        ยืนยันว่าอ่านแล้ว</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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