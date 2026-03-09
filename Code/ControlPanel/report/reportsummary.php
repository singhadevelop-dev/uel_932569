<?php include  $_SERVER['DOCUMENT_ROOT']."/ControlPanel/header.php"; ?>

<?php 
$MonthsArr = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
$currentYear = "2018";

$Type = "";
$Year = "";
$DocStatus = "";
$MatCode = "";




if(isset($_POST["btnApply"]))
{
    $Type = $_POST["ddlType"];
    $Year = $_POST["txtYear"];
    $DocStatus = $_POST["hddListDocStatus"];
    $MatCode = $_POST["hddListMat"];
} 
else
{
    $Type = $_POST["ddlType"];
    $Year = $_POST["txtYear"];
    if($Type == "y"){
        $Year = "";
    }else if(empty($Year) && $Type != "y"){
        $Type = "m";
        $Year = GetCurrentYearServer();
        $DocStatus = "'SUCCESS'";
        $MatCode = "";
    }
}
$arrDocStatus = explode(",", $DocStatus);
$arrMatCode = explode(",", $MatCode);
    
$sqlCart = "SELECT SUM(b.Total) as xTotal, YEAR(a.CreatedOn) as xYear";
    
if ($Type == "m")
{
    $sqlCart = $sqlCart." , MONTH(a.CreatedOn) as xMonth ";
}
    
$sqlCart = $sqlCart." FROM checkout a
            INNER JOIN cart b
            on b.CheckOutCode = a.CheckOutCode
            WHERE 1=1 ";
    
if ($Type == "m")
{
    $sqlCart = $sqlCart." AND YEAR(a.CreatedOn) = ".$Year." ";
}
    
if (!empty($DocStatus))
{
    $sqlCart = $sqlCart." AND a.StatusCode in (".$DocStatus.") ";
}
if (!empty($MatCode))
{
    $sqlCart = $sqlCart." AND b.ProductCode in (".$MatCode.") ";
}
    
$sqlCart = $sqlCart." GROUP BY YEAR(a.CreatedOn) ";
if ($Type == "m")
{
    $sqlCart = $sqlCart." , MONTH(a.CreatedOn) ";
}
    
$datas = SelectRows($sqlCart);
$datasReportArray = ConvertSQLResultToArray($datas);
?>

<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-9">
            <h3 style="margin: 0;">

                <i class="fa fa-bar-chart fa-fw"></i>
                <span class="analysis-left-menu-desc">รายงาน</span>

            </h3>
        </div>

        <div class="col-sm-3" style="padding-top: 5px;">
        </div>

    </div>
</div>

<div class="mat-box grey-bar">

    <a href="reporttotalpay.php" class="link-history-btn">รายงาน</a>
    /
    <span class="link-history-btn">รายงานยอดขาย</span>



