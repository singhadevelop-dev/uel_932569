<?php $_COG_ITEM_CODE = 'SALE_REPORT'; ?>
<?php include "../header.php"; ?>

<?php 
//$MonthsArr = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
$MonthsArr = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
$Year = GetCurrentYearServer();

?>

<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-9">
            <h3 style="margin: 0;">

                <i class="fa fa-bar-chart fa-fw"></i>
                <span class="analysis-left-menu-desc">รายงานสรุปยอดขายแล้ว</span>

            </h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

    <div class="mat-box grey-bar">

        <a href="reporttotalpay.php" class="link-history-btn">รายงาน</a>
        /
        <span class="link-history-btn">รายงานสรุปยอดขายแล้ว</span>

    </div>
    <div class="mat-box" style="border-radius: 0 0 3px 3px">
        <div class="row" style="margin-bottom: -15px;">
            <div class="col-md-12">
                <div id="panel-chart">
                    <div class="row">
                            <div class="col-md-3">
                                <label>ปี</label>
                                <select class="form-control" name="ddlYear" onchange="_load_report_summary();">
                                    <?php
                                        $sqlYear = "
                                            select year(a.CreatedOn) as year
                                            from checkout  a 
                                            group by year(a.CreatedOn)
                                        ";
                                        $datasYear = SelectRowsArray($sqlYear);
                                        foreach ($datasYear as $year) {
                                    ?>
                                        <option value="<?php echo $year["year"] ?>"><?php echo $year["year"] ?></option>
                                    <?php $index++; } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>เดือน</label>
                                <select class="form-control" name="ddlMonth" onchange="_load_report_summary();">
                                    <option value="">ทั้งหมด</option>
                                    <?php
                                        $nMouth = 0;
                                        foreach ($MonthsArr as $month) {
                                            $nMouth++;
                                    ?>
                                        <option value="<?php echo str_pad($nMouth, 2, "0",STR_PAD_LEFT) ?>"><?php echo $month ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>จัดกลุ่มตาม</label>
                                <select class="form-control" name="ddlGroupBy" onchange="_load_report_summary();">
                                    <option value="">ไม่ระบุ</option>
                                    <option value="CATEGORY">กลุ่มสินค้า</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr style="margin-top: 5px;" />
                </div>
        </div>
    </div>

    <div id="panel-report-summary">
        <div class="mat-box" style="border-radius: 0 0 3px 3px;min-height: 6rem;">

        </div>
    </div>

</div>

<script>
    
    $(document).ready(function(){
        _load_report_summary();
    });

    function _load_report_summary()
    {
        $("#panel-report-summary").AlertLoading(true,"โหลดข้อมูล");
        var year = $("[name='ddlYear']").val();
        var month = $("[name='ddlMonth']").val();
        var gropby = $("[name='ddlGroupBy']").val();
        $("#panel-report-summary").load("_load_report_summary.php?year="+year+"&month="+month+"&group="+gropby,function(){});
    }

</script>

<?php include  "../footer.php"; ?>