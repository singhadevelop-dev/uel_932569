<style>

    a.like-item[data-api-action="FAVORITE"],
    .right_caption .action_links ul li a.like-item i,
    .cat-list-view .thumbnail-conten li a.like-item:hover,
    .cat-list-view .thumbnail-conten li a.like-item:hover {
        color: red;
    }
    a.like-item > .icon-heart:before {
        content: "\eabf";
    }
    
</style>
<script>

    $(document).ready(function(){
        //_APICartNumber();
        _APICartList();
        //_APIWishList();
        //_APICompareList();
        $("[data-api-action]").each(function() {

            var elt = $(this);
            _APIAction(
                elt,
                "GET"
            );
            elt.attr("href", "javascript:;").click(function() {
                AlertLoading(true,"กำลังทำรายการ");
                _APIAction(
                    this,
                    "SAVE"
                );
            });
        });
    });

    // window.onload = function() {
    //     //_APICartNumber();
    //     _APICartList();
    //     //_APIWishList();
    //     //_APICompareList();
    //     $("[data-api-action]").each(function() {

    //         var elt = $(this);
    //         _APIAction(
    //             elt,
    //             "GET"
    //         );
    //         elt.attr("href", "javascript:;").click(function() {
    //             AlertLoading(true,"กำลังทำรายการ");
    //             _APIAction(
    //                 this,
    //                 "SAVE"
    //             );
    //         });
    //     });
    // };

    function removeFavoriteItems(_elt)
    {
        var elt = $(_elt);
        var action = elt.attr("data-action");
        var ref_code = elt.attr("data-ref-code");
        var ref_type = elt.attr("data-ref-type");
        AlertLoading(true,"โหลดข้อมูล");
        $.ajax({
            url: "_cogs_api.php",
            type: "POST",
            data: {
                action: action + "_SAVE",
                ref_code: ref_code,
                ref_type: ref_type
            },
            success: function(rest_code) {
                if (rest_code.trim() == "") {
                    var likeItem = $('[data-api-action="'+action+'"][data-api-ref-code="'+ref_code+'"][data-api-ref-type="'+ref_type+'"]');
                    $(elt).closest(".cart_item").remove();
                    if(likeItem.length > 0)
                    {
                        likeItem.removeClass("like-item");
                    }
                    if($("#wishlist-link").length > 0)
                    {
                        var count = $("#wishlist-link .cart_item").length;
                        $("#wishlist-link").closest(".mini_cart_wrapper").find("#_GlobalWishlistCount").html(count).toggle(count > 0);
                    }
                    AlertLoading(false);
                }
            }
        });

    }

    function _APIAction(_elt, method) {
        var elt = $(_elt);
        var action = elt.attr("data-api-action");
        var ref_code = elt.attr("data-api-ref-code");
        var ref_type = elt.attr("data-api-ref-type");
        $.ajax({
            url: "_cogs_api.php",
            type: "POST",
            data: {
                action: action + "_" + method,
                ref_code: ref_code,
                ref_type: ref_type
            },
            success: function(rest_code) {
                if (rest_code.trim() == "") {
                    elt.removeClass("like-item");
                } else {
                    elt.addClass("like-item");
                }
                if(method != "GET")
                {
                    if(action == "FAVORITE"){
                        _APIWishList();
                    }
                    // if(ref_type == "COMPARE"){
                    //     _APICompareList();
                    // }
                }
                AlertLoading(false);
            },
            failure : function(rest_code){
                AlertLoading(false);
            }
        });
    }

    function _APICartNumber(){
        $("#_GlobalCartCount").load("_cogs_api.php?action=CART_NUMBER", function() {
            var count = parseInt($(this).html().trim());
            $(this).closest(".number").toggle(count > 0);
        });
    }

    function _APICartList(){

        $("#cartlist-link").load("_cogs_api.php?action=CART_LIST", function() {
            var count = $(this).find(".cart_item").length;
            $("._GlobalCartCount").html(count).toggle(count > 0);
            $("._GlobalCartPrice").html($(".minicart-drop-total-price").html());
            //$(".cart_price_show_xxx").html($(".cart-price-total-xxx").html()+' <i class="ion-ios-arrow-down"></i>');
        });

    }

    function _APIWishList(){
        $("#wishlist-link").load("_cogs_api.php?action=WISHLIST", function() {
            var count = $(this).find(".cart_item").length;
            $(this).closest(".mini_cart_wrapper").find("#_GlobalWishlistCount").html(count).toggle(count > 0);
            
        });
    }

    // function _APICompareList()
    // {
    //     var cartlistLink = $("#comparelist-link");
    //     if(cartlistLink != undefined && cartlistLink.length > 0)
    //     {
    //         var cCount = cartlistLink.find(".wl_counter");
    //         cCount.load("_cogs_api.php?action=COMPARE_COUNT",function() {
    //             $(this).html($(this).html().trim());
    //         });
    //     }
    // }

    //AddToCart
    function _GlobalAddToCart(refCode,amount,size,color) {
        var msg = [];
        if (refCode == null || refCode == undefined || refCode == "") {
            msg.push("please input product code!");
        }
        if (amount == null || amount == undefined || amount < 0) {
            msg.push("please input amount!");
        }
        // if (size == null || size == undefined || size == "") {
        //     msg.push("please input size!");
        // }
        // if (color == null || color == undefined || color == "") {
        //     msg.push("please input color!");
        // }

        if(msg.length > 0)
        {
            AlertError(msg.join("<br>"));
            return;
        }
        AlertLoading(true,"Add Product");
        $.ajax({
            url: "_cogs_api.php",
            type: "POST",
            data: {
                action: "CART_ADD",
                ref_code: refCode,
                amount: amount,
                size: size,
                color: color
            },
            success: function (result) {

                if(result !== "")
                {
                    if(result.trim() == "NONE_STOCK"){
                        AlertError("สต๊อกมีไม่พอสำหรับสำหรับการสั่งซื้อ.");
                    }else{
                        AlertNoti("เพิ่มสินค้าสำเร็จ.");
                        _APICartList();
                    }
                }
                try {
                    _Header_CartRefreshCart(result);
                    
                } catch (e) {

                }
                AlertLoading(false);
            }
        });
    }

    function removeProductCartItems(_elt)
    {
        AlertLoading(true,"delete data");
        var elt = $(_elt);
        var ref_code = elt.attr("data-ref-code");
        var seq = elt.attr("data-seq");
        $.ajax({
            url: "_cogs_api.php",
            type: "POST",
            data: {
                action: "CART_DELETE",
                ref_code: ref_code,
                seq: seq
            },
            success: function(rest_code) {
                if (rest_code.trim() == "") {
                    _APICartList();
                }
                AlertLoading(false);
            }
        });

    }

</script>

<?php if(!empty($_Util_WebsitDetail["cogs_google_analytics"])){ ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $_Util_WebsitDetail["cogs_google_analytics"] ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', '<?php echo $_Util_WebsitDetail["cogs_google_analytics"] ?>');
</script>
<?php } ?>