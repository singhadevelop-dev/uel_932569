
var uploadPrepareSaveData = [];

function SaveExcelUploadData() {
    $.ajax({
        url: uploadFormDataSaveResultAPI,
        type: "POST",
        data: {
            saveData: JSON.stringify(uploadPrepareSaveData)
        },
        success: function (xhr) {
            var datas = $.parseJSON(xhr);
            alert(datas.message);
            if (datas.result == "S") {
                Menu('product', 'promotion', 'list')
            }
        }
    });
}

function generateGUID() {
    var guid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
    return guid;
}
function GenerateFormData() {
    var guid = generateGUID();

    $(".ajax-form").remove();
    var newForm = $("<form action='"+ uploadFormDataAPI +"' method='post' enctype='multipart/form-data' class='ajax-form' style='display:none;' />");
    var fileUpload = $("<input type='file' class='upload-files' name='import-excel-uploader' accept='.xlsx' />");
    newForm.append($("<input type='text' name='guid' class='upload-guid' value='"+ guid +"' />"));

    fileUpload.change(function () {
        var uploadForm = $(this).closest("form");
        var uploadGuid = uploadForm.find(".upload-guid").val();
        var uploadFilesCount = uploadForm.find(".upload-files").get(0).files.length;

        $(uploadForm).ajaxForm({
            beforeSend: function () {
                var container = $("#div-excel-result");
                container.html('<div style="color:gold;padding:20px"><b>กำลังอัพโหลดไฟล์...</b></div>');
                $(".wg-progress-container").show();
            },
            uploadProgress: function (event, position, total, percentComplete) {
                $(".wg-progress").css("width", percentComplete + "%");
                $(".wg-progress-percent").html(percentComplete);
            },
            complete: function (xhr) {
                console.log("xhr.responseText", xhr.responseText);

                var datas = $.parseJSON(xhr.responseText);

                console.log("datas", datas);

                $("#btnSaveUploadData").attr("disabled",true);
                var container = $("#div-excel-result");
                container.html('<div style="color:#ef5a29;padding:20px"><b>กรุณาทำการอัพโหลดไฟล์ก่อน</b></div>');

                if (datas.result == "S") {
                    uploadPrepareSaveData = [];
                    container.html("");

                    var table = $("<table/>", {
                        class:"table table-striped table-bordered"
                    });
                    table.appendTo(container);
                    table.append($("#table-template").html());
                    

                    for (var i = 0; i < datas.data.length; i++) {

                        var d = datas.data[i];
                        var row = $("<tr/>");

                        var finalDatas = [];
                        var addToArray = false;
                        for (var j = 1; j < 16; j++) {
                            var content = j == 1 ? (i + 1) : datas.data[i][j];
                            var cell = $("<td/>", {
                                html: content
                            });
                            cell.appendTo(row);

                            finalDatas.push(content);

                            if (datas.data[i][j] != null && datas.data[i][j].toString().trim() != "") {
                                addToArray = true;
                            }
                        }


                        //row.addClass(isSuccessRow ? "row-success" : "row-error");
                        //if (!isEmptyRow && isSuccessRow) {
                        //    var finalDatas = [];
                        //    for (var j = 0; j < datas.data[i].length; j++) {
                        //        finalDatas.push(datas.data[i][j]);
                        //    }
                        //    uploadPrepareSaveData.push(finalDatas);
                        //}
                        if (addToArray) {
                            uploadPrepareSaveData.push(finalDatas);
                            row.appendTo(table);
                        }
                        
                    }

                    console.log(datas.data);
                    console.log(uploadPrepareSaveData);

                    if (uploadPrepareSaveData.length > 0) {
                        if (uploadPrepareSaveData.length > 500) {
                            swal("ระบบอนุญาตให้อัพโหลดได้ครั้งละไม่เกิน 500 รายการเท่านั้น", "กรุณาแบ่งการอัพโหลด (คุณกำลังจะอัพโหลดจำนวน " + uploadPrepareSaveData.length + " รายการ)", "error");
                        } else {
                            $("#txtImportDataToSave").val(JSON.stringify(uploadPrepareSaveData));
                            $("#btnSaveUploadData").removeAttr("disabled");
                        }
                    }

                }else{
                    swal("Upload failed",datas.message,"error");
                }
            }
        });
        uploadForm.submit();
    });
    newForm.append(fileUpload);
    $("body").append(newForm);
    fileUpload.click();
}

