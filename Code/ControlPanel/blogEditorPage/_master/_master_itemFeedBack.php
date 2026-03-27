
<?php include_once  "../_master/_master.php"; ?>
<?php 

$uploadFileTarget =  $GLOBALS["ROOT"]."/_content_images/".strtolower($_COG_ITEM_CODE)."/feedback/";

$refCode = !empty($_GET["ref"]) ? $_GET["ref"] : $_COG_ITEM_CODE;
if(isset($_POST["btnDeleteRow"])){
    $sqlDelete = "delete from review where ReviewCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sqlDelete);
    $filePath = $_POST["hddFilePath"];
    unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
}

if(isset($_POST["btnUpdateFeedBack"])){
    $IS_EDIT = !empty($_POST["txtReviewCode"]);
    $txtReviewCode = !empty($_POST["txtReviewCode"]) ? $_POST["txtReviewCode"] : GenerateNextID("review","ReviewCode",10,"R");
    $txtReviewName = $_POST["txtReviewName"];
    $txtReviewPosition = $_POST["txtReviewPosition"];
    $txtReviewMessage = $_POST["txtReviewMessage"];
    $txtReviewRank = intval($_POST["txtReviewRank"]);
    
    $chkReviewActive = $_POST["chkReviewActive"] ? 1 : 0;
    $uploadFileTarget =  $GLOBALS["ROOT"]."/_content_images/review/";
    $fileUploaded = $_FILES["fileUploadChange"];
    if(!empty($fileUploaded["name"])){
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUploadChange"],$uploadFileTarget,$txtReviewCode);
        $fileUploadedPath = parse_url( $fileUploadedPath, PHP_URL_PATH)."?vs=".GetCurrentStringDateTimeServer();
    }else{
        $fileUploadedPath = $_POST["hddBackUpImageChange"];
    }
    if($IS_EDIT){
        $sql = "update review set 
         ByName='$txtReviewName'
        ,Rating=$txtReviewRank
        ,Message='$txtReviewMessage'
        ,Image='$fileUploadedPath'
        ,Position='$txtReviewPosition'
        ,Active=$chkReviewActive
        ,UpdatedOn=Now()
        ,UpdatedBy='".UserService::UserCode()."'
        WHERE ReviewCode='$txtReviewCode' ";
        ExecuteSQL($sql);
    }else{
        
        $sql = "insert into review(ReviewCode,RefCode,ByName,Rating,Message,Image,Position,SEQ,Active,CreatedOn,CreatedBy)
         VALUES (
                '$txtReviewCode',
                '$refCode',
                '$txtReviewName',
                 $txtReviewRank,
                '$txtReviewMessage',
                '$fileUploadedPath',
                '$txtReviewPosition',
                (select IFNULL(max(a.SEQ),0)+1 from review a where a.RefCode='$refCode'),
                $chkReviewActive,
                Now(),
                '".UserService::UserCode()."')";
        ExecuteSQL($sql);
    }
}

if(!empty($refCode)){
    $sqlPrd = "select * from portfolio where PortCode = '$refCode'";
    $data = SelectRow($sqlPrd);
}

?>
<div class="mat-box grey-bar">
    <?php if($_COG_ALLOW_LEFT_MENU || $_COG_ALLOW_LEFT_MENU_ITEMS){  ?>
    <a href="<?php echo $_COG_ALLOW_LEFT_MENU_ITEMS ? "item.php" : "masterDetail.php"  ?>" class="link-history-btn">หน้าหลัก<?php echo $_COG_ITEM_NAME ?></a>
    <?php if($_COG_ALLOW_LEFT_MENU_ITEMS){  ?>
    /
    <a href="item.php" class="link-history-btn">รายการ<?php echo $_COG_ITEM_NAME ?></a>
    <?php } ?>
    /
    <?php } ?>
    <span class="link-history-btn">ผลตอบรับ <?php echo $_COG_ITEM_NAME ?></span>
