
<?php include_once "../../../_cogs.php" ?>
<?php include_once "../../assets/b4w-framework/UtilService.php"; ?>

<style>

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

    :required {
        border-left: 2px solid #E65041;
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
    $itemCode = $_GET["ref"];
    $sql = "select * from portfolio_item where ItemCode='$itemCode'";
    $data = SelectRow($sql);
    $is_check = $data == false ? true : $data["Active"];
?>

<div class="panel-review-detail">
    <div class="row">
        <div class="col-md-12">
            <b>หัวข้อ</b>
            <input type="hidden" name="txtItemCode" value="<?php echo $data["ItemCode"]; ?>">
            <input type="text" name="txtItemName" value="<?php echo $data["ItemName"]; ?>"
                class="form-control inpu-lg" placeholder="หัวข้อ" required>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <b>รายละเอียด</b>
            <textarea name="txtItemDetail" rows="10" class="form-control" placeholder=""><?php echo $data["ItemDetail"] ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <b>ใช้งาน / ไม่ใช้งาน</b>
            <div class="form-check">
                <label class="toggle">
                    <input type="checkbox" name="chkItemActive" <?php echo $is_check ? " checked='' " : ""  ?>> <span class="label-text"></span>
                </label>
            </div>
        </div>
    </div>
</div>

