<?php
$page_name = "Purchase";
include __DIR__ . '/inc/header.php';
if (!isset($_SESSION['logged_in'])) {
    die('You must be logged in to view this page!');
}
include_once __DIR__ . '/classes/productClass.php';
include_once __DIR__ . '/classes/CartItemClass.php';
include_once __DIR__ . '/classes/CartClass.php';
$cart_id =$_GET['cart_id'];
$cart = new Cart();
$cart->orderCart($cart_id);
$orderDetails = new CartItem();
$order = $orderDetails->getOrderItems($cart_id);
$price_total = 0;
$grandTotal = 0;
foreach ($order as $invoice_item) {
    $pricePU = $invoice_item[1];
    $quantity = $invoice_item[2];
    $price_total = $quantity * $pricePU;
    $grandTotal += $price_total;
}
?>

<div class="content">
    <br><br>
    <article>
        <h2>Thanks for your order!</h2>
        <br><br>
        <p>Your invoice for EUR <?php echo $grandTotal ?> has been sent to your email address </p>
    </article>
</div>
<br><br>

<div class="container">
<?php

foreach($order as $orderItem){

    echo '<br><br>';
    echo $orderItem[0] . '   ' . $orderItem[1] . '   ' . $orderItem[2];
}
?>

</div>