</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
        <?php if($_COG_ALLOW_LEFT_MENU){ ?>
        <div class="col-md-2">
            <?php include_once  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/blogEditorPage/_master/_master_leftMenu.php"; ?>
        </div>
        <?php } ?>
        <div class="col-md-<?php echo $_COG_ALLOW_LEFT_MENU ? "10" : "12" ?>">
            <div>
                <a href="javascript:_load_feedback_detail('');" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการ<?php echo $_COG_ITEM_NAME ?>
                </a>
                <span><b>รายการ<?php echo $_COG_ITEM_NAME ?> <span class="text-orange"><?php echo $data["PortName"]." (ผลตอบรับ)" ?></span></b></span>
                <hr style="margin-top: 5px;" />
                <table 
                    data-sortable-table="review"
                    data-sortable-column-seq="SEQ"
                    data-sortable-column-key="concat(ReviewCode,'-',RefCode)"
                    class="jquery-datatable sortable-table table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:10px;">#</th>
                            <th>ชื่อ</th>
                            <?php if($_COG_REVIEW_STAR){ ?>
                            <th>ตำแหน่ง</th>
                            <?php } ?>
                            <th><?php echo $_COG_REVIEW_STAR ? "คะแนน" : "ข้อความ" ?></th>
                            <th style="width:50px;" class="text-center">ใช้งาน</th>
                            <th style="width:100px;" class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="text-center">#</th>
                            <th>ชื่อ</th>
                            <?php if($_COG_REVIEW_STAR){ ?>
                            <th>ตำแหน่ง</th>
                            <?php } ?>
                            <th><?php echo $_COG_REVIEW_STAR ? "คะแนน" : "ข้อความ" ?></th>
                            <th style="width:50px;" class="text-center">ใช้งาน</th>
                            <th style="width:100px;" class="text-center">จัดการ</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $sql = "select r.* from review r
                        where r.RefCode = '".$refCode."' order by r.SEQ,r.ReviewCode";
                        $datas = SelectRows($sql);
                        $inx = 1;
                        foreach ($datas as $data) {
                        ?>
                        <tr data-sortable-row-key="<?php echo $data["ReviewCode"]."-".$data["RefCode"] ?>">
                            <td class="text-center"><?php echo $inx++; ?></td>
                            <td>
                                <?php echo $data["ByName"] ?>
                            </td>
                            <?php if($_COG_REVIEW_STAR){ ?>
                            <td>
                                <?php echo $data["Position"] ?>
                            </td>
                            <?php } ?>
                            <?php if($_COG_REVIEW_STAR){ ?>
                            <td>
                                <?php
                                    $rating = intval($data["Rating"]);
                                    for ($i=1; $i <= 5 ; $i++) { 
                                ?>
                                    <i class="fa fa-star<?php echo $rating >= $i ? "" : "-o"; ?> text-danger" aria-hidden="true"></i>
                                <?php } ?>
                            </td>
                            <?php }else{ ?>
                                <td style="width: 50%;">
                                    <div><?php echo ConvertNewLine($data["Message"]) ?></div>
                                </td>
                            <?php } ?>
                            <td class="text-center sortable-hide-item">
                                <?php echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                            </td>
                            <td class="text-center sortable-hide-item">
                                <a title="แก้ไขข้อมูล" href="Javascript:_load_feedback_detail('<?php echo $data["ReviewCode"] ?>');">
                                    <i class="fa fa-cog"></i>
                                </a>
                                <form method="post" style="display:inline">
                                    <button type="submit" class="btn-link" 
                                        onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                        value="<?php echo $data["ReviewCode"] ?>" name="btnDeleteRow">
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

<form method="post" class="hide">
    <textarea id="txtSortable" name="txtSortable">[]</textarea>
    <input type="submit" id="btnSortable" name="btnSortable" value="" />
</form>

<div id="modal-update-feedback" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">รายละเอียดผลตอบรับ</h4>
                </div>
                <div class="modal-body">
                   <div id="panel-feedback-detail">

                   </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="btnUpdateFeedBack">บันทึก</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function _load_feedback_detail(reviewCode)
    {
        AlertLoading(true,"โหลดข้อมูล");
        $("#panel-feedback-detail").load("../_master/_load_itemFeedback.php?ref="+reviewCode+"&cstar=<?php echo $_COG_REVIEW_STAR ?>"+"&cposition=<?php echo $_COG_REVIEW_POSITION ?>",function(){
            $("#modal-update-feedback").modal('show');
            AlertLoading(false);
        });
    }
</script>

<?php include  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>