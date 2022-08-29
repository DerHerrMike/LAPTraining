<?php
$page_name = "Purchase";
include __DIR__ . '/inc/header.php';
if (!isset($_SESSION['logged_in'])) {
    die('You must be logged in to view this page!');
}
include_once __DIR__ . '/classes/productClass.php';
include_once __DIR__ . '/classes/CartItemClass.php';
$cart_id =$_GET['cart_id'];
$orderDetails = new CartItem();
$order = $orderDetails->getOrderItems($cart_id);
$price_total = 0;
$grandTotal = 0;
foreach ($order as $invoice_item) {
    $quantity = $invoice_item['quantity'];
    $pricePU = $invoice_item['price'];
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
//
//echo var_dump($order);

//echo $order([0][0] . ' ' . $order[0][1] . ' ' . $order[0][2]);

echo '<br><br>';

echo $order[0][0] . ' ' . $order[0][1] . ' ' . $order[0][2];

echo '<br><br>';

echo $order[1][0] . ' ' . $order[1][1] . ' ' . $order[1][2];


echo '<br><br>';

//echo $order['orderItem'][0] . ' ' . $order[0][1] . ' ' . $order[0][2];


//echo $order[1][0][0] . ' ' . $order[1][0][1] . ' ' . $order[1][0][2];

//echo $order[2][0] . ' ' . $order[2][1] . ' ' . $order[2][2];


?>

</div>
