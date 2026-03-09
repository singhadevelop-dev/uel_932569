<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>
<?php 

if(isset($_POST["btnSave"])){

    $startPrice = doubleval(str_replace(",","",$_POST["txtStartPrice"]));
    $endPrice = doubleval(str_replace(",","",$_POST["txtEndPrice"]));

    $sql = "";
    if(empty($_POST["btnSave"])){
        $genID = GenerateNextID("product_price","PriceCode",5,"R");
        $sql = "insert into product_price (PriceCode,StartPrice,EndPrice,CreatedOn,CreatedBy) values(
                '$genID'
                ,'$startPrice'
                ,'$endPrice'
                ,NOW()
                ,'".UserService::UserCode()."'
            );
        ";
    }else{
        $sql = "update product_price set
                 StartPrice = '$startPrice'
                ,EndPrice = '$endPrice'
                where PriceCode = '".$_POST["btnSave"]."'
        ";
    }
    
    ExecuteSQLTransaction($sql,"productPrice.php");
}
if(isset($_POST["btnDeleteRow"])){
    $sql = "delete from product_price where PriceCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
}
?>
<style>
    .img-icon{
        width: 20px;
        height: 20px;
        object-fit: fill;
    }
</style>
<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล</a>
    /
    <span class="link-history-btn">รายการช่วงราคา</span>



</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
        <div class="col-md-2">
            <?php 
            $_LEFT_MENU_ACTIVE = "PRICE";
            include "leftMenu.php"; 
            ?>
        </div>
        <div class="col-md-10">
            <div>
                <a href="javascript:void(0);" onclick="openPrice('','0.00','0.00');" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการ
                </a>
                <span><b>รายการช่วงราคา</b></span>
                <hr style="margin-top: 5px;" />
            </div>

            
            <table 
                class="jquery-datatable table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th class="text-right">ราคาเริ่ม</th>
                        <th class="text-right">ราคาสิ้นสุด</th>
                        <th style="width:50px;" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th class="text-right">ราคาเริ่ม</th>
                        <th class="text-right">ราคาสิ้นสุด</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    
                    $sql = "select * from product_price order by StartPrice asc, EndPrice asc";
                    $datas = SelectRows($sql);
                    $inx = 1;
                    foreach ($datas as $data) {
                    ?>
                    <tr>
                        <td><?php echo $inx++; ?></td>
                        <td class="text-right">
                            <?php echo number_format($data["StartPrice"],2) ?>
                        </td>
                        <td class="text-right">
                            <?php echo number_format($data["EndPrice"],2) ?>
                        </td>
                        <td class="text-center">
                            <a href="javascript:void(0);" onclick="openPrice('<?php echo $data["PriceCode"] ?>','<?php echo $data["StartPrice"] ?>','<?php echo $data["EndPrice"] ?>');">
                                <i class="fa fa-cog"></i>
                            </a>
                            <form method="post" style="display:inline">
                                <button type="submit" class="btn-link" 
                                    onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                    value="<?php echo $data["PriceCode"] ?>" name="btnDeleteRow">
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

<script>
    function openPrice(code,start,end){
        $("[name='txtStartPrice']").val(ConvertFormatNumber(start,2));
        $("[name='txtEndPrice']").val(ConvertFormatNumber(end,2));
        $("[name='btnSave']").val(code);
        $("#modelmaster-price").modal('show');
    }
</script>
<div id="modelmaster-price" class="modal" data-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form class="modal-content" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">อัพเดตข้อมูล</h5>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
                <label>ราคาเริ่ม</label>
                <input type="text" onkeypress='IsKeyNumber(event)' onchange="IsFormatNumber(this,2);" placeholder="ราคา..." name="txtStartPrice" id="txtStartPrice" value="<?php echo number_format($data["StartPrice"],2) ?>"  class="form-control text-right require" />
            </div>
            <div class="col-sm-4">
                <label>ถึง</label>
                <input type="text" onkeypress='IsKeyNumber(event)' onchange="IsFormatNumber(this,2);" placeholder="ราคา..." name="txtEndPrice" id="txtEndPrice" value="<?php echo number_format($data["EndPrice"],2) ?>"  class="form-control text-right require" />
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="btnSave" class="btn btn-success" onclick="return validateSave(this);">
            <i class="fa fa-save"></i>
            บันทึก
        </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </form>
  </div>
</div>

<?php include  "../footer.php"; ?>