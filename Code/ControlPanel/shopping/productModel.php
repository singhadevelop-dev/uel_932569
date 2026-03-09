<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>

<?php 

if(isset($_POST["btnDeleteRow"])){
    $sql = "delete from product_model where ModelCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
    
    $sql = "update product set ModelCode = '',ModelCode = '' where ModelCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
}

?>



<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">รายการรุ่น<?php echo $_COG_ITEM_NAME ?></span>

</div>


<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
       <div class="col-md-3">
            <?php 
            $_LEFT_MENU_ACTIVE = "MODEL";
            include "leftMenu.php";
            ?>
        </div>
        <div class="col-md-9">
            <div>
                <a href="productModelDetail.php" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการรุ่น<?php echo $_COG_ITEM_NAME ?>
                </a>
                <span><b>รายการรุ่น<?php echo $_COG_ITEM_NAME ?></b></span>
                <hr style="margin-top: 5px;" />
            </div>

            

            <table class="jquery-datatable display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="width:50px;">รหัส</th>
                        <th>ชื่อรุ่น<?php echo $_COG_ITEM_NAME ?></th>
                        <th>ยี่ห้อ<?php echo $_COG_ITEM_NAME ?></th>
                        <th style="width:50px;" class="text-center">ใช้งาน</th>
                        <th style="width:50px;" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>รหัส</th>
                        <th>ชื่อรุ่น<?php echo $_COG_ITEM_NAME ?></th>
                        <th>ยี่ห้อ<?php echo $_COG_ITEM_NAME ?></th>
                        <th class="text-center">ใช้งาน</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    
                    $sql = "select m.*,b.BrandName from product_model m , product_brand b 
                    where b.BrandCode = m.BrandCode 
                    order by m.ModelCode";
                    $datas = SelectRows($sql);
                    foreach ($datas as $data) {
                    ?>
                    <tr>
                        <td><?php echo $data["ModelCode"] ?></td>
                        <td>
                        
                        <?php echo $data["ModelName"] ?>

                        </td>
                        <td>
                        
                        <?php echo $data["BrandName"] ?>

                        </td>
                        <td class="text-center">
                            <?php echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                        </td>
                        <td class="text-center">
                            <a href="productModelDetail.php?ref=<?php echo $data["ModelCode"] ?>">
                                <i class="fa fa-cog"></i>
                            </a>

                            <form method="post" style="display:inline">
                                <button type="submit" class="btn-link" 
                                    onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                    value="<?php echo $data["ModelCode"] ?>" name="btnDeleteRow">
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


<?php include  "../footer.php"; ?>