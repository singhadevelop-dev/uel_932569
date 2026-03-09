var ConfirmFlag = undefined;
function AlertConfirm(sender,message)
{
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

function AlertSuccessRedirect(msg,url)
{
    swal('',msg, 'success');
    setTimeout(() => {
        $('.sa-button-container .confirm').click(function(){location.href = url;});
    }, 600);
    
}

function AlertNoti(msg)
{
    swal({
        title: msg,
        text: "",
        type: "success",
        showCancelButton: false,
        showConfirmButton: false,
        html: true,
        customClass: "show-sweet-noti",
        timer: 1500
    });
    $(".sweet-overlay").hide();
}

function AlertSuccess(msg)
{
    swal('',msg, 'success');
}

function AlertError(msg)
{
    swal({
        title: "",
        text: msg,
        type: "error",
        showConfirmButton: true,
        html: true
    });
    //swal('',msg, 'error');
}

function AlertLoadingChange(msg){
    $(".at-loading-xxx-xxxxxx .content").html(msg+"...");
}

function AlertLoading(flag, msg) {
    var elt = $("body");
    if (flag) {
        var loading = $("<div/>", {
            class: "at-loading-xxx-xxxxxx",
            css: {
                "position": "fixed",
                "z-index": "2000",
                "top": "0px",
                "left": "0px",
                "right": "0px",
                "bottom": "0px",
                "background": "rgba(0, 0, 0, 0.46)",
                "text-align": "center"
            },
            html : '<div class="at-loading-content" style="padding: 10px;border-radius: 10px;background: #fff;margin: 20px auto;width: auto;display: inline-block;box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"><img style="width: 20px;margin-right: 5px;" src="'+_root_path_includelibrary+'/ControlPanel/assets/images/loading.gif" alt="Alternate Text" /><span class="content">'+(msg == undefined ? " Loading" : " "+msg) + "..."+'</span></div>'
        });
        $(elt).find(".at-loading-xxx-xxxxxx").remove();
        $(elt).append(loading);
        $(elt).addClass("position-relative");
    }
    else {
        elt.find(".at-loading-xxx-xxxxxx").remove();
        elt.removeClass("position-relative");
    }
}

$.fn.AlertLoading = function (flag, msg) {
    var elt = $(this);
    if (flag) {
        var loading = $("<div/>", {
            class: "alertxxx-content-loading",
            css: {
                zIndex: 1051,
                background: "rgba(255, 255, 255, 0.68)",
                position: "absolute",
                top: 0,
                left: 0,
                right: 0,
                height: "100%",
                width: "100%",
                padding: 20,
                textAlign: "center",
                paddingTop: 150
            }
        });
        $(loading).append($("<img/>", {
            src: _root_path_includelibrary+"/ControlPanel/assets/images/loading.gif",
            css: {
                marginTop: -2,
                width: 20,
                height: 20
            }
        }));
        $(loading).append($("<label/>", {
            html: (msg == undefined ? "Loading content" : msg) + "...",
            css: {
                marginLeft: 10
            }
        }));
        $(loading).css("padding-top", elt.height() / 2);
        $(elt).append(loading);
        $(elt).addClass("position-relative");
    }
    else {
        elt.find(".alertxxx-content-loading").remove();
        elt.removeClass("position-relative");
    }
}

function delay(callback, ms) {
    var timer = 0;
    return function() {
      var context = this, args = arguments;
      clearTimeout(timer);
      timer = setTimeout(function () {
        callback.apply(context, args);
      }, ms || 0);
    };
}

function replaceUrlParam(url, paramName, paramValue)
{
    if (paramValue == null) {
        paramValue = '';
    }
    var pattern = new RegExp('\\b('+paramName+'=).*?(&|#|$)');
    if (url.search(pattern)>=0) {
        return url.replace(pattern,'$1' + paramValue + '$2');
    }
    url = url.replace(/[?#]$/,'');
    return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue;
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

//---------------------------------- Framework number format ---------------------------------------
//onchange="IsFormatNumber(this);"
function IsFormatNumber(obj) {
    var formatValue = new NumberFormat($(obj).val());
    formatValue.setPlaces(2);
    $(obj).val(formatValue.toFormatted());
}
function ConvertFormatNumber(Value, digit) {
    var formatValue = new NumberFormat(Value);
    formatValue.setPlaces(digit);
    return formatValue.toFormatted();
}
function ConvertToNumber(Value) {
    var formatValue = new NumberFormat(Value);
    return parseFloat(formatValue.toFormatted().replace(/,/g , ''));
}
//onkeypress="IsKeyNumber(event);" 
function IsKeyNumber(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}

//---------------------------------- Framework Post Data --------------------------------------------

function PostTransectionsAPI(nameUrlAPI, datapost, callbackFunction, methodType) {
    var callBack = undefined;
    callbackFunction == "" || callbackFunction == null ? undefined : callbackFunction;
    try {
        //Set function CallBack
        if (callbackFunction) {
            callBack = eval(callbackFunction);
        }
    } catch (e) { }

    $.ajax({
        type: (methodType == null || methodType == undefined || methodType == "") ? "POST" : methodType,  // type of request
        url: nameUrlAPI,// funtion name // resource file with extension
        data: datapost,
        success: callBack,//after success call function , callBack is // callback function, called when Ajax operation is complete 
        statusCode: {
            404: function () {
                //AlertLoading(false);
                //AlertError("[404] page not found");
            }
        }
        ,error : callBack
        // ,error: function (xhr, reason, exMessage) {
        //     AlertLoading(false);
        //     if (xhr.status === 555) {
        //         AlertError(exMessage);
        //     }
        //     if (xhr.status === 404) {
        //         AlertError("[404]page not found");
        //     }
        //     else {
        //         AlertError(reason + "[" + xhr.status + "] : " + xhr.responseJSON.message == undefined ? xhr.responseText : xhr.responseJSON.message);
        //     }
        // }
    });
}

function PostFormDataAPI(nameUrlAPI, fromdata, callbackFunction, MethodType) {
    var callBack = undefined;
    callbackFunction == "" || callbackFunction == null ? undefined : callbackFunction;
    try {
        //Set function CallBack
        if (callbackFunction) {
            callBack = eval(callbackFunction);
        }
    } catch (e) { }

    $.ajax({
        type: (MethodType == null || MethodType == undefined || MethodType == "") ? "POST" : MethodType,  // type of request
        url: nameUrlAPI,
        data: fromdata,
        cache: false,
        contentType: false,
        processData: false,
        success: callBack,//after success call function , callBack is // callback function, called when Ajax operation is complete 
        statusCode: {
            404: function () {
               
                //AlertLoading(false);
                //AlertError("[404] page not found");
            }
        }
        ,error: callBack
        // ,error: function (xhr, reason, exMessage) {
        //     //AlertLoading(false);
        //     if (xhr.status === 555) {
        //         AlertError(exMessage);
        //     }
        //     if (xhr.status === 404) {
        //         AlertError("[404]page not found");
        //     }
        //     else {
        //         AlertError(reason + "[" + xhr.status + "] : " + xhr.responseJSON.message == undefined ? xhr.responseText : xhr.responseJSON.message);
        //     }
        // }
    });
}

//---------------------------------- End Framework Post Data --------------------------------------------
$(document).ready(function(){
    if(localStorage.getItem(__dtag__)==null||localStorage.getItem(__dtag__)==undefined||localStorage.getItem(__dtag__)==""){localStorage.setItem(__dtag__,__device__id__);}
    if(localStorage.getItem(__dtag__)!=getCookie(__dtag__)){setCookie(__dtag__, localStorage.getItem(__dtag__), 3650);}
});
