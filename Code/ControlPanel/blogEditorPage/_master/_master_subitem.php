
<?php include_once  "../_master/_master.php"; ?>
<?php 

$uploadFileTarget =  $GLOBALS["ROOT"]."/_content_images/".strtolower($_COG_ITEM_CODE)."/feedback/";

$refCode = !empty($_GET["ref"]) ? $_GET["ref"] : $_COG_ITEM_CODE;
if(isset($_POST["btnDeleteRow"])){
    $sqlDelete = "delete from portfolio_item where ItemCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sqlDelete);
}

if(isset($_POST["btnUpdateSubItem"])){
    $IS_EDIT = !empty($_POST["txtItemCode"]);
    $txtItemCode = !empty($_POST["txtItemCode"]) ? $_POST["txtItemCode"] : GenerateNextID("portfolio_item","ItemCode",10,"I");
    $txtItemName = $_POST["txtItemName"];
    $txtItemDetail = $_POST["txtItemDetail"];
    $chkItemActive = $_POST["chkItemActive"] ? 1 : 0;
    
    if($IS_EDIT){
        $sql = "update portfolio_item set 
         ItemName='$txtItemName'
        ,ItemDetail='$txtItemDetail'
        ,Active=$chkItemActive
        WHERE ItemCode='$txtItemCode' ";
        ExecuteSQL($sql);
    }else{
        
        $sql = "insert into portfolio_item(ItemCode,PortCode,ItemName,ItemDetail,SEQ,Active)
         VALUES (
                '$txtItemCode',
                '$refCode',
                '$txtItemName',
                '".str_replace("'","''",$txtItemDetail)."',
                (select IFNULL(max(a.SEQ),0)+1 from portfolio_item a where a.PortCode='$refCode'),
                $chkItemActive
                )";
        ExecuteSQL($sql);
    }
    AlertSuccessRedirect("สำเร็จ","บันทึกรายการ","itemSubDetail.php?ref=".$_GET["ref"]);
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
    <span class="link-history-btn">รายการย่อย <?php echo $_COG_ITEM_NAME ?></span>
</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
        <div class="col-md-12">
            <div>
                <a href="javascript:_load_data_detail('');" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการ<?php echo $_COG_ITEM_NAME ?>
                </a>
                <span><b>รายการ<?php echo $_COG_ITEM_NAME ?> <span class="text-orange"><?php echo $data["PortName"]." (รายการย่อย)" ?></span></b></span>
                <hr style="margin-top: 5px;" />
                <table 
                    data-sortable-table="portfolio_item"
                    data-sortable-column-seq="SEQ"
                    data-sortable-column-key="concat(ItemCode,'-',PortCode)"
                    class="jquery-datatable sortable-table table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:10px;">#</th>
                            <th>หัวข้อ</th>
                            <th style="width:50px;" class="text-center">ใช้งาน</th>
                            <th style="width:100px;" class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="text-center">#</th>
                            <th>หัวข้อ</th>
                            <th style="width:50px;" class="text-center">ใช้งาน</th>
                            <th style="width:100px;" class="text-center">จัดการ</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $sql = "select r.* from portfolio_item r
                        where r.PortCode = '".$refCode."' order by r.SEQ,r.ItemCode";
                        $datas = SelectRows($sql);
                        $inx = 1;
                        foreach ($datas as $data) {
                        ?>
                        <tr data-sortable-row-key="<?php echo $data["ItemCode"]."-".$data["PortCode"] ?>">
                            <td class="text-center"><?php echo $inx++; ?></td>
                            <td>
                                <?php echo $data["ItemName"] ?>
                            </td>
                            <td class="text-center sortable-hide-item">
                                <?php echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                            </td>
                            <td class="text-center sortable-hide-item">
                                <a title="แก้ไขข้อมูล" href="Javascript:_load_data_detail('<?php echo $data["ItemCode"] ?>');">
                                    <i class="fa fa-cog"></i>
                                </a>
                                <form method="post" style="display:inline">
                                    <button type="submit" class="btn-link" 
                                        onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                        value="<?php echo $data["ItemCode"] ?>" name="btnDeleteRow">
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

<div id="modal-update-subitem" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">รายละเอียดรายการย่อย</h4>
                </div>
                <div class="modal-body">
                   <div id="panel-subitem-detail">

                   </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="btnUpdateSubItem">บันทึก</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function _load_data_detail(code)
    {
        AlertLoading(true,"โหลดข้อมูล");
        $("#panel-subitem-detail").load("../_master/_load_SubItemDetail.php?ref="+code,function(){
            $("#modal-update-subitem").modal('show');
            AlertLoading(false);
        });
    }
</script>

<?php include  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>