<?php include_once "_cogs.php"; ?>
<?php include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/UtilService.php"; ?>
<?php

$ClientID = GetCookieClientID();
$action = $_REQUEST["action"];
$RefCode = $_REQUEST["ref_code"];
$RefType = $_REQUEST["ref_type"];

if ($action == "FAVORITE_GET") {
    $sql = "select * from favorite where ClientID = '$ClientID' and RefCode = '$RefCode' and RefType = '$RefType'";
    $fav = SelectRow($sql);
    echo $fav["FavoriteCode"];
} else if ($action == "FAVORITE_SAVE") {

    $sql = "select * from favorite where ClientID = '$ClientID' and RefCode = '$RefCode' and RefType = '$RefType'";
    $fav = SelectRow($sql);
    if ($fav == false) {
        $favCode = GenerateNextID("favorite", "FavoriteCode", 20, "FAV");
        $sql = "insert into favorite (FavoriteCode,ClientID,RefCode,RefType,CreatedOn)
            values(
                '$favCode'
                ,'$ClientID'
                ,'$RefCode'
                ,'$RefType'
                ,NOW()
            );";
        ExecuteSQL($sql);
        echo $favCode;
    } else {
        $favCode = $fav["FavoriteCode"];
        $sql = "delete from favorite where FavoriteCode = '$favCode'";
        ExecuteSQL($sql);
        echo "";
    }
} else if ($action == "WISHLIST") {
    $sql = "
            select 
            f.FavoriteCode
            ,f.RefType
            ,r.ProductCode as Code
            ,r.ProductName as Name
            ,r.Image
            ,r.Price
            from favorite f
            join product r on f.RefCode = r.ProductCode
            where f.RefType = 'PRODUCT' and f.ClientID = '$ClientID'
        ";
    $favs = SelectRows($sql);
?>
    
        <?php
        foreach ($favs as $fav) {
            $_PRO_URL = DetailPageURL($fav["Code"], $fav["Name"]);
        ?>

            <div class="cart_item">
                <div class="cart_img">
                    <a href="<?php echo $_PRO_URL ?>"><img src="<?php echo $fav["Image"]; ?>" alt="<?php echo $fav["Name"] ?>"></a>
                </div>
                <div class="cart_info">
                    <a href="<?php echo $_PRO_URL ?>"><?php echo $fav["Name"] ?></a>
                    <p><span>฿<?php echo number_format($fav["Price"]) ?></span></p>    
                </div>
                <div class="cart_remove">
                    <a href="#" data-action="FAVORITE" data-ref-code="<?php echo $fav["Code"]; ?>" data-ref-type="PRODUCT" onclick="removeFavoriteItems(this);"><i class="ion-android-close"></i></a>
                </div>
            </div>
        <?php } ?>
    
<?php
} else if ($action == "COMPARE_COUNT") {
    $sql = "select count(f.FavoriteCode) as items 
     from favorite f
     join product r on f.RefCode = r.ProductCode
      where f.ClientID = '$ClientID' and f.RefType = 'COMPARE'";
    $fav = SelectRow($sql);
    echo number_format($fav["items"]);
} else if ($action == "CART_ADD") {

    $amount = intval($_POST["amount"]);
    $size = $_POST["size"];
    $color = $_POST["color"];
    $sqlProduct = "select p.*,c.CategoryName from product p
                    join product_category c
                    on c.CategoryCode = p.CategoryCode
                    where p.productCode = '$RefCode'";

    $dataPrd = SelectRow($sqlProduct);
    $dataCart = GetCartRefProduct($ClientID,$RefCode,$size,$color);
    if(intval($dataPrd["Amount"]) <  intval($dataCart["QTY"]) + $amount){

        echo "NONE_STOCK";
        exit();
    }

    if(isset($dataCart))
    {
        $sqlInsert = "update cart 
        set QTY = (QTY+$amount) 
        ,Total = (Price * QTY)  
        ,TotalBasePrice = (BasePrice * QTY)
        where ClientID = '$ClientID' and ProductCode = '$RefCode' and SEQ = ".$dataCart["SEQ"]." ";
    }
    else
    {
        $sqlInsert = "insert into cart (ClientID,ProductCode,Price,BasePrice,QTY,Color,Size,Total,TotalBasePrice,Active,CreatedOn,CheckOutCode) values(
                '$ClientID'
                ,'$RefCode'
                ,'".$dataPrd["Price"]."'
                ,'".$dataPrd["BasePrice"]."'
                ,'$amount'
                ,'$color'
                ,'$size'
                ,'".(floatval($dataPrd["Price"]) * $amount)."'
                ,'".(floatval($dataPrd["BasePrice"]) * $amount)."'
                ,1
                ,NOW()
                ,''
            )
        ";
    }
    ExecuteSQL($sqlInsert);
    echo $RefCode;
    
} else if ($action == "CART_DELETE") {
    $cartSEQ = $_POST["seq"];
    $sql = "delete from cart where ClientID = '$ClientID' and ProductCode = '$RefCode' and SEQ = $cartSEQ ";
    ExecuteSQL($sql);
    echo "";
} else if ($action == "CART_UPDATE") {
    
    $cartSEQ = $_POST["seq"];
    $cartAmount = intval($_POST["amount"]);
    $sql = "update cart set 
    QTY = $cartAmount
    ,Total = Price * $cartAmount  
    ,TotalBasePrice = BasePrice * $cartAmount
    where ClientID = '$ClientID' and ProductCode = '$RefCode' and SEQ = $cartSEQ ";
    ExecuteSQL($sql);
    echo $cartSEQ;
}
else if($action == "CART_NUMBER")
{
    $sql = "
            select p.ProductCode,p.ProductName,p.Image
                ,c.CategoryName
                ,cart.QTY,cart.Price as CartPrice,cart.Total,cart.SEQ
                ,color.TagName as ColorName
                ,size.TagName  as SizeName
            from cart
            join product p on p.ProductCode = cart.ProductCode
            join product_category c  on c.CategoryCode = p.CategoryCode
            left join tag color on color.TagCode = cart.Color and color.TagType='COLOR'
            left join tag size on size.TagCode = cart.Size and size.TagType='SIZE'
            where cart.ClientID = '$ClientID' and cart.Active = 1 order by p.seq
        ";
        $carts = SelectRowsArray($sql);
    echo  number_format(count($carts));

} 
else if($action == "CART_CHECK_BALANCE"){

    $sqlProduct = "select p.seq,p.ProductCode,p.ProductName,p.Image,'SHOP' as ShopCode, d.WebName as ShopName
                    ,c.CategoryName
                    ,cart.QTY,cart.Price as CartPrice,cart.Total,cart.SEQ
                    ,p.Amount
                    from cart
                    join product p
                        on p.ProductCode = cart.ProductCode
                    join product_category c
                        on c.CategoryCode = p.CategoryCode
                    left join website d on 1=1
                    where cart.ClientID = '$ClientID' and cart.Active = 1 order by p.seq,p.ProductCode,cart.SEQ";
    $dataPrd = SelectRowsArray($sqlProduct);
    $isBalance = false;
    if(count($dataPrd) > 0){
        $isBalance = true;
        foreach ($dataPrd as $cart) {
            if($cart["QTY"] > $cart["Amount"]){
                $isBalance = false;
            }
        }
    }
    echo $isBalance;
}
else if ($action == "CART_LIST") {
    $sql = "
            select p.ProductCode,p.ProductRefCode,p.ProductName,p.Image
                ,c.CategoryName
                ,cart.QTY,cart.Price as CartPrice, p.OldPrice as CartOldPrice
                ,cart.Total,cart.SEQ
                ,color.TagName as ColorName
                ,size.TagName  as SizeName
            from cart
            join product p on p.ProductCode = cart.ProductCode
            join product_category c  on c.CategoryCode = p.CategoryCode
            left join tag color on color.TagCode = cart.Color and color.TagType='COLOR'
            left join tag size on size.TagCode = cart.Size and size.TagType='SIZE'
            where cart.ClientID = '$ClientID' and cart.Active = 1 order by p.seq
        ";
    $carts = SelectRows($sql);
?>
            <?php
                $totalSummary = 0;
                foreach ($carts as $cart) {
                    $totalSummary += intval($cart["Total"]);
                    $_PRO_URL = DetailPageURL($cart["ProductCode"], $cart["ProductName"]);
            ?>
                <div class="product product-cart cart_item">
                <figure class="product-media">
                    <a href="<?php echo $_PRO_URL ?>">
                        <img src="<?php echo $cart["Image"]; ?>" alt="<?php echo $cart["ProductName"]; ?>" />
                    </a>
                    <button class="btn btn-link btn-close" href="javascript:;" data-ref-code="<?php echo $cart["ProductCode"] ?>" data-seq="<?php echo $cart["SEQ"] ?>" onclick="removeProductCartItems(this);">
                        <i class="fas fa-times"></i><span class="sr-only">Close</span>
                    </button>
                </figure>
                <div class="product-detail">
                    <a href="<?php echo $_PRO_URL ?>" class="product-name"><?php echo $cart["ProductName"]; ?></a>
                    <div class="price-box">
                        <span class="product-quantity"><?php echo $cart["QTY"]; ?></span>
                        <span class="product-price">฿<?php echo number_format($cart["CartPrice"],2) ?></span>
                    </div>
                </div>
            </div>
			<?php } ?>
			<!-- End of Products  -->
            <div class="cart-total">
                <label>Subtotal:</label>
                <span class="price minicart-drop-total-price">฿<?php echo number_format($totalSummary,2) ?></span>
            </div>
<?php
}


function GetCartRefProduct($clientID, $product, $size, $color)
{
    $sqlCart = "select * from cart 
    where ClientID = '$clientID' 
    and ProductCode='$product'
    and Color='$color'
    and Size='$size'
    and Active = 1";
    $dataCart = SelectRowsArray($sqlCart);
    if (count($dataCart) > 0) {
        return $dataCart[0];
    }
    return null;
}

?>