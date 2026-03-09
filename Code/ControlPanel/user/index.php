<?php $_COG_ITEM_CODE = 'MEMBER'; ?>
<?php include  "../header.php"; ?>


<div class="mat-box" style="margin-bottom: 0; border-radius: 3px 3px 0 0">
    <div class="row" style="margin-bottom: 0;">
        <div class="col-sm-12">
            <h3 style="margin: 0;">

                <i class="fa fa-users  fa-fw"></i>
                <span class="analysis-left-menu-desc">ข้อมูลสมาชิก</span>

            </h3>
        </div>
    </div>
</div>

<div class="mat-box grey-bar">
    <a href="index.php" class="link-history-btn">ข้อมูลสมาชิก</a>
    /
    <span class="link-history-btn">ข้อมูลสมาชิก</span>
</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">

    <div class="row">
        <div class="col-md-12">
            <style>
                .picked td{
                    background-color:rgba(176, 243, 76, 0.4) !important;
                }
                .picked td:first-child {
                    border-left:3px solid rgba(176, 243, 76, 1);
                }
                .no-picked td{
                    background-color:rgba(255, 0, 0,0.2) !important;
                }
                .no-picked td:first-child {
                    border-left:3px solid rgba(255, 0, 0,1);
                }
                .image-profile{
                    border-radius: 10rem;
                }
            </style>
            <div>
                <span><b>รายการสมาชิก</b></span>
                <hr style="margin-top: 5px;" />

                <script>
                    _datatableOptions = {
                        "order": [[1, "desc"]]
                    }
                </script>
                <table class="jquery-datatable display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>วัน / เวลา</th>
                            <th>ชื่อ-สกุล</th>
                            <!-- <th>เพศ</th> -->
                            <th>เบอร์ติดต่อ</th>
                            <th>สถานะ</th>
                            <th style="width:100px;" class="text-center">ดูข้อมูล</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>วัน / เวลา</th>
                            <th>ชื่อ-สกุล</th>
                            <!-- <th>เพศ</th> -->
                            <th>เบอร์ติดต่อ</th>
                            <th>สถานะ</th>
                            <th style="width:100px;" class="text-center">ดูข้อมูล</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                    
                        $sql = "select a.* from client a 
                            where a.Active=1 or (a.Active=0 and a.ClientFacebookID <> '') or (a.Active=0 and a.UserName <> '' and  a.Email <> '')
                             order by CreatedOn desc";
                        $datas = SelectRows($sql);
                        foreach ($datas as $data) {
                        ?>
                        <tr>
                            <td><span class="hide">
                                <?php echo $data["CreatedOn"]; ?></span>
                                <?php echo ConvertDateTimeDBToDateTimeDisplay($data["CreatedOn"]) ?>
                            </td>
                            <td>
                                <!-- <img src="<?php //echo !empty($data["Image"]) ? $data["Image"] : "/ControlPanel/assets/images/user.png" ?>" width="30" height="30" class="image-profile"> -->
                                <?php echo $data["Name"]." ".$data["LastName"] ?>
                            </td>
                            <!-- <td><?php //echo $data["Gender"] == "MALE" ? "ชาย" : ($data["Gender"] == "FEMALE" ? "หญิง" : "อื่นๆ") ?></td> -->
                            <td><?php echo $data["Phone"] ?></td>
                            <td><?php echo ($data["Active"] == 1 ? "ใช้งาน" : "ไม่อนุญาตให้ใช้งาน" ) ?></td>
                            <td class="text-center">
                                <a title="รายละเอียดสมาชิก" href="detail.php?ref=<?php echo $data["ClientCode"]; ?>"
                                    <i class="fa fa-search"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php include  "../footer.php"; ?>