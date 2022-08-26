<?php
$page_name = "Purchase";
include __DIR__ . '/inc/header.php';
if (!isset($_SESSION['logged_in'])) {
    die('You must be logged in to view this page!');
}
include_once __DIR__ . '/classes/productClass.php';
include_once __DIR__ . '/classes/CartItemClass.php';
$cart_id =$_GET['cart_id'];

?>

<div class="content">
    <br><br>
    <article>
        <h2>Thanks for your order!</h2>
    </article>
</div>
<br><br>

<div class="container">
<?php $orderDetails = new CartItem();
$order =$orderDetails->getOrderItems($cart_id);
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
