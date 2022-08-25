<?php
$page_name = "Shopping cart";
include __DIR__ . '/inc/header.php';
if (!isset($_SESSION['logged_in'])) {
    die('You must be logged in to view this page!');
}
include_once __DIR__ . '/classes/productClass.php';
include_once __DIR__ . '/classes/CartItemClass.php';
$product_id = $_GET['product_id'];
$user_id = $_GET['user_id'];
$cart_id = $_GET['cart_id'];
$product = new Product();


?>

    <div class="content">
        <br><br>
        <article>
            <h2>Shopping Cart Overview Customer</h2>
        </article>
    </div>
    <br><br>

    <div class="container">
        <table style="background: white; border: 1px solid #ccc; border-radius: 3px; padding: 10px;">
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>


                        <?php
            $cartItem = new CartItem();
            $cartItem->getCartItems($cart_id);
            ?>
        </table>
    </div>
<br><br>

<div class="container_small">
    <form method="post" action="#">
        <button type="submit" name="order">buy now!</button>
    </form>
</div>
<br><br>

<?php

/*echo '
    <br><br>
    <div class="content">
    <h4>Product ID:' . $product_id . '</h4>
    <br><br>
    <h4>User ID:' . $user_id . '</h4>
    <br><br>
   
    </div>
    ';*/

include __DIR__ . '/inc/footer.php'; ?>