function GenerateFormDataV2() {
    var guid = generateGUID();

    $(".ajax-form").remove();
    var newForm = $("<form action='"+ uploadFormDataAPI +"' method='post' enctype='multipart/form-data' class='ajax-form' style='display:none;' />");
    var fileUpload = $("<input type='file' class='upload-files' name='import-excel-uploader' id='import-excel-uploader' accept='.xlsx' />");
    newForm.append($("<input type='text' name='guid' class='upload-guid' value='"+ guid +"' />"));

    fileUpload.change(function () {


        $("#btnSaveUploadData").attr("disabled",true);
        var container = $("#div-excel-result");
        container.html('<div style="color:#ef5a29;padding:20px"><b>กรุณาทำการอัพโหลดไฟล์ก่อน</b></div>');
        
        //var uploadForm = $(this).closest("form");
        //var uploadGuid = uploadForm.find(".upload-guid").val();
        //var uploadFilesCount = uploadForm.find(".upload-files").get(0).files.length;

        //Reference the FileUpload element.
        var fileUpload = document.getElementById("import-excel-uploader");
        //Validate whether File is valid Excel file.
        var regex = /^([a-zA-Z0-9\s_\\.\-:\(\)])+(.xls|.xlsx)$/;
        
        if (regex.test(fileUpload.value.toLowerCase())) {
            if (typeof (FileReader) != "undefined") {

                var reader = new FileReader();
 
                //For Browsers other than IE.
                if (reader.readAsBinaryString) {
                    reader.onload = function (e) {
                        GetTableFromExcel(e.target.result);
                    };
                    reader.readAsBinaryString(fileUpload.files[0]);
                } else {
                    //For IE Browser.
                    reader.onload = function (e) {
                        var data = "";
                        var bytes = new Uint8Array(e.target.result);
                        for (var i = 0; i < bytes.byteLength; i++) {
                            data += String.fromCharCode(bytes[i]);
                        }
                        GetTableFromExcel(data);
                    };
                    reader.readAsArrayBuffer(fileUpload.files[0]);
                }
            } else {
               swal("Upload failed","This browser does not support HTML5.","error");
            }
        } else {
            swal("Upload failed","Please upload a valid Excel file.","error");
        }
    });
    newForm.append(fileUpload);
    $("body").append(newForm);
    fileUpload.click();
}

function GetTableFromExcel(data) {
    //Read the Excel File data in binary
    var workbook = XLSX.read(data, {
        type: 'binary'
    });

    //get the name of First Sheet.
    var Sheet = workbook.SheetNames[0];

    //Read all rows from First Sheet into an JSON array.
    var _excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[Sheet]);
   
    
    var _col_sets = ["","ลำดับ","รายละเอียดสินค้า","__EMPTY","__EMPTY_1","__EMPTY_2","__EMPTY_3","__EMPTY_4","__EMPTY_5",
        "__EMPTY_6","__EMPTY_7","__EMPTY_8","__EMPTY_9","__EMPTY_10","__EMPTY_11","__EMPTY_12"];
    uploadPrepareSaveData = [];
    var container = $("#div-excel-result");
    container.html("");

    var table = $("<table/>", {
        class:"table table-striped table-bordered"
    });
    table.appendTo(container);
    table.append($("#table-template").html());
    

    var _total = _excelRows.length;
    var percentComplete = 0;
    for (var i = 2; i < _total; i++) {

        //var d = _excelRows[i];
        var row = $("<tr/>");

        var finalDatas = [];
        var addToArray = false;
        for (var j = 1; j < 16; j++) {
            var content = j == 1 ? (i - 1) : _excelRows[i][_col_sets[j]];
            if(content == undefined){
                content = "#N/A";
            }
            var cell = $("<td/>", {
                html: content
            });
            cell.appendTo(row);

            finalDatas.push(content);

            if (_excelRows[i][_col_sets[j]] != null && _excelRows[i][_col_sets[j]].toString().trim() != "") {
                addToArray = true;
            }
        }

        if (addToArray) {
            uploadPrepareSaveData.push(finalDatas);
            row.appendTo(table);
        }

        percentComplete = (i+1) / _total * 100;
        //show uploadProgress
        $(".wg-progress").css("width", percentComplete + "%");
        $(".wg-progress-percent").html(percentComplete);
        
    }

    console.log(uploadPrepareSaveData);
    if (uploadPrepareSaveData.length > 0) {
        if (uploadPrepareSaveData.length > 500) {
            swal("ระบบอนุญาตให้อัพโหลดได้ครั้งละไม่เกิน 500 รายการเท่านั้น", "กรุณาแบ่งการอัพโหลด (คุณกำลังจะอัพโหลดจำนวน " + uploadPrepareSaveData.length + " รายการ)", "error");
        } else {
            $("#txtImportDataToSave").val(JSON.stringify(uploadPrepareSaveData));
            $("#btnSaveUploadData").removeAttr("disabled");
        }
    }

   
    
};