</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row" style="margin-bottom: 0;">
        <div class="col-md-2 hide">
            <?php 
            $_LEFT_MENU_ACTIVE = "PAYMENT";
            include "leftMenu.php"; 
            ?>
        </div>
        <div class="col-md-12">
            <div id="panel-chart">
                <span><b>รายงานยอดขาย</b></span>
                <hr style="margin-top: 5px;" />
                <div class="row" style="margin-bottom: 0;">
                    <div class="col-sm-12 col-md-4">
                        <form action="reporttotalpay.php" method="post" onsubmit="$('[name=txtYear]').prop('disabled', false)" >
                            <div class="row">
                                <div class="col-md-12">
                                    <label>ประเภท</label>
                                    <select class="form-control" name="ddlType" onchange="checkEditYear(this);">
                                        <option value="m" <?php echo $Type == "m" ? 'selected="selected"' : '' ?>>รายเดือน</option>
                                        <option value="y" <?php echo $Type == "y" ? 'selected="selected"' : '' ?>>รายปี</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>ปี</label>
                                    <input type="number" class="form-control" name="txtYear" value="<?php echo !empty($Year) ? $Year : (!empty($_POST["txtYear"]) ? $_POST["txtYear"] : GetCurrentYearServer()) ?>" <?php echo $Type == "m" ? '' : 'disabled="disabled"' ?> />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>
                                        สถานะเอกสาร
                                    </label>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <input type="checkbox" class="chk-docstatus" onchange="getListDocStatus();" name="chkWaiting" value="WAITING" <?php echo in_array("'WAITING'", $arrDocStatus) || empty($DocStatus) ? 'checked="checked"' : '' ?> />
                                    &nbsp;รอชำระเงิน 
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <input type="checkbox" class="chk-docstatus" onchange="getListDocStatus();" name="chkCheckPaid" value="CHECKPAID" <?php echo in_array("'CHECKPAID'", $arrDocStatus) || empty($DocStatus) ? 'checked="checked"' : '' ?> />
                                    &nbsp;รอตรวจสอบการชำระเงิน 
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <input type="checkbox" class="chk-docstatus" onchange="getListDocStatus();" name="chkPaid" value="PAID" <?php echo in_array("'PAID'", $arrDocStatus) || empty($DocStatus) ? 'checked="checked"' : '' ?> />
                                    &nbsp;ชำระเงินแล้วรอการจัดส่ง 
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <input type="checkbox" class="chk-docstatus" onchange="getListDocStatus();" name="chkSuccess" value="SUCCESS" <?php echo in_array("'SUCCESS'", $arrDocStatus) || empty($DocStatus) ? 'checked="checked"' : '' ?> />
                                    &nbsp;จัดส่งเรียบร้อยแล้ว 
                                </div>
                            </div>
                            <div class="row">
                                <input type="hidden" name="hddListDocStatus" value="<?php echo $DocStatus; ?>" />
                                <input type="hidden" name="hddListMat" value="<?php echo $MatCode; ?>" />
                                <script>
                                    function checkEditYear(obj) {
                                        var val = $(obj).val();
                                        
                                        if (val == "m") {
                                            //$("[name='txtYear']").val("<?php echo empty($Year) ? $currentYear : $Year ?>");
                                            $("[name='txtYear']").prop("disabled", false);
                                        } else {
                                            //$("[name='txtYear']").val("");
                                            $("[name='txtYear']").prop("disabled", true);
                                        }
                                    }

                                    function getListDocStatus() {
                                        var docstatus = [];
                                        var IsAll = true;

                                        $(".chk-docstatus").each(function () {
                                            if ($(this).prop("checked")) {
                                                docstatus.push(this.value);
                                            } else {
                                                IsAll = false;
                                            }
                                        });

                                        if (IsAll) {
                                            $("[name='hddListDocStatus']").val("");
                                        } else {
                                            $("[name='hddListDocStatus']").val("'" + docstatus.join("','") + "'");
                                        }
                                    }

                                    function getListMat() {
                                        var mat = [];
                                        var IsAll = true;

                                        $(".chk-mat").each(function () {
                                            if ($(this).prop("checked")) {
                                                mat.push(this.value);
                                            } else {
                                                IsAll = false;
                                            }
                                        });

                                        if (IsAll) {
                                            $("[name='hddListMat']").val("");
                                        } else {
                                            $("[name='hddListMat']").val("'" + mat.join("','") + "'");
                                        }
                                    }
                                </script>

                                <div class="col-md-12">
                                    <label>
                                        รายการสินค้า
                                    </label>
                                    <div style="max-height: calc(100vh - 530px); overflow: auto;">
                                        <table class="table  table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>รหัสสินค้า</th>
                                                    <th>ชื่อสินค้า</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "select * from product where active = 1 order by ProductName asc";
                                                $datas = SelectRows($sql);
                                                foreach ($datas as $data) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="chkMatSelect" class="chk-mat" onchange="getListMat();" value="<?php echo $data["ProductCode"] ?>"
                                                            <?php echo in_array("'".$data["ProductCode"]."'", $arrMatCode) || empty($MatCode) ? 'checked="checked"' : '' ?> />
                                                    </td>
                                                    <td>
                                                        <?php echo $data["ProductCode"] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data["ProductName"] ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 0;">
                                <div class="col-md-12">
                                    <input type="submit" name="btnApply" value="Apply" class="btn btn-success" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <canvas id="canvas"></canvas>

                        <?php
                        $dataReportTitle = "";
                        $dataReportItem = [];
                        $dataReportValue = [];
                        if ($Type == "m")
                        {
                            $dataReportTitle = "รายเดือน ปี ".$Year;
                            for ($i = 0; $i < count($MonthsArr); $i++)
                            {
                               foreach ($datasReportArray as $datasReport)
                               {
                                   if ($datasReport["xMonth"] == $i + 1)
                                   {
                                   	    $MonthsArr[$i] = $MonthsArr[$i].",".$datasReport["xTotal"];
                                   }
                               }
                            }
                            
                            for ($i = 0; $i < count($MonthsArr); $i++)
                            {
                                array_push($dataReportItem, explode(",", $MonthsArr[$i])[0]);
                                array_push($dataReportValue, (empty(explode(",", $MonthsArr[$i])[1]) ? "0" : explode(",", $MonthsArr[$i])[1]));
                            }
                        }
                        else
                        {
                            $dataReportTitle = "รายปี ".$Year;
                            
                            $YearArr = [];
                            foreach ($datasReportArray as $datasReport)
                            {
                                array_push($YearArr, $datasReport["xYear"].",".$datasReport["xTotal"]);
                            }
                            
                            for ($i = 0; $i < count($YearArr); $i++)
                            {
                                array_push($dataReportItem, explode(",", $YearArr[$i])[0]);
                                array_push($dataReportValue, (empty(explode(",", $YearArr[$i])[1]) ? "0" : explode(",", $YearArr[$i])[1]));
                            }
                        }
                        
                        
                        ?>
                        <!--print-->
                        <script>
                            function PrintElem(elem) {
                                var mywindow = window.open('', 'PRINT', 'height=400,width=600');

                                mywindow.document.write('<html><head><title>' + document.title + '</title>');
                                mywindow.document.write('</head><body >');
                                mywindow.document.write('<h1>' + document.title + '</h1>');
                                mywindow.document.write(document.getElementById(elem).innerHTML);
                                mywindow.document.write('</body></html>');

                                mywindow.document.close(); // necessary for IE >= 10
                                mywindow.focus(); // necessary for IE >= 10*/

                                mywindow.print();
                                mywindow.close();

                                return true;
                            }
                            
                        </script>
                        <!--chart-->
                        <script>
                            var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                            var color = Chart.helpers.color;
                            var barChartData = {
                                labels: [<?php echo "'".join("', '",$dataReportItem)."'"; ?>],
                                datasets: [{
                                    label: '<?php echo $dataReportTitle ?>',
                                    backgroundColor: color(window.chartColors.green).alpha(0.5).rgbString(),
                                    borderColor: window.chartColors.green,
                                    borderWidth: 1,
                                    data: [<?php echo join(", ",$dataReportValue); ?>]
                                }]

                            };

                            window.onload = function () {
                                var ctx = document.getElementById('canvas').getContext('2d');
                                window.myBar = new Chart(ctx, {
                                    type: 'bar',
                                    data: barChartData,
                                    options: {
                                        responsive: true,
                                        legend: {
                                            position: 'top',
                                        },
                                        title: {
                                            display: false,
                                            text: '<?php echo $dataReportTitle ?>'
                                        }
                                    }
                                    //, options: {
                                    //    animation: {
                                    //        onComplete: function () {                
                                    //            window.JSREPORT_READY_TO_START = true
                                    //        }
                                    //    }
                                    //}
                                });

                            };

                            // document.getElementById('randomizeData').addEventListener('click', function () {
                            //     var zero = Math.random() < 0.2 ? true : false;
                            //     barChartData.datasets.forEach(function (dataset) {
                            //         dataset.data = dataset.data.map(function () {
                            //             return zero ? 0.0 : randomScalingFactor();
                            //         });

                            //     });
                            //     window.myBar.update();
                            // });

                            var colorNames = Object.keys(window.chartColors);
	                    </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include  $_SERVER['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>