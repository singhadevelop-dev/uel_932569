<?php include  "../header.php"; ?>
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
                <i class="fa fa-file-o  fa-fw"></i>
                <span class="analysis-left-menu-desc">SAMPLE FORM</span>
            </h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

<div class="mat-box grey-bar">

    <a href="sampleform.php" class="link-history-btn">SAMPLE FORM</a>
    /
    <span class="link-history-btn">ข้อมูล SAMPLE FORM</span>



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
                <span><b>รายการลงทะเบียนเข้ามา</b></span>
                <hr style="margin-top: 5px;" />

                <script>
                _datatableOptions = {
                    "order": [
                        [0, "desc"]
                    ],
                    // dom: 'Bfrtip',
                    // buttons: [{ extend: 'excelHtml5', title: 'SAMPLE FORM' , exportOptions: { columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 ]} },
                    //     //'copyHtml5',
                    //     //'excelHtml5',
                    //     // 'csvHtml5',
                    //     // 'pdfHtml5'
                    // ]
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
                        $(ddlselect_cat).append("<label>เลือกการติดต่อ:</label>");
                        $(ddlselect_cat).find("label").append($("#ddlCategorySelect"));
                        //$(ddlselect_cat).append("&nbsp;&nbsp;&nbsp;");
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
                        <?php 
                            $sqlP = "Select PortCode as ProductCode, PortName as ProductName from portfolio where Active=1 and PortType='ROLE' order by SEQ,PortCode";
                            $datasP = SelectRowsArray($sqlP);
                            foreach ($datasP as $data) { ?>
                            <option value="<?php echo $data["ProductCode"] ?>" <?php echo $CatCode == $data["ProductCode"]  ? 'selected="selected"' : '' ?>>
                                 <?php echo $data["ProductName"] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                
                <table class="jquery-datatable display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="hide">time db</th>
                            <th>วัน / เวลา</th>
                            <th>ชื่อผู้ติดต่อ</th>
                            <th class="">Role</th>
                            <th class="">Product Application</th>
                            <th style="width:100px;" class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="hide">time db</th>
                            <th>วัน / เวลา</th>
                            <th>ชื่อผู้ติดต่อ</th>
                            <th class="">Role</th>
                            <th class="">Product Application</th>
                            <th class="text-center">รายละเอียด</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                    
                        $sql = "select a.*, b.PortName as RoleName, c.PortName as PaymentAmountName
                            ,d.PortName as ProductApplication
                            ,e.PortName as DecisionUse
                            from member a
                            left join portfolio b
                                on a.Subject = b.PortCode and b.PortType='ROLE'
                            left join portfolio c
                                on a.PaymentAmount = c.PortCode and c.PortType='QUANTITY'
                            left join portfolio d
                                on a.CheckOutCode = d.PortCode and d.PortType='PRODUCT_APP'
                            left join portfolio e
                                on a.PaymentTime = e.PortCode and e.PortType='DECISION'
                            where a.MemberType = 'SAMPLE'
                         ";
                        if(!empty($CatCode))
                        {
                            $sql .= " and a.Subject='$CatCode'  ";
                        }
                        $sql .= " order by a.CreatedOn desc ";
                        $datas = SelectRowsArray($sql);
                        foreach ($datas as $data) {
                        ?>
                        <tr class="<?php echo $data["Picked"] == 1 ? "picked" : "no-picked" ?>">
                            <td class="hide"><?php echo $data["CreatedOn"]; ?></td>
                            <td><?php echo ConvertDateTimeDBToDateTimeDisplay($data["CreatedOn"]) ?></td>
                            <td><?php echo $data["MemberName"] ?></td>
                            <td class=""><?php echo $data["RoleName"] ?></td>
                            <td class=""><?php echo $data["ProductApplication"] ?></td>
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
                                                <?php echo ConvertNewLine($data["RoleName"]) ?>
                                                <hr />
                                                <p class="" title="บริษัท">
                                                    <i class="fa fa-building fa-fw"></i>
                                                    ชื่อบริษัท : <span class="text-primary"><?php echo $data["Company"] ?></span>
                                                </p>
                                                <p class="" title="Name">
                                                    <i class="fa fa-user fa-fw"></i>
                                                    ชื่อ : <span class="text-primary"><?php echo $data["MemberName"] ?></span>
                                                </p>
                                                <p title="อีเมล" class="">
                                                    <i class="fa fa-envelope fa-fw"></i>
                                                    อีเมล : <span class="text-primary"><?php echo $data["Email"] ?></span>
                                                </p>
                                                <p class="" title="Position">
                                                    <i class="fa fa-user fa-fw"></i>
                                                    Position : <span class="text-primary"><?php echo $data["MemberName2"] ?></span>
                                                </p>
                                                <p class="" title="Position">
                                                    <i class="fa fa-building fa-fw"></i>
                                                    Department : <span class="text-primary"><?php echo $data["Department"] ?></span>
                                                </p>
                                                <p class="" title="เบอร์มือถีอ">
                                                    <i class="fa fa-phone fa-fw"></i>
                                                    เบอร์มือถีอ : <span class="text-primary"><?php echo $data["Phone"] ?></span>
                                                </p>
                                                <p class="" title="Product Name">
                                                    <i class="fa fa-cubes fa-fw"></i>
                                                    Product Name : <span class="text-primary"><?php echo $data["ProductRefCode"] ?></span>
                                                </p>
                                                <p class="" title="Manufactuer*">
                                                    <i class="fa fa-balance-scale fa-fw"></i>
                                                    Quantity : <span class="text-primary"><?php echo $data["PaymentAmountName"] ?></span>
                                                </p>
                                                <p class="" title="Manufactuer*">
                                                    <i class="fa fa-product-hunt fa-fw"></i>
                                                    Product App/Industry : <span class="text-primary"><?php echo $data["ProductApplication"] ?></span>
                                                </p>
                                                <p class="" title="Decision Use?">
                                                    <i class="fa fa-clock-o fa-fw"></i>
                                                    Decision Use? : <span class="text-primary"><?php echo $data["DecisionUse"] ?></span>
                                                </p>
                                                <p class="" title="Manufactuer*">
                                                    <i class="fa fa-cubes fa-fw"></i>
                                                    Annual potential volume* : <span class="text-primary"><?php echo $data["Message"] ?></span>
                                                </p>
                                                
                                                <p class="hide">
                                                    <i class="fa fa-map fa-fw"></i>
                                                    ที่อยู่ : <span class="text-primary"><?php echo $data["Address"] ?></span>
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