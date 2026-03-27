<?php include  "../header.php"; ?>

<?php 


if(isset($_POST["btnPicked"])){
    $sqlUpdate = "update question set
    Picked = 1
    where QuestionCode = '".$_POST["hdfQuestionCode"]."'";
    ExecuteSQL($sqlUpdate);
    
}

if(isset($_POST["btnDeleteRow"])){
    $sql = "delete from question where QuestionCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
}

?>

<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-9">
            <h3 style="margin: 0;">

                <i class="fa fa-wpforms fa-fw"></i>
                <span class="analysis-left-menu-desc">ผู้เข้ามาตอบแบบสอบถาม</span>

            </h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

<div class="mat-box grey-bar">

    <a href="answer.php" class="link-history-btn">ผู้เข้ามาตอบแบบสอบถาม</a>
    /
    <span class="link-history-btn">ข้อมูลผู้ตอบแบบสอบถาม</span>

</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row">
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
                <span><b>รายการตอบแบบสอบถาม</b></span>
                <hr style="margin-top: 5px;" />

                <script>
                _datatableOptions = {
                    "order": [
                        [0, "desc"]
                    ],
                    // dom: 'Bfrtip',
                    // buttons: [{ extend: 'excelHtml5', title: 'ผู้เข้าตอบแบบสอบถาม' , exportOptions: { columns: [ 1, 2, 3, 4, 5, 6 ]} },
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
                            <th style="width: 100px;">วัน / เวลา</th>
                            <th>วัตถุประสงค์</th>
                            <th>เพศ</th>
                            <th>อายุ</th>
                            <th>พื้นที่ ตม.</th>
                            <th>งบประมาณ</th>
                            <th style="width:100px;" class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="hide">time db</th>
                            <th style="width: 100px;">วัน / เวลา</th>
                            <th>วัตถุประสงค์</th>
                            <th>เพศ</th>
                            <th>อายุ</th>
                            <th>พื้นที่ ตม.</th>
                            <th>งบประมาณ</th>
                            <th style="width:100px;" class="text-center">จัดการ</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                    
                        $sql = "select a.CreatedOn
                            ,a.QuestionCode
                            ,a.Objective
                            ,b.ImageName as ObjectiveName
                            ,a.Gender
                            ,c.ImageName as GenderName
                            ,a.Age
                            ,a.Area
                            ,a.Budget
                            ,d.PortName as BudgetName
                            ,a.Picked
                         from question a
                         left join gallery b on b.RefCode='QUESTION01' and a.Objective = b.ImageCode
                         left join gallery c on c.RefCode='QUESTION02' and a.Gender = c.ImageCode
                         left join portfolio d on d.PortType='BUDGET' and a.Budget = d.PortCode
                         where 1=1
                        order by a.CreatedOn desc";
                        $datas = SelectRowsArray($sql);
                        foreach ($datas as $data) {
                        ?>
                        <tr class="<?php echo $data["Picked"] == 1 ? "picked" : "no-picked" ?>">
                            <td class="hide"><?php echo $data["CreatedOn"]; ?></td>
                            <td><?php echo ConvertDateTimeDBToDateTimeDisplay($data["CreatedOn"]) ?></td>
                            <td><?php echo $data["ObjectiveName"] ?></td>
                            <td><?php echo $data["GenderName"] ?></td>
                            <td><?php echo $data["Age"] ?></td>
                            <td><?php echo $data["Area"] ?></td>
                            <td><?php echo $data["BudgetName"] ?></td>
                            <td class="text-center">
                                <a title="รายละเอียด" href="#"
                                    onclick="opendetail('<?php echo $data["QuestionCode"] ?>')">
                                    <i class="fa fa-search"></i>
                                </a>
                                <form method="post" style="display:inline">
                                    <button type="submit" class="btn-link"
                                        onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                        value="<?php echo $data["QuestionCode"] ?>" name="btnDeleteRow">
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
    </div>
</div>

<script>
    function opendetail(code)
    {
        $("#modal-answer-detail").modal('show');
        $("#panel-answer-detail").AlertLoading(true,"โหลดข้อมูล");
        $("#panel-answer-detail").load("_load_data_answer.php",{ref: code},function(){

        });
    }
</script>
<div id="modal-answer-detail" class="modal fade" role="dialog">
    <div class="modal-dialog text-left modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <button type="button" class="close"
                        data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <p class="" title="รายละเอียดแบบฟอร์ม">
                            <i class="fa fa-wpforms fa-fw"></i>
                            รายละเอียดแบบฟอร์ม
                        </p>
                    </h4>
                </div>
                <div class="modal-body">
                    <div id="panel-answer-detail">
                        
                    </div>
                </div>
                <div class="modal-footer">
                        <span class="pull-left" title="วัน / เวลา"">
                            <i class="fa fa-calendar fa-fw"></i>
                            <?php echo ConvertDateTimeDBToDateTimeDisplay($data["CreatedOn"]) ?>
                        </span>
                        <button type="submit"
                            class="btn btn-success"
                            value="Picked" name="btnPicked">
                            <i class="fa fa-check-square-o"></i>
                            ยืนยันว่าอ่านแล้ว</button>
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>

<?php include  "../footer.php"; ?>