<?php include_once  "_config.php"; ?>
<?php include_once  "../_master/_master.php"; ?>
<?php 
if(isset($_POST["btnDeleteRow"])){
    $sql = "delete from portfolio where PortCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
    $sql = "delete from gallery where RefCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
}
?>
<div class="mat-box grey-bar">
    <a href="item.php" class="link-history-btn">หน้าหลัก<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">รายการ<?php echo $_COG_ITEM_NAME ?></span>
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
                <!-- <a href="itemDetail.php" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการ<?php echo $_COG_ITEM_NAME ?>
                </a> -->
                <span><b>รายการ<?php echo $_COG_ITEM_NAME ?></b></span>
                <hr style="margin-top: 5px;" />
                <!-- data-sortable-table="portfolio"
                    data-sortable-column-seq="SEQ"
                    data-sortable-column-key="PortCode" -->
                <table 
                    
                    class="jquery-datatable sortable-table table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center" style="width:10px;">#</th>
                        <?php if($_COG_ALLOW_CATEGORY){ ?>
                        <th>หมวดหมู่</th>
                        <?php } ?>
                        <th>หัวข้อ</th>
                        <?php if($_COG_ALLOW_FIRST_SHORT_DESCRIPTION){ ?>
                        <th style="width:200px;" >รายละเอียด</th>
                        <?php } ?>
                        <?php if($_COG_ALLOW_HTML_DETAIL){ ?>
                        <th>คำอธิบาย</th>
                        <?php } ?>
                        <?php if($_COG_ALLOW_FIRST_AMOUNT){ ?>
                        <th>จำนวน</th>
                        <?php } ?>
                        <!-- <th style="width:50px;" class="text-center">ใช้งาน</th> -->
                        <th style="width:100px;" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">#</th>
                        <?php if($_COG_ALLOW_CATEGORY){ ?>
                        <th>หมวดหมู่</th>
                        <?php } ?>
                        <th>หัวข้อ</th>
                        <?php if($_COG_ALLOW_FIRST_SHORT_DESCRIPTION){ ?>
                        <th>รายละเอียด</th>
                        <?php } ?>
                        <?php if($_COG_ALLOW_HTML_DETAIL){ ?>
                        <th>คำอธิบาย</th>
                        <?php } ?>
                        <?php if($_COG_ALLOW_FIRST_AMOUNT){ ?>
                        <th>จำนวน</th>
                        <?php } ?>
                        <!-- <th style="width:50px;" class="text-center">ใช้งาน</th> -->
                        <th style="width:100px;" class="text-center">จัดการ</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $sql = "select p.*,c.CategoryName , d.SubCategoryName from portfolio p 
                    left join product_category c on c.CategoryCode = p.CategoryCode
                    left join product_sub_category d on p.SubCategoryCode = d.SubCategoryCode
                    where p.PortType = '".$_COG_ITEM_CODE."' order by p.seq,p.PortCode";
                    $datas = SelectRows($sql);
                    $inx = 1;
                    while($data = $datas->fetch_array()){
                    ?>
                    <tr data-sortable-row-key="<?php echo $data["PortCode"] ?>">
                        <td class="text-center"><?php echo $inx++; ?></td>
                        <?php if($_COG_ALLOW_CATEGORY){ ?>
                        <td><?php echo empty($data["CategoryName"]) ? "ไม่ได้ระบุหมวดหมู่" : $data["CategoryName"].(!empty($data["SubCategoryName"]) ? " -> <span class='text-info'>".$data["SubCategoryName"]."</span> " : "") ?></td>
                        <?php } ?>
                        <td>
                        <?php echo $data["PortName"] ?>
                        </td>
                        <?php if($_COG_ALLOW_FIRST_SHORT_DESCRIPTION){ ?>
                        <td><?php echo empty($data["ShortDescription"]) ? "" : $data["ShortDescription"] ?></td>
                        <?php } ?>
                        <?php if($_COG_ALLOW_HTML_DETAIL){ ?>
                        <td><?php echo empty($data["PortDetail2"]) ? "ไม่ได้ระบุ" : $data["PortDetail2"] ?></td>
                        <?php } ?>
                        <?php if($_COG_ALLOW_FIRST_AMOUNT){ ?>
                        <td><?php echo number_format($data["Amount"],$_COG_ALLOW_AMOUNT_DECIMAL) ?></td>
                        <?php } ?>
                        <!-- <td class="text-center sortable-hide-item">
                            <?php echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                        </td> -->
                        <td class="text-center sortable-hide-item">
                            <?php if($_COG_ALLOW_SUBITEM){ ?>
                                <a title="เพิ่มรายการย่อย" style="margin-right:8px;" href="itemSubDetail.php?ref=<?php echo $data["PortCode"] ?>">
                                    <i class="fa fa-tasks"></i>
                                </a>
                            <?php } ?>
                            <?php if($_COG_ALLOW_FEEDBACK){ ?>
                            <a title="ผลตอบรับ" style="margin-right:8px;" href="itemFeedBack.php?ref=<?php echo $data["PortCode"] ?>">
                                <i class="fa fa-tasks"></i>
                            </a>
                            <?php } ?>
                            <?php if($_COG_ALLOW_GALLERY){ ?>
                            <a title="แกลเลอรี่" style="margin-right:8px;" href="itemDetailGallery.php?ref=<?php echo $data["PortCode"] ?>">
                                <i class="fa fa-picture-o"></i>
                            </a>
                            <?php } ?>
                            <?php if($_COG_ALLOW_GALLERY2){ ?>
                            <a title="รูปแบบห้อง" style="margin-right:8px;" href="itemDetailGallery.php?no=2&ref=<?php echo $data["PortCode"] ?>">
                                <i class="fa fa-building-o"></i>
                            </a>
                            <?php } ?>
                            <a title="แก้ไขข้อมูล" href="itemDetail.php?ref=<?php echo $data["PortCode"] ?>">
                                <i class="fa fa-cog"></i>
                            </a>
                            <!-- <form method="post" style="display:inline">
                                <button type="submit" class="btn-link" 
                                    onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                    value="<?php echo $data["PortCode"] ?>" name="btnDeleteRow">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form> -->
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<?php include_once  $GLOBALS['DOCUMENT_ROOT']."/ControlPanel/footer.php"; ?>