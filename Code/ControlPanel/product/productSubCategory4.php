<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>

<?php 

if(isset($_POST["btnDeleteRow"])){
    $sql = "delete from product_sub_category4 where SubCategoryCode4 = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
    
    $sql = "update product set SubCategoryCode4 = '' where SubCategoryCode4 = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);

}

?>



<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">รายการหมวดหมู่<?php echo $_COG_ITEM_NAME ?> ที่ 4</span>

</div>


<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
       <div class="col-md-3">
            <?php 
            $_LEFT_MENU_ACTIVE = "SUBCATEGORY4";
            include "leftMenu.php"; 
            ?>
        </div>
        <div class="col-md-9">
            <div>
                <a href="productSubCategoryDetail4.php" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการหมวดหมู่<?php echo $_COG_ITEM_NAME ?> ย่อยที่ 4
                </a>
                <span><b>รายการหมวดหมู่<?php echo $_COG_ITEM_NAME ?> ย่อยที่ 4</b></span>
                <hr style="margin-top: 5px;" />
            </div>

            

            <table 
                data-sortable-table="product_sub_category4"
                data-sortable-column-seq="SEQ"
                data-sortable-column-key="SubCategoryCode4"
                class="jquery-datatable sortable-table table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width:50px;">รหัส</th>
                        <th>หมวดหมู่ย่อยที่ 4</th>
                        <th>หมวดหมู่ย่อยที่ 3</th>
                        <th>หมวดหมู่ย่อยที่ 2</th>
                        <!-- <th>หมวดหมู่</th> -->
                        <th style="width:50px;" class="text-center">ใช้งาน</th>
                        <th style="width:50px;" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>รหัส</th>
                        <th>หมวดหมู่ย่อยที่ 4</th>
                        <th>หมวดหมู่ย่อยที่ 3</th>
                        <th>หมวดหมู่ย่อยที่ 2</th>
                        <!-- <th>หมวดหมู่</th> -->
                        <th class="text-center">ใช้งาน</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    
                    $sql = "select m.*,b.CategoryName ,c.SubCategoryName,d.SubCategoryName3
                        from product_sub_category4 m 
                        left join product_category b on b.CategoryCode = m.CategoryCode
                        left join product_sub_category c on c.CategoryCode = m.CategoryCode and c.SubCategoryCode = m.SubCategoryCode
                        left join product_sub_category3 d 
                            on d.CategoryCode = m.CategoryCode 
                            and d.SubCategoryCode = m.SubCategoryCode 
                            and d.SubCategoryCode3 = m.SubCategoryCode3
                        where b.CategoryGroup='$_COG_ITEM_CODE'
                        order by m.SEQ, m.CategoryCode,m.SubCategoryCode,m.SubCategoryCode3 ";
                    $datas = SelectRows($sql);
                    foreach($datas as $data){
                    ?>
                    <tr data-sortable-row-key="<?php echo $data["SubCategoryCode4"] ?>">
                        <td><?php echo $data["SubCategoryCode4"] ?></td>
                        <td><?php echo $data["SubCategoryName4"] ?></td>
                        <td><?php echo $data["SubCategoryName3"] ?></td>
                        <td><?php echo $data["SubCategoryName"] ?></td>
                        <!-- <td><?php echo $data["CategoryName"] ?></td> -->
                        <td class="text-center sortable-hide-item">
                            <?php echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                        </td>
                        <td class="text-center sortable-hide-item">
                            <a href="productSubCategoryDetail4.php?ref=<?php echo $data["SubCategoryCode4"] ?>">
                                <i class="fa fa-cog"></i>
                            </a>

                            <form method="post" style="display:inline">
                                <button type="submit" class="btn-link" 
                                    onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                    value="<?php echo $data["SubCategoryCode4"] ?>" name="btnDeleteRow">
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