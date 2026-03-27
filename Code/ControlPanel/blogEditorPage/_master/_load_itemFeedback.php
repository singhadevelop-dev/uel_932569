<?php include_once "../../assets/b4w-framework/UtilService.php"; ?>

<?php 
    $_IS_STAR = $_GET["cstar"];
    $_IS_POSITION = $_GET["cposition"];
?>

<style>
.star-panel .gold,
.star-panel:hover .fa-star {
    color: gold;
}

.star-panel .grey,
.star-panel .fa-star:hover~.fa-star {
    color: #aaa;
}

.panel-review-detail label {
    position: relative;
    cursor: pointer;
    color: #666;
    font-size: 45px;
}

.panel-review-detail input[type="radio"] {
    position: absolute;
    right: 9000px;
}

.panel-review-detail input[type="radio"]+.label-text:before {
    content: "\f10c";
    font-family: "FontAwesome";
    speak: none;
    font-style: normal;
    font-weight: normal;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    width: 1em;
    display: inline-block;
    margin-right: 5px;
}

.panel-review-detail input[type="checkbox"]:checked+.label-text:before {
    content: "\f192";
    color: #8e44ad;
    animation: effect 250ms ease-in;
}

.panel-review-detail input[type="checkbox"]:disabled+.label-text {
    color: #aaa;
}

.panel-review-detail input[type="checkbox"]:disabled+.label-text:before {
    content: "\f111";
    color: #ccc;
}

/*Radio Toggle*/

.panel-review-detail .toggle input[type="checkbox"]+.label-text:before {
    content: "\f204";
    font-family: "FontAwesome";
    speak: none;
    font-style: normal;
    font-weight: normal;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    width: 1em;
    display: inline-block;
    margin-right: 10px;
}

.panel-review-detail .toggle input[type="checkbox"]:checked+.label-text:before {
    content: "\f205";
    color: #16a085;
    animation: effect 250ms ease-in;
}

.panel-review-detail .toggle input[type="checkbox"]:disabled+.label-text {
    color: #aaa;
}

.panel-review-detail .toggle input[type="checkbox"]:disabled+.label-text:before {
    content: "\f204";
    color: #ccc;
}
.panel-review-detail .form-check input[type="checkbox"]{
    display: none;
}


@keyframes effect {
    0% {
        transform: scale(0);
    }

    25% {
        transform: scale(1.3);
    }

    75% {
        transform: scale(1.4);
    }

    100% {
        transform: scale(1);
    }
}
</style>

<?php
    $reviewCode = $_GET["ref"];
    $sql = "select * from review where ReviewCode='$reviewCode'";
    $data = SelectRow($sql);
    $is_check = $data == false ? true : $data["Active"];
?>

<div class="panel-review-detail">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-4 text-center">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <span><b>รูปหลัก<?php echo $_COG_ITEM_NAME ?></b></span>
                    <hr style="margin-top: 5px; margin-bottom: 5px;" />
                    <p>
                    <div id="imge-preview-<?php echo $data["ReviewCode"] ?>" class="image-box hand"
                        onclick="$(this).next().click();"
                        style="width: 100%; height: 150px;margin-bottom:5px; background-image: url(<?php echo $data["Image"] ?>), url('https://via.placeholder.com/150')">
                    </div>
                    <input class="hide" type="file"
                        onchange="$(this).validateUploadImage($('#imge-preview-<?php echo $data["ReviewCode"] ?>'));"
                        name="fileUploadChange" accept="image/*" />
                    <input type="hidden" name="hddBackUpImageChange" value="<?php echo $data["Image"] ?>" />
                    <div>
                        <small>คลิกด้านบนรูปเพื่อเลือกรูปภาพใหม่</small>
                    </div>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-8">
            <?php if($_IS_STAR){ ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="star-panel text-center gold">
                        <?php 
                            $rank = intval($data["Rating"]);
                        ?>
                        <i class="fa fa-2x fa-star hand <?php echo $rank >= 1 ? "gold" : "grey" ?>" data-rank="1"></i>
                        <i class="fa fa-2x fa-star hand <?php echo $rank >= 2 ? "gold" : "grey" ?>" data-rank="2"></i>
                        <i class="fa fa-2x fa-star hand <?php echo $rank >= 3 ? "gold" : "grey" ?>" data-rank="3"></i>
                        <i class="fa fa-2x fa-star hand <?php echo $rank >= 4 ? "gold" : "grey" ?>" data-rank="4"></i>
                        <i class="fa fa-2x fa-star hand <?php echo $rank >= 5 ? "gold" : "grey" ?>" data-rank="5"></i>
                        <div style="display: none;">
                            <input type="text" id="txtReviewRank" name="txtReviewRank" value="<?php echo $rank <= 0 ? "" : $rank;  ?>" required>
                        </div>
                        <script>
                        $(".star-panel .fa-star").click(function() {
                            $("#txtReviewRank").val($(this).attr("data-rank"));
                            $(this).removeClass("grey").removeClass("gold").addClass("gold");
                            $(this).prevAll().removeClass("grey").removeClass("gold").addClass("gold");
                            $(this).nextAll().removeClass("grey").removeClass("gold").addClass("grey");
                        });
                        </script>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="col-12">
                    <div class="bg-light">
                        <input type="hidden" name="txtReviewCode" value="<?php echo $data["ReviewCode"]; ?>">
                        <input type="text" name="txtReviewName" value="<?php echo $data["ByName"]; ?>"
                            class="form-control inpu-lg" placeholder="ชื่อ" required>
                    </div>
                </div>
            </div>
            <?php //if($_IS_POSITION){ ?>
            <div class="row">
                <div class="col-12">
                    <input type="text" name="txtReviewPosition" value="<?php echo $data["Position"]; ?>"
                        class="form-control inpu-lg" placeholder="ตำแหน่ง" required>
                </div>
            </div>
            <?php //} ?>
            <div class="row">
                <div class="col-12">
                    <textarea name="txtReviewMessage" rows="5" class="form-control"
                        placeholder="บอกให้คนอื่นรู้ว่าคุณรู้สึกอย่างไรต่อ..."><?php echo $data["Message"] ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-check">
                        <label class="toggle">
                            <input type="checkbox" name="chkReviewActive" <?php echo $is_check ? " checked='' " : ""  ?>> <span class="label-text"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>