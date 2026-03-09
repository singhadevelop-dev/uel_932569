$.fn._SetupSummerNote = function(custom) {
    var cogs = {
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'hr']],
            ['view', ['fullscreen']],get
            ['help', ['help']]
        ],
        popover: {
            image: [
                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']]
            ],
            link: [
                ['link', ['linkDialogShow', 'unlink']]
            ],
            air: [
                ['color', ['color']],
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']]
            ]
        },
        fontSizes: ['8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '20', '22', '24', '26', '30', '36', '48']
    };
    $(this).summernote(cogs);
}
$.fn.previewImage = function(imgElt) {
    var input = $(this);
    var fReader = new FileReader();
    fReader.readAsDataURL(input.get(0).files[0]);
    fReader.onloadend = function(event) {
        if ($(imgElt).prop("tagName").toUpperCase() == "IMG") {
            $(imgElt).prop("src", event.target.result);
        }else {
            $(imgElt).css("background-image", "url(" + event.target.result + ")");
        }
    }
}
$.fn.validateUploadImage = function(previewElt) {
    var isValid = true;
    var file = $(this).get(0).files[0];
    var maxSize = 15000000;
    if (file.size > maxSize) {
        swal("Invalid file size", "Maximum image size is 15 MB.", "error");
        isValid = false;
    }
    if (!file.type.match("image/")) {
        swal("Invalid file type", "Only image file types are allowed.", "error");
        isValid = false;
    }
    if (!isValid) {
        $(this).val("");
        return false;
    }
    if (previewElt != undefined) {
        $(this).previewImage(previewElt);
    }
    return true;
}

$.fn.validateUploadVideo = function(previewElt) {
    var isValid = true;
    var file = $(this).get(0).files[0];
    var maxSize = 100000000;
    if (file.size > maxSize) {
        swal("Invalid file size", "Maximum video size is 100 MB.", "error");
        isValid = false;
    }
    if (!file.type.match("video/")) {
        swal("Invalid file type", "Only video file types are allowed.", "error");
        isValid = false;
    }
    if (!isValid) {
        $(this).val("");
        return false;
    }
    if (previewElt != undefined && $(previewElt).prop("tagName").toUpperCase() == "VIDEO") {
        var input = $(this);
        var fReader = new FileReader();
        fReader.readAsArrayBuffer(input.get(0).files[0]);
        fReader.onload = function(e) {
            var buffer = e.target.result;
            var videoBlob = new Blob([new Uint8Array(buffer)], { type: 'video/mp4' });
            var url = window.URL.createObjectURL(videoBlob);
            $(previewElt).find("source").prop("src", url);
            $(previewElt).load();
          }
    }
    return true;
}

function Validate(sender, parent) {
    TrimAll();
    var msg = [];
    var index = 0;
    var elt = parent == undefined ? $(".require:visible") : $(parent).find(".require:visible");
    $(elt).each(function() {
        if ($(this).val().trim() == "") {
            index++;
            var html = $(this).parent().find("label").html();
            msg.push(html);
        }
    });
    if (msg.length > 0) {
        swal('Please fill in all required fields.', msg.join("\n").split(":").join(""), 'warning');
        return false;
    }
    if (!ValidateEmail(parent) || !ValidateUsername(parent) || !ValidatePassword(parent)) {
        return false;
    }
    return Confirm(sender, "Comfirm to continue");
}

function ValidateEmail(parent) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    var toReturn = true;
    var elt = parent == undefined ? $(".email:visible") : $(parent).find(".email:visible");
    $(elt).each(function() {
        if (!pattern.test($(this).val())) {
            $(this).focus();
            swal('Warning', "Please check email format.", 'warning');
            toReturn = false;
            return false;
        }
    });
    return toReturn;
}

function ValidatePassword(parent) {
    var eltPass = parent == undefined ? $(".password:visible") : $(parent).find(".password:visible");
    var eltRePass = parent == undefined ? $(".verify-password:visible") : $(parent).find(".verify-password:visible");
    var pass = $(eltPass).first().val();
    var rePass = $(eltRePass).first().val();
    if (pass == undefined || rePass == undefined) {
        return true;
    }
    if (pass.length < 6 || rePass.length < 6) {
        eltPass.focus();
        swal("", "Password must be 6 characters or more", 'warning');
        return false;
    }
    if (pass != rePass) {
        eltRePass.focus();
        swal("", "Password and verifypassword not match", 'warning');
        return false;
    }
    return true;
}

function ValidateUsername(parent) {
    var elt = parent == undefined ? $(".username:visible") : $(parent).find(".username:visible");
    var username = $(elt).first().val();
    if (username == undefined) {
        return true;
    }
    if (username.length < 6) {
        elt.focus();
        swal("", "username must be 6 characters or more", 'warning');
        return false;
    }
    return true;
}

function TrimAll() {
    $("input[type='text'],input[type='password'],textarea").each(function() {
        $(this).val($(this).val().trim());
    });
}
var ConfirmFlag = undefined;

function Confirm(sender, message) {
    //var evt = window.event || arguments.callee.caller.arguments[0] || lastestEvent;
    if (ConfirmFlag == undefined) {
        swal({
                title: "",
                text: message,
                type: "warning",
                showCancelButton: true,
                html: true,
                confirmButtonText: "OK"
            },
            function(isConfirm) {
                ConfirmFlag = isConfirm;
                $(sender).click();
            });
        return false;
    } else {
        var xConfirm = ConfirmFlag;
        ConfirmFlag = undefined;
        return xConfirm;
    }
}

