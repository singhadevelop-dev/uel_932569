<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include "../assets/b4w-framework/UtilService.php"; ?>
<?php 
    $refCode = $_POST["ref"];
    $imageCode = $_POST["image"];
    $sql = "select a.* , b.Color
    from gallery a 
    left join product b on a.RefCode = b.ProductCode
    where a.RefCode = '".$refCode."' and a.ImageCode='$imageCode'  ";
    $data = SelectRow($sql);
?>
<div class="row">
    <div class="col-sm-3 col-lg-3"></div>
    <div class="col-sm-6 col-lg-6">
        <p>
            <div id="imge-preview-change" class="image-box hand" onclick="$(this).next().click();"
        style="width: 100%; height: 600px;margin-bottom:5px; background-image: url(<?php echo $data["ImagePath"] ?>), url('https://ipsumimage.appspot.com/800x800,eee')">
            </div>

            <input class="hide" type="file" onchange="$(this).validateUploadImage($('#imge-preview-change'));"
        name="fileUploadChange" accept="image/*" />

            <input type="hidden" name="hddBackUpImageChange" value="<?php echo $data["ImagePath"] ?>" />


            <div>
                <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพใหม่</small>
            </div>
        </p>
    </div>
</div>
<div class="row hide">
    <div class="col-sm-3 col-lg-3"></div>
    <div class="col-sm-6 col-lg-6">
        <p>
            <!-- <label>คำอธิบายโดยย่อ</label> -->
            <!-- <input type="text" class="form-control input-sm" name="txtImageName" value="<?php //echo $data["ImageName"] ?>" /> -->
            <label>เลือกกลุ่มสีรูปภาพ</label>
            <select name="txtImageName" class="form-control input-sm require">
                <option value="">เลือกกลุ่มสี</option>
                <?php
                    // $sqlTags = "select * from tag where TagType = 'COLOR' and Active = 1 order by TagName";
                    // $dataTags = SelectRows($sqlTags);
                    // foreach ($dataTags as $tag) {
                    //     if(strpos($data["Color"],$tag["TagCode"]) !== false)
                    //     {
                ?>
                    <!-- <option value="<?php //echo $tag["TagCode"] ?>" <?php //echo $data["ImageName"] == $tag["TagCode"] ? ' selected="selected" ' : '' ?> ><?php //echo $tag["TagName"] ?></option> -->
                <?php //}} ?>
            </select>
        </p>
        <p class="hide">
            <label>คำอธิบายเพิ่มเติม</label>
            <textarea style="min-height:90px;" class="form-control input-sm" name="txtImageDetail"><?php echo $data["ImageDetail"] ?></textarea>
        </p>
    </div>
</div>
<input type="hidden" name="hdfImageCode" value="<?php echo $data["ImageCode"] ?>">