<?php include_once  "../_master/_master.php"; ?>

<?php 

if(isset($_POST["btnDeleteRow"])){
    $sql = "delete from product_sub_category where SubCategoryCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
    
    $sql = "update portfolio set SubCategoryCode = '' where SubCategoryCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
}

?>



<div class="mat-box grey-bar">

    <a href="item.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">รายการ<?php echo $_COG_ITEM_NAME ?>ย่อย</span>

</div>


<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
       <div class="col-md-2">
            <?php include_once  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/blogEditorPage/_master/_master_leftMenu.php"; ?>
        </div>
        <div class="col-md-10">
            <div>
                <a href="itemSubCategoryDetail.php" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการหมวดหมู่<?php echo $_COG_ITEM_NAME ?>ย่อย
                </a>
                <span><b>รายการหมวดหมู่<?php echo $_COG_ITEM_NAME ?>ย่อย</b></span>
                <hr style="margin-top: 5px;" />
            </div>
       
            <table 
                data-sortable-table="product_sub_category"
                data-sortable-column-seq="SEQ"
                data-sortable-column-key="SubCategoryCode"
                class="jquery-datatable sortable-table table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width:50px;">รหัส</th>
                        <th>ชื่อรายการย่อย</th>
                        <th>หมวดหมู่</th>
                        <th style="width:50px;" class="text-center">ใช้งาน</th>
                        <th style="width:50px;" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>รหัส</th>
                        <th>ชื่อรายการย่อย</th>
                        <th>หมวดหมู่</th>
                        <th class="text-center">ใช้งาน</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    
                    $sql = "select m.*,b.CategoryName 
                    from product_sub_category m 
                    inner join product_category b on b.CategoryCode = m.CategoryCode 
                    where b.CategoryGroup='$_COG_ITEM_CODE'
                    order by m.SEQ, m.SubCategoryCode";
                    $datas = SelectRows($sql);
                    foreach($datas as $data){
                    ?>
                    <tr data-sortable-row-key="<?php echo $data["SubCategoryCode"] ?>">
                        <td><?php echo $data["SubCategoryCode"] ?></td>
                        <td>
                        
                        <?php echo $data["SubCategoryName"] ?>

                        </td>
                        <td>
                        
                        <?php echo $data["CategoryName"] ?>

                        </td>
                        <td class="text-center sortable-hide-item">
                            <?php echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                        </td>
                        <td class="text-center sortable-hide-item">
                            <a href="itemSubCategoryDetail.php?ref=<?php echo $data["SubCategoryCode"] ?>">
                                <i class="fa fa-cog"></i>
                            </a>

                            <form method="post" style="display:inline">
                                <button type="submit" class="btn-link" 
                                    onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                    value="<?php echo $data["SubCategoryCode"] ?>" name="btnDeleteRow">
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

<?php include  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>