function bindDateTimeControl() {
    setDateTimePicker();
    setDatePicker();
}

function setDateTimePicker() {
    $(".datetime-picker").datetimepicker({
        format: "dd/mm/yyyy hh:ii",
        autoclose: true,
        todayBtn: true,
        minuteStep: 10
    });
    $(".datetime-picker").next(".input-group-addon").click(function() {
        $(this).prev().focus();
    });
    $(".date-picker").datetimepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        todayBtn: true,
        minView: 'month'
    });
    $(".date-picker").next(".input-group-addon").click(function() {
        $(this).prev().focus();
    });
}

function setDatePicker() {
    $(".date-picker").datetimepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        todayBtn: true
    });
    $(".date-picker").next(".input-group-addon").click(function() {
        $(this).prev().focus();
    });
}

function inputMask() {
    $(".identity-card").mask("9-9999-99999-99-9").attr("placeholder", "เช่น 1-1234-56789-00-0");
    $(".mobile-phone").mask("99-9999-9999").attr("placeholder", "เช่น 08-8888-8888");
}

function AutoTextArea(element) {
    element.style.height = "5px";
    element.style.height = (element.scrollHeight) + "px";
}
var _disableAutoLoading = false;

function disableAutoLoading(flag) {
    _disableAutoLoading = flag;
}
window.onbeforeunload = function() {
    try {
        if (!_disableAutoLoading && !$(".at-loading").is(":visible")) {
            $(".at-loading").show();
        }
    } catch (e) {}
}

function clearSearch() {
    var searchElt = $(".dataTables_filter input[type='search']");
    searchElt.val("").keyup();
}

function enableSort() {
    $(".sortable-table tbody").sortable("enable");
    $(".disabled-sort").hide();
}

function disableSort() {
    $(".sortable-table tbody").sortable("disable");
    $(".disabled-sort").show();
}
$(document).ready(function() {
    bindDateTimeControl();
    inputMask();
    var Options = {};
    try {
        Options = _datatableOptions;
    } catch (e) {};
    $('.jquery-datatable').each(function() {
        var tableOption = Options;
        var table = $(this);
        if (table.hasClass("sortable-table")) {
            tableOption.paging = false;
            tableOption.ordering = false;
        }
        table.DataTable(tableOption);
    });
    $('.jquery-datatable').show();
    $(".sortable-table tbody").sortable({
        distance: 20,
        placeholder: "ui-state-highlight",
        start: function(event, ui) {
            var draggable = $(ui.item[0]);
            draggable.addClass("sortable-hide");
        },
        stop: function(event, ui) {
            var draggable = $(ui.item[0]);
            draggable.removeClass("sortable-hide");
            var table = draggable.closest(".sortable-table");
            var rowItem = table.find("[data-sortable-row-key]");
            var db_table = table.attr("data-sortable-table");
            var db_column_seq = table.attr("data-sortable-column-seq");
            var db_column_key = table.attr("data-sortable-column-key");
            if (db_table != undefined && db_column_seq != undefined && db_column_key != undefined && rowItem.length > 0) {
                var rowKeyArr = [];
                rowItem.each(function() {
                    rowKeyArr.push($(this).attr("data-sortable-row-key"));
                });
                $(".at-loading").show();
                $.ajax({
                    url: _root_path_includelibrary+"/ControlPanel/assets/b4w-framework/SortableItemAPI.php",
                    method: "POST",
                    data: {
                        table: db_table,
                        column_seq: db_column_seq,
                        column_key: db_column_key,
                        row_key_array: rowKeyArr
                    },
                    success: function(result) {
                        if (result.trim() == "S") {
                            location.reload();
                        } else {
                            alert("SORTABLE ERROR [" + result + "]");
                        }
                    }
                });
            }
        }
    });
    $(".sortable-table").disableSelection();
    var searchElt = $(".dataTables_filter input[type='search']");
    searchElt.keyup(function() {
        var val = $(this).val();
        if (val.trim() != "") {
            disableSort();
        } else {
            enableSort();
        }
    });
    var sortableDetail = $("<div/>", {
        class: "sortable-table-detail alert alert-info text-center",
        colspan: "100%",
        html: "<small><i class='fa fa-info-circle'></i><i> คลิกและลากที่รายการเพื่อจัดลำดับใหม่</i></small>" +
            "<div class='text-danger disabled-sort' style='display:none'><b><small>ไม่สามารถจัดลำดับใหม่ได้เนื่องจากอยู่ในโหมดการค้นหา</small><br><a href='javascript:clearSearch();'><i class='fa fa-refresh'></i> ล้างการค้นหา</a></small></div>"
    });
    $(".sortable-table").closest(".dataTables_wrapper").before(sortableDetail.clone()) //.after(sortableDetail.clone());
    $("textarea").keyup(function() {
        AutoTextArea($(this)[0]);
    }).keyup();
    $("form").submit(function(e) {
        $(this).find("input[type='text'],input[type='email'],textarea").each(function() {
            $(this).val($(this).val().split("'").join('’'));
        });
    });
});