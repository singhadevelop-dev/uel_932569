<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>
<?php $IsBrandImg = false; ?>

<?php 

if(isset($_POST["btnDeleteRow"])){
    $sql = "delete from product_brand where BrandCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
    
    $sql = "update product set BrandCode = '',ModelCode = '' where BrandCode = '".$_POST["btnDeleteRow"]."'";
    ExecuteSQL($sql);
}

if(isset($_POST["btnStatus"])){
    $status = !empty($_POST["chkStatus"]) ? 1 : 0;
    $sql = "update product_brand set Status = '$status' where BrandCode = '".$_POST["btnStatus"]."' ";
    ExecuteSQL($sql);
}

?>

<style>
       #table-master-control label{
            position: relative;
            cursor: pointer;
            color: #666;
            font-size: 30px;
            margin-bottom: 0px;
        }

        #table-master-control .form-check{
            margin-top: -15px;
        }

       #table-master-control input[type="checkbox"], #table-master-control input[type="radio"]{
            position: absolute;
            right: 9000px;
        }

        #table-master-control .toggle input[type="checkbox"] + .label-text:before{
            content: "\f204";
            font-family: "FontAwesome";
            speak: none;
            font-style: normal;
            font-weight: normal;
            font-variant: normal;
            text-transform: none;
            line-height: 1;
            -webkit-font-smoothing:antialiased;
            width: 1em;
            display: inline-block;
            margin-right: 10px;
        }

        #table-master-control .toggle input[type="checkbox"]:checked + .label-text:before{
            content: "\f205";
            color: #16a085;
            animation: effect 250ms ease-in;
        }

        #table-master-control .toggle input[type="checkbox"]:disabled + .label-text{
            color: #aaa;
        }

        #table-master-control .toggle input[type="checkbox"]:disabled + .label-text:before{
            content: "\f204";
            color: #ccc;
        }

        @keyframes effect{
            0%{transform: scale(0);}
            25%{transform: scale(1.3);}
            75%{transform: scale(1.4);}
            100%{transform: scale(1);}
        }
    </style>


<div class="mat-box grey-bar">

    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">รายการยี่ห้อ<?php echo $_COG_ITEM_NAME ?></span>

</div>


<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
       <div class="col-md-3">
            <?php 
            $_LEFT_MENU_ACTIVE = "BRAND";
            include "leftMenu.php";
            ?>
        </div>
        <div class="col-md-9">
            <div>
                <a href="productBrandDetail.php" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการยี่ห้อ<?php echo $_COG_ITEM_NAME ?>
                </a>
                <span><b>รายการยี่ห้อ<?php echo $_COG_ITEM_NAME ?></b></span>
                <hr style="margin-top: 5px;" />
            </div>

            

            <table id="table-master-control" class="jquery-datatable display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="width:50px;">รหัส</th>
                        <th>ชื่อยี่ห้อ<?php echo $_COG_ITEM_NAME ?></th>
                        <th class="hide">แสดงที่หน้าแรก</th>
                        <th style="width:50px;" class="text-center">ใช้งาน</th>
                        <th style="width:50px;" class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>รหัส</th>
                        <th>ชื่อยี่ห้อ<?php echo $_COG_ITEM_NAME ?></th>
                        <th class="hide">แสดงที่หน้าแรก</th>
                        <th class="text-center">ใช้งาน</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    
                    $sql = "select * from product_brand order by BrandCode";
                    $datas = SelectRowsArray($sql);
                    foreach ($datas as $data) {
                    ?>
                    <tr>
                        <td><?php echo $data["BrandCode"] ?></td>
                        <td>
                        <?php if($IsBrandImg){ ?>
                        <img src="<?php echo $data["Image"] ?>" width="40" height="30" alt="<?php echo $data["BrandName"] ?>">
                        <?php } ?>
                        <?php echo $data["BrandName"] ?>

                        </td>
                        <td class="text-center hide">
                            <form method="post">
                                <div class="form-check">
                                    <label class="toggle">
                                        <input type="checkbox" name="chkStatus" <?php echo $data["status"] ? "checked" : ""; ?>
                                        onclick="$(this).closest('.form-check').next().click();"
                                        > 
                                        <span class="label-text"></span>
                                    </label>
                                </div>
                                <button type="submit" class="hide" name="btnStatus" value="<?php echo $data["BrandCode"] ?>">
                                </button>
                            </form>
                        </td>
                        <td class="text-center">
                            <?php echo $data["Active"] == 1 ? "ใช้งาน" : "ไม่ใช้งาน" ?>
                        </td>
                        <td class="text-center">
                            <a href="productBrandDetail.php?ref=<?php echo $data["BrandCode"] ?>">
                                <i class="fa fa-cog"></i>
                            </a>

                            <form method="post" style="display:inline">
                                <button type="submit" class="btn-link" 
                                    onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
                                    value="<?php echo $data["BrandCode"] ?>" name="btnDeleteRow">
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