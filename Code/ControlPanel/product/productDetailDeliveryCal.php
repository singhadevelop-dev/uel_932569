<?php include_once realpath(__DIR__ . '/../..') . "/_cogs.php";
include  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/UtilService.php"; ?>


<label class="text-primary">จำลองการคำนวณราคาค่าจัดส่ง (คำนวณ 1 หน่วย)</label>
<?php

$sql = "select *
from delivery_category d
where d.Active = 1
order by Name";
$datas = SelectRowsArray($sql);

?>
<style>
    .table th,
    .table td {
        vertical-align: middle !important;
        padding: 3px 5px !important;
    }
</style>
<table class="table table-striped" style="background: #fff">
    <thead class="text-center" style="background: rgba(255,128,0,0.8);color:#fff">
        <tr>
            <th rowspan="2">การจัดส่ง</th>
            <!-- <th rowspan="2" class="text-center">น้ำหนักสูงสุด (กรัม)</th> -->
            <th colspan="3" class="text-center">ราคาค่าจัดส่ง (บาท)</th>
            <th rowspan="2"></th>
        </tr>
        <tr>
            <th>
                ในกรุงเทพมหานคร
            </th>
            <th>
                ในต่างจังหวัด (จังหวัดเดียวกัน)
            </th>
            <th>
                ข้ามจังหวัด
            </th>
        </tr>
    </thead>

    <?php
    foreach ($datas as $data) {
        $sql = "select * from delivery_price where Code ='".$data["Code"]."' 
        and ".doubleval($_GET["w"])." <= weight order by weight limit 1";
        $price = SelectRow($sql);

        if($price === false){
            $sql = "select * from delivery_price where Code ='".$data["Code"]."' 
             order by weight desc limit 1";
            $price = SelectRow($sql);
        }
    ?>
        <tr>
            <th>
                <?php echo $data["Name"] ?>
            </th>
            <!-- <td class="text-center">
                <?php echo number_format($price["weight"]) ?>
            </td> -->
            <td class="text-center">
                <?php echo number_format($price["BKK"]) ?>
            </td>
            <td class="text-center">
                <?php echo number_format($price["PROVINCE_SAME"]) ?>
            </td>
            <td class="text-center">
                <?php echo number_format($price["PROVINCE_DIFF"]) ?>
            </td>
        </tr>
    <?php
    }
    ?>

</table>