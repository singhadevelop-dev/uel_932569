<?php $_COG_ITEM_CODE = 'PRODUCT'; ?>
<?php include  "../header.php"; ?>
<?php include  "_config.php"; ?>
<?php

$_ProductImg_1 = true;
if (isset($_POST["btnDeleteRow"])) {
    $sql = "delete from product where ProductCode = '".$_POST["btnDeleteRow"]."' ";
    ExecuteSQL($sql);
    $sql = "delete from gallery where RefCode = '".$_POST["btnDeleteRow"]."' ";
    ExecuteSQL($sql);
    $sql = "delete from product_properties_mapping where ProductCode = '".$_POST["btnDeleteRow"]."' ";
    ExecuteSQL($sql);
}

?>
<div class="mat-box grey-bar">
    <a href="product.php" class="link-history-btn">หน้าหลักข้อมูล<?php echo $_COG_ITEM_NAME ?></a>
    /
    <span class="link-history-btn">รายการ<?php echo $_COG_ITEM_NAME ?></span>
</div>
<div class="mat-box" style="border-radius: 0 0 3px 3px">
    <div class="row">
        <?php if ($_COG_ALLOW_LEFT_MENU) { ?>
            <div class="col-md-2">
                <?php
                $_LEFT_MENU_ACTIVE = "PRODUCT";
                include "leftMenu.php";
                ?>
            </div>
        <?php } ?>
        <div class="col-md-<?php echo $_COG_ALLOW_LEFT_MENU ? "10" : "12" ?>">
            <div>
                <a href="javascript:;" onclick="openloadProduct();" class="pull-right hide">
                    <i class="fa fa-upload"></i>
                    อัพโหลดรายการ
                </a>
                <a href="productDetail.php" class="pull-right">
                    <i class="fa fa-plus"></i>
                    เพิ่มรายการ<?php echo $_COG_ITEM_NAME ?>&nbsp;&nbsp;&nbsp;
                </a>
                <span><b>รายการ<?php echo $_COG_ITEM_NAME ?></b></span>
                <hr style="margin-top: 5px;" />
                <?php
                $_CAT = $_POST["cat"];
                $_ACTIVE = $_POST["act"];
                $_SORT_TABLE = empty($_CAT) && empty($_ACTIVE) && $_ACTIVE !== "0";
                ?>
                <style>
                    .it-swi {
                        cursor: pointer;
                        font-size: 2rem;
                    }

                    .it-swi:before {
                        content: "\f204";
                        color: #E65041;
                    }

                    .it-swi.active:before {
                        content: "\f205";
                    }

                    .it-swi.new.active:before {
                        color: #0085A1;
                    }

                    .it-swi.recom.active:before {
                        color: #0aa92a;
                    }

                    .it-swi.hot.active:before {
                        color: #103bbd;
                    }

                    .it-swi.act.active:before {
                        color: #04AC9C;
                    }

                    .dataTables_length {
                        display: none;
                    }

                    table.dataTable thead th.t-w50 {
                        width: 50px !important;
                    }

                    table.dataTable thead th.t-w80 {
                        width: 80px !important;
                    }

                    div.dataTables_wrapper div.dataTables_filter .form-control {
                        display: block;
                    }

                    .sortable-table-x tbody tr {
                        cursor: n-resize;
                    }

                    .pointer {
                        cursor: pointer;
                    }

                    .t-mark {
                        font-style: italic;
                        color: #E65041 !important;
                        text-align: center;
                        font-size: 85%;
                    }

                    #DataTables_Table_0_filter_select_cat {
                        padding-right: 10px;
                    }
                </style>
                <script>
                    <?php if ($_SORT_TABLE) { ?>
                        _datatableOptions = {
                            pageLength: 100,
                            //paging: false
                        };
                    <?php } else { ?>
                        _datatableOptions = {
                            pageLength: 100,
                            //paging: false
                            "order": [
                                [1, "asc"]
                            ],
                        };
                    <?php } ?>


                    $(document).ready(function() {
                        setTimeout(function() {

                            var ddlselect_cat = $("<div />", {
                                "id": "DataTables_Table_0_filter_select_cat",
                                class: "dataTables_filter",
                            });
                            $(ddlselect_cat).append("<label>หมวดหมู่:</label>");
                            $(ddlselect_cat).find("label").append($("#ddlCategorySelect"));
                            $("#DataTables_Table_0_filter").after($(ddlselect_cat));

                            var ddlselect_active = $("<div />", {
                                "id": "DataTables_Table_0_filter_select_active",
                                class: "dataTables_filter",
                            });
                            $(ddlselect_active).append("<label>ใช้งาน:</label>");
                            $(ddlselect_active).find("label").append($("#ddlActiveSelect"));
                            $("#DataTables_Table_0_filter").after($(ddlselect_active));

                            var target = $("#DataTables_Table_0_filter").parent();
                            $(target).removeClass("col-sm-6").removeClass("col-md-6");
                            $(target).addClass("col-sm-12").addClass("col-md-12");

                        }, 800);
                    });
                </script>
                <div style="display:none;">
                    <select id="ddlCategorySelect" onchange="changeRedirect();" style="min-height: 25px;" class="form-control form-control-sm">
                        <option value=""></option>
                        <?php
                        $sqlc = "Select CategoryCode,CategoryName from product_category where Active=1 and CategoryGroup='PRODUCT' order by SEQ,CategoryCode";
                        $cats = SelectRowsArray($sqlc);
                        foreach ($cats as $cat) { ?>
                            <option value="<?php echo $cat["CategoryCode"] ?>" <?php echo $_CAT == $cat["CategoryCode"] ? "selected='selected'" : "" ?>>
                                <?php echo $cat["CategoryName"] ?>
                            </option>
                        <?php } ?>
                    </select>
                    <select id="ddlActiveSelect" onchange="changeRedirect();" style="min-height: 25px;" class="form-control form-control-sm">
                        <option value=""></option>
                        <option value="0" <?php echo $_ACTIVE == "0" ? "selected='selected'" : "" ?>>ปิดใช้งาน</option>
                        <option value="1" <?php echo $_ACTIVE == "1" ? "selected='selected'" : "" ?>>เปิดใช้งาน</option>
                    </select>

                    <script>
                        function changeRedirect() {
                            var target = $("#form-fillter-data");
                            $(target).html("");
                            var cat = $("#ddlCategorySelect").val();
                            var act = $("#ddlActiveSelect").val();
                            if (cat != "") {
                                $(target).append('<input type="text" name="cat" value="' + cat + '">');
                            }
                            if (act != "") {
                                $(target).append('<input type="text" name="act" value="' + act + '">');
                            }
                            $(target).submit();
                        }
                    </script>
                    <form id="form-fillter-data" action="" method="post"></form>
                </div>

                <table style="width: 100%;"
                    data-sortable-table="product"
                    data-sortable-column-seq="SEQ"
                    data-sortable-column-key="ProductCode"
                    class="jquery-datatable sortable-table-x table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อสินค้า</th>
                            <th>หมวดหมู่</th>
                            <th class="t-w50 text-center">ใช้งาน</th>
                            <th class="t-w80 text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>ชื่อสินค้า</th>
                            <th>หมวดหมู่</th>
                            <th class="t-w50 text-center">ใช้งาน</th>
                            <th class="t-w80 text-center">จัดการ</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php

                        $_where = "";
                        if (!empty($_CAT)) {
                            $_where .= " and p.CategoryCode like '%$_CAT%' ";
                        }
                        if (!empty($_ACTIVE) || $_ACTIVE == "0") {
                            $_where .= " and p.Active='$_ACTIVE' ";
                        }

                        $sql = "select p.*,c.CategoryName from product p
                                left join product_category c on c.Active=1 and FIND_IN_SET(c.CategoryCode, p.CategoryCode) > 0
                                where 1=1 $_where
                                group by p.ProductCode 
                                order by p.SEQ,p.ProductCode";
                        $datas = SelectRows($sql);
                        $inx = 0;
                        foreach ($datas as $data) {
                        ?>
                            <tr data-key="<?php echo $data["ProductCode"] ?>" data-seq="<?php echo $inx++ ?>">
                                <td><?php echo $inx; ?></td>
                                <td><?php echo $data["ProductName"] ?></td>
                                <td class="">
                                    <?php echo empty($data["CategoryName"]) ? "<i class='text-muted'>ไม่พบหมวดหมู่</i>" : $data["CategoryName"] ?>
                                </td>
                                <td class="text-center">
                                    <i class="it-swi act fa <?php echo $data["Active"] == 1 ? "active" : "" ?>" onclick="xActive(this)"></i>
                                </td>
                                <td class="text-center">
                                    <a class="hide" title="แกลเลอรี่" href="productDetailGallery.php?ref=<?php echo $data["ProductCode"] ?>">
                                        <i class="fa fa-picture-o"></i>
                                    </a>
                                    <a class="hide" title="Specification" style="margin-left:8px;" href="productSubDetail.php?ref=<?php echo $data["ProductCode"] ?>">
                                        <i class="fa fa-th-list"></i>
                                    </a>
                                    <a title="แก้ไขข้อมูล" style="margin-left:8px;" href="productDetail.php?ref=<?php echo $data["ProductCode"] ?>">
                                        <i class="fa fa-cog"></i>
                                    </a>
                                    <a title="ลบรายการนี้" style="margin-left:8px;" class="pointer" onclick="xdelete(this)">
                                        <i class="fa fa-trash text-danger"></i>
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
<script>
    function xNew(ele) {
        var p = $(ele).closest("tr").attr("data-key");
        var _new = !$(ele).hasClass("active");
        AlertLoading(true, "กำลังทำรายการ");
        $.ajax({
            type: "POST", // type of request
            url: "_post_data.php", // funtion name // resource file with extension
            data: {
                "action": "NEW",
                "product": p,
                "new": _new
            },
            success: function(xhr, reason, exMessage) {
                if (xhr.status == "OK") {
                    var code = xhr.result.product;
                    var status = xhr.result.new;
                    if (status == "true") {
                        $("tr[data-key='" + code + "']").find(".it-swi.new").addClass("active");
                    } else {
                        $("tr[data-key='" + code + "']").find(".it-swi.new").removeClass("active");
                    }
                } else {
                    AlertError(reason + "[" + xhr.status + "] : " + xhr.message == undefined ? xhr : xhr.message);
                }
                AlertLoading(false);
            },
            error: function(xhr, reason, exMessage) {
                AlertError(reason + "[" + xhr.status + "] : " + xhr.message == undefined ? xhr : xhr.message);
                AlertLoading(false);
            }
        });
    }

    function xRecommend(ele) {
        var p = $(ele).closest("tr").attr("data-key");
        var _recom = !$(ele).hasClass("active");
        AlertLoading(true, "กำลังทำรายการ");
        $.ajax({
            type: "POST", // type of request
            url: "_post_data.php", // funtion name // resource file with extension
            data: {
                "action": "RECOMMEND",
                "product": p,
                "recom": _recom
            },
            success: function(xhr, reason, exMessage) {
                if (xhr.status == "OK") {
                    var code = xhr.result.product;
                    var status = xhr.result.recom;
                    if (status == "true") {
                        $("tr[data-key='" + code + "']").find(".it-swi.recom").addClass("active");
                    } else {
                        $("tr[data-key='" + code + "']").find(".it-swi.recom").removeClass("active");
                    }
                } else {
                    AlertError(reason + "[" + xhr.status + "] : " + xhr.message == undefined ? xhr : xhr.message);
                }
                AlertLoading(false);
            },
            error: function(xhr, reason, exMessage) {
                AlertError(reason + "[" + xhr.status + "] : " + xhr.message == undefined ? xhr : xhr.message);
                AlertLoading(false);
            }
        });
    }

    function xHot(ele) {
        var p = $(ele).closest("tr").attr("data-key");
        var _hot = !$(ele).hasClass("active");
        AlertLoading(true, "กำลังทำรายการ");
        $.ajax({
            type: "POST", // type of request
            url: "_post_data.php", // funtion name // resource file with extension
            data: {
                "action": "HOT",
                "product": p,
                "hot": _hot
            },
            success: function(xhr, reason, exMessage) {
                if (xhr.status == "OK") {
                    var code = xhr.result.product;
                    var status = xhr.result.hot;
                    if (status == "true") {
                        $("tr[data-key='" + code + "']").find(".it-swi.hot").addClass("active");
                    } else {
                        $("tr[data-key='" + code + "']").find(".it-swi.hot").removeClass("active");
                    }
                } else {
                    AlertError(reason + "[" + xhr.status + "] : " + xhr.message == undefined ? xhr : xhr.message);
                }
                AlertLoading(false);
            },
            error: function(xhr, reason, exMessage) {
                AlertError(reason + "[" + xhr.status + "] : " + xhr.message == undefined ? xhr : xhr.message);
                AlertLoading(false);
            }
        });
    }

    function xActive(ele) {
        var p = $(ele).closest("tr").attr("data-key");
        var _active = !$(ele).hasClass("active");
        AlertLoading(true, "กำลังทำรายการ");
        $.ajax({
            type: "POST", // type of request
            url: "_post_data.php", // funtion name // resource file with extension
            data: {
                "action": "ACTIVE",
                "product": p,
                "active": _active
            },
            success: function(xhr, reason, exMessage) {
                if (xhr.status == "OK") {
                    var code = xhr.result.product;
                    var status = xhr.result.active;
                    if (status == "true") {
                        $("tr[data-key='" + code + "']").find(".it-swi.act").addClass("active");
                    } else {
                        $("tr[data-key='" + code + "']").find(".it-swi.act").removeClass("active");
                    }
                } else {
                    AlertError(reason + "[" + xhr.status + "] : " + xhr.message == undefined ? xhr : xhr.message);
                }
                AlertLoading(false);
            },
            error: function(xhr, reason, exMessage) {
                AlertError(reason + "[" + xhr.status + "] : " + xhr.message == undefined ? xhr : xhr.message);
                AlertLoading(false);
            }
        });
    }
</script>

<script>
    function xdelete(ele) {
        var p = $(ele).closest("tr").attr("data-key");
        $("[name='btnDeleteRow']").val(p);
        $("[name='btnDeleteRow']").click();
    }
</script>
<form method="post" style="display:none">
    <button type="submit" class="btn-link"
        onclick="return Confirm(this,'ต้องการลบรายการนี้หรือไม่ ?');"
        value="" name="btnDeleteRow">
        <i class="fa fa-trash"></i>
    </button>
</form>

<?php if ($_SORT_TABLE) { ?>
    <script>
        function clearSearchx() {
            var searchElt = $(".dataTables_filter input[type='search']");
            searchElt.val("").keyup();
        }

        function enableSortx() {
            $(".sortable-table-x tbody").sortable("enable");
            $(".disabled-sort").hide();
        }

        function disableSortx() {
            $(".sortable-table-x tbody").sortable("disable");
            $(".disabled-sort").show();
        }

        $(document).ready(function() {

            $(".sortable-table-x tbody").sortable({
                distance: 20,
                placeholder: "ui-state-highlight",
                start: function(event, ui) {
                    var draggable = $(ui.item[0]);
                    draggable.addClass("sortable-hide");
                },
                stop: function(event, ui) {
                    var draggable = $(ui.item[0]);
                    draggable.removeClass("sortable-hide");
                    var table = draggable.closest(".sortable-table-x");
                    var rowItem = table.find("[data-key]");
                    var db_table = table.attr("data-sortable-table");
                    var db_column_seq = table.attr("data-sortable-column-seq");
                    var db_column_key = table.attr("data-sortable-column-key");
                    if (db_table != undefined && db_column_seq != undefined && db_column_key != undefined && rowItem.length > 0) {
                        var rowKeyArr = [];
                        var _start = 0;
                        if ($("tr[data-key]:first").attr("data-seq") !== undefined) {
                            _start = parseInt($("tr[data-key]:first").attr("data-seq"));
                        }
                        rowItem.each(function() {
                            rowKeyArr.push($(this).attr("data-key"));
                            var _n = parseInt($(this).attr("data-seq"));
                            if (_start > _n) {
                                _start = _n;
                            }
                        });
                        $(".at-loading").show();
                        $.ajax({
                            url: _root_path_includelibrary + "/ControlPanel/assets/b4w-framework/SortableItemAPI.php",
                            method: "POST",
                            data: {
                                table: db_table,
                                column_seq: db_column_seq,
                                column_key: db_column_key,
                                row_key_array: rowKeyArr,
                                start: (_start + 1),
                            },
                            success: function(result) {
                                if (result.trim() == "S") {
                                    //location.reload();
                                } else {
                                    alert("SORTABLE ERROR [" + result + "]");
                                }
                                $(".at-loading").hide();
                            }
                        });
                    }
                }
            });
            $(".sortable-table-x").disableSelection();
            var searchElt = $(".dataTables_filter input[type='search']");
            searchElt.keyup(function() {
                var val = $(this).val();
                if (val.trim() != "") {
                    disableSortx();
                } else {
                    enableSortx();
                }
            });
            var sortableDetail = $("<div/>", {
                class: "sortable-table-detail alert alert-info text-center",
                colspan: "100%",
                html: "<small><i class='fa fa-info-circle'></i><i> คลิกและลากที่รายการเพื่อจัดลำดับใหม่</i></small>" +
                    "<div class='text-danger'><small>ครั้งแรกของจัดลำดับในการการโหลดหน้าจอใหม่ทุกครั้ง โปรดตรวจสอบให้แน่ใจว่าข้อมูลคอลัมน์ # อยู่ในลำดับที่ถูกต้องหรือไม่? ก่อนทำการเริ่มจัดลำดับ!!!</i></small></div>" +
                    "<div class='text-danger disabled-sort' style='display:none'><b><small>ไม่สามารถจัดลำดับใหม่ได้เนื่องจากอยู่ในโหมดการค้นหา</small><br><a href='javascript:clearSearchx();'><i class='fa fa-refresh'></i> ล้างการค้นหา</a></small></div>"
            });
            $(".sortable-table-x").closest(".dataTables_wrapper").before(sortableDetail.clone()) //.after(sortableDetail.clone());

        });
    </script>
<?php } else { ?>
    <script>
        $(document).ready(function() {
            var sortableDetail = $("<div/>", {
                class: "sortable-table-detail alert alert-info text-center",
                colspan: "100%",
                html: "<small><i class='fa fa-info-circle'></i><i> คลิกและลากที่รายการเพื่อจัดลำดับใหม่</i></small>" +
                    "<div class='text-danger'><b><small>ไม่สามารถจัดลำดับใหม่ได้เนื่องจากอยู่ในโหมดการค้นหา</small><br><a href='javascript:clearSearchReSetPage();'><i class='fa fa-refresh'></i> ล้างการค้นหา</a></small></div>"
            });
            $(".sortable-table-x").closest(".dataTables_wrapper").before(sortableDetail.clone()) //.after(sortableDetail.clone());
        });

        function clearSearchReSetPage() {
            window.location.href = 'product.php'
        }
    </script>
<?php } ?>


<?php include  "../footer.php"; ?>