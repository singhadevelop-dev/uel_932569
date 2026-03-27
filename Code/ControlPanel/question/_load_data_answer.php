
<?php 
    include_once "../../_cogs.php";
    include_once  "../assets/b4w-framework/UtilService.php"; 

    $questionCode = $_POST["ref"];
    $sql = "
        select a.*
            ,b.ImageName as ObjectiveName
            ,c.ImageName as GenderName
            ,d.ImageName as ColorName
            ,e.ImageName as HobbyName
            ,f.ImageName as StyleName
            ,g.ImageName as MaterialName
            ,h.ImageName as RoomName
            ,i.ImageName as TravelName
            ,j.PortName as BudgetName
            ,k.PortName as ProcessName
            ,l.ImageName as Nice2MeetName
        from question a
        left join gallery b on b.RefCode='QUESTION01' and a.Objective = b.ImageCode
        left join gallery c on c.RefCode='QUESTION02' and a.Gender = c.ImageCode
        left join gallery d on d.RefCode='QUESTION03' and a.Color = d.ImageCode
        left join gallery e on e.RefCode='QUESTION04' and a.Hobby = e.ImageCode
        left join gallery f on f.RefCode='QUESTION05' and a.Style = f.ImageCode
        left join gallery g on g.RefCode='QUESTION06' and a.Material = g.ImageCode
        left join gallery h on h.RefCode='QUESTION07' and a.Room = h.ImageCode
        left join gallery i on i.RefCode='QUESTION10' and a.Travel = i.ImageCode
        left join portfolio j on j.PortType='BUDGET' and a.Budget = j.PortCode
        left join portfolio k on k.PortType='DEADLINE' and a.Process = k.PortCode
        left join gallery l on l.RefCode='QUESTION14' and a.Nice2Meet = l.ImageCode
        where a.QuestionCode='$questionCode'
    ";
    $data = SelectRow($sql);

    $sql = "
        select a.ItemType,a.ItemCode,a.ItemValue
        ,b.ImageName as ItemName
        ,b.ImagePath
        from question_item a
        left join gallery b on a.ItemCode = b.ImageCode
        where a.QuestionCode='$questionCode'
        order by a.ItemType,a.ItemValue
    ";
    $items = SelectRowsArray($sql);
    $_ITEMS = array();
    foreach ($items as $item) {
        if(!isset($_ITEMS[$item["ItemType"]])){
            $_ITEMS[$item["ItemType"]] = array();
        }
        array_push($_ITEMS[$item["ItemType"]],$item);
    }
?>
<style>
    .image-answer{
        width: 100%;
        height: 250px;
        object-fit: cover;
    }
    <?php if($data["Picked"] == 1){ ?>
        button[name='btnPicked']{
            display: none;
        }
<?php } ?>
</style>

<div class="row">
    <div class="col-md-4">(1) วัตถุประสงค์ในการตกแต่งห้องของคุณคือ</div>
    <div class="col-md-8"><b><?php echo $data["ObjectiveName"] ?></b></div>
</div>
<div class="row">
    <div class="col-md-4">(2.1) เพศ</div>
    <div class="col-md-8"><b><?php echo $data["GenderName"] ?></b></div>
</div>
<div class="row">
    <div class="col-md-4">(2.2) อายุ</div>
    <div class="col-md-8"><b><?php echo $data["Age"] ?></b></div>
</div>
<div class="row">
    <div class="col-md-4">(3) คุณชอบโทนสีไหนมากที่สุด</div>
    <div class="col-md-8"><b><?php echo $data["ColorName"] ?></b></div>
</div>
<div class="row">
    <div class="col-md-4">(4) งานอดิเรกของคุณคืออะไร</div>
    <div class="col-md-8"><b><?php echo $data["HobbyName"] ?></b></div>
</div>
<div class="row">
    <div class="col-md-4">(5) คุณชอบตกแต่งบ้านสไตล์ไหนมากที่สุด</div>
    <div class="col-md-8"><b><?php echo $data["StyleName"] ?></b></div>
</div>
<div class="row">
    <div class="col-md-4">(6) คุณชอบวัสดุไหนมากที่สุด</div>
    <div class="col-md-8"><b><?php echo $data["MaterialName"] ?></b></div>
</div>
<div class="row">
    <div class="col-md-4">(7) คุณให้ความสำคัญกับห้องไหนมากที่สุด</div>
    <div class="col-md-8"><b><?php echo $data["RoomName"] ?></b></div>
</div>
<div class="row">
    <div class="col-md-12">(8) ปัจจัยในการตัดสินใจ เรียงลำดับจากมากไปน้อย</div>
    <div class="col-md-12">
        <div class="row">
            <?php 
                foreach ($_ITEMS["DECISION"] as $item) {
            ?>
            <div class="col-md-3">
                <img src="<?php echo $item["ImagePath"] ?>" alt="" class="image-answer">
                <div class="text-center">
                    <label class="text-orange one-line" title="<?php echo "(".$item["ItemValue"].")".$item["ItemName"] ?>">(<?php echo $item["ItemValue"] ?>) <?php echo $item["ItemName"] ?></label>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">(9) คุณให้ความสำคัญกับเรื่องใดมากที่สุด</div>
    <div class="col-md-12">
        <div class="row">
            <?php 
                foreach ($_ITEMS["PRIORITY"] as $item) {
            ?>
            <div class="col-md-3">
                <img src="<?php echo $item["ImagePath"] ?>" alt="" class="image-answer">
                <div class="text-center">
                    <label class="text-orange one-line" title="<?php echo "(".$item["ItemValue"].")".$item["ItemName"] ?>">(<?php echo $item["ItemValue"] ?>) <?php echo $item["ItemName"] ?></label>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">(10) คุณชอบเที่ยวที่ไหน</div>
    <div class="col-md-8"><b><?php echo $data["TravelName"] ?></b></div>
</div>
<div class="row">
    <div class="col-md-4">(11) ห้องคุณมีพื้นที่เท่าไร</div>
    <div class="col-md-8"><b><?php echo $data["Area"] ?></b> ตารางเมตร</div>
</div>
<div class="row">
    <div class="col-md-4">(12) คุณมีงบในการออกแบบเท่าไร</div>
    <div class="col-md-8"><b><?php echo $data["BudgetName"] ?></b></div>
</div>
<div class="row">
    <div class="col-md-4">(13) คุณต้องการให้กระบวนการทั้งหมดเสร็จภายในกี่วัน</div>
    <div class="col-md-8"><b><?php echo $data["ProcessName"] ?></b></div>
</div>
<div class="row">
    <div class="col-md-4">(14) Nice to meet you</div>
    <div class="col-md-8"><b><?php echo $data["Nice2MeetName"] ?></b></div>
</div>
<input type="hidden" name="hdfQuestionCode" value="<?php echo $questionCode ?>">
